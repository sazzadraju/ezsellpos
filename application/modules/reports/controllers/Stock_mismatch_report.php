<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_mismatch_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('stock_mismatch_report_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('stock-mismatch-report'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->stock_mismatch_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->stock_mismatch_report_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        $this->template->load('main', 'stock_mismatch_report/index', $data);
    }


    public function paginate_data()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
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
        //total rows count
        $row = $this->stock_mismatch_report_model->getRowsProducts($conditions);
        $totalRec = ($row!='')?count($row):0;
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['posts'] = $this->stock_mismatch_report_model->getRowsProducts($conditions);
        $data['stores'] = $this->stock_mismatch_report_model->getvalue_row('stores', '*', array('status_id' => 1));
        $this->load->view('stock_mismatch_report/all_stock_report_data', $data, false);
    }
    public function print_data($page = 0)
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
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
        //total rows count
        $totalRec = count($this->stock_mismatch_report_model->getRowsProducts($conditions));
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        $posts = $this->stock_mismatch_report_model->getRowsProducts($conditions);
        $report = '';
        $report .= '<table cellpadding="0" cellspacing="0">';
        $report .= '<tr class="heading">';
        $report .= '<td>' . lang("date") . '</td>';
        $report .= '<td>' . lang("send_invoice") . '</td>';
        $report .= '<td>' . lang("receive_invoice") . '</td>';
        $report .= '<td>' . lang("send-store") . '</td>';
        $report .= '<td>' . lang("receive-store") . '</td>';
        $report .= '<td>' . lang("send-qty") . '</td>';
        $report .= '<td>' . lang("receive-qty") . '</td>';
        $report .= '<td>' . lang("mismatch-qty") . '</td>
        
                </tr>';
        $qty = 0;
        if (!empty($posts)):
            $count = 1;
            foreach ($posts as $post):
                $report .= '<tr>';
                $date = date('Y-m-d', strtotime($post['dtt_add']));
                $report .= '<td>' . $date . '</td>';
                $report .= '<td>' . $post['from_invoice'] . '</td>';
                $report .= '<td>' . $post['to_invoice'] . '</td>';
                $report .= '<td>' . $post['from_store'] . '</td>';
                $report .= '<td>' . $post['to_store'] . '</td>';
                $report .= '<td>' . $post['from_qty'] . '</td>';
                $report .= '<td>' . $post['to_qty'] . '</td>';
                $report .= '<td>' . $post['mismatch_qty'] . '</td>';
                $qty = $qty + $post['mismatch_qty'];


                $report .= '<tr>';
                $count++;
            endforeach;
        else:
            $report .= '<tr>';
            $report .= '<td colspan="4"><b>' . lang("data_not_available") . '</b></td>';
            $report .= '</tr>';
        endif;

        $report .= '</table>';
        $data['report'] = $report;

        $this->load->view('print_page', $data, false);
    }
}
