<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class investor_transaction_report extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('investor_transaction_report_model');
        $this->perPage = 500;
    }

    public function index() {
        $data = array();
        $this->breadcrumb->add(lang('investor-transaction-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
       $type= $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop= $this->session->userdata['login_info']['store_id'];
         if ($type != 3){  
        $data['stores'] = $this->investor_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1,'id_store'=>$selected_shop));
          }
           else if ($type == 3) {
         $data['stores'] = $this->investor_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
            }
         $data['trx_name'] = $this->investor_transaction_report_model->getvalue_row('transaction_types', 'id_transaction_type,trx_name,trx_with', array('trx_with'=>'employee','status_id' => 1));
         $data['employee_name'] = $this->investor_transaction_report_model->getvalue_row('users', 'id_user,fullname', array('user_type_id'=>2,'status_id' => 1));
        $tmp = $this->config->item('trx_type_qty_multipliers');
        $data['transaction_type']   = $tmp['investor'];
        // var_dump($data['transaction_type'] );

        $this->template->load('main', 'investor_transaction_report/index', $data);
    }
   

    public function paginate_data($page = 0) {
        $conditions = array();        
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
       $employee_name_id=$this->input->post('employee_name_id');
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $transaction_type = $this->input->post('transaction_type');
        $transaction_name = $this->input->post('transaction_name');

        if (!empty($employee_name_id)) {
            $conditions['search']['employee_id'] = $employee_name_id;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($transaction_type)) {
            $conditions['search']['qty_multiplier'] = $transaction_type;
        }
        if (!empty($transaction_name)) {
            $conditions['search']['trx_name'] = $transaction_name;
        }
         if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate.' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate.' 23:59:59';
        }
        //   if (!empty($supplier_id)) {
        //     $conditions['search']['supplier_id'] = $supplier_id;
        // }
  // print_r($conditions);
        
        $row = $this->investor_transaction_report_model->getRowsProducts($conditions);
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
        $data['sold_by'] = $this->investor_transaction_report_model->getvalue_row('users', 'id_user,uname', array());
        $data['customers'] = $this->investor_transaction_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['station'] = $this->investor_transaction_report_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $data['store'] = $this->investor_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['accounts'] = $this->investor_transaction_report_model->getvalue_row('accounts', 'id_account,account_name,account_no', array('status_id' => 1));
        $data['brands'] = $this->investor_transaction_report_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
         $data['employee_name'] = $this->investor_transaction_report_model->getvalue_row('users', 'id_user,fullname', array('user_type_id'=>2,'status_id' => 1));
        $data['posts'] = $this->investor_transaction_report_model->getRowsProducts($conditions);
         // $data['payments'] = $this->investor_transaction_report_model->get_payment_details();
         // echo "<pre>";
         // print_r($data['posts']);
        $tmp = $this->config->item('trx_type_qty_multipliers');
        $data['transaction_type']   = $tmp['investor'];
        
        $this->load->view('investor_transaction_report/all_report_data', $data, false);
    // }
    }
    
    public function get_investor_transaction_name(){
     // $type_id= $_POST['country_id'] ;  
     $type_id= $this->input->post('transaction_type');  
     echo $type_id;
     $data['trx_name'] = $this->investor_transaction_report_model->getvalue_row('transaction_types', 'id_transaction_type,trx_name,trx_with', array('trx_with'=>'investor','qty_multiplier'=> $type_id,'status_id' => 1));
     echo '<option value="">Select Transaction Name</option>';
     // print_r($data['trx_name']);
            foreach ($data['trx_name'] as $trx_names){
             echo '<option value="'. $trx_names->trx_name . '">' .$trx_names->trx_name. '</option>';
            }
    }
    public function print_data($page = 0)
    {
        $conditions = array();
        $employee_name_id=$this->input->post('employee_name_id');
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $transaction_type = $this->input->post('transaction_type');
        $transaction_name = $this->input->post('transaction_name');

        if (!empty($employee_name_id)) {
            $conditions['search']['employee_id'] = $employee_name_id;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($transaction_type)) {
            $conditions['search']['qty_multiplier'] = $transaction_type;
        }
        if (!empty($transaction_name)) {
            $conditions['search']['trx_name'] = $transaction_name;
        }
         if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate.' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate.' 23:59:59';
        }
        // print_r($conditions);

       
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Investor Transaction Report';
        //get posts data
        $data['sold_by'] = $this->investor_transaction_report_model->getvalue_row('users', 'id_user,uname', array());
        $data['customers'] = $this->investor_transaction_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['store'] = $this->investor_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['accounts'] = $this->investor_transaction_report_model->getvalue_row('accounts', 'id_account,account_name,account_no', array('status_id' => 1));
         $data['employee_name'] = $this->investor_transaction_report_model->getvalue_row('users', 'id_user,fullname', array('user_type_id'=>2,'status_id' => 1));
        $data['posts'] = $this->investor_transaction_report_model->getRowsProducts($conditions);
        $tmp = $this->config->item('trx_type_qty_multipliers');
        $data['transaction_type']   = $tmp['investor'];
        $data3['report']=$this->load->view('investor_transaction_report/all_report_data', $data, true);
        $this->load->view('print_page', $data3, false);
        // }
    }
    public function create_csv_data()
    {
        $employee_name_id=$this->input->post('employee_name_id');
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $transaction_type = $this->input->post('transaction_type');
        $transaction_name = $this->input->post('transaction_name');

        if (!empty($employee_name_id)) {
            $conditions['search']['employee_id'] = $employee_name_id;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($transaction_type)) {
            $conditions['search']['qty_multiplier'] = $transaction_type;
        }
        if (!empty($transaction_name)) {
            $conditions['search']['trx_name'] = $transaction_name;
        }
         if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate.' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate.' 23:59:59';
        }
        $posts =$this->investor_transaction_report_model->getRowsProducts($conditions);
        $store = $this->investor_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $accounts = $this->investor_transaction_report_model->getvalue_row('accounts', 'id_account,account_name,account_no', array('status_id' => 1));
         $employee_name = $this->investor_transaction_report_model->getvalue_row('users', 'id_user,fullname', array('user_type_id'=>2,'status_id' => 1));
        $fields = array(
            'date' => 'Date'
        , 'store' => 'Store'
        , 'transaction_no' => 'Transaction No'
        , 'investor_name' => 'Investor Name'
        , 'details' => 'Details'
        , 'transaction_type' => 'Transaction Type'
        , 'account_no' => 'Account No'
        , 'amount' => 'Amount'
        
        );
        $total = 0;
        if ($posts != '') {
            $count = 1;
            $tmp = $this->config->item('trx_type_qty_multipliers');
            $transaction_type = $tmp['investor'];
            foreach ($posts as $post) {
              $store_name = '';
               foreach ($store as $stores) {
                  if ($stores->id_store == $post['store_id']) {
                      $store_name = $stores->store_name;
                      break;
                  }
              }
              $employee = '';
               foreach ($employee_name as $employee_names) {
                  if ($employee_names->id_user == $post['ref_id']) {
                      $employee = $employee_names->fullname;
                      break;
                  }
              }
                $total=$total+$post['tot_amount'];
                foreach ($transaction_type as $key => $val) {
                    $type_name = '';
                    if ($key == $post['qty_multiplier']) {
                        $type_name = $val;
                        break;
                    }
                }
                $value[] = array(
                    'date' => date('Y-m-d', strtotime($post['dtt_trx']))
                , 'store' => $store_name
                , 'transaction_no' => $post['trx_no']
                , 'investor_name' => $employee
                , 'details' => $post['description']
                , 'transaction_type' => $type_name
                , 'account_no' => account_name_id($post['account_id'])
                , 'amount' => $post['tot_amount']
                

                );
                $count++;
            }
            $value[] = array(
                'date' => ''
            , 'store' => ''
            , 'transaction_no' => ''
            , 'investor_name' => ''
            , 'details' => ''
            , 'transaction_type' => ''
            , 'account_no' => 'Total'
            , 'amount' =>$total
            

            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'Investor_transaction_report'
        , 'file_title' => 'Investor Transaction Report'
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
