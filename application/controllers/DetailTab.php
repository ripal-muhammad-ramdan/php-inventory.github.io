<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DetailTab extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function index()
    {
        //get data yang di post ke detailtab
        $data['store_info_id'] = $this->input->post('store_info_id');
        $data['name'] = $this->input->post('name');
        // transfer data nya ke view detail 
        //$this->load->view('template/header');
        $this->load->view('detailInventory/detailInventory', $data);
    }

    public function detailStoreType()
    {
        $data['store_type_id'] = $this->input->post('store_type_id');
        $data['name'] = $this->input->post('name');
        // transfer data nya ke view detail 
        //$this->load->view('template/header');
        $this->load->view('detailInventory/detailStoreType', $data);
    }

    public function detailProduct()
    {
        $data['products_id'] = $this->input->post('products_id');
        $data['name_prod'] = $this->input->post('name_prod');
        // transfer data nya ke view detail 
        $this->load->view('detailInventory/detailProduct', $data);
    }

    public function detailProductDetail()
    {
        $data['product_tariff_dt_id'] = $this->input->post('product_tariff_dt_id');
        // transfer data nya ke view detail 
        $this->load->view('detailInventory/detailProductDetail', $data);
    }
}
