<?php

class Supplier_Return_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    public function common_insert($tablename, $data)
    {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

    public function common_update($tablename, $data, $column_name, $column_id, $version = true)
    {
        $this->db->where($column_name, $column_id);
        if ($version) {
            $this->db->set('version', '`version`+1', FALSE);
        }
        $res = $this->db->update($tablename, $data);
        return $res;
    }

    public function common_delete($tablename, $column_name, $column_id)
    {
        $this->db->where($column_name, $column_id);
        $res = $this->db->delete($tablename);
        return $res;
    }

    public function common_cond_dropdown_data($tablename, $id_column, $value_column, $conditional_column, $conditional_value, $order_by, $asc_desc)
    {
        $this->db->select("$id_column,$value_column");
        $this->db->from("$tablename");
        $this->db->where("$conditional_column", "$conditional_value");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function update_value($tblname, $setvalue = array(), $convalue = array(), $version = true)
    {
        $this->sql = '';
        $this->key = '';
        $this->value = '';
        $this->key = array_keys($convalue);
        $this->value = array_values($convalue);
        for ($i = 0; $i < count($convalue); $i++) {
            $this->db->where($this->key[$i], $this->value[$i]);
        }
        if ($version) {
            $this->db->set('version', '`version`+1', FALSE);
        }
        $update = $this->db->update($tblname, $setvalue);
        if ($update) {
            return true;
        }
        return false;
    }

    public function common_single_value_array($tablename, $id_column, $value_column, $order_by, $asc_desc)
    {
        $this->db->select("$id_column,$value_column");
        $this->db->from("$tablename");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function common_cond_single_value_array($tablename, $id_column, $value_column, $conditional_column, $conditional_value, $order_by, $asc_desc)
    {
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

    public function check_customer_address_type($customer_id, $address_type)
    {
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


    public function get_product($request)
    {
        $this->db->select("stocks.id_stock, products.product_name, products.id_product, products.buy_price, products.sell_price, products.is_vatable, products.vat");
        $this->db->from("stocks");
        $this->db->join('products', 'products.id_product = stocks.product_id', 'RIGHT');
        $this->db->like("products.product_name", $request);
        $this->db->or_like("products.product_code", $request);
        $this->db->where("products.status_id", 1);
        $this->db->where("stocks.status_id", 1);
        $this->db->group_by('products.product_name');
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function get_supplier($request)
    {
        $this->db->select("id_supplier, supplier_name");
        $this->db->from("suppliers");
        $this->db->like("supplier_name", $request);
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }


    function stock_out_details_list($stock_out_id)
    {
        $this->db->select('*');
        $this->db->from('stock_details_view');
        $this->db->where('id_stock_mvt', $stock_out_id);
        $this->db->where('stock_mvt_type_id =', '13');
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_doc_file($stock_out_id)
    {
        $this->db->select('id_document,file');
        $this->db->from('documents');
        $this->db->where('ref_id', $stock_out_id);
        $this->db->where('doc_type', 'Stock');
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }

    function supplier_return_list($params = array())
    {
        $this->db->select('supplier_returns.*,documents.file,suppliers.supplier_name');
        $this->db->from('supplier_returns');
        $this->db->join('documents', "documents.ref_id = supplier_returns.id_supplier_return and documents.doc_type= 'Supplier Return'", 'LEFT');
        $this->db->join('suppliers', 'supplier_returns.supplier_id = suppliers.id_supplier', 'left');
        if (!empty($params['search']['invoice_number'])) {
            $this->db->where('supplier_returns.invoice_no', $params['search']['invoice_number']);
        }

        if (!empty($params['search']['from_date'])) {
            $from_date = $params['search']['from_date'] . ' 00:00:00';
            $this->db->where('supplier_returns.dtt_add >=', $from_date);
        }

        if (!empty($params['search']['to_date'])) {
            $to_date = $params['search']['to_date'] . ' 23:59:59';
            $this->db->where('supplier_returns.dtt_add <=', $to_date);
        }
        $this->db->order_by('supplier_returns.id_supplier_return', 'desc');
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function supplier_return_details_by_id($id)
    {
        $this->db->select('a.*,b.product_name,b.product_code');
        $this->db->from('supplier_return_details a');
        $this->db->join('products b', "b.id_product = a.product_id", 'LEFT');
        $this->db->where('supplier_return_id', $id);
        $this->db->order_by('id_supplier_return_detail', 'desc');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }


    public function get_purchase_products($invoice)
    {
        $this->db->select('c.product_name,a.product_id,a.id_purchase_receive_detail,a.purchase_receive_id,a.supplier_id,d.supplier_name,a.qty,a.purchase_price,a.selling_price_act,sum(e.qty) as stock_qty,e.id_stock,e.batch_no');
        $this->db->from('purchase_receive_details a');
        $this->db->join('purchase_receives b', "a.purchase_receive_id  = b.id_purchase_receive", 'LEFT');
        $this->db->join('products c', "a.product_id  = c.id_product", 'LEFT');
        $this->db->join('suppliers d', "a.supplier_id  = d.id_supplier", 'LEFT');
        $this->db->join('stocks e', "a.id_purchase_receive_detail  = e.stock_mvt_detail_id and e.stock_mvt_type_id=1", 'LEFT');

        $this->db->where('b.invoice_no', $invoice);
        $this->db->order_by('a.purchase_receive_id', 'desc');
        $this->db->group_by('a.id_purchase_receive_detail');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function get_batch_list_by_product($product_id, $supplier_id)
    {
        $this->db->select("id_stock, batch_no, stock_mvt_id");
        $this->db->from("stocks");
        //$this->db->where("stock_mvt_type_id", 1);
        $this->db->where("product_id", "$product_id");
        $this->db->where("supplier_id", "$supplier_id");
        $this->db->where("qty != ", "0");
        $this->db->order_by("id_stock", "ASC");
        $this->db->group_by('batch_no');
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function stocks_details($stock_id)
    {
        $this->db->select("stocks.id_stock, stocks.product_id, stocks.supplier_id, stocks.rack_id, stocks.batch_no, stocks.qty, stocks.purchase_price, stocks.selling_price_est, stocks.selling_price_act, stocks.vat_rate, stocks.expire_date, stocks.store_id, stocks.alert_date, suppliers.supplier_name, racks.name");
        $this->db->from("stocks");
        $this->db->join('suppliers', 'suppliers.id_supplier = stocks.supplier_id', 'LEFT');
        $this->db->join('racks', 'racks.id_rack = stocks.rack_id', 'LEFT');
        $this->db->where("id_stock", "$stock_id");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_stocks_reason()
    {
        $this->db->select("id_stock_mvt_reason, reason");
        $this->db->from("stock_mvt_reasons");
        $this->db->where("mvt_type_id", "14");
        $this->db->or_where("qty_multiplier", "0");
        $this->db->order_by("id_stock_mvt_reason", "ASC");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_supplier_drop_down()
    {
        $this->db->select("id_supplier,supplier_name");
        $this->db->from("suppliers");
        $this->db->where("status_id", 1);
        $this->db->order_by("id_supplier", "DESC");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }


}

?>