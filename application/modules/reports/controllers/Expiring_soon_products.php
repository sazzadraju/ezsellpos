<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expiring_soon_products extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('expiring_soon_products_model');
        $this->perPage = 500;
    }

    public function index() {
        $data = array();
        $totalRec = 0;
        $data['ex_product'] = array();

        //pagination start
        if(isset($_GET['xid'])){

            $xid = $_GET['xid'];
            if($xid == 1){
                $end_date = date('Y-m-d',strtotime("-1 days"));
            }else if($xid == 2){
                $start_date = date('Y-m-d');
                $end_date = date('Y-m-d',strtotime("+6 days"));
            }else if($xid == 3){
                $start_date = date('Y-m-d');
                $end_date = date('Y-m-d',strtotime("+14 days"));
            }else if($xid == 4){
                $start_date = date('Y-m-d');
                $end_date = date('Y-m-d',strtotime("+29 days"));
            } 

            $arg = array('end_date'=> $end_date);
            if(!empty($start_date)){
                $arg = array_merge($arg, array('start_date'=> $start_date));
            }
            $serRow = $this->expiring_soon_products_model->getExpiredProductRows($arg);
            if($serRow != NULL){
                $totalRec = count($this->expiring_soon_products_model->getExpiredProductRows($arg));
            }  
            
            $config['target']      = '#postList';
            $config['base_url']    = base_url().'expiring-soon-products/page_data';
            $config['total_rows']  = $totalRec;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'jsLinkFunc1';
            $this->ajax_pagination->initialize($config);

            $arg = array_merge($arg, array('limit'=>$this->perPage));
            $data['ex_product']    = $this->expiring_soon_products_model->getExpiredProductRows($arg);
        }
        //pagination end


        $this->breadcrumb->add(lang('expiring_soon_products'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();

        $data['categories'] = $this->expiring_soon_products_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));

        $type= $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop= $this->session->userdata['login_info']['store_id'];
        if ($type != 3){  
            $data['stores'] = $this->expiring_soon_products_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1,'id_store'=>$selected_shop));
        }else if ($type == 3) {
            $data['stores'] = $this->expiring_soon_products_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['brands'] = $this->expiring_soon_products_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['products'] = $this->commonmodel->getvalue_row('products', 'id_product,product_code,product_name', array('status_id' => 1));

        $this->template->load('main', 'expiring_soon_products/index', $data);
    }

    public function expireLinkPagination(){
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        $arg = array('start_date'=> $_POST['start_date'], 'end_date'=> $_POST['end_date']);
        //total rows count
        $totalRec = 0;
        $serRow = $this->expiring_soon_products_model->getExpiredProductRows($arg);
        if($serRow != NULL){
            $totalRec = count($this->expiring_soon_products_model->getExpiredProductRows($arg));
        } 
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'expiring-soon-products/page_data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'jsLinkFunc1';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $arg = array_merge($arg, array('start'=>$offset,'limit'=>$this->perPage));
                
        $data['ex_product'] = $this->expiring_soon_products_model->getExpiredProductRows($arg);
        
        //load the view
        $this->load->view('expiring_soon_products/all_report_data', $data);
    }

    public function expireSubmitPagination(){
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        $arg = array('type'=> $_POST['type']);
        if(!empty($_POST['start_date'])){
            $arg = array_merge($arg, array('start_date'=>$_POST['start_date']));
        }
        if(!empty($_POST['end_date'])){
            $arg = array_merge($arg, array('end_date'=>$_POST['end_date']));
        }
        if(!empty($_POST['product_id'])){
            $arg = array_merge($arg, array('product_id'=>$_POST['product_id']));
        }
        if(!empty($_POST['cat_name'])){
            $arg = array_merge($arg, array('cat_name'=>$_POST['cat_name']));
        }
        if(!empty($_POST['pro_sub_category'])){
            if($_POST['pro_sub_category'] != -1){
                $arg = array_merge($arg, array('pro_sub_category'=>$_POST['pro_sub_category']));
            }
        }
        if(!empty($_POST['store_id'])){
            $arg = array_merge($arg, array('store_id'=>$_POST['store_id']));
        }
        if(!empty($_POST['brand'])){
            $arg = array_merge($arg, array('brand'=>$_POST['brand']));
        }
        if(!empty($_POST['batch_no'])){
            $arg = array_merge($arg, array('batch_no'=>$_POST['batch_no']));
        }

        //total rows count
        $totalRec = 0;
        $serRow = $this->expiring_soon_products_model->getExpiredProductRows($arg);

        if($serRow != NULL){
            $totalRec = count($this->expiring_soon_products_model->getExpiredProductRows($arg));
        } 
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'expiring-soon-products/page_data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'jsLinkFunc2';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $arg = array_merge($arg, array('start'=>$offset,'limit'=>$this->perPage));
          
        $data['ex_product'] = $this->expiring_soon_products_model->getExpiredProductRows($arg);
     
        //load the view
        $this->load->view('expiring_soon_products/all_report_data', $data);
    }


    public function get_sub_cat() {    
        $subCat = $this->expiring_soon_products_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1, 'parent_cat_id' => $_POST['cid']));

        echo '<select class="select2 form-control" data-live-search="true" id="pro_sub_category" name="pro_sub_category">';
              echo '<option value="-1"> All Sub Categories</option>';              
        

        foreach ($subCat as $aSubCat) {
            echo '<option value="'.$aSubCat->id_product_category.'">'.$aSubCat->cat_name.'</option>';
        }
        echo '</select>';

    }
    public function print_page() {
        $conditions = array();
        $arg = array('type'=> $_POST['type']);
        if(!empty($_POST['start_date'])){
            $arg = array_merge($arg, array('start_date'=>$_POST['start_date']));
        }
        if(!empty($_POST['end_date'])){
            $arg = array_merge($arg, array('end_date'=>$_POST['end_date']));
        }
        if(!empty($_POST['product_id'])){
            $arg = array_merge($arg, array('product_id'=>$_POST['product_id']));
        }
        if(!empty($_POST['cat_name'])){
            $arg = array_merge($arg, array('cat_name'=>$_POST['cat_name']));
        }
        if(!empty($_POST['pro_sub_category'])){
            if($_POST['pro_sub_category'] != -1){
                $arg = array_merge($arg, array('pro_sub_category'=>$_POST['pro_sub_category']));
            }
        }
        if(!empty($_POST['store_id'])){
            $arg = array_merge($arg, array('store_id'=>$_POST['store_id']));
        }
        if(!empty($_POST['brand'])){
            $arg = array_merge($arg, array('brand'=>$_POST['brand']));
        }
        if(!empty($_POST['batch_no'])){
            $arg = array_merge($arg, array('batch_no'=>$_POST['batch_no']));
        }
        $data['fdate'] = $_POST['start_date'];
        $data['tdate'] = $_POST['end_date'];
        $data['title'] = 'Expiring Soon Products';    //get posts data
        
        $data['ex_product'] = $this->expiring_soon_products_model->getExpiredProductRows($arg);
        $data3['report']=$this->load->view('expiring_soon_products/all_report_data', $data, true);
        $this->load->view('print_page', $data3, false);

    }

    public function get_available_stock_in_products(){
        $request = $_REQUEST['request'];

        $product_list = $this->expiring_soon_products_model->get_available_stock_in_products($request);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->product_name,
                "value" => $list->product_id,
                "batch_no" => $list->batch_no,
                "buy_price" => $list->buy_price,
                "sell_price" => $list->sell_price,
                "pro_code" => $list->product_code,
                "is_vatable" => $list->is_vatable
                // "is_unq_barcode" => $list->is_unq_barcode
            );
        }
        echo json_encode($return);
    }
    public function create_csv_data()
    {
        $FromDate=$_POST['start_date'];
        $ToDate=$_POST['end_date'];
        $arg = array('type'=> $_POST['type']);
        if(!empty($_POST['start_date'])){
            $arg = array_merge($arg, array('start_date'=>$_POST['start_date']));
        }
        if(!empty($_POST['end_date'])){
            $arg = array_merge($arg, array('end_date'=>$_POST['end_date']));
        }
        if(!empty($_POST['product_id'])){
            $arg = array_merge($arg, array('product_id'=>$_POST['product_id']));
        }
        if(!empty($_POST['cat_name'])){
            $arg = array_merge($arg, array('cat_name'=>$_POST['cat_name']));
        }
        if(!empty($_POST['pro_sub_category'])){
            if($_POST['pro_sub_category'] != -1){
                $arg = array_merge($arg, array('pro_sub_category'=>$_POST['pro_sub_category']));
            }
        }
        if(!empty($_POST['store_id'])){
            $arg = array_merge($arg, array('store_id'=>$_POST['store_id']));
        }
        if(!empty($_POST['brand'])){
            $arg = array_merge($arg, array('brand'=>$_POST['brand']));
        }
        if(!empty($_POST['batch_no'])){
            $arg = array_merge($arg, array('batch_no'=>$_POST['batch_no']));
        }
        $posts = $this->expiring_soon_products_model->getExpiredProductRows($arg);
        $fields = array(
            'product_name' => 'Product Name'
        , 'product_code' => 'Product Code'
        , 'attributes' => 'Attributes'
        , 'batch_no' => 'Batch No'
        , 'cat_subcat' => 'Cat/Subcat'
        , 'brands' => 'Brands'
        , 'store_name' => 'Store Name'
        , 'expire_date' => 'Expire Date'
        , 'qty' => 'Qty'
        );
        $tot_qty = 0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $tot_qty+=$post['qty'];
                $value[] = array(
                    'product_name' => $post['product_name']
                , 'product_code' => $post['product_code']
                , 'attributes' => $post['attribute_name']
                , 'batch_no' => $post['batch_no']
                , 'cat_subcat' => $post['cat_name'] . ' / ' . $post['sub_cat_name']
                , 'brands' => $post['brand_name']
                , 'store_name' => $post['store_name']
                , 'expire_date' => $post['expire_date']
                , 'qty' => $post['qty']

                );
                $count++;
            }
            $value[] = array(
                'product_name' => ''
            , 'product_code' => ''
            , 'attributes' => ''
            , 'batch_no' => ''
            , 'cat_subcat' => ''
            , 'brands' => ''
            , 'store_name' => ''
            , 'expire_date' => 'Total'
            , 'qty' => $tot_qty

            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'expiring_soon_products'
        , 'file_title' => 'Expiring Soon Products'
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