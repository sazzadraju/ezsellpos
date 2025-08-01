<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->form_validation->CI = &$this;
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
        $offset = 0;
        $this->dynamic_menu->check_menu('purchase-order');
        $this->breadcrumb->add(lang('purchase_order'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->purchase_model->getRowsOrderList();
        $totalRec = ($row)?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'purchase_order/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['rows'] = ($offset * $this->perPage) + 1;
        $data['stores'] = $this->purchase_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->purchase_model->getRowsOrderList(array('limit' => $this->perPage));
        $this->template->load('main', 'order/index', $data);
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
        $totalRec = count($this->purchase_model->getRowsOrderList($conditions));
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'requisition/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['stores'] = $this->purchase_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->purchase_model->getRowsOrderList($conditions);
        //echo $this->db->last_query();
        $this->load->view('order/all_order_data', $data, false);
    }

    public function add_order()
    {
        $this->dynamic_menu->check_menu('purchase-order');
        $data['title'] = 'Purchase Order';
        $this->breadcrumb->add(lang('order_list'), 'purchase-order', 1);
        $this->breadcrumb->add(lang('add_order'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $requestType = $_SERVER['REQUEST_METHOD'];
        $data['stores'] = $this->purchase_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        if (isset($_REQUEST['id'])) {
            if ($_REQUEST['id'] == 'requisition') {
                $data['requisitions'] = $this->purchase_model->getRowsRequisitions();
            }

        }
        if (isset($_REQUEST['sid'])) {
            $tt = 1;
            foreach ($data['stores'] as $st) {
                if ($st->id_store == $_REQUEST['sid']) {
                    $tt = 2;
                }
            }
            if ($tt == 1) {
                redirect('purchase-order');
            }
        }
        $data['attributes'] = $this->purchase_model->getvalue_row('product_attributes', 'id_attribute,attribute_name,attribute_value', array('status_id' => 1));
        $data['categories'] = $this->purchase_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['brands'] = $this->purchase_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['suppliers'] = $this->purchase_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $this->template->load('main', 'order/add_order', $data);
    }

    public function get_products_auto()
    {
        $request = $_REQUEST['request'];
        $product_list = $this->purchase_model->get_product_autocomplete($request);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->product_name,
                "value" => $list->id_product

                // "is_unq_barcode" => $list->is_unq_barcode
            );
        }
        echo json_encode($return);
    }

    public function search_order_product_list()
    {
        $conditions = array();
        $cat_name = $this->input->post('cat_name');
        $product_name = $this->input->post('product_name');
        $sub_category = $this->input->post('sub_category');
        $brand = $this->input->post('brand');
        $supplier = $this->input->post('supplier');
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
        $data['id_supp'] = $supplier;
        $data['suppliers'] = $this->purchase_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['posts'] = $this->purchase_model->getRowsProducts($conditions);
        // $sql = $this->db->last_query();
        //echo $product_name.$cat_name.$sub_category.$brand;
        //print_r($dataArray);
        //echo $sql;
        $this->load->view('order/search_order_list', $data, false);
    }

    public function temp_add_search_order()
    {
        $html = '';
        $checks = $this->input->post('id_check');
        $code = $this->input->post('code');
        $name = $this->input->post('name');
        $qty = $this->input->post('qty');
        $row = $this->input->post('p_row');
        $unit_price = $this->input->post('unit_price');
        $total_price = $this->input->post('total_price');
        $supplierArray = $this->input->post('supplier');
        $supplierArray = $this->input->post('supplier');
        //print_r($supplier);
        $suppliers = $this->purchase_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));

        for ($i = 0; $i < count($checks); $i++) {
            $row += 1;
            $id_qty = $qty[$checks[$i]][0];
            $unit_price_v = $unit_price[$checks[$i]][0];
            $total_price_v = $total_price[$checks[$i]][0];
            $id_supplier = $supplierArray[$checks[$i]][0];
            $product = $this->purchase_model->getvalue_row_one('products', '*', array('status_id' => 1, 'id_product' => $checks[$i]));
            //print_r($product);
            // echo $product[0]['product_name'];

            $html .= '<tr id="' . $row . '">';
            $html .= '<td>' . $product[0]['product_code'] . '<input type="hidden" id="attr_'.$row.'" name="attr[]" value=""><input type="hidden" id="code_'.$row.'" name="code[]" value="' . $product[0]['product_code'] . '">' . '</td>';
            $html .= '<td>' . $product[0]['product_name'] . '<input type="hidden" id="name_'.$row.'" name="name[]" value="' . $product[0]['product_name'] . '">' . '</td>';
            $html .= '<td>' . $product[0]['buy_price'] .'<input type="hidden" id="b_price_'.$row.'" name="s_price[]" value="' . $product[0]['buy_price'] . '">TK</td>';
            $html .= '<td><select class="select2" data-live-search="true" id="supplier" name="p_supplier[]" id="p_supplier[]">';
            $html .= '<option value="0">' . lang("select_one") . '</option>';
            foreach ($suppliers as $supplier) {
                $select = ($supplier->id_supplier == $id_supplier) ? 'selected' : '';
                $html .= '<option value="' . $supplier->id_supplier . '" ' . $select . '>' . $supplier->supplier_name . '</option>';
            }
            $html .= '</select></td>';
            $html .= '<td><input class="form-control" onkeypress="return isNumber(event)" style="width: 60px" type="text" name="p_qty[]" onchange="change_cart(' . $row . ')" id="qty_' . $row . '" value="' . $id_qty . '">' . '</td>';
            $html .= '<td><input class="form-control" onkeypress="return isNumber(event)" style="width: 100px" type="text" name="p_unit_p[]" onchange="change_cart(' . $row . ')" id="unit_price_' . $row . '" value="' . $unit_price_v . '">' . '</td>';
            $html .= '<td><input class="form-control" onkeypress="return isNumber(event)" style="width: 100px" type="text" name="p_tot_p[]" onchange="change_price_cart(' . $row . ')" id="total_price_' . $row . '" value="' . $total_price_v . '">' . '</td>';
           $html .='<td><button type="button" onclick="add_row('.$row.')" class="btn btn-info" data-title="'.lang("add_attributes").'" data-toggle="modal" rel="tooltip" title="'.lang("add_attributes").'"
                                        data-target="#add_attributes"><i class="fa fa-plus"></i></button> </td>';
            $html .= '<td>' . '<input type="hidden" id="id_pro_'.$row.'" name="id_pro[]" value="' . $checks[$i] . '">' . '<button class="btn btn-danger btn-xs" onclick="removeMore(' . $row . ');">X</button></td>';
            $html .= '</tr>';
        }
        echo $html;
    }

    public function add_order_data()
    {

        $this->form_validation->set_rules('p_supplier[]', 'Supplier', 'trim|required|callback_select_check');
        $this->form_validation->set_rules('p_qty[]', 'Quentity', 'trim|required|numeric');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $checks = $this->input->post('id_pro');
            $unit_p = $this->input->post('p_unit_p');
            $total_p = $this->input->post('p_tot_p');
            $qty = $this->input->post('p_qty');
            $supplier = $this->input->post('p_supplier');
            $store_name = $this->input->post('store_name');
            $group_supplier=arrayGroup($supplier);
            $requisition_id = $this->input->post('requisition_id');
            $row_attr_value=$this->input->post('attr');
            try {
                $this->db->trans_start();
                for ($i = 0; $i < count($group_supplier); $i++) {
                    $sum_total = 0;
                    $g_sup_id = $group_supplier[$i];
                    for ($a = 0; $a < count($supplier); $a++) {
                        if ($g_sup_id == $supplier[$a]) {
                            $sum_total += $total_p[$a];
                        }
                    }
                    $invoice_id = $this->auto_increment->getAutoIncKey('PURCHASE_ORDER_INVOICE', 'purchase_orders', 'invoice_no');
                    $uid_add = $this->session->userdata['login_info']['id_user_i90'];
                    $dtt_add = date('Y-m-d H:i:s');
                    $add_table_key = "'" . "invoice_no,store_id,supplier_id,tot_amt,dtt_add,uid_add" . "'";
                    $add_table_value = "'" . $invoice_id . "," . $store_name . "," . $group_supplier[$i] . "," . $sum_total . "," . $dtt_add . "," . $uid_add . "'";
                    $qry_res = $this->db->query("CALL insert_row('purchase_orders'," . $add_table_key . "," . $add_table_value . ")");
                    $pro_id = $qry_res->result_object();
                    $qry_res->next_result();
                    $qry_res->free_result();
                    //$prod_id = $this->purchase_model->common_insert('purchase_orders', $data);
                    for ($j = 0; $j < count($checks); $j++) {
                        if ($group_supplier[$i] == $supplier[$j]) {

                            $add_table_key = "'" . "purchase_order_id,product_id,qty,unit_amt,tot_amt,dtt_add" . "'";
                            $add_table_value = "'" . $pro_id[0]->result . "," . $checks[$j] . "," . $qty[$j] . "," . $unit_p[$j] . "," . $total_p[$j] . "," . $dtt_add . "'";
                            $qry_res = $this->db->query("CALL insert_row('purchase_order_details'," . $add_table_key . "," . $add_table_value . ")");
                            $order_details = $qry_res->result_object();
                            $qry_res->next_result();
                            $qry_res->free_result();
                            //$this->purchase_model->common_insert('purchase_order_details', $array);
                            $sum_total += $total_p[$j];
                            if ($requisition_id == 1) {
                                $req_data = array(
                                    'store_id' => $store_name,
                                    'product_id' => $checks[$j]
                                );
                                $qry_res = $this->db->query("CALL update_row('purchase_requisitions','status_id','3','store_id,product_id','" . $store_name . "," . $checks[$j] . "')");
                                $qry_res->next_result();
                                $qry_res->free_result();
                                //$this->purchase_model->update_value('purchase_requisitions', array('status_id'=>3), $req_data);
                            }
                            if($row_attr_value[$j]!=''){
                                $array = explode(',', $row_attr_value[$j]);
                                $m = 0;
                                while ($m < count($array)) {
                                    $dataArray = $array[$m];
                                    $dataValue = explode('=', $dataArray);
                                    $data = array(
                                        'order_details_id' => $order_details[0]->result
                                    , 'p_attribute_id' => $dataValue[0]
                                    , 's_attribute_name' => $dataValue[1]
                                    , 's_attribute_value' => $dataValue[2]
                                    , 'status_id' => 1
                                    );
                                    $this->purchase_model->common_insert('purchase_attributes',$data);
                                    $m++;
                                }
                            }

                        }
                    }
                    $this->auto_increment->updAutoIncKey('PURCHASE_ORDER_INVOICE', $invoice_id, $invoice_id);
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    throw new Exception("Error in Purchase Order");
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

    public function order_details_data($id = null)
    {
        $data['title'] = 'Purchase Order';
        $data['order_id'] = $id;
        $this->breadcrumb->add(lang('purchase_order'), 'purchase-order', 1);
        $this->breadcrumb->add(lang('details'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['posts'] = $this->purchase_model->order_details($id);
        //$this->load->view('order/order_details_data', $data, false);
        $this->template->load('main', 'order/order_details_data', $data);
    }
    public function order_print_data()
    {
        $id = $this->input->post('id');
        $data['posts'] = $this->purchase_model->order_details($id);
        $reports['head'] = array(
            'title' => 'Purchase Details',
            'invoice_no' => $data['posts'][0]['invoice_no'],
            'date' => $data['posts'][0]['dtt_add']
        );
        $reports['report']=$this->load->view('order/order_details_print_data', $data, true);
        $this->load->view('print_page', $reports, false);
    }

    function select_check($str)
    {
        if ($str == '0') {
            $this->form_validation->set_message('select_check', lang('select_msg'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function show_requisition_orders()
    {
        $requisitions = $this->purchase_model->getRowsRequisitions();
        //print_r($promotions);
        $html = '';
        $html .= '<table id = "mytable" class="table table-bordred table-striped" >';
        $html .= '<thead >';
        $html .= '<th> ' . lang("product_code") . '</th>';
        $html .= '<th>' . lang("product_name") . '</th>';
        $html .= '<th> ' . lang("store_name") . '</th>';
        $html .= '<th>' . lang("qty") . '</th>';
        $html .= '<th> ' . lang("date") . '</th>';
        //$html .= '<th>' . lang("action") . '</th>';
        $html .= '</tbody>';
        $html .= '<tbody>';
        if ($requisitions) {
            foreach ($requisitions as $post) {
                $html .= '<tr>';
                $html .= '<td> ' . $post['product_code'] . ' </td>';
                $html .= '<td> ' . $post['product_name'] . ' </td>';
                $html .= '<td> ' . $post['store_name'] . ' </td>';
                $html .= '<td> ' . number_format($post['qty']) . ' </td>';
                $html .= '<td> ' . explode(" ", $post['dtt_add'])[0] . ' </td>';
                // $html .= '<td>  <a href="' . base_url() . 'sales?restore=' .  $post['product_code'] . '" class="btn btn-primary">Restore</a></td>';
                $html .= '</tr>';
            }
        }
        $html .= '</tbody>';
        $html .= '</table>';
        echo $html;
    }
    public function purchase_insert_attributes(){
        $product_code = $this->input->post('product_code');
        $product_name = $this->input->post('product_name');
        $buying_price = $this->input->post('buying_price');
        $unit_price = $this->input->post('unit_price');
        $id_pro = $this->input->post('id_pro');
        $main = $this->input->post('main');
        $child = $this->input->post('child');
        $suppliers = $this->purchase_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $c_main = count($main);
        $a = 0;
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
        $row = $this->input->post('p_row');
        $html='';
        foreach ($arrayValue as $data) {
            $c=1;
            $attr_show='';
            $attr='';
            foreach ($data as $key => $value){
                //echo 'key:'.$key.'value:'.$value;
                $coma = '';
                $coma=($c > 1)?',':'';
                $lastItem =explode('@',$key);
                $attr .= $coma . $lastItem[0] . '=' . $lastItem[1] . '=' . $value;
                $attr_show .= $coma . $lastItem[1] . '=' . $value;
                $c += 1;
            }
            $row= $row+1;

            $html .= '<tr class="last_'.$row.'" id="' . $row . '">';
            $html .= '<td>' .$product_code .'<br>'.$attr_show.'<input type="hidden" id="attr_'.$row.'" name="attr[]" value="' . $attr . '"><input type="hidden" id="code_'.$row.'" name="code[]" value="' . $product_code . '">' . '</td>';
            $html .= '<td>' . $product_name . '<input type="hidden" id="name_'.$row.'" name="name[]" value="' . $product_name . '">' . '</td>';
            $html .= '<td>' . $buying_price .'<input type="hidden" id="b_price_'.$row.'" name="s_price[]" value="' . $buying_price . '">TK</td>';
            $html .= '<td><select class="select2" data-live-search="true" id="supplier" name="p_supplier[]" id="p_supplier[]">';
            $html .= '<option value="0">' . lang("select_one") . '</option>';
            foreach ($suppliers as $supplier) {
                $select = '';
                $html .= '<option value="' . $supplier->id_supplier . '" ' . $select . '>' . $supplier->supplier_name . '</option>';
            }
            $html .= '</select></td>';
            $html .= '<td><input class="form-control" onkeypress="return isNumber(event)" style="width: 60px" type="text" name="p_qty[]" onchange="change_cart(' . $row . ')" id="qty_' . $row . '" value="">' . '</td>';
            $html .= '<td><input class="form-control" onkeypress="return isNumber(event)" style="width: 100px" type="text" name="p_unit_p[]" onchange="change_cart(' . $row . ')" id="unit_price_' . $row . '" value="' . $unit_price . '">' . '</td>';
            $html .= '<td><input class="form-control" onkeypress="return isNumber(event)" style="width: 100px" type="text" name="p_tot_p[]" onchange="change_price_cart(' . $row . ')" id="total_price_' . $row . '" value="">' . '</td>';
            $html .='<td>&nbsp;</td>';
            $html .= '<td>' . '<input type="hidden" id="id_pro_'.$row.'" name="id_pro[]" value="' . $id_pro . '">' . '<button class="btn btn-danger btn-xs" onclick="removeMore(' . $row . ');">X</button></td>';
            $html .= '</tr>';
        }
        echo $html;
    }

}
