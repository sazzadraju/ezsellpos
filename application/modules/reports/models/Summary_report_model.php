<?php

class Summary_report_Model extends CI_Model {

    
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

    
    

    function getSummarySales($params = array()) {
        $this->db->select('sum(s.tot_amt) total_amount,sum(paid_amt) total_paid,sum(due_amt) total_due');
        $this->db->from('sales s');
        if (!empty($params['store_id'])) {
            $this->db->where('s.store_id', $params['store_id']);
        }
        if (!empty($params['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['FromDate']);
            $this->db->where("s.dtt_add <=", $params['ToDate']);
        }
        $this->db->where('s.status_id', 1);
        $this->db->order_by('s.id_sale', 'desc');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }  
    function getSummarySaleReturns($params = array()) {
        $this->db->select('sum(s.tot_amt) total_amount,sum(paid_amt) total_paid,sum(due_amt) total_due');
        $this->db->from('sale_adjustments s');
        if (!empty($params['store_id'])) {
            $this->db->where('s.store_id', $params['store_id']);
        }
        if (!empty($params['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['FromDate']);
            $this->db->where("s.dtt_add <=", $params['ToDate']);
        }
        $this->db->where('s.status_id', 1);
        $this->db->order_by('s.id_sale_adjustment', 'desc');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    } 
    public function getSummarySuppliers($params = array())
    {
        $this->db->select("sum(t.tot_amount) total_amount,p.type_name,t.trx_mvt_type_id", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_mvt_types AS p', 'p.id_transaction_mvt_type = t.trx_mvt_type_id');
        $this->db->where("t.trx_with", 'supplier');
        $this->db->where("t.status_id", 1);
        if (!empty($params['store_id'])) {
            $this->db->where('t.store_id', $params['store_id']);
        }
        if (!empty($params['FromDate'])) {
            $this->db->where("t.dtt_trx >=", $params['FromDate']);
            $this->db->where("t.dtt_trx <=", $params['ToDate']);
        }
        $this->db->order_by("t.id_transaction DESC");
        $this->db->group_by("t.trx_mvt_type_id");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function getSummaryOffice($params = array())
    {
        $this->db->select("sum(t.tot_amount) total_amount,t.qty_multiplier", FALSE);
        $this->db->from("transactions AS t");
        $this->db->where("t.trx_with", 'office');
        $this->db->where("t.status_id", 1);
        if (!empty($params['store_id'])) {
            $this->db->where('t.store_id', $params['store_id']);
        }
        if (!empty($params['FromDate'])) {
            $this->db->where("t.dtt_trx >=", $params['FromDate']);
            $this->db->where("t.dtt_trx <=", $params['ToDate']);
        }
        $this->db->order_by("t.id_transaction DESC");
        $this->db->group_by("t.qty_multiplier");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function getSummaryEmployee($params = array())
    {
        $this->db->select("sum(t.tot_amount) total_amount,t.qty_multiplier", FALSE);
        $this->db->from("transactions AS t");
        $this->db->where("t.trx_with", 'employee');
        $this->db->where("t.status_id", 1);
        if (!empty($params['store_id'])) {
            $this->db->where('t.store_id', $params['store_id']);
        }
        if (!empty($params['FromDate'])) {
            $this->db->where("t.dtt_trx >=", $params['FromDate']);
            $this->db->where("t.dtt_trx <=", $params['ToDate']);
        }
        $this->db->order_by("t.id_transaction DESC");
        $this->db->group_by("t.qty_multiplier");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function getSummaryInvestor($params = array())
    {
        $this->db->select("sum(t.tot_amount) total_amount,t.qty_multiplier", FALSE);
        $this->db->from("transactions AS t");
        $this->db->where("t.trx_with", 'investor');
        $this->db->where("t.status_id", 1);
        if (!empty($params['store_id'])) {
            $this->db->where('t.store_id', $params['store_id']);
        }
        if (!empty($params['FromDate'])) {
            $this->db->where("t.dtt_trx >=", $params['FromDate']);
            $this->db->where("t.dtt_trx <=", $params['ToDate']);
        }
        $this->db->order_by("t.id_transaction DESC");
        $this->db->group_by("t.qty_multiplier");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function getSaleDetails($params = array()) {
        $this->db->select('s.*,c.full_name as customer_name,st.name as station_name,u.fullname as user_name,ct.name as customer_type');
        $this->db->from('sales s');
        $this->db->join('customers c','s.customer_id = c.id_customer','left');
        $this->db->join('customer_types ct','c.customer_type_id = ct.id_customer_type','left');
        $this->db->join('stations st','s.station_id = st.id_station','left');
        $this->db->join('users u','s.uid_add = u.id_user');
        if (!empty($params['store_id'])) {
            $this->db->where('s.store_id', $params['store_id']);
        }
        if (!empty($params['f_date'])) {
            $this->db->where("s.dtt_add >=", $params['f_date'].' 00:00:00');
            $this->db->where("s.dtt_add <=", $params['t_date'].' 23:59:59');
        }
        $this->db->where('s.status_id', 1);
        $this->db->order_by('s.id_sale', 'desc');
        $this->db->group_by('s.invoice_no');
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function getSaleReturnDetails($params = array()) {
        $this->db->select('s.*,c.full_name as customer_name,st.name as station_name,u.fullname as user_name,ct.name as customer_type');
        $this->db->from('sale_adjustments s');
        $this->db->join('customers c','s.customer_id = c.id_customer','left');
        $this->db->join('customer_types ct','c.customer_type_id = ct.id_customer_type','left');
        $this->db->join('stations st','s.station_id = st.id_station','left');
        $this->db->join('users u','s.uid_add = u.id_user');
        if (!empty($params['store_id'])) {
            $this->db->where('s.store_id', $params['store_id']);
        }
        if (!empty($params['f_date'])) {
            $this->db->where("s.dtt_add >=", $params['f_date'].' 00:00:00');
            $this->db->where("s.dtt_add <=", $params['t_date'].' 23:59:59');
        }
        $this->db->where('s.status_id', 1);
        $this->db->order_by('s.id_sale_adjustment', 'desc');
        $this->db->group_by('s.invoice_no');
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function getSupplierDetails($params = array()) {
        $this->db->select("
            t.id_transaction AS id
          , t.trx_no
          , s.supplier_name AS supplier_name
          , p.type_name
          , sum(t.tot_amount) tot_amount
          , t.trx_mvt_type_id
          , t.qty_multiplier
          , DATE(t.dtt_trx) AS transaction_date
          , t.description
          , t.store_id
          ", FALSE);
        // , CONCAT(s.supplier_code, ': ', s.supplier_name) AS supplier_name
        $this->db->from("transactions AS t");
        $this->db->join('transaction_mvt_types AS p', 'p.id_transaction_mvt_type = t.trx_mvt_type_id');
        $this->db->join('suppliers AS s', 's.id_supplier = t.ref_id');
        $this->db->where("t.trx_with", 'supplier');
        $this->db->where("t.status_id", 1);
        if (!empty($params['store_id'])) {
            $this->db->where('t.store_id', $params['store_id']);
        }
        if (!empty($params['f_date'])) {
            $this->db->where("t.dtt_trx >=", $params['f_date'].' 00:00:00');
            $this->db->where("t.dtt_trx <=", $params['t_date'].' 23:59:59');
        }
        $this->db->where("t.trx_mvt_type_id", $params['name']);
        $this->db->group_by("t.trx_no");
        $this->db->order_by("t.id_transaction DESC");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function getOfficeDetails($params = array()) {
        $this->db->select("
            t.id_transaction AS id
          , t.trx_no
          , t.tot_amount
          , t.qty_multiplier
          , DATE(t.dtt_trx) AS transaction_date
          , t.description
          ,tt.trx_name
          ,tts.trx_name sub_trx_name
          ", FALSE);
        // , CONCAT(s.supplier_code, ': ', s.supplier_name) AS supplier_name
        $this->db->from("transactions AS t");
        $this->db->join('transaction_categories AS tt', 'tt.id_transaction_category = t.ref_id','left');   
        $this->db->join('transaction_categories AS tts', 'tts.id_transaction_category = tt.parent_id','left'); 
        $this->db->where("t.trx_with", 'office');
        $this->db->where("t.status_id", 1);
        if (!empty($params['store_id'])) {
            $this->db->where('t.store_id', $params['store_id']);
        }
        if (!empty($params['f_date'])) {
            $this->db->where("t.dtt_trx >=", $params['f_date'].' 00:00:00');
            $this->db->where("t.dtt_trx <=", $params['t_date'].' 23:59:59');
        }
        $this->db->where("t.qty_multiplier", $params['name']);
        $this->db->group_by("t.trx_no");
        $this->db->order_by("t.id_transaction DESC");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function getEmployeeDetails($params = array()) {
        $this->db->select("
            t.id_transaction AS id
          , t.trx_no
          , u.fullname AS emp_name
          , tt.trx_name
          , t.tot_amount
          , t.qty_multiplier
          , DATE(t.dtt_trx) AS transaction_date
          , t.description
          ", FALSE);
        // , CONCAT(s.supplier_code, ': ', s.supplier_name) AS supplier_name
        $this->db->from("transactions AS t");
        $this->db->join('transaction_details d', 'd.transaction_id = t.id_transaction');
        $this->db->join('transaction_types AS tt', 'tt.id_transaction_type = d.ref_id');
        $this->db->join('users AS u', 'u.id_user = t.ref_id');
        $this->db->where("t.trx_with", 'employee');
        $this->db->where("t.status_id", 1);
        if (!empty($params['store_id'])) {
            $this->db->where('t.store_id', $params['store_id']);
        }
        if (!empty($params['f_date'])) {
            $this->db->where("t.dtt_trx >=", $params['f_date'].' 00:00:00');
            $this->db->where("t.dtt_trx <=", $params['t_date'].' 23:59:59');
        }
        $this->db->where("t.qty_multiplier", $params['name']);
        $this->db->group_by("t.trx_no");
        $this->db->order_by("t.id_transaction DESC");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    
    function getInvestorDetails($params = array()) {
        $this->db->select("
            t.id_transaction AS id
          , t.trx_no
          , u.fullname AS trx_name
          , t.tot_amount
          , t.qty_multiplier
          , DATE(t.dtt_trx) AS transaction_date
          , t.description
          ", FALSE);
        // , CONCAT(s.supplier_code, ': ', s.supplier_name) AS supplier_name
        $this->db->from("transactions AS t");
        $this->db->join('users AS u', 'u.id_user = t.ref_id');
        $this->db->where("t.trx_with", 'investor');
        $this->db->where("t.status_id", 1);
        if (!empty($params['store_id'])) {
            $this->db->where('t.store_id', $params['store_id']);
        }
        if (!empty($params['f_date'])) {
            $this->db->where("t.dtt_trx >=", $params['f_date'].' 00:00:00');
            $this->db->where("t.dtt_trx <=", $params['t_date'].' 23:59:59');
        }
        $this->db->where("t.qty_multiplier", $params['name']);
        $this->db->group_by("t.trx_no");
        $this->db->order_by("t.id_transaction DESC");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }


}

