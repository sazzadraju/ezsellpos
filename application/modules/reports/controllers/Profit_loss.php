<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profit_loss extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('profit_loss_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('profit_loss'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->sell_summary_model_2->getRowsProducts());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'profit_loss/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['de_vat'] = $this->profit_loss_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        // $data['max_val'] = $this->profit_loss_model->max_value('products', 'sell_price');
        // $data['suppliers'] = $this->profit_loss_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['users'] = $this->profit_loss_model->getvalue_row('users', 'id_user,uname', array('status_id' => 1));
        $data['customers'] = $this->profit_loss_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['stations'] = $this->profit_loss_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        // var_export($data['stations']);
        $data['categories'] = $this->profit_loss_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $st['id_store']= $this->session->userdata['login_info']['store_id'];
        }
        $st['status_id']=1;
        $data['salesPersons'] = $this->profit_loss_model->getSales_person_list();
        $data['stores'] = $this->profit_loss_model->getvalue_row('stores', 'id_store,store_name', $st);
        // $data['posts'] = $this->profit_loss_model->getRowsProducts(array('limit' => $this->perPage),'','');

        $this->template->load('main', 'profit_loss/index', $data);
    }

    public function paginate_data($page = 0)
    {
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $store_id = $this->input->post('store_id');
        $sales_person=$this->input->post('sales_person');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        if ($sales_person!= 0 ) {
            $conditions['search']['sales_person'] = $sales_person;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        // print_r($store_id);
        // $totalRec = count($this->profit_loss_model->getRowsProducts($conditions,$store_id));

        //pagination configuration$conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
        $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
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

        $data['store'] = $this->profit_loss_model->getvalue_row('stores', 'id_store,store_name', array());
        $data['categories'] = $this->profit_loss_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['brands'] = $this->profit_loss_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['posts'] = $this->profit_loss_model->getRowsProducts($conditions, $store_id);

        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $key => $val) {
                $arr_date=explode(' ',$val['dtt_add']);
                $data['posts'][$key]['total'] = $this->profit_loss_model->getTotalSale($conditions, $store_id,$val['dtt_add']);
                $data['posts'][$key]['round'] = $this->profit_loss_model->getRowsRound($conditions, $store_id,$val['dtt_add']);
                $data['posts'][$key]['return'] = $this->profit_loss_model->getReturnProduct($conditions, $store_id,$val['dtt_add']);
                $data['posts'][$key]['return_tot'] = $this->profit_loss_model->getTotalSaleReturn($conditions, $store_id,$val['dtt_add']);
                $data['posts'][$key]['tot_vat'] = $this->profit_loss_model->getTotalVat($conditions, $store_id,$val['dtt_add']);
                $data['posts'][$key]['tot_return_vat'] = $this->profit_loss_model->getTotalReturnVat($conditions, $store_id,$val['dtt_add']);
            }
        }
        $data['fdate'] = $ToDate;
        // echo '<pre>';
        // print_r($data['posts']);
        // echo '</pre>';
        $this->load->view('profit_loss/all_report_data', $data, false);
        // }
    }
    public function print_data()
    {
        // print_r("expression");
        $conditions = array();
        //calc offset number
        $store_id = $this->input->post('store_id');
        $sales_person=$this->input->post('sales_person');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        if ($sales_person!= 0 ) {
            $conditions['search']['sales_person'] = $sales_person;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Profit loss Report'; 
        $data['store'] = $this->profit_loss_model->getvalue_row('stores', 'id_store,store_name', array());
        $data['categories'] = $this->profit_loss_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['brands'] = $this->profit_loss_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['posts'] = $this->profit_loss_model->getRowsProducts($conditions, $store_id);

        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $key => $val) {
                $arr_date=explode(' ',$val['dtt_add']);
                $data['posts'][$key]['total'] = $this->profit_loss_model->getTotalSale($conditions, $store_id,$val['dtt_add']);
                $data['posts'][$key]['round'] = $this->profit_loss_model->getRowsRound($conditions, $store_id,$val['dtt_add']);
                $data['posts'][$key]['return'] = $this->profit_loss_model->getReturnProduct($conditions, $store_id,$val['dtt_add']);
                $data['posts'][$key]['return_tot'] = $this->profit_loss_model->getTotalSaleReturn($conditions, $store_id,$val['dtt_add']);
            }
        }
        $data['fdate'] = $ToDate;
        $data3['report']=$this->load->view('profit_loss/all_report_data', $data, true);
        $this->load->view('print_page', $data3, false);
    }

}
