<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function listBanks($type, $total, $limit, $offset=0) {
        $banks = [];
        $this->db->select("id_bank, bank_name");
        $this->db->from("banks");
        $this->db->where("bank_type_id", $type);
        $this->db->where("status_id", 1);
        $this->db->order_by("bank_name", "asc");
        
        // Set Limit and Offset
        if(isset($limit) && $total>$limit){
            if(isset($offset)){
                $this->db->limit($limit, $offset);
            } else{
                $this->db->limit($limit);
            }
        }
        
        $query = $this->db->get();
        $result = $query->result();
        
        //$sql = $this->db->last_query();
        //die($sql);
        
        foreach($result as $res){
            $banks[$res->id_bank] = $res->bank_name;
        }
        return $banks;
    }
    
    public function listBanksAll($type) {
        $banks = [];
        $this->db->select("id_bank, bank_name");
        $this->db->from("banks");
        $this->db->where("bank_type_id", $type);
        $this->db->where("status_id", 1);
        $this->db->order_by("bank_name", "asc");
        
        $query = $this->db->get();
        $result = $query->result();
        
        foreach($result as $res){
            $banks[$res->id_bank] = $res->bank_name;
        }
        return $banks;
    }
    
    public function addUpdBank($data){
        if(empty($data['hid'])){
            $data['status_id'] = 1;
            $data['version'] = 1;
            $this->db->insert('banks', $data);
            $sts = $this->db->insert_id();
            $msg = lang("update_success");
        } else{
            $this->db->where('id_bank', $data['hid']);
            $sts = $this->db->update('banks', $data);
            $msg = lang("add_success");
        }
        return $sts ? $msg : false;
    }
    
    public function addBank($data){
        $data['status_id'] = 1;
        $data['version'] = 1;
        $data['dtt_add'] = date('Y-m-d H:i:s');
        $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
        $this->db->insert('banks', $data);
        $sts = $this->db->insert_id();
        return $sts;
    }
    
    public function updateBank($data, $id){
        $data['status_id'] = 1;
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $this->db->where('id_bank', $id);
        $sts = $this->db->update('banks', $data);
        return $sts;
    }
    
    public function deleteBank($id){
        $data['status_id'] = 2;
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $this->db->where('id_bank', $id);
        $sts = $this->db->update('banks', $data);
        return $sts ? TRUE : FALSE;
    }
    
    public function getTotBanks($bank_type){
        return $this->db
                ->where('status_id', 1)
                ->where('bank_type_id',$bank_type)
                ->count_all_results('banks');
    }
    
    public function getBankById($id){
        $this->db->select("id_bank AS `id`, `bank_type_id` AS `type_id`, bank_name AS `bank`");
        $this->db->from("banks");
        $this->db->where("id_bank", $id);
        $query = $this->db->get();
        $res = $query->result();
        return isset($res[0]) ? $res[0] : null;
    }
}
