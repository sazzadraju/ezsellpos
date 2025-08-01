<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fund_transfer extends MX_Controller {
    
    private $perPage = null;
    
    function __construct(){
		parent::__construct();
        
        $this->form_validation->CI =& $this;
        $this->load->library('form_validation');
		
		if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }

        $this->perPage = 20;
        $this->load->model('auto_increment');
        $this->load->model('Fund_transfer_model', 'ftm');
        $this->load->model('account_settings/Bank_model');
        $this->load->model('account_settings/Card_model');
	}
    
    public function index(){
        redirect('/account-management/fund-transfer', 'refresh');
    }
    
    public function list_fund_transfers(){
        $data = [];
        $this->dynamic_menu->check_menu('account-management/fund-transfer');
        ## BREADCRUMB
        $this->breadcrumb->add(lang('accounts_management'),'account-management/transactions/customer', 1);
        $this->breadcrumb->add(lang('fund_transfer'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        
        $data['accounts_from'] = $this->ftm->listAuthicatedAccounts();
        $data['accounts_to'] = $this->ftm->listAccounts();
        $data['fund_records'] = array();
        
        
        $total = $this->ftm->totalRecords();
        $data['records'] = $this->ftm->listRecords($total, $this->perPage);
         $config = [
            'target'        => '#fund_trx_lst',
            'base_url'      => base_url() . 'account-management/fund-transfer-records',
            'total_rows'    => $total,
            'per_page'      => $this->perPage,
            'link_func'     => 'searchFilter',
        ];
        $this->ajax_pagination->initialize($config);
        
        $data['limit'] = $this->perPage;
        $data['offset'] = 0;
        $this->template->load('main', 'fund_transfer/list_fund_transfers', $data);
    }
    
    public function fund_transfer_records($page=0){
        $data = array();
        $page = (int)$page;
        $offset = !empty($page) ? $page : 0;
        
        $total = $this->ftm->totalRecords();
        $data['records'] = $this->ftm->listRecords($total, $this->perPage,$offset);
         $config = [
            'target'        => '#fund_trx_lst',
            'base_url'      => base_url() . 'account-management/fund-transfer-records',
            'total_rows'    => $total,
            'per_page'      => $this->perPage,
            'link_func'     => 'searchFilter',
        ];
         
        $this->ajax_pagination->initialize($config);
        //$data['pagination_link']=$this->ajax_pagination->create_links();

        $data['limit'] = $this->perPage;
        $data['offset'] = $offset;
        $this->load->view('fund_transfer/fund_transfer_records', $data, false);
    }
    
    public function get_acc_curr_banalce($acc_id){
        $acc_id = (int)$acc_id;
        $curr_amt = $this->ftm->getAccCurBalance($acc_id);
        $curr_amt = trim_zero($curr_amt);
        echo $curr_amt.'|'.comma_seperator($curr_amt) . ' '. lang('tk');
    }
    
    public function add(){
        $data = array();
        
        $this->form_validation->set_rules('acc_frm', 'Account From', "trim|xss_clean|required");
        $this->form_validation->set_rules('acc_to', 'Account To', "trim|xss_clean|required");
        $this->form_validation->set_rules('amount', 'Amount', "trim|xss_clean|required|numeric");
        
        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $data['acc_from_id'] = $this->input->post('acc_frm');
            $data['acc_to_id'] = $this->input->post('acc_to');
            $data['amount'] = $this->input->post('amount');
            $data['description'] = $this->input->post('description');
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $data['status_id'] = 1;
            $data['version'] = 1;
            
            $sts = $this->ftm->addFundTransfer($this->commonlib->trim_array($data));
            $configs = $this->commonmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
            $sms_config = $this->commonmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 8));
            $customerArray=array();
            if($configs[0]->param_val>0 && $sms_config[0]->sms_send ==1){
                $smsArray['sms_count']=1;
                $smsArray['unit_price']=$configs[0]->utilized_val;
                $smsArray['sms_type']=8;
                $smsArray['cus_data']=$customerArray;
                $msgarray=set_sms_send($smsArray);
                //print_r($msgarray);
               
            }
            echo $sts ? json_encode(array("status" => "success", "message" => "Data Added successfully!"))
                    : json_encode(array("status" => "failed", "message" => "Data Add failed!"));
        }
    }
    
    //   http://localhost/dpos/account-management/fund-transfer/test
    public function test(){
        die('***');
        $data = array (
            'acc_from_id' => '7',
            'acc_to_id' => '9',
            'amount' => '1000',
            'description' => 'HSHSHS',
            'dtt_add' => '2017-11-27 17:06:02',
            'uid_add' => '5',
            'status_id' => 1,
            'version' => 1,
          );
        $sts = $this->ftm->addFundTransfer($this->commonlib->trim_array($data));
        dd($sts);
    }
}


/* IMP QUeries

## ADD Fund transfer
SELECT * FROM fund_transfers f;

SELECT a.id_account , a.`initial_balance`, a.curr_balance
FROM accounts a ;
 
=====================================================

TRUNCATE TABLE fund_transfers;

UPDATE accounts a 
SET a.`initial_balance` = a.`id_account` * 1000000
, a.`curr_balance` = a.`id_account` * 1000000
;
*/