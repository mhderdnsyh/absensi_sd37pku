<div class="HalamanDataKehadiran">
<div class="container-fluid">
    <h1 class="my-4"><span class="fas fa-user-check mr-2"></span>Data Kehadiran</h1>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dashboard" id="listabsenku" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama GTK</th>
                            <th>Waktu Datang</th>
                            <th>Waktu Pulang</th>
                            <th>Status</th>
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

<!-- Modal View Absen -->
<div class="modal fade" id="viewabsensimodal" tabindex="-1" role="dialog" aria-labelledby="viewabsensimodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="viewabsensimodallabel"><span class="fas fa-clock mr-1"></span>Preview Absensi</h5>
            </div>
            <div class="modal-body">
                <div id="viewdataabsensi"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="fas fa-times mr-1"></span>Tutup</button>
            </div>
        </div>
    </div>
</div>