<div class="HalamanDataGTK">
<div class="container-fluid">
    <h1 class="my-4"><span class="fas fa-user-tie mr-2"></span>Data GTK</h1>
    <div class="card mb-4">
        <div class="card-header">
            <div class="float-right">
                <button class="btn btn-success" data-toggle="modal" data-target="#addpegawaimodal" id="pgwadduser"><span class="fas fa-user-plus mr-1"></span>Tambah</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datapegawai" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama GTK</th>
                            <th>Kode GTK</th>
                            <th>Pas Foto</th>
                            <th>Username</th>
                            <th>NIP</th>                  
                            <th>Jenis Kelamin</th>
                            <th>Level</th>
                            <th>Shift Bagian</th>
                            <th>Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal Add GTK -->
<div class="modal fade" id="addpegawaimodal" tabindex="-1" role="dialog" aria-labelledby="addpegawaimodal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="addpegawaimodallabel"><span class="fas fa-user-plus mr-1"></span>Tambah GTK</h5>
            </div>
            <div class="modal-body">
                <?= form_open_multipart('#', ['id' => 'addpegawai']) ?>
                <div class="form-group row">
                    <label for="nama_pegawai" class="col-sm-4 col-form-label">Nama GTK</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username_pegawai" class="col-sm-4 col-form-label">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="username_pegawai" name="username_pegawai">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password_pegawai" class="col-sm-4 col-form-label">Password</label>
                    <div class="col-sm-8">
                        <div class="input-group" id="show_hide_password">
                            <input type="password" class="form-control" id="password_pegawai" name="password_pegawai">
                            <div class="input-group-append">
                                <button class="input-group-text" type="button" tabindex="-1"><span class="fas fa-eye-slash" aria-hidden="false"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jabatan_pegawai" class="col-sm-4 col-form-label">Jabatan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="jabatan_pegawai" name="jabatan_pegawai">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="instansi_pegawai" class="col-sm-4 col-form-label">Instansi</label>
                    <div class="col-sm-8">
                        <!-- <input type="text" class="form-control" id="instansi_pegawai" name="instansi_pegawai" value="<?= $nameinstansiset = (empty($dataapp['namaInstansi'])) ? '[Nama Instansi Belum Disetting]' : $dataapp['namaInstansi']; ?>" data-toggle="tooltip" data-placement="top" title="Untuk mengubah nama instansi ini silakan buka pada bagian setting aplikasi" readonly> -->
                        <input type="text" class="form-control" id="instansi_pegawai" name="instansi_pegawai" value="<?= $nameinstansiset = $dataapp['namaInstansi']; ?>" data-toggle="tooltip" data-placement="top" title="Untuk mengubah nama instansi ini silakan buka pada bagian setting aplikasi" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="npwp_pegawai" class="col-sm-4 col-form-label">NIP</label>     
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="npwp_pegawai" name="npwp_pegawai">
                            <div class="input-group-append">
                                <div class="input-group-text">Opsional</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="umur_pegawai" class="col-sm-4 col-form-label">Umur</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="umur_pegawai" name="umur_pegawai" maxlength="2">
                            <div class="input-group-append">
                                <div class="input-group-text">Tahun</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tempat_lahir_pegawai" class="col-sm-4 col-form-label">Tempat Lahir</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="tempat_lahir_pegawai" name="tempat_lahir_pegawai">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_lahir_pegawai" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="tgl_lahir_pegawai" name="tgl_lahir_pegawai">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="role_pegawai" class="col-sm-4 col-form-label">Role Akun</label>
                    <div class="col-sm-8">
                        <?= form_dropdown('role_pegawai', ['' => 'Select Role', 1 => 'Operator', 2 => 'Kepala Sekolah', 3 => 'GTK'], set_value('role_pegawai'), 'class="form-control" id="role_pegawai"'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jenis_kelamin_pegawai" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-8">
                        <div class="form-check form-check-inline">
                            <?= form_radio('jenis_kelamin_pegawai', 'Laki - Laki', set_radio('jenis_kelamin_pegawai[]', 'Laki - Laki'), "id='jenis_kelamin_pegawai' class='form-check-input'"); ?>
                            <label class="form-check-label" for="jenis_kelamin_pegawai1">Laki - Laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?= form_radio('jenis_kelamin_pegawai', 'Perempuan', set_radio('jenis_kelamin_pegawai[]', 'Perempuan'), "class='form-check-input'"); ?>
                            <label class="form-check-label" for="jenis_kelamin_pegawai2">Perempuan</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="shift_pegawai" class="col-sm-4 col-form-label">Shift Kerja</label>
                    <div class="col-sm-8">
                        <div class="form-check form-check-inline">
                            <?= form_radio('shift_pegawai', 1, set_radio('shift_pegawai[]', 1), "id='shift_pegawai' class='form-check-input'"); ?>
                            <label class="form-check-label" for="shift_pegawai1">Pagi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?= form_radio('shift_pegawai', 2, set_radio('shift_pegawai[]', 2), "class='form-check-input'"); ?>
                            <label class="form-check-label" for="shift_pegawai2">Siang</label>
                        </div>
                        <!-- <div class="form-check form-check-inline">
                            <?= form_radio('shift_pegawai', 3, set_radio('shift_pegawai[]', 3), "class='form-check-input'"); ?>
                            <label class="form-check-label" for="shift_pegawai3">Siang</label>
                        </div> -->
                    </div>
                </div>
                <div class="form-group row">
                    <label for="verifikasi_pegawai" class="col-sm-4 col-form-label">Verifikasi GTK</label>      <!--Verifikasi Pegawai-->
                    <div class="col-sm-8">
                        <div class="form-check form-check-inline">
                            <?= form_radio('verifikasi_pegawai', 0, set_radio('verifikasi_pegawai[]', 0), "id='verifikasi_pegawai' class='form-check-input'"); ?>
                            <label class="form-check-label" for="verifikasi_pegawai1">Belum Terverifikasi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?= form_radio('verifikasi_pegawai', 1, set_radio('verifikasi_pegawai[]', 1), "class='form-check-input'"); ?>
                            <label class="form-check-label" for="verifikasi_pegawai2">Terverifikasi</label>
                        </div>
                    </div>
                </div>
       
                <div class="form-group row">
                    <div class="col-sm-4">Pas Foto GTK</div>
                    <div class="col-sm-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="foto_pegawai" name="foto_pegawai">
                            <label class="custom-file-label" for="foto_pegawai">Choose file. Max 2 MB</label>
                        </div>
                    </div>
                </div>
                <div class="my-2" id="info-data"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fas fa-times mr-1"></span>Batal</button>
                <button type="submit" class="btn btn-primary" id="addpgw-btn"><span class="fas fa-plus mr-1"></span>Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View GTK -->
<div class="modal fade" id="viewpegawaimodal" tabindex="-1" role="dialog" aria-labelledby="viewpegawaimodal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="viewpegawaimodallabel"><span class="fas fa-user-tie mr-1"></span>Preview GTK</h5>
            </div>
            <div class="modal-body">
                <div id="viewdatapegawai"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="fas fa-times mr-1"></span>Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit GTK -->
<div class="modal fade" id="editpegawaimodal" tabindex="-1" role="dialog" aria-labelledby="editpegawaimodal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="editpegawaimodallabel"><span class="fas fa-user-edit mr-1"></span>Edit GTK</h5>
            </div>
            <div class="modal-body">
                <div id="editdatapegawai"></div>
            </div>
        </div>
    </div>
</div>