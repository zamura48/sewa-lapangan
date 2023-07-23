<?= $this->extend('layouts/user/app') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card animate__animated animate__fadeIn shadow">
            <div class="card-body">
                <form action="<?= base_url('pelanggan/keranjang/checkout') ?>" method="post">
                    <table class="table">
                        <thead class="text-center">
                            <tr>
                                <th>Kode Pembayaran</th>
                                <th>Lokasi</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Status Booking</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($datas as $data) { ?>
                                <tr>
                                    <td>
                                        <?= $data['kode_pembayaran'] ?>
                                    </td>
                                    <td>
                                        Lapangan
                                        <?= $data['nomor'] ?>
                                    </td>
                                    <td>
                                        <?= $data['tanggal'] ?>
                                    </td>
                                    <td>
                                        <?= $data['jam'] ?>
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
                                        <?php } elseif ($data['status_pembayaran'] == 'Gagal' || $data['status_pembayaran'] == 'Cancel') { ?>
                                            <span class="badge bg-danger text-white">
                                                <?= $data['status_pembayaran'] ?>
                                            </span>
                                        <?php } elseif ($data['status_pembayaran'] == 'DP Terbayar') { ?>
                                            <span class="badge bg-info text-white">
                                                <?= $data['status_pembayaran'] ?>
                                            </span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($data['status_pembayaran'] == 'Lunas' || $data['status_pembayaran'] == 'DP Terbayar') { ?>
                                            <a href="<?= base_url('pelanggan/invoice/' . $data['pembayaran_id']) ?>"
                                                class="btn btn-secondary btn-sm">Invoice</a>
                                        <?php } elseif ($data['status_pembayaran'] == 'Belum dibayar') { ?>
                                            <?php if ($data['status_booking'] != 'Batal') {  ?>
                                                <button class="btn btn-primary btn-sm btn_continue_payment"
                                                    data-kode_pembayaran="<?= $data['kode_pembayaran'] ?>">Pembayaran</button>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content') ?>

<?= $this->section('js') ?>
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?php echo getenv('midtrans.clientKey') ?>"></script>
<script>
    let redirect = '<?= base_url('pelanggan/histori') ?>';
    
    $(document).ready(function () {
        $('.table').dataTable({
            searching: false,
            info: false,
            lengthChange: false,
            order: [[2, 'desc']]
        });
    });

    $(".btn_continue_payment").click(function (e) {
        e.preventDefault();
        let this_data = $(this).data('kode_pembayaran');

        $.ajax({
            type: "get",
            url: "continue-payment/" + this_data,
            dataType: "json",
            success: function (response) {
                snap.pay(response['snap_token'], {
                    // Optional
                    onSuccess: function (result) {
                        /* You may add your own js here, this is just example */
                        Swal.fire({
                            title: 'Suksess',
                            text: "Berhasil melakukan pembayaran!",
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = redirect;
                            }
                        })
                    },
                    // Optional
                    onPending: function (result) {
                        /* You may add your own js here, this is just example */
                        Swal.fire({
                            title: 'Peringatan',
                            text: "Menunggu pembyaran dari anda!",
                            icon: 'warning',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = redirect;
                            }
                        })
                    },
                    // Optional
                    onError: function (result) {
                        /* You may add your own js here, this is just example */
                        cancelPayment(id_pembayaran, id_booking, id_jadwal, id_jam);
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Pembayaran gagal!"
                        })
                    },
                    onClose: function () {
                        // alert('you closed the popup without finishing the payment');
                        cancelPayment(id_pembayaran, id_booking, id_jadwal, id_jam);
                        Swal.fire({
                            icon: "warning",
                            title: "Peringatan",
                            text: "Anda menutup tampilan pembayaran tanpa menyelesaikan pembayaran!"
                        })
                        // window.location.href = redirect;
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection('js') ?>