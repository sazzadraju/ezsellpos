<?php

class AccessControl
{
    var $CI;

    function __construct()
    {
        $this->CI =& get_instance();
        if (isset($this->CI->session)) {
            $this->CI->load->library('session');
            $this->CI->load->library('dynamic_menu');
        }
    }

    function checkAccessControl()
    {
        $url = str_replace("/pos01/", "", $_SERVER['REQUEST_URI']);
        if (isset($this->CI->session->userdata['login_info']) && $url != 'dashboard') {
            $type_id = $this->CI->session->userdata['login_info']['user_type_i92'];
            $user_id = $this->CI->session->userdata['login_info']['id_user_i90'];
            //echo $url . '<br>';
            //echo  $user_id
            if ($type_id != 3) {
                $check = $this->CI->dynamic_menu->check_menu($user_id);
                echo '<br>'.$check;
                if ($check==2) {

                    //$this->CI->session->unset_userdata('login_info');
                   // session_destroy();
                   // redirect('login_form');
                }
                return true;
            } else {
                return true;
            }
        }

//echo 'welcome to jay nale abedin';
        // This function will run after the constructor for the controller is ran
        // Set any initial values here
//        if (!$this->session->userdata('username')) { // This is line 13
//            redirect('login');
//        }
    }
}