<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_register extends CI_Model
{
    function do_register($_table)
    {
        $username = $this->input->post('username');
        $chatID = $this->input->post('chat_id');
        $mail = $this->input->post('email');
        $psw = $this->input->post('password');
        $token = $this->input->post('token');
        $this->form_validation->set_rules('username', 'User Name', 'required|trim', ['required' => 'Isilah Jangan Malas!']);
        $this->form_validation->set_rules('chat_id', 'Chat ID', 'required|trim', ['required' => 'Isilah Jangan Malas!']);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[' . $_table . '.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('token', 'Token', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('register');
        } else {

            $data = [
                'username' => $username,
                'email' => $mail,
                'chat_id' => $chatID,
                'password' => password_hash($psw, PASSWORD_DEFAULT),
                'token' => $token
            ];
            $this->db->insert($_table, $data);

            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'emailkamu@gmail.com',
                'smtp_pass' => 'password email kamu',
                'mailtype'  => 'html',
                'wordwrap' => TRUE,
                'charset'   => 'iso-8859-1'
            );

            // initialization
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            // from email (email sender, Sender Name)
            $this->email->from('emailkamu@gmail.com', 'InventoryKami'); // from email
            // send to 
            $this->email->to($mail);
            // subject email
            $this->email->subject('Selamat Datang di Inventory Kami');
            // Message
            $this->email->message("Selamat user berhasil terdaftar dengan : 
            <br> username : $username
            <br> Chat ID Telegram : $chatID
            <br> email : $mail 
            <br> password : $psw ");

            // send mail
            if ($this->email->send()) {
                echo 'Email sent.!';
            } else {
                show_error($this->email->print_debugger());
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Success, User Has Been Created Check Your Email ! </div>');

            redirect('telegramBot');
        }
    }
}
