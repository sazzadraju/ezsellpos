<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends MX_Controller {
     private $perPage=null;
    
    function __construct(){  
		parent::__construct();
		
		if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }

        $this->perPage = 20;
		$this->load->model('Card_model', 'cardmodel');
	}
    
    
    ## http://localhost/dpos/account-settings/card
    public function index(){
        $data = array();
        $this->dynamic_menu->check_menu('account-settings/card-type');
        $this->breadcrumb->add(lang('account_settings'),'account-settings/account', 1);
        $this->breadcrumb->add(lang('cards'),'', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        
        $data['cards'] = $this->cardmodel->listCards($this->perPage);
        //$data['mobile_banks'] = $this->cardmodel->listCards();
        $this->template->load('main', 'card/index', $data);
    }
}
