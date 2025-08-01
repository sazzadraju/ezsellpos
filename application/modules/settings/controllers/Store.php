<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('store_model');
        $this->perPage = 20;
        $this->form_validation->CI =& $this;
    }

    public function index() {
        $this->dynamic_menu->check_menu('store-settings');
        $data = array();
        $this->breadcrumb->add(lang('store'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['records'] = $this->store_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'TOT_STORES'));
        $data['posts'] = $this->store_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
         $data['city_list'] = $this->store_model->common_single_value_array('loc_cities', 'id_city','city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->store_model->common_single_value_array('loc_divisions', 'id_division','division_name_en', 'id_division', 'ASC');
        $this->template->load('main', 'store/index', $data);
    }

    public function test() {
        $condition = array(
            'param_key' => 'TOT_STORES'
        );
        $dataValue = 'utilized_val';
        $test = $this->store_model->version_update('configs', $dataValue, $condition);
        //pa($test);
        echo $test;
    }

    public function isStorenameExist($str){

        if($this->store_model->isExistExcept('stores', 'store_name', $str)){
            $this->form_validation->set_message('isStorenameExist', "Stoere Name Exists");
            return FALSE;
        } else{
            return TRUE;
        }
    }

     public function add_data77() {
        // var_export($_POST); exit;

       $conditions = array();

        if ($this->input->post('id') != '') {

            $name = $this->input->post('store_name');
            $id_v = $this->input->post('id');
            $this->form_validation->set_rules('store_name', 'Store Name', 'trim|required');
            $val = $this->store_model->isExistExcept('stores', 'store_name', $name, 'id_store', $id_v);
            if ($val == 1) {
                echo json_encode(array('store_name' => lang('name_exist')));
                exit();
            }
        } else {
            $name = $this->input->post('store_name');
            //$this->form_validation->set_rules('store_name', 'Store Name', "trim|required|is_unique[stores.store_name]");
            $this->form_validation->set_rules('store_name', 'Store Name', "trim|required|callback_isStorenameExist");
        }
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $filename = '';
            $file_count=1;
            $newFileName = $_FILES['userfile']['name'];
            if ($newFileName != '') {
                $doc_file = upload_file('user', $_FILES['userfile']);
                 if($doc_file) {
                    $data['store_img'] = $doc_file;
                }
            }
            if($file_count==1){
                $data['store_name'] = $name;
                $data['description'] = $this->input->post('description');
                $data['mobile'] = $this->input->post('mobile_no');
                $data['email'] = $this->input->post('email');
                $data['address_line'] = $this->input->post('address');
                $data['post_code'] = $this->input->post('post_code');
                $data['div_id'] = $this->input->post('division_id');
                $data['dist_id'] = $this->input->post('district_id');
                $data['city_id'] = $this->input->post('city_id');
                $data['vat_reg_no'] = $this->input->post('reg_no');
                $data['area_id'] = $this->input->post('city_location_id');
                if ($this->input->post('id') != '') {
                    $condition = array(
                        'id_store' => $this->input->post('id')
                    );
                    $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                    // $data['store_id'] = $this->session->userdata['login_info']['store_id'];
                    $data['dtt_mod'] = date('Y-m-d H:i:s');
                    $this->store_model->update_value('stores', $data, $condition);
                    $massage = lang("update_success");
                } else {
                    // echo "<pre>";
                    // print_r($_POST);
                    $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    // $data['store_id'] = $this->session->userdata['login_info']['store_id'];
                    $data['dtt_add'] = date('Y-m-d H:i:s');
                    $data['description'] = $this->input->post('description');
                    $data['mobile'] = $this->input->post('mobile_no');
                    $data['email'] = $this->input->post('email');
                    $data['address_line'] = $this->input->post('address');
                    $data['post_code'] = $this->input->post('post_code');
                    $data['div_id'] = $this->input->post('division_id');
                    $data['dist_id'] = $this->input->post('district_id');
                    $data['city_id'] = $this->input->post('city_id');
                    $data['area_id'] = $this->input->post('city_location_id');

                    $insert_id=$this->store_model->common_insert('stores', $data);
                    $station=array(
                        'name'      =>$name.'-primary',
                        'store_id'  =>$insert_id,
                        'dtt_add'  =>date('Y-m-d H:i:s'),
                        'uid_add'  =>$this->session->userdata['login_info']['id_user_i90']
                        );
                    $station_id=$this->store_model->common_insert('stations', $station);
                    $account=array(
                        'account_name'      =>$name.'-primary',
                        'acc_type_id'  =>4,
                        'acc_uses_id'  =>3,
                        'station_id'  =>$station_id,
                        'dtt_add'  =>date('Y-m-d H:i:s'),
                        'uid_add'  =>$this->session->userdata['login_info']['id_user_i90']
                    );
                    $account_id=$this->store_model->common_insert('accounts', $account);
                    $this->store_model->common_insert('accounts_stores', array('account_id'=>$account_id,'store_id'=>$insert_id));
                    $condition = array(
                        'param_key' => 'TOT_STORES'
                    );
                    $dataValue = 'utilized_val';
                    $this->store_model->version_update('configs', $dataValue, $condition);
                    $massage = lang("add_success");
                }
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
        $totalRec = count($this->store_model->getRowsCategories($conditions));

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
        $data['categories'] = $this->store_model->getvalue_row('product_categories', 'cat_name,id_product_category', array());
        $data['posts'] = $this->store_model->getRowsCategories($conditions);

        //load the view
        $this->load->view('categories/all_category_data', $data, false);
    }

    public function edit_data($id = null) {
        $data = $this->store_model->get_data_by_id($id);
        echo json_encode($data);
    }

    public function delete_data($id = null) {
        //$this->store_model->delete_by_brand($id);
        //echo "data delete successfully";
        $condition = array(
            'id_store' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->store_model->update_value('stores', $data, $condition);
        $condition = array(
            'param_key' => 'TOT_STORES'
        );
        $dataValue = 'utilized_val';
        $this->store_model->version_delete('configs', $dataValue, $condition);
        echo json_encode(array("status" => TRUE));
    }

    public function check_station_name() {
        $this->load->database();
        $name = $this->input->post('store_name');
        $this->db->where('store_name', $name);
        $this->db->where('status_id', 1);
        $query = $this->db->get('stores');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
    public function get_district()
        {
            $id = $this->input->post('id');
            $result = $this->store_model->common_cond_single_value_array('loc_districts', 'id_district','district_name_en', 'division_id', $id, 'id_district', 'ASC');
            if($result){
                echo json_encode($result);
            }
        }

        public function get_city_location()
        {
            $id = $this->input->post('id');
            $result = $this->store_model->common_cond_single_value_array('loc_areas', 'id_area','area_name_en', 'city_id', $id, 'id_area', 'ASC');
            if($result){
                echo json_encode($result);
            }
        }

         public function details_data($id_store = null) {
        // echo json_encode('hasib ahmed');
        $data = $this->store_model->get_store_details_by_id($id_store);
        echo json_encode($data);
    }


}
