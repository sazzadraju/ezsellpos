<?php

class Auth_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_password($tablename, $column_name, $value_column) {
        $this->db->select("passwd, salt");
        $this->db->from("$tablename");
        $this->db->where("$column_name", "$value_column");
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }

    public function login_row_array($tablename, $column_name, $value_column) {
        $this->db->select("a.*,b.name as station_name,c.store_name,c.address_line as address,c.mobile as store_mobile,c.store_img,c.email as store_email");
        $this->db->from("$tablename a");
        $this->db->join('stations b', 'b.id_station = a.station_id', 'left');
        $this->db->join('stores c', 'c.id_store = a.store_id', 'left');
        $this->db->where("$column_name", "$value_column");
        $this->db->where("a.status_id", 1);
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }
    public function get_user_account_id($station_id,$store_id){
        $this->db->select("a.id_account");
        $this->db->from("accounts a");
        $this->db->join('accounts_stores b', 'b.account_id = a.id_account AND a.acc_type_id = 4');
        $this->db->where("a.station_id", "$station_id");
        $this->db->where("b.store_id", "$store_id");
        $this->db->where("a.status_id", 1);
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }

    public function subscription_check()
    {
        $data = array();
        $this->db->select("param_key, param_val,utilized_val");
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
    public function update_config($key,$date){
        $this->db->where('param_key', $key);
        $this->db->update('configs', $date);
    }



}

?>