<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Jam;
use App\Models\Lapangan;
use App\Models\Pembayaran;
use App\Models\User;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Pager\Exceptions\PagerException;
use CodeIgniter\Router\Exceptions\RedirectException;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends BaseController
{
    protected $modelBooking;

    public function __construct()
    {
        $this->modelBooking = new Booking();
        session();
    }

    public function index()
    {
        return view('pelanggan/booking/index', [
            'datas' => $this->modelBooking->findAll()
        ]);
    }

    public function postKeranjang($id)
    {
        $modelJadwal = new Jadwal();
        $modelJadwal->save([
            'id_lapangan' => $id
        ]);
        $data = $modelJadwal->where('jadwals_id', $id)->first();

        $this->modelBooking->save([
            'id_pelanggan' => base64_decode(session('id')),
            'id_jadwal' => $id,
            'harga' => $data['harga']
        ]);

        $modelJadwal->update($id, [
            'status_booking' => 1
        ]);

        return redirect()->to(base_url('pelanggan/keranjang'))->with('success', 'Berhasil menambahkan item.');
    }

    public function postPesanan($id, $tanggal, $jamMulai, $jamAkhir)
    {
        $modelJadwal = new Jadwal();
        $modelJam = new Jam();
        $modelLapangan = new Lapangan();

        $modelJam->save([
            'jamMulai' => $jamMulai,
            'jamAkhir' => $jamAkhir
        ]);

        
        $dataLapangan = $modelLapangan->where('lapangan_id', $id)->first();
        
        $harga = $this->hargaPerjam($jamMulai, $jamAkhir, $dataLapangan['harga']);
        
        $modelJadwal->save([
            'id_jam' => $modelJam->getInsertID(),
            'id_lapangan' => $id,
            'tanggal' => $tanggal,
            'harga' => $harga,
            'status_booking' => 'Terboking'
        ]);
        
        $this->modelBooking->save([
            'id_pelanggan' => base64_decode(session('id')),
            'id_jadwal' => $modelJadwal->getInsertID(),
            'harga' => $harga
        ]);

        // dd($this->modelBooking->getInsertID());

        $modelLapangan->update($id, [
            'status' => 1
        ]);

        return redirect()->to(base_url('pelanggan/keranjang'))->with('success', 'Berhasil menambahkan item.');
    }

    public function getKeranjangUser()
    {
        $modelUser = new User();
        $idUser = $modelUser->getIdPelanggan(session('username'));

        return view('pelanggan/booking/index', [
            'title' => ' | Keranjang',
            'datas' => $this->modelBooking->getDataPesananUsers($idUser)
        ]);

    }

    public function deleteKeranjangUser($id)
    {
        $modelJadwal = new Jadwal();
        $modelJam = new Jam();
        $modelUser = new User();
        $modelLapangan = new Lapangan();
        $modelBooking = $this->modelBooking->where('booking_id', $id)->first();
        $dataJadwal = $modelJadwal->where('jadwal_id', $modelBooking['id_jadwal'])->first();

        if ($modelUser->getIdPelanggan(session('username')) === $modelBooking['id_pelanggan']) {

            $modelLapangan->update($dataJadwal['id_lapangan'], [
                'status' => 0
            ]);
            $modelJam->where('jam_id', $dataJadwal['id_jam'])->delete();
            $modelJadwal->where('jadwal_id', $modelBooking['id_jadwal'])->delete();
            $this->modelBooking->where('booking_id', $id)->delete();
            
        } else {
            throw new RedirectException(base_url('pelanggan/keranjang'), 403);
        }

        return redirect()->to(base_url('pelanggan/keranjang'))->with('success', 'Berhasil menghapus item.');
    }

    public function payment()
    {        
        $modelPembayaraan = new Pembayaran();
        $modelUser = new User();
        $checkedChecboxs = $this->request->getVar('id');
        $dataPelanggan = $modelUser->getPelanggan(session('username'));
        $modelBooking = $this->modelBooking->getCheckOutDataPesanan($checkedChecboxs, $dataPelanggan['pelanggan_id']);

        $kodePemabayaran = "TRX-" . date('Ymd') . rand('100', '999');

        $this->modelBooking->db->transBegin();
        $modelPembayaraan->db->transBegin();
        try {

            foreach ($modelBooking['results'] as $item) {

                $this->modelBooking->update($item['booking_id'], [
                    'subtotal' => $modelBooking['subtotal']
                ]);

                $modelPembayaraan->save([
                    'kode_pembayaran' => $kodePemabayaran,
                    'id_booking' => $item['booking_id'],
                ]);

                $modelJadwal = new Jadwal();
                $modelJadwal->update($item['jadwal_id'], ['status_booking' => 'Terboking']);
            }

            $transaction = [
                'transaction_details' => [
                    'order_id' => $kodePemabayaran,
                    'gross_amount' => $this->request->getVar('dp')
                ],
                'customer_details' => [
                    'first_name' => $dataPelanggan['nama'],
                    'email' => $dataPelanggan['email'],
                    'phone' => $dataPelanggan['noHp']
                ],
            ];

            $this->modelBooking->db->transCommit();
            $modelPembayaraan->db->transCommit();

            $snap_token = '';

            $snap_token = Snap::getSnapToken($transaction);
            return response()->setStatusCode(200)->setJSON(['snap_token' => $snap_token]);
            // return view('pelanggan/booking/checkout', [
            //     'snap_token' => $snap_token
            // ]);
        } catch (\Exception | DatabaseException $e) {
            $this->modelBooking->db->transRollback();
            $modelPembayaraan->db->transRollback();

            return response()->setStatusCode(501)->setJSON(['errors' => $e->getMessage()]);
            // return redirect()->to(base_url('pelanggan/keranjang'))->with('errors', $e->getMessage());
        }
    }

    public function paymentCancel()
    {
        $modelPembayaraan = new Pembayaran();
        $modelUser = new User();
        $checkedChecboxs = $this->request->getVar('checkedChecboxs');
        $dataPelanggan = $modelUser->getPelanggan(session('username'));
        $modelBooking = $this->modelBooking->getCheckOutDataPesanan($checkedChecboxs, $dataPelanggan['pelanggan_id']);
        
        try {
            foreach ($modelBooking['results'] as $item) {
                
                $this->modelBooking->update($item['booking_id'], [
                    'subtotal' => null
                ]);
            }
            
            $modelPembayaraan->cancelPayment($checkedChecboxs);

            return response()->setStatusCode(200)->setJSON(['success' => "Pembayaran dibatalkan"]);
        } catch (DatabaseException $e) {
            return response()->setStatusCode(501)->setJSON(['error' => $e->getMessage()]);
        }

    }

    public function checkout()
    {
        $checkedChecboxs = $this->request->getVar('checkboxItem');
        $subTotal = $this->modelBooking->getSubTotal($checkedChecboxs, base64_decode(session('id')));

        return view('pelanggan/booking/checkout', [
            'title' => " | Checkout",
            'subTotal' => $subTotal,
            'checkedChecboxs' => $checkedChecboxs
        ]);
    }
}