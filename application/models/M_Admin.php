<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Admin extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $this->get_today_date = $hari[(int)date("w")] . ', ' . date("j ") . $bulan[(int)date('m')] . date(" Y");
        $this->get_datasess = $this->db->get_where('pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->appsetting = $this->db->get_where('pengaturan', ['statusSetting' => 1])->row_array();
    }

    public function hitungjumlahdata($typehitung)
    {
        $today = $this->get_today_date;
        if ($typehitung == 'jmlpgw') {

            $query = $this->db->get('pengguna');
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return 0;
            }
        } elseif ($typehitung == 'pgwtrl') {
            $query = $this->db->get_where('absensi', ['statusGtk' => 2, 'tglAbsen' => $today]);
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return 0;
            }
        } elseif ($typehitung == 'pgwmsk') {
            $query = $this->db->get_where('absensi', ['statusGtk' => 1, 'tglAbsen' => $today]);
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return 0;
            }
        }
    }

    public function fetchlistpegawai()
    {
        return $this->db->get_where('pengguna')->result();
    }

    public function crudpgw($typesend)
    {
        if ($typesend == 'addpgw') {

            $kd_pegawai = random_string('numeric', 15);

            if (empty(htmlspecialchars($this->input->post('npwp_pegawai')))) {         
                $rownpwp = 'Tidak Ada';
            } else {
                $rownpwp = $this->input->post('npwp_pegawai');                        
            }

            $upload_image = $_FILES['foto_pegawai']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                $config['max_size']      = '2048';
                $config['encrypt_name'] = TRUE;
                $config['upload_path'] = $this->config->item('SAVE_FOLDER_PROFILE');

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto_pegawai')) {
                    $gbr = $this->upload->data();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $this->config->item('SAVE_FOLDER_PROFILE') . $gbr['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 300;
                    $config['height'] = 300;
                    $config['new_image'] = $this->config->item('SAVE_FOLDER_PROFILE') . $gbr['file_name'];
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    return "default.png";
                }
            } else {
                $this->db->set('image', 'default.png');
            }

            $sendsave = [
                'namaLengkap' => htmlspecialchars($this->input->post('nama_pegawai')),
                'username' => htmlspecialchars($this->input->post('username_pegawai')),
                // 'password' => password_hash($this->input->post('password_pegawai'), PASSWORD_DEFAULT),
                'password' => ($this->input->post('password_pegawai')),
                'kodeGtk' => $kd_pegawai,
                'jabatan' => htmlspecialchars($this->input->post('jabatan_pegawai')),
                'instansi' => $this->appsetting['namaInstansi'],                    //awalnya ['nama_instansi']
                'nipGtk' => $rownpwp,                                                             //npwp ragu jdkan nip
                'umur' => htmlspecialchars($this->input->post('umur_pegawai')),
                'tempatLahir' => htmlspecialchars($this->input->post('tempat_lahir_pegawai')),
                'tglLahir' => htmlspecialchars($this->input->post('tgl_lahir_pegawai')),
                'jenisKelamin' => htmlspecialchars($this->input->post('jenis_kelamin_pegawai')),
                'bagianShift' => htmlspecialchars($this->input->post('shift_pegawai')),
                'isActive' => htmlspecialchars($this->input->post('verifikasi_pegawai')),
                'roleId' => htmlspecialchars($this->input->post('role_pegawai')),
                'dateCreated' => time()
            ];
            $this->db->insert('pengguna', $sendsave);
        } elseif ($typesend == 'delpgw') {
            $query = $this->db->get_where('pengguna', ['idGtk' => htmlspecialchars($this->input->post('pgw_id', true))])->row_array();

            $old_image = $query['image'];
            if ($old_image != 'default-profile.png') {
                unlink($this->config->item('SAVE_FOLDER_PROFILE') . $old_image);
            }
            $old_qrcode = $query['qr_code_image'];
            if ($old_qrcode != 'no-qrcode.png') {
                unlink($this->config->item('SAVE_FOLDER_QRCODE') . $old_qrcode);
            }
            $this->db->delete('pengguna', ['idGtk' => htmlspecialchars($this->input->post('pgw_id', true))]);
        } elseif ($typesend == 'actpgw') {
            $this->db->set('isActive', 1);
            $this->db->where('idGtk', htmlspecialchars($this->input->post('pgw_id', true)));
            $this->db->update('pengguna');
        } elseif ($typesend == 'edtpgwalt') {
            $query_user = $this->db->get_where('pengguna', ['idGtk' => htmlspecialchars($this->input->post('id_pegawai_edit', true))])->row_array();
            $kd_pegawai = $query_user['kodeGtk'];
            $queryimage = $query_user;
            if (empty(htmlspecialchars($this->input->post('npwp_pegawai_edit')))) {
                $rownpwp = 'Tidak Ada';
            } else {
                $rownpwp = $this->input->post('npwp_pegawai_edit');
            }

               if (!empty(htmlspecialchars($this->input->post('password_pegawai_edit')))) {
                $this->db->set('password'($this->input->post('password_pegawai_edit')));
            }

            $upload_image = $_FILES['foto_pegawai_edit']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                $config['max_size']      = '2048';
                $config['encrypt_name'] = TRUE;
                $config['upload_path'] = $this->config->item('SAVE_FOLDER_PROFILE');

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto_pegawai_edit')) {
                    $gbr = $this->upload->data();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $this->config->item('SAVE_FOLDER_PROFILE') . $gbr['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 300;
                    $config['height'] = 300;
                    $config['new_image'] = $this->config->item('SAVE_FOLDER_PROFILE') . $gbr['file_name'];
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $old_image = $queryimage['image'];
                    if ($old_image != 'default.png') {
                        unlink($this->config->item('SAVE_FOLDER_PROFILE') . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    return "default.png";
                }
            }

            $sendsave = [
                'namaLengkap' => htmlspecialchars($this->input->post('nama_pegawai_edit')),
                'username' => htmlspecialchars($this->input->post('username_pegawai_edit')),
                'jabatan' => htmlspecialchars($this->input->post('jabatan_pegawai_edit')),
                'instansi' => $this->appsetting['nama_instansi'],
                'nipGtk' => $rownpwp,
                'umur' => htmlspecialchars($this->input->post('umur_pegawai_edit')),
                'tempatLahir' => htmlspecialchars($this->input->post('tempat_lahir_pegawai_edit')),
                'tglLahir' => htmlspecialchars($this->input->post('tgl_lahir_pegawai_edit')),
                'jenisKelamin' => htmlspecialchars($this->input->post('jenis_kelamin_pegawai_edit')),
                'bagianShift' => htmlspecialchars($this->input->post('shift_pegawai_edit')),
                'isActive' => htmlspecialchars($this->input->post('verifikasi_pegawai_edit')),
                'roleId' => htmlspecialchars($this->input->post('role_pegawai_edit')),
            ];
            $this->db->set($sendsave);
            $this->db->where('idGtk', htmlspecialchars($this->input->post('id_pegawai_edit', true)));
            $this->db->update('pengguna');
        }
    }
}
