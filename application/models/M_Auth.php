<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_Model
{
   
    public function do_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user = $this->db->get_where('pengguna', ['username' => $username])->row_array();
        if ($user) {
            //jika user aktif
            if ($user['isActive'] == 1) {
                //check password
                if ($password == $user['password']) {
                    $membuat_session = [
                        'username' => $user['username'],
                        'roleId' => $user['roleId'],
                        'logged_in' => true
                    ];
                    $this->db->where('pengguna.idGtk', $user['idGtk']);
                    $this->session->set_userdata($membuat_session); //Memasukan / menyimpan data ke session
                    redirect(base_url());
                } else {
                    $this->session->set_flashdata('authmsg', '<div class="alert alert-danger" role="alert">Password Atau Username Salah!</div>');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('authmsg', '<div class="alert alert-danger" role="alert">Akun Ini Belum Aktif, Silakan Hubungi Pihak Operator!</div>');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('authmsg', '<div class="alert alert-danger" role="alert">Akun Belum Terdaftar!</div>');
            redirect('login');
        }
    }

    public function do_logout()
    {
        $update_db = [
            'last_login' => time()
        ];
        $this->db->where('username', $this->session->userdata('username'));
        $this->db->update('pengguna', $update_db);
        if ($this->session->userdata('username')) {
            $this->session->sess_destroy();
            // if (!empty(get_cookie('absensi_rememberme'))) {
            //     $get_cookie_rmb = get_cookie('absensi_rememberme');
            //     $this->db->delete('db_rememberme', ['cookie_hash' => $get_cookie_rmb]);
            //     delete_cookie('absensi_rememberme');
            // }
        } else {
            $this->session->set_flashdata('authmsg', '<div class="alert alert-danger" role="alert">You are not logged in!</div>'); //Mengirimkan informasi sukses ke halaman login
            redirect('login'); //Mengarahkan otomatis user ke halaman login
        }
    }
}
