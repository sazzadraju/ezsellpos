<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_commission extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }
        $this->form_validation->CI = &$this;
        $this->load->model('auto_increment');
        $this->load->model('sales_model');
        $this->load->model('sales_model');
        $this->load->model('auto_increment');
        $this->load->model('account_settings/Bank_model');
        $this->load->model('account_settings/Card_model');
        $this->perPage = 50;
    }

    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('sales-person');
        $this->breadcrumb->add(lang('sales_person'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->sales_model->sales_commission_list();
        $totalRec = ($row)?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'sales_commission/paginate_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['posts']=$this->sales_model->sales_commission_list(array('limit' => $this->perPage));
        $data['store_name_p'] = $this->session->userdata['login_info']['store_id'];
        $data['station_name_p'] = $this->session->userdata['login_info']['station_id'];
        $this->template->load('main', 'sales_commission/index', $data);
    }
    public function paginate_data(){
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $totalRec = count($this->sales_model->sales_commission_list());
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'sales_person/paginate_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['posts'] =$this->sales_model->sales_commission_list($conditions);
        //load the view
        $this->load->view('sales_commission/all_sales_commission_data',$data, false);
    }
    public function add_sales_commission(){
        $data = array();
        $this->dynamic_menu->check_menu('sales-commission');
        $this->breadcrumb->add(lang('sales_commission'),'sales-commission', 1);
        $this->breadcrumb->add(lang('add_sales_transaction'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['salesPersons']=$this->sales_model->getSales_person_list(array());
        $data['accounts'] = $this->sales_model->listAccounts($this->session->userdata['login_info']['store_ids']);
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['stores'] = $this->commonmodel->listAllStores();
        $this->template->load('main', 'sales_commission/add_commission', $data);
    }

    public function sales_person_balance(){
        $id = $this->input->post('id');
        $data['comm'] = $this->input->post('com');
        $data['invoice']=$this->input->post('invoice');
        $data['parsons']=$this->sales_model->getvalue_row('sales_person', 'curr_balance,commission',array('id_sales_person'=>$id,'status_id'=>1));
        if( $data['invoice']==2){
            $data['unpaid_invoice']=$this->sales_model->getvalue_row('sales_person_comm', 'id_sales_person_comm,invoice_no,dtt_add',array('sales_person_id'=>$id,'due_amt >'=>0,'status_id'=>2));
        }else{
            $data['unpaid_sales']=$this->sales_model->getvalue_row('sales', 'invoice_no,tot_amt,dtt_add,id_sale',array('sales_person_id'=>$id,'commission'=>1));
        }
        // echo $data[0]->curr_balance commission;
        $this->load->view('sales_person/unpaid_sales',$data, false);
    }
    public function due_sales_commission(){
        $id = $this->input->post('id');
        $data['sales_persons']=$this->sales_model->getvalue_row('sales_person_comm', '*',array('id_sales_person_comm'=>$id));
        $data['unpaid_sales_details']=$this->sales_model->deo_unpaid_sales($id);
        $html_view=$this->load->view('sales_person/due_unpaid_sales',$data, true);
        echo json_encode(array('htmlView'=>$html_view,'pre_due'=>$data['sales_persons'][0]->due_amt));
    }
    public function add_sales_commission_submit(){
        $this->form_validation->set_rules('store_id', lang('stores'), 'trim|required|callback_select_validate');
        $this->form_validation->set_rules('sales_person', lang('sales_person'), 'trim|required|callback_select_validate');
        $this->form_validation->set_rules('pay_amount', lang('payment'), 'trim|required|numeric');
        $this->form_validation->set_rules('paid_amount', lang('paid_amount'), 'trim|required|numeric|less_than['.$this->input->post('pay_amount').']');
        $this->form_validation->set_rules('account', lang('payment_type'), 'required|callback_select_validate');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $ref_acc_no = $this->input->post('ref_acc_no', TRUE);
            $ref_bank_id = $ref_acc_no == 3 ? (int)$this->input->post('ref_mobile_bank') : (int)$this->input->post('ref_bank');
            $amount= ($this->input->post('pay_amount')!='')?$this->input->post('pay_amount', TRUE):0;
            $account_id = $this->input->post('account', TRUE);
            $payment_method_id = (int)$this->input->post('h_pay_method', TRUE);
            $ref_acc_no = $ref_acc_no;
            $ref_bank_id = $ref_bank_id;
            $ref_card_id = (int)$this->input->post('ref_card', TRUE);
            $ref_trx_no = $this->input->post('ref_trx_no', TRUE);
            $note = $this->input->post('note');
            $sale_id = $this->input->post('sl_id');
            $store_id = $this->input->post('store_id');
            $pay_amt = $this->input->post('pay_amt');
            $invoice_amt=$this->input->post('pay_amt_tot');
            $paid_amt = $this->input->post('paid_amount');
            $total_amt = $this->input->post('pay_amount');
            $sales_person = $this->input->post('sales_person');
            $sale_total = $this->input->post('sale_total');
            $comm_amt = $this->input->post('comm_amt');
            $sales_commission = $this->input->post('sales_commission');
            $dp_sales_person_id = $this->input->post('dp_sales_person_id');
            $update_id=0;
            if(isset($dp_sales_person_id)){
                $update_id=$dp_sales_person_id;
            }else{
                $this->db->query("CALL tmp_sales_comm_details()");
                for($i=0; $i<count($sale_id);$i++){
                    // $html=$checks[$i];
                    $uid_add = $this->session->userdata['login_info']['id_user_i90'];
                    $data['sale_id'] = $sale_id[$i];
                    $data['invoice_amt'] = $sale_total[$i];
                    $data['comm_amt'] = $comm_amt[$i];
                    $data['commission'] = $pay_amt[$i];
                    $data['dtt_add'] = date('Y-m-d H:i:s');
                    $this->sales_model->common_insert('tmp_sales_person_comm_details', $data);
                }
            }

            $due_amt=$total_amt-$paid_amt;

            if($this->input->post('sataled')==1){
                $total_amt=$paid_amt;
                $due_amt=0;
            }
            $status_id=($due_amt==0)?1:2;
            $uid = $this->session->userdata['login_info']['id_user_i90'];
            $trx_no=$this->auto_increment->getAutoIncKey('TRANSACTION', 'transactions', 'trx_with');
            $invoice_no=$this->auto_increment->getAutoIncKey('SALES_COMMISSION', 'sales_person_comm', 'invoice_no');
            $dataOrder ="'" . $invoice_no.  "','" . $trx_no . "','" . $store_id . "','" . $sales_person. "','" . $sales_commission. "','" . $invoice_amt. "','" . $total_amt. "','"
                . $paid_amt. "','" . $due_amt . "','"
                . $account_id. "','" . $payment_method_id. "','" . $ref_acc_no. "','" . $ref_bank_id. "','" . $ref_card_id. "','" . $ref_trx_no.  "','" .date('Y-m-d H:i:s') . "','" . $uid. "','" . $note. "','" . $status_id. "','" . $update_id;
            $qry_res = $this->db->query("CALL sales_person_commission(" . $dataOrder . "',@commission_id)");
            $query = $this->db->query("SElECT @commission_id AS commission_id");
            $query_res = $query->result_array();
            if($query_res){
                $this->auto_increment->updAutoIncKey('TRANSACTION', $trx_no, $trx_no);
                $this->auto_increment->updAutoIncKey('SALES_COMMISSION', $invoice_no, $invoice_no);
            }
            $massage = 'Successfully data added..';
            echo json_encode(array("status" => "success", "message" => $massage));
        }
    }
    function select_validate($abcd)
    {
        if($abcd==0){
            $this->form_validation->set_message('select_validate', 'Please Select Any One.');
            return false;
        } else{
            return true;
        }
    }




}
