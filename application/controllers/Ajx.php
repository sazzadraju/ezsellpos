<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajx extends MX_Controller 
{
    function __construct(){  	
		parent::__construct();
        $this->load->model('ajx_model');
	}

	public function list_customers_by_search()
	{
        $key = $this->input->get('key', TRUE);
        $customers = [];
        $tmp = $this->ajx_model->list_customers($key);
        foreach($tmp as $t){
            $customers[] = [
                'label' => $t['name'] . ' ('.$t['phone'].')',
                'value' => $t['id'],
            ];
        }
        echo json_encode($customers);
	}
    
    public function list_suppliers_by_search()
    {
        $key = $this->input->get('key', TRUE);
        $suppliers = [];
        $tmp = $this->ajx_model->list_suppliers($key);
        foreach($tmp as $t){
            $suppliers[] = [
                'label' => $t['name'] . ' ('.$t['phone'].')',
                'value' => $t['id'],
            ];
        }
        echo json_encode($suppliers);
    }

    public function list_employees_by_search()
    {
        $key = $this->input->get('key', TRUE);
        $employees = [];
        $tmp = $this->ajx_model->list_employees($key);
        foreach($tmp as $t){
            $employees[] = [
                'label' => $t['name'] . ' ('.$t['phone'].')',
                'value' => $t['id'],
            ];
        }
        echo json_encode($employees);   
    }

    public function list_investors_by_search()
    {
        $key = $this->input->get('key', TRUE);
        $investors = [];
        $tmp = $this->ajx_model->list_investors($key);
        foreach($tmp as $t){
            $investors[] = [
                'label' => $t['name'] . ' ('.$t['phone'].')',
                'value' => $t['id'],
            ];
        }
        echo json_encode($investors);   
    }
}
