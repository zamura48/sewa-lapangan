<form action="<?= base_url('admin/lapangan/'); ?>" method="post" enctype="multipart/form-data">
    <input type="text" name="nomor">
    <input type="file" name="gambar" accept=".jpg,.png">
    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>thead</tr>
    </thead>
    <tbody>
        <?php foreach ($datas as $data) { ?>
            <tr>
                <td>
                    <?= $data['nomor'] ?>
                </td>
                <td>
                    <?= $data['gambar'] ?>
                </td>
                <td>
                    <?= $data['status'] ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>