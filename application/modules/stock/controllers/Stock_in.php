<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_in extends MX_Controller
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

        $this->load->model('Stock_in_model');
        $this->load->model('auto_increment');
    }


    //**Stock In Section Start**//
    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('stock_in_list');
        $this->breadcrumb->add(lang('stock_list'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->Stock_in_model->stock_in_list();
        $totalRec = ($row!='')?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock/stock_in_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['stores'] = $this->Stock_in_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->Stock_in_model->stock_in_list(array('limit' => $this->perPage));
        //$data['supplier_list'] = $this->Stock_in_model->get_supplier_drop_down();
        $this->template->load('main', 'stock_in/stock_in_list', $data);
    }

    public function stock_in_pagination_data()
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
        $row = $this->Stock_in_model->stock_in_list($conditions);
        $totalRec = ($row!='')?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock/stock_in_pagination_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['stores'] = $this->Stock_in_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->Stock_in_model->stock_in_list($conditions);
        //load the view
        $this->load->view('stock_in/stock_in_list_pagination', $data, false);
    }

    public function product_stock_in()
    {
        $this->dynamic_menu->check_menu('stock_in_list');
        $this->breadcrumb->add(lang('stock_list'), 'stock_in_list', 1);
        $this->breadcrumb->add(lang('stock_in'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['stores'] = $this->Stock_in_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['rack_list'] = $this->Stock_in_model->common_cond_single_value_array('racks', 'id_rack', 'name', 'status_id', '1', 'id_rack', 'ASC');
        $data['invoice_id'] = $this->auto_increment->getAutoIncKey('STOCK_IN_INVOICE', 'stock_mvts', 'invoice_no');
        $data['batch_id'] = $this->auto_increment->getAutoIncKey('STOCK_IN_BATCH', 'stock_mvt_details', 'batch_no');
        $data['attributes'] = $this->Stock_in_model->getvalue_row('product_attributes', 'id_attribute,attribute_name,attribute_value', array('status_id' => 1));
        $data['suppliers'] = $this->Stock_in_model->getvalue_row('suppliers', 'id_supplier,supplier_code,supplier_name', array('status_id' => 1));
        $data['products'] = $this->Stock_in_model->getvalue_row('products', 'id_product,product_code,product_name', array('status_id' => 1));
        $data['reason_list'] = $this->Stock_in_model->get_stocks_reason();
        $this->template->load('main', 'stock_in/stock_in_form', $data);
    }


    public function get_products()
    {
        $request = $_REQUEST['request'];
        $product_list = $this->Stock_in_model->get_product($request);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->product_name,
                "value" => $list->id_product,
                "buy_price" => $list->buy_price,
                "sell_price" => $list->sell_price,
                "pro_code" => $list->product_code,
                "is_vatable" => $list->is_vatable
                // "is_unq_barcode" => $list->is_unq_barcode
            );
        }
        echo json_encode($return);
    }

    public function get_available_stock_in_products()
    {
        $request = $_REQUEST['request'];
        $storename = $_REQUEST['storename'];
        $product_list = $this->Stock_in_model->get_available_stock_in_products($request, $storename);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->product_name,
                "value" => $list->product_id,
                "batch_no" => $list->batch_no,
                "buy_price" => $list->buy_price,
                "sell_price" => $list->sell_price,
                "pro_code" => $list->product_code,
                "is_vatable" => $list->is_vatable
                // "is_unq_barcode" => $list->is_unq_barcode
            );
        }
        echo json_encode($return);
    }
    public function get_suppliers()
    {
        $request = $_REQUEST['request'];
        $supplier_list = $this->Stock_in_model->get_supplier($request);
        $return = array();
        foreach ($supplier_list as $list) {
            $return[] = array(
                "label" => $list->supplier_name,
                "value" => $list->id_supplier
            );
        }
        echo json_encode($return);
    }


    public function stock_in_insert()
    {
        $this->form_validation->set_rules('invoice_no', 'Invoice Number', 'trim|required|is_unique[stock_mvts.invoice_no]');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $total_num_of_fields = $this->input->post('total_num_of_fields');
            $supplier_id = $this->input->post('row_supplier_id');
            $invoice_no = $this->input->post('invoice_no');
            $default_invoice_no = $this->input->post('default_invoice_no');
            $notes = $this->input->post('notes');
            $stock_mvt_date = $this->input->post('dtt_stock_mvt');
            $rack_id = $this->input->post('rack_id');
            $batch_no = $this->input->post('row_batch_no');
            $product_id = $this->input->post('row_product_id');
            $qty = $this->input->post('row_qty');
            $stock_mvt_reason_id = $this->input->post('stock_mvt_reason_id');
            $purchase_price = $this->input->post('row_purchase_price');
            $sale_price = $this->input->post('row_sale_price');
            $expire_date = $this->input->post('row_expire_date');
            $alert_date = $this->input->post('row_alert_date');
            $default_batch_no = $this->input->post('batch_no');
            $new_batch_no = $this->input->post('batch_no');
            $row_attr_value = $this->input->post('row_attr_value');

            if (file_exists($_FILES['stock_in_doc']['tmp_name'])) {
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
                $add_table_value = "'12," . $invoice_no . "," . $store_id . "," . $notes . "," . $stock_mvt_reason_id . "," . $is_doc_attached . "," . $dtt_stock_mvt . "," . $dtt_add . "," . $uid_add . "'";
                $qry_res = $this->db->query("CALL insert_row('stock_mvts'," . $add_table_key . "," . $add_table_value . ")");
                $pro_id = $qry_res->result_object();
                $qry_res->next_result();
                $qry_res->free_result();
                //$stock_mvts_id = $this->Stock_in_model->common_insert('stock_mvts', $data_stock_mvts);

                if ($_FILES['stock_in_doc']['name'] != '') {
                    $filename = upload_file('stock', $_FILES['stock_in_doc']);
                    if ($filename) {
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
                        //$stock_mvt_details_id = $this->Stock_in_model->common_insert('stock_mvt_details', $data_stock_mvts_details);
                        $add_table_key = "'" . "stock_mvt_id,rack_id,batch_no,product_id,supplier_id,qty,purchase_price,selling_price_est,selling_price_act,expire_date,alert_date,dtt_add,uid_add" . "'";
                        $add_table_value = "'" . $pro_id[0]->result . "," . $rack_id[$i] . "," . $batch_no[$i] . "," . $product_id[$i] . "," . $supplier_id[$i] . "," . $qty[$i] . "," . $purchase_price[$i]
                            . "," . $sale_price[$i] . "," . $sale_price[$i] . "," . $expire_date[$i] . "," . $alert_date[$i] . "," . $dtt_add . "," . $uid_add . "'";
                        $qry_res = $this->db->query("CALL insert_row('stock_mvt_details'," . $add_table_key . "," . $add_table_value . ")");
                        $details_id = $qry_res->result_object();
                        $qry_res->next_result();
                        $qry_res->free_result();

                        if ($details_id[0]->result) {
                            $store_id = $this->input->post('store_name');
                            //$stocks_id = $this->Stock_in_model->common_insert('stocks', $data_stocks);
                            $add_table_key = "'" . "stock_mvt_type_id,stock_mvt_id,stock_mvt_detail_id,supplier_id,store_id,rack_id,batch_no,product_id,qty,purchase_price,selling_price_est,selling_price_act,expire_date,alert_date,dtt_add,uid_add" . "'";
                            $add_table_value = "'12," . $pro_id[0]->result . "," . $details_id[0]->result . "," . $supplier_id[$i] . "," . $store_id . "," . $rack_id[$i] . "," . $batch_no[$i] . "," . $product_id[$i]
                                . "," . $qty[$i] . "," . $purchase_price[$i] . "," . $sale_price[$i] . "," . $sale_price[$i] . "," . $expire_date[$i] . "," . $alert_date[$i] . "," . $dtt_add . "," . $uid_add . "'";
                            $qry_res = $this->db->query("CALL insert_row('stocks'," . $add_table_key . "," . $add_table_value . ")");
                            $pro_id1 = $qry_res->result_object();
                            $qry_res->next_result();
                            $qry_res->free_result();
                            if ($row_attr_value[$i]!='') {
                                $array = explode(',', $row_attr_value[$i]);
                                $m = 0;
                                while ($m < count($array)) {
                                    $dataArray = $array[$m];
                                    $dataValue = explode('=', $dataArray);
                                    $data = array(
                                        'stock_id' => $pro_id1[0]->result
                                    , 'p_attribute_id' => $dataValue[0]
                                    , 's_attribute_name' => $dataValue[1]
                                    , 's_attribute_value' => $dataValue[2]
                                    , 'status_id' => 1
                                    );
                                    $this->Stock_in_model->common_insert('stock_attributes', $data);
                                    $m++;
                                }
                            }
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
            echo json_encode(array("status" => $type, "message" => $msg));
        }

    }

    public function stock_in_details($stock_in_id = null)
    {
        $this->breadcrumb->add(lang('stock_list'), 'stock_in_list', 1);
        $this->breadcrumb->add(lang('stock_in_details'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['stock_in_list'] = $this->Stock_in_model->stock_in_details_list($stock_in_id);
        $data['doc_list'] = $this->Stock_in_model->get_doc_file($stock_in_id);
        $data['store_name'] = $this->Stock_in_model->store_name_by_stock_id($stock_in_id);
        $data['stock_id'] = $stock_in_id;
        $this->template->load('main', 'stock_in/stock_in_details', $data);
    }
    public function stock_print_view()
    {
        $id = $this->input->post('id');
        $data['stock_in_list'] = $this->Stock_in_model->stock_in_details_list($id);
        $data3['head'] = array(
            'title' => 'Stock In Details',
            'invoice_no' => $data['stock_in_list'][0]['invoice_no'],
            'date' => $data['stock_in_list'][0]['dtt_stock_mvt']
        );
        $data3['report']=$this->load->view('stock_in/stock_in_details_list', $data, true);
        $this->load->view('print_page', $data3, false);
    }
    public function stock_insert_attributes()
    {
        $main = $this->input->post('main');
        $child = $this->input->post('child');
        $c_main = (isset($main))?count($main):0;
        $a = 0;
        if ($c_main > 0) {
            $arrayValue = array();
            if ($a < $c_main) {
                $array = explode('@', $main[$a]);
                $id = $array[0];
                $name = $array[1];
                for ($i = 0; $i < count($child[$id]); $i++) {
                    $dd = array();
                    $ch = $child[$id][$i];
                    //$dd+=array($id=>$ch);
                    $b = $a + 1;
                    if ($b < $c_main) {
                        $array = explode('@', $main[$b]);
                        $id1 = $array[0];
                        $name1 = $array[1];
                        for ($j = 0; $j < count($child[$id1]); $j++) {
                            $ch1 = $child[$id1][$j];
                            //$dd+=array($id1=>$ch1);
                            $c = $a + 2;
                            // echo $c.'>'.$c_main;
                            if ($c < $c_main) {
                                $array = explode('@', $main[$c]);
                                $id2 = $array[0];
                                $name2 = $array[1];
                                for ($k = 0; $k < count($child[$id2]); $k++) {
                                    $ch2 = $child[$id2][$k];
                                    $dd = array(
                                        $main[$a] => $ch,
                                        $main[$b] => $ch1,
                                        $main[$c] => $ch2
                                    );
                                    $arrayValue[] = $dd;
                                }
                            } else {
                                $dd = array(
                                    $main[$a] => $ch,
                                    $main[$b] => $ch1
                                );
                                $arrayValue[] = $dd;
                            }

                        }
                    } else {
                        $dd = array(
                            $main[$a] => $ch
                        );
                        $arrayValue[] = $dd;
                    }
                    //$arrayValue[]=$dd;
                }
            }
            foreach ($arrayValue as $data) {
                $newData[] = $data;
            }
            echo json_encode($newData);
        } else {
            echo 1;
        }

        //print_r($arrayValue);
    }

    //**Stock In Section End**//


}
