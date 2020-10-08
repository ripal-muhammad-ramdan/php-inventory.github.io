<?php
defined('BASEPATH') or exit('No direct script access allowed');

class accountType extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_inventory', 'inventory');
    }

    public function index()
    {
        if ($this->session->userdata('username') == null) {
            $this->load->view('login');
        } else {
            $this->load->view('template/header');
            $this->load->view('inventory/v_accountType');
            $this->load->view('template/footer');
        }
    }

    function getAccountType()
    {
        $this->inventory->getData('acc_type');
    }

    function crudAccountType()
    {
        $this->inventory->cruds('acc_type', 'acc_type_id', array('name_acc'), 'acc_type_id');
    }
}
