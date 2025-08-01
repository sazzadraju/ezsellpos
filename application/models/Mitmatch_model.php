<?php

/**
 * Contains all common methods to be used in entire project
 *
 * @author Rafiqul Islam <rafiq.kuet@gmail.com>
 * @date September 14, 2017 10:15
 */
class Mitmatch_model extends CI_Model
{

    public function get_stock_mitmatch_row($params=array())
    {
        $this->db->select('sd.product_id,sd.id_sale_detail,s.id_sale,s.store_id,sd.qty AS sale_qty,s.dtt_add,st.qty as stock_qty,st.id_stock,st.store_id as stock_store_id,st.batch_no,s_st.id_stock as sale_stock_id,s_st.qty as sale_stock_qty,s_st.store_id as sale_stock_store_id');
        $this->db->from('sales s');
        $this->db->join('sale_details sd', 's.id_sale = sd.sale_id');
        $this->db->join('stocks st', 'sd.stock_id = st.id_stock');
        $this->db->join('stocks s_st', 's.store_id = s_st.store_id and sd.product_id=s_st.product_id and st.batch_no=s_st.batch_no');
        if (isset($params['product_id'])) {  
            $this->db->where('sd.product_id', $params['product_id']);
        }
        if (isset($params['batch'])) {  
            $this->db->where('st.batch_no', $params['batch']);
        }
        
        $this->db->where('s.store_id != st.store_id', null);
        $this->db->order_by('id_sale', 'desc');
        $this->db->group_by("sd.id_sale_detail");
        //get records
        $query = $this->db->get();
        //echo  $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        
    }
    public function get_sale_stock_details($id){
        $this->db->select('sd.product_id,sd.id_sale_detail,s.id_sale,s.store_id,sd.qty AS sale_qty,s.dtt_add,st.qty as stock_qty,st.id_stock,st.store_id as stock_store_id,st.batch_no');
        $this->db->from('sale_details sd');
        $this->db->join('sales s', 's.id_sale = sd.sale_id');
        $this->db->join('stocks st', 'sd.stock_id = st.id_stock');
        $this->db->where('sd.id_sale_detail', $id);
        $this->db->order_by('id_sale', 'desc');
        $query = $this->db->get();
        //echo  $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }
    public function update_add_stock_qty($params =array()){
        $qty=$params['sale_qty'];
        $this->db->set('qty', "`qty`+$qty", FALSE);
        $this->db->where('id_stock', $params['id_stock']);
        $this->db->update('stocks');
    }
    public function update_deduction_stock_qty($params =array()){
        $qty=$params['sale_qty'];
        $this->db->set('qty', "`qty`- $qty", FALSE);
        $this->db->where('id_stock', $params['id_stock']);
        $this->db->update('stocks');
        // echo '<br>';
        // echo  $this->db->last_query();
    }

    public function get_stock_qty_by_sale($params =array()){
        $this->db->select('id_stock,qty');
        $this->db->from('stocks');
        $this->db->where('store_id', $params['store_id']);
        $this->db->where('product_id', $params['product_id']);
        $this->db->where('batch_no', $params['batch_no']);
        //get records
        $query = $this->db->get();
        //echo '<br>';
        //echo  $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function update_sale_details_stock($params =array()){
        $this->db->set('stock_id',$params['id_stock']);
        $this->db->where('id_sale_detail', $params['details_id']);
        $this->db->update('sale_details');
        return $this->db->affected_rows();
    }

}
