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
            ->join('jams', 'jadwals.id_jam = jams.jam_id')
            ->join('lapangans', 'jadwals.id_lapangan = lapangans.lapangan_id')
            ->select('pembayarans.pembayaran_id, pembayarans.pembayaran_id, pembayarans.kode_pembayaran, pembayarans.payment_method, lapangans.nomor, jadwals.status_booking, jams.jamMulai, jams.jamAkhir, jadwals.tanggal, pembayarans.status, pembayarans.payment_type')
            ->where('bookings.id_pelanggan', $idPelanggan)
            ->orderBy('pembayarans.pembayaran_id', 'desc')
            ->find();

        $datas = array();
        foreach ($results as $result) {
            $datas[] = [
                'pembayaran_id' => $result['pembayaran_id'],
                'kode_pembayaran' => $result['kode_pembayaran'],
                'nomor' => $result['nomor'],
                'tanggal' => $result['tanggal'],
                'jam' => $result['jamMulai'] . ' - ' . $result['jamAkhir'],
                'status_booking' => $result['status_booking'],
                'status_pembayaran' => $result['status']
            ];
        }

        return $datas;
    }

    public function getInvoice($pembayaran_id)
    {
        $dataBooking = $this->join('bookings', 'pembayarans.id_booking = bookings.booking_id', 'left')
            ->join('jadwals', 'bookings.id_jadwal = jadwals.jadwal_id', 'left')
            ->join('jams', 'jadwals.id_jam = jams.jam_id', 'left')
            ->join('lapangans', 'jadwals.id_lapangan = lapangans.lapangan_id', 'left')
            ->select('pembayarans.pembayaran_id, pembayarans.pembayaran_id, pembayarans.kode_pembayaran, pembayarans.payment_method, lapangans.nomor, jadwals.status_booking, jams.jamMulai, jams.jamAkhir, jadwals.tanggal, pembayarans.status, pembayarans.payment_type, bookings.harga, bookings.subtotal')
            ->where('pembayarans.pembayaran_id', $pembayaran_id)
            ->find();

        $dataPembayaran = $this->join('bookings', 'pembayarans.id_booking = bookings.booking_id', 'left')
            ->join('jadwals', 'bookings.id_jadwal = jadwals.jadwal_id', 'left')
            ->join('pelanggans', 'bookings.id_pelanggan = pelanggans.pelanggan_id', 'left')
            ->select('pembayarans.kode_pembayaran, jadwals.tanggal, pelanggans.nama')
            ->where('pembayarans.pembayaran_id', $pembayaran_id)
            ->find();

        return [$dataBooking, $dataPembayaran];
    }

    public function getPembayaran($kodePembayaran)
    {
        $dataPembayaran = $this->join('bookings', 'pembayarans.id_booking = bookings.booking_id', 'left')
            ->join('jadwals', 'bookings.id_jadwal = jadwals.jadwal_id', 'left')
            ->join('pelanggans', 'bookings.id_pelanggan = pelanggans.pelanggan_id', 'left')
            ->join('users', 'pelanggans.id_user = users.user_id', 'left')
            ->select('pembayarans.pembayaran_id, pembayarans.kode_pembayaran, jadwals.tanggal, pelanggans.nama, pelanggans.noHp, users.email, bookings.subtotal, pembayarans.no_rek')
            ->where('pembayarans.kode_pembayaran', $kodePembayaran)
            ->find();

        $data = [];
        foreach ($dataPembayaran as $value) {
            $data['pembayaran_id'] = $value['pembayaran_id'];
            $data['kode_pembayaran'] = $value['kode_pembayaran'];
            $data['kode_pembayaran'] = $value['kode_pembayaran'];
            $data['nama'] = $value['nama'];
            $data['noHp'] = $value['noHp'];
            $data['email'] = $value['email'];
            $data['subtotal'] = $value['subtotal'];
            break;
        }

        return $data;
    }

    public function perbaruiPembyaran()
    {
        $results = $this->select('kode_pembayaran, status, no_rek')->find();

        foreach ($results as $result) {
            if ($result['status'] != 'Lunas' && $result['status'] != 'DP Terbayar' && $result['status'] != 'Cancel') {
                $midtranStatus = Transaction::status($result['kode_pembayaran']);
                $transaction_status = '';
                if ($midtranStatus->transaction_status == 'settlement') {
                    if ($result['payment_method'] == 'CASH') {
                        $transaction_status = 'Lunas';
                    } else {
                        $transaction_status = 'DP Terbayar';
                    }
                } elseif ($midtranStatus->transaction_status == 'pending') {
                    $transaction_status = 'Belum dibayar';
                } elseif ($midtranStatus->transaction_status == 'failure') {
                    $transaction_status = 'Gagal';
                } else {
                    $transaction_status = 'Cancel';
                }

                $this->set(['status' => $transaction_status]);
                $this->where('kode_pembayaran', $result['kode_pembayaran']);
                $this->where('payment_type', null);
                $this->update();
            }

            if (empty($result['no_rek'])) {
                $midtranStatus = Transaction::status($result['kode_pembayaran']);

                $this->set(['no_rek' => $midtranStatus->transaction_time]);
                $this->where('kode_pembayaran', $result['kode_pembayaran']);
                $this->update();
            }
        }
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
        WHERE p.status = 'Lunas'
        GROUP BY MONTH(j.tanggal)";

        return $this->db->query($query, [$get_bulan, $get_tahun])->getResult();
    }
}