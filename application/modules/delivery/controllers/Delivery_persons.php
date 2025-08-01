<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_persons extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('delivery_model');
        $this->perPage = 20;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('delivery-persons'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row =$this->delivery_model->getPersonsData();
        $totalRec = ($row)?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'delivery_persons/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['posts'] = $this->delivery_model->getPersonsData(array('limit' => $this->perPage));
        $data['agents'] = $this->delivery_model->getvalue_row('agents', 'id_agent,agent_name',array('status_id' => 1));
        $this->template->load('main', 'delivery_persons/index', $data);
    }

    public function add_data()
    {
// dd($_POST);
            $name = $this->input->post('person_name');
       
            $data['person_name'] = $this->input->post('person_name');
            $id_v = $this->input->post('id');
            // $data['person_mobile'] = $this->input->post('person_number');
            // $data['ref_id'] = $this->input->post('ref_id');
            $ref=$this->input->post('type_id');
            $data['type_id'] = $this->input->post('type_id');
            if ($this->input->post('id') != '') {
                $this->form_validation->set_rules('agent_name', 'Agent Name', 'trim|required');
            $val = $this->delivery_model->isExistExcept('agents', 'agent_name', $name, 'id_agent', $id_v);
            // echo $val;
                    if ($val) {
                        echo json_encode(array('agent_name' => lang('name_exist')));
                        exit();
                    }
                $condition = array(
                    'id_delivery_person' => $this->input->post('id')
                );
                if($ref==1){
                     $data['person_mobile'] = $this->input->post('person_number');
                     $data['ref_id'] = $this->input->post('ref_id');
                }
                else{
                     $data['person_mobile'] = $this->input->post('person_number1');
                     $data['ref_id'] = $this->input->post('ref_id1');
                }
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $pro_id = $this->delivery_model->update_value('delivery_persons', $data, $condition);
                $massage = 'Successfully data Updated..';
            } else {
                 if($ref==1){
                     $data['person_mobile'] = $this->input->post('person_number');
                     $data['ref_id'] = $this->input->post('ref_id');
                }
                else{
                     $data['person_mobile'] = $this->input->post('person_number1');
                     $data['ref_id'] = $this->input->post('ref_id1');
                }
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $data['status_id'] = 1;
                $pro_id = $this->delivery_model->common_insert('delivery_persons', $data);
                $massage = 'Successfully data added..';
            }

            echo json_encode(array("status" => "success", "message" => $massage));
        // }
    }
   
    public function paginate_data()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $src_person_name = $this->input->post('src_person_name');
        // echo  $src_person_name;
        $src_type_id = $this->input->post('src_type_id');
        if (!empty($src_person_name)) {
            $conditions['search']['src_person_name'] = $src_person_name;
        }
        if (!empty($src_type_id)) {
            $conditions['search']['src_type_id'] = $src_type_id;
        }


        //total rows count
        $totalRec = count($this->delivery_model->getPersonsData($conditions));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'delivery_persons/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['posts'] = $this->delivery_model->getPersonsData($conditions);
        //load the view
        $this->load->view('delivery_persons/all_product_data', $data, false);
    }

    public function edit_data($id = null)
    {
        $data = $this->delivery_model->get_person_by_id($id);
        echo json_encode(array("data" => $data));
        //echo json_encode($data);
    }
    public function delete_data($id = null)
    {
        //echo "data delete successfully";
        $condition = array(
            'id_delivery_person' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->delivery_model->update_value('delivery_persons', $data, $condition);
        echo json_encode(array("status" => TRUE));
    }
     public function checkAgentName() {
        $this->load->database();
        $name = $this->input->post('agent_name');
        $this->db->where('agent_name', $name);
        $this->db->where('status_id', 1);
        $query = $this->db->get('agents');
        $result = $query->result();
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
     public function getStaff()
    {
        // $id = $this->input->post('id');
        $condition = array(
            'user_type_id' => 1,
            'status_id'=>1
        );
        $categories = $this->delivery_model->getvalue_row('users', 'fullname,id_user,mobile', $condition);
        echo json_encode($categories);
    }
     public function getStaffPhone()
    {
        $id = $this->input->post('id');
        $condition = array(
            'user_type_id' => 1,
            'id_user' => $id,
            'status_id'=>1
        );
        $categories = $this->delivery_model->getvalue_row('users', 'mobile', $condition);
        echo json_encode($categories);
    }
}
