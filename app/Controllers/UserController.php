<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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

    
}
