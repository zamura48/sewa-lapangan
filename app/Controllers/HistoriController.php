<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pembayaran;
use App\Models\User;
use Midtrans\Transaction;

class HistoriController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Pembayaran();
    }

    public function index()
    {
        $modelUser = new User();
        $datas = $this->model->getHistoris($modelUser->getIdPelanggan(session('username')));
        
        return view('pelanggan/history/index', [
            'title' => ' | Histori',
            'datas' => $datas
        ]);
    }

    public function invoice($id) 
    {
        return view('pelanggan/history/invoice', [
            'datas' => $this->model->getInvoice($id)
        ]);
    }
}
