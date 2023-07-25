<?= $this->extend('layouts/user/app') ?>

<?= $this->section('content') ?>
<div class="row mt-5">
    <div class="col-md-6 align-self-center text-center">
        <p class="fs-4"><b>KRAKATAU SPORT CENTER</b></p>
        <p>Tempat gelanggang olahraga badminton jombang.</p>
    </div>
    <div class="col-md-6">
        <img src="<?= ('mazer/assets/images/samples/2020-12-29.jpg') ?>" width="546" height="365" alt=""
            class="img-fluid rounded">
    </div>
</div>

<div class="row mt-5">
    <hr>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <p class="fs-4 fw-bold text-black m-0">
                    Lapangan yang sudah terbooking
                </p>
            </div>
            <div class="card-body">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Lapangan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($lapangan_booked)) {
                            foreach ($lapangan_booked as $item): ?>
                                <tr>
                                    <td>Lapangan
                                        <?= $item['nomor'] ?>
                                    </td>
                                    <td>
                                        <?= $item['tanggal'] ?>
                                    </td>
                                    <td>
                                        <?= $item['jamMulai'] . ' - ' . $item['jamAkhir'] ?>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } else { ?>
                        <tr>
                            <td colspan="3" class="text-center">Belum ada booking</td>
                            <td style="display:none"></td>
                            <td style="display:none"></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <hr>
    <center>
        <p class="fs-4"><b>ALAMAT</b></p>
    </center>
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.2924007139013!2d112.20632321437397!3d-7.543056776555412!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78410475661639%3A0x1a92963e7b3d7ea2!2sKrakatau%20Sport%20Centre!5e0!3m2!1sid!2sid!4v1679233072125!5m2!1sid!2sid"
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

<hr>
<figure class="text-center mt-3">
    <blockquote class="blockquote">
        <p>Solusi tempat berolahraga dengan nyaman dan kualitas terbaik</p>
    </blockquote>
</figure>

<?= $this->endSection('content') ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function () {
        $('.table').dataTable({
            searching: false,
            info: false,
            lengthChange: false,
            order: [[1, 'desc']]
        });
    });
</script>
<?= $this->endSection('js') ?>