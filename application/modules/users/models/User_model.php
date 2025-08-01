<?php

class User_Model extends CI_Model
{

    public function common_insert($tablename, $data)
    {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

    public function update_value($tblname, $setvalue = array(), $convalue = array(), $version = true)
    {
        $this->sql = '';
        $this->key = '';
        $this->value = '';
        $this->key = array_keys($convalue);
        $this->value = array_values($convalue);
        for ($i = 0; $i < count($convalue); $i++) {
            $this->db->where($this->key[$i], $this->value[$i]);
        }
        if ($version) {
            $this->db->set('version', '`version`+1', FALSE);
        }
        $update = $this->db->update($tblname, $setvalue);
        if ($update) {
            return true;
        }
        return false;
    }

    public function common_single_value_array($tablename, $id_column, $value_column, $order_by, $asc_desc)
    {
        $this->db->select("$id_column,$value_column");
        $this->db->from("$tablename");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function common_cond_single_value_array($tablename, $id_column, $value_column, $conditional_column, $conditional_value, $order_by, $asc_desc)
    {
        $this->db->select("$id_column,$value_column");
        $this->db->from("$tablename");
        $this->db->where("$conditional_column", "$conditional_value");
        $this->db->order_by("$order_by", "$asc_desc");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
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
    public function is_user($id){
        $this->db->select('uname');
        $this->db->where('id_user',$id);
        $this->db->where('uname',null);
        $q = $this->db->get('users');
        if ($q->num_rows() > 0) {
            return 1;
        }else{
            return 2;
        }
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

    function getRowsEmployees($params = array())
    {
        $this->db->select('a.*,b.type_name,s.store_name');
        $this->db->from('users a');
        $this->db->join('user_types b', 'b.id_user_type=a.user_type_id', 'left');
        $this->db->join('stores s', 'a.store_id=s.id_store', 'left');
        if (!empty($params['search']['full_name'])) {
            $this->db->like('a.fullname', $params['search']['full_name']);
        }
        if (!empty($params['search']['email'])) {
            $this->db->like('a.email', $params['search']['email']);
        }
        if (!empty($params['search']['phone'])) {
            $this->db->like('a.mobile', $params['search']['phone']);
        }
        if (!empty($params['search']['sr_type'])&&$params['search']['sr_type']!='0') {
            $this->db->where('a.user_type_id', $params['search']['sr_type']);
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('a.store_id', $this->session->userdata['login_info']['store_id']);
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

    public function get_employee_details($id)
    {
        $this->db->select('a.*,b.type_name,c.name as station_name,s.store_name');
        $this->db->from('users a');
        $this->db->join('user_types b', 'b.id_user_type=a.user_type_id', 'left');
        $this->db->join('stations c', 'c.id_station=a.station_id', 'left');
        $this->db->join('stores s', 'a.store_id=s.id_store', 'left');
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

    public function get_employee_document_result_pagination($params = array())
    {
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

    public function get_employee_document_result($id)
    {
        $this->db->select("*");
        $this->db->from("documents");
        $this->db->where("doc_type", "User");
        $this->db->where("ref_id", "$id");
        $this->db->where("status_id", "1");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function acl_gorup_module_id($id)
    {
        $this->db->select("id_acl_module");
        $this->db->from('acl_access_module');
        $this->db->where('user_id', $id);
        $this->db->group_by('id_acl_module');
        $query = $this->db->get();
        //return $query->result_array();
        return $query->result();
    }

    public function get_employee_by_id($id = null)
    {
        $this->db->select('a.*,b.type_name');
        $this->db->from('users a');
        $this->db->join('user_types b', 'b.id_user_type=a.user_type_id', 'left');
        $this->db->where('a.id_user', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_employee_document_by_id($id = null)
    {
        $this->db->from('documents');
        $this->db->where('id_document', $id);
        $this->db->where("status_id", "1");
        $query = $this->db->get();
        return $query->row();
    }


    public function delete_data($tblname, $convalue = array())
    {
        $this->db->where($convalue);
        $update = $this->db->delete($tblname);
        if ($update) {
            return true;
        }
        return false;
    }

    public function version_update($tblname, $setvalue, $convalue = array())
    {
        $this->db->where($convalue);
        $this->db->set($setvalue, "IFNULL(`$setvalue`,0)+1", FALSE);
        $update = $this->db->update($tblname);
        if ($update) {
            return true;
        }
        return false;
    }

    public function version_delete($tblname, $setvalue, $convalue = array())
    {
        $this->db->where($convalue);
        $this->db->set($setvalue, "$setvalue-1", FALSE);
        $update = $this->db->update($tblname);
        if ($update) {
            return true;
        }
        return false;
    }

    public function get_data_by_id($id)
    {
        $this->db->from('stations');
        $this->db->where('id_station', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function isExistExcept($table, $chk_column, $chk_value, $expt_column, $expt_value)
    {
        $tot = $this->db
            ->where($chk_column, $chk_value)
            ->where($expt_column . ' !=', $expt_value)
            ->where('status_id', 1)
            ->count_all_results($table);

        return $tot > 0 ? 1 : 0;
    }

    public function isExistStation($table, $chk_column, $expt_column)
    {
        $this->db->where($chk_column);
        if ($expt_column != '') {
            $this->db->where($expt_column);
        }
        $this->db->where('status_id', 1);
            $tot = $this->db->count_all_results($table);

        return $tot > 0 ? 1 : 0;
    }

    public function update_station_account($data, $condition)
    {
        $sql = "UPDATE accounts a
                JOIN accounts_stores s ON a.id_account = s.account_id
                SET a.account_name = '" . $data['account_name'] . "'
                , a.dtt_mod = '" . $data['dtt_mod'] . "'
                , a.uid_mod = '" . $data['uid_mod'] . "'
                WHERE a.station_id = {$condition['station_id']}
                AND s.store_id= {$condition['store_id']}";
        $this->db->query($sql);
    }

    public function checkAccountBalanceByStationId($station_id, $store_id)
    {
        $this->db->select("a.curr_balance", FALSE);
        $this->db->from("accounts AS a");
        $this->db->join("accounts_stores AS s", "a.id_account = s.account_id");
        $this->db->where("a.station_id", $station_id);
        $this->db->where("s.store_id", $store_id);

        $query = $this->db->get();
        $row = $query->row();
        return isset($row->curr_balance) ? $row->curr_balance : '';
    }

    public function get_stations()
    {
        $this->db->select("a.id_station,a.name,a.store_id,b.store_name");
        $this->db->from("stations AS a");
        $this->db->join("stores AS b", "a.store_id = b.id_store");
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('a.store_id', $this->session->userdata['login_info']['store_id']);
        }
        $this->db->where('a.status_id', 1);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function deleteStationAndAccount($id, $data)
    {
        $sql = "UPDATE accounts a
                JOIN accounts_stores t ON a.`id_account` = t.`account_id`
                JOIN stations s ON s.`id_station` = a.`station_id` AND a.`acc_type_id`=4
                SET
                  s.`status_id` = 2
                , s.`dtt_mod` = '" . $data['uid_mod'] . "'
                , s.`uid_mod` = '" . $data['dtt_mod'] . "'
                , s.`version` = s.`version` + 1
                , a.`status_id` = 2
                , a.`dtt_mod` = '" . $data['uid_mod'] . "'
                , a.`uid_mod` = '" . $data['dtt_mod'] . "'
                , a.`version` = a.`version` + 1
                WHERE s.`id_station` = {$id}
                AND a.`curr_balance` = 0";
        $this->db->query($sql);
    }
}