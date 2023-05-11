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
            <div class="table-responsive">

                <table class="table table-bordered">
                    <thead class="text-center">
                        <th>No.</th>
                        <th>Nama</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
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
                                    <?= $data['nama'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $data['noHp'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $data['alamat'] ?>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn btn-info" data-toggle="modal"
                                        data-target="#detail-pelanggan-<?= $data['pelanggan_id'] ?>">Detail Pelanggan</a>
                                </td>
                            </tr>

                            <!-- detil modal -->
                            <div class="modal fade" id="detail-pelanggan-<?= $data['pelanggan_id'] ?>" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Detail Pelanggan</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Nama</label>
                                                        <input type="text" class="form-control" readonly value="<?= $data['nama'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Nomor HP</label>
                                                        <input type="text" class="form-control" readonly value="<?= $data['noHp'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Alamat</label>
                                                        <textarea readonly class="form-control" name="" id="" cols="30" rows="2"><?= $data['alamat'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="text" class="form-control" readonly value="<?= $data['email'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Username</label>
                                                        <input type="text" class="form-control" readonly value="<?= $data['username'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end modal body -->
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Cancel</button>
                                        </div>
                                        <!-- end modal footer -->
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