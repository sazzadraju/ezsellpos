<?php

class Stock_in_summary_model extends CI_Model {

    

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
        $this->db->select("p.*,s.dtt_stock_mvt as date,s.store_id,st.purchase_price,st.selling_price_act,d.product_id,d.supplier_id,d.qty as qty,d.batch_no,s.notes as note,str.reason,stor.store_name,pb.brand_name");
        $this->db->from('stock_mvts s');
        $this->db->join('stock_mvt_details d', 's.id_stock_mvt = d.stock_mvt_id');
        $this->db->join('stocks st', 's.id_stock_mvt = st.stock_mvt_id and d.product_id=st.product_id and d.batch_no=st.batch_no','left');
        $this->db->join('stock_mvt_types stv', 'stv.id_stock_mvt_type = s.stock_mvt_type_id');
        $this->db->join('stock_mvt_reasons str', 'str.id_stock_mvt_reason = s.stock_mvt_reason_id','left');
        $this->db->join('products p', 'd.product_id= p.id_product');
        $this->db->join('product_brands pb', 'pb.id_product_brand= p.brand_id');
        $this->db->join('stores stor', 'stor.id_store= s.store_id');
        if (!empty($params['search']['brand'])) {
            $this->db->where('p.brand_id', $params['search']['brand']);
        }
        if (!empty($params['search']['reason'])) {
            $this->db->where('str.id_stock_mvt_reason', $params['search']['reason']);
        }
        if (!empty($params['search']['product_name'])) {
            $this->db->where('p.id_product', $params['search']['product_name']);
        }
        if (!empty($params['search']['cat_name'])) {
            $this->db->where('p.cat_id', $params['search']['cat_name']);
        }
        if (!empty($params['search']['batch_no'])) {
            $this->db->like('st.batch_no', $params['search']['batch_no']);
        }
        if(!empty($params['search']['store_id'])){
            $this->db->where('s.store_id', $params['search']['store_id']);
        } else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if(!empty($params['search']['stock_type'])){
            $this->db->where('s.stock_mvt_type_id', $params['search']['stock_type']);
        }else{
            $this->db->group_start();
            $this->db->like('s.stock_mvt_type_id', 12);
            $this->db->or_like('s.stock_mvt_type_id', 5);
            $this->db->or_like('s.stock_mvt_type_id', 8);
            $this->db->group_end();
        }
        if (!empty($params['search']['pro_sub_category'])) {

            $this->db->where('p.subcat_id', $params['search']['pro_sub_category']);
        }
        if (!empty($params['search']['supplier_id'])) {

            $this->db->where('d.supplier_id', $params['search']['supplier_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_stock_mvt >=", $params['search']['FromDate']);
            $this->db->where("s.dtt_stock_mvt <=", $params['search']['ToDate']);
        }
        $this->db->where('s.status_id', 1);
        $this->db->group_by('d.id_stock_mvt_detail');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }

    public function getRowsPurchases($params = array()){
        if((isset($params['search']['stock_type'])&&$params['search']['stock_type']==1) || empty($params['search']['stock_type'])){
            $this->db->select("p.*,pr.dtt_receive as date,pr.store_id,pd.product_id,pd.supplier_id,pd.qty,st.batch_no,pr.notes as note,st.purchase_price,st.selling_price_act,str.reason,stor.store_name,pb.brand_name", FALSE);
            $this->db->from('purchase_receives pr');
            $this->db->join('purchase_receive_details pd', 'pr.id_purchase_receive = pd.purchase_receive_id');
            $this->db->join('products p', 'pd.product_id= p.id_product');
            $this->db->join('product_brands pb', 'pb.id_product_brand= p.brand_id');

            $this->db->join('stock_mvt_reasons str', 'str.id_stock_mvt_reason = pr.stock_mvt_reason_id','left');
            $this->db->join('stocks st', 'st.stock_mvt_detail_id = pd.id_purchase_receive_detail AND st.stock_mvt_type_id = 1');
            $this->db->join('stores stor', 'stor.id_store= pr.store_id');
            if (!empty($params['search']['product_name'])) {
                $this->db->where('p.id_product', $params['search']['product_name']);
            }
            if (!empty($params['search']['reason'])) {
                $this->db->where('str.id_stock_mvt_reason', $params['search']['reason']);
            }
            if (!empty($params['search']['batch_no'])) {
                $this->db->like('st.batch_no', $params['search']['batch_no']);
            }
            if (!empty($params['search']['cat_name'])) {
                // $this->db->join('products', 'stocks.product_id= products.id_product');
                $this->db->where('p.cat_id', $params['search']['cat_name']);
            }
            if(!empty($params['search']['store_id'])){
                $this->db->where('pr.store_id', $params['search']['store_id']);
            } else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
                $this->db->where('pr.store_id', $this->session->userdata['login_info']['store_id']);
            }
            if (!empty($params['search']['pro_sub_category'])) {

                $this->db->where('p.subcat_id', $params['search']['pro_sub_category']);
            }
            if (!empty($params['search']['supplier_id'])) {

                $this->db->where('pd.supplier_id', $params['search']['supplier_id']);
            }
            if (!empty($params['search']['FromDate'])) {
                $this->db->where("pr.dtt_receive >=", $params['search']['FromDate']);
                $this->db->where("pr.dtt_receive <=", $params['search']['ToDate']);
            }
            $this->db->where('pr.status_id', 1);
            // $this->db->order_by('s.product_id', 'desc');
            //set start and limit
            if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit'], $params['start']);
            } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit']);
            }
            $query = $this->db->get();
            return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        }else{
            return false;
        }


    }


    public function max_value($table, $value) {
        $this->db->select_max($value);
        $result = $this->db->get($table);
        return (int) $result->row()->$value;
    }
    public function get_reasons($id){
        $this->db->select("*");
        $this->db->from('stock_mvt_reasons'); 
        $this->db->where('mvt_type_id', $id);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
   
   
    

}

