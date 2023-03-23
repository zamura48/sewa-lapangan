<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Booking;

class PesananController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Booking();
    }

    public function index()
    {
        dd($this->model->getDataPesanans());
        return view('admin/pesanan/index', [
            'datas' => $this->model->getDataPesanans()
        ]);
    }
}
