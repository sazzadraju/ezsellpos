<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('language', 'url', 'html', 'form'));
        $this->load->library('session');
        $this->load->library('Ajax_pagination');
        if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('product_model');
        $this->perPage = 20;
    }

    public function index() {
        $data = array();
        $this->dynamic_menu->check_menu('products/brands');
        $this->breadcrumb->add(lang('products'), 'products', 1);
        $this->breadcrumb->add(lang('brands'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->product_model->getRowsbrands();
        $totalRec = ($row)?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product_brands/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['posts'] = $this->product_model->getRowsbrands(array('limit' => $this->perPage));
        $this->template->load('main', 'brands/index', $data);
    }

    public function add_data() {
        $conditions = array();
        if ($this->input->post('id') != '') {
            $name = $this->input->post('br_name');
            $id_v = $this->input->post('id');
            $this->form_validation->set_rules('br_name', 'Brand Name', 'trim|required');
            $val = $this->product_model->isExistExcept('product_brands', 'brand_name', $name, 'id_product_brand', $id_v);
            if ($val) {
                echo json_encode(array('br_name' => lang('name_exist')));
                exit();
            }
        } else {
            $name = $this->input->post('brand_name');
            $this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required|is_unique[product_brands.brand_name]');
        }
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $brand_name = $name;
            $filename = '';
            if ($_FILES['userfile']['name']!='') {
                $filename = upload_file('brand', $_FILES['userfile']);
            }
            if ($name) {
                $data['brand_name'] = $name;
                $data['description'] = 'this is my first page';
                //$data['img_main'] = $filename;
                $data['status_id'] = 1;
                //$this->product_model->common_insert('product_brands', $data);
            }
            if ($this->input->post('id') != '') {
                $condition = array(
                    'id_product_brand' => $this->input->post('id')
                );
                if ($filename == '') {
                    $filename = $this->input->post('image_name');
                }
                $data['img_main'] = $filename;
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $this->product_model->update_value('product_brands', $data, $condition);
                $massage = lang("update_success");
            } else {
                $data['img_main'] = $filename;
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $this->product_model->common_insert('product_brands', $data);
                $massage = lang("add_success");
            }

            echo json_encode(array("status" => "success", "message" => $massage));
        }
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
        //total rows count
        $totalRec = count($this->product_model->getRowsbrands());

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product_brands/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['posts'] = $this->product_model->getRowsbrands($conditions);

        //load the view
        $this->load->view('brands/all_brand_data', $data, false);
    }

    public function edit_data($id = null) {
        $data = $this->product_model->get_brand_by_id($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }

    public function delete_data($id = null) {
        $condition = array(
            'id_product_brand' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $cat = $this->product_model->check_product_brand($id);
        if($cat){
            echo json_encode(array("status" => FALSE));
        } else {
            $this->product_model->update_value('product_brands', $data, $condition);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function check_brand_name() {
        $this->load->database();
        $name = $this->input->post('brand_name');
        $this->db->where('brand_name', $name);
        $this->db->where('status_id', 1);
        $query = $this->db->get('product_brands');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

}
