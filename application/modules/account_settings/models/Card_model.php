<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function listCards($limit=0, $offset=0) {
        
        $cards = [];
        $this->db->select("id_card_type, card_name");
        $this->db->from("card_types");
        $this->db->where("status_id", 1);
        $this->db->order_by("card_name", "asc");
        
        // Set Limit and Offset
        if(isset($limit) && empty($limit)){
            if(isset($offset)){
                $this->db->limit($limit, $offset);
            } else{
                $this->db->limit($limit);
            }
        }
        
        $query = $this->db->get();
        $result = $query->result();
        
        foreach($result as $res){
            $cards[$res->id_card_type] = $res->card_name;
        }
        return $cards;
    }
}
