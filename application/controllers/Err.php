<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Err extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->get_datasess = $this->db->get_where('pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->load->model('Absensi');
        $this->get_datasetupapp = $this->Absensi->muatSemuaPengaturan();
    }

    public function block()
    {
        $data = [
            'title' => 'Access Denied',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp,
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('Error/blocked', $data);
        $this->load->view('layout/footer', $data);
    }

    public function notfound()
    {
        $data = [
            'title' => '404 - Tidak Ditemukan',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp,
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('Error/404', $data);
        $this->load->view('layout/footer', $data);
    }
}
