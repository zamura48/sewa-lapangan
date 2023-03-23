<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['role', 'username', 'email', 'password'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'username' => 'required',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
    ];
    protected $validationMessages = [
        'username' => [
            'required' => 'Username tidak boleh kosong'
        ],
        'role' => [
            'required' => 'Role tidak boleh kosong'
        ],
        'email' => [
            'required' => 'Email tidak boleh kosong',
            'email' => 'Format email salah',
            'is_unique' => 'Email sudah terpakai, tolong gunakan email lain'
        ],
        'password' => [
            'required' => 'Password tidak boleh kosong',
            'min_length' => 'Panjang password minimal 8'
        ]
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getProfile($username)
    {
        $result = $this->join('pelanggans', 'users.user_id = pelanggans.id_user')
            ->select('pelanggans.nama, pelanggans.noHp, pelanggans.alamat, users.email')
            ->where('username', $username)
            ->first();

        return $result;
    }

    public function getIdUser($username)
    {
        $result = $this->where('username', $username)->first();

        return $result['user_id'];
    }
}