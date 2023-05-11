<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Booking;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanPemesananController extends BaseController
{
    protected $modelBooking;

    public function __construct()
    {
        $this->modelBooking = new Booking();
    }
    
    public function index()
    {
        return view('admin/laporan_pemesanan/index', [
            'title' => "Laporan Pemesanan",
            'datas' => $this->modelBooking->getDataPesananTerbayar("Terbayar")
        ]);
    }

    public function exportExcel()
    {
        $input = $this->request->getPost();
        $datas = $this->modelBooking->getDataBerdasarkanTanggal($input['tanggal_mulai'], $input['tanggal_akhir']);

        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No.')
            ->setCellValue('B1', 'Kode Pembayaran')
            ->setCellValue('C1', 'Nama Pelanggan')
            ->setCellValue('D1', 'Tanggal')
            ->setCellValue('E1', 'Jam')
            ->setCellValue('F1', 'Harga')
            ->setCellValue('G1', 'Subtotal')
            ->setCellValue('H1', 'Tipe Pembayaran')
            ->setCellValue('I1', 'Dibayar');

        $column = 2;
        $no = 1;

        foreach ($datas as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data['kode_pembayaran'])
                ->setCellValue('C' . $column, $data['nama'])
                ->setCellValue('D' . $column, $data['tanggal'])
                ->setCellValue('E' . $column, $data['jamMulai'] .' - '.$data['jamAkhir'])
                ->setCellValue('F' . $column, "Rp. " . number_format($data['harga'], 0, ".", ","))
                ->setCellValue('G' . $column, "Rp. " . number_format($data['harga_total'], 0, ".", ","))
                ->setCellValue('H' . $column, $data['payment_method'])
                ->setCellValue('I' . $column, "Rp. " . number_format($data['subtotal'], 0, ".", ","));

            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $file_name = "Laporan pemesanan {$input['tanggal_mulai']} - {$input['tanggal_akhir']}.xlsx";
        $writer->save($file_name);

        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');

		header('Expires: 0');

		header('Cache-Control: must-revalidate');

		header('Pragma: public');

		header('Content-Length:' . filesize($file_name));

		flush();

		readfile($file_name);

        exit();
    }
}
