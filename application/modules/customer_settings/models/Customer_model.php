<?php

class Customer_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

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

    public function common_insert($tablename, $data) {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

    public function common_update($tablename, $data, $column_name, $column_id, $version = true) {
        $this->db->where($column_name, $column_id);
        if($version){
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
    public function update_value($tblname, $setvalue = array(), $convalue = array(), $version = true) {
        $this->sql = '';
        $this->key = '';
        $this->value = '';
        $this->key = array_keys($convalue);
        $this->value = array_values($convalue);
        for ($i = 0; $i < count($convalue); $i++) {
            $this->db->where($this->key[$i], $this->value[$i]);
        }
        $update = $this->db->update($tblname, $setvalue);
        if ($update) {
            return true;
        }
        return false;
    }
    public function getvalue_row_one($tbl, $fn, $fcon = array())
    {
        $this->db->select($fn);
        $this->db->where($fcon);
        $q = $this->db->get($tbl);
        if ($q->num_rows() > 0) {
            $res = $q->result_array();
            return $res;
        }
        return false;
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
    public function customer_sale_invoice($customer_id){
        $this->db->select("a.*,b.store_name");
        $this->db->from("sales a");
        $this->db->join('stores b', 'a.store_id = b.id_store');
        $this->db->where("a.customer_id", $customer_id);
        $this->db->order_by("a.id_sale", "DESC");
        $this->db->limit(20);
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

    public function get_customer_details($customer_id) {
        $this->db->select("customers.*, customer_types.name");
        $this->db->from("customers");
        $this->db->join('customer_types', 'customer_types.id_customer_type = customers.customer_type_id', 'left');
        $this->db->where("customers.id_customer", "$customer_id");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_customer_address_result($customer_id) {
        $this->db->select("customer_addresss.*, loc_divisions.division_name_en, loc_divisions.division_name_bn, loc_districts.district_name_en, loc_districts.district_name_bn, loc_cities.city_name_en, loc_cities.city_name_bn, loc_areas.area_name_en, loc_areas.area_name_bn, loc_areas.area_name_bn, loc_unions.union_name_en, loc_unions.union_name_bn, loc_upazilas.upazila_name_en, loc_upazilas.upazila_name_bn");
        $this->db->from("customer_addresss");
        $this->db->join('loc_divisions', 'loc_divisions.id_division = customer_addresss.div_id', 'left');
        $this->db->join('loc_districts', 'loc_districts.id_district = customer_addresss.dist_id', 'left');
        $this->db->join('loc_cities', 'loc_cities.id_city = customer_addresss.city_id', 'left');
        $this->db->join('loc_areas', 'loc_areas.id_area = customer_addresss.area_id', 'left');
        $this->db->join('loc_unions', 'loc_unions.id_union = customer_addresss.unn_id', 'left');
        $this->db->join('loc_upazilas', 'loc_upazilas.id_upazila = customer_addresss.upz_id', 'left');
        $this->db->where("customer_addresss.customer_id", "$customer_id");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_customer_document_result($customer_id) {
        $this->db->select("*");
        $this->db->from("documents");
        $this->db->where("doc_type", "Customer");
        $this->db->where("ref_id", "$customer_id");
        $this->db->where("status_id", "1");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_customer_document_result_pagination($params = array()) {
        $this->db->select("*");
        $this->db->from("documents");
        //$this->db->where("ref_id","$customer_id");
        if (!empty($params['search']['id_customer'])) {
            $this->db->where('ref_id', $params['search']['id_customer']);
        }
        $this->db->where("doc_type", "Customer");
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function get_customer_address_pagination($params = array()) {
        $this->db->select("customer_addresss.*, loc_divisions.division_name_en, loc_divisions.division_name_bn, loc_districts.district_name_en, loc_districts.district_name_bn, loc_cities.city_name_en, loc_cities.city_name_bn, loc_areas.area_name_en, loc_areas.area_name_bn, loc_areas.area_name_bn, loc_unions.union_name_en, loc_unions.union_name_bn, loc_upazilas.upazila_name_en, loc_upazilas.upazila_name_bn");
        $this->db->from("customer_addresss");
        $this->db->join('loc_divisions', 'loc_divisions.id_division = customer_addresss.div_id', 'left');
        $this->db->join('loc_districts', 'loc_districts.id_district = customer_addresss.dist_id', 'left');
        $this->db->join('loc_cities', 'loc_cities.id_city = customer_addresss.city_id', 'left');
        $this->db->join('loc_areas', 'loc_areas.id_area = customer_addresss.area_id', 'left');
        $this->db->join('loc_unions', 'loc_unions.id_union = customer_addresss.unn_id', 'left');
        $this->db->join('loc_upazilas', 'loc_upazilas.id_upazila = customer_addresss.upz_id', 'left');
        if (!empty($params['search']['id_customer'])) {
            $this->db->where('customer_addresss.customer_id', $params['search']['id_customer']);
        }
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    function all_customer_type_list($params = array()) {
        $this->db->select('*');
        $this->db->from('customer_types');
        $this->db->where('status_id =', '1');
        $this->db->order_by('id_customer_type', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function all_customer_list($params = array()) {
        $this->db->select('customers.*, customer_types.name,customer_addresss.*,loc_divisions.division_name_en, loc_districts.district_name_en, loc_cities.city_name_en, loc_areas.area_name_en,stores.store_name');
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


    public function get_customer_type_by_id($id) {
        $this->db->select('*');
        $this->db->from('customer_types');
        $this->db->where('id_customer_type', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function check_value($table, $column, $value) {
        $tot = $this->db
                ->where($column, $value)
                ->where('status_id', 1)
                ->count_all_results($table);

        return $tot > 0 ? TRUE : FALSE;
    }

    public function isExistExcept($table, $chk_column, $chk_value, $expt_column, $expt_value) {
        $tot = $this->db
            ->where($chk_column, $chk_value)
            ->where($expt_column.' !=', $expt_value)
            ->where('status_id', 1)
            ->count_all_results($table);
        
        return $tot>0 ? 1 : 0;
    }
    public function get_customer_autocomplete($request){
        $this->db->select("*");
        $this->db->from("customers");
        $this->db->group_start();
        $this->db->like("full_name", $request);
        $this->db->or_like("customer_code", $request);
        $this->db->or_like("phone", $request);
        $this->db->group_end();
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }
    public function due_customer_list(){
        $this->db->select("c.id_customer,c.customer_code,c.full_name,c.phone,c.balance,ct.name type_name");
        $this->db->from("customers c");
        $this->db->join('customer_types ct', 'ct.id_customer_type = c.customer_type_id', 'LEFT');
        $this->db->where("c.status_id", 1);
        $this->db->where("c.balance > 0");
        $this->db->order_by('c.full_name','asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        //exit();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

}

?>