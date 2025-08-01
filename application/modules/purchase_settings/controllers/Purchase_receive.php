<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_receive extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('purchase_model');
        $this->load->model('auto_increment');
        $this->perPage = 20;
    }

    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('purchase-receive');
        $this->breadcrumb->add(lang('purchase_receive'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $totalRec = count($this->purchase_model->getRowsReceiveList());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'purchase_order/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['stores'] = $this->purchase_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->purchase_model->getRowsReceiveList(array('limit' => $this->perPage));
        $this->template->load('main', 'receive/index', $data);
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
        $store_name = $this->input->post('store_name');
        $invoice_no = $this->input->post('invoice_no');
        $supplier_name = $this->input->post('supplier_name');
        if (!empty($store_name)) {
            $conditions['search']['store_name'] = $store_name;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($supplier_name)) {
            $conditions['search']['supplier_name'] = $supplier_name;
        }
        $totalRec = count($this->purchase_model->getRowsReceiveList($conditions));
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'requisition/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['stores'] = $this->purchase_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->purchase_model->getRowsReceiveList($conditions);
        //echo $this->db->last_query();
        $this->load->view('receive/all_receive_data', $data, false);
    }

    public function add_receive($id = null)
    {
        $this->dynamic_menu->check_menu('purchase-receive');
        $data = array();
        $this->breadcrumb->add(lang('purchase_receive'), 'purchase_receive', 1);
        $this->breadcrumb->add(lang('add_receive'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['posts'] = $this->purchase_model->order_details($id);
        $data['rack_list'] = $this->purchase_model->getvalue_row('racks', 'id_rack,name', array('status_id' => 1, 'store_id' => $this->session->userdata['login_info']['store_id']));
        $data['orders'] = $this->purchase_model->getvalue_row('purchase_orders', 'id_purchase_order,store_id,supplier_id', array('status_id' => 1, 'id_purchase_order' => $id));
        $data['invoice_id'] = $this->auto_increment->getAutoIncKey('PURCHASE_RECEIVE_INVOICE', 'purchase_receives', 'invoice_no');
        $data['batch_id'] = $this->auto_increment->getAutoIncKey('STOCK_IN_BATCH', 'stocks', 'batch_no');
        $data['attributes'] = $this->purchase_model->getvalue_row('product_attributes', 'id_attribute,attribute_name,attribute_value', array('status_id' => 1));
        $data['reason_list'] = $this->purchase_model->get_stocks_reason(1);
        $this->template->load('main', 'receive/add_receive', $data);
    }

    public function temp_add_search_receive()
    {
        $html = '';
        $checks = $this->input->post('id_check');
        $code = $this->input->post('code');
        $name = $this->input->post('name');
        $qty = $this->input->post('qty');
        $act_qty = $this->input->post('act_qty');
        $unit_price = $this->input->post('unit_price');
        $total_price = $this->input->post('total_price');
        $expire_date = $this->input->post('f_expire_date');
        $alert_date = $this->input->post('f_alert_date');
        $sell_price = $this->input->post('sell_price');
        $details_id_v = $this->input->post('details_id');
        $row_attr_value = $this->input->post('row_attr_value');
        $row_attr_show = $this->input->post('row_attr_show');
        // echo '<pre>';
        // print_r($checks);
        $batch_id = $this->auto_increment->getAutoIncKey('STOCK_IN_BATCH', 'stock_mvt_details', 'batch_no');
        //$suppliers = $this->purchase_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $rack_id = $this->purchase_model->getvalue_row('racks', 'id_rack,name', array('status_id' => 1));
        $bId = 1;
        $count = 0;
        $temp_name = array();
        for ($i = 0; $i < count($checks); $i++) {
            $row_id = $checks[$i];
            $id_qty = $qty[$i];
            $code_v = $code[$i];
            $name_v = $name[$i];
            if (in_array($name_v, $temp_name)) {
                $new_batch_id = $batch_id . '-' . $bId;
                $bId++;
            } else {
                $new_batch_id = $batch_id;
            }
            array_push($temp_name, $name_v);
            $sell_price_v = $sell_price[$i];
            // $act_qty_v = $act_qty[$i];
            // $product = $this->purchase_model->getvalue_row_one('products', '*', array('status_id' => 1, 'id_product' => $checks[$i]));
            //print_r($product);
            // echo $product[0]['product_name'];
            // if(count($id_qty)>1){
            //echo $row_id.'='.$code_v.'='.$name_v.'='.$act_qty_v.'='.$unit_price_v.'='.$total_price_v.'/////';
            // }
            //echo count($act_qty[$checks[$i]]).'bb';
            //echo $act_qty_v.'==';


            $html .= '<tr id="' . $checks[$i] . '">';
            $html .= '<td>' . $code_v.'<br>'.$row_attr_show[$i]. '<input type="hidden" name="row_attr_value[]" value="' . $row_attr_value[$i] . '"><input type="hidden" name="code[]" value="' . $code_v . '"> <input type="hidden" name="pro_id[]" value="' . $row_id . '">'
                . '<input type="hidden" name="details_id[]" value="' . $details_id_v[$i] . '">' . '</td>';
            $html .= '<td>' . $name_v . '<input type="hidden" name="name[]" value="' . $name_v . '">' . '</td>';
            $html .= '<td><input style="width:50px;" class="form-control" onchange="change_price(this)" type="text" name="act_qty[]" value="' . $act_qty[$i] . '" id="act_qty_' . $i . '"></td>';
            $html .= '<td><input style="width:70px;" class="form-control Number" onchange="change_price(this)" type="text" name="unit_price[]" onchange="change_cart(' . $i . ')" id="unit_price_' . $i . '" value="' . $unit_price[$i] . '">' . '</td>';
            $html .= '<td><input style="width:60px;" class="form-control" type="text" name="sell_price[]" value="' . $sell_price_v . '"></td>';
            $html .= '<td><select class="select2" data-live-search="true" name="rack_id[]" id="rack_id[]">';
            $html .= '<option value="0">' . lang("select_one") . '</option>';
            if (!empty($rack_id)) {
                foreach ($rack_id as $rack) {
                    //$select = ($rack->id_supplier == $id_supplier) ? 'selected' : '';
                    $html .= '<option value="' . $rack->id_rack . '">' . $rack->name . '</option>';
                }
            }
            $html .= '</select></td>';
            $html .= '<td><input type="text" class="form-control datepicker3"id="f_expire_date[]" name="f_expire_date[]" value="' . $expire_date[$i] . '">' . '</td>';
            $html .= '<td><input type="text" class="form-control datepicker3" name="f_alert_date[]" value="' . $alert_date[$i] . '">' . '</td>';
            $html .= '<td><input class="form-control" type="text" name="batch[]"  id="p_batch_' . $i . '" value="' . $new_batch_id . '" readonly>' . '</td>';
            $html .= '<td>' . '<input type="text" class="form-control" onchange="change_price(this)" id="total_price_' . $i . '" name="total_price[]" value="' . $total_price[$i] . '"></td>';
            $html .= '</tr>';
            $count++;
            //$bId++; 
        }
        $rowArr = ($bId == 1) ? 0 : $bId;
        $html .= '<input type="hidden" id="tot_rows" value="' . $rowArr . '">';
        $html .= '<script>$(function () {$(".datepicker3").datetimepicker({viewMode: "years",format: "YYYY-MM-DD",});});</script>';
        echo $html;
    }

    public function add_receive_data()
    {
        $this->form_validation->set_rules('invoice_no', 'Invoice Number', 'trim|required|is_unique[purchase_receives.invoice_no]');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $total_num_of_fields = $this->input->post('total_num_of_fields');
            $supplier_id = $this->input->post('supp_id');
            $invoice_no = $this->input->post('invoice_no');
            $order_id = $this->input->post('order_id');
            $notes = $this->input->post('notes');
            $stock_mvt_date = $this->input->post('dtt_stock_mvt');
            $rack_id = $this->input->post('rack_id');
            $batch = $this->input->post('batch');
            $product_id = $this->input->post('pro_id');
            $details_id = $this->input->post('details_id');
            $qty = $this->input->post('act_qty');
            $stock_mvt_reason_id = $this->input->post('stock_mvt_reason_id');
            $purchase_price = $this->input->post('unit_price');
            $sale_price = $this->input->post('sell_price');
            $vat_rate = $this->input->post('vat_v');
            $expire_date = $this->input->post('f_expire_date');
            $alert_date = $this->input->post('f_alert_date');
            $default_batch_no = $this->input->post('batch_no');
            $store_id = $this->input->post('store_id');
            $total_price = $this->input->post('total_price');
            $row_attr_value = $this->input->post('row_attr_value');
            $notes_id = '';
            $reson = '';
            if ($stock_mvt_reason_id != 0) {
                $reson = explode('@', $stock_mvt_reason_id);
                $notes_id = ($notes == '') ? $reson[1] : $notes;
            }
            if (file_exists($_FILES['stock_in_doc']['tmp_name'])) {
                $is_doc_attached = 1;
            } else {
                $is_doc_attached = 0;
            }
            try {
                $this->db->trans_start();
                $sum_total = 0;
                for ($a = 0; $a < count($total_price); $a++) {
                    $sum_total += $total_price[$a];
                }
                $data_stock_mvts['purchase_order_id'] = $order_id;
                $data_stock_mvts['invoice_no'] = $invoice_no;
                $data_stock_mvts['store_id'] = $store_id;
                $data_stock_mvts['supplier_id'] = $supplier_id;
                $data_stock_mvts['notes'] = $notes_id;
                $data_stock_mvts['invoice_amt'] = $sum_total;
                $data_stock_mvts['tot_amt'] = $sum_total;
                $data_stock_mvts['due_amt'] = $sum_total;
                $reason_id =($reson != '')? $reson[0]:'null';
                $data_stock_mvts['is_doc_attached'] = $is_doc_attached;
                $dtt_receive = $stock_mvt_date . ' ' . date('H:i:s');


                $dtt_add = date('Y-m-d H:i:s');
                $uid_add = $this->session->userdata['login_info']['id_user_i90'];
                $add_table_key = "'" . "purchase_order_id,invoice_no,store_id,supplier_id,notes,invoice_amt,tot_amt,due_amt,stock_mvt_reason_id,is_doc_attached,dtt_receive,dtt_add,uid_add" . "'";
                $add_table_value = "'" . $order_id . "," . $invoice_no . "," . $store_id . "," . $supplier_id . "," . $notes_id . "," . $sum_total . "," . $sum_total . "," . $sum_total . "," . $reason_id . "," . $is_doc_attached . ",". $dtt_receive . ",". $dtt_add . "," . $uid_add . "'";
                $qry_res = $this->db->query("CALL insert_row('purchase_receives'," . $add_table_key . "," . $add_table_value . ")");
                $pro_id = $qry_res->result_object();
                $qry_res->next_result();
                $qry_res->free_result();



                //$stock_mvts_id = $this->purchase_model->common_insert('purchase_receives', $data_stock_mvts);
                $this->commonmodel->update_balance_amount('suppliers', 'balance', $sum_total, '+', array('id_supplier' => $supplier_id));
                $status['status_id'] = 3;
                $this->purchase_model->update_value('purchase_orders', $status, array('id_purchase_order' => $order_id));
                if ($_FILES['stock_in_doc']['name']!='') {
                    $filename = upload_file('stock', $_FILES['stock_in_doc']);
                    if($filename){
                        $add_table_key = "'" . "doc_type,ref_id,file,dtt_add,uid_add" . "'";
                        $add_table_value = "'Purchase Receive," . $pro_id[0]->result . "," . $filename . "," . $dtt_add . "," . $uid_add . "'";
                        $qry_res = $this->db->query("CALL insert_row('documents'," . $add_table_key . "," . $add_table_value . ")");
                        //$pro_id = $qry_res->result_object();
                        $qry_res->next_result();
                        $qry_res->free_result();
                    }
                }
                for ($i = 0; $i < count($product_id); $i++) {

                    if ($pro_id[0]->result) {
                        $data_stock_mvts_details['purchase_receive_id'] = $pro_id[0]->result;
                        $data_stock_mvts_details['purchase_order_detail_id'] = $details_id[$i];
                        //$data_stock_mvts_details['batch_no'] = $batch[$i];
                        $data_stock_mvts_details['store_id'] = $store_id;
                        $data_stock_mvts_details['product_id'] = $product_id[$i];
                        $data_stock_mvts_details['supplier_id'] = $supplier_id;
                        $data_stock_mvts_details['qty'] = $qty[$i];
                        $data_stock_mvts_details['purchase_price'] = $purchase_price[$i];
                        $data_stock_mvts_details['selling_price_est'] = $sale_price[$i];
                        $data_stock_mvts_details['selling_price_act'] = $sale_price[$i];
                        // $data_stock_mvts_details['discount_amt'] = $this->input->post('row_sale_price');
                        // $data_stock_mvts_details['discount_rate'] = $this->input->post('row_sale_price');
                        //$data_stock_mvts_details['vat_rate'] = $vat_rate[$i];
                        $data_stock_mvts_details['expire_date'] = $expire_date[$i];
                        $data_stock_mvts_details['alert_date'] = $alert_date[$i];
                        $data_stock_mvts_details['dtt_add'] = date('Y-m-d H:i:s');
                        $data_stock_mvts_details['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];

//                        $add_table_key = "'" . "purchase_receive_id,purchase_order_detail_id,store_id,product_id,supplier_id,qty,purchase_price,selling_price_est,selling_price_act,expire_date,alert_date,dtt_add,uid_add" . "'";
//                        $add_table_value = "'" . $pro_id[0]->result . "," . $details_id[$i] . "," .$store_id . "," . $product_id[$i] . "," . $supplier_id . "," . $qty[$i] . "," . $purchase_price[$i]
//                            . "," . $sale_price[$i] . "," . $sale_price[$i] . "," . $expire_date[$i] . "," . $alert_date[$i] . "," . $dtt_add . "," . $uid_add . "'";
//                        $qry_res = $this->db->query("CALL insert_row('purchase_receive_details'," . $add_table_key . "," . $add_table_value . ")");
//                        $details_id = $qry_res->result_object();
//                        $qry_res->next_result();
//                        $qry_res->free_result();
                        $stock_mvt_details_id = $this->purchase_model->common_insert('purchase_receive_details', $data_stock_mvts_details);
                        if ($stock_mvt_details_id) {
                            $add_table_key = "'" . "stock_mvt_type_id,stock_mvt_id,stock_mvt_detail_id,supplier_id,store_id,rack_id,batch_no,product_id,qty,purchase_price,selling_price_est,selling_price_act,expire_date,alert_date,dtt_add,uid_add" . "'";
                            $add_table_value = "'1," . $pro_id[0]->result . "," . $stock_mvt_details_id . "," . $supplier_id . "," . $store_id . "," . $rack_id[$i] . "," . $batch[$i] . "," . $product_id[$i]
                                . "," . $qty[$i] . "," . $purchase_price[$i] . "," . $sale_price[$i] . "," . $sale_price[$i] . "," . $expire_date[$i] . "," . $alert_date[$i] . "," . $dtt_add . "," . $uid_add . "'";
                            $qry_res = $this->db->query("CALL insert_row('stocks'," . $add_table_key . "," . $add_table_value . ")");
                            $pro_id1 = $qry_res->result_object();
                            $qry_res->next_result();
                            $qry_res->free_result();
                            if($row_attr_value[$i]!=''){
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
                                    $this->purchase_model->common_insert('stock_attributes',$data);
                                    $m++;
                                }
                            }
                        }
                    }
                }
                $this->auto_increment->updAutoIncKey('PURCHASE_RECEIVE_INVOICE', $invoice_no, $invoice_no);
                $this->auto_increment->updAutoIncKey('STOCK_IN_BATCH', $default_batch_no, $default_batch_no);
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    throw new Exception("Error in Purchase Receive");
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

    public function receive_details_data($id = null)
    {
        $data['title'] = 'Purchase Receive';
        $data['receive_id'] = $id;
        $this->breadcrumb->add(lang('purchase_receive'), 'purchase-receive', 1);
        $this->breadcrumb->add(lang('details'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['posts'] = $this->purchase_model->receive_details($id);
        $data['doc_list'] = $this->purchase_model->get_doc_file($id);
        $this->template->load('main', 'receive/receive_details_data', $data);
    }
    public function receive_print_data()
    {
        $id = $this->input->post('id');
        $data['posts'] = $this->purchase_model->receive_details($id);
        $data['doc_list'] = $this->purchase_model->get_doc_file($id);
        $reports['head'] = array(
            'title' => 'Purchase Receive Details',
            'invoice_no' => $data['doc_list']['invoice_no'],
            'date' => $data['doc_list']['dtt_receive']
        );
        $reports['report']=$this->load->view('receive/receive_details_print_data', $data, true);
        $this->load->view('print_page', $reports, false);
    }

    public function barcode()
    {
        $data = array();
        //I'm just using rand() function for data example
        //$this->load->library('zend');
        //load in folder Zend
        //$this->zend->load('Zend/Barcode');
        $this->load->library('barcode');
        $temp = '12345656565656565656565';
        //$data['temp']=$this->set_barcode($temp);
        $this->template->load('main', 'receive/barcode', $data);
//        $config = new Zend_Config(array(
//            'barcode' => 'code39',
//            'barcodeParams' => array('text' => 'TestCode', 'barHeight' => 30, 'factor' => 2),
//            'renderer' => 'image',
//            'rendererParams' => array('imageType' => 'gif'),
//        ));
//
//        $barcode = Zend_Barcode::factory($config);
//
//        imagegif($barcode->draw(), 'barcode-img/barcode.gif');
    }

    private function set_barcode($code)
    {
        //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //generate barcode
        Zend_Barcode::render('code128', 'image', array('text' => $code), array());
    }

}
