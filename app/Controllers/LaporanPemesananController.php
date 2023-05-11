<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Booking;

class LaporanPemesananController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Booking();
    }
    
    public function index()
    {
        return view('admin/laporan_pemesanan/index', [
            'title' => "Laporan Pemesanan",
            'datas' => $this->model->getDataPesananTerbayar("Terbayar")
        ]);
    }
}
