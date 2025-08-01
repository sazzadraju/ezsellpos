<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Add_order extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->lang->load('en');
        $this->form_validation->CI = &$this;
        $this->load->model('order_model');
        $this->load->model('sales_model');
        $this->load->model('auto_increment');
        $this->load->model('account_settings/Bank_model');
        $this->load->model('account_settings/Card_model');
        $this->perPage = 30;
    }

    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('add-order');
        $this->breadcrumb->add(lang('order_list'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->sales_model->getSales_person_list();
        $totalRec = ($row)?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'add-order/paginate-data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['offset']=0;
        $data['posts']=$this->order_model->getOrderList(array('limit' => $this->perPage));
        $this->template->load('main', 'add_order/index', $data);
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
        //total rows count
        $rec=$this->order_model->getOrderList();
        $totalRec = count($rec);
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'add-order/paginate-data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['offset']=$offset;
        $data['posts']=$this->order_model->getOrderList($conditions);
        $this->load->view('add_order/all_order_data',$data, false);
    }

    public function add_order_data(){
        $data = array();
        $this->dynamic_menu->check_menu('add-order');
        $this->breadcrumb->add(lang('order_list'),'add-order', 1);
        $this->breadcrumb->add(lang('add'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['customers'] = $this->sales_model->getvalue_row('customers', 'id_customer,phone,full_name', array('status_id' => 1));
        $data['salesPersons']=$this->sales_model->getSales_person_list(array());
        $data['accounts'] = $this->sales_model->listAccounts($this->session->userdata['login_info']['store_ids']);
        $data['general_banks'] = $this->Bank_model->listBanksAll(1);
        $data['mobile_banks'] = $this->Bank_model->listBanksAll(2);
        $data['cards'] = $this->Card_model->listCards();
        $data['posts'] = $this->sales_model->getvalue_row('products', '*', array('status_id' => '1'));
        $this->template->load('main', 'add_order/add_order', $data);
    }
    public function add_order_row(){
        $id=$this->input->post('id');
        $data['row']=$this->input->post('row');
        $data['posts'] = $this->order_model->productListWithStock($id);
        $store_id= $this->session->userdata['login_info']['store_id'];
        $brand =  $data['posts'][0]['brand_id'];
        $cat =  $data['posts'][0]['cat_id'];
        $subcat =  $data['posts'][0]['subcat_id'];
        $promotions = $this->sales_model->getvalue_row('promotion_products_view', '*', array('store_id' => $store_id));
        $discount_per = 0;$promotion_id='';
        if ($promotions) {
            foreach ($promotions as $promotion) {
                if ($promotion->type_id == 1) {
                    $chk_promo = 1;
                    if (($brand == $promotion->brand_id) && ($cat == $promotion->cat_id)) {
                        $chk_promo = 2;
                    } else if (($brand == $promotion->brand_id) && ($subcat == $promotion->subcat_id)) {
                        $chk_promo = 2;
                    } else if (($brand == $promotion->brand_id) && ($promotion->cat_id == NULL) && ($promotion->subcat_id == NULL)) {
                        $chk_promo = 2;
                    } else if (($cat == $promotion->cat_id) && ($promotion->subcat_id == NULL) && ($promotion->brand_id == NULL)) {
                        $chk_promo = 2;
                    } else if (($subcat == $promotion->subcat_id) && ($cat == $promotion->cat_id) && ($promotion->subcat_id == NULL)) {
                        $chk_promo = 2;
                    }
                    if ($chk_promo == 2) {
                        if ($promotion->discount_rate != NULL) {
                            $discount_per = $promotion->discount_rate;
                            $promotion_id = $promotion->promotion_id;
                        }
                    }
                }

            }
        }
        $data['promotion_id']=$promotion_id;
        $data['dis_per']=$discount_per;
        $this->load->view('add_order/add_row_data', $data);
    }
    public function add_order_submit(){
        $pro_id = $this->input->post('pro_id');
        $qty = $this->input->post('qty');
        $order_type = $this->input->post('order_type');

        $unit_price = $this->input->post('unit_price');
        $discount = $this->input->post('discount');
        $discount_amt = $this->input->post('discount_amt');
        $vat_amt = $this->input->post('vat_amt');
        $promotion_id = $this->input->post('promotion_id', TRUE);
        $vat = $this->input->post('vat');
        $total_price = $this->input->post('total_price');
        $subTotal = $this->input->post('subTotal');
        $customer_name = $this->input->post('customer_name');
        $sales_person = $this->input->post('sales_person');
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
        $discount_amount=0;$vat_tot=0;$unit_price_tot=0;
        $this->db->query("CALL temp_order_details()");
        for ($i = 0; $i < count($pro_id); $i++) {
            $product = array();
            $product['product_id'] = $pro_id[$i];
            $product['promotion_id'] = $promotion_id[$i];
            $product['qty'] = $qty[$i];
            $product['discount_rate'] = $discount[$i];
            $product['discount_amt'] = $discount_amt[$i];
            $product['unit_price'] = $unit_price[$i];
            $product['vat_rate'] = $vat[$i];
            $product['vat_amt'] = $vat_amt[$i];
            $product['total_price'] = $total_price[$i];
            $details = $this->commonmodel->commonInsertSTP('temp_order_details', $product);
            $discount_amount += (($unit_price[$i]*$qty[$i])*$discount[$i])/100;
            $vat_tot+=((($unit_price[$i]*$qty[$i])-$discount_amount)*$vat[$i])/100;
            $unit_price_tot+= $unit_price[$i];
        }
        $store_id= $this->session->userdata['login_info']['store_id'];
        $uid = $this->session->userdata['login_info']['id_user_i90'];
        $invoice=$this->auto_increment->getAutoIncKey('ORDER', 'orders');
        $trx_no=$this->auto_increment->getAutoIncKey('TRANSACTION', 'sale_transactions');
        $dataOrder = "'" . $invoice . "','" . $store_id . "','" . $account_id . "','" . $customer_name . "','" . $sales_person . "','" . $unit_price_tot . "','" . $vat_tot
            . "','" . $discount_amount . "','" . $subTotal . "','" . $amount . "','" . ($subTotal-$amount)
            . "','" . date('Y-m-d H:i:s') . "','" . $uid. "','" . $note. "','" . $trx_no. "','" . $account_id. "','" . $payment_method_id. "','" . $ref_acc_no. "','" . $ref_bank_id. "','" . $ref_card_id. "','" . $ref_trx_no;
        $qry_res = $this->db->query("CALL order_add(" . $dataOrder . "',@order_id)");
        $query = $this->db->query("SElECT @order_id AS order_id");
        $query_res = $query->result_array();
        if($query_res){
            $configs = $this->commonmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
            $sms_config = $this->commonmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 10));
            $cusArray = $this->commonmodel->getvalue_row('customers', 'full_name name,phone', array('id_customer' => $customer_name));
            $customerArray[]=array(
                'name'=>$cusArray[0]->name,
                'phone'=>$cusArray[0]->phone
            );
            if($configs[0]->param_val>0 && $sms_config[0]->sms_send ==1){
                $smsArray['sms_count']=1;
                $smsArray['unit_price']=$configs[0]->utilized_val;
                $smsArray['sms_type']=10;
                $smsArray['cus_data']=$customerArray;
                $msgarray=set_sms_send($smsArray);
                //print_r($msgarray);
               
            }
            $this->auto_increment->updAutoIncKey('TRANSACTION', $trx_no, $trx_no);
            $this->auto_increment->updAutoIncKey('ORDER', $invoice, $invoice);
            if($order_type=='print'){
                $this->load->library('barcode');
                $data['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store' => $this->session->userdata['login_info']['store_id']));
                $data['transactions'] = $this->order_model->order_transaction_details($query_res[0]['order_id']);
                $data['products'] = $this->order_model->orderDetailsById($query_res[0]['order_id']);
                $data['settings'] = $this->commonmodel->invoice_setting_report('full');
                $data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($query_res[0]['order_id']);
                $data['invoices'] = $this->order_model->get_order_print_invoice($query_res[0]['order_id']);
                $this->load->view('add_order/invoice_a4_print_view', $data, false);
            }else{
                echo 3;
            }
        }

    }
    public function print_invoice($id=null){
        $this->load->library('barcode');
        $data['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['transactions'] = $this->order_model->order_transaction_details($id);
        $data['products'] = $this->order_model->orderDetailsById($id);
        $data['settings'] = $this->commonmodel->invoice_setting_report('full');
        $data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($id);
        $data['invoices'] = $this->order_model->get_order_print_invoice($id);
        $this->load->view('add_order/invoice_a4_print_view', $data, false);

    }
    public function order_details_data(){
        $id=$this->input->post('id');
        $data['posts'] = $this->order_model->orderDetailsById($id);
        $this->load->view('add_order/order_details_data', $data);
    }
    public function order_cancel_data(){
        $id=$this->input->post('id');
        $data['posts'] = $this->order_model->orderCancelById($id);
        $data['id']=$id;
        $this->load->view('add_order/order_cancel_data', $data);
    }
    public function cancel_order(){
        $id=$this->input->post('id');
        $ret_amt=$this->input->post('ret_amt');

        if($ret_amt==''){
            $data = $this->order_model->cancelOrder(array('id'=>$id,'ret_amt'=>$ret_amt));
        }else{
            $customer_id=$this->input->post('customer_id');
            $store_id = $this->session->userdata['login_info']['store_id'];
            $station_id = $this->session->userdata['login_info']['station_id'];
            $uid = $this->session->userdata['login_info']['id_user_i90'];
            $trx_no=$this->auto_increment->getAutoIncKey('TRANSACTION', 'sale_transactions');
            $dataOrder = "'" . $trx_no . "','" . $id . "','" . $store_id . "','" . $station_id . "','" . $customer_id . "','" . $ret_amt
                . "','" . date('Y-m-d H:i:s') . "','" . $uid;
            $qry_res = $this->db->query("CALL order_cancel_data(" . $dataOrder . "',@order_id)");
            $query = $this->db->query("SElECT @order_id AS order_id");
            $query_res = $query->result_array();
            $this->auto_increment->updAutoIncKey('TRANSACTION', $trx_no, $trx_no);
        }




        echo 2;
    }


}
