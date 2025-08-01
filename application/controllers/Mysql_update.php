<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mysql_update extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $transaction_mvt_types=array('Sales Commission','Credit Balance','Advance Amount','Refund Amount');
        for ($i=0; $i <count($transaction_mvt_types) ; $i++) { 
            $name=$transaction_mvt_types[$i];
        }
        $query = 'ALTER TABLE products ADD INDEX idx_product_name (product_name)';
        if($this->db->query($query)) {
            echo "It worked";
        }else{
            echo mysql_error();
        }
        $query = 'ALTER TABLE `stocks` ADD  INDEX `qty` (`qty`)';
        if($this->db->query($query)) {
            echo "It worked";
        }else{
            echo mysql_error();
        }
        echo 'connect';
    }

}
