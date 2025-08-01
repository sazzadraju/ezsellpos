<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('api_model', 'model');

    }

    public function daily_sale_reports_get()
    {
        $store_id = $this->input->get('store_id');
        $data = $this->model->daily_sale_report($store_id);
        if ($data) {
            $this->response(array('response' => $data), 200);
        } else {
            $this->response(array('error' => 'Error in code'), 400);
        }
    }

    public function stock_summary_get()
    {
        $rowArray = array(
            'store_id' => $this->input->get('store_id')
        , 'product_name' => $this->input->get('product_name')
        );
        $data = $this->model->stockSummaryReports($rowArray);
        if ($data) {
            $this->response(array('response' => $data), 200);
        } else {
            $this->response(array('error' => 'Error in code'), 400);
        }
    }

    public function customer_view_get()
    {
        $rowArray = array(
            'customer_name' => $this->input->get('cus_name')
            ,'customer_phone' => $this->input->get('cus_phone')
        );
        $data = $this->model->customer_view($rowArray);
        if ($data) {
            $this->response(array('response' => $data), 200);
        } else {
            $this->response(array('error' => 'Error in code'), 400);
        }
    }
}