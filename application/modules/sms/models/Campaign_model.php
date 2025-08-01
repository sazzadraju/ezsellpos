<?php

class Campaign_Model extends CI_Model {

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
    

    
    public function all_campaign_list($params=array()){
        $this->db->select("sc.*, GROUP_CONCAT(ssp.title SEPARATOR ', ') AS title,ssp.id_set_person");
        $this->db->from('sms_campaign sc');
        $this->db->join('sms_campaign_person cp', 'cp.campaign_id = sc.id_campaign');
        $this->db->join('sms_set_person ssp', 'ssp.id_set_person = cp.set_person_id');
        $this->db->where('sc.status_id', 1);
        $this->db->order_by('sc.id_campaign', 'desc');
        $this->db->group_by('sc.id_campaign');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function getAudienceById($id){
        $this->db->select('count(pd.id_set_person_details) as total,sp.title');
        $this->db->from('sms_campaign_person cp');
        $this->db->join('sms_set_person sp', 'sp.id_set_person = cp.set_person_id');
        $this->db->join('sms_set_person_details pd', 'sp.id_set_person = pd.set_person_id');
        $this->db->where('cp.campaign_id', $id);
        $this->db->where('sp.status_id', 1);
        $this->db->group_by('cp.id_campaign_person');
        //$this->db->order_by('id_set_person', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function all_audience_list($params=array()){
        $this->db->select('ssp.title,ssp.id_set_person,count(pd.id_set_person_details) as total_row');
        $this->db->from('sms_set_person ssp');
        $this->db->join('sms_set_person_details pd', 'ssp.id_set_person = pd.set_person_id');
        $this->db->where('ssp.status_id', 1);
        $this->db->group_by('ssp.id_set_person');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function update_config( $params = array()){
        $this->db->where('param_key','SMS_CONFIG');
        $qty=$params['total_sms'];
        $this->db->set('param_val', "`param_val`-$qty", FALSE);
        $this->db->set('utilized_val',$params['unit_price']);
        $res = $this->db->update('configs');
        return $res;

    }
    function get_person_list($id){
        $this->db->select('pd.*,c.full_name customer_name,s.supplier_name,c.phone cus_phone,s.phone sup_phone');
        $this->db->from('sms_set_person_details pd');
        $this->db->join('customers c', 'c.id_customer = pd.person_id and type=1','left');
        $this->db->join('suppliers s', 's.id_supplier = pd.person_id and type=2','left');
        $this->db->where('pd.set_person_id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function getSmsListById($id){
        $this->db->select('*');
        $this->db->from('sms_campaign_details');
        $this->db->where('campaign_id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

}
