<?php

class Supplier_ledger_report_model extends CI_Model
{


    public function getvalue_row($tbl, $fn, $fcon = array())
    {
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

    function getSupplierLedgerReport($params = array())
    {
        // $this->db->distinct('dtt_add');
        // $this->db->select("tr.tot_amount as payment_amt,tr.account_id,tr.dtt_add,pr.supplier_id, GROUP_CONCAT(DISTINCT pr.invoice_no SEPARATOR ',') AS invoice_no,(pr.`tot_amt`)=0 AS invoice_total_amt,tr.trx_mvt_type_id");
        // $this->db->from('transactions tr');
        // $this->db->join('transaction_details trd', 'trd.transaction_id = tr.id_transaction','left');
        // $this->db->join('purchase_receives pr', 'pr.id_purchase_receive = trd.ref_id','left');
        // if (!empty($params['search']['store_id'])) {
        //     $this->db->where('tr.store_id', $params['search']['store_id']);
        // }
        // if (!empty($params['search']['supplier_id'])) {
        //     $this->db->where('tr.ref_id', $params['search']['supplier_id']);
        // }
        // $this->db->where('tr.trx_with', 'supplier');
        // if (!empty($params['search']['FromDate'])) {
        //     $this->db->where("tr.dtt_add >=", $params['search']['FromDate']);
        //     $this->db->where("tr.dtt_add <=", $params['search']['ToDate']);
        // }
        // $this->db->where('tr.status_id', 1);
        // $this->db->group_by('tr.id_transaction');
        $this->db->select("tr.trx_no,trd.amount as payment_amt,tr.account_id,tr.dtt_add,pr.supplier_id, pr.invoice_no,(pr.`tot_amt`)=0 AS invoice_total_amt,tr.trx_mvt_type_id");
        $this->db->from('transaction_details  trd');
        $this->db->join('purchase_receives pr', 'pr.id_purchase_receive = trd.ref_id');
        $this->db->join('transactions tr', 'trd.transaction_id = tr.id_transaction');
        
        if (!empty($params['search']['store_id'])) {
            $this->db->where('tr.store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['supplier_id'])) {
            $this->db->where('tr.ref_id', $params['search']['supplier_id']);
        }
        $this->db->where('tr.trx_with', 'supplier');
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("tr.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("tr.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('tr.status_id', 1);
        $this->db->group_by('trd.id_transaction_detail');
        //$this->db->order_by('tr.dtt_add', 'asc');
        //$query = $this->db->get();
        //echo $this->db->last_query();
        //return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        $query1 = $this->db->get_compiled_select();
        $this->db->select('0 as trx_no,pr.tot_amt=0 as payment_amt,pr.id_purchase_receive=0 as account_id, pr.`dtt_add`,pr.`supplier_id`, pr.`invoice_no`,pr.`tot_amt` AS invoice_total_amt,0 as trx_mvt_type_id',false);
        $this->db->from('purchase_receives pr');
        if (!empty($params['search']['store_id'])) {
            $this->db->where('pr.store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['supplier_id'])) {
            $this->db->where('pr.supplier_id', $params['search']['supplier_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("pr.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("pr.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('pr.status_id', 1);
        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1." UNION ".$query2);
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function getSupplierLedgerBalance(){
        if (!empty($params['search']['FromDate'])) {
            $prev_date = date('Y-m-d', strtotime($params['search']['FromDate'] .' -1 day'));
            $to_date=$prev_date. ' 23:59:59';
        }

        $this->db->select('sum(tot_amount) AS payment_amt');
        $this->db->from('transactions');
        if (!empty($params['search']['store_id'])) {
            $this->db->where('store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['supplier_id'])) {
            $this->db->where('ref_id', $params['search']['supplier_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("dtt_add <=", $to_date);
        }
        $this->db->where('status_id', 1);
        $this->db->where('trx_with', 'supplier');
        $query = $this->db->get();
        $result1= ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        $this->db->select('sum(tot_amt) AS invoice_total_amt');
        $this->db->from('purchase_receives');
        if (!empty($params['search']['store_id'])) {
            $this->db->where('store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['supplier_id'])) {
            $this->db->where('supplier_id', $params['search']['supplier_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("dtt_add <=", $to_date);
        }
        $this->db->where('status_id', 1);
        $query2 = $this->db->get();
        $result2= ($query2->num_rows() > 0) ? $query2->result_array() : FALSE;
        $data=array('total_invoice'=>$result2[0]['invoice_total_amt'],'total_payment'=>$result1[0]['payment_amt']);
        return $data;
    }
    function getSumsettleAmount($params = array()) {
        $this->db->select('sum(due_amt) AS total_settle');
        $this->db->from('purchase_receives');
        if (!empty($params['search']['store_id'])) {
            $this->db->where('store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['supplier_id'])) {
            $this->db->where('supplier_id', $params['search']['supplier_id']);
        }
        if (!empty($params['search']['FromDate'])) {
           $this->db->where("dtt_add >=", $params['search']['FromDate']);
            $this->db->where("dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('status_id', 1);
        $this->db->where('settle', 1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function get_type_name($id){
        $this->db->select('type_name');
        $this->db->from('transactions tr');
        $this->db->join('transaction_mvt_types tt', 'tt.id_transaction_mvt_type = tr.trx_mvt_type_id');
        $this->db->where('tr.trx_no', $id);
        $this->db->where('tr.trx_mvt_type_id', '106');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }



}

