<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends MX_Controller
{

    private $perPage = null;

    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {
            $this->lang->load('en');
        }

        $this->perPage = 20;
        $this->load->model('Bank_model', 'bankmodel');
    }

    ## http://localhost/dpos/account-settings/bank
    public function index()
    {
        $data = array();
        $this->dynamic_menu->check_menu('account-settings/bank');
        $this->breadcrumb->add(lang('account_settings'), 'account-settings/account', 1);
        $this->breadcrumb->add(lang('banks'), '', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();

        $total = $this->bankmodel->getTotBanks(1);
        $data['general_banks'] = $this->bankmodel->listBanks(1, $total, $this->perPage);

        $config = [
            'target' => '#gen_bnk_lst',
            'base_url' => base_url() . 'account-settings-bank/page_general',
            'total_rows' => $total,
            'per_page' => $this->perPage,
            'link_func' => 'searchFilter1',
        ];
        $pagination1 = clone($this->ajax_pagination);
        $pagination1->initialize($config);
        $data['pagination_link_1'] = $pagination1->create_links();

//        $config['target'] = '#gen_bnk_lst';
//        $config['base_url'] = base_url() . 'account-settings-bank/page_general';
//        $config['total_rows'] = $total;
//        $config['per_page'] = $this->perPage;
//        $config['link_func'] = 'searchFilter';
//        $this->ajax_pagination->initialize($config);
//        $data['pagination_link_1']=$this->ajax_pagination->create_links();


        $total = $this->bankmodel->getTotBanks(2);
        $data['mobile_banks'] = $this->bankmodel->listBanks(2, $total, $this->perPage);
        $config = [
            'target' => '#mob_bnk_lst',
            'base_url' => base_url() . 'account-settings-bank/page_mobile',
            'total_rows' => $total,
            'per_page' => $this->perPage,
            'link_func' => 'searchFilter2',
        ];
        $pagination2 = clone($this->ajax_pagination);
        $pagination2->initialize($config);
        $data['pagination_link_2'] = $pagination2->create_links();

//        $config['target'] = '#mob_bnk_lst';
//        $config['base_url'] = base_url() . 'account-settings-bank/page_mobile';
//        $config['total_rows'] = $total;
//        $config['per_page'] = $this->perPage;
//        $config['link_func'] = 'searchFilter2';
//        $this->ajax_pagination->initialize($config);
//        $data['pagination_link_2']=$this->ajax_pagination->create_links();

        $this->template->load('main', 'bank/index', $data);
    }

    public function page_general_data($page)
    {
        $data = array();
        $bank_type = 1;
        $page = (int)$page;
        $offset = !empty($page) ? $page : 0;

        $total = $this->bankmodel->getTotBanks($bank_type);
        $data['general_banks'] = $this->bankmodel->listBanks($bank_type, $total, $this->perPage);

        $config = [
            'target' => '#gen_bnk_lst',
            'base_url' => base_url() . 'account-settings-bank/page_general',
            'total_rows' => $total,
            'per_page' => $this->perPage,
            'link_func' => 'searchFilter1',
        ];
        $pagination1 = clone($this->ajax_pagination);
        $pagination1->initialize($config);
        $data['pagination_link_1'] = $pagination1->create_links();

        //pagination configuration
//        $config['target'] = '#gen_bnk_lst';
//        $config['base_url'] = base_url() . 'account-settings-bank/page_general';
//        $config['total_rows'] = $this->bankmodel->getTotBanks($bank_type);
//        $config['per_page'] = $this->perPage;
//        $config['link_func'] = 'searchFilter';
//        $this->ajax_pagination->initialize($config);
//        $data['pagination_link_1']=$this->ajax_pagination->create_links();
//        $data['general_banks'] = $this->bankmodel->listBanks($bank_type, $total, $this->perPage, $offset);


        $data['limit'] = $this->perPage;
        $data['offset'] = $offset;
        $this->load->view('bank/paginated_gen_data', $data, false);
    }

    public function page_mobile_data($page)
    {
        $data = array();
        $bank_type = 2;
        $page = (int)$page;
        $offset = !empty($page) ? $page : 0;

        $total = $this->bankmodel->getTotBanks($bank_type);
        $data['mobile_banks'] = $this->bankmodel->listBanks($bank_type, $total, $this->perPage);
        $config = [
            'target' => '#mob_bnk_lst',
            'base_url' => base_url() . 'account-settings-bank/page_mobile',
            'total_rows' => $total,
            'per_page' => $this->perPage,
            'link_func' => 'searchFilter2',
        ];
        $pagination2 = clone($this->ajax_pagination);
        $pagination2->initialize($config);
        $data['pagination_link_2'] = $pagination2->create_links();
//        //pagination configuration
//        $config['target'] = '#mob_bnk_lst';
//        $config['base_url'] = base_url() . 'account-settings-bank/page_mobile';
//        $config['total_rows'] = $this->bankmodel->getTotBanks($bank_type);
//        $config['per_page'] = $this->perPage;
//        $config['link_func'] = 'searchFilter';
//        $this->ajax_pagination->initialize($config);
//        $data['pagination_link_2']=$this->ajax_pagination->create_links();
//        $data['mobile_banks'] = $this->bankmodel->listBanks($bank_type, $total, $this->perPage, $offset);

        $data['limit'] = $this->perPage;
        $data['offset'] = $offset;
        $this->load->view('bank/paginated_mob_data', $data, false);
    }

    public function edit_data($id = null)
    {
        $data = $this->bankmodel->getBankById($id);
        echo json_encode($data);
    }

    public function add_data()
    {
        if ($this->input->post('bank_name')) {
            $hid = (int)$this->input->post('hid', true);
            $data['bank_name'] = $this->input->post('bank_name', true);
            $data['bank_type_id'] = $this->input->post('bank_type', true);

            $errors = array();
//            if(empty($data['bank_name'])){
//               $errors['bank_name'] = 'Bank name is empty!';
//            } elseif(empty($hid) && $this->commonmodel->isExist('banks', 'bank_name', $data['bank_name'])){
//                $errors['bank_name'] ='Bank name exists!';
//            } elseif(!empty($hid) && $this->commonmodel->isExistExcept('banks', 'bank_name', $data['bank_name'], 'id_bank', $hid)){
//                $errors['bank_name'] = 'Bank name exists!';
//            }

            if (!empty($errors)) {
                echo json_encode(array("status" => "error", "errors" => $errors));
            } else {
                $message = '';
                if (empty($hid)) {
                    $data['dtt_add'] = date('Y-m-d H:i:s');
                    $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $message = $this->commonmodel->commonInsertSTP('banks', $data);
                    if ($message) {
                        echo json_encode(array("status" => "success", "message" => "Bank added successfully"));
                    } else {
                        echo json_encode(array("status" => "failed", "message" => "Bank add failed"));
                    }
                } else {
                    $data['dtt_mod'] = date('Y-m-d H:i:s');
                    $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
                    $message = $this->commonmodel->commonUpdateSTP('banks', $data, ['id_bank' => $hid]);
                    if ($message) {
                        echo json_encode(array("status" => "success", "message" => "Bank updated successfully"));
                    } else {
                        echo json_encode(array("status" => "failed", "message" => "Bank update failed"));
                    }
                }
            }
        } else {
            echo json_encode(array("status" => "warning", "message" => 'NO DATA'));
        }
    }

    public function delete_data($id)
    {
        $data['status_id'] = 2;
        $count=$this->commonmodel->isExist('accounts', 'bank_id', $id);
        if($count){
            echo json_encode(array('type'=>1));
        }else{
            $data['dtt_mod'] = date('Y-m-d H:i:s');
            $data['uid_mod'] = $this->session->userdata['login_info']['id_user_i90'];
            $sts=$this->commonmodel->commonUpdateSTP('banks', $data, ['id_bank' => $id]);
            echo json_encode(array("status" => $sts,'type'=>2));
        }

    }

    /**
     * writes false if name exists.
     * writes true if name does not exist
     */
    public function check_bank_name()
    {
        $bank_name = $this->input->post('bank_name', true);
        $bank_type = $this->input->post('bank_type', true);
        $bank_id = (int)$this->input->post('hid', true);

        $exist = empty($bank_id)
            ? $this->commonmodel->isExist('banks', 'bank_name', $bank_name)
            : $this->commonmodel->isExistExcept('banks', 'bank_name', $bank_name, 'id_bank', $bank_id);

        echo $exist ? 'false' : 'true';
        //echo 'false';
    }
}
