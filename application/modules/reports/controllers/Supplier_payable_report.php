<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_payable_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('supplier_payable_report_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('supplier-payable-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['suppliers'] = $this->supplier_payable_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name,phone', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->supplier_payable_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->supplier_payable_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $this->template->load('main', 'supplier_payable_report/index', $data);
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
        $supplier_id = $this->input->post('supplier_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');

        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }

        $row = $this->supplier_payable_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['store'] = $this->supplier_payable_report_model->getvalue_row('stores', 'id_store,store_name', array());
        $data['posts'] = $this->supplier_payable_report_model->getRowsProducts($conditions);
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['which_store'] = $store_id;

        $this->load->view('supplier_payable_report/all_report_data', $data, false);
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
        $supplier_id = $this->input->post('supplier_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');

        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }

        $totalRec = count($this->supplier_payable_report_model->getRowsProducts($conditions));

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['store'] = $this->supplier_payable_report_model->getvalue_row('stores', 'id_store,store_name', array());
        $posts = $this->supplier_payable_report_model->getRowsProducts($conditions);
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Supplier Payable Report';
        $report = '';

        $report .= '<table cellpadding="0" cellspacing="0">';

        $report .= '<tr class="heading">';
        $report .= '<th>' . lang("supplier_name") . '</th>';
        $report .= '<th>' . lang("store") . '</th>
      <th class="right_text">' . lang("invoice_amount") .' ('.set_currency().')'. '</th>
      <th class="right_text">' . lang("paid-amt") .' ('.set_currency().')'. '</th> 
      <th class="right_text">' . lang("dues").' ('.set_currency().')' . '</th> 
                </tr>
    <tbody>';
        $count = 1;
        $tot_due = 0;
        $tot_paid = 0;
        $tot_amount = 0;
        if (!empty($posts)):

            foreach ($posts as $post):
                $report .= '<tr>';

                $report .= '<td>' . $post['supplier_name'] . '</td>';
                $report .= '<td>' . $post['store_name'] . '</td>';
                $report .= '<td class="right_text">' . $post['tot_amt'] . '</td>';
                $report .= '<td class="right_text">' . $post['paid_amt'] . '</td>';
                $report .= '<td class="right_text">' . $post['due_amt'] . '</td>';
                $tot_due = $tot_due + $post['due_amt'];
                $tot_paid = $tot_paid + $post['paid_amt'];
                $tot_amount = $tot_amount + $post['tot_amt'];
                $report .= '</tr>';
                $count++;
            endforeach;
        else:
            $report .= '<tr>
                   <td colspan="4"><b>' . lang("data_not_available") . '</b></td>
        </tr>';
        endif;
        $report .= '</tbody>
            <tfoot>
                <th></th>
                <th class="right_text">' . lang("total") . '</th>
                <th class="right_text">' . number_format($tot_amount, 2) . '</th>
                <th class="right_text">' . number_format($tot_paid, 2) . '</th>
                <th class="right_text">' . number_format($tot_due, 2) . '</th>
             </tfoot>';

        $report .= '</table>';
        $data['report'] = $report;

        $this->load->view('print_page', $data, false);
        // }
    }
    public function create_csv_data()
    {
        $store_id = $this->input->post('store_id');
        $supplier_id = $this->input->post('supplier_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');

        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($supplier_id)) {
            $conditions['search']['supplier_id'] = $supplier_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $posts = $this->supplier_payable_report_model->getRowsProducts($conditions);
        $fields = array(
            'supplier_name' => 'Supplier Name'
        , 'store' => 'Store Name'
        , 'invoice_amount' => 'Invoice Amount'
        , 'paid_amt' => 'Paid Amount'
        , 'dues' => 'Due Amount'
        );
        $tot_due=0;
        $tot_paid=0;
        $tot_amount=0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $tot_due=$tot_due+ $post['due_amt'];
                $tot_paid=$tot_paid+ $post['paid_amt'];
                $tot_amount=$tot_amount+ $post['tot_amt'];
                $value[] = array(
                    'supplier_name' => $post['supplier_name']
                , 'store' => $post['store_name']
                , 'invoice_amount' => $post['tot_amt']
                , 'paid_amt' => $post['paid_amt']
                , 'dues' => $post['due_amt']
                );
                $count++;
            }
            $value[] = array(
                'supplier_name' => ''
            , 'store' => 'Total'
            , 'invoice_amount' => number_format($tot_amount, 2)
            , 'paid_amt' => number_format($tot_paid, 2)
            , 'dues' => number_format($tot_due, 2)
            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'supplier_payable_report'
        , 'file_title' => 'Supplier Payable Report'
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
