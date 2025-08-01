<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Best_selling_customers extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('best_selling_customers_model','bscm');
        $this->perPage = 500;
    }

    public function index() {
        $data = array();
        $this->breadcrumb->add(lang('product-sell-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->bscm->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->bscm->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['customers'] = $this->bscm->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['customer_types'] = $this->bscm->getvalue_row('customer_types', 'id_customer_type,name', array('status_id' => 1));
        $this->template->load('main', 'best_selling_customers/index', $data);
    }

   

    public function paginate_data($page = 0) {
        $conditions = array();

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        //$customer_id = $this->input->post('customer_id');
        $customer_type = $this->input->post('customer_type');
        if ($customer_type!= 0 ) {
            $conditions['search']['customer_type'] = $customer_type;
        }
        // if ($customer_id!= 0 ) {
        //     $conditions['search']['customer_id'] = $customer_id;
        // }
        if ($store_id!= 0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['store'] = $this->bscm->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $row = $this->bscm->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product-sell-report/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['posts'] = $this->bscm->getRowsProducts($conditions);
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['which_store'] = $store_id;

        $this->load->view('best_selling_customers/all_report_data', $data, false);
    }
    
    public function print_data() {
        $conditions = array();
         
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        //$customer_id = $this->input->post('customer_id');
        $customer_type = $this->input->post('customer_type');
        if ($customer_type!= 0 ) {
            $conditions['search']['customer_type'] = $customer_type;
        }
        // if ($customer_id!= 0 ) {
        //     $conditions['search']['customer_id'] = $customer_id;
        // }
        if ($store_id!= 0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        
        
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Best Selling Customer Report';
        
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['which_store'] = $store_id;
        $data['posts'] = $this->bscm->getRowsProducts($conditions);
        $data3['report']=$this->load->view('best_selling_customers/all_report_data', $data, true);
        $this->load->view('print_page', $data3, false);
    // }
    }
    public function create_csv_data()
    {
        $conditions = array();
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        //$customer_id = $this->input->post('customer_id');
        $customer_type = $this->input->post('customer_type');
        if ($customer_type!= 0 ) {
            $conditions['search']['customer_type'] = $customer_type;
        }
        // if ($customer_id!= 0 ) {
        //     $conditions['search']['customer_id'] = $customer_id;
        // }
        if ($store_id!= 0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $posts = $this->bscm->getRowsProducts($conditions);
        $fields = array(
            'serial' => 'Serial No'
        ,'customer' => 'Customer Name'
        , 'customer_code' => 'Customer Code'
        , 'phone' => 'Phone'
        , 'type' => 'Customer Type'
        , 'store' => 'Store Name'
        , 'tot_amt' => 'Total Amount'
        , 'paid' => 'Paid Amount'
        , 'due' => 'Due Amount'
        );
        $sum_total = 0;
        $paid_total = 0;
        $due_total = 0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $sum_total += $post['tot_amt'];
                $paid_total += $post['paid_amt'];
                $due_total += $post['due_amt'];
                $value[] = array(
                    'serial' => $count
                    ,'customer' => $post['customer_name']
                    , 'customer_code' => $post['customer_code']
                    , 'phone' => $post['phone']
                    , 'type' => $post['customer_type']
                    , 'store' => $post['store_name']
                    , 'tot_amt' => $post['tot_amt']
                    , 'paid' => $post['paid_amt']
                    , 'due' => $post['due_amt']
                );
                $count++;
            }
            $value[] = array(
                'serial' => ''
                ,'customer' => ''
                , 'customer_code' => ''
                , 'phone' => ''
                , 'type' => ''
                , 'store' => 'Total'
                , 'tot_amt' =>  $sum_total
                , 'paid' => $paid_total
                , 'due' => $due_total
            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'top_customers_report'
        , 'file_title' => 'Top Customers Report'
        , 'field_title' => $fields
        , 'field_data' => $value
        , 'from' => $FromDate
        , 'to' => $ToDate
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

}
