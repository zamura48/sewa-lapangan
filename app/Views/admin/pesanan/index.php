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
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Pilih Tipe Pembayaran</label>
                        <select class="form-control tipe_pembayaran" name="" data-allow-clear="true">
                            <option value=''>-- Pilih --</option>
                            <option value="CASH">CASH</option>
                            <option value="DP">DP</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Pilih Status Pembayaran</label>
                        <select class="form-control status_pembayaran" name="" data-allow-clear="true">
                            <option value=''>-- Pilih --</option>
                            <option value="Terbayar">Terbayar</option>
                            <option value="Belum dibayar">Belum dibayar</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">

                <table class="table table-bordered">
                    <thead class="text-center">
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Nama Pelanggan</th>
                        <th>Tipe Pembayaran</th>
                        <th>Sub Total</th>
                        <th>Status</th>
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
                                    <?= $data['tanggal'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $data['nama'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $data['payment_method'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= "Rp. " . number_format($data['harga_total'], 0, ".", ","); ?>
                                </td>
                                <td class="align-middle">
                                    <?= $data['status'] ?>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn btn-info" data-toggle="modal"
                                        data-target="#detailPesananModal<?= $data['booking_id'] ?>">Detail</a>
                                    <a class="btn btn-warning" data-toggle="modal"
                                        data-target="#ubahPesananModal<?= $data['booking_id'] ?>">Ubah Status</a>
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

                            <!-- ubah modal -->
                            <div class="modal fade" id="ubahPesananModal<?= $data['booking_id'] ?>" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ubah Pesanan</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="<?= base_url('admin/pesanan/update/' . $data['pembayaran_id']) ?>"
                                            method="post">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Status</label>
                                                            <select class="form-control" name="status" id="status" required>
                                                                <option value="Terbayar" <?= $data['status'] == "Terbayar" ? 'selected' : '' ?>>Terbayar</option>
                                                                <option value="Belum dibayar" <?= $data['status'] == "Belum dibayar" ? 'selected' : '' ?>>Belum dibayar</option>
                                                            </select>
                                                            <!-- <input type="text" readonly class="form-control"
                                                                value="<?= $data['status'] ?>"> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end modal body -->
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-success" type="button">Simpan</button>
                                            </div>
                                        </form>
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
    function filterData(value, column) {
        $('.table').DataTable().column(column).search(value == '' ? value : '^' + value + '$', true, false).draw();
    }

    $('.tipe_pembayaran').on('change', function () {
        let this_value = $(this).val();

        filterData(this_value, 3);
    });

    $('.status_pembayaran').on('change', function () {
        let this_value = $(this).val();

        filterData(this_value, 5);
    });

    $(document).ready(function () {
        $('.table').dataTable({
            responsive: true,
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