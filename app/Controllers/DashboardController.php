<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function adminIndex()
    {
        return view('admin/dashboard/index');
    }

    public function pelangganIndex()
    {
        return view('pelanggan/pesanlapangan/index', [
            'title' => " | Pesan Lapangan"
        ]);
    }
}
