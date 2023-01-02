<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanPengaturanAplikasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->get_datasess = $this->db->get_where('pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->load->model('Absensi');
        $this->load->model('Pengguna');
        $this->get_datasetupapp = $this->Absensi->muatSemuaPengaturan();
    }
    public function tampilHalamanPengaturanAplikasi()                    
    {   
        is_operator();
        $data = [
            'title' => 'Pengaturan Aplikasi',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin/HalamanPengaturanAplikasi', $data);
        $this->load->view('layout/footer', $data);
    }
}