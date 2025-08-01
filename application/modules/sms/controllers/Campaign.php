<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));
        if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->perPage = 200;

        $this->load->model('campaign_model');
    }


    //**Stock In Section Start**//
    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('sms/campaign');
        $this->breadcrumb->add(lang('campaign_list'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->campaign_model->all_campaign_list($data);
        $totalRec = ($row!='')?count($row):'';
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'sms/campaign';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
         $data['posts'] = $this->campaign_model->all_campaign_list($data);
        //$data['supplier_list'] = $this->campaign_model->get_supplier_drop_down();
       
        $data['stores'] = $this->campaign_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $this->template->load('main', 'campaign/index', $data);
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
        $totalRec = count($this->campaign_model->stock_in_list($conditions));
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
        $data['stores'] = $this->campaign_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->campaign_model->stock_in_list($conditions);
        //load the view
        $this->load->view('stock_in/stock_in_list_pagination', $data, false);
    }

    public function add()
    {
        
        $this->dynamic_menu->check_menu('sms/campaign');
        $this->breadcrumb->add(lang('campaign_list'), 'sms/campaign', 1);
        $this->breadcrumb->add(lang('campaign_add'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->campaign_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->campaign_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['audiences'] = $this->campaign_model->all_audience_list();
        $data['configs'] = $this->campaign_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
        $this->template->load('main', 'campaign/add_form', $data);
    }
    public function submit_data(){
        $campaign_name=$this->input->post('campaign_name');
        $curr_balance=$this->input->post('curr_balance');
        $audience_name=$this->input->post('audience_name');
        $total_sms=$this->input->post('total_sms');
        $message=$this->input->post('message');
        $sms_count=$this->input->post('sms_count');
        $unit_price=$this->input->post('unit_price');
        $sum_total_sms=$this->input->post('sum_total_sms');
        $sum_total_price=$this->input->post('sum_total_price');
       // print_r($checks);
        $uid_add = $this->session->userdata['login_info']['id_user_i90'];
        $dtt_add = date('Y-m-d H:i:s');
        $add_date = date('Y-m-d');
        
        $customer=array();
        for($i=0; $i<count($audience_name);$i++){
           // $html=$checks[$i];
            //$data['campaign_id']=$paernt_id;
            //$data['set_person_id']=$audience_name[$i];
            //$this->campaign_model->common_insert('sms_campaign_person', $data);
            $persons=$this->campaign_model->get_person_list($audience_name[$i]);
            foreach ($persons as $value) {
                $name= ($value['type']==1)?$value['customer_name']:$value['supplier_name'];
                $phone= ($value['type']==1)?$value['cus_phone']:$value['sup_phone'];
                // if (strpos($phone, '88') == false) {
                //     $phone='88'.$phone;
                // }
                $search = '88';
                if(!preg_match("/{$search}/i", $phone)) {
                    $phone='88'.$phone;
                }
                $key=array(
                    'type'=>$value['type'],
                    'name'=> $name,
                    'phone'=>$phone
                );
                array_push($customer, $key);
            }
        }
        //if($paernt_id){
            $row_data=array(
                'total_sms'=>$sum_total_sms,
                'unit_price'=>$unit_price,
            );
            $this->campaign_model->update_config($row_data);
            // Curl post data
            $client_id= $this->session->userdata['login_info']['subscription_info']['CLIENT_ID'];
            $client_name= $this->session->userdata['login_info']['subscription_info']['CLIENT_USERNAME'];
            $this->load->library('Curl');
            //$url = 'http://localhost/sms/api_sms/update_client_sms';
            $url = 'http://posspot.com/sms/api_sms/update_client_sms';
            $jsonData = array(
                'message' => $message,
                'message_qty' => $sms_count,
                'unit_price' => $unit_price,
                'total_price' => $sum_total_price,
                'sms_qty' => $sum_total_sms,
                'customer' => $customer,
                'client_id' => $client_id,
                'client_name' => $client_name,
                'password' => md5('syntech_98765430')
            );
            $jsonDataEncoded = json_encode($jsonData);
            $this->curl->create($url);
            $this->curl->option(CURLOPT_HTTPHEADER, array('Content-type: application/json; Charset=UTF-8'));
            $this->curl->post($jsonDataEncoded);
            $result = $this->curl->execute();
            //echo $jsonDataEncoded; 
            //echo $result;
            if($result!='error'){
                $row['campaign_name']=$campaign_name;
                $row['add_date']=$add_date;
                $row['message']=$message;
                $row['message_qty']=$sms_count;
                $row['total_sms']=$sum_total_sms;
                $row['unit_price']=$unit_price;
                $row['total_price']=$sum_total_price;
                $row['dtt_add']=$dtt_add;
                $row['uid_add']=$uid_add;
                $paernt_id=$this->campaign_model->common_insert('sms_campaign', $row);
                for($i=0; $i<count($audience_name);$i++){
                    $data['campaign_id']=$paernt_id;
                    $data['set_person_id']=$audience_name[$i];
                    $this->campaign_model->common_insert('sms_campaign_person', $data);
                }
                
                //$cam['set_person_id']=$audience_name[$i];
                $dataArray=json_decode($result);
                // foreach ($dataArray['SMSINFO'] as  $value) {
                //     print_r($value);
                //     # code...
                // }
                if($dataArray->PARAMETER=='OK'){
                    foreach ($dataArray->SMSINFO as  $value) {
                        $status_title='Success';
                        $status=1;
                        if(isset($value->MSISDNSTATUS)){
                            $status_title=$value->MSISDNSTATUS;
                            $status=2;
                        }
                        $cam['campaign_id']=$paernt_id;
                        $cam['phone']=$value->MSISDN;
                        $cam['status_title']=$status_title;
                        $cam['status']=$status;
                        $this->campaign_model->common_insert('sms_campaign_details', $cam);
                    }
                    echo $paernt_id;
                }else{
                    echo 'error';
                }
                //print_r($dataArray);
                //echo $dataArray->PARAMETER;


            }
            //End Curl post data
        //}
        //pa($customer);

        // $massage = 'Successfully data added..';
        // if($paernt_id){
        //     echo json_encode(array("status" => "success", "message" => $massage));
        // }else{
        //     echo json_encode(array("status" => "error", "message" => 'Error in insert data'));
        // }
        
    }


    

    public function show_details($id = null)
    {
        $data['posts'] = $this->campaign_model->getDetailsById($id);
        $this->load->view('campaign/details_data', $data, false);
    }
    public function success($id = null)
    {
        $data = array();
        $this->dynamic_menu->check_menu('sms/campaign');
        $this->breadcrumb->add(lang('campaign_list'), 'sms/campaign', 1);
        $this->breadcrumb->add('SMS List', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['posts'] = $this->campaign_model->getSmsListById($id);
         $this->template->load('main', 'campaign/sms_list', $data);
    }
    public function view_details($id = null)
    {
        $data = array();
        $this->dynamic_menu->check_menu('sms/campaign');
        $this->breadcrumb->add(lang('campaign_list'), 'sms/campaign', 1);
        $this->breadcrumb->add('SMS List', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['posts'] = $this->campaign_model->getSmsListById($id);
         $this->template->load('main', 'campaign/sms_list', $data);
    }

    

}
