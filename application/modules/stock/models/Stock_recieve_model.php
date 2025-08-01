<?php

class Stock_Recieve_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    public function common_insert($tablename, $data) {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

    public function common_update($tablename, $data, $column_name, $column_id, $version = true) {
        $this->db->where($column_name, $column_id);
        if ($version) {
            $this->db->set('version', '`version`+1', FALSE);
        }
        $res = $this->db->update($tablename, $data);
        return $res;
    }

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

    public function general_update($tablename, $data, $column_name, $column_id) {
        $this->db->where($column_name, $column_id);
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

    public function common_cond_row_array($tablename, $column_name, $value_column)
    {
        $this->db->select("*");
        $this->db->from("$tablename");
        $this->db->where("$column_name", "$value_column");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function check_customer_address_type($customer_id, $address_type) {
        $this->db->select("address_type");
        $this->db->from("customer_addresss");
        $this->db->where("customer_id", "$customer_id");
        $this->db->where("address_type", "$address_type");
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }

    public function common_result_array($tablename, $order_by, $asc_desc)
    {
        $this->db->select("*");
        $this->db->from("$tablename");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_doc_file($stock_mvt_id){
        $this->db->select('id_document,file');
        $this->db->from('documents');
        $this->db->where('ref_id', $stock_mvt_id);
        $this->db->where('doc_type', 'Stock');
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }


    public function get_product($request)
    {
        $this->db->select("stocks.id_stock, products.product_name, products.id_product, products.buy_price, products.sell_price, products.is_vatable, products.vat");
        $this->db->from("stocks");
        $this->db->join('products', 'products.id_product = stocks.product_id', 'RIGHT');
        $this->db->group_start();
        $this->db->like("products.product_name", $request);
        $this->db->or_like("products.product_code", $request);
        $this->db->group_end();
        $this->db->where("products.status_id", 1);
        $this->db->where("stocks.status_id", 1);
        $this->db->group_by('products.product_name');
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function get_supplier($request){
        $this->db->select("id_supplier, supplier_name");
        $this->db->from("suppliers");
        $this->db->like("supplier_name", $request);
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    function stock_transfer_list($params = array()) {
        $this->db->select('r.id_stock_mvt, r.ref_id, r.store_id as to_store, r.dtt_stock_mvt as recieve_date,r.status_id, r.notes, r.invoice_no as recieve_invoice, s.id_stock_mvt as stock_mvt_id, s.invoice_no as transfer_invoice, s.dtt_stock_mvt as transfer_date,s.store_id as from_store');
        $this->db->from('stock_mvts as r');
        $this->db->join('stock_mvts as s', 's.id_stock_mvt = r.ref_id', 'LEFT');
        if (!empty($params['search']['invoice_number'])) {
            $this->db->where('r.invoice_no', $params['search']['invoice_number']);
        }

        if (!empty($params['search']['from_date'])) {
            $from_date = $params['search']['from_date'] . ' 00:00:00';
            $this->db->where('r.dtt_stock_mvt >=', $from_date);
        }

        if (!empty($params['search']['to_date'])) {
            $to_date = $params['search']['to_date'] . ' 23:59:59';
            $this->db->where('r.dtt_stock_mvt <=', $to_date);
        }
        if (!empty($params['search']['store_name'])) {
            $store_name = $params['search']['store_name'];
            $this->db->where('r.store_id', $store_name);
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('r.store_id', $this->session->userdata['login_info']['store_id']);
        }
        //$this->db->where('r.status_id =', '0');
        $this->db->where('r.stock_mvt_type_id =', '8');
        $this->db->where('r.store_id =', $this->session->userdata['login_info']['store_id']);
        $this->db->order_by('r.dtt_stock_mvt', 'desc');
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        // exit();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function stock_transfer_details($stock_mvt_id)
    {
        $this->db->select("stock_mvt_details.id_stock_mvt_detail,stock_mvt_details.stock_mvt_id,stock_mvt_details.batch_no, stock_mvt_details.product_id, stock_mvt_details.supplier_id, stock_mvt_details.qty, stock_mvt_details.purchase_price, stock_mvt_details.selling_price_est, stock_mvt_details.vat_rate, stock_mvt_details.expire_date, stock_mvt_details.alert_date,products.product_name, products.product_code,suppliers.supplier_name, stock_mvts.invoice_no, stock_mvts.id_stock_mvt, stock_mvts.status_id,at.attribute_name,at.attribute_ids");
        $this->db->from("stock_mvt_details");
        $this->db->join('suppliers', 'suppliers.id_supplier = stock_mvt_details.supplier_id', 'LEFT');
        $this->db->join('products', 'products.id_product = stock_mvt_details.product_id', 'LEFT');
       // $this->db->join('stock_mvts', 'stock_mvts.id_stock_mvt = stock_mvt_details.stock_mvt_id', 'LEFT');
        $this->db->join('stock_mvts', 'stock_mvts.ref_id = stock_mvt_details.stock_mvt_id', 'LEFT');
        $this->db->join('stocks stk', 'stock_mvt_details.batch_no=stk.batch_no and stock_mvt_details.product_id=stk.product_id','LEFT');
        $this->db->join('vw_stock_attr at', 'stk.id_stock=at.stock_id', 'LEFT');
        $this->db->where("stock_mvt_details.stock_mvt_id", "$stock_mvt_id");
        $this->db->where("stock_mvt_details.status_id", "1");
        $this->db->group_by('stock_mvt_details.id_stock_mvt_detail');
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function stock_request_details($stock_mvt_id){
        $this->db->select("stock_mvt_details.id_stock_mvt_detail,stock_mvt_details.stock_mvt_id,stock_mvt_details.batch_no, stock_mvt_details.product_id, stock_mvt_details.supplier_id, stock_mvt_details.qty, stock_mvt_details.purchase_price, stock_mvt_details.selling_price_est, stock_mvt_details.vat_rate, stock_mvt_details.expire_date, stock_mvt_details.alert_date,products.product_name, products.product_code,suppliers.supplier_name, stock_mvts.dtt_stock_mvt, stock_mvts.invoice_no, stock_mvts.ref_id, stock_mvts.notes, stock_mvts.status_id,at.attribute_name");
        $this->db->from("stock_mvt_details");
        $this->db->join('suppliers', 'suppliers.id_supplier = stock_mvt_details.supplier_id', 'LEFT');
        $this->db->join('products', 'products.id_product = stock_mvt_details.product_id', 'LEFT');
        $this->db->join('stock_mvts', 'stock_mvts.ref_id = stock_mvt_details.stock_mvt_id', 'LEFT');
        $this->db->join('stocks stk', 'stock_mvt_details.batch_no=stk.batch_no and stock_mvt_details.product_id=stk.product_id','LEFT');
        $this->db->join('vw_stock_attr at', 'stk.id_stock=at.stock_id', 'LEFT');
        $this->db->where("stock_mvts.id_stock_mvt", "$stock_mvt_id");
        $this->db->where("stock_mvt_details.status_id", "1");
        $this->db->group_by('stock_mvt_details.id_stock_mvt_detail');
        $query = $this->db->get();
        // echo $this->db->last_query();
        // exit();
        $res = $query->result_array();
        return $res;
    }
//    public function stock_request_details($stock_mvt_id)
//    {
//        $this->db->select("id_stock_mvt_detail,id_stock_mvt as stock_mvt_id,batch_no, product_id, supplier_id, qty, purchase_price,selling_price_est,expire_date,alert_date,product_name,supplier_name,dtt_stock_mvt,invoice_no,notes");
//        $this->db->from("stock_details_view");
//        $this->db->where("id_stock_mvt", "$stock_mvt_id");
//        $query = $this->db->get();
//        // echo $this->db->last_query();
//        // exit();
//        $res = $query->result_array();
//        return $res;
//    }

    public function get_batch_list_by_product($product_id) {
        $this->db->select("id_stock, batch_no");
        $this->db->from("stocks");
        $this->db->where("product_id", "$product_id");
        $this->db->where("qty != ", "0");
        $this->db->order_by("id_stock", "ASC");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function stocks_details($stock_id) {
        $this->db->select("stocks.id_stock, stocks.product_id, stocks.supplier_id, stocks.rack_id, stocks.batch_no, stocks.qty, stocks.purchase_price, stocks.selling_price_est, stocks.selling_price_act, stocks.vat_rate, stocks.expire_date, stocks.store_id, stocks.alert_date, suppliers.supplier_name, racks.name,p.product_code");
        $this->db->from("stocks");
        $this->db->join('suppliers', 'suppliers.id_supplier = stocks.supplier_id', 'LEFT');
        $this->db->join('products p', 'p.id_product = stocks.product_id', 'LEFT');
        $this->db->join('racks', 'racks.id_rack = stocks.rack_id', 'LEFT');
        $this->db->where("id_stock", "$stock_id");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_stocks_reason() {
        $this->db->select("id_stock_mvt_reason, reason");
        $this->db->from("stock_mvt_reasons");
        $this->db->group_start();
        $this->db->where("mvt_type_id", "8");
        $this->db->or_where("qty_multiplier", "0");
        $this->db->group_end();
        $this->db->where("status_id", "1");
        $this->db->order_by("id_stock_mvt_reason", "ASC");
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

    public function get_stores() {
        $this->db->select("id_store,store_name");
        $this->db->from("stores");
        $this->db->where("status_id", 1);
        $this->db->where("id_store !=", $this->session->userdata['login_info']['store_id']);
        $this->db->order_by("id_store", "ASC");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    function stock_transfer_stores($stock_transfer_id) {
        $this->db->select('fs.store_name to_store ,ts.store_name from_store');
        $this->db->from('stock_details_view std');
        $this->db->join('stock_mvts sm', 'sm.ref_id= std.id_stock_mvt', 'LEFT');
        $this->db->join('stores ts', 'ts.id_store= std.store_id');
        $this->db->join('stores fs', 'fs.id_store= sm.store_id');
        $this->db->where('std.id_stock_mvt', $stock_transfer_id);
        $this->db->where('std.stock_mvt_type_id =', '7');
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }



}

?>