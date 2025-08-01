<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fund_transfer extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('fund_transfer_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('fund_transfer'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->fund_transfer_model->getRowsProducts());
        
        $data['users'] = $this->fund_transfer_model->getvalue_row('users', 'id_user,uname,fullname', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->fund_transfer_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->fund_transfer_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['accounts_from'] = $this->fund_transfer_model->listAuthicatedAccounts();

        $this->template->load('main', 'fund_transfer/index', $data);
    }


    public function paginate_data($page = 0)
    {
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        //$type = $this->input->post('type');
        $from_store = $this->input->post('from_store');
        $to_store = $this->input->post('to_store');
        $acc_frm = $this->input->post('acc_frm');
        $acc_to = $this->input->post('acc_to');
        $user_id = $this->input->post('user_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        if ($from_store != '0') {
            $conditions['search']['from_store'] = $from_store;
        }
        if ($to_store != '0') {
            $conditions['search']['to_store'] = $to_store;
        }
        if ($acc_frm != '0') {
            $conditions['search']['acc_frm'] = $acc_frm;
        }
        if ($acc_to != '0') {
            $conditions['search']['acc_to'] = $acc_to;
        }
        if ($user_id != '0') {
            $conditions['search']['user_id'] = $user_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $row = $this->fund_transfer_model->getRowsTransfer($conditions);
        $totalRec = ($row != '')?count($row):0;
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
       
        $data['offset']=$offset;
        $data['records'] = $this->fund_transfer_model->getRowsTransfer($conditions);
        $this->load->view('fund_transfer/all_report_invoice_data', $data, false);
         
        
        // }
    }
    public function print_data()
    {
        $conditions = array();
        //$type = $this->input->post('type');
        $from_store = $this->input->post('from_store');
        $to_store = $this->input->post('to_store');
        $acc_frm = $this->input->post('acc_frm');
        $acc_to = $this->input->post('acc_to');
        $user_id = $this->input->post('user_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        if ($from_store != '0') {
            $conditions['search']['from_store'] = $from_store;
        }
        if ($to_store != '0') {
            $conditions['search']['to_store'] = $to_store;
        }
        if ($acc_frm != '0') {
            $conditions['search']['acc_frm'] = $acc_frm;
        }
        if ($acc_to != '0') {
            $conditions['search']['acc_to'] = $acc_to;
        }
        if ($user_id != '0') {
            $conditions['search']['user_id'] = $user_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['offset']=0;
        $data['records'] = $this->fund_transfer_model->getRowsTransfer($conditions);
        $data3['report']=$this->load->view('fund_transfer/all_report_invoice_data', $data, true);
        $this->load->view('print_page', $data3, false);
        
        // }
    }
    public function  get_account_name(){
        $id=$this->input->post('store_id');
        $lists=$this->fund_transfer_model->get_store_accounts($id);
        echo '<option actp="0" value="0">'.lang('select_one') .'</option>';
        foreach ($lists as $account) {
            ?>
            <option actp="<?php echo $account['acc_type']; ?>" value="<?php echo $account['acc_id']; ?>">
            <?php echo!empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name']; ?>
            </option>
            <?php
        }
        //echo $id;
    }
    public function create_csv_data()
    {
        $conditions = array();
        $from_store = $this->input->post('from_store');
        $to_store = $this->input->post('to_store');
        $acc_frm = $this->input->post('acc_frm');
        $acc_to = $this->input->post('acc_to');
        $user_id = $this->input->post('user_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        if ($from_store != '0') {
            $conditions['search']['from_store'] = $from_store;
        }
        if ($to_store != '0') {
            $conditions['search']['to_store'] = $to_store;
        }
        if ($acc_frm != '0') {
            $conditions['search']['acc_frm'] = $acc_frm;
        }
        if ($acc_to != '0') {
            $conditions['search']['acc_to'] = $acc_to;
        }
        if ($user_id != '0') {
            $conditions['search']['user_id'] = $user_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $posts = $this->fund_transfer_model->getRowsTransfer($conditions);
        $fields = array(
            'sl' => 'SL'
        , 'date' => 'Date'
        , 'time' => 'Time'
        , 'from_store' => 'From Store'
        , 'account_from' => 'Account From'
        , 'to_store' => 'To Store'
        , 'acccount_to' => 'Account To'
        , 'description' => 'Description'
        , 'user' => 'User'
        , 'amount' => 'Amount'
        );
        $total = 0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $total+=$post['amount'];
                //$date=nice_datetime($post['dtt_add']);
                //$dateArray=explode(' ',$date);
                $value[] = array(
                    'sl' => $count
                    , 'date' => nice_date($post['dtt_add'])
                    , 'time' =>nice_time($post['dtt_add'])
                    , 'from_store' => $post['from_store']
                    , 'account_from' => account_name_id($post['acc_frm'])
                    , 'to_store' => $post['to_store']
                    , 'acccount_to' => account_name_id($post['acc_to'])
                    , 'description' => $post['description']
                    , 'user' => $post['fullname']
                    , 'amount' => $post['amount']
                );
                $count++;
            }
            $value[] = array(
                'sl' => ''
                , 'date' => ''
                , 'time' =>''
                , 'from_store' => ''
                , 'account_from' => ''
                , 'to_store' => ''
                , 'acccount_to' => ''
                , 'description' => ''
                , 'user' => ''
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
