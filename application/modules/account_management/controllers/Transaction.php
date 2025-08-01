<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends MX_Controller
{
    private $perPage = 25;
    private $per_page_invoice = 100;

    function __construct()
    {
        parent::__construct();

        $this->form_validation->CI =& $this;
        $this->load->library('form_validation');

        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }

        $this->perPage = 10;
        $this->load->model('auto_increment');
        $this->load->model('Transaction_model', 'trxmodel');
        $this->load->model('account_settings/Bank_model');
        $this->load->model('account_settings/Card_model');
    }

    public function index()
    {
        redirect('/account-management/transactions/customer', 'refresh');
    }

    public function trx_list($trx_with, $offset = 0)
    {
        $data = [];
        $data['trx_with'] = strtolower($trx_with);
        $this->dynamic_menu->check_menu('account-management/transactions/customer');
        ## BREADCRUMB
        $this->breadcrumb->add(lang('accounts_management'), 'account-management/transactions/customer', 1);
        $this->breadcrumb->add(lang('transactions'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['menus'] = $this->trxmodel->listCheckMenu();
        //print_r($data['menus']);
        if (!in_array($data['trx_with'], $this->config->item('transaction_with'))) {
            redirect('/account-management/transactions/customer', 'refresh');
        }
        $type=$this->session->userdata['login_info']['user_type_i92'];
        if($type!=3){
            $cnt=1;
            foreach ($data['menus'] as $value) {
                if($value->page_name==$data['trx_with']){
                   $cnt=2; 
                }
            }
            if($cnt==1){
                redirect('/account-management/transactions/'.$data['menus'][0]->page_name, 'refresh');
            }
        }
        $data['transactions'] = $this->trxmodel->listTransactions($data['trx_with'], $this->perPage, $offset);
        $data['limit'] = $this->perPage;
        $data['offset'] = $offset;

        $data['qty_multipliers'] = isset($this->config->item('trx_type_qty_multipliers')[$trx_with])
            ? $this->config->item('trx_type_qty_multipliers')[$trx_with] : [];
        $data['stores'] = $this->commonmodel->listAllStores();

        $this->template->load('main', 'transaction/trx_list', $data);
    }

    public function trx_add($trx_with)
    {
        $data = [];
        $this->dynamic_menu->check_menu('account-management/transactions/customer');
        $data['trx_with'] = strtolower($trx_with);
        $data['page_title'] = lang("add_{$data['trx_with']}_trx");
        if (!in_array($data['trx_with'], $this->config->item('transaction_with'))) {
            redirect('/account-management/transactions/customer', 'refresh');
        }
        $this->trxmodel->listCheckMenu($data['trx_with']);
        $type=$this->session->userdata['login_info']['user_type_i92'];

        ## BREADCRUMB
        $this->breadcrumb->add(lang('accounts_management'), "account-management/transactions/{$data['trx_with']}", 1);
        $this->breadcrumb->add($data['page_title'], '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();

        $data['dtt_trx'] = date('Y-m-d H:i:s');
        $data['trx_no'] = $this->auto_increment->getAutoIncKey('TRANSACTION', 'transactions', 'trx_with');
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')[$trx_with];
        $data['accounts'] = $this->trxmodel->listTrxAccounts($this->session->userdata['login_info']['store_ids']);
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['trx_types'] = $this->trxmodel->listTrxTypes($data['trx_with']);
        $data['stores'] = $this->commonmodel->listAuthenticatedStores();

        if ($trx_with == 'employee') {
            $data['employees'] = $this->commonmodel->listAuthenticatedUsers(1);
        }
        if ($trx_with == 'investor') {
            $data['investors'] = $this->commonmodel->listAuthenticatedUsers(2);
        }
        if ($trx_with == 'supplier') {
            $data['suppliers'] = $this->commonmodel->getvalue_row('suppliers', 'id_supplier,supplier_name,supplier_code,phone,credit_balance', array('status_id' => 1));
        }
        $customers =
            $this->template->load('main', "transaction/add/{$data['trx_with']}", $data);
    }

    /**
     * $return_type indicates which page to return after edit is done
     * $return_type=1 >> return to account-management/transactions/~
     * $return_type=2 >> return to account-management/transaction-invoices
     */
    public function trx_edit($trx_with, $id, $return_type = 1)
    {

        $data = [];
        $this->dynamic_menu->check_menu('account-management/transactions/customer');
        $id = (int)$this->commonlib->decrypt_srting($id);
        $trx_with = strtolower($trx_with);

        if (!in_array($trx_with, $this->config->item('transaction_with'))) {
            redirect("/account-management/transactions/customer", 'refresh');
        }

        $data = $this->trxmodel->trxDetails($trx_with, $id);

        if (empty($id) || empty($data) || !in_array($data['store_id'], $this->session->userdata['login_info']['store_ids'])) {
            redirect("/account-management/transactions/{$trx_with}", 'refresh');
        }

        $data['return_type'] = in_array($return_type, [1, 2]) ? $return_type : 1;

        ## PREPARING PARAMETERS FOR HIDDEN FIELD
        if (isset($data['trx_details'])) {
            if ($trx_with == 'customer') {
                foreach ($data['trx_details'] as $k => $v) {
                    $data['trx_details'][$k]['params'] = $this->encryption->encrypt("{$v['sale_id']}|{$v['amount']}|" . ($v['amount'] + $v['due_amt']) . "|{$v['tot_amt']}");
                }
            } else {
                foreach ($data['trx_details'] as $k => $v) {
                    $data['trx_details'][$k]['params'] = $this->encryption->encrypt("{$v['ref_id']}|{$v['amount']}|" . ($v['amount'] + $v['due_amt']) . "|{$v['tot_amt']}");
                }
            }
        }

        $data['id'] = $id;
        $data['trx_with'] = $trx_with;
        $data['page_title'] = lang("edit_{$data['trx_with']}_trx");

        ## BREADCRUMB
        $this->breadcrumb->add(lang('accounts_management'), "account-management/transactions/{$data['trx_with']}", 1);
        $this->breadcrumb->add($data['page_title'], '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['documents'] = $this->trxmodel->getDocument($id);
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')[$trx_with];
        //$data['accounts'] = $this->trxmodel->listTrxAccounts($this->session->userdata['login_info']['store_ids']);
        $data['accounts'] = $this->trxmodel->listTrxAccounts([$data['store_id']]);
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['trx_types'] = $this->trxmodel->listTrxTypes($data['trx_with']);
        $data['stores'] = $this->commonmodel->listAuthenticatedStores();
        if ($trx_with == 'employee') {
            $data['employees'] = $this->commonmodel->listAuthenticatedUsers(1);
        }
        if ($trx_with == 'investor') {
            $data['investors'] = $this->commonmodel->listAuthenticatedUsers(2);
        }

        $this->template->load('main', "transaction/edit/{$data['trx_with']}", $data);
    }

    public function customer_upaid_orders($customer_id, $store_id = 0)
    {
        $data = [];
        $customer_id = (int)$customer_id;
        $store_id = (int)$store_id;
        $data['unpaid_orders'] = $this->trxmodel->listCustomerUnpaidOrders($customer_id, $store_id);
        foreach ($data['unpaid_orders'] as $key => $val) {
            ## PASS PARAMETERS AS ENCRYPTED FIELD
            $data['unpaid_orders'][$key]['params'] = $this->encryption->encrypt("{$data['unpaid_orders'][$key]['id']}|{$data['unpaid_orders'][$key]['tot_amt']}|{$data['unpaid_orders'][$key]['due_amt']}|{$data['unpaid_orders'][$key]['paid_amt']}");
        }
        $this->load->view("transaction/customer_upaid_orders", $data);
    }

    public function ajx_customer_list()
    {
        $store = $this->input->post('stores');
        $customers = $this->commonmodel->getvalue_row('customers', 'full_name,customer_code,id_customer,phone', array('status_id' => 1));
        echo '<option value="0">' . lang('select_one') . '</option>';
        if ($customers) {
            foreach ($customers as $customer) {
                echo '<option value="' . $customer->id_customer . '">' . $customer->full_name.' '. $customer->customer_code. ' (' . $customer->phone . ')' . '</option>';
            }
        }

    }

    public function ajx_supplier_list()
    {
        $store = $this->input->post('stores');
        $customers = $this->commonmodel->getvalue_row('suppliers', 'id_supplier,supplier_name,supplier_code,phone', array('status_id' => 1));
        echo '<option value="0">' . lang('select_one') . '</option>';
        if ($customers) {
            foreach ($customers as $customer) {
                echo '<option value="' . $customer->id_customer . '">' . $customer->full_name . ' (' . $customer->phone . ')' . '</option>';
            }
        }

    }

    public function supplier_unpaid_purchases($supplier_id, $store_id = 0)
    {
        $data = [];
        $supplier_id = (int)$supplier_id;
        $store_id = (int)$store_id;
        $data['unpaid_purchases'] = $this->trxmodel->listSupplierUnpaidPurchases($supplier_id, $store_id);
        foreach ($data['unpaid_purchases'] as $key => $val) {
            ## PASS PARAMETERS AS ENCRYPTED FIELD
            $data['unpaid_purchases'][$key]['params'] = $this->encryption->encrypt("{$val['id']}|{$val['tot_amt']}|{$val['due_amt']}|{$val['paid_amt']}");
        }
        $this->load->view("transaction/supplier_unpaid_purchases", $data);
    }

    public function add_customer_transaction($id = 0)
    {
        $trx_amt = [];
        $param = $this->input->post('param');
        $pay_amt = $this->input->post('pay_amt');
        $settle = $this->input->post('settle');
        //pa($_POST);
        //exit();
        $customer_balance=0;
        foreach ($param as $k => $v) {
            $arr = explode("|", $this->encryption->decrypt($v));
            ## PREPARE RAW DATA
            $trx_amt[$k] = [
                'id' => isset($arr[0]) ? $this->commonlib->toNumeric($arr[0]) : 0,
                'tot_amt' => isset($arr[1]) ? $this->commonlib->toNumeric($arr[1]) : 0,
                'due_amt' => isset($arr[2]) ? $this->commonlib->toNumeric($arr[2]) : 0,
                'paid_amt' => isset($arr[3]) ? $this->commonlib->toNumeric($arr[3]) : 0,
                'pay_amt' => isset($pay_amt[$k]) ? $this->commonlib->toNumeric($pay_amt[$k]) : 0,
                'settle' => ($settle[$k]==1) ? $settle[$k] : 0,
            ];
            $customer_balance+=($settle[$k]==1) ? $arr[2] : $this->commonlib->toNumeric($pay_amt[$k]);
            ## VALIDATE RAW DATA
            $this->form_validation->set_rules('pay_amt_' . ($k + 1), 'Pay Amount', "callback_isValidPayAmt[" . json_encode($trx_amt[$k]) . "]");
        }
        //pa($trx_amt);
        //exit;

        $this->form_validation->set_rules('dtt_trx', '', "callback_isValidPaymentDate[" . $this->input->post('dtt_trx') . "]");
        $this->form_validation->set_rules('store', 'Store', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('account', 'Account', "required|numeric|greater_than[0]|callback_isValidAccount[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('pay_method', '', "callback_isValidPaymentMethod[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_card', '', "callback_isValidCardForCardPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_bank', '', "callback_isValidBankForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_acc_no', '', "callback_isValidAccountForCheckPayment[" . $this->input->post('h_pay_method') . "]");

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $is_doc_attached = isset($_FILES['document_file']['tmp_name']) && file_exists($_FILES['document_file']['tmp_name']) ? 1 : 0;
            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank');
            $data = [
                //'trx_no' => $this->input->post('trx_no', TRUE),
                'trx_no' => $this->auto_increment->getAutoIncKey('TRANSACTION', 'sale_transactions'),
                'customer_id' => $this->input->post('customer_id', TRUE),
                'store_id' => $this->input->post('store', TRUE),
                'description' => $this->input->post('description', TRUE),
                'tot_amount' => $this->input->post('tot_amount', TRUE),
                'qty_multiplier' => $this->input->post('qty_multiplier', TRUE),
                'is_doc_attached' => $is_doc_attached,
                'dtt_trx' => date('Y-m-d H:i:s'),
                'dtt_add' => date('Y-m-d H:i:s'),
                'uid_add' => $this->session->userdata['login_info']['id_user_i90'],
                'status_id' => 1,
                'version' => 1,
            ];
            $payment_data = [
                'amount' => $this->input->post('tot_amount', TRUE),
                'account_id' => $this->input->post('account', TRUE),
                'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                'ref_acc_no' => $ref_acc_no,
                'ref_bank_id' => $ref_bank_id,
                'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
            ];

            $document_data = [];
            $document_name = $this->input->post('document_name', TRUE);
            $document_description = $this->input->post('document_description', TRUE);
            $document_file = $this->input->post('document_file');

            if ($is_doc_attached == 1) {
                $filename = upload_file('transaction', $_FILES['document_file']);
                if ($filename) {
                    $document_data = array(
                        'doc_type' => 'Transaction',
                        'name' => $document_name,
                        'description' => $document_description,
                        'file' => $filename,
                        'dtt_add' => $data['dtt_add'],
                        'uid_add' => $data['uid_add'],
                        'status_id' => '1',
                        'version' => '1'
                    );
                }
            }
            $sts = $this->trxmodel->addCustomerTransaction(
                $this->commonlib->trim_array($data),
                $this->commonlib->trim_array($payment_data),
                $trx_amt,
                $document_data,
                $customer_balance
            );
            $configs = $this->trxmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
            $sms_config = $this->trxmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 3));
            $cusArray = $this->trxmodel->getvalue_row('customers', 'full_name name,phone', array('id_customer' => $this->input->post('customer_id', TRUE)));
            $customerArray[]=array(
                'name'=>$cusArray[0]->name,
                'phone'=>$cusArray[0]->phone
            );
            if($configs[0]->param_val>0 && $sms_config[0]->sms_send ==1){
                $smsArray['sms_count']=1;
                $smsArray['unit_price']=$configs[0]->utilized_val;
                $smsArray['sms_type']=3;
                $smsArray['cus_data']=$customerArray;
                $msgarray=set_sms_send($smsArray);
                //print_r($data $msgarray;
               
            }
            
            $this->auto_increment->updAutoIncKey('TRANSACTION', $data['trx_no'], $data['trx_no']);
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }

    public function account_balance_by_id()
    {
        $id = $this->input->post('id', TRUE);
        $data = $this->commonmodel->getvalue_row_one('accounts', 'curr_balance', array('id_account' => $id));
        //print_r($data);
        echo $data[0]['curr_balance'];
    }


    public function edit_customer_transaction($id)
    {

        $id = $this->commonlib->decrypt_srting($id);
        $trx_upd_amt = [];
        $trx_del_amt = [];
        $trx_del_id = [];
        $param = $this->input->post('param');
        $pay_amt = $this->input->post('pay_amt');

        // Prepare Amount data
        foreach ($param as $k => $v) {
            $arr = explode("|", $this->encryption->decrypt($v));

            $tmp = [
                'sale_id' => isset($arr[0]) ? $this->commonlib->toNumeric($arr[0]) : 0,
                'tot_amt' => isset($arr[3]) ? $this->commonlib->toNumeric($arr[3]) : 0,
                'pay_amt' => isset($pay_amt[$k]) ? $this->commonlib->toNumeric($pay_amt[$k]) : 0,
                'due_amt' => isset($arr[2]) ? $this->commonlib->toNumeric($arr[2]) : 0,
                'paid_earlier_amt' => isset($arr[1]) ? $this->commonlib->toNumeric($arr[1]) : 0,
            ];

            if (empty($tmp['pay_amt'])) {
                $trx_del_id[] = $tmp['sale_id'];
                $trx_del_amt[$tmp['sale_id']] = $tmp['due_amt'] + $tmp['paid_earlier_amt'];
            } elseif ($tmp['pay_amt'] != $tmp['paid_earlier_amt']) {
                $trx_upd_amt[$k] = $tmp;
                // Validate Amount Data
                $this->form_validation->set_rules('pay_amt_' . ($k + 1), 'Pay Amount', "callback_isValidPayAmt[" . json_encode($trx_upd_amt[$k]) . "]");
            }
        }

        $this->form_validation->set_rules('dtt_trx', '', "callback_isValidPaymentDate[" . $this->input->post('dtt_trx') . "]");
        //$this->form_validation->set_rules('store', 'Store', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('account', 'Account', "required|numeric|greater_than[0]|callback_isValidAccount[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('pay_method', '', "callback_isValidPaymentMethod[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_card', '', "callback_isValidCardForCardPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_bank', '', "callback_isValidBankForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_acc_no', '', "callback_isValidAccountForCheckPayment[" . $this->input->post('h_pay_method') . "]");

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $is_doc_attached = isset($_FILES['document_file']['tmp_name']) && file_exists($_FILES['document_file']['tmp_name']) ? 1 : 0;
            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank');

            $data = [
                'description' => $this->input->post('description', TRUE),
                'tot_amount' => $this->input->post('tot_amount', TRUE),
                //'qty_multiplier' => $this->input->post('qty_multiplier'),
                //'is_doc_attached' => $is_doc_attached,
                'dtt_trx' => date('Y-m-d H:i:s'),
                'dtt_mod' => date('Y-m-d H:i:s'),
                'uid_mod' => $this->session->userdata['login_info']['id_user_i90'],
            ];
            $payment_data = [
                'amount' => $this->input->post('tot_amount', TRUE),
                'account_id' => $this->input->post('account', TRUE),
                'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                'ref_acc_no' => $ref_acc_no,
                'ref_bank_id' => $ref_bank_id,
                'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
            ];

            $document_data = [];
            $document_data_del = $this->input->post('doc_id', TRUE);
            $doc_file = $this->input->post('doc_file', TRUE);
            $document_name = $this->input->post('document_name', TRUE);
            $document_description = $this->input->post('document_description', TRUE);
            $document_file = $this->input->post('document_file');

            if ($is_doc_attached == 1) {
                if ($doc_file != '') {
                    delete_file('transaction', $doc_file);
                }
                $doc_file = upload_file('transaction', $_FILES['document_file']);
            }
            $document_data = array(
                'doc_type' => 'Transaction',
                'name' => $document_name,
                'description' => $document_description,
                'file' => $doc_file,
                'dtt_mod' => $data['dtt_mod'],
                'uid_mod' => $data['uid_mod']
            );

            $sts = $this->trxmodel->updCustomerTransaction(
                $id,
                $this->commonlib->trim_array($data),
                $this->commonlib->trim_array($payment_data),
                $trx_upd_amt,
                $trx_del_id,
                //$trx_del_amt, 
                $document_data_del,
                $document_data,
                $this->input->post('customer_id', TRUE)
            );
            echo json_encode($sts);
        }
    }


    public function add_supplier_transaction($id = 0)
    {
        $trx_amt = [];
        $param = $this->input->post('param');
        $pay_amt = $this->input->post('pay_amt');
        $settle = $this->input->post('settle');
        foreach ($param as $k => $v) {
            $arr = explode("|", $this->encryption->decrypt($v));
            // Prepare Raw data
            $trx_amt[$k] = [
                'id' => isset($arr[0]) ? $this->commonlib->toNumeric($arr[0]) : 0,
                'tot_amt' => isset($arr[1]) ? $this->commonlib->toNumeric($arr[1]) : 0,
                'due_amt' => isset($arr[2]) ? $this->commonlib->toNumeric($arr[2]) : 0,
                'paid_amt' => isset($arr[3]) ? $this->commonlib->toNumeric($arr[3]) : 0,
                'pay_amt' => isset($pay_amt[$k]) ? $this->commonlib->toNumeric($pay_amt[$k]) : 0,
                'settle' => isset($settle[$k]) ? $settle[$k] : 0,
            ];

            // Validate Raw Data
            $this->form_validation->set_rules('pay_amt_' . ($k + 1), 'Pay Amount', "callback_isValidPayAmt[" . json_encode($trx_amt[$k]) . "]");
        }
        $this->form_validation->set_rules('dtt_trx', '', "callback_isValidPaymentDate[" . $this->input->post('dtt_trx') . "]");
        $this->form_validation->set_rules('store', 'Store', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('account', 'Account', "required|numeric|greater_than[0]|callback_isValidAccount[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('pay_method', '', "callback_isValidPaymentMethod[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_card', '', "callback_isValidCardForCardPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_bank', '', "callback_isValidBankForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_acc_no', '', "callback_isValidAccountForCheckPayment[" . $this->input->post('h_pay_method') . "]");

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $is_doc_attached = isset($_FILES['document_file']['tmp_name']) && file_exists($_FILES['document_file']['tmp_name']) ? 1 : 0;
            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $amount_type= $this->input->post('amount_type', TRUE);
            $payment_type= $this->input->post('payment_type', TRUE);
            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank');
            $transation_no=$this->auto_increment->getAutoIncKey('TRANSACTION', 'transactions', 'trx_with');
            if ($payment_type==1){
                $type_id=1;
                $tot_amount=$this->input->post('tot_amount', TRUE);
            }elseif ($payment_type==2){
                $type_id=107;
                $tot_amount=$this->input->post('tot_amount', TRUE);
            }else{
                $type_id=108;
                $tot_amount=$this->input->post('debit_amount', TRUE);
            }
            $data = [
                //'trx_no' => $this->input->post('trx_no', TRUE),
                'trx_no' => $transation_no,
                'trx_with' => 'supplier',
                'ref_id' => (int)$this->input->post('supplier_id', TRUE),
                'store_id' => $this->input->post('store', TRUE),
                'description' => $this->input->post('description', TRUE),
                'trx_mvt_type_id' => $type_id,
                'tot_amount' => $tot_amount,
                'qty_multiplier' => $this->input->post('qty_multiplier', TRUE),
                'is_doc_attached' => $is_doc_attached,
                'account_id' => $this->input->post('account', TRUE),
                'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                'ref_acc_no' => $ref_acc_no,
                'ref_bank_id' => $ref_bank_id,
                'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
                'dtt_trx' => date('Y-m-d H:i:s'),
                'dtt_add' => date('Y-m-d H:i:s'),
                'uid_add' => $this->session->userdata['login_info']['id_user_i90'],
                'status_id' => 1,
                'version' => 1,
            ];
            if($this->input->post('debit_amount', TRUE)!=''&&$payment_type!=3){
                $d_amount= [
                    'trx_no' => $transation_no,
                    'trx_with' => 'supplier',
                    'ref_id' => (int)$this->input->post('supplier_id', TRUE),
                    'store_id' => $this->input->post('store', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'trx_mvt_type_id' => 106,
                    'tot_amount' => $this->input->post('debit_amount', TRUE),
                    'qty_multiplier' => $this->input->post('qty_multiplier', TRUE),
                    'is_doc_attached' => $is_doc_attached,
                    'account_id' => ($this->input->post('account', TRUE)!='')?$this->input->post('account', TRUE):0,
                    'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                    'ref_acc_no' => $ref_acc_no,
                    'ref_bank_id' => $ref_bank_id,
                    'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                    'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
                    'dtt_trx' => date('Y-m-d H:i:s'),
                    'dtt_add' => date('Y-m-d H:i:s'),
                    'uid_add' => $this->session->userdata['login_info']['id_user_i90']
                ];
            }else{
                $d_amount=array();
            }

            $document_data = [];
            $document_name = $this->input->post('document_name', TRUE);
            $document_description = $this->input->post('document_description', TRUE);
            $document_file = $this->input->post('document_file');

            if ($is_doc_attached == 1) {
                $doc_file = upload_file('transaction', $_FILES['document_file']);

                if ($doc_file) {
                    $document_data = array(
                        'doc_type' => 'Transaction',
                        'name' => $document_name,
                        'description' => $document_description,
                        'file' => $doc_file,
                        'dtt_add' => $data['dtt_add'],
                        'uid_add' => $data['uid_add'],
                        'status_id' => '1',
                        'version' => '1'
                    );
                }
            }
            $sts = $this->trxmodel->addSupplierTransaction($this->commonlib->trim_array($data), $trx_amt, $document_data,$this->commonlib->trim_array($d_amount),$payment_type,$amount_type);
            $this->auto_increment->updAutoIncKey('TRANSACTION', $data['trx_no'], $data['trx_no']);
            
            $configs = $this->trxmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
            $sms_config = $this->trxmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 4));
            $cusArray = $this->trxmodel->getvalue_row('suppliers', 'supplier_name name,phone', array('id_supplier' => $this->input->post('supplier_id', TRUE)));
            $customerArray[]=array(
                'name'=>$cusArray[0]->name,
                'phone'=>$cusArray[0]->phone
            );
            if($configs[0]->param_val>0 && $sms_config[0]->sms_send ==1){
                $smsArray['sms_count']=1;
                $smsArray['unit_price']=$configs[0]->utilized_val;
                $smsArray['sms_type']=4;
                $smsArray['cus_data']=$customerArray;
                $msgarray=set_sms_send($smsArray);
                //print_r($msgarray);
               
            }
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }

    public function edit_supplier_transaction($id)
    {
        $id = $this->commonlib->decrypt_srting($id);
        $trx_upd_amt = [];
        $trx_del_amt = [];
        $trx_del_id = [];
        $param = $this->input->post('param');
        $pay_amt = $this->input->post('pay_amt');
        foreach ($param as $k => $v) {
            $arr = explode("|", $this->encryption->decrypt($v));
            // Prepare Amount data
            $tmp = [
                'id' => isset($arr[0]) ? $this->commonlib->toNumeric($arr[0]) : 0,
                'tot_amt' => isset($arr[3]) ? $this->commonlib->toNumeric($arr[3]) : 0,
                'pay_amt' => isset($pay_amt[$k]) ? $this->commonlib->toNumeric($pay_amt[$k]) : 0,
                'due_amt' => isset($arr[2]) ? $this->commonlib->toNumeric($arr[2]) : 0,
                'paid_earlier_amt' => isset($arr[1]) ? $this->commonlib->toNumeric($arr[1]) : 0,
            ];

            if (empty($tmp['pay_amt'])) {
                $trx_del_id[] = $tmp['id'];
                $trx_del_amt[$tmp['id']] = $tmp['due_amt'] + $tmp['paid_earlier_amt'];
            } elseif ($tmp['pay_amt'] != $tmp['paid_earlier_amt']) {
                $trx_upd_amt[$k] = $tmp;
                // Validate Amount Data
                $this->form_validation->set_rules('pay_amt_' . ($k + 1), 'Pay Amount', "callback_isValidPayAmt[" . json_encode($trx_upd_amt[$k]) . "]");
            }
        }
        $this->form_validation->set_rules('dtt_trx', '', "callback_isValidPaymentDate[" . $this->input->post('dtt_trx') . "]");
        //$this->form_validation->set_rules('store', 'Store', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('account', 'Account', "required|numeric|greater_than[0]|callback_isValidAccount[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('pay_method', '', "callback_isValidPaymentMethod[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_card', '', "callback_isValidCardForCardPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_bank', '', "callback_isValidBankForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_acc_no', '', "callback_isValidAccountForCheckPayment[" . $this->input->post('h_pay_method') . "]");

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $is_doc_attached = isset($_FILES['document_file']['tmp_name']) && file_exists($_FILES['document_file']['tmp_name']) ? 1 : 0;
            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank', TRUE);
            $data = [
                'description' => $this->input->post('description', TRUE),
                'tot_amount' => $this->input->post('tot_amount', TRUE),
                //'is_doc_attached' => $is_doc_attached,
                'account_id' => $this->input->post('account', TRUE),
                'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                'ref_acc_no' => $ref_acc_no,
                'ref_bank_id' => $ref_bank_id,
                'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
                'dtt_trx' => date('Y-m-d H:i:s'),
                'dtt_mod' => date('Y-m-d H:i:s'),
                'uid_mod' => $this->session->userdata['login_info']['id_user_i90'],
            ];

            $document_data = [];
            $document_data_del = $this->input->post('doc_id', TRUE);
            $doc_file = $this->input->post('doc_file', TRUE);
            $document_name = $this->input->post('document_name', TRUE);
            $document_description = $this->input->post('document_description', TRUE);
            $document_file = $this->input->post('document_file');

            if ($is_doc_attached == 1) {
                if ($doc_file != '') {
                    delete_file('transaction', $doc_file);
                }
                $doc_file = upload_file('transaction', $_FILES['document_file']);
            }
            $document_data = array(
                'doc_type' => 'Transaction',
                'name' => $document_name,
                'description' => $document_description,
                'file' => $doc_file,
                'dtt_mod' => $data['dtt_mod'],
                'uid_mod' => $data['uid_mod']
            );
            $sts = $this->trxmodel->updSupplierTransaction($id, $this->commonlib->trim_array($data), $trx_upd_amt, $trx_del_id, $trx_del_amt, $document_data_del, $document_data);
            echo json_encode($sts);
        }
    }

    public function add_office_transaction($id = 0)
    {
        $this->form_validation->set_rules('dtt_trx', '', "callback_isValidPaymentDate[" . $this->input->post('dtt_trx') . "]");
        $this->form_validation->set_rules('store', 'Store', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('account', 'Account', "required|numeric|greater_than[0]|callback_isValidAccount[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('pay_method', '', "callback_isValidPaymentMethod[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_card', '', "callback_isValidCardForCardPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_bank', '', "callback_isValidBankForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_acc_no', '', "callback_isValidAccountForCheckPayment[" . $this->input->post('h_pay_method') . "]");

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $is_doc_attached = isset($_FILES['document_file']['tmp_name']) && file_exists($_FILES['document_file']['tmp_name']) ? 1 : 0;
            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $qty_multiplier = (int)$this->input->post('qty_multiplier', TRUE);
            $tt_expense = (int)$this->input->post('tt_expense', TRUE);
            $tt_income = (int)$this->input->post('tt_income', TRUE);
            $tt_child = (int)$this->input->post('tt_child', TRUE);


            // Set $ref_id
            if (!empty($tt_child)) {
                $ref_id = $tt_child;
            } else if ($qty_multiplier == -1) {
                $ref_id = $tt_expense;
            } else {
                $ref_id = $tt_income;
            }

            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank');
            $data = [
                //'trx_no' => $this->input->post('trx_no', TRUE),
                'trx_no' => $this->auto_increment->getAutoIncKey('TRANSACTION', 'transactions', 'trx_with'),
                'trx_with' => 'office',
                'ref_id' => $ref_id,
                'store_id' => $this->input->post('store', TRUE),
                'description' => $this->input->post('description', TRUE),
                'trx_mvt_type_id' => 101,
                'tot_amount' => $this->input->post('tot_amount', TRUE),
                'qty_multiplier' => $this->input->post('qty_multiplier', TRUE),
                'is_doc_attached' => $is_doc_attached,
                'account_id' => $this->input->post('account', TRUE),
                'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                'ref_acc_no' => $ref_acc_no,
                'ref_bank_id' => $ref_bank_id,
                'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
                'dtt_trx' => date('Y-m-d H:i:s'),
                'dtt_add' => date('Y-m-d H:i:s'),
                'uid_add' => $this->session->userdata['login_info']['id_user_i90'],
                'status_id' => 1,
                'version' => 1,
            ];

            $document_data = [];
            $document_name = $this->input->post('document_name', TRUE);
            $document_description = $this->input->post('document_description', TRUE);
            $document_file = $this->input->post('document_file');

            if ($is_doc_attached == 1) {
                $doc_file = upload_file('transaction', $_FILES['document_file']);

                if ($doc_file) {
                    $document_data = array(
                        'doc_type' => 'Transaction',
                        'name' => $document_name,
                        'description' => $document_description,
                        'file' => $doc_file,
                        'dtt_add' => $data['dtt_add'],
                        'uid_add' => $data['uid_add'],
                        'status_id' => '1',
                        'version' => '1'
                    );
                }
            }
            $configs = $this->trxmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
            $sms_config = $this->trxmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 5));
            $customerArray=array();
            if($configs[0]->param_val>0 && $sms_config[0]->sms_send ==1){
                $smsArray['sms_count']=1;
                $smsArray['unit_price']=$configs[0]->utilized_val;
                $smsArray['sms_type']=5;
                $smsArray['cus_data']=$customerArray;
                $msgarray=set_sms_send($smsArray);
                //print_r($msgarray);
               
            }
            $sts = $this->trxmodel->addOfficeTransaction($this->commonlib->trim_array($data), $document_data);
            $this->auto_increment->updAutoIncKey('TRANSACTION', $data['trx_no'], $data['trx_no']);
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }

    public function edit_office_transaction($id)
    {

        $id = $this->commonlib->decrypt_srting($id);
        $trx_upd_amt = [];
        $trx_del_amt = [];
        $trx_del_id = [];
        $param = $this->input->post('param');
        $pay_amt = $this->input->post('pay_amt');

        $this->form_validation->set_rules('dtt_trx', '', "callback_isValidPaymentDate[" . $this->input->post('dtt_trx') . "]");
        //$this->form_validation->set_rules('store', 'Store', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('account', 'Account', "required|numeric|greater_than[0]|callback_isValidAccount[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('pay_method', '', "callback_isValidPaymentMethod[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_card', '', "callback_isValidCardForCardPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_bank', '', "callback_isValidBankForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_acc_no', '', "callback_isValidAccountForCheckPayment[" . $this->input->post('h_pay_method') . "]");

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $is_doc_attached = isset($_FILES['document_file']['tmp_name']) && file_exists($_FILES['document_file']['tmp_name']) ? 1 : 0;
            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $qty_multiplier = (int)$this->input->post('qty_multiplier', TRUE);
            $tt_expense = (int)$this->input->post('tt_expense', TRUE);
            $tt_income = (int)$this->input->post('tt_income', TRUE);
            $tt_child = (int)$this->input->post('tt_child', TRUE);

            // Set $ref_id
            if (!empty($tt_child)) {
                $ref_id = $tt_child;
            } else if ($qty_multiplier == -1) {
                $ref_id = $tt_expense;
            } else {
                $ref_id = $tt_income;
            }

            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank');

            $data = [
                'ref_id' => $ref_id,
                'description' => $this->input->post('description', TRUE),
                'tot_amount' => $this->input->post('tot_amount', TRUE),
                //'is_doc_attached' => $is_doc_attached,
                'account_id' => $this->input->post('account', TRUE),
                'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                'ref_acc_no' => $ref_acc_no,
                'ref_bank_id' => $ref_bank_id,
                'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
                'dtt_trx' => date('Y-m-d H:i:s'),
                'dtt_mod' => date('Y-m-d H:i:s'),
                'uid_mod' => $this->session->userdata['login_info']['id_user_i90'],
            ];

            $document_data = [];
            $document_data_del = $this->input->post('doc_id', TRUE);
            $doc_file = $this->input->post('doc_file', TRUE);
            $document_name = $this->input->post('document_name', TRUE);
            $document_description = $this->input->post('document_description', TRUE);
            $document_file = $this->input->post('document_file');

            if ($is_doc_attached == 1) {
                if ($doc_file != '') {
                    delete_file('transaction', $doc_file);
                }
                $doc_file = upload_file('transaction', $_FILES['document_file']);
            }
            $document_data = array(
                'doc_type' => 'Transaction',
                'name' => $document_name,
                'description' => $document_description,
                'file' => $doc_file,
                'dtt_mod' => $data['dtt_mod'],
                'uid_mod' => $data['uid_mod']
            );

            $sts = $this->trxmodel->updOfficeTransaction($id, $this->commonlib->trim_array($data), $document_data_del, $document_data);
            echo json_encode($sts);
        }
    }

    public function add_employee_transaction($id = 0)
    {
        $this->form_validation->set_rules('dtt_trx', '', "callback_isValidPaymentDate[" . $this->input->post('dtt_trx') . "]");
        $this->form_validation->set_rules('store', 'Store', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('account', 'Account', "required|numeric|greater_than[0]|callback_isValidAccount[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('pay_method', '', "callback_isValidPaymentMethod[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_card', '', "callback_isValidCardForCardPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_bank', '', "callback_isValidBankForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_acc_no', '', "callback_isValidAccountForCheckPayment[" . $this->input->post('h_pay_method') . "]");

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $is_doc_attached = isset($_FILES['document_file']['tmp_name']) && file_exists($_FILES['document_file']['tmp_name']) ? 1 : 0;
            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank');
            $data = [
                //'trx_no' => $this->input->post('trx_no'),
                'trx_no' => $this->auto_increment->getAutoIncKey('TRANSACTION', 'transactions', 'trx_with'),
                'trx_with' => 'employee',
                'ref_id' => $this->input->post('employee_id'),
                'store_id' => $this->input->post('store', TRUE),
                'description' => $this->input->post('description', TRUE),
                'trx_mvt_type_id' => 102,
                'tot_amount' => $this->input->post('tot_amount', TRUE),
                'qty_multiplier' => $this->input->post('qty_multiplier'),
                'is_doc_attached' => $is_doc_attached,
                'account_id' => $this->input->post('account', TRUE),
                'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                'ref_acc_no' => $ref_acc_no,
                'ref_bank_id' => $ref_bank_id,
                'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
                'dtt_trx' => date('Y-m-d H:i:s'),
                'dtt_add' => date('Y-m-d H:i:s'),
                'uid_add' => $this->session->userdata['login_info']['id_user_i90'],
                'status_id' => 1,
                'version' => 1,
            ];

            $trx_type_id = $this->input->post('qty_multiplier') == -1 ? (int)$this->input->post('tt_payment') : (int)$this->input->post('tt_return');

            $document_data = [];
            $document_name = $this->input->post('document_name', TRUE);
            $document_description = $this->input->post('document_description', TRUE);
            $document_file = $this->input->post('document_file');

            if ($is_doc_attached == 1) {
                $doc_file = upload_file('transaction', $_FILES['document_file']);

                if ($doc_file) {

                    $document_data = array(
                        'doc_type' => 'Transaction',
                        'name' => $document_name,
                        'description' => $document_description,
                        'file' => $doc_file,
                        'dtt_add' => $data['dtt_add'],
                        'uid_add' => $data['uid_add'],
                        'status_id' => '1',
                        'version' => '1'
                    );
                }
            }
            $sts = $this->trxmodel->addEmployeeTransaction($this->commonlib->trim_array($data), $trx_type_id, $document_data);
            $this->auto_increment->updAutoIncKey('TRANSACTION', $data['trx_no'], $data['trx_no']);
            $configs = $this->trxmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
            $sms_config = $this->trxmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 6));
            $cusArray = $this->trxmodel->getvalue_row('users', 'fullname name,mobile phone', array('id_user' => $this->input->post('employee_id', TRUE)));
            $customerArray[]=array(
                'name'=>$cusArray[0]->name,
                'phone'=>$cusArray[0]->phone
            );
            if($configs[0]->param_val>0 && $sms_config[0]->sms_send ==1){
                $smsArray['sms_count']=1;
                $smsArray['unit_price']=$configs[0]->utilized_val;
                $smsArray['sms_type']=6;
                $smsArray['cus_data']=$customerArray;
                $msgarray=set_sms_send($smsArray);
                //print_r($msgarray);
               
            }
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }

    public function edit_employee_transaction($id)
    {
        $id = $this->commonlib->decrypt_srting($id);
        $trx_upd_amt = [];
        $trx_del_amt = [];
        $trx_del_id = [];
        $param = $this->input->post('param');
        $pay_amt = $this->input->post('pay_amt');

        $this->form_validation->set_rules('dtt_trx', '', "callback_isValidPaymentDate[" . $this->input->post('dtt_trx') . "]");
        $this->form_validation->set_rules('account', 'Account', "required|numeric|greater_than[0]|callback_isValidAccount[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('pay_method', '', "callback_isValidPaymentMethod[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_card', '', "callback_isValidCardForCardPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_bank', '', "callback_isValidBankForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_acc_no', '', "callback_isValidAccountForCheckPayment[" . $this->input->post('h_pay_method') . "]");

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $is_doc_attached = isset($_FILES['document_file']['tmp_name']) && file_exists($_FILES['document_file']['tmp_name']) ? 1 : 0;
            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank');
            $data = [
                'description' => $this->input->post('description', TRUE),
                'tot_amount' => $this->input->post('tot_amount', TRUE),
                //'is_doc_attached' => $is_doc_attached,
                'account_id' => $this->input->post('account', TRUE),
                'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                'ref_acc_no' => $ref_acc_no,
                'ref_bank_id' => $ref_bank_id,
                'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
                'dtt_trx' => date('Y-m-d H:i:s'),
                'dtt_mod' => date('Y-m-d H:i:s'),
                'uid_mod' => $this->session->userdata['login_info']['id_user_i90'],
            ];

            $document_data = [];
            $document_data_del = $this->input->post('doc_id', TRUE);
            $doc_file = $this->input->post('doc_file', TRUE);
            $document_name = $this->input->post('document_name', TRUE);
            $document_description = $this->input->post('document_description', TRUE);
            $document_file = $this->input->post('document_file');

            if ($is_doc_attached == 1) {
                if ($doc_file != '') {
                    delete_file('transaction', $doc_file);
                }
                $doc_file = upload_file('transaction', $_FILES['document_file']);
            }
            $document_data = array(
                'doc_type' => 'Transaction',
                'name' => $document_name,
                'description' => $document_description,
                'file' => $doc_file,
                'dtt_mod' => $data['dtt_mod'],
                'uid_mod' => $data['uid_mod']
            );

            $sts = $this->trxmodel->updEmployeeTransaction($id, $this->commonlib->trim_array($data), $document_data_del, $document_data);
            echo json_encode($sts);
        }
    }

    public function add_investor_transaction($id = 0)
    {

        $this->form_validation->set_rules('tot_amount', 'Amount', 'trim|xss_clean|required|numeric');
        $this->form_validation->set_rules('dtt_trx', '', "callback_isValidPaymentDate[" . $this->input->post('dtt_trx') . "]");
        $this->form_validation->set_rules('store', 'Store', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('account', 'Account', "required|numeric|greater_than[0]|callback_isValidAccount[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('pay_method', '', "callback_isValidPaymentMethod[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_card', '', "callback_isValidCardForCardPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_bank', '', "callback_isValidBankForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_acc_no', '', "callback_isValidAccountForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $is_doc_attached = isset($_FILES['document_file']['tmp_name']) && file_exists($_FILES['document_file']['tmp_name']) ? 1 : 0;
            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank');
            $data = [
                //'trx_no' => $this->input->post('trx_no'),
                'trx_no' => $this->auto_increment->getAutoIncKey('TRANSACTION', 'transactions', 'trx_with'),
                'trx_with' => 'investor',
                'ref_id' => $this->input->post('investor_id'),
                'store_id' => $this->input->post('store', TRUE),
                'description' => $this->input->post('description', TRUE),
                'trx_mvt_type_id' => 103,
                'tot_amount' => $this->input->post('tot_amount', TRUE),
                'qty_multiplier' => $this->input->post('qty_multiplier'),
                'is_doc_attached' => $is_doc_attached,
                'account_id' => $this->input->post('account', TRUE),
                'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                'ref_acc_no' => $ref_acc_no,
                'ref_bank_id' => $ref_bank_id,
                'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
                'dtt_trx' => date('Y-m-d H:i:s'),
                'dtt_add' => date('Y-m-d H:i:s'),
                'uid_add' => $this->session->userdata['login_info']['id_user_i90'],
                'status_id' => 1,
                'version' => 1,
            ];

            $trx_type_id = 0;
            $document_data = [];
            $document_name = $this->input->post('document_name', TRUE);
            $document_description = $this->input->post('document_description', TRUE);
            $document_file = $this->input->post('document_file');

            if ($is_doc_attached == 1) {
                $doc_file = upload_file('transaction', $_FILES['document_file']);
                if ($doc_file) {
                    $document_data = array(
                        'doc_type' => 'Transaction',
                        'name' => $document_name,
                        'description' => $document_description,
                        'file' => $doc_file,
                        'dtt_add' => $data['dtt_add'],
                        'uid_add' => $data['uid_add'],
                        'status_id' => '1',
                        'version' => '1'
                    );
                }
            }
            $sts = $this->trxmodel->addInvestorTransaction($this->commonlib->trim_array($data), $trx_type_id, $document_data);
            $this->auto_increment->updAutoIncKey('TRANSACTION', $data['trx_no'], $data['trx_no']);
            $configs = $this->trxmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
            $sms_config = $this->trxmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 7));
            $cusArray = $this->trxmodel->getvalue_row('users', 'fullname name,mobile phone', array('id_user' => $this->input->post('investor_id', TRUE)));
            $customerArray[]=array(
                'name'=>$cusArray[0]->name,
                'phone'=>$cusArray[0]->phone
            );
            if($configs[0]->param_val>0 && $sms_config[0]->sms_send ==1){
                $smsArray['sms_count']=1;
                $smsArray['unit_price']=$configs[0]->utilized_val;
                $smsArray['sms_type']=7;
                $smsArray['cus_data']=$customerArray;
                $msgarray=set_sms_send($smsArray);
                //print_r($msgarray);
               
            }
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }

    public function edit_investor_transaction($id)
    {
        $id = $this->commonlib->decrypt_srting($id);
        $trx_upd_amt = [];
        $trx_del_amt = [];
        $trx_del_id = [];
        $param = $this->input->post('param');
        $pay_amt = $this->input->post('pay_amt');


        $this->form_validation->set_rules('tot_amount', 'Amount', 'trim|xss_clean|required|numeric');
        $this->form_validation->set_rules('dtt_trx', '', "callback_isValidPaymentDate[" . $this->input->post('dtt_trx') . "]");
        //$this->form_validation->set_rules('store', 'Store', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('account', 'Account', "required|numeric|greater_than[0]|callback_isValidAccount[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('pay_method', '', "callback_isValidPaymentMethod[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_card', '', "callback_isValidCardForCardPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_bank', '', "callback_isValidBankForCheckPayment[" . $this->input->post('h_pay_method') . "]");
        $this->form_validation->set_rules('ref_acc_no', '', "callback_isValidAccountForCheckPayment[" . $this->input->post('h_pay_method') . "]");

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
        } else {
            $is_doc_attached = isset($_FILES['document_file']['tmp_name']) && file_exists($_FILES['document_file']['tmp_name']) ? 1 : 0;

            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank');
            $data = [
                'description' => $this->input->post('description', TRUE),
                'tot_amount' => $this->input->post('tot_amount', TRUE),
                'account_id' => $this->input->post('account', TRUE),
                'payment_method_id' => (int)$this->input->post('h_pay_method', TRUE),
                'ref_acc_no' => $ref_acc_no,
                'ref_bank_id' => $ref_bank_id,
                'ref_card_id' => (int)$this->input->post('ref_card', TRUE),
                'ref_trx_no' => $this->input->post('ref_trx_no', TRUE),
                'dtt_trx' => date('Y-m-d H:i:s'),
                'dtt_mod' => date('Y-m-d H:i:s'),
                'uid_mod' => $this->session->userdata['login_info']['id_user_i90'],
            ];

            $document_data = [];
            $document_data_del = $this->input->post('doc_id', TRUE);
            $doc_file = $this->input->post('doc_file', TRUE);
            $document_name = $this->input->post('document_name', TRUE);
            $document_description = $this->input->post('document_description', TRUE);
            $document_file = $this->input->post('document_file');
            if ($is_doc_attached == 1) {
                if ($doc_file != '') {
                    delete_file('transaction', $doc_file);
                }
                $doc_file = upload_file('transaction', $_FILES['document_file']);
            }
            $document_data = array(
                'doc_type' => 'Transaction',
                'name' => $document_name,
                'description' => $document_description,
                'file' => $doc_file,
                'dtt_mod' => $data['dtt_mod'],
                'uid_mod' => $data['uid_mod']
            );
            $sts = $this->trxmodel->updInvestorTransaction($id, $this->commonlib->trim_array($data), $document_data_del, $document_data);
            echo json_encode($sts);
        }
    }

    public function isValidPayAmt($str, $param)
    {
        $arr = json_decode($param, true);
        if ($arr['pay_amt'] > $arr['due_amt']) {
            $this->form_validation->set_message('isValidPayAmt', lang('invalid_amount'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function isValidPaymentDate($str, $param)
    {
        if (!$this->commonlib->isValidDate($param)) {
            $this->form_validation->set_message('isValidPaymentDate', lang('invalid_payment_date'));
            return FALSE;
        } elseif ($this->commonlib->isFutureDate($param)) {
            $this->form_validation->set_message('isValidPaymentDate', lang('future_date_not_allowed'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function isValidAccount($str, $param)
    {
        // 1=CashAccount, 3=MobileAccount, 0,3,4=BankAccount
        if (!in_array($param, [0, 1, 2, 3, 4])) {
            $this->form_validation->set_message('isValidAccount', lang('invalid_account'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function isValidPaymentMethod($str, $param)
    {

        // 2=card, 4=check
        if ($param == 0 && !in_array($str, [2, 4])) {
            $this->form_validation->set_message('isValidPaymentMethod', lang('invalid_payment_method'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function isValidCardForCardPayment($str, $param)
    {
        // 2=card, 4=check
        if ($param == 2 && empty($str)) {
            $this->form_validation->set_message('isValidCardForCardPayment', lang('invalid_card'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function isValidBankForCheckPayment($str, $param)
    {
        // 2=card, 4=check
        if ($param == 4 && empty($str)) {
            $this->form_validation->set_message('isValidBankForCheckPayment', lang('invalid_bank'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function isValidAccountForCheckPayment($str, $param)
    {
        // 2=card, 4=check
        if ($param == 4 && empty($str)) {
            $this->form_validation->set_message('isValidAccountForCheckPayment', lang('invalid_account'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function customer_trx_details($id)
    {
        $id = $this->commonlib->decrypt_srting($id);
        $data = $this->trxmodel->getCustomerTrxDetails($id);
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')['customer'];
        $data['trx_types'] = $this->trxmodel->listTrxTypes('customer');
        $this->load->view("transaction/details/customer", $data);
    }

    public function supplier_trx_details($id)
    {
        $id = $this->commonlib->decrypt_srting($id);
        $trx_array = $this->trxmodel->getTrxNo($id);
        //print_r($trx_array);
        $data = $this->trxmodel->getSupplierTrxIdDetails($trx_array[0]['trx_no']);
        $data['payment'] = $this->trxmodel->getSupplierTrxPayment($data['trx_no']);
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')['supplier'];
        $data['trx_types'] = $this->trxmodel->listTrxTypes('supplier');
        $this->load->view("transaction/details/supplier", $data);
    }

    public function office_trx_details($id)
    {
        $id = $this->commonlib->decrypt_srting($id);
        $data = $this->trxmodel->getOfficeTrxDetails($id);
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')['customer'];
        $data['trx_types'] = $this->trxmodel->listTrxTypes('customer');
        $this->load->view("transaction/details/office", $data);
    }

    public function employee_trx_details($id)
    {
        $id = $this->commonlib->decrypt_srting($id);
        $data = $this->trxmodel->getEmployeeTrxDetails($id);
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')['employee'];
        $data['trx_types'] = $this->trxmodel->listTrxTypes('employee');
        $this->load->view("transaction/details/employee", $data);
    }

    public function investor_trx_details($id)
    {
        $id = $this->commonlib->decrypt_srting($id);
        $data = $this->trxmodel->getInvestorTrxDetails($id);
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')['investor'];
        $data['trx_types'] = $this->trxmodel->listTrxTypes('investor');
        $this->load->view("transaction/details/investor", $data);
    }

    public function office_trx_chld_cats($parent_id, $qty_multiplier, $child_id = 0)
    {
        $arr = $this->trxmodel->office_trx_child_categories((int)$parent_id, (int)$qty_multiplier);
        if (!empty($arr)) {
            ?>
            <select class="form-control" data-live-search="true" id="tt_child" name="tt_child">
                <option value="0"><?= lang('select_one') ?></option><?php
                foreach ($arr as $k => $v) {
                    ?>
                    <option value="<?= $k; ?>" <?php if ($child_id == $k) {
                        echo 'selected';
                    } ?>><?= $v; ?></option><?php
                }
                ?>
            </select>
            <?php
        }
    }

    public function ajx_accounts_under_stores()
    {
        $stores = $this->input->post('stores');
        $accounts = $this->trxmodel->listTrxAccounts($stores);
        ?>
        <option actp="" value=""><?= lang('select_one') ?></option><?php
        if (!empty($accounts)) {
            foreach ($accounts as $account) {
                ?>
                <option actp="<?php echo $account['acc_type']; ?>"
                        value="<?php echo $account['acc_id']; ?>"><?php echo !empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name']; ?></option><?php
            }
        }
    }

    public function ajx_users_under_stores($user_type)
    {
        $stores = $this->input->post('stores');
        $users = $this->trxmodel->listTrxUsers($user_type, $stores);
        ?>
        <option actp="" value=""><?= lang('select_one') ?></option><?php
        if (!empty($users)) {
            foreach ($users as $key => $val) {
                ?>
                <option value="<?php echo $key; ?>"><?php echo $val; ?></option><?php
            }
        }
    }

    public function list_transaction_invoices()
    {
        $data = array();
        $this->dynamic_menu->check_menu('account-management/transaction-invoices');
        ## BREADCRUMB
        $this->breadcrumb->add(lang('accounts_management'), 'account-management/transactions/customer', 1);
        $this->breadcrumb->add(lang('transaction_invoices'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();

        $data['trx_wth_items'] = array_slice($this->config->item('transaction_with'), 0, 5);
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->trxmodel->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->trxmodel->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['trx_with'] = 'customer';

        $this->template->load('main', 'transaction/invoices/list_trx_invoices', $data);
    }

    public function search_transaction_invoices($page_num = 0)
    {
        $data = array();
        $this->dynamic_menu->check_menu('account-management/transaction-invoices');

        $data['trx_with'] = $this->input->post('trx_type');
        $data['trx_id'] = $this->input->post('trx_id');
        $data['inv_no'] = $this->input->post('inv_no');
        $data['from_date'] = $this->input->post('from_date');
        $data['to_date'] = $this->input->post('to_date');
        $data['store_id'] = $this->input->post('store_id');
        $data['page_num'] = $page_num;

        // $data['trx_with'] = 'customer';
        // $data['trx_id'] = '';
        // $data['inv_no'] = '';
        // $data['from_date'] = '';
        // $data['to_date'] = '';
        // $data['page_num'] = $page_num;

        $data['trx_wth_items'] = array_slice($this->config->item('transaction_with'), 0, 5);
        $data['transactions'] = $this->trxmodel->searchTransactions($data['trx_with'], $this->per_page_invoice, $data['page_num'], $data['from_date'], $data['to_date'], $data['trx_id'], $data['inv_no'],$data['store_id']);

        $config = [
            'target' => '#transactions',
            'base_url' => base_url() . 'account-management/transaction-invoices',
            'total_rows' => $data['transactions']['total'],
            'per_page' => $this->per_page_invoice,
            'link_func' => 'searchFilter',
        ];
        $this->ajax_pagination->initialize($config);

        $data['limit'] = $this->per_page_invoice;
        $data['offset'] = $data['page_num'];

        $data['qty_multipliers'] = isset($this->config->item('trx_type_qty_multipliers')[$data['trx_with']])
            ? $this->config->item('trx_type_qty_multipliers')[$data['trx_with']] : [];
        $data['stores'] = $this->commonmodel->listAllStores();

        if (in_array($data['trx_with'], $data['trx_wth_items'])) {
            $this->load->view("transaction/list_paginated/{$data['trx_with']}", $data);
        }
    }

    ## http://localhost/dpos/account_management/transaction/test
    public function test()
    {
        $t1 = $this->commonmodel->getAmtQtyMultiplierForOtherTrx(1);
        $t2 = $this->commonmodel->getAmtQtyMultiplierForCustomerTrx(1);
        pa($t1);
    }

    public function customer_print_invoice($id=null){
        $this->load->library('barcode');
        $data = $this->trxmodel->getCustomerTrxDetails($id);
        $data['store'] = $this->commonmodel->getvalue_row_one('stores', '*', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')['customer'];
        $data['trx_types'] = $this->trxmodel->listTrxTypes('customer');
        $data['settings'] = $this->commonmodel->invoice_setting_report('full');
        //$data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($id);
        
        $data['invoices'] = $this->trxmodel->get_customer_print_invoice($id);
         $this->load->view("transaction/list/customer_print", $data);
    }
    public function employee_print_invoice($id=null){
        $this->load->library('barcode');
        $data = $this->trxmodel->getEmployeeTrxDetails($id);
        $data['store'] = $this->commonmodel->getvalue_row_one('stores', '*', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')['employee'];
        $data['trx_types'] = $this->trxmodel->listTrxTypes('employee');
        $data['settings'] = $this->commonmodel->invoice_setting_report('full');
        //$data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($id);
        //$data['invoices'] = $this->trxmodel->get_customer_print_invoice($id);
         $this->load->view("transaction/list/employee_print", $data);
    }
    public function supplier_print_invoice($id=null){
        $this->load->library('barcode');
        $data = $this->trxmodel->getSupplierTrxDetails($id);
         //echo $data['trx_no'];
        //pa($data);
        $data['payment'] = $this->trxmodel->getSupplierTrxPayment($data['trx_no']);
        //pa($data['payment'] );
        $data['store'] = $this->commonmodel->getvalue_row_one('stores', '*', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')['supplier'];
        $data['trx_types'] = $this->trxmodel->listTrxTypes('supplier');
        $data['settings'] = $this->commonmodel->invoice_setting_report('full');
        //$data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($id);
        //$data['invoices'] = $this->trxmodel->get_customer_print_invoice($id);
         $this->load->view("transaction/list/supplier_print", $data);
    }
    public function office_print_invoice($id=null){
        $this->load->library('barcode');
        $data = $this->trxmodel->getOfficeTrxDetails($id);
        $data['store'] = $this->commonmodel->getvalue_row_one('stores', '*', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')['office'];
        $data['trx_types'] = $this->trxmodel->listTrxTypes('office');
        $data['settings'] = $this->commonmodel->invoice_setting_report('full');
        //$data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($id);
        //$data['invoices'] = $this->trxmodel->get_customer_print_invoice($id);
         $this->load->view("transaction/list/office_print", $data);
    }
    public function investor_print_invoice($id=null){
        $this->load->library('barcode');
        $data = $this->trxmodel->getInvestorTrxDetails($id);
        $data['store'] = $this->commonmodel->getvalue_row_one('stores', '*', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['qty_multipliers'] = $this->config->item('trx_type_qty_multipliers')['investor'];
        $data['trx_types'] = $this->trxmodel->listTrxTypes('investor');
        $data['settings'] = $this->commonmodel->invoice_setting_report('full');
        //$data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($id);
        //$data['invoices'] = $this->trxmodel->get_customer_print_invoice($id);
         $this->load->view("transaction/list/investor_print", $data);
    }
}
