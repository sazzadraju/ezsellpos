<?php

class Expiring_soon_products_model extends CI_Model {

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

    public function getExpiredProductRows($params = array()){

        $this->db->select("s.*, p.product_code, p.product_name, p.product_code, pc.cat_name, pcs.cat_name as sub_cat_name, pb.brand_name, ps.store_name,GROUP_CONCAT(DISTINCT CONCAT(a.s_attribute_name,'=',a.s_attribute_value) SEPARATOR ',') AS attribute_name");
        $this->db->from('stocks s');
        $this->db->join('stock_attributes a', 's.id_stock=a.stock_id','left');
        $this->db->join('products p', 's.product_id = p.id_product', 'left');
        $this->db->join('product_categories pc', 'p.cat_id = pc.id_product_category ', 'left');
        $this->db->join('product_categories pcs', 'p.subcat_id = pcs.id_product_category ', 'left');
        $this->db->join('product_brands pb', 'p.brand_id = pb.id_product_brand ', 'left');
        $this->db->join('stores ps', 's.store_id = ps.id_store ', 'left');
        
        $this->db->where('s.qty >', 0);

        
        if(array_key_exists("batch_no",$params)){
            $this->db->like('s.batch_no', $params['batch_no']);
        }

        if(array_key_exists("start_date",$params)){
            $this->db->where('s.expire_date >=', $params['start_date']);
        }

        if(array_key_exists("end_date",$params)){
            $this->db->where('s.expire_date <=', $params['end_date']);
        }

        if(array_key_exists("product_id",$params)){
            $this->db->where('s.product_id =', $params['product_id']);
        }

        if(array_key_exists("cat_name",$params)){
            $this->db->where('p.cat_id =', $params['cat_name']);
        }

        if(array_key_exists("pro_sub_category",$params)){
            $this->db->where('p.subcat_id =', $params['pro_sub_category']);
        }

        if(array_key_exists("store_id",$params)){
            $this->db->where('s.store_id =', $params['store_id']);
        }

        if(array_key_exists("brand",$params)){
            $this->db->where('p.brand_id =', $params['brand']);
        }        
        $this->db->where('s.status_id', 1);
        $this->db->group_by('s.id_stock');
        $this->db->order_by('s.expire_date', 'desc');
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    public function get_available_stock_in_products($request) {
        $this->db->select("s.id_stock, s.batch_no, s.product_id, s.dtt_add,  p.product_name, p.buy_price, p.sell_price, p.is_vatable, p.product_code,GROUP_CONCAT(DISTINCT CONCAT(a.s_attribute_name,'=',a.s_attribute_value) SEPARATOR ',') AS attribute_name");
        $this->db->from("stocks s");
        $this->db->join('stock_attributes a', 's.id_stock=a.stock_id','left');
        $this->db->join('products p', 's.product_id = p.id_product', 'left');
        $this->db->group_start();
        $this->db->like("p.product_name", $request);
        $this->db->or_like("p.product_code", $request);
        $this->db->group_end();
        $this->db->where("p.status_id", 1);

        $this->db->where('s.qty >', 0);
        $this->db->group_by('s.product_id');
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

}