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
        $modelUser->save([
            'role' => "Admin",
            'username' => "admin",
            'email' => "admin@admin.com",
            'password' => password_hash("123123123", PASSWORD_DEFAULT)
        ]);
    }
}
