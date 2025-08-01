<?php

class Transaction_categories_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function getTotTransactionCatories(){
        return $this->db
                ->where('status_id', 1)
                ->count_all_results('transaction_categories');
    }
    
    public function listTransactionCatories($limit, $offset=0) {
        
        $sql = "SELECT 
                p.`id_transaction_category`  AS `id`
              , p.`trx_name` 	AS `category`
              , '' 			AS `child_category`
              , '' 			AS `parent_id`
              , p.`qty_modifier`
              , p.status_id
              FROM transaction_categories p
              WHERE p.`parent_id` IS NULL OR p.`parent_id`=0
              AND p.status_id = 1
              UNION
              SELECT 
                c.`id_transaction_category`
              , p.`trx_name`
              , c.`trx_name`
              , p.`id_transaction_category`
              , c.`qty_modifier`
              , c.status_id
              FROM transaction_categories p
              INNER JOIN transaction_categories c ON p.`id_transaction_category` = c.`parent_id`
              WHERE c.`parent_id`!=0
              AND c.status_id = 1
              ORDER BY `category` ASC, `child_category` ASC";
            
        //$sql .= "LIMIT 2  OFFSET 2";
        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        
        return $result;
    }
    
    public function get_category_data_by_id($id){
        $this->db->select("
                trx_name
              , parent_id
              , qty_modifier
            ", FALSE);
        $this->db->from("transaction_categories");
        $this->db->where("id_transaction_category", $id);
        $this->db->where("status_id", 1);
        $this->db->limit(1);
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        return isset($result[0]) ? $result[0] : array();
    }
    
    public function listParentCatories($cat_type=1) {
        $pcats = [];
        
        $this->db->select("
              id_transaction_category AS id
            , trx_name
            , qty_modifier
            ", FALSE);
        $this->db->from("transaction_categories");
        $this->db->where("status_id", 1);
        //$this->db->where("parent_id", 1);
        $this->db->where('parent_id',0);
        $this->db->order_by("trx_name", "asc");
        
        $query = $this->db->get();
        $result = $query->result();
        //echo $this->db->last_query($result); exit;
        
        foreach($result as $res){
            $pcats[$res->qty_modifier][$res->id] = $res->trx_name;
        }
        
        return $pcats;
    }
    public function listParentCatoriesId($cat_type) {
        $pcats = [];

        $this->db->select("
              id_transaction_category AS id
            , trx_name
            , qty_modifier
            ", FALSE);
        $this->db->from("transaction_categories");
        $this->db->where("status_id", 1);
        $this->db->where("qty_modifier", $cat_type);
        $this->db->where('parent_id', 0);
        $this->db->order_by("trx_name", "asc");

        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }


    
    public function hasChildCat($cat_name){

        /*SELECT COUNT(*) AS `numrows` 
          FROM `transaction_categories` `t` 
            JOIN `transaction_categories` `p` ON p.`parent_id` = t.`id_transaction_category` 
          WHERE `t`.`trx_name` = 'bbbb';*/
        
        $tot = $this->db
            ->from("transaction_categories t")
            ->join("transaction_categories p", "p.`parent_id` = t.`id_transaction_category`")
            ->where('t.trx_name', $cat_name)
            ->count_all_results();
        
        return $tot>0 ? TRUE : FALSE;
    }
    
    public function isDeletable($id){
        
        /*SELECT 
            COUNT(*) AS `numrows` 
          FROM `transaction_categories` `t` 
          JOIN `transaction_categories` `p` ON p.`parent_id` = t.`id_transaction_category` 
          WHERE
            t.`id_transaction_category` = 2
            AND t.`status_id`=1*/
        $tot = $this->db
            ->from("transaction_categories t")
            ->join("transaction_categories p", "p.`parent_id` = t.`id_transaction_category`")
            ->where('t.id_transaction_category', $id)
            ->where('t.status_id', 1)
            ->where('p.status_id', 1)
            ->count_all_results();
        
        return $tot>0 ? TRUE : FALSE;
        
    }
    public function isTransactionDelete($id){
        $tot = $this->db
            ->from("transactions t")
            ->where('t.ref_id', $id)
            ->where('t.trx_with', 'office')
            ->where('t.status_id', 1)
            ->count_all_results();

        return $tot>0 ? TRUE : FALSE;

    }
}
