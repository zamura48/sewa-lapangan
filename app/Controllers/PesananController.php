<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Booking;
use App\Models\Pembayaran;

class PesananController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Booking();
    }

    public function index()
    {
        return view('admin/pesanan/index', [
            'title' => "Pesanan",
            'datas' => $this->model->getDataPesanans()
        ]);
    }

    public function update($id)
    {
        $modelPembayaran = new Pembayaran();
        $modelPembayaran->update($id, [
            'payment_type' => '1',
            'status' => $this->request->getPost('status')
        ]);

        return redirect()->to(base_url('admin/pesanan'))->with('success', 'Berhasil memperbarui data.');
    }
}
