<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_sms extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('api_sms_model');
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
            $this->api_sms_model->common_insert('sms_entry_log',$getData);
            $this->api_sms_model->update_sms($getData);
            echo 'success';
        }else{
            echo 'error';
        }
    }


    

}
