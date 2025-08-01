<?php

class Product_Model extends CI_Model {

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
    function getRowsAttributes($params = array()) {
        $this->db->select('*');
        $this->db->from('product_attributes');
//        get_category_by_id
        $this->db->where('status_id', 1);
        $this->db->order_by('id_attribute', 'desc');
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
    public function get_attribute_by_id($id) {
        $this->db->from('product_attributes');
        $this->db->where('id_attribute', $id);
        $query = $this->db->get();

        return $query->row();
    }
    public function get_category_by_id($id) {
        $this->db->from('product_categories');
        $this->db->where('id_product_category', $id);
        $this->db->where('status_id', 1);
        $query = $this->db->get();

        return $query->row();
    }
    
    function getRowsProducts($params = array()) {
        $this->db->select('products.*');
        $this->db->from('products');
       $this->db->join('stocks', 'stocks.product_id=products.id_product', 'left');
//        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
//            $this->db->where('stocks.store_id', $this->session->userdata['login_info']['store_id']);
//        }
        if (!empty($params['search']['product_name'])) {
            $this->db->group_start();
            $this->db->like('product_name', $params['search']['product_name']);
            $this->db->or_like('product_code', $params['search']['product_name']);
            $this->db->group_end();
        }
        if (!empty($params['search']['cat_name'])) {
            $this->db->where('cat_id', $params['search']['cat_name']);
        }
        if (!empty($params['search']['brand_name'])) {
            $this->db->where('brand_id', $params['search']['brand_name']);
        }
        if (!empty($params['search']['pro_sub_category'])) {
            $this->db->where('subcat_id', $params['search']['pro_sub_category']);
        }
        if (!empty($params['search']['pro_price_from'])) {
            $this->db->where("sell_price >=", $params['search']['pro_price_from']);
            $this->db->where("sell_price <=", $params['search']['pro_price_to']);
        }
        if (!empty($params['search']['inactive_product'])) {
            $this->db->where('products.status_id !=', 1);
        }else{
            $this->db->where('products.status_id', 1);
        }
        $this->db->order_by('products.id_product', 'desc');
        $this->db->group_by('products.id_product');
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
    public function product_stock(){
        $this->db->select('product_id,SUM(qty) as stock_qty');
        $this->db->from('stocks');
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('store_id', $this->session->userdata['login_info']['store_id']);
        }
        $this->db->group_by('product_id');
        $query = $this->db->get();
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
        $this->db->select('c.supplier_name,c.id_supplier');
        $this->db->from('products a');
        $this->db->join('products_suppliers b', 'b.porduct_id=a.id_product', 'left');
        $this->db->join('suppliers c', 'c.id_supplier=b.supplier_id', 'left');
        $this->db->where('a.id_product', $id);
        $this->db->where('a.status_id', 1);
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
    public function check_category_name($value) {
        $tot = $this->db
                ->where('cat_name', $value)
                ->where('status_id', 1)
                ->where('parent_cat_id IS NULL', null, false)
                ->count_all_results('product_categories');

        return $tot > 0 ? TRUE : FALSE;
    }
    public function check_product_cat($id) {
        $this->db->select("a.*");
        $this->db->from("products a");
        $this->db->join('stocks b', 'b.product_id=a.id_product');
        $this->db->where("b.qty !=", 0);
		$this->db->where("a.status_id",1);
        $this->db->group_start();
        $this->db->where("a.cat_id", $id, FALSE);
        $this->db->or_where("a.subcat_id", $id, NULL, FALSE);
        $this->db->group_end();
        $query = $this->db->get();
        return $query->num_rows() > 0 ? TRUE : FALSE;
    }
    public function check_product_brand($id){
        $this->db->select("a.*");
        $this->db->from("products a");
        $this->db->join('stocks b', 'b.product_id=a.id_product');
        $this->db->where("b.qty !=", 0);
		$this->db->where("a.status_id",1);
        $this->db->where("a.brand_id", $id);
        $query = $this->db->get();
        return $query->num_rows() > 0 ? TRUE : FALSE;
    }

    public function delete_data($tblname, $convalue = array()) {
        $this->db->where($convalue);
        $update = $this->db->delete($tblname);
        if ($update) {
            return true;
        }
        return false;
    }

    public function isExistExcept($table, $chk_column, $chk_value, $expt_column, $expt_value) {
        $tot = $this->db
                ->where($chk_column, $chk_value)
                ->where($expt_column . ' !=', $expt_value)
                ->count_all_results($table);

        return $tot > 0 ? 1 : 0;
    }

    public function isExist($table, $column, $value) {
        $tot = $this->db
                ->where($column, $value)
                ->count_all_results($table);

        return $tot > 0 ? TRUE : FALSE;
    }

    public function max_value($table, $value) {
        $this->db->select_max($value);
        $result = $this->db->get($table);
        return (int) $result->row()->$value;
    }
    
    public function batch_no_product_id($id){
        $this->db->select("DISTINCT(batch_no)");
        $this->db->from("stocks");
        $this->db->where("status_id", "1");
        $this->db->where("qty >", "0");
        $this->db->where("product_id", $id);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
//        $res = $query->result_array();
//        return $res;
    }
	public function get_stock_by_product($id){
		$this->db->select("s.id_stock,s.batch_no,s.purchase_price,s.selling_price_act, sum(s.qty) as stk_qty,s.expire_date,s.dtt_add,st.store_name");
        $this->db->from("stocks s");
		//$this->db->join('stock_attributes a', 's.id_stock=a.stock_id', 'left');
        $this->db->join('stores st', 's.store_id=st.id_store');
        $this->db->where("s.status_id", "1");
        $this->db->where("s.qty >", "0");
        $this->db->where("s.product_id", $id);
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
        }
        $this->db->group_by(['s.store_id','s.batch_no']);
        //$this->db->group_by('s.id_stock');
		$query = $this->db->get();
        if ($query->num_rows() != 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
	}
    public function get_low_stock_by_product($id,$store_id){
        $this->db->select("s.id_stock,s.batch_no,s.purchase_price,s.selling_price_act, sum(s.qty) as stk_qty,s.expire_date,s.dtt_add,st.store_name");
        $this->db->from("stocks s");
        $this->db->join('stores st', 's.store_id=st.id_store');
        $this->db->where("s.status_id", "1");
        $this->db->where("s.qty >", "0");
        $this->db->where("s.product_id", $id);
        $this->db->where("s.store_id", $store_id);
        $this->db->group_by('s.product_id,s.batch_no');
        //$this->db->group_by('s.id_stock');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }
    public function get_attribute_by_stock($id){
        $this->db->select("GROUP_CONCAT(DISTINCT CONCAT(s_attribute_name,'=',s_attribute_value) SEPARATOR ',') AS attribute_name");
        $this->db->from("stock_attributes");
        $this->db->where("stock_id", $id);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            foreach ($query->result() as $row) {
                $data = $row->attribute_name;
            }
            return $data;
        } else {
            return false;
        }
    }

    public function get_available_stock_by_product($id, $storeId){
        $this->db->select("s.id_stock,s.batch_no,s.purchase_price,s.selling_price_act,s.qty,s.expire_date,s.dtt_add,a.attribute_name");
        $this->db->from("stocks s");
        $this->db->join('vw_stock_attr a', 's.id_stock=a.stock_id', 'left');
        $this->db->where("s.status_id", "1");
        $this->db->where("s.product_id", $id);
        $this->db->where("s.store_id", $storeId);
        $this->db->where('s.qty >', 0);
        $this->db->group_by('s.batch_no');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }
public function get_available_stock_by_invoice($inv_no,$inv_type,$store_id){
        $type='';
        if($inv_type==1){
            $type=12;
        }else if($inv_type==2){
            $type=8;
        }
    $this->db->select('v.*,a.attribute_name');
    $this->db->from('stock_details_view v');
    $this->db->join('vw_stock_attr a', 'v.id_stock=a.stock_id', 'left');
    $this->db->where('v.invoice_no',$inv_no );
    $this->db->where('v.stock_mvt_type_id', $type);
    $this->db->where('v.store_id', $store_id);
    $query = $this->db->get();
    if ($query->num_rows() != 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
        return $data;
    } else {
        return false;
    }
}
public function get_available_receive_by_invoice($inv_no,$store_id)
{
    $this->db->select("p.product_name,s.selling_price_act,s.store_id,,s.id_stock,s.batch_no,s.dtt_add,s.qty as current_qty,s.product_id, sta.`attribute_name`");
    $this->db->from("stocks s");
    $this->db->join('products p', 's.product_id=p.id_product', 'left');
    $this->db->join('purchase_receives pr', 's.stock_mvt_id=pr.id_purchase_receive', 'left');
    $this->db->join('vw_stock_attr sta', 'sta.stock_id=s.id_stock', 'left');
    $this->db->where('pr.invoice_no',$inv_no );
    $this->db->where('pr.store_id', $store_id);
    $this->db->where('s.stock_mvt_type_id', 1);
    $this->db->where("s.status_id", "1");
    $this->db->group_by('s.id_stock');
    $query = $this->db->get();
    if ($query->num_rows() != 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
        return $data;
    } else {
        return false;
    }
}

    public function getStockPriceByProduct($id, $batch,$store_id=0){
        $this->db->select("p.product_name,p.product_code,s.selling_price_act,p.is_vatable");
        $this->db->from("stocks s");
        $this->db->join('products p', 's.product_id=p.id_product', 'left');
        $this->db->where("s.status_id", "1");
        $this->db->where("s.product_id", $id);
        $this->db->where("s.batch_no", $batch);
        $this->db->where("s.store_id", $store_id);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    public function low_stock_data($params = array()){

        $this->db->select('t.store_id,p.*,SUM(t.qty) as total_quantity,s.store_name, pc.cat_name, pb.brand_name, pcs.cat_name as sub_cat_name',false);
        $this->db->from('stocks t');
        $this->db->join('products p','p.id_product = t.product_id','full');
        $this->db->join('product_categories pc','p.cat_id = pc.id_product_category','left');
        $this->db->join('product_categories pcs', 'p.subcat_id = pcs.id_product_category ', 'left');
        $this->db->join('product_brands pb','p.brand_id = pb.id_product_brand','left');
        $this->db->join('stores s','t.store_id = s.id_store','left');
        $this->db->group_by('t.product_id');
        //$this->db->having('SUM(t.qty) < p.min_stock');
		
		if ($params['type']==1) {
             $this->db->having('SUM(t.qty) < p.min_stock');
        }else{
            $this->db->having('SUM(t.qty) > p.max_stock');
        }

        if(array_key_exists("product_name",$params)){
            $p = $params['product_name'];
            $this->db->where("p.product_name = '$p' OR p.product_code = '$p'");
        }
        if(array_key_exists("cat_name",$params)){
            $this->db->where('p.cat_id =', $params['cat_name']);
        }
        if(array_key_exists("pro_sub_category",$params)){
            $this->db->where('p.subcat_id =', $params['pro_sub_category']);
        }
        if(array_key_exists("store_id",$params)){
            $this->db->where('t.store_id =', $params['store_id']);
        } else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if(array_key_exists("brand",$params)){
            $this->db->where('p.brand_id =', $params['brand']);
        }


        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
		//echo $this->db->last_query();
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }
    public function getStoreName($id){
        $this->db->select("store_name");
        $this->db->from("stores");
        $this->db->where("id_store", $id);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res[0]['store_name'];
    }	

    public function getProductName($id){
        $this->db->select("product_name");
        $this->db->from("products");
        $this->db->where("id_product", $id);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res[0]['product_name'];
    } 
	public function getProductDetails($params = array()){

        $this->db->select('s.*, p.product_code as p_product_code, p.product_name as p_product_name,pc.cat_name, pca.cat_name as sub_cat_name, pb.brand_name, s.batch_no, spl.supplier_name');
        $this->db->from('stocks s');
        $this->db->join('products p', 'p.id_product=s.product_id', 'left');
        $this->db->join('product_categories pc', 'pc.id_product_category=p.cat_id', 'left');
        $this->db->join('product_categories pca', 'pca.id_product_category=p.subcat_id', 'left');
        $this->db->join('product_brands pb', 'pb.id_product_brand=p.brand_id', 'left');
        $this->db->join('suppliers spl', 'spl.id_supplier=s.supplier_id', 'left');

        $this->db->order_by('s.dtt_add','desc');
        $this->db->where("s.status_id", 1);
        $this->db->where("s.qty > ", 0);

        if(array_key_exists("store",$params)){
            $this->db->where('s.store_id =', $params['store']);
        }
        if(array_key_exists("product_name",$params)){
            $this->db->where('s.product_id =', $params['product_name']);
        }
        if(array_key_exists("cat_name",$params)){
            $this->db->where('p.cat_id =', $params['cat_name']);
        }
        if(array_key_exists("pro_sub_category",$params)){
            $this->db->where('p.subcat_id =', $params['pro_sub_category']);
        }
        if(array_key_exists("brand",$params)){
            $this->db->where('p.brand_id =', $params['brand']);
        }
        if(array_key_exists("supplier",$params)){
            $this->db->where('s.supplier_id =', $params['supplier']);
        }
        
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    public function getStoreInfo($id){
        $this->db->select('*');
        $this->db->from('stores');
        $this->db->where("id_store", $id);
        $query = $this->db->get();
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    public function updateStockProductInfo($srcData){
        $data = array(
           'expire_date' => $srcData['expire_date'],
           'alert_date' => $srcData['alert_date'],
           'selling_price_act' => $srcData['selling_price_act'],
           'selling_price_est' => $srcData['selling_price_est'],
        );

        $this->db->where('id_stock', $srcData['id_stock']);
        $this->db->update('stocks', $data); 
        return $this->db->affected_rows();
    }
    public function get_available_stock_in_products() {
        $this->db->select("s.id_stock, s.batch_no, s.product_id,  p.product_name,p.product_code");
        $this->db->from("stocks s");
        $this->db->join('products p', 's.product_id = p.id_product', 'left');
        $this->db->where("p.status_id", 1);
        $this->db->where('s.qty >', 0);
        $this->db->group_by('s.product_id');
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }
    public function get_product_auto_list($request){
        $this->db->select("product_name, id_product,buy_price,sell_price,product_code");
       $this->db->from("products");
       $this->db->where('status_id', 1);
       $this->db->group_start();
       $this->db->like("product_name", $request);
       $this->db->or_like("product_code", $request);
       $this->db->group_end();
       $this->db->order_by("product_name", 'asc');
       $this->db->limit('20');
       $query = $this->db->get();
       $res = $query->result();
       return $res;
    }
}

