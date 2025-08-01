<?php

class Supplier_transaction_report_model extends CI_Model {

    
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
    public function get_payment_details($trx_no) {
        // $this->db->select('stp.amount,stp.account_id,st.trx_no,s.invoice_no,a.account_name,a.account_no');
        $this->db->select('t.tot_amount,t.trx_no,pr.invoice_no');
        $this->db->from('transactions t');
        //$this->db->join('sale_transaction_payments stp','st.id_sale_transaction= stp.sale_transaction_id');
        $this->db->join('transaction_details td', 't.id_transaction=td.transaction_id');
        $this->db->join('purchase_receives pr', 't.ref_id=pr.supplier_id');
        // $this->db->join('accounts a', 'stp.account_id= a.id_account');
        $this->db->where('t.trx_no', $trx_no);
        $query = $this->db->get();
        // echo  $this->db->last_query();
         if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
        // return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        //return $query->row();
    }
    public function get_method_details($trx_no) {
        $this->db->select("t.tot_amount,t.account_id,a.account_name, IFNULL(a.account_no, '') AS account_no");
        // $this->db->select('st.tot_amount,st.trx_no,s.invoice_no');
        $this->db->from('transactions t');
        $this->db->join('purchase_receives pr','t.ref_id=pr.supplier_id');
        $this->db->join('accounts a', 't.account_id= a.id_account');
        $this->db->where('t.trx_no', $trx_no);
        $query = $this->db->get();
        // echo  $this->db->last_query();
         if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
        // return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        //return $query->row();
    }

     public function get_invoice_details($invoice_id) {
        $this->db->select('*');
        $this->db->from('sale_details sd');
        $this->db->join('sales s','sd.sale_id = s.id_sale');
        $this->db->where('sd.sale_id', $invoice_id);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        //return $query->row();
    }

     function getRowsProducts($params = array()) {
        $this->db->select('t.trx_no,t.trx_with,t.account_id,pr.invoice_no,t.ref_id,t.tot_amount, t.dtt_trx,t.store_id,sp.supplier_name,st.store_name,ac.account_no');
        $this->db->from('transactions t');
		$this->db->join('transaction_details trd', 'trd.transaction_id = t.id_transaction');
        $this->db->join('purchase_receives pr', 'pr.id_purchase_receive = trd.ref_id');
        $this->db->join('suppliers sp', 't.ref_id= sp.id_supplier');
        $this->db->join('stores st', 't.store_id= st.id_store');
        $this->db->join('accounts ac', 't.account_id= ac.id_account');
        if (!empty($params['search']['store_id'])) {

            $this->db->where('t.store_id', $params['search']['store_id']);
        }
         else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['transaction_no'])) {
            $this->db->where('t.trx_no', $params['search']['transaction_no']);
        }
        if (!empty($params['search']['invoice_no'])) {
            $this->db->where('pr.invoice_no', $params['search']['invoice_no']);
        }
       if (!empty($params['search']['supplier_id'])) {

            $this->db->where('t.ref_id', $params['search']['supplier_id']);
        }
         if (!empty($params['search']['FromDate'])) {
            $this->db->where("t.dtt_trx >=", $params['search']['FromDate']);
            $this->db->where("t.dtt_trx <=", $params['search']['ToDate']);
        }
       
        $this->db->where('t.status_id', 1);
		$this->db->where('t.trx_with','supplier');
        $this->db->group_by('t.trx_no','desc');
        $query = $this->db->get();
          // echo  $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }


    public function max_value($table, $value) {
        $this->db->select_max($value);
        $result = $this->db->get($table);
        return (int) $result->row()->$value;
    }
   
    
}

