<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cod_cost extends MX_Controller
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
        $this->breadcrumb->add(lang('cod_cost'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->sell_summary_model_2->getRowsProducts());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'cod_cost/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['de_vat'] = $this->delivery_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        $data['users'] = $this->delivery_model->getvalue_row('users', 'id_user,uname', array('status_id' => 1));
        $data['persons'] = $this->delivery_model->getvalue_row('delivery_persons', 'id_delivery_person,person_name', array('status_id' => 1,'type_id'=>2));
          $data['agents'] = $this->delivery_model->getvalue_row('agents', 'agent_name,id_agent', array('status_id' => 1));
        $data['stations'] = $this->delivery_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        // var_export($data['stations']);
        $data['categories'] = $this->delivery_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['stores'] = $this->delivery_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $this->template->load('main', 'cod_cost/index', $data);
    }

    public function paginate_data($page = 0)
    {
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        $agent_name = $this->input->post('agent_name');
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        if (!empty($agent_name)) {
            $conditions['search']['agent_name'] = $agent_name;
        }

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data

        $data['store'] = $this->delivery_model->getvalue_row('stores', 'id_store,store_name', array());
        $data['categories'] = $this->delivery_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['agents'] = $this->delivery_model->getvalue_row('agents', 'agent_name,id_agent', array('status_id' => 1));
        $data['posts'] = $this->delivery_model->getfilterData($conditions);
        //load the view
        $data['fdate'] = $ToDate;
        $this->load->view('cod_cost/all_report_data', $data, false);
        // }
    }

}
