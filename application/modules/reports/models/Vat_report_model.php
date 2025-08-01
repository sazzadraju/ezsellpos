<?php

class Vat_report_model extends CI_Model
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

    function getRowsProducts($params = array())
    {
        $this->db->select('s.id_sale,s.dtt_add,s.store_id,SUM(p.discount_amt) as total_discount');
        $this->db->from('sales s');
        $this->db->join('sale_promotions p', 's.id_sale=p.sale_id and p.promotion_type_id != 1', 'left');
       // $this->db->join('sale_details sd_v', 's.id_sale=sd_v.sale_id and sd_v.vat_amt > 0', 'left');
        if (!empty($params['search']['store_id'])) {
            $this->db->where('s.store_id', $params['search']['store_id']);
        } else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("s.dtt_add <=", $params['search']['ToDate']);
        }
        $this->db->where('s.status_id', 1);
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->group_by("DATE(s.dtt_add)");
        // $this->db->group_by("s.id_sale");
        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function get_sale_nonVat_product_total($date,$store_id){
        $this->db->select('SUM(sd_n.selling_price_est-sd_n.discount_amt) as vat_sale ,SUM(sd_n.vat_amt) as vat_total');
        $this->db->from('sale_details sd_n');
        $this->db->join('sales s', "sd_n.sale_id=s.id_sale");
        if ($store_id!=0) {
            $this->db->where('s.store_id',$store_id);
        }
        $this->db->where('sd_n.vat_amt <=', 0);
        $this->db->where("sd_n.dtt_add >=", $date.' 00:00:00');
        $this->db->where("sd_n.dtt_add <=", $date.' 23:59:59');
        $this->db->where('sd_n.status_id', 1);
        $this->db->where('sd_n.sale_type_id', 1);
        $this->db->group_by("DATE(sd_n.dtt_add)");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }
    public function get_sale_vat_product_total($date,$store_id){
        $this->db->select('SUM(sd_n.selling_price_est-sd_n.discount_amt) as vat_sale ,SUM(sd_n.vat_amt) as vat_total');
        $this->db->from('sale_details sd_n');
        $this->db->join('sales s', "sd_n.sale_id=s.id_sale");
        $this->db->where('sd_n.vat_amt >', 0);
        if ($store_id!=0) {
            $this->db->where('s.store_id',$store_id);
        }
        $this->db->where("sd_n.dtt_add >=", $date.' 00:00:00');
        $this->db->where("sd_n.dtt_add <=", $date.' 23:59:59');
        $this->db->where('sd_n.status_id', 1);
        $this->db->group_by("DATE(sd_n.dtt_add)");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }


}

