<?php

class Stock_report_Model extends CI_Model
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
		$this->db->select('s.*,p.product_name,p.*,pb.brand_name,pc.cat_name,psc.cat_name as subcat_name,st.store_name,sp.supplier_name,a.attribute_name');
        $this->db->from('stocks s');
        $this->db->join('products p','s.product_id= p.id_product','left');
        $this->db->join('product_brands pb', 'pb.id_product_brand=p.brand_id','left');
        $this->db->join('product_categories pc', 'pc.id_product_category=p.cat_id','left');
        $this->db->join('product_categories psc', 'psc.id_product_category=p.subcat_id','left');
        $this->db->join('stores st', 's.store_id= st.id_store');
        $this->db->join('suppliers sp', 's.supplier_id= sp.id_supplier','left');
		$this->db->join('vw_stock_attr a', 's.id_stock=a.stock_id', 'left');
        if (!empty($params['search']['product_name'])) {
            $this->db->where('p.id_product', $params['search']['product_name']);
        }
		if (!empty($params['search']['attribue_data'])) {
            $dataArray=explode(',', $params['search']['attribue_data']);
            for($i=0;$i<count($dataArray);$i++){
                $data=explode(';', $dataArray[$i]);
                $this->db->group_start();
                for($k=0;$k<count($data);$k++){
                    $this->db->like('a.attribute_name', $data[$k]);
                }
                $this->db->group_end();
            }

        }
        if (!empty($params['search']['batch_no'])) {
            $this->db->like('s.batch_no', $params['search']['batch_no']);
        }
        if (!empty($params['search']['cat_name'])) {
            $this->db->where('p.cat_id', $params['search']['cat_name']);
        }
        if (!empty($params['search']['pro_sub_category'])) {

            $this->db->where('p.subcat_id', $params['search']['pro_sub_category']);
        }
        if (!empty($params['search']['supplier_id'])) {

            $this->db->where('s.supplier_id', $params['search']['supplier_id']);
        }
        if (!empty($params['search']['brand_id'])) {
            $this->db->where('p.brand_id', $params['search']['brand_id']);
        }
        if (!empty($params['search']['store_id'])) {

            $this->db->where('s.store_id', $params['search']['store_id']);
        }else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("s.dtt_add <=", $params['search']['ToDate']);
        }
        if($params['search']['zero_stock']==1) {
            //$this->db->where("s.qty >",0);
        }else if($params['search']['zero_stock']==2){
            $this->db->where("s.qty",0);
        }else{
            $this->db->where("s.qty >",0);
        }
        $this->db->where('s.status_id', 1);
        //$this->db->group_by(array("s.batch_no", "s.product_id","s.store_id"));
        $this->db->order_by('s.product_id', 'desc');
        $query = $this->db->get();
        //return fetched data
        //echo $this->db->last_query();  
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    // function getRowsProducts2($params = array())
    // {
    //     $this->db->select("v.*,a.attribute_name");
    //     $this->db->from('stock_details_view v');
    //     $this->db->join('vw_stock_attr a', 'v.id_stock=a.stock_id', 'left');
    //     if (!empty($params['search']['product_name'])) {
    //         $this->db->where('v.product_id', $params['search']['product_name']);
    //     }
    //     if (!empty($params['search']['attribue_data'])) {
    //         $dataArray=explode(',', $params['search']['attribue_data']);
    //         for($i=0;$i<count($dataArray);$i++){
    //             //$data=str_replace(';',',',$dataArray[$i]);
    //             $data=explode(';', $dataArray[$i]);
    //             $this->db->group_start();
    //             for($k=0;$k<count($data);$k++){
    //                 $this->db->like('a.attribute_name', $data[$k]);
    //             }
    //             $this->db->group_end();

    //         }

    //     }
    //     if (!empty($params['search']['cat_name'])) {
    //         // $this->db->join('products', 'stocks.product_id= products.id_product');
    //         $this->db->where('v.cat_id', $params['search']['cat_name']);
    //     }
    //     if (!empty($params['search']['pro_sub_category'])) {
    //         $this->db->where('v.subcat_id', $params['search']['pro_sub_category']);
    //     }
    //     if (!empty($params['search']['supplier_id'])) {

    //         $this->db->where('v.supplier_id', $params['search']['supplier_id']);
    //     }
    //     if (!empty($params['search']['store_id'])) {

    //         $this->db->where('v.store_id', $params['search']['store_id']);
    //     } else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
    //         $this->db->where('v.store_id', $this->session->userdata['login_info']['store_id']);
    //     }
    //     if (!empty($params['search']['FromDate'])) {
    //         $this->db->where("v.dtt_add >=", $params['search']['FromDate']);
    //         $this->db->where("v.dtt_add <=", $params['search']['ToDate']);
    //     }
    //     if (empty($params['search']['zero_stock'])) {
    //         $this->db->where("v.current_qty >",0);
    //     }
    //     $this->db->group_by(array("v.batch_no", "v.product_id","v.store_id"));
    //     $this->db->order_by('v.product_id', 'desc');
    //     $query = $this->db->get();
    //     //echo $this->db->last_query();
    //     //return fetched data

    //     return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    // }


    public function suppliers()
    {
        $this->db->select("*");
        $this->db->from("suppliers");
        $this->db->where("status_id", "1");
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }


    public function max_value($table, $value)
    {
        $this->db->select_max($value);
        $result = $this->db->get($table);
        return (int)$result->row()->$value;
    }

    public function get_user_name_by_id($userid)
    {
        $this->db->select('uname');
        $this->db->from('users');
        $this->db->where('id_user', $userid);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->row();
            foreach ($query->result() as $row) {
                $data['username'] = $row;
            }
            return $data['username'];
        } else {
            return false;
        }
    }


}

