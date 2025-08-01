<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_transaction_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('supplier_transaction_report_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('supplier_transaction_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'supplier_transaction_report/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['de_vat'] = $this->supplier_transaction_report_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        $data['users'] = $this->supplier_transaction_report_model->getvalue_row('users', 'id_user,uname', array('status_id' => 1));
        $data['suppliers'] = $this->supplier_transaction_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['accounts'] = $this->supplier_transaction_report_model->getvalue_row('accounts', 'id_account,account_name,account_no', array('status_id' => 1));
        $data['stations'] = $this->supplier_transaction_report_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        // var_export($data['stations']);
        $data['categories'] = $this->supplier_transaction_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->supplier_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->supplier_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['posts'] = $this->supplier_transaction_report_model->getRowsProducts(array('limit' => $this->perPage), '');
        $data['company'] = $this->session->userdata['login_info']['store_id'];
        $data['address'] = $this->session->userdata['login_info']['address'];
        $data['mobile'] = $this->session->userdata['login_info']['mobile'];
        $data['printed_by'] = $this->session->userdata['login_info']['fullname'];
        $this->template->load('main', 'supplier_transaction_report/index', $data);
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
        $trans_account = $this->input->post('trans_account');
        $supplier_id = $this->input->post('supplier_id');
        $invoice_no = $this->input->post('invoice_no');

        
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        //   if (!empty($supplier_id)) {
        //     $conditions['search']['supplier_id'] = $supplier_id;
        // }
        // print_r($conditions);
        $row = $this->supplier_transaction_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;

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

        //get posts data
        $data['sold_by'] = $this->supplier_transaction_report_model->getvalue_row('users', 'id_user,uname', array());
        $data['customers'] = $this->supplier_transaction_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['station'] = $this->supplier_transaction_report_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $data['store'] = $this->supplier_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['accounts'] = $this->supplier_transaction_report_model->getvalue_row('accounts', 'id_account,account_name,account_no', array('status_id' => 1));
        $data['brands'] = $this->supplier_transaction_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['suppliers'] = $this->supplier_transaction_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['posts'] = $this->supplier_transaction_report_model->getRowsProducts($conditions);
        

        $this->load->view('supplier_transaction_report/all_report_data', $data, false);
        // }
    }

    public function details_data($trx_no)
    {
        $data = $this->supplier_transaction_report_model->get_payment_details($trx_no);
//dd($data);

        // $data = $this->store_model->get_store_details_by_id($id_store);
        echo json_encode($data);
    }

    public function method_details_data($trx_no)
    {
        $data = $this->supplier_transaction_report_model->get_method_details($trx_no);
//dd($data);

        // $data = $this->store_model->get_store_details_by_id($id_store);
        echo json_encode($data);
    }


    public function print_data($page = 0)
    {
        $conditions = array();
        
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $supplier_id = $this->input->post('supplier_id');
        $invoice_no = $this->input->post('invoice_no');

        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        //get posts data
        $data['sold_by'] = $this->supplier_transaction_report_model->getvalue_row('users', 'id_user,uname', array());
        $data['customers'] = $this->supplier_transaction_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['station'] = $this->supplier_transaction_report_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $data['store'] = $this->supplier_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['accounts'] = $this->supplier_transaction_report_model->getvalue_row('accounts', 'id_account,account_name,account_no', array('status_id' => 1));
        $data['brands'] = $this->supplier_transaction_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['suppliers'] = $this->supplier_transaction_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['posts'] = $this->supplier_transaction_report_model->getRowsProducts($conditions);
        $data3['report']=$this->load->view('supplier_transaction_report/all_report_data', $data, true);
        $this->load->view('print_page', $data3, false);
        // }
    }
    public function create_csv_data()
    {
        $conditions = array();
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $supplier_id = $this->input->post('supplier_id');
        $invoice_no = $this->input->post('invoice_no');

        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if ($supplier_id!=0) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $posts = $this->supplier_transaction_report_model->getRowsProducts($conditions);
        $store = $this->supplier_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $accounts = $this->supplier_transaction_report_model->getvalue_row('accounts', 'id_account,account_name,account_no', array('status_id' => 1));
        $suppliers = $this->supplier_transaction_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $fields = array(
         'date' => 'Date'
        , 'store' => 'Store Name'
        , 'transaction_no' => 'Transaction No'
        , 'supplier_name' => 'supplier Name'
        , 'trans_account' => 'Transaction Account'
        , 'invoice_no' => 'Invoice No'
        , 'account_no' => 'Account No'
        , 'amount' => 'Amount'
        );
        $total = 0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $total+=$post['tot_amount'];
                $store_name = '';
                 foreach ($store as $stores) {
                    if ($stores->id_store == $post['store_id']) {
                        $store_name = $stores->store_name;
                        break;
                    }
                }
                $supplier_name = '';
                 foreach ($suppliers as $supplier) {
                    if ($supplier->id_supplier == $post['ref_id']) {
                        $supplier_name = $supplier->supplier_name;
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
                $date = date('Y-m-d', strtotime($post['dtt_trx']));
                //$dateArray=explode(' ',$date);
                $value[] = array(
                     'date' => $date
                    , 'store' => $store_name
                    , 'transaction_no' => $post['trx_no']
                    , 'supplier_name' => $supplier_name
                    , 'trans_account' => $account_no
                    , 'invoice_no' => $post['invoice_no'] 
                    , 'account_no' => account_name_id($post['account_id'])
                    , 'amount' => $post['tot_amount']
                );
                $count++;
            }
            $value[] = array(
                 'date' => $date
                , 'store' => ''
                , 'transaction_no' => ''
                , 'supplier_name' => ''
                , 'trans_account' => ''
                , 'invoice_no' =>'' 
                , 'account_no' => 'Total:'
                , 'amount' => $total

            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'fund_transfer'
        , 'file_title' => 'Fund Transfer Report'
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
