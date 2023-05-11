<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LapanganKu |
        <?= $title ?>
    </title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>/sb-admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>/sb-admin/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- datatable -->
    <link href="<?= base_url() ?>/assets/vendor/datatable/datatables.min.css">
    <link href="<?= base_url() ?>/assets/vendor/datatable/Bootstrap-4-4.6.0/css/bootstrap.min.css">

    <!-- sweetalert -->
    <link rel="stylesheet" href="<?= base_url('mazer/assets/vendors/sweetalert2/sweetalert2.min.css') ?>">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?= $this->include('layouts/admin/sidebar') ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?= $this->include('layouts/admin/navbar') ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?= $this->renderSection('content') ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?= $this->include('layouts/admin/footer') ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>/sb-admin/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>/sb-admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- datatable -->
    <script src="<?= base_url() ?>/assets/vendor/datatable/datatables.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/datatable/Bootstrap-4-4.6.0/js/bootstrap.min.js"></script>

    <!-- sweetallert -->
    <script src="<?= base_url('mazer/assets/vendors/sweetalert2/sweetalert2.all.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>/sb-admin/js/sb-admin-2.min.js"></script>

    <script>
        $("#btn-logout").click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan terlogout dari sistem ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('logout') ?>"
                }
            })
        });
    </script>

    <?= $this->renderSection('js') ?>

</body>

</html>