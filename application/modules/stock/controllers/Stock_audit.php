<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_audit extends MX_Controller
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

        $this->load->model('Stock_audit_model');
        $this->load->model('auto_increment');
    }


    //**Stock Audit Section Start**//
    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('stock_audit');
        $this->breadcrumb->add(lang('stock_audit_list'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $totalRec = count($this->Stock_audit_model->stock_audit_list());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock/stock_audit_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['posts'] = $this->Stock_audit_model->stock_audit_list(array('limit' => $this->perPage));
        $data['stores'] = $this->Stock_audit_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $key => $value) {
                $data['posts'][$key]['audit_participants'] = $this->Stock_audit_model->get_audit_users($data['posts'][$key]['audit_by']);
            }
        }

        $this->template->load('main', 'stock_audit/stock_audit_list', $data);
    }

    public function stock_audit_pagination_data()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $audit_no = $this->input->post('audit_no');
        if (!empty($audit_no)) {
            $conditions['search']['audit_no'] = $audit_no;
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
        $totalRec = count($this->Stock_audit_model->stock_audit_list($conditions));
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock/stock_audit_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['posts'] = $this->Stock_audit_model->stock_audit_list($conditions);
        $data['stores'] = $this->Stock_audit_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $key => $value) {
                $data['posts'][$key]['audit_participants'] = $this->Stock_audit_model->get_audit_users($data['posts'][$key]['audit_by']);
            }
        }

        //load the view
        $this->load->view('stock_audit/stock_audit_list_pagination', $data, false);
    }


    public function add_stock_audit()
    {
        $this->dynamic_menu->check_menu('stock_audit');
        $this->breadcrumb->add(lang('stock_audit_list'), 'stock_audit', 1);
        $this->breadcrumb->add(lang('stock_audit'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['stores'] = $this->Stock_audit_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['categories'] = $this->Stock_audit_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['brands'] = $this->Stock_audit_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['store_users'] = $this->Stock_audit_model->common_cond_dropdown_data('users', 'id_user', 'uname', 'store_id', $this->session->userdata['login_info']['store_id'], 'id_user', 'ASC');
        $data['audit_no'] = $this->auto_increment->getAutoIncKey('AUDIT_NUMBER', 'stock_audits', 'audit_no');
        $this->template->load('main', 'stock_audit/stock_audit_form', $data);
    }

    public function search_audit_stock_list()
    {
        $conditions = array();
        $cat_name = $this->input->post('cat_name');
        $product_name = $this->input->post('product_name');
        $sub_category = $this->input->post('sub_category');
        $brand = $this->input->post('brand');
        $store_id = $this->input->post('store_id');
        $values = $this->input->post('values');
        $data['value'] = explode(',', $values);
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($product_name)) {
            $conditions['search']['product_name'] = $product_name;
        }
        if (!empty($sub_category)) {
            $conditions['search']['sub_category'] = $sub_category;
        }
        if (!empty($brand)) {
            $conditions['search']['brand'] = $brand;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        $data['posts'] = $this->Stock_audit_model->getRowsProducts($conditions);
        // $sql = $this->db->last_query();
        //echo $product_name.$cat_name.$sub_category.$brand;
        //print_r($dataArray);
        //echo $sql;
        $this->load->view('stock_audit/search_audit_list', $data, false);
    }

    public function search_stock_product()
    {
        $return = array();
        $product_id = $this->input->post('id_check');
        $store_id = $this->input->post('store_id');
        for ($i = 0; $i < count($product_id); $i++) {
            $result = $this->Stock_audit_model->search_stock_in_product($product_id[$i], $store_id);
            if ($result) {
                foreach ($result as $list) {
                    $return[] = array(
                        "id_stock" => $list->id_stock,
                        "batch_no" => $list->batch_no,
                        "qty" => $list->qty,
                        "product_id" => $list->product_id,
                        "product_code" => $list->product_code,
                        "product_name" => $list->product_name
                    );
                }
            }
        }
        echo json_encode($return);
    }

    public function temp_add_cart_for_barcode()
    {
        $barcode_name = $this->input->post('barcode_name');
        $store_id = $this->input->post('store_name');
        // $acc_type = $this->input->post('acc_type');
        $batch_no = $this->input->post('batch_no');
        $product_id = $this->input->post('product_id');
        $total_count = $this->input->post('total_count');
        $barcode_exist = $this->input->post('barcode_exist');

        $batch = '';
        if ($barcode_name != '') {
            //if ($acc_type == 'No') {
            $pro_id = explode('-', $barcode_name);
            $id = explode('-', $barcode_name)[0];
            if (count($pro_id) > 2) {
                $batch = $pro_id[1] . '-' . $pro_id[2];
            } else if (count($pro_id) == 2) {
                $batch = $pro_id[1];
            }
            //}
            $data['batch_no'] = $batch;
            $data['id_product'] = $id;
            $data['store_id'] = $store_id;
            $post = $this->Stock_audit_model->get_product_barcode($data);
            $inc = 0;
            $row_id = array();
            $row_batch = array();
            $html = '';
            $i = 200;
            $inc = 1;
            $cn = $total_count + 1;
            if ($post) {
                if ($product_id != '') {
                    if ($barcode_exist) {
                        $row_id = explode(',', $product_id);
                        $row_batch = explode(',', $batch_no);
                        //$i=count($row_id)+1;
                        for ($k = 0; $k < count($row_id); $k++) {
                            if (($post[0]['product_id'] == $row_id[$k]) && ($post[0]['batch_no'] == $row_batch[$k])) {
                                $inc = 2;
                            }
                        }
                    }
                    $i += 1;
                }

                if ($inc == 1) {
                    //print_r($post);
                    $html .= '<tr id="' . $post[0]['id_stock'] . '"><input type="hidden" name="stock_audit_detail_id[]"><input type="hidden" name="stock_id[]" value="' . $post[0]['id_stock'] . '"><input type="hidden" name="id_pro[]" id="id_pro_' . $cn . '" value="' . $post[0]['product_id'] . '"><input type="hidden" name="batch_no[]" id="batch_no_' . $cn . '" value="' . $post[0]['batch_no'] . '">';
                    $html .= '<td>' . $post[0]['product_code'] . '</td>';
                    $html .= '<td>' . $post[0]['product_name'] . '</td>';
                    $html .= '<td>' . $post[0]['cat_name'] . '</td>';
                    $html .= '<td>' . $post[0]['sub_cat_name'] . '</td>';
                    $html .= '<td>' . $post[0]['brand_name'] . '</td>';
                    $html .= '<td>' . $post[0]['batch_no'] . '</td>';
                    $html .= '<td>' . $post[0]['purchase_price'] . '<input type="hidden" name="purchase_price[]" value="' . $post[0]['purchase_price'] . '" id="purchase_price_' . $cn . '"><input type="hidden" name="total_price[]" value="' . $post[0]['purchase_price'] * $post[0]['qty'] . '"> </td>';
                    $html .= '<td>' . $post[0]['qty'] . '<input type="hidden" name="qty_db[]" value="' . $post[0]['qty'] . '"></td>';
                    $html .= '<td><input class="form-control change_qty" style="width: 60px" type="text" name="qty_store[]" id="qty_store_' . $cn . '" value="1">' . '<input type="hidden" name="act_purchase_price[]" value="' . $post[0]['purchase_price'] . '" id="act_purchase_price_' . $cn . '"></td>';
                    $html .= '<td><input class="form-control" style="width: 100%" type="text" name="notes[]" id="notes"></td>';
                    $html .= '<td> <button class="btn btn-danger btn-xs" onclick="removeMore(' . $post[0]['id_stock'] . ');">X</button></td>';
                    echo json_encode(array('status' => 1, 'data' => $html));
                } else {
                    echo json_encode(array('status' => 2, 'data' => $data));
                }
            }
            //echo json_encode($data);
        } else {
            echo '';
        }
    }

    public function add_stock_audit_data()
    {
        // echo json_encode($_POST);
        // exit();
        $this->form_validation->set_rules('audit_no', 'Audit Number', 'trim|required|is_unique[stock_audits.audit_no]');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $dtt_audit = $this->input->post('dtt_audit');
            $audited_by_temp = $this->input->post('audited_by'); // array
            $audited_by = explode(',', $audited_by_temp);

            $audit_status = $this->input->post('audit_status');
            $stock_id = $this->input->post('stock_id');
            $qty_db = $this->input->post('qty_db');
            $qty_store = $this->input->post('qty_store');
            $notes = $this->input->post('notes');
            $audit_no = $this->input->post('audit_no');
            $store_name = $this->input->post('store_name');
            $audit_user = "";

            for ($i = 0; $i < count($audited_by); $i++) {
                if (count($audited_by) - 1 == $i) {
                    $audit_user .= $audited_by[$i];
                } else {
                    $audit_user .= $audited_by[$i] . ',';
                }
            }

            //////////insert stock audits//////////////////
            $data_stock_audits['audit_no'] = $audit_no;
            $data_stock_audits['store_id'] = $store_name;
            $data_stock_audits['audit_by'] = $audit_user;
            $data_stock_audits['dtt_audit'] = $dtt_audit;
            $data_stock_audits['status_id'] = $audit_status;
            $data_stock_audits['dtt_add'] = date('Y-m-d H:i:s');
            $data_stock_audits['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $stock_audits_id = $this->Stock_audit_model->common_insert('stock_audits', $data_stock_audits);



            if ($stock_audits_id) {
                for ($j = 0; $j < count($stock_id); $j++) {

                    $data_stock_audit_details['stock_audit_id'] = $stock_audits_id;
                    $data_stock_audit_details['stock_id'] = $stock_id[$j];
                    $data_stock_audit_details['qty_store'] = $qty_store[$j];
                    $data_stock_audit_details['qty_db'] = $qty_db[$j];
                    $data_stock_audit_details['notes'] = $notes[$j];
                    $data_stock_audit_details['dtt_add'] = date('Y-m-d H:i:s');
                    $data_stock_audit_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $stock_audit_details_id = $this->Stock_audit_model->common_insert('stock_audit_details', $data_stock_audit_details);
                }
            }

            if ($stock_audits_id) {
                $this->auto_increment->updAutoIncKey('AUDIT_NUMBER', $audit_no, $audit_no);
                echo json_encode(array("status" => "success", "message" => lang('add_success')));
            }
        }
    }

    public function edit_stock_audit_details($stock_audit_id = null)
    {
        $this->breadcrumb->add(lang('stock_audit_list'), 'stock_audit', 1);
        $this->breadcrumb->add(lang('edit_stock_audit'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['categories'] = $this->Stock_audit_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['brands'] = $this->Stock_audit_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['store_users'] = $this->Stock_audit_model->common_cond_dropdown_data('users', 'id_user', 'uname', 'store_id', $this->session->userdata['login_info']['store_id'], 'id_user', 'ASC');
        $data['audit_list'] = $this->Stock_audit_model->stock_audit_details($stock_audit_id);
        $data['audit_info'] = $this->Stock_audit_model->stock_audit_info($stock_audit_id);
        $data['doc_list'] = $this->Stock_audit_model->get_doc_file($stock_audit_id);

        // dd($data['audit_list']);
        $this->template->load('main', 'stock_audit/edit_stock_audit_form', $data);
    }


    public function update_stock_audit_data()
    {
        $stock_audit_id = $this->input->post('stock_audit_id');
        $old_audit_doc = $this->input->post('old_audit_doc');
        $is_doc_attached_old = $this->input->post('is_doc_attached');

        $stock_audit_detail_id = $this->input->post('stock_audit_detail_id');
        $dtt_audit = $this->input->post('dtt_audit');
        $audited_by_temp = $this->input->post('audited_by');
        $audited_by = explode(',', $audited_by_temp);

        $audit_status = $this->input->post('audit_status');
        $stock_id = $this->input->post('stock_id');
        $qty_db = $this->input->post('qty_db');
        $qty_store = $this->input->post('qty_store');
        $notes = $this->input->post('notes');
        $audit_no = $this->input->post('audit_no');
        $audit_user = "";

        for ($i = 0; $i < count($audited_by); $i++) {
            if (count($audited_by) - 1 == $i) {
                $audit_user .= $audited_by[$i];
            } else {
                $audit_user .= $audited_by[$i] . ',';
            }
        }

        if (!empty($_FILES['stock_in_doc']['tmp_name']) || !empty($old_audit_doc)) {
            $is_doc_attached = 1;
        } else {
            $is_doc_attached = 0;
        }

        //////////insert stock audits//////////////////
        $data_stock_audits['store_id'] = $this->session->userdata['login_info']['store_id'];
        $data_stock_audits['audit_by'] = $audit_user;
        $data_stock_audits['is_doc_attached'] = $is_doc_attached;
        $data_stock_audits['dtt_audit'] = $dtt_audit;
        $data_stock_audits['status_id'] = $audit_status;
        $data_stock_audits['dtt_add'] = date('Y-m-d H:i:s');
        $data_stock_audits['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
        $stock_audits_id = $this->Stock_audit_model->common_update('stock_audits', $data_stock_audits, 'id_stock_audit', $stock_audit_id);

        if ($is_doc_attached_old == 0 && $is_doc_attached == 1) {
            if (!empty($_FILES)) {
                $config['upload_path'] = 'public/uploads/stock_documents';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
                $config['max_size'] = 50000;
                $config['max_width'] = 1024;
                $config['max_height'] = 768;
                $config['file_name'] = date('d-m-Y') . '_' . time();

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('stock_in_doc')) {
                    $recipe_file = $this->upload->data();
                    $file = $config['file_name'];
                    $data_document['doc_type'] = 'Stock Audit';
                    $data_document['ref_id'] = $stock_audit_id;
                    $data_document['file'] = $recipe_file['file_name'];
                    $data_document['dtt_add'] = date('Y-m-d H:i:s');
                    $data_document['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $result = $this->Stock_audit_model->common_insert('documents', $data_document);
                }
            }
        } elseif ($is_doc_attached_old == 1 && $is_doc_attached == 1) {
            if (!empty($_FILES)) {
                $dir = realpath('public/uploads/stock_documents/' . $old_audit_doc);
                if (file_exists($dir)) {
                    unlink($dir);
                }
                $config['upload_path'] = 'public/uploads/stock_documents';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx';
                $config['max_size'] = 100000;
                $config['max_width'] = 102400;
                $config['max_height'] = 100000;
                $config['file_name'] = date('d-m-Y') . '_' . time();
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('stock_in_doc')) {

                    $recipe_file = $this->upload->data();
                    $file = $recipe_file['file_name'];
                    $data_document['file'] = $file;
                    $data_document['dtt_mod'] = date('Y-m-d H:i:s');
                    $data_document['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                    $doc_id = $this->Stock_audit_model->common_update('documents', $data_document, 'ref_id', $stock_audit_id);
                }
            }
        }

        if ($stock_audits_id) {
            if (!empty($stock_audit_detail_id)) {
                for ($k = 0; $k < count($stock_audit_detail_id); $k++) {
                    if (!empty($stock_audit_detail_id[$k])) {
                        //update
                        $id_stock_audit_detail = $stock_audit_detail_id[$k];
                        $data_stock_audit_details['qty_store'] = $qty_store[$k];
                        $data_stock_audit_details['notes'] = $notes[$k];
                        $data_stock_audit_details['dtt_mod'] = date('Y-m-d H:i:s');
                        $data_stock_audit_details['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                        $stock_audit_details_id = $this->Stock_audit_model->common_update('stock_audit_details', $data_stock_audit_details, 'id_stock_audit_detail', $id_stock_audit_detail);
                    } else {
                        //insert
                        $data_stock_audit_details['stock_audit_id'] = $stock_audit_id;
                        $data_stock_audit_details['stock_id'] = $stock_id[$k];
                        $data_stock_audit_details['qty_store'] = $qty_store[$k];
                        $data_stock_audit_details['qty_db'] = $qty_db[$k];
                        $data_stock_audit_details['notes'] = $notes[$k];
                        $data_stock_audit_details['dtt_add'] = date('Y-m-d H:i:s');
                        $data_stock_audit_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                        $stock_audit_details_id = $this->Stock_audit_model->common_insert('stock_audit_details', $data_stock_audit_details);
                    }
                }
            } else {
                ///insert
                for ($j = 0; $j < count($stock_id); $j++) {

                    $data_stock_audit_details['stock_audit_id'] = $stock_audit_id;
                    $data_stock_audit_details['stock_id'] = $stock_id[$j];
                    $data_stock_audit_details['qty_store'] = $qty_store[$j];
                    $data_stock_audit_details['qty_db'] = $qty_db[$j];
                    $data_stock_audit_details['notes'] = $notes[$j];
                    $data_stock_audit_details['dtt_add'] = date('Y-m-d H:i:s');
                    $data_stock_audit_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $stock_audit_details_id = $this->Stock_audit_model->common_insert('stock_audit_details', $data_stock_audit_details);
                }
            }
        }

        if ($stock_audit_details_id) {
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }


    public function stock_audit_details($stock_audit_id = null)
    {
        $this->breadcrumb->add(lang('stock_audit_list'), 'stock_audit', 1);
        $this->breadcrumb->add(lang('stock_audit_details'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['stock_audit_list'] = $this->Stock_audit_model->stock_audit_details($stock_audit_id);
        foreach ($data['stock_audit_list'] as $key => $value) {
            $data['stock_audit_list'][$key]['audit_participants'] = $this->Stock_audit_model->get_audit_users($data['stock_audit_list'][$key]['audit_by']);
        }
        $data['doc_list'] = $this->Stock_audit_model->get_doc_file($stock_audit_id);
        $this->template->load('main', 'stock_audit/stock_audit_details', $data);
    }
    public function get_products()
    {
        $request = $_REQUEST['request'];
        $store = $_REQUEST['store'];
        $product_list = $this->Stock_audit_model->get_product($request, $store);
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

    public function export_csv()
    {
        $this->load->helper('export_csv_helper');
        $id_stock_audit = $this->input->get('id_stock_audit');
        if ($id_stock_audit == null || $id_stock_audit == '') {
            echo 'No data found';
        }


        $stock_audit_list = $this->Stock_audit_model->stock_audit_details($id_stock_audit);
        $fields =
            ['Invoice No', 'Batch No', 'Product Name', 'Product Category', 'Sub Category', 'Brand', 'Attributes', 'Supplier', 'Stock Qty', 'Actual Qty', 'Note'];


        foreach ($stock_audit_list as $key => $value) {
            $data[] = [$value['invoice_no'], $value['batch_no'], $value['product_name'], $value['cat_name'], $value['sub_cat_name'], $value['brand_name'], $value['attribute_name'], $value['supplier_name'], $value['qty_db'], $value['qty_store'], $value['notes']];
        }


        $file_name = 'stock_audit_report_' . $id_stock_audit;
        $date[] = array('title' => 'Title', 'value' => 'Stock Audit Report');
        // $date[] = array('title' => 'From', 'value' => '0000-00-00');
        // $date[] = array('title' => 'To', 'value' => '0000-00-00');

        echo arrayToCSV($data, $fields, $date, $file_name);
    }


    public function update_stock_audit()
    {

        $stockData = $this->input->post('stockData');
        $audit_by = $this->input->post('audit_by');
        $stock_audit_id = $this->input->post('stock_audit_id');
        $status_id = $this->input->post('status_id');
        $exist_stock_db = $this->Stock_audit_model->getvalue_row('stock_audit_details', 'stock_id', array('stock_audit_id' => $stock_audit_id));
        $dtt_audit = $this->input->post('dtt_audit');


        $updated_stock_id = [];
        foreach ($stockData as $value) {
            $updated_stock_id[] = $value['stock_id'];
        }

        $db_stock_id = [];
        foreach ($exist_stock_db as $value) {
            $db_stock_id[] = $value->stock_id;
        }

        // Find new stock IDs
        $new_stock_id = array_diff($updated_stock_id, $db_stock_id);

        //find new stock IDs on stockData 
        $new_stock_data = [];
        foreach ($stockData as $value) {
            if (in_array($value['stock_id'], $new_stock_id)) {
                $new_stock_data['stock_id'] = $value['stock_id'];
                $new_stock_data['qty_store'] = $value['qty_store'];
                $new_stock_data['qty_db'] = $value['qty_db'];
                $new_stock_data['stock_audit_id'] = $stock_audit_id;
                $new_stock_data['dtt_add'] = date('Y-m-d H:i:s');
                $new_stock_data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $new_stock_data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $new_stock_data['status_id'] = $status_id;
                $this->Stock_audit_model->common_insert('stock_audit_details', $new_stock_data);
            }
        }

        // Find deleted stock IDs
        $deleted_stock_id = array_diff($db_stock_id, $updated_stock_id);

        // Delete stock IDs
        foreach ($deleted_stock_id as $value) {
            $this->Stock_audit_model->common_delete('stock_audit_details', 'stock_id', $value);
        }
 

        foreach ($stockData as $value) {
            $data_stock_audit_details['qty_store'] = $value['qty_store'];
            $data_stock_audit_details['dtt_mod'] = date('Y-m-d H:i:s');
            $data_stock_audit_details['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
            $this->Stock_audit_model->common_update('stock_audit_details', $data_stock_audit_details, 'stock_id', $value['stock_id']);
        }


        $data_stock_audits['audit_by'] = $audit_by;
        $data_stock_audits['status_id'] = $status_id;
        $data_stock_audits['dtt_mod'] = date('Y-m-d H:i:s');
        $data_stock_audits['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data_stock_audits['dtt_audit'] = date('Y-m-d H:i:s', strtotime($dtt_audit));
        $this->Stock_audit_model->common_update('stock_audits', $data_stock_audits, 'id_stock_audit', $stock_audit_id);


        

        $response = [
            "status" => "success",
            "message" => lang('update_success')
        ];

        echo json_encode($response);


    }










    //**Stock Audit Section End**//



}
