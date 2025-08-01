<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_ledger_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('supplier_ledger_report_model');
        $this->perPage = 5000;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('supplier_ledger_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $data['suppliers'] = $this->supplier_ledger_report_model->getvalue_row('suppliers', 'id_supplier,supplier_name,phone', array('status_id' => 1));
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->supplier_ledger_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->supplier_ledger_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $this->template->load('main', 'supplier_ledger_report/index', $data);
    }


    public function paginate_data()
    {
        $conditions = array();
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
        //get posts data
        $data['posts'] = $this->supplier_ledger_report_model->getSupplierLedgerReport($conditions);
        $data['balance'] = $this->supplier_ledger_report_model->getSupplierLedgerBalance($conditions);
        $data['settle'] = $this->supplier_ledger_report_model->getSumsettleAmount($conditions);
        //print_r($data['balance']);
        $this->load->view('supplier_ledger_report/all_report_data', $data, false);
    }

    public function print_data($page = 0)
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
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Supplier Ledger Report';
        //get posts data
        $posts = $this->supplier_ledger_report_model->getSupplierLedgerReport($conditions);
        $balance = $this->supplier_ledger_report_model->getSupplierLedgerBalance($conditions);
        $settle = $this->supplier_ledger_report_model->getSumsettleAmount($conditions);
        $report = '';
        if(!empty($FromDate)){
            $report='Previous Balance: '. ($balance['total_invoice']-$balance['total_payment']);
        }
        $report .= '<table cellpadding="0" cellspacing="0">';

        $report .= '<tr class="heading">';
        $report .= '<td>' . lang("date") . '</td>';
        $report .= '<td>' . lang("trx_no") . '</td>';
        $report .= '<td>' . lang("invoice_no") . '</td>';
        $report .= '<td>' . lang("type") . '</td>';
        $report .= '<td class="right_text">' . lang("invoice_amount") .' (' .set_currency().')'. '</td>';
        $report .= '<td class="right_text">' . lang("paid_amount") .' (' .set_currency().')'. '</td>';
        $report .= '</tr>';
        $count = 1;
        $tot_due = 0;
        $tot_paid = 0;
        $tot_amount = 0;
        if (!empty($posts)):
            $newData=sortData($posts);
            foreach ($newData as $post):
                $report .= '<tr>';
                $date = date('Y-m-d', strtotime($post['dtt_add']));
                $report .= '<td>' . $date . '</td>';
                if ($post['account_id']>0) {
                    $report .= '<td>' . $post['trx_no'] . '</td>';
                } else{
                    $report .= '<td></td>';
                }
                $report .= '<td>' . $post['invoice_no'] . '</td>';
                if ($post['account_id']>0) {
                    $type=$this->supplier_ledger_report_model->get_type_name($post['trx_no']);
                    $type_name=($type!='')?' ('.$type[0]['type_name'].')':'';
                    $report .= '<td>' . account_name_id($post['account_id']) .$type_name. '</td>';
                } else{
                    $report .= '<td></td>';
                }
                if ($post['invoice_total_amt']>0) {
                    $report .= '<td class="right_text">' . $post['invoice_total_amt'] . '</td>';
                } else{
                    $report .= '<td class="right_text"></td>';
                }
                if ($post['payment_amt']>0) {
                    $report .= '<td class="right_text">' . $post['payment_amt'] . '</td>';
                } else{
                    $report .= '<td class="right_text"></td>';
                }
                $tot_paid = $tot_paid + $post['payment_amt'];
                $tot_amount = $tot_amount + $post['invoice_total_amt'];
                $report .= '</tr>';
                $count++;
            endforeach;
        else:
            $report .= '<tr>';
            $report .= '<td colspan="4"><b>' . lang("data_not_available") . '</b></td>
                  </tr>';
        endif;
        $due_amount=$tot_amount-$tot_paid;
        $report .= '</tbody>
              <tfoot>
				<tr>
                <th></th>
                <th></th>
                <th></th>
                <th class="right_text">' . lang("total") . '</th>
                <th class="right_text">' . number_format($tot_amount, 2, '.', '') . '</th>
                <th class="right_text">' . number_format($tot_paid, 2, '.', ''). '</th>
				</tr>
				<tr>
                    <th colspan="4"></th>
                    <th class="right_text">Due Amount:</th>
                    <th class="right_text">'. number_format($due_amount, 2, '.', '').'</th>
				</tr>
                <tr>
                    <th colspan="4"></th>
                    <th class="right_text">Settle Amount:</th>
                    <th class="right_text">'. number_format($settle[0]['total_settle'], 2, '.', '').'</th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                    <th class="right_text">Actual Due Amount:</th>
                    <th class="right_text">'. number_format(($due_amount-$settle[0]['total_settle']), 2, '.', '').'</th>
                </tr>
              </tfoot>
            </table>';
        $data['report'] = $report;
        $this->load->view('print_page', $data, false);
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
        //get posts data
        $posts = $this->supplier_ledger_report_model->getSupplierLedgerReport($conditions);
        $balance = $this->supplier_ledger_report_model->getSupplierLedgerBalance($conditions);
        $settle = $this->supplier_ledger_report_model->getSumsettleAmount($conditions);
        $fields = array(
            'date' => 'Date'
        , 'trx_no' => 'transaction No'
        , 'invoice_no' => 'Invoice No'
        , 'type' => 'Type'
        , 'invoice_amount' => 'Invoice Amount'
        , 'paid_amount' => 'Paid Amount'
        );

        $tot_paid = 0;
        $tot_amount = 0;
		$account_name='';
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                $trn_no='';
                $account_name='';
                $tot_paid = $tot_paid+$post['payment_amt'];
                $tot_amount =$tot_amount+$post['invoice_total_amt'];
                if ($post['account_id']>0) {
                    $trn_no=$post['trx_no'];
                    $type=$this->supplier_ledger_report_model->get_type_name($post['trx_no']);
                    $type_name=($type!='')?' ('.$type[0]['type_name'].')':'';
                    $account_name = account_name_id($post['account_id']) .$type_name;
                }
                $value[] = array(
                    'date' => date('Y-m-d', strtotime($post['dtt_add']))
                , 'trx_no' => $trn_no
                , 'invoice_no' => $post['invoice_no']
                , 'type' => $account_name
                , 'invoice_amount' => $post['invoice_total_amt']
                , 'paid_amount' => $post['payment_amt']

                );
                $count++;
            }
            $value[] = array(
                'date' => ''
            , 'trx_no' => ''
            , 'invoice_no' => ''
            , 'type' => 'Total'
            , 'invoice_amount' => $tot_amount
            , 'paid_amount' => $tot_paid

            );
            $due_amount=$tot_amount-$tot_paid;
            $value[] = array(
                'date' => ''
                , 'trx_no' => ''
                , 'invoice_no' => ''
                , 'type' => ''
                , 'invoice_amount' => 'Due Amount'
                , 'paid_amount' => number_format($due_amount, 2, '.', '')
            );
            $value[] = array(
                'date' => ''
                , 'trx_no' => ''
                , 'invoice_no' => ''
                , 'type' => ''
                , 'invoice_amount' => 'Settle Amount'
                , 'paid_amount' => number_format($settle[0]['total_settle'], 2, '.', '')
            );
            $value[] = array(
                'date' => ''
                , 'trx_no' => ''
                , 'invoice_no' => ''
                , 'type' => ''
                , 'invoice_amount' => 'Actual Due Amount'
                , 'paid_amount' => number_format(($due_amount-$settle[0]['total_settle']), 2, '.', '')
            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'supplier_ledger_report'
        , 'file_title' => 'Supplier Ledger Report'
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
