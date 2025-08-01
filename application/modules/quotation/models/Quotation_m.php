<?php
 
class Quotation_m extends CI_Model {
 
    function __construct() {
        parent::__construct();
 
    }    

    public function get_all_quotation($qNo){
        $this->db->select('qm.*, c.full_name, c.email, c.phone');
        $this->db->from('quotation_master qm');  
        $this->db->join('customers c','qm.customer_id=c.id_customer', 'left');
        $this->db->where('qm.quotation_no', $qNo);
        $query = $this->db->get(); 
        $result = $query->result_array();
        return $result;
    }

    public function get_all_customer(){
    	$this->db->select('*');
        $this->db->from('customers');  
        $this->db->where('status_id', 1);
        $query = $this->db->get(); 
        $result = $query->result_array();
        return $result;
    }

    public function get_available_stock_in_products($request) {
        $this->db->select("s.id_stock, s.batch_no, s.product_id, s.dtt_add,  p.product_name, p.buy_price, p.sell_price, p.is_vatable, p.product_code");
        $this->db->from("stocks s");
        $this->db->join('products p', 's.product_id = p.id_product', 'left');
        $this->db->group_start();
        $this->db->like("p.product_name", $request);
        $this->db->or_like("p.product_code", $request);
        $this->db->group_end();
        $this->db->where("p.status_id", 1);
        $this->db->where('s.qty >', 0);
        $this->db->where("s.store_id", $_SESSION['login_info']['store_id']);
        // $this->db->group_by('s.product_id');
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function get_all_products($request){
        $this->db->select("p.id_product, p.product_name, p.buy_price, p.sell_price, p.is_vatable, p.product_code");
        $this->db->from("products p");
        $this->db->group_start();
        $this->db->like("p.product_name", $request);
        $this->db->or_like("p.product_code", $request);
        $this->db->group_end();
        $this->db->where("p.status_id", 1);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function getProductDetail($data){

        $cb = $data['cb'];
        $product_id = $data['product_id'];
        $batch_no = $data['batch_no'];

        if($cb == 1){
            $this->db->select("*");
            $this->db->from("stocks s");
            $this->db->join('products p', 's.product_id = p.id_product', 'left');
            $this->db->where("s.product_id", $product_id);
            $this->db->where("s.batch_no", $batch_no);
            $query = $this->db->get();
            $res = $query->result_array();
            return $res;
        }

        if($cb == 2){
            $this->db->select("*");
            $this->db->from("products p");
            $this->db->where("p.id_product", $product_id);
            $query = $this->db->get();
            $res = $query->result_array();
            return $res;
        }

    }

    function insert_into_quotation($quotation_master, $quotation_details){

        $this->db->query("CALL temp_quotation_details()");

        foreach ($quotation_details as $aDetail) {
            $this->commonmodel->commonInsertSTP('temp_quotation_details',$aDetail);
        }

        $data = "'".$quotation_master['quotation_no']."','".$quotation_master['rivision_no']."','".$quotation_master['customer_id']."','".$quotation_master['store_id']."','".$quotation_master['station_id']."','".$quotation_master['note']."','".$quotation_master['product_amt']."','".$quotation_master['vat_amt']."','".$quotation_master['discount_amt']."','".$quotation_master['total_amt']."','".$quotation_master['dtt_add']."','".$quotation_master['uid_add']."',@insert_id";
      
        
        $insert=$this->db->query("CALL quotation_master(".$data.")");
        $query=$this->db->query("SElECT @insert_id AS insert_id");
        return $query->result_array();

    }

    function getQuotationMasterById($qid){
        $this->db->select("qm.*, c.full_name, c.email, c.phone");
        $this->db->from("quotation_master qm");
        $this->db->join('customers c', 'qm.customer_id = c.id_customer', 'left');
        $this->db->where("qm.id_quotation", $qid);
        $this->db->where("qm.status_id", 1);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    function getQuotationDetailById($qid){
        $this->db->select("qd.*, s.qty as s_qty, s.purchase_price as s_purchase_price, p.product_name, p.product_code, p.buy_price as p_buy_price");
        $this->db->from("quotation_details qd");
        $this->db->join('stocks s', 'qd.batch_no = s.batch_no and qd.product_id=s.product_id and qd.batch_no!=0000','left');
        $this->db->join('products p', 'qd.product_id = p.id_product','left');
        $this->db->where("qd.quotation_id", $qid);
        $this->db->order_by('qd.quotation_id');
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
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

    function getQuotationRows($params = array())
    {
        $this->db->select('qm.*, c.full_name, c.email, c.phone');
        $this->db->from('quotation_master qm');  
        $this->db->join('customers c','qm.customer_id=c.id_customer', 'left');
        $this->db->where('qm.status_id', 1);
        $this->db->order_by('dtt_add','desc');
        
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getQuotationNo($qid){
        $this->db->select('qm.quotation_no');
        $this->db->from('quotation_master qm'); 
        $this->db->where('qm.id_quotation', $qid);
        $query = $this->db->get();
        $cInfo = $query->result_array();
        return $cInfo; 
    }
    public function count_table($table, $column, $value)
    {
        $tot = $this->db
            ->where($column, $value)
            ->where('status_id', 1)
            ->count_all_results($table);

        return $tot > 0 ? $tot : FALSE;
    }


}