<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stations extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('User_model', 'user_model');
        $this->perPage = 20;
    }

    public function index()
    {
        $this->dynamic_menu->check_menu('users/stations');
        $data = array();
        $this->breadcrumb->add(lang('stations'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();

        $data['records'] = $this->user_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'TOT_STATIONS'));

        // Convert into integer
        $data['records'][0]->param_val = (int)$data['records'][0]->param_val;
        $data['records'][0]->utilized_val = (int)$data['records'][0]->utilized_val;
        $data['stores'] = $this->user_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['posts'] = $this->user_model->get_stations();
        $this->template->load('main', 'stations/index', $data);
    }

    public function add_data()
    {
        $conditions = array();
        $name = '';
        if ($this->input->post('id') != '') {
            $name = $this->input->post('st_name');
            $id_v = $this->input->post('id');
            $store = $this->input->post('store_name');
            $this->form_validation->set_rules('st_name', 'Station Name', 'trim|required');
            $array = array(
                'name' => $name,
                'store_id' => $store
            );
            $arrayNot = array(
                'id_station !=' => $id_v
            );
            $val = $this->user_model->isExistStation('stations', $array, $arrayNot);
            if ($val == 1) {
                echo json_encode(array('st_name' => lang('name_exist')));
                exit();
            }
        } else {
            $name = $this->input->post('station_name');
            $store = $this->input->post('store_name');
            $array = array(
                'name' => $name,
                'store_id' => $store
            );
            $val = $this->user_model->isExistStation('stations', $array, null);
           // $this->form_validation->set_rules('station_name', 'Station Name', 'trim|required|is_unique[stations.name]');
        }
        if ($val == 1) {
            echo json_encode(array('station_name' => lang('name_exist')));
            exit();
        }
        else if($this->input->post('id') == 1){
            // TODO:: set Error Message
            echo json_encode(array('station_name' => 'Primary Station is not Editable'));
            exit();
        }
        else {
            $data['name'] = $name;
            $store_name = $this->input->post('store_name');
            if ($this->input->post('id') != '') {
                $condition = array(
                    'id_Station' => $this->input->post('id')
                );
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $this->user_model->update_value('stations', $data, $condition);

                ## Update Station (Cash) Account
                $acc_data = [
                    'account_name' => $name,
                    'dtt_mod' => $data['dtt_mod'],
                    'uid_mod' => $data['uid_mod'],
                    'status_id' => 1,
                ];
                $condition = [
                    'station_id' => $this->input->post('id'),
                    'store_id' => $this->input->post('store_id')
                ];
                $this->user_model->update_station_account($acc_data, $condition);

                $massage = lang("update_success");
            } else {
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $data['store_id'] = $store_name;
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $station_id = $this->user_model->common_insert('stations', $data);

                ## CREATE STATION (CASH) ACCOUNT
                $acc_data = [
                    'account_name' => $name,
                    'acc_type_id' => 4,
                    'acc_uses_id' => 2,  // Shop Account
                    'station_id' => $station_id,
                    'initial_balance' => 0,
                    'curr_balance' => 0,
                    'dtt_add' => $data['dtt_add'],
                    'uid_add' => $data['uid_add'],
                    'status_id' => 1,
                    'version' => 1,
                ];
                $acc_id = $this->user_model->common_insert('accounts', $acc_data);

                $acc_store_data = [
                    'account_id' => $acc_id,
                    'store_id' => $store_name,
                ];
                $this->user_model->common_insert('accounts_stores', $acc_store_data);

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

    public function chk_acc_balance()
    {
        $st_id = $this->input->post('st_id');
        $str_id = $this->input->post('str_id');
        $balance = $this->user_model->checkAccountBalanceByStationId($st_id, $str_id);
        echo json_encode(['balance' => $balance]);
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

    public function edit_data($id = null)
    {
        $data = $this->user_model->get_data_by_id($id);
        echo json_encode($data);
    }

    public function check_station_name()
    {
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
