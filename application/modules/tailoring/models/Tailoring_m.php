<?php
 
class Tailoring_m extends CI_Model {
 
    function __construct() {
        parent::__construct();
 
    }
    public function getvalue_row_array($tbl, $fn, $fcon = array())
    {
        $this->db->select($fn);
        $this->db->where($fcon);
        $q = $this->db->get($tbl);
        if ($q->num_rows() > 0) {
            $res = $q->result_array();
            return $res;
        }
        return false;
    }
    public function update_value($tblname, $setvalue = array(), $convalue = array(), $version = false) {
        $this->sql = '';
        $this->key = '';
        $this->value = '';
        $this->key = array_keys($convalue);
        $this->value = array_values($convalue);
        for ($i = 0; $i < count($convalue); $i++) {
            $this->db->where($this->key[$i], $this->value[$i]);
        }
        if ($version) {
            $this->db->set('version', '`version`+1', FALSE);
        }
        $update = $this->db->update($tblname, $setvalue);
        if ($update) {
            return true;
        }
        return false;
    }
    public function get_all_tailoring(){
        $this->db->select('ts.id_service,ts.service_name,ts.service_price');
        $this->db->from(' tailoring_services ts');
        $this->db->where('status_id', 1);    
        $query=$this->db->get();
        $data= $query->result_array();
        return $data;
    }

    public function getServiceById($id){

        $this->db->select('*');
        $this->db->from('tailoring_services'); 
        $this->db->where('id_service', $id);    
        $this->db->where('status_id', 1);    
        $query1 = $this->db->get(); 
        $service = $query1->result_array();

        $this->db->select('*');
        $this->db->from('tailoring_fields');      
        $this->db->where('service_id', $id); 
        $query3 = $this->db->get(); 
        $field_types = $query3->result_array();

        $fields = array();
        $designs = array();
        foreach ($field_types as $ftValue) {
            
            if($ftValue['field_type_id'] == 1){
                $fields[] = $ftValue;
            } 

            if($ftValue['field_type_id'] == 2){
                $designs[] = $ftValue;
            }          

        }


        $TDFarray = array();
        foreach ($service as $serviceValue) {
            $TDFarray = array(
                'service_name' => $serviceValue['service_name'],
                'service_price' => $serviceValue['service_price'],
                'fields' => $fields,
                'designs' => $designs
            );
        }
        return $TDFarray;
    }

    public function serviceDelete($sid){
        $data = array( 'status_id' => 2);
        $this->db->where('id_service', $sid);
        $this->db->update(' tailoring_services', $data); 
        $updated_status = $this->db->affected_rows();
        if($updated_status):
            // delete images            
            // $this->db->select('field_img');
            // $this->db->from('tailoring_fields');  
            // $this->db->where('field_type_id', 2);  
            // $this->db->where('service_id', $sid);  
            // $query = $this->db->get(); 
            // $deletedImg = $query->result_array();

            // foreach ($deletedImg as $dimgs) {               
            //     delete_file('tailoring', $dimgs['field_img']);
            // }
             
            return $student_id;
        else:
            return false;
        endif;
    }

    public function insert_tailoring_types_fields_designs($types, $fields){

        $this->db->query("CALL temp_tailoring_fields()");

        foreach ($fields as $field) {

            $this->commonmodel->commonInsertSTP('tmp_tailoring_fields',$field);
        }

        $data="'".$types['service_name']."','".$types['service_price']."','".$types['dtt_add']."','".$types['uid_add']."',@insert_id";
        
        $insert=$this->db->query("CALL tailoring_service_add(".$data.")");
        $query=$this->db->query("SElECT @insert_id AS insert_id");
        return $query->result_array();
    }

    public function update_tailoring_types_fields_designs($types, $fields){
        $this->db->query("CALL temp_tailoring_fields()");
        foreach ($fields as $field) {
            $this->commonmodel->commonInsertSTP('tmp_tailoring_fields',$field);
        }
        $data="'".$types['id_service']."','".$types['service_name']."','".$types['service_price']."','".$types['dtt_mod']."','".$types['uid_mod']."','upt',@insert_id";
        
        $insert=$this->db->query("CALL tailoring_service_update(".$data.")");
        $query=$this->db->query("SElECT @insert_id AS insert_id");
        return $query->result_array();
    }

