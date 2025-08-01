<?php

class Stock_mismatch_report_model extends CI_Model {

    

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
   public function get_payment_details($inv_no) {
        // $this->db->select('stp.amount,stp.account_id,st.trx_no,s.invoice_no,a.account_name,a.account_no');
       $this->db->select('p.product_name,p.product_code,smm.qty,smd1.qty as sqty');
         $this->db->from('stock_mvt_mismatches smm');
        $this->db->join('stock_mvts sm1', 'sm1.id_stock_mvt=smm.stk_tx_snd_id');
        $this->db->join('stock_mvts sm2', 'sm2.id_stock_mvt=smm.stk_tx_snd_id');
        $this->db->join('stock_mvt_details smd1', 'smd1.stock_mvt_id=sm1.id_stock_mvt');
        $this->db->join('stock_mvt_details smd2', 'smd2.stock_mvt_id=sm1.id_stock_mvt');
        $this->db->join('products p','p.id_product = smd1.product_id');
        $this->db->where('sm1.invoice_no', $inv_no);
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

    function getRowsProducts($params = array()) {

        $this->db->select('`sms`.`dtt_add`, `sms`.`qty` AS mismatch_qty ,   `sm1`.`invoice_no` AS `from_invoice`, `st1`.`store_name` AS `from_store`, `sm2`.`invoice_no` AS `to_invoice`, `st2`.`store_name` AS `to_store` ,smd1.`qty` AS from_qty, smd2.`qty` AS to_qty');
        $this->db->from('stock_mvt_mismatches sms');
        $this->db->join('stock_mvts sm1', 'sm1.id_stock_mvt=sms.stk_tx_snd_id');
        $this->db->join('stock_mvts sm2', 'sm2.id_stock_mvt=sms.stk_tx_rcv_id');
        $this->db->join('stock_mvt_details smd1', 'smd1.id_stock_mvt_detail=sms.`stk_tx_snd_detail_id');
        $this->db->join('stock_mvt_details smd2', 'smd2.id_stock_mvt_detail=sms.`stk_tx_rcv_detail_id');
        $this->db->join('stores st1', 'sm1.store_id= st1.id_store');
        $this->db->join('stores st2', 'sm2.store_id= st2.id_store');

        if (!empty($params['search']['store_id'])) {
            $this->db->group_start();
            $this->db->like('sm1.store_id', $params['search']['store_id']);
            $this->db->or_like('sm2.store_id', $params['search']['store_id']);
            $this->db->group_end();
        }
         else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
             $this->db->group_start();
             $this->db->like('sm1.store_id', $this->session->userdata['login_info']['store_id']);
             $this->db->or_like('sm2.store_id', $this->session->userdata['login_info']['store_id']);
             $this->db->group_end();
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("sms.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("sms.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('sms.status_id', 1);
        // $this->db->where('m.stock_mvt_type_id',13);
    
         $this->db->group_by("sms.id_stock_mvt_mismatch");
        $query = $this->db->get();
         //echo  $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }

     public function get_invoice_details($invoice_id) {
        $this->db->select('*');
        $this->db->from('stock_mvt_details d');
        $this->db->join('stock_mvts m','m.id_stock_mvt = d.stock_mvt_id');
        $this->db->where('m.invoice_no', $invoice_id);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        //return $query->row();
    }

//    

    public function max_value($table, $value) {
        $this->db->select_max($value);
        $result = $this->db->get($table);
        return (int) $result->row()->$value;
    }

   

}

