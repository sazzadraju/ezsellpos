<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }
        $this->load->model('user_model');
        $this->perPage = 20;
    }

    public function index()
    {
        $this->dynamic_menu->check_menu('employees');
        $data = array();
        $this->breadcrumb->add('Employees', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $totalRec = count($this->user_model->getRowsEmployees());

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'employee/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['totalUser'] = $this->user_model->getvalue_row_one('configs', 'param_val,utilized_val', array('param_key' => 'TOT_USERS'));
        $data['city_list'] = $this->user_model->common_single_value_array('loc_cities', 'id_city', 'city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->user_model->common_single_value_array('loc_divisions', 'id_division', 'division_name_en', 'id_division', 'ASC');
        $data['stations'] = $this->user_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $data['stores'] = $this->user_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['types'] = $this->user_model->getvalue_row('user_types', 'id_user_type,type_name', array('status_id' => 1));
        $data['posts'] = $this->user_model->getRowsEmployees(array('limit' => $this->perPage));
        $this->template->load('main', 'employees/index', $data);
    }

    public function user_access($id = null)
    {
        if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
            $data = array();
            $this->breadcrumb->add(lang('users'), 'employees', 1);
            $this->breadcrumb->add(lang('user_access_contorll'), '', 0);
            $data['breadcrumb'] = $this->breadcrumb->output();
            $data['id'] = $id;
            $data['accessMenus'] = $this->user_model->getvalue_row('acl_modules', '*', array('status_id' => 1));
            $data['accessPages'] = $this->user_model->getvalue_row('acl_pages', '*', array('status_id' => 1));
            if ($this->input->post('sub_acc')) {
                $this->user_model->delete_data('acl_user_modules', array('user_id' => $id));
                $this->user_model->delete_data('acl_user_pages', array('user_id' => $id));
                $parent = $this->input->post('parent');
                $child = $this->input->post('child');
                $pages = $this->input->post('menu_page');
                $trangection = $this->input->post('tr_page');
                if (!empty($parent)) {
                    foreach ($parent as $check) {
                        $dataArray = array(
                            'user_id' => $this->input->post('id'),
                            'module_id' => $check
                        );
                        $result = $this->user_model->common_insert('acl_user_modules', $dataArray);
                    }
                }
                if (!empty($child)) {
                    foreach ($child as $key => $value) {
                        for ($i = 0; $i < count($value); $i++) {
                            $dataArray = array(
                                'user_id' => $this->input->post('id'),
                                'module_id' => $key,
                                'submodule_id' => $value[$i]
                            );
                            $result = $this->user_model->common_insert('acl_user_modules', $dataArray);
                        }
                    }
                    if (isset($pages)) {
                        foreach ($pages as $page) {
                            $dataArray = array(
                                'user_id' => $this->input->post('id'),
                                'page_id' => $page
                            );
                            $result = $this->user_model->common_insert('acl_user_pages', $dataArray);
                        }
                    }
                    if (isset($trangection)) {
                        foreach ($trangection as $trn) {
                            $dataArray = array(
                                'user_id' => $this->input->post('id'),
                                'submodule_id' => 47,
                                'page_name' => $trn,
                            );
                            $result = $this->user_model->common_insert('acl_user_pages', $dataArray);
                        }
                    }
                    $this->session->set_flashdata('message', lang('add_success'));
                    redirect('employees', 'refresh');
                }
            }
            $data['accessModules'] = $this->user_model->acl_gorup_module_id($id);
            $data['accessSubModules'] = $this->user_model->getvalue_row('acl_access_submodule', 'id_acl_module', array('user_id' => $id));
            $data['accessSubModulePages'] = $this->user_model->getvalue_row('acl_access_pages', 'page_id,module_id', array('user_id' => $id));
            $data['userPages'] = $this->user_model->getvalue_row('acl_user_pages', '*', array('user_id' => $id));
            $this->template->load('main', 'employees/user_access', $data);
        } else {
            redirect('employees', 'refresh');
        }
    }

    public function paginate_data()
    {
        $conditions = array();
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $full_name = $this->input->post('sr_full_name');
        $email = $this->input->post('sr_email');
        $phone = $this->input->post('sr_phone');
        $sr_type = $this->input->post('sr_type');

        if (!empty($full_name)) {
            $conditions['search']['full_name'] = $full_name;
        }
        if (!empty($email)) {
            $conditions['search']['email'] = $email;
        }
        if (!empty($phone)) {
            $conditions['search']['phone'] = $phone;
        }
        if (!empty($sr_type)) {
            $conditions['search']['sr_type'] = $sr_type;
        }
        $totalRec = count($this->user_model->getRowsEmployees($conditions));
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'employee/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['stations'] = $this->user_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $data['types'] = $this->user_model->getvalue_row('user_types', 'id_user_type,type_name', array('status_id' => 1));
        $data['posts'] = $this->user_model->getRowsEmployees($conditions);
        $this->load->view('employees/all_employee_data', $data, false);
    }

    public function check_employee_email()
    {
        $this->load->database();
        $emp_email = $this->input->post('emp_email');
        $this->db->where('email', $emp_email);
        $query = $this->db->get('users');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function check_employee_username()
    {
        $this->load->database();
        $emp_username = $this->input->post('emp_username');
        $this->db->where('uname', $emp_username);
        $this->db->where('status_id', 1);
        $query = $this->db->get('users');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function add_employee_info()
    {
        $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('user_type', 'Type', 'trim|required');
        $this->form_validation->set_rules('emp_email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        if ($this->input->post('access') == 'Yes') {
            $this->form_validation->set_rules('emp_username', 'User Name', 'trim|required|min_length[3]|is_unique[users.uname]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        }
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $filename = '';
            if ($_FILES['userfile']['name'] != '') {
                $filename = upload_file('user', $_FILES['userfile']);
            }
            $data['fullname'] = $this->input->post('name');
            $data['user_type_id'] = $this->input->post('user_type');
            $data['email'] = $this->input->post('emp_email');
            $data['mobile'] = $this->input->post('phone');
            $data['job_title'] = $this->input->post('job_title');
            $data['birth_date'] = $this->input->post('dob');
            $data['join_date'] = $this->input->post('joining_date');
            $data['salary'] = $this->input->post('salary');
            $data['station_id'] = $this->input->post('category');
            $data['div_id'] = $this->input->post('division_id');
            $data['dist_id'] = $this->input->post('district_id');
            $data['city_id'] = $this->input->post('city_id');
            $data['area_id'] = $this->input->post('city_location_id');
            $data['nid'] = $this->input->post('nid');
            $data['addr_line_1'] = $this->input->post('addr_line');
            $data['store_id'] = $this->input->post('store_name');
            $data['profile_img'] = $filename;
            $user_count = 1;
            if ($this->input->post('access') == 'Yes') {
                $data['uname'] = $this->input->post('emp_username');
                $salt = rand(100000000, 999999999);
                $pass = $this->input->post('password') . $salt;
                $data['passwd'] = md5($pass);
                $data['salt'] = $salt;
                $user_count = 2;
                $this->commonmodel->update_balance_amount('configs', 'utilized_val', 1, '+', array('param_key' => 'TOT_USERS'));
            }
            if ($this->input->post('blood_group') != '0') {
                $data['blood_group'] = $this->input->post('blood_group');
            }
            $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $user_id = $this->user_model->common_insert('users', $data);
            echo json_encode(array("status" => "success", "message" => lang("add_success"), "count" => $user_count));

        }
    }

    public function edit_employee_info()
    {
        $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {

            $filename = '';
            $old_image=$this->input->post('image_id');
            if ($_FILES['userfile']['name'] != '') {
                if($old_image != ''){
                    delete_file('user', $old_image);
                }
                $filename = upload_file('user', $_FILES['userfile']);
            } else {
                $filename = $old_image;
            }
            $data['fullname'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['mobile'] = $this->input->post('phone');
            $data['job_title'] = $this->input->post('job_title');
            $data['birth_date'] = $this->input->post('dob');
            $data['join_date'] = $this->input->post('joining_date');
            $data['salary'] = $this->input->post('salary');
            $data['store_id'] = $this->input->post('store_name');
            $data['station_id'] = $this->input->post('category');
            $data['addr_line_1'] = $this->input->post('addr_line');
            $data['div_id'] = $this->input->post('division_id');
            $data['dist_id'] = $this->input->post('district_id');
            $data['city_id'] = $this->input->post('city_id');
            $data['area_id'] = $this->input->post('city_location_id');
            $data['nid'] = $this->input->post('emp_nid');
            $data['addr_line_1'] = $this->input->post('addr_line');
            $data['profile_img'] = $filename;
            if ($this->input->post('emp_blood_group') != '0') {
                $data['blood_group'] = $this->input->post('emp_blood_group');
            }
            //$data['store_id'] = 3;
            $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
            $data['dtt_mod'] = date('Y-m-d H:i:s');
            $condition = array(
                'id_user' => $this->input->post('employee_id')
            );
            $this->user_model->update_value('users', $data, $condition);
            echo json_encode(array("status" => "success", "message" => lang("update_success")));
        }
    }

    public function employee_details($id = null)
    {
        $this->dynamic_menu->check_menu('employees');
        $this->breadcrumb->add('Employees', 'employees', 1);
        $this->breadcrumb->add('Employee Details', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['employee_info'] = $this->user_model->get_employee_details($id);
        $data['city_list'] = $this->user_model->common_single_value_array('loc_cities', 'id_city', 'city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->user_model->common_single_value_array('loc_divisions', 'id_division', 'division_name_en', 'id_division', 'ASC');
        $data['stations'] = $this->user_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $data['stores'] = $this->user_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['types'] = $this->user_model->getvalue_row('user_types', 'id_user_type,type_name', array('status_id' => 1));
        $data['posts'] = $this->user_model->get_employee_document_result($id);
        $this->template->load('main', 'employees/employee_details', $data);
    }

    public function edit_employee_data($id = null)
    {
        $data = $this->user_model->get_employee_by_id($id);
        echo json_encode($data);
    }

    public function delete_employee_data($id = null)
    {
        //$this->user_model->delete_by_brand($id);
        //echo "data delete successfully";
        $condition = array(
            'id_user' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $upd = $this->user_model->update_value('users', $data, $condition);
        $user_count = 1;
        $is_user = $this->user_model->is_user($id);
        if ($is_user==2) {
            $user_count = 2;
            $this->commonmodel->update_balance_amount('configs', 'utilized_val', 1, '-', array('param_key' => 'TOT_USERS'));
        }
        echo json_encode(array("status" => TRUE, 'count' => $user_count));
    }

    public function add_employee_document()
    {
        $data['doc_type'] = 'User';
        $data['ref_id'] = $this->input->post('id_user');
        $data['name'] = $this->input->post('document_name');
        $data['description'] = $this->input->post('document_description');
        $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_add'] = date('Y-m-d H:i:s');
        if ($_FILES['document_file']['name']!='') {
            $filename = upload_file('user', $_FILES['document_file']);
            $data['file']=$filename;
        }

        $result = $this->user_model->common_insert('documents', $data);
        if ($result) {
            echo json_encode(array("status" => "success", "message" => "Suppliers document added successfully", "user_id" => $this->input->post('id_user')));
        }
        //echo json_encode(array("status" => "success", "message" =>$this->input->post('user_id').$this->input->post('document_name') ,"user_id" => $this->input->post('user_id')));
    }

    public function employee_document_pagination()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        $user_id = $this->input->post('user_id');
        if (!empty($user_id)) {
            $conditions['search']['user_id'] = $user_id;
        }
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        //total rows count
        $totalRec = count($this->user_model->get_employee_document_result_pagination($conditions));
        //pagination configuration
        $config['target'] = '#documentList';
        $config['base_url'] = base_url() . 'employees/employee_document_pagination';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterDocument';
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['posts'] = $this->user_model->get_employee_document_result_pagination($conditions);
        $this->load->view('employees/employee_document_pagination', $data, false);
    }

    public function edit_employee_doc_by_id()
    {
        $id = $this->input->post('id');
        $data = $this->user_model->get_employee_document_by_id($id);
        echo json_encode($data);
    }

    public function update_employee_document()
    {
        $id = $this->input->post('edit_employee_document_id');
        $data['name'] = $this->input->post('document_name');
        $data['description'] = $this->input->post('document_description');
        $old_employee_doc = $this->input->post('old_employee_doc');
        $version = $this->input->post('version');
        $data['version'] = $version + 1;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        if ($_FILES['edit_document_file']['name']!='') {
            if($old_employee_doc != ''){
                delete_file('user', $old_employee_doc);
            }
            $filename = upload_file('user', $_FILES['edit_document_file']);
            $data['file']=$filename;
        }
        $condition = array(
            'id_document' => $id
        );
        $result = $this->user_model->update_value('documents', $data, $condition);
        if ($result) {
            echo json_encode(array("status" => "success", "message" => "Suppliers document updated successfully"));
        }
    }

    public function delete_employee_document_data()
    {
        $id = $this->input->post('id');
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $condition = array(
            'id_document' => $id
        );
        $this->user_model->update_value('documents', $data, $condition);
        echo json_encode(array("status" => TRUE));
    }

    public function get_district()
    {
        $id = $this->input->post('id');
        $result = $this->user_model->common_cond_single_value_array('loc_districts', 'id_district', 'district_name_en', 'division_id', $id, 'id_district', 'ASC');
        if ($result) {
            echo json_encode($result);
        }
    }

    public function get_city_location()
    {
        $id = $this->input->post('id');
        $result = $this->user_model->common_cond_single_value_array('loc_areas', 'id_area', 'area_name_en', 'city_id', $id, 'id_area', 'ASC');
        if ($result) {
            echo json_encode($result);
        }
    }

    public function get_stations_by_store()
    {
        $id = $this->input->post('id');
        $result = $this->user_model->common_cond_single_value_array('stations', 'name', 'id_station', 'store_id', $id, 'name', 'ASC');
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(array('status' => 3));
        }
    }

    public function error_msg()
    {
        $this->template->load('main', 'employees/error');
    }

}
