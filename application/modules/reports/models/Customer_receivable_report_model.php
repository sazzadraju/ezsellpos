<?php

class Customer_receivable_report_model extends CI_Model {

    
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

    function getCustomerReceivableReport($params = array()) {
       // $this->db->distinct('dtt_add');
        $this->db->select('s.invoice_no,s.store_id,sum(s.tot_amt) as tot_amt,sum(s.paid_amt) as paid_amt,sum(s.due_amt) as due_amt,s.dtt_add,st.store_name,c.full_name as customer_name');
        $this->db->from('sales s');
        $this->db->join('customers c','s.customer_id = c.id_customer','left');
         $this->db->join('stores st', 's.store_id= st.id_store');
        if (!empty($params['search']['store_id'])) {  
            $this->db->where('s.store_id', $params['search']['store_id']);
        }
          if (!empty($params['search']['customer_id'])) {
            $this->db->where('s.customer_id', $params['search']['customer_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("s.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('s.status_id', 1);
        $this->db->where('s.customer_id !=', '');
        $this->db->where('s.due_amt>', 0);
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->group_by('customer_id');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function getcustomerReportByInvoice($params = array()){
        $this->db->select('s.invoice_no,s.store_id,s.tot_amt,s.paid_amt,s.due_amt,s.dtt_add,s.settle,st.store_name,c.full_name as customer_name');
        $this->db->from('sales s');
        $this->db->join('customers c','s.customer_id = c.id_customer','left');
         $this->db->join('stores st', 's.store_id= st.id_store');
        if (!empty($params['search']['type_data'])) { 
            if($params['search']['type_data']==1){
                $this->db->group_start();
                $this->db->where('s.due_amt <=', 0);
                $this->db->or_where('s.settle', 0);
                $this->db->group_end();
            }else if($params['search']['type_data']==2){
                $this->db->group_start();
                $this->db->where('s.due_amt', 0);
                $this->db->or_where('s.settle', 1);
                $this->db->group_end();
            }
        }
        if (!empty($params['search']['store_id'])) {  
            $this->db->where('s.store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['customer_id'])) {
            $this->db->where('s.customer_id', $params['search']['customer_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("s.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('s.status_id', 1);
        $this->db->where('s.customer_id !=', '');
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }
    
   
    

}

