<?php
defined('BASEPATH') or exit('No direct script access allowed');

class otpLogin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('M_login', 'login');
        $this->load->model('M_register', 'register');
    }
    public function index()
    {
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[12]');

        if ($this->session->userdata('username')) {
            $this->load->view('template/header');
            $this->load->view('inventory/v_product');
            $this->load->view('template/footer');
        } else {
            if ($this->form_validation->run() == false) {
                $this->load->view('otp_login');
            } else {
                $this->otpLog();
            }
        }
    }

    public function otpLog()
    {
        $this->login->otp('form_user');
    }


    public function logout()
    {
        $this->session->unset_userdata('username');
        redirect('index');
    }

    public function register()
    {
        $this->register->do_register('form_user');
    }
}
