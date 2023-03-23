<?php

namespace App\Models;

use CodeIgniter\Model;

class Booking extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pelanggan', 'id_jadwal', 'harga', 'subtotal'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        // 'id_pelanggan' => 'required',
        'id_jadwal' => 'required', 
        'harga' => 'required', 
        'subtotal' => 'required'
    ];
    protected $validationMessages   = [
        // 'id_pelanggan' => [
        //     'required' => 'Pelanggan tidak boleh kosong'
        // ],
        'id_jadwal' => [
            'required' => 'Jadwal tidak boleh kosong'
        ], 
        'harga' => [
            'required' => 'Harga tidak boleh kosong'
        ], 
        'subtotal' => [
            'required' => 'Subtotal tidak boleh kosong'
        ]
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

    public function getDataPesanans()
    {
        $result = $this->join('pelanggans', 'bookings.id_pelanggan = pelanggans.pelanggan_id')
        ->join('jadwals', 'bookings.id_jadwal = jadwals.jadwal_id')
        ->join('lapangans', 'jadwals.id_lapangan = lapangans.lapangan_id')
        ->join('jams', 'jadwals.id_jam = jams.jam_id')
        ->select('pelanggans.nama, jams.jam, lapangans.nomor, lapangans.gambar, lapangans.status, jadwals.tanggal, jadwals.harga')
        ->find();

        return $result;
    }

    public function getDataPesananUser($idUser)
    {
        $result = $this->join('pelanggans', 'bookings.id_pelanggan = pelanggans.pelanggan_id')
        ->join('jadwals', 'bookings.id_jadwal = jadwals.jadwal_id')
        ->join('lapangans', 'jadwals.id_lapangan = lapangans.lapangan_id')
        ->join('jams', 'jadwals.id_jam = jams.jam_id')
        ->join('users', 'pelanggans.id_user = users.user_id')
        ->select('bookings.booking_id, pelanggans.nama, jams.jam, lapangans.nomor, lapangans.gambar, lapangans.status, jadwals.tanggal, jadwals.harga')
        ->where('users.user_id', $idUser)
        ->find();

        return $result;
    }

    public function getDataPesanan($idBooking)
    {
        $result = $this->join('pelanggans', 'bookings.id_pelanggan = pelanggans.pelanggan_id')
        ->join('users', 'pelanggans.id_user = users.user_id')
        ->select('bookings.booking_id, pelanggans.nama, users.email, pelanggans.noHp, bookings.harga, bookings.subtotal')
        ->where('bookings.booking_id', $idBooking)
        ->first();

        return $result;
    }
}
