<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_settings extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->form_validation->CI = &$this;

        if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->perPage = 20;

        $this->load->model('Supplier_settings_model');
    }


    //**Supplier Settings::**//
    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('suppliers');
        $this->breadcrumb->add('Suppliers', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->Supplier_settings_model->all_supplier_list();
        $totalRec = ($row)?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'supplier_info_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['posts'] = $this->Supplier_settings_model->all_supplier_list(array('limit' => $this->perPage));
        //dropdown data
        $data['city_list'] = $this->Supplier_settings_model->common_single_value_array('loc_cities', 'id_city', 'city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->Supplier_settings_model->common_single_value_array('loc_divisions', 'id_division', 'division_name_en', 'id_division', 'ASC');
        $data['store_list'] = $this->Supplier_settings_model->common_single_value_array('stores', 'id_store', 'store_name', 'id_store', 'ASC');
        $data['customer_type_list'] = $this->Supplier_settings_model->common_cond_dropdown_data('customer_types', 'id_customer_type', 'name', 'status_id', '1', 'id_customer_type', 'ASC');
        $this->template->load('main', 'supplier_settings/supplier_list', $data);
    }

    public function supplier_info_data()
    {
        $conditions = array();
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $name_supplier = $this->input->post('name_supplier');
        if (!empty($name_supplier)) {
            $conditions['search']['name_supplier'] = $name_supplier;
        }
        $phone_supplier = $this->input->post('phone_supplier');
        if (!empty($phone_supplier)) {
            $conditions['search']['phone_supplier'] = $phone_supplier;
        }

        $email_supplier = $this->input->post('email_supplier');
        if (!empty($email_supplier)) {
            $conditions['search']['email_supplier'] = $email_supplier;
        }
        $inactive_supplier = $this->input->post('inactive_supplier');
        if ($inactive_supplier==1) {
            $conditions['search']['inactive_supplier'] = $inactive_supplier;
        }

        $totalRec = count($this->Supplier_settings_model->all_supplier_list($conditions));
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'supplier_info_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['posts'] = $this->Supplier_settings_model->all_supplier_list($conditions);
        $this->load->view('supplier_settings/supplier_info_data', $data, false);
    }
    public function create_csv_data()
    {
        $conditions=array();
        $name_supplier = $this->input->post('name_supplier');
        if (!empty($name_supplier)) {
            $conditions['search']['name_supplier'] = $name_supplier;
        }

        $phone_supplier = $this->input->post('phone_supplier');
        if (!empty($phone_supplier)) {
            $conditions['search']['phone_supplier'] = $phone_supplier;
        }

        $email_supplier = $this->input->post('email_supplier');
        if (!empty($email_supplier)) {
            $conditions['search']['email_supplier'] = $email_supplier;
        }
        $inactive_supplier = $this->input->post('inactive_supplier');
        if ($inactive_supplier==1) {
            $conditions['search']['inactive_supplier'] = $inactive_supplier;
        }
        //total rows count
        $posts = $this->Supplier_settings_model->all_supplier_list($conditions);
        $fields = array(
            'supplier_name' => 'Supplier Name'
        , 'phone' => 'Phone Number'
        , 'email' => 'Email'
        , 'address' => 'Address'
        , 'dues' => 'Dues'
        , 'advance' => 'Advance'
        );
        $tot_amount=0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $value[] = array(
                    'supplier_name' => $post['supplier_name']
                , 'phone' => $post['phone']
                , 'email' => $post['email']
                , 'address' => $post['addr_line_1']
                , 'dues' => $post['balance']
                , 'advance' => $post['credit_balance']
                );
                $count++;
            }
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'Supplier_list'
        , 'file_title' => 'Supplier List'
        , 'field_title' => $fields
        , 'field_data' => $value
        , 'from' => ''
        , 'to' => ''
        );
        $data = json_encode($dataArray);
        $token=rand();
        $re=array(
            'token'=>$token
        ,'value'=>$data
        ,'date'=>date('Y-m-d')
        );
        $id=$this->commonmodel->common_insert('csv_report',$re);
        echo json_encode(array('id'=>$id,'token'=>$token));
    }

    public function checkSupplierCode()
    {
        $this->load->database();
        $supplier_code = $this->input->post('supplier_code');
        $this->db->where('supplier_code', $supplier_code);
        $query = $this->db->get('suppliers');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }

    }

    public function create_supplier()
    {
        $this->form_validation->set_rules('supplier_code', 'Supplier code', 'trim|required|callback_is_unique_supplier');
        $this->form_validation->set_rules('full_name', 'Fullname', 'trim|required');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_numeric');

        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $store_id = $this->input->post('store_id');
            $data['supplier_code'] = $this->input->post('supplier_code');
            $data['supplier_name'] = $this->input->post('full_name');
            $data['contact_person'] = $this->input->post('contact_person');
            $data['email'] = $this->input->post('s_email');
            $data['phone'] = $this->input->post('phone');
            $data['div_id'] = $this->input->post('division_id');
            $data['dist_id'] = $this->input->post('district_id');
            $data['city_id'] = $this->input->post('city_id');
            $data['area_id'] = $this->input->post('city_location_id');
            $data['addr_line_1'] = $this->input->post('s_addr_line_1');
            $data['note'] = $this->input->post('note');
            $data['vat_reg_no'] = $this->input->post('vat_reg_no');
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $data['status_id'] = '1';
            $data['version'] = '1';
            if ($_FILES['profile_img']['name']!='') {
                $filename = upload_file('supplier', $_FILES['profile_img']);
                $data['profile_img'] = $filename;
            }
            $supplier_id = $this->Supplier_settings_model->common_insert('suppliers', $data);

            if (!empty($store_id)) {
                for ($i = 0; $i < count($store_id); $i++) {
                    $data_store['supplier_id'] = $supplier_id;
                    $data_store['store_id'] = $store_id[$i];
                    $data_store['status_id'] = 1;
                    $data_store['dtt_add'] = date('Y-m-d H:i:s');
                    $data_store['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $data_store['version'] = '1';
                    $supplier_store_id = $this->Supplier_settings_model->common_insert('supplier_stores', $data_store);
                }
            }
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }


    }

    public function delete_supplier_info()
    {
        $id = $this->input->post('id');
        $data['status_id'] = 2;
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $result = $this->Supplier_settings_model->common_update('suppliers', $data, 'id_supplier', $id);
        if ($result) {
            echo json_encode(array("status" => TRUE));
        }

    }

    public function delete_supplier_payment_alert_info()
    {
        $id = $this->input->post('id');
        $data['status_id'] = 2;
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $result = $this->Supplier_settings_model->common_update('supplier_payment_alerts', $data, 'id_supplier_payment_alert', $id);
        if ($result) {
            echo json_encode(array("status" => TRUE));
        }

    }

    public function editSupplierInfo()
    {
        $id = $this->input->post('id');
        $result = $this->Supplier_settings_model->common_cond_row_array('suppliers', 'id_supplier', $id);
        $store = $this->Supplier_settings_model->get_store();
        $supplier_store = $this->Supplier_settings_model->get_supplier_store($id);

        if (!empty($result)) {
            echo json_encode(array("result" => $result, "store" => $store, "supplier_store" => $supplier_store));
        } else {
            echo "0";
        }
    }

    public function update_supplier_info()
    {
        $this->form_validation->set_rules('edit_full_name', 'Fullname', 'trim|required');
        $this->form_validation->set_rules('edit_contact_person', 'Contact Person', 'trim|required');
        $this->form_validation->set_rules('edit_phone', 'Phone', 'trim|required|is_numeric');

        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $store_id = $this->input->post('edit_store_id');
            $id = $this->input->post('supplier_id');
            $old_supplier_photo = $this->input->post('old_supplier_photo');
            $this->commonmodel->commonDelete('supplier_stores', 'supplier_id', $id);
            if (!empty($store_id)) {
                for ($s = 0; $s < count($store_id); $s++) {
                    $store_data['supplier_id'] = $id;
                    $store_data['store_id'] = $store_id[$s];
                    $store_data['status_id'] = 1;
                    $store_data['dtt_add'] = date('Y-m-d H:i:s');
                    $store_data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $insert_store_result = $this->Supplier_settings_model->common_insert('supplier_stores', $store_data);
                }
            }
            if ($_FILES['edit_profile_img']['name']!='') {
                if($old_supplier_photo != ''){
                    delete_file('supplier', $old_supplier_photo);
                }
                $filename = upload_file('supplier', $_FILES['edit_profile_img']);
                $data['profile_img'] = $filename;
            }
            $data['supplier_code'] = $this->input->post('edit_supplier_code');
            $data['supplier_name'] = $this->input->post('edit_full_name');
            $data['contact_person'] = $this->input->post('edit_contact_person');
            $data['email'] = $this->input->post('edit_s_email');
            $data['phone'] = $this->input->post('edit_phone');
            $data['addr_line_1'] = $this->input->post('edit_s_addr_line_1');
            $data['div_id'] = $this->input->post('division_id');
            $data['dist_id'] = $this->input->post('district_id');
            $data['city_id'] = $this->input->post('city_id');
            $data['area_id'] = $this->input->post('city_location_id');
            $data['dtt_mod'] = date('Y-m-d H:i:s');
            $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
            $result = $this->Supplier_settings_model->common_update('suppliers', $data, 'id_supplier', $id);
            if ($result) {
                echo json_encode(array("status" => "success", "message" => lang('update_success')));
            }
        }

    }

    public function get_district()
    {
        $id = $this->input->post('id');
        $result = $this->Supplier_settings_model->common_cond_single_value_array('loc_districts', 'id_district', 'district_name_en', 'division_id', $id, 'id_district', 'ASC');
        if ($result) {
            echo json_encode($result);
        }
    }

    public function get_city_location()
    {
        $id = $this->input->post('id');
        $result = $this->Supplier_settings_model->common_cond_single_value_array('loc_areas', 'id_area', 'area_name_en', 'city_id', $id, 'id_area', 'ASC');
        if ($result) {
            echo json_encode($result);
        }
    }

    public function supplier_details($supplier_id = null)
    {
        $this->dynamic_menu->check_menu('suppliers');
        $this->breadcrumb->add('Suppliers', 'suppliers', 1);
        $this->breadcrumb->add('Supplier Details', '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['supplier_payment_alert_list'] = $this->Supplier_settings_model->common_cond_row_array('supplier_payment_alerts', 'supplier_id', $supplier_id);
        $data['city_list'] = $this->Supplier_settings_model->common_single_value_array('loc_cities', 'id_city', 'city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->Supplier_settings_model->common_single_value_array('loc_divisions', 'id_division', 'division_name_en', 'id_division', 'ASC');
        $data['supplier_info'] = $this->Supplier_settings_model->get_supplier_details($supplier_id);
        $data['supplier_document_list'] = $this->Supplier_settings_model->get_supplier_document_result($supplier_id);
        $this->template->load('main', 'supplier_settings/supplier_details', $data);
    }

    public function supplier_document_pagination()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        $supplier_id = $this->input->post('supplier_id');
        if (!empty($supplier_id)) {
            $conditions['search']['id_supplier'] = $supplier_id;
        }

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        //total rows count
        $totalRec = count($this->Supplier_settings_model->get_supplier_document_result_pagination($conditions));
        //pagination configuration
        $config['target'] = '#documentList';
        $config['base_url'] = base_url() . 'suppliers/supplier_document_pagination';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterDocument';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['posts'] = $this->Supplier_settings_model->get_supplier_document_result_pagination($conditions);
        //load the view
        $this->load->view('supplier_settings/supplier_document_pagination', $data, false);
    }

    public function create_supplier_document()
    {
        $this->form_validation->set_rules('document_name', 'Name', 'trim|required');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $data['doc_type'] = 'Supplier';
            $data['ref_id'] = $this->input->post('supplier_id');
            $data['name'] = $this->input->post('document_name');
            $data['description'] = $this->input->post('document_description');
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $data['status_id'] = 1;
            $data['version'] = 1;

            if ($_FILES['document_file']['name']!='') {
                $filename = upload_file('supplier', $_FILES['document_file']);
                $data['file'] = $filename;
            }

            $result = $this->Supplier_settings_model->common_insert('documents', $data);
            if ($result) {
                echo json_encode(array("status" => "success", "message" => lang('add_success'), "supplier_id" => $this->input->post('supplier_id')));
            }
        }

    }

    public function edit_supplier_doc()
    {
        $id = $this->input->post('id');
        $result = $this->Supplier_settings_model->common_cond_row_array('documents', 'id_document', $id);
        if ($result) {
            echo json_encode($result);
        }
    }

    public function update_supplier_document()
    {
        $this->form_validation->set_rules('edit_document_name', 'Name', 'trim|required');

        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $id = $this->input->post('edit_supplier_document_id');
            $data['name'] = $this->input->post('edit_document_name');
            $data['description'] = $this->input->post('edit_document_description');
            $old_supplier_doc = $this->input->post('old_supplier_doc');
            $data['dtt_mod'] = date('Y-m-d H:i:s');
            $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
            if ($_FILES['edit_document_file']['name']!='') {
                if($old_supplier_doc != ''){
                    delete_file('supplier', $old_supplier_doc);
                }
                $filename = upload_file('supplier', $_FILES['edit_document_file']);
                $data['file'] = $filename;
            }

            $result = $this->Supplier_settings_model->common_update('documents', $data, 'id_document', $id);
            if ($result) {
                echo json_encode(array("status" => "success", "message" => lang('update_success')));
            }
        }
    }

    public function delete_supplier_doc()
    {
        $id = $this->input->post('id');
        $data['status_id'] = 2;
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $result = $this->Supplier_settings_model->common_update('documents', $data, 'id_document', $id);
        if ($result) {
            echo json_encode(array("status" => TRUE));
        }

    }

    public function supplier_payment_alert_action()
    {
        $id_supplier_payment_alert = $this->input->post('id_supplier_payment_alert');
        if ($id_supplier_payment_alert != 0) {
            //update
            $this->form_validation->set_rules('edit_category', 'Supplier', 'trim|required|callback_select_check');
            $this->form_validation->set_rules('edit_number', 'Amount', 'trim|required|is_numeric');
            $this->form_validation->set_rules('edit_f_date', 'Date', 'trim|required');
            $this->form_validation->set_rules('edit_t_date', 'Date', 'trim|required');

            if ($this->form_validation->run() == false) {
                $value = $this->form_validation->error_array();
                echo json_encode($value);
            } else {
                $data['supplier_id'] = $this->input->post('edit_category');
                $data['amount'] = $this->input->post('edit_number');
                $data['dtt_notification'] = $this->input->post('edit_f_date');
                $data['dtt_payment_est'] = $this->input->post('edit_t_date');
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $result = $this->Supplier_settings_model->common_update('supplier_payment_alerts', $data, 'id_supplier_payment_alert', $id_supplier_payment_alert);
                if ($result) {
                    echo json_encode(array("status" => "success", "message" => lang('update_success')));
                }
            }

        } else {
            //insert
            $this->form_validation->set_rules('category', 'Supplier', 'trim|required|callback_select_check');
            $this->form_validation->set_rules('number', 'Amount', 'trim|required|is_numeric');
            $this->form_validation->set_rules('f_date', 'Date', 'trim|required');
            $this->form_validation->set_rules('t_date', 'Date', 'trim|required');

            if ($this->form_validation->run() == false) {
                $value = $this->form_validation->error_array();
                echo json_encode($value);
            } else {
                $data['supplier_id'] = $this->input->post('category');
                $data['amount'] = $this->input->post('number');
                $data['dtt_notification'] = $this->input->post('f_date');
                $data['dtt_payment_est'] = $this->input->post('t_date');
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $result = $this->Supplier_settings_model->common_insert('supplier_payment_alerts', $data);
                if ($result) {
                    echo json_encode(array("status" => "success", "message" => lang('add_success')));
                }
            }
        }

    }

    public function viewSupplierAlert()
    {
        $id = $this->input->post('id');
        $result = $this->Supplier_settings_model->common_cond_row_array('supplier_payment_alerts', 'id_supplier_payment_alert', $id);

        if (!empty($result)) {
            echo json_encode($result);
        } else {
            echo "0";
        }
    }

    //*Supplier Payment Alert Start*//
    public function supplier_payment_alert()
    {
        $data = array();
        $this->dynamic_menu->check_menu('supplier_payment_alert');
        $this->breadcrumb->add(lang('supplier_payment_alert'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $totalRec = count($this->Supplier_settings_model->supplier_payment_alert_list());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'supplier_payment_alert_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['posts'] = $this->Supplier_settings_model->supplier_payment_alert_list(array('limit' => $this->perPage));
        //dropdown data
        $data['supplier_list'] = $this->Supplier_settings_model->get_supplier_drop_down();
        $this->template->load('main', 'supplier_settings/supplier_payment_alert_list', $data);
    }

    public function supplier_payment_alert_data()
    {
        $conditions = array();
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $name_supplier = $this->input->post('name_supplier');
        if ($name_supplier != 0) {
            $conditions['search']['name_supplier'] = $name_supplier;
        }

        $totalRec = count($this->Supplier_settings_model->supplier_payment_alert_list($conditions));
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'supplier_payment_alert_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['posts'] = $this->Supplier_settings_model->supplier_payment_alert_list($conditions);
        $this->load->view('supplier_settings/supplier_payment_alert_data', $data, false);
    }

    function select_check($str)
    {
        if ($str == '0') {
            $this->form_validation->set_message('select_check', lang('select_msg'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function is_unique_supplier($str)
    {
        $this->load->database();
        $this->db->where('supplier_code', $str);
        $query = $this->db->get('suppliers');
        $result = $query->result();
        if ($result) {
            $this->form_validation->set_message('is_unique_supplier', lang('unique_false_msg'));
            return FALSE;
        } else {
            return TRUE;
        }
    }


    //*Supplier Payment Alert End*//

    //**Suuplier Settings::Supplier Settings End**//

}
