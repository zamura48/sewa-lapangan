<?php
$url = session('_ci_previous_url');
$activepage = str_replace('http://localhost:8080/index.php/owner', '', $url);
$explode = explode('/', $activepage);
$jumlah_array = count($explode);
?>
<?= $this->extend('layouts/admin/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <?= $title ?>
    </h1>

    <div class="card shadow">
        <div class="card-header">
            <h4 class="card-title">Daftar
                <?= $title ?>
            </h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('owner/laporan-keuangan/export-excel') ?>" method="post">
                <label for=""> <b>Filter</b></label>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="bulan">Pilih bulan:</label>
                            <select id="bulan" name="bulan" class="form-control bulan">
                                <option value="">-- Pilih Bulan --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="cold-md-2">
                        <div class="form-group">
                            <label for="">Tahun</label>
                            <input type="number" class="form-control" name="tahun" id="tahun" min="1999"
                                max="<?= date('Y') ?>" placeholder="Tahun">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        &nbsp; <button type="submit" class="btn btn-info mt-4">Export Excel</button>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary btn_reset">Reset</button>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label>Pilih Tipe Pembayaran</label>
                            <select class="form-control tipe_pembayaran" name="" data-allow-clear="true">
                                <option value=''>-- Pilih --</option>
                                <option value="CASH">CASH</option>
                                <option value="DP">DP</option>
                            </select>
                        </div>
                    </div> -->
                </div>
            </form>


            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <th>No.</th>
                        <th>Kode Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                        <th>Dibayar</th>
                        <!-- <th>Tipe Pembayaran</th> -->
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($datas as $data) { ?>
                            <tr>
                                <td class="align-middle">
                                    <?= $no++ ?>
                                </td>
                                <td class="align-middle">
                                    <?= $data['kode_pembayaran'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $data['tanggal'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $data['jamMulai'] . ' - ' . $data['jamAkhir'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= "Rp. " . number_format($data['harga'], 0, ".", ","); ?>
                                </td>
                                <td class="align-middle">
                                    <?= "Rp. " . number_format($data['harga_total'], 0, ".", ","); ?>
                                </td>
                                <td class="align-middle">
                                    <?= "Rp. " . number_format($data['subtotal'], 0, ".", ","); ?>
                                </td>
                                <!-- <td class="align-middle">
                                    <?= $data['payment_method'] ?>
                                </td> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content') ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function () {

        $('.table').dataTable({
            language: {
                "sProcessing": "Sedang memproses...",
                "sLengthMenu": "Tampilkan _MENU_ entri",
                "sZeroRecords": "Tidak ditemukan data yang sesuai",
                "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix": "",
                "sSearch": "Cari:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Pertama",
                    "sPrevious": "Sebelumnya",
                    "sNext": "Selanjutnya",
                    "sLast": "Terakhir"
                }
            }
        });
    });

    let bulan, tahun, tipe_pembayaran;

    function filterData(value, column) {
        $('.table').DataTable().column(column).search(value == '' ? value : value, true, false).draw();
    }

    $('.btn_reset').click(function (e) {
        e.preventDefault();
        $('.bulan').val('').trigger('change');
        $('#tahun').val('');
        filterData('', 2);
    });

    $('.bulan').on('change', function () {
        bulan = $(this).val();

        filterData(bulan + '-', 2);
        if (tahun) {
            filterData(tahun + '-' + bulan + '-', 2);
        }
    });

    // $('.tipe_pembayaran').on('change', function () {
    //     tipe_pembayaran = $(this).val();

    //     filterData(tipe_pembayaran, 7);
    // });

    $("#tahun").blur(function (e) {
        e.preventDefault();
        tahun = $(this).val();

        filterData(tahun + '-', 2);
        if (bulan) {
            filterData(tahun + '-' + bulan, 2);
        }
    });
</script>
<?= view('layouts/alert') ?>
<?= $this->endSection('js') ?>