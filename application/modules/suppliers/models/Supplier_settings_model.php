<?php

class Supplier_Settings_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // public function version_change(){
    //     $this->db->set('version', '`version+1`', FALSE);
    // }

    public function common_insert($tablename, $data) {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

    public function common_update($tablename, $data, $column_name, $column_id, $version = true) {
        $this->db->where($column_name, $column_id);
        if($version){
            $this->db->set('version', '`version`+1', FALSE);
        }
        $res = $this->db->update($tablename, $data);
        return $res;
    }

    public function common_delete($tablename, $column_name, $column_id) {
        $this->db->where($column_name, $column_id);
        $res = $this->db->delete($tablename);
        return $res;
    }

    public function common_cond_dropdown_data($tablename, $id_column, $value_column, $conditional_column, $conditional_value, $order_by, $asc_desc) {
        $this->db->select("$id_column,$value_column");
        $this->db->from("$tablename");
        $this->db->where("$conditional_column", "$conditional_value");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function common_single_value_array($tablename, $id_column, $value_column, $order_by, $asc_desc) {
        $this->db->select("$id_column,$value_column");
        $this->db->from("$tablename");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function common_cond_single_value_array($tablename, $id_column, $value_column, $conditional_column, $conditional_value, $order_by, $asc_desc) {
        $this->db->select("$id_column,$value_column");
        $this->db->from("$tablename");
        $this->db->where("$conditional_column", "$conditional_value");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function common_cond_row_array($tablename, $column_name, $value_column) {
        $this->db->select("*");
        $this->db->from("$tablename");
        $this->db->where("$column_name", "$value_column");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }


    public function common_result_array($tablename, $order_by, $asc_desc) {
        $this->db->select("*");
        $this->db->from("$tablename");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }


    function all_supplier_list($params = array()) {
        $this->db->select('*');
        $this->db->from('suppliers');
        if (!empty($params['search']['name_supplier'])) {
            $this->db->like('supplier_name', $params['search']['name_supplier']);
        }

        if (!empty($params['search']['phone_supplier'])) {
            $this->db->like('phone', $params['search']['phone_supplier']);
        }

        if (!empty($params['search']['email_supplier'])) {
            $this->db->like('email', $params['search']['email_supplier']);
        }

        if (!empty($params['search']['inactive_supplier'])) {
            $this->db->where('status_id !=', 1);
        }else{
            $this->db->where('status_id', 1);
        }
        $this->db->order_by('id_supplier', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
        //echo $this->db->last_query();
        //exit();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function get_store() {
        $this->db->select("*");
        $this->db->from("stores");
        $this->db->where("status_id", "1");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_supplier_store($supplier_id) {
        $this->db->select("*");
        $this->db->from("supplier_stores");
        //$this->db->join('supplier_stores', 'supplier_stores.supplier_id = suppliers.id_supplier', 'LEFT');
        $this->db->where("status_id", "1");
        $this->db->where("supplier_id", $supplier_id);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_supplier_store_for_checking($supplier_id) {
        $this->db->select("*");
        $this->db->from("supplier_stores");
        $this->db->where("supplier_id", $supplier_id);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_supplier_details($supplier_id) {
        $this->db->select("suppliers.*, GROUP_CONCAT(stores.store_name SEPARATOR ', ') AS stores");
        $this->db->from("suppliers");
        $this->db->join('supplier_stores', 'suppliers.id_supplier = supplier_stores.supplier_id', 'LEFT');
        $this->db->join('stores', 'supplier_stores.store_id = stores.id_store', 'LEFT');
        $this->db->where("suppliers.id_supplier", "$supplier_id");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_supplier_document_result($supplier_id) {
        $this->db->select("*");
        $this->db->from("documents");
        $this->db->where("doc_type", "Supplier");
        $this->db->where("ref_id", "$supplier_id");
        $this->db->where("status_id", "1");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_supplier_document_result_pagination($params = array()) {
        $this->db->select("*");
        $this->db->from("documents");
        if (!empty($params['search']['id_supplier'])) {
            $this->db->where('ref_id', $params['search']['id_supplier']);
        }
        $this->db->where("doc_type", "Supplier");
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_supplier_drop_down() {
        $this->db->select("id_supplier,supplier_name");
        $this->db->from("suppliers");
        $this->db->where("status_id", 1);
        $this->db->order_by("id_supplier", "DESC");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    function supplier_payment_alert_list($params = array()) {
        $this->db->select('supplier_payment_alerts.id_supplier_payment_alert,supplier_payment_alerts.amount,supplier_payment_alerts.dtt_notification,supplier_payment_alerts.dtt_payment_est,suppliers.supplier_name');
        $this->db->from('supplier_payment_alerts');
        $this->db->join('suppliers', 'suppliers.id_supplier = supplier_payment_alerts.supplier_id', 'LEFT');

        if (!empty($params['search']['name_supplier'])) {
            $this->db->where('supplier_payment_alerts.supplier_id', $params['search']['name_supplier']);
        }

        $this->db->where('supplier_payment_alerts.status_id =', '1');
        $this->db->where('suppliers.status_id =', '1');
        $this->db->order_by('supplier_payment_alerts.dtt_notification', 'ASC');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
        // echo $this->db->last_query();
        // exit();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }


    public function isExistExcept($table, $chk_column, $chk_value, $expt_column, $expt_value) {
        $tot = $this->db
            ->where($chk_column, $chk_value)
            ->where($expt_column.' !=', $expt_value)
            ->where('status_id', 1)
            ->count_all_results($table);
        
        return $tot>0 ? 1 : 0;
    }
    function supplier_current_balance($id=0){
        // $this->db->select("sum(trd.amount) as payment_amt");
        // $this->db->from('transaction_details  trd');
        // //$this->db->join('purchase_receives pr', 'pr.id_purchase_receive = trd.ref_id');
        // $this->db->join('transactions tr', "trd.transaction_id = tr.id_transaction and tr.trx_with ='supplier'");
        // $this->db->where('tr.ref_id', $id);
        // $this->db->where('tr.status_id', 1);
        // $this->db->group_by('trd.id_transaction_detail');
        // $query = $this->db->get();
        // //echo $this->db->last_query();
        // $transaction= ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        $this->db->select('sum(pr.tot_amt) tot_amt,sum(pr.paid_amt) paid_amt,sum(pr.due_amt) due_amt,sum(stl.due_amt) settle_amt',false);
        $this->db->from('purchase_receives pr');
        $this->db->join('purchase_receives stl', "stl.id_purchase_receive = pr.id_purchase_receive and stl.settle =1",'left');
        $this->db->where('pr.supplier_id', $id);
        $this->db->where('pr.status_id', 1);
        //$this->db->group_by('pr.id_purchase_receive');
        $query2 = $this->db->get();
        //echo $this->db->last_query();
        return ($query2->num_rows() > 0) ? $query2->result_array() : FALSE;
        // $payment_amt=($transaction)?$transaction[0]['payment_amt']:0;
        // $tot_amt=0;$paid_amt=0;$due_amt=0;$settle_amt=0;
        // if($purchase){
        //     $tot_amt=$purchase[0]['tot_amt'];
        //     $paid_amt=$purchase[0]['paid_amt'];
        //     $due_amt=$purchase[0]['due_amt'];
        //     $settle_amt=$purchase[0]['settle_amt'];
        // }
    }

}

?>