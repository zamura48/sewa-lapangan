<!DOCTYPE html>
<html>

<body>
    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo getenv('midtrans.clientKey') ?>"></script>
    <script type="text/javascript">
        let redirect = "<?= base_url('pelanggan/history') ?>";
        // SnapToken acquired from previous step
        snap.pay('<?php echo $snap_token ?>', {
            // Optional
            onSuccess: function (result) {
                /* You may add your own js here, this is just example */
                alert("payment success!");
                console.log(result);
                window.location.href = redirect;
            },
            // Optional
            onPending: function (result) {
                /* You may add your own js here, this is just example */
                alert("wating your payment!");
                console.log(result);
                window.location.href = redirect;
            },
            // Optional
            onError: function (result) {
                /* You may add your own js here, this is just example */
                alert("payment failed!");
                console.log(result);
                window.location.href = redirect;
            },
            onClose: function () {
                // alert('you closed the popup without finishing the payment');
                window.location.href = redirect;
            }
        });
    </script>
</body>

</html>