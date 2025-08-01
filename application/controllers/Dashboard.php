<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('product_settings/product_model', 'models');
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
    }

    public function index()
    {
        $data['config'] = $this->commonmodel->getvalue_row('configs', '*', array());
        $stocks = $this->commonmodel->getvalue_row('stocks', 'purchase_price,qty', array('qty !=' => 0));
        $sum = 0;
        if (!empty($stocks)) {
            foreach ($stocks as $stock) {
                $sum += $stock->qty * $stock->purchase_price;
            }
        }
        $data['stock'] = $sum;
        $endWeek = date('Y-m-d', strtotime("friday Last Week"));
        $date = strtotime(date("Y-m-d", strtotime($endWeek)) . " -7 day");
        $startWeek = date('Y-m-d H:i:s', $date);
        $endWeek = $endWeek . ' 23:59:59';
        $data['sales'] = $this->commonmodel->last_week_sale($startWeek, $endWeek);
        $data['sale_date'] = explode(' ', $startWeek)[0] . ' TO ' . explode(' ', $endWeek)[0];
        $data['accounts'] = $this->commonmodel->account_stocks_last();
        $data['stock_data'] = $this->commonmodel->get_stock_data();
        $data['low_stock'] = count($this->commonmodel->low_stock_data());
        $data['sp_alerts'] = $this->commonmodel->supplier_payment_alerts();
        $this->template->load('main', 'dashboard', $data);
    }

    public function sale_invoice_view($id)
    {
        $this->load->library('barcode');
        $invoice_id = $id;
        $data['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['transactions'] = $this->commonmodel->sale_transaction_details($invoice_id);
        $data['products'] = $this->commonmodel->getvalue_sale_details($invoice_id);
        $data['settings'] = $this->commonmodel->invoice_setting_report('thermal');
        $data['serial_no'] = $this->commonmodel->sale_serial_no($invoice_id,1);
        $data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($invoice_id);
        $dataArray = array(
            'status_id' => 1,
            'sale_id' => $invoice_id,
            'promotion_type_id !=' => 1
        );
        $data['promotions'] = $this->commonmodel->getvalue_row('sale_promotions', 'promotion_type_id,discount_rate,discount_amt', $dataArray);
        $data['invoices'] = $this->commonmodel->get_print_invoice($invoice_id);
        $this->load->view('invoice_report_print', $data, false);
    }

    public function sale_print_view($id)
    {
        $this->load->library('barcode');
        $invoice_id = $id;
        $data['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['transactions'] = $this->commonmodel->sale_transaction_details($invoice_id);
        $data['products'] = $this->commonmodel->getvalue_sale_details($invoice_id);
        $data['settings'] = $this->commonmodel->invoice_setting_report('full');
        $data['serial_no'] = $this->commonmodel->sale_serial_no($invoice_id,1);
        $data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($invoice_id);
        $dataArray = array(
            'status_id' => 1,
            'sale_id' => $invoice_id,
            'promotion_type_id !=' => 1
        );
        $data['delivery'] = $this->commonmodel->getvalue_row('delivery_order_details', '*', array('status_id' => 1, 'sale_id' => $invoice_id));
        if($data['delivery']){
            if ($data['delivery'][0]->type_id == 1) {
                $data['delivery_person'] = $this->commonmodel->getvalue_row('users', 'fullname as person_name', array('status_id' => 1, 'id_user' => $data['delivery'][0]->person_ref_id));
            }else{
                $data['delivery_person'] = $this->commonmodel->getvalue_row('delivery_persons', 'person_name', array('status_id' => 1, 'id_delivery_person' => $data['delivery'][0]->person_id));
            }
        }
        $data['promotions'] = $this->commonmodel->getvalue_row('sale_promotions', 'promotion_type_id,discount_rate,discount_amt', $dataArray);
        $data['invoices'] = $this->commonmodel->get_print_invoice($invoice_id);
        $this->load->view('invoice_a4_print', $data, false);
    }
    public function sale_print_view_full($id)
    {
        $this->load->library('barcode');
        $invoice_id = $id;
        $data['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['transactions'] = $this->commonmodel->sale_transaction_details($invoice_id);
        $data['products'] = $this->commonmodel->getvalue_sale_details($invoice_id);
        $data['settings'] = $this->commonmodel->invoice_setting_report('full');
        $data['serial_no'] = $this->commonmodel->sale_serial_no($invoice_id,1);
        $data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($invoice_id);
        $dataArray = array(
            'status_id' => 1,
            'sale_id' => $invoice_id,
            'promotion_type_id !=' => 1
        );
        $data['delivery'] = $this->commonmodel->getvalue_row('delivery_order_details', '*', array('status_id' => 1, 'sale_id' => $invoice_id));
        if($data['delivery']){
            if ($data['delivery'][0]->type_id == 1) {
                $data['delivery_person'] = $this->commonmodel->getvalue_row('users', 'fullname as person_name', array('status_id' => 1, 'id_user' => $data['delivery'][0]->person_ref_id));
            }else{
                $data['delivery_person'] = $this->commonmodel->getvalue_row('delivery_persons', 'person_name', array('status_id' => 1, 'id_delivery_person' => $data['delivery'][0]->person_id));
            }
        }
        $data['promotions'] = $this->commonmodel->getvalue_row('sale_promotions', 'promotion_type_id,discount_rate,discount_amt', $dataArray);
        $data['invoices'] = $this->commonmodel->get_print_invoice($invoice_id);
        $this->load->view('invoice_a4_print_view', $data, false);
    }
    public function sale_return_invoice_view($id)
    {
        // print_r($id);
        $this->load->library('barcode');
        $sale_id = $id;
        $ret_sale_id = $this->commonmodel->getvalue_row_one('sale_adjustments', 'ref_sale_id', array('id_sale_adjustment' => $sale_id));
        $data['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['transactions'] = $this->commonmodel->sale_transaction_details($sale_id);
        $data['products'] = $this->commonmodel->getvalue_sale_return_details($sale_id);
        $data['settings'] = $this->commonmodel->invoice_setting_report('thermal');
        $data['sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($sale_id);
        $dataArray = array(
            'status_id' => 1,
            'sale_id' => $ret_sale_id[0]['ref_sale_id'], 
            'promotion_type_id !=' => 1
        );
        $data['promotions'] = $this->commonmodel->getvalue_row('sale_promotions', 'promotion_type_id,discount_rate,discount_amt', $dataArray);
        $data['invoices'] = $this->commonmodel->get_sellReturn_print_invoice($sale_id);
        $this->load->view('return_invoice_report_print', $data, false);
    }
    public function show_preview_chalan_print(){
        $this->load->library('barcode');
        $details_id_array = $this->input->post('details_id');
        $send_qty = $this->input->post('send_qty');
        $remarks = $this->input->post('remarks');
        $data['customer_id'] = $this->input->post('customer_id');

        $total_row=count($details_id_array);
        $html = '';
        $sum=0;
        $count=1;
        for ($i = 0; $i < $total_row; $i++) {
            $details_id = $details_id_array[$i];
            $data = $this->commonmodel->chalan_print_data($details_id);
            if ($data) {
                $html .= '<tr>';
                $html .= '<td style="text-align: center">' . $count . '</td>';
                $html .= '<td>' . $data[0]['product_name'].'<br>'.$data[0]['product_code'].'<br>'.$data[0]['attribute_name'] . '</td>';
                 $html .= '<td>Brand:' . $data[0]['brand_name'].'<br>Cat:'.$data[0]['product_code'].'/'.$data[0]['sub_cat_name'] . '</td>';
                $html .= '<td style="text-align: center">' . $send_qty[$i] . '</td>';
                if($sum==0){
                    $html .= '<td style="text-align: center;border-bottom: 1px solid #000 !important;" rowspan="'.($total_row +1).'">' . $remarks . '</td>';
                }
                $html .= '</tr>';
                $sale_id = $data[0]['sale_id'];
                $sum+=$send_qty[$i];
                $count++;
            }

        }
        $html .= '<tr>';
        $html .= '<td colspan="3" style="text-align: right;font-weight: bold;border-bottom: 1px solid #000 !important;">' . lang("total") . '</td>';
        $html .= '<td style="text-align: center;font-weight: bold; border-bottom: 1px solid #000 !important;">' . $sum . '</td>';
        $html .= '</tr>';
        $data['post_data'] =$html;
        $data['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store' => $this->session->userdata['login_info']['store_id']));
        $data['invoices'] = $this->commonmodel->get_print_invoice($sale_id);
        $data['customer_address'] = $this->input->post('address');
        $this->load->view('chalan_print_view', $data);
    }
	public function export_csv_data(){
        $this->load->helper('export_csv');
        $urlArray=$this->input->get('request');
        $url=json_decode($urlArray);
        $id=$url->id;
        $tok=$url->token;
        $json_array = $this->commonmodel->getvalue_row_one('csv_report', 'value', array('id'=>$id,'token'=>$tok));
        $data=json_decode($json_array[0]['value']);
        if($data!=''){
            $query=$data->field_data;
            $fields=$data->field_title;
            $file=$data->file_name;
            $title=$data->file_title;
            $from=$data->from;
            $to=$data->to;
            if($query!='') {
                foreach ($query as $value) {
                    $new[] = $value;
                }
            }else{
                $new='';
            }
            $date[]=array('title'=>'Title','value'=>$title);
            $date[]=array('title'=>'From','value'=>$from);
            $date[]=array('title'=>'To','value'=>$to);
            echo arrayToCSV($new, $fields, $date, $file);
        }
        else{
            echo 'Error in CSV file..';
        }

    }
    public function stock_mismatch(){
        $data['products'] = $this->commonmodel->getvalue_row('products', '*',array('status_id'=>1));
        $this->load->view('stock_mismatch', $data, false);
    } 
    public function get_batch(){
        $id=$this->input->post('id');
        $products = $this->commonmodel->getvalue_row('stocks', 'batch_no', array('product_id'=>$id));
        $html='<option value="0" selected>'.lang("select_one").'</option>';
        foreach ($products as $row) {
            $html.= '<option value="' . $row->batch_no . '">' .$row->batch_no. '</option>';
        }
        echo $html;
    }
    public function temp_show_mismatch_data(){
        $this->load->model('mitmatch_model');
        $product_id=$this->input->post('product_id');
        $batch=$this->input->post('batch'); 
        $condition=array(
            'product_id'=>$product_id,
            'batch'=>$batch
        );
        $data['mitmatch_row']=$this->mitmatch_model->get_stock_mitmatch_row($condition);
        $this->load->view('stock_mismatch_temp_show', $data, false);
    }
    public function stock_mismatch_submit(){
        $this->load->model('mitmatch_model');
        $error_count=1;
        $product_id=$this->input->post('product_id');
        $batch=$this->input->post('batch');
        if($product_id!=0 && $batch !=0){
            $condition=array(
                'product_id'=>$product_id,
                'batch'=>$batch
            );
            $data['mitmatch_row']=$this->mitmatch_model->get_stock_mitmatch_row($condition);
            $maismatch_stock_array=array();
            $details_stock_array=array();
            if($data['mitmatch_row']!=''){
                foreach ($data['mitmatch_row'] as $row) {
                    $sale_store=$row['store_id'];
                    $sale_qty=$row['sale_qty'];
                    $product_id=$row['product_id'];
                    $batch_no=$row['batch_no'];
                    $id_stock=$row['id_stock'];
                    $stock_store_id=$row['stock_store_id'];
                    $stock_qty=$row['stock_qty'];
                    $id_sale_detail=$row['id_sale_detail'];
                    $add_stock_array=array(
                        'id_stock'=>$id_stock,
                        'sale_qty'=>$sale_qty
                    );
                    $this->mitmatch_model->update_add_stock_qty($add_stock_array);
                    array_push($maismatch_stock_array, $id_stock);
                    $sale_stock=array(
                        'store_id'=>$sale_store,
                        'sale_qty'=>$sale_qty,
                        'product_id'=>$product_id,
                        'batch_no'=>$batch_no
                    );
                    $stock=$this->mitmatch_model->get_stock_qty_by_sale($sale_stock);
                    $sale_stock_qty=$stock[0]['qty'];
                    if($sale_stock_qty>$sale_qty){
                        $did_stock_array=array(
                            'id_stock'=>$stock[0]['id_stock'],
                            'sale_qty'=>$sale_qty
                        );
                        $this->mitmatch_model->update_deduction_stock_qty($did_stock_array);
                        $add_stock_by_details=array(
                            'id_stock'=>$stock[0]['id_stock'],
                            'details_id'=>$id_sale_detail
                        );
                        $update_details=$this->mitmatch_model->update_sale_details_stock($add_stock_by_details);
                        array_push($details_stock_array, $id_sale_detail);

                    }else{
                        $error_count=2;
                        $msg='Stock not available for deduction';
                    }
                    

                }
            }
            $data['details_stock_array']=$details_stock_array;
            $data['maismatch_stock_array']=$maismatch_stock_array;
            $this->load->view('stock_mismatch_submit', $data, false);

        }else{
            echo '<span class="error">Select Product and Batch No ...</span>';
        }
    }

    public function bulk_insert(){
        $this->load->model('auto_increment');
        $products = $this->commonmodel->getvalue_row('products', '*', array('status_id' => 1));
        $invoice_id = $this->auto_increment->getAutoIncKey('STOCK_IN_INVOICE', 'stock_mvts', 'invoice_no');
        $batch_id = $this->auto_increment->getAutoIncKey('STOCK_IN_BATCH', 'stock_mvt_details', 'batch_no');
        $total_num_of_fields = $this->input->post('total_num_of_fields');
            $supplier_id = 1;
            $default_invoice_no = $invoice_id;
            $notes = 'bulk insert';
            $stock_mvt_date = date('Y-m-d');
            $rack_id = 0;
            $batch_no = $batch_id;
            $product_id = $this->input->post('row_product_id');
            $qty = 1500;
            $stock_mvt_reason_id =0;
            $purchase_price = '';
            $sale_price = '';
            $expire_date = '';
            $alert_date = '';
            $default_batch_no = $batch_id;
            $new_batch_no = $batch_id;
            $row_attr_value = '';
            $is_doc_attached = 0;
            $invoice_no=$invoice_id;
            try {
                $this->db->trans_start();
                $store_id = 13;
                $dtt_stock_mvt = $stock_mvt_date . ' ' . date('H:i:s');
                $dtt_add = date('Y-m-d H:i:s');
                $uid_add = 1;
                $add_table_key = "'" . "stock_mvt_type_id,invoice_no,store_id,notes,stock_mvt_reason_id,is_doc_attached,dtt_stock_mvt,dtt_add,uid_add" . "'";
                $add_table_value = "'12," . $invoice_no . "," . $store_id . "," . $notes . "," . $stock_mvt_reason_id . "," . $is_doc_attached . "," . $dtt_stock_mvt . "," . $dtt_add . "," . $uid_add . "'";
                $qry_res = $this->db->query("CALL insert_row('stock_mvts'," . $add_table_key . "," . $add_table_value . ")");
                $pro_id = $qry_res->result_object();
                $qry_res->next_result();
                $qry_res->free_result();
                //$stock_mvts_id = $this->Stock_in_model->common_insert('stock_mvts', $data_stock_mvts);
                foreach ($products as $value) {
                    $product_id=$value->id_product;
                    $purchase_price=$value->buy_price;
                    $sale_price=$value->sell_price;
                    if ($pro_id[0]->result) {
                        $add_table_key = "'" . "stock_mvt_id,rack_id,batch_no,product_id,supplier_id,qty,purchase_price,selling_price_est,selling_price_act,expire_date,alert_date,dtt_add,uid_add" . "'";
                        $add_table_value = "'" . $pro_id[0]->result . "," . $rack_id . "," . $batch_no . "," . $product_id . "," . $supplier_id . "," . $qty . "," . $purchase_price . "," . $sale_price . "," . $sale_price . "," . $expire_date . "," . $alert_date . "," . $dtt_add . "," . $uid_add . "'";
                        $qry_res = $this->db->query("CALL insert_row('stock_mvt_details'," . $add_table_key . "," . $add_table_value . ")");
                        $details_id = $qry_res->result_object();
                        $qry_res->next_result();
                        $qry_res->free_result();
                        if ($details_id[0]->result) {
                            $add_table_key = "'" . "stock_mvt_type_id,stock_mvt_id,stock_mvt_detail_id,supplier_id,store_id,rack_id,batch_no,product_id,qty,purchase_price,selling_price_est,selling_price_act,expire_date,alert_date,dtt_add,uid_add" . "'";
                            $add_table_value = "'12," . $pro_id[0]->result . "," . $details_id[0]->result . "," . $supplier_id . "," . $store_id . "," . $rack_id. "," . $batch_no . "," . $product_id . "," . $qty . "," . $purchase_price . "," . $sale_price . "," . $sale_price . "," . $expire_date . "," . $alert_date . "," . $dtt_add . "," . $uid_add . "'";
                            $qry_res = $this->db->query("CALL insert_row('stocks'," . $add_table_key . "," . $add_table_value . ")");
                            $pro_id1 = $qry_res->result_object();
                            $qry_res->next_result();
                            $qry_res->free_result();
                        }
                    }
                }
                if ($pro_id1[0]->result) {
                    $this->auto_increment->updAutoIncKey('STOCK_IN_INVOICE', $invoice_no, $default_invoice_no);
                    $this->auto_increment->updAutoIncKey('STOCK_IN_BATCH', $new_batch_no, $default_batch_no);
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    throw new Exception("Error in Stock in");
                }
                $type = 'success';
                $msg = lang('add_success');
                $sts = TRUE;
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $msg = $e->getMessage();
                $sts = FALSE;
                $type = 'error';
            }
            echo $type;
            echo '<br>'.'inser data.....';
    }
    
}