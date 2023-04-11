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
                                    <th><input type="checkbox" class="form-check-input" id="checkboxAll"></th>
                                    <th>Item</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($datas as $data) { ?>
                                    <tr id="keranjang">
                                        <td>
                                            <input type="checkbox" class="form-check-input" id="checkboxItem"
                                                name="checkboxItem[]" value="<?= $data['booking_id'] ?>">
                                        </td>
                                        <td>
                                            Lapangan <?= $data['nomor'] ?>
                                        </td>
                                        <td>
                                            <?= $data['tanggal'] ?>
                                        </td>
                                        <td>
                                            <?= $data['jamMulai'] ?> - <?= $data['jamAkhir'] ?>
                                        </td>
                                        <td id="harga<?= $data['booking_id'] ?>" class="harga">
                                            <?= $data['harga'] ?>
                                        </td>
                                        <td>
                                            <!-- <a href=""
                                                class="btn btn-danger">Hapus</a> -->
                                            <a class="btn btn-danger" onclick="alertDelete(<?= $data['booking_id']?>)">Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-md-6 align-self-end">
                            <div class="form-group row align-items-center">
                                <div class="col-lg-4 col-3">
                                    <label for="col-form-label">Sub Total</label>
                                </div>
                                <div class="col-lg-8 col-md-9">
                                    <span class="text-secondary" id="totalHarga">0</span>
                                </div>
                            </div>
                            <!-- <div class="form-group row align-items-center">
                                <div class="col-lg-4 col-3">
                                    <label for="col-form-label">Pembayaran DP <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-lg-8 col-md-9">
                                    <input type="text" class="form-control" name="dp">
                                </div>
                            </div> -->
                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-warning">Pembayaran</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content') ?>

<?= $this->section('js') ?>
<script>
    let parentCheckbox = document.getElementById('checkboxAll');
    let subTotal = 0;
    parentCheckbox.addEventListener('change', e => {
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
        if (e.target.checked == true) {
            document.querySelectorAll('.harga').forEach(harga => {
                harga.innerHTML;
                subTotal += parseInt(harga.innerHTML);
            });
            document.getElementById('totalHarga').innerHTML = subTotal;
        } else {
            subTotal = 0;
            document.getElementById('totalHarga').innerHTML = subTotal;
        }
    });

    document.querySelectorAll('tbody .form-check-input').forEach(checkbox => {
        checkbox.addEventListener('change', e => {
            let checkboxNoChecked = document.querySelectorAll('tbody .form-check-input').length;
            let checkboxChecked = document.querySelectorAll('tbody .form-check-input:checked').length;

            if (checkboxNoChecked == checkboxChecked) {
                parentCheckbox.indeterminate = false;
                parentCheckbox.checked = true;

                if (e.target.checked == true) {
                    subTotal = 0;
                    document.querySelectorAll('.harga').forEach(harga => {
                        harga.innerHTML;
                        subTotal += parseInt(harga.innerHTML);
                    });
                    document.getElementById('totalHarga').innerHTML = subTotal;
                } else {
                    subTotal = 0;
                    document.getElementById('totalHarga').innerHTML = subTotal;
                }
            }

            /**
             * jika checkbox di dalam tbody ada yang di centang 
             * maka checkbox di judul akan tercentang
             */
            if (checkboxNoChecked > checkboxChecked && checkboxChecked >= 1) {
                parentCheckbox.checked = true;

                document.querySelectorAll('.form-check-input:checked').forEach(cariCheckbox => {
                    let hargaItem = document.getElementById('harga' + cariCheckbox.value);
                    if (hargaItem) {
                        subTotal = 0;
                        subTotal += parseInt(hargaItem.innerHTML);
                        document.getElementById('totalHarga').innerHTML = subTotal;
                    }
                });
            }

            /**
             * jika checkbox di dalam tbody tidak ada yang di centang
             * maka checkbox di judul akan teruncen
             */
            if (checkboxChecked == 0) {
                parentCheckbox.indeterminate = false;
                parentCheckbox.checked = false;

                subTotal = 0;
                document.getElementById('totalHarga').innerHTML = subTotal;
            }
        });
    });

    function alertDelete(id) {
        Swal.fire({
            title: 'Kamu yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('pelanggan/keranjang/') ?>"+id+"/delete"
            }
        })
    }
</script>
<?= view('layouts/alert') ?>
<?= $this->endSection('js') ?>