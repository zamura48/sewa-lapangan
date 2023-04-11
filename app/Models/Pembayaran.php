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
        $modelJadwal = new Jadwal();
        $modelJadwal->jadwalSelesai();

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

            $this->update($result['kode_pembayaran'], [
                'status' => $transaction_status
            ]);

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

    public function cancelBayarLangsung($idLapangan)
    {
        $sql = "DELETE pembayarans, bookings, jadwals, jams FROM pembayarans
        JOIN bookings ON pembayarans.id_booking = bookings.booking_id
        JOIN jadwals ON bookings.id_jadwal = jadwals.jadwal_id
        JOIN jams ON jadwals.id_jam = jams.jam_id
        WHERE jadwals.id_lapangan = ?";

        $this->db->query($sql, array($idLapangan));
    }
}