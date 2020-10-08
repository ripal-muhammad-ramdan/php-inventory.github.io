<?php
defined('BASEPATH') or exit('No direct script access allowed');

class stockProductDetail extends CI_Controller
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
            $this->load->view('inventory/v_stockProductDetail');
            $this->load->view('template/footer');
        }
    }

    function getStockProductDetail()
    {
        $this->inventory->getData('vw_stockproddetail');
    }

    function crudStockProductDetail()
    {
        $this->inventory->cruds('stockproduct_details', 'stckprod_dt_id', array('acc_type_id', 'stock_products_id', 'description'), 'stckprod_dt_id');
    }

    function html_select_accType()
    {
        $this->inventory->getType('acc_type', 'acc_type_id', 'name_acc');;
    }

    function html_select_stockProduct()
    {
        $this->inventory->getType('stock_products', 'stock_products_id', 'name');;
    }

    function html_select_join()
    {
        try {

            $join = $this->db->query("SELECT stock_products.stock_products_id, products.name_prod, store_info.name
            FROM stock_products 
            INNER JOIN store_info 
                ON store_info.store_info_id=stock_products.store_info_id 
            INNER JOIN products 
                ON stock_products.products_id=products.products_id")->result_array();
            echo '<select>';
            foreach ($join as $jn) {
                echo '<option value="' . $jn['stock_products_id'] . '">' . $jn['name'] . ' - '  . $jn['name_prod'] . '</option>';
            }
            echo '</select>';
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
