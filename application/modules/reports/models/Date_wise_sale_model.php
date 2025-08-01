<?php

class Date_wise_sale_Model extends CI_Model {

    
    public function getvalue_row($tbl, $fn, $fcon = array()) {
        $this->db->select($fn);
        $this->db->where($fcon);
        $q = $this->db->get($tbl);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    function getRowsProducts($params = array()) {
       // $this->db->distinct('dtt_add');
        $this->db->select('dtt_add,store_id,SUM(tot_amt) as tot_amt,SUM(paid_amt) as paid_amt,SUM(due_amt) as due_amt');
        $this->db->from('sales');
        if (!empty($params['search']['store_id'])) {  
            $this->db->where('store_id', $params['search']['store_id']);
        }
         else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("dtt_add >=", $params['search']['FromDate']);
            $this->db->where("dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('status_id', 1);
        $this->db->order_by('id_sale', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->group_by("DATE(dtt_add)");
        //get records
        $query = $this->db->get();
        //return $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
}

