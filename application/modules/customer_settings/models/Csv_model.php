<?php
 
class Csv_model extends MX_Controller {
 
    function __construct() {
        parent::__construct();
 
    }

    function catMatchingID($pc){

            $this->db->select("id_product_category");
            $this->db->from("product_categories");
            $this->db->where('cat_name', $pc);
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->result_array();
            
    }


    function insertCatNameGetId($newCat){

        $this->load->helper('date');

        $catData = array(
            'cat_name' => $newCat,
            'parent_cat_id' => NULL,
            'dtt_add' => mdate("%Y-%m-%d %H:%i:%s"),
            'uid_add' => 1,
            'dtt_mod' => NULL,
            'uid_mod' => NULL
        );
        $this->db->insert('product_categories', $catData);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function insertSubCatNameGetId($newSubCat, $catId){

        $this->load->helper('date');

        $subCatData = array(
            'cat_name' => $newSubCat,
            'parent_cat_id' => $catId,
            'dtt_add' => mdate("%Y-%m-%d %H:%i:%s"),
            'uid_add' => 1,
            'dtt_mod' => NULL,
            'uid_mod' => NULL
        );
        $this->db->insert('product_categories', $subCatData);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function insertACsvProduct($data){

        $productData = array(
          'product_code' => $data['product_code'],
          'cat_id' => $data['cat_id'],
          'subcat_id' => $data['subcat_id'],
          'product_name' => $data['product_name'],
          'description' => $data['description'],
          'brand_id' => $data['brand_id'],
          'is_vatable' => 1,
          'unit_id' => $data['unit_id'],
          'buy_price' => $data['buy_price'],
          'sell_price' => $data['sell_price'],
          'min_stock' => $data['min_stock'],
          'product_img' => 'img',
          'dtt_add' => mdate("%Y-%m-%d %H:%i:%s"),
          'uid_add' => 1,
          'dtt_mod' => NULL,
          'uid_mod' => NULL
        );

        $this->db->insert('products', $productData);
    }

    function matchingBrandId($brandName){
        $this->db->select("id_product_brand");
        $this->db->from("product_brands");
        $this->db->where('brand_name', $brandName);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function insertNewBrand($brandName){

        $this->load->helper('date');

        $brandData = array(
            'brand_name' => $brandName,
            'description' => '',
            'img_main' => '',
            'img_thumb' => '',
            'dtt_add' => mdate("%Y-%m-%d %H:%i:%s"),
            'uid_add' => 1,
            'dtt_mod' => NULL,
            'uid_mod' => NULL
        );
        $this->db->insert('product_brands', $brandData);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function matchingUnitId($unit_name){
        $this->db->select("id_product_unit");
        $this->db->from("product_units");
        $this->db->where('unit_code', $unit_name);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function insertNewUnit($unitName){

        $this->load->helper('date');

        $unitData = array(
            'unit_code' => $unitName,
            'title' => '',
            'dtt_add' => mdate("%Y-%m-%d %H:%i:%s"),
            'uid_add' => 1,
            'dtt_mod' => NULL,
            'uid_mod' => NULL
        );
        $this->db->insert('product_units', $unitData);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function product_exists($key){
        $this->db->where('product_name',$key);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    function customer_code_exists($key){
        $this->db->where('customer_code',$key);
        $query = $this->db->get('customers');
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

}
