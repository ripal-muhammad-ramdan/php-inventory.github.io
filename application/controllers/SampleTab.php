<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SampleTab extends CI_Controller
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
        $this->load->view('template/header');
        $this->load->view('sampletabs/sampletabs');
        $this->load->view('template/footer');
    }

    function dataPasien()
    {

        $page = $_POST['page']; // get the requested page
        $limit = $_POST['rows']; // get how many rows we want to have into the grid
        $sidx = $_POST['sidx']; // get index row - i.e. user click to sort
        $sord = $_POST['sord']; // get the direction
        if (!$sidx) $sidx = 1;

        $tableName = 'pasiens';
        //search 
        $where = '1=1'; // if user not user searching 
        if ($_POST['_search'] == 'true') {
            $param['search_field'] = $_POST['searchField'];
            $param['search_str'] = $_POST['searchString'];
            $param['search_operator'] = $_POST['searchOper'];
            $where = $this->generateWhereCondition($param);
        }
        // count all rows 
        $this->db->where($where); // generate where 
        $count = $this->db->count_all_results($tableName);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) $page = $total_pages;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        $start = $start < 0 ? 0 : $start; // start cant be negative 

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        // set limit 
        if ($limit != '') $this->db->limit($limit, $start);
        // set order by 
        // if($sidx!= '') $this->db->order_by($sidx, $sord);
        $this->db->where($where);
        $responce['rows'] = $this->db->get($tableName)->result_array();

        echo json_encode($responce);
    }

    function generateWhereCondition($param)
    {
        if (is_numeric($param['search_str'])) {
            $wh = "" . $param['search_field'] . "";
        } else {
            $wh = "UPPER(" . $param['search_field'] . " )";
        }
        switch ($param['search_operator']) {
            case "bw": // begin with
                $wh .= " LIKE UPPER('" . $param['search_str'] . "%')";
                break;
            case "ew": // end with
                $wh .= " LIKE UPPER('%" . $param['search_str'] . "')";
                break;
            case "cn": // contain %param%
                $wh .= " LIKE UPPER('%" . $param['search_str'] . "%')";
                break;
            case "eq": // equal =
                if (is_numeric($param['search_str'])) {
                    $wh .= " = " . $param['search_str'];
                } else {
                    $wh .= " = UPPER('" . $param['search_str'] . "')";
                }
                break;
            case "ne": // not equal
                if (is_numeric($param['search_str'])) {
                    $wh .= " <> " . $param['search_str'];
                } else {
                    $wh .= " <> UPPER('" . $param['search_str'] . "')";
                }
                break;
            case "lt":
                if (is_numeric($param['search_str'])) {
                    $wh .= " < " . $param['search_str'];
                } else {
                    $wh .= " < '" . $param['search_str'] . "'";
                }
                break;
            case "le":
                if (is_numeric($param['search_str'])) {
                    $wh .= " <= " . $param['search_str'];
                } else {
                    $wh .= " <= '" . $param['search_str'] . "'";
                }
                break;
            case "gt":
                if (is_numeric($param['search_str'])) {
                    $wh .= " > " . $param['search_str'];
                } else {
                    $wh .= " > '" . $param['search_str'] . "'";
                }
                break;
            case "ge":
                if (is_numeric($param['search_str'])) {
                    $wh .= " >= " . $param['search_str'];
                } else {
                    $wh .= " >= '" . $param['search_str'] . "'";
                }
                break;
            default:
                $wh = "";
        }
        return $wh;
    }

    function crud()
    {

        $table = "pasiens";
        $key = "id_p";
        $field = array('nama', 'alamat');

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
        $birth_date = $this->input->post('birth_date');

        $count = count($field);
        //  print_r($count);
        for ($i = 0; $i < $count; $i++) {
            $data[$field[$i]] = $this->input->post($field[$i], true);
        }
        switch ($oper) {
            case 'add':
                $new_id = $this->gen_id($key, $table);
                $this->db->set($key, $new_id);
                // $this->db->set('birth_date', "to_date('$birth_date', 'yyyy-mm-dd' )", false);
                $this->db->insert($table, $data);
                break;
            case 'edit':
                $this->db->where($key, $id_);
                $this->db->set('birth_date', "to_date('$birth_date', 'yyyy-mm-dd' )", false);
                $this->db->update($table, $data);
                break;
            case 'del':
                // die($id_);
                $this->db->where($key, $id_);
                $this->db->delete($table);
                break;
        }
    }

    function gen_id($key, $table)
    {

        $q = $this->db->query("SELECT coalesce(MAX($key),0)+1 id FROM $table");
        $row = $q->row(0);
        return $row->id;
    }
}
