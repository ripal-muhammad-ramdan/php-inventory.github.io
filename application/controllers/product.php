<?php
defined('BASEPATH') or exit('No direct script access allowed');

class product extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_inventory', 'inventory');
        $this->load->helper('url');
    }

    public function index()
    {
        if ($this->session->userdata('username') == null) {
            $this->load->view('login');
        } else {
            $API = "http://localhost/rest-api-php28/rest-api-server/product.php/getProduct";
            $client = curl_init($API);
            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($client);
            $result = json_decode($response);

            $data['products'] = $result;
            $this->load->view('template/header');
            $this->load->view('inventory/v_product',$data);
            $this->load->view('template/footer');
        }
    }

    function getProduct()
    {
        

        //print_r($result);
    }

    function detailProduct()
    {
        $getDetailData = $this->inventory;
        $getDetailData->getDetailData('products', 'products_id');
    }

    function crudProduct()
    {
        $this->inventory->cruds('products', 'products_id', array('product_type_id', 'name_prod', 'description'), 'products_id');
    }

    function html_select_productType()
    {
        $this->inventory->getType('product_type', 'product_type_id', 'name');;
    }
}
