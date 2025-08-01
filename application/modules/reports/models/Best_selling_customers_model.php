<?php

class Best_selling_customers_model extends CI_Model {

    
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
        $this->db->select('s.store_id,st.store_name,SUM(s.tot_amt) as tot_amt,SUM(s.paid_amt) as paid_amt,SUM(s.due_amt) as due_amt,c.full_name customer_name,c.customer_code,c.phone,ct.name as customer_type');
        $this->db->from('sales s');
        $this->db->join('customers c', 's.customer_id= c.id_customer','left');
        $this->db->join('customer_types ct','c.customer_type_id = ct.id_customer_type','left');
        $this->db->join('stores st', 's.store_id= st.id_store');
        //$this->db->join('stocks stk', 'stk.id_stock= sd.stock_id');
        if (!empty($params['search']['customer_type'])) {
            $this->db->where('c.customer_type_id', $params['search']['customer_type']);
        }
        if (!empty($params['search']['store_id'])) {
            $this->db->where('s.store_id', $params['search']['store_id']);
        }else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("s.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('s.status_id', 1);
        $this->db->where('s.customer_id >', 0);
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->group_by(array("s.customer_id","s.store_id"));
        $this->db->order_by("SUM(s.tot_amt)", "desc");
        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    
   
    

}

