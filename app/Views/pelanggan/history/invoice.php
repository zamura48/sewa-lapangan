<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LapanganKu | Invoice
    </title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('mazer/assets/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('mazer/assets/vendors/toastify/toastify.css') ?>">
    <link rel="stylesheet" href="<?= base_url('mazer/assets/vendors/sweetalert2/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('mazer/assets/vendors/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('mazer/assets/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('customcss.css') ?>">
    <link rel="stylesheet" href="<?= base_url('mazer/assets/vendors/fontawesome/all.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<style>
    /* Sembunyikan header dan footer saat mencetak pada browser Chrome */
    @media print {
        body * {
            visibility: hidden;
        }

        #areaPrint,
        #areaPrint * {
            visibility: visible;
        }

        #areaPrint {
            box-shadow: none !important;
            position: absolute;
            width: 90%;
        }

        @page {
            margin-top: 0;
            margin-bottom: 0;
        }

        /* Selain itu, Anda juga bisa menyembunyikan elemen header dan footer jika ada */
        header,
        footer {
            display: none;
        }
    }
</style>

<body>
    <main class="container-fluid p-5">
        <div class="d-flex justify-content-between mb-3">
            <a href="<?= base_url('pelanggan/histori') ?>" class="btn btn-primary"><i class="bi bi-arrow-left"></i>
                Kembali</a>
            <button class="btn btn-secondary" onclick="window.print()"><i class="bi bi-printer"></i> Cetak</button>
        </div>
        <?php
        $bulan = [
            "01" => "Januari",
            "02" => "Februari",
            "03" => "Maret",
            "04" => "April",
            "05" => "Mei",
            "06" => "Juni",
            "07" => "Juli",
            "08" => "Agustus",
            "09" => "September",
            "10" => "Oktober",
            "11" => "November",
            "12" => "Desember" 
        ];
          
        $explode = explode('-', $datas[1][0]['tanggal']);
        $tanggal = $explode[2] . ' - ' . $bulan[$explode[1]] . ' - ' . $explode[0];
        ?>
        <div class="card shadow" id="areaPrint">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between">
                    <p class="fs-1 fw-bold text-primary">LapanganKu</p>
                    <p class="fs-4 text-end">
                        Invoice <br>
                        <span class="fw-bold">
                            <?= $datas[1][0]['nama'] ?> <br>
                        </span>
                        <span class="fs-5">
                            <?= $datas[1][0]['kode_pembayaran'] ?> <br>
                        </span>
                        <span class="fs-6 mt-0">
                            <?= $tanggal ?>
                        </span>
                    </p>
                </div>
            </div>
            <div class="card-body mt-3">
                <?php
                $subtotal = 0;
                foreach ($datas[0] as $data): ?>
                    <div class="d-flex justify-content-between">
                        <p class="fs-4">Lapangan
                            <?= $data['nomor'] ?>
                        </p>
                        <p class="fs-4">Rp.
                            <?= number_format($data['harga'], 0, ',', '.') ?>
                        </p>
                    </div>
                    <?php $subtotal += $data['harga'] ?>
                <?php endforeach ?>

            </div>
            <div class="card-footer border-top">
                <div class="d-grid justify-content-end ">
                    <p class="fs-5">
                        Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Rp.
                        <?= number_format($subtotal, 0, ',', '.') ?>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>

<!-- <script>
    function printDiv() {
        var printContents = document.getElementById('areaPrint').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script> -->

<script src="<?= base_url('mazer/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('mazer/assets/js/bootstrap.bundle.min.js') ?>"></script>

<script src="<?= base_url('mazer/assets/vendors/toastify/toastify.js') ?>"></script>
<script src="<?= base_url('mazer/assets/js/extensions/toastify.js') ?>"></script>

<script src="<?= base_url('mazer/assets/vendors/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('mazer/assets/vendors/sweetalert2/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('mazer/assets/js/extensions/sweetalert2.js') ?>"></script>

<script src="<?= base_url('mazer/assets/js/main.js') ?>"></script>
<?= $this->renderSection('js') ?>

</html>