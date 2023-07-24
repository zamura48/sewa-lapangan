<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pembayaran;
use App\Models\User;
use Midtrans\Transaction;
use Midtrans\Config;

class HistoriController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Pembayaran();
        
        Config::$serverKey = getenv('midtrans.serverKey');
        Config::$clientKey = getenv('midtrans.clientKey');
        // Config::$isProduction = getenv('midtrans.isProduction');
        Config::$isSanitized = getenv('midtrans.isSanitized');
        Config::$is3ds = getenv('midtrans.is3ds');

        try {
            $this->model->perbaruiPembyaran();
        } catch (\Throwable $th) {
            $this->model->perbaruiPembyaran();
        }
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
