<?= $this->extend('layouts/user/app') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-6">
        <div class="card animate__animated animate__fadeIn">
            <div class="card-body">
                <form action="<?= base_url('pelanggan/pesan-lapangan') ?>" method="post" id="form">
                    <div class="row">
                        <div class="form-group">
                            <label for="">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                value="<?= set_value('tanggal') ?>" required
                                oninvalid="this.setCustomValidity('Harap isi tanggal ini')"
                                oninput="setCustomValidity('')">
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Jam Mulai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="jamMulai"
                                    value="<?= set_value('jamMulai') ?>" required
                                    oninvalid="this.setCustomValidity('Harap isi jam mulai ini')"
                                    oninput="setCustomValidity('')">
                            </div>
                        </div>
                        <div class="col-md-2 align-self-center text-center">
                            <h3 class="mt-2">-</h3>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Jam Akhir <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="jamAkhir"
                                    value="<?= set_value('jamAkhir') ?>" required
                                    oninvalid="this.setCustomValidity('Harap isi jam akhir ini')"
                                    oninput="setCustomValidity('')">
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
                            <div class="row">
                                <div class="col-md-8">
                                    <form
                                        action="<?= base_url('pelanggan/pesan-lapangan/checkout/' . $data['lapangan_id'] . '/' . $tanggal . '/' . $jamMulai . '/' . $jamAkhir) ?>"
                                        method="post">
                                        <button class="btn btn-secondary">Pesan Sekarang</button>
                                    </form>
                                </div>
                                <div class="col-md-4 align-self-center">
                                    <form
                                        action="<?= base_url('pelanggan/booking/' . $data['lapangan_id'] . '/' . $tanggal . '/' . $jamMulai . '/' . $jamAkhir) ?>"
                                        method="post">
                                        <button class="btn btn-transparent">
                                            <span class="fs-4">
                                                <i class="bi bi-cart-plus"></i>
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
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
    $(function () {
        var dtToday = new Date();

        /**
         * get bulan kemudian tambah 1
         * kenapa di tambah satu karena ketika
         * mengambil nilai dari bulan dimulai dari 0 bukan 1
         */
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();
        var maxDate = year + '-' + month + '-' + day;
        document.getElementById("tanggal").setAttribute("min", maxDate);
    });

    // document.getElementById('form').addEventListener('submit', (e) => {
    //     e.preventDefault;

    // });

    function reset() {
        location.assign("<?= base_url('pelanggan/pesan-lapangan') ?>");
    }
</script>
<?= view('layouts/alert') ?>
<?= $this->endSection('js') ?>