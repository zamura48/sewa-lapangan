<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">LapanganKu </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php if ($title == "Dashboard") { ?>
        active
    <?php } ?>">
        <a class="nav-link" href="<?= base_url(strtolower(session('role')) . '/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <?php if (session('role') == 'Admin') { ?>
        <!-- Nav Item - Pesanan -->
        <li class="nav-item <?php if ($title == "Pesanan") { ?>
            active
        <?php } ?>">
            <a class="nav-link" href="<?= base_url('admin/pesanan') ?>">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>Pesanan</span></a>
        </li>
    <?php } else { ?>
        <li class="nav-item <?php if ($title == "Administrator") { ?>
                active
            <?php } ?>">
            <a class="nav-link" href="<?= base_url('owner/administrator') ?>">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>Administrator</span></a>
        </li>
    <?php } ?>

    <!-- Nav Item - Pesanan -->
    <li class="nav-item <?php if ($title == "Lapangan") { ?>
        active
    <?php } ?>">
        <a class="nav-link" href="<?= base_url(strtolower(session('role')) . '/lapangan') ?>">
            <i class="fas fa-fw fa-square"></i>
            <span>Lapangan</span></a>
    </li>

    <!-- Nav Item - Pesanan -->
    <li class="nav-item <?php if ($title == "Pelanggan") { ?>
        active
    <?php } ?>">
        <a class="nav-link" href="<?= base_url(strtolower(session('role')) . '/pelanggan') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Pelanggan</span></a>
    </li>

    <!-- Nav Item - Pesanan -->
    <li class="nav-item <?php if ($title == "Laporan Pemesanan") { ?>
        active
    <?php } ?>">
        <a class="nav-link" href="<?= base_url(strtolower(session('role')) . '/laporan-pemesanan') ?>">
            <i class="fas fa-fw fa-file"></i>
            <span>Laporan Pemesanan</span></a>
    </li>

</ul>