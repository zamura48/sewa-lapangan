<table>
    <thead>
        <tr></tr>
    </thead>
    <tbody>
        <?php foreach ($datas as $data) { ?>
            <tr>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['noHp'] ?></td>
                <td><?= $data['alamat'] ?></td>
                <td>
                    <a href="<?= base_url('admin/pelanggan/edit/'. $data['pelanggan_id']) ?>">Edit</a>
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>