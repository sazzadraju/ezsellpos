<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Best_selling_products extends MX_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('best_selling_products_model','bspm');
        $this->perPage = 500;
    }

    public function index() {
        $data = array();
        $this->breadcrumb->add(lang('product-sell-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['categories'] = $this->bspm->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->bspm->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->bspm->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['brands'] = $this->bspm->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $this->template->load('main', 'best_selling_products/index', $data);
    }
    public function paginate_data($page = 0) {
        $conditions = array();

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $store_id = $this->input->post('store_id');
        $cat_name = $this->input->post('cat_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $brand = $this->input->post('brand');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $report_type = $this->input->post('report_type');
        $conditions['search']['report_type'] = $report_type;
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if (!empty($brand)) {
            $conditions['search']['brand'] = $brand;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['store'] = $this->bspm->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $row = $this->bspm->getRowsProducts($conditions);
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
        $data['posts'] = $this->bspm->getRowsProducts($conditions);
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['which_store'] = $store_id;

        $this->load->view('best_selling_products/all_report_data', $data, false);
    }
    
    public function print_data() {
        $conditions = array();
       
        $store_id = $this->input->post('store_id');
        $cat_name = $this->input->post('cat_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $brand = $this->input->post('brand');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $report_type = $this->input->post('report_type');
        $conditions['search']['report_type'] = $report_type;
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if (!empty($brand)) {
            $conditions['search']['brand'] = $brand;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Best Selling Product Report';
        //pagination configuration
       

        
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['which_store'] = $store_id;
        $data['posts'] = $this->bspm->getRowsProducts($conditions);
        $data3['report']=$this->load->view('best_selling_products/all_report_data', $data, true);
        $this->load->view('print_page', $data3, false);
    // }
    }
    public function create_csv_data()
    {
        $conditions = array();
        $store_id = $this->input->post('store_id');
        $cat_name = $this->input->post('cat_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $brand = $this->input->post('brand');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $report_type = $this->input->post('report_type');
        $conditions['search']['report_type'] = $report_type;
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if (!empty($brand)) {
            $conditions['search']['brand'] = $brand;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $posts = $this->bspm->getRowsProducts($conditions);
        $fields = array(
            'date' => 'Date'
        , 'product_name' => 'Product Name'
        , 'product_code' => 'Product Code'
        , 'cat_subcat' => 'Cat/Subcat'
        , 'brand' => 'Brand'
        , 'store' => 'Store'
        , 'unit_price' => 'Unit Price'
        , 'qty' => 'Qty'
        , 'total' => 'Total'
        , 'dis' => 'Discount'
        , 'vat' => 'Vat'
        , 'amount' => 'Amount'
        );
        $sum_qty = 0;
        $unit_sum = 0;
        $total = 0;
        $vat_sum = 0;
        $dis_sum = 0;
        $purchase_sum=0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $total += $post['amt'];
                $sum_qty += $post['qty'];
                $unit_sum += $post['unit_price'];
                $vat_sum += $post['vat_amt'];
                $dis_sum +=  $post['discount_amt'];
                $purchase_sum +=  $post['purchase_price']*$post['qty'];
                $category=$post['cat_name'] . '/' . $post['subcat_name'];
                $value[] = array(
                    'date' => date('Y-m-d', strtotime($post['dtt_add']))
                , 'product_name' => $post['product_name']
                , 'product_code' => $post['product_code']
                , 'cat_subcat' => $category
                , 'brand' => $post['brand_name']
                , 'store' => $post['store_name']
                , 'unit_price' => $post['unit_price']/$post['qty']
                , 'qty' => $post['qty']
                , 'total' => $post['unit_price']
                , 'dis' => $post['discount_amt']
                , 'vat' => $post['vat_amt']
                , 'amount' => $post['amt']
                );
                $count++;
            }
            $value[] = array(
                'date' => ''
            , 'product_name' => ''
            , 'product_code' => ''
            , 'cat_subcat' => ''
            , 'brand' => ''
            , 'store' => ''
            , 'unit_price' => 'total'
            , 'qty' => $sum_qty
            , 'total' => $unit_sum
            , 'dis' => $dis_sum
            , 'vat' => $vat_sum
            , 'amount' => $total
            );
        }else{
            $value='';
        }
        $dataArray = array(
        'file_name' => 'top_selling_product_report'
        , 'file_title' => 'Top Selling Product Report'
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
