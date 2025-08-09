<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sell_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('sell_report_model');
        $this->load->model('../../sales_settings/models/sales_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('sell_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->sell_report_model->getRowsProducts());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'sell_report/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        $data['customers'] = $this->sell_report_model->getvalue_row('customers', 'id_customer,full_name,phone', array('status_id' => 1));
        $data['customer_types'] = $this->sell_report_model->getvalue_row('customer_types', 'id_customer_type,name', array('status_id' => 1));
        $data['stations'] = $this->sell_report_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->sell_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->sell_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['posts'] = $this->sell_report_model->getRowsProducts(array('limit' => $this->perPage));
        $data['persons'] = $this->sell_report_model->getSoldByList();
        $data['salesPersons'] = $this->sell_report_model->getSales_person_list();
        $this->template->load('main', 'sell_report/index', $data);
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
        $invoice_no = $this->input->post('invoice_no');
        $station_id = $this->input->post('station_id');
        $store_id = $this->input->post('store_id');
        $customer_id = $this->input->post('customer_id');
        $ToDate = $this->input->post('ToDate');
        $type = $this->input->post('type');
        $FromDate = $this->input->post('FromDate');
        $sold_by = $this->input->post('sold_by');
        $sales_person = $this->input->post('sales_person');
        $gift_sale = $this->input->post('gift_sale');
        if ($gift_sale!= 0 ) {
            $conditions['search']['gift_sale'] = $gift_sale;
        }
        if (!empty($sold_by)) {
            $conditions['search']['sold_by'] = $sold_by;
        }
        if ($sales_person!= 0 ) {
            $conditions['search']['sales_person'] = $sales_person;
        }

        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($station_id)) {
            $conditions['search']['station_id'] = $station_id;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($type)) {
            $conditions['search']['type'] = $type;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }

        $row =$this->sell_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
       // $data['invoice'] = $this->sell_report_model->get_invoice_amount($conditions);
        //$data['posts'] = $this->sell_report_model->getRowsProducts($conditions);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['posts'] = $this->sell_report_model->getRowsProducts($conditions);
        $this->load->view('sell_report/all_report_data', $data, false);
    }
    public function print_data($page = 0) {
        $conditions = array();
         
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
       
        $data['offset']=$offset;
        $invoice_no = $this->input->post('invoice_no');
        $station_id = $this->input->post('station_id');
        $store_id = $this->input->post('store_id');
        $customer_id = $this->input->post('customer_id');
        $ToDate = $this->input->post('ToDate');
        $type = $this->input->post('type');
        $FromDate = $this->input->post('FromDate');
        $sold_by = $this->input->post('sold_by');
        $sales_person = $this->input->post('sales_person');
        $gift_sale = $this->input->post('gift_sale');
        if ($gift_sale!= 0 ) {
            $conditions['search']['gift_sale'] = $gift_sale;
        }
        if (!empty($sold_by)) {
            $conditions['search']['sold_by'] = $sold_by;
        }
        if ($sales_person!= 0 ) {
            $conditions['search']['sales_person'] = $sales_person;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($station_id)) {
            $conditions['search']['station_id'] = $station_id;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($type)) {
            $conditions['search']['type'] = $type;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = '<h3>Sell Report<h3>';
        $data['which_store'] = $store_id;
        $data['posts'] = $this->sell_report_model->getRowsProducts($conditions);
        $data3['report']=$this->load->view('sell_report/all_print_data', $data, true);
        $this->load->view('print_page', $data3, false);
    // }
    }
    public function create_csv_data()
    {
        $conditions = array();
        $invoice_no = $this->input->post('invoice_no');
        $station_id = $this->input->post('station_id');
        $store_id = $this->input->post('store_id');
        $customer_id = $this->input->post('customer_id');
        $ToDate = $this->input->post('ToDate');
        $type = $this->input->post('type');
        $FromDate = $this->input->post('FromDate');
        $sold_by = $this->input->post('sold_by');
        $sales_person = $this->input->post('sales_person');
        $gift_sale = $this->input->post('gift_sale');
        if ($gift_sale!= 0 ) {
            $conditions['search']['gift_sale'] = $gift_sale;
        }
        if ($sold_by!= 0) {
            $conditions['search']['sold_by'] = $sold_by;
        }
        if ($sales_person!= 0 ) {
            $conditions['search']['sales_person'] = $sales_person;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($station_id)) {
            $conditions['search']['station_id'] = $station_id;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($type)) {
            $conditions['search']['type'] = $type;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $posts = $this->sell_report_model->getRowsProducts($conditions);
        $fields = array(
            'sl' => 'SL'
        , 'invoice_no' => 'Invoice No'
        , 'sold_date' => 'Sold Date'
        , 'sold_by' => 'Sold By'
        , 'sales_person' => 'Sales Person'
        , 'customer_name' => 'Customer Name'
        , 'type' => 'Type'
        , 'station_name' => 'Station Name'
        , 'store_name' => 'Store Name'
        , 'invoice_amount' => 'Invoice Amount'
        , 'discount_amount' => 'Discount Amount'
        , 'sale_price' => 'Sale Price'
        , 'cash' => 'Cash'
        , 'bank' => 'Bank'
        , 'mobile' => 'Mobile'
        , 'due_amount' => 'Due Amount'
        , 'sattle_amount' => 'Sattle Amount'
        , 'notes' => 'Note'
        );
        $invoice_total = $due_total = $cash_total = $bank_total = $mobile_total =$total_discount = $product_total = 0;
        $total_settle=0;
        if ($posts != '') {
            $count = 1;
            $total_settle=0;
            foreach ($posts as $post) {
                $transactions = $this->commonmodel->sale_transaction_details($post['id_sale']);
                $personId = $this->sales_model->getSalesPersonById($post['sales_person_id']);
                $sPersonName=($personId)?$personId[0]['user_name'].'('.$personId[0]['person_type'].')':'';
                $cash = $bank = $mobile = 0;
                foreach ($transactions as $tran) {
                    if ($tran['payment_method_id'] == 1) {
                        $cash += $tran['amount'];
                        $cash_total += $tran['amount'];
                    } elseif ($tran['payment_method_id'] == 3) {
                        $mobile += $tran['amount'];
                        $mobile_total += $tran['amount'];
                    } else {
                        $bank += $tran['amount'];
                        $bank_total += $tran['amount'];
                    }
                }
                $promotions = $this->sell_report_model->sale_promotion_list($post['id_sale']);
                $discount_list=0;
                if ($promotions) {
                    $i=1;
                    $promo = $this->config->item('promotion_type_sales');
                    foreach ($promotions as $promotion) {
                        $comma=($i==1)?'':', ';
                        $type = $promotion['promotion_type_id'];
                        //$discount_list=$discount_list.$comma.$promo[$type].'='.$promotion['discount_amt'];
                        $discount_list+=$promotion['discount_amt'];
                        $total_discount += $promotion['discount_amt'];
                        $i++;
                    }

                }
                //$invoice_total+=$post['tot_amt'];
                $settle=0;
                $due=0;
                if($post['settle']==1){
                    $total_settle+=$post['due_amt'];
                    $settle=$post['due_amt'];
                }else{
                    $due_total+=$post['due_amt'];
                    $due=$post['due_amt'];
                }
                $value[] = array(
                    'sl' => $count
                ,'invoice_no' => $post['invoice_no']
                , 'sold_date' => $post['dtt_add']
                , 'sold_by' => $post['user_name']
                , 'sales_person' => $sPersonName
                , 'customer_name' => $post['customer_name']
                , 'type' => $post['customer_type']
                , 'station_name' => $post['station_name']
                , 'store_name' => $post['store_name']
                , 'invoice_amount' => $post['product_amt']
                , 'discount_amount' => $discount_list
                , 'sale_price' => $post['tot_amt']
                , 'cash' => $cash
                , 'bank' => $bank
                , 'mobile' => $mobile
                , 'due_amount' => $due
                , 'sattle_amount' =>  $settle
                , 'notes' => $post['notes']

                );
                $count++;
                $product_total+=$post['product_amt'];
                $invoice_total+=$post['tot_amt'];
            }
            $value[] = array(
                'sl' => ''
            , 'invoice_no' => ''
            , 'sold_date' => ''
            , 'sold_by' => ''
            , 'sales_person' => ''
            , 'customer_name' => ''
            , 'type' => ''
            , 'station_name' => ''
            , 'store_name' => 'Total'
            , 'invoice_amount' => $product_total
            , 'discount_amount' => $total_discount
            , 'sale_price' => $invoice_total
            , 'cash' => $cash_total
            , 'bank' => $bank_total
            , 'mobile' => $mobile_total
            , 'due_amount' => $due_total
            , 'sattle_amount' => $total_settle
            , 'notes' => ''

            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'sale_invoice_report'
        , 'file_title' => 'Sale Invoice Report'
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
