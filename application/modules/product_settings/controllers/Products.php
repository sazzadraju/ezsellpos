<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('product_model');
        $this->perPage = 50;
    }

    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('products');
        $this->breadcrumb->add(lang('products'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $rec=$this->product_model->getRowsProducts();
        $totalRec = ($rec !='')?count($rec):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        //$data['de_vat'] = $this->product_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        $data['columns'] = $this->product_model->getvalue_row('acl_user_column', 'permission', array('acl_module_id'=>19));
        $data['max_val'] = $this->product_model->max_value('products', 'sell_price');
        $data['suppliers'] = $this->product_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['units'] = $this->product_model->getvalue_row('product_units', 'unit_code,id_product_unit', array('status_id' => 1));
        $data['brands'] = $this->product_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['categories'] = $this->product_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['posts'] = $this->product_model->getRowsProducts(array('limit' => $this->perPage));
        $data['stocks'] = $this->product_model->product_stock();
        $this->template->load('main', 'products/index', $data);
    }

    public function check_product_code()
    {
        $this->load->database();
        $pro_code = $this->input->post('pro_code');
        $this->db->where('product_code', $pro_code);
        $this->db->where('status_id', 1);
        $query = $this->db->get('products');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function getMaxNumber()
    {
        $this->load->database();
        $this->db->select('max(product_code) as code');
        $result = $this->db->get('products')->row();
        $code = ($result->code) + 1;
        echo $code;
    }

    public function add_data()
    {

        if ($this->input->post('id') != '') {
            $name = $this->input->post('pr_name');
            $code = $this->input->post('pro_code');
            $id_v = $this->input->post('id');
            $this->form_validation->set_rules('pr_name', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('pro_code', 'Product Code', 'trim|required');
            $val = $this->product_model->isExistExcept('products', 'product_code', $code, 'id_product', $id_v);
            if ($val) {
                echo json_encode(array('pro_code' => lang('name_exist')));
                exit();
            }
            $val = $this->product_model->isExistExcept('products', 'product_name', $name, 'id_product', $id_v);
            if ($val) {
                echo json_encode(array('pr_name' => lang('name_exist')));
                exit();
            }
        } else {
            $code = $this->input->post('pro_code');
            $name = $this->input->post('pro_name');
            $val = $this->product_model->isExist('products', 'product_code', $code);
            if ($val) {
                echo json_encode(array('pro_code' => lang('name_exist')));
                exit();
            }
            $val = $this->product_model->isExist('products', 'product_name', $name);
            if ($val) {
                echo json_encode(array('pro_name' => lang('name_exist')));
                exit();
            }
        }
        $this->form_validation->set_rules('category', 'Category', 'trim|required');
        $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
        $this->form_validation->set_rules('buying_price', 'Buying Price', 'trim|required');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $conditions = array();
            $filename = '';
            if ($_FILES['userfile']['name']!='') {
                $filename = upload_file('product', $_FILES['userfile']);
            }
            $product_code = $this->input->post('pro_code');
            $product_name = $name;
            $cat_id = $this->input->post('category');
            $subcat_id = $this->input->post('subcategory');
            $brand_id = $this->input->post('brands');
            $unit_id = $this->input->post('unit');
            $buy_price = $this->input->post('buying_price');
            $sell_price = $this->input->post('selling_price');
            $min_stock = $this->input->post('min_stock');
            $max_stock = $this->input->post('max_stock');

            $suppliers = $this->input->post('supplier');
            if ($this->input->post('vatType') == 'Yes') {
                $is_vatable = '1';
            } else {
                $is_vatable = '2';
            }
            if ($this->input->post('id') != '') {
                $old_image=$this->input->post('old_image');
                if($old_image != ''){
                    delete_file('product', $old_image);
                }
                $condition = array(
                    'id_product' => $this->input->post('id')
                );
                if ($filename == '') {
                    $filename = $this->input->post('image_dir');
                }
                $product_img = $filename;
                $uid_mod = $this->session->userdata['login_info']['id_user_i90'];
                $dtt_mod = date('Y-m-d H:i:s');
                //$pro_id = $this->product_model->update_value('products', $data, $condition);
                $add_table_key = "'" . "product_code,cat_id,subcat_id,product_name,brand_id,is_vatable,unit_id,buy_price,sell_price,min_stock,max_stock,product_img,dtt_mod,uid_mod" . "'";
                $add_table_value = "'" . $product_code . "," . $cat_id . "," . $subcat_id . "," . $product_name . "," . $brand_id . "," . $is_vatable . "," . $unit_id . "," . $buy_price . "," . $sell_price . "," . $min_stock . "," . $max_stock . "," . $product_img . "," . $dtt_mod . "," . $uid_mod . "'";
                $qry_res = $this->db->query("CALL update_row('products'," . $add_table_key . "," . $add_table_value . ",'id_product','" . $this->input->post('id') . "')");
                $pro_id = $qry_res->result_object();
                $qry_res->next_result();
                $qry_res->free_result();
                if (!empty($suppliers)) {
                    $p_id = $this->input->post('id');
                    //$this->product_model->delete_data('products_suppliers', array('porduct_id' => $p_id));
                    $qry_res1 = $this->db->query("CALL delete_row('products_suppliers','porduct_id','" . $p_id . "')");
                    for ($i = 0; $i < count($suppliers); $i++) {
                        $add_table_key = "'" . "porduct_id,supplier_id,status_id,dtt_add,uid_add" . "'";
                        $add_table_value = "'" . $p_id . "," . $suppliers[$i] . ",1," . date('Y-m-d H:i:s') . ",1" . "'";
                        $qry_res = $this->db->query("CALL insert_row('products_suppliers'," . $add_table_key . "," . $add_table_value . ")");
                        $qry_res->next_result();                        
                        $qry_res->free_result();
                        //$product_supplier_id = $this->product_model->common_insert('products_suppliers', $data_supplier);
                    }
                }
                $massage = 'Successfully data Updated..';
            } else {
                $uid_add = $this->session->userdata['login_info']['id_user_i90'];
                $dtt_add = date('Y-m-d H:i:s');
                $product_img = ($filename == '') ? null : $filename;
                $add_table_key = "'" . "product_code,cat_id,subcat_id,product_name,brand_id,is_vatable,unit_id,buy_price,sell_price,min_stock,max_stock,product_img,dtt_add,uid_add" . "'";
                $add_table_value = "'" . $product_code . "," . $cat_id . "," . $subcat_id . "," . $product_name . "," . $brand_id . "," . $is_vatable . "," . $unit_id . "," . $buy_price . "," . $sell_price . "," . $min_stock . "," . $max_stock. "," . $product_img . "," . $dtt_add . "," . $uid_add . "'";
                $qry_res = $this->db->query("CALL insert_row('products'," . $add_table_key . "," . $add_table_value . ")");
                $pro_id = $qry_res->result_object();
                $qry_res->next_result(); 
                $qry_res->free_result();
                //$this->db->freeDBResource($this->db->conn_id);
                //$pro_id = $this->product_model->common_insert('products', $data);
                if (!empty($suppliers)) {
                    for ($i = 0; $i < count($suppliers); $i++) {
                        $add_table_key = "'" . "porduct_id,supplier_id,status_id,dtt_add,uid_add" . "'";
                        $add_table_value = "'" . $pro_id[0]->result . "," . $suppliers[$i] . ",1," . date('Y-m-d H:i:s') . ",1" . "'";
                        $qry_res = $this->db->query("CALL insert_row('products_suppliers'," . $add_table_key . "," . $add_table_value . ")");
                        $qry_res->next_result();
                        $qry_res->free_result();
                        // $this->db->freeDBResource($this->db->conn_id);
                        // $product_supplier_id = $this->product_model->common_insert('products_suppliers', $data_supplier);
                    }
                }
                $massage = 'Successfully data added..';
            }
            echo json_encode(array("status" => "success", "message" => $massage));
        }
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
        $cat_name = $this->input->post('cat_name');
        $product_name = $this->input->post('product_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $price_range = $this->input->post('price_range');
        $brand_name = $this->input->post('brand_name');
        $inactive_product = $this->input->post('inactive_product');
        if (!empty($brand_name)) {
            $conditions['search']['brand_name'] = $brand_name;
        }
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($product_name)) {
            $conditions['search']['product_name'] = $product_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if ($inactive_product==1) {
            $conditions['search']['inactive_product'] = $inactive_product;
        }
        if (!empty($price_range)) {
            $cur = set_currency();
            $var = ' - ' . $cur . ' ';
            $str1 = explode($var, $price_range);
            $str2 = ltrim($str1[0], $cur . ' ');
            $from = ($str2 == 0) ? 0 : $str2;
            $conditions['search']['pro_price_from'] = $from;
            $conditions['search']['pro_price_to'] = $str1[1];
        }

        //total rows count
        //$totalRec = count($this->product_model->getRowsProducts($conditions));
        $rec=$this->product_model->getRowsProducts($conditions);
        $totalRec = ($rec !='')?count($rec):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['brands'] = $this->product_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array());
        $data['categories'] = $this->product_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['posts'] = $this->product_model->getRowsProducts($conditions);
        $data['stocks'] = $this->product_model->product_stock();
        //load the view
        $this->load->view('products/all_product_data', $data, false);
    }

    public function create_csv_data()
    {
        $conditions=array();
        $cat_name = $this->input->post('cat_name');
        $product_name = $this->input->post('product_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $price_range = $this->input->post('price_range');
        $brand_name = $this->input->post('brand_name');
        $inactive_product = $this->input->post('inactive_product');
        if (!empty($brand_name)) {
            $conditions['search']['brand_name'] = $brand_name;
        }
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($product_name)) {
            $conditions['search']['product_name'] = $product_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if ($inactive_product==1) {
            $conditions['search']['inactive_product'] = $inactive_product;
        }
        if (!empty($price_range)) {
            $cur=set_currency();
            $var=' - '.$cur.' ';
            $str1 = explode($var, $price_range);
            $str2 = ltrim($str1[0], $cur.' ');
            $from=($str2==0)?0:$str2;
            $conditions['search']['pro_price_from'] = $from;
            $conditions['search']['pro_price_to'] = $str1[1];
        }
        //total rows count
        $brands = $this->product_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array());
        $categories = $this->product_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $posts = $this->product_model->getRowsProducts($conditions);
        $stocks = $this->product_model->product_stock();
        $fields = array(
            'product_code' => 'Product Code'
        , 'product_name' => 'product_name'
        , 'category' => 'category'
        , 'sub_category' => 'sub_category'
        , 'brand' => 'brand'
        , 'stock' => 'stock'
        , 'price' => 'price'
        );
        $tot_amount=0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $category_n='';
                $sub_category='';
                foreach ($categories as $category) {
                    if ($category->id_product_category == $post['cat_id']) {
                        $category_n = $category->cat_name;
                    }
                    if ($category->id_product_category == $post['subcat_id']) {
                        $sub_category = $category->cat_name;
                    }
                }
                $brand_c='';
                foreach ($brands as $brand) {
                    if ($brand->id_product_brand == $post['brand_id']) {
                        $brand_c = $brand->brand_name;
                        break;
                    }
                }
                $stock_t='';
                if(!empty($stocks)){
                    foreach ($stocks as $stock) {
                        if ($post['id_product'] == $stock['product_id']) {
                            $stock_t = $stock['stock_qty'];
                            break;
                        }
                    }
                }
                $value[] = array(
                    'product_code' => $post['product_code']
                , 'product_name' => $post['product_name']
                , 'category' => $category_n
                , 'sub_category' => $sub_category
                , 'brand' => $brand_c
                , 'stock' => $stock_t
                , 'price' => $post['sell_price']
                );
                $count++;
            }
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'product_list'
        , 'file_title' => 'Product List'
        , 'field_title' => $fields
        , 'field_data' => $value
        , 'from' => ''
        , 'to' => ''
        );
        $data = json_encode($dataArray);
        $token=rand();
        $re=array(
            'token'=>$token
        ,'value'=>$data
        ,'date'=>date('Y-m-d')
        );
        $id=$this->commonmodel->common_insert('csv_report',$re);
        echo json_encode(array('id'=>$id,'token'=>$token));
    }

    public function edit_data($id = null)
    {
        $data = $this->product_model->get_product_by_id($id);
        $suppliers = $this->product_model->suppliers();
        $product_suppliers = $this->product_model->get_product_supplier($id);
        echo json_encode(array("data" => $data, "suppliers" => $suppliers, "product_suppliers" => $product_suppliers));
        //echo json_encode($data);
    }

    public function details_data($id = null)
    {
        $data = $this->product_model->get_product_details_by_id($id);
        $data1 = $this->product_model->get_supplier_by_product_id($id);
        $df_vat = $this->product_model->getvalue_row('configs', 'param_val', array('param_key'=>'DEFAULT_VAT'));

        foreach ($data as $key => $value) {
            $arrayVal[$key] = $value;
        }
        $dataValue = '';
        if (!empty($data1)) {
            foreach ($data1 as $val) {
                $coma = (empty($dataValue) ? '' : ', ');
                $dataValue .= $coma . '<a href="' . base_url() . 'supplier/' . $val['id_supplier'] . '" target="_blank">' . $val['supplier_name'] . '</a>   ';
            }
        }
        $arrayVal['supplier_name'] = $dataValue;
        foreach ($df_vat as $valttt) {
            $arrayVal['default_vat'] = $valttt->param_val;;
        }
        // $arrayVal['default_vat'] = $df_vat->param_val;
        echo json_encode($arrayVal);
    }

    public function delete_data($id = null)
    {
        //echo "data delete successfully";
        //$this->product_model->update_value('products', $data, $condition);
        $type=$this->input->post('type');
        if($type=='active'){
            $add_table_key = "'" . "status_id,dtt_mod,uid_mod" . "'";
            $add_table_value = "'1"  . "," . date('Y-m-d H:i:s') ."," .$this->session->userdata['login_info']['id_user_i90']. "'";
            $qry_res = $this->db->query("CALL update_row('products'," . $add_table_key . "," . $add_table_value . ",'id_product','" . $id . "')");
            echo json_encode(array("status" => TRUE));
        }else{
            $add_table_key = "'" . "status_id,dtt_mod,uid_mod" . "'";
            $add_table_value = "'2"  . "," . date('Y-m-d H:i:s') ."," .$this->session->userdata['login_info']['id_user_i90']. "'";
            $qry_res = $this->db->query("CALL update_row('products'," . $add_table_key . "," . $add_table_value . ",'id_product','" . $id . "')");
            echo json_encode(array("status" => TRUE));

        }
        
    }

    public function getsubcategory()
    {
        $id = $this->input->post('id');
        $condition = array(
            'parent_cat_id' => $id,
            'status_id' => 1
        );
        $categories = $this->product_model->getvalue_row('product_categories', 'cat_name,id_product_category', $condition);
        echo json_encode($categories);
    }

    public function isProductExist($pro_code)
    {
        //$pro_code=$this->input->post('pro_code');
        $is_exist = $this->product_model->isProductExist($pro_code);

        if (!$is_exist) {
            $this->form_validation->set_message(
                'pro_code', 'This code already taken'
            );
            return false;
        } else {
            return true;
        }
    }

    public function select_category()
    {
        if ($this->input->post('category') == 0) {
            $this->form_validation->set_message('category', 'Please choose any one');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_product_name()
    {
        $pro_name = $this->input->post('pro_name');
        $res = $this->product_model->check_value('products', 'product_name', $pro_name);
        $val = ($res) ? 'false' : 'true';
        echo $val;
    }

    public function barcode_data($id = null)
    {
        $data = array();
        $this->breadcrumb->add(lang('products'), 'products', 1);
        $this->breadcrumb->add(lang('barcode'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $condition = array(
            'id_product' => $id
        );
        $data['product_id'] = $id;
        $data['product_name'] = $this->product_model->getvalue_row('products', 'product_name', $condition);
        $data['posts'] = $this->product_model->batch_no_product_id($id);
        //echo '<pre>';
        //print_r($data['posts']);
        if ($this->input->post('batch_no')) {
            $this->load->library('barcode');
            $data['batch_no'] = $this->input->post('batch_no');
            $data['qty'] = $this->input->post('qty');
            $data['barcode_size'] = $this->input->post('barcode_size');
            $data['paper_size'] = $this->input->post('paper_size');
            $tmp = $this->product_model->getStockPriceByProduct($id, $data['batch_no']);
            $data['p_product_name'] = $tmp[0]['product_name'];
            //print_r($_POST);
            $data['product_price'] = $tmp[0]['selling_price_act'];
            $data['is_vat'] = ($tmp[0]['is_vatable']==1)?'+VAT':'';
        }
        $this->template->load('main', 'products/pro_barcode', $data);
    }

    public function get_product_qty_byBatch()
    {

        $condition = array(
            'product_id' => $this->input->post('pro_id'),
            'batch_no' => $this->input->post('batch')
        );
        $product_name = $this->product_model->getvalue_row('stocks', 'SUM(qty) as total_qty', $condition);
        echo $product_name[0]->total_qty;
    }

    public function get_barcode_byProduct()
    {
        $this->load->library('barcode');
        $pro_id = $this->input->post('pro_id');
        $batch = $this->input->post('batch');
        $qty = $this->input->post('qty');
        $barcode_size = $this->input->post('barcode_size');
        $paper_size = $this->input->post('paper_size');

        $tmp = $this->product_model->getStockPriceByProduct($pro_id, $batch);
        $product_name = $tmp[0]['product_name'];
        $product_price = $tmp[0]['selling_price_act'];
        //dd($product_name);

        $barcode = $pro_id . '-' . $batch;
        $html = '';
        $height = '';
        $width = '';
        $page_size_width = '';
        $bar_width = '';

        // $page_size_width='';
        if ($barcode_size == 1) {
            $height = '70px';
            $width = '150px';
            $bar_width = '160px';
        } else if ($barcode_size == 2) {
            $height = '40px';
            $width = '141px';
            $bar_width = '141px';
        }
        if ($paper_size == 1) {
            $page_size_width = '200px';
            // echo $page_size_width;
        } else if ($paper_size == 2) {
            $page_size_width = '150px';
        }
        $html = '<div class="barcodeouter"  style="width:' . $page_size_width . '; margin-bottom:4px;">';
        echo $html;
        for ($i = 1; $i <= $qty; $i++) {
            $img = $this->barcode->code128BarCode($barcode, 1);
            //echo'<br>';

            ob_start();
            imagepng($img);
            $output_img = ob_get_clean();
            $html .= '<div class="barcode" style="width:' . $width . '">';

            $html .= '<div style="padding:0px;">';
            $html .= '<span style="width:100%;line-height: 12px;float: left; font-weight:bold;font-size:12px;">' . $product_name . '</span>';
            $html .= '<span class="no" style="font-size:9px;margin-top: -4px;">'.set_currency() .' '. $product_price . '</span>';
            $html .= '<img height="' . $height . '" style="width:100%;"  src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
            $html .= '<span class="no" style="font-size:10px;margin-top: -3px;"> ' . $barcode . '</span>';

            $html .= '</div></div>';
        }
        echo $html;
        $html = '</div>';
        //echo $pro_id . '-' . $batch . '-' . $qty;
        // <div style="width: 595px; height: 842px">
        // <label style="width:97px;display:block;height:15px;pading:2px 0px 2px 0px; ">hasib</label>
    }

    // public function get_bulk_barcode_byProduct($barcode_size, $paper_size, $barcodeParameter)
    // {

    //     $this->load->library('barcode');

    //     $html = '';
    //     $height = '';
    //     $width = '';
    //     $page_size_width = '';
    //     $bar_width = '';

    //     if ($barcode_size == 1) {
    //         $height = '45px';
    //         $width = '192px';
    //         $bar_height='138px';
    //         $font_size='12px';
    //         $font_size2='10px';
    //         $margin_img='8px 0 0 0';
    //         $price_margin='0 0 0px 0';
    //         $bar_width = '192px';
    //         $new_css='large_size';
    //     } else if ($barcode_size == 2) {
    //         $height = '30px';
    //         $width = '150px';
    //         $bar_height='107px';
    //         $font_size='12px';
    //         $font_size2='11px';
    //         $margin_img='3px 0 0 0';
    //         $price_margin='0';
    //         $bar_width = '150px';
    //         $new_css='small_size';
    //     }
    //     $css = '';
    //     if ($paper_size == 1) {
    //         $page_size_width = '950px';
    //         $css = '; margin: 12px!important;';
    //     } else if ($paper_size == 2) {
    //         $page_size_width = '150px';

    //     }

    //     $html = '<div class="barcodeouter" style="width:' . $page_size_width . '; margin-bottom:4px;margin-left: 35px; font-family: Tahoma,Arial !important;">';

    //     $k = 0;
    //     foreach ($barcodeParameter as $data):

    //         $pro_id = $data['pro_id'];
    //         $batch = $data['batch_no'];
    //         $qty = $data['qty'];

    //         $tmp = $this->product_model->getStockPriceByProduct($pro_id, $batch);
    //         $product_name = $tmp[0]['product_name'];
    //         $product_code = $tmp[0]['product_code'];
    //         $product_price = $tmp[0]['selling_price_act'];
    //         $is_vat = ($tmp[0]['is_vatable']==1)?'+VAT':'';

    //         $barcode = $pro_id . '-' . $batch;

    //         for ($i = 1; $i <= $qty; $i++) {
    //             $img = $this->barcode->code128BarCode($barcode, 1);
    //             ob_start();
    //             imagepng($img);
    //             $output_img = ob_get_clean();
    //             $k += 1;
    //             $html .= '<div class="barcode '.$new_css.'" style="width:' . $width .';'. $css . 'height:'.$bar_height.';display: block;border: 1px dashed #888;border-radius: 8px;padding: 5px;overflow: hidden;">';
    //             $html .= '<div style="padding:0px;display: block;box-sizing: border-box;overflow: hidden">';
    //             if ($data['ck_shop'] != '') {
    //                 $html .= '<span style="width:100%;line-height: 8px;float: left;text-transform: uppercase; font-weight:bold;font-size:10px">' . $this->input->post('store_value') . '</span>';
    //             }
    //             if ($data['ck_name'] != '') {
    //                 $html .= '<span style="width:100%;line-height: 11px;margin-top: 0px;float: left; font-weight:600;font-size:'.$font_size2.';">' . $product_name . '</span>';
    //             }
    //             if ($data['ck_attr'] != '') {
    //                 $html .= '<span style="width:100%;line-height: 8px;float: left; font-weight:400;font-size:10px;font-size:'.$font_size2.';">' . $data['attr_name'] . '</span>';
    //             }
    //             $set_price = $product_price;
    //             if ($data['ck_cur'] != '') {
    //                 $set_price=set_currency($product_price);
    //             }


    //             $html .= '<img height="' . $height . '" style="width:100%;margin:'.$margin_img.'" src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
    //             $html .= '<span class="no" style="font-size:'.$font_size2.';margin:'.$price_margin.'"> ' . $barcode . '</span>';
    //             if ($data['ck_code'] != '') {
    //                 $html .= '<span style="width:100%;line-height: 12px;float: left; font-weight:600;font-size:10px;font-size:'.$font_size2.';">' . $product_code . '</span>';
    //             }
    //             if ($data['ck_price'] != '') {
    //                 $html .= '<span class="no" style="font-size:' . $data['ck_size'] . 'px;margin-top: 0px;font-weight:bold;letter-spacing: 2px;">' . $set_price . $is_vat.'</span>';
    //             }


    //             $html .= '</div></div>';


    //             if ($barcode_size == 2) {
    //                 if ($k % 50 == 0) {
    //                     $html .= '<span  style="float: left;width: 100%;display: block;height: 13px;"></span>';
    //                     $k = 0;

    //                 }
    //             }
    //             if ($barcode_size == 1) {
    //                 if ($k % 32 == 0) {
    //                     $html .= '<span style="float: left;width: 100%;display: block;height: 30px;"></span>';
    //                     $k = 0;
    //                 }
    //             }

    //         }

    //     endforeach;
    //     $html .= '</div>';

    //     echo $html;

    // }
    public function get_bulk_barcode_byProduct($barcode_size, $paper_size, $barcodeParameter,$barcode_text,$store_name=null)
    {

        $this->load->library('barcode');

        $html = '';
        $height = '';
        $width = '';
        $page_size_width = '';
        $bar_width = '';

        if ($barcode_size == 1) {
            $height = '30px';
            $width = '192px';
            $bar_height='138px';
            $font_size='12px';
            $font_size2='10px';
            $margin_img='8px 0 0 0';
            $price_margin='0 0 0px 0';
            $bar_width = '192px';
            $new_css='large_size';
        } else if ($barcode_size == 2) {
            $height = '18px';
            $width = '150px';
            $bar_height='107px';
            $font_size='12px';
            $font_size2='11px';
            $margin_img='3px 0 0 0';
            $price_margin='-2px auto';
            $bar_width = '150px';
            $new_css='small_size';
        }
        $css = '';
        if ($paper_size == 1) {
            $page_size_width = '950px';
            $css = '; margin: 12px!important;';
        } else if ($paper_size == 2) {
            $page_size_width = '150px';

        }

        $html = '<div class="barcodeouter" style="width:' . $page_size_width . '; margin-bottom:4px;margin-left: 35px; font-family: Tahoma,Arial !important;">';

        $k = 0;
        foreach ($barcodeParameter as $data):

            $pro_id = $data['pro_id'];
            $batch = $data['batch_no'];
            $qty = $data['qty'];

            $tmp = $this->product_model->getStockPriceByProduct($pro_id, $batch,$store_name);
            $product_name = $tmp[0]['product_name'];
            $product_code = $tmp[0]['product_code'];
            $product_price = $tmp[0]['selling_price_act'];
            $is_vat = ($tmp[0]['is_vatable']==1)?'+VAT':'';

            $barcode = $pro_id . '-' . $batch;

            for ($i = 1; $i <= $qty; $i++) {
                $img = $this->barcode->code128BarCode($barcode, 1);
                ob_start();
                imagepng($img);
                $output_img = ob_get_clean();
                $k += 1;
                $html .= '<div class="barcode" style="width:' . $width . $css . 'height:'.$bar_height.';display: block;border: 1px dashed #888;border-radius: 8px;padding: 5px;overflow: hidden;">';

                $html .= '<div style="padding:0px;display: block;box-sizing: border-box;overflow: hidden">';
                if ($data['ck_shop'] != '') {
                    $html .= '<span style="width:100%;line-height: 8px;float: left;text-transform: uppercase; font-weight:bold;font-size:10px">' . $this->input->post('store_value') . '</span>';
                }
                if ($data['ck_name'] != '') {
                    $html .= '<span style="width:100%;line-height: 11px;margin-top: 0px;float: left; font-weight:600;font-size:'.$font_size2.';">' . $product_name . '</span>';
                }
                if ($data['ck_attr'] != '') {
                    $html .= '<span style="width:100%;line-height: 8px;float: left; font-weight:400;font-size:10px;font-size:'.$font_size2.';">' . $data['attr_name'] . '</span>';
                }
                $set_price = $product_price;
                if ($data['ck_cur'] != '') {
                    $set_price=set_currency($product_price);
                }


                $html .= '<img height="' . $height . '" style="width:100%;margin:'.$margin_img.'" src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
                $html .= '<span class="no" style="font-size:'.$font_size2.';margin:'.$price_margin.'"> ' . $barcode . '</span>';
                if ($data['ck_code'] != '') {
                    $html .= '<span style="width:100%;line-height: 12px;float: left; font-weight:600;font-size:10px;font-size:'.$font_size2.';">' . $product_code . '</span>';
                }
                if ($data['ck_price'] != '') {
                    $html .= '<span class="no" style="font-size:' . $data['ck_size'] . 'px;margin-top: 0px;font-weight:bold;letter-spacing: 2px;">' . $set_price . $is_vat.'</span>';
                }
                if($barcode_text !=''){

                 $html .= '<span style="width:100%;line-height: 12px;float: left;font-size:11px;">' .$barcode_text . '</span>';
                }
                

                $html .= '</div></div>';


                if ($barcode_size == 2) {
                    if ($k % 50 == 0) {
                        $html .= '<span  style="float: left;width: 100%;display: block;height: 13px;"></span>';
                        $k = 0;

                    }
                }
                if ($barcode_size == 1) {
                    if ($k % 32 == 0) {
                        $html .= '<span style="float: left;width: 100%;display: block;height: 30px;"></span>';
                        $k = 0;
                    }
                }

            }

        endforeach;
        $html .= '</div>';

        echo $html;

    }

    public function get_barcode_byProduct2()
    {
        $this->load->library('barcode');
        $pro_id = $this->input->post('pro_id');
        $batch = $this->input->post('batch');
        $qty = $this->input->post('qty');
        $barcode_size = $this->input->post('barcode_size');
        $paper_size = $this->input->post('paper_size');
        $barcode = $pro_id . '-' . $batch;
        $html = '';
        $height = '';
        $width = '';
        $page_size_width = '';
        // $page_size_width='';
        if ($barcode_size == 1) {
            $height = '75px';
            $width = '97px';
        } else if ($barcode_size == 2) {
            $height = '93px';
            $width = '131px';
        }
        if ($paper_size == 1) {
            $page_size_width = '595px';
            // echo $page_size_width;
        } else if ($paper_size == 2) {
            $page_size_width = '145px';
        }
        $html = '<div style="width:' . $page_size_width . ';">';
        echo $html;
        for ($i = 1; $i <= $qty; $i++) {
            $img = $this->barcode->code128BarCode($barcode, 1);
            //echo'<br>';

            ob_start();
            imagepng($img);
            $output_img = ob_get_clean();
            $html .= '<div class="barcode">';
            $html .= '<div style="background:yellow;margin:2px;border:1px solid;padding:2px;"><img width="' . $width . '" height="' . $height . '"  src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
            $html .= '<span class="no"> ' . $barcode . '</span>';
            $html .= '</div></div>';
        }
        echo $html;
        $html = '</div>';
        //echo $pro_id . '-' . $batch . '-' . $qty;
        // <div style="width: 595px; height: 842px">
        $this->load->view('products/index2', $html, false);
    }

    public function get_stock_qty_details()
    {
        $html = '';
        $pro_id = $this->input->post('id');
        $total = 0;
        $stocks = $this->product_model->get_stock_by_product($pro_id);
        $type= $this->session->userdata['login_info']['user_type_i92']; 
        $columns = $this->product_model->getvalue_row('acl_user_column', 'permission', array('acl_module_id'=>19));
        
        foreach ($stocks as $stock) {
            $stock_id=$stock->id_stock;
            $attr_name = $this->product_model->get_attribute_by_stock($stock_id);
            $html .= '<tr>';
            $html .= '<td>' . explode(' ',$stock->dtt_add)[0] . '</td>';
            $html .= '<td>' . $stock->batch_no . '</td>';
            $html .= '<td>' . $stock->store_name . '</td>';
            $html .= '<td>' . $attr_name . '</td>';
            if($columns[0]->permission==1||$type==3){
                $html .= '<td class="center">' . $stock->purchase_price . '</td>';
            }
            $html .= '<td class="center">' . $stock->selling_price_act . '</td>';
            $html .= '<td class="center">' . $stock->stk_qty . '</td>';
            $html .= '<td>' . $stock->expire_date . '</td>';
            $html .= '</tr>';
            $total += $stock->stk_qty;
        }
        $html .= '<tr>';
        $html .= '<td colspan="6" style="text-align: right">' . '<b>Total</b>' . '</td>';
        $html .= '<td class="center"><b>' . $total . '</b></td>';
        echo $html;
    }

    public function get_low_stock_qty_details(){
        $html = '';
        $pro_id = $this->input->post('id');
        $store_id = $this->input->post('store_id');
        $total = 0;
        //$stocks = $this->product_model->get_stock_by_product($pro_id);
        $stocks = $this->product_model->get_low_stock_by_product($pro_id,$store_id);
        foreach ($stocks as $stock) {
            $html .= '<tr>';
            $html .= '<td>' . explode(' ',$stock->dtt_add)[0] . '</td>';
            $html .= '<td>' . $stock->batch_no . '</td>';
            $html .= '<td>' . $stock->store_name . '</td>';
            $html .= '<td class="center">' . $stock->purchase_price . '</td>';
            $html .= '<td class="center">' . $stock->selling_price_act . '</td>';
            $html .= '<td class="center">' . $stock->stk_qty . '</td>';
            $html .= '<td>' . $stock->expire_date . '</td>';
            $html .= '</tr>';
            $total += $stock->stk_qty;
        }
        $html .= '<tr>';
        $html .= '<td colspan="5" style="text-align: right">' . '<b>Total</b>' . '</td>';
        $html .= '<td class="center"><b>' . $total . '</b></td>';
        echo $html;
    }
    // ash start

    public function bulk_barcode()
    {
        $userTypeId = $_SESSION['login_info']['user_type_i92'];
        if($userTypeId == 3){
            $store_ids = $_SESSION['login_info']['store_ids'];
            $storeName = array();
            foreach ($store_ids as $store_id) {
                $storeName[$store_id] = $this->product_model->getStoreName($store_id);
            }
            $data['storeName'] = $storeName;
        }else if($userTypeId == 1){
            $store_id = $_SESSION['login_info']['store_id'];
            $storeName = $this->product_model->getStoreName($store_id);

            $data['storeName'] = array($store_id => $storeName);
        }
        $data['products'] = $this->product_model->get_available_stock_in_products();

        $this->template->load('main', 'products/bulk-barcode.php', $data);
    }

    public function get_available_stocked_product()
    {
        $pro_id = $this->input->post('pId');
        $storeId = $this->input->post('storeId');
        $stocks = $this->product_model->get_available_stock_by_product($pro_id, $storeId);
        $pro_name = $this->product_model->getProductName($pro_id);

        if (!empty($stocks)) {
            $tableRow = array();
            foreach ($stocks as $aStock) {
                $tableRow[] = '<tr><input type="hidden" name="pro_id[]" value="' . $pro_id . '"/><input type="hidden" name="attr_name[]" value="' . $aStock->attribute_name . '"/><input type="hidden" name="id_stock[]" value="' . $aStock->id_stock . '"/><input type="hidden" name="batch_no[]" value="' . $aStock->batch_no . '"/><td>' . $pro_name . '</td><td>' . $aStock->batch_no . '</td><td>' . $aStock->dtt_add . '</td><td>' . $aStock->attribute_name . '</td><td><input type="text" name="qty[]" value="' . $aStock->qty . '"/></td><td><button class="btn btn-danger btn-xs removeItem" type="button" ><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
            }
            print_r($tableRow);
        }
    }
    public function get_available_invoice_stocked_product()
    {
        $inv_type = $this->input->post('invType');
        $inv_no = $this->input->post('invNo');
        $storeId = $this->input->post('storeId');
        if($inv_type!=3){
            $stocks = $this->product_model->get_available_stock_by_invoice($inv_no, $inv_type, $storeId);
        }else{
            $stocks = $this->product_model->get_available_receive_by_invoice($inv_no, $storeId);
        }
        if (!empty($stocks)) {
            $tableRow = array();
            foreach ($stocks as $aStock) {
                $tableRow[] = '<tr><input type="hidden" name="pro_id[]" value="' . $aStock->product_id . '"/><input type="hidden" name="attr_name[]" value="' . $aStock->attribute_name . '"/><input type="hidden" name="id_stock[]" value="' . $aStock->id_stock . '"/><input type="hidden" name="batch_no[]" value="' . $aStock->batch_no . '"/><td>' . $aStock->product_name . '</td><td>' . $aStock->batch_no . '</td><td>' . $aStock->dtt_add . '</td><td>' . $aStock->attribute_name . '</td><td><input type="text" name="qty[]" value="' . $aStock->current_qty . '"/></td><td><button class="btn btn-danger btn-xs removeItem" type="button" ><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
            }
            print_r($tableRow);
        }
    }

    public function proview_bulk_barcode()
    {
        $pro_id = $this->input->post('pro_id');
        $barcode_size = $this->input->post('barcode_size');
        $paper_size = $this->input->post('paper_size');
        $barcode_text = $this->input->post('barcode_text');
        $id_stock = $this->input->post('id_stock');
        $batch_no = $this->input->post('batch_no');
        $store_name = $this->input->post('store_name');

        $qty = $this->input->post('qty');
        $attr_name = $this->input->post('attr_name');
        $ck_shop = $this->input->post('ck_shop');
        $ck_name = $this->input->post('ck_name');
        $ck_code= $this->input->post('ck_code');
        $ck_price = $this->input->post('ck_price');
        $ck_size = $this->input->post('ck_size');
        $ck_cur = $this->input->post('ck_cur');
        $ck_attr = $this->input->post('ck_attr');
        $barNums = count($id_stock);

        $barcodeParameter = array();
        $bcArray = array();
        for ($i = 0; $i < $barNums; $i++) {
            $barcodeParameter[] = array(
                'pro_id' => $pro_id[$i],
                'id_stock' => $id_stock[$i],
                'batch_no' => $batch_no[$i],
                'qty' => $qty[$i],
                'attr_name' => $attr_name[$i],
                'ck_shop' => (isset($ck_shop)) ? 1 : '',
                'ck_name' => (isset($ck_name)) ? 1 : '',
                'ck_code' => (isset($ck_code)) ? 1 : '',
                'ck_price' => (isset($ck_price)) ? 1 : '',
                'ck_size' => (isset($ck_size)) ? $ck_size : '',
                'ck_cur' => (isset($ck_cur)) ? 1 : '',
                'ck_attr' => (isset($ck_attr)) ? 1 : '',
            );
        }

        $this->get_bulk_barcode_byProduct($barcode_size, $paper_size, $barcodeParameter,$barcode_text,$store_name);

    }

    public function print_bulk_barcode(){
        $pro_id = explode(',', $this->input->post('pro_id'));
        $barcode_size = explode(',', $this->input->post('barcode_size'));
        $paper_size = explode(',', $this->input->post('paper_size'));

        $id_stock = explode(',', $this->input->post('id_stock'));
        $batch_no = explode(',', $this->input->post('batch_no'));

        $qty = explode(',', $this->input->post('qty'));

        $barNums = count($id_stock);

        $barcodeParameter = array();
        $bcArray = array();
        for ($i=0; $i < $barNums; $i++) { 
            $barcodeParameter[] = array(
                'pro_id'        => $pro_id[$i],
                'id_stock'      => $id_stock[$i],
                'batch_no'      => $batch_no[$i],
                'qty'           => $qty[$i]
            );
        }

        $this->get_bulk_barcode_byProduct($barcode_size, $paper_size, $barcodeParameter);
    }

    public function product_details_by_id()
    {
        $product_id = $this->input->post('id');
        $data = $this->product_model->getvalue_row('products', 'id_product,product_code,cat_id,subcat_id,product_name,brand_id,is_vatable,unit_id,buy_price,sell_price', array('status_id' => 1, 'id_product' => $product_id));
        echo json_encode($data);
    }
    public function product_stock_list()
    {
        $store_id = $this->input->post('id');
        $data = $this->commonmodel->product_stock_list($store_id);
        echo json_encode($data);
    }
    public function low_high_stock()
    {
        $data = array();
        //total rows count
        $totalRec = 0;
        // $lowsdt = $this->product_model->low_stock_data();
        // if (!empty($lowsdt)) {
        //     $totalRec = count($this->product_model->low_stock_data());
        // }
        //pagination configuration
        // $config['target']      = '#postList';
        // $config['base_url']    = base_url().'products/lowStockPagination';
        // $config['total_rows']  = $totalRec;
        // $config['per_page']    = $this->perPage;
        // $this->ajax_pagination->initialize($config);

        //get the posts data
        //$data['low_stock_data'] = $this->product_model->low_stock_data(array('limit' => $this->perPage));

        $this->dynamic_menu->check_menu('products/low-high-stock');
        $this->breadcrumb->add('Min/Max Stock Report', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['categories'] = $this->product_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));

        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->product_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->product_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }

        $data['brands'] = $this->product_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));


        $this->template->load('main', 'products/low_stock', $data);
    }

    public function lowStockPagination()
    {
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $totalRec = 0;
        $lowsdt = $this->product_model->low_stock_data();
        if (!empty($lowsdt)) {
            $totalRec = count($this->product_model->low_stock_data());
        }

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'products/lowStockPagination';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['low_stock_data'] = $this->product_model->low_stock_data(array('start' => $offset, 'limit' => $this->perPage));

        //load the view
        $this->load->view('products/lowStockPagination', $data, false);
    }

    public function lowStockPagi2()
    {
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $totalRec = 0;
        $arg = array('type' => 'submit');
        if (!empty($_POST['product_name'])) {
            $arg = array_merge($arg, array('product_name' => $_POST['product_name']));
        }
        if (!empty($_POST['cat_name'])) {
            $arg = array_merge($arg, array('cat_name' => $_POST['cat_name']));
        }
        if ($_POST['type']!=0) {
            $arg = array_merge($arg, array('type' => $_POST['type']));
        }
        if (!empty($_POST['pro_sub_category'])) {
            if ($_POST['pro_sub_category'] != -1) {
                $arg = array_merge($arg, array('pro_sub_category' => $_POST['pro_sub_category']));
            }
        }
        if (!empty($_POST['store_id'])) {
            $arg = array_merge($arg, array('store_id' => $_POST['store_id']));
        }
        if (!empty($_POST['brand'])) {
            $arg = array_merge($arg, array('brand' => $_POST['brand']));
        }
        $lowsdt = $this->product_model->low_stock_data($arg);
        if (!empty($lowsdt)) {
            $totalRec = count($this->product_model->low_stock_data($arg));
        }
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'products/lowStockPagination';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'jsLinkFunc';
        $this->ajax_pagination->initialize($config);
        $arg = array_merge($arg, array('start' => $offset, 'limit' => $this->perPage));
        //get the posts data
        $data['type']=$_POST['type'];
        $data['low_stock_data'] = $this->product_model->low_stock_data($arg);

        //load the view
        $this->load->view('products/lowStockPagination', $data, false);
    }
    public function get_product_auto_list(){
        $request = $_REQUEST['term'];
        $return = array();
        if($request!=''){
            $product_list = $this->product_model->get_product_auto_list($request);
            foreach ($product_list as $list) {
                $return[] = array(
                    "label" => $list->product_name . '(' . $list->product_code . ')',
                    "value" => $list->id_product,
                    "purchase_price" => $list->buy_price,
                    "product_code" => $list->product_code,
                    "sale_price" => $list->sell_price
                );
            }
        }
        echo json_encode($return);
    }
}
