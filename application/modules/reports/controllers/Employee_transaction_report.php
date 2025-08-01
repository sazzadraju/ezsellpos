<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class employee_transaction_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('employee_transaction_report_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('employee-transaction-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->employee_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->employee_transaction_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['trx_name'] = $this->employee_transaction_report_model->getvalue_row('transaction_types', 'id_transaction_type,trx_name,trx_with', array('trx_with' => 'employee', 'status_id' => 1));
        $data['employee_name'] = $this->employee_transaction_report_model->getvalue_row('users', 'id_user,fullname', array('user_type_id' => 1, 'status_id' => 1));
        $tmp = $this->config->item('trx_type_qty_multipliers');
        $data['transaction_type'] = $tmp['employee'];
        $this->template->load('main', 'employee_transaction_report/index', $data);
    }


    public function paginate_data($page = 0)
    {
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $employee_name_id = $this->input->post('employee_name_id');
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $transaction_type = $this->input->post('transaction_type');
        $transaction_name = $this->input->post('transaction_name');

        if ($employee_name_id != 0) {
            $conditions['search']['employee_id'] = $employee_name_id;
        }
        if ($store_id != 0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if ($transaction_type != 0) {
            $conditions['search']['qty_multiplier'] = $transaction_type;
        }
        if ($transaction_name != 0) {
            $conditions['search']['trx_name'] = $transaction_name;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $row = $this->employee_transaction_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'employee-transaction-report/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        
        
        $data['posts'] = $this->employee_transaction_report_model->getRowsProducts($conditions);
        // $data['payments'] = $this->employee_transaction_report_model->get_payment_details();
        // echo "<pre>";
        // print_r($data['posts']);
        $tmp = $this->config->item('trx_type_qty_multipliers');
        $data['transaction_type'] = $tmp['employee'];

        $this->load->view('employee_transaction_report/all_report_data', $data, false);
    }
    public function print_data(){
        $conditions = array();
        $employee_name_id = $this->input->post('employee_name_id');
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $transaction_type = $this->input->post('transaction_type');
        $transaction_name = $this->input->post('transaction_name');

        if ($employee_name_id != 0) {
            $conditions['search']['employee_id'] = $employee_name_id;
        }
        if ($store_id != 0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if ($transaction_type != 0) {
            $conditions['search']['qty_multiplier'] = $transaction_type;
        }
        if ($transaction_name != 0) {
            $conditions['search']['trx_name'] = $transaction_name;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }

        $data['posts'] = $this->employee_transaction_report_model->getRowsProducts($conditions);
        $tmp = $this->config->item('trx_type_qty_multipliers');
        $data['transaction_type'] = $tmp['employee'];
        $data3['report']=$this->load->view('employee_transaction_report/all_report_data', $data, true);
        $this->load->view('print_page', $data3, false);
    }
    public function create_csv_data()
    {
        $conditions = array();
        $employee_name_id = $this->input->post('employee_name_id');
        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $transaction_type = $this->input->post('transaction_type');
        $transaction_name = $this->input->post('transaction_name');

        if ($employee_name_id != 0) {
            $conditions['search']['employee_id'] = $employee_name_id;
        }
        if ($store_id != 0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if ($transaction_type != 0) {
            $conditions['search']['qty_multiplier'] = $transaction_type;
        }
        if ($transaction_name != 0) {
            $conditions['search']['trx_name'] = $transaction_name;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }

        $posts = $this->employee_transaction_report_model->getRowsProducts($conditions);
        $tmp = $this->config->item('trx_type_qty_multipliers');
        $transaction_type = $tmp['employee'];
        $pur_val='';
        $fields['date'] = 'Date';
        $fields['transaction_no'] = 'Transaction No';
        $fields['employee_name'] = 'Employee Name';
        $fields['transaction_name'] = 'Transaction Name';
        $fields['transaction_type'] = 'Transaction Type';
        $fields['store_name'] = 'Store Name';
        $fields['account_no'] = 'Account No';
        $fields['total'] = 'Total Price';
        $sum_qty = 0;
        $total = 0;
        $count = 1;
        if ($posts != '') {
            foreach ($posts as $post) {
                foreach ($transaction_type as $key => $val) {
                    $type_name = '';
                    if ($key == $post['qty_multiplier']) {
                        $type_name = $val;
                        break;
                    }
                }
                $total += $post['tot_amount'];
                $array['date'] = $post['dtt_trx'];
                $array['transaction_no'] =$post['trx_no'];
                $array['employee_name'] =$post['emp_name'];
                $array['transaction_name'] =$post['trx_name'];
                $array['transaction_type'] =$type_name;
                $array['store_name'] =$post['store_name'];
                $array['account_no'] =account_name_id($post['account_id']);
                $array['total'] =$post['tot_amount'];
                $value[] = $array;
                $count++;
            }
        }
        $count = 1;
        if($posts!=''){
            $array['date'] = '';
            $array['transaction_no'] ='';
            $array['employee_name'] ='';
            $array['transaction_name'] ='';
            $array['transaction_type'] ='';
            $array['store_name'] ='';
            $array['account_no'] ='Total:';
            $array['total'] =$total;
            $value[] = $array;
        }
        if(!isset($value)){
            $value='';
        }
        $dataArray = array(
            'file_name' => 'employee_transaction_report'
        , 'file_title' => 'Employee Transaction Report'
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
