<?php

class Store_sale_summary_model extends CI_Model {

    
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
    function getRowsProducts($params = array(),$store_id) {
        $new_store_id=0;
        if(!empty($store_id)){
            $new_store_id=$store_id;
        }

        $this->db->select('s.id_sale,s.dtt_add,s.store_id,st.store_name,SUM(s.tot_amt) as tot_amt,SUM(s.paid_amt) as paid_amt,SUM(s.due_amt) as due_amt');
        $this->db->from('sales s');
        $this->db->join('stores st', 's.store_id= st.id_store');
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("s.dtt_add <=", $params['search']['ToDate']);
        }
        if(!empty($store_id)){
            $this->db->where("s.store_id IN ({$store_id})");
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
        }
        $this->db->group_by("s.store_id");
        $this->db->order_by('s.id_sale', 'desc');
        $query = $this->db->get();
        //echo  $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function store_promotion_list($params, $store_id){
        $this->db->select('s.store_id,SUM(sp.discount_amt) AS discount_amt');
        $this->db->from('sale_promotions sp');
        $this->db->join('sales s', 's.id_sale=sp.sale_id');
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("s.dtt_add <=", $params['search']['ToDate']);
        }
        if(!empty($store_id)){
            $this->db->where("s.store_id IN ({$store_id})");
        }
        $this->db->group_by('s.store_id');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    } 
    public function sale_transaction_details($id)
    {
        $this->db->select("a.amount as total_amount,b.payment_method_id,
        CASE a.qty_multiplier
            WHEN '0' THEN b.amount
            WHEN '1' THEN a.amount
        END AS amount,a.dtt_add");
        $this->db->from("sale_transaction_details a");
        $this->db->join('sale_transaction_payments b', 'a.sale_transaction_id = b.sale_transaction_id', 'left');
        $this->db->where("a.sale_id", $id);
         $this->db->where("a.transaction_type_id", 1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $res = $query->result_array();
        return $res;
    }

    
    

}

