<?php

class Office_transaction_report_model extends CI_Model
{


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

    public function get_payment_details($trx_no)
    {
        // $this->db->select('stp.amount,stp.account_id,st.trx_no,s.invoice_no,a.account_name,a.account_no');
        $this->db->select('st.tot_amount,st.trx_no,s.invoice_no');
        $this->db->from('sale_transactions st');
        //$this->db->join('sale_transaction_payments stp','st.id_sale_transaction= stp.sale_transaction_id');
        $this->db->join('sale_transaction_details std', 'st.id_sale_transaction= std.sale_transaction_id');
        $this->db->join('sales s', 'std.sale_id= s.id_sale');
        // $this->db->join('accounts a', 'stp.account_id= a.id_account');
        $this->db->where('st.trx_no', $trx_no);
        $query = $this->db->get();
        // echo  $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
        // return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        //return $query->row();
    }

    public function get_method_details($trx_no)
    {
        $this->db->select('stp.amount,stp.account_id,a.account_name,a.account_no');
        // $this->db->select('st.tot_amount,st.trx_no,s.invoice_no');
        $this->db->from('sale_transaction_payments stp');
        $this->db->join('sale_transactions st', 'st.id_sale_transaction= stp.sale_transaction_id');
        $this->db->join('sale_transaction_details std', 'st.id_sale_transaction= std.sale_transaction_id');
        $this->db->join('sales s', 'std.sale_id= s.id_sale');
        $this->db->join('accounts a', 'stp.account_id= a.id_account');
        $this->db->where('st.trx_no', $trx_no);
        $query = $this->db->get();
        // echo  $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
        // return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        //return $query->row();
    }

// SELECT * FROM `sales` WHERE DATE(dtt_add) = '2017-11-22'

    public function get_invoice_details($invoice_id)
    {
        $this->db->select('*');
        $this->db->from('sale_details sd');
        $this->db->join('sales s', 'sd.sale_id = s.id_sale');
        $this->db->where('sd.sale_id', $invoice_id);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        //return $query->row();
    }
    // public function get_payment_details() {
    //     $this->db->select('stp.amount,stp.payment_method_id,st.trx_no');
    //     $this->db->from('sale_transactions st');
    //     $this->db->join('sale_transaction_payments stp','st.id_sale_transaction= stp.sale_transaction_id');
    //     $query = $this->db->get();
    //     return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    //     //return $query->row();
    // }

    function getRowsProducts($params = array())
    {
        $this->db->select('t.dtt_trx,t.trx_no,tt.trx_name as sub_cat,ts.trx_name as cat,t.qty_multiplier,t.tot_amount,t.account_id,t.payment_method_id,t.store_id,st.store_name,t.ref_id,fn_account_name_by_id(t.account_id) AS account_name');
        $this->db->from('transactions t');
        $this->db->join('stores st', 't.store_id= st.id_store');
        $this->db->join('transaction_categories tt', 'tt.id_transaction_category = t.ref_id', 'left');
        $this->db->join('transaction_categories ts', 'tt.parent_id = ts.id_transaction_category', 'left');
        $this->db->where('t.trx_with', 'office');
        if (!empty($params['search']['store_id'])) {

            $this->db->where('t.store_id', $params['search']['store_id']);
        } else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['transaction_subcategory'])) {
            $this->db->where('ts.id_transaction_category', $params['search']['trx_name']);
            $this->db->where('tt.id_transaction_category', $params['search']['transaction_subcategory']);
        } else if (!empty($params['search']['categories'])) {
            $this->db->where_in('tt.id_transaction_category', $params['search']['categories']);
        }
        if (!empty($params['search']['qty_multiplier'])) {

            $this->db->where('t.qty_multiplier', $params['search']['qty_multiplier']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("t.dtt_trx >=", $params['search']['FromDate']);
            $this->db->where("t.dtt_trx <=", $params['search']['ToDate']);
        }

        $this->db->where('t.status_id', 1);
        // $this->db->group_by('t.trx_no','desc');
        $query = $this->db->get();
        // echo  $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function getCategoryAll($id, $type)
    {
        $this->db->select('t.dtt_trx,t.trx_no,tt.trx_name as sub_cat,ts.trx_name as cat,t.qty_multiplier,t.tot_amount,t.account_id,t.payment_method_id,t.store_id,st.store_name,t.ref_id,fn_account_name_by_id(t.account_id) AS account_name');
        $this->db->from('transaction_categories t');
        $this->db->join('transaction_categories st', 'st.parent_id= t.id_transaction_category', 'left');
        $this->db->where('t.qty_multiplier', 'office');
        $this->db->where('t.qty_multiplier', 'office');
    }


    public function check_value($table, $column, $value)
    {
        $tot = $this->db
            ->where($column, $value)
            ->where('status_id', 1)
            ->count_all_results($table);

        return $tot > 0 ? TRUE : FALSE;
    }


    public function max_value($table, $value)
    {
        $this->db->select_max($value);
        $result = $this->db->get($table);
        return (int)$result->row()->$value;
    }

}

