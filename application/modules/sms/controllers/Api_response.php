<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_response extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('api_response_model');
    }


    //**Stock In Section Start**//
    public function index()
    {
        $data = array();
        
        
         //$data['posts'] = $this->audience_model->all_audience_list($data);
        //$data['supplier_list'] = $this->audience_model->get_supplier_drop_down();
        echo 'connect';
    }
    public function update_sms_balance(){
        $data = json_decode(file_get_contents('php://input'), true);
        $password=$data['password'];
        if($password==md5('syntech_98765430')){
            $getData = array(
                    'qty' =>$data['sms_qty'],
                    'unit_price' =>$data['unit_price'],
                    'total_price' => $data['total_price'],
                    'allocation_id' => $data['allocation_id']
                );
            $this->api_response_model->common_insert('sms_entry_log',$getData);
            $this->api_response_model->update_sms($getData);
            echo 'success';
        }else{
            echo 'error';
        }
    }

    public function pagination_data()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $invoice_number = $this->input->post('invoice_number');
        if (!empty($invoice_number)) {
            $conditions['search']['invoice_number'] = $invoice_number;
        }

        $from_date = $this->input->post('from_date');
        if (!empty($from_date)) {
            $conditions['search']['from_date'] = $from_date;
        }

        $to_date = $this->input->post('to_date');
        if (!empty($to_date)) {
            $conditions['search']['to_date'] = $to_date;
        }
        $store_name = $this->input->post('store_name');
        if (!empty($store_name)) {
            $conditions['search']['store_name'] = $store_name;
        }


        //total rows count
        $totalRec = count($this->audience_model->stock_in_list($conditions));
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock/stock_in_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['stores'] = $this->audience_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->audience_model->stock_in_list($conditions);
        //load the view
        $this->load->view('stock_in/stock_in_list_pagination', $data, false);
    }

    public function add()
    {
        $this->dynamic_menu->check_menu('sms/audience');
        $this->breadcrumb->add(lang('audience_list'), 'sms/audience', 1);
        $this->breadcrumb->add(lang('audience_add'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->audience_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->audience_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['city_list'] = $this->audience_model->common_single_value_array('loc_cities', 'id_city', 'city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->audience_model->common_single_value_array('loc_divisions', 'id_division', 'division_name_en', 'id_division', 'ASC');
        $data['customer_type_list'] = $this->audience_model->common_cond_dropdown_data('customer_types', 'id_customer_type', 'name', 'status_id', '1', 'id_customer_type', 'ASC');
        
        
        $data['suppliers'] = $this->audience_model->getvalue_row('suppliers', 'id_supplier,supplier_code,supplier_name', array('status_id' => 1));
        $data['products'] = $this->audience_model->getvalue_row('products', 'id_product,product_code,product_name', array('status_id' => 1));
        $this->template->load('main', 'audience/add_form', $data);
    }
    public function search_customer(){
        $conditions = array();
        $name_customer = $this->input->post('name_customer');
        $div_id = $this->input->post('division_id');
        $dist_id = $this->input->post('district_id');
        $city_id = $this->input->post('city_id');
        $area_id = $this->input->post('city_location_id');
        $cus_address = $this->input->post('cus_address');
        $store_id = $this->input->post('store_name');
        $phone_customer = $this->input->post('phone_customer');
        $type_of_customer = $this->input->post('type_of_customer');

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
        if (!empty($name_customer)) {
            $conditions['search']['name_customer'] = $name_customer;
        }
        if (!empty($phone_customer)) {
            $conditions['search']['phone_customer'] = $phone_customer;
        }
        if (($type_of_customer != 0)) {
            $conditions['search']['type_of_customer'] = $type_of_customer;
        }
        //total rows count
        $data['posts'] = $this->audience_model->search_customer_list($conditions);
        $this->load->view('audience/search_customer_list', $data, false);
    }
    public function search_supplier(){
        $conditions = array();
        $name_supplier = $this->input->post('name_supplier');
        $store_id = $this->input->post('store_name');
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($name_supplier)) {
            $conditions['search']['name_supplier'] = $name_supplier;
        }
        $phone_supplier = $this->input->post('phone_supplier');
        if (!empty($phone_supplier)) {
            $conditions['search']['phone_supplier'] = $phone_supplier;
        }

        $email_supplier = $this->input->post('email_supplier');
        if (!empty($email_supplier)) {
            $conditions['search']['email_supplier'] = $email_supplier;
        }
        $inactive_supplier = $this->input->post('inactive_supplier');
        if ($inactive_supplier==1) {
            $conditions['search']['inactive_supplier'] = $inactive_supplier;
        }
        //total rows count
        $data['posts'] = $this->audience_model->search_supplier_list($conditions);
        $this->load->view('audience/search_supplier_list', $data, false);
    }
    public function submit_data(){
        $id=$this->input->post('id');
        $type=$this->input->post('type');
        $name=$this->input->post('name');
        $phone=$this->input->post('phone');
        $add_date=$this->input->post('add_date');
        $title=$this->input->post('title');
       // print_r($checks);
        $uid_add = $this->session->userdata['login_info']['id_user_i90'];
        $dtt_add = date('Y-m-d H:i:s');
        $add_date = date('Y-m-d');
        $row['title']=$title;
        $row['date']=$add_date;
        $row['dtt_add']=$dtt_add;
        $row['uid_add']=$uid_add;
        $paernt_id=$this->audience_model->common_insert('sms_set_person', $row);
        for($i=0; $i<count($id);$i++){
           // $html=$checks[$i];
            $data['set_person_id']=$paernt_id;
            $data['type']=$type[$i];
            $data['person_id']=$id[$i];
            $data['phone']=$phone[$i];
            $data['person_name']=$name[$i];
            
            $this->audience_model->common_insert('sms_set_person_details', $data);
        }
        $massage = 'Successfully data added..';
        echo json_encode(array("status" => "success", "message" => $massage));
    }


    

    public function show_details($id = null)
    {
        $this->dynamic_menu->check_menu('sms/audience');
        $this->breadcrumb->add(lang('audience_list'), 'sms/audience', 1);
        $this->breadcrumb->add(lang('details'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['posts'] = $this->audience_model->getDetailsById($id);
        $this->template->load('main','audience/details_data', $data);
    }

    

}
