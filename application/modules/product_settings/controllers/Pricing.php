<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pricing extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('language', 'url', 'html', 'form'));
        $this->load->library('session');
        $this->load->library('Ajax_pagination');        

        $this->lang->load('en');

        $this->load->model('product_model');
        $this->perPage = 200;
    }

    public function index() {
        $data = array();
        $this->dynamic_menu->check_menu('products/pricing');
        $this->breadcrumb->add(lang('products'), 'products', 1);
        $this->breadcrumb->add('Pricing', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();

        $store_ids = $_SESSION['login_info']['store_ids'];

        if(!empty($store_ids)){
            $store_info = array();
            foreach($store_ids as $store_id){
                $store_info[] = $this->product_model->getStoreInfo($store_id);
            } 
        }
        $data['store_info'] = $store_info;        
        $data['products'] = $this->product_model->getvalue_row('products', '*', array('status_id'=> 1));
        $data['categories'] = $this->product_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));

        $data['brands'] = $this->product_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));

        $data['suppliers'] = $this->product_model->getvalue_row('suppliers', '*', array('status_id' => 1));

        // echo '<pre>';
        // print_r($p);
        // echo "</pre>";
        // die();

        $this->template->load('main', 'pricing/index', $data);
    }

    function pricingPaginationData(){

        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        $store              = $this->input->post('store');
        $product_name       = $this->input->post('product_name');
        $cat_name           = $this->input->post('cat_name');
        $pro_sub_category   = $this->input->post('pro_sub_category');
        $brand              = $this->input->post('brand');
        $supplier           = $this->input->post('supplier');

        $arg = array('solt'=> '420');
        if($store != 0){
            $arg = array_merge($arg, array('store'=>$store));
        }else{
            $arg = array_merge($arg, array('store'=>$this->session->userdata['login_info']['store_id'])); 
        }
        if($product_name != 0){
            $arg = array_merge($arg, array('product_name'=>$product_name));
        }
        if($cat_name != 0){
            $arg = array_merge($arg, array('cat_name'=>$cat_name));
        }
        if($pro_sub_category != -1){
            $arg = array_merge($arg, array('pro_sub_category'=>$pro_sub_category));
        }
        if($brand != 0){
            $arg = array_merge($arg, array('brand'=>$brand));
        }
        if($supplier != 0){
            $arg = array_merge($arg, array('supplier'=>$supplier));
        }

        
        
        //total rows count
        $totalRec = 0;
        $dt = $this->product_model->getProductDetails($arg);
        if(!empty($dt)){
            $totalRec = count($this->product_model->getProductDetails($arg));
        }
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'products/pricingPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $this->ajax_pagination->initialize($config);



        $arg = array_merge($arg, array('start'=>$offset,'limit'=>$this->perPage));
       
        
        //get the posts data
        $data['products'] = $this->product_model->getProductDetails($arg);
        $data['columns'] = $this->product_model->getvalue_row('acl_user_column', 'permission', array('acl_module_id'=>121));

        // echo '<pre>';
        // print_r($data['products']);
        // echo '</pre>';
        // die();
        //load the view
        $this->load->view('pricing/pricing-pagination-data', $data, false);
    }

    public function pricing_update(){

        $expire_date         = $this->input->post('expire_date');
        $alert_date          = $this->input->post('alert_date');
        $selling_price_act   = $this->input->post('selling_price_act');
        $stock_id            = $this->input->post('stock_id');

        
        // $this->form_validation->set_rules('expire_date[]', 'Expire Date', 'required');
        // $this->form_validation->set_rules('alert_date[]', 'Alert Date', 'required');
        $this->form_validation->set_rules('selling_price_act[]', 'Selling price', 'required');
          
        


        if ($this->form_validation->run() == FALSE)
        {
            echo validation_errors();

        }
        else
        {
            $i = 0;
            $srcData = array();
            $cnt = 0;
            foreach ($stock_id as $aStock_id) {
                $srcData = array(
                    'expire_date' => $expire_date[$i],
                    'alert_date' => $alert_date[$i],
                    'selling_price_act' => $selling_price_act[$i],
                    'selling_price_est' => $selling_price_act[$i],
                    'id_stock' => $stock_id[$i]
                );
                $cnt += $this->product_model->updateStockProductInfo($srcData);
                $i++;
            }

            echo $cnt;
        }
    }
    
}    