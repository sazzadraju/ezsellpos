<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CompanyInfo extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('setting_model');
        $this->load->model('Auth_model');
        $this->perPage = 20;
    }

    public function index() {
        $data = array();
        $this->dynamic_menu->check_menu('company-info');
        $this->breadcrumb->add(lang('company_info'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        //$totalRec = count($this->setting_model->getRowsUnits());

        $data['sms_configs'] = $this->setting_model->getvalue_row('sms_config', '*', array('status_id' => 1));
        $data['sales_configs'] = $this->setting_model->getvalue_row('configs', 'param_val', array('param_key' => 'SALES_CONFIG'));
        $data['columns'] = $this->setting_model->getvalue_row('acl_user_column', '*', array('status_id' => 1));
        $data['configs'] = $this->setting_model->getvalue_row('configs', 'param_key,param_val', array());
        $data['image'] = $this->setting_model->getvalue_row('stores', 'store_img', array('id_store'=>1));
        $data['vat'] = $this->setting_model->getvalue_row('configs', 'param_val', array('param_key' => 'VAT_REG_NO'));
        $data['invoice'] = $this->setting_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'INVOICE_SETUP'));
        $data['currency'] = $this->setting_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'CURRENCY'));
        $data['time_zone'] = $this->setting_model->getvalue_row('configs', 'param_val', array('param_key' => 'TIME_ZONE'));
        $data['zones'] = $this->setting_model->getvalue_row('timezones', '*', array());
        $this->template->load('main', 'companyInfo/index', $data);
    }
    public function edit_vat_reg_no() {
        $vat = $this->input->post('vat');
        $condition = array(
            'param_key' => 'VAT_REG_NO'
        );
        $data['param_val'] = $vat;
        $this->setting_model->update_value('configs', $data, $condition,FALSE);
        echo $vat;
        //echo json_encode(array("success" => TRUE, "data"=>$vat,"Message"=>''));
    }
    public function edit_default_vat() {
        $vat = $this->input->post('vat');
        $condition = array(
            'param_key' => 'DEFAULT_VAT'
        );
        $data['param_val'] = $vat;
        $this->setting_model->update_value('configs', $data, $condition,FALSE);
        echo $vat;
        //echo json_encode(array("success" => TRUE, "data"=>$vat,"Message"=>''));
    }
    public function full_invoice_setup(){
        $this->session->unset_userdata('subscription_info');
        $f_shop=$this->input->post('f_shop');
        $f_logo=$this->input->post('f_logo');
        $f_phone=$this->input->post('f_phone');
        $f_email=$this->input->post('f_email');
        $f_brand=$this->input->post('f_brand');
        $f_code=$this->input->post('f_code');
        $f_sub_cat=$this->input->post('f_sub_cat');
        $f_note_type=$this->input->post('f_note_type');
        $f_note=$this->input->post('f_note');
        $f_header=$this->input->post('f_header');
        $shop_name=(isset($f_shop))?$f_shop:'';
        $shop_logo=(isset($f_logo))?$f_logo:'';
        $phone=(isset($f_phone))?$f_phone:'';
        $email=(isset($f_email))?$f_email:'';
        $brand=(isset($f_brand))?$f_brand:'';
        $code=(isset($f_code))?$f_code:'';
        $header=(isset($f_header))?$f_header:'';
        $head_size=$this->input->post('head_size');
        $foot_size=$this->input->post('foot_size');
        $sub_cat=(isset($f_sub_cat))?$f_sub_cat:'';
        $note_type=(isset($f_note_type))?$f_note_type:'';
        $note=(isset($f_note))?$f_note:'';
        $arrayData=json_encode(
            array(
                'shop_name'=>$shop_name
                ,'shop_logo'=>$shop_logo
                ,'phone'=>$phone
                ,'email'=>$email
                ,'brand'=>$brand
                ,'code'=>$code
                ,'sub_cat'=>$sub_cat
                ,'note_type'=>$note_type
                ,'note'=>$note
                ,'header'=>$header
                ,'head_size'=>$head_size
                ,'foot_size'=>$foot_size
            )
        );
        $da=$this->setting_model->update_value('configs', array('param_val' => $arrayData), array('param_key' => 'INVOICE_SETUP'),FALSE);
        if($da){
            $SubscriptionInfo = $this->Auth_model->subscription_check();
            $session_data = $this->session->userdata('login_info');
            $session_data['subscription_info'] = $SubscriptionInfo;
            $this->session->set_userdata("login_info", $session_data);
            echo '1';
        }else{
            echo '2';
        }
    }
    public function thermal_invoice_setup(){
        $this->session->unset_userdata('subscription_info');
        $t_shop=$this->input->post('t_shop');
        $t_logo=$this->input->post('t_logo');
        $t_phone=$this->input->post('t_phone');
        $t_email=$this->input->post('t_email');
        $t_brand=$this->input->post('t_brand');
        $t_code=$this->input->post('t_code');
        $t_note_type=$this->input->post('t_note_type');
        $t_note=$this->input->post('t_note');
        $shop_name=(isset($t_shop))?$t_shop:'';
        $shop_logo=(isset($t_logo))?$t_logo:'';
        $phone=(isset($t_phone))?$t_phone:'';
        $email=(isset($t_email))?$t_email:'';
        $code=(isset($t_code))?$t_code:'';
        $brand=(isset($t_brand))?$t_brand:'';
        $note=(isset($t_note))?$t_note:'';
        $note_type=(isset($t_note_type))?$t_note_type:'';
        $arrayData=json_encode(
            array(
                'shop_name'=>$shop_name
                ,'shop_logo'=>$shop_logo
                ,'phone'=>$phone
                ,'email'=>$email
                ,'brand'=>$brand
                ,'code'=>$code
                ,'note_type'=>$note_type
                ,'note'=>$note
            )
        );
        $da=$this->setting_model->update_value('configs', array('utilized_val' => $arrayData), array('param_key' => 'INVOICE_SETUP'),FALSE);
        if($da){
            $SubscriptionInfo = $this->Auth_model->subscription_check();
            $session_data = $this->session->userdata('login_info');
            $session_data['subscription_info'] = $SubscriptionInfo;
            $this->session->set_userdata("login_info", $session_data);
            echo '1';
        }else{
            echo '2';
        }
    }
    public function permission_setup(){
        $id_column=$this->input->post('id_column');
        for ($i=0; $i <count($id_column) ; $i++) { 
            $id=$id_column[$i];
            $permission=$this->input->post('permission_'.$id);
            $da=$this->setting_model->update_value('acl_user_column', array('permission' =>$permission), array('id_acl_user_column' => $id),FALSE);
        }
        if($da){
            echo '1';
        }else{
            echo '2';
        }
    }
    public function sms_config_setup(){
        $id_column=$this->input->post('id_column');
        for ($i=0; $i <count($id_column) ; $i++) { 
            $id=$id_column[$i];
            $sms_send=$this->input->post('sms_send_'.$id);
            $admin_phone=$this->input->post('admin_phone_'.$id);
            $da=$this->setting_model->update_value('sms_config', array('sms_send' =>$sms_send,'sms_phone' =>$admin_phone), array('id_sms_config' => $id),FALSE);
        }
        if($da){
            echo '1';
        }else{
            echo '2';
        }
    }


    public function update_info(){
        $vat = $this->input->post('vat');
        $position = $this->input->post('position');
        $cur_name = $this->input->post('cur_name');
        $time_zone = $this->input->post('time_zone');
        $this->setting_model->update_value('configs', array('param_val' => $vat), array('param_key' => 'DEFAULT_VAT'),FALSE);
        $this->setting_model->update_value('configs', array('param_val' => $cur_name,'utilized_val'=>$position), array('param_key' => 'CURRENCY'),FALSE);
        $this->setting_model->update_value('configs', array('param_val' => $time_zone), array('param_key' => 'TIME_ZONE'),FALSE);
        // echo $time_zone.$vat.$position.$cur_name;
        echo 'success';
    }
    public function sales_permission(){
        //pa($_POST);
        $empty_customer = $this->input->post('empty_customer');
        $price = $this->input->post('price');
        $discount = $this->input->post('discount');
        $discount_invoice = $this->input->post('discount_invoice');
        $round_option = $this->input->post('round_option');
        $array=array(
            'empty_customer'=>$empty_customer
            ,'price'=>$price
            ,'discount'=>$discount
            ,'discount_invoice'=>$discount_invoice
            ,'round'=>$round_option
            );
        $data=json_encode($array);
        $this->setting_model->update_value('configs', array('param_val' => $data), array('param_key' => 'SALES_CONFIG'),FALSE);
        echo 1;
    }
    
    public function s3_create_bucket(){
        echo 'session: ';
        //pa($this->session->userdata);
        pa($this->session->all_userdata());
    }
}
