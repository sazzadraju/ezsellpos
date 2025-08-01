<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stations extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('user_model');
        $this->perPage = 20;
    }

    public function index() {
        $data = array();
        $this->breadcrumb->add(lang('users'), 'employees', 1);
        $this->breadcrumb->add(lang('stations'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['records'] = $this->user_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'TOT_STATIONS'));
        $data['posts'] = $this->user_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $this->template->load('main', 'stations/index', $data);
    }

    public function test() {
        $condition = array(
            'param_key' => 'TOT_STATIONS'
        );
        $dataValue = 'utilized_val';
        $test = $this->user_model->version_update('configs', $dataValue, $condition);
        //pa($test);
        echo $test;
    }

    public function add_data() {
        $conditions = array();
        if ($this->input->post('id') != '') {
            $name = $this->input->post('st_name');
            $id_v = $this->input->post('id');
            $this->form_validation->set_rules('st_name', 'Station Name', 'trim|required');
            $val = $this->user_model->isExistExcept('stations', 'name', $name, 'id_station', $id_v);
            if ($val == 1) {
                echo json_encode(array('st_name' => lang('name_exist')));
                exit();
            }
        } else {
            $name = $this->input->post('station_name');
            $this->form_validation->set_rules('station_name', 'Station Name', 'trim|required|is_unique[stations.name]');
        }
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $data['name'] = $name;
            if ($this->input->post('id') != '') {
                $condition = array(
                    'id_Station' => $this->input->post('id')
                );
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['store_id'] = $this->session->userdata['login_info']['store_id'];
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $this->user_model->update_value('stations', $data, $condition);
                $massage = lang("update_success");
            } else {
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['store_id'] = $this->session->userdata['login_info']['store_id'];
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $this->user_model->common_insert('stations', $data);
                $condition = array(
                    'param_key' => 'TOT_STATIONS'
                );
                $dataValue = 'utilized_val';
                $this->user_model->version_update('configs', $dataValue, $condition);
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
        $totalRec = count($this->user_model->getRowsCategories($conditions));

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
        $data['categories'] = $this->user_model->getvalue_row('product_categories', 'cat_name,id_product_category', array());
        $data['posts'] = $this->user_model->getRowsCategories($conditions);

        //load the view
        $this->load->view('categories/all_category_data', $data, false);
    }

    public function edit_data($id = null) {
        $data = $this->user_model->get_data_by_id($id);
        echo json_encode($data);
    }

    public function delete_data($id = null) {
        //$this->user_model->delete_by_brand($id);
        //echo "data delete successfully";
        $condition = array(
            'id_station' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->user_model->update_value('stations', $data, $condition);
        $condition = array(
            'param_key' => 'TOT_STATIONS'
        );
        $dataValue = 'utilized_val';
        $this->user_model->version_delete('configs', $dataValue, $condition);
        echo json_encode(array("status" => TRUE));
    }

    public function check_station_name() {
        $this->load->database();
        $name = $this->input->post('station_name');
        $this->db->where('name', $name);
        $this->db->where('status_id', 1);
        $query = $this->db->get('stations');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

}
