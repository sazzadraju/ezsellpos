<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('change_pass_model');
        $this->perPage = 20;
        $this->form_validation->CI =& $this;
    }

    public function index() {
        $data = array();
        $this->breadcrumb->add(lang('users'), 'employees', 1);
        $this->breadcrumb->add(lang('change-pass'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['records'] = $this->change_pass_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'TOT_STORES'));
        $data['posts'] = $this->change_pass_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
         $data['city_list'] = $this->change_pass_model->common_single_value_array('loc_cities', 'id_city','city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->change_pass_model->common_single_value_array('loc_divisions', 'id_division','division_name_en', 'id_division', 'ASC');
        $this->template->load('main', 'change_password/index', $data);
    }

    public function success() {
      $data = array();
        $this->breadcrumb->add(lang('users'), 'employees', 1);
        $this->breadcrumb->add(lang('change-pass'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['records'] = $this->change_pass_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'TOT_STORES'));
        $data['posts'] = $this->change_pass_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
         $data['city_list'] = $this->change_pass_model->common_single_value_array('loc_cities', 'id_city','city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->change_pass_model->common_single_value_array('loc_divisions', 'id_division','division_name_en', 'id_division', 'ASC');
        $this->template->load('main', 'change_password/index_2', $data);
    }

    public function isStorenameExist($str){

        if($this->change_pass_model->isExistExcept('stores', 'store_name', $str)){
            $this->form_validation->set_message('isStorenameExist', "Stoere Name Exists");
            return FALSE;
        } else{
            return TRUE;
        }
    }

     public function password_change() {
        // echo 'test';
        // var_export($_POST); 
        // exit;
        $old_pass='';
        $Salt='';
           $current_password = $this->input->post('current_password');
            $confirm_password = $this->input->post('confirm_password');
           $user=$this->session->userdata['login_info']['id_user_i90'];
       // $conditions = array();
            // $old_password = $this->change_pass_model->getvalue_row('user',$user);
             $data['pass'] = $this->change_pass_model->getvalue_row('users', 'passwd,salt', array('id_user' =>$user));
        // if ($this->input->post('id') != '') {
foreach ($data['pass'] as $row) {
    $old_pass=$row->passwd;
    $Salt=$row->salt;
}
 $login_password = md5($current_password . $Salt);
 $new_password = md5($confirm_password . $Salt);
  $condition = array(
            'id_user' => $user
        );
 // echo "<pre>";
 // print_r($old_pass);
 // echo "<br>";
 // print_r($Salt);
 //  echo "<br>";
 // print_r($login_password);

 if($login_password == $old_pass){
   $new_pass['passwd']=$new_password;
    $this->change_pass_model->update_value('users', $new_pass, $condition);
    $massage = lang("update_success");
    echo json_encode(array('status'=> 'active', 'message'=>$massage));
   }
 else{
     $massage = lang("update_success");
    echo json_encode(array('status'=> 'inactive'));
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
        $totalRec = count($this->change_pass_model->getRowsCategories($conditions));

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
        $data['categories'] = $this->change_pass_model->getvalue_row('product_categories', 'cat_name,id_product_category', array());
        $data['posts'] = $this->change_pass_model->getRowsCategories($conditions);

        //load the view
        $this->load->view('categories/all_category_data', $data, false);
    }

    public function edit_data($id = null) {
        $data = $this->change_pass_model->get_data_by_id($id);
        echo json_encode($data);
    }

    public function delete_data($id = null) {
        //$this->change_pass_model->delete_by_brand($id);
        //echo "data delete successfully";
        $condition = array(
            'id_store' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->change_pass_model->update_value('stores', $data, $condition);
        $condition = array(
            'param_key' => 'TOT_STORES'
        );
        $dataValue = 'utilized_val';
        $this->change_pass_model->version_delete('configs', $dataValue, $condition);
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
            $result = $this->change_pass_model->common_cond_single_value_array('loc_districts', 'id_district','district_name_en', 'division_id', $id, 'id_district', 'ASC');
            if($result){
                echo json_encode($result);
            }
        }

        public function get_city_location()
        {
            $id = $this->input->post('id');
            $result = $this->change_pass_model->common_cond_single_value_array('loc_areas', 'id_area','area_name_en', 'city_id', $id, 'id_area', 'ASC');
            if($result){
                echo json_encode($result);
            }
        }

         public function details_data($id_store = null) {
        // echo json_encode('hasib ahmed');
        $data = $this->change_pass_model->get_store_details_by_id($id_store);
        echo json_encode($data);
    }


}
