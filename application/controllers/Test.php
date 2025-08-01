<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        exit;
        $this->load->library('DigitalOcean');

        //var_dump($this->digitalocean->chkBucketExists('clients'));
        var_dump($this->digitalocean->addBucket('clients'));
        exit;
    }
}