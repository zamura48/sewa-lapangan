<?php
$url = session('_ci_previous_url');
$activepage = str_replace('http://localhost:8080/index.php/admin', '', $url);
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
            <form action="<?= base_url('owner/laporan-pemesanan/export-excel') ?>" method="post">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="date" class="form-control" name="tanggal_mulai" placeholder="Tanggal Mulai">
                        </div>
                    </div>
                    <div class="cold-md-2">
                        <div class="form-group">
                            <input type="date" class="form-control" name="tanggal_akhir" placeholder="Tanggal Akhir">
                        </div>
                    </div>
                    <div class="cold-md-3">
                        &nbsp; <button type="submit" class="btn btn-info">Export Excel</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <th>No.</th>
                        <th>Kode Pembayaran</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                        <th>Tipe Pembayaran</th>
                        <th>Dibayar</th>
                        <th>Aksi</th>
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
                                    <?= $data['nama'] ?>
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
                                    <?= $data['payment_method'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= "Rp. " . number_format($data['subtotal'], 0, ".", ","); ?>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn btn-info" data-toggle="modal"
                                        data-target="#detailPesananModal<?= $data['booking_id'] ?>">Detail</a>
                                </td>
                            </tr>

                            <!-- detail modal -->
                            <div class="modal fade" id="detailPesananModal<?= $data['booking_id'] ?>" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Kode Pembayaran</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= $data['kode_pembayaran'] ?>">
                                                    </div>
                                                </div>
                                                <!-- end div kode Pembayaran -->
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="">Nama Pelanggan</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= $data['nama'] ?>">
                                                    </div>
                                                </div>
                                                <!-- end div kode nama pelanggan -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">No. HP</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= $data['noHp'] ?>">
                                                    </div>
                                                </div>
                                                <!-- end div kode No. HP -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Lapangan Nomor</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= $data['nomor'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Tanggal</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= $data['tanggal'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Jam</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= $data['jamMulai'] . ' - ' . $data['jamAkhir'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Harga</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= "Rp. " . number_format($data['harga'], 0, ".", ","); ?>">
                                                    </div>
                                                </div>
                                                <!-- end div kode total -->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Sub Total</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= "Rp. " . number_format($data['harga_total'], 0, ".", ","); ?>">
                                                    </div>
                                                </div>
                                                <!-- end div kode subtotal -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Tipe Pembayaran</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= $data['payment_method'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Dibayar</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= "Rp. " . number_format($data['subtotal'], 0, ".", ","); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Status</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="<?= $data['status'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end modal body -->
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Tutup</button>
                                        </div>
                                        <!-- end modal footer -->
                                        </form>
                                        <!-- end form -->
                                    </div>
                                </div>
                            </div>
                            <!-- end modal -->
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
</script>
<?= view('layouts/alert') ?>
<?= $this->endSection('js') ?>