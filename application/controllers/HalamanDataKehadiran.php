<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanDataKehadiran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->get_datasess = $this->db->get_where('pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->load->model('Absensi');
        // $this->load->model('Pengguna');
        $this->get_datasetupapp = $this->Absensi->muatSemuaPengaturan();
    }
    public function tampilHalamanDataKehadiran()                          
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

       //Fitur Preview Absensi
       public function tampilDialogPreviewAbsensi()                      
       {
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
           $typesend = $this->input->get('type');
           $reponse = [
               'csrfName' => $this->security->get_csrf_token_name(),
               'csrfHash' => $this->security->get_csrf_hash()
           ];
          if ($typesend == 'viewabs') {
               $data = [
                   'dataabsensi' => $this->db->get_where('absensi', ['idAbsen' => $this->input->post('absen_id')])->row_array(),    
                   'dataapp' => $this->appsetting
               ];
               $html = $this->load->view('layout/dataabsensi/viewabsensi', $data);
               $reponse = [
                   'html' => $html,
                   'csrfName' => $this->security->get_csrf_token_name(),
                   'csrfHash' => $this->security->get_csrf_hash(),
                   'success' => true
               ];
           } 
           echo json_encode($reponse);
       }
}
