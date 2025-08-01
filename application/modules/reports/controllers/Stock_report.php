<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_report extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('stock_report_model');
        $this->perPage = 500;
    }

    public function index() {
        $data = array();
        $this->breadcrumb->add(lang('stock_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        //get the posts data
        $data['suppliers'] = $this->stock_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['categories'] = $this->stock_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        //$data['products'] = $this->commonmodel->getvalue_row('products', 'id_product,product_code,product_name', array('status_id' => 1));
        $data['brands'] = $this->stock_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['attributes'] = $this->commonmodel->getvalue_row('product_attributes', 'id_attribute,attribute_name,attribute_value', array('status_id' => 1));
        $type= $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop= $this->session->userdata['login_info']['store_id'];
         if ($type != 3){  
        $data['stores'] = $this->stock_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1,'id_store'=>$selected_shop));
          }
           else if ($type == 3) {
         $data['stores'] = $this->stock_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
            }
        $this->template->load('main', 'stock_report/index', $data);
    } 

    public function paginate_data() {
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
        $store_id = $this->input->post('store_id');
        $zero_stock = $this->input->post('zero_stock');
        $attribue_data = $this->input->post('attribue_data');
        $brand_id = $this->input->post('brand_id');
        $batch_no = $this->input->post('batch_no');
        if(!empty($batch_no)){
            $conditions['search']['batch_no'] = $batch_no;
        }
        if(!empty($attribue_data)){
            $conditions['search']['attribue_data'] = $attribue_data;
        }
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
        if (!empty($brand_id)) {
            $conditions['search']['brand_id'] = $brand_id;
        }
         if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        //if ($zero_stock==1) {
            $conditions['search']['zero_stock'] = $zero_stock;
        //}

        //total rows count
        $row = $this->stock_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;

        //get posts data
        $data['columns'] = $this->stock_report_model->getvalue_row('acl_user_column', 'permission', array('acl_module_id'=>86));
        $data['brands'] = $this->stock_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array());
        $data['categories'] = $this->stock_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['posts']= $this->stock_report_model->getRowsProducts($conditions);
        // var_export($conditions);
        $data['suppliers'] = $this->stock_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['stores'] = $this->stock_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        //load the view
        $this->load->view('stock_report/all_stock_report_data', $data, false);
    }

    public function print_data() {
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
        $store_id = $this->input->post('store_id');
        $zero_stock = $this->input->post('zero_stock');
        $attribue_data = $this->input->post('attribue_data');
        $brand_id = $this->input->post('brand_id');
        $batch_no = $this->input->post('batch_no');
        if(!empty($batch_no)){
            $conditions['search']['batch_no'] = $batch_no;
        }
        if(!empty($attribue_data)){
            $conditions['search']['attribue_data'] = $attribue_data;
        }
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($product_name)) {
            $conditions['search']['product_name'] = $product_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if (!empty($brand_id)) {
            $conditions['search']['brand_id'] = $brand_id;
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
         if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        //if ($zero_stock==1) {
            $conditions['search']['zero_stock'] = $zero_stock;
        //}
        //total rows count
        $data['title'] = 'Stock Report';
        //get posts data

        $type= $this->session->userdata['login_info']['user_type_i92']; 
        $data['columns'] = $this->stock_report_model->getvalue_row('acl_user_column', 'permission', array('acl_module_id'=>86));
        $data['brands'] = $this->stock_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array());
        $data['categories'] = $this->stock_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['posts'] = $this->stock_report_model->getRowsProducts($conditions);
        // var_export($conditions);
        $data['suppliers'] = $this->stock_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['store'] = $this->stock_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data3['report']=$this->load->view('stock_report/all_stock_report_data', $data, true);
        $this->load->view('print_page', $data3, false);
    } 
    public function create_csv_data()
    {
        $conditions = array();
        $cat_name = $this->input->post('cat_name');
        $product_name = $this->input->post('product_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $supplier_id = $this->input->post('supplier_id');
        $store_id = $this->input->post('store_id');
        $zero_stock = $this->input->post('zero_stock');
        $attribue_data = $this->input->post('attribue_data');
        $brand_id = $this->input->post('brand_id');
        $batch_no = $this->input->post('batch_no');
        if(!empty($batch_no)){
            $conditions['search']['batch_no'] = $batch_no;
        }
        if(!empty($attribue_data)){
            $conditions['search']['attribue_data'] = $attribue_data;
        }
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($product_name)) {
            $conditions['search']['product_name'] = $product_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if (!empty($brand_id)) {
            $conditions['search']['brand_id'] = $brand_id;
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
         if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        //if ($zero_stock==1) {
            $conditions['search']['zero_stock'] = $zero_stock;
        //}
        $posts = $this->stock_report_model->getRowsProducts($conditions);
        $type= $this->session->userdata['login_info']['user_type_i92']; 
        $columns = $this->stock_report_model->getvalue_row('acl_user_column', 'permission', array('acl_module_id'=>86));
        $fields['product_code'] = 'Product Code';
        $fields['product_name'] = 'product Name';
        $fields['attributes'] = 'Attributes';
        $fields['cat_subcat'] = 'Cat/Subcat';
        $fields['store'] = 'Store Name';
        $fields['supplier_name'] = 'Supplier Name';
        $fields['brand_name'] = 'Brand Name';
        $fields['batch_no'] = 'Batch No';
        $fields['quantity'] = 'Quantity';
        if($columns[0]->permission==1||$type==3){
             $fields['purchase_price'] = 'Purchase Price';
        }
        $fields['selling_price'] = 'Selling Price';
        $fields['total_price'] = 'Total Price';
        $qty = 0;
        $sell = 0;
        $total_price = 0;
        $purchase = 0;
        $count = 1;
        $total_sell=0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $array['product_code'] = $post['product_code'];
                $array['product_name'] = $post['product_name'];
                $array['attributes'] = $post['attribute_name'];
                $array['cat_subcat'] = $post['cat_name'].'/'.$post['subcat_name'];
                $array['store'] = $post['store_name'];
                $array['supplier_name'] = $post['supplier_name'];
                $array['brand_name'] = $post['brand_name'];
                $array['batch_no'] = $post['batch_no'];
                $array['quantity'] = $post['qty'];
                if($columns[0]->permission==1||$type==3){
                     $array['purchase_price'] = $post['purchase_price'];
                }
                $array['selling_price'] = $post['selling_price_act'];
                $array['total_price'] = $post['qty']*$post['purchase_price'];
                $value[] = $array;
                $count++;
                $qty +=$post['qty'];
                $sell += $post['selling_price_act'];
                $purchase += $post['purchase_price'];
                $total_price +=($post['qty'] * $post['purchase_price']);
                $total_sell += ($post['qty'] * $post['selling_price_act']);
            }
            $array['product_code'] = '';
            $array['product_name'] = '';
            $array['attributes'] = '';
            $array['cat_subcat'] = '';
            $array['store'] = '';
            $array['supplier_name'] = '';
            $array['brand_name'] = '';
            $array['batch_no'] = 'Total Qty.:';
            $array['quantity'] = number_format($qty, 2,'.','');
            if($columns[0]->permission==1||$type==3){
                $array['purchase_price'] = 'Stock Value: '.set_currency(number_format($total_price, 2,'.',''));
            }
            $array['selling_price'] = '';
            $array['total_price'] ='';
            $value[] = $array;
            $array['product_code'] = '';
            $array['product_name'] = '';
            $array['attributes'] = '';
            $array['cat_subcat'] = '';
            $array['store'] = '';
            $array['supplier_name'] = '';
            $array['brand_name'] = '';
            $array['batch_no'] = 'Total Item:';
            $array['quantity'] = $count - 1;;
            if($columns[0]->permission==1||$type==3){
                $array['purchase_price'] = '';
            }
            $array['selling_price'] = 'Est. Selling Price: '.set_currency(number_format($total_sell, 2,'.',''));
            $array['total_price'] ='';
            $value[] = $array;
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'stock_report'
        , 'file_title' => 'Stock Report'
        , 'field_title' => $fields
        , 'field_data' => $value
        , 'from' => ''
        , 'to' => ''
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
