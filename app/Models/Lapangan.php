<?php

namespace App\Models;

use CodeIgniter\Model;

class Lapangan extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'lapangans';
    protected $primaryKey = 'lapangan_id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nomor', 'gambar', 'status', 'jam_mulai', 'jam_akhir'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nomor' => 'required',
        // 'status' => 'required'
    ];
    protected $validationMessages = [
        'nomor' => [
            'required' => 'Nomor tidak boleh kosong'
        ],
        // 'status' => [
        //     'required' => 'Status tidak boleh kosong'
        // ]
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

    public function getLapanganExist($tanggal = '', $jam_mulai = '', $jam_akhir = '')
    {
        $query = "SELECT l.nomor, l.harga, l.lapangan_id, j.tanggal, jm.jamMulai, jm.jamAkhir
        -- , p.status
        FROM lapangans l
        LEFT JOIN jadwals j ON j.id_lapangan = l.lapangan_id AND j.tanggal = '$tanggal' AND j.status_booking != 'Batal'
        LEFT JOIN jams jm ON j.id_jam = jm.jam_id AND jm.jamMulai BETWEEN '$jam_mulai' AND '$jam_akhir' AND jm.jamAkhir BETWEEN '$jam_mulai' AND '$jam_akhir'
        -- LEFT JOIN bookings b ON b.id_jadwal = j.jadwal_id
        -- LEFT JOIN `pembayarans` p ON p.id_booking = b.booking_id
        WHERE l.status = 0
        ORDER BY l.lapangan_id asc, jm.jamMulai desc";
        $result = $this->db->query($query)->getResultArray();

        $data = [];

        $lapangan_id = 0;

        foreach ($result as $item) {
            if ($item['jamMulai'] == null && $item['jamMulai'] == null) {
                if ($lapangan_id == 0) {
                    $lapangan_id = $item['lapangan_id'];

                    $data[] = [
                        'lapangan_id' => $item['lapangan_id'],
                        'nomor' => $item['nomor'],
                        'harga' => $item['harga'],
                    ];
                } else {
                    if ($lapangan_id != $item['lapangan_id']) {
                        $lapangan_id = $item['lapangan_id'];

                        $data[] = [
                            'lapangan_id' => $item['lapangan_id'],
                            'nomor' => $item['nomor'],
                            'harga' => $item['harga'],
                        ];
                    }
                }
            } else {
                $lapangan_id = $item['lapangan_id'];
            }
        }

        return $data;
    }

    public function getJumlahLapangan()
    {
        $query = "select count(lapangan_id) as total_lapangan from lapangans";

        return $this->db->query($query)->getResult();
    }

    public function getLapanganWithJadwal($date = '')
    {
        $datas = $this->findAll();

        $result = [];

        foreach ($datas as $data) {
            $query = "SELECT jadwals.tanggal, jams.jamMulai, jams.jamAkhir
        FROM jadwals
        RIGHT JOIN jams ON jadwals.id_jam = jams.jam_id
        RIGHT JOIN lapangans ON jadwals.id_lapangan = lapangans.lapangan_id AND lapangans.lapangan_id = '{$data['lapangan_id']}'
        WHERE jadwals.tanggal = CURDATE()
        ORDER BY jams.jam_id asc";

            $get_jadwals = $this->db->query($query)->getResultArray();

            $row = [];
            $row['lapangan_id'] = $data['lapangan_id'];
            $row['nomor'] = $data['nomor'];
            $row['status'] = $data['status'];

            foreach ($get_jadwals as $item) {
                $rw = [];
                $rw['tanggal'] = $item['tanggal'];
                $rw['jamMulai'] = $item['jamMulai'];
                $rw['jamAkhir'] = $item['jamAkhir'];

                $row['jadwal'][] = $rw;
            }

            $result[] = $row;
        }

        return $result;
    }

    public function getLapanganWithJadwals()
    {

        $query = "SELECT lapangans.nomor, jadwals.tanggal, jams.jamMulai, jams.jamAkhir
    FROM jadwals
    left JOIN jams ON jadwals.id_jam = jams.jam_id
    left JOIN lapangans ON jadwals.id_lapangan = lapangans.lapangan_id
    WHERE jadwals.tanggal = CURDATE() and jadwals.status_booking != 'Batal'
    ORDER BY jams.jam_id asc";

        $get_jadwals = $this->db->query($query)->getResultArray();

        $result = [];
        foreach ($get_jadwals as $item) {

            $row = [];
            $row['nomor'] = $item['nomor'];
            $row['tanggal'] = $item['tanggal'];
            $row['jamMulai'] = $item['jamMulai'];
            $row['jamAkhir'] = $item['jamAkhir'];

            $result[] = $row;
        }

        return $result;
    }
}