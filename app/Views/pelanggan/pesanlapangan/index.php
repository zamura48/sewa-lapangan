<?= $this->extend('layouts/user/app') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-6">
        <div class="card animate__animated animate__fadeIn">
            <div class="card-body">
                <form action="<?= base_url('pelanggan/pesan-lapangan') ?>" method="post">
                    <div class="row">
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="<?= set_value('tanggal') ?>">
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Jam Mulai</label>
                                <input type="time" class="form-control" name="jamMulai" value="<?= set_value('jamMulai') ?>">
                            </div>
                        </div>
                        <div class="col-md-2 align-self-center text-center">
                            <h3 class="mt-2">-</h3>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Jam Akhir</label>
                                <input type="time" class="form-control" name="jamAkhir" value="<?= set_value('jamAkhir') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid gap-2 mt-2">
                                <a class="btn btn-warning" onclick="reset()">Reset</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid gap-2 mt-2">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (isset($datas)) { ?>
    <div class="row mt-5 animate__animated animate__fadeIn">
        <p class="text-center fs-4">-= Daftar Lapangan Yang Tersedia =- </p>
        <?php if ($datas) { ?>
            <?php foreach ($datas as $data) { ?>
                <div class="col-md-3 text-black">
                    <div class="card text-center">
                        <div class="card-header">
                            <p class="fs-5">Lapangan
                                <?= $data['nomor'] ?>
                            </p>
                        </div>
                        <div class="card-body">
                            <p>Rp. <span class="fs-4">
                                    <?= $data['harga'] ?>
                                </span> / jam</p>
                            <form action="<?= base_url('booking/' . $data['jadwal_id']) ?>" method="post">
                                <button class="btn btn-secondary">Pesan Sekarang</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="row col-md-12 text-center align-items-center">
                <p class="fs-3">Tidak ada lapangan yang tersedia.</p>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<?= $this->endSection('content') ?>

<?= $this->section('js') ?>
<script>
    function reset() {
        location.assign("<?= base_url('pelanggan/pesan-lapangan') ?>");
    }
</script>
<?= $this->endSection('js') ?>