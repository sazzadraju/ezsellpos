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
        //$tt=$this->common_model->update_balance_amount('customers','balance','50','+', array('id_customer'=>'1'));
        //echo $tt;
        $this->load->model('customer_settings/Customer_model');
        $data = array();
        $this->dynamic_menu->check_menu('sales');
        $this->breadcrumb->add(lang('sales'), 'sales', 0);
        $data['breadcrumb'] = $this->breadcrumb->output();
        $store_m = $this->session->userdata['login_info']['store_id'];
        $data['store_name_p'] = $this->session->userdata['login_info']['store_id'];
        $data['station_name_p'] = $this->session->userdata['login_info']['station_id'];
        $data['banks'] = $this->sales_model->get_bank_name($store_m);
        $data['vat'] = $this->sales_model->getvalue_row_one('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        $data['point_earn'] = $this->sales_model->getvalue_row_one('configs', 'param_val', array('param_key' => 'POINT_EARN_RATIO'));
        $data['point_remit'] = $this->sales_model->getvalue_row_one('configs', 'param_val', array('param_key' => 'POINT_REDEEM_RATIO'));
        $data['customers'] = $this->sales_model->getvalue_row('customers', 'id_customer,customer_code,phone,full_name', array('status_id' => 1));
        $data['city_list'] = $this->Customer_model->common_single_value_array('loc_cities', 'id_city', 'city_name_en', 'id_city', 'ASC');
        $data['division_list'] = $this->Customer_model->common_single_value_array('loc_divisions', 'id_division', 'division_name_en', 'id_division', 'ASC');
        //echo 'store='.$this->session->userdata['login_info']['store_id'].'&station='.$this->session->userdata['login_info']['station_id'].'@account_id='.$this->session->userdata['login_info']['station_acc_id'];
        if (isset($_REQUEST['order'])) {
            $data['ord'] = $this->order_sale_data();
        }
        if (isset($_REQUEST['restore'])) {
            $request_id = $_REQUEST['restore'];
            $honds = $this->sales_model->getvalue_row('hold_sales', '*', array('invoice_no' => $request_id));
            $html = '';
            $rowCount = 1;
            if ($honds) {
                $this->sales_model->delete_data('hold_sales', array('invoice_no' => $request_id));
                $coutn = 0;
                foreach ($honds as $hond) {
                    $stock_id = $hond->stock_id;
                    $pro_id = $hond->product_id;
                    $store_id = $hond->store_id;
                    $pro_qty = $hond->qty;
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
                        $brand = $product[0]['brand_id'];
                        $cat = $product[0]['cat_id'];
                        $subcat = $product[0]['subcat_id'];
                        $selling_price = $product[0]['selling_price_est'];
                        $promotions = $this->sales_model->getvalue_row('promotion_products_view', '*', array('store_id' => $store_id));
                        $promotion_id = '';
                        $discount_type = '';
                        $total_per = 0;
                        if ($promotions) {
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
                                    $promotion_id = $promotion->promotion_id;
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
                        }
                        if (($total_per != 0) || ($total_amt != 0)) {
                            $qty_selling_price = ($pro_qty * $selling_price) * $total_per;
                            $per_taka = $qty_selling_price / 100;
                            $discount = ($per_taka > $total_amt) ? $total_per : $total_amt;
                            $discount_type = ($per_taka > $total_amt) ? '%' : 'TK';
                            if ($discount_type == '%') {
                                $total_discount_amount = (($selling_price * $pro_qty) * $discount) / 100;
                                //total_discount_amount = ($product.data[0]['selling_price_est'] - discount_amount);
                            } else {
                                $total_discount_amount = $discount;
                            }
                        }
                        $page = '';
                        if ($total_discount_amount != 0) {
                            $page = '<div class="prom">P</div>';
                        }
                        $pro_total = ($product[0]['selling_price_est'] * $pro_qty) - $total_discount_amount;

                        $html .= '<tr id="' . $rowCount . '"><input type="hidden" id="' . 'unit_id_' . $rowCount . '" name="unit_id[]" value="' . $product[0]['unit_id'] . '">';
                        $html .= '<td>' . $product[0]['product_name'] . $page . '<input type="hidden" id="' . 'pro_name_' . $rowCount . '" name="pro_name[]" value="' . $product[0]['product_name'] . '"><input type="hidden" id="' . 'pro_id_' . $rowCount . '" name="pro_id[]" value="' . $product[0]['id_product'] . '">';
                        $html .= '<input type="hidden" id="' . 'stock_id_' . $rowCount . '" name="stock_id[]" value="' . $product[0]['id_stock'] . '"><input type="hidden" id="' . 'cat_id_' . $rowCount . '" name="cat_id[]" value="' . $product[0]['cat_id'] . '"><input type="hidden" id="' . 'subcat_id_' . $rowCount . '" name="subcat_id[]" value="' . $product[0]['subcat_id'] . '"><input type="hidden" id="' . 'brand_id_' . $rowCount . '" name="brand_id[]" value="' . $product[0]['brand_id'] . '"></td>';
                        $html .= '<td>' . $product[0]['product_code'] . '<input type="hidden" id="' . 'pro_code_' . $rowCount . '" name="pro_code[]" value="' . $product[0]['product_code'] . '">' . '</td>';
                        //$html += '<td>' + $product.data[0]['batch_no'] + '<input type="hidden" id="' + 'batch_' + $rowCount + '" name="batch[]" value="' + $product.data[0]['batch_no'] + '">' + '</td>';
                        $html .= '<td>';
                        $html .= '<select id="batch_' . $rowCount . '" name="batch[]">';
                        foreach ($batch_new as $batch) {
                            $select = ($batch->batch_no == $product[0]['batch_no']) ? 'selected' : '';
                            $html .= '<option value="' . $batch->batch_no . '" ' . $select . '>' . $batch->batch_no . '</option>';
                        }
                        if ($product[0]['is_vatable'] == 1) {
                            $de_vat = $data['vat'][0]['param_val'];
                            $vat_total = ($pro_total * $de_vat) / 100;
                        }

                        $html .= '</select>';
                        $html .= '</td>';
                        $html .= '<td>' . '<input readonly style="width: 40px" type="text" id="' . 'total_qty_' . $rowCount . '" name="total_qty[]" value="' . $product[0]['total_qty'] . '">' . '</td>';
                        $html .= '<td>' . '<input type="text" style="width: 50px" id="' . 'qty_' . $rowCount . '" name="qty[]" value="' . $hond->qty . '" class="change_price">' . '</td>';
                        $html .= '<td>' . '<input type="text" style="width: 60px" id="' . 'unit_price_' . $rowCount . '" name="unit_price[]" value="' . $product[0]['selling_price_est'] . '" class="change_price">' . '</td>';
                        $html .= '<td id="discount_td">' . '<input type="text" style="width: 45px" id="' . 'discount_' . $rowCount . '" name="discount[]" value="' . $discount . '" class="change_price"><strong>' . $discount_type . '</strong><input type="hidden" id="' . 'discount_type_' . $rowCount . '" name="discount_type[]" value="' . $discount_type . '"> <input type="hidden" name="pro_sale_id[]" value="' . $promotion_id . '"></td>';
                        $html .= '<td>' . '<input type="text" style="width: 40px" id="' . 'def_vat_' . $rowCount . '" name="def_vat[]" value="' . $de_vat . '" readonly><input type="hidden" id="def_vat_amt_' . $rowCount . '" name="def_vat_amt[]" value="' . $vat_total . '" readonly>' . '</td>';
                        $html .= '<td>' . '<input type="text" style="width: 60px" id="' . 'total_price_' . $rowCount . '" name="total_price[]" value="' . ($pro_total + $vat_total) . '" readonly>' . '</td>';
                        $html .= '<td><a class="close-button" onclick="temp_remove_product(' . $rowCount . ')"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
                        $html .= '</tr>';
                    }
                    $rowCount++;
                } //end foreach


                $data['request_key'] = $html;
            }
        }
        $chk_store['type_id'] = 3;
        $chk_store['store_id'] = $this->session->userdata['login_info']['store_id'];


        $data['stores'] = $this->sales_model->getvalue_row('stores', 'id_store,store_name', array('status_id' => 1));
        $data['card_type'] = $this->sales_model->getvalue_row('card_types', 'id_card_type,card_name', array());
        $data['card_promotions'] = $this->sales_model->getvalue_row('promotion_products_view', 'title,type_id,discount_rate,promotion_id', $chk_store);
        $data['customer_type_list'] = $this->sales_model->getvalue_row('customer_types', 'id_customer_type,name', array('status_id' => '1'));
        $data['salesPersons'] = $this->sales_model->getSales_person_list();

