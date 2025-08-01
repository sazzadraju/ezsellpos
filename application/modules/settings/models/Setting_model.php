<?php

class Setting_Model extends CI_Model {

    public function common_insert($tablename, $data) {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

    public function update_value($tblname, $setvalue = array(), $convalue = array(), $version = true) {
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
    public function subscription_check()
    {
        $data = array();
        $this->db->select("param_key, param_val");
        $this->db->from('configs');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach($result as $res){

            if($res['param_key']=='INVOICE_SETUP'){
                $data[$res['param_key']] = $res['param_val'].'&&'.$res['utilized_val'];
            }else{
                $data[$res['param_key']] = $res['param_val'];
            }
        }
        return $data;
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

    public function all_brands() {
        $this->db->select("*");
        $this->db->from('product_brands');
        $this->db->order_by("id_product_brand", "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    function getRowsbrands($params = array()) {
        $this->db->select('*');
        $this->db->where('status_id', 1);
        $this->db->from('product_brands');
        $this->db->order_by('id_product_brand', 'desc');
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

    public function get_brand_by_id($id) {
        $this->db->from('product_brands');
        $this->db->where('id_product_brand', $id);
        $query = $this->db->get();

        return $query->row();
    }

    function delete_by_brand($id = null) {
        $this->db->where('id_product_brand', $id);
        $this->db->delete('product_brands');
    }

    function getRowsCategories($params = array()) {
        $this->db->select('*');
        $this->db->from('product_categories');
        if (!empty($params['search']['cat_name'])) {
            $this->db->like('cat_name', $params['search']['cat_name']);
        }
        $this->db->where('status_id', 1);
        $this->db->order_by('id_product_category', 'desc');
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

    public function get_category_by_id($id) {
        $this->db->from('product_categories');
        $this->db->where('id_product_category', $id);
        $query = $this->db->get();

        return $query->row();
    }

    function getRowsProducts($params = array()) {
        $this->db->select('*');
        $this->db->from('products');
        if (!empty($params['search']['product_name'])) {
            $this->db->or_like('product_name', $params['search']['product_name']);
            $this->db->or_like('product_code', $params['search']['product_name']);
        }
        if (!empty($params['search']['cat_name'])) {
            $this->db->where('cat_id', $params['search']['cat_name']);
        }
        if (!empty($params['search']['pro_sub_category'])) {
            $this->db->where('subcat_id', $params['search']['pro_sub_category']);
        }
        if (!empty($params['search']['pro_price_from'])) {
            $this->db->where("sell_price >=", $params['search']['pro_price_from']);
            $this->db->where("sell_price <=", $params['search']['pro_price_to']);
        }
        $this->db->where('status_id', 1);
        $this->db->order_by('id_product', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function get_product_by_id($id) {
        $this->db->from('products');
        $this->db->where('id_product', $id);
        $query = $this->db->get();

        return $query->row();
    }

    function getRowsUnits($params = array()) {
        $this->db->select('*');
        $this->db->from('product_units');
        $this->db->where('status_id', 1);
        $this->db->order_by('id_product_unit', 'desc');
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

    public function get_unit_by_id($id) {
        $this->db->from('product_units');
        $this->db->where('id_product_unit', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_product_details_by_id($id) {
        $this->db->select('a.*,b.cat_name,c.brand_name as brands,d.unit_code as unit_name, e.cat_name as sub_category ');
        $this->db->from('products a');
        $this->db->join('product_categories b', 'b.id_product_category=a.cat_id', 'left');
        $this->db->join('product_brands c', 'c.id_product_brand=a.brand_id', 'left');
        $this->db->join('product_units d', 'd.id_product_unit=a.unit_id', 'left');
        $this->db->join('product_categories e', 'e.id_product_category=a.subcat_id', 'left');
        $this->db->where('a.id_product', $id);
        $this->db->order_by('a.id_product', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->row();
//            foreach ($query->result() as $row) {
//                $data[] = $row;
//            }
//            return $data;
        } else {
            return false;
        }
    }
    
    public function get_supplier_by_product_id($id) {
        $this->db->select('c.supplier_name');
        $this->db->from('products a');
        $this->db->join('products_suppliers b', 'b.porduct_id=a.id_product', 'left');
        $this->db->join('suppliers c', 'c.id_supplier=b.supplier_id', 'left');
        $this->db->where('a.id_product', $id);
        $this->db->where('a.status_id',1);
        $this->db->order_by('a.id_product', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            //return $query->result_array();
            return $query->result_array();
        } else {
            return false;
        }
    }

    function isProductExist($code) {
        $this->db->select('id_product');
        $this->db->where('product_code', $code);
        $query = $this->db->get('products');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function suppliers() {
        $this->db->select("*");
        $this->db->from("suppliers");
        $this->db->where("status_id", "1");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_product_supplier($id) {
        $this->db->select("*");
        $this->db->from("products_suppliers");
        $this->db->where("status_id", "1");
        $this->db->where("porduct_id", $id);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function check_value($table, $column, $value) {
        $tot = $this->db
                ->where($column, $value)
                ->where('status_id', 1)
                ->count_all_results($table);

        return $tot > 0 ? TRUE : FALSE;
    }
    public function delete_data($tblname, $convalue = array()) {
        $this->db->where($convalue);
        $update = $this->db->delete($tblname);
        if ($update) {
            return true;
        }
        return false;
    }

}

?>