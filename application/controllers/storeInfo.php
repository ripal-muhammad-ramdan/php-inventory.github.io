<?php
defined('BASEPATH') or exit('No direct script access allowed');

class storeInfo extends CI_Controller
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
            $data['store_info_id'] = $this->input->post('store_info_id');
            $data['name'] = $this->input->post('name');
            $this->load->view('template/header');
            $this->load->view('inventory/v_storeInfo', $data);
            $this->load->view('template/footer');
        }
    }

    function datastoreInfo()
    {

        $getDT = $this->inventory;
        $getDT->getData('vw_store');
    }


    function detailData()
    {
        $getDetailData = $this->inventory;
        $getDetailData->getDetailData('store_info', 'store_info_id');
    }

    function detailDataStoreType()
    {
        $getDetailData = $this->inventory;
        $getDetailData->getDetailData('store_type', 'store_type_id');
    }

    function crudStoreInfo()
    {
        $strInf = $this->inventory;
        $strInf->cruds('store_info', 'store_info_id', array('store_type_id', 'name', 'description'), 'store_info_id');
    }
}
