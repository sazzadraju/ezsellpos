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
          'is_vatable' => $data['is_vatable'],
          'vat' => $data['vat'],
          'unit_id' => $data['unit_id'],
          'buy_price' => $data['buy_price'],
          'sell_price' => $data['sell_price'],
          'min_stock' => $data['min_stock'],
          'dtt_add' => mdate("%Y-%m-%d %H:%i:%s"),
          'uid_add' => 1
        );

        $this->db->insert('products', $productData);
        if($data['supplier_id']!=''){
            $insert_id = $this->db->insert_id();
            $data = array(
              'porduct_id' => $insert_id,
              'supplier_id' => $data['supplier_id'],
              'dtt_add' => mdate("%Y-%m-%d %H:%i:%s"),
              'uid_add' => 1
            );
            $this->db->insert('products_suppliers', $data);

        }
    }
    function matchingSupplierId($name){
        $this->db->select("id_supplier");
        $this->db->from("suppliers");
        $this->db->where('supplier_name', $name);
        $this->db->limit(1);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function insertNewSupplier($name){

        $this->load->helper('date');

        $data = array(
            'supplier_name' => $name,
            'supplier_code' => rand().rand().rand(),
            'balance' => 0,
            'credit_balance' => 0,
            'dtt_add' => date('Y-m-d H:i:s'),
            'uid_add' => 1
        );
        $this->db->insert('suppliers', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
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

    function pcode_exists($key){
        $this->db->where('product_code',$key);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

}
