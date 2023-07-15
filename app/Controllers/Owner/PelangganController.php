<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\Pelanggan;

class PelangganController extends BaseController
{
    protected $modelPelanggan;

    public function __construct()
    {
        $this->modelPelanggan = new Pelanggan();
    }

    public function index()
    {
        return view('owner/pelanggan/index', [
            'title' => "Pelanggan",
            'datas' => $this->modelPelanggan->join('users', 'pelanggans.id_user = users.user_id')->whereNotIn('nama', ['Admin', 'Owner'])->find()
        ]);
    }
}
