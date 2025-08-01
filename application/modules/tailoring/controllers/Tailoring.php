<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tailoring extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }
        $this->load->library('form_validation');
        $this->load->model('Tailoring_m');
        $this->load->model('auto_increment');
		$this->load->library('Ajax_pagination');
        $this->perPage = 20;
    }

    public function index()
    {

        $data = array();    
        $totalRec = 0;    
        //total rows count
        $serRow = $this->Tailoring_m->getServiceRows();
        if($serRow != NULL){
            $totalRec = count($this->Tailoring_m->getServiceRows());
        }      
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'tailoring/serviceAjaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $this->ajax_pagination->initialize($config);        
        //get the posts data
        $data['services'] = $this->Tailoring_m->getServiceRows(array('limit'=>$this->perPage));        

        $this->template->load('main', 'tailoring_index', $data);
    }

    public function serviceAjaxPaginationData(){
      $page = $this->input->post('page');
      if(!$page){
          $offset = 0;
      }else{
          $offset = $page;
      }      
      //total rows count
      $totalRec = count($this->Tailoring_m->getServiceRows());      
      //pagination configuration
      $config['target']      = '#postList';
      $config['base_url']    = base_url().'tailoring/serviceAjaxPaginationData';
      $config['total_rows']  = $totalRec;
      $config['per_page']    = $this->perPage;
      $this->ajax_pagination->initialize($config);      
      //get the posts data
      $data['services'] = $this->Tailoring_m->getServiceRows(array('start'=>$offset,'limit'=>$this->perPage));      
      // load the view
      $this->load->view('tailoring/service_list_pagination_data', $data, false);
    }

    public function service_create()
    {
        $this->template->load('main', 'service_create');
    }

    public function service_insert()
    {
        $this->load->helper('date');

        // tailoring_types table data

        $dsNames = $this->input->post('sName');
        $dsPrices = $this->input->post('sPrice');

        // validation

        $this->form_validation->set_rules('sName', 'Service name', 'trim|required');
        $this->form_validation->set_rules('sPrice', 'Service Price', 'trim|required|numeric');


        $tailoring_types = array(
            'service_name' => $dsNames,
            'service_price' => $dsPrices,
            'dtt_add' => mdate("%Y-%m-%d %H:%i:%s"),
            'uid_add' => 1
        );


        // tailoring_fields table data

        $cMeasures = $this->input->post('cMeasure');
        $fieldNames = $this->input->post('fieldName');

        $fSta = $this->input->post('fSta');

        $cmc = 0;
        foreach ($cMeasures as $scMas) {
            $dfieldName = $fieldNames[$cmc];

            if (empty($fSta[$cmc])) {
                $dfSta = 2;
            } else {
                $dfSta = 1;
            }

            // validation
            $this->form_validation->set_rules('fieldName[' . $cmc . ']', 'Field Name', 'trim|required');


            $tailoring_fields[] = array(
                'field_type_id' => 1, // measurement
                'field_name' => $dfieldName,
                'is_required' => $dfSta
            );
            $cmc++;

        }

        // tailoring_designs table data

        $oldfiles = $this->input->post('oldfiles');

        $designNames = $this->input->post('designName');
        $dDescs = $this->input->post('dDesc');

        $this->load->library('upload');
        $files = $_FILES;
        $cDesigns = $this->input->post('cDesign');
        $cdc = 0;
        $fileName = '';
        foreach ($cDesigns as $cDesign) {

            $designName = $designNames[$cdc];
            $dDesc = $dDescs[$cdc];

            // validation
            // $this->form_validation->set_rules('designName[' . $cdc . ']', 'Design Name', 'trim|required');
            // $this->form_validation->set_rules('dDesc[' . $cdc . ']', 'Design description', 'trim|required');
            // $this->form_validation->set_rules('userfile['.$cdc.']', 'File Upload', 'trim|required');

            if ($files['userfile']['name'][$cdc] == '') {
                $fileName = $oldfiles[$cdc];
            } else {

                $_FILES['userfile']['name'] = $files['userfile']['name'][$cdc];
                $_FILES['userfile']['type'] = $files['userfile']['type'][$cdc];
                $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$cdc];
                $_FILES['userfile']['error'] = $files['userfile']['error'][$cdc];
                $_FILES['userfile']['size'] = $files['userfile']['size'][$cdc];
                $fileName = upload_file('tailoring', $_FILES['userfile']);
            }

            $tailoring_designs[] = array(
                'field_type_id' => 2,
                'field_name' => $designName,
                'field_img' => $fileName,
                'notes' => $dDesc
            );

            $cdc++;
        }


        $tailoringAllFields = array_merge($tailoring_fields, $tailoring_designs);


        if ($this->form_validation->run() == FALSE) {


            // echo validation_errors();


            $data['tailoring_types'] = $tailoring_types;
            $data['tailoring_fields'] = $tailoring_fields;
            $data['tailoring_designs'] = $tailoring_designs;
            $this->template->load('main', 'service_create', $data);

        } else {
            $ttid = $this->Tailoring_m->insert_tailoring_types_fields_designs($tailoring_types, $tailoringAllFields);

            if ($ttid[0]['insert_id'] > 0) {
                $this->session->set_flashdata('success', 'Tailoring service insert succesfully');
            }

            redirect(base_url() . 'tailoring');
        }

    }

    public function service_view()
    {
        $data['sid'] = $this->input->get('sid');
        $data['aService'] = $this->Tailoring_m->getServiceById($data['sid']);
        $this->load->view('tailoring_view', $data);
    }

    public function edit()
    {
        $id = $this->uri->segment(3);

        if (empty($id)) {
            die('404 Error');
        }
        $data['updateid'] = $id;
        $data['aServiceData'] = $this->Tailoring_m->getServiceById($id);

        // echo '<pre>';
        // print_r($data['aServiceData']);
        // die();
        $this->template->load('main', 'service_edit', $data);

    }

    public function service_update()
    {
        $this->load->helper('date');

        // tailoring_types table data

        $updateid = $this->input->post('updateid');
        $dsNames = $this->input->post('sName');
        $dsPrices = $this->input->post('sPrice');

        // $deletedDesign = $this->input->post('deletedDesign'); 

        // validation

        $this->form_validation->set_rules('sName', 'Service name', 'trim|required');
        $this->form_validation->set_rules('sPrice', 'Service Price', 'trim|required|numeric');

        $tailoring_types = array(
            'id_service' => $updateid,
            'service_name' => $dsNames,
            'service_price' => $dsPrices,
            'dtt_mod' => mdate("%Y-%m-%d %H:%i:%s"),
            'uid_mod' => 1
        );


        // tailoring_fields table data

        $cMeasures = $this->input->post('cMeasure');
        $fieldNames = $this->input->post('fieldName');

        $fSta = $this->input->post('fSta');

        $dfieldName = '';
        $cmc = 0;
        foreach ($cMeasures as $scMas) {

            if(isset($fieldNames[$cmc])){
                $dfieldName = $fieldNames[$cmc];
            }
            

            if (empty($fSta[$cmc])) {
                $dfSta = 2;
            } else {
                $dfSta = 1;
            }

            // validation
            $this->form_validation->set_rules('fieldName[' . $cmc . ']', 'Field Name', 'trim|required');


            $tailoring_fields[] = array(
                'field_type_id' => 1, // measurement
                'service_id' => $updateid,
                'field_name' => $dfieldName,
                'is_required' => $dfSta
            );
            $cmc++;

        }

        // tailoring_designs table data

        $oldfiles = $this->input->post('oldfiles');

        $designNames = $this->input->post('designName');
        $dDescs = $this->input->post('dDesc');

        $this->load->library('upload');
        $files = $_FILES;
        $cDesigns = $this->input->post('cDesign');
        $designName = '';
        $dDesc = '';
        $cdc = 0;
        foreach ($cDesigns as $cDesign) {

            if(isset($designNames[$cdc])){                
                $designName = $designNames[$cdc];
            }
            if(isset($dDescs[$cdc])){                
                $dDesc = $dDescs[$cdc];
            }            

            // validation

            // $this->form_validation->set_rules($designName, 'Design Name', 'trim|required');
            // $this->form_validation->set_rules($dDesc, 'Design description', 'trim|required');

            if(!empty($files['userfile']['name'][$cdc])){
                delete_file('tailoring', $oldfiles[$cdc]);
                $_FILES['userfile']['name'] = $files['userfile']['name'][$cdc];
                $_FILES['userfile']['type'] = $files['userfile']['type'][$cdc];
                $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$cdc];
                $_FILES['userfile']['error'] = $files['userfile']['error'][$cdc];
                $_FILES['userfile']['size'] = $files['userfile']['size'][$cdc];
                $fileName = upload_file('tailoring', $_FILES['userfile']);
            }else{
                $fileName = $oldfiles[$cdc];
            }    
            $tailoring_designs[] = array(
                'field_type_id' => 2,
                'service_id' => $updateid,
                'field_name' => $designName,
                'field_img' => $fileName,
                'notes' => $dDesc
            );

        
            $cdc++;
        }


        $tailoringAllFields = array_merge($tailoring_fields, $tailoring_designs);


        // remove deleted design image from s3

        // if(!empty($deletedDesign)){
        //     foreach ($deletedDesign as $dDvalue) {
        //         delete_file('tailoring', $dDvalue);
        //     }

        // }

        $ttid = $this->Tailoring_m->update_tailoring_types_fields_designs($tailoring_types, $tailoringAllFields);

        if ($ttid[0]['insert_id'] > 0) {

            $this->session->set_flashdata('success', 'Tailoring service update succesfully');
        }
        redirect(base_url() . 'tailoring');
    }

    public function service_delete()
    {
        $sid = $this->input->get('sid');
        $aService = $this->Tailoring_m->serviceDelete($sid);
        return $aService;
    }

    public function pricing()
    {

        $data = array();
        
        //total rows count
        $totalRec = count($this->Tailoring_m->getAllBillType());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'tailoring/billTypeAjaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['billTypes'] = $this->Tailoring_m->getAllBillType(array('limit'=>$this->perPage));

        $this->template->load('main', 'tailoring_pricing', $data);
    }

    public function billTypeAjaxData(){
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //total rows count
        $totalRec = count($this->Tailoring_m->getAllBillType());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'tailoring/billTypeAjaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['billTypes'] = $this->Tailoring_m->getAllBillType(array('start'=>$offset,'limit'=>$this->perPage));
        
        //load the view
        $this->load->view('tailoring/bill_type_ajax_data', $data, false);
    }

    public function addbilltype()
    {
        $billtn = $this->input->get('billtn');
        $this->Tailoring_m->insertBillType($billtn);
        $stdata = $this->db->insert_id();
        echo $stdata;
    }

    public function pricing_delete()
    {
        $dv = $this->input->get('dv');
        $this->Tailoring_m->pricing_delete($dv);
    }

    public function order()
    {
        $this->breadcrumb->add('Tailoring Orders', 'tailoring-orders', 1);
        $this->breadcrumb->add(lang('add_order'), '', 0);
        $this->load->model('common_model');
        $data['services'] = $this->Tailoring_m->getServices();
        $data['billingTypes'] = $this->Tailoring_m->getAllBillingTypes();
        $data['getAllAccounts'] = $this->Tailoring_m->getAllAccounts();
        //$data['getAllCustomer'] = $this->commonmodel->getAllCustomers();
        $data['receipt_no'] = $this->auto_increment->getAutoIncKey('TAILORING', 'tailoring_orders');
        $this->template->load('main', 'tailoring_order', $data);

    }

    public function getaServiceById()
    {
        $sid = $this->input->get('sid');
        $customer_id = $this->input->get('customer_id');
        $data['stdata'] = $this->Tailoring_m->getServiceById($sid);
        $order = $this->Tailoring_m->getOrderByCustomer($customer_id,$sid);
        $data['measurements'] = $this->Tailoring_m->getMeasureByCustomer($order[0]['id_order_detail']);
        $this->load->view('order_service_form', $data);

    }

    public function getaDesignById()
    {

        $did = $this->input->get('did');

        $this->db->select('*');
        $this->db->from('tailoring_fields');
        $this->db->where('id_field', $did);
        $query = $this->db->get();
        $design = $query->result_array();

        echo base_url() . 'uploads/' . $design[0]['field_img'];
    }

    public function order_complete()
    {

        $this->load->helper('date');

        $serCount = $this->input->post('serCount');
        $serID = $this->input->post('serID');
        $pQuantity = $this->input->post('pQuantity');
        $serName = $this->input->post('serName');
        $mFieldsId = $this->input->post('mFieldsId');
        $mFields = $this->input->post('mFields');
        $sDesignId = $this->input->post('sDesignId');
        $sNote = $this->input->post('sNote');
        $serPrice = $this->input->post('serPrice');
        $customerId = $this->input->post('customerId');
        $receiptNo = $this->input->post('receiptNo');
        $orderDate = $this->input->post('orderDate');
        $deliveryDate = $this->input->post('deliveryDate');
        $radioGroup = $this->input->post('radio-group');
        $dAmount = $this->input->post('dAmount');
        $dPercentage = $this->input->post('dPercentage');
        $billType = $this->input->post('billType');
        $billTypeId = $this->input->post('billTypeId');
        foreach ($billTypeId as $aID) {
            $billTypeName[] = $this->Tailoring_m->getBillTypeName($aID);
        }

        $total_amount = $this->input->post('totalAmount');

        $paid_amount = $this->input->post('paid_amount');
        $account = $this->input->post('account');
        $description = $this->input->post('description');
        $order_status = $this->input->post('order_status');

        $ctid = $this->input->post('ctid');

        $ref_card = $this->input->post('ref_card');
        $ref_acc_no = $this->input->post('ref_acc_no');
        $ref_bank = $this->input->post('ref_bank');
        $ref_trx_no = $this->input->post('ref_trx_no');


        $trx_no = $this->auto_increment->getAutoIncKey('TRANSACTION', 'sale_transactions');


        // if (empty($description)) {
        //     $description = 'NULL';
        // }
        if (empty($dAmount)) {
            $dAmount = '0.00';
        }
        if (empty($dPercentage)) {
            $dPercentage = '0.00';
        }
        if (empty($paid_amount)) {
            $paid_amount = '0.00';
        }
        if (empty($account)) {
            $account = '0.00';
        }
        // if (empty($ctid)) {
        //     $ctid = 'NULL';
        // }
        // if (empty($ref_acc_no)) {
        //     $ref_acc_no = 'NULL';
        // }
        // if (empty($ref_bank)) {
        //     $ref_bank = 'NULL';
        // }
        // if (empty($ref_card)) {
        //     $ref_card = 'NULL';
        // }
        // if (empty($ref_trx_no)) {
        //     $ref_trx_no = 'NULL';
        // }

        $order = array(
            'customer_id' => $customerId,
            'store_id' => $_SESSION['login_info']['store_id'],
            'receipt_no' => $receiptNo,
            'notes' => $description,
            'order_date' => $orderDate,
            'delivery_date' => $deliveryDate,
            'tot_amt' => $total_amount,
            'paid_amt' => $paid_amount,
            'discount_rate' => $dPercentage,
            'discount_amt' => $dAmount,
            'order_status' => $order_status,
            'station_id' => $_SESSION['login_info']['station_id'],
            'invoice_no' => time(),
            'trx_no' => $trx_no,
            'account_id' => $account,
            'payment_method_id' => $ctid,
            'ref_acc_no' => $ref_acc_no,
            'ref_bank_id' => $ref_bank,
            'ref_card_id' => $ref_card,
            'ref_trx_no' => $ref_trx_no,

            'dtt_add' => date('Y-m-d H:i:s'),
            'uid_add' => $_SESSION['login_info']['id_user_i90'],

        );


        $services = array();
        $measurements = array();
        $designs = array();

        for ($i = 0; $i < count($serCount); $i++) {
            $services[] = array(
                'service_id' => $serID[$i],
                'service_identify' => ($i + 1),
                'service_qty' => $pQuantity[$i],
                'service_price' => $serPrice[$i],
                'notes' => $sNote[$i]
            );
            $fieldId = explode(',', $mFieldsId[$i]);
            $fieldVal = explode(',', $mFields[$i]);

            for ($j = 0; $j < count($fieldId); $j++) {
                $measurements[] = array(
                    'service_id' => $serID[$i],
                    'service_identify' => ($i + 1),
                    'field_type_id' => 1,
                    'field_id' => $fieldId[$j],
                    'field_value' => $fieldVal[$j],
                );
            }

            $designIds = explode(',', $sDesignId[$i]);
            for ($q = 0; $q < count($designIds); $q++) {
                $designs[] = array(
                    'service_id' => $serID[$i],
                    'service_identify' => ($i + 1),
                    'field_type_id' => 2,
                    'field_id' => $designIds[$q],
                    'field_value' => '',
                );
            }

        }

        $rt = 0;
        foreach ($billTypeId as $aBil) {
            $billData[] = array(
                'service_id' => 'None',
                'service_identify' => '',
                'field_type_id' => 3,
                'field_id' => $aBil,
                'field_value' => $billType[$rt],
            );
            $rt++;
        }

        $measure1 = array_merge($measurements, $designs);

        $measure = array_merge($measure1, $billData);


        $ttid = $this->Tailoring_m->insert_tailoring_order_measurement($order, $services, $measure);

        if ($ttid[0]['insert_id'] > 0) {
            echo $ttid[0]['insert_id'];
            $this->auto_increment->updAutoIncKey('TRANSACTION', $trx_no, $trx_no);
        }

    }

    public function getSinAccount()
    {

        $aid = $this->input->get('aid');
        $aAcc = $this->Tailoring_m->getSinAccount($aid);

        if (!empty($aAcc[0]['bank_id'])) {
            if ($aAcc[0]['bank_type_id'] == 1) {
                // bank
                echo '<div class="form-group row">';
                echo '<label class="col-sm-5 col-form-label">Payment Method <span class="req">*</span></label>';
                echo '<div class="col-md-7">';
                echo '<div class="row-fluid">';
                echo '<select class="form-control" data-live-search="true" id="pay_method" name="pay_method">';
                echo '<option value="0">Select One</option>';
                echo '<option value="2">Card</option>';
                echo '<option value="4">Cheque</option>';
                echo '</select>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                // mobile bank
                echo '<div class="form-group row">';
                echo '<label class="col-sm-5 col-form-label">Sender Mobile No <span class="req">*</span></label>';
                echo '<div class="col-md-7">';
                echo '<input class="form-control" type="text" name="ref_acc_no" id="ref_acc_no">';
                echo '</div>';
                echo '</div>';
                echo '<div class="form-group row">';
                echo '<label class="col-sm-5 col-form-label">Reff Transaction No <span class="req">*</span></label>';
                echo '<div class="col-md-7">';
                echo '<input class="form-control" type="text" name="ref_trx_no" id="ref_trx_no" "="">';
                echo '</div>';
                echo '</div>';
            }
        }
    }
    public function getSinAccount2()
    {

        $aid = $this->input->get('aid');
        $aAcc = $this->Tailoring_m->getSinAccount($aid);

        if (!empty($aAcc[0]['bank_id'])) {
            if ($aAcc[0]['bank_type_id'] == 1) {
                // bank
                echo '<div class="form-group row">';
                echo '<label class="col-sm-12 col-form-label">Payment Method <span class="req">*</span></label>';
                echo '<div class="col-md-12">';
                echo '<div class="row-fluid">';
                echo '<select class="form-control" data-live-search="true" id="pay_method" name="pay_method">';
                echo '<option value="0">Select One</option>';
                echo '<option value="2">Card</option>';
                echo '<option value="4">Cheque</option>';
                echo '</select>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                // mobile bank
                echo '<div class="form-group row">';
                echo '<label class="col-sm-12 col-form-label">Sender Mobile No <span class="req">*</span></label>';
                echo '<div class="col-md-12">';
                echo '<input class="form-control" type="text" name="ref_acc_no" id="ref_acc_no">';
                echo '</div>';
                echo '</div>';
                echo '<div class="form-group row">';
                echo '<label class="col-sm-12 col-form-label">Reff Transaction No <span class="req">*</span></label>';
                echo '<div class="col-md-12">';
                echo '<input class="form-control" type="text" name="ref_trx_no" id="ref_trx_no" "="">';
                echo '</div>';
                echo '</div>';
            }
        }
    }
    
      public function order_list(){
        $data = array();    
        $totalRec = 0;    
        //total rows count
        $serRow = $this->Tailoring_m->getOrderRows();
        if($serRow != NULL){
            $totalRec = count($this->Tailoring_m->getOrderRows());
        }              
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'tailoring/orderAjaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $this->ajax_pagination->initialize($config);        
        //get the posts data
        $data['orders'] = $this->Tailoring_m->getOrderRows(array('limit'=>$this->perPage));        

        $this->template->load('main', 'tailoring/order_list', $data);
      }

      public function orderAjaxPaginationData(){
          $page = $this->input->post('page');
          if(!$page){
              $offset = 0;
          }else{
              $offset = $page;
          }      
          //total rows count
          $totalRec = 0;
          $serRow = $this->Tailoring_m->getOrderRows();
            if($serRow != NULL){
                $totalRec = count($this->Tailoring_m->getOrderRows());
          }      
          //pagination configuration
          $config['target']      = '#postList';
          $config['base_url']    = base_url().'tailoring/orderAjaxPaginationData';
          $config['total_rows']  = $totalRec;
          $config['per_page']    = $this->perPage;
          $this->ajax_pagination->initialize($config);      
          //get the posts data
          $data['orders'] = $this->Tailoring_m->getOrderRows(array('start'=>$offset,'limit'=>$this->perPage));      
          // load the view
          $this->load->view('tailoring/order_list_pagination_data', $data, false);
      }

      public function filterOrderPagination(){


          $page = $this->input->post('page');
          if(!$page){
              $offset = 0;
          }else{
              $offset = $page;
          }      

            $arg = array('offset' => $offset);

            if(!empty($_POST['receipt_no'])){
                $arg = array_merge($arg, array('receipt_no'=>$_POST['receipt_no']));
            }
            if(!empty($_POST['name_customer'])){
                $arg = array_merge($arg, array('name_customer'=>$_POST['name_customer']));
            }
            if(!empty($_POST['phone_customer'])){
                $arg = array_merge($arg, array('phone_customer'=>$_POST['phone_customer']));
            }
            if(!empty($_POST['date_type'])){
                $arg = array_merge($arg, array('date_type'=>$_POST['date_type']));
            }            
            if(!empty($_POST['start_date'])){
                $arg = array_merge($arg, array('start_date'=>$_POST['start_date']));
            }
            if(!empty($_POST['end_date'])){
                $arg = array_merge($arg, array('end_date'=>$_POST['end_date']));
            }
          if($_POST['order_status']!=0){
              $arg = array_merge($arg, array('order_status'=>$_POST['order_status']));
          }

          $totalRec = 0;   
          //total rows count   
          $serRow = $this->Tailoring_m->getFilterOrderRows($arg);
            if($serRow != NULL){
                $totalRec = count($this->Tailoring_m->getFilterOrderRows($arg)); 
          }    
          //pagination configuration
          $config['target']      = '#postList';
          $config['base_url']    = base_url().'tailoring/filterOrderPagination';
          $config['total_rows']  = $totalRec;
          $config['per_page']    = $this->perPage;

          $this->ajax_pagination->initialize($config);      
          //get the posts data

          $arg = array_merge($arg, array('start'=>$offset,'limit'=>$this->perPage));
            
          $data['orders'] = $this->Tailoring_m->getFilterOrderRows($arg);      
          // load the view
          $this->load->view('tailoring/order_list_pagination_data', $data, false);
      }


    public function order_view()
    {

        $id = $this->uri->segment(3);
        $this->breadcrumb->add('Tailoring Orders', 'tailoring-orders', 1);
        $this->breadcrumb->add(lang('view'), '', 0);
        $data['aOrder'] = $this->Tailoring_m->get_order_by_id($id);
        $data['customer_info'] = $this->Tailoring_m->getCustomerInfo($data['aOrder'][0]['customer_id']);
        $data['billingTypes'] = $this->Tailoring_m->getAllBillingTypes();
        $data['getAllAccounts'] = $this->Tailoring_m->getAllAccounts();

        $aOrderDetails = $this->Tailoring_m->get_order_detail_by_id($id);

        $serviceFullData = array();
        $serviceName = array();
        $sMeaserments = array();
        $i = 0;
        foreach ($aOrderDetails as $aOrderDetail) {

            $serviceName[] = $this->Tailoring_m->getServiceName($aOrderDetail['service_id']);
            $sMeaserments[] = $this->Tailoring_m->get_order_measurements_by_id($aOrderDetail['order_id']);

            $serviceFullData[] = array(
                'service_name' => $serviceName[$i][0]['service_name'],
                'measerDesign' => $sMeaserments[$i],
                'service_qty' => $aOrderDetail['service_qty'],
                'service_price' => $aOrderDetail['service_price'],
                'notes' => $aOrderDetail['notes'],
                'id_order_detail' => $aOrderDetail['id_order_detail']
            );

            $i++;
        }

        $data['serFullDt'] = $serviceFullData;

        $this->template->load('main', 'order_view', $data);
    }

    public function order_edit()
    {

        $data['services'] = $this->Tailoring_m->getServices();
        $data['billingTypes'] = $this->Tailoring_m->getAllBillingTypes();
        $data['getAllAccounts'] = $this->Tailoring_m->getAllAccounts();
        $data['getAllCustomer'] = $this->Tailoring_m->getAllCustomer();
        $data['receipt_no'] = $this->auto_increment->getAutoIncKey('TAILORING', 'tailoring_orders');

        $id = $this->uri->segment(3);

        if (isset($id)) {
            $data['ef'] = TRUE;
            $data['aOrder'] = $this->Tailoring_m->get_order_by_id($id);
            $nameArray['customer_name'] = $this->Tailoring_m->getCustomerName($data['aOrder'][0]['customer_id']);

            $data['billingTypes'] = $this->Tailoring_m->getAllBillingTypes();
            $aOrderDetails = $this->Tailoring_m->get_order_detail_by_id($id);

            // echo '<pre>';
            // print_r($aOrderDetails);
            // echo '</pre>';

            // die();

            $serviceFullData = array();
            $serviceName = array();
            $sMeaserments = array();
            $i = 0;
            foreach ($aOrderDetails as $aOrderDetail) {

                $serviceName[] = $this->Tailoring_m->getServiceName($aOrderDetail['service_id']);
                $sMeaserments[] = $this->Tailoring_m->get_order_measurements_by_id($aOrderDetail['service_id'], $aOrderDetail['id_order_detail']);

                $serviceFullData[] = array(
                    'id_order_detail' => $aOrderDetail['id_order_detail'],
                    'service_identify' => $aOrderDetail['service_identify'],
                    'service_id' => $aOrderDetail['service_id'],
                    'service_qty' => $aOrderDetail['service_qty'],
                    'service_price' => $aOrderDetail['service_price'],
                    'notes' => $aOrderDetail['notes'],
                    'service_name' => $serviceName[$i][0]['service_name'],
                    'measerDesign' => $sMeaserments[$i]
                );

                $i++;
            }

            $data['serFullDt'] = $serviceFullData;
        }

        $this->template->load('main', 'order_edit', $data);

    }

    public function order_preview()
    {

        $this->load->helper('date');

        $serCount = $this->input->post('serCount');
        $serID = $this->input->post('serID');
        $pQuantity = $this->input->post('pQuantity');
        $serName = $this->input->post('serName');
        $mFieldsId = $this->input->post('mFieldsId');
        $mFields = $this->input->post('mFields');
        $sDesignId = $this->input->post('sDesignId');
        $sNote = $this->input->post('sNote');
        $serPrice = $this->input->post('serPrice');


        $customerId = $this->input->post('customerId');
        $customerName = $this->Tailoring_m->getCustomerName($customerId);
        $receiptNo = $this->input->post('receiptNo');
        $orderDate = $this->input->post('orderDate');
        $deliveryDate = $this->input->post('deliveryDate');

        $radioGroup = $this->input->post('radio-group');
        $dAmount = $this->input->post('dAmount');
        $dPercentage = $this->input->post('dPercentage');

        $billType = $this->input->post('billType');

        $billTypeId = $this->input->post('billTypeId');

        $subTotal = $this->input->post('subTotal');

        $total_amount = $this->input->post('totalAmount');

        $paid_amount = $this->input->post('paid_amount');
        $account = $this->input->post('account');
        $description = $this->input->post('description');
        $order_status = $this->input->post('order_status');

        $ctid = $this->input->post('ctid');

        $ref_card = $this->input->post('ref_card');
        $ref_acc_no = $this->input->post('ref_acc_no');
        $ref_bank = $this->input->post('ref_bank');
        $ref_trx_no = $this->input->post('ref_trx_no');

        if (empty($radioGroup)) {
            $radioGroup = '';
        }
        if (empty($dAmount)) {
            $dAmount = '0';
        }
        if (empty($dPercentage)) {
            $dPercentage = '0';
        }
        if (empty($billType)) {
            $billType = '0';
        }
        if (empty($total_amount)) {
            $total_amount = '0';
        }
        if (empty($paid_amount)) {
            $paid_amount = '0';
        }
        
        


        foreach ($billTypeId as $aID) {
            $billTypeName[] = $this->Tailoring_m->getBillTypeName($aID);
        }


        $data['aOrder'] = array(
            'customerName' => $customerName,
            'receiptNo' => $receiptNo,
            'orderDate' => $orderDate,
            'deliveryDate' => $deliveryDate,
            'radioGroup' => $radioGroup,
            'dAmount' => $dAmount,
            'dPercentage' => $dPercentage,
            'billTypeName' => $billTypeName,
            'billType' => $billType,
            'total_amount' => $total_amount,
            'subTotal' => $subTotal,
            'paid_amount' => $paid_amount,
            'account' => $account,
            'description' => $description,
            'order_status' => $order_status,
            'ctid' => $ctid,
            'ref_card' => $ref_card,
            'ref_acc_no' => $ref_acc_no,
            'ref_bank' => $ref_bank,
            'ref_trx_no' => $ref_trx_no
        );

        $allServices = array(
            'serCount' => $serCount,
            'serID' => $serID,
            'pQuantity' => $pQuantity,
            'serName' => $serName,
            'mFieldsId' => $mFieldsId,
            'mFields' => $mFields,
            'sDesignId' => $sDesignId,
            'sNote' => $sNote,
            'serPrice' => $serPrice,
        );

        $viewServices = array();
        $mFieldsId = array();
        $mFieldsIdArr = array();
        $asi = 0;
        foreach ($allServices['serCount'] as $aCount) {

            $mFieldsId = explode(',', $allServices['mFieldsId'][$asi]);

            foreach ($mFieldsId as $aFieldsId) {
                $fieldName = $this->Tailoring_m->getFieldNameById($aFieldsId);
                $mFieldsIdArr[$asi][] = $fieldName[0]['field_name'];
            }

            $mFields = explode(',', $allServices['mFields'][$asi]);

            $sDesignId = explode(',', $allServices['sDesignId'][$asi]);

            $mDesignIdArr[$asi] = array();

            foreach ($sDesignId as $aDesignId) {
                $designUrl = $this->Tailoring_m->getDesignUrlById($aDesignId);
                if (!empty($designUrl[0]['field_img'])) {
                    $mDesignIdArr[$asi][] = $designUrl[0]['field_img'];
                }
            }

            $viewServices[] = array(
                'serCount' => $allServices['serCount'][$asi],
                'serID' => $allServices['serID'][$asi],
                'pQuantity' => $allServices['pQuantity'][$asi],
                'serName' => $allServices['serName'][$asi],
                'mFieldsId' => $mFieldsIdArr[$asi],
                'mFields' => $mFields,
                'sDesignId' => $mDesignIdArr[$asi],
                'sNote' => $allServices['sNote'][$asi],
                'serPrice' => $allServices['serPrice'][$asi],
            );

            $asi++;
        }

        // $data['viewServices'] = $viewServices;

        $data['allServices'] = $viewServices;


        $modal_cont = $this->load->view('tailoring/order_preview', $data);

        echo $modal_cont;

    }

    public function reTransection()
    {

        $this->load->helper('date');

        $trx_no = $this->auto_increment->getAutoIncKey('TRANSACTION', 'sale_transactions');


        $orderId = $this->input->post('orderId');
        $accType = $this->input->post('accType');
        $customerId = $this->input->post('customerId');
        $rAmount = $this->input->post('rAmount');
        $sale_id = $this->input->post('sale_id');
        $due_amt = $this->input->post('due_amt');
        $paidAmount = $this->input->post('paidAmount');


        $account_id = $this->input->post('account');
        $pay_method = $this->input->post('pay_method');
        $ref_card = $this->input->post('ref_card');
        $ref_acc_no = $this->input->post('ref_acc_no');
        $ref_bank = $this->input->post('ref_bank');

        // $this->db->trans_begin();


        // sale_transactions


        $sale_transactions = array(
            'trx_no' => $trx_no,
            'customer_id' => $customerId,
            'store_id' => $_SESSION['login_info']['store_id'],
            'description' => '',
            'tot_amount' => $due_amt,
            'qty_multiplier' => 1,
            'is_doc_attached' => 2,
            'dtt_trx' => mdate("%Y-%m-%d %H:%i:%s"),
            'dtt_add' => mdate("%Y-%m-%d %H:%i:%s"),
            'uid_add' => $_SESSION['login_info']['id_user_i90'],
            'status_id' => 1
        );

        $this->db->insert('sale_transactions', $sale_transactions);

        $sale_transaction_id = $this->db->insert_id();

        // sale_transaction_details

        $sale_transaction_details = array(
            'sale_transaction_id' => $sale_transaction_id,
            'sale_id' => $sale_id,
            'transaction_type_id' => 4,
            'amount' => $rAmount,
            'qty_multiplier' => 0,
            'dtt_add' => mdate("%Y-%m-%d %H:%i:%s"),
            'uid_add' => $_SESSION['login_info']['id_user_i90']
        );

        $this->db->insert('sale_transaction_details', $sale_transaction_details);


        // sale_transaction_payments

        if (empty($account_id)) {
            $account_id = 0;
        }
        if (empty($payment_method_id)) {
            $payment_method_id = 0;
        }
        if (empty($ref_acc_no)) {
            $ref_acc_no = 0;
        }
        if (empty($ref_bank_id)) {
            $ref_bank_id = 0;
        }
        if (empty($ref_card_id)) {
            $ref_card_id = 0;
        }

        $sale_transaction_payments = array(
            'sale_transaction_id' => $sale_transaction_id,
            'amount' => $rAmount,
            'qty_multiplier' => 1,
            'account_id' => $account_id,
            'payment_method_id' => $accType,
            'ref_acc_no' => $ref_acc_no,
            'ref_bank_id' => $ref_bank_id,
            'ref_card_id' => $ref_card_id,
            'ref_trx_no' => 'NULL'
        );

        $this->db->insert('sale_transaction_payments', $sale_transaction_payments);

        $curr_balance = $this->Tailoring_m->getCurrentBallance($account_id);

        $curr_balance = $curr_balance[0]['curr_balance'] + $rAmount;

        $this->db->where('id_account', $account_id);
        $this->db->update('accounts', array('curr_balance' => $curr_balance));


        $cBalance = $this->Tailoring_m->getCustomerBallance($customerId);

        // print_r($cBalance);

        $cBalance = $cBalance[0]['balance'] - $rAmount;

        $this->db->where('id_customer', $customerId);
        $this->db->update('customers', array('balance' => $cBalance));

        // update order table info

        $tPayA = $paidAmount + $rAmount;
        $tDueA = $due_amt - $rAmount;

        $oData = array(
            'paid_amt' => $tPayA,
            'due_amt' => $tDueA
        );

        $this->db->where('id_order', $orderId);
        $this->db->update('tailoring_orders', $oData);


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
        } else {
            $this->db->trans_commit();
            echo 'ok';
        }


        // echo '<pre>';
        // print_r($sale_transactions);
        // print_r($sale_transaction_details);
        // print_r($sale_transaction_payments);
        // print_r($curr_balance);
        // print_r($cBalance);
        // echo '</pre>';


    }

    public function order_invoice()
    {


        $id = $this->uri->segment(3);

        $data['aOrder'] = $this->Tailoring_m->get_order_by_id($id);

        $data['sellerName'] = $this->Tailoring_m->getSellerName($data['aOrder'][0]['uid_add']);

        $data['store_info'] = $this->Tailoring_m->getStoreInfo($data['aOrder'][0]['store_id']);


        $data['customer_name'] = $this->Tailoring_m->getCustomerName($data['aOrder'][0]['customer_id']);
        $data['customer_info'] = $this->Tailoring_m->getCustomerInfo($data['aOrder'][0]['customer_id']);
        $data['billingTypes'] = $this->Tailoring_m->getAllBillingTypes();
        $data['getAllAccounts'] = $this->Tailoring_m->getAllAccounts();

        $aOrderDetails = $this->Tailoring_m->get_order_detail_by_id($id);

        $serviceFullData = array();
        $serviceName = array();
        $sMeaserments = array();
        $i = 0;
        foreach ($aOrderDetails as $aOrderDetail) {

            $serviceName[] = $this->Tailoring_m->getServiceName($aOrderDetail['service_id']);
            $sMeaserments[] = $this->Tailoring_m->get_order_measurements_by_id($aOrderDetail['order_id']);

            $serviceFullData[] = array(
                'service_name' => $serviceName[$i][0]['service_name'],
                'measerDesign' => $sMeaserments[$i],
                'service_qty' => $aOrderDetail['service_qty'],
                'service_price' => $aOrderDetail['service_price'],
                'notes' => $aOrderDetail['notes']
            );

            $i++;
        }

        $data['serFullDt'] = $serviceFullData;
        $this->load->view('tailoring/order_invoice', $data);
    }
    public function order_full_invoice()
    {

        $id = $this->uri->segment(3);

        $data['aOrder'] = $this->Tailoring_m->get_order_by_id($id);

         $data['transactions'] = $this->Tailoring_m->sale_transaction_details($data['aOrder'][0]['sale_id']);

        $data['sellerName'] = $this->Tailoring_m->getSellerName($data['aOrder'][0]['uid_add']);

        $data['store_info'] = $this->Tailoring_m->getStoreInfo($data['aOrder'][0]['store_id']);


        $data['customer_name'] = $this->Tailoring_m->getCustomerName($data['aOrder'][0]['customer_id']);
        $data['customer_info'] = $this->Tailoring_m->getCustomerInfo($data['aOrder'][0]['customer_id']);
        $data['billingTypes'] = $this->Tailoring_m->getAllBillingTypes();
        $data['getAllAccounts'] = $this->Tailoring_m->getAllAccounts();

        $aOrderDetails = $this->Tailoring_m->get_order_detail_by_id($id);

        $serviceFullData = array();
        $serviceName = array();
        $sMeaserments = array();
        $i = 0;
        foreach ($aOrderDetails as $aOrderDetail) {

            $serviceName[] = $this->Tailoring_m->getServiceName($aOrderDetail['service_id']);
            $sMeaserments[] = $this->Tailoring_m->get_order_measurements_by_id($aOrderDetail['order_id']);

            $serviceFullData[] = array(
                'service_name' => $serviceName[$i][0]['service_name'],
                'measerDesign' => $sMeaserments[$i],
                'service_qty' => $aOrderDetail['service_qty'],
                'service_price' => $aOrderDetail['service_price'],
                'notes' => $aOrderDetail['notes']
            );

            $i++;
        }

        $data['serFullDt'] = $serviceFullData;
        $this->load->view('tailoring/order_full_invoice', $data);

    }

    public function getBillingById($id)
    {

        $id = $this->input->post('bId');
        $data['bill'] = $this->Tailoring_m->getBillingById($id);

        echo $data['bill'];

    }

    public function editBillTypes()
    {

        $id = $this->input->post('bId');
        $fName = $this->input->post('fName');

        $upId = $this->Tailoring_m->editBillType($id, $fName);

        echo $upId;
    }

    public function orderStatusUpdate(){
        $upId = $this->Tailoring_m->orderStatusUpdate();
        echo $upId;
    }
    public function getCustomerInfoById(){
        $ci = $this->Tailoring_m->getCustomerInfo($_POST['cid']);
        $res = '<div class="ci-info"><div class="namePhn"><span>'.$ci[0]['full_name'].'</span><span>('.$ci[0]['phone'].')</div></span><div class="pointBalance"><span>Points: '.$ci[0]['points'].'</span><span>Balance: '.$ci[0]['balance'].'</span></div></div>';
        echo $res;
    }
    public function get_customer_auto_list()
    {
        $request = $_REQUEST['request'];
        //$store_id = $_REQUEST['store_id'];
        $store_id = $this->session->userdata['login_info']['store_id'];
        //$product_list = $this->commonmodel->getAllCustomers();
        $customer_list = $this->Tailoring_m->get_customer_auto_list($request);
        $return = array();
        foreach ($customer_list as $list) {
            $return[] = array(
                "label" => $list->customer_code.' '.$list->full_name.' ('.$list->phone.')' ,
                "value" => $list->id_customer,
                "phone" => $list->phone,
                "customer_code" => $list->customer_code
                // "is_unq_barcode" => $list->is_unq_barcode
            );
        }
        echo json_encode($return);
    }
    public function measurement_details(){
        $id = $this->input->get('id');
        $data['lists'] = $this->Tailoring_m->get_measurement_details($id);
        $this->load->view('measurements_view', $data);
    }
    public function measurement_update(){
        $measurement_id = $this->input->post('measurement_id');
        $field_value = $this->input->post('field_value');
        for ($i=0; $i < count($measurement_id) ; $i++) { 
           $this->Tailoring_m->update_value('tailoring_measurements',array('field_value' =>$field_value[$i]),array('id_measurement' => $measurement_id[$i] ));
        }
        echo 1;
    }

}
