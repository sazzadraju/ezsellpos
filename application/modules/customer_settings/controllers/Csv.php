<?php

defined('BASEPATH') OR exit('No direct script access allowed');

 
class Csv extends MX_Controller {
 
    function __construct() {
        parent::__construct();
        $this->form_validation->CI = &$this;
        if ($this->session->userdata('language') == "bn") {

            $this->lang->load('bn');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('csv_model');
        $this->load->model('customer_model');
    }
 
    function index() {
        $data['content_view'] = 'csv/csvindex';
        //$this->template->main_template($data);
        $this->template->load('main', 'csv/csvindex');
    }

    function previewcsv(){        

        $data['error'] = '';    //initialize image upload error array to empty
 
        $config['upload_path'] = './public/uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '100000';
 
        $this->load->library('upload', $config);

        // If upload failed, display error

        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            $this->template->load('main', 'csv/csvindex',$data);
            //$this->load->view('csvindex', $data);
        } else {
            $file_data = $this->upload->data();
            $file_path =  './public/uploads/'.$file_data['file_name'];

            
 
            if (array_map('str_getcsv', file($file_path))) {



                $data['previewarray'] = array_map('str_getcsv', file($file_path));
                unset($data['previewarray'][0]);
                $data['content_view'] = 'csv/csvpreview';
                $data['customer_type_list'] = $this->customer_model->common_cond_dropdown_data('customer_types', 'id_customer_type', 'name', 'status_id', '1', 'id_customer_type', 'ASC');
                //$this->template->main_template($data);
                $this->template->load('main', 'csv/csvpreview',$data);

            } else {
                $data['error'] = "Error occured";
                $this->template->load('main', 'csv/csvindex',$data);
                //$this->load->view('csvindex', $data);
            }
        }    
 
 
    }
 
    function importcsv() {          

       $customer_code = $this->input->post('customer_code');
       $customer_type_id = $this->input->post('customer_type_id');
       $full_name = $this->input->post('full_name');
       $c_email = $this->input->post('c_email');
       $phone = $this->input->post('phone');
       $gender = $this->input->post('gender');
       $birth_date = $this->input->post('birth_date');
       $marital_status = $this->input->post('marital_status');
       $anniversary_date = $this->input->post('anniversary_date');
       $addr_line_1 = $this->input->post('addr_line_1');
       $rCount = $this->input->post('rCount');

       $j = 0;
       foreach ($rCount as $srCount) {

            // empty product code validation  
            if(empty($customer_code[$j])){
                $customer_code[$j] = time()+$j;
            }

            // codeigniter form validation
            // Unique product code check

            $pce = $this->csv_model->customer_code_exists($customer_code[$j]);

            if($pce) {
               $is_unique2 =  '|is_unique[customers.customer_code]';
            } else {
               $is_unique2 =  '';
            }

            
            $this->form_validation->set_rules('customer_code['.$j.']', 'Customer Code', 'trim'.$is_unique2);
            $this->form_validation->set_rules('full_name['.$j.']', 'Full Name', 'trim|required');

            $this->form_validation->set_message('is_unique', 'Already exist');
            $this->form_validation->set_message('required', 'Required');

            // Product info array

            $importData[] = array(
                $customer_code[$j],        // [0]
                $customer_type_id[$j],        // [1]
                $full_name[$j],         // [2]
                $c_email[$j],      // [3]
                $phone[$j],         // [4]
                $gender[$j],       // [5]
                $birth_date[$j],        // [6]
                $marital_status[$j],    // [7]
                $anniversary_date[$j],   // [8]
                $addr_line_1[$j],    // [9]
            );

        $j++;
       }

       // codeigniter backend validation 

       if ($this->form_validation->run() == FALSE){

                $data['previewarray'] = $importData;
                $data['customer_type_list'] = $this->customer_model->common_cond_dropdown_data('customer_types', 'id_customer_type', 'name', 'status_id', '1', 'id_customer_type', 'ASC');
                $data['content_view'] = 'csv/csvpreview';
               // $this->template->main_template($data);
           $this->template->load('main', 'csv/csvpreview',$data);
        }
        else
        {
            // one by one product insert 

            foreach ($importData as $singleData) {                      

                  $data['customer_code'] = $singleData[0];
                  $data['customer_type_id'] = $singleData[1];
                  $data['full_name'] = $singleData[2];
                  $data['email'] = $singleData[3];
                  $data['phone'] = $singleData[4];
                  $data['gender'] = $singleData[5];
                  $data['birth_date'] = $singleData[6];
                  $data['marital_status'] = $singleData[7];
                  $data['anniversary_date'] = $singleData[8];
                  $data['store_id'] = $this->session->userdata['login_info']['store_id']; 
                  $data['dtt_add'] = date('Y-m-d H:i:s');  
                  $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90']; 
                  $cus_id=$this->customer_model->common_insert('customers',$data);
                  $addr=$singleData[9];
                  if(!empty($addr)){
                      $addressArray=array(
                        'customer_id'=>$cus_id
                        ,'address_type'=>'Present Address'
                        ,'addr_line_1'=>$addr
                      );
                      $address = $this->customer_model->common_insert('customer_addresss',$addressArray);
                  }

            }

            $this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
            redirect(base_url().'customer');

            //$data['content_view'] = 'csv/csvindex';
            $this->template->load('main', 'csv/csvindex');
            //$this->template->main_template($data);
        }
    }

}