// $data['records'] = $this->user_model->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'TOT_STATIONS'));
        //$data['posts'] = $this->user_model->getvalue_row('stations', 'id_station,name', array('status_id' => 1));
        $this->template->load('main', 'sales/index', $data);
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
            $name=$this->input->post('full_name');
            $code=$this->input->post('customer_code');
            $phone=$this->input->post('phone');
            $data['customer_code'] = $this->input->post('customer_code');
            $data['full_name'] = $this->input->post('full_name');
            $data['customer_type_id'] = $this->input->post('customer_type_id');
            $data['email'] = $this->input->post('email2');
            $data['phone'] = $this->input->post('phone');
            $data['store_id'] = $this->session->userdata['login_info']['store_id'];
            $data['dtt_add'] = date('Y-m-d H:i:s');
            $data['uid_add'] = $this->session->userdata['login_info']['id_user_i90'];
            $customer_id = $this->sales_model->common_insert('customers', $data);
            if ($customer_id) {

                if (($this->input->post('address_type2') != 0) || ($this->input->post('division_id') != '') || ($this->input->post('city_id') != '') || ($this->input->post('addr_line_1') != ''))
                    $address_data['customer_id'] = $customer_id;
                $address_data['address_type'] = $this->input->post('address_type2');
                $address_data['div_id'] = $this->input->post('division_id');
                $address_data['dist_id'] = $this->input->post('district_id');
                $address_data['city_id'] = $this->input->post('city_id');
                $address_data['area_id'] = $this->input->post('city_location_id');
                $address_data['addr_line_1'] = $this->input->post('addr_line_1');
                $log_id = $this->sales_model->common_insert('customer_addresss', $address_data);
            }
            echo json_encode(array("status" => "success", "message" => lang('add_success'),'id'=>$customer_id,'name'=>$name,'code'=>$code,'phone'=>$phone));
        }
    }

    public function temp_add_cart_for_sales()
    {
        $html = '';
        $product_name = $this->input->post('product_name');
        $store_id = $this->session->userdata['login_info']['store_id'];
        $acc_type = $this->input->post('acc_type');
        //echo $product_name.'=='.$acc_type;

        if ($acc_type == 'No') {
            $pro_id = explode('-', $product_name);
            $id = explode('-', $product_name)[0];
            if (count($pro_id) > 2) {
                $batch = $pro_id[1] . '-' . $pro_id[2];
            } else {
                $batch = $pro_id[1];
            }
        } else {
            $batch = $this->input->post('batch_s');
            $id = $this->input->post('product_id');
        }
        if ($batch != '') {
            $data['batch_no'] = $batch;
        }
        //exit();
        $data['id_product'] = $id;
        $data['store_id'] = $store_id;
        $data['product_name'] = $product_name;
        $vat = $this->sales_model->getvalue_row_one('configs', 'param_val', array('param_key' => 'DEFAULT_VAT'));
        $batch_new = $this->sales_model->getTempProductNameBatch(array('id_product' => $id, 'store_id' => $store_id, 'product_name' => $product_name));
        $product = $this->sales_model->getTempProductName($data);
        $attArray = $this->sales_model->getvalue_row_one('vw_stock_attr', 'attribute_name', array('stock_id' => $product[0]['id_stock']));
        if($attArray){
            $product[0]['attribute_name']=$attArray[0]['attribute_name'];
            //array_push($product, );
        }
        if ($product) {
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
                    // if ($promotion->type_id == 2) {
                    //$purchase_dis[] = array('amount' => $promotion->min_purchase_amt, 'rate_per' => $promotion->discount_rate, 'rate_taka' => $promotion->discount_amount);
                    //$purchase_dis[]=$promotion->min_purchase_amt;
                    // }
                }
                if (($total_per != 0) || ($total_amt != 0)) {
                    $per_taka = ($total_per * $selling_price) / 100;
                    $discount = ($per_taka > $total_amt) ? $total_per . ' % ' . $promotion_id : $total_amt . ' TK ' . $promotion_id;
                }
            }
            $p_batch=(isset($data['batch_no'])?$data['batch_no']:'');
            $promoArray=array(
                'product_id'=>$product[0]['id_product'],
                'store_id'=>$store_id,
                'batch_no'=>$p_batch,


            );
            $promotionsProduct = $this->sales_model->get_promotion_product($promoArray);
            if($promotionsProduct && ($discount_amt==0||$discount_per==0)){
                $promotion_id =$promotionsProduct[0]['promotion_id'];
                $discount_per=$promotionsProduct[0]['discount_rate'];
                $total_per=$promotionsProduct[0]['discount_rate'];
                $discount_amt=$promotionsProduct[0]['discount_amount'];
                $total_amt =$promotionsProduct[0]['discount_amount'];
                if (($total_per != 0) || ($total_amt != 0)) {
                    //$per_taka = ($total_per * $selling_price) / 100;
                    $discount = $total_per . ' % ' . $promotion_id;
                }
            }

            
            echo json_encode(array('status' => 1,'data' => $product, 'batch' => $batch_new, 'discount' => $discount, 'def_vat' => $vat[0]['param_val']));
        } else {
            echo json_encode(array('status' => 3, 'message' => 'No Product Found')); 
        }
    }
