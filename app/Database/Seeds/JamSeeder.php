<?php

namespace App\Database\Seeds;

use App\Models\Jam;
use CodeIgniter\Database\Seeder;

class JamSeeder extends Seeder
{
    public function run()
    {
        $model = new Jam();
        $model->save([
            'jam' => "17:00",
        ]);
    }
}
