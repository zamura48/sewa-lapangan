<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pelanggan;
use App\Models\User;

class UserController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        $data = $this->model->findAll();

        return view('');
    }

    public function profil()
    {
        return view('pelanggan/profil/index', [
            'title' => ' | Profil',
            'data' => $this->model->getProfile(session('username'))
        ]);
    }

    public function updateProfil()
    {
        $modelUser = $this->model;
        $modelPelanggan = new Pelanggan();

        
    }
    
}
