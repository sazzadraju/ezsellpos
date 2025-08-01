<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('purchase_report_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('purchase_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();


        $data['suppliers'] = $this->purchase_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
        $data['customers'] = $this->purchase_report_model->getvalue_row('customers', 'id_customer,full_name', array('status_id' => 1));
        $data['products'] = $this->commonmodel->getvalue_row('products', 'id_product,product_code,product_name', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->purchase_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->purchase_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $data['categories'] = $this->purchase_report_model->getvalue_row('product_categories', 'cat_name,id_product_category,parent_cat_id', array('status_id' => 1));
        $this->template->load('main', 'purchase_report/index', $data);
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
        $product_name = $this->input->post('product_name');
        $ToDate = $this->input->post('ToDate');
        $cat_name = $this->input->post('cat_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $supplier_id = $this->input->post('supplier_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $batch_no = $this->input->post('batch_no');
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
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
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        $row = $this->purchase_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'purchase-report/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['posts'] = $this->purchase_report_model->getRowsProducts($conditions);

        $this->load->view('purchase_report/all_report_data', $data, false);
        // }
    }

    public function print_data($page = 0)
    {
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $store_id = $this->input->post('store_id');
        $product_name = $this->input->post('product_name');
        $ToDate = $this->input->post('ToDate');
        $cat_name = $this->input->post('cat_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $supplier_id = $this->input->post('supplier_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $batch_no = $this->input->post('batch_no');
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
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
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        $totalRec = count($this->purchase_report_model->getRowsProducts($conditions));
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Purchase Report';
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'purchase-report/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $posts = $this->purchase_report_model->getRowsProducts($conditions);

        $report = '';
        $report .= '<table cellpadding="0" cellspacing="0">';

        $report .= '<tr class="heading">';
        $report .= '<td>' . lang("purchase_date") . '</td>';
        $report .= '<td>' . lang("product_name") . '</td>';
        $report .= '<td>' . lang("product_code") . '</td>';
        $report .= '<td>' . lang("batch_no") . '</td>';
        $report .= '<td>' . lang("category") . '</td>';
        $report .= '<td>' . lang("sub_category") . '</td>';
        $report .= '<td>' . lang("store_name") . '</td>';
        $report .= '<td>' . lang("supplier_name") . '</td>';
        $report .= '<td class="right_text">' . lang("purchase_price") . '</td>';
        $report .= '<td class="right_text">' . lang("qty") . '</td>';
        $report .= '<td class="right_text">' . lang("total") . '</td>';
        $report .= ' </tr>
    <tbody>';
        $qty = 0;
        $total=0;
        if (!empty($posts)):

            $count = 1;
            foreach ($posts as $post):
                $report .= '<tr>';
                $val = '';

                $report .= '<td>' . $post['dtt_add'] . '</td>';
                $report .= '<td>' . $post['product_name'] . '</td>';
                 $report .= '<td>'. $post['product_code'] . '</td>';
                $report .= '<td>' . $post['batch_no'] . '</td>';
                $report .= '<td>' . $post['cat_name'] . '</td>';
                $report .= '<td>' . $post['subcat_name'] . '</td>';
                $report .= '<td>' . $post['store_name'] . '</td>';
                $report .= '<td>' . $post['supplier_name'] . '</td>';
                $report .= '<td class="right_text">' . set_currency($post['purchase_price']) . '</td>';
                $report .= '<td class="right_text">' . $post['qty'] . '</td>';
                $qty = $qty + $post['qty'];
                $total += $post['purchase_price'] * $post['qty'];
                $report .= '<td class="right_text">' .  $post['purchase_price'] * $post['qty'] . '</td>';
                $report .= '</tr>';
                $count++;
            endforeach;
        else:
            $report .= '<tr>';
            $report .= '<td colspan="4"><b>' . lang("data_not_available") . '</b></td>';
            $report .= '</tr>';
        endif;
        $report .= '</tbody>
<tfoot>
  <td colspan="7"></th>
  <td>' . lang("total") . '</td>
  <td></td>
  <td class="right_text">' . number_format($qty, 2) . '</td>
  <td class="right_text">' . number_format($total, 2) . '</td>
</tfoot>
            </table>';
        $data['report'] = $report;
        $this->load->view('print_page', $data, false);
        // }
    }
    public function create_csv_data()
    {
        $conditions = array();
        $store_id = $this->input->post('store_id');
        $product_name = $this->input->post('product_name');
        $cat_name = $this->input->post('cat_name');
        $pro_sub_category = $this->input->post('pro_sub_category');
        $supplier_id = $this->input->post('supplier_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        $batch_no = $this->input->post('batch_no');
        if (!empty($batch_no)) {
            $conditions['search']['batch_no'] = $batch_no;
        }
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
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        $posts = $this->purchase_report_model->getRowsProducts($conditions);
        $fields = array(
            'purchase_date' => 'Purchase Date'
        , 'product_name' => 'Product Name'
        , 'product_code' => 'Product Code'
        , 'batch_no' => 'Batch No'
        , 'category' => 'Category'
        , 'sub_category' => 'Sub Category'
        , 'store_name' => 'Store Name'
        , 'supplier_name' => 'Supplier Name'
        , 'purchase_price' => 'Purchase Price'
        , 'qty' => 'Qty'
        , 'total' => 'Total'
        );
        $sum_qty = 0;
        $total = 0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $total += $post['purchase_price'] * $post['qty'];
                $sum_qty += $post['qty'];
                $value[] = array(
                    'purchase_date' => $post['dtt_add']
                , 'product_name' => $post['product_name']
                , 'product_code' =>  $post['product_code']
                , 'batch_no' =>  $post['batch_no']
                , 'category' => $post['cat_name']
                , 'sub_category' => $post['subcat_name']
                , 'store_name' => $post['store_name']
                , 'supplier_name' => $post['supplier_name']
                , 'purchase_price' => $post['purchase_price']
                , 'qty' => $post['qty']
                , 'total' => $post['purchase_price'] * $post['qty']

                );
                $count++;
            }
            $value[] = array(
                'purchase_date' => ''
            , 'product_name' => ''
            , 'product_code' => ''
            , 'batch_no' => ''
            , 'category' => ''
            , 'sub_category' => ''
            , 'store_name' => ''
            , 'supplier_name' => ''
            , 'purchase_price' => 'Total'
            , 'qty' => $sum_qty
            , 'total' =>$total

            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'purchase_report'
        , 'file_title' => 'Purchase Report'
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
