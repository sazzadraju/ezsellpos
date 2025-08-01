<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        // $this->load->library('form_validation');
        $this->form_validation->CI = &$this;
        if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->perPage = 20;

        $this->load->model('Customer_model');
    }

    //**Customer Settings::Customer Type Start**//
    public function customer_type()
    {
        $data = array();
        $this->dynamic_menu->check_menu('customer/type');
        $this->breadcrumb->add('Customer Type', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        //total rows count
        $totalRec = count($this->Customer_model->all_customer_type_list());

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'customer/customer_type_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['posts'] = $this->Customer_model->all_customer_type_list(array('limit' => $this->perPage));
        $this->template->load('main', 'customer/customer_type', $data);
    }

    public function customer_type_data()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        //total rows count
        $row = $this->Customer_model->all_customer_type_list();
        $totalRec = ($row!='')?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'customer/customer_type_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['posts'] = $this->Customer_model->all_customer_type_list($conditions);
        //load the view
        $this->load->view('customer/customer_type_data', $data, false);
    }

    public function create_customer_type()
    {
        if ($this->input->post('id') != '') {
            $name = $this->input->post('cty_name');
            $id_v = $this->input->post('id');
            $this->form_validation->set_rules('cty_name', 'Customer Type Name', 'trim|required');
            $val = $this->Customer_model->isExistExcept('customer_types', 'name', $name, 'id_customer_type', $id_v);
            if ($val) {
                echo json_encode(array('cty_name' => lang('name_exist')));
                exit();
            }
        } else {
            $name = $this->input->post('cus_type_name');
            $this->form_validation->set_rules('cus_type_name', 'Customer Type Name', 'trim|required');
        }
        $this->form_validation->set_rules('discount', 'Discount', 'trim|required|numeric');
        $this->form_validation->set_rules('target_sales_volume', 'Target Sale', 'trim|required|numeric');

        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $data['name'] = $name;
            $data['discount'] = $this->input->post('discount');
            $data['target_sales_volume'] = $this->input->post('target_sales_volume');
            $data['status_id'] = 1;
            $id_customer_type = $this->input->post('id');

            if ($id_customer_type != '') {
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $result = $this->Customer_model->common_update('customer_types', $data, 'id_customer_type', $id_customer_type);
                if ($result) {
                    echo json_encode(array("status" => "success", "message" => lang('update_success')));
                }
            } else {
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $result = $this->Customer_model->common_insert('customer_types', $data);
                if ($result) {
                    echo json_encode(array("status" => "success", "message" => lang('add_success')));
                }
            }
        }
    }

    public function edit_customer_type($id = null)
    {
        $data = $this->Customer_model->get_customer_type_by_id($id);
        echo json_encode($data);
    }

    public function delete_customer_type($id = null)
    {
        $customer=$this->commonmodel->getvalue_row('customers', 'id_customer', array('status_id' => 1,'customer_type_id'=>$id));
        if(!$customer){
            $data['status_id'] = 2;
            $data['dtt_mod'] = date('Y-m-d H:i:s');
            $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
            $this->Customer_model->common_update('customer_types', $data, 'id_customer_type', $id);
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => 2));
        }
    }

    public function checkCustomerCode()
    {
        $this->load->database();
        $customer_code = $this->input->post('customer_code');
        $this->db->where('customer_code', $customer_code);
        $this->db->where('status_id', 1);
        $query = $this->db->get('customers');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    //**Customer Settings::Customer Type End**//
    //**Customer Settings::Customer Start**//
    public function customers()
    {
        $this->dynamic_menu->check_menu('customer');
        $data = array();
        $this->breadcrumb->add('Customers', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->Customer_model->all_customer_list();
        $totalRec = ($row!='')?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'customer/customer_info_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['posts'] = $this->Customer_model->all_customer_list(array('limit' => $this->perPage));
        //dropdown data
        $data['customer_type_list'] = $this->Customer_model->common_cond_dropdown_data('customer_types', 'id_customer_type', 'name', 'status_id', '1', 'id_customer_type', 'ASC');
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->Customer_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->Customer_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['offset'] =0;
        $data['city_list'] = $this->Customer_model->common_single_value_array('loc_cities', 'id_city', 'city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->Customer_model->common_single_value_array('loc_divisions', 'id_division', 'division_name_en', 'id_division', 'ASC');
        $data['configs'] = $this->Customer_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
        $data['sms_config'] = $this->Customer_model->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 1));
        $data['sms_due_config'] = $this->Customer_model->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 2));
        $data['due_customers'] = $this->Customer_model->due_customer_list();
        $this->template->load('main', 'customer/customers', $data);
    }
    public function create_csv_data()
    {
        $conditions=array();
        $div_id = $this->input->post('division_id');
        $dist_id = $this->input->post('district_id');
        $city_id = $this->input->post('city_id');
        $area_id = $this->input->post('city_location_id');
        $cus_address = $this->input->post('cus_address');
        $store_id = $this->input->post('store_id');
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($div_id)) {
            $conditions['search']['div_id'] = $div_id;
        }
        if (!empty($dist_id)) {
            $conditions['search']['dist_id'] = $dist_id;
        }
        if (!empty($city_id)) {
            $conditions['search']['city_id'] = $city_id;
        }
        if (!empty($area_id)) {
            $conditions['search']['area_id'] = $area_id;
        }
        if (!empty($cus_address)) {
            $conditions['search']['cus_address'] = $cus_address;
        }
        $name_customer = $this->input->post('name_customer');
        if (!empty($name_customer)) {
            $conditions['search']['name_customer'] = $name_customer;
        }
        $phone_customer = $this->input->post('phone_customer');
        if (!empty($phone_customer)) {
            $conditions['search']['phone_customer'] = $phone_customer;
        }
        $type_of_customer = $this->input->post('type_of_customer');
        if (($type_of_customer != 0)) {
            $conditions['search']['type_of_customer'] = $type_of_customer;
        }
        //total rows count
        $posts = $this->Customer_model->all_customer_list($conditions);
        $fields = array(
            'customer_code' => 'Customer Code'
        , 'customer_name' => 'Customer Name'
        , 'customer_type' => 'Customer Type'
        , 'division' => 'Division / City'
        , 'district' => 'District / Area'
        , 'address' => 'Address'
        , 'store_name' => 'Store Name'
        , 'mobile_number' => 'Mobile Number'
        , 'points' => 'Points'
        , 'balance' => 'Balance'
        );
        $tot_amount=0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $tot_amount =$tot_amount+$post['balance'];
                $division=($post['division_name_en'] != "")?$post['division_name_en']: $post['city_name_en'];
                $district=($post['district_name_en'] !="")?$post['district_name_en']:$post['area_name_en'];
                $value[] = array(
                    'customer_code' => $post['customer_code']
                , 'customer_name' => $post['full_name']
                , 'customer_type' => $post['name']
                , 'division' =>  $division
                , 'district' =>  $district
                , 'address' => $post['addr_line_1']
                , 'store_name' =>$post['store_name']
                , 'mobile_number' => $post['phone']
                , 'points' => $post['points']
                , 'balance' => $post['balance']
                );
                $count++;
            }
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'customer_list'
        , 'file_title' => 'Customer List'
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

    public function customer_info_data()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $div_id = $this->input->post('division_id');
        $dist_id = $this->input->post('district_id');
        $city_id = $this->input->post('city_id');
        $area_id = $this->input->post('city_location_id');
        $cus_address = $this->input->post('cus_address');
        $store_id = $this->input->post('store_id');
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($div_id)) {
            $conditions['search']['div_id'] = $div_id;
        }
        if (!empty($dist_id)) {
            $conditions['search']['dist_id'] = $dist_id;
        }
        if (!empty($city_id)) {
            $conditions['search']['city_id'] = $city_id;
        }
        if (!empty($area_id)) {
            $conditions['search']['area_id'] = $area_id;
        }
        if (!empty($cus_address)) {
            $conditions['search']['cus_address'] = $cus_address;
        }
        $name_customer = $this->input->post('name_customer');
        if (!empty($name_customer)) {
            $conditions['search']['name_customer'] = $name_customer;
        }
        $phone_customer = $this->input->post('phone_customer');
        if (!empty($phone_customer)) {
            $conditions['search']['phone_customer'] = $phone_customer;
        }
        $type_of_customer = $this->input->post('type_of_customer');
        if (($type_of_customer != 0)) {
            $conditions['search']['type_of_customer'] = $type_of_customer;
        }
        //total rows count
        $row = $this->Customer_model->all_customer_list($conditions);
        $totalRec = ($row!='')?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'customer/customer_info_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['posts'] = $this->Customer_model->all_customer_list($conditions);
        //load the viewoffset
        $data['offset'] =$offset;
        $this->load->view('customer/customer_info_data', $data, false);
    }

    public function create_customer_info()
    {
        $this->form_validation->set_rules('customer_code', 'Customer code', 'trim|required|callback_is_unique_customer');
        $this->form_validation->set_rules('full_name', 'Fullname', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_numeric');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');

        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $data['customer_code'] = $this->input->post('customer_code');
            $data['full_name'] = $this->input->post('full_name');
            $data['customer_type_id'] = $this->input->post('customer_type_id');
            $data['email'] = $this->input->post('c_email');
            $data['phone'] = $this->input->post('phone');
            $data['gender'] = $this->input->post('gender');
            $data['marital_status'] = $this->input->post('marital_status');
            $data['birth_date'] = $this->input->post('birth_date');
            $data['anniversary_date'] = $this->input->post('anniversary_date');
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $data['status_id'] = '1';
            $data['version'] = '1';
            $data['store_id'] = $this->session->userdata['login_info']['store_id'];
            if ($_FILES['profile_img']['name'] != '') {
                $filename = upload_file('customer', $_FILES['profile_img']);
                $data['profile_img'] = $filename;
            }
            $customer_id = $this->Customer_model->common_insert('customers', $data);

            if ($customer_id) {

                if (($this->input->post('address_type2') != 0) || ($this->input->post('division_id') != '') || ($this->input->post('city_id') != '') || ($this->input->post('addr_line_1') != ''))
                    $address_data['customer_id'] = $customer_id;
                $address_data['address_type'] = $this->input->post('address_type2');
                $address_data['div_id'] = $this->input->post('division_id');
                $address_data['dist_id'] = $this->input->post('district_id');
                $address_data['city_id'] = $this->input->post('city_id');
                $address_data['area_id'] = $this->input->post('city_location_id');
                $address_data['addr_line_1'] = $this->input->post('addr_line_1');
                $log_id = $this->Customer_model->common_insert('customer_addresss', $address_data);
            }
            $sms_send=$this->input->post('sms_send');
            $curr_balance=$this->input->post('curr_balance');
            if( $sms_send==1&& $curr_balance>0){
                $smsArray['sms_count']=1;
                $smsArray['unit_price']=$this->input->post('unit_price');
                $smsArray['sms_type']=1;
                //$smsArray['cus_phone']=$this->input->post('phone');
                //$smsArray['cus_name']=$this->input->post('full_name');
                $customerArray[]=array(
                    'name'=>$this->input->post('full_name'),
                    'phone'=>$this->input->post('phone')
                );
                 $smsArray['cus_data']=$customerArray;
                $msgarray=set_sms_send($smsArray);
                //print_r($msgarray);
            }
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }
    public function submit_send_sms(){
            $nameArray=$this->input->post('nameArray');
            $phoneArray=$this->input->post('phoneArray');
            $unit_price=$this->input->post('unit_price');
            //$customerArray=array();
            for ($i=0; $i < count($nameArray); $i++) {
                $customerArray[]=array(
                    'name'=> $nameArray[$i],
                    'phone'=>$phoneArray[$i]
                );
                // if(count($nameArray)==1){
                //     $customerArray=array(
                //         'name'=> $nameArray[$i],
                //         'phone'=>$phoneArray[$i]
                //     );
                // } else{
                //     $key=array(
                //         'name'=> $nameArray[$i],
                //         'phone'=>$phoneArray[$i]
                //     );
                //     array_push($customerArray, $key);
                // } 
            }
            //if($configs[0]->param_val>0 && $sms_config[0]->sms_send ==1){
                $smsArray['sms_count']=1;
                $smsArray['unit_price']=$unit_price;
                $smsArray['sms_type']=2;
                $smsArray['cus_data']=$customerArray;
                //print_r($smsArray);
                $msgarray=set_sms_send($smsArray);
                //print_r($msgarray);
                echo 'success';
               
            //}
        //print_r($_POST);
    }

    function send_sms_due_customers (){
        $configs = $this->Customer_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
        $sms_config = $this->Customer_model->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 1));
        $sms_send=$sms_config[0]['sms_send'];
        $curr_balance=$configs[0]['param_val'];
        $unit_price=$configs[0]['utilized_val'];
        if( $sms_send==1&& $curr_balance>0){
            $smsArray['sms_count']=1;
            $smsArray['unit_price']=$this->input->post('unit_price');
            $smsArray['sms_type']=1;
            $smsArray['cus_phone']=$this->input->post('phone');
            $smsArray['cus_name']=$this->input->post('full_name');
            $msgarray=set_sms_send($smsArray);
            //print_r($msgarray);
        }
        echo json_encode(array("status" => "success", "message" => lang('add_success')));   
    }

    function check_default($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }

    public function edit_customer_basic_info()
    {
        if ($this->input->post('customer_id') != '') {

            $name = $this->input->post('edit_customer_code');
            $id_v = $this->input->post('customer_id');
            $this->form_validation->set_rules('edit_customer_code', 'Membership ID', 'trim|required');
            $val = $this->commonmodel->isExistExcept('customers', 'customer_code', $name, 'id_customer', $id_v);
            if ($val == 1) {
                echo json_encode(array('edit_customer_code' => lang('name_exist')));
                exit();
            }
        } else {
            $this->form_validation->set_rules('edit_full_name', 'Fullname', 'trim|required');
            $this->form_validation->set_rules('edit_phone', 'Phone', 'trim|required|is_numeric');
            $this->form_validation->set_rules('edit_gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('edit_customer_type_id', 'Address Type', 'trim|required|callback_select_check');
        }
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $customer_id = $this->input->post('customer_id');
            $data['customer_code'] = $this->input->post('edit_customer_code');
            $data['full_name'] = $this->input->post('edit_full_name');
            $data['customer_type_id'] = $this->input->post('edit_customer_type_id');
            $data['email'] = $this->input->post('edit_c_email');
            $data['phone'] = $this->input->post('edit_phone');
            $data['gender'] = $this->input->post('edit_gender');
            $data['birth_date'] = $this->input->post('edit_birth_date');
            $data['marital_status'] = $this->input->post('edit_marital_status');
            $data['anniversary_date'] = $this->input->post('edit_anniversary_date');
            $data['dtt_mod'] = date('Y-m-d H:i:s');
            $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
            $old_customer_photo = $this->input->post('old_customer_photo');
            if ($_FILES['profile_img']['name']!='') {
                if($old_customer_photo != ''){
                    delete_file('customer', $old_customer_photo);
                }
                $filename = upload_file('customer', $_FILES['profile_img']);
                $data['profile_img'] = $filename;
            }

            $result = $this->Customer_model->common_update('customers', $data, 'id_customer', $customer_id);

            if ($result) {
                echo json_encode(array("status" => "success", "message" => lang('update_success')));
            }
        }
    }

    public function delete_customer_info()
    {
        $id = $this->input->post('id');
        $data['status_id'] = 2;
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
        $result = $this->Customer_model->common_update('customers', $data, 'id_customer', $id);
        if ($result) {
            echo json_encode(array("status" => TRUE));
        }
    }

    ///////////////////Customer Address Start////////////////////////
    public function customer_address_pagination()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        $customer_id = $this->input->post('customer_id');

        if (!empty($customer_id)) {
            $conditions['search']['id_customer'] = $customer_id;
        }

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        //total rows count
        $totalRec = count($this->Customer_model->get_customer_address_pagination($conditions));
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'customer_settings/customer/customer_address_pagination';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['posts'] = $this->Customer_model->get_customer_address_pagination($conditions);
        //load the view
        $this->load->view('customer/customer_address_pagination', $data, false);
    }

    public function customer_details($customer_id = null)
    {
        $this->breadcrumb->add('Customers', 'customer', 1);
        $this->breadcrumb->add('Customer details', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['customer_info'] = $this->Customer_model->get_customer_details($customer_id);
        $data['invoices'] = $this->Customer_model->customer_sale_invoice($customer_id);
        $data['customer_address_list'] = $this->Customer_model->get_customer_address_result($customer_id);
        $data['customer_document_list'] = $this->Customer_model->get_customer_document_result($customer_id);
        $data['city_list'] = $this->Customer_model->common_single_value_array('loc_cities', 'id_city', 'city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->Customer_model->common_single_value_array('loc_divisions', 'id_division', 'division_name_en', 'id_division', 'ASC');
        $data['customer_type_list'] = $this->Customer_model->common_cond_dropdown_data('customer_types', 'id_customer_type', 'name', 'status_id', '1', 'id_customer_type', 'ASC');
        $this->template->load('main', 'customer/customer_details', $data);
    }

    public function customer_address_list()
    {
        $customer_id = $this->uri->segment(4);
        $data['customer_info'] = $this->Customer_model->common_cond_row_array('customers', 'id_customer', $customer_id);
        $data['customer_address_list'] = $this->Customer_model->get_customer_address_result($customer_id);
        $data['city_list'] = $this->Customer_model->common_single_value_array('loc_cities', 'id_city', 'city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->Customer_model->common_single_value_array('loc_divisions', 'id_division', 'division_name_en', 'id_division', 'ASC');
        $this->template->load('main', 'customer/customer_address_list', $data);
    }

    public function edit_customer_address()
    {
        $id = $this->input->post('id');
        $result = $this->Customer_model->common_cond_row_array('customer_addresss', 'id_customer_address', $id);
        $city_id = $result[0]['city_id'];
        $division_id = $result[0]['div_id'];
        if ($city_id != 0) {
            $area = 'city';
            $location_result = $this->Customer_model->common_cond_single_value_array('loc_areas', 'id_area', 'area_name_en', 'city_id', $city_id, 'id_area', 'ASC');
        }

        if ($division_id != 0) {
            $area = 'division';
            $location_result = $this->Customer_model->common_cond_single_value_array('loc_districts', 'id_district', 'district_name_en', 'division_id', $division_id, 'id_district', 'ASC');
        }

        if ($result) {
            echo json_encode(array("result" => $result, "location_result" => $location_result, "area" => $area));
        }
    }

    public function create_customer_address()
    {
        $this->form_validation->set_rules('address_type', 'Address Type', 'trim|required|callback_select_check');
        $this->form_validation->set_rules('city_division', 'City / Division', 'trim|required|callback_select_check');
        $this->form_validation->set_rules('address_location', 'Location', 'trim|required|callback_select_check');
        $this->form_validation->set_rules('addr_line_1', 'Address', 'trim|required');

        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $data['customer_id'] = $this->input->post('customer_id');
            $data['address_type'] = $this->input->post('address_type');
            $data['div_id'] = $this->input->post('division_id');
            $data['dist_id'] = $this->input->post('district_id');
            $data['city_id'] = $this->input->post('city_id');
            $data['area_id'] = $this->input->post('city_location_id');
            $data['addr_line_1'] = $this->input->post('addr_line_1');

            // $check = $this->Customer_model->check_customer_address_type($this->input->post('customer_id'), $this->input->post('address_type'));

            // if ($check) {
            //     echo json_encode(array("status" => "success", "message" => $this->input->post('address_type') . " already exist !"));
            // } else {
                $result = $this->Customer_model->common_insert('customer_addresss', $data);
                if ($result) {
                    echo json_encode(array("status" => "success", "message" => lang('add_success'), "customer_id" => $this->input->post('customer_id')));
                }
            //}
        }
    }

    public function update_customer_address()
    {
        $this->form_validation->set_rules('edit_address_type', 'Address Type', 'trim|required|callback_select_check');
        $this->form_validation->set_rules('city_division1', 'City / Division', 'trim|required|callback_select_check');
        $this->form_validation->set_rules('edit_address_location', 'Location', 'trim|required|callback_select_check');
        $this->form_validation->set_rules('edit_addr_line_1', 'Address', 'trim|required');

        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $id = $this->input->post('edit_id_customer_address');
            $data['address_type'] = $this->input->post('edit_address_type');
            $data['div_id'] = $this->input->post('division_id');
            $data['dist_id'] = $this->input->post('district_id');
            $data['city_id'] = $this->input->post('city_id');
            $data['area_id'] = $this->input->post('city_location_id');
            $data['addr_line_1'] = $this->input->post('edit_addr_line_1');

            $result = $this->Customer_model->common_update('customer_addresss', $data, 'id_customer_address', $id, FALSE);
            if ($result) {
                echo json_encode(array("status" => "success", "message" => lang('update_success')));
            }
        }
    }

    public function delete_customer_address()
    {
        $id = $this->input->post('id');
        $result = $this->Customer_model->common_delete('customer_addresss', 'id_customer_address', $id);
        if ($result) {
            echo json_encode(array("status" => TRUE));
        }
    }

    ///////////////////Customer Address Start////////////////////////
    ///////////////////Customer Document Start////////////////////////
    public function create_customer_document()
    {
        $this->form_validation->set_rules('document_name', 'Doc Name', 'trim|required');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $data['doc_type'] = 'Customer';
            $data['ref_id'] = $this->input->post('customer_id');
            $data['name'] = $this->input->post('document_name');
            $data['description'] = $this->input->post('document_description');
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $data['status_id'] = 1;
            $data['version'] = 1;

            if ($_FILES['document_file']['name']!='') {
                $filename = upload_file('customer', $_FILES['document_file']);
                $data['file'] = $filename;
            }

            $result = $this->Customer_model->common_insert('documents', $data);
            if ($result) {
                echo json_encode(array("status" => "success", "message" => lang('add_success'), "customer_id" => $this->input->post('customer_id')));
            }
        }
    }

    public function customer_documents_pagination()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        $customer_id = $this->input->post('customer_id');

        if (!empty($customer_id)) {
            $conditions['search']['id_customer'] = $customer_id;
        }

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        //total rows count
        $totalRec = count($this->Customer_model->get_customer_document_result_pagination($conditions));
        //pagination configuration
        $config['target'] = '#documentList';
        $config['base_url'] = base_url() . 'customer_settings/customer/customer_documents_pagination';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterDocument';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['posts'] = $this->Customer_model->get_customer_document_result_pagination($conditions);
        //load the view
        $this->load->view('customer/customer_document_pagination', $data, false);
    }

    public function edit_customer_doc()
    {
        $id = $this->input->post('id');
        $result = $this->Customer_model->common_cond_row_array('documents', 'id_document', $id);
        if ($result) {
            echo json_encode($result);
        }
    }

    public function update_customer_document()
    {
        $this->form_validation->set_rules('edit_document_name', 'Doc Name', 'trim|required');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $id = $this->input->post('edit_customer_document_id');
            $data['name'] = $this->input->post('edit_document_name');
            $data['description'] = $this->input->post('edit_document_description');
            $data['dtt_mod'] = date('Y-m-d H:i:s');
            $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
            $old_customer_doc = $this->input->post('old_customer_doc');

            if ($_FILES['edit_document_file']['name'] != '') {
                if ($old_customer_doc != '') {
                    delete_file('customer', $old_customer_doc);
                }
                $filename = upload_file('customer', $_FILES['edit_document_file']);
                $data['file'] = $filename;
            }
            $result = $this->Customer_model->common_update('documents', $data, 'id_document', $id);
            if ($result) {
                echo json_encode(array("status" => "success", "message" => lang('update_success')));
            }
        }
    }

    public function delete_customer_doc()
    {
        $id = $this->input->post('id');
        $data['status_id'] = 2;
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $result = $this->Customer_model->common_update('documents', $data, 'id_document', $id);
        if ($result) {
            echo json_encode(array("status" => TRUE));
        }
    }

    ///////////////////Customer Document End////////////////////////

    public function get_district()
    {
        $id = $this->input->post('id');
        $result = $this->Customer_model->common_cond_single_value_array('loc_districts', 'id_district', 'district_name_en', 'division_id', $id, 'id_district', 'ASC');
        if ($result) {
            echo json_encode($result);
        }
    }

    public function get_city_location()
    {
        $id = $this->input->post('id');
        $result = $this->Customer_model->common_cond_single_value_array('loc_areas', 'id_area', 'area_name_en', 'city_id', $id, 'id_area', 'ASC');
        if ($result) {
            echo json_encode($result);
        }
    }

    public function editCustomerInfo()
    {
        $id = $this->input->post('id');
        $result = $this->Customer_model->common_cond_row_array('customers', 'id_customer', $id);
        if (!empty($result)) {
            echo json_encode($result);
        } else {
            echo "0";
        }
    }

    public function check_customer_type_name()
    {
        $name = $this->input->post('cus_type_name');
        $res = $this->Customer_model->check_value('customer_types', 'name', $name);
        $val = ($res) ? 'false' : 'true';
        echo $val;
    }

    function select_check($str)
    {
        if ($str == '0') {
            $this->form_validation->set_message('select_check', lang('select_msg'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function is_unique_customer($str)
    {
        $this->load->database();
        $this->db->where('customer_code', $str);
        $query = $this->db->get('customers');
        $result = $query->result();
        if ($result) {
            $this->form_validation->set_message('is_unique_customer', lang('unique_false_msg'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_customers_auto()
    {
        $request = $_REQUEST['request'];
        $product_list = $this->Customer_model->get_customer_autocomplete($request);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->full_name.'('. $list->customer_code.')',
                "value" => $list->id_customer,
                "code" => $list->customer_code,
                "customer_type_id" => $list->customer_type_id,
                "phone" => $list->phone,
                "points" => $list->points,
                "balance" => $list->balance

                // "is_unq_barcode" => $list->is_unq_barcode
            );
        }
        echo json_encode($return);
    }

    //**Customer Settings::Customer End**//
}
