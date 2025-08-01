<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_costs extends MX_Controller
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
        $this->perPage = 40;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('delivery-costs'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->delivery_model->getCostData();
        $totalRec = ($row)?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'delivery_cost/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['posts'] = $this->delivery_model->getCostData(array('limit' => $this->perPage));
        $data['agents'] = $this->delivery_model->getvalue_row('agents', 'id_agent,agent_name',array('status_id' => 1));
        $this->template->load('main', 'delivery_costs/index', $data);
    }
    public function add_data()
    {  

    $data2 = [];
           $name = $this->input->post('person_name');
            
            $data['delivery_name'] = $this->input->post('delivery_cost_name');
            $id_v = $this->input->post('id');
            $ref=$this->input->post('type_id');
            if ($this->input->post('id') != '') {
                $data['ref_id'] = $this->input->post('agent_list_edit');
                $data['type_id'] = $this->input->post('person_type_edit');
                $id= $this->input->post('id');
                $condition = array(
                    'id_delivery_cost' => $this->input->post('id')
                );
                $condition1 = array(
                    'delivery_cost_id' => $this->input->post('id')
                );
                $gm_from = $this->input->post('gm_from');

                 $price = $this->input->post('price');
                 $gm_to = $this->input->post('gm_to');
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $pro_id = $this->delivery_model->update_value('delivery_costs', $data, $condition);
                 $pro_id2=$this->delivery_model->update_value_step_1($condition1);
                 for($i=0; $i<count($gm_from);$i++){
                 $value_data= array(
                    'delivery_cost_id' => $id,
                    'gm_from' => $gm_from[$i], 
                    'gm_to' => $gm_to[$i], 
                    'price' => $price[$i], 
                );
                   $pro_id3=$this->delivery_model->common_insert('delivery_cost_details', $value_data);
                }
                $massage = 'Successfully data Updated..';
            } else {
                $data['ref_id'] = $this->input->post('ref_id');
                $data['type_id'] = $this->input->post('type_id');
                 $data1['gm_from'] = $this->input->post('gm_from');    
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $data['status_id'] = 1;
                $pro_id = $this->delivery_model->common_insert('delivery_costs', $data);
                $gm_from = $this->input->post('gm_from');
                $price = $this->input->post('price');
                $gm_to = $this->input->post('gm_to');
                for($i=0; $i<count($gm_from);$i++){
                     $value_data= array(
                        'delivery_cost_id' => $pro_id,
                        'gm_from' => $gm_from[$i], 
                        'gm_to' => $gm_to[$i], 
                        'price' => $price[$i], 
                    );
                    $pro_id2=$this->delivery_model->common_insert('delivery_cost_details', $value_data);
                }
                
                $massage = 'Successfully data added..';
            }

            echo json_encode(array("status" => "success", "message" => $massage));        
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
        //total rows count
        $totalRec = count($this->delivery_model->getCostData($conditions));
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'delivery_cost/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['posts'] = $this->delivery_model->getCostData($conditions);
        //load the view
        $this->load->view('delivery_costs/all_product_data', $data, false);
    }

    public function edit_data($id = null)
    {
        $data = $this->delivery_model->get_cost_by_id($id);
        $details = $this->delivery_model->get_cost_det_by_id($id);
        $i=0;
        $html='';
        foreach ($details as $detail) {
            $html.= '<tr>';
            $html.= '';
            $html.='<td><input type="text" id="gm_from'.$i.'" name="gm_from[]" class="form-control" value="'.$detail['gm_from'].'"/></td>';
            $html.='<td><input type="text" id="gm_to'.$i.'" name="gm_to[]" class="form-control" value="'.$detail['gm_to'].'"/></td>';
            $html.='<td><input type="text" id="price'.$i.'" name="price[]" class="form-control" value="'.$detail['price'].'"/></td>';
            $html.= '<td><span class="btn btn-danger btn-xs addBtnRemove" id="addBtn_1" onclick="addBtnRemove(this)">X</span></td></tr>';
            $i++;
        }
        echo json_encode(array("data" => $data,'details'=>$html));
        //echo json_encode($data);
    }

    public function details_data($id = null)
    {
        $data = $this->delivery_model->get_cost_details_by_id($id);
        foreach ($data as $key => $value) {
            $arrayVal[$key] = $value;
        }
        $dataValue = '';
        echo json_encode($arrayVal);
    }

     public function costDetails_data($id = null)
    {
        $data = $this->delivery_model->get_cost_configure_details($id);
        echo json_encode($data);
    }

    public function delete_data($id = null)
    {
        $condition = array(
            'id_delivery_cost' => $id
        );
        $data['status_id'] = 2;
        $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
        $data['dtt_mod'] = date('Y-m-d H:i:s');
        $this->delivery_model->update_value('delivery_costs', $data, $condition);
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
}
