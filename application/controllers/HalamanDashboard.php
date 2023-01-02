<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
		$this->get_datasess = $this->db->get_where('pengguna', ['username' =>
		$this->session->userdata('username')])->row_array();
		$this->load->model('Absensi');
		$this->get_datasetupapp = $this->Absensi->muatSemuaPengaturan();
		$timezone_all = $this->get_datasetupapp;
		date_default_timezone_set($timezone_all['timezone']);

    }
    public function tampilHalamanDashboard()
	{
        if (date("H") < 4) {
			$greet = 'Selamat Malam';
		} elseif (date("H") < 11) {
			$greet = 'Selamat Pagi';
		} elseif (date("H") < 16) {
			$greet = 'Selamat Siang';
		} elseif (date("H") < 18) {
			$greet = 'Selamat Sore';
		} else {
			$greet = 'Selamat Malam';
		}
		$data = [
			'title' => $this->get_datasetupapp['namaAppAbsensi'],
			'user' => $this->get_datasess,
			'dataapp' => $this->get_datasetupapp,
			'dbabsensi' => $this->Absensi->muatSemuaAbsensi($this->get_datasess['kodeGtk']),
			'greeting' => $greet
		];
		$this->load->view('layout/header', $data);
		$this->load->view('layout/navbar', $data);
		$this->load->view('layout/sidebar', $data);
		$this->load->view('front/HalamanDashboard', $data);
		$this->load->view('layout/footer', $data);
	}
}