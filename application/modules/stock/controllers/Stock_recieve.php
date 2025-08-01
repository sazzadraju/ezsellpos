<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_recieve extends MX_Controller {

	function __construct(){  
		parent::__construct();
		$this->load->library(array('form_validation'));
		if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->perPage = 20;

		$this->load->model('Stock_recieve_model');
        $this->load->model('auto_increment');
        $this->load->model('Common_model');
	}


	//**Stock In Section Start**//
	public function index()
	{
        $data = array();
        $this->dynamic_menu->check_menu('stock-recieve');
        $this->breadcrumb->add(lang('stock_recieve'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->Stock_recieve_model->stock_transfer_list();
        $totalRec = ($row!='')?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock/stock_recieve_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['stores'] = $this->Stock_recieve_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->Stock_recieve_model->stock_transfer_list(array('limit' => $this->perPage));
        $data['supplier_list'] = $this->Stock_recieve_model->get_supplier_drop_down();
		$this->template->load('main', 'stock_recieve/stock_recieve_list',$data); 
	}

	public function stock_recieve_pagination_data() {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $invoice_number= $this->input->post('invoice_number');
        if(!empty($invoice_number)){
            $conditions['search']['invoice_number'] = $invoice_number;
        }

        $from_date= $this->input->post('from_date');
        if(!empty($from_date)){
            $conditions['search']['from_date'] = $from_date;
        }

        $to_date= $this->input->post('to_date');
        if(!empty($to_date)){
            $conditions['search']['to_date'] = $to_date;
        }
        $store_name= $this->input->post('store_name');
        if(!empty($store_name)){
            $conditions['search']['store_name'] = $store_name;
        }

        //total rows count
       $row = $this->Stock_recieve_model->stock_transfer_list($conditions);
        $totalRec = ($row!='')?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock/stock_recieve_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['stores'] = $this->Stock_recieve_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->Stock_recieve_model->stock_transfer_list($conditions);
        //load the view
        $this->load->view('stock_recieve/stock_recieve_list_pagination', $data, false);
    }


    public function product_stock_recieve()
    {
        $this->dynamic_menu->check_menu('stock-recieve');
        $this->breadcrumb->add(lang('stock_recieve'),'stock-recieve', 1);
        $this->breadcrumb->add(lang('recieve_stock'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['stores'] = $this->Stock_recieve_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['invoice_id'] = $this->auto_increment->getAutoIncKey('STOCK_IN_INVOICE', 'stock_mvts', 'invoice_no');
        $data['reason_list'] = $this->Stock_recieve_model->get_stocks_reason();
        $data['store_list'] = $this->Stock_recieve_model->get_stores();
        $this->template->load('main', 'stock_recieve/stock_recieve_form',$data); 
    }

    public function stock_transfer_details($stock_mvt_id = null)
    {
        $this->breadcrumb->add(lang('stock_recieve'),'stock-recieve', 1);
        $this->breadcrumb->add(lang('recieve_stock'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['columns'] = $this->Stock_recieve_model->getvalue_row('acl_user_column', 'permission', array('menu_url'=>'stock_transfer_details'));
        $data['invoice_id'] = $this->auto_increment->getAutoIncKey('STOCK_IN_INVOICE', 'stock_mvts', 'invoice_no');
        $data['reason_list'] = $this->Stock_recieve_model->get_stocks_reason();
        $data['stock_transfer_list'] = $this->Stock_recieve_model->stock_transfer_details($stock_mvt_id);
        $this->template->load('main', 'stock_recieve/stock_transfer_details',$data); 
    }

    public function stock_transfer_view($stock_mvt_id = null)
    {
        $this->breadcrumb->add(lang('stock_recieve'),'stock-recieve', 1);
        $this->breadcrumb->add(lang('stock_transfer_details'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['columns'] = $this->Stock_recieve_model->getvalue_row('acl_user_column', 'permission', array('menu_url'=>'stock_transfer_view'));
        $data['invoice_id'] = $this->auto_increment->getAutoIncKey('STOCK_IN_INVOICE', 'stock_mvts', 'invoice_no');
        $data['reason_list'] = $this->Stock_recieve_model->get_stocks_reason();
        $data['stock_transfer_list'] = $this->Stock_recieve_model->stock_request_details($stock_mvt_id);
        $data['stock_mvt_id'] = $stock_mvt_id;
        $data['doc_list'] = $this->Stock_recieve_model->get_doc_file($stock_mvt_id);
        //$data['stores'] = $this->Stock_recieve_model->stock_transfer_stores($stock_mvt_id);
        $this->template->load('main', 'stock_recieve/stock_transfer_view',$data); 
    }
    public function stock_receive_print_view()
    {
        $stock_mvt_id = $this->input->post('id');
        $data['columns'] = $this->Stock_recieve_model->getvalue_row('acl_user_column', 'permission', array('menu_url'=>'stock_transfer_view'));
        $data['stock_transfer_list'] = $this->Stock_recieve_model->stock_request_details($stock_mvt_id);
        $data3['head'] = array(
            'title' => 'Stock Receive Details',
            'invoice_no' => $data['stock_transfer_list'][0]['invoice_no'],
            'date' => $data['stock_transfer_list'][0]['dtt_stock_mvt']
        );
        $data3['report']=$this->load->view('stock_recieve/stock_transfer_view_list', $data, true);
        $this->load->view('print_page', $data3, false);
    }


    public function get_products()
    {
        $request = $_REQUEST['request'];
        $product_list = $this->Stock_recieve_model->get_product($request);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->product_name,
                "value" => $list->id_product,
                "buy_price" => $list->buy_price,
                "sell_price" => $list->sell_price,
                "is_vatable" => $list->is_vatable,
                "vat" => $list->vat
                // "is_unq_barcode" => $list->is_unq_barcode
            );
        }
        echo json_encode($return);
    }

    public function get_stock_batch_by_product_id(){
        $product_id = $this->input->post('product_id');

        if(!empty($product_id)){
            $batch_list = $this->Stock_recieve_model->get_batch_list_by_product($product_id);
            echo json_encode($batch_list);
        }
    }

    public function get_stock_detail_data(){
        $stock_id = $this->input->post('stock_id');
        if(!empty($stock_id)){
            $stock_list = $this->Stock_recieve_model->stocks_details($stock_id);
            echo json_encode($stock_list);
        }
    }


    public function stock_recieve_insert()
    {
        $this->form_validation->set_rules('invoice_no', 'Invoice Number', 'trim|required|is_unique[stock_mvts.invoice_no]');
       
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $total_num_of_fields = $this->input->post('total_num_of_fields');
            // $id_stock = $this->input->post('row_id_stock');
            $supplier_id = $this->input->post('supplier_id');
            $invoice_no = $this->input->post('invoice_no');
            $default_invoice_no = $this->input->post('default_invoice_no');
            $notes = $this->input->post('notes');
            $stock_mvt_date = $this->input->post('dtt_stock_mvt');
            $batch_no = $this->input->post('batch_no');
            $product_id = $this->input->post('product_id');
            $row_qty = $this->input->post('row_qty');
            $existing_qty = $this->input->post('qty');
            $stock_out_qty = $this->input->post('row_stock_out_qty');
            $stock_mvt_reason_id = $this->input->post('stock_mvt_reason_id');
            $purchase_price = $this->input->post('purchase_price');
            $sale_price = $this->input->post('selling_price_est');
            $vat_rate = $this->input->post('vat_rate');
            $expire_date = $this->input->post('expire_date');
            $send_details_id = $this->input->post('id_stock_mvt_detail');
            $stk_tx_snd_id = $this->input->post('stk_tx_snd_id');
            $alert_date = $this->input->post('alert_date');
            $stock_mvt_id = $this->input->post('stock_mvt_id');
            $attribute_name = $this->input->post('attribute_name');
            $attribute_id = $this->input->post('attribute_id');
            
            if(file_exists($_FILES['stock_in_doc']['tmp_name'])){
                $is_doc_attached = 1;
            }else{
                $is_doc_attached = 0;
            }

            if($stock_mvt_id){
                $data_stock_mvts['id_stock_mvt'] = $stock_mvt_id;
                $data_stock_mvts['invoice_no'] = $invoice_no;
                $data_stock_mvts['dtt_stock_mvt'] = $stock_mvt_date;
                $data_stock_mvts['notes'] = $notes;
                $data_stock_mvts['is_doc_attached'] = $is_doc_attached;
                $data_stock_mvts['dtt_add'] = date('Y-m-d H:i:s');
                $data_stock_mvts['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data_stock_mvts['status_id'] = 1;
                $stock_mvts_id = $this->Stock_recieve_model->general_update('stock_mvts', $data_stock_mvts, 'id_stock_mvt', $stock_mvt_id);
            }
            $dtt_add = date('Y-m-d H:i:s');
            $uid_add = $this->session->userdata['login_info']['id_user_i90'];

            if ($_FILES['stock_in_doc']['name']!='') {
                $filename = upload_file('stock', $_FILES['stock_in_doc']);
                if($filename){
                    $add_table_key = "'" . "doc_type,ref_id,file,dtt_add,uid_add" . "'";
                    $add_table_value = "'Stock," . $stock_mvt_id . "," . $filename . "," . $dtt_add . "," . $uid_add . "'";
                    $qry_res = $this->db->query("CALL insert_row('documents'," . $add_table_key . "," . $add_table_value . ")");
                    //$pro_id = $qry_res->result_object();
                    $qry_res->next_result();
                    $qry_res->free_result();
                }
            }

            for($i = 0; $i < $total_num_of_fields; $i++){

                if($stock_mvts_id){
                    $data_stock_mvts_details['stock_mvt_id'] = $stock_mvt_id;
                    $data_stock_mvts_details['batch_no'] = $batch_no[$i];
                    $data_stock_mvts_details['product_id'] = $product_id[$i];
                    // $data_stock_mvts_details['product_archive'] = "";
                    $data_stock_mvts_details['qty'] = $row_qty[$i];
                    $data_stock_mvts_details['supplier_id'] = $supplier_id[$i];
                    $data_stock_mvts_details['purchase_price'] = $purchase_price[$i];
                    $data_stock_mvts_details['selling_price_est'] = $sale_price[$i];
                    $data_stock_mvts_details['selling_price_act'] = $sale_price[$i];
                    // $data_stock_mvts_details['discount_amt'] = $this->input->post('row_sale_price');
                    // $data_stock_mvts_details['discount_rate'] = $this->input->post('row_sale_price');
                    $data_stock_mvts_details['vat_rate'] = $vat_rate[$i];
                    $data_stock_mvts_details['expire_date'] = $expire_date[$i];
                    $data_stock_mvts_details['alert_date'] = $alert_date[$i];
                    $data_stock_mvts_details['dtt_add'] = date('Y-m-d H:i:s');
                    $data_stock_mvts_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $stock_mvt_details_id = $this->Stock_recieve_model->common_insert('stock_mvt_details', $data_stock_mvts_details);

                    if($row_qty[$i] != $existing_qty[$i]){
                        if($row_qty[$i] > $existing_qty[$i]){
                            $data_stock_mvt_mismatches['mismatch_type_id'] = 2;
                            $data_stock_mvt_mismatches['qty'] = $row_qty[$i] - $existing_qty[$i];
                        }else{
                            $data_stock_mvt_mismatches['mismatch_type_id'] = 1;
                            $data_stock_mvt_mismatches['qty'] = $existing_qty[$i] - $row_qty[$i];
                        }
                        $data_stock_mvt_mismatches['stk_tx_snd_id'] = $stk_tx_snd_id;
                        $data_stock_mvt_mismatches['stk_tx_snd_detail_id'] = $send_details_id[$i];
                        $data_stock_mvt_mismatches['stk_tx_rcv_id'] = $stock_mvt_id;
                        $data_stock_mvt_mismatches['stk_tx_rcv_detail_id'] = $stock_mvt_details_id;
                        $data_stock_mvt_mismatches['dtt_add'] = date('Y-m-d H:i:s');
                        $data_stock_mvt_mismatches['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                        $id_stock_mvt_mismatch = $this->Stock_recieve_model->common_insert('stock_mvt_mismatches', $data_stock_mvt_mismatches);
                    }

                    if($stock_mvt_details_id){
                        $data_stocks['stock_mvt_type_id'] = '8';
                        $data_stocks['stock_mvt_id'] = $stock_mvt_id;
                        $data_stocks['stock_mvt_detail_id'] = $stock_mvt_details_id;
                        $data_stocks['supplier_id'] = $supplier_id[$i];
                        $data_stocks['store_id'] = $this->session->userdata['login_info']['store_id'];
                        $data_stocks['batch_no'] = $batch_no[$i];
                        $data_stocks['product_id'] = $product_id[$i];
                        $data_stocks['qty'] = $row_qty[$i];
                        $data_stocks['purchase_price'] = $purchase_price[$i];
                        $data_stocks['selling_price_est'] = $sale_price[$i];
                        $data_stocks['selling_price_act'] = $sale_price[$i];
                        $data_stocks['vat_rate'] = $vat_rate[$i];
                        $data_stocks['expire_date'] = $expire_date[$i];
                        $data_stocks['alert_date'] = $alert_date[$i];
                        $data_stocks['dtt_add'] = date('Y-m-d H:i:s');
                        $data_stocks['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                        $stocks_id = $this->Stock_recieve_model->common_insert('stocks', $data_stocks);
                        if(!empty($attribute_name[$i])){
                            $attr_name_array=explode(',',$attribute_name[$i]);
                            for ($a=0;$a<count($attr_name_array);$a++){
                                $attr_name_value=$attr_name_array[$a];
                                $array_attr_data=array(
                                    'stock_id'=>$stocks_id,
                                    'p_attribute_id'=>explode(',',$attribute_id[$i])[$a],
                                    's_attribute_name'=>explode('=',$attr_name_value)[0],
                                    's_attribute_value'=>explode('=',$attr_name_value)[1]
                                );
                                $this->Stock_recieve_model->common_insert('stock_attributes', $array_attr_data);
                            }
                        }

                    }
                    
                }

            }

            if($stocks_id){
                $this->auto_increment->updAutoIncKey('STOCK_IN_INVOICE', $invoice_no, $default_invoice_no);
                echo json_encode(array("status" => "success", "message" => lang('add_success')));
            }
        }

        
    }

    public function check_invoice_no(){
        $invoice_number = $this->input->post('invoice_number');
        $invoice_check = $this->Common_model->isExist('stock_mvts', 'invoice_no', $invoice_number);
        if($invoice_check){
            echo 1;
        }else{
            echo 0;
        }
        
    }

	//**Stock In Section End**//

	

}
