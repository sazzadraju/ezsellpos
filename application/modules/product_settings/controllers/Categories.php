<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MX_Controller {

    function __construct() {
        parent::__construct();
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
        $this->dynamic_menu->check_menu('products/categories');
        $this->breadcrumb->add(lang('products'), 'products', 1);
        $this->breadcrumb->add(lang('categories'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->product_model->getRowsCategories();
        $totalRec = ($row)?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product_categories/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['categories'] = $this->product_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['posts'] = $this->product_model->getRowsCategories(array('limit' => $this->perPage));
        $this->template->load('main', 'categories/index', $data);
    }

    public function add_data() {
        $conditions = array();
        if ($this->input->post('id') != '') {
            $name = $this->input->post('cate_name');
            $id_v = $this->input->post('id');
            $this->form_validation->set_rules('cate_name', 'Category Name', 'trim|required');
            //$val = $this->product_model->isExistExcept('product_categories', 'cat_name', $name, 'id_product_category', $id_v);
            // if ($val == 1) {
            //     echo json_encode(array('cate_name' => lang('name_exist')));
            //     exit();
            // }
            if($id_v==$this->input->post('category_main')){
                echo json_encode(array('cate_name' => lang('unable_to_update')));
                exit();
            }
        } else {
            $name = $this->input->post('category_name');
            //$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|is_unique[product_categories.cat_name]');
            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
        }
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $insert_id = '';
            $category = $this->input->post('category_main');
            $data['cat_name'] = $name;
            if ($category != 0) {
                $data['parent_cat_id'] = $this->input->post('category_main');
            }
            if ($this->input->post('id') != '') {
                $condition = array(
                    'id_product_category' => $this->input->post('id')
                );
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $this->product_model->update_value('product_categories', $data, $condition);
                $massage = lang('update_success');
            } else {
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $insert_id = $this->product_model->common_insert('product_categories', $data);
                $massage = lang('add_success');
            }
            if ($category == 0) {
                echo json_encode(array("status" => "success", "message" => $massage, 'id' => $insert_id, 'name' => $name));
            } else {
                echo json_encode(array("status" => "success", "message" => $massage));
            }
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
        $cat_name = $this->input->post('cat_name');
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        //total rows count
        $totalRec = count($this->product_model->getRowsCategories($conditions));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product_category/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['categories'] = $this->product_model->getvalue_row('product_categories', 'cat_name,id_product_category', array());
        $data['posts'] = $this->product_model->getRowsCategories($conditions);

        //load the view
        $this->load->view('categories/all_category_data', $data, false);
    }

    public function edit_data($id = null) {
        $data = $this->product_model->get_category_by_id($id);
        echo json_encode($data);
    }

    public function check_cagegory_name() {
        $this->load->database();
        $category_name = $this->input->post('category_name');
        $res = $this->product_model->check_category_name($category_name);
        $val = ($res) ? 'false' : 'true';
        echo $val;
    }

    public function delete_data($id = null) {
        $condition = array(
            'id_product_category' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $val = $this->product_model->check_value('product_categories', 'parent_cat_id', $id);
        $cat = $this->product_model->check_product_cat($id);
        //$val=false;
        if ($val) {
            echo json_encode(array("status" => FALSE));
        }else if($cat){
            echo json_encode(array("status" => FALSE));
        } else {
            $this->product_model->update_value('product_categories', $data, $condition);
            echo json_encode(array("status" => TRUE));
        }
    }

}
