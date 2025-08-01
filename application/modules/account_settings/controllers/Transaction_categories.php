<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class transaction_categories extends MX_Controller {
    
    private $perPage=null;
    
    function __construct(){  
		parent::__construct();
        
        $this->form_validation->CI =& $this;
        $this->load->library('form_validation');
		
		if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }

        $this->perPage = 20;
		$this->load->model('Transaction_categories_model', 'trxcatmodel');
	}

    public function index() {
        $data = array();
        $this->dynamic_menu->check_menu('account-settings/transaction-category');
        $this->breadcrumb->add(lang('account_settings'),'account-settings/account', 1);
        $this->breadcrumb->add(lang('transaction_categories'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        
        $data['parent_categories'] = $this->trxcatmodel->listParentCatories(1);
        //dd($data['parent_categories']);
        $data['categories'] = $this->trxcatmodel->listTransactionCatories($this->perPage);
        
        $config['target'] = '#catlist';
        $config['base_url'] = base_url() . 'account-settings/transaction-category-page';
        $config['total_rows'] = $this->trxcatmodel->getTotTransactionCatories();
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        $data['offset'] = 0;
        
//        dd($data['categories']);
        $this->template->load('main', 'transaction_categories/index', $data);
    }
    
    public function paginated_data($offset=0){
        $data = array();
        $acc_type = 1;
        $offset = (int) $offset;
        
        $data['categories'] = $this->trxcatmodel->listTransactionCatories($this->perPage, $offset);
        
        $config['target'] = '#catlist';
        $config['base_url'] = base_url() . 'account-settings/transaction-category-page';
        $config['total_rows'] = $this->trxcatmodel->getTotTransactionCatories();
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        $data['limit'] = $this->perPage;
        $data['offset'] = $offset;
        $this->load->view('transaction_categories/paginated_data', $data, false);
    }

    public function add_data() {
        $id = $this->input->post('id');
        $cat_type = (int)$this->input->post('cat_type');
        $cat_name = $this->input->post('cat_name');
        $parent_cat = (int)$this->input->post('parent_cat');
        
        //$this->form_validation->set_rules('cat_type', 'Type', 'trim|required|callback_isValidTrxType');
        $this->form_validation->set_rules('cat_name', 'Name', 'trim|required|min_length[3]|max_length[20]|callback_is_unique_cat['.$id.']|callback_isChildCatAllowed['.$parent_cat.']|callback_isParentChildSame['.$id.'@'.$parent_cat.']');
        //$this->form_validation->set_rules('cat_name', 'Name', 'trim|required|min_length[3]|max_length[20]|callback_is_unique_cat['.$id.']');
        
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $data = array();
            $data['trx_name'] = trim($cat_name);
            $data['parent_id'] = (int)$parent_cat;
            $data['qty_modifier'] = $cat_type;
            
            if(empty($id)){
                $data['dtt_add'] = date('Y-m-d H:i:s');
                $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                $insert_id = $this->commonmodel->commonInsertSTP('transaction_categories', $data);
                echo json_encode(array("status" => "success", "message" => 'Category Added successfully'));
            } else{
                $data['dtt_mod'] = date('Y-m-d H:i:s');
                $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                $sts = $this->commonmodel->commonUpdateSTP('transaction_categories', $data, ['id_transaction_category'=>$id]);
                echo json_encode(array("status" => "success", "message" => 'Category Updated successfully'));
            }
        }
    }
    
    public function delete_data($id) {
        if($this->trxcatmodel->isDeletable($id)){
           //echo 'This Category has child categories. Delete is not possible.'; 
            echo json_encode(array("status" => FALSE,'res'=>1));
        }elseif($this->trxcatmodel->isTransactionDelete($id)){
            echo json_encode(array("status" => FALSE,'res'=>2));
        } else{
            $data = [
                'status_id' => '2',
                'dtt_mod' => date('Y-m-d H:i:s'),
                'uid_mod' => $this->session->userdata['login_info']['id_user_i90'],
            ];
            $this->commonmodel->commonUpdateSTP('transaction_categories', $data, ['id_transaction_category'=>$id]);
            echo json_encode(array("status" => 'Category deleted successfully.'));
        }
    }
    
    public function edit_data($id = null) {
        $data = $this->trxcatmodel->get_category_data_by_id($id);
        echo json_encode($data);
    }
    
    public function is_unique_cat($str, $id){
        $sts = $this->commonmodel->isExistExcept('transaction_categories', 'trx_name', $str, 'id_transaction_category', $id);
        if($sts){
            $this->form_validation->set_message('is_unique_cat', 'Category already exists');
            return FALSE;
        } else{
            return TRUE;
        }
    }
    
    public function isChildCatAllowed($str, $parent_cat_id){
        ## hasChildCat && $parent_cat_id => NOT ALLOWED
        if(!empty($parent_cat_id) && $this->trxcatmodel->hasChildCat($str)){
            $this->form_validation->set_message('isChildCatAllowed', $this->lang->line('err_has_child_caterogy'));
            return FALSE;
        } else{
            return TRUE;
        }
    }
    
    public function isParentChildSame($str, $ids){
        $tmp = explode('@',$ids);
        $id = $tmp[0];
        $parent_id = isset($tmp[1]) ? $tmp[1] : 0;
        
        if($id > 0 && $id==$parent_id){
            $this->form_validation->set_message('isParentChildSame', $this->lang->line('err_parent_child_same'));
            return FALSE;
        } else{
            return TRUE;
        }
    }
    
    public function isValidTrxType($type){
        if(!in_array($type, [1, -1])){
            $this->form_validation->set_message('isValidTrxType', 'Type is Invalid');
            return FALSE;
        } else{
            return TRUE;
        }
    }
    
    ##  http://localhost/dpos/account-settings/transaction-categories/parent_categories
    public function parent_categories(){
        $cat_id = (int)$this->input->post('id');
        $cat='';
        //echo $cat_id;
        $parentCatories = $this->trxcatmodel->listParentCatoriesId($cat_id);
        //print_r($parentCatories);
        $cat.= '<option value="0">'.$this->lang->line("select_one").'</option>';
        foreach($parentCatories as $data){
            $cat.= '<option value="'.$data->id.'">'.$data->trx_name.'</option>';
        }
        echo $cat;
    }
    
    ##  http://localhost/dpos/account-settings/transaction-categories/test
    public function test(){
        $str = 'bbbb';
        $this->trxcatmodel->hasChildCat($str);
    }

}
