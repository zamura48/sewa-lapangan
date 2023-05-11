<?php if ($session = session('validation')) { ?>
    <?= dd($session) ?>
<?php } ?>

<form action="<?= base_url('admin/pelanggan/update/'. $data['pelanggan_id']) ?>" method="post">
<?= csrf_field() ?>
<button type="submit">Kirim</button>
</form>