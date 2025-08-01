<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_receivable_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('customer_receivable_report_model');
        $this->perPage = 5000;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('customer-receivable-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['customers'] = $this->customer_receivable_report_model->getvalue_row('customers', 'id_customer,full_name,phone', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->customer_receivable_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->customer_receivable_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $this->template->load('main', 'customer_receivable_report/index', $data);
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
        $customer_id = $this->input->post('customer_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $report_type = $this->input->post('report_type');
        $type_data = $this->input->post('type_data');
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        if($report_type=='customer'){
            $row = $this->customer_receivable_report_model->getCustomerReceivableReport($conditions);
        }else{
            $conditions['search']['type_data'] = $type_data;
            $row = $this->customer_receivable_report_model->getcustomerReportByInvoice($conditions);
        }
        $totalRec = ($row != '')?count($row):0;
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        if($report_type=='customer'){
            $data['posts'] = $this->customer_receivable_report_model->getCustomerReceivableReport($conditions);
            $this->load->view('customer_receivable_report/all_report_data', $data, false);
         }else{
            $data['posts'] = $this->customer_receivable_report_model->getcustomerReportByInvoice($conditions);
            $this->load->view('customer_receivable_report/all_report_invoice_data', $data, false);
         }
    }

    public function print_data($page = 0)
    {
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $store_id = $this->input->post('store_id');
        $customer_id = $this->input->post('customer_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $report_type = $this->input->post('report_type');
        $type_data = $this->input->post('type_data');
        $conditions['search']['type_data'] = $type_data;
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Customer Receivable Report';
        if($report_type=='customer'){
            $data['posts'] = $this->customer_receivable_report_model->getCustomerReceivableReport($conditions);
            $data3['report']=$this->load->view('customer_receivable_report/all_report_data', $data, true);
        }else{
            $data['posts'] = $this->customer_receivable_report_model->getcustomerReportByInvoice($conditions);
            $data3['report']=$this->load->view('customer_receivable_report/all_report_invoice_data', $data, true);
        }
        $this->load->view('print_page', $data3, false);
    }
    public function get_station_name(){
        $store_id= $this->input->post('store_id');
        $data['station_id'] = $this->commonmodel->getvalue_row('stations', 'id_station,name', array('store_id'=> $store_id,'status_id' => 1));
        echo '<option value="" disable>Select One</option>';
        foreach ($data['station_id'] as $station){
            echo '<option value="'. $station->id_station . '">' .$station->name. '</option>';
        }
    }
    public function create_csv_data()
    {
        $conditions = array();
        $store_id = $this->input->post('store_id');
        $customer_id = $this->input->post('customer_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $report_type = $this->input->post('report_type');
        $type_data = $this->input->post('type_data');
        $conditions['search']['type_data'] = $type_data;
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $store = $this->customer_receivable_report_model->getvalue_row('stores', 'id_store,store_name', array());
        if($report_type=='customer'){
            $posts= $this->customer_receivable_report_model->getCustomerReceivableReport($conditions);
            $fields = array(
                'customer_name' => 'Customer Name'
                , 'store' => 'Store Name'
                , 'invoice_amount' => 'Invoice Amount'
                , 'paid_amt' => 'Paid Amount'
                , 'dues' => 'Due Amount'
            );
            $tot_due=0;
            $tot_paid=0;
            $tot_amount=0;
            if ($posts != '') {
                $count = 1;
                foreach ($posts as $post) {
                    $tot_due=$tot_due+ $post['due_amt'];
                    $tot_paid=$tot_paid+ $post['paid_amt'];
                    $tot_amount=$tot_amount+ $post['tot_amt'];
                    $value[] = array(
                        'customer_name' => $post['customer_name']
                        , 'store' => $post['store_name']
                        , 'invoice_amount' => $post['tot_amt']
                        , 'paid_amt' => $post['paid_amt']
                        , 'dues' => $post['due_amt']
                    );
                    $count++;
                }
                $value[] = array(
                    'customer_name' => ''
                    , 'store' => 'Total'
                    , 'invoice_amount' => $tot_amount
                    , 'paid_amt' => $tot_paid
                    , 'dues' => $tot_due
                );
            }else{
                $value='';
            }
            $dataArray = array(
                'file_name' => 'customer_receivable_report'
                , 'file_title' => 'Customer Receivable Report'
                , 'field_title' => $fields
                , 'field_data' => $value
                , 'from' => $FromDate
                , 'to' => $ToDate
            );
        
        }else{
            $posts = $this->customer_receivable_report_model->getcustomerReportByInvoice($conditions);
            $fields = array(
                'date' => 'Date'
                , 'invoice_no' => 'Invoice No'
                , 'customer_name' => 'Customer Name'
                , 'store' => 'Store Name'
                , 'invoice_amount' => 'Invoice Amount'
                , 'paid_amt' => 'Paid Amount'
                , 'dues' => 'Due Amount'
                , 'settle' => 'Settle Amount'
            );
            $tot_due=0;
            $tot_paid=0;
            $tot_amount=0;
            $total_settle=0;
            if ($posts != '') {
                $count = 1;
                foreach ($posts as $post) {
                    $tot_paid=$tot_paid+ $post['paid_amt'];
                    $tot_amount=$tot_amount+ $post['tot_amt'];
                    $settle=0;
                    $due=0;
                    if($post['settle']==1){
                        $total_settle+=$post['due_amt'];
                        $settle=$post['due_amt'];
                    }else{  
                        $tot_due+=$post['due_amt'];
                        $due=$post['due_amt'];
                    }
                    $value[] = array(
                        'date' => nice_date($post['dtt_add'])
                        ,'invoice_no' => $post['invoice_no']
                        ,'customer_name' => $post['customer_name']
                        , 'store' => $post['store_name']
                        , 'invoice_amount' => $post['tot_amt']
                        , 'paid_amt' => $post['paid_amt']
                        , 'dues' => $due
                        , 'settle' => $settle
                    );
                    $count++;
                }
                $value[] = array(
                    'date' => ''
                    ,'invoice_no' => ''
                    ,'customer_name' => ''
                    , 'store' => 'Total'
                    , 'invoice_amount' => $tot_amount
                    , 'paid_amt' => $tot_paid
                    , 'dues' => $tot_due
                    , 'settle' => $total_settle
                );
            }else{
                $value='';
            }
            $dataArray = array(
                'file_name' => 'customer_receivable_report'
                , 'file_title' => 'Customer Receivable Report Invoice View'
                , 'field_title' => $fields
                , 'field_data' => $value
                , 'from' => $FromDate
                , 'to' => $ToDate
            );
        }
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


}
