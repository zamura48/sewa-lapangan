<script>
    <?php if (session()->has('success')) { ?>
        Swal.fire({
            icon: "success",
            title: "Sukses",
            text: "<?= session('success') ?>"
        })
    <?php } ?>

    <?php if (session()->has('errors')) { ?>
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "<?= session('errors') ?>"
        })
    <?php } ?>

    <?php if (session()->has('validation')) { ?>
        Swal.fire({
            icon: "error",
            title: "Error",
        })
    <?php } ?>
</script>