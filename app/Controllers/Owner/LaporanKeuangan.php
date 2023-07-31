<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\Booking;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanKeuangan extends BaseController
{
    protected $modelBooking;

    public function __construct()
    {
        $this->modelBooking = new Booking();
    }
    
    public function index()
    {
        return view('owner/laporan_keuangan/index', [
            'title' => "Laporan Keuangan",
            'datas' => $this->modelBooking->getDataPesananTerbayar("Lunas")
        ]);
    }

    public function exportExcel()
    {
        $input = $this->request->getPost();
        $datas = $this->modelBooking->getDataBerdasarkanBulan($input['bulan'], $input['tahun']);

        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No.')
            ->setCellValue('B1', 'Kode Pembayaran')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Jam')
            ->setCellValue('E1', 'Harga')
            ->setCellValue('F1', 'Subtotal')
            ->setCellValue('G1', 'Dibayar');

        $column = 2;
        $no = 1;
        $total = 0;

        foreach ($datas as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data['kode_pembayaran'])
                ->setCellValue('C' . $column, $data['tanggal'])
                ->setCellValue('D' . $column, $data['jamMulai'] .' - '.$data['jamAkhir'])
                ->setCellValue('E' . $column, "Rp. " . number_format($data['harga'], 0, ".", ","))
                ->setCellValue('F' . $column, "Rp. " . number_format($data['harga_total'], 0, ".", ","))
                ->setCellValue('G' . $column, "Rp. " . number_format($data['subtotal'], 0, ".", ","));

            $total += $data['subtotal'];
            $column++;
        }

        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, 'Total')
                ->mergeCells("A$column:F$column")
                ->setCellValue('G' . $column, "Rp. " . number_format($total, 0, ".", ","));

        $writer = new Xlsx($spreadsheet);
        $file_name = "Laporan Keuangan.xlsx";
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
