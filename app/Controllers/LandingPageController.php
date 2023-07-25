<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Lapangan;

class LandingPageController extends BaseController
{
    public function index()
    {
        $model_lapangan = new Lapangan();
        return view('layouts/landingpage', [
            'title' => "",
            'lapangan_booked' => $model_lapangan->getLapanganWithJadwals(),            
        ]);
    }
}
