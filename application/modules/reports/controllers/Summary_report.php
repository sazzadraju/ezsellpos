<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Summary_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('summary_report_model');
        //$this->load->model('../../sales_settings/models/sales_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('summary_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->summary_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->summary_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $this->template->load('main', 'summary_report/index', $data);
    }


    public function paginate_data($page = 0)
    {
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $data['offset']=$offset;
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $conditions['store_id'] = $store_id;
        $conditions['FromDate'] = $FromDate . ' 00:00:00';
        $conditions['ToDate'] = $ToDate . ' 23:59:59';
        $data['fdate']=$FromDate;
        $data['tdate']=$ToDate;
        $data['store']=$store_id;
        $data['sales'] = $this->summary_report_model->getSummarySales($conditions);
        $data['saleReturns'] = $this->summary_report_model->getSummarySaleReturns($conditions);
        $data['suppliers'] = $this->summary_report_model->getSummarySuppliers($conditions);
        $data['office'] = $this->summary_report_model->getSummaryOffice($conditions);
        $data['employees'] = $this->summary_report_model->getSummaryEmployee($conditions);
        $data['investors'] = $this->summary_report_model->getSummaryInvestor($conditions);
        $this->load->view('summary_report/all_report_data', $data, false);
    }
    public function print_data($page = 0) {
        $conditions = array();
         
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
       
         $data['offset']=$offset;
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $conditions['store_id'] = $store_id;
        $conditions['FromDate'] = $FromDate . ' 00:00:00';
        $conditions['ToDate'] = $ToDate . ' 23:59:59';
        $stores = $this->summary_report_model->getvalue_row('stores', 'store_name', array('status_id' => 1, 'id_store' => $store_id));
        $data['title']='Summary Report ('.$stores[0]->store_name.')';
        $data['fdate']=$FromDate;
        $data['tdate']=$ToDate;
        $data['store']=$store_id;
        
        $data['sales'] = $this->summary_report_model->getSummarySales($conditions);
        $data['saleReturns'] = $this->summary_report_model->getSummarySaleReturns($conditions);
        $data['suppliers'] = $this->summary_report_model->getSummarySuppliers($conditions);
        $data['office'] = $this->summary_report_model->getSummaryOffice($conditions);
        $data['employees'] = $this->summary_report_model->getSummaryEmployee($conditions);
        $data['investors'] = $this->summary_report_model->getSummaryInvestor($conditions);
        $data3['report']=$this->load->view('summary_report/all_report_print_data', $data, true);
        $this->load->view('print_page', $data3, false);
    // }
    }
    public function summary_details($type,$name){
        $f_date=$this->input->get('fdate');
        $t_date=$this->input->get('tdate');
        $store_id=$this->input->get('store');
        $type = strtolower($type);
        $name = strtolower($name);
        $data['f_date']=$f_date;
        $data['t_date']=$t_date;
        $data['store_id']=$store_id;
        $data['name']=$name;
        if($type=='sales'){
            $this->sale_details_data($data);
        }else if($type=='supplier'){
            $this->supplier_details_data($data);
        }else if($type=='office'){
            $this->office_details_data($data);
        }else if($type=='employee'){
            $this->employee_details_data($data);
        }else if($type=='investor'){
            $this->investor_details_data($data);
        }
        
    }
    function sale_details_data($data){
        $data3['fdate'] = $data['f_date'];
        $data3['tdate'] = $data['t_date'];
        if($data['name']=='entry'){
            $data3['title'] = 'Sale Details Report';
            $data['posts'] = $this->summary_report_model->getSaleDetails($data);
            $data3['report']=$this->load->view('summary_report/sale_details_data', $data, true);
            $this->load->view('print_page', $data3, false);
        }else if($data['name']=='return'){
            $data3['title'] = 'Sale Return Report';
            $data['posts'] = $this->summary_report_model->getSaleReturnDetails($data);
            $data3['report']=$this->load->view('summary_report/sale_return_data', $data, true);
            $this->load->view('print_page', $data3, false);
        }else{
            $this->load->view('summary_report/no_data');
        }
    }
    function supplier_details_data($data){
        $data3['fdate'] = $data['f_date'];
        $data3['tdate'] = $data['t_date'];
        if($data['name']==1||$data['name']==107||$data['name']==108){
            $data3['title'] = 'Supplier Transaction Report';
            $data['posts'] = $this->summary_report_model->getSupplierDetails($data);
            $data3['report']=$this->load->view('summary_report/supplier_details_data', $data, true);
            $this->load->view('print_page', $data3, false);
        }else{
            $this->load->view('summary_report/no_data');
        }
    }
    function office_details_data($data){
        $data3['fdate'] = $data['f_date'];
        $data3['tdate'] = $data['t_date'];
        if($data['name']=='expense'||$data['name']=='income'){
            $data['name']=($data['name']=='income')?1:-1;
            $data3['title'] = 'Office Transaction Report';
            $data['posts'] = $this->summary_report_model->getOfficeDetails($data);
            $data3['report']=$this->load->view('summary_report/office_details_data', $data, true);
            $this->load->view('print_page', $data3, false);
        }else{
            $this->load->view('summary_report/no_data');
        }
    }
    function employee_details_data($data){
        $data3['fdate'] = $data['f_date'];
        $data3['tdate'] = $data['t_date'];
        if($data['name']=='return'||$data['name']=='payment'){
            $data['name']=($data['name']=='return')?1:-1;
            $data3['title'] = 'Employee Transaction Report';
            $data['posts'] = $this->summary_report_model->getEmployeeDetails($data);
            $data3['report']=$this->load->view('summary_report/employee_details_data', $data, true);
            $this->load->view('print_page', $data3, false);
        }else{
            $this->load->view('summary_report/no_data');
        }
    }
    function investor_details_data($data){
        $data3['fdate'] = $data['f_date'];
        $data3['tdate'] = $data['t_date'];
        if($data['name']=='invest'||$data['name']=='invest_withdraw'||$data['name']=='profit_withdraw'){
            if($data['name']=='invest')$data['name']='1';
            if($data['name']=='invest_withdraw')$data['name']='-1';
            if($data['name']=='profit_withdraw')$data['name']='0';
            $data3['title'] = 'Employee Transaction Report';
            $data['posts'] = $this->summary_report_model->getInvestorDetails($data);
            $data3['report']=$this->load->view('summary_report/investor_details_data', $data, true);
            $this->load->view('print_page', $data3, false);
        }else{
            $this->load->view('summary_report/no_data');
        }
    }
    


}
