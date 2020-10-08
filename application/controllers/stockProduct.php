<?php
defined('BASEPATH') or exit('No direct script access allowed');

class stockProduct extends CI_Controller
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
            $this->load->view('inventory/v_stockProduct');
            $this->load->view('template/footer');
        }
    }

    function getStockProduct()
    {
        $this->inventory->getData('vw_stockprod');
    }

    function detailStockProduct()
    {
        $getDetailData = $this->inventory;
        $getDetailData->getDetailData('stock_products', 'stock_products_id');
    }

    function crudStockProduct()
    {
        $this->inventory->cruds('stock_products', 'stock_products_id', array('store_info_id', 'products_id', 'stok'), 'stock_products_id');
    }

    function html_select_storeInfo()
    {
        $this->inventory->getType('store_info', 'store_info_id', 'name');;
    }

    function html_select_product()
    {
        $this->inventory->getType('products', 'products_id', 'name_prod');;
    }
}
