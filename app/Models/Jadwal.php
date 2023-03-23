<?php

namespace App\Models;

use CodeIgniter\Model;

class Jadwal extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'jadwals';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    // protected $insertID         = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_jam', 'id_lapangan', 'tanggal', 'harga', 'status_booking'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'id_jam' => 'required',
        'id_lapangan' => 'required',
        'tanggal' => 'required|date',
        'harga' => 'required',
        'status_booking' => 'required'
    ];
    protected $validationMessages = [
        'id_jam' => [
            'required' => 'Jam tidak boleh kosong'
        ],
        'id_lapangan' => [
            'required' => 'Lapangan tidak boleh kosong'
        ],
        'tanggal' => [
            'required' => 'Tanggal tidak boleh kosong',
        ],
        'harga' => [
            'required' => 'Harga tidak boleh kosong'
        ],
        'status_booking' => [
            'required' => 'Status Booking tidak boleh kosong'
        ],
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

    public function getJadwalWithLapanganAndJams()
    {
        $result = $this->join('lapangans', 'jadwals.id_lapangan = lapangans.lapangan_id')
            ->join('jams', 'jadwals.id_jam = jams.jam_id')
            ->select('jadwals.jadwal_id, jams.jam, lapangans.nomor, lapangans.gambar, lapangans.status, jadwals.tanggal, jadwals.harga, jadwals.status_booking')
            ->orderBy('jadwals.status_booking', 'asc')
            ->find();

        return $result;
    }

    public function getJadwalWithLapanganAndJam($id)
    {
        $result = $this->join('lapangans', 'jadwals.id_lapangan = lapangans.lapangan_id')
            ->join('jams', 'jadwals.id_jam = jams.jam_id')
            ->select('jadwals.jadwal_id, jams.jam, lapangans.nomor, lapangans.gambar, lapangans.status, jadwals.tanggal, jadwals.harga, jadwals.status_booking')
            ->where('jadwals.jadwal_id', $id)
            ->orderBy('jadwals.status_booking', 'asc')
            ->first();

        return $result;
    }

    public function getJadwalLapanganExit($tanggal, $jamMulai, $jamAkhir)
    {
        $result = $this->join('lapangans', 'jadwals.id_lapangan = lapangans.lapangan_id')
            ->join('jams', 'jadwals.id_jam = jams.jam_id')
            ->select('jadwals.jadwal_id, jams.jam, lapangans.nomor, lapangans.gambar, lapangans.status, jadwals.tanggal, jadwals.harga, jadwals.status_booking')
            ->where('jadwals.tanggal', $tanggal)
            ->where('jams.jam Between "'.$jamMulai.'" and "'. $jamAkhir. '"')
            ->orderBy('jadwals.status_booking', 'asc')
            ->find();

        return $result;
    }
}