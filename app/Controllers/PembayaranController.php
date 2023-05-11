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
use Midtrans\Snap;

class PembayaranController extends BaseController
{
    public function index()
    {
        //
    }

    public function bayarLangsung($id, $tanggal, $jamMulai, $jamAkhir)
    {
        $modelLapangan = new Lapangan();
        $dataLapangan = $modelLapangan->where('lapangan_id', $id)->first();
        $subTotal = $this->hargaPerjam($jamMulai, $jamAkhir, $dataLapangan['harga']);

        return view('pelanggan/pesanlapangan/checkout', [
            'title' => " | Checkout",
            'subTotal' => $subTotal,
            'idLapangan' => $id,
            'tanggal' => $tanggal, 
            'jamMulai' => $jamMulai, 
            'jamAkhir' => $jamAkhir
        ]);
    }

    public function payment()
    {        
        $modelBooking = new Booking();
        $modelJadwal = new Jadwal();
        $modelJam = new Jam();
        $modelLapangan = new Lapangan();
        $modelPembayaraan = new Pembayaran();
        $modelUser = new User();
        
        $idLapangan = $this->request->getVar('id');
        $idPelanggan = base64_decode(session('id'));
        $subTotal = $this->request->getVar('subTotal');
        $tanggal = $this->request->getVar('tanggal');
        $jamMulai = $this->request->getVar('jamMulai');
        $jamAkhir = $this->request->getVar('jamAkhir');

        $modelJam->save([
            'jamMulai' => $jamMulai,
            'jamAkhir' => $jamAkhir
        ]);

        $dataLapangan = $modelLapangan->where('lapangan_id', $idLapangan)->first();

        $harga = $this->hargaPerjam($jamMulai, $jamAkhir, $dataLapangan['harga']);

        $modelJadwal->save([
            'id_jam' => $modelJam->getInsertID(),
            'id_lapangan' => $idLapangan,
            'tanggal' => $tanggal,
            'harga' => $harga,
            'status_booking' => 'Terboking'
        ]);

        $modelBooking->save([
            'id_pelanggan' => $idPelanggan,
            'id_jadwal' => $modelJadwal->getInsertID(),
            'harga' => $harga,
            'subtotal' => $subTotal
        ]);

        $kodePemabayaran = "TRX-" . date('Ymd') . rand('100', '999');

        $dataPelanggan = $modelUser->getPelanggan(session('username'));

        $modelBooking->db->transBegin();
        $modelPembayaraan->db->transBegin();
        try {

            $modelPembayaraan->save([
                'kode_pembayaran' => $kodePemabayaran,
                'id_booking' => $modelBooking->getInsertID(),
                'payment_method' => $harga == $subTotal ? "Cash" : "DP"
            ]);

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

            $modelBooking->db->transCommit();
            $modelPembayaraan->db->transCommit();

            $snap_token = Snap::getSnapToken($transaction);
            return response()->setStatusCode(200)->setJSON(['snap_token' => $snap_token]);
        } catch (\Exception | DatabaseException $e) {
            $modelBooking->db->transRollback();
            $modelPembayaraan->db->transRollback();

            return response()->setStatusCode(501)->setJSON(['errors' => $e->getMessage()]);
        }
    }

    public function paymentCancel()
    {
        $modelLapangan = new Lapangan();
        $modelPembayaraan = new Pembayaran();

        $idLapangan = $this->request->getVar('id');        
        
        try {
            $modelPembayaraan->cancelBayarLangsung($idLapangan);

            $modelLapangan->update($idLapangan, ['status' => 0]);

            return response()->setStatusCode(200)->setJSON(['success' => "Pembayaran dibatalkan"]);
        } catch (DatabaseException $e) {
            return response()->setStatusCode(501)->setJSON(['error' => $e->getMessage()]);
        }

    }
}
