<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rack extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('rack_model');
        $this->perPage = 20;
    }

    public function index() {
        $data = array();
        $this->dynamic_menu->check_menu('rack-settings');
        $this->breadcrumb->add(lang('rack'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $data['records'] = $this->rack_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'TOT_STORES'));
        $data['posts'] = $this->rack_model->getvalue_row('racks', 'id_rack,name', array('status_id' => 1));
        $this->template->load('main', 'rack/index', $data);
    }

    public function test() {
        $condition = array(
            'param_key' => 'TOT_STORES'
        );
        $dataValue = 'utilized_val';
        $test = $this->rack_model->version_update('configs', $dataValue, $condition);
        //pa($test);
        echo $test;
    }

     public function add_data77() {
       $conditions = array();
        if ($this->input->post('id') != '') {
            $name = $this->input->post('rack_name');
            $id_v = $this->input->post('id');
            $this->form_validation->set_rules('rack_name', 'Rack Name', 'trim|required');
            $val = $this->rack_model->isExistExcept('racks', 'name', $name, 'id_rack', $id_v);
            if ($val == 1) {
                echo json_encode(array('rack_name' => lang('name_exist')));
                exit();
            }
        } else {
            $name = $this->input->post('rack_name');
            $this->form_validation->set_rules('rack_name', 'Rack Name', 'trim|required|is_unique[racks.name]');
        }
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $data['name'] = $name;
            if ($this->input->post('id') != '') {
                $condition = array(
                    'id_rack' => $this->input->post('id')
                );
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                // $data['store_id'] = $this->session->userdata['login_info']['store_id'];
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $this->rack_model->update_value('racks', $data, $condition);
                $massage = lang("update_success");
            } else {
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['store_id'] = $this->session->userdata['login_info']['store_id'];
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $this->rack_model->common_insert('racks', $data);
                $condition = array(
                    'param_key' => 'TOT_STORES'
                );
                $dataValue = 'utilized_val';
                // $this->rack_model->version_update('configs', $dataValue, $condition);
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
        $cat_name = $this->input->post('cat_name');
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        //total rows count
        $totalRec = count($this->rack_model->getRowsCategories($conditions));

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
        $data['categories'] = $this->rack_model->getvalue_row('product_categories', 'cat_name,id_product_category', array());
        $data['posts'] = $this->rack_model->getRowsCategories($conditions);

        //load the view
        $this->load->view('categories/all_category_data', $data, false);
    }

    public function edit_data77($id = null) {
        $data = $this->rack_model->get_data_by_id($id);
        echo json_encode($data);
    }
    public function delete_data77($id = null) {
        //$this->rack_model->delete_by_brand($id);
        //echo "data delete successfully";
        $condition = array(
            'id_rack' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->rack_model->update_value('racks', $data, $condition);
        echo json_encode(array("status" => TRUE));
    }

    public function check_station_name() {
        $this->load->database();
        $name = $this->input->post('rack_name');
        $this->db->where('name', $name);
        $this->db->where('status_id', 1);
        $query = $this->db->get('racks');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

}
