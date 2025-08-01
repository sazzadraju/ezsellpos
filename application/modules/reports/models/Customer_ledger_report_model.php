<?php

class Customer_ledger_report_model extends CI_Model {

    
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
    function getCustomerLedgerReport($params = array()) {
        $this->db->select('stp.`amount` AS payment_amt,stp.account_id,st.dtt_add,st.`customer_id`, (st.id_sale_transaction)=0 as`invoice_no`,(st.tot_amount)=0 AS invoice_total_amt');
        $this->db->from('sale_transactions st');
        $this->db->join('sale_transaction_payments stp','stp.sale_transaction_id = st.id_sale_transaction');
        if (!empty($params['search']['store_id'])) {
            $this->db->where('st.store_id', $params['search']['store_id']);
        }
          if (!empty($params['search']['customer_id'])) {
            $this->db->where('st.customer_id', $params['search']['customer_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("st.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("st.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('st.status_id', 1);
        $query1 = $this->db->get_compiled_select();
        $this->db->select('s.tot_amt=0 as payment_amt,s.id_sale=0 as account_id, s.`dtt_add`,s.`customer_id`, s.`invoice_no`,s.`tot_amt` AS invoice_total_amt',false);
        $this->db->from('sales s');
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
        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1." UNION ".$query2);
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function getCustomerLedgerBalance($params = array()){
        if (!empty($params['search']['FromDate'])) {
            $prev_date = date('Y-m-d', strtotime($params['search']['FromDate'] .' -1 day'));
            $to_date=$prev_date. ' 23:59:59';
        }

        $this->db->select('sum(stp.`amount`) AS payment_amt');
        $this->db->from('sale_transaction_payments stp');
        $this->db->join('sale_transactions st','st.id_sale_transaction = stp.sale_transaction_id');
        if (!empty($params['search']['store_id'])) {
            $this->db->where('st.store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['customer_id'])) {
            $this->db->where('st.customer_id', $params['search']['customer_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("st.dtt_add <=", $to_date);
        }
        $this->db->where('st.status_id', 1);
        $query = $this->db->get();
        //echo '////////////'.$this->db->last_query();
        $result1= ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        $this->db->select('sum(s.`tot_amt`) AS invoice_total_amt');
        $this->db->from('sales s');
        if (!empty($params['search']['store_id'])) {
            $this->db->where('s.store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['customer_id'])) {
            $this->db->where('s.customer_id', $params['search']['customer_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_add <=", $to_date);
        }
        $this->db->where('s.status_id', 1);
        $query2 = $this->db->get();
        //echo '////////////'.$this->db->last_query();
        $result2= ($query2->num_rows() > 0) ? $query2->result_array() : FALSE;
        $data=array('total_invoice'=>$result2[0]['invoice_total_amt'],'total_payment'=>$result1[0]['payment_amt']);
        return $data;
    }
    function getSumsettleAmount($params = array()) {
        $this->db->select('sum(s.due_amt) AS total_settle');
        $this->db->from('sales s');
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
        $this->db->where('s.settle', 1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    
   
    

}

