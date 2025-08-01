<?php

class Purchase_report_model extends CI_Model
{

    public function common_insert($tablename, $data)
    {
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


    function getRowsProducts($params = array())
    {
        $this->db->select('DATE(pr.dtt_receive) as dtt_add,prd.store_id,prd.purchase_price,prd.supplier_id,prd.qty,p.product_name,p.product_code,p.cat_id,p.subcat_id,pb.brand_name,pc.cat_name,psc.cat_name as subcat_name,st.store_name,sp.supplier_name,stk.batch_no');
        $this->db->from('purchase_receive_details prd');
        $this->db->join('purchase_receives pr', 'pr.id_purchase_receive= prd.purchase_receive_id');
        $this->db->join('products p', 'prd.product_id= p.id_product');
        $this->db->join('product_brands pb', 'pb.id_product_brand=p.brand_id','left');
        $this->db->join('product_categories pc', 'pc.id_product_category=p.cat_id','left');
        $this->db->join('product_categories psc', 'psc.id_product_category=p.subcat_id','left');
        $this->db->join('stores st', 'prd.store_id= st.id_store');
        $this->db->join('suppliers sp', 'prd.supplier_id= sp.id_supplier','left');
        $this->db->join('stocks stk', 'stk.stock_mvt_detail_id= prd.id_purchase_receive_detail and stk.stock_mvt_type_id=1');
        if (!empty($params['search']['product_name'])) {
            $this->db->where('p.id_product', $params['search']['product_name']);
        }
        if (!empty($params['search']['store_id'])) {

            $this->db->where('prd.store_id', $params['search']['store_id']);
        } else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('prd.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['batch_no'])) {
            $this->db->like('stk.batch_no', $params['search']['batch_no']);
        }
        if (!empty($params['search']['cat_name'])) {
            $this->db->where('p.cat_id', $params['search']['cat_name']);
        }
        if (!empty($params['search']['pro_sub_category'])) {

            $this->db->where('p.subcat_id', $params['search']['pro_sub_category']);
        }
        if (!empty($params['search']['supplier_id'])) {

            $this->db->where('prd.supplier_id', $params['search']['supplier_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("pr.dtt_receive >=", $params['search']['FromDate']);
            $this->db->where("pr.dtt_receive <=", $params['search']['ToDate']);
        }

        $this->db->where('prd.status_id', 1);
        // $this->db->order_by('prd.id_purchase_receive', 'desc');
        $query = $this->db->get();
        // echo  $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

}

