<?php
defined('BASEPATH') or exit('No direct script access allowed');

class telegramBot extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // error_reporting(0);
        // ini_set('display_errors', 0);
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('M_login', 'login');
        $this->load->model('M_register', 'register');
    }
    public function index()
    {
        $this->form_validation->set_rules('username', 'username', 'required');

        if ($this->session->userdata('username')) {
            $this->load->view('otp_login');
        } else {
            if ($this->form_validation->run() == false) {
                $this->load->view('login');
            } else {
                $this->__login();
            }
        }
    }

    public function getUpdateMessage()
    {
        $token = $this->input->post('token', true);
        $execfgc = file_get_contents("https://api.telegram.org/bot$token/getUpdates");
        try {
            if (!$execfgc) {
                throw new Exception('Something really gone wrong');
            } else {
                echo $execfgc; // echo json_encode($execfgc); 
            }
        } catch (Exception $e) {
            echo json_encode(array('success' => false, 'msg' => 'Chat fail to send'));
        }
    }

    private function __login()
    {
        $this->login->do_login('form_user');
    }

    public function reload()
    {
        $this->login->do_login('form_user');
    }

    public function otpLog()
    {
        $this->login->otp('form_user');
    }


    public function logout()
    {
        $this->session->unset_userdata('username');
        redirect('telegramBot');
    }

    public function register()
    {
        $this->register->do_register('form_user');
    }
}
