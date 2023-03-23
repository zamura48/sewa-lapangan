<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LandingPageController extends BaseController
{
    public function index()
    {
        return view('layouts/landingpage', [
            'title' => ""
        ]);
    }
}