    public function getAllBillType($params = array()){

        $this->db->select('*');
        $this->db->from('tailoring_fields');
        $this->db->where('field_type_id', 3);
        $this->db->where('status_id', 1);
        
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    public function getFilterOrderRows($params = array()){
        $this->db->select('*');
        $this->db->from('tailoring_orders to'); 
        $this->db->join('customers c','to.customer_id=c.id_customer', 'left');
        $this->db->where('to.status_id', 1); 
        $this->db->order_by('to.dtt_add','desc');

        if(array_key_exists("name_customer",$params)){
            $this->db->where('c.full_name =', $params['name_customer']);
        }

        if(array_key_exists("phone_customer",$params)){
            $this->db->where('c.phone =', $params['phone_customer']);
        }
        if(array_key_exists("receipt_no",$params)){
            $this->db->where('to.receipt_no =', $params['receipt_no']);
        }
        if(array_key_exists("order_status",$params)){
            $this->db->where('to.order_status =', $params['order_status']);
        }

        if(array_key_exists("date_type",$params)){
            if($params['date_type'] == 1 && !empty($params['start_date']) && !empty($params['end_date'])){
                $this->db->where('to.order_date >=', $params['start_date']);
                $this->db->where('to.order_date <=', $params['end_date']);
            }
            if($params['date_type'] == 2 && !empty($params['start_date']) && !empty($params['end_date'])){
                $this->db->where('to.delivery_date >=', $params['start_date']);
                $this->db->where('to.delivery_date <=', $params['end_date']);
            }
        }
        
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    public function insertBillType($billtn){        
        $data = array(
           'field_type_id' => 3,
           'field_name' => $billtn,
           'dtt_add' => null,
           'uid_add' => 1
        );

        $this->db->insert('tailoring_fields', $data); 
        return $this->db->insert_id(); 
    }

    public function pricing_delete($id){
        $data = array('status_id' => 0);
        $this->db->where('id_field', $id);
        $this->db->update('tailoring_fields', $data);

    }

    public function getServices(){
        $this->db->select('ts.id_service, ts.service_name, ts.service_price');
        $this->db->from('tailoring_services ts'); 
        $this->db->where('ts.status_id', 1);       
        $query = $this->db->get(); 
        $service = $query->result_array();
        return $service;
    }

    public function getAllBillingTypes(){
        $this->db->select('*');
        $this->db->from('tailoring_fields'); 
        $this->db->where('status_id', 1);     
        $this->db->where('field_type_id', 3);  
        $query = $this->db->get(); 
        $billingTypes = $query->result_array();
        return $billingTypes;
    }

    public function getAllAccounts(){
        $this->db->select('*');
        $this->db->from('accounts a'); 
        $this->db->join('banks b','a.bank_id=b.id_bank', 'left');
        $this->db->where('a.status_id', 1);  
        $query = $this->db->get(); 
        $accDetail = $query->result_array();
        return $accDetail;
    }

    public function getSinAccount($id){
        $this->db->select('*');
        $this->db->from('accounts a'); 
        $this->db->join('banks b','a.bank_id=b.id_bank', 'left');
        $this->db->where('id_account', $id);  
        $this->db->where('a.status_id', 1);  
        $query = $this->db->get(); 
        $accDetail = $query->result_array();
        return $accDetail;
    }

    public function getAllCustomer(){
        $this->db->select('*');
        $this->db->from('customers'); 
        // $this->db->join('banks b','a.bank_id=b.id_bank', 'left');
        // $this->db->where('id_account', $id);  
        $this->db->where('status_id', 1); 
        $query = $this->db->get(); 
        $customers = $query->result_array();
        return $customers;        
    }

    public function insert_tailoring_order_measurement($order, $services, $measurements){

        $this->db->query("CALL temp_tailoring_orders()");

        foreach ($services as $service) {
            $this->commonmodel->commonInsertSTP('tmp_tailoring_order_details',$service);
        }

        foreach ($measurements as $measurement) {
            $this->commonmodel->commonInsertSTP('tmp_tailoring_measurements',$measurement);
        }


        $data="'".$order['customer_id']."','".$order['store_id']."','".$order['receipt_no']."','".$order['notes']."','".$order['order_date']."','".$order['delivery_date']."','".$order['tot_amt']."','".$order['paid_amt']."','".$order['discount_rate']."','".$order['discount_amt']."','".$order['order_status']."','".$order['station_id']."','".$order['invoice_no']."','".$order['trx_no']."','".$order['account_id']."','".$order['payment_method_id']."','".$order['ref_acc_no']."','".$order['ref_bank_id']."','".$order['ref_card_id']."','".$order['ref_trx_no']."','".$order['dtt_add']."','".$order['uid_add']."',@insert_id";
      
        
        $insert=$this->db->query("CALL tailoring_orders(".$data.")");
        $query=$this->db->query("SElECT @insert_id AS insert_id");
       $this->auto_increment->updAutoIncKey('TAILORING', $order['receipt_no'], $order['receipt_no']);
       return $query->result_array();
    }

    public function  get_all_tailoring_orders(){
        $this->db->select('*');
        $this->db->from('tailoring_orders to'); 
        $this->db->join('customers c','to.customer_id=c.id_customer', 'left');
        // $this->db->where('id_account', $id);  
        $this->db->where('to.status_id', 1); 
        $query = $this->db->get(); 
        $orders = $query->result_array();
        return $orders;   
    }

    public function get_order_by_id($id){
        $this->db->select('*');
        $this->db->from('tailoring_orders'); 
        $this->db->where('id_order', $id);  
        $this->db->where('status_id', 1); 
        $query = $this->db->get(); 
        $order = $query->result_array();
        return $order;  
    }

    public function get_order_detail_by_id($id){
        $this->db->select('*');
        $this->db->from('tailoring_order_details'); 
        $this->db->where('order_id', $id);  
        $query = $this->db->get(); 
        $orderDetails = $query->result_array();
        return $orderDetails; 
    }

    public function get_order_measurements_by_id($oId){

        $this->db->select('*');
        $this->db->from('tailoring_measurements'); 
        $this->db->where('order_id', $oId); 
        
        // $this->db->where('service_id', $sid);  
        // $this->db->where('order_details_id', $odid);  
        $query = $this->db->get(); 
        $measurements = $query->result_array();

        $realDesign = array();
        $realMeasure = array();
        $realBill = array();

        foreach ($measurements as $singleMeasur) {



            if($singleMeasur['field_type_id'] == 1){

                $this->db->select('field_name');
                $this->db->from('tailoring_fields'); 
                $this->db->where('id_field', $singleMeasur['field_id']);  
                $query = $this->db->get(); 
                $sName = $query->result_array();


                $realMeasure[] = array(
                    'id_measurement' => $singleMeasur['id_measurement'],
                    'order_details_id' => $singleMeasur['order_details_id'],
                    'service_id' => $singleMeasur['service_id'],
                    'service_identify' => $singleMeasur['service_identify'],
                    'field_type_id' => $singleMeasur['field_type_id'],
                    'field_id' => $sName[0]['field_name'],
                    'field_value' => $singleMeasur['field_value'],
                );
            }

            if($singleMeasur['field_type_id'] == 2){

                $this->db->select('field_img');
                $this->db->from('tailoring_fields'); 
                $this->db->where('id_field', $singleMeasur['field_id']);  
                $query = $this->db->get(); 
                $imgName = $query->result_array();

                if(empty($imgName[0]['field_img'])){
                    $imgName[0]['field_img'] = '';
                }

                $realDesign[] = array(
                    'id_measurement' => $singleMeasur['id_measurement'],
                    'order_details_id' => $singleMeasur['order_details_id'],
                    'service_id' => $singleMeasur['service_id'],
                    'service_identify' => $singleMeasur['service_identify'],
                    'field_type_id' => $singleMeasur['field_type_id'],
                    'field_id' => $imgName[0]['field_img'],
                    'field_value' => $singleMeasur['field_value'],
                );
            }

            if($singleMeasur['field_type_id'] == 3){

                $this->db->select('field_name');
                $this->db->from('tailoring_fields'); 
                $this->db->where('id_field', $singleMeasur['field_id']);  
                $query = $this->db->get(); 
                $billName = $query->result_array();

                $realBill[] = array(
                    'id_measurement' => $singleMeasur['id_measurement'],
                    'order_details_id' => $singleMeasur['order_details_id'],
                    'service_id' => $singleMeasur['service_id'],
                    'service_identify' => $singleMeasur['service_identify'],
                    'field_type_id' => $singleMeasur['field_type_id'],
                    'field_id' => $billName[0]['field_name'],
                    'field_value' => $singleMeasur['field_value'],
                );
            }




        }

        $mesBillDesign = array(
            'measure' => $realMeasure,
            'design' => $realDesign,
            'bill' => $realBill,
        );

        return $mesBillDesign;



    }

    public function getServiceName($id){
        $this->db->select('service_name');
        $this->db->from('tailoring_services'); 
        $this->db->where('id_service', $id);  
        $query = $this->db->get(); 
        $sName = $query->result_array();
        return $sName; 
    }

    public function getCustomerName($id){
        $this->db->select('full_name');
        $this->db->from('customers'); 
        $this->db->where('id_customer', $id);  
        $query = $this->db->get(); 
        $cName = $query->result_array();
        return $cName; 
    }
    public function orderStatusUpdate(){
        
        $data['order_status'] =$_GET['sid'];
        $this->db->where('id_order', $_GET['oid']);
        if($_GET['sid'] == 3){
            $data['ac_delivery_date']= date("Y-m-d");
        }
        $upId = $this->db->update('tailoring_orders', $data); 
        return $upId;
    }
        
    public function getFieldNameById($id){
        $this->db->select('field_name');
        $this->db->from('tailoring_fields'); 
        $this->db->where('id_field', $id);  
        $query = $this->db->get(); 
        $cName = $query->result_array();
        return $cName; 
    }

    public function getDesignUrlById($id){
        $this->db->select('field_img');
        $this->db->from('tailoring_fields'); 
        $this->db->where('id_field', $id);  
        $query = $this->db->get(); 
        $cName = $query->result_array();
        return $cName; 
    }

    public function reTransection(){

    }

    public function getCurrentBallance($id){
        $this->db->select('curr_balance');
        $this->db->from('accounts'); 
        $this->db->where('id_account', $id);  
        $query = $this->db->get(); 
        $cBalance = $query->result_array();
        return $cBalance;
    }


    public function getCustomerBallance($id){
        $this->db->select('balance');
        $this->db->from('customers'); 
        $this->db->where('id_customer', $id);  
        $query = $this->db->get(); 
        $cBalance = $query->result_array();
        return $cBalance;
    }

    public function getBillTypeName($id){
        $this->db->select('field_name');
        $this->db->from('tailoring_fields'); 
        $this->db->where('id_field', $id);  
        $query = $this->db->get(); 
        $fName = $query->result_array();
        return $fName[0]['field_name'];
    }

    public function getBillingById($id){

        $this->db->select('field_name');
        $this->db->from('tailoring_fields'); 
        $this->db->where('field_type_id', 3);          
        $this->db->where('id_field', $id);  
        $query = $this->db->get(); 
        $fName = $query->result_array();
        return $fName[0]['field_name'];
    }

    public function getCustomerInfo($id){
        $this->db->select('*');
        $this->db->from('customers'); 
        $this->db->where('id_customer', $id);  
        $query = $this->db->get(); 
        $cInfo = $query->result_array();
        return $cInfo; 
    }

    public function getSellerName($id){
        $this->db->select('fullname');
        $this->db->from('users'); 
        $this->db->where('id_user', $id);  
        $query = $this->db->get(); 
        $cInfo = $query->result_array();
        return $cInfo[0]['fullname']; 
    }

    public function getStoreInfo($id){
        $this->db->select('*');
        $this->db->from('stores'); 
        $this->db->where('id_store', $id);  
        $query = $this->db->get(); 
        $cInfo = $query->result_array();
        return $cInfo; 
    }

    public function editBillType($id, $fName){
        $data = array('field_name' => $fName);
        $this->db->where('id_field', $id);
        $upId = $this->db->update('tailoring_fields', $data); 
        return $upId;
    }

    function getOrderRows($params = array())
    {
        $this->db->select('*');
        $this->db->from('tailoring_orders to'); 
        $this->db->join('customers c','to.customer_id=c.id_customer', 'left');
        $this->db->where('to.status_id', 1); 
        $this->db->order_by('to.id_order','desc');
        
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getServiceRows($params = array()){

        $this->db->select('ts.id_service,ts.service_name,ts.service_price');
        $this->db->from(' tailoring_services ts');
        $this->db->where('ts.status_id', 1);    
        $this->db->order_by('ts.dtt_add','desc');

        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;

    }

    public function sale_transaction_details($id)
    {
        $this->db->select("a.amount as total_amount,b.payment_method_id,b.amount,a.dtt_add");
        $this->db->from("sale_transaction_details a");
        $this->db->join('sale_transaction_payments b', 'a.sale_transaction_id = b.sale_transaction_id', 'left');
        $this->db->where("a.sale_id", $id);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    public function get_customer_auto_list($request)
    {
        $this->db->select("*");
        $this->db->from("customers");
        //$this->db->where('store_id', $store_id);
        $this->db->group_start();
            $this->db->like("full_name", $request);
            $this->db->or_like("phone", $request);
            $this->db->or_like("email", $request);
        $this->db->group_end();
        $this->db->order_by("full_name", 'asc');
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }
    public function getMeasureByCustomer($id){
        $this->db->select("tm.*");
        $this->db->from("tailoring_measurements tm");
        $this->db->where("tm.order_details_id", $id);
        $this->db->where("tm.field_type_id", 1);
        $query = $this->db->get();
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
        
    }
    public function getOrderByCustomer($id,$service_id){
        $this->db->select("tr.id_order,trd.id_order_detail");
        $this->db->from("tailoring_orders tr");
        $this->db->join('tailoring_order_details trd', "tr.id_order = trd.order_id and trd.service_id = $service_id");
        $this->db->where("tr.customer_id", $id);
        $this->db->order_by('id_order','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }
    public function get_measurement_details($id){
        $this->db->select('tm.*,tf.field_name');
        $this->db->from('tailoring_measurements tm'); 
        $this->db->join('tailoring_fields tf', "tf.id_field = tm.field_id",'left');
        $this->db->where('tm.order_details_id', $id); 
        $this->db->where('tm.field_type_id', 1);   
        $query = $this->db->get(); 
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

}