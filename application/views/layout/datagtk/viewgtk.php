<div class="row detail">
    <div class="col-md-2 col-sm-4 col-6 p-2">
        <img class="img-thumbnail" src="<?= ($datapegawai['image'] == 'default.png' ? base_url('assets/img/default-profile.png') : base_url('storage/profile/' . $datapegawai['image'])); ?>" class="card-img">
    </div>
    <div class="col-md-10 col-sm-8 col-6">
        <dl class="row">
            <dt class="col-sm-5">Nama Lengkap:</dt>
            <dd class="col-sm-7"><?= $datapegawai['namaLengkap'] ?></dd>
            <dt class="col-sm-5">Umur:</dt>
            <dd class="col-sm-7"><?= $datapegawai['umur'] ?><div class="ml-1 d-inline">Tahun</div>
            </dd>
            <dt class="col-sm-5">Instansi:</dt>
            <dd class="col-sm-7 text-truncate"><?= $datapegawai['instansi'] ?></dd>
            <dt class="col-sm-5">Jabatan:</dt>
            <dd class="col-sm-7"><?= $datapegawai['jabatan'] ?></dd>
            <dt class="col-sm-5">NIP:</dt>
            <dd class="col-sm-7"><?= $datapegawai['nipGtk'] ?></dd>
            <dt class="col-sm-5">Tempat / Tanggal Lahir:</dt>
            <dd class="col-sm-7"><?= $datapegawai['tempatLahir'] ?>,<?= $datapegawai['tglLahir'] ?></dd>
            <dt class="col-sm-5">Jenis Kelamin:</dt>
            <dd class="col-sm-7"><?= $datapegawai['jenisKelamin'] ?></dd>
            <dt class="col-sm-5">Shift Bekerja:</dt>
            <dd class="col-sm-7"><?= $shiftpegawai = ($datapegawai['bagianShift'] == 1) ? '<span class="badge badge-success">Pagi</span>' : (($datapegawai['bagianShift'] == 2) ? '<span class="badge badge-warning">Siang</span>' : '<span class="badge badge-primary">Full Time</span>'); ?></dd>
        </dl>
    </div>
</div>
