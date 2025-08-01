<?php

class Ajx_model  extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function list_customers($key) {
        $this->db->select("
            id_customer     AS id, 
            customer_code   AS code, 
            full_name       AS name,
            phone");
        $this->db->from("customers");
        $this->db->where("(full_name LIKE '%".$key."%' OR customer_code LIKE '%".$key."%' OR phone LIKE '%".$key."%')", NULL, FALSE);
        $this->db->where("status_id !=", 2);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    
    public function list_suppliers($key){
        $this->db->select("
            id_supplier     AS id, 
            supplier_code   AS code, 
            supplier_name   AS name,
            phone");
        $this->db->from("suppliers");
        $this->db->where("(supplier_code LIKE '%".$key."%' OR supplier_name LIKE '%".$key."%' OR phone LIKE '%".$key."%')", NULL, FALSE);
        $this->db->where("status_id !=", 2);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_employees($key){
        $this->db->select("
            id_user     AS id, 
            fullname   AS name,
            mobile  AS phone");
        $this->db->from("users");
        $this->db->where("(uname LIKE '%".$key."%' OR fullname LIKE '%".$key."%')", NULL, FALSE);
        $this->db->where("user_type_id", 1);
        $this->db->where("status_id !=", 2);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_investors($key){
        $this->db->select("
            id_user     AS id, 
            fullname   AS name,
            mobile  AS phone");
        $this->db->from("users");
        $this->db->where("(uname LIKE '%".$key."%' OR fullname LIKE '%".$key."%')", NULL, FALSE);
        $this->db->where("user_type_id", 2);
        $this->db->where("status_id !=", 2);
        $query = $this->db->get();
        return $query->result_array();
    }
}
