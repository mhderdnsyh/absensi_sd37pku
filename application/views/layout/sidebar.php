<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <!--Operator URL di routes.php -->
            <?php if ($this->session->userdata('roleId') == 1) : ?>
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Home</div>
                        <a class="nav-link" href="<?= base_url(''); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-tachometer-alt"></span></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="<?= base_url('tampilHalamanDataKehadiran'); ?>">               <!--ini perlu diganti jd tampilHalamanDataKehadiran ? -->
                            <div class="sb-nav-link-icon"><span class="fas fa-chart-area"></span></div>
                            Data Kehadiran
                        </a>
                        <div class="sb-sidenav-menu-heading">Operator</div>
                        <a class="nav-link" href="<?= base_url('tampilHalamanDataGTK'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-users"></span></div>
                            Data GTK
                        </a><a class="nav-link" href="<?= base_url('tampilHalamanAbsensiGTK'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-user-check"></span></div>
                            Absensi GTK
                        </a>
                        </a><a class="nav-link" href="<?= base_url('tampilHalamanPengaturanAplikasi'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-cog"></span></div>
                            Pengaturan Aplikasi
                        </a>
                    </div>
                </div>
                 <!--Kepala Sekolah URL di routes.php -->
            <?php elseif ($this->session->userdata('roleId') == 2) : ?>
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Home</div>
                        <a class="nav-link" href="<?= base_url(''); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-tachometer-alt"></span></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="<?= base_url('tampilHalamanDataKehadiran'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-chart-area"></span></div>
                            Data Kehadiran
                        </a>
                        <div class="sb-sidenav-menu-heading">Kepala Sekolah</div>
                        </a><a class="nav-link" href="<?= base_url('tampilHalamanAbsensiGTK'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-user-check"></span></div>
                            Absensi GTK
                        </a>
                    </div>
                </div>
                 <!--GTK URL di routes.php -->
            <?php elseif ($this->session->userdata('roleId') == 3) : ?>
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Home</div>
                        <a class="nav-link" href="<?= base_url(''); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-tachometer-alt"></span></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="<?= base_url('tampilHalamanDataKehadiran'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-chart-area"></span></div>
                            Data Kehadiran
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <div class="sb-sidenav-footer">
                <div class="small">Selamat Datang:</div>
                <?= $user['namaLengkap'] ?>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>