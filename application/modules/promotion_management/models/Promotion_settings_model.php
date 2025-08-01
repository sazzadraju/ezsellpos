<?php

class Promotion_Settings_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

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
    public function getvalue_row_array($tbl, $fn, $fcon = array()) {
        $this->db->select($fn);
        $this->db->where($fcon);
        $query = $this->db->get($tbl);
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
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

    public function get_cat_list() {
        $this->db->select("id_product_category, cat_name");
        $this->db->from("product_categories");
        $this->db->where("status_id", 1);
        $this->db->where("parent_cat_id", null);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_sub_cat_list($cat_id) {
        $this->db->select("id_product_category, cat_name");
        $this->db->from("product_categories");
        $this->db->where("status_id", 1);
        $this->db->where("parent_cat_id", $cat_id);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_cat_by_id($id_product_category) {
        $this->db->select("id_product_category, cat_name, parent_cat_id");
        $this->db->from("product_categories");
        $this->db->where("status_id", 1);
        $this->db->where("id_product_category", $id_product_category);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }


    public function get_brand_list() {
        $this->db->select("id_product_brand, brand_name");
        $this->db->from("product_brands");
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }


    function all_promotion_list($params = array()) {
        $this->db->select('a.id_promotion, a.title, a.details, a.type_id, a.is_brand, a.is_category, a.is_product, a.dt_from, a.dt_to, a.status_id, GROUP_CONCAT(c.store_name) AS store_name');
        $this->db->from('promotions a');
        $this->db->join('promotion_stores b', "b.promotion_id = a.id_promotion", 'LEFT');
        $this->db->join('stores c', "b.store_id = c.id_store", 'LEFT');
        if (!empty($params['search']['title'])) {
            $this->db->or_like('a.title', $params['search']['title']);
        }

        if (!empty($params['search']['type_id'])) {
            $this->db->where('a.type_id', $params['search']['type_id']);
        }
        if (!empty($params['search']['store_name'])) {
           $this->db->where('b.store_id',$params['search']['store_name']);
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('b.store_id', $this->session->userdata['login_info']['store_id']);
        }

        $this->db->where('a.status_id !=', '2');
        $this->db->order_by('a.id_promotion', 'desc');
        $this->db->group_by('a.id_promotion');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }


        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        //exit();
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

    function promotion_details_data($promotion_id) {
        $this->db->select('promotions.id_promotion, promotions.title, promotions.details, promotions.type_id, promotions.is_customer_type, promotions.is_brand, promotions.is_category, promotions.is_product, promotions.dt_from, promotions.dt_to, promotion_details.customer_type_id, promotion_details.min_purchase_amt, promotion_details.payment_type, promotion_details.discount_rate, promotion_details.discount_amount, product_categories.cat_name, products.product_name, product_brands.brand_name,psc.cat_name as subcat_name');
        $this->db->from('promotions');
        $this->db->join('promotion_details', 'promotion_details.promotion_id = promotions.id_promotion', 'LEFT');
        $this->db->join('product_categories', 'product_categories.id_product_category = promotion_details.cat_id', 'LEFT');
        $this->db->join('product_categories psc', 'psc.id_product_category = promotion_details.subcat_id', 'LEFT');
        $this->db->join('products', 'products.id_product = promotion_details.product_id', 'LEFT');
        $this->db->join('product_brands', 'product_brands.id_product_brand = promotion_details.brand_id', 'LEFT');
        $this->db->where('promotions.id_promotion', $promotion_id);
        //$this->db->where('promotions.status_id', 1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $res = $query->result_array();
        return $res;
    }

    function promotion_row_details($promotion_id) {
        $this->db->select('promotions.id_promotion, promotions.title, promotions.details, promotions.type_id, promotions.is_customer_type, promotions.is_brand, promotions.is_category, promotions.is_product, promotions.dt_from, promotions.dt_to, promotion_details.customer_type_id, promotion_details.min_purchase_amt, promotion_details.payment_type, promotion_details.discount_rate, promotion_details.discount_amount, promotion_details.brand_id, promotion_details.cat_id, promotion_details.subcat_id, d1.cat_name as cat_name, d2.cat_name as sub_cat_name, d2.parent_cat_id, product_brands.brand_name');
        $this->db->from('promotions');
        $this->db->join('promotion_details', 'promotion_details.promotion_id = promotions.id_promotion', 'LEFT');
        $this->db->join('product_categories as d1', 'd1.id_product_category = promotion_details.cat_id', 'LEFT');
        $this->db->join('product_categories as d2', 'd2.id_product_category = promotion_details.subcat_id', 'LEFT');
        $this->db->join('product_brands', 'product_brands.id_product_brand = promotion_details.brand_id', 'LEFT');
        // $this->db->join('product_brands', 'product_brands.id_product_brand = promotion_details.brand_id', 'LEFT');
        $this->db->where('promotions.id_promotion', $promotion_id);
        //$this->db->where('promotions.status_id', 1);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    public function edit_promotion_store($promotion_id) {
        $this->db->select("a.id_promotion,GROUP_CONCAT(b.`store_id`) AS store_id");
        $this->db->from("promotions a");
        $this->db->join('promotion_stores b', 'b.promotion_id = a.id_promotion', 'LEFT');
        $this->db->where("a.id_promotion",$promotion_id);
        $this->db->group_by("a.id_promotion");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }


    public function get_brands_list($brand) {
        $this->db->select("id_product_brand, brand_name");
        $this->db->from("product_brands");
        $this->db->where_in("id_product_brand", $brand, false);
        $this->db->order_by("id_product_brand", "ASC");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function promotion_check($user_id){
        $sql = "UPDATE promotions p
                SET p.status_id = 0
                , dtt_mod = '".date('Y-m-d H:i:s')."'
                , uid_mod = $user_id
                WHERE p.dt_to < '".date('Y-m-d')."'
                AND p.status_id = 1";
        //die($sql);
        $query = $this->db->query($sql);
        return $query;
    }
    public function get_product_by_cart($cat=0,$sub_cat=0,$brand=0,$store_name=0,$product=''){
        $this->db->select('p.*,stk.purchase_price,sum(stk.qty) qty,s.store_name, stk.store_id, stk.batch_no, stk.selling_price_act');
        $this->db->from('products p');
        $this->db->join('stocks stk', "stk.product_id = p.id_product");
        $this->db->join('stores s', "s.id_store = stk.store_id");
        if($cat!=0){
            $this->db->where('p.cat_id', $cat);
        }
        if($sub_cat!=0){
            $this->db->where('p.subcat_id', $sub_cat);
        }
        if($brand!=0){
            $this->db->where('p.brand_id', $brand);
        }
        if($product!=''){
            $this->db->like('p.product_name', $product);
        }
        // if($store_name!=0){
        //     $store=explode(',',$store_name);
        //     if(count($store)>1){
        //         $this->db->where_in('stk.store_id', $store_name,false);
        //     }else{
        //         $this->db->where('stk.store_id', $store_name);
        //     }
            
        // }
        $this->db->where('p.status_id', '1');
        $this->db->order_by('p.id_product', 'desc');
        //$this->db->group_by('p.id_product,stk.store_id,stk.batch_no');
        $this->db->group_by('p.id_product');
        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        //exit();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function promotion_product_list($promo_id=0){
        $this->db->select('pd.*,s.store_name,p.id_product,p.product_name,p.product_code,sum(stk.qty) qty,stk.purchase_price, pd.batch_no, stk.selling_price_act');
        $this->db->from('promotion_details pd');
        $this->db->join('products p', 'p.id_product = pd.product_id');
        $this->db->join('stocks stk', "stk.product_id = p.id_product and stk.store_id=pd.store_id");
        $this->db->join('stores s', "s.id_store = stk.store_id");
         $this->db->where('pd.promotion_id =', $promo_id);
        $this->db->where('p.status_id =', '1');
        //$this->db->group_by('pd.id_promotion_detail');
        $this->db->group_by('pd.product_id');
        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        //exit();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function promotion_product_details_list($promo_id=0){
        $this->db->select('pd.*,s.store_name,p.id_product,p.product_name,p.product_code,sum(stk.qty) qty,stk.purchase_price, pd.batch_no, stk.selling_price_act');
        $this->db->from('promotion_details pd');
        $this->db->join('products p', 'p.id_product = pd.product_id');
        $this->db->join('stocks stk', "stk.product_id = p.id_product and stk.store_id=pd.store_id");
        $this->db->join('stores s', "s.id_store = stk.store_id");
         $this->db->where('pd.promotion_id =', $promo_id);
        $this->db->where('p.status_id =', '1');
        $this->db->group_by('pd.id_promotion_detail');
        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        //exit();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

}

?>