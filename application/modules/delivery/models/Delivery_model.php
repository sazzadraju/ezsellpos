<?php

class Delivery_Model extends CI_Model {

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
        // if ($version) {
        //     $this->db->set('version', '`version`+1', FALSE);
        // }
        $update = $this->db->update($tblname, $setvalue);
        if ($update) {
            return true;
        }
        return false;
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
    public function getvalue_row_array($tbl, $fn, $fcon = array()) {
        $this->db->select($fn);
        $this->db->where($fcon);
        $query = $this->db->get($tbl);
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
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




    function getAgentData($params = array()) {
        $this->db->select('*');
        $this->db->from('agents');
        $this->db->where('status_id', 1);
        $this->db->order_by('id_agent', 'desc');
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

     function getPersonsData($params = array()) {
        $this->db->select('d.*,u.fullname,u2.fullname as added,a.agent_name');
        $this->db->from('delivery_persons d');
        $this->db->join('users u', 'u.id_user=d.ref_id', 'left');
        $this->db->join('users u2', 'u2.id_user=d.uid_add', 'left');
        $this->db->join('agents a', 'a.id_agent=d.ref_id', 'left');
        
        $this->db->order_by('d.id_delivery_person', 'desc');

        if (!empty($params['search']['src_person_name'])) {
            $this->db->where('d.person_name', $params['search']['src_person_name']);
            $this->db->where('d.type_id',2);
            $this->db->or_where('u.fullname', $params['search']['src_person_name']);
            $this->db->where('d.type_id',1);
            // $this->db->or_like('d.person_name', $params['search']['src_person_name']);
            // $this->db->or_like('u.fullname', $params['search']['src_person_name']);
        }
        if (!empty($params['search']['src_type_id'])) {
            $this->db->where('d.type_id', $params['search']['src_type_id']);
        }
        $this->db->where('d.status_id', 1);
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        //get records

        $query = $this->db->get();
        // echo $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function getCostData($params = array()) {
        $this->db->select('dc.*,u.fullname,a.agent_name');
        $this->db->from('delivery_costs dc');
        // $this->db->join('delivery_cost_details dcd', 'dcd.delivery_cost_id=dc.id_delivery_cost', 'left');
        $this->db->join('users u', 'u.id_user=dc.ref_id', 'left');
        $this->db->join('agents a', 'a.id_agent=dc.ref_id', 'left');
        $this->db->where('dc.status_id', 1);
        $this->db->order_by('dc.id_delivery_cost', 'desc');
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

    public function getOrderData($params = array()){
        $this->db->select('do.*,u.fullname,s.tot_amt as sale_amt,s.paid_amt as sale_paid,s.due_amt as sale_due,s.round_amt sale_round,s.notes,su.fullname as sale_by');
        $this->db->from('delivery_order_details do');
        $this->db->join('delivery_persons dp', 'dp.id_delivery_person=do.person_id and do.type_id=1', 'left');
        $this->db->join('users u', 'u.id_user=dp.ref_id and dp.type_id=1', 'left');
        $this->db->join('sales s', 'do.sale_id=s.id_sale', 'left');
        $this->db->join('users su', 'su.id_user=s.uid_add', 'left');
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

    public function get_person_by_id($id) {
        $this->db->from('delivery_persons');
        $this->db->where('id_delivery_person', $id);
        $query = $this->db->get();

        return $query->row();
    }
    public function get_agent_by_id($id) {
        $this->db->from('agents');
        $this->db->where('id_agent', $id);
        $query = $this->db->get();

        return $query->row();
    }
    public function get_cost_by_id($id) {
        $this->db->from('delivery_costs');
        $this->db->where('id_delivery_cost', $id);
        $query = $this->db->get();

        return $query->row();
    }
    public function get_cost_det_by_id($id) {
        $this->db->from('delivery_cost_details');
        $this->db->where('delivery_cost_id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

//     public function get_product_details_by_id($id) {
//         $this->db->select('d.*,u.fullname');
//         $this->db->from('delivery_persons d');
//         $this->db->join('users u', 'u.id_user=d.ref_id', 'left');
//         $this->db->where('d.id_agent', $id);
//         $this->db->order_by('d.id_agent', 'desc');
//         $query = $this->db->get();
//         if ($query->num_rows() != 0) {
//             return $query->row();
// //            foreach ($query->result() as $row) {
// //                $data[] = $row;
// //            }
// //            return $data;
//         } else {
//             return false;
//         }
//     }
    public function get_agent_details_by_id($id) {
        $this->db->select('a.*,u.fullname');
        $this->db->from('agents a');
        $this->db->join('users u', 'u.id_user=a.uid_add', 'left');
        $this->db->where('a.id_agent', $id);
        $this->db->order_by('a.id_agent', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->row();
//            foreach ($query->result() as $row) {
//                $data[] = $row;
//            }
//            return $data;
        } else {
            return false;
        }
    }
    public function get_cost_configure_details($id) {
        $this->db->select('*');
        $this->db->from('delivery_cost_details');
        $this->db->where('delivery_cost_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function get_cost_details_by_id($id) {
        $this->db->select('dc.*,u.fullname,a.agent_name');
        $this->db->from('delivery_costs dc');
        $this->db->join('delivery_cost_details dcd', 'dcd.delivery_cost_id=dc.id_delivery_cost', 'left');
        $this->db->join('users u', 'u.id_user=dc.uid_add', 'left');
        $this->db->join('agents a', 'a.id_agent=dc.ref_id', 'left');
        $this->db->where('dc.id_delivery_cost', $id);
        $this->db->where('dc.status_id', 1);
        $this->db->order_by('dc.id_delivery_cost', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->row();
//            foreach ($query->result() as $row) {
//                $data[] = $row;
//            }
//            return $data;
        } else {
            return false;
        }
    }


    public function check_value($table, $column, $value) {
        $tot = $this->db
                ->where($column, $value)
                ->where('status_id', 1)
                ->count_all_results($table);

        return $tot > 0 ? TRUE : FALSE;
    }
    

    public function delete_data($tblname, $convalue = array()) {
        $this->db->where($convalue);
        $update = $this->db->delete($tblname);
        if ($update) {
            return true;
        }
        return false;
    }

    public function isExistExcept($table, $chk_column, $chk_value, $expt_column, $expt_value) {
        $tot = $this->db
                ->where($chk_column, $chk_value)
                ->where($expt_column . ' !=', $expt_value)
                ->where('status_id', 1)
                ->count_all_results($table);

        return $tot > 0 ? 1 : 0;
    }

    public function isExist($table, $column, $value) {
        $tot = $this->db
                ->where($column, $value)
                ->count_all_results($table);

        return $tot > 0 ? TRUE : FALSE;
    }

    public function max_value($table, $value) {
        $this->db->select_max($value);
        $result = $this->db->get($table);
        return (int) $result->row()->$value;
    }
    
    public function update_value_step_1($condition){
       
        $this->db->where_in('delivery_cost_id', $condition);
        $this->db->delete('delivery_cost_details');
        // $update = $this->db->update($tblname, $setvalue);         
    }

    public function listAccounts($stores = [], $acc_type = 0, $acc_use = 0)
    {
        foreach ($stores as $k => $v) {
            if (empty($stores[$k])) unset($stores[$k]);
        }
        if (!(isset($stores) && !empty($stores))) return [];

        $acc_type = (int)$acc_type;
        $acc_use = (int)$acc_use;

        $this->db->select("
            a.id_account AS acc_id,
             a.curr_balance AS curr_balance,
            CASE a.acc_type_id
              WHEN 1 THEN b.bank_name
              WHEN 2 THEN a.account_name
              WHEN 3 THEN b.bank_name
              WHEN 4 THEN a.account_name
              ELSE ''
            END AS acc_name,
            a.account_no AS acc_no,
            a.acc_type_id AS acc_type", FALSE);
        $this->db->from("accounts AS a");
        $this->db->join('accounts_stores AS acs', 'acs.account_id = a.id_account');
        $this->db->join('banks AS b', 'b.id_bank = a.bank_id', 'left');
        if (!empty($acc_type)) {
            $this->db->where("a.acc_type_id", $acc_type);
        }
        if (empty($acc_use)) {
            // Office uses OR Both
            $this->db->where("(a.acc_uses_id = 1 OR a.acc_uses_id = 3)", NULL, FALSE);
        } else {
            $this->db->where("a.acc_uses_id", $acc_use);
        }
        $this->db->where("a.status_id", 1);
        $this->db->where("acs.store_id IN (" . implode(',', $stores) . ")", NULL, FALSE);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function getfilterData($params = array()) {
        $this->db->select("s.`tot_amt` AS invoice_total,s.invoice_no,d.tot_amt as delivery_charge,d.cod_charge,a.agent_name");
        $this->db->from('delivery_orders d');
        $this->db->join('sales s', 'd.sale_id = s.id_sale','left');
        $this->db->join('agents a', 'd.ref_id=a.id_agent','left');
         if (!empty($params['search']['FromDate'])) {
            $this->db->where("d.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("d.dtt_add <=", $params['search']['ToDate']);
        }
        if (!empty($params['search']['agent_name'])) {
            $this->db->where("a.id_agent", $params['search']['agent_name']);
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('d.store_id', $this->session->userdata['login_info']['store_id']);
        }
        $this->db->where('d.type_id', 2);
        $this->db->group_by('d.id_delivery_order');
        $this->db->order_by('d.id_delivery_order', 'desc');
        $query = $this->db->get();
        // echo $params['search']['agent_name'];
          // echo  $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function delivety_person_staff_list(){
        $this->db->select("a.id_delivery_person,b.fullname as person_name");
        $this->db->from("delivery_persons a");
        $this->db->join('users b', 'a.ref_id = b.id_user', 'left');
        $this->db->where("a.type_id", 1);
        $this->db->where("a.status_id", 1);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    public function get_agent_info($id){
        $this->db->select('do.type_id,do.delivery_address,do.agent_name,do.delivery_name, do.person_name,u.fullname');
        $this->db->from('delivery_order_details do');
        $this->db->join('delivery_persons dp', 'dp.id_delivery_person=do.person_id and do.type_id=1', 'left');
        $this->db->join('users u', 'u.id_user=dp.ref_id and dp.type_id=1', 'left');
        $this->db->where('do.status_id', 1);
        $this->db->where('do.sale_id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function update_value_add($tblname, $field_name, $field_value, $convalue = array())
    {
        $this->sql = '';
        $this->key = '';
        $this->value = '';
        $this->key = array_keys($convalue);
        $this->value = array_values($convalue);
        for ($i = 0; $i < count($convalue); $i++) {
            $this->db->where($this->key[$i], $this->value[$i]);
        }
        $this->db->set($field_name, "`$field_name`+$field_value", FALSE);
        $update = $this->db->update($tblname);
        if ($update) {
            return true;
        }
        return false;
    }
    
}

