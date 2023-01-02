<?php

function is_logged_in()
{
    $ci = get_instance();
    $ci->load->model('Pengguna');
    $username = $ci->session->userdata('username');
    if (!$ci->session->userdata('logged_in')) {
        redirect('login');
    } elseif (empty($ci->db->get_where('pengguna', ['username' => $username])->row_array())) {
        $ci->session->sess_destroy();
        redirect('login');
    }
}

function is_operator()
{
    $ci = get_instance();
    $roleId = $ci->session->userdata('roleId');

    if ($roleId != 1) {
        redirect('block');
    }
}

function is_kepsek()
{
    $ci = get_instance();
    $roleId = $ci->session->userdata('roleId');

    if ($roleId != 1 && $roleId != 2) {
        redirect('block');
    }
}
