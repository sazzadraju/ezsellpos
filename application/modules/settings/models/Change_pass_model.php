<?php

class Change_pass_model extends CI_Model {

    public function common_insert($tablename, $data) {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
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
        if($version){
            $this->db->set('version', '`version`+1', FALSE);
        }
        $update = $this->db->update($tblname, $setvalue);
        if ($update) {
            return true;
        }
        return false;
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

    function getRowsEmployees($params = array()) {
        $this->db->select('a.*,b.type_name');
        $this->db->from('users a');
        $this->db->join('user_types b', 'b.id_user_type=a.user_type_id', 'left');
        if (!empty($params['search']['full_name'])) {
            $this->db->like('a.fullname', $params['search']['full_name']);
        }
        if (!empty($params['search']['email'])) {
           $this->db->like('a.email', $params['search']['email']);
        }
        if (!empty($params['search']['phone'])) {
           $this->db->like('a.mobile', $params['search']['phone']);
        }
        $this->db->where('a.status_id', 1);
        $this->db->order_by('id_user', 'desc');
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function get_employee_details($id) {
        $this->db->select('a.*,b.type_name,c.name as station_name');
        $this->db->from('users a');
        $this->db->join('user_types b', 'b.id_user_type=a.user_type_id', 'left');
        $this->db->join('stations c', 'c.id_station=a.station_id', 'left');
        $this->db->where('a.id_user', $id);
        $this->db->order_by('a.id_user', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
            //return $query->row();
        } else {
            return false;
        }
    }
    public function get_employee_document_result_pagination($params = array()) {
        $this->db->select("*");
        $this->db->from("documents");
        if (!empty($params['search']['user_id'])) {
            $this->db->where('ref_id', $params['search']['user_id']);
        }
        $this->db->where("doc_type", "User");
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    public function get_employee_document_result($id) {
        $this->db->select("*");
        $this->db->from("documents");
        $this->db->where("doc_type", "User");
        $this->db->where("ref_id", "$id");
        $this->db->where("status_id", "1");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    
    public function acl_gorup_module_id($id) {
         $this->db->select("id_acl_module");
        $this->db->from('acl_access_module');
        $this->db->where('user_id', $id);
        $this->db->group_by('id_acl_module');
        $query = $this->db->get();
        //return $query->result_array();
        return $query->result();
    }

    public function get_employee_by_id($id = null) {
        $this->db->select('a.*,b.type_name');
        $this->db->from('users a');
        $this->db->join('user_types b', 'b.id_user_type=a.user_type_id', 'left');
        $this->db->where('a.id_user', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_employee_document_by_id($id = null) {
        $this->db->from('documents');
        $this->db->where('id_document', $id);
        $this->db->where("status_id", "1");
        $query = $this->db->get();
        return $query->row();
    }
    

   public function delete_data($tblname, $convalue = array()) {
        $this->db->where($convalue);
        $update = $this->db->delete($tblname);
        if ($update) {
            return true;
        }
        return false;
    }
    public function version_update($tblname, $setvalue, $convalue = array()) {
        $this->db->where($convalue);
        $this->db->set($setvalue, "IFNULL(`$setvalue`,0)+1", FALSE);
        $update = $this->db->update($tblname);
        if ($update) {
            return true;
        }
        return false;
    }
     public function version_delete($tblname, $setvalue, $convalue = array()) {
        $this->db->where($convalue);
        $this->db->set($setvalue, "$setvalue-1", FALSE);
        $update = $this->db->update($tblname);
        if ($update) {
            return true;
        }
        return false;
    }
    public function get_data_by_id($id) {
        $this->db->from('stores');
        $this->db->where('id_store', $id);
        $query = $this->db->get();

        return $query->row();
    }
    public function isExistExcept($table, $chk_column, $chk_value, $expt_column='', $expt_value='') {
        if(empty($expt_value)){
            $tot = $this->db
            ->where($chk_column, $chk_value)
            ->where('status_id', 1)
            ->count_all_results($table);

        } else{            
            $tot = $this->db
            ->where($chk_column, $chk_value)
            ->where($expt_column.' !=', $expt_value)
            ->where('status_id', 1)
            ->count_all_results($table);
        }
        
        return $tot>0 ? 1 : 0;
    }

    public function get_store_details_by_id($id_store) {
                 //echo json_encode($id_store);
            // $this->db->select('a.*,b.cat_name,c.brand_name as brands,d.unit_code as unit_name, e.cat_name as sub_category ');
            $this->db->select('s.*,u.id_user,u.uname,a.area_name_en,c.city_name_en,d.district_name_en,dv.division_name_en');
            $this->db->from('stores s');
             $this->db->join('users u', 'u.id_user=s.uid_add', 'left');
             $this->db->join('loc_areas a', 'a.id_area=s.area_id', 'left');
             $this->db->join('loc_cities c', 'c.id_city=s.city_id', 'left');
             $this->db->join('loc_districts d', 'd.id_district=s.dist_id', 'left');
             $this->db->join('loc_divisions dv', 'dv.id_division=s.div_id', 'left');
            $this->db->where('s.id_store', $id_store);
            $query = $this->db->get();
            if ($query->num_rows() != 0) {
                return $query->row();
               foreach ($query->result() as $row) {
                   $data[] = $row;
               }
               return $data;
            } else {
                return false;
            }
        }
    
}

?>