<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_in_summary extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('stock_in_summary_model');
        $this->perPage = 500;
    }

    public function index() {
        $data = array();
        $this->breadcrumb->add(lang('stock-in-summary'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->stock_in_summary_model->getRowsProducts());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock_in_summary/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['de_vat'] = $this->stock_in_summary_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        //$data['max_val'] = $this->stock_in_summary_model->max_value('products', 'sell_price');
        $data['suppliers'] = $this->stock_in_summary_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        //$data['units'] = $this->stock_in_summary_model->getvalue_row('product_units', 'unit_code,id_product_unit', array('status_id' => 1));
        $data['brands'] = $this->stock_in_summary_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['categories'] = $this->stock_in_summary_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        //$data['products'] = $this->stock_in_summary_model->getvalue_row('products', 'id_product,product_code,product_name', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->stock_in_summary_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->stock_in_summary_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['posts'] = $this->stock_in_summary_model->getRowsProducts(array('limit' => $this->perPage));
        $this->template->load('main', 'stock_in_summary/index', $data);
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
        //$totalRec = count($this->stock_in_summary_model->getRowsProducts($conditions));

      
       

        //get posts data
        $data['brands'] = $this->stock_in_summary_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array());
        $data['columns'] = $this->stock_in_summary_model->getvalue_row('acl_user_column', 'permission', array('acl_module_id'=>97));
        $data['categories'] = $this->stock_in_summary_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['posts'] = $this->stock_in_summary_model->getRowsProducts($conditions);
        $data['postsPurchases'] = $this->stock_in_summary_model->getRowsPurchases($conditions);
        // var_export($conditions);
         $data['suppliers'] = $this->stock_in_summary_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        //load the view
        $this->load->view('stock_in_summary/all_stock_report_data', $data, false);
    }    
    public function print_page() {
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
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Stock In Summary';    //get posts data
        $data['brands'] = $this->stock_in_summary_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array());
        $data['columns'] = $this->stock_in_summary_model->getvalue_row('acl_user_column', 'permission', array('acl_module_id'=>97));
        $data['categories'] = $this->stock_in_summary_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['posts'] = $this->stock_in_summary_model->getRowsProducts($conditions);
        $data['postsPurchases'] = $this->stock_in_summary_model->getRowsPurchases($conditions);
        // var_export($conditions);
        $data['suppliers'] = $this->stock_in_summary_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data3['report']=$this->load->view('stock_in_summary/all_stock_report_data', $data, true);
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
        $posts = $this->stock_in_summary_model->getRowsProducts($conditions);
        $postsPurchases = $this->stock_in_summary_model->getRowsPurchases($conditions);
        $categories = $this->stock_in_summary_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $type= $this->session->userdata['login_info']['user_type_i92']; 
        $columns = $this->stock_in_summary_model->getvalue_row('acl_user_column', 'permission', array('acl_module_id'=>97));
        $suppliers = $this->stock_in_summary_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $pur_val='';
        
        $fields['serial'] = 'Serial';
        $fields['date'] = 'Date';
        $fields['store_name'] = 'Store Name';
        $fields['product_code'] = 'Product Code';
        $fields['product_name'] = 'Product Name';
        $fields['batch_no'] = 'Batch No';
        $fields['brand_name'] = 'Brand Name';
        $fields['cat_subcat'] = 'Cat/Subcat';
        $fields['supplier'] = 'Supplier Name';
        $fields['reason'] = 'Reason';
        if($columns[0]->permission==1||$type==3){
             $fields['purchase_price'] = 'Purchase Price';
        }
        $fields['sale_price'] = 'Sale Price';
        $fields['qty'] = 'Quantity';
        if($columns[0]->permission==1||$type==3){
             $fields['pur_total'] = 'Purchase Total';
        }
        $fields['sale_total'] = 'Sale Total';
        
        $sum_qty = 0;
        $purchase_total = 0;
        $sale_total = 0;
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
                $array['serial'] =$count;
                $array['date'] = date('Y-m-d', strtotime($post['date']));
                $array['store_name'] =$post['store_name'];
                $array['product_code'] =$post['product_code'];
                $array['product_name'] =$post['product_name'];
                $array['batch_no'] =$post['batch_no'];
                $array['brand_name'] =$post['brand_name'];
                $array['cat_subcat'] =$categ . '/' . $sub_category_name;
                $array['supplier'] =$supplier_name;
                $array['reason'] =$post['reason'];
                if($columns[0]->permission==1||$type==3){
                    $array['purchase_price'] =$post['purchase_price'];
                }
                $array['sale_price'] =$post['selling_price_act'];
                $array['qty'] =$post['qty'];
                if($columns[0]->permission==1||$type==3){
                    $array['pur_total'] =$post['purchase_price'] * $post['qty'];
                    $purchase_total += $post['purchase_price'] * $post['qty'];
                }
                $array['sale_total'] =$post['selling_price_act'] * $post['qty'];
                $sale_total += $post['selling_price_act'] * $post['qty'];
                $value[] = $array;
                $count++;
            }
        }
        $count = 1;
        if($postsPurchases!=''){
            foreach ($postsPurchases as $post) {
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
                $total += $post['purchase_price'] * $post['qty'];
                $sum_qty += $post['qty'];
                $array['serial'] =$count;
                $array['date'] = date('Y-m-d', strtotime($post['date']));
                $array['store_name'] =$post['store_name'];
                $array['product_code'] =$post['product_code'];
                $array['product_name'] =$post['product_name'];
                $array['batch_no'] =$post['batch_no'];
                $array['brand_name'] =$post['brand_name'];
                $array['cat_subcat'] =$categ . '/' . $sub_category_name;
                $array['supplier'] =$supplier_name;
                $array['reason'] =$post['reason'];
                if($columns[0]->permission==1||$type==3){
                    $array['purchase_price'] =$post['purchase_price'];
                }
                $array['sale_price'] =$post['selling_price_act'];
                $array['qty'] =$post['qty'];
                if($columns[0]->permission==1||$type==3){
                    $array['pur_total'] =$post['purchase_price'] * $post['qty'];
                    $purchase_total += $post['purchase_price'] * $post['qty'];
                }
                $array['sale_total'] =$post['selling_price_act'] * $post['qty'];
                $sale_total += $post['selling_price_act'] * $post['qty'];
                $value[] = $array;
                $count++;
            }
        }
        if($columns[0]->permission==1||$type==3){
             $pur_val=", 'purchase_price' => ''";
        }

        if($posts!='' || $postsPurchases!=''){
            $array['serial'] ='';
            $array['date'] = '';
            $array['store_name'] ='';
            $array['product_code'] ='';
            $array['product_name'] ='';
            $array['batch_no'] ='';
            $array['brand_name'] ='';
            $array['cat_subcat'] ='';
            $array['supplier'] ='';
            $array['reason'] ='';
            if($columns[0]->permission==1||$type==3){
                $array['purchase_price'] ='';
            }
            $array['sale_price'] ='Total';
            $array['qty'] =$sum_qty;
            if($columns[0]->permission==1||$type==3){
                $array['pur_total'] =$purchase_total;
            }
             $array['sale_total'] =$sale_total;
            $value[] = $array;
        }
        if(!isset($value)){
            $value='';
        }
        $dataArray = array(
            'file_name' => 'stock_in_summary'
        , 'file_title' => 'Stock In Summary Report'
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
    public function getStockReason(){
        $id=$this->input->post('id');
        $data = $this->stock_in_summary_model->get_reasons($id);
        echo json_encode($data);
    }
   
}
