<?php

class Audience_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function common_insert($tablename, $data) {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }
    
    public function getvalue_row($tbl, $fn, $fcon = array())
    {
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

    public function common_update($tablename, $data, $column_name, $column_id, $version = true) {
        $this->db->where($column_name, $column_id);
        if ($version) {
            $this->db->set('version', '`version`+1', FALSE);
        }
        $res = $this->db->update($tablename, $data);
        return $res;
    }

    public function common_delete($tablename, $column_name, $column_id) {
        $this->db->where($column_name, $column_id);
        $res = $this->db->delete($tablename);
        return $res;
    }

    public function common_cond_dropdown_data($tablename, $id_column, $value_column, $conditional_column, $conditional_value, $order_by, $asc_desc) {
        $this->db->select("$id_column,$value_column");
        $this->db->from("$tablename");
        $this->db->where("$conditional_column", "$conditional_value");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function common_single_value_array($tablename, $id_column, $value_column, $order_by, $asc_desc) {
        $this->db->select("$id_column,$value_column");
        $this->db->from("$tablename");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function common_cond_single_value_array($tablename, $id_column, $value_column, $conditional_column, $conditional_value, $order_by, $asc_desc) {
        $this->db->select("$id_column,$value_column");
        $this->db->from("$tablename");
        $this->db->where("$conditional_column", "$conditional_value");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function common_cond_row_array($tablename, $column_name, $value_column) {
        $this->db->select("*");
        $this->db->from("$tablename");
        $this->db->where("$column_name", "$value_column");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function check_customer_address_type($customer_id, $address_type) {
        $this->db->select("address_type");
        $this->db->from("customer_addresss");
        $this->db->where("customer_id", "$customer_id");
        $this->db->where("address_type", "$address_type");
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }

    public function common_result_array($tablename, $order_by, $asc_desc) {
        $this->db->select("*");
        $this->db->from("$tablename");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    function search_customer_list($params = array()) {
        $this->db->select('customers.*, customer_types.name,stores.store_name');
        $this->db->from('customers');
        $this->db->join('customer_types', 'customer_types.id_customer_type = customers.customer_type_id', 'LEFT');
        $this->db->join('customer_addresss', "customer_addresss.customer_id = customers.id_customer and customer_addresss.address_type LIKE  'Present Address'", 'LEFT');
        $this->db->join('loc_divisions', 'loc_divisions.id_division = customer_addresss.div_id', 'left');
        $this->db->join('loc_districts', 'loc_districts.id_district = customer_addresss.dist_id', 'left');
        $this->db->join('loc_cities', 'loc_cities.id_city = customer_addresss.city_id', 'left');
        $this->db->join('loc_areas', 'loc_areas.id_area = customer_addresss.area_id', 'left');
        $this->db->join('stores', 'stores.id_store = customers.store_id', 'left');
        // $this->db->join('loc_unions', 'loc_unions.id_union = customer_addresss.unn_id', 'left');
        // $this->db->join('loc_upazilas', 'loc_upazilas.id_upazila = customer_addresss.upz_id', 'left');
        if (!empty($params['search']['store_id'])) {
            $this->db->where('customers.store_id', $params['search']['store_id']);
        }
        if (!empty($params['search']['div_id'])) {
            $this->db->where('loc_divisions.id_division', $params['search']['div_id']);
        }
        if (!empty($params['search']['dist_id'])) {
            $this->db->where('loc_districts.id_district', $params['search']['dist_id']);
        }
        if (!empty($params['search']['city_id'])) {
            $this->db->where('loc_cities.id_city', $params['search']['city_id']);
        }
        if (!empty($params['search']['area_id'])) {
            $this->db->where('loc_areas.id_area', $params['search']['area_id']);
        }
        if (!empty($params['search']['cus_address'])) {
            $this->db->like('customer_addresss.addr_line_1', $params['search']['cus_address']);
        }
        if (!empty($params['search']['name_customer'])) {
            $this->db->like('full_name', $params['search']['name_customer']);
        }

        if (!empty($params['search']['phone_customer'])) {
            $this->db->like('phone', $params['search']['phone_customer']);
        }

        if (!empty($params['search']['type_of_customer'])) {
            $this->db->where('customer_type_id', $params['search']['type_of_customer']);
        }

        $this->db->where('customers.status_id =', '1');
        $this->db->order_by('customers.id_customer', 'desc');
        
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }


        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        //exit();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function search_supplier_list($params = array()) {
        $this->db->select('*');
        $this->db->from('suppliers');
        if (!empty($params['search']['name_supplier'])) {
            $this->db->like('supplier_name', $params['search']['name_supplier']);
        }

        if (!empty($params['search']['phone_supplier'])) {
            $this->db->like('phone', $params['search']['phone_supplier']);
        }
        if (!empty($params['search']['email_supplier'])) {
            $this->db->like('email', $params['search']['email_supplier']);
        }
        if (!empty($params['search']['inactive_supplier'])) {
            $this->db->where('status_id !=', 1);
        }else{
            $this->db->where('status_id', 1);
        }
        $this->db->order_by('id_supplier', 'desc');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function all_audience_list($params=array()){
        $this->db->select('ssp.*');
        $this->db->from('sms_set_person ssp');
        $this->db->where('status_id', 1);
        $this->db->order_by('id_set_person', 'desc');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function getDetailsById($id){
        $this->db->select('pd.*');
        $this->db->from('sms_set_person_details pd');
        $this->db->where('set_person_id', $id);
        $this->db->where('status_id', 1);
        //$this->db->order_by('id_set_person', 'desc');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

}
