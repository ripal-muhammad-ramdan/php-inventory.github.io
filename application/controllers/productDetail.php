<?php
defined('BASEPATH') or exit('No direct script access allowed');

class productDetail extends CI_Controller
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
            $this->load->view('inventory/v_productDetail');
            $this->load->view('template/footer');
        }
    }

    function getProductTarif()
    {
        $this->inventory->getData('vw_product_tarif_detail');
    }
    function detailProductDetail()
    {
        $getDetailData = $this->inventory;
        $getDetailData->getDetailData('product_tariff_details', 'product_tariff_dt_id');
    }

    function crudProductTarifDetail()
    {
        $this->inventory->cruds('product_tariff_details', 'product_tariff_dt_id', array('products_id', 'rate', 'valid_from', 'valid_until'), 'product_tariff_dt_id');
    }

    function html_select_product()
    {
        $this->inventory->getType('products', 'products_id', 'name_prod');;
    }
}
