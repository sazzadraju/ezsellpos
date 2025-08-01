<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_sell_report extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('product_sell_report_model');
        $this->perPage = 500;
    }

    public function index() {
        $data = array();
        $this->breadcrumb->add(lang('product-sell-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['categories'] = $this->product_sell_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->product_sell_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->product_sell_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['customers'] = $this->product_sell_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['suppliers'] = $this->product_sell_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name,phone', array('status_id' => 1));
        $data['salesPersons'] = $this->product_sell_report_model->getSales_person_list();
        $data['brands'] = $this->product_sell_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['products'] = $this->commonmodel->getvalue_row('products', 'id_product,product_code,product_name', array('status_id' => 1));
        $this->template->load('main', 'product_sell_report/index', $data);
    }

   

    public function paginate_data($page = 0) {
        $conditions = array();

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $store_id = $this->input->post('store_id');
        $cat_name = $this->input->post('cat_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $brand = $this->input->post('brand');
        $product_name = $this->input->post('product_name');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $batch_no = $this->input->post('batch_no');
        $sales_person = $this->input->post('sales_person');
        $customer_id = $this->input->post('customer_id');
        $supplier_id = $this->input->post('supplier_id');
        $gift_sale = $this->input->post('gift_sale');
        if ($gift_sale!= 0 ) {
            $conditions['search']['gift_sale'] = $gift_sale;
        }
        if ($supplier_id!= 0 ) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if ($sales_person!= 0 ) {
            $conditions['search']['sales_person'] = $sales_person;
        }
        if ($customer_id!= 0 ) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if (!empty($brand)) {
            $conditions['search']['brand'] = $brand;
        }
        if ($product_name != 0) {
            $conditions['search']['product_name'] = $product_name;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['store'] = $this->product_sell_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $row = $this->product_sell_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product-sell-report/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['posts'] = $this->product_sell_report_model->getRowsProducts($conditions);
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['which_store'] = $store_id;

        $this->load->view('product_sell_report/all_report_data', $data, false);
    }
    
    public function print_data($page = 0) {
        $conditions = array();
         
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
       
        $store_id = $this->input->post('store_id');
        $cat_name = $this->input->post('cat_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $brand = $this->input->post('brand');
        $product_name = $this->input->post('product_name');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $batch_no = $this->input->post('batch_no');
        $sales_person = $this->input->post('sales_person');
        $customer_id = $this->input->post('customer_id');
        $supplier_id = $this->input->post('supplier_id');
        $gift_sale = $this->input->post('gift_sale');
        if ($gift_sale!= 0 ) {
            $conditions['search']['gift_sale'] = $gift_sale;
        }
        if ($supplier_id!= 0 ) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if ($sales_person!= 0 ) {
            $conditions['search']['sales_person'] = $sales_person;
        }
        if ($customer_id!= 0 ) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if (!empty($brand)) {
            $conditions['search']['brand'] = $brand;
        }
         if (!empty($product_name)) {
            $conditions['search']['product_name'] = $product_name;
        }
         if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate.' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate.' 23:59:59';
        }
        
        $row = $this->product_sell_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Product Sale Report';
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product-sell-report/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['which_store'] = $store_id;
        $data['posts'] = $this->product_sell_report_model->getRowsProducts($conditions);
        $data3['report']=$this->load->view('product_sell_report/all_report_data', $data, true);
        $this->load->view('print_page', $data3, false);
    // }
    }
    public function create_csv_data()
    {
        $conditions = array();
        $store_id = $this->input->post('store_id');
        $cat_name = $this->input->post('cat_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $brand = $this->input->post('brand');
        $product_name = $this->input->post('product_name');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $batch_no = $this->input->post('batch_no');
        $sales_person = $this->input->post('sales_person');
        $customer_id = $this->input->post('customer_id');
        $gift_sale = $this->input->post('gift_sale');
        if ($gift_sale!= 0 ) {
            $conditions['search']['gift_sale'] = $gift_sale;
        }
        if ($sales_person!= 0 ) {
            $conditions['search']['sales_person'] = $sales_person;
        }
        if ($customer_id!= 0 ) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }

        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if (!empty($brand)) {
            $conditions['search']['brand'] = $brand;
        }
        if ($product_name!=0) {
            $conditions['search']['product_name'] = $product_name;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $posts = $this->product_sell_report_model->getRowsProducts($conditions);
        $fields = array(
            'date' => 'Date'
        , 'invoice_no' => 'Invoice No'
        , 'product_name' => 'Product Name'
        , 'product_code' => 'Product Code'
        , 'batch_no' => 'Batch No'
        , 'customer' => 'Customer Name'
        , 'cat_subcat' => 'Cat/Subcat'
        , 'brand' => 'Brand'
        , 'store' => 'Store'
        , 'purchase_unit' => 'Unit Purchase'
        , 'unit_price' => 'Unit Price'
        , 'qty' => 'Qty'
        , 'purchase_price' => 'Total Purchase'
        , 'vat' => 'Vat'
        , 'dis' => 'Discount'
        , 'amount' => 'Amount'
        );
        $sum_qty = 0;
        $total = 0;
        $vat_sum = 0;
        $dis_sum = 0;
        $purchase_sum=0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $total += $post['amt'];
                $sum_qty += $post['qty'];
                $vat_sum += $post['vat_amt'];
                $dis_sum +=  $post['discount_amt'];
                $purchase_sum +=  $post['purchase_price']*$post['qty'];
                $category=$post['cat_name'] . '/' . $post['subcat_name'];
                $value[] = array(
                    'date' => date('Y-m-d', strtotime($post['dtt_add']))
                , 'invoice_no' => $post['invoice_no']
                , 'product_name' => $post['product_name']
                , 'product_code' => $post['product_code']
                , 'batch_no' => $post['batch_no']
                , 'customer' => $post['customer_name'] . ' (' . $post['customer_code'] .')'
                , 'cat_subcat' => $category
                , 'brand' => $post['brand_name']
                , 'store' => $post['store_name']
                , 'purchase_unit' => $post['purchase_price']
                , 'unit_price' => $post['unit_price']/$post['qty']
                , 'qty' => $post['qty']
                , 'purchase_price' => $post['purchase_price']*$post['qty']
                , 'vat' => $post['vat_amt']
                , 'dis' => $post['discount_amt']
                , 'amount' => $post['amt']
                );
                $count++;
            }
            $value[] = array(
                'date' => ''
            , 'invoice_no' => ''
            , 'product_name' => ''
            , 'product_code' => ''
            , 'batch_no' => ''
            , 'customer' =>''
            , 'cat_subcat' => ''
            , 'brand' => ''
            , 'store' => ''
            , 'purchase_unit' => ''
            , 'unit_price' => 'total'
            , 'qty' => $sum_qty
            , 'purchase_price' => $purchase_sum
            , 'vat' => $vat_sum
            , 'dis' => $dis_sum
            , 'amount' => $total
            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'product_sale_report'
        , 'file_title' => 'Product Sale Report'
        , 'field_title' => $fields
        , 'field_data' => $value
        , 'from' => $FromDate
        , 'to' => $ToDate
        );
        $data = json_encode($dataArray);
        $token=rand();
        $re=array(
            'token'=>$token
        ,'value'=>$data
        ,'date'=>date('Y-m-d')
        );
        $id=$this->commonmodel->common_insert('csv_report',$re);
        echo json_encode(array('id'=>$id,'token'=>$token));
    }

}
