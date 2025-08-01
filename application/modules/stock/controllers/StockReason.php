<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StockReason extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }

        $this->load->model('stock_in_model');
        $this->perPage = 15;
    }

    public function index() {
        $data = array();
        $this->dynamic_menu->check_menu('stock-reason');
        $this->breadcrumb->add(lang('stock_reason'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $totalRec = count($this->stock_in_model->getRowsReason());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock_reason/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['stock_mvt_type_list'] = $this->stock_in_model->common_cond_single_value_array('stock_mvt_types', 'id_stock_mvt_type', 'type_name','is_active',1, 'id_stock_mvt_type', 'ASC');
        $data['posts'] = $this->stock_in_model->getRowsReason(array('limit' => $this->perPage));
        $this->template->load('main', 'stock_reason/index', $data);
    }
    public function paginate_data() {
        $conditions = array();
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $totalRec = count($this->stock_in_model->getRowsReason());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'stock_reason/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['posts'] = $this->stock_in_model->getRowsReason($conditions);
        $this->load->view('stock_reason/all_reason_data', $data, false);
    }

    public function add_data() {
        // echo json_encode($_POST);
        // exit();
        $conditions = array();
        $reason = $this->input->post('reason_name');

        if ($reason) {
            $data['reason'] = $reason;
            $data['qty_multiplier'] = $this->input->post('qty_multiplier');
            $data['mvt_type_id'] = $this->input->post('category');
            if ($this->input->post('id') != '') {
                $condition = array(
                    'id_stock_mvt_reason' => $this->input->post('id')
                );
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $this->stock_in_model->common_update('stock_mvt_reasons', $data,'id_stock_mvt_reason', $this->input->post('id'));
                $massage = lang("update_success");
            } else {
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $this->stock_in_model->common_insert('stock_mvt_reasons', $data);
                $massage = lang("add_success");
            }

            echo json_encode(array("status" => "success", "message" => $massage));
        }
        
    }
    public function edit_data($id = null) {
        $data = $this->stock_in_model->get_reason_by_id($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }

    public function find_qty($id = null) {
        $data = $this->stock_in_model->get_qty_from_mvt_types($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }

    public function delete_data($id = null) {
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->stock_in_model->common_update('stock_mvt_reasons', $data,'id_stock_mvt_reason', $id);
        echo json_encode(array("status" => TRUE));
    }
    public function check_reason_name() {
        $reason_name = $this->input->post('reason_name');
        $res = $this->stock_in_model->check_value('stock_mvt_reasons', 'reason', $reason_name);
        $val = ($res) ? 'false' : 'true';
        echo $val;
    }

}
