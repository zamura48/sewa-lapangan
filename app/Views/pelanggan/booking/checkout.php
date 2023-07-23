<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LapanganKu
        <?= $title ?>
    </title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('mazer/assets/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('mazer/assets/vendors/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('mazer/assets/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('mazer/assets/vendors/sweetalert2/sweetalert2.min.css') ?>">
</head>

<body>
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="<?= base_url('pelanggan/keranjang') ?>"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-2" href="<?= base_url('pelanggan/keranjang') ?>">
                <span class="fw-bold">LapanganKu</span>
            </a>
        </div>
    </nav>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 align-self-end">
                                <form id="form">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-4 col-3">
                                            <label for="col-form-label">Sub Total</label>
                                        </div>
                                        <div class="col-lg-8 col-md-9">
                                            <span class="text-secondary" id="totalHarga">
                                                <?= $subTotal ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items center">
                                        <div class="col-lg-4 col-3">
                                            <label for="col-form-label">Metode Pembayaran <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-8 col-md-9">
                                            <select name="payment_method" id="payment_method" class="form-select"
                                                required>
                                                <option value="">-- Pilih Metode --</option>
                                                <option value="CASH">CASH</option>
                                                <option value="DP">DP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-4 col-3">
                                            <label for="col-form-label">Pembayaran <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-8 col-md-9">
                                            <input type="text" class="form-control" id="dp" name="dp" required>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-warning" id="btnBayar" disabled>Bayar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="<?= base_url('mazer/assets/vendors/jquery/jquery.min.js') ?>"></script>

    <script src="<?= base_url('mazer/assets/vendors/sweetalert2/sweetalert2.all.min.js') ?>"></script>
    <script src="<?= base_url('mazer/assets/js/extensions/sweetalert2.js') ?>"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?php echo getenv('midtrans.clientKey') ?>"></script>
    <script type="text/javascript">
        let redirect = "<?= base_url('pelanggan/histori') ?>";
        // SnapToken acquired from previous step

        let subTotal = <?= $subTotal ?>;
        let inputDP = document.getElementById('dp');
        inputDP.addEventListener('blur', () => {
            let minimalDP = subTotal * 0.5;
            if (inputDP.value < minimalDP) {
                Swal.fire({
                    'title': 'Peringtan',
                    'icon': 'warning',
                    'text': 'Minimal DP 50% dari sub total!'
                });
                $("#btnBayar").attr('disabled', true);
            } else if (inputDP.value > subTotal) {
                Swal.fire({
                    'title': 'Peringtan',
                    'icon': 'warning',
                    'text': 'Pembayaran lebih dari sub total!'
                });
                $("#btnBayar").attr('disabled', true);
            } else if (inputDP.value == subTotal) {
                $("#btnBayar").attr('disabled', false);
            } else {
                $("#btnBayar").attr('disabled', false);
            }
        });

        $('#payment_method').change(function (e) {
            e.preventDefault();
            let this_val = $(this).val();
            console.log(this_val);

            if (this_val == 'CASH') {
                inputDP.value = subTotal;
                $("#btnBayar").attr('disabled', false);
            } else {
                inputDP.value = '';
                $("#btnBayar").attr('disabled', true);
            }
        });

        $("#form").submit(function (e) {
            e.preventDefault();

            $("#btnBayar").attr('disabled', true).text('').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

            let cbCheckeds = [];
            let dp = $("#dp").val();
            let payment_method = $("#payment_method").val();

            <?php foreach ($checkedChecboxs as $value) { ?>
                cbCheckeds.push('<?= $value ?>');
            <?php } ?>

            $.ajax({
                type: "POST",
                url: "<?= base_url('pelanggan/keranjang/checkout/payment') ?>",
                data: {
                    'id': cbCheckeds,
                    'dp': dp,
                    'payment_method': payment_method,
                },
                dataType: "json",
                success: function (response) {
                    $("#btnBayar").attr('disabled', false).text('Bayar');
                    $(".spinner-border").remove();

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
                            cancelPayment(cbCheckeds);
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Pembayaran gagal!"
                            })
                        },
                        onClose: function () {
                            // alert('you closed the popup without finishing the payment');
                            cancelPayment(cbCheckeds);
                            Swal.fire({
                                icon: "warning",
                                title: "Peringatan",
                                text: "Anda menutup tampilan pembayaran tanpa menyelesaikan pembayaran!"
                            })
                            // window.location.href = redirect;
                        }
                    });
                },
                error: (response) => {
                    $("#btnBayar").attr('disabled', false).text('Bayar');
                    $(".spinner-border").remove();
                    
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response['error']
                    })
                }
            });
        });


        function cancelPayment(cbCheckeds) {
            $.ajax({
                type: "post",
                url: "<?= base_url('pelanggan/keranjang/checkout/payment/cancel') ?>",
                data: {
                    'checkedChecboxs': cbCheckeds,
                },
                dataType: "json",
                success: function (response) {

                }
            });
        }
    </script>
</body>

</html>