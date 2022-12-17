<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class User extends CI_Controller
class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->get_datasess = $this->db->get_where('pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->load->model('M_Front');
        $this->load->model('M_User');
        $this->get_datasetupapp = $this->M_Front->fetchsetupapp();
    }

    public function absensiku()                                 //klo ini nanti coba aja test ganti atasnya aja soalnya bawahnya cmn user/absensi bukan user/absensiku
    {
        $data = [
            'title' => 'Data Kehadiran',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('user/HalamanDataKehadiran', $data);
        $this->load->view('layout/footer', $data);
    }
}
