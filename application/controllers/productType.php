<?php
defined('BASEPATH') or exit('No direct script access allowed');

class productType extends CI_Controller
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
            $this->load->view('inventory/v_productType');
            $this->load->view('template/footer');
        }
    }

    function getProductType()
    {
        $this->inventory->getData('product_type');
    }

    function crudProductType()
    {
        $this->inventory->cruds('product_type', 'product_type_id', array('name'), 'product_type_id');
    }
}
