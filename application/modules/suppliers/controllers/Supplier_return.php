<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_return extends MX_Controller
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

        $this->load->model('Supplier_return_model');
        $this->load->model('auto_increment');
        $this->load->model('Common_model');
    }


    //**Stock In Section Start**//
    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('supplier-return');
        $this->breadcrumb->add(lang('supplier_return_list'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $totalRec = count($this->Supplier_return_model->supplier_return_list());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'supplier-return/supplier_return_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['posts'] = $this->Supplier_return_model->supplier_return_list(array('limit' => $this->perPage));
        $data['supplier_list'] = $this->Supplier_return_model->get_supplier_drop_down();
        $this->template->load('main', 'supplier_return/supplier_return_list', $data);
    }

    public function supplier_return_pagination_data()
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

        //total rows count
        $totalRec = count($this->Supplier_return_model->supplier_return_list($conditions));
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
        $data['posts'] = $this->Supplier_return_model->supplier_return_list($conditions);
        //load the view
        $this->load->view('supplier_return/supplier_return_list_pagination', $data, false);
    }


    public function supplier_return_form()
    {
        $this->dynamic_menu->check_menu('supplier-return');
        $this->breadcrumb->add(lang('supplier_return_list'), 'supplier-return', 1);
        $this->breadcrumb->add(lang('supplier_return'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['invoice_id'] = $this->auto_increment->getAutoIncKey('SUPPLIER_RETURN_INVOICE', 'stock_mvts', 'invoice_no');
        $data['reason_list'] = $this->Supplier_return_model->get_stocks_reason();
        $data['supplier_list'] = $this->Supplier_return_model->get_supplier_drop_down();
        $this->template->load('main', 'supplier_return/supplier_return_form', $data);
    }

    public function get_supplier_return_purchase_list()
    {
        $invoice_no = $this->input->post('invoice_number');
        $products = $this->Supplier_return_model->get_purchase_products($invoice_no);
        //print_r($products);
        $html = '';
        $count = 1;
        if ($products) {
            foreach ($products as $data) {
                $html .= '<tr id="' . $count . '">';
                $html .= '<td>' . $data['product_name'] . '<input type="hidden" name="pro_name[]" id="pro_name_' . $count . '" value="' . $data['product_id'] . '" ><input type="hidden" name="pur_receive_id[]" id="pur_receive_id" value="' . $data['purchase_receive_id'] . '" >';
                $html .= '<input type="hidden" name="pur_receive_details_id[]" id="pur_receive_details_id" value="' . $data['id_purchase_receive_detail'] . '" >';
                $html .= '<input type="hidden" name="supplier_id[]" id="supplier_id" value="' . $data['supplier_id'] . '" >';
                $html .= '<input type="hidden" name="stock_id[]" id="product_id" value="' . $data['id_stock'] . '" >';
                $html .= '<input type="hidden" name="batch_no[]" id="batch_no" value="' . $data['batch_no'] . '" >';
                $html .= '<input type="hidden" name="selling_price_act[]" id="selling_price_act" value="' . $data['selling_price_act'] . '" >';
                $html .= '</td>';
                $html .= '<td>' . $data['supplier_name'] . '</td>';
                $html .= '<td><input type="text" name="pur_qty[]" id="pur_qty_' . $count . '" value="' . $data['qty'] . '" readonly ></td>';
                $html .= '<td><input type="text" name="stock_qty[]" id="stock_qty_' . $count . '" value="' . $data['stock_qty'] . '" readonly ></td>';
                $html .= '<td><input type="text" name="pur_price[]" id="pur_price_' . $count . '" value="' . $data['purchase_price'] . '"readonly ></td>';
                $html .= '<td><input class="chqty" type="text" name="return_qty[]" id="return_' . $count . '" > <lable id="return_error_' . $count . '" class="error"></lable></td>';
                $html .= '<td><input type="text" name="total_price[]" id="total_price_' . $count . '" > <lable id="total_price_error_' . $count . '" class="error"></lable></td>';
                $html .= '<td><button class="btn btn-danger btn-xs" onclick="removeMore(' . $count . '  );">X</button></td>';
                $html .= '</tr>';
                $count++;
            }
        } else {
            $html .= '<tr rowspan="3">';
            $html .= '<td>No data found</td>';
            $html .= '</tr>';
        }

        echo $html;
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

    public function get_purchase_recieve_data()
    {
        $product_id = $this->input->post('product_id');
        $supplier_id = $this->input->post('supplier_id');

        if (!empty($product_id) && !empty($supplier_id)) {
            $batch_list = $this->Supplier_return_model->get_batch_list_by_product($product_id, $supplier_id);
            echo json_encode($batch_list);
        }
    }

    public function get_stock_detail_data()
    {
        $stock_id = $this->input->post('stock_id');
        if (!empty($stock_id)) {
            $stock_list = $this->Supplier_return_model->stocks_details($stock_id);
            echo json_encode($stock_list);
        }
    }


    public function supplier_return_insert()
    {

        $product_id = $this->input->post('pro_name');
        $pur_receive_id = $this->input->post('pur_receive_id');
        $supplier_id = $this->input->post('supplier_id');
        $pur_receive_details_id = $this->input->post('pur_receive_details_id');
        $pur_qty = $this->input->post('pur_qty');
        $notes = $this->input->post('notes');
        $batch_no = $this->input->post('batch_no');
        $stock_mvt_date = $this->input->post('dtt_stock_mvt');
        $id_stock = $this->input->post('stock_id');
        $pur_price = $this->input->post('pur_price');
        $selling_price_act = $this->input->post('selling_price_act');
        $unit_total_price = $this->input->post('total_price');
        $return_qty = $this->input->post('return_qty');
        $invoice_no = $this->input->post('invoice_no');
        $stock_mvt_reason_id = $this->input->post('stock_mvt_reason_id');
        if (file_exists($_FILES['stock_out_doc']['tmp_name'])) {
            $is_doc_attached = 1;
        } else {
            $is_doc_attached = 0;
        }
        $total_qty=$total_price=0;
        for ($i = 0; $i < count($return_qty); $i++) {
            $total_qty+=$return_qty[$i];
            $total_price+=$unit_total_price[$i];
        }
        $data_supplier_returns['purchase_receive_id'] = $pur_receive_id[0];
        $data_supplier_returns['supplier_id'] = $supplier_id[0];
        $data_supplier_returns['invoice_no'] = $invoice_no;
        $data_supplier_returns['store_id'] = $this->session->userdata['login_info']['store_id'];
        $data_supplier_returns['notes'] = $notes;
        $data_supplier_returns['qty'] = $total_qty;
        $data_supplier_returns['tot_amt'] = $total_price;
        $data_supplier_returns['is_doc_attached'] = $is_doc_attached;
        $data_supplier_returns['dtt_add'] = date('Y-m-d H:i:s');
        $data_supplier_returns['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
        $stock_mvts_id = $this->Supplier_return_model->common_insert('supplier_returns', $data_supplier_returns);
        if ($_FILES['stock_out_doc']['name']!='') {
            $filename = upload_file('supplier', $_FILES['stock_out_doc']);
            $data_document['doc_type'] = 'Supplier Return';
            $data_document['ref_id'] = $stock_mvts_id;
            $data_document['file'] = $filename;
            $data_document['dtt_add'] = date('Y-m-d H:i:s');
            $data_document['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $document_id = $this->Supplier_return_model->common_insert('documents', $data_document);
        }
        $store_id = $this->session->userdata['login_info']['store_id'];
        $dtt_stock_mvt = $stock_mvt_date . ' ' . date('H:i:s');
        $dtt_add = date('Y-m-d H:i:s');
        $uid_add = $this->session->userdata['login_info']['id_user_i90'];
        $add_table_key = "'" . "stock_mvt_type_id,invoice_no,store_id,notes,stock_mvt_reason_id,is_doc_attached,dtt_stock_mvt,dtt_add,uid_add" . "'";
        $add_table_value = "'6," . $invoice_no . "," . $store_id . "," . $notes . "," . $stock_mvt_reason_id . "," . $is_doc_attached . "," . $dtt_stock_mvt . "," . $dtt_add . "," . $uid_add . "'";
        $qry_res = $this->db->query("CALL insert_row('stock_mvts'," . $add_table_key . "," . $add_table_value . ")");
        $stock_mvt = $qry_res->result_object();
        $qry_res->next_result();
        $qry_res->free_result();
        for ($i = 0; $i < count($product_id); $i++) {
            if ($stock_mvts_id) {
                $add_table_key = "'" . "stock_mvt_id,batch_no,product_id,supplier_id,qty,purchase_price,selling_price_est,selling_price_act,dtt_add,uid_add" . "'";
                $add_table_value = "'" . $stock_mvt[0]->result . "," . $batch_no[$i] . "," . $product_id[$i] . "," . $supplier_id[$i] . "," . $return_qty[$i] . "," . $pur_price[$i]
                    . "," . $selling_price_act[$i] . "," . $selling_price_act[$i] . "," . $dtt_add . "," . $uid_add . "'";
                $qry_res = $this->db->query("CALL insert_row('stock_mvt_details'," . $add_table_key . "," . $add_table_value . ")");
                $details_id = $qry_res->result_object();
                $qry_res->next_result();
                $qry_res->free_result();
                $data_supplier_return_details['supplier_return_id'] = $stock_mvts_id;
                $data_supplier_return_details['purchase_receive_details_id'] = $pur_receive_details_id[$i];
                $data_supplier_return_details['qty'] = $return_qty[$i];
                $data_supplier_return_details['product_id'] = $product_id[$i];
                $data_supplier_return_details['unit_price'] = $pur_price[$i];
                $data_supplier_return_details['adjust_price'] = $unit_total_price[$i];
                $supplier_return_details_id = $this->Supplier_return_model->common_insert('supplier_return_details', $data_supplier_return_details);

                if ($supplier_return_details_id) {
                    $stocks_id = $this->Common_model->update_balance_amount('stocks', 'qty', $return_qty[$i], '-', array('id_stock' => $id_stock[$i]));
                }

            }
        }
        if ($stock_mvts_id) {
            $this->Common_model->update_balance_amount('suppliers', 'credit_balance',$total_price, '+', array('id_supplier' => $supplier_id[0]));
        }
        if ($stocks_id) {
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
        // }


    }
    public function supplier_return_details($id=null){
        $products = $this->Supplier_return_model->supplier_return_details_by_id($id);
        $html='';
        if ($products) {
            foreach ($products as $data) {
                $html .= '<tr>';
                $html .= '<td>' . $data['product_name'] . '</td>';
                $html .= '<td>' . $data['product_code'] . '</td>';
                $html .= '<td>' . $data['qty'] . '</td>';
                $html .= '<td class="text-right">' . $data['unit_price'] . '</td>';
                $html .= '<td class="text-right">' .  $data['qty']*$data['unit_price'] . '</td>';
                $html .= '<td class="text-right">' . $data['adjust_price'] . '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr>';
            $html .= '<td colspan="5">No data found</td>';
            $html .= '</tr>';
        }
        echo $html;
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
        $data['stock_out_list'] = $this->Supplier_return_model->stock_out_details_list($stock_out_id);
        $data['doc_list'] = $this->Supplier_return_model->get_doc_file($stock_out_id);
        $this->template->load('main', 'stock_out/stock_out_details', $data);
    }

    //**Stock In Section End**//


}
