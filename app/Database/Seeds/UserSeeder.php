<?php

namespace App\Database\Seeds;

use App\Models\Pengguna;
use App\Models\User;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $modelUser = new User();
        $data = [
            [
                'role' => "Admin",
                'username' => "admin",
                'email' => "admin@admin.com",
                'password' => password_hash("admin", PASSWORD_DEFAULT)
            ],
            [
                'role' => "Pelanggan",
                'username' => "pelanggan",
                'email' => "pelanggan@admin.com",
                'password' => password_hash("pelanggan", PASSWORD_DEFAULT)
            ]
        ];
        $modelUser->insertBatch($data);
    }
}