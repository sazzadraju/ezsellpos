<?php

class Profit_loss_model extends CI_Model {

    
    public function getvalue_row($tbl, $fn, $fcon = array()) {
        $this->db->select($fn);
        $this->db->where($fcon);
        $q = $this->db->get($tbl);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
     public function get_invoice_details($invoice_id) {
        $this->db->select('*');
        $this->db->from('sale_details sd');
        $this->db->join('sales s','sd.sale_id = s.id_sale');
        $this->db->where('sd.sale_id', $invoice_id);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        //return $query->row();
    }

    function getRowsProducts($params = array(),$store_id) {
        $pm=0;
        $new_store_id=0;
        if(!empty($store_id)){
            $pm=1;
            $new_store_id=explode(',', $store_id);
        }


        $this->db->select('s.dtt_add, s.store_id, SUM(t.purchase_price*sd.qty) AS amt');
        $this->db->from('sales s');
        $this->db->join("sale_details sd", 'sd.sale_id = s.id_sale');
        $this->db->join("stocks t", 't.id_stock = sd.stock_id and sale_type_id=1');
        if (!empty($params['search']['FromDate'])) {
            $this->db->where("s.dtt_add >=", $params['search']['FromDate']);
            $this->db->where("s.dtt_add <=", $params['search']['ToDate']);
        }
        //echo "*******";
         $where='';
        $count=0;
        $tt='';
        $count_store=count($new_store_id);
        // echo $count_store;
        if($count_store>0 && $pm==1){
            if($count_store==1){
                $this->db->where('s.store_id', $new_store_id[0]);
            }
            else{
                 $this->db->group_start();
                for($i=0;$i < count($new_store_id);$i++){
                    // print_r($new_station_id[$i]);
                    if($count > 0){
                        $tt=' OR ';
                    }
                    $where.=$tt.'s.store_id ='.$new_store_id[$i];
                    $count++;
                    //$this->db->or_like('store_id', $new_store_id[$i]);
                }
                $this->db->where($where,null,false);
                $this->db->group_end();
            }
        }
        $group_sales_person='';
        if (!empty($params['search']['sales_person'])) {
            $this->db->where('s.sales_person_id', $params['search']['sales_person']);
            $group_sales_person=',s.sales_person_id';
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
        }
        $this->db->group_by("DATE(s.dtt_add)$group_sales_person");
        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
function getRowsRound($params = array(),$store_id,$date) {
    $pm=0;
    $new_store_id=0;
    if(!empty($store_id)){
        $pm=1;
        $new_store_id=explode(',', $store_id);
    }
    $this->db->select('SUM(round_amt) as ramt, SUM(remit_amt) as remit_amt');
    $this->db->from('sales');
    $arr_date=explode(' ',$date);
    if (!empty($arr_date)) {
        $this->db->where("dtt_add >=", $arr_date[0].' 00:00:00');
        $this->db->where("dtt_add <=", $arr_date[0].' 23:59:59');
    }

    //echo "*******";
    $where='';
    $count=0;
    $tt='';
    $count_store=count($new_store_id);
    // echo $count_store;
    if($count_store>0 && $pm==1){
        if($count_store==1){
            $this->db->where('store_id', $new_store_id[0]);
        }
        else{
            $this->db->group_start();
            for($i=0;$i < count($new_store_id);$i++){
                // print_r($new_station_id[$i]);
                if($count > 0){
                    $tt=' OR ';
                }
                $where.=$tt.'`store_id` ='.$new_store_id[$i];
                $count++;
                //$this->db->or_like('store_id', $new_store_id[$i]);
            }
            $this->db->where($where,null,false);
            $this->db->group_end();
        }
    }
    $group_sales_person='';
    if (!empty($params['search']['sales_person'])) {
        $this->db->where('sales_person_id', $params['search']['sales_person']);
        $group_sales_person=',sales_person_id';
    }
    $this->db->group_by("DATE(dtt_add)$group_sales_person");
    $query = $this->db->get();
    return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

}
    function getTotalSale($params = array(),$store_id,$date) {
        $pm=0;
        $new_store_id=0;
        if(!empty($store_id)){
            $pm=1;
            $new_store_id=explode(',', $store_id);
        }
        $this->db->select('SUM(tot_amt) as sale_invoice');
        $this->db->from('sales');
        $arr_date=explode(' ',$date);
        if (!empty($arr_date)) {
            $this->db->where("dtt_add >=", $arr_date[0].' 00:00:00');
            $this->db->where("dtt_add <=", $arr_date[0].' 23:59:59');
        }

        //echo "*******";
        $where='';
        $count=0;
        $tt='';
        $count_store=count($new_store_id);
        // echo $count_store;
        if($count_store>0 && $pm==1){
            if($count_store==1){
                $this->db->where('store_id', $new_store_id[0]);
            }
            else{
                $this->db->group_start();
                for($i=0;$i < count($new_store_id);$i++){
                    // print_r($new_station_id[$i]);
                    if($count > 0){
                        $tt=' OR ';
                    }
                    $where.=$tt.'`store_id` ='.$new_store_id[$i];
                    $count++;
                    //$this->db->or_like('store_id', $new_store_id[$i]);
                }
                $this->db->where($where,null,false);
                $this->db->group_end();
            }
        }
        $group_sales_person='';
        if (!empty($params['search']['sales_person'])) {
            $this->db->where('sales_person_id', $params['search']['sales_person']);
            $group_sales_person=',sales_person_id';
        }
        $this->db->group_by("DATE(dtt_add)$group_sales_person");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }
    function getReturnProduct($params = array(),$store_id,$date) {
        $pm=0;
        $new_store_id=0;
        if(!empty($store_id)){
            $pm=1;
            $new_store_id=explode(',', $store_id);
        }
        $this->db->select('s.dtt_add, s.store_id, SUM(t.purchase_price*sd.qty) AS return_purchase_price');
        $this->db->from('sale_adjustments s');
        $this->db->join("sale_details sd", 'sd.sale_id = s.id_sale_adjustment');
        $this->db->join("stocks t", 't.id_stock = sd.stock_id and sale_type_id=2');
        $this->db->join("sales refs", 'refs.id_sale = s.ref_sale_id');

        $arr_date=explode(' ',$date);
        if (!empty($arr_date)) {
            $this->db->where("s.dtt_add >=", $arr_date[0].' 00:00:00');
            $this->db->where("s.dtt_add <=", $arr_date[0].' 23:59:59');
        }
        //echo "*******";
        $where='';
        $count=0;
        $tt='';
        $count_store=count($new_store_id);
        // echo $count_store;
        if($count_store>0 && $pm==1){
            if($count_store==1){
                $this->db->where('s.store_id', $new_store_id[0]);
            }
            else{
                $this->db->group_start();
                for($i=0;$i < count($new_store_id);$i++){
                    // print_r($new_station_id[$i]);
                    if($count > 0){
                        $tt=' OR ';
                    }
                    $where.=$tt.'s.store_id ='.$new_store_id[$i];
                    $count++;
                    //$this->db->or_like('store_id', $new_store_id[$i]);
                }
                $this->db->where($where,null,false);
                $this->db->group_end();
            }
        }
        if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('s.store_id', $this->session->userdata['login_info']['store_id']);
        }
        $group_sales_person='';
        if (!empty($params['search']['sales_person'])) {
            $this->db->where('refs.sales_person_id', $params['search']['sales_person']);
            $group_sales_person=',refs.sales_person_id';
        }

        $this->db->group_by("DATE(s.dtt_add)$group_sales_person");
        //get records
        $query = $this->db->get();
        //echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    function getTotalSaleReturn($params = array(),$store_id,$date) {
        $pm=0;
        $new_store_id=0;
        if(!empty($store_id)){
            $pm=1;
            $new_store_id=explode(',', $store_id);
        }
        $this->db->select('SUM(s.tot_amt) as return_invoice');
        $this->db->from('sale_adjustments s');
        $this->db->join("sales refs", 'refs.id_sale = s.ref_sale_id');
        $arr_date=explode(' ',$date);
        if (!empty($arr_date)) {
            $this->db->where("s.dtt_add >=", $arr_date[0].' 00:00:00');
            $this->db->where("s.dtt_add <=", $arr_date[0].' 23:59:59');
        }

        //echo "*******";
        $where='';
        $count=0;
        $tt='';
        $count_store=count($new_store_id);
        // echo $count_store;
        if($count_store>0 && $pm==1){
            if($count_store==1){
                $this->db->where('s.store_id', $new_store_id[0]);
            }
            else{
                $this->db->group_start();
                for($i=0;$i < count($new_store_id);$i++){
                    // print_r($new_station_id[$i]);
                    if($count > 0){
                        $tt=' OR ';
                    }
                    $where.=$tt.'s.store_id ='.$new_store_id[$i];
                    $count++;
                    //$this->db->or_like('store_id', $new_store_id[$i]);
                }
                $this->db->where($where,null,false);
                $this->db->group_end();
            }
        }
        $group_sales_person='';
        if (!empty($params['search']['sales_person'])) {
            $this->db->where('refs.sales_person_id', $params['search']['sales_person']);
            $group_sales_person=',refs.sales_person_id';
        }
        $this->db->group_by("DATE(s.dtt_add)$group_sales_person");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }
    public function getReturnSale($params = array(),$store_id,$date){
        $pm=0;
        $new_store_id=0;
        if(!empty($store_id)){
            $pm=1;
            $new_store_id=explode(',', $store_id);
        }
        $this->db->select('return_invoice, SUM(st.purchase_price*sd.qty) AS return_purchase_price');
        $this->db->from('sale_adjustments sa');
        $join_invoice="(SELECT id_sale_adjustment,SUM(tot_amt) AS return_invoice 
	                    FROM sale_adjustments
	                    GROUP BY (dtt_add))";
        $this->db->join("$join_invoice sb", 'sb.id_sale_adjustment = sa.id_sale_adjustment','inner');
        $this->db->join('sale_details sd','sa.id_sale_adjustment=sd.sale_id and sd.sale_type_id=2','left');
        $this->db->join('stocks st','sd.stock_id=st.id_stock','left');
        $this->db->join("sales refs", 'refs.id_sale = s.ref_sale_id');
        $arr_date=explode(' ',$date);
        if (!empty($arr_date)) {
            $this->db->where("sa.dtt_add >=", $arr_date[0].' 00:00:00');
            $this->db->where("sa.dtt_add <=", $arr_date[0].' 23:59:59');
        }

        //echo "*******";
        $where='';
        $count=0;
        $tt='';
        $count_store=count($new_store_id);
        // echo $count_store;
        if($count_store>0 && $pm==1){
            if($count_store==1){
                $this->db->where('sa.store_id', $new_store_id[0]);
            }
            else{
                $this->db->group_start();
                for($i=0;$i < count($new_store_id);$i++){
                    // print_r($new_station_id[$i]);
                    if($count > 0){
                        $tt=' OR ';
                    }
                    $where.=$tt.'sa.`store_id` ='.$new_store_id[$i];
                    $count++;
                    //$this->db->or_like('store_id', $new_store_id[$i]);
                }
                $this->db->where($where,null,false);
                $this->db->group_end();
            }
        }
        $group_sales_person='';
        if (!empty($params['search']['sales_person'])) {
            $this->db->where('refs.sales_person_id', $params['search']['sales_person']);
            $group_sales_person=',refs.sales_person_id';
        }
        $this->db->group_by("DATE(sa.dtt_add)$group_sales_person");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function getSales_person_list($params = array()){
        $this->db->select("sp.*,
        CASE sp.person_type
            WHEN '1' THEN u.fullname
            WHEN '2' THEN u.fullname
            WHEN '3' THEN s.supplier_name
            WHEN '4' THEN c.full_name
        END AS user_name,
        CASE sp.person_type
            WHEN '1' THEN u.mobile
            WHEN '2' THEN u.mobile
            WHEN '3' THEN s.phone
            WHEN '4' THEN c.phone
        END AS phone
        ");
        $this->db->from("sales_person sp");
        $this->db->join('users u', 'u.id_user = sp.person_id and (sp.person_type=1 OR sp.person_type=2)', 'left');
        $this->db->join('suppliers s', 's.id_supplier = sp.person_id and sp.person_type=3', 'left');
        $this->db->join('customers c', 'c.id_customer = sp.person_id and sp.person_type=4', 'left');
        $this->db->where("sp.status_id", "1");
        $this->db->order_by("sp.id_sales_person", "desc");
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            return $res;
        }
        return false;
    }
    
    function getTotalVat($params = array(),$store_id,$date) {
        $pm=0;
        $new_store_id=0;
        if(!empty($store_id)){
            $pm=1;
            $new_store_id=explode(',', $store_id);
        }
        $this->db->select('SUM(sd.vat_amt) as tot_vat');
        $this->db->from('sale_details sd');
        $this->db->join('sales s', 's.id_sale = sd.sale_id', 'left');
        $arr_date=explode(' ',$date);
        if (!empty($arr_date)) {
            $this->db->where("sd.dtt_add >=", $arr_date[0].' 00:00:00');
            $this->db->where("sd.dtt_add <=", $arr_date[0].' 23:59:59');
        }

        //echo "*******";
        $where='';
        $count=0;
        $tt='';
        $count_store=count($new_store_id);
        // echo $count_store;
        if($count_store>0 && $pm==1){
            if($count_store==1){
                $this->db->where('s.store_id', $new_store_id[0]);
            }
            else{
                $this->db->group_start();
                for($i=0;$i < count($new_store_id);$i++){
                    // print_r($new_station_id[$i]);
                    if($count > 0){
                        $tt=' OR ';
                    }
                    $where.=$tt.'`s.store_id` ='.$new_store_id[$i];
                    $count++;
                }
                $this->db->where($where,null,false);
                $this->db->group_end();
            }
        }
        $group_sales_person='';
        if (!empty($params['search']['sales_person'])) {
            $this->db->where('s.sales_person_id', $params['search']['sales_person']);
            $group_sales_person=',s.sales_person_id';
        }
        $this->db->where('sd.sale_type_id','1');
        $this->db->group_by("DATE(sd.dtt_add)$group_sales_person");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }
    function getTotalReturnVat($params = array(),$store_id,$date) {
        $pm=0;
        $new_store_id=0;
        if(!empty($store_id)){
            $pm=1;
            $new_store_id=explode(',', $store_id);
        }
        $this->db->select('SUM(sd.vat_amt) as tot_ret_vat');
        $this->db->from('sale_details sd');
        $this->db->join('sale_adjustments s', 's.id_sale_adjustment = sd.sale_id', 'left');
        $this->db->join("sales refs", 'refs.id_sale = s.ref_sale_id');
        $arr_date=explode(' ',$date);
        if (!empty($arr_date)) {
            $this->db->where("sd.dtt_add >=", $arr_date[0].' 00:00:00');
            $this->db->where("sd.dtt_add <=", $arr_date[0].' 23:59:59');
        }

        //echo "*******";
        $where='';
        $count=0;
        $tt='';
        $count_store=count($new_store_id);
        // echo $count_store;
        if($count_store>0 && $pm==1){
            if($count_store==1){
                $this->db->where('s.store_id', $new_store_id[0]);
            }
            else{
                $this->db->group_start();
                for($i=0;$i < count($new_store_id);$i++){
                    // print_r($new_station_id[$i]);
                    if($count > 0){
                        $tt=' OR ';
                    }
                    $where.=$tt.'`s.store_id` ='.$new_store_id[$i];
                    $count++;
                }
                $this->db->where($where,null,false);
                $this->db->group_end();
            }
        }
        $group_sales_person='';
        if (!empty($params['search']['sales_person'])) {
            $this->db->where('refs.sales_person_id', $params['search']['sales_person']);
            $group_sales_person=',refs.sales_person_id';
        }
        $this->db->where('sd.sale_type_id','2');
        $this->db->group_by("DATE(s.dtt_add)$group_sales_person");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }
    
        
}

