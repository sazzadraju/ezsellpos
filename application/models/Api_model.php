<?php

/**
 * Contains all common methods to be used in entire project
 *
 * @author Rafiqul Islam <rafiq.kuet@gmail.com>
 * @date September 14, 2017 10:15
 */
class Api_model extends CI_Model
{

    public function daily_sale_report($store_id)
    {
        $date = date('Y-m-d');
        $FromDate = $date . ' 00:00:00';
        $ToDate = $date . ' 23:59:59';
        $this->db->select(' SUM(a.tot_amt) AS amount, b.store_name', FALSE);
        $this->db->from('sales a');
        $this->db->join('stores b', 'a.store_id=b.id_store', 'left');
        $this->db->where('a.dtt_add >=', $FromDate);
        $this->db->where('a.dtt_add <=', $ToDate);
        if (!empty($store_id)){
            $this->db->where("a.store_id", $store_id);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function stockSummaryReports($params = array()) {
        $this->db->select('products.product_name,products.product_code,SUM(stocks.qty) as stock_qty');
        $this->db->from('products');
        $this->db->join('stocks', 'stocks.product_id=products.id_product', 'left');
        if (!empty($params['product_name'])) {
            $this->db->group_start();
            $this->db->like('product_name', $params['product_name']);
            $this->db->or_like('product_code', $params['product_name']);
            $this->db->group_end();
        }

        if (!empty($params['store_id'])) {
            $this->db->where('stocks.store_id', $params['store_id']);
        }
        $this->db->where('stocks.qty >', 0);
        $this->db->where('products.status_id', 1);
        $this->db->order_by('products.id_product', 'desc');
        $this->db->group_by('products.id_product');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function customer_view($params = array()){
        $this->db->select('a.*,b.name as customer_type_name');
        $this->db->from('customers a');
        $this->db->join('customer_types b', 'a.customer_type_id=b.id_customer_type', 'left');
        if (!empty($params['customer_name'])) {
            $this->db->like('a.full_name', $params['customer_name']);
        }
        if (!empty($params['customer_phone'])) {
            $this->db->where('a.phone', $params['customer_phone']);
        }
        $this->db->where('a.status_id', 1);
        $this->db->order_by('a.id_customer', 'desc');
        $query = $this->db->get();
        //$this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    

    public function get_print_invoice($invoice)
    {
        $this->db->select('a.*,c.fullname,b.mobile,b.address_line,b.email,b.store_name,d.full_name as customer_name,d.phone as customer_mobile');
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
        $this->db->select('a.*,c.fullname,b.mobile,b.address_line,b.email,b.store_name,d.full_name as customer_name,d.points as customer_points,e.invoice_no as ref_sale_invoice');
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
        $this->db->select("a.*,b.product_name,b.product_code");
        $this->db->from("sale_details a");
        $this->db->join('products b', 'a.product_id = b.id_product', 'left');
        $this->db->where("a.sale_id", $id);
        $this->db->where("a.sale_type_id", 1);
        $query = $this->db->get();
        $res = $query->result_array();
        //$hh= $this->bd->last_query();
        //print_r($hh);
        return $res;
    }

    public function getvalue_sale_return_details($id)
    {
        $this->db->select("a.*,b.product_name,b.product_code");
        $this->db->from("sale_details a");
        $this->db->join('products b', 'a.product_id = b.id_product', 'left');
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
        $this->db->select("a.amount as total_amount,b.payment_method_id,b.amount,a.dtt_add");
        $this->db->from("sale_transaction_details a");
        $this->db->join('sale_transaction_payments b', 'a.sale_transaction_id = b.sale_transaction_id', 'left');
        $this->db->where("a.sale_id", $id);
        $query = $this->db->get();
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
        $qry_res = $this->db->query("CALL insert_row('" . $table . "','" . $key . "','" . $value . "')");
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

    public function common_insert($tablename, $data)
    {
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

    public function store_details($company)
    {
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
}
