<?php

namespace App\Models;

use CodeIgniter\Model;

class Pelanggan extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'pelanggans';
    protected $primaryKey = 'pelanggan_id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_user', 'nama', 'noHp', 'alamat', 'foto'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nama' => 'required',
        'noHp' => 'required',
        'alamat' => 'required'
    ];
    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama tidak boleh kosong'
        ],
        'noHp' => [
            'required' => 'No HP tidak boleh kosong'
        ],
        'alamat' => [
            'required' => 'Alamat tidak boleh kosong'
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

    public function getPelangganWithUser($id)
    {
        $result = $this->find($id);

        $user = new User();
        $result['user'] = $user->find($result['id_user']);

        return $result;
    }

    public function destroyPelangganWithUser($id)
    {
        $dataPelanggan = $this->find($id);
        $user = new User();
        $user->where('user_id', $dataPelanggan['id_user'])->delete();
        $this->where('pelanggan_id', $id)->delete();

        return 1;
    }
}