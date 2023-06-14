<?php

namespace App\Controllers\Owner;

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

    public function index()
    {
        $total_harga = 0;
        if (!empty($this->model_pembayaran->getTotalPendapatanPerbulan())) {
            $total_harga = $this->model_pembayaran->getTotalPendapatanPerbulan()[0]->total_harga;
        } 

        return view('owner/dashboard/index', [
            'title' => "Dashboard",
            'pendapatan' => $total_harga,
            'total_lapangan' => $this->model_lapangan->getJumlahLapangan()[0]->total_lapangan
        ]);
    }
}
