<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Booking;
use App\Models\Pembayaran;

class BookingController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Booking();
    }
    
    public function index()
    {
        return view('pelanggan/booking/index', [
            'datas' => $this->model->findAll()
        ]);
    }

    public function store()
    {
        $modelBooking = $this->model;
        $modelPembayaraan = new Pembayaran();

        $validationRules = $modelBooking->getValidationRules();
        $validationMessages = $modelBooking->getValidationMessages();
        
        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->to(base_url('pelanggan/booking'))->with('validation', $this->validation->getErrors());
        }
        
        $kodePemabayaran = "TRX".date('Ymd').rand('100', '999');
        dd($kodePemabayaran);

        return redirect()->to(base_url('pelanggan/booking'))->with('success', 'Berhasil melakukan booking');
    }
}
