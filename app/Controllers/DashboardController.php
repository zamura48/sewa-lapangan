<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Lapangan;
use App\Models\Pembayaran;

class DashboardController extends BaseController
{
    protected $model_pembayaran;
    protected $model_lapangan;

    public function __construct()
    {
        $this->model_pembayaran = new Pembayaran();
        $this->model_lapangan = new Lapangan();
    }

    public function adminIndex()
    {
        return view('admin/dashboard/index', [
            'title' => 'Dashboard',
            'pendapatan' => $this->model_pembayaran->getTotalPendapatanPerbulan()[0]->total_harga,
            'total_lapangan' => $this->model_lapangan->getJumlahLapangan()[0]->total_lapangan
        ]);
    }

    public function pelangganIndex()
    {
        return view('pelanggan/pesanlapangan/index', [
            'title' => " | Pesan Lapangan"
        ]);
    }
}
