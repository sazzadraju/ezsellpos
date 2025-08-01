<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_requisitions extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('purchase_model');
        $this->perPage = 10;
    }

    public function index() {
        $data=array();
        $this->dynamic_menu->check_menu('requisitions');
        $this->breadcrumb->add(lang('requisitions'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->purchase_model->getRowsRequisitions();
        $totalRec = ($row!='')?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'requisition/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['stores'] = $this->purchase_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->purchase_model->getRowsRequisitions(array('limit' => $this->perPage));
        $this->template->load('main', 'requisitions/index', $data);
    }
    public function paginate_data() {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $store_name = $this->input->post('store_name');
        $product_name = $this->input->post('product_name');
        $user_name = $this->input->post('user_name');
        if (!empty($store_name)) {
            $conditions['search']['store_name'] = $store_name;
        }
        if (!empty($product_name)) {
            $conditions['search']['product_name'] = $product_name;
        }
        if (!empty($user_name)) {
            $conditions['search']['user_name'] = $user_name;
        }
        $row = $this->purchase_model->getRowsRequisitions($conditions);
        $totalRec = ($row!='')?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'requisition/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['stores'] = $this->purchase_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->purchase_model->getRowsRequisitions($conditions);
        //echo $this->db->last_query();
        $this->load->view('requisitions/all_requisition_data', $data, false);
    }
    public function add_requisition() {
        $this->dynamic_menu->check_menu('requisitions');
        $this->breadcrumb->add(lang('requisitions'), 'requisitions', 1);
        $this->breadcrumb->add(lang('add_requisition'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['stores'] = $this->purchase_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['categories'] = $this->purchase_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['brands'] = $this->purchase_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $this->template->load('main', 'requisitions/add_requisition', $data);
    }
    public function get_products_auto()
    {
        $request = $_REQUEST['request'];
        $product_list = $this->purchase_model->get_product_autocomplete($request);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->product_name,
                "value" => $list->id_product,
                "sell_price" => $list->sell_price,
                 "product_code" => $list->product_code,
                "vat" => $list->vat

                // "is_unq_barcode" => $list->is_unq_barcode
            );
        }
        echo json_encode($return);
    }
    public function search_requisition_product_list(){
        $conditions=array();
        $cat_name = $this->input->post('cat_name');
        $product_name = $this->input->post('product_name');
        $sub_category = $this->input->post('sub_category');
        $brand = $this->input->post('brand');
        $values = $this->input->post('values');
        $data['value']=explode(',', $values);
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
        $data['posts']= $this->purchase_model->getRowsProducts($conditions);
       // $sql = $this->db->last_query();
        //echo $product_name.$cat_name.$sub_category.$brand;
        //print_r($dataArray);
        //echo $sql;
        $this->load->view('requisitions/search_requisition_list', $data, false);

    }

    public function temp_add_search_requisition(){
        $html='';
        $checks=$this->input->post('id_check');
        $code=$this->input->post('code');
        $name=$this->input->post('name');
        $qty=$this->input->post('qty');
        print_r($checks);

        /*foreach ($checks as $key=>$value) {
            $html.= '<tr id="'.$value.'">';
            $html.='<td>'.$code[$key].'<input type="hidden" name="code[]" value="'.$code[$key].'">'.'</td>';
            $html.='<td>'.$key.$name[$key].'<input type="hidden" name="code[]" value="'.$name[$key].'">'.'</td>';
            $html.='<td><input class="form-control" style="width: 60px" type="text" name="qty[]" id="qty[]" value="'.$qty[$key].'">'.'</td>';
            $html.='<td>'.'<input type="hidden" name="id_pro[]" value="'.$checks[$key].'">'.'<button class="btn btn-danger btn-xs" onclick="removeMore('.$checks[$key].');">X</button></td>';
            $html.= '</tr>';
        }*/
        /*for($i=0; $i<count($checks);$i++){
            $html.= '<tr id="'.$checks[$i].'">';
            $html.='<td>'.$checks[$i].$code[$i].'<input type="hidden" name="code[]" value="'.$code[$i].'">'.'</td>';
            $html.='<td>'.$name[$i].'<input type="hidden" name="code[]" value="'.$name[$i].'">'.'</td>';
            $html.='<td><input class="form-control" style="width: 60px" type="text" name="qty[]" id="qty[]" value="'.$qty[$i].'">'.'</td>';
            $html.='<td>'.'<input type="hidden" name="id_pro[]" value="'.$checks[$i].'">'.'<button class="btn btn-danger btn-xs" onclick="removeMore('.$checks[$i].');">X</button></td>';
            $html.= '</tr>';
        }*/
        echo $html;
    }
    public function add_requisition_data(){
        $checks=$this->input->post('id_pro');
        //$code=$this->input->post('code');
        $store_name=$this->input->post('store_name');
        $qty=$this->input->post('qty');
       // print_r($checks);
        for($i=0; $i<count($checks);$i++){
           // $html=$checks[$i];
            $uid_add = $this->session->userdata['login_info']['id_user_i90'];
            $dtt_add = date('Y-m-d H:i:s');
            //$this->purchase_model->common_insert('purchase_requisitions', $data);
            $add_table_key = "'" . "product_id,qty,store_id,dtt_add,uid_add" . "'";
            $add_table_value = "'" . $checks[$i] . "," . $qty[$i] . "," . $store_name . ",". $dtt_add . ",".$uid_add  . "'";
            $qry_res = $this->db->query("CALL insert_row('purchase_requisitions'," . $add_table_key . "," . $add_table_value . ")");
            $qry_res->next_result();
            $qry_res->free_result();
        }
        $massage = 'Successfully data added..';
        echo json_encode(array("status" => "success", "message" => $massage));
    }

}