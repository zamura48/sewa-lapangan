<form action="<?= base_url('admin/jadwal') ?>" method="post">
    <?= csrf_field() ?>
    <select name="id_lapangan" id="">
        <?php foreach ($dataLapangans as $lapangan) { ?>
            <option value="<?= $lapangan['lapangan_id'] ?>"><?= $lapangan['nomor'] ?></option>
        <?php } ?>
    </select>
    <input type="date" name="tanggal">
    <input type="text" name="harga">
    <input type="time" name="id_jam">
    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <th>thead</th>
    </thead>
    <tbody>
        <?php foreach ($datas as $data) { ?>
            <tr>
                <td><?= $data['tanggal'] ?></td>
                <td><?= $data['harga'] ?></td>
                <td><?= $data['status_booking'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>