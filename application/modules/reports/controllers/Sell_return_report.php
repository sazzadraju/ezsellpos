<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sell_return_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('sell_return_report_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('sell_return_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->sell_return_report_model->getRowsProducts());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'sell_return_report/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['de_vat'] = $this->sell_return_report_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        // $data['max_val'] = $this->sell_return_report_model->max_value('products', 'sell_price');
        // $data['suppliers'] = $this->sell_return_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['users'] = $this->sell_return_report_model->getvalue_row('users', 'id_user,uname', array('status_id' => 1));
        $data['customers'] = $this->sell_return_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['stations'] = $this->sell_return_report_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $data['products'] = $this->sell_return_report_model->getvalue_row('products', 'id_product,product_code,product_name', array('status_id' => 1));
        // var_export($data['stations']);
        $data['categories'] = $this->sell_return_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['brands'] = $this->sell_return_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->sell_return_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->sell_return_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['posts'] = $this->sell_return_report_model->getRowsProducts(array('limit' => $this->perPage));

        $this->template->load('main', 'sell_return_report/index', $data);
    }


    public function paginate_data($page = 0)
    {
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $report_type = $this->input->post('report_type');
        $product_id = $this->input->post('product_id');
        $invoice_no = $this->input->post('invoice_no');
        $station_id = $this->input->post('station_id');
        $store_id = $this->input->post('store_id');
        $customer_id = $this->input->post('customer_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $batch_no = $this->input->post('batch_no');
        $brand = $this->input->post('brand');
        if (!empty($brand)) {
            $conditions['search']['brand'] = $brand;
        }
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if ($product_id != '0') {
            $conditions['search']['product_id'] = $product_id;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        if($report_type=='invoice'){
            $row = $this->sell_return_report_model->getRowsProducts($conditions);
         }else{
            $row = $this->sell_return_report_model->getRowsSummary($conditions);
         }
       
        $totalRec = ($row != '')?count($row):0;
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
        $data['sold_by'] = $this->sell_return_report_model->getvalue_row('users', 'id_user,uname', array());
        $data['customers'] = $this->sell_return_report_model->getvalue_row('customers', 'id_customer,full_name', array());
        $data['station'] = $this->sell_return_report_model->getvalue_row('stations', 'id_station,name', array());
        $data['store'] = $this->sell_return_report_model->getvalue_row('stores', 'id_store,store_name', array());
        $data['categories'] = $this->sell_return_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['brands'] = $this->sell_return_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['offset']=$offset;
        if($report_type=='invoice'){
            $data['posts'] = $this->sell_return_report_model->getRowsProducts($conditions);
            $this->load->view('sell_return_report/all_report_invoice_data', $data, false);
         }else{
            $data['posts'] = $this->sell_return_report_model->getRowsSummary($conditions);
            $this->load->view('sell_return_report/all_report_summary_data', $data, false);
         }
        
        // }
    }
    public function print_data(){
        $report_type = $this->input->post('report_type');
        $product_id = $this->input->post('product_id');
        $invoice_no = $this->input->post('invoice_no');
        $station_id = $this->input->post('station_id');
        $store_id = $this->input->post('store_id');
        $customer_id = $this->input->post('customer_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $batch_no = $this->input->post('batch_no');
        $brand = $this->input->post('brand');
        if (!empty($brand)) {
            $conditions['search']['brand'] = $brand;
        }
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if ($product_id != '0') {
            $conditions['search']['product_id'] = $product_id;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['offset']=0;
        $data['title'] = 'Sale Return Report';
        $data['sold_by'] = $this->sell_return_report_model->getvalue_row('users', 'id_user,uname', array());
        $data['customers'] = $this->sell_return_report_model->getvalue_row('customers', 'id_customer,full_name', array());
        $data['station'] = $this->sell_return_report_model->getvalue_row('stations', 'id_station,name', array());
        $data['store'] = $this->sell_return_report_model->getvalue_row('stores', 'id_store,store_name', array());
        $data['categories'] = $this->sell_return_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['brands'] = $this->sell_return_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        if($report_type=='invoice'){
            $data['posts'] = $this->sell_return_report_model->getRowsProducts($conditions);
            $data3['report']=$this->load->view('sell_return_report/all_print_invoice_data', $data, true);
         }else{
            $data['posts'] = $this->sell_return_report_model->getRowsSummary($conditions);
            $data3['report']=$this->load->view('sell_return_report/all_report_summary_data', $data, true);
         }
         $this->load->view('print_page', $data3, false);
    }


}
