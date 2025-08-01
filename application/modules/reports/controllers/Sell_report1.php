<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sell_report extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('sell_report_model');
        $this->perPage = 20;
    }

    public function index() {
        $data = array();
        $this->breadcrumb->add(lang('sell_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->sell_report_model->getRowsProducts());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'sell_report/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['de_vat'] = $this->sell_report_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        // $data['max_val'] = $this->sell_report_model->max_value('products', 'sell_price');
        // $data['suppliers'] = $this->sell_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['users'] = $this->sell_report_model->getvalue_row('users', 'id_user,uname', array('status_id' => 1));
        $data['customers'] = $this->sell_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['stations'] = $this->sell_report_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        // var_export($data['stations']);
        $data['posts'] = $this->sell_report_model->getRowsProducts(array('limit' => $this->perPage));

        $this->template->load('main', 'sell_report/index', $data);
    }

    public function check_product_code() {
        $this->load->database();
        $pro_code = $this->input->post('pro_code');
        $this->db->where('product_code', $pro_code);
        $this->db->where('status_id', 1);
        $query = $this->db->get('products');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function getMaxNumber() {
        $this->load->database();
        $this->db->select('max(product_code) as code');
        $result = $this->db->get('products')->row();
        $code = ($result->code) + 1;
        echo $code;
    }

   

    public function paginate_data($page = 0) {
        $conditions = array();
         
        //calc offset number
    // public function paginate_data() {
    //     $conditions = array();
    //     $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
       // if ($this->input->post('FromDate') == '') {
         // $this->form_validation->set_rules('FromDate', 'From Date', 'trim|required');
        // }
        // else{
        $invoice_no = $this->input->post('invoice_no');
        $station_id = $this->input->post('station_id');
        $customer_id = $this->input->post('customer_id');
        $uid_add = $this->input->post('uid_add');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($station_id)) {
            $conditions['search']['station_id'] = $station_id;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($uid_add)) {
            $conditions['search']['uid_add'] = $uid_add;
        }
         if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate;
            $conditions['search']['ToDate'] = $ToDate;
        }
        
        $totalRec = count($this->sell_report_model->getRowsProducts($conditions));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['sold_by'] = $this->sell_report_model->getvalue_row('users', 'id_user,uname', array());
        $data['customers'] = $this->sell_report_model->getvalue_row('customers', 'id_customer,full_name', array());
        $data['station'] = $this->sell_report_model->getvalue_row('stations', 'id_station,name', array());
        $data['store'] = $this->sell_report_model->getvalue_row('stores', 'id_store,store_name', array());
        // $data['categories'] = $this->sell_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['posts'] = $this->sell_report_model->getRowsProducts($conditions);
        // var_export($data['posts']);
        //  var_export($conditions);
        //load the view
        $this->load->view('sell_report/all_report_data', $data, false);
    // }
    }
    public function edit_data($id = null) {
        $data = $this->sell_report_model->get_product_by_id($id);
        $suppliers = $this->sell_report_model->suppliers();
        $product_suppliers = $this->sell_report_model->get_product_supplier($id);
        echo json_encode(array("data" => $data, "suppliers" => $suppliers, "product_suppliers" => $product_suppliers));
        //echo json_encode($data);
    }

    public function details_data($id = null) {
        $data = $this->sell_report_model->get_product_details_by_id($id);
        $data1 = $this->sell_report_model->get_supplier_by_product_id($id);
        foreach ($data as $key => $value) {
            $arrayVal[$key] = $value;
        }
        $dataValue = '';
        if (!empty($data1)) {
            foreach ($data1 as $val) {
                $coma = (empty($dataValue) ? '' : ', ');
                $dataValue .= $coma . '<a href="' . base_url() . 'supplier/' . $val['id_supplier'] . '" target="_blank">' . $val['supplier_name'] . '</a>   ';
            }
        }
        $arrayVal['supplier_name'] = $dataValue;
        echo json_encode($arrayVal);
    }

    public function delete_data($id = null) {
        //echo "data delete successfully";
        $condition = array(
            'id_product' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->sell_report_model->update_value('products', $data, $condition);
        echo json_encode(array("status" => TRUE));
    }

    public function getsubcategory() {
        $id = $this->input->post('id');
        $condition = array(
            'parent_cat_id' => $id
        );
        $categories = $this->sell_report_model->getvalue_row('product_categories', 'cat_name,id_product_category', $condition);
        echo json_encode($categories);
    }

    public function isProductExist($pro_code) {
        //$pro_code=$this->input->post('pro_code');
        $is_exist = $this->sell_report_model->isProductExist($pro_code);

        if (!$is_exist) {
            $this->form_validation->set_message(
                    'pro_code', 'This code already taken'
            );
            return false;
        } else {
            return true;
        }
    }

    public function select_category() {
        if ($this->input->post('category') == 0) {
            $this->form_validation->set_message('category', 'Please choose any one');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_product_name() {
        $pro_name = $this->input->post('pro_name');
        $res = $this->sell_report_model->check_value('products', 'product_name', $pro_name);
        $val = ($res) ? 'false' : 'true';
        echo $val;
    }
    
    public function print_page() {
          $data = array();
        $this->breadcrumb->add(lang('sell_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->sell_report_model->getRowsProducts());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['configs'] = $this->sell_report_model->getvalue_row('configs', 'param_key,param_val', array());
        $data['de_vat'] = $this->sell_report_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        $data['max_val'] = $this->sell_report_model->max_value('products', 'sell_price');
        $data['suppliers'] = $this->sell_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['units'] = $this->sell_report_model->getvalue_row('product_units', 'unit_code,id_product_unit', array('status_id' => 1));
        $data['brands'] = $this->sell_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['categories'] = $this->sell_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['posts'] = $this->sell_report_model->getRowsProducts(array('limit' => $this->perPage));
        $this->template->load('main', 'sell_report/index2', $data);
    }
    public function paginate_data2() {
         $conditions = array();
         //calc offset number
         $page = $this->input->post('page');
         if (!$page) {
             $offset = 0;
         } else {
             $offset = $page;
         }
         $cat_name = $this->input->post('cat_name');
         $product_name = $this->input->post('product_name');
         $pro_sub_category = $this->input->post('pro_sub_category');
         $supplier_id = $this->input->post('supplier_id');
         $ToDate = $this->input->post('ToDate');
         $FromDate = $this->input->post('FromDate');
         // $price_range = $this->input->post('price_range');
         if (!empty($cat_name)) {
             $conditions['search']['cat_name'] = $cat_name;
         }
         if (!empty($product_name)) {
             $conditions['search']['product_name'] = $product_name;
         }
         if (!empty($pro_sub_category)) {
             $conditions['search']['pro_sub_category'] = $pro_sub_category;
         }
         if (!empty($supplier_id)) {
             $conditions['search']['supplier_id'] = $supplier_id;
         }
          if (!empty($FromDate)) {
             $conditions['search']['FromDate'] = $FromDate;
             $conditions['search']['ToDate'] = $ToDate;
         }
         //  if (!empty($ToDate)) {
         //     $conditions['search']['ToDate'] = $ToDate;
         // }
         // if (!empty($price_range)) {
         //     $str1 = explode(' - ৳', $price_range);
         //     $str2 = ltrim($str1[0], '৳');
         //     $conditions['search']['pro_price_from'] = $str2;
         //     $conditions['search']['pro_price_to'] = $str1[1];
         // }

         //total rows count
         $totalRec = count($this->sell_report_model->getRowsProducts($conditions));
          $userid= $this->session->userdata['login_info']['id_user_i90'];
         //pagination configuration
         $config['target'] = '#postList';
         $config['base_url'] = base_url() . 'product/page_data';
         $config['total_rows'] = $totalRec;
         $config['per_page'] = $this->perPage;
         $config['link_func'] = 'searchFilter';
         $this->ajax_pagination->initialize($config);

         //set start and limit
         $conditions['start'] = $offset;
         $conditions['limit'] = $this->perPage;

         //get posts data
         $data['configs'] = $this->sell_report_model->getvalue_row('configs', 'param_key,param_val', array());
         $data['brands'] = $this->sell_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array());
         $data['categories'] = $this->sell_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
          $data['suppliers'] = $this->sell_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
         $data['posts'] = $this->sell_report_model->getRowsProducts($conditions);
         $data['username'] = $this->sell_report_model->get_user_name_by_id($userid);
         //load the view
        $this->load->view('sell_report/index2', $data, false);
    }
}
