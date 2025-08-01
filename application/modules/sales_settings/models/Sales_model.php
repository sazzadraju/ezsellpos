<?php

class Sales_Model extends CI_Model
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
    public function getTempProductNameBatch($data=array()){
        $this->db->select("st.batch_no");
        $this->db->from("stocks st");
        $this->db->join('products p', 'p.id_product = st.product_id AND p.status_id = 1');
        if($data['id_product']==''){
            $this->db->where("product_code", $data['product_name']);
        }else{
            $this->db->where("id_product", $data['id_product']);
        }
        $this->db->where("st.qty >",0);
        $this->db->where("st.store_id", $this->session->userdata['login_info']['store_id']);
        $this->db->group_by("st.batch_no,st.product_id,st.store_id");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function getTempProductName($data=array()){
        $this->db->select("st.store_id,st.id_stock,st.batch_no,sum(st.qty) total_qty,st.selling_price_est,st.discount_amt,p.id_product,p.product_code,p.product_name,p.is_vatable,p.brand_id,p.cat_id,p.subcat_id");
        $this->db->from("stocks st");
        $this->db->join('products p', 'p.id_product = st.product_id AND p.status_id = 1');
        if($data['id_product']==''){
            $this->db->where("p.product_code", $data['product_name']);
        }else{
            $this->db->where("p.id_product", $data['id_product']);
        }
        if($data['batch_no'] != ''){
            $this->db->where("st.batch_no", $data['batch_no']);
        }
        $this->db->where("st.qty >",0);
        $this->db->where("st.store_id", $this->session->userdata['login_info']['store_id']);
        $this->db->group_by("st.batch_no,st.product_id,st.store_id");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function get_promotion_product($data=array()){
        $this->db->select('pd.discount_rate,pd.discount_amount,pd.promotion_id');
        $this->db->from("promotion_details pd");
        $this->db->join('promotions p', 'p.id_promotion = pd.promotion_id');
        if($data['product_id']  !=''){
            $this->db->where("pd.product_id", $data['product_id']);
        }
        $this->db->where("pd.store_id", $data['store_id']);
        if ($data['batch_no']!='') {
            $this->db->where("pd.batch_no", $data['batch_no']);
        }
        $this->db->where("p.status_id", '1');
        $q = $this->db->get();
        //echo $this->db->last_query();
        if ($q->num_rows() > 0) {
            $res = $q->result_array();
            return $res;
        }
        return false;
    }

    public function update_value_deduct($tblname, $field_name, $field_value, $convalue = array())
    {
        $this->sql = '';
        $this->key = '';
        $this->value = '';
        $this->key = array_keys($convalue);
        $this->value = array_values($convalue);
        for ($i = 0; $i < count($convalue); $i++) {
            $this->db->where($this->key[$i], $this->value[$i]);
        }
        $this->db->set($field_name, "`$field_name`-$field_value", FALSE);
        $update = $this->db->update($tblname);
        if ($update) {
            return true;
        }
        return false;
    }
    public function update_value_add($tblname, $field_name, $field_value, $convalue = array())
    {
        $this->sql = '';
        $this->key = '';
        $this->value = '';
        $this->key = array_keys($convalue);
        $this->value = array_values($convalue);
        for ($i = 0; $i < count($convalue); $i++) {
            $this->db->where($this->key[$i], $this->value[$i]);
        }
        $this->db->set($field_name, "`$field_name`+$field_value", FALSE);
        $update = $this->db->update($tblname);
        if ($update) {
            return true;
        }
        return false;
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

    

    public function get_bank_name($store_m)
    {
        $this->db->select("a.bank_id,a.acc_type_id,b.bank_name,a.id_account,a.account_no");
        $this->db->from("accounts a");
        $this->db->join('banks b', 'a.bank_id = b.id_bank', 'left');
        $this->db->join('accounts_stores c', 'c.account_id = a.id_account');
        $this->db->where("c.store_id", $store_m);
        $this->db->where("a.status_id", 1);
        $this->db->group_start();
        $this->db->like("a.acc_uses_id", 2);
        $this->db->or_like("a.acc_uses_id", 3);
        $this->db->group_end();
        $this->db->order_by("b.bank_name", "asc");
        $query = $this->db->get();
        $res = $query->result_array();
        //$hh= $this->bd->last_query();
        //print_r($hh);
        return $res;
    }
    public function getvalue_sale_details($id)
    {
        $this->db->select("a.*,b.product_name,pb.brand_name,pc.cat_name,pca.cat_name as sub_cat_name,b.product_code, GROUP_CONCAT(DISTINCT CONCAT(sa.s_attribute_name,'=',sa.s_attribute_value) SEPARATOR ',') AS attribute_name");
        $this->db->from("sale_details a");
        $this->db->join('products b', 'a.product_id = b.id_product', 'left');
        $this->db->join('product_categories pc', 'pc.id_product_category=b.cat_id', 'left');
        $this->db->join('product_categories pca', 'pca.id_product_category=b.subcat_id', 'left');
        $this->db->join('product_brands pb', 'b.brand_id = pb.id_product_brand', 'left');
        $this->db->join('stock_attributes sa', 'a.stock_id= sa.stock_id', 'left');
        $this->db->where("a.sale_id", $id);
        $this->db->where("a.sale_type_id",'1');
        $this->db->group_by("a.id_sale_detail");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_customer_details_sale($name)
    {
        $this->db->select("a.id_customer,a.customer_code,a.full_name,a.phone,a.points,a.balance,b.discount,b.name as type_name");
        $this->db->from("customers a");
        $this->db->join('customer_types b', 'a.customer_type_id = b.id_customer_type', 'left');
        $this->db->where("a.id_customer", $name);
        $this->db->where("a.status_id", 1);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_customer_details_sale_by_id($name)
    {
        $this->db->select("a.id_customer,a.full_name,a.phone,a.points,a.balance,b.discount,b.target_sales_volume,b.name as type_name");
        $this->db->from("customers a");
        $this->db->join('customer_types b', 'a.customer_type_id = b.id_customer_type', 'left');
        $this->db->where("a.id_customer", $name);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }


    

    public function get_product_auto_sale($request, $store_id)
    {
//        $this->db->select("product_name, id_product,selling_price_est,product_code,batch_no,attribute_name");
//        $this->db->from("sale_product_view");
//        $this->db->where('store_id', $store_id);
//        $this->db->group_start();
//        $this->db->like("product_name", $request);
//        $this->db->or_like("product_code", $request);
//        $this->db->group_end();
//        $this->db->order_by("product_name", 'asc');
//        $query = $this->db->get();
//        $res = $query->result();
//        return $res;
        return $this->db->query("CALL stock_product_list('".$request."',$store_id)")->result();
    }

    public function hold_sale_list($store_id)
    {
        $this->db->select("s.*,c.full_name,c.phone");
        $this->db->from("hold_sales s");
        $this->db->join('customers c', 'c.id_customer = s.customer_id', 'left');
        $this->db->where('s.store_id',$store_id);
        $this->db->group_by("s.invoice_no");
        $this->db->order_by('s.id_hold_sale', 'desc');
        $query = $this->db->get();
        $res = $query->result();
        return $res;

    }
    public function listAccounts($stores = [], $acc_type = 0, $acc_use = 0)
    {
        foreach ($stores as $k => $v) {
            if (empty($stores[$k])) unset($stores[$k]);
        }
        if (!(isset($stores) && !empty($stores))) return [];

        $acc_type = (int)$acc_type;
        $acc_use = (int)$acc_use;

        $this->db->select("
            a.id_account AS acc_id,
             a.curr_balance AS curr_balance,
            CASE a.acc_type_id
              WHEN 1 THEN b.bank_name
              WHEN 2 THEN a.account_name
              WHEN 3 THEN b.bank_name
              WHEN 4 THEN a.account_name
              ELSE ''
            END AS acc_name,
            a.account_no AS acc_no,
            a.acc_type_id AS acc_type", FALSE);
        $this->db->from("accounts AS a");
        $this->db->join('accounts_stores AS acs', 'acs.account_id = a.id_account');
        $this->db->join('banks AS b', 'b.id_bank = a.bank_id', 'left');
        if (!empty($acc_type)) {
            $this->db->where("a.acc_type_id", $acc_type);
        }
        if (empty($acc_use)) {
            // Office uses OR Both
            $this->db->where("(a.acc_uses_id = 1 OR a.acc_uses_id = 3)", NULL, FALSE);
        } else {
            $this->db->where("a.acc_uses_id", $acc_use);
        }
        $this->db->where("a.status_id", 1);
        $this->db->where("acs.store_id IN (" . implode(',', $stores) . ")", NULL, FALSE);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function delivety_person_staff_list(){
        $this->db->select("a.id_delivery_person,b.fullname as person_name");
        $this->db->from("delivery_persons a");
        $this->db->join('users b', 'a.ref_id = b.id_user', 'left');
        $this->db->where("a.type_id", 1);
        $this->db->where("a.status_id", 1);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    public function get_customer_address($customer_id) {
        $this->db->select("customer_addresss.*, loc_divisions.division_name_en, loc_divisions.division_name_bn, loc_districts.district_name_en, loc_districts.district_name_bn, loc_cities.city_name_en, loc_cities.city_name_bn, loc_areas.area_name_en, loc_areas.area_name_bn, loc_areas.area_name_bn, loc_unions.union_name_en, loc_unions.union_name_bn, loc_upazilas.upazila_name_en, loc_upazilas.upazila_name_bn");
        $this->db->from("customer_addresss");
        $this->db->join('loc_divisions', 'loc_divisions.id_division = customer_addresss.div_id', 'left');
        $this->db->join('loc_districts', 'loc_districts.id_district = customer_addresss.dist_id', 'left');
        $this->db->join('loc_cities', 'loc_cities.id_city = customer_addresss.city_id', 'left');
        $this->db->join('loc_areas', 'loc_areas.id_area = customer_addresss.area_id', 'left');
        $this->db->join('loc_unions', 'loc_unions.id_union = customer_addresss.unn_id', 'left');
        $this->db->join('loc_upazilas', 'loc_upazilas.id_upazila = customer_addresss.upz_id', 'left');
        $this->db->where("customer_addresss.customer_id", "$customer_id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            return $res;
        }
        return false;
    }

    public function getSales_person_list($params = array()){
        $this->db->select("sp.*,
        CASE sp.person_type
            WHEN '1' THEN u.fullname
            WHEN '2' THEN u.fullname
            WHEN '3' THEN s.supplier_name
            WHEN '4' THEN c.full_name
        END AS user_name,
        CASE sp.person_type
            WHEN '1' THEN u.mobile
            WHEN '2' THEN u.mobile
            WHEN '3' THEN s.phone
            WHEN '4' THEN c.phone
        END AS phone
        ");
        $this->db->from("sales_person sp");
        $this->db->join('users u', 'u.id_user = sp.person_id and (sp.person_type=1 OR sp.person_type=2)', 'left');
        $this->db->join('suppliers s', 's.id_supplier = sp.person_id and sp.person_type=3', 'left');
        $this->db->join('customers c', 'c.id_customer = sp.person_id and sp.person_type=4', 'left');
        $this->db->where("sp.status_id", "1");
        $this->db->order_by("sp.id_sales_person", "desc");
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            return $res;
        }
        return false;
    }
    public function get_sales_person_autocomplete($name){
        $this->db->select("user_name,phone,type_name,id_sales_person
        ");
        $this->db->from("vw_sales_person_list");
        $this->db->like("user_name", $name);
        $this->db->where("status_id", "1");
        $this->db->order_by("user_name", "asc");
        $this->db->limit(20);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->result();
            return $res;
        }
        return false;
    }
    public function deo_unpaid_sales($id=0){
        $this->db->select("sp.*,s.invoice_no");
        $this->db->from("sales_person_comm_details sp");
        $this->db->join('sales s', 'sp.sale_id = s.id_sale', 'left');
        $this->db->where("sp.sales_person_comm_id", "$id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            return $res;
        }
        return false;
    }
    public function sales_commission_list($params=array()){
        $this->db->select("spc.*,sp.person_type,
        CASE sp.person_type
            WHEN '1' THEN u.fullname
            WHEN '2' THEN u.fullname
            WHEN '3' THEN s.supplier_name
            WHEN '4' THEN c.full_name
        END AS user_name,
        ");
        $this->db->from("sales_person_comm spc");
        $this->db->join('sales_person sp', 'spc.sales_person_id = sp.id_sales_person AND sp.status_id = 1', 'left');
        $this->db->join('users u', 'u.id_user = sp.person_id and (sp.person_type=1 OR sp.person_type=2)', 'left');
        $this->db->join('suppliers s', 's.id_supplier = sp.person_id and sp.person_type=3', 'left');
        $this->db->join('customers c', 'c.id_customer = sp.person_id and sp.person_type=4', 'left');
        $this->db->order_by("spc.id_sales_person_comm", "desc");
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            return $res;
        }
        return false;
    }
	public function getSalesPersonById($id=''){
        $this->db->select("sp.person_type,
        CASE sp.person_type
            WHEN '1' THEN u.fullname
            WHEN '2' THEN u.fullname
            WHEN '3' THEN s.supplier_name
            WHEN '4' THEN c.full_name
        END AS user_name
        ");
        $this->db->from("sales_person sp");
        $this->db->join('users u', 'u.id_user = sp.person_id and (sp.person_type=1 OR sp.person_type=2)', 'left');
        $this->db->join('suppliers s', 's.id_supplier = sp.person_id and sp.person_type=3', 'left');
        $this->db->join('customers c', 'c.id_customer = sp.person_id and sp.person_type=4', 'left');
        $this->db->where("sp.status_id", "1");
        $this->db->where("sp.id_sales_person", $id);
        $this->db->order_by("sp.id_sales_person", $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            return $res;
        }
        return false;
    }

    public function check_batch_product($params){
        $this->db->select("st.id_stock,p.is_vatable,sum(st.qty) total_qty,st.selling_price_est,p.brand_id,p.cat_id,p.subcat_id");
        $this->db->from("stocks st");
        $this->db->join('products p', 'p.id_product = st.product_id AND p.status_id = 1');
        $this->db->where("st.product_id", $params['id_product']);
        $this->db->where("st.batch_no", $params['batch_no']);
        $this->db->where("st.qty >",0);
        $this->db->where("st.store_id", $this->session->userdata['login_info']['store_id']);
        $this->db->group_by("st.batch_no,st.product_id,st.store_id");
        $query = $this->db->get();
        //echo $this->db->last_query();
        //print_r($params);
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function return_product_list($invoice)
    {
        $this->db->select("SUM(d.qty)AS rtn_qty,d.id_sale_detail,d.stock_id");
        $this->db->from("sale_adjustments a");
        $this->db->join('sale_details d', 'a.id_sale_adjustment = d.sale_id AND d.sale_type_id=2');
        $this->db->where("a.ref_sale_id", $invoice);
        $this->db->group_by("d.stock_id");
        $query = $this->db->get();
        $res = $query->result_array();
        //$hh= $this->bd->last_query();
        //print_r($hh);
        return $res;
    }
}

        