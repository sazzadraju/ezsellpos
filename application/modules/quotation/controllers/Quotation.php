<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('en');
        $this->load->model('quotation_m');
        $this->load->model('auto_increment');
        $this->perPage = 20;

    }

    public function index()
    {
        $this->dynamic_menu->check_menu('quotation');
        $totalRec = 0; 
        $serRow = $this->quotation_m->getQuotationRows();
        if($serRow != NULL){
            $totalRec = count($this->quotation_m->getQuotationRows());
        }   

        $config['target']      = '#postList';
        $config['base_url']    = base_url().'quotation/quotationAjaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $this->ajax_pagination->initialize($config);
        $data['all_quotation'] = $this->quotation_m->getQuotationRows(array('limit'=>$this->perPage));
        $this->template->load('main', 'quotation_index', $data);
    }

    public function quotationAjaxPaginationData(){
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //total rows count
        $totalRec = count($this->quotation_m->getQuotationRows());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'quotation/quotationAjaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['all_quotation'] = $this->quotation_m->getQuotationRows(array('start'=>$offset,'limit'=>$this->perPage));
        
        //load the view
        $this->load->view('quotation/quotation-ajax-pagination-data', $data, false);
    }

    public function add(){
        $this->dynamic_menu->check_menu('quotation/add');
        $data['all_customer'] = $this->quotation_m->get_all_customer();
        $this->template->load('main', 'quotation_add', $data);
    }

    public function edit(){
        $this->dynamic_menu->check_menu('quotation/edit');
        $qid = $this->uri->segment(3);        
        $data['all_customer']   = $this->quotation_m->get_all_customer();
        $data['qMaster']        = $this->quotation_m->getQuotationMasterById($qid);
        $data['qDetails']       = $this->quotation_m->getQuotationDetailById($qid);

        $this->template->load('main', 'quotation_edit', $data);
    }

    public function view(){
        $this->dynamic_menu->check_menu('quotation/view');
        $qid = $this->uri->segment(3);
        $data['id']=$qid;
        $qtNo = $this->quotation_m->getQuotationNo($qid); 
        $data['all_quotation'] = $this->quotation_m->get_all_quotation($qtNo[0]['quotation_no']);
        $data['qMaster']        = $this->quotation_m->getQuotationMasterById($qid);
        $data['qDetails']       = $this->quotation_m->getQuotationDetailById($qid);

        $this->template->load('main', 'quotation_view', $data);
    }

    public function print(){
        $this->load->library('barcode');
        $this->dynamic_menu->check_menu('quotation/print');
        $qid = $this->uri->segment(3);

        $data['qMaster']        = $this->quotation_m->getQuotationMasterById($qid);
        $data['qDetails']       = $this->quotation_m->getQuotationDetailById($qid);

        $data['sellerName'] = $this->quotation_m->getSellerName($data['qMaster'][0]['uid_add']);
        $data['store_info'] = $this->quotation_m->getStoreInfo($data['qMaster'][0]['store_id']);
        $data['settings'] = $this->commonmodel->invoice_setting_report('full');
        $data['store'] = $this->commonmodel->getvalue_row_one('stores', '*', array('id_store' => $this->session->userdata['login_info']['store_id']));

        $this->load->view('quotation_print', $data);
    }


    public function get_available_stock_in_products(){
        $request = $_REQUEST['request'];
        $product_list = $this->quotation_m->get_available_stock_in_products($request);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->product_name.'( '.$list->batch_no.' )',
                "value" => $list->product_id,
                "batch_no" => $list->batch_no,
                "buy_price" => $list->buy_price,
                "sell_price" => $list->sell_price,
                "pro_code" => $list->product_code,
                "is_vatable" => $list->is_vatable
            );
        }
        echo json_encode($return);
    }

    public function get_all_products(){

        $request = $_REQUEST['request'];
        $product_list = $this->quotation_m->get_all_products($request);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->product_name,
                "value" => $list->id_product
            );
        }
        echo json_encode($return);        
    }

    public function QuotationAddRow(){
        $data['cb'] = $_POST['cb'];
        $data['disType'] = $_POST['disType'];  

        $data['pDetails'] = $this->quotation_m->getProductDetail($_POST);
        $this->load->view('quotation_row.php', $data);

    }

    public function Quotation_insert(){

        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';

        // die();

        $this->form_validation->set_rules('quotationNo', 'Quotation No', 'required');
        $this->form_validation->set_rules('customerId', 'Customer', 'required');

        if ($this->form_validation->run() == FALSE){
            $data = array(
                'quotationNo' => form_error('quotationNo'),
                'customerId' => form_error('customerId')
            );
            echo json_encode($data);
        }else{
            $version = $this->quotation_m->count_table('quotation_master', 'quotation_no',$_POST['quotationNo']);
            if(empty($_POST['note'])){
                $note = 'NULL';
            }else{
                $note = $_POST['note'];
            }
            
            $vat_amt = 0;
            $vi = 0;
            foreach ($_POST['vat_amt'] as $aVatAmt) {
                $vat_amt += $_POST['vat_amt'][$vi];
                $vi++;
            }
            
            if(empty($_POST['finalTotDisAmt'])){
                $discount_amt = '0.00';
            }else{
                $discount_amt = $_POST['finalTotDisAmt'];
            }
            $quotation_master = array(
                'quotation_no'  => $_POST['quotationNo'],
                'rivision_no'   => $version+1,
                'customer_id'   => $_POST['customerId'],
                'store_id'      => $_SESSION['login_info']['store_id'],
                'station_id'    => $_SESSION['login_info']['station_id'],
                'note'          => $note,
                'product_amt'   => $_POST['subTotal'],
                'vat_amt'       => $vat_amt,
                'discount_amt'  => $discount_amt,
                'total_amt'     => $_POST['finalTotAmt'],
                'dtt_add'       => date("Y-m-d H:i:s"),
                'uid_add'       => $_SESSION['login_info']['id_user_i90']
            );        
            $pCount = count($_POST['uniqueFld']);
            for ($i=0; $i < $pCount; $i++) { 
                $quotation_details[] = array(
                    'product_id'    =>  $_POST['id_product'][$i],
                    'batch_no'      => $_POST['batch_no'][$i],
                    'qty'           => $_POST['qty'][$i],
                    'selling_price' => $_POST['sell_price'][$i],
                    'discount_rate' => $_POST['discountP'][$i],
                    'discount_amt'  => $_POST['discountA'][$i],
                    'vat_rate'      => $_POST['aVat'][$i],
                    'vat_amt'       => $_POST['vat_amt'][$i],
                    'total_amt'     => $_POST['total_price'][$i]
                );
            }
            $quotation_id = $this->quotation_m->insert_into_quotation($quotation_master, $quotation_details);
            $this->session->set_flashdata('success', 'Quotation Successfully Added');
            echo $quotation_id[0]['insert_id'];
            // echo $quotation_master;
        }
          
    }

}
