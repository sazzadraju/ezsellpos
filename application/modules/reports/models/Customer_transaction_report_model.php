<?php

class Customer_transaction_report_model extends CI_Model {


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
        $this->db->select('std.amount as tot_amount,st.trx_no,s.invoice_no');
        $this->db->from('sale_transactions st');
        //$this->db->join('sale_transaction_payments stp','st.id_sale_transaction= stp.sale_transaction_id');
        $this->db->join('sale_transaction_details std', 'st.id_sale_transaction= std.sale_transaction_id');
        $this->db->join('sales s', 'std.sale_id= s.id_sale');
        // $this->db->join('accounts a', 'stp.account_id= a.id_account');
        $this->db->where('st.trx_no', $trx_no);
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
        $this->db->select('stp.amount,stp.account_id,a.account_name,a.account_no');
        // $this->db->select('st.tot_amount,st.trx_no,s.invoice_no');
        $this->db->from('sale_transaction_payments stp');
        $this->db->join('sale_transactions st','st.id_sale_transaction= stp.sale_transaction_id');
        $this->db->join('sale_transaction_details std', 'st.id_sale_transaction= std.sale_transaction_id');
        $this->db->join('sales s', 'std.sale_id= s.id_sale');
        $this->db->join('accounts a', 'stp.account_id= a.id_account');
        $this->db->where('st.trx_no', $trx_no);
        $this->db->group_by('stp.sale_transaction_id');
        $query = $this->db->get();
        //echo  $this->db->last_query();
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
        $this->db->select('st.dtt_trx,st.trx_no,st.customer_id,st.store_id,st.tot_amount,std.sale_id,std.amount,stp.account_id,s.invoice_no,stp.amount as pamount');
        $this->db->from('sale_transactions st');
        $this->db->join('sale_transaction_details std', 'st.id_sale_transaction= std.sale_transaction_id');
        $this->db->join('sale_transaction_payments stp', 'st.id_sale_transaction= stp.sale_transaction_id');
        $this->db->join('sales s', 'std.sale_id= s.id_sale');
        if (!empty($params['search']['store_id'])) {

            $this->db->where('st.store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['transaction_no'])) {
            $this->db->where('st.trx_no', $params['search']['transaction_no']);
        }
        if (!empty($params['search']['customer_id'])) {

            $this->db->where('st.customer_id', $params['search']['customer_id']);
        }
        if (!empty($params['search']['invoice_no'])) {

            $this->db->like('s.invoice_no', $params['search']['invoice_no']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("st.dtt_trx >=", $params['search']['FromDate']);
            $this->db->where("st.dtt_trx <=", $params['search']['ToDate']);
        }
        $this->db->where('st.status_id', 1);
        $this->db->group_by('st.trx_no','desc');
        $query = $this->db->get();
        //echo  $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

}

