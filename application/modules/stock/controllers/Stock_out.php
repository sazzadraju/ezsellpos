<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_out extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));
        if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->perPage = 20;

        $this->load->model('Stock_out_model');
        $this->load->model('auto_increment');
        $this->load->model('Common_model');
    }


    //**Stock In Section Start**//
    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('stock_out');
        $this->breadcrumb->add(lang('stock_out_list'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->Stock_out_model->stock_out_list();
        $totalRec = ($row)?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock/stock_out_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['stores'] = $this->Stock_out_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->Stock_out_model->stock_out_list(array('limit' => $this->perPage));
        $data['supplier_list'] = $this->Stock_out_model->get_supplier_drop_down();
        $this->template->load('main', 'stock_out/stock_out_list', $data);
    }

    public function stock_out_pagination_data()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $invoice_number = $this->input->post('invoice_number');
        if (!empty($invoice_number)) {
            $conditions['search']['invoice_number'] = $invoice_number;
        }

        $from_date = $this->input->post('from_date');
        if (!empty($from_date)) {
            $conditions['search']['from_date'] = $from_date;
        }

        $to_date = $this->input->post('to_date');
        if (!empty($to_date)) {
            $conditions['search']['to_date'] = $to_date;
        }
        $store_name = $this->input->post('store_name');
        if (!empty($store_name)) {
            $conditions['search']['store_name'] = $store_name;
        }

        //total rows count
        $row = $this->Stock_out_model->stock_out_list($conditions);
        $totalRec = ($row!='')?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock/stock_out_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['stores'] = $this->Stock_out_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->Stock_out_model->stock_out_list($conditions);
        //load the view
        $this->load->view('stock_out/stock_out_list_pagination', $data, false);
    }


    public function product_stock_out()
    {
        $this->dynamic_menu->check_menu('stock_out');
        $this->breadcrumb->add(lang('stock_out_list'), 'stock_out', 1);
        $this->breadcrumb->add(lang('stock_out'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['stores'] = $this->Stock_out_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['columns'] = $this->Stock_out_model->getvalue_row('acl_user_column', 'permission', array('menu_url'=>'product_stock_out'));
        $data['invoice_id'] = $this->auto_increment->getAutoIncKey('STOCK_OUT_INVOICE', 'stock_mvts', 'invoice_no');
        $data['products'] = $this->commonmodel->product_stock_list($this->session->userdata['login_info']['store_id']);
        $data['reason_list'] = $this->Stock_out_model->get_stocks_reason();
        $this->template->load('main', 'stock_out/stock_out_form', $data);
    }


    public function get_products()
    {
        $request = $_REQUEST['request'];
        $store = $_REQUEST['store'];
        $product_list = $this->Stock_out_model->get_product($request, $store);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->product_name,
                "value" => $list->id_product,
                "buy_price" => $list->buy_price,
                "sell_price" => $list->sell_price,
                "is_vatable" => $list->is_vatable
                // "is_unq_barcode" => $list->is_unq_barcode
            );
        }
        echo json_encode($return);
    }

    public function get_stock_batch_by_product_id()
    {
        $product_id = $this->input->post('product_id');
        $store_id = $this->input->post('store_id');
        if (!empty($product_id)) {
            $batch_list = $this->Stock_out_model->get_batch_list_by_product($product_id,$store_id);
            echo json_encode($batch_list);
        }
    }
    public function temp_add_cart_for_barcode()
    {
        $barcode_name = $this->input->post('barcode_name');
        $store_id = $this->input->post('store_name');
        $acc_type = $this->input->post('acc_type');
        $batch_no = $this->input->post('batch_no');
        $product_id = $this->input->post('product_id');
        $row_qty = $this->input->post('row_qty');
        $batch='';
        if ($barcode_name != '') {
            if ($acc_type == 'No') {
                $pro_id = explode('-', $barcode_name);
                $id = explode('-', $barcode_name)[0];
                if (count($pro_id) > 2) {
                    $batch = $pro_id[1] . '-' . $pro_id[2];
                } else if(count($pro_id) == 2) {
                    $batch = $pro_id[1];
                }
            }
            $data['batch_no'] = $batch;
            $data['id_product'] = $id;
            $data['store_id'] = $store_id;
            $batch_list = $this->Stock_out_model->get_product_barcode($data);
            $inc = 0;
            if ($batch_list) {
                if ($product_id != '') {
                    if (preg_match("/,/", $product_id)) {
                        $product_id = explode(',', $product_id);
                        $batch_no = explode(',', $batch_no);
                        $row_qty = explode(',', $row_qty);
                        for ($i = 0; $i < count($product_id); $i++) {
                            if (($product_id[$i] == $data['id_product']) && ($batch_no[$i] == $data['batch_no'])) {
                                if ($row_qty[$i] == $batch_list[0]->qty) {
                                    $inc = 1;
                                } else {
                                    $inc = 2;
                                }
                            }
                        }
                    } elseif (($product_id == $data['id_product']) && ($batch_no == $data['batch_no'])) {
                        if ($row_qty == $batch_list[0]->qty) {
                            $inc = 1;
                        } else {
                            $inc = 2;
                        }
                    }
                }
                if ($inc > 0) {
                    echo json_encode(array('status' => $inc, 'data' => $data));
                } else {
                    echo json_encode(array('status' => 5, 'data' => $batch_list));
                }
            }else{
                 echo json_encode(array('status' => 2, 'data' => $batch_list));
            }
        } else {
            echo '';
        }

    }

    public function get_stock_detail_data()
    {
        $stock_id = $this->input->post('stock_id');
        if (!empty($stock_id)) {
            $stock_list = $this->Stock_out_model->stocks_details($stock_id);
            echo json_encode($stock_list);
        }
    }


    public function stock_out_insert()
    {

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
            $expire_date = $this->input->post('row_expire_date');
            $alert_date = $this->input->post('row_alert_date');

            if (file_exists($_FILES['stock_out_doc']['tmp_name'])) {
                $is_doc_attached = 1;
            } else {
                $is_doc_attached = 0;
            }
            try {

                $this->db->trans_start();
                $store_id = $this->input->post('store_name');
                $dtt_stock_mvt = $stock_mvt_date . ' ' . date('H:i:s');
                $dtt_add = date('Y-m-d H:i:s');
                $uid_add = $this->session->userdata['login_info']['id_user_i90'];
                $add_table_key = "'" . "stock_mvt_type_id,invoice_no,store_id,notes,stock_mvt_reason_id,is_doc_attached,dtt_stock_mvt,dtt_add,uid_add" . "'";
                $add_table_value = "'13," . $invoice_no . "," . $store_id . "," . $notes . "," . $stock_mvt_reason_id . "," . $is_doc_attached . "," . $dtt_stock_mvt . "," . $dtt_add . "," . $uid_add . "'";
                $qry_res = $this->db->query("CALL insert_row('stock_mvts'," . $add_table_key . "," . $add_table_value . ")");
                $pro_id = $qry_res->result_object();
                $qry_res->next_result();
                $qry_res->free_result();

                if ($_FILES['stock_out_doc']['name']!='') {
                    $filename = upload_file('stock', $_FILES['stock_out_doc']);
                    if($filename){
                        $add_table_key = "'" . "doc_type,ref_id,file,dtt_add,uid_add" . "'";
                        $add_table_value = "'Stock," . $pro_id[0]->result . "," . $filename . "," . $dtt_add . "," . $uid_add . "'";
                        $qry_res = $this->db->query("CALL insert_row('documents'," . $add_table_key . "," . $add_table_value . ")");
                        //$pro_id = $qry_res->result_object();
                        $qry_res->next_result();
                        $qry_res->free_result();
                    }
                }
                for ($i = 0; $i < $total_num_of_fields; $i++) {

                    if ($pro_id[0]->result) {
                        //$stock_mvt_details_id = $this->Stock_out_model->common_insert('stock_mvt_details', $data_stock_mvts_details);
                        $add_table_key = "'" . "stock_mvt_id,rack_id,batch_no,product_id,supplier_id,qty,purchase_price,selling_price_est,selling_price_act,expire_date,alert_date,dtt_add,uid_add" . "'";
                        $add_table_value = "'" . $pro_id[0]->result . "," . $rack_id[$i] . "," . $batch_no[$i] . "," . $product_id[$i] . "," . $supplier_id[$i] . "," . $stock_out_qty[$i] . "," . $purchase_price[$i]
                            . "," . $sale_price[$i] . "," . $sale_price[$i] . "," . $expire_date[$i] . "," . $alert_date[$i] . "," . $dtt_add . "," . $uid_add . "'";
                        $qry_res = $this->db->query("CALL insert_row('stock_mvt_details'," . $add_table_key . "," . $add_table_value . ")");
                        $details_id = $qry_res->result_object();
                        $qry_res->next_result();
                        $qry_res->free_result();
                        if ($details_id[0]->result) {
                            $stock_id_val = $id_stock[$i];
                            $data_qty = $qty[$i] - $stock_out_qty[$i];
                            //$stocks_id = $this->Stock_out_model->common_update('stocks', $data_stocks, 'id_stock', $stock_id_val, false);
                            $add_table_key = "'" . "qty,dtt_mod,uid_mod" . "'";
                            $add_table_value = "'" . $data_qty . "," . $dtt_add . "," . $uid_add . "'";
                            $qry_res = $this->db->query("CALL update_row('stocks'," . $add_table_key . "," . $add_table_value . ",'id_stock','" . $stock_id_val . "')");
                            $qry_res->next_result();
                            $qry_res->free_result();
                        }

                    }
                }
                $this->auto_increment->updAutoIncKey('STOCK_OUT_INVOICE', $invoice_no, $default_invoice_no);

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
            echo json_encode(array("status" => $type, "message" => $msg));
        }
    }

    public function check_invoice_no()
    {
        $invoice_number = $this->input->post('invoice_number');
        $invoice_check = $this->Common_model->isExist('stock_mvts', 'invoice_no', $invoice_number);
        if ($invoice_check) {
            echo 1;
        } else {
            echo 0;
        }

    }

    public function stock_out_details($stock_out_id = null)
    {
        $this->breadcrumb->add(lang('stock_out_list'), 'stock_out', 1);
        $this->breadcrumb->add(lang('stock_out_details'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['stock_out_list'] = $this->Stock_out_model->stock_out_details_list($stock_out_id);
        $data['columns'] = $this->Stock_out_model->getvalue_row('acl_user_column', 'permission', array('menu_url'=>'stock_out_details'));
        $data['doc_list'] = $this->Stock_out_model->get_doc_file($stock_out_id);
        $data['stock_out_id'] = $stock_out_id;
        $data['store_name'] = $this->Stock_out_model->store_name_by_stock_id($stock_out_id);
        $this->template->load('main', 'stock_out/stock_out_details', $data);
    }
    public function stock_out_print_view()
    {
        $stock_out_id = $this->input->post('id');
        $data['stock_out_list'] = $this->Stock_out_model->stock_out_details_list($stock_out_id);
        $data['columns'] = $this->Stock_out_model->getvalue_row('acl_user_column', 'permission', array('menu_url'=>'stock_out_details'));
        $data3['head'] = array(
            'title' => 'Stock Out Details',
            'invoice_no' => $data['stock_out_list'][0]['invoice_no'],
            'date' => $data['stock_out_list'][0]['dtt_stock_mvt']
        );
        $data3['report']=$this->load->view('stock_out/stock_out_details_list', $data, true);
        $this->load->view('print_page', $data3, false);
    }

    //**Stock In Section End**//


}
