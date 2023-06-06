<?php

namespace App\Models;

use CodeIgniter\Model;
use Midtrans\Transaction;

class Pembayaran extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'pembayarans';
    protected $primaryKey = 'pembayaran_id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['pembayaran_id', 'kode_pembayaran', 'id_booking', 'payment_method', 'payment_type', 'no_rek', 'status'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
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

    public function getHistoris($idPelanggan)
    {
        $results = $this->join('bookings', 'pembayarans.id_booking = bookings.booking_id')
            ->join('jadwals', 'bookings.id_jadwal = jadwals.jadwal_id')
            ->join('lapangans', 'jadwals.id_lapangan = lapangans.lapangan_id')
            ->select('pembayarans.pembayaran_id, pembayarans.kode_pembayaran, lapangans.nomor, jadwals.status_booking, jadwals.tanggal, pembayarans.status')
            ->where('bookings.id_pelanggan', $idPelanggan)
            ->find();


        $datas = array();
        foreach ($results as $result) {
            $midtranStatus = Transaction::status($result['kode_pembayaran']);
            $transaction_status = '';
            if ($midtranStatus->transaction_status == 'settlement') {
                $transaction_status = 'Terbayar';
            } elseif ($midtranStatus->transaction_status == 'pending') {
                $transaction_status = 'Belum dibayar';
            } elseif ($midtranStatus->transaction_status == 'failure') {
                $transaction_status = 'Gagal';
            }
            
            $this->set(['status' => $transaction_status]);
            $this->where('kode_pembayaran', $result['kode_pembayaran']);
            $this->update();

            $datas[] = [
                'kode_pembayaran' => $result['kode_pembayaran'],
                'nomor' => $result['nomor'],
                'tanggal' => $result['tanggal'],
                'status_booking' => $result['status_booking'],
                'status_pembayaran' => $transaction_status
            ];
        }

        return $datas;
    }

    public function cancelPayment($idBooking)
    {
        $this->whereIn("id_booking", $idBooking)->delete();
    }

    public function cancelBayarLangsung($id = [])
    {
        $this->db->table('pembayarans')->where('pembayaran_id', $id['id_pembayaran'])->delete();
        $this->db->table('bookings')->where('booking_id', $id['id_booking'])->delete();
        $this->db->table('jadwals')->where('jadwal_id', $id['id_jadwal'])->delete();
        $this->db->table('jams')->where('jam_id', $id['id_jam'])->delete();

        // $this->db->query($sql, array($idLapangan));
    }

    public function getTotalPendapatanPerbulan($bulan = '', $tahun = '')
    {
        $get_bulan = $bulan == '' ? date('n') : $bulan;
        $get_tahun = $tahun == '' ? date('Y') : $tahun;

        $query = "SELECT SUM(b.harga) AS total_harga 
        FROM pembayarans p
        INNER JOIN bookings b ON b.booking_id = p.id_booking
        INNER JOIN jadwals j ON j.jadwal_id = b.id_jadwal AND MONTH(j.tanggal) = ? AND YEAR(j.tanggal) = ?
        WHERE p.status = 'Terbayar'
        GROUP BY MONTH(j.tanggal)";

        return $this->db->query($query, [$get_bulan, $get_tahun])->getResult();
    }
}