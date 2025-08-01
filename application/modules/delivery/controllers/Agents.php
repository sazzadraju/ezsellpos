<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agents extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('delivery_model');
        $this->perPage = 20;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('agents'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->delivery_model->getAgentData();
        $totalRec = ($row)?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'agents/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        //$data['de_vat'] = $this->delivery_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        $data['max_val'] = $this->delivery_model->max_value('products', 'sell_price');
        $data['suppliers'] = $this->delivery_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['units'] = $this->delivery_model->getvalue_row('product_units', 'unit_code,id_product_unit', array('status_id' => 1));
        $data['brands'] = $this->delivery_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['categories'] = $this->delivery_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['posts'] = $this->delivery_model->getAgentData(array('limit' => $this->perPage));
        $this->template->load('main', 'agents/index', $data);
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
// pa($_POST);
        // if ($this->input->post('id') != '') {
            $name = $this->input->post('agent_name');
        //     $id_v = $this->input->post('id');
        //     $this->form_validation->set_rules('agent_name', 'Agent Name', 'trim|required');
        //     $val = $this->delivery_model->isExistExcept('agents', 'agent_name', $name, 'id_agents', $id_v);
        //     if ($val) {
        //         echo json_encode(array('agent_name' => lang('name_exist')));
        //         exit();
        //     }
        //     // $this->form_validation->set_rules('pro_code', 'Product Code', 'trim|required');
        // } else {
        //     $name = $this->input->post('agent_name');
        //     // $this->form_validation->set_rules('agent_name', 'Product Code', 'trim|required|is_unique[products.product_code]');
        //     // $this->form_validation->set_rules('agent_name', 'Product Name', 'trim|required|is_unique[products.product_name]');
        // }
        // $this->form_validation->set_rules('category', 'Category', 'trim|required');
        // $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
        // $this->form_validation->set_rules('buying_price', 'Buying Price', 'trim|required');
        // if ($this->form_validation->run() == false) {
        //     $value = $this->form_validation->error_array();
        //     echo json_encode($value);
        // } else {
        //     $conditions = array();
        //     $filename = '';
        //     $newFileName = $_FILES['userfile']['name'];
        //     if ($newFileName != '') {
        //         $nfile = explode(".", $newFileName);
        //         $fileExt = array_pop($nfile);
        //         $filename = date('d-m-Y') . '_' . time() . "." . $fileExt;
        //         $config['upload_path'] = './public/uploads/products/';
        //         $config['allowed_types'] = 'gif|jpg|png|jpeg';
        //         $config['max_size'] = 100000;
        //         $config['max_width'] = 102400;
        //         $config['max_height'] = 100000;
        //         $config['file_name'] = $filename;
        //         $this->load->library('upload', $config);
        //         if (!$this->upload->do_upload('userfile')) {
        //             echo $this->upload->display_errors();
        //         } else {
        //             $recipe_file = $this->upload->data();
        //             $file = $config['file_name'];
        //             //$data['logo'] = $recipe_file['file_name'];
        //         }
        //     }
            $data['agent_name'] = $this->input->post('agent_name');
            $id_v = $this->input->post('id');
            // $data['product_name'] = $name;
            $data['agent_number'] = $this->input->post('agent_number');
            $data['address'] = $this->input->post('address');
            $data['email'] = $this->input->post('agent_email');
            $data['contact_person_name'] = $this->input->post('contact_person_name');
            $data['contact_person_number'] = $this->input->post('contact_person_number');
            if ($this->input->post('id') != '') {
                $this->form_validation->set_rules('agent_name', 'Agent Name', 'trim|required');
            $val = $this->delivery_model->isExistExcept('agents', 'agent_name', $name, 'id_agent', $id_v);
            // echo $val;
            if ($val) {
                echo json_encode(array('agent_name' => lang('name_exist')));
                exit();
            }
                $condition = array(
                    'id_agent' => $this->input->post('id')
                );
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $pro_id = $this->delivery_model->update_value('agents', $data, $condition);
                $massage = 'Successfully data Updated..';
            } else {
                $this->form_validation->set_rules('agent_name', 'Agent Name', 'trim|required');
            $val = $this->delivery_model->isExistExcept('agents', 'agent_name', $name, 'id_agent', $id_v);
            // echo $val;
            if ($val) {
                echo json_encode(array('agent_name' => lang('name_exist')));
                exit();
            }
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $pro_id = $this->delivery_model->common_insert('agents', $data);
                $massage = 'Successfully data added..';
            }

            echo json_encode(array("status" => "success", "message" => $massage));
        // }
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
        // $cat_name = $this->input->post('cat_name');
        // $product_name = $this->input->post('product_name');
        // $pro_sub_category = $this->input->post('pro_sub_category');
        // $price_range = $this->input->post('price_range');
        // if (!empty($cat_name)) {
        //     $conditions['search']['cat_name'] = $cat_name;
        // }
        // if (!empty($product_name)) {
        //     $conditions['search']['product_name'] = $product_name;
        // }
        // if (!empty($pro_sub_category)) {
        //     $conditions['search']['pro_sub_category'] = $pro_sub_category;
        // }
      

        //total rows count
        $totalRec = count($this->delivery_model->getAgentData($conditions));

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
        $data['brands'] = $this->delivery_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array());
        $data['categories'] = $this->delivery_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['posts'] = $this->delivery_model->getAgentData($conditions);
        //load the view
        $this->load->view('agents/all_product_data', $data, false);
    }

    public function edit_data($id = null)
    {
        $data = $this->delivery_model->get_agent_by_id($id);
        echo json_encode(array("data" => $data));
        //echo json_encode($data);
    }

    public function details_data($id = null)
    {
        $data = $this->delivery_model->get_agent_details_by_id($id);
        // $data1 = $this->delivery_model->get_supplier_by_product_id($id);
        foreach ($data as $key => $value) {
            $arrayVal[$key] = $value;
        }
        $dataValue = '';
        // if (!empty($data1)) {
        //     foreach ($data1 as $val) {
        //         $coma = (empty($dataValue) ? '' : ', ');
        //         $dataValue .= $coma . '<a href="' . base_url() . 'supplier/' . $val['id_supplier'] . '" target="_blank">' . $val['supplier_name'] . '</a>   ';
        //     }
        // }
        // $arrayVal['supplier_name'] = $dataValue;
        echo json_encode($arrayVal);
    }

    public function delete_data($id = null)
    {
        //echo "data delete successfully";
        $condition = array(
            'id_agent' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->delivery_model->update_value('agents', $data, $condition);
        echo json_encode(array("status" => TRUE));
    }

    public function getsubcategory()
    {
        $id = $this->input->post('id');
        $condition = array(
            'parent_cat_id' => $id,
            'status_id'=>1
        );
        $categories = $this->delivery_model->getvalue_row('product_categories', 'cat_name,id_product_category', $condition);
        echo json_encode($categories);
    }

    public function isProductExist($pro_code)
    {
        //$pro_code=$this->input->post('pro_code');
        $is_exist = $this->delivery_model->isProductExist($pro_code);

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
        $res = $this->delivery_model->check_value('products', 'product_name', $pro_name);
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
        $data['product_name'] = $this->delivery_model->getvalue_row('products', 'product_name', $condition);
        $data['posts'] = $this->delivery_model->batch_no_product_id($id);
        //echo '<pre>';
        //print_r($data['posts']);
        $this->template->load('main', 'products/pro_barcode', $data);
    }

    public function get_product_qty_byBatch()
    {

        $condition = array(
            'product_id' => $this->input->post('pro_id'),
            'batch_no' => $this->input->post('batch')
        );
        $product_name = $this->delivery_model->getvalue_row('stocks', 'SUM(qty) as total_qty', $condition);
        echo $product_name[0]->total_qty;
    }

    public function get_barcode_byProduct()
    {
        $this->load->library('barcode');
        $pro_id = $this->input->post('pro_id');
        $batch = $this->input->post('batch');
        $qty = $this->input->post('qty');
        $barcode_size=$this->input->post('barcode_size');
        $paper_size=$this->input->post('paper_size');
        $tmp = $this->delivery_model->getvalue_row('products', 'product_name', array('id_product' => $pro_id));
        $product_name = $tmp[0]->product_name;
        $tmp2 = $this->delivery_model->getvalue_row('products', 'sell_price', array('id_product' => $pro_id));
        $product_price = $tmp2[0]->sell_price;
        //dd($product_name);

        $barcode = $pro_id . '-' . $batch;
        $html = '';
        $height='';
        $width=''; 
        $page_size_width='';
        $bar_width='';

        // $page_size_width='';
        if($barcode_size==1){
            $height='75px';
           $width='97px';
           $bar_width='80px';  
        }
        else if($barcode_size==2){
           $height='93px';
           $width='131px'; 
           $bar_width='116px'; 
        }
        if($paper_size==1){
           $page_size_width='595px';  
           // echo $page_size_width;
        }
        else if($paper_size==2){
           $page_size_width='145px'; 
        }
       $html = '<div class="barcodeouter"  style="width:'.$page_size_width.'; margin-bottom:4px;">';
       echo $html;
        for ($i = 1; $i <= $qty; $i++) {
            $img = $this->barcode->code128BarCode($barcode, 1);
            //echo'<br>';

            ob_start();
            imagepng($img);
            $output_img = ob_get_clean();
            $html .= '<div class="barcode" style="width:'.$width.'">';

            $html .= '<div style="background:yellow;margin:0px 2px 2px 2px;border:1px solid;padding:0px;"><span style="width:100%;line-height: 12px;float: left;height:12px;font-size:10px;">'.$product_name .'</span><img width="'.$bar_width.'"src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
            $html .= '<span class="no" style="font-size:10px;margin-top: -3px;"> ' . $barcode . '</span>';
            $html .= '<span class="no" style="font-size:9px;margin-top: -4px;"> BDT ' . $product_price . '</span>';
            $html .= '</div></div>';
        }
        echo $html;
        $html = '</div>';
        //echo $pro_id . '-' . $batch . '-' . $qty;
        // <div style="width: 595px; height: 842px">
       // <label style="width:97px;display:block;height:15px;pading:2px 0px 2px 0px; ">hasib</label>
    }
     public function get_barcode_byProduct2()
    {
        $this->load->library('barcode');
        $pro_id = $this->input->post('pro_id');
        $batch = $this->input->post('batch');
        $qty = $this->input->post('qty');
        $barcode_size=$this->input->post('barcode_size');
        $paper_size=$this->input->post('paper_size');
        $barcode = $pro_id . '-' . $batch;
        $html = '';
        $height='';
        $width=''; 
        $page_size_width='';
        // $page_size_width='';
        if($barcode_size==1){
           $height='75px';
           $width='97px';  
        }
        else if($barcode_size==2){
           $height='93px';
           $width='131px';  
        }
        if($paper_size==1){
           $page_size_width='595px';  
           // echo $page_size_width;
        }
        else if($paper_size==2){
           $page_size_width='145px'; 
        }
       $html = '<div style="width:'.$page_size_width.';">';
       echo $html;
        for ($i = 1; $i <= $qty; $i++) {
            $img = $this->barcode->code128BarCode($barcode, 1);
            //echo'<br>';

            ob_start();
            imagepng($img);
            $output_img = ob_get_clean();
            $html .= '<div class="barcode">';
            $html .= '<div style="background:yellow;margin:2px;border:1px solid;padding:2px;"><img width="'.$width.'" height="'.$height.'"  src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
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
        $total=0;
        $stocks = $this->delivery_model->getvalue_row('stocks', '*', array('product_id' => $pro_id));
        foreach ($stocks as $stock) {
            $html .= '<tr>';
            $html .= '<td>' . $stock->batch_no . '</td>';
            $html .= '<td>' . $stock->qty . '</td>';
            $html .= '</tr>';
            $total+=$stock->qty;
        }
        $html .= '<tr>';
        $html .= '<td style="text-align: right">' . '<b>Total</b>' . '</td>';
        $html .= '<td ><b>' . $total . '</b></td>';
        echo $html;
    }



     public function checkAgentName() {
        $this->load->database();
        $name = $this->input->post('agent_name');
        $this->db->where('agent_name', $name);
        $this->db->where('status_id', 1);
        $query = $this->db->get('agents');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
}
