<?php

class Delivery_report_Model extends CI_Model {

    
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
    public function getvalue_row_array($tbl, $fn, $fcon = array()) {
        $this->db->select($fn);
        $this->db->where($fcon);
        $query = $this->db->get($tbl);
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function getOrderData($params = array()){
        $this->db->select('do.*,u.fullname,s.tot_amt as sale_amt,s.paid_amt as sale_paid,s.due_amt as sale_due,s.round_amt sale_round,s.notes,su.fullname as sale_by,s.notes');
        $this->db->from('delivery_order_details do');
        $this->db->join('delivery_persons dp', 'dp.id_delivery_person=do.person_id and do.type_id=1', 'left');
        $this->db->join('users u', 'u.id_user=dp.ref_id and dp.type_id=1', 'left');
        $this->db->join('sales s', 'do.sale_id=s.id_sale', 'left');
        $this->db->join('users su', 'su.id_user=s.uid_add', 'left');
        if (!empty($params['search']['sales_person'])) {
            $this->db->where('s.sales_person_id', $params['search']['sales_person']);
        }
        if (!empty($params['search']['note'])) {  
            $this->db->like('s.notes', $params['search']['note']);
        }
        if (!empty($params['search']['customer_id'])) {  
            $this->db->where('do.customer_id', $params['search']['customer_id']);
        }
        if (!empty($params['search']['invoice_no'])) {  
            $this->db->like('do.invoice_no', $params['search']['invoice_no']);
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
            $this->db->where('s.uid_add', $this->session->userdata['login_info']['id_user_i90']);
        }
        if (!empty($params['search']['delivery_type'])) {  
            $this->db->where('do.type_id', $params['search']['delivery_type']);
        }
        if (!empty($params['search']['ref_no'])) {  
            $this->db->like('do.reference_num', $params['search']['ref_no']);
        }
        if (!empty($params['search']['status'])) {  
            $this->db->like('do.order_status', $params['search']['status']);
        }
        if (!empty($params['search']['person_name'])) {
            if($params['search']['delivery_type']==2){
                 $this->db->where('do.ref_id', $params['search']['person_name']);
            }else{
                $this->db->where('u.id_user', $params['search']['person_name']);
            }
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("do.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("do.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('do.status_id', 1);
        $this->db->order_by('do.id_delivery_order', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }


        
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function getSales_person_list($params = array()){
        $this->db->select("sp.*,
        CASE sp.person_type
            WHEN '1' THEN u.fullname
            WHEN '2' THEN u.fullname
            WHEN '3' THEN s.supplier_name
            WHEN '4' THEN c.full_name
        END AS user_name,
        CASE sp.person_type
            WHEN '1' THEN u.mobile
            WHEN '2' THEN u.mobile
            WHEN '3' THEN s.phone
            WHEN '4' THEN c.phone
        END AS phone
        ");
        $this->db->from("sales_person sp");
        $this->db->join('users u', 'u.id_user = sp.person_id and (sp.person_type=1 OR sp.person_type=2)', 'left');
        $this->db->join('suppliers s', 's.id_supplier = sp.person_id and sp.person_type=3', 'left');
        $this->db->join('customers c', 'c.id_customer = sp.person_id and sp.person_type=4', 'left');
        $this->db->where("sp.status_id", "1");
        $this->db->order_by("sp.id_sales_person", "desc");
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            return $res;
        }
        return false;
    }

    
    

    
    

}

