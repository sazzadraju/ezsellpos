<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function listAccounts($acc_type, $total, $limit, $offset=0) {
        $accounts = [];
        $this->db->select("
          a.id_account AS id
        , a.account_name
        , b.bank_name
        , a.branch_name AS bank_branch
        , a.account_no
        , a.acc_uses_id
        , a.trx_charge
        , s.`name` AS station_name
        , TRIM(TRAILING '.' FROM TRIM(TRAILING '0' from a.initial_balance)) AS initial_balance
        , TRIM(TRAILING '.' FROM TRIM(TRAILING '0' from a.curr_balance)) AS curr_balance
        , GROUP_CONCAT(st.store_name SEPARATOR '<br> ') AS stores
        ", FALSE);
        $this->db->from("accounts AS a");
        $this->db->join('banks AS b', 'b.id_bank = a.bank_id', 'left');
        $this->db->join('accounts_stores AS accst', 'accst.account_id = a.id_account', 'left');
        $this->db->join('stores AS st', 'st.id_store = accst.store_id', 'left');
        $this->db->join('stations AS s', 's.id_station = a.station_id', 'left');
        $this->db->where("a.acc_type_id", $acc_type);
        $this->db->where("a.status_id", 1);
        $this->db->where("st.id_store IN (".implode(',', $this->session->userdata['login_info']['store_ids']).")", NULL, FALSE);
        $this->db->group_by('a.id_account'); 
        switch($acc_type){
            case 1:
            case 3:
                $this->db->order_by("b.bank_name ASC", "a.account_no ASC");
                break;
            
            case 2:
            case 4:
                $this->db->order_by("a.account_name", "ASC");
                break;
        }
        
        // Set Limit and Offset
        if(isset($limit) && $total>$limit){
            if(isset($offset)){
                $this->db->limit($limit, $offset);
            } else{
                $this->db->limit($limit);
            }
        }
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        foreach($result as $res){
            $accounts[] = $res;
        }
        
        return $accounts;
    }
    
    public function getTotAccounts($acc_type){
        $this->db->select("
          a.id_account AS id
        , a.account_name
        , b.bank_name
        , a.account_no
        , a.acc_uses_id
        , GROUP_CONCAT(st.store_name) AS `stores`
        ", FALSE);
        $this->db->from("accounts AS a");
        $this->db->join('banks AS b', 'b.id_bank = a.bank_id', 'left');
        $this->db->join('accounts_stores AS accst', 'accst.account_id = a.id_account', 'left');
        $this->db->join('stores AS st', 'st.id_store = accst.store_id', 'left');
        $this->db->join('stations AS s', 's.id_station = a.station_id', 'left');
        $this->db->where("a.acc_type_id", $acc_type);
        $this->db->where("a.status_id", 1);
        $this->db->where("st.id_store IN (".implode(',', $this->session->userdata['login_info']['store_ids']).")", NULL, FALSE);
        $this->db->group_by('a.id_account'); 
        
        return $this->db->count_all_results();
    }
    
    public function accountDetails($acc_id) {
        $this->db->select("
            a.acc_type_id
            , CASE a.acc_type_id
                  WHEN 1 THEN 'Bank Account'
                  WHEN 2 THEN 'Cash Account'
                  WHEN 3 THEN 'Mobile Bank Account'
                  WHEN 4 THEN 'Station (Cash) Account'
                  ELSE NULL
              END AS account_type
            , a.acc_uses_id
            , CASE a.acc_uses_id
                  WHEN 1 THEN 'Office Account'
                  WHEN 2 THEN 'Shop Account'
                  WHEN 3 THEN 'Both'
                  ELSE NULL
              END AS acc_uses
            , a.account_name
            , b.bank_name AS bank_or_acc_name
            , a.branch_name AS branch_name
            , a.address AS address
            , a.account_no
            , a.mob_acc_type_id
            , CASE a.mob_acc_type_id
                  WHEN 1 THEN 'Business'
                  WHEN 2 THEN 'Personal'
                  WHEN 3 THEN 'Agent'
                  ELSE NULL
              END AS type_of_account
            , TRIM(TRAILING '.' FROM TRIM(TRAILING '0' FROM a.trx_charge)) AS charge_per_transaction
            , a.description AS description
            , TRIM(TRAILING '.' FROM TRIM(TRAILING '0' FROM a.initial_balance)) AS initial_balance
            , GROUP_CONCAT(st.store_name SEPARATOR ', ') AS stores
        ", FALSE);
        $this->db->from("accounts AS a");
        $this->db->join('banks AS b', 'b.id_bank = a.bank_id', 'left');
        $this->db->join('accounts_stores AS accst', 'accst.account_id = a.id_account', 'left');
        $this->db->join('stores AS st', 'st.id_store = accst.store_id', 'left');
        $this->db->where("a.id_account", $acc_id);
        $this->db->where("a.status_id", 1);
        $this->db->limit(1);
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        return isset($result[0]) ? $result[0] : array();
    }
    
    public function accountEditInfo($acc_id){
        $this->db->select("
              a.acc_type_id
            , a.acc_uses_id
            , a.account_name
            , a.bank_id
            , b.bank_name AS bank_or_acc_name
            , a.branch_name AS branch_name
            , a.address AS address
            , a.account_no
            , a.mob_acc_type_id
            , TRIM(TRAILING '.' FROM TRIM(TRAILING '0' FROM a.trx_charge)) AS charge_per_transaction
            , a.description AS description
            , TRIM(TRAILING '.' FROM TRIM(TRAILING '0' FROM a.initial_balance)) AS initial_balance
        ", FALSE);
        $this->db->from("accounts AS a");
        $this->db->join('banks AS b', 'b.id_bank = a.bank_id', 'left');
        $this->db->where("a.id_account", $acc_id);
        $this->db->where("a.status_id", 1);
        $this->db->limit(1);
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        if(isset($result[0])){
            $result[0]['store_id'] = $this->storesByAccountId($acc_id);
        }
        
        return isset($result[0]) ? $result[0] : array();
    }
    
    public function storesByAccountId($acc_id){
        
        $stores = array();
        
        $acc_id = (int)$acc_id;
        $this->db->select("store_id", FALSE);
        $this->db->from("accounts_stores");
        $this->db->where("account_id", $acc_id);
        $query = $this->db->get();
        $result = $query->result_array();
        
        foreach($result as $res){
            $stores[] = $res['store_id'];
        }
        return $stores;
    }
    
    function isCashAccountExists($chk_value, $expt_value=0) {
        $this->db->where('account_name', $chk_value);
        if(!empty($expt_value)){
            $this->db->where('id_account !=', $expt_value);
        }
        $tot = $this->db
            ->where('status_id', 1)
            ->count_all_results('accounts');
        
        return $tot>0 ? TRUE : FALSE;
    }
    
    public function isBankAccountExists($acc_no, $id=0){
        $this->db->where('account_no', $acc_no);
        if(!empty($id)){
            $this->db->where('id_account !=', $id);
        }
        $tot = $this->db
            ->where('acc_type_id', 1)
            ->where('status_id', 1)
            ->count_all_results('accounts');
        
        return $tot>0 ? TRUE : FALSE;
    }
    
    public function isMobileAccountExists($acc_no, $mobile_bank_id, $id=0) {
        $this->db->where('account_no', $acc_no);
        if(!empty($id)){
            $this->db->where('id_account !=', $id);
        }
        $tot = $this->db
            ->where('bank_id', $mobile_bank_id)
            ->where('acc_type_id', 3)
            ->where('status_id', 1)
            ->count_all_results('accounts');
        
        
        return $tot>0 ? TRUE : FALSE;
    }
}