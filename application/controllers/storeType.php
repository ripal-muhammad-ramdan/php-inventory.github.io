<?php
defined('BASEPATH') or exit('No direct script access allowed');

class storeType extends CI_Controller
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
            $this->load->view('inventory/v_storeType');
            $this->load->view('template/footer');
        }
    }

    function getStoreType()
    {
        $this->inventory->getData('store_type');
    }


    function crudStoreType()
    {
        $this->inventory->cruds('store_type', 'store_type_id', array('name'), 'store_type_id');
    }

    function html_select_StoreType()
    {
        $jrs = $this->inventory;
        $jrs->getType('store_type', 'store_type_id', 'name');
    }
}
