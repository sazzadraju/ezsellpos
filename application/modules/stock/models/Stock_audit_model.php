<?php

class Stock_Audit_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    ///new
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


    function getRowsProducts($params = array())
    {
        $this->db->select('id_product,product_code,product_name,sell_price');
        $this->db->from('products');
        if (!empty($params['search']['cat_name'])) {
            $this->db->where('cat_id', $params['search']['cat_name']);
        }
        if (!empty($params['search']['sub_category'])) {
            $this->db->where('subcat_id', $params['search']['sub_category']);
        }
        if (!empty($params['search']['brand'])) {
            $this->db->where("brand_id", $params['search']['brand']);
        }
        $this->db->where('status_id', 1);
        if (!empty($params['search']['product_name'])) {
            $this->db->where('id_product', $params['search']['product_name']);
        }
        $this->db->order_by('id_product', 'desc');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function search_stock_in_product($product_id, $store_id)
    {
        $this->db->select("stocks.id_stock, stocks.batch_no, stocks.product_id,stocks.purchase_price,stocks.qty, products.product_code, products.product_name");
        $this->db->from("stocks");
        $this->db->join('products', 'products.id_product = stocks.product_id', 'INNER');
        $this->db->where("stocks.product_id", $product_id);
        $this->db->where("stocks.store_id", $store_id);
        $this->db->where("stocks.status_id", 1);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function get_product_barcode($data = array())
    {
        $this->db->select("s.id_stock, p.product_name, s.product_id,s.purchase_price,s.qty,s.batch_no,p.product_code, pc.cat_name, psc.cat_name as sub_cat_name, brand.brand_name");
        $this->db->from("stocks s");
        $this->db->join('products p', 'p.id_product = s.product_id', 'RIGHT');
        $this->db->join('product_categories pc', 'pc.id_product_category = p.cat_id', 'LEFT');
        $this->db->join('product_categories psc', 'psc.id_product_category = p.subcat_id', 'LEFT');
        $this->db->join('product_brands brand', 'brand.id_product_brand = p.brand_id', 'LEFT');
        if (isset($data['store_id'])) {
            $this->db->where("s.store_id", $data['store_id']);
        }
        if (isset($data['id_product'])) {
            $this->db->where("p.id_product", $data['id_product']);
        }
        if (isset($data['batch_no'])) {
            $this->db->where("s.batch_no", $data['batch_no']);
        }
        $this->db->where("p.status_id", 1);
        $this->db->where("s.status_id", 1);
        $this->db->group_by('p.product_name');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    /////new

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


    public function get_product($request, $store)
    {
        $this->db->select("stocks.id_stock, products.product_name, products.id_product, products.buy_price, products.sell_price, products.is_vatable");
        $this->db->from("stocks");
        $this->db->join('products', 'products.id_product = stocks.product_id', 'RIGHT');
        $this->db->group_start();
        $this->db->like("products.product_name", $request);
        $this->db->or_like("products.product_code", $request);
        $this->db->group_end();
        $this->db->where("stocks.store_id", $store);
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


    function stock_audit_details($stock_audit_id)
    {

        $this->db->select('s.*, pc.cat_name, psc.cat_name as sub_cat_name, brand.brand_name, stocks.purchase_price');
        $this->db->from('stock_audit_details_view s');
        $this->db->join('products p', 'p.id_product = s.id_product', 'LEFT');
        $this->db->join('product_categories pc', 'pc.id_product_category = p.cat_id', 'LEFT');
        $this->db->join('product_categories psc', 'psc.id_product_category = p.subcat_id', 'LEFT');
        $this->db->join('product_brands brand', 'brand.id_product_brand = p.brand_id', 'LEFT');
        $this->db->join('stocks', 'stocks.id_stock = s.id_stock', 'LEFT');
        $this->db->where('id_stock_audit', $stock_audit_id);
        $query = $this->db->get();

        $res = $query->result_array();

        return $res;

    }

    function stock_audit_info($stock_audit_id)
    {
        $this->db->select('*');
        $this->db->from('stock_audits');
        $this->db->where('id_stock_audit', $stock_audit_id);
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }

    public function get_doc_file($stock_audit_id)
    {
        $this->db->select('file');
        $this->db->from('documents');
        $this->db->where('ref_id', $stock_audit_id);
        $this->db->where('doc_type', 'Stock Audit');
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }

    function stock_audit_list($params = array())
    {
        $this->db->select('id_stock_audit,audit_no, dtt_audit, audit_by, status_id');
        $this->db->from('stock_audits');

        if (!empty($params['search']['audit_no'])) {
            $this->db->where('audit_no', $params['search']['audit_no']);
        }

        if (!empty($params['search']['from_date'])) {
            $from_date = $params['search']['from_date'] . ' 00:00:00';
            $this->db->where('dtt_audit >=', $from_date);
        }

        if (!empty($params['search']['to_date'])) {
            $to_date = $params['search']['to_date'] . ' 23:59:59';
            $this->db->where('dtt_audit <=', $to_date);
        }
        if (!empty($params['search']['store_name'])) {
            $store_name = $params['search']['store_name'];
            $this->db->where('store_id', $store_name);
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('store_id', $this->session->userdata['login_info']['store_id']);
        }

        $this->db->where('store_id =', $this->session->userdata['login_info']['store_id']);
        $this->db->order_by('id_stock_audit', 'desc');
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

    public function get_audit_users($user_id)
    {
        $this->db->select("GROUP_CONCAT(fullname SEPARATOR ', ') AS fullname", false);
        $this->db->from("users");
        $this->db->where_in("id_user", $user_id, false);
        $query = $this->db->get();
        $res = $query->row_array();
        return isset($res['fullname']) ? $res['fullname'] : '';
    }

    function getRowsReason($params = array())
    {
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
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function check_value($table, $column, $value)
    {
        $tot = $this->db
            ->where($column, $value)
            ->where('status_id', 1)
            ->count_all_results($table);

        return $tot > 0 ? TRUE : FALSE;
    }
    public function get_reason_by_id($id)
    {
        $this->db->from('stock_mvt_reasons');
        $this->db->where('id_stock_mvt_reason', $id);
        $this->db->where('status_id', 1);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_qty_from_mvt_types($id)
    {
        $this->db->select('qty_multiplier');
        $this->db->from('stock_mvt_types');
        $this->db->where('id_stock_mvt_type', $id);
        $this->db->where('is_active', 1);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_stocks_reason()
    {
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
