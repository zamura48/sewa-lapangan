<?php

namespace App\Models;

use CodeIgniter\Model;

class Lapangan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lapangans';
    protected $primaryKey       = 'lapangan_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nomor', 'gambar', 'status'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nomor' => 'required',
        // 'status' => 'required'
    ];
    protected $validationMessages   = [
        'nomor' => [
            'required' => 'Nomor tidak boleh kosong'
        ],
        // 'status' => [
        //     'required' => 'Status tidak boleh kosong'
        // ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
