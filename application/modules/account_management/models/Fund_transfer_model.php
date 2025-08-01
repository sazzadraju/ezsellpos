<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fund_transfer_model extends CI_Model {
  function __construct() {
    parent::__construct();
  }
  
  public function listAccounts() {
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
    ORDER BY (s.store_id)";
    
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
     foreach($q->result_array() as $row) {
      $accounts[] = $row;
    }
  }
  return $accounts;
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

public function getAccCurBalance($acc_id){
  $this->db->select('curr_balance');
  $this->db->where('id_account', $acc_id); 
  $q = $this->db->get('accounts');
  
  if ($q->num_rows() > 0) {
    $res = $q->result();
    return $res[0]->curr_balance;
  } 
  return '0';
}


public function addFundTransfer($data){
  try{
    $this->db->trans_start();
    
            ## ADD fund_transfers TBL. 
    $id = $this->commonmodel->commonInsert('fund_transfers', $data);
    
            ## UPD FROM account TBL
    $sql = "UPDATE accounts SET `curr_balance` = `curr_balance` - {$data['amount']}
    , `dtt_mod` = '{$data['dtt_add']}'
    , `uid_mod` = '{$data['uid_add']}'
    WHERE id_account = {$data['acc_from_id']}";
    $this->db->query($sql);
    
            ## UPD TO account TBL
    $sql = "UPDATE accounts SET `curr_balance` = `curr_balance` + {$data['amount']}
    , `dtt_mod` = '{$data['dtt_add']}'
    , `uid_mod` = '{$data['uid_add']}'
    WHERE id_account = {$data['acc_to_id']}";
    $this->db->query($sql);
    
    $this->db->trans_complete();
    
    if ($this->db->trans_status() === FALSE) {
      throw new Exception("Fund Transfer Save Failed.");
    }
    
    $response = [
      'status' => 'success',
      'message' => "Fund Transfer Saved Successfully."
    ];
    return TRUE;
    
  } catch (Exception $e) {
    $this->db->trans_rollback();
//            $response = [
//                'status' => 'failed',
//                'message' => "Fund Transfer Save Failed."
//            ];
    return FALSE;
  }
  
        //return $response;
}


public function totalRecords(){
  $this->db->select("1 AS id", FALSE);
  $this->db->from("fund_transfers");
  $this->db->where("status_id", 1);
  return $this->db->count_all_results();
}


public function listRecords($total, $limit, $offset=0){
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
  if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
    $this->db->where('a.store_id', $this->session->userdata['login_info']['store_id']);
  }
  $this->db->where("t.status_id", 1);
  $this->db->order_by("t.dtt_add DESC");
  $this->db->group_by("t.id_fund_transfer");
  if(isset($limit) && $total>$limit){
    if(isset($offset)){
      $this->db->limit($limit, $offset);
    } else{
      $this->db->limit($limit);
    }
  }
  
  $query = $this->db->get();
  return $query->result_array();
}
}
