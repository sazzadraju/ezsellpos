<?php

class Employee_transaction_report_model extends CI_Model {

    
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
        $this->db->select('t.dtt_trx,t.trx_no,t.qty_multiplier,t.tot_amount,t.account_id,t.payment_method_id,t.store_id,t.ref_id,trx_name,a.account_name,a.account_no,tt.trx_name,st.store_name,u.fullname as emp_name');
        $this->db->from('transactions t');
        $this->db->join('transaction_details td', 't.id_transaction= td.transaction_id');
        $this->db->join('transaction_types tt', 'tt.id_transaction_type = td.ref_id');
        $this->db->join('accounts a', 't.account_id= a.id_account');
        $this->db->join('stores st', 't.store_id= st.id_store');
         $this->db->join('users u', 't.ref_id= u.id_user');
        if (!empty($params['search']['store_id'])) {
            $this->db->where('t.store_id', $params['search']['store_id']);
        }else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['trx_name'])) {
            $this->db->where('tt.trx_name', $params['search']['trx_name']);
        }
       if (!empty($params['search']['qty_multiplier'])) {
            $this->db->where('td.qty_multiplier', $params['search']['qty_multiplier']);
        }
        if (!empty($params['search']['employee_id'])) {
            $this->db->where('t.ref_id', $params['search']['employee_id']);
        }
         if (!empty($params['search']['FromDate'])) {
            $this->db->where("t.dtt_trx >=", $params['search']['FromDate']);
            $this->db->where("t.dtt_trx <=", $params['search']['ToDate']);
        }
       
        $this->db->where('t.trx_with', 'employee');
        $this->db->where('t.status_id', 1);
        // $this->db->group_by('t.trx_no','desc');
        $query = $this->db->get();
        //   echo  $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
}

