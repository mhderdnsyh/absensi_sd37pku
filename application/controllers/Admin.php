<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Admin extends CI_Controller
class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->get_datasess = $this->db->get_where('pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->load->model('M_Front');
        $this->load->model('M_Admin');
        $this->get_datasetupapp = $this->M_Front->fetchsetupapp();
    }

    public function settingapp()                    //tampilPengaturanAplikasi
    {
        is_admin();
        $data = [
            'title' => 'Setting Aplikasi',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin/HalamanPengaturanAplikasi', $data);
        $this->load->view('layout/footer', $data);
    }

    public function datapegawai()               //tampilDataGTK
    {
        is_admin();
        $data = [
            'title' => 'Data Pegawai',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp,
            'fetchdbpegawai' => $this->M_Admin->fetchlistpegawai()
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin/HalamanDataGTK', $data);
        $this->load->view('layout/footer', $data);
    }

    public function absensi()                   //tampilAbsensiGTK
    {
        is_moderator();
        $data = [
            'title' => 'Kehadiran Pegawai',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin/HalamanAbsensiGTK', $data);
        $this->load->view('layout/footer', $data);
    }
}
