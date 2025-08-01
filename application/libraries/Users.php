<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users{
	
	
	
	public static function is_logged_in() {
        $CI = & get_instance();
        if ($CI->session->userdata('login_info')!="") {
            return true;
        } else {
            redirect('login_form');
            exit();
        }
    }
	

	
}	//End Class
?>