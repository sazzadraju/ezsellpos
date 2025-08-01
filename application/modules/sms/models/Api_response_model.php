<?php

class Api_response_Model extends CI_Model {

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
    public function update_sms($params=array()){
        $this->db->where('param_key','SMS_CONFIG');
        $qty=$params['qty'];
        $this->db->set('param_val', "`param_val`+$qty", FALSE);
        $this->db->set('utilized_val',$params['unit_price']);
        $res = $this->db->update('configs');
        return $res;

    }

    

}
