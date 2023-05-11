<?= $this->extend('layouts/user/app') ?>

<?= $this->section('content') ?>
<div class="row mt-5">
    <div class="col-md-6 align-self-center text-center">
        <p class="fs-4"><b>KRAKATAU SPORT CENTER</b></p>
        <p>Tempat gelanggang olahraga badminton jombang.</p>
    </div>
    <div class="col-md-6">
        <img src="<?= ('mazer/assets/images/samples/2020-12-29.jpg') ?>" width="546" height="365" alt="" class="img-fluid rounded">
    </div>
</div>

<div class="row mt-5">
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