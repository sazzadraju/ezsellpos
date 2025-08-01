<?php

class Supplier_payable_report_model extends CI_Model {

    
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
        $this->db->select('pr.due_amt,pr.invoice_no,pr.store_id,sum(pr.tot_amt)as tot_amt,sum(pr.paid_amt)as paid_amt,sum(pr.due_amt)as due_amt,pr.dtt_add,st.store_name,sp.supplier_name');
        $this->db->from('purchase_receives pr');
        $this->db->join('stores st', 'pr.store_id= st.id_store');
        $this->db->join('suppliers sp', 'sp.id_supplier=pr.supplier_id');
        if (!empty($params['search']['store_id'])) {  
            $this->db->where('pr.store_id', $params['search']['store_id']);
        }
         else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('pr.store_id', $this->session->userdata['login_info']['store_id']);
        }
          if (!empty($params['search']['supplier_id'])) {  
            $this->db->where('pr.supplier_id', $params['search']['supplier_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("pr.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("pr.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('pr.status_id', 1);
        $this->db->where('pr.due_amt>', 0);
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
         $this->db->group_by("supplier_id");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    
    

}

