<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\Lapangan;

class LapanganController extends BaseController
{
    protected $modelLapangan;

    public function __construct()
    {
        $this->modelLapangan = new Lapangan();
    }
    
    public function index()
    {
        return view('owner/lapangan/index', [
            'title' => "Lapangan",
            'datas' => $this->modelLapangan->getLapanganWithJadwal(),
        ]);
    }
}
