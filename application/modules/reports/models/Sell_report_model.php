<?php

class Sell_report_Model extends CI_Model {

    
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

    
    

    function getRowsProducts($params = array()) {
        // $this->db->distinct('s.invoice_no');
        $this->db->select('s.*,c.full_name as customer_name,st.name as station_name,u.fullname as user_name,str.store_name,ct.name as customer_type');
        $this->db->from('sales s');
        $this->db->join('customers c','s.customer_id = c.id_customer','left');
        $this->db->join('customer_types ct','c.customer_type_id = ct.id_customer_type','left');
        $this->db->join('stations st','s.station_id = st.id_station','left');
        $this->db->join('users u','s.uid_add = u.id_user');
        $this->db->join('stores str','s.store_id =str.id_store');

        if (!empty($params['search']['gift_sale'])) {
            $this->db->where('s.gift_sale', 1);
        }

        if (!empty($params['search']['sales_person'])) {
            $this->db->where('s.sales_person_id', $params['search']['sales_person']);
        }
        if (!empty($params['search']['sold_by'])) {
            $this->db->where('s.uid_add', $params['search']['sold_by']);
        }
        if (!empty($params['search']['invoice_no'])) {
            $this->db->like('s.invoice_no', $params['search']['invoice_no']);
        }
        if (!empty($params['search']['station_id'])) {
            $this->db->where('s.station_id', $params['search']['station_id']);
        }
         if (!empty($params['search']['store_id'])) {
            $this->db->where('s.store_id', $params['search']['store_id']);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['customer_id'])) {

            $this->db->where('s.customer_id', $params['search']['customer_id']);
        }
        if (!empty($params['search']['type'])) {
            $this->db->where('ct.id_customer_type', $params['search']['type']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("s.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('s.status_id', 1);
        $this->db->order_by('s.id_sale', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->group_by('s.invoice_no');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }  
    public function getSoldByList(){
        $this->db->select('id_user,fullname');
        $this->db->from('users');
        $this->db->group_start();
        $this->db->where("user_type_id",1);
        $this->db->or_where("user_type_id",3);
        $this->db->group_end();
        if ($this->session->userdata['login_info']['user_type_i92'] == 1) {
            $this->db->where('id_user', $this->session->userdata['login_info']['id_user_i90']);
        }
        $this->db->where("id_user != ",1);
        $this->db->where("uname !=",'');
        $this->db->where("status_id",1);
        $this->db->order_by('fullname', 'asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function sale_promotion_list($id){
        $this->db->select('promotion_type_id,discount_amt,discount_rate');
        $this->db->from('sale_promotions');
        $this->db->where('sale_id', $id);
        $this->db->order_by('id_sale_promotion', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    } 
    // function get_invoice_amount($params = array()) {
    //     // $this->db->distinct('s.invoice_no');
    //     $this->db->select('count(s.id_sale)as total_count,sum(s.product_amt) as invoice_amt');
    //     $this->db->from('sales s');
    //     $this->db->join('customers c','s.customer_id = c.id_customer','left');
    //     $this->db->join('customer_types ct','c.customer_type_id = ct.id_customer_type','left');
    //     $this->db->join('stations st','s.station_id = st.id_station','left');
    //     $this->db->join('users u','s.uid_add = u.id_user');
    //     $this->db->join('stores str','s.store_id =str.id_store');

    //     if (!empty($params['search']['invoice_no'])) {
    //         $this->db->like('s.invoice_no', $params['search']['invoice_no']);
    //     }
    //     if (!empty($params['search']['station_id'])) {
    //         $this->db->where('s.station_id', $params['search']['station_id']);
    //     }
    //      if (!empty($params['search']['store_id'])) {
    //         $this->db->where('s.store_id', $params['search']['store_id']);
    //     }
    //     else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
    //         $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
    //     }
    //     if (!empty($params['search']['customer_id'])) {

    //         $this->db->where('s.customer_id', $params['search']['customer_id']);
    //     }
    //     if (!empty($params['search']['type'])) {
    //         $this->db->where('ct.id_customer_type', $params['search']['type']);
    //     }
    //     if (!empty($params['search']['FromDate'])) {
    //         $this->db->where("s.dtt_add >=", $params['search']['FromDate']);
    //         $this->db->where("s.dtt_add <=", $params['search']['ToDate']);
    //     }
    //     $this->db->where('s.status_id', 1);
    //     $this->db->order_by('s.id_sale', 'desc');
    //     //set start and limit
    //     $this->db->group_by('s.invoice_no');
    //     $query = $this->db->get();
    //     //echo $this->db->last_query();
    //     return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    // }
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

