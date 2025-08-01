<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion_settings extends MX_Controller {

	function __construct(){  
		parent::__construct();
        // $this->load->library('form_validation');
        $this->form_validation->CI = & $this;
		if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->perPage = 20;

		$this->load->model('Promotion_settings_model');
	}


	public function index()
	{
        $data = array();
        $this->dynamic_menu->check_menu('promotion-management');
        $this->breadcrumb->add(lang('promotions'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        //total rows count
        $row = $this->Promotion_settings_model->all_promotion_list();
        $totalRec = ($row)?count($row):0;

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'promotion-management/promotion_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['stores'] = $this->Promotion_settings_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->Promotion_settings_model->all_promotion_list(array('limit' => $this->perPage));
        $data['promotion_types'] = $this->config->item('promotion_types');
        //$data['cat_subcat_list'] = $this->Promotion_settings_model->get_cat_subcat_list();
        $data['brand_list'] = $this->Promotion_settings_model->get_brand_list();
		$this->template->load('main', 'promotion_settings/promotion_list',$data); 
	}

    public function add_promotion()
    {
        $data = array();
        $this->dynamic_menu->check_menu('add_promotion');
        $this->breadcrumb->add(lang('promotions'),'promotion-management', 1);
        $this->breadcrumb->add(lang('add_promotion'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['stores'] = $this->Promotion_settings_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['promotion_types'] = $this->config->item('promotion_types');
        $data['cat_list'] = $this->Promotion_settings_model->get_cat_list();
        $data['brand_list'] = $this->Promotion_settings_model->get_brand_list();
        $this->template->load('main', 'promotion_settings/index',$data); 
    }


    //////cat/subcat list
    public function cat_with_subcat_list(){
        $data = $this->Promotion_settings_model->get_cat_subcat_list();
        echo json_encode($data);
    }

	public function promotion_pagination_data() {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $title= $this->input->post('title');
        if(!empty($title)){
            $conditions['search']['title'] = $title;
        }

        $type_id= $this->input->post('type_id');
        if(($type_id != 0)){
            $conditions['search']['type_id'] = $type_id;
        }
        $store_name= $this->input->post('store_name');
        if(!empty($store_name)){
            $conditions['search']['store_name'] = $store_name;
        }
        //total rows count
        $totalRec = count($this->Promotion_settings_model->all_promotion_list());
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'promotion-management/promotion_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['stores'] = $this->Promotion_settings_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->Promotion_settings_model->all_promotion_list($conditions);
        //load the view
        $this->load->view('promotion_settings/promotion_list_pagination', $data, false);
    }

    public function promotion_insert()
    {
        // echo json_encode($_POST);
        // exit();
        $brand = $this->input->post('promo_brand_id');
        $cat_selection = $this->input->post('promo_cat_id');
        $sub_cat_selection = $this->input->post('promo_sub_cat_id');
        $promotion_on = $this->input->post('promotion_on');
        $store_name = $this->input->post('store_name');

        $discount_type = $this->input->post('discount_type');
        $discount_amount = $this->input->post('discount_amount');
        $dt_from = $this->input->post('dt_from');
        $dt_to = $this->input->post('dt_to');
        $type_id = $this->input->post('type_id');
        $purchase_amt_from = $this->input->post('purchase_amt_from');
        $total_row_number  = $this->input->post('total_row_number');

        $product_id=$this->input->post('pro_id');
        $percet=$this->input->post('percet');
        $taka=$this->input->post('taka');
        $cat_id=$this->input->post('cat_id');
        $subcat_id=$this->input->post('subcat_id');
        $brand_id=$this->input->post('brand_id');
        $store_id=$this->input->post('store_id');
        $batch_no=$this->input->post('batch_no');

        ///////////////////insert on promotions///////////////////
        $data_promotions['title'] = $this->input->post('title');
        $data_promotions['details'] = $this->input->post('details');
        $data_promotions['type_id'] = $type_id;
        if($promotion_on == 1 && $type_id == 1){
            $data_promotions['is_category'] = 1;
        }elseif($promotion_on == 2 && $type_id == 1){
            $data_promotions['is_brand'] = 1;
        }elseif($promotion_on == 3 && $type_id == 1){
            $data_promotions['is_category'] = 1;
            $data_promotions['is_brand'] = 1;
        }
        if($promotion_on == 4 && $type_id == 1){
            $data_promotions['is_product'] = 1;
        }
        $data_promotions['dt_from'] = $dt_from;
        $data_promotions['dt_to'] = $dt_to;
        $data_promotions['dtt_add'] = date('Y-m-d H:i:s');
        $data_promotions['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
        $promotion_id = $this->Promotion_settings_model->common_insert('promotions', $data_promotions);
        ///////////////////insert on promotions end///////////////////
        if($promotion_id){
            for ($i = 0; $i < count($store_name); $i++) {
                $promo_t['promotion_id']=$promotion_id;
                $promo_t['store_id']=$store_name[$i];
                $this->Promotion_settings_model->common_insert('promotion_stores', $promo_t);
            }

        }

        if(!empty($promotion_id) && $type_id == 1 && $promotion_on == 3){
            for($count = 0; $count < $total_row_number; $count++){
                $data_promotion_details['cat_id'] = "";
                $data_promotion_details['subcat_id'] = "";
                $data_promotion_details['promotion_id'] = $promotion_id;

                if($sub_cat_selection[$count] == 0 || $sub_cat_selection[$count] == ""){
                    $data_promotion_details['cat_id'] = $cat_selection[$count];
                    $data_promotion_details['subcat_id'] = null;
                }elseif($sub_cat_selection[$count] != 0 || $sub_cat_selection[$count] != ""){
                    $data_promotion_details['cat_id'] = null;
                    $data_promotion_details['subcat_id'] = $sub_cat_selection[$count];
                }

                $data_promotion_details['brand_id'] = $brand[$count];  
                if($discount_type == 1){
                    $data_promotion_details['discount_rate'] = $discount_amount;
                }elseif($discount_type == 2){
                    $data_promotion_details['discount_amount'] = $discount_amount;
                }
                $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
            }
        }elseif(!empty($promotion_id) && $type_id == 1 && $promotion_on == 2){
            for($count = 0; $count < $total_row_number; $count++){

                $data_promotion_details['promotion_id'] = $promotion_id;
                $data_promotion_details['brand_id'] = $brand[$count];  
                if($discount_type == 1){
                    $data_promotion_details['discount_rate'] = $discount_amount;
                }elseif($discount_type == 2){
                    $data_promotion_details['discount_amount'] = $discount_amount;
                }
                $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
            }
        }elseif(!empty($promotion_id) && $type_id == 1 && $promotion_on == 1){
            for($count = 0; $count < $total_row_number; $count++){

                $data_promotion_details['promotion_id'] = $promotion_id;
                if($sub_cat_selection[$count] == 0 || $sub_cat_selection[$count] == ""){
                    $data_promotion_details['cat_id'] = $cat_selection[$count];
                    $data_promotion_details['subcat_id'] = null;
                }elseif($sub_cat_selection[$count] != 0 || $sub_cat_selection[$count] != ""){
                    $data_promotion_details['cat_id'] = null;
                    $data_promotion_details['subcat_id'] = $sub_cat_selection[$count];
                } 
                if($discount_type == 1){
                    $data_promotion_details['discount_rate'] = $discount_amount;
                }elseif($discount_type == 2){
                    $data_promotion_details['discount_amount'] = $discount_amount;
                }
                $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
            }
        }elseif(!empty($promotion_id) && $type_id == 2){
            // echo "2"; exit();
            $data_promotion_details['promotion_id'] = $promotion_id;
            $data_promotion_details['min_purchase_amt'] = $purchase_amt_from;
            if($discount_type == 1){
                $data_promotion_details['discount_rate'] = $discount_amount;
            }elseif($discount_type == 2){
                $data_promotion_details['discount_amount'] = $discount_amount;
            }
            $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
            $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details); 
        }elseif(!empty($promotion_id) && $type_id == 3){
            $data_promotion_details['promotion_id'] = $promotion_id;
            $data_promotion_details['payment_type'] = 1;
            if($discount_type == 1){
                $data_promotion_details['discount_rate'] = $discount_amount;
            }elseif($discount_type == 2){
                $data_promotion_details['discount_amount'] = $discount_amount;
            }
            $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
            $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details); 
        }elseif(!empty($promotion_id) && $type_id == 1 && $promotion_on == 4){
            for ($i = 0; $i < count($store_name); $i++) {
                for($count = 0; $count < count($product_id); $count++){
                    $batch_no = $this->Promotion_settings_model->getvalue_row_array('stocks', 'batch_no', array('product_id' => $product_id[$count],'store_id'=>$store_name[$i],'qty >'=>0));
                    if($batch_no){
                        foreach ($batch_no as $batchKey) {
                            $data_promotion_details['promotion_id'] = $promotion_id;
                            $data_promotion_details['product_id'] = $product_id[$count];
                            $data_promotion_details['cat_id'] = $cat_id[$count];
                            $data_promotion_details['store_id'] = $store_name[$i];
                            $data_promotion_details['batch_no'] = $batchKey['batch_no'];
                            $data_promotion_details['subcat_id'] = $subcat_id[$count];
                            $data_promotion_details['brand_id'] = $brand_id[$count];
                            $data_promotion_details['discount_rate'] = $percet[$count];
                            $data_promotion_details['discount_amount'] = $taka[$count];
                            $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                            $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                            $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
                        }
                    }
                }
            }
        }

        if($promotion_details_id){
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }


    public function promotion_details($promotion_id = null){
        $this->breadcrumb->add(lang('promotions'),'promotion-management', 1);
        $this->breadcrumb->add(lang('promotion_details'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['promotion_details_list'] = $this->Promotion_settings_model->promotion_details_data($promotion_id);
        $data['promo'] = $this->Promotion_settings_model->getvalue_row_array('promotions', '*', array('id_promotion' => $promotion_id));
        if($data['promo']){
            if($data['promo'][0]['is_product']==1){
                $data['product_lists'] = $this->Promotion_settings_model->promotion_product_details_list($promotion_id);
            }
        }
        $this->template->load('main', 'promotion_settings/promotion_details',$data); 
    }

    public function edit_promotion($promotion_id = null){
        $this->breadcrumb->add(lang('promotions'),'promotion-management', 1);
        $this->breadcrumb->add(lang('edit_promotion'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['promotion_types'] = $this->config->item('promotion_types');
        $data['cat_list'] = $this->Promotion_settings_model->get_cat_list();
        $data['brand_list'] = $this->Promotion_settings_model->get_brand_list();
        $data['stores'] = $this->Promotion_settings_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['promo'] = $this->Promotion_settings_model->getvalue_row_array('promotions', '*', array('id_promotion' => $promotion_id));
        $data['promotional_data'] = $this->Promotion_settings_model->promotion_row_details($promotion_id);
        if($data['promo']){
            if($data['promo'][0]['is_product']==1){
                $data['product_lists'] = $this->Promotion_settings_model->promotion_product_list($promotion_id);
            }
        }
        $data['store'] = $this->Promotion_settings_model->edit_promotion_store($promotion_id);
        $this->template->load('main', 'promotion_settings/edit_promotion',$data); 
    }

    public function get_sub_cat(){
        $cat_id = $this->input->post('cat_id');
        $result = $this->Promotion_settings_model->get_sub_cat_list($cat_id);
        echo json_encode(array("subcat_list" => $result));
    }

    public function promotion_cart_details(){
        // echo json_encode($_POST);
        // exit();
        $cat_id = $this->input->post('cat_id');
        $sub_cat_id = $this->input->post('sub_cat_id');
        $brand_id = $this->input->post('brand_id');
        

        if(!empty($cat_id) && $sub_cat_id == 0 && $brand_id == 0){
            $cat_sub_list = $this->Promotion_settings_model->get_cat_by_id($cat_id);
            $check = 1;
            echo json_encode(array("cat_sub_list" => $cat_sub_list, "brand_list" => "", "check" => $check));
        }

        if($sub_cat_id != 0 && $brand_id == 0){
            $cat_sub_list = $this->Promotion_settings_model->get_cat_by_id($sub_cat_id);
            $check = 2;
            echo json_encode(array("cat_sub_list" => $cat_sub_list, "brand_list" => "", "check" => $check));
        }

        if($cat_id == 0 && ($sub_cat_id == 0 || $sub_cat_id == "") && $brand_id != 0){
            $brand_list = $this->Promotion_settings_model->get_brands_list($brand_id);
            echo json_encode(array("cat_sub_list" => "","brand_list" => $brand_list, "check" => ""));
        }

        if(!empty($cat_id) && $brand_id != 0){
            if($sub_cat_id != 0){
            $cat_sub_list = $this->Promotion_settings_model->get_cat_by_id($sub_cat_id);
            $check = 2;
            }else{
                $cat_sub_list = $this->Promotion_settings_model->get_cat_by_id($cat_id);
                $check = 1;
            }
            $brand_list = $this->Promotion_settings_model->get_brands_list($brand_id);
            echo json_encode(array("cat_sub_list" => $cat_sub_list, "brand_list" => $brand_list, "check" => $check));
        }
        
    }
    public function promotion_cart_details_product(){
        $cat_id = $this->input->post('cat_id');
        $sub_cat_id = $this->input->post('sub_cat_id');
        $brand_id = $this->input->post('brand_id');
        $store_name = $this->input->post('store_name');
        $s_product = $this->input->post('s_product');
        $rowCount = $this->input->post('rowCount');
        $data['rowCount']=($rowCount!='')?$rowCount:1;
        $data['posts'] = $this->Promotion_settings_model->get_product_by_cart($cat_id,$sub_cat_id,$brand_id,$store_name,$s_product);
        $this->load->view('promotion_settings/product_list', $data, false);

    }

    public function promotion_preview()
    {
        $category = $this->input->post('cat_selection');
        $sub_category = $this->input->post('sub_cat_selection');
        $brand = $this->input->post('brand');
        $subcat_list = $this->Promotion_settings_model->get_sub_cat_list($sub_category);
        $brand_list = $this->Promotion_settings_model->get_brands_list($brand);
        echo json_encode(array("subcat_list" => $subcat_list, "brand_list" => $brand_list));
    }

   public function promotion_update()
    {
        //print_r($_POST);
        //exit();
        $promotion_id = $this->input->post('promotion_id');
        $brand = $this->input->post('promo_brand_id');
        $cat_selection = $this->input->post('promo_cat_id');
        $sub_cat_selection = $this->input->post('promo_sub_cat_id');
        $promotion_on = $this->input->post('edit_promotion_on');
        $store_name=$this->input->post('store_name');
        $selected_stores=$this->input->post('selected_stores');
        $discount_type = $this->input->post('discount_type');
        $discount_amount = $this->input->post('discount_amount');
        $dt_from = $this->input->post('dt_from');
        $dt_to = $this->input->post('dt_to');
        $type_id = $this->input->post('promo_type_id');
        $purchase_amt_from = $this->input->post('purchase_amt_from');
        $total_row_number  = $this->input->post('total_row_number');
        

        $product_id=$this->input->post('pro_id');
        $percet=$this->input->post('percet');
        $taka=$this->input->post('taka');
        $cat_id=$this->input->post('cat_id');
        $subcat_id=$this->input->post('subcat_id');
        $brand_id=$this->input->post('brand_id');
        $store_id=$this->input->post('store_id');
        $batch_no=$this->input->post('batch_no');

        $delete_result = $this->Promotion_settings_model->common_delete('promotion_details', 'promotion_id', $promotion_id);

        $data_promotions['title'] = $this->input->post('title');
        $data_promotions['details'] = $this->input->post('details');
        $data_promotions['type_id'] = $type_id;
        $data_promotions['dt_from'] = $dt_from;
        $data_promotions['dt_to'] = $dt_to;
        $data_promotions['dtt_mod'] = date('Y-m-d H:i:s');
        $data_promotions['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        
        
        $promotion_id_update = $this->Promotion_settings_model->common_update('promotions', $data_promotions, 'id_promotion', $promotion_id);
        if($promotion_id_update){
            if($promotion_on != 4){
               //$this->Promotion_settings_model->common_delete('promotion_stores', 'promotion_id', $promotion_id);
                for ($i = 0; $i < count($store_name); $i++) {
                    $promo_t['promotion_id']=$promotion_id;
                    $promo_t['store_id']=$store_name[$i];
                    $this->Promotion_settings_model->common_insert('promotion_stores', $promo_t);
                } 
            }
        }

        if(!empty($promotion_id) && $type_id == 1 && $promotion_on == 3){
    
            for($count = 0; $count < $total_row_number; $count++){
                $data_promotion_details['cat_id'] = "";
                $data_promotion_details['subcat_id'] = "";
                $data_promotion_details['promotion_id'] = $promotion_id;

                if(isset($sub_cat_selection[$count]) && $sub_cat_selection[$count] == 0 || $sub_cat_selection[$count] == ""){
                    $data_promotion_details['cat_id'] = $cat_selection[$count];
                    $data_promotion_details['subcat_id'] = null;
                }elseif(isset($sub_cat_selection[$count]) && $sub_cat_selection[$count] != 0 || $sub_cat_selection[$count] != ""){
                    $data_promotion_details['cat_id'] = null;
                    $data_promotion_details['subcat_id'] = $sub_cat_selection[$count];
                }

                $data_promotion_details['brand_id'] = $brand[$count];  
                if($discount_type == 1){
                    $data_promotion_details['discount_rate'] = $discount_amount;
                }elseif($discount_type == 2){
                    $data_promotion_details['discount_amount'] = $discount_amount;
                }
                $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
            }
        }elseif(!empty($promotion_id) && $type_id == 1 && $promotion_on == 2){
            for($count = 0; $count < $total_row_number; $count++){

                $data_promotion_details['promotion_id'] = $promotion_id;
                $data_promotion_details['brand_id'] = $brand[$count];  
                if($discount_type == 1){
                    $data_promotion_details['discount_rate'] = $discount_amount;
                }elseif($discount_type == 2){
                    $data_promotion_details['discount_amount'] = $discount_amount;
                }
                $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
            }
        }elseif(!empty($promotion_id) && $type_id == 1 && $promotion_on == 1){
            for($count = 0; $count < $total_row_number; $count++){

                $data_promotion_details['promotion_id'] = $promotion_id;
                if($sub_cat_selection[$count] == 0 || $sub_cat_selection[$count] == ""){
                    $data_promotion_details['cat_id'] = $cat_selection[$count];
                    $data_promotion_details['subcat_id'] = null;
                }elseif($sub_cat_selection[$count] != 0 || $sub_cat_selection[$count] != ""){
                    $data_promotion_details['cat_id'] = null;
                    $data_promotion_details['subcat_id'] = $sub_cat_selection[$count];
                } 
                if($discount_type == 1){
                    $data_promotion_details['discount_rate'] = $discount_amount;
                }elseif($discount_type == 2){
                    $data_promotion_details['discount_amount'] = $discount_amount;
                }
                $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
            }
        }elseif(!empty($promotion_id) && $type_id == 2){
            // echo "2"; exit();
            $data_promotion_details['promotion_id'] = $promotion_id;
            $data_promotion_details['min_purchase_amt'] = $purchase_amt_from;
            if($discount_type == 1){
                $data_promotion_details['discount_rate'] = $discount_amount;
            }elseif($discount_type == 2){
                $data_promotion_details['discount_amount'] = $discount_amount;
            }
            $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
            $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details); 
        }elseif(!empty($promotion_id) && $type_id == 3){
            $data_promotion_details['promotion_id'] = $promotion_id;
            $data_promotion_details['payment_type'] = 1;
            if($discount_type == 1){
                $data_promotion_details['discount_rate'] = $discount_amount;
            }elseif($discount_type == 2){
                $data_promotion_details['discount_amount'] = $discount_amount;
            }
            $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
            $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details); 
        }elseif(!empty($promotion_id) && $type_id == 1 && $promotion_on == 4){
            $StoreArray=explode(',',$selected_stores);
            for ($i = 0; $i < count($StoreArray); $i++) {
                for($count = 0; $count < count($product_id); $count++){
                    $batch_no = $this->Promotion_settings_model->getvalue_row_array('stocks', 'batch_no', array('product_id' => $product_id[$count],'store_id'=>$StoreArray[$i],'qty >'=>0));
                    if($batch_no){
                        foreach ($batch_no as $batchKey) {
                            $data_promotion_details['promotion_id'] = $promotion_id;
                            $data_promotion_details['product_id'] = $product_id[$count];
                            $data_promotion_details['cat_id'] = $cat_id[$count];
                            $data_promotion_details['store_id'] = $StoreArray[$i];
                            $data_promotion_details['batch_no'] = $batchKey['batch_no'];
                            $data_promotion_details['subcat_id'] = $subcat_id[$count];
                            $data_promotion_details['brand_id'] = $brand_id[$count];
                            $data_promotion_details['discount_rate'] = $percet[$count];
                            $data_promotion_details['discount_amount'] = $taka[$count];
                            $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                            $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                            $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
                        }
                    }
                }
            }
        }

        if($promotion_details_id){
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }

    public function inactive_promotion()
    {
        $id = $this->input->post('id');
        $promotion_status['status_id'] = 0;
        if($id){
            $inactive_promotion = $this->Promotion_settings_model->common_update('promotions', $promotion_status, 'id_promotion', $id);
            echo json_encode($inactive_promotion);
        }
        
    }

    public function delete_promotion()
    {
        $id = $this->input->post('id');
        $promotion_status['status_id'] = 2;
        if($id){
            $inactive_promotion = $this->Promotion_settings_model->common_update('promotions', $promotion_status, 'id_promotion', $id);
            echo json_encode($inactive_promotion);
        }
        
    }

    public function reactive_promotion($promotion_id = null)
    {
        $this->breadcrumb->add(lang('promotions'),'promotion-management', 1);
        $this->breadcrumb->add(lang('reactive_promotion'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['promotion_types'] = $this->config->item('promotion_types');
        $data['cat_list'] = $this->Promotion_settings_model->get_cat_list();
        $data['brand_list'] = $this->Promotion_settings_model->get_brand_list();
        $data['promotional_data'] = $this->Promotion_settings_model->promotion_row_details($promotion_id);
        $data['stores'] = $this->Promotion_settings_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['promo'] = $this->Promotion_settings_model->getvalue_row_array('promotions', '*', array('id_promotion' => $promotion_id));
        if($data['promo']){
            if($data['promo'][0]['is_product']==1){
                $data['product_lists'] = $this->Promotion_settings_model->promotion_product_list($promotion_id);
            }
        }
        $data['store'] = $this->Promotion_settings_model->edit_promotion_store($promotion_id);
        $this->template->load('main', 'promotion_settings/reactive_promotion',$data); 
    }

    public function enter_reactive_promotion()
    {
        // echo json_encode($_POST);
        // exit();
        $promotion_id = $this->input->post('promotion_id');
        $brand = $this->input->post('promo_brand_id');
        $cat_selection = $this->input->post('promo_cat_id');
        $sub_cat_selection = $this->input->post('promo_sub_cat_id');
        $promotion_on = $this->input->post('edit_promotion_on');
        $store_name=$this->input->post('store_name');
        $discount_type = $this->input->post('discount_type');
        $discount_amount = $this->input->post('discount_amount');
        $dt_from = $this->input->post('dt_from');
        $dt_to = $this->input->post('dt_to');
        $type_id = $this->input->post('promo_type_id');
        $purchase_amt_from = $this->input->post('purchase_amt_from');
        $total_row_number  = $this->input->post('total_row_number');
        

        $product_id=$this->input->post('pro_id');
        $percet=$this->input->post('percet');
        $taka=$this->input->post('taka');
        $cat_id=$this->input->post('cat_id');
        $subcat_id=$this->input->post('subcat_id');
        $brand_id=$this->input->post('brand_id');
        $store_id=$this->input->post('store_id');
        $batch_no=$this->input->post('batch_no');

        $delete_result = $this->Promotion_settings_model->common_delete('promotion_details', 'promotion_id', $promotion_id);

        $data_promotions['title'] = $this->input->post('title');
        $data_promotions['details'] = $this->input->post('details');
        $data_promotions['type_id'] = $type_id;
        $data_promotions['dt_from'] = $dt_from;
        $data_promotions['dt_to'] = $dt_to;
        $data_promotions['dtt_mod'] = date('Y-m-d H:i:s');
        $data_promotions['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        
        
        $promotion_id_update = $this->Promotion_settings_model->common_update('promotions', $data_promotions, 'id_promotion', $promotion_id);
        if($promotion_id_update){
            if($promotion_on != 4){
               $this->Promotion_settings_model->common_delete('promotion_stores', 'promotion_id', $promotion_id);
                for ($i = 0; $i < count($store_name); $i++) {
                    $promo_t['promotion_id']=$promotion_id;
                    $promo_t['store_id']=$store_name[$i];
                    $this->Promotion_settings_model->common_insert('promotion_stores', $promo_t);
                } 
            }
        }

        if(!empty($promotion_id) && $type_id == 1 && $promotion_on == 3){
    
            for($count = 0; $count < $total_row_number; $count++){
                $data_promotion_details['cat_id'] = "";
                $data_promotion_details['subcat_id'] = "";
                $data_promotion_details['promotion_id'] = $promotion_id;

                if(isset($sub_cat_selection[$count]) && $sub_cat_selection[$count] == 0 || $sub_cat_selection[$count] == ""){
                    $data_promotion_details['cat_id'] = $cat_selection[$count];
                    $data_promotion_details['subcat_id'] = null;
                }elseif(isset($sub_cat_selection[$count]) && $sub_cat_selection[$count] != 0 || $sub_cat_selection[$count] != ""){
                    $data_promotion_details['cat_id'] = null;
                    $data_promotion_details['subcat_id'] = $sub_cat_selection[$count];
                }

                $data_promotion_details['brand_id'] = $brand[$count];  
                if($discount_type == 1){
                    $data_promotion_details['discount_rate'] = $discount_amount;
                }elseif($discount_type == 2){
                    $data_promotion_details['discount_amount'] = $discount_amount;
                }
                $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
            }
        }elseif(!empty($promotion_id) && $type_id == 1 && $promotion_on == 2){
            for($count = 0; $count < $total_row_number; $count++){

                $data_promotion_details['promotion_id'] = $promotion_id;
                $data_promotion_details['brand_id'] = $brand[$count];  
                if($discount_type == 1){
                    $data_promotion_details['discount_rate'] = $discount_amount;
                }elseif($discount_type == 2){
                    $data_promotion_details['discount_amount'] = $discount_amount;
                }
                $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
            }
        }elseif(!empty($promotion_id) && $type_id == 1 && $promotion_on == 1){
            for($count = 0; $count < $total_row_number; $count++){

                $data_promotion_details['promotion_id'] = $promotion_id;
                if($sub_cat_selection[$count] == 0 || $sub_cat_selection[$count] == ""){
                    $data_promotion_details['cat_id'] = $cat_selection[$count];
                    $data_promotion_details['subcat_id'] = null;
                }elseif($sub_cat_selection[$count] != 0 || $sub_cat_selection[$count] != ""){
                    $data_promotion_details['cat_id'] = null;
                    $data_promotion_details['subcat_id'] = $sub_cat_selection[$count];
                } 
                if($discount_type == 1){
                    $data_promotion_details['discount_rate'] = $discount_amount;
                }elseif($discount_type == 2){
                    $data_promotion_details['discount_amount'] = $discount_amount;
                }
                $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
            }
        }elseif(!empty($promotion_id) && $type_id == 2){
            // echo "2"; exit();
            $data_promotion_details['promotion_id'] = $promotion_id;
            $data_promotion_details['min_purchase_amt'] = $purchase_amt_from;
            if($discount_type == 1){
                $data_promotion_details['discount_rate'] = $discount_amount;
            }elseif($discount_type == 2){
                $data_promotion_details['discount_amount'] = $discount_amount;
            }
            $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
            $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details); 
        }elseif(!empty($promotion_id) && $type_id == 3){
            $data_promotion_details['promotion_id'] = $promotion_id;
            $data_promotion_details['payment_type'] = 1;
            if($discount_type == 1){
                $data_promotion_details['discount_rate'] = $discount_amount;
            }elseif($discount_type == 2){
                $data_promotion_details['discount_amount'] = $discount_amount;
            }
            $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
            $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details); 
        }elseif(!empty($promotion_id) && $type_id == 1 && $promotion_on == 4){
            for($count = 0; $count < count($product_id); $count++){

                $data_promotion_details['promotion_id'] = $promotion_id;
                $data_promotion_details['product_id'] = $product_id[$count];
                $data_promotion_details['cat_id'] = $cat_id[$count];
                $data_promotion_details['store_id'] = $store_id[$count];
                $data_promotion_details['batch_no'] = $batch_no[$count];
                $data_promotion_details['subcat_id'] = $subcat_id[$count];
                $data_promotion_details['brand_id'] = $brand_id[$count];
                $data_promotion_details['discount_rate'] = $percet[$count];
                $data_promotion_details['discount_amount'] = $taka[$count];
                $data_promotion_details['dtt_add'] = date('Y-m-d H:i:s');
                $data_promotion_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $promotion_details_id = $this->Promotion_settings_model->common_insert('promotion_details', $data_promotion_details);
            }
        }

        if($promotion_details_id){
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }

    


// public function test(){
//     $promotion_id = 32;
//     $data_promotions = array (
//       'title' => 'qqq',
//       'details' => 'qqq',
//       'type_id' => '1',
//       'dt_from' => '2017-11-09',
//       'dt_to' => '2017-11-09',
//       'dtt_mod' => '2017-11-09 19:32:46',
//       'uid_mod' => '5',
//     );

//     $promotion_id_update = $this->Promotion_settings_model->common_update('promotions', $data_promotions, 'id_promotion', $promotion_id);
// }
	

}
