<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vat_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('vat_report_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('vat-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->vat_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->vat_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        //$data['posts'] = $this->vat_report_model->getRowsProducts(array('limit' => $this->perPage));
        $this->template->load('main', 'vat_report/index', $data);
    }


    public function getMaxNumber()
    {
        $this->load->database();
        $this->db->select('max(product_code) as code');
        $result = $this->db->get('products')->row();
        $code = ($result->code) + 1;
        echo $code;
    }


    public function paginate_data($page = 0)
    {
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $vat_type = $this->input->post('vat_type');
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }

        $row = $this->vat_report_model->getRowsProducts($conditions);
        $totalRec = ($row)?count($row):0;

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['store'] = $this->vat_report_model->getvalue_row('stores', 'id_store,store_name', array());

        $data['posts'] = $this->vat_report_model->getRowsProducts($conditions);

        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['which_store'] = $store_id;
        if($vat_type == 1){
            $this->load->view('vat_report/all_list_with_nonvat', $data, false);
        }else{
            $this->load->view('vat_report/all_list_without_nonvat', $data, false);
        }
        
    }

    public function print_data($page = 0)
    {
        $conditions = array();
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $vat_type = $this->input->post('vat_type');
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['store'] = $this->vat_report_model->getvalue_row('stores', 'id_store,store_name', array());
        $data['posts'] = $this->vat_report_model->getRowsProducts($conditions);
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['which_store'] = $store_id;
        if($vat_type==1){
            $data3['report']=$this->load->view('vat_report/all_list_with_nonvat', $data, true);
        }else{
            $data3['report']=$this->load->view('vat_report/all_list_without_nonvat', $data, true);
        }
        $data3['title']='Vat Reports';
        
        $this->load->view('print_page', $data3, false);
    }
}
