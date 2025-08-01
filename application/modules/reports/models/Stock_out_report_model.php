<?php

class Stock_out_report_model extends CI_Model {

    

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

    public function get_stock_out_reason() {
        $this->db->select('id_stock_mvt_reason,reason,mvt_type_id');
        $this->db->from('stock_mvt_reasons');
        $this->db->where('status_id','1');
        $this->db->where('qty_multiplier','-1');
        $this->db->group_start();
        $this->db->where("mvt_type_id =13");
        $this->db->or_where("mvt_type_id =6");
        $this->db->or_where("mvt_type_id =7");
        $this->db->group_end();
        $query = $this->db->get();

        if ( $query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    function getRowsProducts($params = array()) {

        // pa($params);
        // var_export('hasib ahmed');
        $this->db->select('m.stock_mvt_reason_id,d.batch_no,d.qty,d.purchase_price,m.invoice_no,m.store_id,m.dtt_stock_mvt,mr.reason,mr.mvt_type_id,m.notes,stv.type_name,st.store_name,p.product_name,p.product_code,p.subcat_id,p.cat_id,pb.brand_name,d.supplier_id');
        $this->db->from('stock_mvts m');
        $this->db->join('stock_mvt_details d', 'm.id_stock_mvt = d.stock_mvt_id');
        $this->db->join('products p', 'd.product_id= p.id_product');
         $this->db->join('product_brands pb', 'pb.id_product_brand= p.brand_id');
        $this->db->join('stock_mvt_reasons mr', 'mr.id_stock_mvt_reason = m.stock_mvt_reason_id','left');
        $this->db->join('stock_mvt_types stv', 'stv.id_stock_mvt_type = m.stock_mvt_type_id');
        $this->db->join('stores st', 'm.store_id= st.id_store');
        if (!empty($params['search']['product_name'])) {
            $this->db->where('p.id_product', $params['search']['product_name']);
        }
        if (!empty($params['search']['store_id'])) {
            $this->db->where('m.store_id', $params['search']['store_id']);
        }else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('m.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['cat_name'])) {
            $this->db->where('p.cat_id', $params['search']['cat_name']);
        }
        if (!empty($params['search']['pro_sub_category'])) {

            $this->db->where('p.subcat_id', $params['search']['pro_sub_category']);
        }
        if (!empty($params['search']['supplier_id'])) {

            $this->db->where('d.supplier_id', $params['search']['supplier_id']);
        }
        if(!empty($params['search']['batch_no'])){
            $this->db->like('d.batch_no', $params['search']['batch_no']);
        }
        if (!empty($params['search']['reason'] ) ){
            // pa($params['search']['reason']);
            $this->db->where('mr.id_stock_mvt_reason',$params['search']['reason'] );
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("m.dtt_stock_mvt >=", $params['search']['FromDate']);
            $this->db->where("m.dtt_stock_mvt <=", $params['search']['ToDate']);
        }
        if(!empty($params['search']['stock_type'])){
            $this->db->where('m.stock_mvt_type_id', $params['search']['stock_type']);
        }else {
            $this->db->group_start();
            $this->db->where("m.stock_mvt_type_id =13");
            $this->db->or_where("m.stock_mvt_type_id =6");
            $this->db->or_where("m.stock_mvt_type_id =7");
            $this->db->group_end();
        }
        $this->db->where('m.status_id', 1);
        //$this->db->group_by("m.invoice_no");
        $query = $this->db->get();
        //echo  $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }

     public function get_invoice_details($invoice_id) {
        $this->db->select("d.*,m.*,st.store_name,p.product_name,p.product_name,GROUP_CONCAT(DISTINCT CONCAT(a.s_attribute_name,'=',a.s_attribute_value) SEPARATOR ',') AS attribute_name");
        $this->db->from('stock_mvt_details d');
        $this->db->join('stock_mvts m','m.id_stock_mvt = d.stock_mvt_id');
        $this->db->join('stocks s', 'd.batch_no = s.batch_no AND d.product_id=s.product_id','left');
        $this->db->join('stock_attributes a', 's.id_stock=a.stock_id','left');
        $this->db->join('products p', 'd.product_id= p.id_product');
        $this->db->join('stores st', 'm.store_id= st.id_store');
        $this->db->where('m.invoice_no', $invoice_id);
        $this->db->where('d.status_id', 1);
         $this->db->group_by('d.batch_no');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        //return $query->row();
    }

//

    public function max_value($table, $value) {
        $this->db->select_max($value);
        $result = $this->db->get($table);
        return (int) $result->row()->$value;
    }

   

}

