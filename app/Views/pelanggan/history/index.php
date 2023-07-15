<?= $this->extend('layouts/user/app') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card animate__animated animate__fadeIn shadow">
            <div class="card-body">
                <form action="<?= base_url('pelanggan/keranjang/checkout') ?>" method="post">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kode Pembayaran</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal</th>
                                    <th>Status Booking</th>
                                    <th>Status Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($datas as $data) { ?>
                                    <tr>
                                        <td>
                                            <?= $data['kode_pembayaran'] ?>
                                        </td>
                                        <td>
                                            Lapangan <?= $data['nomor'] ?>
                                        </td>
                                        <td>
                                            <?= $data['tanggal'] ?>
                                        </td>
                                        <td>
                                            <?php if ($data['status_booking'] == 'Selesai') { ?>
                                                <span class="badge bg-success text-white">
                                                    <?= $data['status_booking'] ?>
                                                </span>
                                            <?php } elseif ($data['status_booking'] == 'Terboking') { ?>
                                                <span class="badge bg-warning text-white">
                                                    <?= $data['status_booking'] ?>
                                                </span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger text-white">
                                                    <?= $data['status_booking'] ?>
                                                </span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($data['status_pembayaran'] == 'Lunas') { ?>
                                                <span class="badge bg-success text-white">
                                                    <?= $data['status_pembayaran'] ?>
                                                </span>
                                            <?php } elseif ($data['status_pembayaran'] == 'Belum dibayar') { ?>
                                                <span class="badge bg-warning text-white">
                                                    <?= $data['status_pembayaran'] ?>
                                                </span>
                                            <?php } elseif ($data['status_pembayaran'] == 'Gagal') { ?>
                                                <span class="badge bg-danger text-white">
                                                    <?= $data['status_pembayaran'] ?>
                                                </span>
                                            <?php } elseif ($data['status_pembayaran'] == 'DP') { ?>
                                                <span class="badge bg-info text-white">
                                                    <?= $data['status_pembayaran'] ?>
                                                </span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content') ?>