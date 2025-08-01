<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MX_Controller {
    private $perPage=null;
    
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
        $this->load->model('Bank_model', 'bankmodel');
		$this->load->model('Account_model', 'accountmodel');
	}
    
     public function index(){
         $data = array();
         $this->dynamic_menu->check_menu('account-settings/account');
        ## BREADCRUMB
        $this->breadcrumb->add(lang('account_settings'),'account-settings/account', 1);
        $this->breadcrumb->add(lang('accounts'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        
        ## BANK ACCOUNT DATA
        $tot_acc = $this->accountmodel->getTotAccounts(1);
        $data['bank_accounts'] = $this->accountmodel->listAccounts(1, $tot_acc, $this->perPage);
        $config = [
            'target'        => '#bank_account',
            'base_url'      => base_url() . 'account-settings-account/page-bank-account',
            'total_rows'    => $tot_acc,
            'per_page'      => $this->perPage,
            'link_func'     => 'searchFilter1',
        ];
        $pagination1 = clone($this->ajax_pagination);
        $pagination1->initialize($config);
        $data['pagination_link_1'] = $pagination1->create_links();
        
        ## CASH ACCOUNT DATA
        $tot_acc = $this->accountmodel->getTotAccounts(2);
        $data['cash_accounts'] = $this->accountmodel->listAccounts(2, $tot_acc, $this->perPage);
        $config = [
            'target'        => '#cash_account',
            'base_url'      => base_url() . 'account-settings-account/page-cash-account',
            'total_rows'    => $tot_acc,
            'per_page'      => $this->perPage,
            'link_func'     => 'searchFilter2',
        ];
        $pagination2 = clone($this->ajax_pagination);
        $pagination2->initialize($config);
        $data['pagination_link_2'] = $pagination2->create_links();
        
        ## MOBILE ACCOUNT DATA
        $tot_acc = $this->accountmodel->getTotAccounts(3);
        $data['mobile_accounts'] = $this->accountmodel->listAccounts(3, $tot_acc, $this->perPage);
        $config = [
            'target'        => '#mobile_account',
            'base_url'      => base_url() . 'account-settings-account/page-mobile-account',
            'total_rows'    => $tot_acc,
            'per_page'      => $this->perPage,
            'link_func'     => 'searchFilter3',
        ];
        $pagination3 = clone($this->ajax_pagination);
        $pagination3->initialize($config);
        $data['pagination_link_3'] = $pagination3->create_links();
        
        ## STATION ACCOUNT DATA
        $tot_acc = $this->accountmodel->getTotAccounts(4);
        $data['station_accounts'] = $this->accountmodel->listAccounts(4, $tot_acc, $this->perPage);
        $config = [
            'target'        => '#station_account',
            'base_url'      => base_url() . 'account-settings-account/page-station-account',
            'total_rows'    => $tot_acc,
            'per_page'      => $this->perPage,
            'link_func'     => 'searchFilter4',
        ];
        $pagination4 = clone($this->ajax_pagination);
        $pagination4->initialize($config);
        $data['pagination_link_4'] = $pagination4->create_links();
        
        $data['general_banks'] = $this->bankmodel->listBanksAll(1);
        $data['mobile_banks'] = $this->bankmodel->listBanksAll(2);
        $data['stores'] = $this->commonmodel->listAuthenticatedStores();
        
        $data['offset'] = 0;
        $this->template->load('main', 'account/index', $data);
     }
     
     public function bank_account_page($offset){
        $data = array();
        $acc_type = 1;
        $offset = (int) $offset;
        
        $config = [];
        
        $tot_acc = $this->accountmodel->getTotAccounts($acc_type);
        $data['bank_accounts'] = $this->accountmodel->listAccounts($acc_type, $tot_acc, $this->perPage);
        $config = [
            'target'        => '#bank_account',
            'base_url'      => base_url() . 'account-settings-account/page-bank-account',
            'total_rows'    => $tot_acc,
            'per_page'      => $this->perPage,
            'link_func'     => 'searchFilter1',
        ];
        $pagination1 = clone($this->ajax_pagination);
        $pagination1->initialize($config);
        $data['pagination_link_1'] = $pagination1->create_links();
        
        $data['limit'] = $this->perPage;
        $data['offset'] = $offset;
        $this->load->view('account/bank_account_page', $data, false);
    }
    
    public function cash_account_page($offset){
        $data = array();
        $acc_type = 2;
        $offset = (int) $offset;
        
        $config = [];
        $tot_acc = $this->accountmodel->getTotAccounts($acc_type);
        $data['cash_accounts'] = $this->accountmodel->listAccounts($acc_type, $tot_acc, $this->perPage);
        $config = [
            'target'        => '#cash_account',
            'base_url'      => base_url() . 'account-settings-account/page-cash-account',
            'total_rows'    => $tot_acc,
            'per_page'      => $this->perPage,
            'link_func'     => 'searchFilter2',
        ];
        $pagination2 = clone($this->ajax_pagination);
        $pagination2->initialize($config);
        $data['pagination_link_2'] = $pagination2->create_links();
        $data['limit'] = $this->perPage;
        $data['offset'] = $offset;
        
        $this->load->view('account/cash_account_page', $data, false);
    }
    
    public function mobile_account_page($offset){
        $data = array();
        $acc_type = 3;
        $offset = (int) $offset;
        
        $tot_acc = $this->accountmodel->getTotAccounts($acc_type);
        $data['mobile_accounts'] = $this->accountmodel->listAccounts($acc_type, $tot_acc, $this->perPage);
        $config = [
            'target'        => '#mobile_account',
            'base_url'      => base_url() . 'account-settings-account/page-mobile-account',
            'total_rows'    => $tot_acc,
            'per_page'      => $this->perPage,
            'link_func'     => 'searchFilter3',
        ];
        $pagination3 = clone($this->ajax_pagination);
        $pagination3->initialize($config);
        $data['pagination_link_3'] = $pagination3->create_links();
        
        $data['limit'] = $this->perPage;
        $data['offset'] = $offset;
        
        $this->load->view('account/mobile_account_page', $data, false);
    }
    
    public function station_account_page($offset){
        $data = array();
        $acc_type = 4;
        $offset = (int) $offset;
        
        $tot_acc = $this->accountmodel->getTotAccounts($acc_type);
        $data['mobile_accounts'] = $this->accountmodel->listAccounts($acc_type, $tot_acc, $this->perPage);
        $config = [
            'target'        => '#mobile_account',
            'base_url'      => base_url() . 'account-settings-account/page-mobile-account',
            'total_rows'    => $tot_acc,
            'per_page'      => $this->perPage,
            'link_func'     => 'searchFilter3',
        ];
        $pagination3 = clone($this->ajax_pagination);
        $pagination3->initialize($config);
        $data['pagination_link_3'] = $pagination3->create_links();
        
        $data['limit'] = $this->perPage;
        $data['offset'] = $offset;
        
        $this->load->view('account/mobile_account_page', $data, false);
    }
    
    public function details($acc_id){
        $data = $this->accountmodel->accountDetails($acc_id);
        $str = json_encode($data);
        echo str_replace('null', '""', $str);
    }
    
    public function add_account(){
        $acc_id = (int)$this->input->post('id');
        $errors = array();
        $data = array();
        if(empty($acc_id)){  // ADD MODE
            $this->form_validation->set_rules('acc_uses', 'Account Uses', 'required|numeric');
            $data['acc_type_id'] = $this->input->post('acc_type');
            if($data['acc_type_id'] == 1){
                $this->form_validation->set_rules('bank_account', 'Bank Account', 'trim|xss_clean|required|numeric');
                $this->form_validation->set_rules('acc_no', 'Account No', "trim|xss_clean|required|min_length[5]|max_length[20]|callback_isUnqBankAccountNo[$acc_id]");
                $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|xss_clean|required|min_length[5]|max_length[128]');
                $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean|min_length[5]|max_length[128]');
            } elseif($data['acc_type_id'] == 2){
                $this->form_validation->set_rules('cash_acc_name', 'Cash Account Name', "trim|required|min_length[5]|max_length[64]|callback_isUnqCashAccount[$acc_id]");
            } elseif($data['acc_type_id'] == 3){
                $mob_acc_param = trim($this->input->post('mobile_bank_account')) . '@'.$acc_id;
                $this->form_validation->set_rules('mobile_bank_account', 'Bank Account', 'trim|xss_clean|required|numeric');
                $this->form_validation->set_rules('acc_no', 'Account No', "trim|xss_clean|required|min_length[5]|max_length[20]|callback_isUnqMobileAccountNo[$mob_acc_param]");
                $this->form_validation->set_rules('trx_charge', 'Transaction Charge', 'trim|xss_clean|required|numeric');
            }
            
            $store_str = json_encode($this->input->post('store_id'));
            $this->form_validation->set_rules('store_id', 'Store', "callback_isStoreEmpty[$store_str]");
            $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean|min_length[5]|max_length[128]');
            $this->form_validation->set_rules('initial_balance', 'Initial Balance', 'trim|xss_clean|required|numeric');
            
        } else{  // EDIT MODE
            $store_str = json_encode($this->input->post('store_id'));
            $this->form_validation->set_rules('store_id', 'Store', "callback_isStoreEmpty[$store_str]");
            $this->form_validation->set_rules('acc_uses', 'Account Uses', 'required|xss_clean|numeric');
        }
        
        if ($this->form_validation->run() == false) {
            echo json_encode($this->form_validation->error_array());
        } else {
            $data['acc_uses_id'] = $this->input->post('acc_uses');
            $stores = $this->input->post('store_id');
            if(empty($stores)){$stores = array();}
            //$data['acc_type_id'] = $this->input->post('acc_type');
            if(empty($acc_id)){
                if($data['acc_type_id']==1){
                    $data['bank_id'] = (int)$this->input->post('bank_account');
                    $data['account_no'] = trim($this->input->post('acc_no'));
                    $data['branch_name'] = trim($this->input->post('branch_name'));
                    $data['address'] = trim($this->input->post('address'));
                } elseif($data['acc_type_id']==2){
                    $data['account_name'] = $this->input->post('cash_acc_name');
                } elseif($data['acc_type_id']==3){
                    $data['bank_id'] = (int)$this->input->post('mobile_bank_account');
                    $data['account_no'] = trim($this->input->post('acc_no'));
                    $data['mob_acc_type_id'] = $this->input->post('mob_acc_type');
                    $data['trx_charge'] = trim($this->input->post('trx_charge'));
                }
                $data['description'] = trim($this->input->post('description'));
                $data['initial_balance'] = trim($this->input->post('initial_balance'));
                $data['curr_balance'] = $data['initial_balance'];
                
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['status_id'] = 1;
                $data['version'] = 1;
                $acc_id = $this->commonmodel->commonInsertSTP('accounts', $data);
                $message = 'Account created successfully.';
            } else{
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $this->commonmodel->commonUpdateSTP('accounts', $data, ['id_account'=>$acc_id]);
                $this->commonmodel->commonDeleteSTP('accounts_stores', ['account_id'=>$acc_id]);
                $message = 'Account updated successfully.';
            }

            if(!empty($stores)){
                foreach($stores as $store){
                    $this->commonmodel->commonInsertSTP('accounts_stores', ['account_id'=>$acc_id, 'store_id'=>$store]);
                }
            }
            
            echo json_encode(array("status" => "success", "message" => $message));
        }
    }
    
    ##  http://localhost/dpos/account-settings-account/edit-account-info/1
    public function edit_acc_info($acc_id){
        $data = $this->accountmodel->accountEditInfo($acc_id);
        $str = json_encode($data);
        echo str_replace('null', '""', $str);
    }
    
    public function delete($acc_id){
        $data = [
            'status_id' => '2',
            'dtt_mod' => date('Y-m-d H:i:s'),
            'uid_mod' => $this->session->userdata['login_info']['id_user_i90'],
        ];
        $this->commonmodel->commonUpdateSTP('accounts', $data, ['id_account'=>$acc_id]);
        echo json_encode(array("status" => 'Account deleted successfully.'));
    }
    
    public function isUnqBankAccountNo($str, $id)
    {
        if(empty($str)){
            $this->form_validation->set_message('isUnqBankAccountNo', 'Account No is empty');
            return FALSE;
        } else if($this->accountmodel->isBankAccountExists($str, $id)){
            $this->form_validation->set_message('isUnqBankAccountNo', 'Account No already exists');
            return FALSE;
        } else{
            return TRUE;
        } /*else if($this->commonmodel->isExistExcept('accounts', 'account_no', $str, 'id_account', $id)){
            $this->form_validation->set_message('isUnqBankAccountNo', 'Account No already exists');
            return FALSE;
        } else{
            return TRUE;
        }*/
    }
    
    public function isUnqCashAccount($str, $id)
    {
        if($this->accountmodel->isCashAccountExists(trim($str), $id)){
            $this->form_validation->set_message('isUnqCashAccount', 'Account Name already exists');
            return FALSE;
        } else{
            return TRUE;
        }
    }
    
    public function isUnqMobileAccountNo($str, $param)
    {
        $tmp = explode('@',$param);
        $mobile_bank_id = $tmp[0];
        $id = isset($tmp[1]) ? $tmp[1] : 0;
        if(empty($str)){
            $this->form_validation->set_message('isUnqMobileAccountNo', 'Account No is empty');
            return FALSE;
        } else if($this->accountmodel->isMobileAccountExists($str, $mobile_bank_id, $id)){
            $this->form_validation->set_message('isUnqMobileAccountNo', 'Account No already exists');
            return FALSE;
        } else{
            return TRUE;
        }
    }
    
    public function isStoreEmpty($str, $stores_str)
    {
        $stores_str = str_replace("NULL", "", $stores_str);
        $stores_str = str_replace("null", "", $stores_str);
        
        if($stores_str == NULL || empty($stores_str)){
            $this->form_validation->set_message('isStoreEmpty', "Please select stores.");
            return FALSE;
        } else{
            return TRUE;
        }
    }
    
    ##  http://localhost/dpos/account-settings-account/test
    public function test(){
        $str = '123456';
        $param = '8' . '@'.'0';
        $tmp = explode('@',$param);
        $mobile_bank_id = $tmp[0];
        $id = isset($tmp[1]) ? $tmp[1] : 0;
        if($this->accountmodel->isMobileAccountExists($str, $mobile_bank_id, $id)){
            echo 'Account No already exists';
        }
    }
}