<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sistem extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $this->get_today_date = $hari[(int)date("w")] . ', ' . date("j ") . $bulan[(int)date('m')] . date(" Y");
        $this->load->model('Absensi');
        $this->load->model('Pengaturan');
        $this->load->model('Pengguna');
        $this->get_datasess = $this->db->get_where('pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->appsetting = $this->db->get_where('pengaturan', ['statusSetting' => 1])->row_array();
        $timezone_all = $this->appsetting;
        date_default_timezone_set($timezone_all['timezone']);
    }

    //Fitur Ajax Tombol Absensi
    public function absensi()
    {
        $clocknow = date("H:i:s");
        $today = $this->get_today_date;
        $appsettings = $this->appsetting;
        $is_pulang = $this->db->get_where('absensi', ['tglAbsen' => $today, 'kodeGtk' => $this->get_datasess['kodeGtk']])->row_array();
        if (strtotime($clocknow) <= strtotime($appsettings['absenMulai'])) {
            $reponse = [
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash(),
                'success' => false,
                'msgabsen' => '<div class="alert alert-danger text-center" role="alert">Belum Waktunya Absensi Datang</div>'
            ];
        } elseif (strtotime($clocknow) >= strtotime($appsettings['absenMulaiTo']) && strtotime($clocknow) <= strtotime($appsettings['absenPulang']) && $this->db->get_where('absensi', ['tglAbsen' => $today, 'kodeGtk' => $this->get_datasess['kodeGtk']])->row_array()) {
            $reponse = [
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash(),
                'success' => false,
                'msgabsen' => '<div class="alert alert-danger text-center" role="alert">Belum Waktunya Absensi Pulang</div>'
            ];
        } elseif (strtotime($clocknow) >= strtotime($appsettings['absenMulaiTo']) && strtotime($clocknow) >= strtotime($appsettings['absenPulang']) && !empty($is_pulang['jamPulang'])) {
            $reponse = [
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash(),
                'success' => false,
                'msgabsen' => '<div class="alert alert-danger text-center" role="alert">Anda Sudah Absensi Pulang</div>'
            ];
        } else {
            $this->Absensi->absensi();                
            $reponse = [
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash(),
                'success' => true
            ];
        }
        echo json_encode($reponse);
    }

    //Fitur Ajax Logout
    public function logoutAjax()
    {
        $reponse = [
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash(),
        ];
        $this->Pengguna->lakukanLogout();
        echo json_encode($reponse);
    }


    //Fitur CRUD Data Pegawai/GTK
    public function fiturCrudDataGtk()   
    {
        $typesend = $this->input->get('type');
        $reponse = [
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        ];
        
        if ($typesend == 'addpgw') {
            $reponse = [
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash(),
                'success' => False,
                'messages' => []
            ];
            $validation = [
                [
                    'field' => 'nama_pegawai',
                    'label' => 'Nama GTK',         
                    'rules' => 'trim|required|xss_clean',
                    'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
                ],
                [
                    'field' => 'username_pegawai',
                    'label' => 'Username',         
                    'rules' => 'trim|required|xss_clean|is_unique[pengguna.username]',  
                    'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.', 'is_unique' => 'Username ini telah terdaftar didatabase!']
                ],
                [
                    'field' => 'password_pegawai',
                    'label' => 'Password',          
                    'rules' => 'trim|required|xss_clean|min_length[8]',
                    'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.', 'max_length' => 'Password terlalu pendek, Minimal 8 Karakter!']
                ],
                [
                    'field' => 'jabatan_pegawai',
                    'label' => 'Jabatan',
                    'rules' => 'trim|required|xss_clean',
                    'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
                ],
                [
                    'field' => 'npwp_pegawai',
                    'label' => 'NIP',                      
                    'rules' => 'trim|xss_clean|numeric',
                    'errors' => ['xss_clean' => 'Please check your form on %s.', 'numeric' => 'Karakter harus angka tidak boleh huruf pada %s.']
                ],
                [
                    'field' => 'umur_pegawai',
                    'label' => 'Umur GTK',                
                    'rules' => 'required|xss_clean|max_length[2]|numeric',
                    'errors' => [
                        'required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.', 'numeric' => 'Karakter harus angka tidak boleh huruf pada %s.', 'max_length' => 'Angka umur terlalu panjang, Max Karakter 2!'
                    ]
                ],
                [
                    'field' => 'tempat_lahir_pegawai',
                    'label' => 'Tempat Lahir',
                    'rules' => 'required|xss_clean',
                    'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
                ],
                [
                    'field' => 'role_pegawai',
                    'label' => 'Role Akun',         
                    'rules' => 'required|xss_clean',
                    'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
                ],
                [
                    'field' => 'tgl_lahir_pegawai',
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required|xss_clean',
                    'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
                ],
                [
                    'field' => 'jenis_kelamin_pegawai',
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required|xss_clean|in_list[Laki - Laki,Perempuan]',
                    'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
                ],
                [
                    'field' => 'shift_pegawai',
                    'label' => 'Bagian Shift',
                    'rules' => 'required|xss_clean|in_list[1,2,3]',
                    'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
                ],
                [
                    'field' => 'verifikasi_pegawai',
                    'label' => 'Verifikasi GTK',
                    'rules' => 'required|xss_clean|in_list[0,1]',
                    'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
                ],
            ];
            $this->form_validation->set_rules($validation);
            if ($this->form_validation->run() == FALSE) {
                $reponse['messages'] = '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
            } else {
                $this->Pengguna->crudGtk($typesend);
                $reponse = [
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash(),
                    'success' => true
                ];
            }
        } elseif ($typesend == 'delpgw') {
            $check_admin = $this->db->get_where('pengguna', ['roleId' => 1]);
            $reponse = [
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash(),
                'message' => [],
                'success' => false
            ];
            if ($this->get_datasess['roleId'] != 1 || $check_admin->num_rows() < 1) {
                $reponse['message'] = 'Hanya Operator yang boleh menghapus pengguna!';
            } else {
                $reponse = [
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash(),
                    'message' => 'Anda telah menghapus pengguna!',
                    'success' => true
                ];
                $this->Pengguna->crudGtk($typesend);
            }
        } elseif ($typesend == 'actpgw') {
            if ($this->db->get_where('pengguna', ['idGtk' => $this->input->post('pgw_id'), 'isActive' => 1])->row_array()) {
                $reponse = [
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash(),
                    'success' => false
                ];
            } else {
                $reponse = [
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash(),
                    'success' => true
                ];
                $this->Pengguna->crudGtk($typesend);
            }
        } elseif ($typesend == 'viewpgw') {
            $data['datapegawai'] =  $this->db->get_where('pengguna', ['idGtk' => $this->input->post('pgw_id')])->row_array();
            $html = $this->load->view('layout/datagtk/viewgtk', $data);
            $reponse = [
                'html' => $html,
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash(),
                'success' => true
            ];
        } elseif ($typesend == 'edtpgw') {
            $data['dataapp'] = $this->appsetting;
            $data['datapegawai'] =  $this->db->get_where('pengguna', ['idGtk' => $this->input->post('pgw_id')])->row_array();
            $html = $this->load->view('layout/datagtk/editgtk', $data);
            $reponse = [
                'html' => $html,
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            ];
        }
        echo json_encode($reponse);
    }


    public function editpgwbc()
    {
        $typesend = $this->input->get('type');
        $reponse = [
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash(),
            'success' => False,
            'messages' => []
        ];

        $oldusername = $this->db->get_where('pengguna', ['idGtk' => htmlspecialchars($this->input->post('id_pegawai_edit', true))])->row_array();

        if ($oldusername['username'] == htmlspecialchars($this->input->post('username_pegawai_edit'))) {
            $rule_username = 'trim|required|xss_clean';
        } else {
            $rule_username = 'trim|required|xss_clean|is_unique[pengguna.username]';            
        }

        $validation = [
            [
                'field' => 'nama_pegawai_edit',
                'label' => 'Nama GTK',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'username_pegawai_edit',
                'label' => 'Username',
                'rules' => $rule_username,
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.', 'is_unique' => 'Username ini telah terdaftar didatabase!']
            ],
            [
                'field' => 'password_pegawai_edit',
                'label' => 'Password',
                'rules' => 'trim|xss_clean|min_length[8]',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.', 'max_length' => 'Password terlalu pendek, Minimal 8 Karakter!']
            ],
            [
                'field' => 'jabatan_pegawai_edit',
                'label' => 'Jabatan',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'npwp_pegawai_edit',
                'label' => 'NIP',
                'rules' => 'trim|xss_clean|numeric',
                'errors' => ['xss_clean' => 'Please check your form on %s.', 'numeric' => 'Karakter harus angka tidak boleh huruf pada %s.']
            ],
            [
                'field' => 'umur_pegawai_edit',
                'label' => 'Umur',
                'rules' => 'required|xss_clean|max_length[2]|numeric',
                'errors' => [
                    'required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.', 'numeric' => 'Karakter harus angka tidak boleh huruf pada %s.', 'max_length' => 'Angka umur terlalu panjang, Max Karakter 2!'
                ]
            ],
            [
                'field' => 'tempat_lahir_pegawai_edit',
                'label' => 'Tempat Lahir',
                'rules' => 'required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'role_pegawai_edit',
                'label' => 'Role Akun',
                'rules' => 'required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'tgl_lahir_pegawai_edit',
                'label' => 'Tanggal Lahir',
                'rules' => 'required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'jenis_kelamin_pegawai_edit',
                'label' => 'Jenis Kelamin',
                'rules' => 'required|xss_clean|in_list[Laki - Laki,Perempuan]',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'shift_pegawai_edit',
                'label' => 'Bagian Shift',
                'rules' => 'required|xss_clean|in_list[1,2,3]',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'verifikasi_pegawai_edit',
                'label' => 'Verifikasi GTK',
                'rules' => 'required|xss_clean|in_list[0,1]',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
        ];
        $this->form_validation->set_rules($validation);
        if ($this->form_validation->run() == FALSE) {
            $reponse['messages'] = '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
        } else {
            $this->Pengguna->crudGtk($typesend);
            $reponse = [
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash(),
                'success' => true
            ];
        }
        echo json_encode($reponse);
    }

    //Fitur Ajax Tabel Absensi
    function muatDataTabel()
    { //data absen menggunakan JSON object
        $dataabsen = $this->input->get('type');
        $datapegawai = $this->get_datasess;
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $nowday = $hari[(int)date("w")] . ', ' . date("j ") . $bulan[(int)date('m')] . date(" Y");
        $data = [];
        $no = 1;
        if ($dataabsen == 'fiturCrudDataGtk') {
            $check_admin = $this->db->get_where('pengguna', ['roleId' => 1]);
            $query = $this->db->get("pengguna");
            foreach ($query->result() as $r) {
                $data[] = [
                    $no++,
                    $r->namaLengkap,
                    $r->kodeGtk,
                    '<img class="img-thumbnail" src="' . ($r->image == 'default.png' ? base_url('assets/img/default-profile.png') : base_url('storage/profile/' . $r->image)) . '" class="card-img" style="width: 100%;">',
                    $r->username,
                    $r->nipGtk,         
                    $r->jenisKelamin,
                    ($r->roleId == 1) ? '<span class="badge badge-danger ml-1">Operator</span>' : (($r->roleId == 2) ? '<span class="badge badge-primary ml-1">Kepala Sekolah</span>' : (($r->roleId == 3) ? '<span class="badge badge-success ml-1">GTK</span>' : '<span class="badge badge-secondary ml-1">Tidak Ada Role</span>')),
                    ($r->bagianShift == 1) ? '<span class="badge badge-success ml-1">Pagi</span>' : (($r->bagianShift == 2) ? '<span class="badge badge-warning">Siang</span>' : '<span class="badge badge-primary">Full Time</span>'),
                    ($r->isActive == 1) ? '<span class="badge badge-success ml-1">Terverifikasi</span>' : '<span class="badge badge-danger ml-1">Belum Terverifikasi</span>',
                    (($query->num_rows() > 1 && $r->roleId != 1) || $check_admin->num_rows() > 1) ?
                        '<div class="btn-group btn-small " style="text-align: right;">
                        <button id="detailpegawai" class="btn btn-primary view-pegawai" data-pegawai-id="' . $r->idGtk . '" title="Lihat Pegawai"><span class="fas fa-fw fa-address-card"></span></button>
                        <button class="btn btn-danger delete-pegawai" title="Hapus Pegawai" data-pegawai-id="' . $r->idGtk . '"><span class="fas fa-trash"></span></button>
                        <button class="btn btn-warning edit-pegawai" title="Edit Pegawai" data-pegawai-id="' . $r->idGtk . '"><span class="fas fa-user-edit"></span></button>
                    </div>' : '<div class="btn-group btn-small " style="text-align: right;">
                        <button id="detailpegawai" class="btn btn-primary view-pegawai" data-pegawai-id="' . $r->idGtk . '" title="Lihat Pegawai"><span class="fas fa-fw fa-address-card"></span></button>
                        <button class="btn btn-warning edit-pegawai" title="Edit Pegawai" data-pegawai-id="' . $r->idGtk . '"><span class="fas fa-user-edit"></span></button>
                    </div>'
                ];
            }
            $result = array(
                "draw" => $draw,
                "recordsTotal" => $query->num_rows(),
                "recordsFiltered" => $query->num_rows(),
                "data" => $data
            );
        } elseif ($dataabsen == 'all') {
            if ($this->session->userdata('roleId') == 1) {
                $query = $this->db->get("absensi");
                foreach ($query->result() as $r) {
                    $data[] = [
                        $no++,
                        $r->tglAbsen,
                        $r->namaGtk,
                        $r->jamMasuk,
                        $r->jamPulang,
                        (empty($r->statusGtk)) ? '<span class="badge badge-primary">Belum Absensi</span>' : (($r->statusGtk == 1) ? '<span class="badge badge-success">Sudah Absensi</span>' : '<span class="badge badge-danger">Absensi Terlambat</span>'),
                        '<div class="btn-group btn-small " style="text-align: right;">
                    <button class="btn btn-primary detail-absen" data-absen-id="' . $r->idAbsen . '" title="Lihat Absensi"><span class="fas fa-fw fa-address-card"></span></button>
                    </div>'
                    ];
                }
            } elseif ($this->session->userdata('roleId') == 2) {
                $query = $this->db->get("absensi");
                foreach ($query->result() as $r) {
                    $data[] = [
                        $no++,
                        $r->tglAbsen,
                        $r->namaGtk,
                        $r->jamMasuk,
                        $r->jamPulang,
                        (empty($r->statusGtk)) ? '<span class="badge badge-primary">Belum Absensi</span>' : (($r->statusGtk == 1) ? '<span class="badge badge-success">Sudah Absensi</span>' : '<span class="badge badge-danger">Absensi Terlambat</span>'),
                        '<div class="btn-group btn-small " style="text-align: right;">
                    <button class="btn btn-primary detail-absen" data-absen-id="' . $r->idAbsen . '" title="Lihat Absensi"><span class="fas fa-fw fa-address-card"></span></button>
                    </div>'
                    ];
                }
            }
        } elseif ($dataabsen == 'allself') {
            $query = $this->db->get_where("absensi", ['kodeGtk' => $datapegawai['kodeGtk']]);
            foreach ($query->result() as $r) {
                $data[] = [
                    $no++,
                    $r->tglAbsen,
                    $r->namaGtk,
                    $r->jamMasuk,
                    $r->jamPulang,
                    (empty($r->statusGtk)) ? '<span class="badge badge-primary">Belum Absensi</span>' : (($r->statusGtk == 1) ? '<span class="badge badge-success">Sudah Absensi</span>' : '<span class="badge badge-danger">Absensi Terlambat</span>'),
                    '<div class="btn-group btn-small " style="text-align: right;">
                    <button class="btn btn-primary detail-absen" data-absen-id="' . $r->idAbsen . '" title="Lihat Absensi"><span class="fas fa-fw fa-address-card"></span></button>
                    </div>'
                ];
            }
        } elseif ($dataabsen == 'getallmsk') {
            $query = $this->db->get_where("absensi", ['tglAbsen' => $nowday, 'statusGtk' => 1]);
            foreach ($query->result() as $r) {
                $data[] = [
                    $no++,
                    $r->jamMasuk,
                    $r->namaGtk,
                    (empty($r->statusGtk)) ? '<span class="badge badge-primary">Belum Absensi</span>' : (($r->statusGtk == 1) ? '<span class="badge badge-success">Sudah Absensi</span>' : '<span class="badge badge-danger">Absensi Terlambat</span>')
                ];
            }
        } elseif ($dataabsen == 'getalltrl') {
            $query = $this->db->get_where("absensi", ['tglAbsen' => $nowday, 'statusGtk' => 2]);
            foreach ($query->result() as $r) {
                $data[] = [
                    $no++,
                    $r->jamMasuk,
                    $r->namaGtk,
                    (empty($r->statusGtk)) ? '<span class="badge badge-primary">Belum Absensi</span>' : (($r->statusGtk == 1) ? '<span class="badge badge-success">Sudah Absensi</span>' : '<span class="badge badge-danger">Absensi Terlambat</span>')
                ];
            }
        }
        $result = array(
            "draw" => $draw,
            "recordsTotal" => $query->num_rows(),
            "recordsFiltered" => $query->num_rows(),
            "data" => $data
        );
        echo json_encode($result);
    }

    // Fitur Ajax Pengaturan Aplikasi
    public function awalPengaturanAplikasi()
    {
        $typeinit = $this->input->get('type');
        $reponse = [
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash(),
        ];
        $this->Pengaturan->awalPengaturan($typeinit);
        echo json_encode($reponse);
    }

    public function validasi()                  
    {
        $reponse = [
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash(),
            'success' => False,
            'messages' => []
        ];
        $validation = [
            [
                'field' => 'nama_instansi',
                'label' => 'Nama Instansi',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'pesan_jumbotron',
                'label' => 'Pesan Jumbotron',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'nama_app_absen',
                'label' => 'Nama Aplikasi Absen',
                'rules' => 'trim|required|xss_clean|max_length[20]',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.', 'max_length' => 'Nama aplikasi terlalu panjang, Max Karakter 20!']
            ],
            [
                'field' => 'timezone_absen',
                'label' => 'Zona Waktu Absen',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'absen_mulai',
                'label' => 'Absen Mulai',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'absen_sampai',
                'label' => 'Batas Absen Masuk',
                'rules' => 'required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'absen_pulang_sampai',
                'label' => 'Absen Pulang',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ]
        ];
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            foreach ($_POST as $key => $value) {
                $reponse['messages'][$key] = form_error($key);
            }
        } else {
            $this->Pengaturan->atur();
            $reponse = [
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash(),
                'success' => true
            ];
        }
        echo json_encode($reponse);
    }

       //Fitur Print
       public function cetak()
       {
        is_logged_in();
        is_kepsek();
        $this->get_datasess = $this->db->get_where('pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->load->model('Absensi');
        $this->get_datasetupapp = $this->Absensi->muatSemuaPengaturan();
        $timezone_all = $this->get_datasetupapp;
        date_default_timezone_set($timezone_all['timezone']);
           if (!empty($this->input->get('idAbsen'))) {
               $id_absen = $this->input->get('idAbsen');                      
               $querydata = $this->db->get_where('absensi', ['idAbsen' => $id_absen])->row_array();
               $data = [
                   'dataapp' => $this->get_datasetupapp,
                   'dataabsensi' => $querydata
               ];
               ob_clean();
               $mpdf = new \Mpdf\Mpdf();
               $html = $this->load->view('layout/dataabsensi/printselfabsensi', $data, true);
               //$pdfFilePath = "storage/pdf_cache/absensipegawai_" . time() . "_download.pdf";
               $stylesheet = file_get_contents(FCPATH . 'assets/css/mpdf-bootstrap.css');
               $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
               $mpdf->WriteHTML(utf8_encode($html), \Mpdf\HTMLParserMode::HTML_BODY);
               $mpdf->SetTitle('Cetak Absen Pegawai');
               //$mpdf->Output(FCPATH . $pdfFilePath, "F");
               $mpdf->Output("absensipegawai_" . time() . "_self" . "_download.pdf", "I");
           } else {
               redirect(base_url('absensi'));
           }
       }

}
