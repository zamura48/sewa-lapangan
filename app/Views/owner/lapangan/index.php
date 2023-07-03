<?= $this->extend('layouts/admin/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <?= $title ?>
    </h1>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar
                <?= $title ?>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered text-center">
                    <thead>
                        <th>No.</th>
                        <th>Lapangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($datas as $data) { ?>
                            <tr>
                                <td class="align-middle">
                                    <?= $no++ ?>
                                </td>
                                <td class="align-middle">
                                    Lapangan
                                    <?= $data['nomor'] ?>
                                </td>
                                <td class="align-middle">
                                    <?php if ($data['status'] == 1) { ?>
                                        <span class="bg-danger text-white p-2 rounded">Repair</span>
                                    <?php } else { ?>
                                        <span class="bg-success text-white p-2 rounded">Ready</span>
                                    <?php } ?>
    
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#jadwal<?= $data['lapangan_id'] ?>">
                                        Jadwal
                                    </a>
                                    <span> | </span>
                                    <a class="btn btn-warning" href="javascript:void(0)" data-toggle="modal" data-target="#editLapanganModal<?= $data['lapangan_id'] ?>">
                                        Edit
                                    </a>
                                </td>
                            </tr>
    
                            <!-- edit modal -->
                            <div class="modal fade" id="editLapanganModal<?= $data['lapangan_id'] ?>" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ubah Status Lapangan</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="<?= base_url('owner/lapangan/update/'. $data['lapangan_id']) ?>" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Nomor</label>
                                                    <input type="text" id="nomor" name="nomor" class="form-control"
                                                        value="<?= $data['nomor'] ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Status</label>
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="0" <?php if ($data['status'] == 0) { ?>
                                                            selected
                                                        <?php } ?>>Ready</option>
                                                        <option value="1" <?php if ($data['status'] == 1) { ?>
                                                            selected
                                                        <?php } ?>>Repair</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                            <!-- end modal footer -->
                                        </form>
                                        <!-- end form -->
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="jadwal<?= $data['lapangan_id'] ?>" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Daftar Jadwal Yang Tebooking</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <?php if (isset($data['jadwal'])) { ?>
                                                    <?php foreach ($data['jadwal'] as $item) { ?>
                                                        <div class="col-md-3">
                                                            <div class="card shadow">
                                                                <div class="card-body">
                                                                    <span>Tanggal: <br> <?= $item['tanggal'] ?></span> <br>
                                                                    <span>Jam: <br> <?= $item['jamMulai'] . ' - ' . $item['jamAkhir'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <div class="col-md-12 text-center">
                                                        <h3>Lapangan belum ada yang terboking</h3>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                                        </div>
                                        <!-- end modal footer -->
                                    </div>
                                </div>
                            </div>
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
                "sProcessing":   "Sedang memproses...",
                "sLengthMenu":   "Tampilkan _MENU_ entri",
                "sZeroRecords":  "Tidak ditemukan data yang sesuai",
                "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix":  "",
                "sSearch":       "Cari:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Pertama",
                    "sPrevious": "Sebelumnya",
                    "sNext":     "Selanjutnya",
                    "sLast":     "Terakhir"
                }
            }
        });
    });
</script>

<?= view('layouts/alert') ?>
<?= $this->endSection('js') ?>