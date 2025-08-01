<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chalan extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }
        $this->form_validation->CI = &$this;
        $this->load->model('auto_increment');
        $this->load->model('sales_model');
        $this->load->model('common_model');
        $this->perPage = 20;
    }

    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('chalan');
        $this->breadcrumb->add(lang('chalan'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $store_m = $this->session->userdata['login_info']['store_id'];
        $data['store_name_p'] = $this->session->userdata['login_info']['store_id'];
        $data['station_name_p'] = $this->session->userdata['login_info']['station_id'];
        $this->template->load('main', 'chalan/index', $data);
    }
    public function temp_add_print_chalan(){
        $data=array();
        $invoice = $this->input->post('invoice');
        $store_id=$this->session->userdata['login_info']['store_id'];
        $data['sales'] = $this->sales_model->getvalue_row_one('sales', 'customer_id,id_sale', array('invoice_no' => $invoice,'store_id'=>$store_id));
        if ($data['sales']) {
            $saleId = $data['sales'][0]['id_sale'];
            $data['customer_id'] = $data['sales'][0]['customer_id'];
            $data['products'] = $this->commonmodel->getvalue_sale_details($saleId);
            $data['posts'] = $this->sales_model->get_customer_address($data['customer_id']);
        }
        $this->load->view('chalan/chalan_product_list', $data);
    }
    public function show_preview_chalan(){

    }



}
