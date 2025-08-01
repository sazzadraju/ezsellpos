<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_transaction_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('customer_transaction_report_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('customer-transaction-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();

        $data['customers'] = $this->customer_transaction_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->customer_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->customer_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $this->template->load('main', 'customer_transaction_report/index', $data);
    }


    public function paginate_data($page = 0)
    {
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $transaction_no = $this->input->post('transaction_no');
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $invoice_no = $this->input->post('invoice_no');
        $customer_id = $this->input->post('customer_id');

        if (!empty($transaction_no)) {
            $conditions['search']['transaction_no'] = $transaction_no;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $row = $this->customer_transaction_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;


        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'customer-transaction-report/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['sold_by'] = $this->customer_transaction_report_model->getvalue_row('users', 'id_user,uname', array());
        $data['customers'] = $this->customer_transaction_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['station'] = $this->customer_transaction_report_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $data['store'] = $this->customer_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['accounts'] = $this->customer_transaction_report_model->getvalue_row('accounts', 'id_account,account_name,account_no', array('status_id' => 1));
        $data['brands'] = $this->customer_transaction_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));

        $data['posts'] = $this->customer_transaction_report_model->getRowsProducts($conditions);
        $this->load->view('customer_transaction_report/all_report_data', $data, false);
    }


    public function details_data($trx_no)
    {
        $data = $this->customer_transaction_report_model->get_payment_details($trx_no);
//dd($data);

        // $data = $this->store_model->get_store_details_by_id($id_store);
        echo json_encode($data);
    }

    public function method_details_data($trx_no)
    {
        $data = $this->customer_transaction_report_model->get_method_details($trx_no);
        echo json_encode($data);
    }
    public function print_data(){
        $conditions = array();
        $transaction_no = $this->input->post('transaction_no');
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $invoice_no = $this->input->post('invoice_no');
        $customer_id = $this->input->post('customer_id');

        if (!empty($transaction_no)) {
            $conditions['search']['transaction_no'] = $transaction_no;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        
        $data['sold_by'] = $this->customer_transaction_report_model->getvalue_row('users', 'id_user,uname', array());
        $data['customers'] = $this->customer_transaction_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['station'] = $this->customer_transaction_report_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $data['store'] = $this->customer_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['accounts'] = $this->customer_transaction_report_model->getvalue_row('accounts', 'id_account,account_name,account_no', array('status_id' => 1));
        $data['brands'] = $this->customer_transaction_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));

        $data['posts'] = $this->customer_transaction_report_model->getRowsProducts($conditions);
        $data3['report']=$this->load->view('customer_transaction_report/all_print_data', $data, true);
        $this->load->view('print_page', $data3, false);
    }
    public function create_csv_data()
    {
        $conditions = array();
        $transaction_no = $this->input->post('transaction_no');
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $invoice_no = $this->input->post('invoice_no');
        $customer_id = $this->input->post('customer_id');

        if (!empty($transaction_no)) {
            $conditions['search']['transaction_no'] = $transaction_no;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $sold_by = $this->customer_transaction_report_model->getvalue_row('users', 'id_user,uname', array());
        $customers = $this->customer_transaction_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $station = $this->customer_transaction_report_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $store = $this->customer_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $accounts = $this->customer_transaction_report_model->getvalue_row('accounts', 'id_account,account_name,account_no', array('status_id' => 1));
        $brands = $this->customer_transaction_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));

        $posts = $this->customer_transaction_report_model->getRowsProducts($conditions);
        $pur_val='';
        
        $fields['date'] = 'Date';
        $fields['transaction_no'] = 'Transaction No';
        $fields['invoice_no'] = 'invoice No';
        $fields['customer_name'] = 'customer_name';
        $fields['store_name'] = 'Store Name';
        $fields['total'] = 'Total Price';
        $sum_qty = 0;
        $total = 0;
        $count = 1;
        if ($posts != '') {
            foreach ($posts as $post) {
                $customer_name = '';
                foreach ($customers as $customer) {
                    if ($customer->id_customer == $post['customer_id']) {
                        $customer_name = $customer->full_name;
                        break;
                    }
                }
                $store_name = '';
                foreach ($store as $stores) {
                    if ($stores->id_store == $post['store_id']) {
                        $store_name = $stores->store_name;
                        break;
                    }
                }
                $account_name = '';
                $account_no = '';

                foreach ($accounts as $account) {
                    if ($account->id_account == $post['account_id']) {
                        $account_name = $account->account_name;
                        $account_no = $account->account_no;
                        break;
                    }
                }
                $total += $post['tot_amount'];
                $array['date'] = $post['dtt_trx'];
                $array['transaction_no'] =$post['trx_no'];
                $array['invoice_no'] =$post['invoice_no'];
                $array['customer_name'] =$customer_name;
                $array['store_name'] =$store_name;
                $array['total'] =$post['tot_amount'];
                $value[] = $array;
                $count++;
            }
        }
        $count = 1;
        if($posts!=''){
            $array['date'] = '';
            $array['transaction_no'] ='';
            $array['invoice_no'] ='';
            $array['customer_name'] ='';
            $array['store_name'] ='Total:';
            $array['total'] =$total;
            $value[] = $array;
        }
        if(!isset($value)){
            $value='';
        }
        $dataArray = array(
            'file_name' => 'customer_transaction_report'
        , 'file_title' => 'Customer Transaction Report'
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
