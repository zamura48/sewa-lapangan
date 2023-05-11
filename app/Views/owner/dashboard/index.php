<?= $this->extend('layouts/admin/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card shadow mb-3 text-center bg-primary text-light">
        <div class="card-body">
            <h1><b>KRAKATAU SPORT CENTER</b></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3>Pendapatan Bulan Ini</h3>
                    <h2 class="mt-4 text-right mr-3"><b> <?= "Rp. " . number_format($pendapatan, 0, ".", ","); ?></b></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3>Lapangan</h3>
                    <h2 class="mt-4 text-right mr-3"><b><?= $total_lapangan; ?></b></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<?= view('layouts/alert') ?>
<?= $this->endSection('content') ?>