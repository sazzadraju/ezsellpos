<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_person extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }
        $this->form_validation->CI = &$this;
        $this->load->model('auto_increment');
        $this->load->model('sales_model');
        $this->perPage = 20;
    }

    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('sales-person');
        $this->breadcrumb->add(lang('sales_person'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $row = $this->sales_model->getSales_person_list();
        $totalRec = ($row)?count($row):0;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'sales_person/paginate_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['posts']=$this->sales_model->getSales_person_list(array('limit' => $this->perPage));
        $store_m = $this->session->userdata['login_info']['store_id'];
        $data['store_name_p'] = $this->session->userdata['login_info']['store_id'];
        $data['station_name_p'] = $this->session->userdata['login_info']['station_id'];
        $this->template->load('main', 'sales_person/index', $data);
    }
    public function paginate_data(){
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        //total rows count
        $rec=$this->sales_model->getSales_person_list();
        $totalRec = count($rec);
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'sales_person/paginate_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['posts'] = $this->sales_model->getSales_person_list($conditions);
        //load the view
        $this->load->view('sales_person/all_sales_person_data',$data, false);
    }
    public function temp_add_print_chalan(){
        $invoice = $this->input->post('invoice');
        $store_id=$this->session->userdata['login_info']['store_id'];
        $data['sales'] = $this->sales_model->getvalue_row_one('sales', 'customer_id,id_sale', array('invoice_no' => $invoice,'store_id'=>$store_id));
        if ($data['sales']) {
            $saleId = $data['sales'][0]['id_sale'];
            $data['customer_id'] = $data['sales'][0]['customer_id'];
            $data['products'] = $this->commonmodel->getvalue_sale_details($saleId);
        }
        $data['posts'] = $this->sales_model->get_customer_address($data['customer_id']);
        $this->load->view('chalan/chalan_product_list', $data);
    }
    public function person_list(){
        $id = $this->input->post('id');
        $data=array();
        if($id==1){
            $data['posts']=$this->sales_model->getvalue_row('users', 'id_user as id, fullname as  user_name',array('uname'=>null,'status_id'=>1,'user_type_id'=>1));
        }elseif ($id==2){
            $data['posts']=$this->sales_model->getvalue_row('users', 'id_user as id, fullname as  user_name',array('uname'=>null,'status_id'=>1,'user_type_id'=>2));
        }elseif ($id==3){
            $data['posts']=$this->sales_model->getvalue_row('suppliers', 'id_supplier as id, supplier_name as  user_name',array('status_id'=>1));
        }
        elseif ($id==4){
            $data['posts']=$this->sales_model->getvalue_row('customers', 'id_customer as id, full_name as  user_name',array('status_id'=>1));
        }
        $this->load->view('sales_person/user_list', $data);
    }
    public function add_person_commission(){
        $person_type = $this->input->post('person_type');
        $person_name = $this->input->post('person_name');
        $commission = $this->input->post('commission');

        $check=$this->sales_model->getvalue_row('sales_person', 'person_id',array('person_id'=>$person_name,'person_type'=>$person_type));
        if($check){
            echo 3;
        }else{
            $data=array(
                'person_id'=>$person_name
            ,'person_type'=>$person_type
            ,'commission'=>$commission
            ,'dtt_add'=>date('Y-m-d H:i:s')
            );
            $qry=$this->sales_model->common_insert('sales_person',$data);
            if($qry){
                echo 1;
            }else{
                echo 2;
            }
        }

    }
    public function update_person_commission(){
        $id = $this->input->post('c_id');
        $commiss = $this->input->post('commission');
        $data=array(
            'commission'=>$commiss
            ,'dtt_mod'=>date('Y-m-d H:i:s')
        );
        $qry=$this->sales_model->update_value('sales_person',$data,array('id_sales_person'=>$id));
        if($qry){
            echo 1;
        }else{
            echo 2;
        }
    }



}
