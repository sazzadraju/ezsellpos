<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_report_details extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('purchase_report_details_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('purchase_report_details'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->purchase_report_details_model->getRowsProducts());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'purchase_report_details/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['de_vat'] = $this->purchase_report_details_model->getvalue_row('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        // $data['max_val'] = $this->purchase_report_details_model->max_value('products', 'purchase_price');
        // $data['suppliers'] = $this->purchase_report_details_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['users'] = $this->purchase_report_details_model->getvalue_row('users', 'id_user,uname', array('status_id' => 1));
        $data['customers'] = $this->purchase_report_details_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['stations'] = $this->purchase_report_details_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->purchase_report_details_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->purchase_report_details_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['suppliers'] = $this->purchase_report_details_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        // var_export($data['stations']);
        $data['categories'] = $this->purchase_report_details_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['brands'] = $this->purchase_report_details_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['posts'] = $this->purchase_report_details_model->getRowsProducts(array('limit' => $this->perPage));

        $this->template->load('main', 'purchase_report_details/index', $data);
    }


    public function getMaxNumber()
    {
        $this->load->database();
        $this->db->select('max(product_code) as code');
        $result = $this->db->get('products')->row();
        $code = ($result->code) + 1;
        echo $code;
    }


    public function paginate_data($page = 0)
    {
        $conditions = array();

        //calc offset number
        // public function paginate_data() {
        //     $conditions = array();
        //     $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        // if ($this->input->post('FromDate') == '') {
        // $this->form_validation->set_rules('FromDate', 'From Date', 'trim|required');
        // }
        // else{
        $invoice_no = $this->input->post('invoice_no');
        $store_id = $this->input->post('store_id');
        $product_name = $this->input->post('product_name');
        // $customer_id = $this->input->post('customer_id');
        // $uid_add = $this->input->post('uid_add');
        $ToDate = $this->input->post('ToDate');
        $cat_name = $this->input->post('cat_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $supplier_id = $this->input->post('supplier_id');
        // $brand = $this->input->post('brand');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        if (!empty($product_name)) {
            $conditions['search']['product_name'] = $product_name;
        }
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($cat_name)) {
            $conditions['search']['cat_name'] = $cat_name;
        }
        if (!empty($pro_sub_category)) {
            $conditions['search']['pro_sub_category'] = $pro_sub_category;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }


        $row = $this->purchase_report_details_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['sold_by'] = $this->purchase_report_details_model->getvalue_row('users', 'id_user,uname', array());
        $data['customers'] = $this->purchase_report_details_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['station'] = $this->purchase_report_details_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $data['store'] = $this->purchase_report_details_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['categories'] = $this->purchase_report_details_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $data['brands'] = $this->purchase_report_details_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array('status_id' => 1));
        $data['posts'] = $this->purchase_report_details_model->getRowsProducts($conditions);
        $data['suppliers'] = $this->purchase_report_details_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        // var_export($data['posts']);
        //  var_export($conditions);
        //load the view
        $this->load->view('purchase_report_details/all_report_data', $data, false);
        // }
    }


    // public function details_data($id = null) {
    //     $data = $this->purchase_report_details_model->get_product_details_by_id($id);
    //     $data1 = $this->purchase_report_details_model->get_supplier_by_product_id($id);
    //     foreach ($data as $key => $value) {
    //         $arrayVal[$key] = $value;
    //     }
    //     $dataValue = '';
    //     if (!empty($data1)) {
    //         foreach ($data1 as $val) {
    //             $coma = (empty($dataValue) ? '' : ', ');
    //             $dataValue .= $coma . '<a href="' . base_url() . 'supplier/' . $val['id_supplier'] . '" target="_blank">' . $val['supplier_name'] . '</a>   ';
    //         }
    //     }
    //     $arrayVal['supplier_name'] = $dataValue;
    //     echo json_encode($arrayVal);
    // }


    public function paginate_data2($id)
    {

        // $invoice_id = $this->input->post('invoice_id');
        $invoice_id = $id;

        $userid = $this->session->userdata['login_info']['id_user_i90'];
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'product/page_data';
        // $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        // $conditions['start'] = $offset;
        // $conditions['limit'] = $this->perPage;

        //get posts data
        $data['configs'] = $this->purchase_report_details_model->getvalue_row('configs', 'param_key,param_val', array());

        // $data['brands'] = $this->purchase_report_details_model->getvalue_row('product_brands', 'brand_name,id_product_brand', array());
        // $data['categories'] = $this->purchase_report_details_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array());
        $data['product'] = $this->purchase_report_details_model->getvalue_row('products', 'id_product,product_name', array('status_id' => 1));
        $data['customers'] = $this->purchase_report_details_model->getvalue_row('customers', 'id_customer,full_name', array());
        // $data['posts'] = $this->purchase_report_details_model->getRowsProducts($conditions);
        // $data['username'] = $this->purchase_report_details_model->get_user_name_by_id($userid);

        $data['invoice_details'] = $this->purchase_report_details_model->get_invoice_details($invoice_id);
        $data['invoices'] = $this->purchase_report_details_model->getvalue_row('sales', 'invoice_no,id_sale,customer_id', array('id_sale' => $invoice_id));
        // $data['categories'] = $this->purchase_report_details_model->getvalue_row('sales', 'id_sale,sale_id,parent_cat_id', array('status_id' => 1));
        $data['stores'] = $this->purchase_report_details_model->getvalue_row('stores', '*', array('status_id' => 1));
        $data['suppliers'] = $this->purchase_report_details_model->getvalue_row('suppliers', '*', array('status_id' => 1));
        $data['documents'] = $this->purchase_report_details_model->get_doc_file($id);
        //load the view
        // var_export( $data['documents']);
        $this->load->view('purchase_report_details/index2', $data, false);
    }

    public function print_data()
    {
        $conditions = array();
        $invoice_no = $this->input->post('invoice_no');
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $supplier_id = $this->input->post('supplier_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        if (!empty($product_name)) {
            $conditions['search']['product_name'] = $product_name;
        }
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if ($supplier_id !=0) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }

        $data['posts'] = $this->purchase_report_details_model->getRowsProducts($conditions);
        $data3['report']=$this->load->view('purchase_report_details/all_print_data', $data, true);
        $this->load->view('print_page', $data3, false);
    }
    public function create_csv_data()
    {
        $conditions = array();
        $invoice_no = $this->input->post('invoice_no');
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $supplier_id = $this->input->post('supplier_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        if (!empty($product_name)) {
            $conditions['search']['product_name'] = $product_name;
        }
        if ($store_id!=0) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($invoice_no)) {
            $conditions['search']['invoice_no'] = $invoice_no;
        }
        if ($supplier_id !=0) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }

        $posts = $this->purchase_report_details_model->getRowsProducts($conditions);
        $pur_val='';
        $fields['purchase_date'] = 'Purchase Date';
        $fields['invoice_no'] = 'Transaction No';
        $fields['store_name'] = 'Employee Name';
        $fields['supplier_name'] = 'Transaction Name';
        $fields['total'] = 'Total Price';
        $sum_qty = 0;
        $total = 0;
        $count = 1;
        if ($posts != '') {
            foreach ($posts as $post) {
                $total += $post['tot_amt'];
                $array['purchase_date'] = $post['dtt_receive'];
                $array['invoice_no'] =$post['invoice_no'];
                $array['store_name'] =$post['store_name'];
                $array['supplier_name'] =$post['supplier_name'];
                $array['total'] =$post['tot_amt'];
                $value[] = $array;
                $count++;
            }
        }
        $count = 1;
        if($posts!=''){
            $array['purchase_date'] = '';
            $array['invoice_no'] ='';
            $array['store_name'] ='';
            $array['supplier_name'] ='Total:';
            $array['total'] =$total;
            $value[] = $array;
        }
        if(!isset($value)){
            $value='';
        }
        $dataArray = array(
            'file_name' => 'purchase_report_details'
        , 'file_title' => 'Purchase Report Details'
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
