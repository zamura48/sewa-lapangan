<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Booking();
        session();
    }

    public function index()
    {
        return view('pelanggan/booking/index', [
            'datas' => $this->model->findAll()
        ]);
    }

    public function getKeranjangUser()
    {
        $modelUser = new User();
        $idUser = $modelUser->getIdUser(session('username'));

        return view('pelanggan/booking/index', [
            'title' => ' | Keranjang',
            'datas' => $this->model->getDataPesananUser($idUser)
        ]);

    }

    // public function getCheckout($id)
    // {
    //     $modelJadwal = new Jadwal();

    //     return view('pelanggan/booking/checkout', [
    //         'data' => $modelJadwal->getJadwalWithLapanganAndJam($id)
    //     ]);
    // }

    public function postCheckOut()
    {
        $modelPembayaraan = new Pembayaran();
        $checkedChecboxs = $this->request->getVar('checkboxItem');
        $modelBooking = $this->model->getDataPesanan($checkedChecboxs[0]);

        $kodePemabayaran = "TRX-" . date('Ymd') . rand('100', '999');

        Config::$serverKey = getenv('midtrans.serverKey');
        Config::$clientKey = getenv('midtrans.clientKey');
        // Config::$isProduction = getenv('midtrans.isProduction');
        Config::$isSanitized = getenv('midtrans.isSanitized');
        Config::$is3ds = getenv('midtrans.is3ds');

        $item = [
            'id' => $modelBooking['booking_id'],
            'price' => 1000,
            'quantity' => 1,
            'name' => "Lapangan"
        ];

        $item_details = array($item);

        $transaction = [
            'transaction_details' => [
                'order_id' => $kodePemabayaran,
                'gross_amount' => 1000
            ],
            'customer_details' => [
                'first_name' => $modelBooking['nama'],
                'email' => $modelBooking['email'],
                'phone' => $modelBooking['noHp']
            ],
            'item_details' => $item_details
        ];

        $snap_token = '';
        try {
            $snap_token = Snap::getSnapToken($transaction);
            return view('pelanggan/booking/checkout', [
                'snap_token' => $snap_token
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}