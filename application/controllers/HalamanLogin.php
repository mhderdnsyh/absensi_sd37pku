<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanLogin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengguna');
        $this->load->model('Absensi');
        $this->get_datasetupapp = $this->Absensi->muatSemuaPengaturan();
    }

    public function tampilHalamanLogin()                                              
    {
        if ($this->session->userdata('username')) {
            // redirect(base_url());
            redirect('sistem/tampilHalamanDashboard');
        }
        $validation = [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ]
        ];
        $this->form_validation->set_rules($validation);
        if ($this->form_validation->run() == false) {
            $data = [
                'title' => 'Login Absensi',
                'dataapp' => $this->get_datasetupapp
            ];
            $this->load->view('layout/header', $data);
            $this->load->view('auth/HalamanLogin', $data);
            $this->load->view('layout/footer', $data);
        } else {
            //validasi sukses
            $this->Pengguna->cekAkun();
        }
    }
}