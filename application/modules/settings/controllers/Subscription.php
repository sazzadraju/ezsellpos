<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }
        $this->load->model('Subscription_model');
        //$this->perPage = 20;
        $this->form_validation->CI =& $this;
    }
    
    
    ## http://localhost/pos01/subscription-renew/pay-confirm/successed
    ## http://localhost/pos01/subscription-renew/pay-confirm/failed
    ## http://localhost/pos01/subscription-renew/pay-confirm/cancelled
    public function pay_confirm($status) {
        $this->config->load('config_api');
        $data = [];
        $data['status'] = $status;
        
        $client_id = $this->Subscription_model->getClientId();

//        if($this->input->server('REQUEST_METHOD') == 'POST'){
//            $sts = $this->commonlib->apiRequest(
//                $this->config->item('api_base_url').'/sms/save_payment_log',
//                [
//                    'notes'             => 'subscription renew attempt for client-id:'.$client_id,
//                    'invoice_status'    => $status,
//                    'response_text'     => json_encode($_POST),
//                    'dtt_add'           => date('Y-m-d H:i:s')
//                ],
//                'post'
//            );
//        }
//        if ($this->session->userdata('login_info')!="") {
//            $data['profile_img']=$this->session->userdata['login_info']['store_img'];
//        }else{
//            $img = $this->commonmodel->getvalue_row_one('stores','store_img',array('id_store'=>1));
//            $data['profile_img']=$img[0]['store_img'];
//        }
//        $data['client_id'] = $client_id;
//        $tmp = $this->commonlib->apiRequest($this->config->item('api_base_url').'/sms/client_subscription_info/' . $client_id);
//        $tmp = json_decode($tmp, true);
//        $data['subscription_data'] = isset($tmp['response']) ? $tmp['response'] : false;
        
        switch($status){
            case 'successed':
                // UPDATE SUBSCRIPTION STATUS
                //$this->_updSubsInfo($data);
                $data['message'] = 'ACCOUNT CREATED SUCCESSFULLY';
                $data['message_details'] = 'Payment confirmed.';
                break;
                
            case 'failed':
                $data['message'] = 'PAYMENT FAILED';
                $data['message_details'] = 'Please try to pay again.';
                break;
            
            case 'cancelled':
                $data['message'] = 'PAYMENT CANCLED';
                $data['message_details'] = 'Please try to pay again.';
                break;

            default:
                $data['message'] = 'SOMETHING WENT WRONG';
                $data['message_details'] = 'Please try to pay again.';
                break;
        }

        if ($this->session->userdata('login_info')!="") {
            $this->template->load('main', 'subscription/pay_confirm', $data);
        } else {
            $this->template->load('subscription_layout', 'subscription/pay_confirm', $data);
        }



    }
    
    private function _updSubsInfo($raw_data=array()){
        
        // converts into single dimension array
        $data = $raw_data['subscription_data'];
        $data['status'] = $raw_data['status'];
        $data['client_id'] = $raw_data['client_id'];
        
        // update store db config table
        $this->Subscription_model->updSubsInfo($data);
        
        // update smsdb
        $this->commonlib->apiRequest($this->config->item('api_base_url').'/sms/upd_subs_info', $data, 'post');
        
        // TODO :: send invoice mail
    }
}