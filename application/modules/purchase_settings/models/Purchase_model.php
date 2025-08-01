<?php

class Purchase_Model extends CI_Model
{

    public function common_insert($tablename, $data)
    {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
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

    public function getvalue_row_one($tbl, $fn, $fcon = array())
    {
        $this->db->select($fn);
        $this->db->where($fcon);
        $q = $this->db->get($tbl);
        if ($q->num_rows() > 0) {
            $res = $q->result_array();
            return $res;
        }
        return false;
    }

    public function get_product_autocomplete($request)
    {
        $this->db->select("product_name, id_product,sell_price,vat,product_code");
        $this->db->from("products");
        $this->db->like("product_name", $request);
        $this->db->or_like("product_code", $request);
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    function getRowsProducts($params = array())
    {
        $this->db->select('id_product,product_code,product_name,sell_price,buy_price');
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
            $this->db->group_start();
            $this->db->like('product_name', $params['search']['product_name']);
            $this->db->or_like('product_code', $params['search']['product_name']);
            $this->db->group_end();
        }
        $this->db->order_by('id_product', 'desc');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function delete_data($tblname, $convalue = array())
    {
        $this->db->where($convalue);
        $update = $this->db->delete($tblname);
        if ($update) {
            return true;
        }
        return false;
    }

    public function version_update($tblname, $setvalue, $convalue = array())
    {
        $this->db->where($convalue);
        $this->db->set($setvalue, "IFNULL(`$setvalue`,0)+1", FALSE);
        $update = $this->db->update($tblname);
        if ($update) {
            return true;
        }
        return false;
    }

    public function version_delete($tblname, $setvalue, $convalue = array())
    {
        $this->db->where($convalue);
        $this->db->set($setvalue, "$setvalue-1", FALSE);
        $update = $this->db->update($tblname);
        if ($update) {
            return true;
        }
        return false;
    }

    public function getRowsRequisitions($params = array())
    {
        $this->db->select('*');
        $this->db->from('purchase_requisition_view');
        if (!empty($params['search']['store_name'])) {
            $this->db->like('store_name', $params['search']['store_name']);
        }
        if (!empty($params['search']['user_name'])) {
            $this->db->like("fullname", $params['search']['user_name']);
        }
        if (!empty($params['search']['product_name'])) {
            $this->db->group_start();
            $this->db->like('product_name', $params['search']['product_name']);
            $this->db->or_like('product_code', $params['search']['product_name']);
            $this->db->group_end();
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('store_id', $this->session->userdata['login_info']['store_id']);
        }
        $this->db->where('status_id', 1);
        $this->db->order_by('id_purchase_requisition', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function getRowsRequisition_order($store_id = null)
    {
        $this->db->select('product_id,product_code,product_name,id_purchase_requisition,sum(qty) as qty,buy_price');
        $this->db->from('purchase_requisition_view');
        $this->db->where('store_id', $store_id);
        $this->db->where('status_id', 1);
        $this->db->group_by('product_id');
        $this->db->order_by('id_purchase_requisition', 'desc');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function getRowsOrderList($params = array())
    {
        $this->db->select('*');
        $this->db->from('purchase_order_view');
        if (!empty($params['search']['store_name'])) {
            $this->db->like('store_name', $params['search']['store_name']);
        }
        if (!empty($params['search']['supplier_name'])) {
            $this->db->like("supplier_name", $params['search']['supplier_name']);
        }
        if (!empty($params['search']['invoice_no'])) {
            $this->db->like('invoice_no', $params['search']['invoice_no']);
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('store_id', $this->session->userdata['login_info']['store_id']);
        }
       // $this->db->where('status_id', 1);
        $this->db->order_by('id_purchase_order', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function order_details($id)
    {
       // $this->db->select('a.qty,a.unit_amt,a.tot_amt,a.id_purchase_order_detail,b.*,d.supplier_name, GROUP_CONCAT(pa.p_attribute_id SEPARATOR ",") AS attribute_id, GROUP_CONCAT(pa.s_attribute_name SEPARATOR ",") AS attribute_name, GROUP_CONCAT(pa.s_attribute_value SEPARATOR ",") AS attribute_value');
        $this->db->select("a.qty,a.unit_amt,a.tot_amt,a.id_purchase_order_detail,b.*,d.supplier_name, c.invoice_no,s.store_name,c.dtt_add,GROUP_CONCAT(DISTINCT CONCAT(at.s_attribute_name,'=',at.s_attribute_value) SEPARATOR ',') AS attribute_name");
        $this->db->from('purchase_order_details a');
        $this->db->join('products b', 'a.product_id = b.id_product', 'left');
        $this->db->join('purchase_orders c', 'c.id_purchase_order = a.purchase_order_id', 'left');
        $this->db->join('suppliers d', 'c.supplier_id = d.id_supplier', 'left');
        $this->db->join('stores s', 'c.store_id = s.id_store', 'left');
        $this->db->join('purchase_attributes at', 'a.id_purchase_order_detail=at.order_details_id', 'left');
        $this->db->where('a.purchase_order_id', $id);
        // $this->db->where('c.status_id', 1);
        $this->db->where('b.status_id', 1);
        $this->db->group_by('a.id_purchase_order_detail');
        $query = $this->db->get();
        // $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function receive_details($id)
    {
        $this->db->select("a.qty,a.purchase_price,a.purchase_order_detail_id,b.*,stk.batch_no, at.attribute_name");
        $this->db->from('purchase_receive_details a');
        $this->db->join('products b', 'a.product_id = b.id_product', 'left');
        $this->db->join('stocks stk', 'a.id_purchase_receive_detail=stk.stock_mvt_detail_id and a.purchase_receive_id = stk.stock_mvt_id and stk.stock_mvt_type_id=1');
        $this->db->join('vw_stock_attr at', 'stk.id_stock=at.stock_id', 'left');
        $this->db->where('a.purchase_receive_id', $id);
        $this->db->where('b.status_id', 1);
        $this->db->group_by('a.id_purchase_receive_detail');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function get_stocks_reason($id)
    {
        $this->db->select("id_stock_mvt_reason, reason");
        $this->db->from("stock_mvt_reasons");
        $this->db->where("mvt_type_id", $id);
        $this->db->or_where("qty_multiplier", "0");
        $this->db->order_by("id_stock_mvt_reason", "ASC");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function getRowsReceiveList($params = array())
    {
        $this->db->select('*');
        $this->db->from('purchase_receive_view');
        if (!empty($params['search']['store_name'])) {
            $this->db->like('store_name', $params['search']['store_name']);
        }
        if (!empty($params['search']['supplier_name'])) {
            $this->db->like("supplier_name", $params['search']['supplier_name']);
        }
        if (!empty($params['search']['invoice_no'])) {
            $this->db->like('invoice_no', $params['search']['invoice_no']);
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('store_id', $this->session->userdata['login_info']['store_id']);
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

    public function get_doc_file($id)
    {
        $this->db->select('b.id_document,b.file,a.dtt_receive,a.notes,a.invoice_no,s.store_name,sp.supplier_name');
        $this->db->from('purchase_receives a');
        $this->db->join('documents b', 'b.ref_id = a.id_purchase_receive', 'left');
        $this->db->join('stores s', 'a.store_id = s.id_store', 'left');
        $this->db->join('suppliers sp', 'a.supplier_id = sp.id_supplier', 'left');
        $this->db->where('a.id_purchase_receive', $id);
        //$this->db->where('doc_type','Purchase Receive');
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }

}

