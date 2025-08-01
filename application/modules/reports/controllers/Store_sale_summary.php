<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Store_sale_summary extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }

        $this->load->model('store_sale_summary_model');
        $this->perPage = 500;
    }

    public function index()
    {
        $data = array();
        $this->breadcrumb->add(lang('store_sale_summary'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        // $totalRec = count($this->sell_summary_model_2->getRowsProducts());
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'store_sale_summary/page_data';
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $type = $this->session->userdata['login_info']['user_type_i92'];
        $selected_shop = $this->session->userdata['login_info']['store_id'];
        if ($type != 3) {
            $data['stores'] = $this->store_sale_summary_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1, 'id_store' => $selected_shop));
        } else if ($type == 3) {
            $data['stores'] = $this->store_sale_summary_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        }
        //$data['posts'] = $this->store_sale_summary_model->getRowsProducts(array('limit' => $this->perPage), '');
        $this->template->load('main', 'store_sale_summary/index', $data);
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
        // dd($store_id);
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $row = $this->store_sale_summary_model->getRowsProducts($conditions, $store_id);
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
        $data['discounts'] = $this->store_sale_summary_model->store_promotion_list($conditions, $store_id);
        $data['payments'] = $this->store_sale_summary_model->sale_transaction_details($store_id);
        $data['posts'] = $this->store_sale_summary_model->getRowsProducts($conditions, $store_id);
        $data['fdate'] = $FromDate;
        $this->load->view('store_sale_summary/all_report_data', $data, false);
        // }
    }

    public function print_data($page = 0)
    {
        //$this->print_data2();
        $conditions = array();
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $store_id = $this->input->post('store_id');
        $FromDate = $this->input->post('FromDate');
        $ToDate = $this->input->post('ToDate');
        if (!empty($FromDate)) {
            $conditions['search']['FromDate'] = $FromDate . ' 00:00:00';
            $conditions['search']['ToDate'] = $ToDate . ' 23:59:59';
        }
        $totalRec = count($this->store_sale_summary_model->getRowsProducts($conditions, $store_id));

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

        $posts = $this->store_sale_summary_model->getRowsProducts($conditions, $store_id);
        $discounts = $this->store_sale_summary_model->store_promotion_list($conditions, $store_id);

        $data['fdate'] = $FromDate;
        $data['tdate'] = $ToDate;
        $data['title'] = 'Store Sale Summary';
        $report = '<table cellpadding="0" cellspacing="0">';
        $report .= '<tr class="heading">';

        $report .= '<tr class="heading">';
        $report .= '<td>' . lang("sl") . '</td>';
        $report .= '<td>' . lang("store_name") . '</td>';
        $report .= '<td class="right_text">' . lang("invoice_amount") . '</td>';
        $report .= '<td class="right_text">' . lang("discount_amount") . '</td>';
        $report .= '<td class="right_text">' . lang("paid-amt") . '</td>';
        $report .= '<td class="right_text">' . lang("due_amount") . '</td>';
        $report .= '</tr><tbody>';
        $sum = 0;
        $invoice_sum=$paid_sum=$due_sum=$discount_sum=0;
        if (!empty($posts)):
            $count = 1;
            // print_r($posts);
            foreach ($posts as $post):
                $discount=0;
                foreach ($discounts as $key) {
                   if($key['store_id']==$post['store_id']){
                        $discount=$key['discount_amt'];
                        break;
                   }
                }
                $report .= '<tr>';

                $report .= '<td id="invoiceNo">'.$count.'</td>';
                $date = date('Y-m-d', strtotime($post['dtt_add']));
                $report .= '<td>' . $post['store_name'] . '</td>';
                $report .= '<td class="right_text">' . ($post['tot_amt']) . '</td>';
                $report .= '<td class="right_text">' .  $discount . '</td>';
                $report .= '<td class="right_text">' . ($post['paid_amt']) . '</td>';
                $report .= '<td class="right_text">' . ($post['due_amt']) . '</td>';
                $invoice_sum+=$post['tot_amt'];
                $paid_sum+=$post['paid_amt'];
                $due_sum+=$post['due_amt'];
                $discount_sum+=$discount;
                $report .= '</tr>';
                $count++;
            endforeach;
        else:
            $report .= '<tr>';
            $report .= '<td colspan="4"><b>' . lang("data_not_available") . '</b></td>';
            $report .= '</tr>';
        endif;
        $report .= '</tbody><tfoot><th></th>';

        $report .= '<th>' . lang("total") . '</th>';
        $report .= '<th class="right_text">' . number_format($invoice_sum, 2, '.', '') . '</th>';
        $report .= '<th class="right_text">' . number_format($discount_sum, 2, '.', '') . '</th>';
        $report .= '<th class="right_text">' . number_format($paid_sum, 2, '.', '') . '</th>';
        $report .= '<th class="right_text">' . number_format($due_sum, 2, '.', '') . '</th>';
        $report .= '</tfoot> </table>';
        $data['report'] = $report;
        $this->load->view('print_page', $data);
    }


}
