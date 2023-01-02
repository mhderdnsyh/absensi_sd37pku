<div class="HalamanPengaturanAplikasi">
<div class="container-fluid">
    <h1 class="my-4"><span class="fas fa-tools mr-2"></span>Pengaturan Aplikasi</h1>
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="card mb-4">
                <!-- <div class="card-header">
                    <div class="float-right">
                        <?php if (empty($dataapp['statusSetting'])) : ?>
                            <button id="awalPengaturanAplikasi" class="btn btn-primary"><span class="fas fa-wrench mr-1"></span>Initialisasi Pengaturan Aplikasi</button>
                        <?php elseif (!empty($dataapp['statusSetting'])) : ?>
                            <button class="btn btn-success" disabled><span class="fas fa-wrench mr-1"></span>Telah Di Initialisasi</button>
                        <?php endif; ?>
                        <?php if (empty($dataapp['statusSetting'])) : ?>
                            <button class="btn btn-danger" disabled><span class="fas fa-undo-alt mr-1"></span>Reset Pengaturan Aplikasi</button>
                        <?php elseif (!empty($dataapp['statusSetting'])) : ?>
                            <button id="resetsettingapp" class="btn btn-danger"><span class="fas fa-undo-alt mr-1"></span>Reset Pengaturan Aplikasi</button>
                        <?php endif; ?>
                    </div>
                </div> -->
                <!-- <?php if (empty($dataapp['statusSetting'])) : ?>
                    <div class="card-body text-center">
                        <h3 class="mb-4"><span class="fas fa-fw fa-exclamation-triangle mr-1"></span>Fitur Pengaturan Belum Ada</h3>
                        Silakan Klik Tombol <div class="d-inline font-weight-bold">[Initialisasi Pengaturan Aplikasi]</div> Untuk Menginstal Fitur Pengaturan Aplikasi
                    </div>
                <?php else : ?> -->
                    <div class="card-body">
                        <?= form_open_multipart('#', ['id' => 'settingapp']) ?>   
                        <div class="form-group row">
                            <label for="nama_instansi" class="col-sm-4 col-form-label">Nama Instansi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" value="<?= $nameinstansiset = (empty($dataapp['namaInstansi'])) ? '[Nama Instansi Belum Di Atur]' : $dataapp['namaInstansi']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pesan_jumbotron" class="col-sm-4 col-form-label">Pesan Halaman Depan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pesan_jumbotron" name="pesan_jumbotron" value="<?= $jumbotronset = (empty($dataapp['jumbotronLeadSet'])) ? '[Ubah Kalimat Pada Teks Ini Di Pengaturan Aplikasi]' : $dataapp['jumbotronLeadSet']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_app_absen" class="col-sm-4 col-form-label">Nama Aplikasi Absensi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_app_absen" name="nama_app_absen" value="<?= $nameapp = (empty($dataapp['namaAppAbsensi'])) ? 'Absensi SDN 37 Kota Pekanbaru' : $dataapp['namaAppAbsensi']; ?>">           <!-- ini perlu pake camel case? -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="timezone_absen" class="col-sm-4 col-form-label">Zona Waktu Absensi</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="timezone_absen" name="timezone_absen" value="<?= $nameapp = (empty($dataapp['timezone'])) ? 'Asia/Jakarta' : $dataapp['timezone']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="absen_mulai" class="col-sm-4 col-form-label">Absensi Dimulai Jam</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="absen_mulai" name="absen_mulai" value="<?= $nameapp = (empty($dataapp['absenMulai'])) ? '06:00:00' : $dataapp['absenMulai']; ?>">
                                    <div class="input-group-append">
                                        <button class="input-group-text" type="button" id="setTimebtn" tabindex="-1">Set Current Time</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="absen_sampai" class="col-sm-4 col-form-label">Batas Absensi Masuk</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="absen_sampai" name="absen_sampai" value="<?= $nameapp = (empty($dataapp['absenMulaiTo'])) ? '11:00:00' : $dataapp['absenMulaiTo']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="absen_pulang_sampai" class="col-sm-4 col-form-label">Absensi Pulang</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="absen_pulang_sampai" name="absen_pulang_sampai" value="<?= $nameapp = (empty($dataapp['absenPulang'])) ? '16:00:00' : $dataapp['absenPulang']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lokasi_absensi" class="col-sm-4 col-form-label">Absensi Dengan Lokasi</label>
                            <div class="col-sm-8">
                                <div class="custom-control custom-checkbox"><?= form_checkbox('lokasi_absensi', 1, ($dataapp['mapsUse'] == 1) ? true : false, 'id="lokasi_absensi" class="custom-control-input"'); ?><label class="custom-control-label" for="lokasi_absensi">Menggunakan Maps</label></div>
                                <div class="small">(Fitur lokasi ini perlu akses jaringan internet)</div>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <div class="col-sm-2">Logo Instansi</div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="<?= (empty($dataapp['logoInstansi'])) ? base_url('assets/img/logo_sd37.png') : (($dataapp['logoInstansi'] == 'default-logo.png') ? base_url('assets/img/logo_sd37.png') : base_url('storage/setting/' . $dataapp['logoInstansi'])); ?>" class="img-thumbnail">
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="logo_instansi" name="logo_instansi">
                                            <label class="custom-file-label" for="logo_instansi">Choose file. Max 2 MB</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary" id="settingapp-btn"><span class="fas fa-pen mr-1"></span>Atur</button>
                            </div>
                        </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>