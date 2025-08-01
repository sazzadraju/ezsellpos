<?php

class Stock_In_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function common_insert($tablename, $data) {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
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

    public function common_update($tablename, $data, $column_name, $column_id, $version = true) {
        $this->db->where($column_name, $column_id);
        if ($version) {
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

    public function check_customer_address_type($customer_id, $address_type) {
        $this->db->select("address_type");
        $this->db->from("customer_addresss");
        $this->db->where("customer_id", "$customer_id");
        $this->db->where("address_type", "$address_type");
        $query = $this->db->get();
        $res = $query->row_array();
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

    public function get_product($request) {
        $this->db->select("product_name, id_product, buy_price, sell_price, is_vatable, product_code");
        $this->db->from("products");
        $this->db->group_start();
        $this->db->like("product_name", $request);
        $this->db->or_like("product_code", $request);
        $this->db->group_end();
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function get_available_stock_in_products($request, $storeid) {
        $this->db->select("s.id_stock, s.batch_no, s.product_id, s.dtt_add,  p.product_name, p.buy_price, p.sell_price, p.is_vatable, p.product_code");
        $this->db->from("stocks s");
        $this->db->join('products p', 's.product_id = p.id_product', 'left');
        $this->db->group_start();
        $this->db->like("p.product_name", $request);
        $this->db->or_like("p.product_code", $request);
        $this->db->group_end();
        $this->db->where("p.status_id", 1);
        $this->db->where("s.store_id", $storeid);
        $this->db->where('s.qty >', 0);
        $this->db->group_by('s.product_id');
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function get_supplier($request) {
        $this->db->select("id_supplier, supplier_name");
        $this->db->from("suppliers");
        $this->db->like("supplier_name", $request);
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    function stock_in_details_list($stock_in_id) {
        $this->db->select('*,at.attribute_name');
        $this->db->from('stock_details_view');
        $this->db->join('vw_stock_attr at','stock_details_view.id_stock=at.stock_id','left');
        $this->db->where('id_stock_mvt', $stock_in_id);
        $this->db->where('stock_mvt_type_id =', '12');
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    function store_name_by_stock_id($id){
        $this->db->select('st.store_name');
        $this->db->from('stock_mvts sm');
        $this->db->join('stores st', 'st.id_store = sm.store_id');
        $this->db->where('sm.id_stock_mvt', $id);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_doc_file($stock_in_id){
        $this->db->select('id_document,file');
        $this->db->from('documents');
        $this->db->where('ref_id',$stock_in_id);
        $this->db->where('doc_type','Stock');
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }


    function stock_in_list($params = array()) {
        $this->db->select('users.fullname as  user_name,stock_mvts.id_stock_mvt,stock_mvts.notes, stock_mvts.dtt_stock_mvt, stock_mvts.invoice_no, documents.id_document, documents.file,stores.store_name');
        $this->db->from('stock_mvts');
        $this->db->join('documents', 'documents.ref_id = stock_mvts.id_stock_mvt', 'LEFT');
        $this->db->join('stores', 'stores.id_store = stock_mvts.store_id', 'LEFT');
        $this->db->join('users', 'users.id_user = stock_mvts.uid_add', 'LEFT');
        if (!empty($params['search']['invoice_number'])) {
            $this->db->where('stock_mvts.invoice_no', $params['search']['invoice_number']);
        }

        if (!empty($params['search']['from_date'])) {
            $from_date = $params['search']['from_date'].' 00:00:00';
            $this->db->where('stock_mvts.dtt_stock_mvt >=', $from_date);
        }

        if (!empty($params['search']['to_date'])) {
            $to_date = $params['search']['to_date'].' 23:59:59';
            $this->db->where('stock_mvts.dtt_stock_mvt <=', $to_date);
        }
        if (!empty($params['search']['store_name'])) {
            $store_name = $params['search']['store_name'];
            $this->db->where('stock_mvts.store_id', $store_name);
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('stock_mvts.store_id', $this->session->userdata['login_info']['store_id']);
        }

        $this->db->group_by('stock_mvts.invoice_no');
        $this->db->where('stock_mvts.stock_mvt_type_id =', '12');
        $this->db->order_by('stock_mvts.id_stock_mvt', 'desc');
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function getRowsReason($params = array()) {
        $this->db->select('stock_mvt_reasons.*, stock_mvt_types.type_name');
        $this->db->where('status_id', 1);
        $this->db->from('stock_mvt_reasons');
        $this->db->join('stock_mvt_types', 'stock_mvt_types.id_stock_mvt_type = stock_mvt_reasons.mvt_type_id', 'LEFT');
        $this->db->order_by('stock_mvt_reasons.id_stock_mvt_reason', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->where("stock_mvt_reasons.status_id", 1);
        $this->db->where("stock_mvt_types.is_active", 1);
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function check_value($table, $column, $value) {
        $tot = $this->db
                ->where($column, $value)
                ->where('status_id', 1)
                ->count_all_results($table);

        return $tot > 0 ? TRUE : FALSE;
    }
    public function get_reason_by_id($id) {
        $this->db->from('stock_mvt_reasons');
        $this->db->where('id_stock_mvt_reason', $id);
        $this->db->where('status_id', 1);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_qty_from_mvt_types($id) {
        $this->db->select('qty_multiplier');
        $this->db->from('stock_mvt_types');
        $this->db->where('id_stock_mvt_type', $id);
        $this->db->where('is_active', 1);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_stocks_reason() {
        $this->db->select("id_stock_mvt_reason, reason");
        $this->db->from("stock_mvt_reasons");
        $this->db->group_start();
        $this->db->where("mvt_type_id", "12");
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

}
