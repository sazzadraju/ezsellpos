<?php

class Fund_transfer_Model extends CI_Model {

    
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
    public function getRowsTransfer($params = array()){
        $this->db->select("
        t.id_fund_transfer                    AS id
        , t.acc_from_id                         AS acc_frm
        , t.acc_to_id                           AS acc_to
        , t.amount
        , t.description
        , t.dtt_add
        , u.fullname
        ,fst.store_name                        AS from_store
        ,tst.store_name                        AS to_store
        ", FALSE);
        $this->db->from("fund_transfers t");
        $this->db->join("accounts_stores AS a", "a.account_id = t.acc_from_id");
        $this->db->join("accounts_stores AS ta", "ta.account_id = t.acc_to_id");
        $this->db->join("stores AS fst", "a.store_id = fst.id_store");
        $this->db->join("stores AS tst", "ta.store_id = tst.id_store");
        $this->db->join("users AS u", "t.uid_add = u.id_user");
        if (!empty($params['search']['from_store'])) {
            $this->db->where('a.store_id', $params['search']['from_store']);
        }
        if (!empty($params['search']['to_store'])) {
            $this->db->where('ta.store_id', $params['search']['to_store']);
        }
        if (!empty($params['search']['acc_frm'])) {
            $this->db->where('a.account_id', $params['search']['acc_frm']);
        }
        if (!empty($params['search']['acc_to'])) {
            $this->db->where('ta.account_id', $params['search']['acc_to']);
        }
        if (!empty($params['search']['user_id'])) {
            $this->db->where('u.id_user', $params['search']['user_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("t.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("t.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where("t.status_id", 1);
        $this->db->order_by("t.dtt_add DESC");
        $this->db->group_by("t.id_fund_transfer");
        

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

        
    }
    function getRowsSummary($params = array()) {
        // $this->db->distinct('dtt_add');
        $this->db->select('sd.brand_id,sd.product_id,sd.dtt_add,sa.store_id,sa.invoice_no,p.product_name,pb.brand_name,st.store_name,SUM(sd.selling_price_act) as amt,SUM(sd.qty) AS qty,stk.batch_no,SUM(sd.selling_price_est) as unit_price,SUM(sd.vat_amt) as vat_amt,SUM(sd.discount_amt) as discount_amt,p.product_code,c.full_name customer_name');
        $this->db->from('sale_details sd');
        $this->db->join('sale_adjustments sa','sd.sale_id = sa.id_sale_adjustment');
        $this->db->join('products p', 'sd.product_id= p.id_product');
        $this->db->join('product_brands pb', 'pb.id_product_brand=sd.brand_id');
        $this->db->join('customers c', 'c.id_customer=sa.customer_id','left');
        $this->db->join('stores st', 'sa.store_id= st.id_store');
        $this->db->join('stocks stk', 'stk.id_stock= sd.stock_id');
        if (!empty($params['search']['brand'])) {
            $this->db->where('pb.id_product_brand', $params['search']['brand']);
        }
        if (!empty($params['search']['store_id'])) {
            $this->db->where('sa.store_id', $params['search']['store_id']);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('sa.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['invoice_no'])) {
            $this->db->like('sa.invoice_no', $params['search']['invoice_no']);
        }
        if (!empty($params['search']['product_id'])) {
            $this->db->where('sd.product_id', $params['search']['product_id']);
        }
        if (!empty($params['search']['batch_no'])) {
            $this->db->like('stk.batch_no', $params['search']['batch_no']);
        }
         if (!empty($params['search']['store_id'])) {
            $this->db->where('sa.store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['customer_id'])) {

            $this->db->where('sa.customer_id', $params['search']['customer_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("sd.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("sd.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('sd.status_id', 1);
        $this->db->where('sd.sale_type_id', 2);
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->group_by(array("DATE(sd.dtt_add)","sd.product_id","stk.batch_no","sa.invoice_no","sa.store_id"));
        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }  
    public function listAuthicatedAccounts() {
      $accounts = [];
      $sql = "SELECT
      a.id_account AS acc_id
      , a.acc_type_id AS acc_type
      , a.account_no AS acc_no
      , st.store_name
      , CASE a.acc_type_id
      WHEN 2 THEN a.account_name
      WHEN 4 THEN a.account_name
      ELSE b.bank_name
      END AS acc_name
      FROM accounts a
      INNER JOIN accounts_stores AS s ON s.account_id = a.id_account
      INNER JOIN stores AS st ON s.store_id = st.id_store
      LEFT JOIN banks AS b ON b.id_bank = a.bank_id
      WHERE a.status_id = 1
      AND s.store_id IN (". implode(',', $this->session->userdata['login_info']['store_ids']) .")
      ORDER BY (s.store_id)";
    //        echo '<pre>'; echo $sql; echo '</pre>'; exit;
      $q = $this->db->query($sql);

      if ($q->num_rows() > 0) {
         foreach($q->result_array() as $row) {
          $accounts[] = $row;
        }
      }
      return $accounts;
    }
    public function get_store_accounts($id) {
      $accounts = [];
      $sql = "SELECT
      a.id_account AS acc_id
      , a.acc_type_id AS acc_type
      , a.account_no AS acc_no
      , st.store_name
      , CASE a.acc_type_id
      WHEN 2 THEN a.account_name
      WHEN 4 THEN a.account_name
      ELSE b.bank_name
      END AS acc_name
      FROM accounts a
      INNER JOIN accounts_stores AS s ON s.account_id = a.id_account
      INNER JOIN stores AS st ON s.store_id = st.id_store
      LEFT JOIN banks AS b ON b.id_bank = a.bank_id
      WHERE a.status_id = 1
      AND s.store_id=$id
      ORDER BY (s.store_id)";
    //        echo '<pre>'; echo $sql; echo '</pre>'; exit;
      $q = $this->db->query($sql);

      if ($q->num_rows() > 0) {
         foreach($q->result_array() as $row) {
          $accounts[] = $row;
        }
      }
      return $accounts;
    }
    

}

