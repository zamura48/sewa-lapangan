<?php

namespace App\Models;

use CodeIgniter\Model;

class Booking extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bookings';
    protected $primaryKey       = 'booking_id';
    protected $useAutoIncrement = true;    
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
        'id_pelanggan' => 'required',
        'id_jadwal' => 'required', 
    ];
    protected $validationMessages   = [
        'id_pelanggan' => [
            'required' => 'Pelanggan tidak boleh kosong'
        ],
        'id_jadwal' => [
            'required' => 'Jadwal tidak boleh kosong'
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

    public function getDataPesananUsers($idUser)
    {
        // $this->pembatalanBooking();

        $result = $this->join('pelanggans', 'bookings.id_pelanggan = pelanggans.pelanggan_id')
        ->join('jadwals', 'bookings.id_jadwal = jadwals.jadwal_id')
        ->join('lapangans', 'jadwals.id_lapangan = lapangans.lapangan_id')
        ->join('jams', 'jadwals.id_jam = jams.jam_id')
        ->join('users', 'pelanggans.id_user = users.user_id')
        ->select('bookings.booking_id, pelanggans.nama, jams.jamMulai, jams.jamAkhir, lapangans.nomor, lapangans.gambar, lapangans.status, jadwals.tanggal, jadwals.harga')
        ->where('bookings.id_pelanggan', $idUser)
        ->where('bookings.subtotal', null)
        ->orderBy('bookings.booking_id', 'desc')
        ->find();

        return $result;
    }

    public function getCheckOutDataPesanan(array $idBooking, $idPelanggan)
    {
        $results = $this->join('pelanggans', 'bookings.id_pelanggan = pelanggans.pelanggan_id')
        ->join('users', 'pelanggans.id_user = users.user_id')
        ->join('jadwals', 'bookings.id_jadwal = jadwals.jadwal_id')
        ->join('lapangans', 'jadwals.id_lapangan = lapangans.lapangan_id')
        ->select('bookings.booking_id, lapangans.nomor, pelanggans.nama, users.email, pelanggans.noHp, bookings.harga, bookings.subtotal, jadwals.jadwal_id')
        ->whereIn("bookings.booking_id", $idBooking)
        ->where('bookings.id_pelanggan', $idPelanggan)
        ->find();

        $datas = [
            'results' => $results,
            'subtotal' => $this->getSubTotal($idBooking, $idPelanggan)
        ];

        return $datas;
    }

    public function getSubTotal(array $idBooking, $idPelanggan)
    {
        $result = $this->join('jadwals', 'bookings.id_jadwal = jadwals.jadwal_id')
        ->selectSum("jadwals.harga", 'subtotal')
        ->whereIn("bookings.booking_id", $idBooking)
        ->where('bookings.id_pelanggan', $idPelanggan)
        ->first();

        return $result['subtotal'];
    }

    public function postPesanan($id, $tanggal, $jamMulai, $jamAkhir)
    {
        $modelJadwal = new Jadwal();
        $modelJam = new Jam();
        $modelLapangan = new Lapangan();

        $modelJam->save([
            'jamMulai' => $jamMulai,
            'jamAkhir' => $jamAkhir
        ]);

        $dataLapangan = $modelLapangan->where('lapangan_id', $id)->first();

        $selisihJam = date_diff(date_create($jamMulai), date_create($jamAkhir));
        $explodeJam = explode('.', $selisihJam->format("%h.%i"));
        
        $harga = $dataLapangan['harga'] * $explodeJam[0];

        $tambahanHarga = 0;
        if ($explodeJam[1] >= 1 && $explodeJam[1] <= 30) {
            $tambahanHarga = $dataLapangan['harga'] / 2;
        } elseif ($explodeJam[1] >= 30 && $explodeJam[1] <= 59) {
            $tambahanHarga = $dataLapangan['harga'];
        }

        $harga += $tambahanHarga;

        $modelJadwal->save([
            'id_jam' => $modelJam->getInsertID(),
            'id_lapangan' => $id,
            'tanggal' => $tanggal,
            'harga' => $harga,
            'status_booking' => 'Terboking'
        ]);

        $this->save([
            'id_pelanggan' => base64_decode(session('id')),
            'id_jadwal' => $modelJadwal->getInsertID(),
            'harga' => $harga
        ]);

        $modelLapangan->update($id, [
            'status' => 1
        ]);

        return $this->getInsertID();
    }

    public function pembatalanBooking()
    {
        $datas = $this->join('jadwals', 'bookings.id_jadwal = jadwals.jadwal_id')
        ->join('jams', 'jadwals.id_jam = jams.jam_id')
        ->select('jams.jamAkhir, jadwals.tanggal, jadwals.id_lapangan, jadwals.id_jam, bookings.id_jadwal, bookings.booking_id')
        ->where('bookings.subtotal', null)
        // ->where('jadwals.status_booking', "Terbooking")
        ->find();

        foreach ($datas as $data) {
            if ($data['tanggal'] <= date('Y-m-d')) {
                $modelJadwal = new Jadwal();
                $modelJam = new Jam();
                $modelLapangan = new Lapangan();

                $modelLapangan->update($data['id_lapangan'], ['status' => 0]);

                $modelJadwal->where('jadwal_id', $data['id_jadwal'])->delete();
                $modelJam->where('jam_id', $data['id_jam'])->delete();
                $this->where('booking_id', $data['booking_id'])->delete();
            }
        }
    }
}
