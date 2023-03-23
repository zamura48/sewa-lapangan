<?= $this->extend('layouts/user/app') ?>
<?= $this->section('content') ?>
<div class="row mt-5">
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
        <div class="col-md-12 text-center align-items-center">
            <p class="fs-3">Tidak ada lapangan yang tersedia.</p>
        </div>
    <?php } ?>
</div>
<?= $this->endSection('content') ?>