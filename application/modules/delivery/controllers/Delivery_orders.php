<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_orders extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('delivery_model');
        $this->load->model('auto_increment');
        $this->perPage = 60;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('delivery_orders'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->delivery_model->getOrderData();
        $totalRec =($row!='')? count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'delivery_cost/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        $data['customers']=$this->delivery_model->getvalue_row_array('customers','id_customer,phone,customer_code,full_name as customer_name',array('status_id'=>1));
        //get the posts data
        $data['offset']=0;
        $data['posts'] = $this->delivery_model->getOrderData(array('limit' => $this->perPage));
        //$data['agents'] = $this->delivery_model->getvalue_row('agents', 'id_agent,agent_name',array('status_id' => 1));
        $this->template->load('main', 'delivery_orders/index', $data);
    }

    public function paginate_data()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $delivery_type = $this->input->post('delivery_type');
        $person_list = $this->input->post('person_list');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $ref_no = $this->input->post('ref_no');
        $status = $this->input->post('status');
        $customer_id = $this->input->post('customer_id');
        $invoice_no = $this->input->post('invoice_no');
        if (!empty($customer_id)) {
            $conditions['search']['customer_id'] = $customer_id;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($status)) {
            $conditions['search']['status'] = $status;
        }
        if (!empty($ref_no)) {
            $conditions['search']['ref_no'] = $ref_no;
        }
        if (!empty($delivery_type)) {
            $conditions['search']['delivery_type'] = $delivery_type;
        }
        if (!empty($person_list)) {
            $conditions['search']['person_name'] = $person_list;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }

        
        $totalRec = count($this->delivery_model->getOrderData($conditions));
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'delivery-orders/page-data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['offset']=$offset;
        //get posts data
        $data['posts'] = $this->delivery_model->getOrderData($conditions);
        //load the view
        $this->load->view('delivery_orders/all_order_data', $data, false);
    }

    public function order_details($id = null)
    {
        $this->breadcrumb->add(lang('delivery_orders'), 'delivery-orders', 1);
        $this->breadcrumb->add(lang('delivery_details'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $invoice_id = $id;
        $data['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store'=> $this->session->userdata['login_info']['store_id']));
        $data['transactions'] = $this->commonmodel->sale_transaction_details($invoice_id);
        $data['products'] = $this->commonmodel->getvalue_sale_details($invoice_id);
        $dataArray=array(
            'status_id'=>1,
            'sale_id'=>$invoice_id,
            'promotion_type_id !='=>1
        );
        $data['invoice']=$invoice_id;
        $data['promotions'] = $this->commonmodel->getvalue_row('sale_promotions', 'promotion_type_id,discount_rate,discount_amt', $dataArray);
        $data['invoices'] = $this->commonmodel->get_print_invoice($invoice_id);
        $data['agent'] = $this->delivery_model->get_agent_info($invoice_id);
        $data['delivery'] = $this->commonmodel->getvalue_row('delivery_order_details', '*', array('status_id'=>1, 'sale_id'=>$invoice_id));
        $data['accounts'] = $this->delivery_model->listAccounts($this->session->userdata['login_info']['store_ids']);
        $data['ref_no'] = $this->commonmodel->getvalue_row_one('delivery_orders', 'reference_num', array('sale_id'=> $invoice_id));
        //pa($data['delivery']);
        $this->template->load('main', 'delivery_orders/sale_order_view', $data);
    }

     public function costDetails_data($id = null)
    {
        $data = $this->delivery_model->get_cost_configure_details($id);
        echo json_encode($data);
    }

    public function delete_data($id = null)
    {
        $condition = array(
            'id_delivery_cost' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->delivery_model->update_value('delivery_costs', $data, $condition);
        echo json_encode(array("status" => TRUE));
    }
     public function checkAgentName() {
        $this->load->database();
        $name = $this->input->post('agent_name');
        $this->db->where('agent_name', $name);
        $this->db->where('status_id', 1);
        $query = $this->db->get('agents');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
     public function getStaff()
    {
        // $id = $this->input->post('id');
        $condition = array(
            'user_type_id' => 1,
            'status_id'=>1
        );
        $categories = $this->delivery_model->getvalue_row('users', 'fullname,id_user,mobile', $condition);
        echo json_encode($categories);
    }
    
    public function add_delivery_order_payment(){
        $sale_id = $this->input->post('sale_id');
        $order_id = $this->input->post('order_id');
        $customer_id = $this->input->post('customer_id');
        $p_amount = $this->input->post('p_amount');
        $d_amount = $this->input->post('d_amount');
        $accounts = $this->input->post('accounts');
         $status = $this->input->post('status');
         $ref_num = $this->input->post('ref_num');
        $payment_method_id = $this->input->post('method_id');
        $ref_trx_no= $this->input->post('ref_trx_no');
        $mobile_trx_no=($payment_method_id==3)?$ref_trx_no:'NULL';
        $store_id=$this->session->userdata['login_info']['store_id'];
        $uid = $this->session->userdata['login_info']['id_user_i90'];
        if( $p_amount > 0  || $d_amount>0){
            $trx_no = $this->auto_increment->getAutoIncKey('TRANSACTION', 'sale_transactions');
            $dataDelivery = "'" . $sale_id . "','" . $store_id . "','" . $customer_id . "','" . $p_amount . "','" . $d_amount . "','" . ($d_amount+$p_amount) . "','" . $trx_no
                . "','" . $accounts . "','" . $payment_method_id . "','" . $ref_trx_no . "','" . $status . "','" . date('Y-m-d H:i:s') . "','" . $uid. "','" . $ref_num;
            $qry_res = $this->db->query("CALL delivery_payment(" . $dataDelivery . "',@trn_id)");
            $query = $this->db->query("SElECT @trn_id AS trn_id");
            $query_r = $query->result_array();
            $trn_no_n=$trx_no+1;
            $this->auto_increment->updAutoIncKey('TRANSACTION',$trn_no_n, $trn_no_n);
            $tt=($query_r)?$query_r[0]['trn_id']:0;
        }
        else{

            $condition = array(
                'sale_id' => $order_id
            );
            $data['reference_num'] = $ref_num;    
            $data['order_status'] = $status;
            $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
            $data['dtt_mod'] = date('Y-m-d H:i:s');
            $this->delivery_model->update_value('delivery_orders', $data, $condition);
            $tt=1;    
        }
        
        echo $tt;
    }
    public function show_agent_staff_list()
    {
        $id = $this->input->post('id');
        //echo $id;
        //$id=1 staff
        $html = '';
        $html .= '<option value="0" selected>' . lang('select_one') . '</option>';
        if ($id == 2) {
            $agents = $this->delivery_model->getvalue_row('agents', 'id_agent,agent_name', array('status_id' => 1));
            if (!empty($agents)) {
                foreach ($agents as $agent) {
                    $html .= '<option value="' . $agent->id_agent . '@' . $agent->agent_name . '">' . $agent->agent_name . '</option>';
                }
            } 
        }
        if ($id == 1) {
            $staffs = $this->delivery_model->delivety_person_staff_list();
            if (!empty($staffs)) {
                foreach ($staffs as $staff) {
                    $html .= '<option value="' . $staff['id_delivery_person'] . '@' . $staff['person_name'] . '">' . $staff['person_name'] . '</option>';
                }
            }
        }
        echo $html;
    }
    public function create_csv_data()
    {
        $conditions=array();
        $delivery_type = $this->input->post('delivery_type');
        $person_list = $this->input->post('person_list');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $ref_no = $this->input->post('ref_no');
        if (!empty($ref_no)) {
            $conditions['search']['ref_no'] = $ref_no;
        }
        if (!empty($delivery_type)) {
            $conditions['search']['delivery_type'] = $delivery_type;
        }
        if (!empty($person_list)) {
            $conditions['search']['person_name'] = $person_list;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $posts = $this->delivery_model->getOrderData($conditions);
        $fields = array(
          'dtt_add' => 'Date'
        , 'sale_by' => 'Served By'
        , 'invoice_no' => 'Invoice No'
        , 'type_id' => 'Delivery Type'
        , 'agent_name' => 'Agent Name'
        , 'reference_num' => 'Reference Number'
        , 'customer_name' => 'Customer Name'
        , 'delivery_address' => 'Delivery Address'
        , 'customer_phone' => 'Customer Phone'
        , 'sale_amt' => 'Invoice Amount'
        , 'sale_paid' => 'Invoice Paid Amount'
       // , 'sale_round' => 'Invoice Round Amount'
        , 'sale_due' => 'Invoice Due Amount'
        , 'tot_amt' => 'Delivery Charge'
        , 'paid_amt' => 'Paid Amount'
        , 'tot_payable_amt' => 'Total Payable Amount'
        , 'tot_paid_amt' => 'Total Paid Amount'
        , 'tot_due_amt' => 'Total Due Amount'
        , 'order_status' => 'Status'
        , 'notes' => 'Note'
        );
        $tot_amount=0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $ttt=($post['type_id']==2)?'Agent':'Staf';
                $person=($post['type_id']==2)?$post['agent_name']:'Self';
                $order_status=$this->config->item('order_status');
                $total_payable_amt=$post['sale_amt']+ $post['tot_amt'];
                //$total_paid_amt=$post['sale_paid']+ $post['paid_amt']-$post['sale_round'];
                $total_paid_amt=$post['sale_paid']+ $post['paid_amt']-$post['sale_round'];
                $value[] = array(
                    'dtt_add' => nice_date($post['dtt_add'])
                    , 'sale_by' => $post['sale_by']
                    , 'invoice_no' => $post['invoice_no']
                    , 'type_id' => $ttt.' ('. $post['delivery_name'] .')'
                    , 'agent_name' => $person
                    , 'reference_num' => $post['reference_num']
                    , 'customer_name' => $post['customer_name']
                    , 'delivery_address' => $post['delivery_address']
                    , 'customer_phone' => $post['customer_phone']
                    , 'sale_amt' => $post['sale_amt']
                    , 'sale_paid' => $post['sale_paid']
                    //, 'sale_round' => $post['sale_round']
                    , 'sale_due' => $post['sale_due']
                    , 'tot_amt' => $post['tot_amt']
                    , 'paid_amt' => $post['paid_amt']
                    , 'tot_payable_amt' => $total_payable_amt
                    , 'tot_paid_amt' => $total_paid_amt
                    , 'tot_due_amt' =>$total_payable_amt-$total_paid_amt
                    , 'order_status' => $order_status[$post['order_status']]
                    , 'notes' => $post['notes']
                );
                $count++;
            }
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'delivery_orders'
        , 'file_title' => 'Delivery Orders'
        , 'field_title' => $fields
        , 'field_data' => $value
        , 'from' => ''
        , 'to' => ''
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

    public function return_data($id = null)
    {
        $this->breadcrumb->add(lang('delivery_orders'), 'delivery-orders', 1);
        $this->breadcrumb->add(lang('return'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $sale_id = $id;
        //$invoice = $this->input->post('invoice');
        $data['sales'] = $this->delivery_model->getvalue_row_one('sales', '*', array('id_sale' => $sale_id));
        if ($data['sales']) {
            $data['invoices'] = $this->commonmodel->get_print_invoice($sale_id);
            $data['agent'] = $this->delivery_model->get_agent_info($sale_id);
            $data['customer_id'] = $data['sales'][0]['customer_id'];
            $data['posts'] = $this->delivery_model->getvalue_row('sale_details_view', '*', array('sale_id' => $sale_id));
            $data['promotions'] = $this->delivery_model->getvalue_row('sale_promotions', '*', array('sale_id' => $sale_id, 'promotion_type_id!=' => 1));
            $data['delivery'] = $this->commonmodel->getvalue_row_one('delivery_orders', 'tot_amt,paid_amt,id_delivery_order', array('sale_id'=> $sale_id));
            $rr = $this->config->item('promotion_types');
        }
        $this->template->load('main', 'delivery_orders/order_return_view', $data);
    }
    public function add_sale_return()
    {
        try {
            $this->db->trans_start();
            //$cart_total = (int)$this->input->post('cart_total');
            $sale_id = (int)$this->input->post('sale_id');
            //$dis_amt = (int)$this->input->post('dis_amt');
            $order_id = (int)$this->input->post('order_id');
            
            $total_invoice_amt = (int)$this->input->post('total_invoice_amt');
            $total_paid_amt = (int)$this->input->post('total_paid_amt');
            $sales = $this->delivery_model->getvalue_row_one('sales', '*', array('id_sale' => $sale_id));
            //`ref_sale_id` `type_id` `invoice_no` `store_id` `station_id` `customer_id` `product_amt` `vat_amt` `discount_amt` `round_amt` `tot_amt` `paid_amt` `due_amt`
            $data['invoice_no'] = time();
            $data['type_id'] = 1;
            $data['ref_sale_id'] = $sale_id;
            $data['store_id'] = $this->session->userdata['login_info']['store_id'];
            $data['customer_id'] = $sales[0]['customer_id'];
            $data['product_amt'] = $sales[0]['product_amt'];
            $data['vat_amt'] = $sales[0]['vat_amt'];
            $data['discount_amt'] = $sales[0]['discount_amt'];
            $data['tot_amt'] = $sales[0]['tot_amt'];
            $data['paid_amt'] = $sales[0]['tot_amt'];
            $data['station_id'] = $this->session->userdata['login_info']['station_id'];
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $result = $this->delivery_model->common_insert('sale_adjustments', $data);
            $original_points = 0;
            $point_balance = $this->commonmodel->getvalue_row_one('configs', 'param_val', array('param_key' => 'POINT_EARN_RATIO'));
            $per_point_balance = $point_balance[0]['param_val'];
            $minus_points=0;
            if($per_point_balance > 0){
                $minus_points = $data['tot_amt'] / $per_point_balance;
                $this->commonmodel->update_balance_amount('customers', 'points', $minus_points, '-', array('id_customer' => $sales[0]['customer_id']));
            }
            $condition = array(
                'id_delivery_order' => $order_id
            );
            $array=array(
                'order_status'=>4
                ,'dtt_mod'=>date('Y-m-d H:i:s')
                ,'uid_mod'=>$this->session->userdata['login_info']['id_user_i90']
            );
            $this->delivery_model->update_value('delivery_orders', $array,$condition);

            $data2['minus_points'] = $minus_points;
            if ($result) {
                $posts = $this->delivery_model->getvalue_row_array('sale_details', '*', array('sale_id' => $sale_id,'sale_type_id'=>1));
                foreach ($posts as $value) {
                    $product = array();
                    $product['sale_id'] = $result;
                    $product['sale_type_id'] = 2;
                    $product['qty_multiplier'] = 1;
                    $product['stock_id'] = $value['stock_id'];
                    $product['product_id'] = $value['product_id'];
                    $product['cat_id'] = $value['cat_id'];
                    $product['subcat_id'] = $value['subcat_id'];
                    $product['brand_id'] = $value['brand_id'];
                    $product['qty'] = $value['qty'];
                    $product['unit_id'] = $value['unit_id'];
                    $product['selling_price_est'] = $value['selling_price_est'];
                    $product['selling_price_act'] = $value['selling_price_act'];
                    $product['discount_rate'] = $value['discount_rate'];
                    $product['discount_amt'] = $value['discount_amt'];
                    $product['vat_rate'] = $value['vat_rate'];
                    $product['vat_amt'] =$value['vat_amt'];
                    $product['dtt_add'] = date('Y-m-d H:i:s');
                    $product['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $details = $this->delivery_model->common_insert('sale_details', $product);
                    //$this->commonmodel->update_balance_amount('stocks', 'qty', $return_qty[$i], '+', array('id_stock' => $posts[0]['stock_id']));
                    $this->delivery_model->update_value_add('stocks', 'qty', $value['qty'], array('id_stock' => $value['stock_id']));
                }
                $this->commonmodel->updAccCurrBalance($this->session->userdata['login_info']['station_acc_id'], $sales[0]['tot_amt'], -1);
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Error in Sale Return");
            }   
            $type = 'success';
            $msg = 'Return Successfully..';
            $sts = TRUE;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
            $sts = FALSE;
            $type = 'error';
        }
        echo json_encode(array("status" => $type, "message" => $msg));
        //$this->load->library('barcode');
        //$invoice_id = $id;
        //$data2['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store' => $this->session->userdata['login_info']['store_id']));
        //$data2['transactions'] = $this->commonmodel->sale_transaction_details($sale_id);
        //$data2['products'] = $this->commonmodel->getvalue_sale_return_details($result);
        // $dataArray = array(
        //     'status_id' => 1,
        //     'sale_id' => $sale_id,
        //     'promotion_type_id !=' => 1
        // );
        // $data2['promotions'] = $this->commonmodel->getvalue_row('sale_promotions', 'promotion_type_id,discount_rate,discount_amt', $dataArray);
        // $data2['invoices'] = $this->commonmodel->get_sellReturn_print_invoice($result);
        //$this->load->view('sales/sale_returns/saleReturn_view_print', $data2, false);
        //echo json_encode(array('success'=>true,'message'=>'success'));

    }
}
