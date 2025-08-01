<?php

class Order_Model extends CI_Model
{

    public function common_insert($tablename, $data)
    {
        $res = $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

    public function update_value($tblname, $setvalue = array(), $convalue = array(), $version = true)
    {
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



    public function getvalue_row($tbl, $fn, $fcon = array())
    {
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
    public function productListWithStock($id){
        $this->db->select('p.id_product,p.product_code,p.product_name,p.sell_price,p.is_vatable,p.brand_id,p.cat_id,p.subcat_id,sum(s.qty) as stock_qty,p.sell_price as p_sale_price,s.selling_price_act as s_sale_price,s.discount_rate,s.discount_amt');
        $this->db->from('products p');
        $this->db->join('stocks s', 'p.id_product = s.product_id AND s.status_id=1','left');
        $this->db->where('p.id_product',$id);
        $query = $this->db->get();
        return  ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function getOrderList($params = array()){
        $this->db->select('o.*,c.full_name as customer_name,s.store_name');
        $this->db->from('orders o');
        $this->db->join('customers c', 'o.customer_id = c.id_customer AND c.status_id=1','left');
        $this->db->join('stores s', 'o.store_id = s.id_store','left');
        $this->db->order_by('o.id_order','desc');
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return  ($query->num_rows() > 0)?$query->result_array():false;

    }
    public function orderDetailsById($id=0){
        $this->db->select('od.*,p.product_name,p.product_code,pb.brand_name,pc.cat_name,pca.cat_name as sub_cat_name');
        $this->db->from('order_details od');
        $this->db->join('products p', 'od.product_id = p.id_product ','left');
        $this->db->join('product_categories pc', 'pc.id_product_category=p.cat_id', 'left');
        $this->db->join('product_categories pca', 'pca.id_product_category=p.subcat_id', 'left');
        $this->db->join('product_brands pb', 'p.brand_id = pb.id_product_brand', 'left');
        if($id!=0){
            $this->db->where('od.order_id',$id);
        }
        $this->db->group_by("od.id_order_detail");
        $query = $this->db->get();
        return  ($query->num_rows() > 0)?$query->result_array():false;
    }
    public function orderCancelById($id){
        $this->db->select('o.*,tp.amount');
        $this->db->from('orders o');
        $this->db->join('sale_transaction_details td', 'o.id_order =td.sale_id and td.transaction_type_id=5  ','left');
        $this->db->join('sale_transaction_payments tp', 'td.sale_transaction_id =tp.sale_transaction_id','left');
        $this->db->where('o.id_order',$id);
        $query = $this->db->get();
        return  ($query->num_rows() > 0)?$query->result_array():false;
    }
    public function cancelOrder($data=array()){
        $this->update_value('orders',array('status_id'=>4),array('id_order'=>$data['id']));
        return true;
    }
    public function orderPaymentById($id=0){
        $this->db->select('tp.*');
        $this->db->from('sale_transaction_details td');
        $this->db->join('sale_transaction_payments tp', 'td.sale_transaction_id =tp.sale_transaction_id','left');
        $this->db->where('td.sale_id',$id);
        $this->db->where('td.transaction_type_id',5);
        $query = $this->db->get();
        return  ($query->num_rows() > 0)?$query->result_array():false;

    }
    public function order_transaction_details($id)
    {
        $this->db->select("a.amount as total_amount,b.payment_method_id,
        CASE a.qty_multiplier
            WHEN '0' THEN b.amount
            WHEN '1' THEN a.amount
        END AS amount,a.dtt_add");
        $this->db->from("sale_transaction_details a");
        $this->db->join('sale_transaction_payments b', 'a.sale_transaction_id = b.sale_transaction_id', 'left');
        $this->db->where("a.sale_id", $id);
         $this->db->where("a.transaction_type_id", 5);
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    public function get_order_print_invoice($invoice)
    {
        $this->db->select('o.*,c.fullname,b.mobile,b.address_line,b.email,b.store_name,b.store_img,d.full_name as customer_name,d.phone as customer_mobile,d.customer_code');
        $this->db->from('orders o');
        $this->db->join('stores b', 'o.store_id=b.id_store', 'left');
        $this->db->join('users c', 'o.uid_add=c.id_user', 'left');
        $this->db->join('customers d', 'o.customer_id=d.id_customer ', 'left');
        // $this->db->where("a.dtt_add >=", $start);
        $this->db->where("o.id_order", $invoice);
        $query = $this->db->get();
        //return $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }



}

        