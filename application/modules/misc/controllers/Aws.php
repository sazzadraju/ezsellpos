<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aws extends CI_Controller{
    
    private $bucket = 'posspot';
    private $client = 'pos01';
    
    public function __construct() {
        parent::__construct();	
		$this->load->library('aws3');	
	}
    
    ##  http://localhost/pos01/misc/aws/index
    public function index(){
        echo 'Test';
    }
    
    ##  http://localhost/pos01/misc/aws/add_bucket
    public function add_bucket(){
        
        $return = $this->aws3->addBucket($this->bucket);
        pa($return);
    }
    
    ##  http://localhost/pos01/misc/aws/upload_document
    public function upload_document(){
        
        ## 1. Confirm the buckets exists. if not exists creates bucket
        $this->aws3->addBucket($this->bucket);
            
        if(isset($_FILES['file']))
        {
            ## 2. Uplaods file in the bucket
            $doc_type = $this->input->post('doc_type');
            $ext = @end((explode(".", $_FILES['file']['name'])));
            $file_upload_path = $this->client.'/'.get_key($this->config->item('document_paths'), $doc_type).'/'.date('Ymd') . time() .'.'. $ext;
            $file_location = $_FILES['file']['tmp_name'];
            $data['aws_s3_url'] = $this->aws3->sendFile($this->bucket, $file_upload_path, $file_location);	
        }
        
        $data['types'] = array_keys($this->config->item('document_paths'));
        $data['file_size'] = $this->aws3->getFolderSize($this->bucket, $this->client);
        $this->load->view('aws/upload_document', $data);
    }
    
    public function get_filesize(){
        $this->aws3->getFolderSize($this->bucket, $this->client);
    }
    
    
    ##  http://localhost/pos01/misc/aws/delete_document
    public function delete_document(){
        $filepath = 'pos01/employees';
        $filename = '201803011519897418.jpg';
        
        
        ##  https://s3.amazonaws.com/posspot/pos01/employees/201803011519897630.jpg
        
        $result = $this->aws3->deleteFile($this->bucket, $filepath, $filename);
        pa($result);
        
       /* ## DELETE REQUEST WITH EXISTING FILE
        Guzzle\Service\Resource\Model::__set_state(array(
            'structure' => NULL,
            'data' => 
           array (
             'DeleteMarker' => false,
             'VersionId' => '',
             'RequestCharged' => '',
             'RequestId' => 'CFA435E0AAFCADC1',
           ),
         ))
        */
        
        /* ## DELETE REQUEST WITH NOT EXIST FILE
        Guzzle\Service\Resource\Model::__set_state(array(
            'structure' => NULL,
            'data' => 
           array (
             'DeleteMarker' => false,
             'VersionId' => '',
             'RequestCharged' => '',
             'RequestId' => '160FB97D5928D2BC',
           ),
         ))
        */
    }
}
