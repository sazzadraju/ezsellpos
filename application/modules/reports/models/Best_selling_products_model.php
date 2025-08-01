<?php

class Best_selling_products_model extends CI_Model {

    
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
        // $this->db->distinct('dtt_add');
        // $this->db->distinct('dtt_add');
        $this->db->select('sd.product_id,sd.dtt_add,s.store_id,p.product_name,pb.brand_name,pc.cat_name,psc.cat_name as subcat_name,st.store_name,SUM(sd.selling_price_act) as amt,SUM(sd.qty) AS qty,SUM(stk.purchase_price) as purchase_price,SUM(sd.selling_price_est) as unit_price,SUM(sd.vat_amt) as vat_amt,SUM(sd.discount_amt) as discount_amt,p.product_code');
        $this->db->from('sale_details sd');
        $this->db->join('sales s','sd.sale_id = s.id_sale');
        $this->db->join('products p', 'sd.product_id= p.id_product');
        $this->db->join('product_brands pb', 'pb.id_product_brand=sd.brand_id');
        $this->db->join('product_categories pc', 'pc.id_product_category=sd.cat_id');
        $this->db->join('product_categories psc', 'psc.id_product_category=sd.subcat_id','left');
        $this->db->join('stores st', 's.store_id= st.id_store');
        $this->db->join('stocks stk', 'stk.id_stock= sd.stock_id');
       
        if (!empty($params['search']['store_id'])) {
            $this->db->where('s.store_id', $params['search']['store_id']);
        }else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("sd.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("sd.dtt_add <=", $params['search']['ToDate']);
        }
        if (!empty($params['search']['cat_name'])) {

            $this->db->where('sd.cat_id', $params['search']['cat_name']);
        }
        if (!empty($params['search']['pro_sub_category'])) {

            $this->db->where('sd.subcat_id', $params['search']['pro_sub_category']);
        }
        if (!empty($params['search']['brand'])) {
            $this->db->where('sd.brand_id', $params['search']['brand']);
        }
        $this->db->where('sd.status_id', 1);
        $this->db->where('sd.sale_type_id', 1);
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->group_by(array("DATE(sd.dtt_add)","sd.product_id","s.store_id"));
        if ($params['search']['report_type']==1) {
            $this->db->order_by("SUM(sd.qty)", "desc");
        }else{
            $this->db->order_by("SUM(sd.selling_price_act)", "desc");
        }
        
        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
}

