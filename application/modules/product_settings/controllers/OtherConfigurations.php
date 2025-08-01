<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class otherConfigurations extends MX_Controller {

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
        $this->dynamic_menu->check_menu('products/other-configuration');
        $this->breadcrumb->add(lang('products'), 'products', 1);
        $this->breadcrumb->add(lang('other_configuration'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->product_model->getRowsUnits();
        $totalRec = ($row)?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product_categories/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['vat'] = $this->product_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        $data['posts'] = $this->product_model->getRowsUnits(array('limit' => $this->perPage));
        $this->template->load('main', 'otherConfigarations/index', $data);
    }

    public function add_data() {
        $conditions = array();
        if ($this->input->post('id') != '') {
            $name=$this->input->post('name');
            $id_v=$this->input->post('id');
            $this->form_validation->set_rules('name', 'Type Name', 'trim|required');
            $val=$this->product_model->isExistExcept('product_units', 'unit_code',$name,'id_product_unit',$id_v);
            if($val){
                echo json_encode(array('name'=>lang('name_exist')));
                exit();
            }  
        } else {
            $name=$this->input->post('unit_type_name');
            $this->form_validation->set_rules('unit_type_name', 'Type Name', 'trim|required|is_unique[product_units.unit_code]');
        }
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            //$name = $this->input->post('unit_type_name');
            $data['unit_code'] = $name;
            if ($this->input->post('id') != '') {
                $condition = array(
                    'id_product_unit' => $this->input->post('id')
                );
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $this->product_model->update_value('product_units', $data, $condition);
                $massage = lang("update_success");
            } else {
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $this->product_model->common_insert('product_units', $data);
                $massage = lang("add_success");
            }

            echo json_encode(array("status" => "success", "message" => $massage));
        }
    }

    public function checkUnitType() {
        $this->load->database();
        $unit_type = $this->input->post('unit_type_name');
        $this->db->where('unit_code', $unit_type);
        $this->db->where('status_id', 1);
        $query = $this->db->get('product_units');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
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
        $totalRec = count($this->product_model->getRowsUnits($conditions));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'otherConfiguration/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['vat'] = $this->product_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        $data['posts'] = $this->product_model->getRowsUnits($conditions);

        //load the view
        $this->load->view('otherConfigarations/all_configure_data', $data, false);
    }

    public function edit_data($id = null) {
        $data = $this->product_model->get_unit_by_id($id);
        echo json_encode($data);
    }

    public function edit_vat() {
        $vat = $this->input->post('vat');
        $condition = array(
            'param_key' => 'DEFAULT_VAT'
        );
        $data['param_val'] = $vat;
        $this->product_model->update_value('configs', $data, $condition, FALSE);
        echo $vat;
        //echo json_encode(array("success" => TRUE, "data"=>$vat,"Message"=>''));
    }

    public function delete_data($id = null) {
        $condition = array(
            'id_product_unit' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->product_model->update_value('product_units', $data, $condition);
        echo json_encode(array("status" => TRUE));
    }
    public function isExistExcept($table, $chk_column, $chk_value, $expt_column, $expt_value) {
        $name=$this->product_model->isExistExcept($table, $chk_column, $chk_value, $expt_column, $expt_value);
        if ($name) {
            $this->form_validation->set_message('name', 'Please choose any one');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
   public function name_function()
    {
        $this->form_validation->set_message('name_function', 'Hello World !');
        return FALSE;
    }

}
