<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_points extends MX_Controller {

    function __construct() {
        parent::__construct();
        // $this->load->library('form_validation');
        $this->form_validation->CI = & $this;
        if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->perPage = 20;

        $this->load->model('Customer_model');
    }

    //**Customer Settings::Customer Type Start**//
    public function index() {
        $data = array();
        $this->dynamic_menu->check_menu('customer/points');
        $this->breadcrumb->add('Customers', 'customer', 1);
        $this->breadcrumb->add('Customer Points', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['earn_ratio'] = $this->Customer_model->getvalue_row_one('configs', 'param_val', array('param_key'=>'POINT_EARN_RATIO'));
        $data['redeem_ratio'] = $this->Customer_model->getvalue_row_one('configs', 'param_val', array('param_key'=>'POINT_REDEEM_RATIO'));
        $data['posts'] = $this->Customer_model->all_customer_type_list(array('limit' => $this->perPage));
        $this->template->load('main', 'customer/customer_points', $data);
    }
    public function earn_points(){
       // $id = $this->input->post('id');
        //$data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['param_val'] = $this->input->post('id');
        $this->Customer_model->update_value('configs', $data, array('param_key'=>'POINT_EARN_RATIO'));
        echo json_encode(array("status" => "success", "message" => lang('update_success')));
    }
    public function redeem_points(){
        // $id = $this->input->post('id');
        //$data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['param_val'] = $this->input->post('id');
        $this->Customer_model->update_value('configs', $data, array('param_key'=>'POINT_REDEEM_RATIO'));
        echo json_encode(array("status" => "success", "message" => lang('update_success')));
    }












    //**Customer Settings::Customer End**//
}
