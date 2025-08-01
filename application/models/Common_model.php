<?php

/**
 * Contains all common methods to be used in entire project
 *
 * @author Rafiqul Islam <rafiq.kuet@gmail.com>
 * @date September 14, 2017 10:15
 */
class Common_model extends CI_Model
{

    /**
     * Checks whether a value exists in a table
     *
     * @param string $table : table name to check
     * @param string $column : column name to check
     * @param string $value : value to be matched in the column of the table
     * @return boolean
     */
    public function isExist($table, $column, $value)
    {
        $tot = $this->db
            ->where($column, $value)
            ->where('status_id', 1)
            ->count_all_results($table);

        return $tot > 0 ? TRUE : FALSE;
    }

    public function get_currency(){
        $this->db->where('param_key','CURRENCY');
        $q = $this->db->get('configs');
        if ($q->num_rows() > 0) {

            return $q->result_array();
        }
        return false;
    }
    public function get_js_currency(){
        $this->db->where('param_key','CURRENCY');
        $q = $this->db->get('configs');
        if ($q->num_rows() > 0) {
            $data= $q->result_array();
            return $data[0]['param_val'].'@'.$data[0]['utilized_val'];
        }
    }
    public function get_time_zone(){
        $this->db->select('param_val');
        $this->db->where('param_key','TIME_ZONE');
        $q = $this->db->get('configs');
        if ($q->num_rows() > 0) {
            $data=$q->result_array();
            return $data[0]['param_val'];
        }
        return false;
    }
    public function isExistExcept($table, $chk_column, $chk_value, $expt_column = '', $expt_value = '')
    {
        $this->db->where($chk_column, $chk_value);
        if (!empty($expt_value)) {
            $this->db->where($expt_column . ' !=', $expt_value);
        }
        $tot = $this->db
            ->where('status_id', 1)
            ->count_all_results($table);

        return $tot > 0 ? TRUE : FALSE;
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

    public function get_print_invoice($invoice)
    {
        $this->db->select('a.*,c.fullname,b.mobile,b.address_line,b.email,b.store_name,b.store_img,d.full_name as customer_name,d.customer_code,d.phone as customer_mobile,d.balance as customer_balance');
        $this->db->from('sales a');
        $this->db->join('stores b', 'a.store_id=b.id_store', 'left');
        $this->db->join('users c', 'a.uid_add=c.id_user', 'left');
        $this->db->join('customers d', 'a.customer_id=d.id_customer ', 'left');
        // $this->db->where("a.dtt_add >=", $start);
        $this->db->where("a.id_sale", $invoice);
        $query = $this->db->get();
        //return $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    

    public function get_sellReturn_print_invoice($invoice)
    {
        $this->db->select('a.*,c.fullname,b.mobile,b.store_img,b.address_line,b.email,b.store_name,d.full_name as customer_name,d.customer_code,d.points as customer_points,e.invoice_no as ref_sale_invoice');
        $this->db->from('sale_adjustments a');
        $this->db->join('stores b', 'a.store_id=b.id_store', 'left');
        $this->db->join('users c', 'a.uid_add=c.id_user', 'left');
        $this->db->join('customers d', 'a.customer_id=d.id_customer ', 'left');
        $this->db->join('sales e', 'a.ref_sale_id=e.id_sale ', 'left');
        $this->db->where("a.id_sale_adjustment", $invoice);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
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

    public function getvalue_sale_return_details($id)
    {
        $this->db->select("a.*,b.product_name,b.product_code,pb.brand_name,pc.cat_name,pca.cat_name as sub_cat_name,");
        $this->db->from("sale_details a");
        $this->db->join('products b', 'a.product_id = b.id_product', 'left');
        $this->db->join('product_categories pc', 'pc.id_product_category=b.cat_id', 'left');
        $this->db->join('product_categories pca', 'pca.id_product_category=b.subcat_id', 'left');
        $this->db->join('product_brands pb', 'b.brand_id = pb.id_product_brand', 'left');
        $this->db->where("a.sale_id", $id);
        $this->db->where("a.sale_type_id", 2);
        $query = $this->db->get();
        $res = $query->result_array();
        //$hh= $this->bd->last_query();
        //print_r($hh);
        return $res;
    }

    public function sale_transaction_details($id)
    {
        $this->db->select("a.amount as total_amount,b.payment_method_id,
        CASE a.qty_multiplier
            WHEN '0' THEN b.amount
            WHEN '1' THEN a.amount
        END AS amount,a.dtt_add");
        $this->db->from("sale_transaction_details a");
        $this->db->join('sale_transaction_payments b', 'a.sale_transaction_id = b.sale_transaction_id', 'left');
        $this->db->where("a.sale_id", $id);
        $this->db->where("a.transaction_type_id", 1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $res = $query->result_array();
        return $res;
    }
    public function sale_transaction_by_date($id,$store_id=0)
    {
        $this->db->select("sum(a.amount) as total_amount,b.payment_method_id,
        CASE a.qty_multiplier
           WHEN '0' THEN SUM(b.amount)
           WHEN '1' THEN SUM(a.amount)
        END AS amount,a.dtt_add");
        $this->db->from("sale_transaction_details a");
        $this->db->join('sale_transaction_payments b', 'a.sale_transaction_id = b.sale_transaction_id');
        $this->db->join('sales s', "s.id_sale=a.sale_id and s.dtt_add LIKE '$id%'");
        $this->db->like("a.dtt_add", $id);
        $this->db->where("a.transaction_type_id", 1);
		$this->db->where("s.store_id", $store_id);
        $this->db->group_by('b.payment_method_id');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $res = $query->result_array();
        return $res;
    }


    public function last_week_sale($start, $end)
    {
        $this->db->select('SUM(a.tot_amt) as tot_amt,b.store_name');
        $this->db->from('sales a');
        $this->db->join('stores b', 'a.store_id=b.id_store', 'left');
        $this->db->where("a.dtt_add >=", $start);
        $this->db->where("a.dtt_add <=", $end);
        $this->db->group_by('a.store_id');
        $query = $this->db->get();
        //return $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function account_stocks_last()
    {
        $this->db->select("
        , a.account_name
        , b.bank_name
        , a.acc_type_id
        , TRIM(TRAILING '.' FROM TRIM(TRAILING '0' from a.initial_balance)) AS initial_balance
        , TRIM(TRAILING '.' FROM TRIM(TRAILING '0' from a.curr_balance)) AS curr_balance
        , GROUP_CONCAT(st.store_name SEPARATOR '/') AS stores
        ", FALSE);
        $this->db->from("accounts AS a");
        $this->db->join('banks AS b', 'b.id_bank = a.bank_id', 'left');
        $this->db->join('accounts_stores AS accst', 'accst.account_id = a.id_account', 'left');
        $this->db->join('stores AS st', 'st.id_store = accst.store_id', 'left');
        $this->db->where("a.status_id", 1);
        $this->db->group_by('a.id_account');
        $query = $this->db->get();
        //return $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function is_exist($data)
    {
        $this->db->where($data['column'], $data['value']);

        if (isset($data['except_column']) && !empty($data['except_column']) && isset($data['except_value'])) {
            $this->db->where($data['except_column'] . ' !=', $data['except_value']);
        }

        $tot = $this->db->count_all_results('table');

        return $tot > 0 ? TRUE : FALSE;
    }

    /*$data = [
        [
            'title' => 'My title',
            'name' => 'My Name',
            'date' => 'My date'
        ],
        [
            'title' => 'Another title',
            'name' => 'Another Name',
            'date' => 'Another date'
        ]
    ];*/
    public function batchInsert($table, $data)
    {

        $this->db->insert_batch($table, $data);
    }

    public function commonInsert($table, $data)
    {
        $this->db->insert($table, $data);
        $this->saveLog($this->db->last_query());
        return $this->db->insert_id();
    }

    public function commonInsertSTP($table, $data)
    {
        $key = '';
        $value = '';
        $count = 0;
        foreach ($data as $k => $v) {
            $cot = ($count > 0) ? ',' : '';
            $key .= $cot . $k;
            $value .= $cot . $v;
            $count++;
        }
        //echo "CALL insert_row('" . $table . "','" . $key . "','" . $value . "')";exit;
        $qry_res = $this->db->query("CALL insert_row('" . $table . "','" . $key . "','" . $value . "')");
        //if(!$qry_res) $error = $this->db->error(); var_dump($error); exit;
        //var_dump($qry_res);exit;
        $details_id = $qry_res->result_object();
        $qry_res->next_result();
        $qry_res->free_result();
        return $details_id[0]->result;
    }

    public function commonUpdateSTP($table, $set_data, $check_data, $version_option = FALSE)
    {
        $key = '';
        $value = '';
        $count = 0;
        foreach ($set_data as $k => $v) {
            $cot = ($count > 0) ? ',' : '';
            $key .= $cot . $k;
            $value .= $cot . $v;
            $count++;
        }
        if ($version_option) {
            $key .= ',version';
            $value .= ',`version`+1';
        }
        $conKey = '';
        $conValue = '';
        $count = 0;
        foreach ($check_data as $k => $v) {
            $cot = ($count > 0) ? ',' : '';
            $conKey .= $cot . $k;
            $conValue .= $cot . $v;
            $count++;
        }
        $qry_res = $this->db->query("CALL update_row('" . $table . "','" . $key . "','" . $value . "','" . $conKey . "','" . $conValue . "')");
        $pro_id = $qry_res->result_object();
        $qry_res->next_result();
        $qry_res->free_result();
        return ($pro_id) ? true : false;
    }
    public function commonDeleteSTP($table, $data)
    {
        $key = '';
        $value = '';
        $count = 0;
        foreach ($data as $k => $v) {
            $cot = ($count > 0) ? ',' : '';
            $key .= $cot . $k;
            $value .= $cot . $v;
            $count++;
        }
        $qry_res = $this->db->query("CALL delete_row('" . $table . "','" . $key . "','" . $value . "')");
        return ($qry_res) ? true : false;
    }
    public function commonUpdate($table, $set_data, $check_data, $version_option = FALSE)
    {
        foreach ($check_data as $key => $val) {
            $this->db->where($key, $val);
        }
        if ($version_option) {
            $this->db->set('version', '`version`+1', FALSE);
        }
        $update = $this->db->update($table, $set_data);
        $this->saveLog($this->db->last_query());

        if ($update) {
            return true;
        }
        return false;
    }

    public function commonDelete($table, $column, $value)
    {
        $this->db->where($column, $value);
        $this->db->delete($table);
        $this->saveLog($this->db->last_query());
    }

    public function saveLog($txt)
    {
        $data = [
            'log' => $txt,
            'dtt_add' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('logs', $data);
    }

    public function listAllStores()
    {
        $stores = array();
        $this->db->select("id_store, store_name");
        $this->db->from("stores");
        $this->db->where("status_id", 1);
        $this->db->order_by("store_name", "asc");

        $query = $this->db->get();
        $result = $query->result();

        foreach ($result as $res) {
            $stores[$res->id_store] = $res->store_name;
        }

        return $stores;
    }

    public function listAuthenticatedStores()
    {
        $stores = array();
        $this->db->select("id_store, store_name");
        $this->db->from("stores");
        $this->db->where("status_id", 1);
        $this->db->where("id_store IN (" . implode(',', $this->session->userdata['login_info']['store_ids']) . ")", NULL, FALSE);
        $this->db->order_by("store_name", "asc");

        $query = $this->db->get();
        $result = $query->result();

        foreach ($result as $res) {
            $stores[$res->id_store] = $res->store_name;
        }

        return $stores;
    }

    public function listAuthenticatedUsers($user_type)
    {

        $employees = array();
        $this->db->select("id_user, fullname, mobile");
        $this->db->from("users");
        $this->db->where("status_id", 1);
        $this->db->where("user_type_id", $user_type);
        if ($user_type != 2) {
            $this->db->where("store_id IN (" . implode(',', $this->session->userdata['login_info']['store_ids']) . ")", NULL, FALSE);
        }
        $this->db->order_by("fullname", "asc");

        $query = $this->db->get();
        $result = $query->result();
        //die($this->db->last_query());

        foreach ($result as $res) {
            $employees[$res->id_user] = $res->fullname . ' (' . $res->mobile . ')';
        }

        return $employees;
    }
    public function common_insert($tablename, $data) {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

    public function updAccCurrBalance($acc_id, $amt, $qty_multiplier)
    {
        $this->db->set('curr_balance', "`curr_balance`+($amt*$qty_multiplier)", FALSE);
        $this->db->where('id_account', $acc_id);
        $this->db->update('accounts');
    }

    public function getAmtQtyMultiplierForCustomerTrx($trx_id)
    {
        $this->db->select("account_id, amount, qty_multiplier");
        $this->db->from("sale_transaction_payments");
        $this->db->where("sale_transaction_id", $trx_id);

        $query = $this->db->get();
        $result = $query->result();

        if (isset($result[0])) {
            return [
                'account_id' => $result[0]->account_id,
                'amount' => $result[0]->amount,
                'qty_multiplier' => $result[0]->qty_multiplier,
            ];
        }
        return ['account_id' => 0, 'amount' => 0, 'qty_multiplier' => 1];
    }

    public function getAmtQtyMultiplierForOtherTrx($trx_id)
    {
        $this->db->select("account_id, tot_amount AS amount, qty_multiplier");
        $this->db->from("transactions");
        $this->db->where("id_transaction", $trx_id);

        $query = $this->db->get();
        $result = $query->result();

        if (isset($result[0])) {
            return [
                'account_id' => $result[0]->account_id,
                'amount' => $result[0]->amount,
                'qty_multiplier' => $result[0]->qty_multiplier,
            ];
        }
        return ['account_id' => 0, 'amount' => 0, 'qty_multiplier' => 1];
    }

    public function update_balance_amount($table, $field, $amount, $sign, $convalue = array())
    {
        if ($sign == '+') {
            $this->db->set($field, "`$field`+$amount", FALSE);
        } else if ($sign == '-') {
            $this->db->set($field, "`$field`-$amount", FALSE);
        }
        $this->key = '';
        $this->value = '';
        $this->key = array_keys($convalue);
        $this->value = array_values($convalue);
        for ($i = 0; $i < count($convalue); $i++) {
            $this->db->where($this->key[$i], $this->value[$i]);
        }
        $update = $this->db->update($table);
        if ($update) {
            return true;
        }
        return false;
    }
    public function store_details($company){
        $this->db->select("s.*,a.area_name_en,c.city_name_en,division_name_en,district_name_en");
        $this->db->from("stores s");
        $this->db->join('loc_areas a', 'a.id_area = s.area_id', 'left');
        $this->db->join('loc_cities c', 'c.id_city = s.city_id', 'left');
        $this->db->join('loc_districts d', 'd.id_district = s.dist_id', 'left');
        $this->db->join('loc_divisions dv', 'dv.id_division = s.div_id', 'left');
        $this->db->where("s.id_store", $company);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_stock_data(){
        $date = date('Y-m-d',strtotime('+30 days'));
        $this->db->select("*");
        $this->db->from("stocks");
        $this->db->where("qty > ", 0);
        $this->db->where("expire_date <", $date);
        $query = $this->db->get();
        return $query->result();
    }

    public function low_stock_data(){
        $this->db->select('p.min_stock,SUM(t.qty) as total_quantity',false)
            ->from('stocks t')
            ->join('products p','p.id_product = t.product_id','full')
            ->group_by('t.product_id')
            ->having('SUM(t.qty) < p.min_stock');
        $result=$this->db->get()->result();
        return $result;
    }

    public function supplier_payment_alerts($id=null){
        $today = date('Y-m-d');
        $this->db->select("spa.*, s.supplier_name, s.supplier_code, s.contact_person, s.phone, s.email");
        $this->db->from("supplier_payment_alerts spa");
        $this->db->where("DATE_FORMAT(spa.dtt_notification,'%Y-%m-%d') =", $today);
        if($id != null){
            $this->db->where("spa.id_supplier_payment_alert =", $id);
        }
        $this->db->join('suppliers s','spa.supplier_id = s.id_supplier','full');
        $query = $this->db->get();
        return $query->result();


    }
    public function product_stock_list($store_id=null){
        $this->db->select("stocks.id_stock, products.product_name, products.id_product,products.product_code,sum(stocks.id_stock) as tot_qty ");
        $this->db->from("stocks");
        $this->db->join('products', 'products.id_product = stocks.product_id');
        if($store_id != null){
            $this->db->where("stocks.store_id", $store_id);
        }
        $this->db->where("stocks.qty >", 0);
        $this->db->where("products.status_id", 1);
        $this->db->where("stocks.status_id", 1);
        $this->db->group_by('stocks.product_id');
        $query = $this->db->get();
        $res = $query->result();
        return $res;

    }
    public function invoice_setting_report($name=null){
        $session_data = $this->session->userdata['login_info']['subscription_info']['INVOICE_SETUP'];
        $arraySessionData=explode('&&',$session_data);
        $fullView=$arraySessionData[0];
        $thermalView=$arraySessionData[1];
        if(!empty($fullView) && $name=='full' ){
            $full_invoice=json_decode($fullView);
            $data=array(
                'shop_name'=>$full_invoice->shop_name
                ,'shop_logo'=>$full_invoice->shop_logo
                ,'phone'=>$full_invoice->phone
                ,'email'=>$full_invoice->email
                ,'brand'=>$full_invoice->brand
                ,'code'=>$full_invoice->code
                ,'sub_cat'=>$full_invoice->sub_cat
                ,'note_type'=>$full_invoice->note_type
                ,'note'=>$full_invoice->note
                ,'header'=>$full_invoice->header
                ,'head_size'=>$full_invoice->head_size
                ,'foot_size'=>$full_invoice->foot_size
            );

        }else if(!empty($thermalView) && $name=='thermal'){
            $thermal_invoice=json_decode($thermalView);
            $data=array(
                'shop_name'=>$thermal_invoice->shop_name
                ,'shop_logo'=>$thermal_invoice->shop_logo
                ,'phone'=>$thermal_invoice->phone
                ,'email'=>$thermal_invoice->email
                ,'brand'=>$thermal_invoice->brand
                ,'code'=>$thermal_invoice->code
                ,'note_type'=>$thermal_invoice->note_type
                ,'note'=>$thermal_invoice->note
            );
        }else{
            $data=array(
                'shop_name'=>''
                ,'shop_logo'=>''
                ,'phone'=>''
                ,'email'=>''
                ,'brand'=>''
                ,'code'=>''
                ,'sub_cat'=>''
                ,'note_type'=>''
                ,'note'=>''
            );
        }
        return $data;

    }
    public function chalan_print_data($id){
        $this->db->select("s.product_name,s.product_code,b.brand_name,s.sale_id,sa.attribute_name,pc.cat_name, psc.cat_name sub_cat_name");
        $this->db->from("sale_details_view s");
        $this->db->join('product_brands b', 's.brand_id = b.id_product_brand');
        $this->db->join('product_categories pc', 'pc.id_product_category = s.cat_id','left');
        $this->db->join('product_categories psc', 'psc.id_product_category = s.subcat_id','left');
        $this->db->join('vw_stock_attr sa', 'sa.stock_id = s.stock_id','left');
        $this->db->where("s.id_sale_detail", $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function sale_serial_no($sale_id=0,$type=1){
        $this->db->select('sale_id');
        $this->db->from('sale_details');
        $this->db->where("sale_type_id", $type);
        $this->db->group_by("sale_id");
        $query = $this->db->get();

        $dataAttay=($query->num_rows() > 0) ? $query->result_array():0;
        $invoice=1;
        if($dataAttay!=0){
            foreach ($dataAttay as $data){
                if($data['sale_id']==$sale_id){
                    break;
                }else{
                    $invoice++;
                }
            }
        }
        return $invoice;
    }
    public function salesPersonNameBySaleId($id=0){
        $this->db->select("
        CASE sp.person_type
            WHEN '1' THEN u.fullname
            WHEN '2' THEN u.fullname
            WHEN '3' THEN s.supplier_name
            WHEN '4' THEN c.full_name
        END AS user_name,
        ");
        $this->db->from("sales_person sp");
        $this->db->join('sales sl', "sl.sales_person_id = sp.id_sales_person and sl.id_sale=$id");
        $this->db->join('users u', 'u.id_user = sp.person_id and (sp.person_type=1 OR sp.person_type=2)', 'left');
        $this->db->join('suppliers s', 's.id_supplier = sp.person_id and sp.person_type=3', 'left');
        $this->db->join('customers c', 'c.id_customer = sp.person_id and sp.person_type=4', 'left');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            return $res[0]['user_name'];
        }
        return false;
    }
    public function salesPersonNameByOrderId($id=0){
        $this->db->select("
        CASE sp.person_type
            WHEN '1' THEN u.fullname
            WHEN '2' THEN u.fullname
            WHEN '3' THEN s.supplier_name
            WHEN '4' THEN c.full_name
        END AS user_name,
        ");
        $this->db->from("sales_person sp");
        $this->db->join('orders o', "o.sales_person_id = sp.id_sales_person and o.id_order=$id");
        $this->db->join('users u', 'u.id_user = sp.person_id and (sp.person_type=1 OR sp.person_type=2)', 'left');
        $this->db->join('suppliers s', 's.id_supplier = sp.person_id and sp.person_type=3', 'left');
        $this->db->join('customers c', 'c.id_customer = sp.person_id and sp.person_type=4', 'left');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            return $res[0]['user_name'];
        }
        return false;
    }
    public function get_customer_balance($customer_id, $store_id = 0)
    {
        $this->db->select("sum(s.due_amt) total_due", FALSE);
        $this->db->from("sales AS s");
        $this->db->where("s.customer_id", $customer_id);
        $this->db->where("s.store_id", $store_id);
        $this->db->where("s.status_id", 1);
        $this->db->where("s.settle", 0);
        $this->db->where("s.due_amt >", 0);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
     public function update_sms_qty( $params = array()){
        $this->db->where('param_key','SMS_CONFIG');
        $qty=$params['total_sms'];
        $this->db->set('param_val', "`param_val`-$qty", FALSE);
        $this->db->set('utilized_val',$params['unit_price']);
        $res = $this->db->update('configs');
        return $res;

    }
    public function getAllCustomers(){
       // $this->load->driver('cache',array('adapter' => 'file', 'backup' => 'file'));
       // $cacheSubModuel = 'all_customers';
      //  if (!$querySub = $this->cache->get($cacheSubModuel)) {
            $this->db->select("id_customer,customer_code,full_name customer_name,store_id,phone,balance", FALSE);
            $this->db->where('status_id', 1);
            $this->db->order_by("full_name asc");
            $que2 = $this->db->get('customers');
            $querySub = $que2->result_array();
           // $this->cache->save($cacheSubModuel, $querySub, 10000);
        //}
        return $querySub;
    }
    public function checkMenuAccess($page_name=0,$module_id=0){
        $type_id = $this->session->userdata['login_info']['user_type_i92'];
        $user_id = $this->session->userdata['login_info']['id_user_i90'];
        if ($type_id != 3) {
            $this->db->select("page_name");
            $this->db->from("acl_user_pages");
            if($page_name!=''){
               $this->db->where("page_name", $page_name); 
            }
            $this->db->where("submodule_id", $module_id);
            $this->db->where("user_id",$user_id);
            $query = $this->db->get();
            return ($query->num_rows() > 0) ? $query->result() : FALSE;
        }
        return FALSE;
    }

}
