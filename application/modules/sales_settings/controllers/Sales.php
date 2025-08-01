<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('language') == "jp") {
            $this->lang->load('jp');
        } else {

            $this->lang->load('en');
        }
        $this->form_validation->CI = &$this;
        $this->load->model('auto_increment');
        $this->load->model('sales_model');
        $this->load->model('common_model');
        $this->perPage = 20;
    }

    public function index()
    {
        $this->load->model('customer_settings/Customer_model');
        $data = array();
        $this->dynamic_menu->check_menu('sales');
        $this->breadcrumb->add(lang('sales'), 'sales', 0);
        $data['sales_configs'] = $this->sales_model->getvalue_row('configs', 'param_val', array('param_key' => 'SALES_CONFIG'));
        if (isset($_REQUEST['restore'])) {
            $request_id = $_REQUEST['restore'];
            $honds = $this->sales_model->getvalue_row('hold_sales', '*', array('invoice_no' => $request_id));
            $html = '';
            $rowCount = 1;
            if ($honds) {
                $this->sales_model->delete_data('hold_sales', array('invoice_no' => $request_id));
                $coutn = 0;
                $result['def_vat']=$this->session->userdata['login_info']['subscription_info']['DEFAULT_VAT'];
                foreach ($honds as $hond) {
                    $stock_id = $hond->stock_id;
                    $pro_id = $hond->product_id;
                    $store_id = $hond->store_id;
                    $pro_qty = $hond->qty;
                    $batch_no = $hond->batch_no;
                    $dis_rate = $hond->dis_rate;
                    $dis_amt = $hond->dis_amt;
                    $data['store_name_p'] = $store_id;
                    $data['station_name_p'] = $hond->station_id;
                    if (($hond->customer_id != '') && ($coutn == 0)) {
                        $data['customer_d'] = $this->sales_model->get_customer_details_sale_by_id($hond->customer_id);
                        $coutn += 1;
                    }

                    $discount_per = $discount_amt = $total_per = $total_amt = $discount = $total_discount_amount = 0;
                    $batch_new = $this->sales_model->getvalue_row('sale_product_view', 'batch_no', array('id_product' => $pro_id, 'store_id' => $store_id));
                    $product = $this->sales_model->getvalue_row_one('sale_product_view', '*', array('id_stock' => $stock_id, 'store_id' => $store_id));
                    $de_vat = $vat_total = 0;
                    if ($product) {
                        $result['product']=$product;
                        $brand = $product[0]['brand_id'];
                        $cat = $product[0]['cat_id'];
                        $subcat = $product[0]['subcat_id'];
                        $selling_price = $product[0]['selling_price_est'];
                        $promotions = $this->sales_model->getvalue_row('promotion_products_view', '*', array('store_id' => $store_id));
                        $promotion_id = '';
                        $discount_type = '';
                        $total_per = 0;
                        if (!empty($promotions)) {
                            foreach ($promotions as $promotion) {
                                if ($promotion->type_id == 1) {
                                    $chk_promo = 1;
                                    if (($brand == $promotion->brand_id) && ($cat == $promotion->cat_id)) {
                                        $chk_promo = 2;
                                    } else if (($brand == $promotion->brand_id) && ($subcat == $promotion->subcat_id)) {
                                        $chk_promo = 2;
                                    } else if (($brand == $promotion->brand_id) && ($promotion->cat_id == NULL) && ($promotion->subcat_id == NULL)) {
                                        $chk_promo = 2;
                                    } else if (($cat == $promotion->cat_id) && ($promotion->subcat_id == NULL) && ($promotion->brand_id == NULL)) {
                                        $chk_promo = 2;
                                    } else if (($subcat == $promotion->subcat_id) && ($cat == $promotion->cat_id) && ($promotion->subcat_id == NULL)) {
                                        $chk_promo = 2;
                                    }
                                    if ($chk_promo == 2) {
                                        if ($promotion->discount_rate != NULL) {
                                            $discount_per = $promotion->discount_rate;
                                            $total_per = ($discount_per > $total_per) ? $discount_per : $total_per;
                                        } else {
                                            $discount_amt = $promotion->discount_amount;
                                            $total_amt = ($discount_amt > $total_amt) ? $discount_amt : $total_amt;
                                        }
                                        $promotion_id = $promotion->promotion_id;
                                    }
                                }
                            }
                            if (($total_per != 0) || ($total_amt != 0)) {
                                $per_taka = ($total_per * $selling_price) / 100;
                                $result['promotion_id']=$promotion_id;
                                if ($per_taka > $total_amt) {
                                    $result['promotion_discount']=$total_per;
                                    $result['promotion_discount_amt']=$per_taka;
                                    $result['promotion_type']='%';
                                }else{
                                    $per = $selling_price/$total_amt;
                                    $result['promotion_discount_amt']=$total_amt;
                                    $result['promotion_discount']=$per;
                                    $result['promotion_type']='TK';
                                }
                            }
                        }
                        $promoArray=array(
                            'product_id'=>$product[0]['id_product'],
                            'store_id'=>$store_id,
                            'batch_no'=>''
                        );
                        $promotionsProduct = $this->sales_model->get_promotion_product($promoArray);
                        if($promotionsProduct && ($discount_amt==0||$discount_per==0)){
                            $promotion_id =$promotionsProduct[0]['promotion_id'];
                            $discount_per=$promotionsProduct[0]['discount_rate'];
                            $total_per=$promotionsProduct[0]['discount_rate'];
                            $discount_amt=$promotionsProduct[0]['discount_amount'];
                            $total_amt =$promotionsProduct[0]['discount_amount'];
                            $result['promotion_id']=$promotion_id;
                            if (($total_per != 0) || ($total_amt != 0)) {
                                $per_taka = ($total_per * $selling_price) / 100;
                                $result['promotion_discount']=$total_per;
                                $result['promotion_discount_amt']=$per_taka;
                                $result['promotion_type']='%';
                            }
                        }
                        $result['countRow']=$rowCount;
                        $configs = json_decode($data['sales_configs'][0]->param_val);
                        $result['config_discount']=$configs->discount;
                        $result['config_price']=$configs->price;

                        $html .=$this->load->view('sales/add_cart_product_list', $result, true); 
                    }
                    $rowCount++;
                } //end foreach
                $data['request_key'] = $html;
            }
        }


        $store_m = $this->session->userdata['login_info']['store_id'];
        $data['store_name_p'] = $this->session->userdata['login_info']['store_id'];
        $data['station_name_p'] = $this->session->userdata['login_info']['station_id'];
        $data['banks'] = $this->sales_model->get_bank_name($store_m);
        $data['customers'] = $this->sales_model->getvalue_row('customers', 'id_customer,customer_code,phone,full_name', array('status_id' => 1));
        $data['city_list'] = $this->Customer_model->common_single_value_array('loc_cities', 'id_city', 'city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->Customer_model->common_single_value_array('loc_divisions', 'id_division', 'division_name_en', 'id_division', 'ASC');
        
        $data['stores'] = $this->sales_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['card_type'] = $this->sales_model->getvalue_row('card_types', 'id_card_type,card_name', array());
        $chk_store['type_id'] = 3;
        $chk_store['store_id'] = $this->session->userdata['login_info']['store_id'];
        $data['card_promotions'] = $this->sales_model->getvalue_row('promotion_products_view', 'title,type_id,discount_rate,promotion_id', $chk_store);
        $data['purchase_promotion'] = $this->sales_model->getvalue_row_one('promotion_products_view', 'discount_rate,discount_amount,promotion_id,min_purchase_amt', array('type_id' => 2,'store_id' => $store_m));
        $data['customer_type_list'] = $this->sales_model->getvalue_row('customer_types', 'id_customer_type,name', array('status_id' => '1'));
        $data['salesPersons'] = $this->sales_model->getSales_person_list();
        
        
        $this->load->view('sales/index', $data);
    }
    public function get_sales_person_auto(){
        $request = $_REQUEST['request'];
        $product_list = $this->sales_model->get_sales_person_autocomplete($request);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->user_name.'('. $list->type_name.')',
                "value" => $list->id_sales_person,
                "person_type" => $list->type_name,
                "phone" => $list->phone
            );
        }
        echo json_encode($return);
    }
    
    public function temp_add_cart_for_sales()
    {
        $product_name = $this->input->post('product_name');
        $store_id = $this->session->userdata['login_info']['store_id'];
        $product_id = $this->input->post('src_product_id');
        $batch = $this->input->post('src_batch_no');
        $config_price = $this->input->post('config_price');
        $config_discount = $this->input->post('config_discount');
        if ($product_id == '') {
            $pro_id = explode('-', $product_name);
            //echo 'total='.count($pro_id);
            if(count($pro_id)>1){
                $product_id = $pro_id[0];
                if (count($pro_id) > 2) {
                    $batch = $pro_id[1] . '-' . $pro_id[2];
                } else {
                    $batch = $pro_id[1];
                }
            }
            
        } 
        $data['batch_no'] = $batch;
        $data['id_product'] = $product_id;
        $data['store_id'] = $store_id;
        $data['product_name'] = $product_name;
        $result['def_vat']=$this->session->userdata['login_info']['subscription_info']['DEFAULT_VAT'];
        $result['countRow']=$this->input->post('count_row');
        $result['batches']= $this->sales_model->getTempProductNameBatch($data);
        $product = $this->sales_model->getTempProductName($data);
        if ($product) {
            $attArray = $this->sales_model->getvalue_row_one('vw_stock_attr', 'attribute_name', array('stock_id' => $product[0]['id_stock']));
            if($attArray){
                $product[0]['attribute_name']=$attArray[0]['attribute_name'];
                //array_push($product, );
            }
            $result['product']=$product;
            $brand = $product[0]['brand_id'];
            $cat = $product[0]['cat_id'];
            $subcat = $product[0]['subcat_id'];
            $selling_price = $product[0]['selling_price_est'];
            $promotions = $this->sales_model->getvalue_row('promotion_products_view', '*', array('store_id' => $store_id));
            $discount_per = $discount_amt = $total_per = $total_amt = $discount = 0;
            //$purchase_dis = array();
            $promotion_id = '';
            if (!empty($promotions)) {
                foreach ($promotions as $promotion) {
                    if ($promotion->type_id == 1) {
                        $chk_promo = 1;
                        if (($brand == $promotion->brand_id) && ($cat == $promotion->cat_id)) {
                            $chk_promo = 2;
                        } else if (($brand == $promotion->brand_id) && ($subcat == $promotion->subcat_id)) {
                            $chk_promo = 2;
                        } else if (($brand == $promotion->brand_id) && ($promotion->cat_id == NULL) && ($promotion->subcat_id == NULL)) {
                            $chk_promo = 2;
                        } else if (($cat == $promotion->cat_id) && ($promotion->subcat_id == NULL) && ($promotion->brand_id == NULL)) {
                            $chk_promo = 2;
                        } else if (($subcat == $promotion->subcat_id) && ($cat == $promotion->cat_id) && ($promotion->subcat_id == NULL)) {
                            $chk_promo = 2;
                        }
                        if ($chk_promo == 2) {
                            if ($promotion->discount_rate != NULL) {
                                $discount_per = $promotion->discount_rate;
                                $total_per = ($discount_per > $total_per) ? $discount_per : $total_per;
                            } else {
                                $discount_amt = $promotion->discount_amount;
                                $total_amt = ($discount_amt > $total_amt) ? $discount_amt : $total_amt;
                            }
                            $promotion_id = $promotion->promotion_id;
                        }
                    }
                }
                if (($total_per != 0) || ($total_amt != 0)) {
                    $per_taka = ($total_per * $selling_price) / 100;
                    $result['promotion_id']=$promotion_id;
                    if ($per_taka > $total_amt) {
                        $result['promotion_discount']=$total_per;
                        $result['promotion_discount_amt']=$per_taka;
                        $result['promotion_type']='%';
                    }else{
                        $per = $selling_price/$total_amt;
                        $result['promotion_discount_amt']=$total_amt;
                        $result['promotion_discount']=$per;
                        $result['promotion_type']='TK';
                    }
                }
            }
            $promoArray=array(
                'product_id'=>$product[0]['id_product'],
                'store_id'=>$store_id,
                'batch_no'=>$data['batch_no'],
            );
            $promotionsProduct = $this->sales_model->get_promotion_product($promoArray);
            if($promotionsProduct && ($discount_amt==0||$discount_per==0)){
                $promotion_id =$promotionsProduct[0]['promotion_id'];
                $discount_per=$promotionsProduct[0]['discount_rate'];
                $total_per=$promotionsProduct[0]['discount_rate'];
                $discount_amt=$promotionsProduct[0]['discount_amount'];
                $total_amt =$promotionsProduct[0]['discount_amount'];
                $result['promotion_id']=$promotion_id;
                if (($total_per != 0) || ($total_amt != 0)) {
                    $per_taka = ($total_per * $selling_price) / 100;
                    $result['promotion_discount']=$total_per;
                    $result['promotion_discount_amt']=$per_taka;
                    $result['promotion_type']='%';
                }
            }
            //pa($result);
            //pa($_POST);
            $result['user_columns'] = $this->sales_model->getvalue_row('acl_user_column', 'permission,column_name,id_acl_user_column', array('menu_url'=>'sales'));
            $result['config_discount']=$config_discount;
            $result['config_price']=$config_price;
            $htmlData=$this->load->view('sales/add_cart_product_list', $result, true);
            //echo json_encode(array('status' => 1,'data' => $product, 'batch' => $batch_new, 'discount' => $discount, 'def_vat' => $vat[0]['param_val']));
            echo json_encode(array('status' => 1,'data' => $htmlData,'product'=>array('stock_id' => $product[0]['id_stock'])));
        } else {
            echo json_encode(array('status' => 3, 'message' => 'No Product Found')); 
        }
    }
    public function get_products_auto_sales()
    {
        $request = $_REQUEST['term'];
        //$store_id = $_REQUEST['store_id'];
        $store_id = $this->session->userdata['login_info']['store_id'];
        $return = array();
        if($request!=''){
            $product_list = $this->sales_model->get_product_auto_sale($request, $store_id);
            foreach ($product_list as $list) {
                $return[] = array(
                    "label" => $list->product_name . '(' . $list->batch_no . ')' . $list->attribute_name,
                    "value" => $list->id_product,
                    "sell_price" => $list->selling_price_est,
                    "product_code" => $list->product_code,
                    "batch_no" => $list->batch_no
                );
            }
        }
        echo json_encode($return);
    }
    public function get_customer_balance(){
        $id=$this->input->get('id');
        $data= $this->sales_model->get_customer_details_sale_by_id($id);
        if($data[0]['discount']>0){
            $arrayName = array(
                'discount' => $data[0]['discount'], 
                'target_sales_volume' => $data[0]['target_sales_volume']
            );
            echo json_encode(array('status'=>1,'data'=>$arrayName));
        }else{
            echo json_encode(array('status'=>2,'message'=>'No data found'));
        } 
    }
    public function check_batch_product()
    {
        $id_product = $this->input->post('product_id');
        $batch_no = $this->input->post('batch_no');
        $data = array(
            'id_product' => $id_product,
            'batch_no' => $batch_no
        );
        $product = $this->sales_model->check_batch_product($data);
        echo json_encode(array('data'=>$product));
    }
    public function sales_add()
    {
        //print_r($_POST);
        //exit();
        $gift_sale = $this->input->post('gift_sale');
        $pro_id = $this->input->post('pro_id');
        $batch = $this->input->post('batch');
        $qty = $this->input->post('qty');
        $note = $this->input->post('note');
        $id_stock = $this->input->post('stock_id');
        $cat_id = $this->input->post('cat_id');
        $subcat_id = $this->input->post('subcat_id');
        $brand_id = $this->input->post('brand_id');
        $unit_id = $this->input->post('unit_id');
        $unit_price = $this->input->post('unit_price');
        $discount = $this->input->post('discount');
        $discount_amt = $this->input->post('discount_amt');
        $discount_type = $this->input->post('discount_type');
        $total_price = $this->input->post('total_price');
        $pro_sale_id = $this->input->post('pro_sale_id');
        $store_name = $this->session->userdata['login_info']['store_id'];
        $p_store_id = $this->session->userdata['login_info']['store_id'];
        $station_id = $this->session->userdata['login_info']['station_id'];
        $cart_total = $this->input->post('cart_total');
        $customer_code = $this->input->post('customer_code');
        $customer_balance = $this->input->post('customer_balance');
        $def_vat = $this->input->post('def_vat');
        $def_vat_amt = $this->input->post('def_vat_amt');
        $special_dis = $this->input->post('special_dis');
        $cus_dis = $this->input->post('cus_dis');
        $pur_dis = $this->input->post('pur_dis');
        $card_dis = $this->input->post('card_dis');
        $total_pur_dis = $this->input->post('total_pur_dis');
        $card_promotion = $this->input->post('card_promotion');
        $original_product_price = $this->input->post('original_product_price');
        $grand_total = $this->input->post('grand_total');
        $product_discount = $original_product_price - $cart_total;
        $customer_id = $this->input->post('src_customer_id');
        $paid_amt = $this->input->post('paid_amt');
        $con_round_amt = $this->input->post('con_round_amt');
        $paid_amt_array = explode('@', $paid_amt);
        $special_dis_array = explode('@', $special_dis);
        $cus_dis_array = explode('@', $cus_dis);
        $pur_dis_array = explode('@', $pur_dis);
        $card_dis_array = explode('@', $card_dis);
        $special_dis_val = (count($special_dis_array) > 1) ? round($special_dis_array[1], 2) : 0;
        $cus_dis_val = (count($cus_dis_array) > 1) ? round($cus_dis_array[1], 2) : 0;
        $pur_dis_val = (count($pur_dis_array) > 1) ? round($pur_dis_array[1], 2) : 0;
        $card_dis_val = (count($card_dis_array) > 1) ? round($card_dis_array[1], 2) : 0;
        $total_discount = $special_dis_val + $cus_dis_val + $pur_dis_val + $card_dis_val;
        $invoice = $this->generateInvoiceNo();//time();
        $remit_point = $this->input->post('remit_point');
        $remit_taka = $this->input->post('remit_taka_val');
        $remit_val = (isset($remit_taka) && $remit_taka != '') ? $remit_taka : 0;
        $this->db->query("SET SESSION sql_require_primary_key=0");
        $this->db->query("CALL temp_sales_table()");
        // if ($this->db->error()) {
        //     print_r($this->db->error());exit;
        // }
        $points = $this->input->post('points');
        $to_point = 0;
        if ($points != '') {
            $original_points = 0;
            $t_point = '';
            $per_point_balance = $this->input->post('per_point_balance');
            $bonus_points = ($per_point_balance == 0) ? 0 : $grand_total / $per_point_balance;
            if (isset($remit_point) && $remit_point != '') {
                $saleData['remit_point'] = $remit_point;
                $original_points = $remit_point - $bonus_points;
                $t_point = '-' . $original_points;
            }
            $to_point = ($t_point != '') ? $t_point : $bonus_points;
            $saleData['bonus_points'] = $bonus_points;
        }
        $saleData['points'] = ($points != '') ? $points : '';
        $saleData['remit_taka'] = $remit_val;
        for ($i = 0; $i < count($pro_id); $i++) {
            $product = array();
            $product['stock_id'] = $id_stock[$i];
            $product['product_id'] = $pro_id[$i];
            $product['cat_id'] = $cat_id[$i];
            $product['subcat_id'] = $subcat_id[$i];
            $product['brand_id'] = $brand_id[$i];
            $product['qty'] = $qty[$i];
            $product['unit_id'] = $unit_id[$i];
            $product['selling_price_est'] = ($unit_price[$i] * $qty[$i]);
            $product['selling_price_act'] = $total_price[$i];
            $discount_rate = 0;
            $product['discount_rate'] = $discount[$i];
            $product['discount_amt'] = $discount_amt[$i];
            $product['vat_rate'] = $def_vat[$i];
            $product['vat_amt'] = $def_vat_amt[$i];
            $details = $this->common_model->commonInsertSTP('tmp_sale_details', $product);
            if (((int)$pro_sale_id[$i]) != '') {
                $pro_promotion = array();
                $pro_promotion['product_id'] = $pro_id[$i];
                $pro_promotion['stock_id'] = $id_stock[$i];
                $pro_promotion['promotion_id'] = $pro_sale_id[$i];
                $pro_promotion['promotion_type_id'] = 1;
                $pro_promotion['discount_rate'] = $discount[$i];
                $pro_promotion['discount_amt'] = $discount_amt[$i];
                $details = $this->common_model->commonInsertSTP('tmp_sale_promotions', $pro_promotion);
            }
            $data_condition = array(
                'id_stock' => $id_stock[$i]
            );
            $qtyCondition = array(
                'product_id' => $pro_id[$i],
                'batch_no' => $batch[$i],
                'store_id' => $this->session->userdata['login_info']['store_id'],
                'qty >' => 0,
            );
            $stockQtyArray = $this->common_model->getvalue_row('stocks', 'qty,id_stock', $qtyCondition);
            //pa($stockQtyArray);
            $stock_qty=$qty[$i];
            foreach ($stockQtyArray as $value) {
                //pa($value);
                if($stock_qty <= $value->qty){
                    $this->sales_model->update_value_deduct('stocks', 'qty', $stock_qty, array('id_stock'=>$value->id_stock));
                    break;
                }else{
                    $this->sales_model->update_value_deduct('stocks', 'qty', $value->qty, array('id_stock'=>$value->id_stock));
                    $stock_qty=$stock_qty-$value->qty;
                }
            }
        }
        $sales_person = $this->input->post('sales_person');
        // $ord_pro_id = $this->input->post('ord_pro_id');
         $ord_id_t = $this->input->post('order_id');
         $order_id = (isset($ord_id_t)) ? $ord_id_t : '0';
        // $ord_sale_qty = $this->input->post('ord_sale_qty');
         $order_status = 3;
        

        $ck_sp_dis = $this->input->post('ck_sp_dis');
        if (($special_dis_val > 0) && (isset($ck_sp_dis))) {
            $promo_data = array();
            $promo_data['promotion_type_id'] = 5;
            $cus_per = null;
            //print_r($special_dis_array);
            $spc=(isset($special_dis_array))?1:0;
            if ($spc == 1) {
                if ($special_dis_array[0] != '') {
                    $percen = substr($special_dis_array[0], 0, -1);
                    $cus_per = $percen;
                } else {
                    $cus_per11 = ($special_dis_array[1] * 100) / $cart_total;
                    $cus_per = round($cus_per11, 2);
                }
            }
            $promo_data['discount_rate'] = $cus_per;
            $promo_data['discount_amt'] = $special_dis_array[1];
            $sale_pro_in_id = $this->common_model->commonInsertSTP('tmp_sale_promotions', $promo_data);
            $saleData['sp_discount'] = $cus_per . '@' . $special_dis_array[1];
        }
        $ck_cus_dis = $this->input->post('ck_cus_dis');
        if (($cus_dis_val > 0) && (isset($ck_cus_dis))) {
            $promo_data = array();
            $promo_data['promotion_type_id'] = 4;
            $cus_per = null;
            if(is_array($cus_dis_array)){
                if (isset($pur_dis_array[0])) {
                $cus_per = $cus_dis_array[0];
                }
            }
            $promo_data['discount_rate'] = $cus_per;
            $promo_data['discount_amt'] = $cus_dis_array[1];
            $sale_pro_in_id = $this->common_model->commonInsertSTP('tmp_sale_promotions', $promo_data);
            $saleData['cus_discount'] = $cus_per . '@' . $cus_dis_array[1];
        }
        $ck_pur_dis = $this->input->post('ck_pur_dis');
        if (($pur_dis_val > 0) && (isset($ck_pur_dis))) {
            $promo_data = array();
            $promo_data['promotion_type_id'] = 2;
            $cus_per = null;
            if (isset($pur_dis_array[0])) {
                $cus_per = $pur_dis_array[0];
            }
            $promo_data['discount_rate'] = $cus_per;
            $promo_data['discount_amt'] = $pur_dis_array[1];
            $sale_pro_in_id = $this->common_model->commonInsertSTP('tmp_sale_promotions', $promo_data);
            $saleData['pur_discount'] = $cus_per . '@' . $pur_dis_array[1];
        }
        $ck_cart_dis = $this->input->post('ck_cart_dis');
        if (($card_dis_val > 0) && (isset($ck_cart_dis))) {
            $promo_data = array();
            $promo_data['promotion_type_id'] = 3;
            $cus_per = null;
            if (count($card_dis_array[0]) == 1) {
                $cus_per = $card_dis_array[0];
            }
            $promo_data['discount_rate'] = $cus_per;
            $promo_data['discount_amt'] = $card_dis_array[1];
            $sale_pro_in_id = $this->common_model->commonInsertSTP('tmp_sale_promotions', $promo_data);
            $saleData['cart_discount'] = $cus_per . '@' . $card_dis_array[1];
        }
        
        $multiple_payment = $this->input->post('multiple_payment');
        if($multiple_payment==1){
            $cash = $this->input->post('m_cash');
            $card_payment = $this->input->post('m_card_payment');
            $bank_name = $this->input->post('m_bank_name');
            $card_number=$this->input->post('m_card_number');
            $card_type=$this->input->post('m_card_type');
            $mob_bank_name = $this->input->post('m_mob_bank_name');
            $mobile_amount = $this->input->post('m_mobile_amount');
            $mob_card_number=$this->input->post('m_mob_acc_no');
            $transaction_no =$this->input->post('m_transaction_no');

        }else{
            $cash = $this->input->post('cash');
            $card_payment = $this->input->post('card_payment');
            $bank_name = $this->input->post('bank_name');
            $card_number=$this->input->post('card_number');
            $card_type=$this->input->post('card_type');
            $mob_bank_name = $this->input->post('mob_bank_name');
            $mobile_amount = $this->input->post('mobile_amount');
            $mob_card_number=$this->input->post('mob_acc_no');
            $transaction_no =$this->input->post('transaction_no');
        }
        if ($cash != '') {
            $transaction_payment['account_id'] = $this->session->userdata['login_info']['station_acc_id'];
            $transaction_payment['payment_method_id'] = 1;
            $transaction_payment['amount'] = $cash;
            $transaction_payment_d = $this->common_model->commonInsertSTP('tmp_sale_transaction_payments', $transaction_payment);
            if ($transaction_payment_d) {
                //$this->common_model->updAccCurrBalance($this->session->userdata['login_info']['station_acc_id'], $cash, 1);
            }
            $saleData['cash_pay'] = $cash;
        }
        // $order_paid = $this->input->post('order_paid_amount');
        // if ($order_paid != '') {
        //     $transaction_payment['account_id'] = $this->input->post('order_account_id');
        //     $transaction_payment['payment_method_id'] = 5;
        //     $transaction_payment['amount'] = $order_paid;
        //     $transaction_payment_d = $this->common_model->commonInsertSTP('tmp_sale_transaction_payments', $transaction_payment);
        //     $saleData['order_pay'] = $order_paid;
        // }
        
        if (!empty($card_payment)) {
            
            $transaction_payment = array();
            $transaction_payment['account_id'] = explode("@", $bank_name)[1];
            $transaction_payment['payment_method_id'] = 2;
            $transaction_payment['amount'] = $card_payment;
            $transaction_payment['ref_acc_no'] = $card_number;
            $transaction_payment['ref_bank_id'] = explode("@", $bank_name)[0];
            $transaction_payment['ref_card_id'] = $card_type;
            $transaction_payment_c = $this->common_model->commonInsertSTP('tmp_sale_transaction_payments', $transaction_payment);
            if ($transaction_payment_c) {
                //$this->common_model->updAccCurrBalance(explode("@", $bank_name)[1], $card_payment, 1);
            }
            $saleData['cart_pay'] = $card_payment;
        }
        if (!empty($mobile_amount)) {
            $transaction_payment = array();
            $transaction_payment['account_id'] = explode("@", $mob_bank_name)[1];
            $transaction_payment['payment_method_id'] = 3;
            $transaction_payment['amount'] = $mobile_amount;
            $transaction_payment['ref_acc_no'] = $mob_card_number;
            $transaction_payment['ref_bank_id'] = explode("@", $mob_bank_name)[0];
            $transaction_payment['ref_trx_no'] = $transaction_no;
            $transaction_payment_e = $this->common_model->commonInsertSTP('tmp_sale_transaction_payments', $transaction_payment);
            if ($transaction_payment_e) {
                // $this->common_model->updAccCurrBalance(explode("@", $mob_bank_name)[1], $mobile_amount, 1);
            }
            $saleData['mobile_pay'] = $mobile_amount;
        }
        // Replace Start
        $sale_adjustments_id='';
        $r_total_amt=0;
        $replace_data = $this->input->post('replace_data');
        if($replace_data==1){
            $r_total_amt = $this->input->post('r_total_amt');
            $r_sale_id = $this->input->post('r_sale_id');
            $r_dis_amt = $this->input->post('r_dis_amt');
            $r_customer_id = $this->input->post('r_customer_id');
            $r_act_amount = $this->input->post('r_act_amount');
            $r_total_pro_dis = $this->input->post('r_total_pro_dis');
            $r_total_vat = $this->input->post('r_total_vat');
            $data['invoice_no'] = $this->generateInvoiceNo();//time().'-'.rand(100,999);
            $data['type_id'] = 1;
            $data['ref_sale_id'] = $r_sale_id;
            $data['store_id'] = $this->session->userdata['login_info']['store_id'];
            $data['customer_id'] = $r_customer_id;
            $data['product_amt'] = $r_act_amount;
            $data['vat_amt'] = $r_total_vat;
            $data['discount_amt'] = $r_dis_amt + $r_total_pro_dis;
            $data['tot_amt'] = $r_total_amt;
            $data['paid_amt'] = $r_total_amt;
            $data['station_id'] = $this->session->userdata['login_info']['station_id'];
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $sale_adjustments_id = $this->sales_model->common_insert('sale_adjustments', $data);
            $original_points = 0;
            $saleData['replace_amount'] =$r_total_amt;
            $rep_data=array();
            if ($sale_adjustments_id) {
                $r_details_id = $this->input->post('r_details_id');
                $r_return_qty = $this->input->post('r_return_qty');
                $r_price_est = $this->input->post('r_price_est');
                $r_dis_rate_val = $this->input->post('r_dis_rate_val');
                $r_vat_act = $this->input->post('r_vat_act');
                $r_unit_total = $this->input->post('r_unit_total');
                for ($i = 0; $i < count($r_details_id); $i++) {
                    $product = array();
                    $posts = $this->sales_model->getvalue_row_one('sale_details_view', '*', array('id_sale_detail' => $r_details_id[$i]));
                    $product['sale_id'] = $sale_adjustments_id;
                    $product['sale_type_id'] = 2;
                    $product['qty_multiplier'] = 1;
                    $product['stock_id'] = $posts[0]['stock_id'];
                    $product['product_id'] = $posts[0]['product_id'];
                    $product['cat_id'] = $posts[0]['cat_id'];
                    $product['subcat_id'] = $posts[0]['subcat_id'];
                    $product['brand_id'] = $posts[0]['brand_id'];
                    $product['qty'] = $r_return_qty[$i];
                    $product['unit_id'] = $posts[0]['unit_id'];
                    $product['selling_price_est'] = $r_price_est[$i];
                    $product['selling_price_act'] = $r_unit_total[$i];
                    $product['discount_rate'] = ($r_dis_rate_val[$i] / $r_return_qty[$i]);
                    $product['discount_amt'] = $r_dis_rate_val[$i];
                    $product['vat_rate'] = $r_vat_act[$i] / $r_return_qty[$i];
                    $product['vat_amt'] = $r_vat_act[$i];
                    $product['dtt_add'] = date('Y-m-d H:i:s');
                    $product['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
                    $details = $this->sales_model->common_insert('sale_details', $product);
                    $this->sales_model->update_value_add('stocks', 'qty', $r_return_qty[$i], array('id_stock' => $posts[0]['stock_id']));
                    // $rep=array(
                    //     'product_name'=>$posts[0]['product_name'],
                    //     'product_code'=>$posts[0]['product_code'],
                    //     'unit_price'=>$r_price_est[$i]/$r_return_qty[$i],
                    //     'qty'=>$r_return_qty[$i],
                    //     'discout'=>$r_dis_rate_val[$i],
                    //     'vat_amt'=>$r_vat_act[$i],
                    //     'total_price'=>$r_unit_total[$i],
                    // );
                    // array_push($rep_data,$rep);
                }
                //$saleData['replace_products'] =$rep_data;
            } 
        }
        
        // Replace End
        $trx_no = $this->auto_increment->getAutoIncKey('TRANSACTION', 'sale_transactions');
        $uid = $this->session->userdata['login_info']['id_user_i90'];
        $round_amt=($con_round_amt!='')?$con_round_amt:$paid_amt_array[1];
        if ($cart_total > 0) {
            $dataSale = "'" . $invoice . "','" . $store_name . "','" . $station_id . "','" . $customer_id . "','" . $to_point . "','" . $trx_no . "','" . $cart_total
                . "','" . $total_discount . "','" . $grand_total . "','" . $paid_amt_array[0] . "','" . $remit_val . "','" . $round_amt . "','" . $paid_amt_array[2]
                . "','" . date('Y-m-d H:i:s') . "','" . $uid . "','" . $note . "','" . $sales_person . "','" . $order_id . "','" . $order_status. "','" . $sale_adjustments_id. "','" . $r_total_amt. "','" . $gift_sale;
            $qry_res = $this->db->query("CALL ImportSales(" . $dataSale . "',@sale_id)");
            $query = $this->db->query("SElECT @sale_id AS sale_d");
            $query_res = $query->result_array();
            //$msg = "Supplier Transaction Saved successfully.";
            //echo $query_res[0]['sale_d'];
            if ($query_res) {
                $delivery_type = $this->input->post('delivery_type');
                if (isset($delivery_type)) {
                    $delivery_type = $this->input->post('delivery_type');
                    $agent_name = $this->input->post('agent_name');
                    $delivery_person1 = $this->input->post('delivery_person1');
                    $service_name = $this->input->post('service_name');
                    $service_range = $this->input->post('service_range');
                    $service_price = $this->input->post('service_price');
                    $paid_amount = $this->input->post('paid_amount');
                    $cod = $this->input->post('cod');
                    $account_method = $this->input->post('account_method');
                    $ref_trx_no = $this->input->post('ref_trx_no');
                    $service_accounts = $this->input->post('service_accounts');
                    $delivery_address_id = $this->input->post('delivery_address_id');
                    $delivery_address = $this->input->post('delivery_address');
                    $ref_id = ($delivery_type == 2) ? $agent_name : 'NULL';
                    $mobile_trx_no = ($account_method == 3) ? $ref_trx_no : 'NULL';
                    $paid_amount = ($paid_amount == '' || $paid_amount == 0) ? 0 : $paid_amount;
                    $discount_amt_v = 0;
                    $trn_id = $this->common_model->getvalue_row_one('sale_transactions', 'id_sale_transaction', array('trx_no' => $trx_no));
                    $trx_no = $trx_no + 1;
                    $dataDelivery = "'" . $query_res[0]['sale_d'] . "','" . $delivery_type . "','" . $ref_id . "','" . $delivery_person1 . "','" . $service_name . "','" . $service_range . "','" . $service_price
                        . "','" . $paid_amount . "','" . $discount_amt_v . "','" . $cod . "','" . $trx_no . "','" . $customer_id . "','" . $store_name . "','" . $service_accounts . "','" . $account_method . "','" . $mobile_trx_no
                        . "','" . $delivery_address_id . "','" . $delivery_address . "','" . date('Y-m-d H:i:s') . "','" . $uid;
                    $qry_res = $this->db->query("CALL delivery_add(" . $dataDelivery . "',@delivery_id)");
                    $query = $this->db->query("SElECT @delivery_id AS delivery_id");
                    $query_r = $query->result_array();
                }

                $this->auto_increment->updAutoIncKey('TRANSACTION', $trx_no, $trx_no);
                $this->load->library('barcode');
                $saleData['paid_amt'] = $paid_amt;
                $saleData['round_amt'] = $round_amt;
                $saleData['products'] = $this->sales_model->getvalue_sale_details($query_res[0]['sale_d']);
                $saleData['customers'] = $this->commonmodel->getvalue_row_one('customers', 'customer_code,full_name,phone', array('id_customer' => $customer_id));
                $saleData['customer_name'] = $this->input->post('customer_name');
                $saleData['customer_code'] = $customer_code;
                $saleData['customer_balance'] = $customer_balance;
                $saleData['delivery_address'] = $this->input->post('delivery_address');
                $saleData['delivery_person_name'] = $this->input->post('delivery_person_name');
                $saleData['service_price'] = $this->input->post('service_price');
                $saleData['de_paid_amount'] = $this->input->post('paid_amount');
                $saleData['cash_paid'] = $this->input->post('cash_paid');
                $saleData['change_amt'] = $this->input->post('change_amt');
                $saleData['vat_reg_no'] = $this->commonmodel->getvalue_row_one('stores', 'vat_reg_no', array('id_store' => $this->session->userdata['login_info']['store_id']));
                $saleData['customer_phone'] = $this->input->post('customer_phone');
                $saleData['invoice'] = $invoice;
                $saleData['note'] = $note;
                $saleData['sales_person_name'] = $this->input->post('sales_person_name');
                if($replace_data==1){
                    $saleData['return_products'] = $this->commonmodel->getvalue_sale_return_details($sale_adjustments_id);
                    $saleData['return_sales_person_name'] = $this->commonmodel->salesPersonNameBySaleId($sale_adjustments_id);
                    $dataArray = array(
                        'status_id' => 1,
                        'sale_id' => $r_sale_id, 
                        'promotion_type_id !=' => 1
                    );
                    $saleData['return_promotions'] = $this->commonmodel->getvalue_row('sale_promotions', 'promotion_type_id,discount_rate,discount_amt', $dataArray);
                    $saleData['return_invoices'] = $this->commonmodel->get_sellReturn_print_invoice($sale_adjustments_id);
                }
                if ($this->input->post('print_type') == 'a4print') {
                    $saleData['settings'] = $this->commonmodel->invoice_setting_report('full');
                    $this->load->view('sales/sale_view_a4_print', $saleData, false);
                } else {
                    $saleData['settings'] = $this->commonmodel->invoice_setting_report('thermal');
                    $this->load->view('sales/sale_view_print', $saleData, false);
                }
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }
    private function generateInvoiceNo() {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random = '';
        for ($i = 0; $i < 3; $i++) {
            $random .= $chars[rand(0, strlen($chars) - 1)];
        }
        return time() . $random;
    }
    public function show_agent_staff_list()
    {
        $id = $this->input->post('id');
        $data['id']=$id;
        $data['agents'] = $this->common_model->getvalue_row('agents', 'id_agent,agent_name', array('status_id' => 1));
        $data['staffs'] = $this->sales_model->delivety_person_staff_list();
        $data['costs'] = $this->common_model->getvalue_row('delivery_costs', 'id_delivery_cost,delivery_name', array('status_id' => 1, 'type_id' => $id));
        $data['accounts'] = $this->sales_model->listAccounts($this->session->userdata['login_info']['store_ids']);
        $this->load->view('sales/delivery',$data);
    }
    public function show_service_range()
    {
        $id = $this->input->post('id');
        $costs = $this->common_model->getvalue_row('delivery_cost_details', 'id_delivery_cost_details,gm_from,gm_to,price', array('delivery_cost_id' => $id));
        $html = '';
        $html .= '<option value="0" selected>' . lang('select_one') . '</option>';
        if (!empty($costs)) {
            foreach ($costs as $cost) {
                $value = $cost->gm_from . ' To ' . $cost->gm_to;
                $html .= '<option actp="' . $cost->price . '" value="' . $cost->id_delivery_cost_details . '@' . $value . '">' . $value . '</option>';
            }
        }
        echo $html;
    }

    public function show_delivery_person_agent()
    {
        $id = $this->input->post('id');
        $agents = $this->common_model->getvalue_row('delivery_persons', 'person_name,id_delivery_person', array('ref_id' => $id, 'status_id' => 1, 'type_id' => 2));
        $html = '';
        $html .= '<option value="0" selected>' . lang('select_one') . '</option>';
        if (!empty($agents)) {
            foreach ($agents as $agent) {
                $html .= '<option value="' . $agent->id_delivery_person . '@' . $agent->person_name . '">' . $agent->person_name . '</option>';
            }
        }
        $costs = $this->common_model->getvalue_row('delivery_costs', 'id_delivery_cost,delivery_name', array('status_id' => 1, 'ref_id' => $id, 'type_id' => 2));
        $html1 = '';
        $html1 .= '<option value="0" selected>' . lang('select_one') . '</option>';
        if (!empty($costs)) {
            foreach ($costs as $cost) {
                $html1 .= '<option value="' . $cost->id_delivery_cost . '@' . $cost->delivery_name . '">' . $cost->delivery_name . '</option>';
            }
        }
        echo json_encode(array('person' => $html, 'service' => $html1));
    }

    public function add_delivery_charge_sales()
    {
        $delivery_type = $this->input->post('delivery_type');
        $agent_name = $this->input->post('agent_name');
        $delivery_person1 = $this->input->post('delivery_person1');
        $service_name = $this->input->post('service_name');
        $service_range = $this->input->post('service_range');
        $service_price = $this->input->post('service_price');
        $paid_amount = ($this->input->post('paid_amount') == '') ? 0 : $this->input->post('paid_amount');
        $cod = $this->input->post('cod');
        $account_method = $this->input->post('account_method');
        $ref_trx_no = $this->input->post('ref_trx_no');
        $service_accounts = $this->input->post('service_accounts');
        $check_address = $this->input->post('check_address');
        $address = $this->input->post('address');
        $pers_name='';
        $pers_id='';
        if($delivery_person1 != '0'){
            $pers_name=explode("@", $delivery_person1)[1];
            $pers_id=explode("@", $delivery_person1)[0];
        }
        if ($check_address == 'new') {
            $data['customer_id'] = $this->input->post('customer_id');
            $data['address_type'] = 'Shipping Address';
            $data['div_id'] = $this->input->post('division_id');
            $data['dist_id'] = $this->input->post('district_id');
            $data['city_id'] = $this->input->post('city_id');
            $data['area_id'] = $this->input->post('city_location_id');
            $data['addr_line_1'] = $this->input->post('addr_line_1');
            $ad_id = $this->common_model->common_insert('customer_addresss', $data);
            $check_address = $ad_id;
        }
        $html = '<div class="info-1">';
        $html .= '<div><strong class="fix-width">' . lang("delivery_type") . '</strong>: <span>' . explode("@", $delivery_type)[1] . '</span></div>';
        if (explode("@", $delivery_type)[0] == 2) {
            $html .= '<div><strong class="fix-width">' . lang("agent-name") . '</strong>: <span>' . explode("@", $agent_name)[1] . '</span></div>';
            $html .= '<input type="hidden" name="agent_name" value="' . explode("@", $agent_name)[0] . '">';
        }
        $html .= '<div><strong class="fix-width">' . lang("delivery_person") . '</strong>: <span>' . $pers_name . '</span></div>';
        $html .= '<div><strong class="fix-width">' . lang("service_name") . '</strong>: <span>' . explode("@", $service_name)[1] . '</span></div>';
        $html .= '<div><strong class="fix-width">' . lang("service_range") . '</strong>: <span>' . explode("@", $service_range)[1] . '</span></div>';
        $html .= '<div><strong class="fix-width">' . lang("accounts") . '</strong>: <span>' . explode("@", $service_accounts)[1] . '</span></div>';
        if (isset($ref_trx_no)) {
            $html .= '<div><strong class="fix-width">' . lang("ref_trx_no") . '</strong>: <span>' . $ref_trx_no . '</span></div>';
            $html .= '<input type="hidden" name="ref_trx_no" value="' . $ref_trx_no . '">';
        }
        $html .= '<div><strong class="fix-width">' . lang("cod_charge") . '</strong>: <span>' . $cod . '</span></div>';
        $html .= '<div><strong class="fix-width">' . lang("delivery_address") . '</strong>: <span>' . $address . '</span></div>';
        $html .= '<div><strong class="fix-width">' . lang("service_price") . '</strong>: <span>' . $service_price . '</span></div>';
        $html .= '<div><strong class="fix-width">' . lang("paid_amount") . '</strong>: <span>' . $paid_amount . '</span></div>';
        $html .= '<div><strong class="fix-width">' . lang("due_amount") . '</strong>: <span>' . ($service_price - $paid_amount) . '</span></div>';
        $html .= '<input type="hidden" name="delivery_type" value="' . explode("@", $delivery_type)[0] . '">';
        $html .= '<input type="hidden" name="delivery_address_id" value="' . $check_address . '">';
        $html .= '<input type="hidden" name="delivery_address" value="' . $address . '">';
        $html .= '<input type="hidden" name="delivery_person" value="' . $pers_id . '">';
        $html .= '<input type="hidden" name="delivery_person_name" value="' . $pers_name . '">';
        $html .= '<input type="hidden" name="service_name" value="' . explode("@", $service_name)[0] . '">';
        $html .= '<input type="hidden" name="service_range" value="' . explode("@", $service_range)[0] . '">';
        $html .= '<input type="hidden" name="service_price" value="' . $service_price . '">';
        $html .= '<input type="hidden" name="paid_amount" value="' . $paid_amount . '">';
        $html .= '<input type="hidden" name="cod" value="' . $cod . '">';
        $html .= '<input type="hidden" name="service_accounts" value="' . explode("@", $service_accounts)[0] . '">';
        $html .= '<input type="hidden" name="account_method" value="' . $account_method . '">';
        echo $html;

    }
    public function show_customer_address()
    {
        $id = $this->input->post('id');
        $customers = $this->sales_model->get_customer_address($id);
        //if($customers){
        $data['posts'] = $customers;
        $this->load->view('sales/customer_address', $data);
    }

    public function customer_address_add()
    {
        $id = $this->input->post('id');
        $data['id'] = $id + 1;
        $data['city_list'] = $this->sales_model->getvalue_row('loc_cities', 'id_city,city_name_en', array());
        $data['division_list'] = $this->sales_model->getvalue_row('loc_divisions', 'id_division,division_name_en', array());
        $this->load->view('sales/add_customer_address', $data);
    }
    public function create_customer_info_short()
    {
        $this->form_validation->set_rules('customer_code', 'Customer code', 'trim|required|callback_is_unique_customer');
        $this->form_validation->set_rules('full_name', 'Fullname', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_numeric');
        if ($this->form_validation->run() == false) {
            $value = $this->form_validation->error_array();
            echo json_encode($value);
        } else {
            $data['customer_code'] = $this->input->post('customer_code');
            $data['full_name'] = $this->input->post('full_name');
            $data['customer_type_id'] = $this->input->post('customer_type_id');
            $data['email'] = $this->input->post('email2');
            $data['phone'] = $this->input->post('phone');
            $data['store_id'] = $this->session->userdata['login_info']['store_id'];
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $result = $this->sales_model->common_insert('customers', $data);
            $posts = $this->sales_model->getvalue_row_one('customers', '*', array('id_customer' => $result));
            echo json_encode(array("status" => "success", "message" => $posts));
        }
    }
    function is_unique_customer($str)
    {
        $this->load->database();
        $this->db->where('customer_code', $str);
        $query = $this->db->get('customers');
        $result = $query->result();
        if ($result) {
            $this->form_validation->set_message('is_unique_customer', lang('unique_false_msg'));
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function hold_sale_add()
    {
        $date = time();
        $stock_id = $this->input->post('stock_id');
        $customer_id = $this->input->post('customer_id');
        $pro_id = $this->input->post('pro_id');
        $qty = $this->input->post('qty');
        $discount_amt = $this->input->post('discount_amt');
        $discount = $this->input->post('discount');
        $batch = $this->input->post('batch');
        for ($i = 0; $i < count($stock_id); $i++) {
            // `invoice_no``store_id` `station_id` `customer_id` `stock_id` `product_id` `qty` `qty``uid_add`
            $product = array();
            $product['invoice_no'] = $this->generateInvoiceNo();//$date;
            $product['stock_id'] = $stock_id[$i];
            $product['station_id'] = $this->session->userdata['login_info']['station_id'];
            $product['store_id'] = $this->session->userdata['login_info']['store_id'];
            $product['customer_id'] = $customer_id;
            $product['product_id'] = $pro_id[$i];
            $product['batch_no'] = $batch[$i];
            $product['qty'] = $qty[$i];
            $product['dis_rate'] = $discount[$i];
            $product['dis_amt'] = $discount_amt[$i];
            $product['dtt_add'] = date('Y-m-d H:i:s');
            $product['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $details = $this->sales_model->common_insert('hold_sales', $product);
        }
        if ($details) {
            echo json_encode(array("status" => "success", "message" => lang('add_success')));
        }
    }

    public function hold_sale_list()
    {
        $store_id = $this->session->userdata['login_info']['store_id'];
        $holds = $this->sales_model->hold_sale_list($store_id);
        //print_r($promotions);
        $html = '';
        $html .= '<table id = "mytable" class="table table-bordered table-striped" >';
        $html .= '<thead >';
        $html .= '<th >Invoice No</th>';
        $html .= '<th> Station </th>';
        $html .= '<th>Customer Id</th>';
        $html .= '<th> ' . lang("date") . '</th>';
        $html .= '<th>' . lang("action") . '</th>';
        $html .= '</tbody>';
        $html .= '<tbody>';
        foreach ($holds as $data) {
            $html .= '<tr>';
            $html .= '<td> ' . $data->invoice_no . ' </td>';
            $html .= '<td> ' . $data->station_id . ' </td>';
            $phone=($data->full_name!='')?' ('.$data->phone.')':'';
            $html .= '<td> ' . $data->full_name.$phone . ' </td>';
            $html .= '<td> ' . $data->dtt_add . ' </td>';
            $html .= '<td>  <a href="' . base_url() . 'sales?restore=' . $data->invoice_no . '" class="btn btn-primary">Restore</a></td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        echo $html;
    }
    public function temp_add_return_sale()
    {
        $invoice = $this->input->post('invoice');
        $this->load->model('sales_model');
        $store_id = $this->session->userdata['login_info']['store_id'];
        $data['sales'] = $this->sales_model->getvalue_row_one('sales', '*', array('invoice_no' => $invoice,'store_id'=>$store_id));
        if ($data['sales']) {
            $saleId = $data['sales'][0]['id_sale'];
            $dArray= $this->sales_model->getvalue_row_one('delivery_orders', 'id_delivery_order', array('sale_id' => $saleId));
            $data['delivery']=($dArray!='')?'1':'';
            $data['returns'] = $this->sales_model->return_product_list($data['sales'][0]['id_sale']);
           
            $data['customer_id'] = $data['sales'][0]['customer_id'];
            $data['posts'] = $this->sales_model->getvalue_row('sale_details_view', '*', array('sale_id' => $saleId));
            $data['promotions'] = $this->sales_model->getvalue_row('sale_promotions', '*', array('sale_id' => $saleId, 'promotion_type_id!=' => 1));
            $rr = $this->config->item('promotion_types');
        }
        $this->load->view('sales/replace_invoice_list', $data);
    }
    public function show_sale_return_data()
    {
        $check_id = $this->input->post('check_id');
        $return_qty = $this->input->post('return_qty');
        $selling_price = $this->input->post('selling_price');
        $promo['customer_id'] = $this->input->post('customer_id');
        $html = '';
        $total = $total_vat = $act_amount = $total_pro_dis = 0;
        for ($i = 0; $i < count($check_id); $i++) {
            $details_id = $check_id[$i];
            $data = $this->sales_model->getvalue_row_one('sale_details_view', '*', array('id_sale_detail' => $details_id));
            if ($data) {
                $html .= '<tr>';
                $html .= '<td>' . $data[0]['product_name'] . ' <input type="hidden" name="r_details_id[]" value="' . $data[0]['id_sale_detail'] . '"></td>';
                $html .= '<td>' . $data[0]['batch_no'] . '</td>';
                $html .= '<td>' . $return_qty[$i] . ' <input type="hidden" name="r_return_qty[]" value="' . $return_qty[$i] . '"></td>';
                $html .= '<td>' . $data[0]['selling_price_est'] / $data[0]['qty'] . '</td>';
                $price_est = ($data[0]['selling_price_est'] / $data[0]['qty']) * $return_qty[$i];
                $html .= '<td>' . $price_est . '<input type="hidden" name="r_price_est[]" value="' . $price_est . '"></td>';
                $dis_rate_val = ($data[0]['discount_amt'] / $data[0]['qty']) * $return_qty[$i];
                $html .= '<td>' . $dis_rate_val . '<input type="hidden" name="r_dis_rate_val[]" value="' . $dis_rate_val . '"></td>';
                $vat_act = number_format((($data[0]['vat_amt'] / $data[0]['qty']) * $return_qty[$i]), 2);
                $html .= '<td>' . $vat_act . '<input type="hidden" name="r_vat_act[]" value="' . $vat_act . '"></td>';
                $unit_total = $selling_price[$i];
                $html .= '<td>' . number_format($unit_total,2) . '<input type="hidden" name="r_unit_total[]" value="' . $unit_total . '"></td>';
                $html .= '</tr>';
                $total = $total + $selling_price[$i];
                $sale_id = $data[0]['sale_id'];
                $total_vat += (($data[0]['vat_amt'] / $data[0]['qty']) * $return_qty[$i]);
                $act_amount += $selling_price[$i];
                $total_pro_dis += $dis_rate_val;
            }
        }
        $promo['promotions'] = $this->sales_model->getvalue_row('sale_promotions', '*', array('sale_id' => $sale_id, 'promotion_type_id!=' => 1));
        $promo['total'] = $total;
        $promo['data'] = $html;
        $promo['sale_id'] = $sale_id;
        $promo['total_vat'] = $total_vat;
        $promo['act_amount'] = $act_amount;
        $promo['total_pro_dis'] = $total_pro_dis;

        $this->load->view('sales/replace_product_list', $promo);
    }

   


}
