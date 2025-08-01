<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_returns extends MX_Controller
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
        $this->load->model('sales_model');
        $this->perPage = 20;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('sales'), 'sales', 1);
        $this->breadcrumb->add(lang('sale_returns'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['banks'] = $this->sales_model->get_bank_name($this->session->userdata['login_info']['store_id']);
        // $this->bd->last_query();
        //echo '<pre>';
        //print_r($data['banks']);
        // echo '</pre>';```id_card_type` ``

        $data['vat'] = $this->sales_model->getvalue_row_one('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        $data['card_type'] = $this->sales_model->getvalue_row('card_types', 'id_card_type,card_name', array());
        $data['card_promotions'] = $this->sales_model->getvalue_row('promotion_products_view', 'title,type_id,discount_rate,promotion_id', array('type_id' => '3'));
        $data['customer_type_list'] = $this->sales_model->getvalue_row('customer_types', 'id_customer_type,name', array('status_id' => '1'));

// $data['records'] = $this->user_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'TOT_STATIONS'));
        //$data['posts'] = $this->user_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $this->template->load('main', 'sales/sale_returns/index', $data);
    }

    public function temp_add_return_sale()
    {
        $invoice = $this->input->post('invoice');
        $data['sales'] = $this->sales_model->getvalue_row_one('sales', '*', array('invoice_no' => $invoice));
        if ($data['sales']) {
            $saleId = $data['sales'][0]['id_sale'];
            $dArray= $this->sales_model->getvalue_row_one('delivery_orders', 'id_delivery_order', array('sale_id' => $saleId));
            $data['delivery']=($dArray!='')?'1':'';
            $data['returns'] = $this->sales_model->return_product_list($data['sales'][0]['id_sale']);
           
            $data['customer_id'] = $data['sales'][0]['customer_id'];
            $data['posts'] = $this->sales_model->getvalue_row('sale_details_view', '*', array('sale_id' => $saleId));
            $data['promotions'] = $this->sales_model->getvalue_row('sale_promotions', '*', array('sale_id' => $saleId, 'promotion_type_id!=' => 1));
            $rr = $this->config->item('promotion_types');
        }
        $this->load->view('sales/sale_returns/invoice_data', $data);
    }

    public function show_sale_return_data()
    {
        $check_id = $this->input->post('check_id');
        $return_qty = $this->input->post('return_qty');
        $promo['customer_id'] = $this->input->post('customer_id');
        $html = '';
        $total = $total_vat = $act_amount = $total_pro_dis = 0;
        for ($i = 0; $i < count($check_id); $i++) {
            $details_id = $check_id[$i];
            $data = $this->sales_model->getvalue_row_one('sale_details_view', '*', array('id_sale_detail' => $details_id));
            if ($data) {
                $html .= '<tr>';
                $html .= '<td>' . $data[0]['product_name'] . ' <input type="hidden" name="details_id[]" value="' . $data[0]['id_sale_detail'] . '"></td>';
                $html .= '<td>' . $data[0]['batch_no'] . '</td>';
                $html .= '<td>' . $return_qty[$i] . ' <input type="hidden" name="return_qty[]" value="' . $return_qty[$i] . '"></td>';
                $html .= '<td>' . $data[0]['selling_price_est'] / $data[0]['qty'] . '</td>';
                $price_est = ($data[0]['selling_price_est'] / $data[0]['qty']) * $return_qty[$i];
                $html .= '<td>' . $price_est . '<input type="hidden" name="price_est[]" value="' . $price_est . '"></td>';
                $dis_rate_val = ($data[0]['discount_amt'] / $data[0]['qty']) * $return_qty[$i];
                $html .= '<td>' . $dis_rate_val . '<input type="hidden" name="dis_rate_val[]" value="' . $dis_rate_val . '"></td>';
                $vat_act = number_format((($data[0]['vat_amt'] / $data[0]['qty']) * $return_qty[$i]), 2);
                $html .= '<td>' . $vat_act . '<input type="hidden" name="vat_act[]" value="' . $vat_act . '"></td>';
                $unit_total = (($data[0]['selling_price_act'] / $data[0]['qty']) * $return_qty[$i]);
                $html .= '<td>' . number_format($unit_total,2) . '<input type="hidden" name="unit_total[]" value="' . $unit_total . '"></td>';
                $html .= '</tr>';
                $total = $total + (($data[0]['selling_price_act'] / $data[0]['qty']) * $return_qty[$i]);
                $sale_id = $data[0]['sale_id'];
                $total_vat += (($data[0]['vat_amt'] / $data[0]['qty']) * $return_qty[$i]);
                $act_amount += ($data[0]['selling_price_est'] / $data[0]['qty']) * $return_qty[$i];
                $total_pro_dis += $dis_rate_val;
            }
        }
        $promo['promotions'] = $this->sales_model->getvalue_row('sale_promotions', '*', array('sale_id' => $sale_id, 'promotion_type_id!=' => 1));
        $promo['total'] = $total;
        $promo['data'] = $html;
        $promo['sale_id'] = $sale_id;
        $promo['total_vat'] = $total_vat;
        $promo['act_amount'] = $act_amount;
        $promo['total_pro_dis'] = $total_pro_dis;

        $this->load->view('sales/sale_returns/return_discount', $promo);
    }

    private function generateInvoiceNo() {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random = '';
        for ($i = 0; $i < 3; $i++) {
            $random .= $chars[rand(0, strlen($chars) - 1)];
        }
        return time() . $random;
    }

    public function add_sale_return()
    {
        $cart_total = (int)$this->input->post('cart_total');
        $sale_id = (int)$this->input->post('sale_id');
        $dis_amt = (int)$this->input->post('dis_amt');
        $customer_id = (int)$this->input->post('customer_id');
        $act_amount = (int)$this->input->post('act_amount');
        $total_pro_dis = (int)$this->input->post('total_pro_dis');
        $total_vat = (int)$this->input->post('total_vat');
        $total_price=$cart_total - $dis_amt;
        //`ref_sale_id` `type_id` `invoice_no` `store_id` `station_id` `customer_id` `product_amt` `vat_amt` `discount_amt` `round_amt` `tot_amt` `paid_amt` `due_amt`
        $data['invoice_no'] = $this->generateInvoiceNo();//time();
        $data['type_id'] = 1;
        $data['ref_sale_id'] = $sale_id;
        $data['store_id'] = $this->session->userdata['login_info']['store_id'];
        $data['customer_id'] = $customer_id;
        $data['product_amt'] = $act_amount;
        $data['vat_amt'] = $total_vat;
        $data['discount_amt'] = $dis_amt + $total_pro_dis;
        $data['tot_amt'] = $total_price;
        $data['paid_amt'] = $total_price;
        $data['station_id'] = $this->session->userdata['login_info']['station_id'];
        $data['dtt_add'] = date('Y-m-d H:i:s');
        $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
        $result = $this->sales_model->common_insert('sale_adjustments', $data);
        $original_points = 0;
        $point_balance = $this->commonmodel->getvalue_row_one('configs', 'param_val', array('param_key' => 'POINT_EARN_RATIO'));
        $per_point_balance = $point_balance[0]['param_val'];
        $minus_points=0;
        if($per_point_balance > 0){
            $minus_points = $data['tot_amt'] / $per_point_balance;
            $this->commonmodel->update_balance_amount('customers', 'points', $minus_points, '-', array('id_customer' => $customer_id));
        }
        $data2['minus_points'] = $minus_points;
        if ($result) {
            $details_id = $this->input->post('details_id');
            $return_qty = $this->input->post('return_qty');
            $price_est = $this->input->post('price_est');
            $dis_rate_val = $this->input->post('dis_rate_val');
            $vat_act = $this->input->post('vat_act');
            $unit_total = $this->input->post('unit_total');
            for ($i = 0; $i < count($details_id); $i++) {
                $product = array();
                $posts = $this->sales_model->getvalue_row_one('sale_details_view', '*', array('id_sale_detail' => $details_id[$i]));
                $product['sale_id'] = $result;
                $product['sale_type_id'] = 2;
                $product['qty_multiplier'] = 1;
                $product['stock_id'] = $posts[0]['stock_id'];
                $product['product_id'] = $posts[0]['product_id'];
                $product['cat_id'] = $posts[0]['cat_id'];
                $product['subcat_id'] = $posts[0]['subcat_id'];
                $product['brand_id'] = $posts[0]['brand_id'];
                $product['qty'] = $return_qty[$i];
                $product['unit_id'] = $posts[0]['unit_id'];
                $product['selling_price_est'] = $price_est[$i];
                $product['selling_price_act'] = $unit_total[$i];
                $product['discount_rate'] = ($dis_rate_val[$i] / $return_qty[$i]);
                $product['discount_amt'] = $dis_rate_val[$i];
                $product['vat_rate'] = $vat_act[$i] / $return_qty[$i];
                $product['vat_amt'] = $vat_act[$i];
                $product['dtt_add'] = date('Y-m-d H:i:s');
                $product['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $details = $this->sales_model->common_insert('sale_details', $product);
                //$this->commonmodel->update_balance_amount('stocks', 'qty', $return_qty[$i], '+', array('id_stock' => $posts[0]['stock_id']));
                $this->sales_model->update_value_add('stocks', 'qty', $return_qty[$i], array('id_stock' => $posts[0]['stock_id']));
            }
            $this->commonmodel->updAccCurrBalance($this->session->userdata['login_info']['station_acc_id'], $total_price, -1);
        }

        $this->load->library('barcode');
        //$invoice_id = $id;
        $data2['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data2['transactions'] = $this->commonmodel->sale_transaction_details($sale_id);
        $data2['products'] = $this->commonmodel->getvalue_sale_return_details($result);
        $dataArray = array(
            'status_id' => 1,
            'sale_id' => $sale_id,
            'promotion_type_id !=' => 1
        );
        $data2['promotions'] = $this->commonmodel->getvalue_row('sale_promotions', 'promotion_type_id,discount_rate,discount_amt', $dataArray);
        $data2['invoices'] = $this->commonmodel->get_sellReturn_print_invoice($result);
        $this->load->view('sales/sale_returns/saleReturn_view_print', $data2, false);
        //echo json_encode(array('success'=>true,'message'=>'success'));

    }


}
