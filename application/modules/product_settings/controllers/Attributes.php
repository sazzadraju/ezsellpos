<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attributes extends MX_Controller {

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
        $row = $this->product_model->getRowsAttributes();
        $totalRec = ($row)?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'attributes/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['posts'] = $this->product_model->getRowsAttributes(array('limit' => $this->perPage));
        $this->template->load('main', 'attributes/index', $data);
    }

    public function add_data() {
        $conditions = array();
        if ($this->input->post('id') != '') {
            $name = $this->input->post('attr_name');
            $id_v = $this->input->post('id');
            $this->form_validation->set_rules('attr_name', 'Attribute Name', 'trim|required');
            $val = $this->product_model->isExistExcept('product_attributes', 'attribute_name', $name, 'id_attribute', $id_v);
            if ($val == 1) {
                echo json_encode(array('attr_name' => lang('name_exist')));
                exit();
            }
        } else {
            $name = $this->input->post('attr_name');
            $this->form_validation->set_rules('attr_name', 'Attribute Name', 'trim|required|is_unique[product_attributes.attribute_name]');
        }
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $insert_id = '';
            $attr_val = $this->input->post('attr_val');
            $data['attribute_name'] = $name;
            $data['attribute_value'] = $attr_val;
            if ($this->input->post('id') != '') {
                $condition = array(
                    'id_attribute' => $this->input->post('id')
                );
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $this->product_model->update_value('product_attributes', $data, $condition);
                $massage = lang('update_success');
                $insert_id=1;
            } else {
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $insert_id = $this->product_model->common_insert('product_attributes', $data);
                $massage = lang('add_success');
            }
            if ($insert_id > 0) {
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
        $attr_name = $this->input->post('attr_name');
        if (!empty($attr_name)) {
            $conditions['search']['attr_name'] = $attr_name;
        }
        //total rows count
        $totalRec = count($this->product_model->getRowsAttributes($conditions));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'attributes/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['posts'] = $this->product_model->getRowsAttributes($conditions);

        //load the view
        $this->load->view('attributes/all_attribute_data', $data, false);
    }

    public function edit_data($id = null) {
        $data = $this->product_model->get_attribute_by_id($id);
        echo json_encode($data);
    }


    public function delete_data($id = null) {
        $condition = array(
            'id_attribute' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        //$val=false;
        $rr=$this->product_model->update_value('product_attributes', $data, $condition);
        if($rr)  {
            echo json_encode(array("status" => TRUE));
        }
    }

}
