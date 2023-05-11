<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\Booking;

class LaporanPemesananController extends BaseController
{
    protected $modelBooking;

    public function __construct()
    {
        $this->modelBooking = new Booking();
    }
    
    public function index()
    {
        return view('owner/laporan_pemesanan/index', [
            'title' => "Laporan Pemesanan",
            'datas' => $this->modelBooking->getDataPesananTerbayar("Terbayar")
        ]);
    }

    public function exportExcel()
    {
        // 
    }
}
