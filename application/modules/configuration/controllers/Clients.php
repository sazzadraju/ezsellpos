<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends MX_Controller {

	function __construct(){  
		parent::__construct();
		
		$this->load->helper('language');
		$this->load->library('session');
		if ($this->session->userdata('language') == "en") {

            $this->lang->load('en');
        } else {

            $this->lang->load('jp');
        }

		$this->load->model('Clients_model');
	}		
	
	public function index()
	{
		$data['sajib'] = 'sajib';
		//echo lang('sajib');
		$this->template->load('main', 'clients/index');
        
	}


}