//    function get_product_discount($brand,$cat,$subcat,$selling_price){
//
//
//    }
    public function check_batch_product()
    {
        $id_product = $this->input->post('product_id');
        $batch_no = $this->input->post('batch_no');
        $store_id = $this->input->post('store_id');
        $data = array(
            'id_product' => $id_product,
            'batch_no' => $batch_no,
            'store_id' => $store_id
        );
       // print_r($data);
        //exit();
//        $data['id_product'] = $stock_id;
//        $data['batch_no'] = $batch_no;
        //$product = $this->sales_model->getvalue_row_one('sale_product_view', 'id_stock,is_vatable,total_qty,selling_price_est,brand_id,cat_id,subcat_id', $data);
        $product = $this->sales_model->check_batch_product($data);
        // echo $stock_id.'=='.$batch_no;
        //echo $this->db->last_query();
        $promotions = $this->sales_model->getvalue_row('promotion_products_view', '*', array('store_id' => $store_id));
        $discount_per = $discount_amt = $total_per = $total_amt = $discount = 0;
        //$purchase_dis = array();
        $promotion_id = '';
        if (!empty($promotions)) {
            $brand = $product[0]['brand_id'];
            $cat = $product[0]['cat_id'];
            $subcat = $product[0]['subcat_id'];
            $selling_price = $product[0]['selling_price_est'];
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
                // if ($promotion->type_id == 2) {
                //$purchase_dis[] = array('amount' => $promotion->min_purchase_amt, 'rate_per' => $promotion->discount_rate, 'rate_taka' => $promotion->discount_amount);
                //$purchase_dis[]=$promotion->min_purchase_amt;
                // }
            }
            if (($total_per != 0) || ($total_amt != 0)) {
                $per_taka = ($total_per * $selling_price) / 100;
                $discount = ($per_taka > $total_amt) ? $total_per . ' % ' . $promotion_id : $total_amt . ' TK ' . $promotion_id;
            }
        }
        $promoArray=array(
            'product_id'=>$id_product,
            'store_id'=>$store_id,
            'batch_no'=>$batch_no
        );
        $promotionsProduct = $this->sales_model->get_promotion_product($promoArray);
        if($promotionsProduct && ($discount_amt==0||$discount_per==0)){
            $promotion_id =$promotionsProduct[0]['promotion_id'];
            $discount_per=$promotionsProduct[0]['discount_rate'];
            $total_per=$promotionsProduct[0]['discount_rate'];
            $discount_amt=$promotionsProduct[0]['discount_amount'];
            $total_amt =$promotionsProduct[0]['discount_amount'];
            if (($total_per != 0) || ($total_amt != 0)) {
                //$per_taka = ($total_per * $selling_price) / 100;
                $discount = $total_per . ' % ' . $promotion_id;
            }

        }
        echo json_encode(array('data'=>$product,'discount'=>$discount));
    }

    public function total_purchase_discount()
    {
        $request = $_REQUEST['request'];
        $promotions = $this->sales_model->getvalue_row('promotion_products_view', '*', array('type_id' => 2));
        $discount_amount = $purchase_discount = $purchase_amount = $dis_amt = '';
        if ($promotions) {
            foreach ($promotions as $promotion) {
                $amount_rate = $promotion->min_purchase_amt;
                if ($request >= $amount_rate) {
                    if ($amount_rate > $discount_amount) {
                        $discount_amount = $amount_rate;
                        $purchase_discount = $promotion->discount_rate;
                        $purchase_amount = $promotion->discount_amount;
                    }
                }

            }
            if ($purchase_discount != '') {
                $dis_amt = ($purchase_discount * $request) / 100;
                //$dis_amt=$request
            }
            if ($purchase_amount != '') {
                $dis_amt = $purchase_amount;
            }
            if ($dis_amt != '') {
                $dis_amt = round($dis_amt, 2);
            }
        }
        echo json_encode(array('rate' => $purchase_discount, 'amount' => $dis_amt));
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

    public function get_products_auto_sales()
    {
        $request = $_REQUEST['request'];
        //$store_id = $_REQUEST['store_id'];
        $store_id = $this->session->userdata['login_info']['store_id'];
        $product_list = $this->sales_model->get_product_auto_sale($request, $store_id);
        $return = array();
        foreach ($product_list as $list) {
            $return[] = array(
                "label" => $list->product_name . '(' . $list->batch_no . ')' . $list->attribute_name,
                "value" => $list->id_product,
                "sell_price" => $list->selling_price_est,
                "product_code" => $list->product_code,
                "batch_no" => $list->batch_no

                // "is_unq_barcode" => $list->is_unq_barcode
            );
        }
        echo json_encode($return);
    }

    public function show_customer_for_sales()
    {
        $name = $this->input->post('customer_name');
        $products = $this->sales_model->get_customer_details_sale($name);
        echo json_encode($products);
    }

    public function sales_add()
    {
        //print_r($_POST);
        //exit();
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
        $discount_type = $this->input->post('discount_type');
        $total_price = $this->input->post('total_price');
        $pro_sale_id = $this->input->post('pro_sale_id');
        $store_name = $this->input->post('store_from');
        $p_store_id = $this->input->post('p_store_id');
        $station_id = $this->input->post('station_id');
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
        $customer_id = $this->input->post('customer_id');
        $paid_amt = $this->input->post('paid_amt');
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
        $invoice = time();
        $remit_point = $this->input->post('remit_point');
        $remit_taka = $this->input->post('remit_taka_val');
        $remit_val = (isset($remit_taka) && $remit_taka != '') ? $remit_taka : 0;
        $this->db->query("CALL temp_sales_table()");
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
            if($p_store_id[$i]!=$store_name){
                echo 'error';
                exit();
            }
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
            $discount_amt = 0;
            $chk_dis = $discount[$i];
            if ($chk_dis != '') {
                if ($discount_type[$i] == 'TK') {
                    $discount_amt = $discount[$i];
                } else {
                    $discount_rate = $discount[$i];
                    $discount_amt = ($discount[$i] * $unit_price[$i]) / 100;
                }
            }
            $product['discount_rate'] = $discount_rate;
            $product['discount_amt'] = $discount_amt * $qty[$i];
            $product['vat_rate'] = $def_vat[$i];
            $product['vat_amt'] = $def_vat_amt[$i];
            $details = $this->common_model->commonInsertSTP('tmp_sale_details', $product);
            if (((int)$pro_sale_id[$i]) != '') {
                $pro_promotion = array();
                $pro_promotion['product_id'] = $pro_id[$i];
                $pro_promotion['stock_id'] = $id_stock[$i];
                $pro_promotion['promotion_id'] = $pro_sale_id[$i];
                $pro_promotion['promotion_type_id'] = 1;
                $pro_promotion['discount_rate'] = $discount_rate;
                $pro_promotion['discount_amt'] = $discount_amt;
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
        $ord_pro_id = $this->input->post('ord_pro_id');
        $ord_id_t = $this->input->post('order_id');
        $order_id = (isset($ord_id_t)) ? $ord_id_t : '0';
        $sales_person = $this->input->post('sales_person');
        $ord_sale_qty = $this->input->post('ord_sale_qty');
        $order_status = 3;
        $count_ord_prd=($ord_pro_id!='')?count($ord_pro_id):0;
        for ($k = 0; $k < $count_ord_prd; $k++) {
            if (!in_array($ord_pro_id[$k], $pro_id)) {
                $order_status = 2;
            }
            $ord_data = array();
            $ord_data['product_id'] = $ord_pro_id[$k];
            $ord_data['sale_qty'] = $ord_sale_qty[$k];
            $this->common_model->commonInsert('tmp_order_details', $ord_data);
        }

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
        $cash = $this->input->post('cash');
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
        $order_paid = $this->input->post('order_paid_amount');
        if ($order_paid > 0) {
            $transaction_payment['account_id'] = $this->input->post('order_account_id');
            $transaction_payment['payment_method_id'] = 5;
            $transaction_payment['amount'] = $order_paid;
            $transaction_payment_d = $this->common_model->commonInsertSTP('tmp_sale_transaction_payments', $transaction_payment);
            $saleData['order_pay'] = $order_paid;
        }
        $card_payment = $this->input->post('card_payment');
        if (!empty($card_payment)) {
            $bank_name = $this->input->post('bank_name');
            $transaction_payment = array();
            $transaction_payment['account_id'] = explode("@", $bank_name)[1];
            $transaction_payment['payment_method_id'] = 2;
            $transaction_payment['amount'] = $card_payment;
            $transaction_payment['ref_acc_no'] = $this->input->post('card_number');
            $transaction_payment['ref_bank_id'] = explode("@", $bank_name)[0];
            $transaction_payment['ref_card_id'] = $this->input->post('card_type');
            $transaction_payment_c = $this->common_model->commonInsertSTP('tmp_sale_transaction_payments', $transaction_payment);
            if ($transaction_payment_c) {
                //$this->common_model->updAccCurrBalance(explode("@", $bank_name)[1], $card_payment, 1);
            }
            $saleData['cart_pay'] = $card_payment;
        }
        $mob_bank_name = $this->input->post('mob_bank_name');
        $mobile_amount = $this->input->post('mobile_amount');
        if (!empty($mobile_amount)) {
            $transaction_payment = array();
            $transaction_payment['account_id'] = explode("@", $mob_bank_name)[1];
            $transaction_payment['payment_method_id'] = 3;
            $transaction_payment['amount'] = $mobile_amount;
            $transaction_payment['ref_acc_no'] = $this->input->post('mob_acc_no');
            $transaction_payment['ref_bank_id'] = explode("@", $mob_bank_name)[0];
            $transaction_payment['ref_trx_no'] = $this->input->post('transaction_no');
            $transaction_payment_e = $this->common_model->commonInsertSTP('tmp_sale_transaction_payments', $transaction_payment);
            if ($transaction_payment_e) {
                // $this->common_model->updAccCurrBalance(explode("@", $mob_bank_name)[1], $mobile_amount, 1);
            }
            $saleData['mobile_pay'] = $mobile_amount;
        }
        $trx_no = $this->auto_increment->getAutoIncKey('TRANSACTION', 'sale_transactions');
        $uid = $this->session->userdata['login_info']['id_user_i90'];
        if ($cart_total > 0) {
            $dataSale = "'" . $invoice . "','" . $store_name . "','" . $station_id . "','" . $customer_id . "','" . $to_point . "','" . $trx_no . "','" . $cart_total
                . "','" . $total_discount . "','" . $grand_total . "','" . $paid_amt_array[0] . "','" . $remit_val . "','" . $paid_amt_array[1] . "','" . $paid_amt_array[2]
                . "','" . date('Y-m-d H:i:s') . "','" . $uid . "','" . $note . "','" . $sales_person . "','" . $order_id . "','" . $order_status;
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
                $saleData['products'] = $this->sales_model->getvalue_sale_details($query_res[0]['sale_d']);
                $saleData['customer_name'] = $this->input->post('customer_name');
                $saleData['customer_code'] = $customer_code;
                $balance= $this->commonmodel->get_customer_balance($customer_id,$this->session->userdata['login_info']['store_id']);
                $saleData['customer_balance'] = $balance[0]['total_due'];
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
                $configs = $this->commonmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
                $sms_config = $this->commonmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' =>9));
                $customerArray[]=array(
                    'name'=> $this->input->post('customer_id'),
                    'phone'=>$this->input->post('customer_phone')
                );
                if($configs[0]->param_val>0 && $sms_config[0]->sms_send ==1){
                    $smsArray['sms_count']=1;
                    $smsArray['unit_price']=$configs[0]->utilized_val;
                    $smsArray['sms_type']=9;
                    $smsArray['cus_data']=$customerArray;
                    $msgarray=set_sms_send($smsArray);
                    //print_r($msgarray); 
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

    public function hold_sale_add()
    {
        $date = time();
        $stock_id = $this->input->post('stock_id');
        $customer_id = $this->input->post('customer_id');
        $pro_id = $this->input->post('pro_id');
        $qty = $this->input->post('qty');
        for ($i = 0; $i < count($stock_id); $i++) {
            // `invoice_no``store_id` `station_id` `customer_id` `stock_id` `product_id` `qty` `qty``uid_add`
            $product = array();
            $product['invoice_no'] = $date;
            $product['stock_id'] = $stock_id[$i];
            $product['station_id'] = $this->input->post('station_id');
            $product['store_id'] = $this->input->post('store_from');
            $product['customer_id'] = $customer_id;
            $product['product_id'] = $pro_id[$i];
            $product['qty'] = $qty[$i];
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
        $html .= '<table id = "mytable" class="table table-bordred table-striped" >';
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
            $html .= '<td> ' . $data->customer_id . ' </td>';
            $html .= '<td> ' . $data->dtt_add . ' </td>';
            $html .= '<td>  <a href="' . base_url() . 'sales?restore=' . $data->invoice_no . '" class="btn btn-primary">Restore</a></td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        echo $html;
    }

    public function show_agent_staff_list()
    {
        $id = $this->input->post('id');
        //echo $id;
        //$id=1 staff
        $html = '';
        if ($id == 2) {
            $agents = $this->common_model->getvalue_row('agents', 'id_agent,agent_name', array('status_id' => 1));
            $html .= '<div class="col-md-4">';
            $html .= '<div class="form-group row">';
            $html .= '<label class="col-sm-12 col-form-label" for="">' . lang('agent-name') . '<span class="req">*</span></label>';
            $html .= '<div class="col-sm-12">';
            $html .= '<select class="form-control" id="agent_name" onchange="setDelPerson(this)" name="agent_name">';
            $html .= '<option value="0" selected>' . lang('select_one') . '</option>';
            if (!empty($agents)) {
                foreach ($agents as $agent) {
                    $html .= '<option value="' . $agent->id_agent . '@' . $agent->agent_name . '">' . $agent->agent_name . '</option>';
                }
            }
            $html .= '</select>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        $html .= '<div class="col-md-4">';
        $html .= '<div class="form-group row">';
        $html .= '<label class="col-sm-12 col-form-label" for="">' . lang('delivery_person') . '</label>';
        $html .= '<div class="col-sm-12">';
        $html .= '<select class="form-control" id="delivery_person1" name="delivery_person1">';
        $html .= '<option value="0" selected>' . lang('select_one') . '</option>';
        if ($id == 1) {
            $staffs = $this->sales_model->delivety_person_staff_list();
            if (!empty($staffs)) {
                foreach ($staffs as $staff) {
                    $html .= '<option value="' . $staff['id_delivery_person'] . '@' . $staff['person_name'] . '">' . $staff['person_name'] . '</option>';
                }
            }
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-4">';
        $html .= '<div class="form-group row">';
        $html .= '<label class="col-sm-12 col-form-label" for="">' . lang('service_name') . '<span class="req">*</span></label>';
        $html .= '<div class="col-sm-12">';
        $html .= '<select class="form-control" onchange="setServiceRange(this)"  id="service_name" name="service_name">';
        $html .= '<option value="0" selected>' . lang('select_one') . '</option>';
        if ($id == 1) {
            $costs = $this->common_model->getvalue_row('delivery_costs', 'id_delivery_cost,delivery_name', array('status_id' => 1, 'type_id' => $id));
            if (!empty($costs)) {
                foreach ($costs as $cost) {
                    $html .= '<option value="' . $cost->id_delivery_cost . '@' . $cost->delivery_name . '">' . $cost->delivery_name . '</option>';
                }
            }
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-4">';
        $html .= '<div class="form-group row">';
        $html .= '<label class="col-sm-12 col-form-label" for="">' . lang('service_range') . '<span class="req">*</span></label>';
        $html .= '<div class="col-sm-12">';
        $html .= '<select class="form-control" onchange="setServicePrice(this)" id="service_range" name="service_range">';
        $html .= '<option value="0" selected>' . lang('select_one') . '</option>';
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-4">';
        $html .= '<div class="form-group row">';
        $html .= '<label class="col-sm-12 col-form-label" for="">' . lang('service_price') . '<span class="req">*</span></label>';
        $html .= '<div class="col-sm-6">';
        $html .= '<input class="form-control" type="text" id="service_price" name="service_price">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-4">';
        $html .= '<div class="form-group row">';
        $html .= '<label class="col-sm-12 col-form-label" for="">' . lang('paid_amount') . '</label>';
        $html .= '<div class="col-sm-6">';
        $html .= '<input class="form-control" type="text" id="paid_amount" name="paid_amount">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-4">';
        $html .= '<div class="form-group row">';
        $html .= '<label class="col-sm-12 col-form-label" for="">' . lang('cod_charge') . '</label>';
        $html .= '<div class="col-sm-12">';
        $html .= '<input class="form-control" type="text" id="cod" name="cod">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-4">';
        $html .= '<div class="form-group row">';
        $html .= '<label class="col-sm-12 col-form-label" for="">' . lang('accounts') . '<span class="req">*</span></label>';
        $html .= '<div class="col-sm-12">';
        $html .= '<select class="form-control" onchange="checkAccounts(this)" id="service_accounts" name="service_accounts">';
        $html .= '<option value="0" selected>' . lang('select_one') . '</option>';
        $accounts = $this->sales_model->listAccounts($this->session->userdata['login_info']['store_ids']);
        if (!empty($accounts)) {
            foreach ($accounts as $account) :
                $ac_name = !empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name'];
                $html .= '<option actp="' . $account['acc_type'] . '" value="' . $account['acc_id'] . '@' . $ac_name . '">' . $ac_name . '</option>';
            endforeach;
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div id="ref_trx_no"></div>';
        echo $html;
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
        $address_id = $this->input->post('address_id');
        $customers = $this->sales_model->get_customer_address($id);
        //if($customers){
        $data['posts'] = $customers;
        $data['address_id'] = $address_id;
        $this->load->view('sales/customer_address', $data);
        // }else{
        // echo 1;
        // }

        // $html = '';
    }

    public function customer_address_add()
    {
        $id = $this->input->post('id');
        $data['id'] = $id + 1;
        $data['city_list'] = $this->sales_model->getvalue_row('loc_cities', 'id_city,city_name_en', array());
        $data['division_list'] = $this->sales_model->getvalue_row('loc_divisions', 'id_division,division_name_en', array());
        $this->load->view('sales/add_customer_address', $data);
    }

    public function order_sale_data()
    {

        $order_id = $_REQUEST['order'];
        $data['orders'] = $this->sales_model->getvalue_row_one('orders', '*', array('id_order' => $order_id, 'status_id!=' => 3));
        if ($data['orders']) {
            $this->load->model('order_model');
            $data['orderDetails'] = $this->order_model->orderDetailsById($order_id);
            $data['orderPayments'] = $this->order_model->orderPaymentById($order_id);
            return $data;
        }
        return false;
    }


}
