<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_inventory extends CI_Model
{

    
    public function cruds($_table, $_key, $_field, $_getId)
    {
        $user_session = $this->session->userdata("username");
        $table = $_table;
        $key = $_key;
        $field = $_field;
        $getId = $_getId;
        $input = $this->input;
        $create = ['created_date' => 'now()', 'created_by' => $user_session];
        $update = ['updated_by' => $user_session, 'updated_date' => 'now()'];

        $oper = $input->post('oper');
        $id = $input->post($getId);

        $count = count($field);
        //  print_r($count);
        for ($i = 0; $i < $count; $i++) {
            $data[$field[$i]] = $input->post($field[$i]);
        }
        switch ($oper) {
            case 'add':
                $new_id = $this->gen_id($key, $table);
                $this->db->set($key, $new_id);
                $this->db->set($create);
                $this->db->set($update);
                $this->db->insert($table, $data);
                break;
            case 'edit':
                $this->db->where($key, $id);
                $this->db->set($update);
                $this->db->update($table, $data);
                break;
            case 'del':
                $this->db->where($key, $id);
                $this->db->delete($table);
                break;
        }
    }

    function gen_id($key, $table)
    {

        $q = $this->db->query("SELECT coalesce(MAX($key),0)+1 $key FROM $table");
        $row = $q->row(0);
        return $row->$key;
    }

    public function getData($_tableName)
    {
        $page = $_GET['page']; // get the requested page
        $limit = $_GET['rows']; // get how many rows we want to have into the grid
        $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
        $sord = $_GET['sord']; // get the direction
        if (!$sidx) $sidx = 1;

        $tableName = $_tableName;
        //search 
        $where = '1=1'; // if user not user searching 
        if ($_GET['_search'] == 'true') {
            $param['search_field'] = $_GET['searchField'];
            $param['search_str'] = $_GET['searchString'];
            $param['search_operator'] = $_GET['searchOper'];
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
        if ($sidx != '') $this->db->order_by($sidx, $sord);
        $this->db->where($where);
        $responce['rows'] = $this->db->get($tableName)->result_array();

        echo json_encode($responce);
    }

    public function getDetailData($_tableName, $_getID)
    {
        $page = $_POST['page']; // get the requested page
        $limit = $_POST['rows']; // get how many rows we want to have into the grid
        $sidx = $_POST['sidx']; // get index row - i.e. user click to sort
        $sord = $_POST['sord']; // get the direction
        if (!$sidx) $sidx = 1;

        $idStrInf =  $this->input->post($_getID);

        $tableName = $_tableName;
        //search 
        $where = "$_getID = $idStrInf "; // if user not user searching 
        if ($_POST['_search'] == 'true') {
            $param['search_field'] = $_POST['searchField'];
            $param['search_str'] = $_POST['searchString'];
            $param['search_operator'] = $_POST['searchOper'];
            $where = $this->generateWhereCondition($param);
        }

        // print_r($where);

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
        if ($sidx != '') $this->db->order_by($sidx, $sord);
        $this->db->where($where);
        $responce['rows'] = $this->db->get($tableName)->result_array();

        echo json_encode($responce);
    }

    function generateWhereCondition($param)
    {
        // searchField
        // searchString
        // searchOper
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

    public function getType($_tbl, $id, $value)
    {
        try {

            $items = $this->db->get($_tbl)->result_array();
            echo '<select>';
            foreach ($items  as $item) {
                echo '<option value="' . $item[$id] . '">' . $item[$value] . '</option>';
            }
            echo '</select>';
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
