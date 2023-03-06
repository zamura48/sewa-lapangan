<?php foreach ($datas as $data) { ?>
    <div style="margin-top: 3em;">
        <img src="<?= base_url('/uploads/image/lapangan/'.$data['gambar']) ?>" alt="" width="30%" height="30%">
        <br>
        <label for="">
            <?= $data['nomor'] ?>
        </label>
        <p>
            <?= $data['tanggal'] ?> /
            <?= $data['jam'] ?>
        </p>
        <h4>
            <?= $data['harga'] ?>
        </h4>
        <?php if ($data['status_booking'] !== '1') { ?>
            <h5>Booking Available</h5>
            <button>Booking</button>
        <?php } ?>
        <b></b>
    </div>
<?php } ?>