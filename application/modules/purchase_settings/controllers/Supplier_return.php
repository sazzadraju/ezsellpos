<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_return extends MX_Controller {

	function __construct(){  
		parent::__construct();
		$this->load->library(array('form_validation'));
		if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->perPage = 20;

		$this->load->model('Supplier_return_model');
        $this->load->model('auto_increment');
        $this->load->model('Common_model');
	}


	//**Stock In Section Start**//
	public function index()
	{
        $data = array();
        $this->breadcrumb->add(lang('supplier_return_list'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $totalRec = count($this->Supplier_return_model->stock_return_list());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'supplier-return/supplier_return_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['posts'] = $this->Supplier_return_model->stock_return_list(array('limit' => $this->perPage));
        $data['supplier_list'] = $this->Supplier_return_model->get_supplier_drop_down();
		$this->template->load('main', 'supplier_return/supplier_return_list',$data); 
	}

	public function supplier_return_pagination_data() {
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

        //total rows count
        $totalRec = count($this->Supplier_return_model->stock_return_list($conditions));
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'supplier-return/supplier_return_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['posts'] = $this->Supplier_return_model->stock_return_list($conditions);
        //load the view
        $this->load->view('supplier_return/supplier_return_list_pagination', $data, false);
    }


    public function supplier_return_form()
    {
        $this->breadcrumb->add(lang('supplier_return_list'),'supplier-return', 1);
        $this->breadcrumb->add(lang('supplier_return'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['invoice_id'] = $this->auto_increment->getAutoIncKey('SUPPLIER_RETURN_INVOICE', 'stock_mvts', 'invoice_no');
        $data['reason_list'] = $this->Supplier_return_model->get_stocks_reason();
        $data['supplier_list'] = $this->Supplier_return_model->get_supplier_drop_down();
        $this->template->load('main', 'supplier_return/supplier_return_form',$data); 
    }


    public function get_products()
    {
        $request = $_REQUEST['request'];
        $product_list = $this->Supplier_return_model->get_product($request);
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

    public function get_purchase_recieve_data(){
        $product_id = $this->input->post('product_id');
        $supplier_id = $this->input->post('supplier_id');

        if(!empty($product_id) && !empty($supplier_id)){
            $batch_list = $this->Supplier_return_model->get_batch_list_by_product($product_id, $supplier_id);
            echo json_encode($batch_list);
        }
    }

    public function get_stock_detail_data(){
        $stock_id = $this->input->post('stock_id');
        if(!empty($stock_id)){
            $stock_list = $this->Supplier_return_model->stocks_details($stock_id);
            echo json_encode($stock_list);
        }
    }


    public function supplier_return_insert()
    {
        // echo json_encode($_POST);
        // exit();

        $this->form_validation->set_rules('invoice_no', 'Invoice Number', 'trim|required|is_unique[stock_mvts.invoice_no]');
       
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $total_num_of_fields = $this->input->post('total_num_of_fields');
            $id_stock = $this->input->post('row_id_stock');
            $supplier_id = $this->input->post('row_supplier_id');
            $invoice_no = $this->input->post('invoice_no');
            $default_invoice_no = $this->input->post('default_invoice_no');
            $notes = $this->input->post('notes');
            $stock_mvt_date = $this->input->post('dtt_stock_mvt');
            $rack_id = $this->input->post('row_rack_id');
            $batch_no = $this->input->post('row_batch_no');
            $product_id = $this->input->post('row_product_id');
            $qty = $this->input->post('row_qty');
            $stock_out_qty = $this->input->post('row_stock_out_qty');
            $stock_mvt_reason_id = $this->input->post('stock_mvt_reason_id');
            $purchase_price = $this->input->post('row_purchase_price');
            $sale_price = $this->input->post('row_sale_price');
            $vat_rate = $this->input->post('row_vat_rate');
            $expire_date = $this->input->post('row_expire_date');
            $alert_date = $this->input->post('row_alert_date');
            $purchase_receive_id = $this->input->post('row_purchase_receive_id');
            
            if(file_exists($_FILES['stock_out_doc']['tmp_name'])){
                $is_doc_attached = 1;
            }else{
                $is_doc_attached = 0;
            }

            $data_supplier_returns['invoice_no'] = $invoice_no;
            $data_supplier_returns['purchase_receive_id'] = $purchase_receive_id;
            $data_supplier_returns['supplier_id'] = $supplier_id;
            $data_supplier_returns['store_id'] = $this->session->userdata['login_info']['store_id'];
            $data_supplier_returns['notes'] = $notes;
            $data_supplier_returns['stock_mvt_reason_id'] = $stock_mvt_reason_id;
            $data_supplier_returns['is_doc_attached'] = $is_doc_attached;
            $data_supplier_returns['dtt_supplier_return'] = $stock_mvt_date.' '.date('H:i:s');
            $data_supplier_returns['dtt_add'] = date('Y-m-d H:i:s');
            $data_supplier_returns['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $stock_mvts_id = $this->Supplier_return_model->common_insert('supplier_returns', $data_supplier_returns);


            if (!empty($_FILES)) {
                $config['upload_path'] = 'public/uploads/stock_documents';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx';
                $config['max_size'] = 100000;
                $config['max_width'] = 102400;
                $config['max_height'] = 100000;
                $config['file_name'] = date('d-m-Y') . '_' . time();
              
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('stock_out_doc')) {
                    $recipe_file = $this->upload->data();
                    $file = $config['file_name'];
                    $data_document['doc_type'] = 'Supplier Return';
                    $data_document['ref_id'] = $stock_mvts_id;
                    $data_document['file'] = $recipe_file['file_name'];
                    $data_document['dtt_add'] = date('Y-m-d H:i:s');
                    $data_document['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $document_id = $this->Supplier_return_model->common_insert('documents', $data_document);
                }
            }

            for($i = 0; $i < $total_num_of_fields; $i++){

                if($stock_mvts_id){
                    $data_supplier_return_details['supplier_return_id'] = $stock_mvts_id;
                    $data_supplier_return_details['stock_id'] = $id_stock[$i];
                    $data_supplier_return_details['qty'] = $stock_out_qty[$i];
                    $data_supplier_return_details['dtt_add'] = date('Y-m-d H:i:s');
                    $data_supplier_return_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $supplier_return_details_id = $this->Supplier_return_model->common_insert('supplier_return_details', $data_supplier_return_details);

                    if($supplier_return_details_id){
                        $stock_id_val = $id_stock[$i];
                        $data_stocks['qty'] = $qty[$i] - $stock_out_qty[$i];
                        $data_stocks['dtt_mod'] = date('Y-m-d H:i:s');
                        $data_stocks['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                        $stocks_id = $this->Supplier_return_model->common_update('stocks', $data_stocks, 'id_stock', $stock_id_val, false);
                    }
                    
                }
            }

            if($stocks_id){
                $this->auto_increment->updAutoIncKey('SUPPLIER_RETURN_INVOICE', $invoice_no, $default_invoice_no);
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

    public function stock_out_details($stock_out_id = null){
        $this->breadcrumb->add(lang('stock_out_list'),'stock_out', 1);
        $this->breadcrumb->add(lang('stock_out_details'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['stock_out_list'] = $this->Supplier_return_model->stock_out_details_list($stock_out_id);
        $data['doc_list'] = $this->Supplier_return_model->get_doc_file($stock_out_id);
        $this->template->load('main', 'stock_out/stock_out_details',$data); 
    }

	//**Stock In Section End**//

	

}
