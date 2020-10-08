<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{
    function do_login($_table)
    {
        $username = $this->input->post('username');

        $data = ['username' => $username];
        $user = $this->db->get_where($_table, $data)->row_array();
        if ($user == null) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            username, Does Not Exists ! </div>');
            redirect('telegramBot');
        } else {
            $datasession = ['username' => $username];
            $this->session->set_userdata($datasession);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Success, Cek Telegram ! </div>');
            $this->sendMessageTelegram($user['chat_id'], $user['token']);
            redirect('telegramBot');
        }
    }

    public function sendMessageTelegram($_chat_id, $_token)
    {
        $chatid = $_chat_id;
        $token = $_token;
        $message = rand();
        $message2 = "OTP Anda Adalah : " . $message;


        try { /*Config data query*/
            $data = [
                'text' => $message2,
                'chat_id' => $chatid
            ];
            $execfgc = file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data));
            if (!$execfgc) {
                throw new Exception('Something really gone wrong');
            } else {
                echo json_encode(array('success' => true, 'msg' => 'Chat Has been send'));
                $this->db->query("UPDATE form_user 
                                    SET otpuser = '$message',
                                    otpdate = 'now()' 
                                    WHERE chat_id = '$chatid'");
            }
        } catch (Exception $e) {
            echo json_encode(array('success' => false, 'msg' => 'Chat fail to send'));
        }
    }

    public function otp($_table)
    {
        $username = $this->input->post('username');
        $otp = $this->input->post('otpuser');
        $pwd = $this->input->post('password');


        $data = [
            'username' => $username,
            'otpuser' => $otp
        ];
        $user = $this->db->get_where($_table, $data)->row_array();
        if ($user == null) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Error, OTP Does Not Exists ! </div>');
            redirect('telegramBot');
        } else {
            if (password_verify($pwd, $user['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Success, Login ! </div>');
                redirect('accountType');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Error, Wrong Password ! </div>');
                redirect('telegramBot');
            }
        }
    }
}
