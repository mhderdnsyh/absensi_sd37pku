<div class="container-fluid">
    <div class="mt-4 jumbotron jumbotron-fluid shadow-lg">
        <div class="container">
            <div class="text-center">
                <img src="<?= (empty($dataapp['logoInstansi'])) ? base_url('assets/img/logo_sd37.png') : (($dataapp['logoInstansi'] == 'default-logo.png') ? base_url('assets/img/logo_sd37.png') : base_url('storage/setting/' . $dataapp['logoInstansi'])); ?>" class="card-img" style="width:15%;">
                <h1 class="display-5">
                    <?= (empty($dataapp['namaInstansi'])) ? '[Nama Instansi Belum Disetting]' : $dataapp['namaInstansi']; ?>
                </h1>
                <h4>
                    <div class="d-inline"><?= $greeting ?></div>, <?= $user['namaLengkap'] ?>
                </h4>
                <p class="lead">
                    <marquee width="60%" direction="left"><?= (empty($dataapp['jumbotronLeadSet'])) ? '[Ubah Kalimat Pada Teks Ini Disetting Aplikasi]' : $dataapp['jumbotronLeadSet']; ?></marquee>
                </p>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xl-7">
            <div class="card mb-4">
                <div class="card-header text-center">
                    <span class="fas fa-user mr-1"></span>Identitas Diri
                </div>
                <div class="card-body">
                    <div class="row detail">
                        <div class="col-md-2 col-sm-4 col-6 p-2">
                            <img class="img-thumbnail" src="<?= ($user['image'] == 'default.png' ? base_url('assets/img/default-profile.png') : base_url('storage/profile/' . $user['image'])); ?>" class="card-img" style="width:100%;">
                        </div>
                        <div class="col-md-10 col-sm-8 col-6">
                            <dl class="row">
                                <dt class="col-sm-5">Nama Lengkap:</dt>
                                <dd class="col-sm-7"><?= $user['namaLengkap'] ?></dd>
                                <dt class="col-sm-5">Umur:</dt>
                                <dd class="col-sm-7"><?= $user['umur'] ?><div class="ml-1 d-inline">Tahun</div>
                                </dd>
                                <dt class="col-sm-5">Instansi:</dt>
                                <dd class="col-sm-7 text-truncate"><?= $user['instansi'] ?></dd>
                                <dt class="col-sm-5">Jabatan:</dt>
                                <dd class="col-sm-7"><?= $user['jabatan'] ?></dd>
                                <dt class="col-sm-5">NIP:</dt>
                                <dd class="col-sm-7"><?= $user['nipGtk'] ?></dd>
                                <dt class="col-sm-5">Tempat / Tanggal Lahir:</dt>
                                <dd class="col-sm-7"><?= $user['tempatLahir'] ?>,<?= $user['tglLahir'] ?></dd>
                                <dt class="col-sm-5">Jenis Kelamin:</dt>
                                <dd class="col-sm-7"><?= $user['jenisKelamin'] ?></dd>
                                <dt class="col-sm-5">Shift Bekerja:</dt>
                                <dd class="col-sm-7"><?= $shiftpegawai = ($user['bagianShift'] == 1) ? '<span class="badge badge-success">Full Time</span>' : (($user['bagianShift'] == 2) ? '<span class="badge badge-warning">Part Time</span>' : '<span class="badge badge-primary">Shift Time</span>'); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Kode Pegawai: <?= $user['kodeGtk'] ?></div>
                        <div class="text-muted">Akun Dibuat: <?= date('d F Y', $user['dateCreated']); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card mb-4">
                <div class="card-header text-center"><span class="fas fa-clock mr-1"></span>Absensi</div>
                <div class="card-body text-center">
                    <div id="infoabsensi"></div>
                    <?php if ($dataapp['mapsUse'] == 1) : ?>
                        <div id='maps-absen' style='width: 100%; height:250px;'></div>
                        <hr>
                    <?php endif; ?>
                    <div id="location-maps" style="display: none;"></div>
                    <div id="date-and-clock">
                        <h3 id="clocknow"></h3>
                        <h3 id="datenow"></h3>
                    </div>
                    <?= form_dropdown('ket_absen', ['Bekerja Di Kantor' => 'Bekerja Di Kantor', 'Bekerja Di Rumah / WFH' => 'Bekerja Di Rumah / WFH', 'Sakit' => 'Sakit', 'Cuti' => 'Cuti'], '', ['class' => 'form-control align-content-center my-2', 'id' => 'ket_absen']); ?>
                    <div class="mt-2">
                        <div id="func-absensi">
                            <p class="font-weight-bold">Status Kehadiran: <?= $statuspegawai = (empty($dbabsensi['statusGtk'])) ? '<span class="badge badge-primary">Belum Absen</span>' : (($dbabsensi['statusGtk'] == 1) ? '<span class="badge badge-success">Sudah Absen</span>' : '<span class="badge badge-danger">Absen Terlambat</span>'); ?></p>
                            <div id="jamabsen">
                                <p>Waktu Datang: <?= $jammasuk = (empty($dbabsensi['jamMasuk'])) ? '00:00:00' : $dbabsensi['jamMasuk']; ?></p>
                                <p>Waktu Pulang: <?= $jammasuk = (empty($dbabsensi['jamPulang'])) ? '00:00:00' : $dbabsensi['jamPulang']; ?></p>
                            </div>
                        </div>
                        <button class="btn btn-dark" id="btn-absensi">Absensi</button>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-muted">Absensi Datang Jam: <?= $dataapp['absenMulai'] ?></div>
                        <div class="text-muted">Absensi Pulang Jam: <?= $dataapp['absenPulang']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

