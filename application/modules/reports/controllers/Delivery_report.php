<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('delivery_report_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('delivery_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->sell_report_model->getRowsProducts());
        $data['customers']=$this->delivery_report_model->getvalue_row_array('customers','id_customer,phone,customer_code,full_name as customer_name',array('status_id'=>1));
        $data['salesPersons'] = $this->delivery_report_model->getSales_person_list();
        $this->template->load('main', 'delivery_report/index', $data);
    }


    public function paginate_data($page = 0)
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $delivery_type = $this->input->post('delivery_type');
        $person_list = $this->input->post('person_list');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $ref_no = $this->input->post('ref_no');
        $status = $this->input->post('status');
        $customer_id = $this->input->post('customer_id');
        $invoice_no = $this->input->post('invoice_no');
        $note = $this->input->post('note');
        $sales_person = $this->input->post('sales_person');
        if ($sales_person!= 0 ) {
            $conditions['search']['sales_person'] = $sales_person;
        }
        if (!empty($note)) {
            $conditions['search']['note'] = $note;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($status)) {
            $conditions['search']['status'] = $status;
        }
        if (!empty($ref_no)) {
            $conditions['search']['ref_no'] = $ref_no;
        }
        if (!empty($delivery_type)) {
            $conditions['search']['delivery_type'] = $delivery_type;
        }
        if (!empty($person_list)) {
            $conditions['search']['person_name'] = $person_list;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }

        
        $row = $this->delivery_report_model->getOrderData($conditions);
        $totalRec = ($row!='')?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'delivery-report/page-data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['posts'] = $this->delivery_report_model->getOrderData($conditions);
        //load the view
        $this->load->view('delivery_report/all_report_data', $data, false);
    }
    public function create_csv_data()
    {
        $conditions = array();
        $delivery_type = $this->input->post('delivery_type');
        $person_list = $this->input->post('person_list');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $ref_no = $this->input->post('ref_no');
        $status = $this->input->post('status');
        $customer_id = $this->input->post('customer_id');
        $invoice_no = $this->input->post('invoice_no');
        $note = $this->input->post('note');
        $sales_person = $this->input->post('sales_person');
        if ($sales_person!= 0 ) {
            $conditions['search']['sales_person'] = $sales_person;
        }
        if (!empty($note)) {
            $conditions['search']['note'] = $note;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($status)) {
            $conditions['search']['status'] = $status;
        }
        if (!empty($ref_no)) {
            $conditions['search']['ref_no'] = $ref_no;
        }
        if (!empty($delivery_type)) {
            $conditions['search']['delivery_type'] = $delivery_type;
        }
        if (!empty($person_list)) {
            $conditions['search']['person_name'] = $person_list;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $posts = $this->delivery_report_model->getOrderData($conditions);
        $fields = array(
            'sl' => 'SL'
        , 'date' => 'Date'
        , 'invoice_no' => 'Invoice No'
        , 'delivery_type' => 'Delivery Type'
        , 'agent_name' => 'Agent Name'
        , 'reference_number' => 'Reference Number'
        , 'customer_info' => 'Customer Info'
        , 'note' => 'Note'
        , 'invoice_amount' => 'Invoice Amount'
        , 'invoice_paid' => 'Invoice Paid'
        , 'service_price' => 'Service Price'
        , 'paid_amount' => 'Paid Amount'
        , 'status' => 'status'
        
        );
        $invoice_total = $due_total = $cash_total = $bank_total = $mobile_total = 0;
        $total_sale_amt=0;
        $total_sale_paid=0;
        $total_amt=0;
        $total_paid=0;
        if ($posts != '') {
            $count = 1;
            $order_status=$this->config->item('order_status');
            foreach ($posts as $post){
                $ttt=($post['type_id']==2)?'Agent':'Staf';
                $person=($post['type_id']==2)?$post['agent_name']:'Self';
                $value[] = array(
                    'sl' => $count
                , 'date' => nice_date($post['dtt_add'])
                , 'invoice_no' => $post['invoice_no']
                , 'delivery_type' =>$ttt.' ('. $post['delivery_name'] .')'
                , 'agent_name' => $person
                , 'reference_number' => $post['reference_num']
                , 'customer_info' => $post['customer_code'].' '.$post['customer_name'] .' ('.$post['customer_phone']. ')'
                , 'note' => $post['notes']
                , 'invoice_amount' => $post['sale_amt']
                , 'invoice_paid' => $post['sale_paid']
                , 'service_price' => $post['tot_amt']
                , 'paid_amount' => $post['paid_amt']
                , 'status' => $order_status[$post['order_status']]
                );
                $total_sale_amt+=$post['sale_amt'];
                $total_sale_paid+=$post['sale_paid'];
                $total_amt+=$post['tot_amt'];
                $total_paid+=$post['paid_amt'];
                $count++;
            }
            $value[] = array(
                'sl' => ''
            , 'date' => ''
            , 'invoice_no' => ''
            , 'delivery_type' =>''
            , 'agent_name' => ''
            , 'reference_number' => ''
            , 'customer_info' => ''
            , 'note' => 'Total:'
            , 'invoice_amount' => $total_sale_amt
            , 'invoice_paid' => $total_sale_paid
            , 'service_price' =>$total_amt
            , 'paid_amount' => $total_paid
            , 'status' => ''

            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'delivery_report'
        , 'file_title' => 'Delivery Report'
        , 'field_title' => $fields
        , 'field_data' => $value
        , 'from' => $FromDate
        , 'to' => $ToDate
        );
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
