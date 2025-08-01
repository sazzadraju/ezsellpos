<?php

defined('BASEPATH') OR exit('No direct script access allowed');

 
class Csv extends MX_Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->model('csv_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('date'); 
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

       $rCount = $this->input->post('rCount');
       $pCodes = $this->input->post('pCode');
       $pNames = $this->input->post('pName');
       $pCats = $this->input->post('pCat');
       $pSubCats = $this->input->post('pSubCat');
       $pDess = $this->input->post('pDes');
       $pBrands = $this->input->post('pBrand');
       $pUnits = $this->input->post('pUnit');
       $pBuyPrices = $this->input->post('pBuyPrice');
       $pSellPrices = $this->input->post('pSellPrice');
       $pMinStocks = $this->input->post('pMinStock');
       $pVat = $this->input->post('pVat');
       $pSupplier = $this->input->post('pSupplier');

       $j = 0;
       foreach ($rCount as $srCount) {

            // empty product code validation  

            if(empty($pCodes[$j])){
                $pCodes[$j] = time()+$j;
            }

            // codeigniter form validation
            // Unique product code check

            $pce = $this->csv_model->pcode_exists($pCodes[$j]);

            if($pce) {
               $is_unique2 =  '|is_unique[products.product_code]';
            } else {
               $is_unique2 =  '';
            }

            // Unique product name check

            $pe = $this->csv_model->product_exists($pNames[$j]);

            if($pe) {
               $is_unique =  '|is_unique[products.product_name]';
            } else {
               $is_unique =  '';
            }

            $this->form_validation->set_rules('pCode['.$j.']', 'Product Code', 'trim'.$is_unique2);
            //$this->form_validation->set_rules('pName['.$j.']', 'Product Name', 'trim|required'.$is_unique);
            $this->form_validation->set_rules('pCat['.$j.']', 'Product Category', 'trim|required');
            $this->form_validation->set_rules('pBrand['.$j.']', 'Brand Name', 'trim|required');
            $this->form_validation->set_rules('pUnit['.$j.']', 'Unit Name', 'trim|required');
            $this->form_validation->set_rules('pBuyPrice['.$j.']', 'Buy Price', 'trim|required');

            $this->form_validation->set_message('is_unique', 'Already exist');
            $this->form_validation->set_message('required', 'Required');

            // Product info array

            $importData[] = array(
                $pCodes[$j],        // [0]
                $pNames[$j],        // [1]
                $pCats[$j],         // [2]
                $pSubCats[$j],      // [3]
                $pDess[$j],         // [4]
                $pBrands[$j],       // [5]
                $pUnits[$j],        // [6]
                $pBuyPrices[$j],    // [7]
                $pSellPrices[$j],   // [8]
                $pMinStocks[$j],    // [9]
                $pVat[$j],          // [10]
                $pSupplier[$j]      // [11]
            );

        $j++;
       }

       // codeigniter backend validation 

       if ($this->form_validation->run() == FALSE){

                $data['previewarray'] = $importData;

                $data['content_view'] = 'csv/csvpreview';
                $value = $this->form_validation->error_array();
                //pa($value);
               // $this->template->main_template($data);
           $this->template->load('main', 'csv/csvpreview',$data);
        }
        else
        {
            // one by one product insert 

            foreach ($importData as $singleData) {                      

                  $data['product_code'] = $singleData[0];
                  $data['product_name'] = $singleData[1];
                  $data['description'] = $singleData[4];
                  $data['buy_price'] = $singleData[7];
                  $data['sell_price'] = $singleData[8];
                  $data['min_stock'] = $singleData[9];
                                       
                  // Category and sub cat selection and creation

                  $pc = $singleData[2];
                  $psc = $singleData[3];

                  if(empty($psc)){
                      $catInfo = $this->csv_model->catMatchingID($pc);
                      if(empty($catInfo[0]['id_product_category'])){
                          // insert new cat name and get id
                          $data['cat_id'] = $this->csv_model->insertCatNameGetId($pc);
                      }else{
                          // get Matching cat id
                          $data['cat_id'] = $catInfo[0]['id_product_category'];
                      }  
                      $data['subcat_id'] = NULL;                        
                  }else{
                      $catInfo = $this->csv_model->catMatchingID($pc);
                      if(empty($catInfo[0]['id_product_category'])){
                          // insert new cat name and get id
                          $data['cat_id'] = $this->csv_model->insertCatNameGetId($pc);
                          $data['subcat_id'] = $this->csv_model->insertSubCatNameGetId($psc, $data['cat_id']);
                      }else{
                          $subCatInfo = $this->csv_model->catMatchingID($psc);
                          
                          if(empty($subCatInfo[0]['id_product_category'])){

                            // get Matching cat id and not sub catID
                            $data['cat_id'] = $catInfo[0]['id_product_category'];
                            $data['subcat_id'] = $this->csv_model->insertSubCatNameGetId($psc, $data['cat_id']);

                          }else{

                            // get Matching cat id and sub catID
                            $data['cat_id'] = $catInfo[0]['id_product_category'];
                            $data['subcat_id'] = $subCatInfo[0]['id_product_category'];

                          }
                      } 
                  }

                  // end cat sub cat


                  // Brand selection and creation
                  $brandName = $singleData[5];
                  $brandInfo = $this->csv_model->matchingBrandId($brandName);
                  if(empty($brandInfo[0]['id_product_brand'])){
                    $brandId = $this->csv_model->insertNewBrand($brandName);
                    $data['brand_id'] = $brandId;
                  }else{
                    $data['brand_id'] = $brandInfo[0]['id_product_brand'];
                  }
                  
                  // unit id

                  $unit_name = $singleData[6];

                  $unitInfo = $this->csv_model->matchingUnitId($unit_name);

                  if(empty($unitInfo[0]['id_product_unit'])){

                    // insert new brand and return id
                    $unitId = $this->csv_model->insertNewUnit($unit_name);
                    $data['unit_id'] = $unitId;

                  }else{
                    // selected brand id
                    $data['unit_id'] = $unitInfo[0]['id_product_unit'];
                  }

                  // Supplier selection and creation
                  $supplierName = $singleData[11];
                  if($supplierName!=''){
                    $supplierInfo = $this->csv_model->matchingSupplierId($supplierName);
                    if($supplierInfo==''){
                      $supplierId = $this->csv_model->insertNewSupplier($supplierName);
                      $data['supplier_id'] = $supplierId;
                    }else{
                      $data['supplier_id'] = $supplierInfo[0]['id_supplier'];
                    }
                  }else{
                    $data['supplier_id']='';
                  }
                  $data['is_vatable']=($singleData[10]!='')?1:0;
                  $data['vat']=$singleData[10];
                  $this->csv_model->insertACsvProduct($data);
            }

            $this->session->set_flashdata('success', 'Csv Data Imported Succesfully'.$supplierName);
            redirect(base_url().'products');

            //$data['content_view'] = 'csv/csvindex';
            $this->template->load('main', 'csv/csvindex');
            //$this->template->main_template($data);
        }
    }

}