<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function bulk_customer(){
		for ($i=0; $i <=50000 ; $i++) { 
			$data['customer_code'] = $this->generateRandomString(13);
            $data['full_name'] = $this->generateRandomString(20);
            $data['customer_type_id'] = 1;
            $data['email'] = $this->generateRandomString(10).'@gmail.com';
            $data['phone'] = rand().rand();
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $data['uid_add'] = 1;
            $data['store_id'] = 1;
            $result=$this->commonmodel->common_insert('customers_test', $data);
            if($result){
            	echo $i.' -success.<br>';
            }else{
            	echo 'error.<br>';
            }
		}
	}
	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
