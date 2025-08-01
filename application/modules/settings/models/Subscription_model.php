<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    public function getClientId() {
        $this->db->select("param_val", FALSE);
        $this->db->from("configs");
        $this->db->where("param_key", 'CLIENT_ID');
        $this->db->limit('1');
        $q = $this->db->get();
        $r = $q->row_array();
        return isset($r['param_val']) ? $r['param_val'] : false;
    }
    
    public function updSubsInfo($data, $uid_upd_by=0){
        
        $now = date('Y-m-d H:i:s');
        
        $frm = ['param_val'=>$data['subscription_from_date'], 'dtt_mod'=>$now];
        $to  = ['param_val'=>$data['subscription_to_date'], 'dtt_mod'=>$now];
        $sts = ['param_val'=>'Active', 'dtt_mod'=>$now];
        
        $uid_upd_by = (int)$uid_upd_by;
        if(!empty($uid_upd_by)){
            $frm['uid_mod'] = $uid_upd_by;
            $to['uid_mod']  = $uid_upd_by;
            $sts['uid_mod'] = $uid_upd_by;
        }
        
        $this->commonmodel->commonUpdate('configs', $frm, ['param_key'=>'SUBSCRIPTION_FROM']);
        $this->commonmodel->commonUpdate('configs', $to,  ['param_key'=>'SUBSCRIPTION_TO']);
        $this->commonmodel->commonUpdate('configs', $sts, ['param_key'=>'SUBSCRIPTION_STATUS']);
    }
}