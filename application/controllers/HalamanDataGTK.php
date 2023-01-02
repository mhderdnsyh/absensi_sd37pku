<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanDataGTK extends CI_Controller
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

    public function tampilHalamanDataGTK()              
    {
        is_operator();
        $data = [
            'title' => 'Data GTK',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp,
            'fetchdbpegawai' => $this->Pengguna->muatSemuaPengguna()
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin/HalamanDataGTK', $data);
        $this->load->view('layout/footer', $data);
    }
}