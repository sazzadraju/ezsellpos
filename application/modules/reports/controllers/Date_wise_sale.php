<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Date_wise_sale extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('date_wise_sale_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('sell_report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();

        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->date_wise_sale_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->date_wise_sale_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        //$data['posts'] = $this->date_wise_sale_model->getRowsProducts(array('limit' => $this->perPage));

        $this->template->load('main', 'date_wise_sale/index', $data);
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
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $data['store'] = $this->date_wise_sale_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $row = $this->date_wise_sale_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'date-wise-sale/page_data';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        $data['posts'] = $this->date_wise_sale_model->getRowsProducts($conditions);
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['which_store'] = $store_id;
        $this->load->view('date_wise_sale/all_report_data', $data, false);
        // }
    }

    public function print_data($page = 0)
    {
        $conditions = array();
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $totalRec = count($this->date_wise_sale_model->getRowsProducts($conditions));
        //get posts data
        $posts = $this->date_wise_sale_model->getRowsProducts($conditions);
        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Date Wise Sale';
        $data['which_store'] = $store_id;
        $report = '';
        $report .= '<table cellpadding="0" cellspacing="0">';

        $report .= '<tr class="heading">';
        $report .= '<th>' . lang("sl") . '</th>';
        $report .= '<th>' . lang("date") . '</th>';
        $report .= '<td class="right_text">' . lang("invoice_amount") . '</td>';
        $report .= '<td class="right_text">' . lang("cash") . '</td>';
        $report .= '<td class="right_text">' . lang("bank") . '</td>';
        $report .= '<td class="right_text">' . lang("mobile") . '</td>';
        $report .= '<td class="right_text">' . lang("paid-amt") . '</td>';
        $report .= '<td class="right_text">' . lang("due_amount") . '</td>';
        $report .= '</tr><tbody>';
        $sum = 0;
        $invoice_sum = $paid_sum = $due_sum =$cash_total = $bank_total = $mobile_total = 0;
        if (!empty($posts)):
            $count = 1;
            foreach ($posts as $post):
                $transactions = $this->commonmodel->sale_transaction_by_date(explode(' ',$post['dtt_add'])[0],$post['store_id']);
                $cash = $bank = $mobile = 0;
                foreach ($transactions as $tran) {
                    if ($tran['payment_method_id'] == 1) {
                        $cash = $tran['amount'];
                        $cash_total += $tran['amount'];
                    } elseif ($tran['payment_method_id'] == 3) {
                        $mobile = $tran['amount'];
                        $mobile_total += $tran['amount'];
                    } else {
                        $bank = $tran['amount'];
                        $bank_total += $tran['amount'];
                    }
                }
                $report .= '<tr>';
                $report .= '<td id="invoiceNo">' . $count . '</td>';
                $date = date('Y-m-d', strtotime($post['dtt_add']));
                $report .= '<td>' . $date . '</td>';
                $report .= '<td class="right_text">' . ($post['tot_amt']) . '</td>';
                $report .= '<td class="right_text">' . $cash . '</td>';
                $report .= '<td class="right_text">' . $bank . '</td>';
                $report .= '<td class="right_text">' . $mobile . '</td>';
                $report .= '<td class="right_text">' . ($post['paid_amt']) . '</td>';
                $report .= '<td class="right_text">' . ($post['due_amt']) . '</td>';
                $invoice_sum+=$post['tot_amt'];
                $paid_sum+=$post['paid_amt'];
                $due_sum+=$post['due_amt'];
                $report .= '</tr>';
                $count++;
            endforeach;
        else:
            $report .= '<tr>';
            $report .= '<td colspan="4"><b>' . lang("data_not_available") . '</b></td>
            </tr>';
        endif;
        $report .= '</tbody><tfoot><th></th>';
        $report .= '<th>' . lang("total") . '</th>';
        $report .= '<th class="right_text">' . number_format($invoice_sum, 2, '.', '') . '</th>';
        $report .= '<th class="right_text">' . number_format($cash_total, 2, '.', '') . '</th>';
        $report .= '<th class="right_text">' . number_format($bank_total, 2, '.', '') . '</th>';
        $report .= '<th class="right_text">' . number_format($mobile_total, 2, '.', '') . '</th>';
        $report .= '<th class="right_text">' . number_format($paid_sum, 2, '.', '') . '</th>';
        $report .= '<th class="right_text">' . number_format($due_sum, 2, '.', '') . '</th>';
        $report .= '</tfoot>';
        $report .= '</table>';
        $data['report'] = $report;
        $this->load->view('print_page', $data, false);
    }
    public function create_csv_data()
    {
        $conditions = array();
        $store_id = $this->input->post('store_id');
        $ToDate = $this->input->post('ToDate');
        $FromDate = $this->input->post('FromDate');
        if (!empty($store_id)) {
            $conditions['search']['store_id'] = $store_id;
        }
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $posts = $this->date_wise_sale_model->getRowsProducts($conditions);
        $fields = array(
            'sl' => 'SL'
        , 'date' => 'Date'
        , 'invoice_amount' => 'Invoice amount'
        , 'cash' => 'Cash'
        , 'bank' => 'Bank'
        , 'mobile' => 'Mobile'
        , 'paid_amount' => 'Paid Amount'
        , 'due_amount' => 'Due Amount'
        );
        $sum_due = 0;
        $sum_paid = 0;
        $total = 0;
        $cash_total = $bank_total = $mobile_total=0;
        if ($posts != '') {
            $count = 1;
            foreach ($posts as $post) {
                 $transactions = $this->commonmodel->sale_transaction_by_date(explode(' ',$post['dtt_add'])[0],$post['store_id']);
                $cash = $bank = $mobile = 0;
                foreach ($transactions as $tran) {
                    if ($tran['payment_method_id'] == 1) {
                        $cash = $tran['amount'];
                        $cash_total += $tran['amount'];
                    } elseif ($tran['payment_method_id'] == 3) {
                        $mobile = $tran['amount'];
                        $mobile_total += $tran['amount'];
                    } else {
                        $bank = $tran['amount'];
                        $bank_total += $tran['amount'];
                    }
                }
                $total += $post['tot_amt'];
                $sum_paid += $post['paid_amt'];
                $sum_due += $post['due_amt'];
                $value[] = array(
                    'sl' => $count
                , 'date' => date('Y-m-d', strtotime($post['dtt_add']))
                , 'invoice_amount' => $post['tot_amt']
                , 'cash' => $cash
                , 'bank' => $bank
                , 'mobile' => $mobile
                , 'paid_amount' => $post['paid_amt']
                , 'due_amount' => $post['due_amt']
                );
                $count++;
            }
            $value[] = array(
                'sl' => ''
            , 'date' => 'Total'
            , 'total' => $total
            , 'cash' => $cash_total
            , 'bank' => $bank_total
            , 'mobile' => $mobile_total
            , 'paid' => $sum_paid
            , 'due' => $sum_due
            );
        }else{
            $value='';
        }
        $dataArray = array(
            'file_name' => 'date_wise_sale'
        , 'file_title' => 'Date Wise Sale Report'
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
