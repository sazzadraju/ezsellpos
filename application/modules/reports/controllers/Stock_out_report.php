<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_out_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('stock_out_report_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('stock-out-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->stock_out_report_model->getRowsProducts());
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->stock_out_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->stock_out_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['suppliers'] = $this->stock_out_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['brands'] = $this->stock_out_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['categories'] = $this->stock_out_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['products'] = $this->stock_out_report_model->getvalue_row('products', 'id_product,product_code,product_name', array('status_id' => 1));
        $data['reason'] = $this->stock_out_report_model->get_stock_out_reason();
        $this->template->load('main', 'stock_out_report/index', $data);
    }


    public function paginate_data()
    {
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
        $store_id = $this->input->post('store_id');
        $stock_type = $this->input->post('stock_type');
        $batch_no = $this->input->post('batch_no');
        $brand = $this->input->post('brand');
        $reason = $this->input->post('reason');
        if ($brand!=0) {
            $conditions['search']['brand'] = $brand;
        }
        if ($reason!=0) {
            $conditions['search']['reason'] = $reason;
        }
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if ($stock_type!=0) {
            $conditions['search']['stock_type'] = $stock_type;
        }
        if ($cat_name!=0) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if ($product_name!=0) {
            $conditions['search']['product_name'] = $product_name;
        }
        if ($pro_sub_category!=0) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if ($supplier_id!=0) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
         if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate.' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate.' 23:59:59';
        }
        //total rows count
        $row = $this->stock_out_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['brands'] = $this->stock_out_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array());
        $data['categories'] = $this->stock_out_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['posts'] = $this->stock_out_report_model->getRowsProducts($conditions);
        // var_export($conditions);
        $data['suppliers'] = $this->stock_out_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['columns'] = $this->stock_out_report_model->getvalue_row('acl_user_column', 'permission', array('menu_url'=>'stock_out_details'));
        $data['stores'] = $this->stock_out_report_model->getvalue_row('stores', '*', array('status_id' => 1));
        //load the view
        $this->load->view('stock_out_report/all_stock_report_data', $data, false);
    }

    public function paginate_data2($id)
    {

        $invoice_id = $id;

        $data['product'] = $this->stock_out_report_model->getvalue_row('products', 'id_product,product_name', array('status_id' => 1));
        $data['invoice_details'] = $this->stock_out_report_model->get_invoice_details($invoice_id);
        $data['invoices'] = $this->stock_out_report_model->getvalue_row('sales', 'invoice_no,id_sale,customer_id', array('id_sale' => $invoice_id));
        $data['stores'] = $this->stock_out_report_model->getvalue_row('stores', '*', array('status_id' => 1));
        $this->load->view('stock_out_report/report_details', $data, false);
    }

    public function print_data()
    {
        // print_r("expression");
        $conditions = array();
        //calc offset number
        $cat_name = $this->input->post('cat_name');
        $product_name = $this->input->post('product_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $supplier_id = $this->input->post('supplier_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $store_id = $this->input->post('store_id');
        $stock_type = $this->input->post('stock_type');
        $batch_no = $this->input->post('batch_no');
        $brand = $this->input->post('brand');
        $reason = $this->input->post('reason');
        if ($brand!=0) {
            $conditions['search']['brand'] = $brand;
        }
        if ($reason!=0) {
            $conditions['search']['reason'] = $reason;
        }
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if ($stock_type!=0) {
            $conditions['search']['stock_type'] = $stock_type;
        }
        if ($cat_name!=0) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if ($product_name!=0) {
            $conditions['search']['product_name'] = $product_name;
        }
        if ($pro_sub_category!=0) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if ($supplier_id!=0) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate.' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate.' 23:59:59';
        }
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Stock Out Report'; 
        $data['posts'] = $this->stock_out_report_model->getRowsProducts($conditions);
        $data['categories'] = $this->stock_out_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['suppliers'] = $this->stock_out_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['columns'] = $this->stock_out_report_model->getvalue_row('acl_user_column', 'permission', array('menu_url'=>'stock_out_details'));
        $data3['report']=$this->load->view('stock_out_report/all_stock_report_data', $data, true);
        $this->load->view('print_page', $data3, false);
    }
    public function create_csv_data()
    {
        $conditions = array();
        $cat_name = $this->input->post('cat_name');
        $product_name = $this->input->post('product_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $supplier_id = $this->input->post('supplier_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $store_id = $this->input->post('store_id');
        $stock_type = $this->input->post('stock_type');
        $batch_no = $this->input->post('batch_no');
        $brand = $this->input->post('brand');
        $reason = $this->input->post('reason');
        if ($brand!=0) {
            $conditions['search']['brand'] = $brand;
        }
        if ($reason!=0) {
            $conditions['search']['reason'] = $reason;
        }
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if ($stock_type!=0) {
            $conditions['search']['stock_type'] = $stock_type;
        }
        if ($cat_name!=0) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if ($product_name!=0) {
            $conditions['search']['product_name'] = $product_name;
        }
        if ($pro_sub_category!=0) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if ($supplier_id!=0) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate.' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate.' 23:59:59';
        }
        $posts = $this->stock_out_report_model->getRowsProducts($conditions);
        $categories = $this->stock_out_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $suppliers = $this->stock_out_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $columns = $this->stock_out_report_model->getvalue_row('acl_user_column', 'permission', array('menu_url'=>'stock_out_details'));
        $pur_val='';
        $type= $this->session->userdata['login_info']['user_type_i92'];
        $fields['date'] = 'Date';
        $fields['store_name'] = 'Store Name';
        $fields['product_code'] = 'Product Code';
        $fields['product_name'] = 'Product Name';
        $fields['batch_no'] = 'Batch No';
        $fields['brand_name'] = 'Brand Name';
        $fields['cat_subcat'] = 'Cat/Subcat';
        $fields['supplier'] = 'Supplier Name';
        $fields['stock_type'] = 'Stock Type';
        $fields['reason'] = 'Reason';
        $fields['qty'] = 'Quantity';
        if($columns[0]->permission==1||$type==3){
            $fields['purchase_price'] = 'Purchse Price';
            $fields['total'] = 'Total';
        }
        $sum_qty = 0;
        $total = 0;
        $count = 1;
        if ($posts != '') {
            foreach ($posts as $post) {
                $categ='';
                foreach ($categories as $category) {
                    if ($category->id_product_category == $post['cat_id']) {
                        $categ = $category->cat_name;
                        break;
                    }
                }
                $sub_category_name = '';
                foreach ($categories as $category) {
                    if ($category->id_product_category == $post['subcat_id'] && $category->parent_cat_id != null) {
                        $sub_category_name = $category->cat_name;
                        break;
                    }
                }
                $supplier_name = '';
                foreach ($suppliers as $supplier) {
                    if ($supplier->id_supplier == $post['supplier_id']) {
                        $supplier_name = $supplier->supplier_name;
                        break;
                    }
                }
                $sum_qty += $post['qty'];
                $array['date'] = date('Y-m-d', strtotime($post['dtt_stock_mvt']));
                $array['store_name'] =$post['store_name'];
                $array['product_code'] =$post['product_code'];
                $array['product_name'] =$post['product_name'];
                $array['batch_no'] =$post['batch_no'];
                $array['brand_name'] =$post['brand_name'];
                $array['cat_subcat'] =$categ . '/' . $sub_category_name;
                $array['supplier'] =$supplier_name;
                $array['stock_type'] =$post['type_name'];
                $array['reason'] =$post['reason'];
                $array['qty'] =$post['qty'];
                if($columns[0]->permission==1||$type==3){
                    $array['purchase_price'] =$post['purchase_price'];
                    $total +=$post['purchase_price']*$post['qty'];
                    $array['total'] =$post['purchase_price']*$post['qty'];
                }
                $value[] = $array;
                $count++;
            }
        }
        $count = 1;

        if($posts!=''){
            $array['date'] = '';
            $array['store_name'] ='';
            $array['product_code'] ='';
            $array['product_name'] ='';
            $array['batch_no'] ='';
            $array['brand_name'] ='';
            $array['cat_subcat'] ='';
            $array['supplier'] ='';
             $array['stock_type'] ='';
            $array['reason'] ='';
            $array['qty'] =$sum_qty;
            if($columns[0]->permission==1||$type==3){
            $array['purchase_price'] ='';
            $array['total'] =$total;
            }
            $value[] = $array;
        }
        if(!isset($value)){
            $value='';
        }
        $dataArray = array(
            'file_name' => 'stock_out_report'
        , 'file_title' => 'Stock Out Report'
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
