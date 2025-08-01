<?php

class Purchase_report_details_model extends CI_Model {

    public function common_insert($tablename, $data) {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

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
        $this->db->select('pr.*,sr.supplier_name,st.store_name');
        $this->db->from('purchase_receives pr');
        $this->db->join('purchase_receive_details prd', 'pr.id_purchase_receive= prd.id_purchase_receive_detail');
        $this->db->join('products p', 'prd.product_id= p.id_product');
        $this->db->join('stores st', 'prd.store_id= st.id_store');
        $this->db->join('suppliers sr', 'pr.supplier_id= sr.id_supplier');
        if (!empty($params['search']['invoice_no'])) {
            $this->db->or_like('pr.invoice_no', $params['search']['invoice_no']);
        }
        if (!empty($params['search']['store_id'])) {

            $this->db->where('pr.store_id', $params['search']['store_id']);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('pr.store_id', $this->session->userdata['login_info']['store_id']);
        }
         if (!empty($params['search']['supplier_id'])) {

            $this->db->where('pr.supplier_id', $params['search']['supplier_id']);
        }
         if (!empty($params['search']['FromDate'])) {
            $this->db->where("pr.dtt_receive >=", $params['search']['FromDate']);
            $this->db->where("pr.dtt_receive <=", $params['search']['ToDate']);
        }
        $this->db->where('pr.status_id', 1);
        $this->db->order_by('pr.id_purchase_receive', 'desc');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    

    public function order_details($id) {
        $this->db->select('a.qty,a.unit_amt,a.tot_amt,a.id_purchase_order_detail,b.*');
        $this->db->from('purchase_order_details a');
        $this->db->join('products b', 'a.product_id = b.id_product', 'left');
        $this->db->where('a.purchase_order_id', $id);
        $this->db->where('b.status_id', 1);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function receive_details($id) {
        $this->db->select('a.qty,a.purchase_price,a.purchase_order_detail_id,b.*');
        $this->db->from('purchase_receive_details a');
        $this->db->join('products b', 'a.product_id = b.id_product', 'left');
        $this->db->where('a.purchase_receive_id', $id);
        $this->db->where('b.status_id', 1);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function get_stocks_reason() {
        $this->db->select("id_stock_mvt_reason, reason");
        $this->db->from("stock_mvt_reasons");
        $this->db->where("mvt_type_id", "12");
        $this->db->or_where("qty_multiplier", "0");
        $this->db->order_by("id_stock_mvt_reason", "ASC");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
     public function getRowsReceiveList($params = array()) {
        $this->db->select('*');
        $this->db->from('purchase_receive_view');
        if (!empty($params['search']['store_name'])) {
            $this->db->like('store_name', $params['search']['store_name']);
        }
         else if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
            $this->db->where('store_name', 3);
        }
        if (!empty($params['search']['supplier_name'])) {
            $this->db->like("supplier_name", $params['search']['supplier_name']);
        }
        if (!empty($params['search']['invoice_no'])) {
            $this->db->like('invoice_no', $params['search']['invoice_no']);
        }
        $this->db->where('status_id', 1);
        $this->db->order_by('id_purchase_receive', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function get_doc_file($id){
        $this->db->select('b.id_document,b.file,a.dtt_receive,a.notes,a.invoice_no');
        $this->db->from('purchase_receives a');
        $this->db->join('documents b', 'b.ref_id = a.id_purchase_receive', 'left');
        $this->db->where('a.id_purchase_receive',$id);
        $this->db->where('doc_type','Purchase Receive');
        $query = $this->db->get();
        // $res = $query->row_array();
         return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        // return $res;
    }

     public function get_invoice_details($invoice_id) {
        $this->db->select('*');
        $this->db->from('purchase_receive_details prd');
        $this->db->join('purchase_receives pr','prd.purchase_receive_id = pr.id_purchase_receive');
        $this->db->where('prd.purchase_receive_id', $invoice_id);
        $this->db->join('products p', 'prd.product_id= p.id_product');
        $this->db->join('stores st', 'prd.store_id= st.id_store');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        //return $query->row();
    }

}

