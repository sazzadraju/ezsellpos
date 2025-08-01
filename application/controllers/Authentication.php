<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {

            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->load->model('Auth_model');
        $this->load->model('promotion_management/Promotion_settings_model');
    }

    function index() {
        $data['subs']=$this->Auth_model->subscription_check();
        $this->load->view('auth/login',$data);
    }

    function renew_update(){
        $data = json_decode(file_get_contents('php://input'), true);
        $date=$data['date'];
        $password=$data['password'];
        if($password==md5('syntech_98765430')){
            $array = array(
               array(
                  'param_key' => 'SUBSCRIPTION_TO' ,
                  'param_val' => $date
               ),
               array(
                  'param_key' => 'TOT_STORES' ,
                  'param_val' => $data['store']
               ),
               array(
                  'param_key' => 'TOT_STATIONS' ,
                  'param_val' => $data['station']
               ),
               array(
                  'param_key' => 'TOT_USERS' ,
                  'param_val' => $data['user']
               )
            );
        $this->db->update_batch('configs', $array, 'param_key');
            echo 'success';
        }else{
            echo 'error';
        }

    }

    public function authentication_check() {
        $login_name = $this->input->post('login_name');
        $login_password = $this->input->post('login_password');
        
        if (filter_var($login_name, FILTER_VALIDATE_EMAIL)) {
            $UserInfo = $this->Auth_model->login_row_array('users', 'email', $login_name);
        } else {
            $UserInfo = $this->Auth_model->login_row_array('users', 'uname', $login_name);
        }

        $SubscriptionInfo = $this->Auth_model->subscription_check();
        $login_password = md5($login_password . $UserInfo['salt']);
        
        if ($login_password == $UserInfo['passwd'] && $UserInfo['status_id'] == 1) {
            if (!empty($SubscriptionInfo['SUBSCRIPTION_TO']) && $SubscriptionInfo['SUBSCRIPTION_STATUS'] == "Active") {
                $subscription_end_date = strtotime($SubscriptionInfo['SUBSCRIPTION_TO'] . ' +1 day');
                $todays_date = strtotime("now");
                if ($todays_date <= $subscription_end_date) {
                    $acc_id = $this->Auth_model->get_user_account_id($UserInfo['station_id'], $UserInfo['store_id']);
                    $login_info = array(
                        'id_user_i90' => $UserInfo['id_user'],
                        'uname_i91' => $UserInfo['uname'],
                        'user_type_i92' => $UserInfo['user_type_id'],
                        'store_img' => $UserInfo['store_img'],
                        'fullname' => $UserInfo['fullname'],
                        'nickname' => $UserInfo['nickname'],
                        'user_email' => $UserInfo['email'],
                        'store_email' => $UserInfo['store_email'],
                        'mobile' => $UserInfo['mobile'],
                        'store_mobile' => $UserInfo['store_mobile'],
                        'store_id' => $UserInfo['store_id'],
                        'store_ids' => $UserInfo['user_type_id']==3 
                            ? array_keys($this->commonmodel->listAllStores()) : [$UserInfo['store_id']],
                        'station_id' => $UserInfo['station_id'],
                        'address'=>$UserInfo['address'],
                        'store_name' => $UserInfo['store_name'].'&'.$UserInfo['store_id'],
                        'station_name' => $UserInfo['station_name'],
                        'station_acc_id' => $acc_id['id_account'],
                        'subscription_info' => $SubscriptionInfo,
                        'logged_in' => TRUE);
                    $this->session->set_userdata('login_info', $login_info);
                    $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'file'));
                    $this->cache->delete('acl_module_id_'.$UserInfo['id_user']);
                    $this->cache->delete('acl_sub_module_id_'.$UserInfo['id_user']);
                    $this->cache->delete('acl_module');
                    $this->cache->delete('acl_sub_module');
                    $this->Promotion_settings_model->promotion_check($UserInfo['id_user']);
                    redirect('dashboard');
                    exit;
                } else {
                    $this->session->set_flashdata('login_error', lang('package_exired'));
                    redirect('login_form', $data);
                    exit;
                }
            } else {
                $this->session->set_flashdata('login_error', lang('package_exired'));
                redirect('login_form', $data);
                exit;
            }
        } else {
            $this->session->set_flashdata('login_error', lang('login_mismatch'));
            redirect('login_form', $data);
            exit;
        }
    }

    public function signout() {
        if ($this->session->userdata['login_info']['logged_in'] == 1) {
            $this->session->unset_userdata('login_info');
            session_destroy();
            redirect('login_form');
            exit();
        } else {
            redirect('login_form');
            exit();
        }
    }

}
