<?php
include('header.php');
$pointEarnRate = (!empty($point_earn) && isset($point_earn[0]['param_val'])) ? (float)$point_earn[0]['param_val'] : 0;
$pointRedeemRate = (!empty($point_remit) && isset($point_remit[0]['param_val'])) ? (float)$point_remit[0]['param_val'] : 0;
$hasCustomer = (isset($customer_d) && $customer_d);
$customerPointsValue = $hasCustomer ? (float)$customer_d[0]['points'] : 0;
$displayCustomerPoints = $hasCustomer ? $customer_d[0]['points'] : '0';
$pointsFieldValue = $hasCustomer ? $customer_d[0]['points'] : '';
$showRedeemButton = ($hasCustomer && $customerPointsValue > 0 && $pointRedeemRate > 0);
?>
<div class="panel panel-default" style="background:#e6ffe3;">
    <div class="panel-body">
        <div class="row">
            <!--Body Left------>
            <div class="col-sm-12 col-md-8 sidebar">
                <div class="card side-card-bg">
                    <div class="card-header">
                        <?php 
                        $configs = json_decode($sales_configs[0]->param_val);
                        ?>
                        <input type="hidden" name="config_round" id="config_round" value="<?= $configs->round;?>">
                        <input type="hidden" name="config_customer" id="config_customer" value="<?= $configs->empty_customer;?>">
                        <form role="search" id="add_product_to_cart">
                            <div class="md-form mb-3">
                                <label class="open-search" for="open-search">
                                   <i class="fas fa-search"></i>
                                   <div class="search">
                                       <button class="button-search"><i class="fas fa-search"></i></button>
                                       <input id="product_name" name="product_name" type="text" placeholder="Search Product...." class="input-search" />
                                   </div>
                                </label>
                                <input type="hidden" id="src_product_id" name="src_product_id">
                                <input type="hidden" id="src_batch_no" name="src_batch_no">
                                <input type="hidden" id="count_row" name="count_row" value="1">
                                <input type="hidden" name="config_price" id="config_price" value="<?= $configs->price;?>">
                                <input type="hidden" name="config_discount" id="config_discount" value="<?= $configs->discount;?>">
                                <input type="hidden" name="discount_invoice" id="discount_invoice" value="<?= $configs->discount_invoice;?>">
                            </div>
                        </form>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input id="src_sales_person" type="text" placeholder="Search Sales Person...." class="form-control" />
                                        <input type="hidden" name="sales_person" id="sales_person">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php 
                                        $name='';
                                        $cus_id='';
                                        $balance='';
                                        $phone='';
                                        if (isset($customer_d) && $customer_d) {
                                            $cus_id=$customer_d[0]['id_customer'];
                                            $balance=$customer_d[0]['balance'];
                                            $phone=$customer_d[0]['phone'];
                                            $name=$customer_d[0]['full_name'].' ('.$customer_d[0]['phone'].')';
                                        }
                                        ?>
                                        <input id="src_customer_name" type="text" placeholder="Search Customer...." class="form-control" value="<?= $name?>" />
                                   </div>
                               </div>
                            </div>
                            <div class="col-md-3" style="height:75px;">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <span class="material-icons"   style="position: relative; top: 1px; background: #fff; width: 50px; height: 36px; border: 1px solid #fff; text-align: center; line-height: 1.4; border-radius:4px;">call</span>
                                        <span id="show_customer_phone" style="color: #fff; font-size: 18px; position: relative;top: -3px;left: 10px;"> <?= $phone?></span><input type="hidden" name="src_customer_balance" id="src_customer_balance" value="<?= $balance?>"><br>
                                        <div class="cus-balance"><?php echo set_currency()?></div>
                                        <span id="show_customer_balance" style="position: relative; top: -29px; left: 64px; font-size: 18px;color: #fff;">  <?= $balance?>  </span><br>
                                        <div class="customer-points" style="position: relative; top: -23px; left: 64px; font-size: 16px; color: #fff;">
                                            <span>Points: </span>
                                            <span id="show_customer_points"><?= $displayCustomerPoints ?></span>
                                            <span id="remit_val">
                                                <?php if ($showRedeemButton): ?>
                                                    <button type="button" class="btn btn-sm btn-warning ml-2" data-toggle="modal" data-target="#pointDetails" onclick="show_points(<?= $customerPointsValue ?>)">Redeem</button>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                   </div>
                                </div>
                            </div>
                            <div class="col-md-2 pl-md-2" >
                            <button class="btn btn-sm bg-light w-100" data-toggle="modal"  data-target="#customer_add" style="font-size:17px; position:relative; left:100px"> 
                            <span class="material-icons" style="position:relative;top:5px;">add_circle</span> Add Customer
                                </button>
                            </div>
                        </div>
                    </div>
                    <form name="cart_data" id="cart_data" method="post">
                        <input type="hidden" name="src_customer_id" readonly="" id="src_customer_id" value="<?= $cus_id?>">
                        <div class="card-body scroll">
                            <div class="row">
                                <div class="col temp-product">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="addSection">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Attributes</th>
                                                    <th>Batch</th>
                                                    <th>Stock</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Dis(%)</th>
                                                    <th>Dis(<?=set_currency()?>)</th>
                                                    <th>Vat(%)</th>
                                                    <th>Vat(<?=set_currency()?>)</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($request_key)) {
                                                    echo $request_key;
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr style="text-transform: uppercase; position: -webkit-sticky;
                                                position: sticky; bottom: 0; background: #009b79; color: #fff; z-index:4;">
                                                    <th colspan="4">Total: <span style="padding-right: 4px;" id="total_item_show">0</span>items</th>
                                                    <th id="total_qty_show"></th>
                                                    <th id="total_unit_price_show"></th>
                                                    <th> &nbsp;</th>
                                                    <th id="total_discount_show"></th>
                                                    <th> &nbsp;</th>
                                                    <th id="total_vat_show"></th>
                                                    <th id="total_price_show"></th>
                                                    <th> 
                                                        <input type="hidden" name="original_product_price" id="original_product_price">
                                                        <input type="hidden" name="cart_total_price" id="cart_total_price">
                                                        <?php 
                                                        $promo='';
                                                        $promo_id='';
                                                        $min_purchase=0;
                                                        if($purchase_promotion){
                                                            $rate=($purchase_promotion[0]['discount_rate']!='')?$purchase_promotion[0]['discount_rate']:'0';
                                                            $amount=($purchase_promotion[0]['discount_amount']!='')?$purchase_promotion[0]['discount_amount']:'0';
                                                            $promo=$rate.'&&'.$amount;
                                                            $promo_id=$purchase_promotion[0]['discount_rate'];
                                                            $min_purchase=$purchase_promotion[0]['min_purchase_amt'];
                                                        }
                                                        ?>
                                                        <input type="hidden" name="total_pur_promo_val" id="total_pur_promo_val" value="<?= $promo?>">
                                                        <input type="hidden" name="total_pur_promo_id" id="total_pur_promo_id" value="<?= $promo_id?>">
                                                        <input type="hidden" name="min_purchase_amt" id="min_purchase_amt" value="<?= $min_purchase?>">
                                                        <input type="hidden" name="tmp_customer_dis_rate" id="tmp_customer_dis_rate" value="">
                                                        <input type="hidden" name="tmp_customer_dis_target_sale" id="tmp_customer_dis_target_sale" value="">
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" name="replace_data" id="replace_data" value="">
                                <div id="replace_product_data"></div>
                            </div>
                            <div class="row">
                                <div id="show_delivery"></div>
                                <div class="col-sm-6">
                                    <label class="col-lg-12">Note:</label>
                                    <div class="col-lg-12">
                                        <textarea name="note" id="note" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--Body Right------>
            <div class="col-sm-12 col-md-4 body-right">
                <div class="card" style="height: 90vh;background:#e6ffe3;border:none;">
                    <form action="" id="submit_sales_form" method="post">
                        <input type="hidden" name="points" id="points" value="<?= $pointsFieldValue === '' ? '' : html_escape($pointsFieldValue) ?>">
                        <input type="hidden" name="per_point_balance" id="per_point_balance" value="<?= html_escape($pointEarnRate) ?>">
                        <input type="hidden" name="remit_point" id="remit_point" value="">
                        <input type="hidden" name="remit_taka_val" id="remit_taka_val" value="">
                        <input type="hidden" name="point_per_amount" id="point_per_amount" value="<?= html_escape($pointRedeemRate) ?>">
                        <div class="card-body body-right-div" style="padding-top:0px; position: relative;background:#e6ffe3;" id="bodyContent">
                            <div class="cost">
                                <h2>Cart Total : <span id="cart_total">00</span> <?= set_currency()?></h2>

                                <table class="saleOverview" style="margin-left:10px;">
                                    <tbody id="all_discount">
                                        <?php  
                                        if($configs->round>0){
                                            ?>
                                            <tr>
                                                <td>Round</td>
                                                <td id="con_round">00</td>
                                            </tr>
                                            <?php 
                                        }
                                        ?>
                                        <?php
                                        if (isset($customer_d) && $customer_d) {
                                            if($customer_d[0]['discount']>0){
                                                echo '<tr id="show_customer_discount_div"> <td>Cus. Dis. <b id="cus_dis">'.floatVal($customer_d[0]['discount']).'</b>% <label class="switch"><input type="checkbox" name="ck_cus_dis" id="ck_cus_dis" checked="" onclick="discount_chk()"><span class="slider round"></span></label> </td><td id="cus_dis_total">0</td> </tr>';
                                            }
                                        }    
                                        ?>
                                        
                                        <tr class="shtr">
                                            <td>Total</td>
                                            <td id="grand_total">00</td>
                                        </tr>
                                        <tr>
                                            <td>Paid (<span id="paid_div"></span>)</td>
                                            <td id="paid_amount">00</td>
                                        </tr>
                                        <tr id="remit_summary" style="display:none;">
                                            <td>Remit</td>
                                            <td><span id="remit_text">0.00</span></td>
                                        </tr>
                                        <?php  
                                        if($configs->round==0){
                                            ?>
                                            <tr>
                                                <td>Round <label class="switch round-position" >
                                                                <input class="amount_round" type="checkbox" id="round_check">
                                                                <span class="slider round"></span>
                                                            </label></td>
                                                <td id="round">00</td>
                                            </tr>
                                            <?php 
                                        }
                                        ?>
                                        <tr>
                                            <td>Total Due :</td>
                                            <td id="tot_due_amount">00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="payment_option">
                                <h4>PAYMENT DETAILS</h4>
                                <div class="PaymentTab tabs">
                                    <ul id="myTabs" class="nav nav-tabs" role="tablist" data-tabs="tabs">
                                        <li class="nav-item"><a class="nav-link active" href="#CashPay" data-toggle="tab" role="tab" class="paymentTab" id="payCash" onclick="clear_payment()">Cash</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#CardPay" data-toggle="tab" role="tab" class="paymentTab" id="payCard" onclick="clear_payment()">Card</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#MobilePay" data-toggle="tab" role="tab" class="paymentTab" id="payMob" onclick="clear_payment()">M.BANK</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#Multiple" data-toggle="tab" role="tab" onclick="multiple()">Multiple</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="CashPay">
                                            <div class="payment_opt cash_pay">
                                                <div class="uk-grid-small" uk-grid>
                                                    <div class="uk-width-1-1">
                                                        <input class="uk-input Number payment" name="cash" id="cash" type="text" placeholder="Cash Amount">
                                                    </div>
                                                    <div class="uk-width-1-2">
                                                        <input class="uk-input Number" name="cash_paid" id="cash_paid" type="text" placeholder="Cash Paid">
                                                    </div>
                                                    <div class="uk-width-1-2">
                                                        <input class="uk-input" name="change_amt" id="change_amt" type="text" placeholder="Change Amount" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="CardPay">
                                            <div class="payment_opt card_pay">
                                                <div class="uk-grid-small" uk-grid>
                                                    <div class="uk-width-1-2@s">
                                                        <input class="uk-input Number payment" type="text" placeholder="Enter Amount" name="card_payment" id="card_payment">
                                                    </div>
                                                    <div class="uk-width-1-2@s">
                                                        <input class="uk-input" type="text" placeholder="Card Number" name="card_number" id="card_number">
                                                    </div>
                                                    <div class="uk-width-1-2@s uk-grid-margin">
                                                        <select class="uk-select" name="card_type" id="card_type">
                                                            <option value="0" selected>Card Type</option>
                                                            <?php
                                                            foreach ($card_type as $card) {
                                                                echo '<option value="' . $card->id_card_type . '">' . $card->card_name . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="uk-width-1-2@s uk-grid-margin">
                                                        <select class="uk-select" name="bank_name" id="bank_name">
                                                            <option value="0" selected>Select Bank</option>
                                                            <?php
                                                            foreach ($banks as $bank) {
                                                                if ($bank['acc_type_id'] == 1) {
                                                                    echo '<option value="' . $bank['bank_id'] . '@' . $bank['id_account'] . '">' . $bank['bank_name'] . '(' . $bank['account_no'] . ')' . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="MobilePay">
                                            <div class="uk-grid-small" uk-grid>

                                                <div class="uk-width-1-2@s">
                                                    <input class="uk-input Number payment" type="text" name="mobile_amount" id="mobile_amount" placeholder="Mobile Amount">
                                                </div>
                                                <div class="uk-width-1-2@s">
                                                    <select class="uk-select" id="mob_bank_name" name="mob_bank_name">
                                                        <option value="0" selected>Mobile Bank</option>
                                                        <?php
                                                        foreach ($banks as $bank) {
                                                            if ($bank['acc_type_id'] == 3) {
                                                                echo '<option value="' . $bank['bank_id'] . '@' . $bank['id_account'] . '">' . $bank['bank_name'] . '(' . $bank['account_no'] . ')' . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="uk-width-1-2@s">
                                                    <input class="uk-input" type="text" placeholder="Transaction No" name="transaction_no" id="transaction_no">
                                                </div>
                                                <div class="uk-width-1-2@s">
                                                    <input class="uk-input" type="text" placeholder="Receiver No" name="mob_acc_no" id="mob_acc_no">
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="Multiple">
                                            <div class="uk-grid-small" uk-grid>
                                                <div class="uk-width-1-1">
                                                    <span id="multiple_payment_error" class="error"></span>
                                                    <input type="hidden" name="multiple_payment" id="multiple_payment" value="">
                                                    <div id="show_multiple_payment"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>        
                            </div>
                            <div class="modal fade" id="MultiplePay" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Multiple Payment</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-striped table-responsive-stack" id="tableOne">
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <div class="form-group input-group-sm">
                                                                <label for="form_name">Enter Cash Amount</label>
                                                                <input type="text" class="form-control input-sm Number m_payment" placeholder="Enter Amount" id="m_cash" name="m_cash">
                                                            </div>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>

                                                            <div class="form-group input-group-sm">
                                                                <label for="form_name">Card Number</label>
                                                                <input type="text" class="form-control input-sm Number m_payment" placeholder="Card Number" id="m_card_number" name="m_card_number">
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <label for="">Select Card & Bank</label>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="input-group">
                                                                        <select class="custom-select custom-select-sm" name="m_card_type" id="m_card_type">
                                                                            <option value="0" selected>Card Type</option>
                                                                            <?php
                                                                            foreach ($card_type as $card){
                                                                                echo '<option value="' . $card->id_card_type . '">' . $card->card_name . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="input-group">
                                                                        <select class="custom-select custom-select-sm" name="m_bank_name" id="m_bank_name">
                                                                            <option value="0" selected>Select Bank</option>
                                                                            <?php
                                                                            foreach ($banks as $bank) {
                                                                                if ($bank['acc_type_id'] == 1) {
                                                                                    echo '<option value="' . $bank['bank_id'] . '@' . $bank['id_account'] . '">' . $bank['bank_name'] . '(' . $bank['account_no'] . ')' . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group input-group-sm">
                                                                <label for="form_name">Card Amount</label>
                                                                <input type="text" class="form-control Number m_payment" placeholder="Enter Amount" id="m_card_payment" name="m_card_payment">
                                                            </div>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>

                                                            <div class="form-group input-group-sm">
                                                                <label for="form_name">Transection ID</label>
                                                                <input type="text" class="form-control" placeholder="Transaction Id" name="m_transaction_no" id="m_transaction_no">
                                                                <input type="hidden" name="m_mob_acc_no" id="m_mob_acc_no" value="">
                                                            </div>

                                                        </td>
                                                        <td>

                                                            <div class="input-group input-group-sm">
                                                                <label for="">Mobile Banking</label>
                                                                <div class="input-group">
                                                                    <select class="custom-select custom-select-sm" id="m_mob_bank_name" name="m_mob_bank_name">
                                                                        <option value="0" selected>Select Mobile Bank</option>
                                                                        <?php
                                                                        foreach ($banks as $bank) {
                                                                            if ($bank['acc_type_id'] == 3) {
                                                                                echo '<option value="' . $bank['bank_id'] . '@' . $bank['id_account'] . '">' . $bank['bank_name'] . '(' . $bank['account_no'] . ')' . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>

                                                            <div class="form-group input-group-sm">
                                                                <label for="form_name">Mobile Amount</label>
                                                                <input type="text" class="form-control Number m_payment" placeholder="Enter Amount" id="m_mobile_amount" name="m_mobile_amount">
                                                            </div>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <div class="multiple_total">
                                                                <ul>
                                                                    <li>Total: <span id="m_total"></span></li>
                                                                    <li>Paid: <span id="m_paid_total"></span></li>
                                                                    <li>Due: <span id="m_due"></span></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning" type="button" data-dismiss="modal" onclick="enablePayment()">Cancel</button>
                                            <button type="button" class="btn btn-success" onclick="add_multiple_payment()" >Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <!-- <button type="submit" class="saleBtn submit_sale">Sale Now <i class="fas fa-arrow-right" value="sale"></i></button> -->
                        <div class="row mt-3">

                            <div class="col-md-4 mb-2 mb-md-0">
                                <button class="btn btn-sm btn-success btn-block submit_sale" title="" id="sale" style="height: 60px; background: #009b79;font-size: 19px; text-transform: uppercase;">Sale Now</button>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <button class="btn btn-sm btn-success btn-block submit_sale" title="" id="print" style="height: 60px; background: #025e4a;font-size: 19px; text-transform: uppercase;" >Sale & Print</button>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <button class="btn btn-sm btn-info btn-block submit_sale" title="" id="a4print" style="height: 60px; background: #024032;font-size: 19px; text-transform: uppercase;">A4 Print</button>
                            </div>
                        </div>
                        <div class="row d-none">
                            <div class="col-12 text-center">
                                <span class="">Sale Processing...</span>
                            </div>
                        </div>
                            <!-- <div class="row">
                                <div id="sub_check_pro" class="">
                                    <button type="submit" class="saleBtn submit_sale">A4 Print <i class="fas fa-arrow-right" value="a4print"></i></button>
                                    <button type="submit" class="saleBtn submit_sale">Sale & Print<i class="fas fa-arrow-right" value="print"></i></button>
                                    <button type="submit" class="saleBtn submit_sale">Sale Now <i class="fas fa-arrow-right" value="sale"></i></button>
                                </div>
                                <div id="sub_check_w" style="display: none;text-align: center">
                                    <button type="text" class="btn btn-primary btn-md">Sale Processing...</button>
                                </div>
                           </div> -->
                        </div>
                    </form>
                    <div class="card-footer responsiveCssForCp" style="background:#e6ffe3;border:none;">
                        
                       <div class="row mt-3">
                            <div class="col-md-2 mb-2 mb-md-0">
                                <button class="sales-tool-discount" uk-toggle data-target="#Discount" title="Discount"><span class="material-icons">percent</span></button>
                            </div>
                            <div class="col-md-2 mb-2 mb-md-0">
                                <button class="sales-tool-pause" onclick="hold_sale()" title="Hold Sale"><span class="material-icons">pause_presentation</span></button>
                            </div>
                            <div class="col-md-2 mb-2 mb-md-0">
                                <button class="sales-tool-restore" data-toggle="modal"data-target="#restore_hold" title="Restore" onclick="restore_hold()"><span class="material-icons">settings_backup_restore</span></button>
                            </div>
                            <div class="col-md-2">
                                <button class="sales-tool-delivery" onclick="add_delivery()" title="Delivery Service"><span class="material-icons">local_shipping</span></button>
                            </div>
                            <div class="col-md-2">
                                <button class="sales-tool-replace" data-toggle="modal"data-target="#replaceSale" title="Sale Replace"><span class="material-icons">change_circle</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="showmessage" id="showMessage" style="display: none;"></div>
<div class="loading"  style="display: none;">
    <div class="loader"></div>
</div>
<div class="modal fade" id="pointDetails" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Redeem Points</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="redeem">
                    <h4>1 point = <?= set_currency($pointRedeemRate) ?></h4>
                    <div class="crnt-points">
                        Current Points: <span id="cur_pnt"></span>
                    </div>
                    <div class="remit-points">
                        Redeem points
                        <input class="Number" type="text" name="remit" id="remit">
                    </div>
                    <span class="error" id="remit_error" style="float: left;text-align: center;"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="add_remit_point()">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('sales/sale_customer_add');?>

<div id="replaceSale" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sale Replace</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row" role="search" id="return_to_cart">
                    <div class="col-md-8 col-sm-10">
                        <div class="form-group">
                            <input class="form-control" placeholder="Invoice No" type="text" id="invoice" name="invoice">
                            <span class="error" id="invoice_error"></span>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-2">
                        <button type="button" class="btn btn-primary right" onclick="invoiceProductList()"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
                <div class="row" id="resultInvoiceData">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div id="restore_hold" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Hold Sale List</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="restore_hold_data"></div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Delivery service --------------------------------------------------------->
<div id="deliveryAdd" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><?= lang('add_delivery_cost') ?></h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <?php echo form_open_multipart('', array('id' => 'delivery_info', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                <div class="controls">
                    <div class="row mb-2">
                        <div class="col-12">
                            <label class="col-sm-12 col-form-label" for=""><?= lang('delivery_type') ?><span class="text-denger">*</span></label>
                            <div class="input-group">
                                <select class="custom-select custom-select-sm" id="delivery_type" onchange="setAgentStaff(this)"
                                        name="delivery_type">
                                    <option value="0" selected><?= lang('select_one') ?></option>
                                    <option value="1@Staff"><?= lang('staff') ?></option>
                                    <option value="2@Agents"><?= lang('agents') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="order_sort_data"></div>
                <div id="customer_data"></div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" value="<?= lang('submit') ?>"> </button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- Modal for Discount --------------------------------------------------------->
<div id="Discount" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <fieldset class="uk-fieldset">
            <?php 
            $dis_div=($configs->discount_invoice==0)?'style="display: none;"':'';
            ?>
            <div class="uk-margin" <?= $dis_div?> >
                <label class=".uk-form-label" for="">Discount (%)</label>
                <input class="uk-input sp_discount Number" type="text" placeholder="Discount in %" name="percent" id="percent">
            </div>
            <div class="uk-margin" <?= $dis_div?>>
                <label class=".uk-form-label" for="">Discount Taka</label>
                <input class="uk-input sp_discount Number" type="text" placeholder="Discount in Taka" name="taka" id="taka">
            </div>

            <div class="uk-margin">
                <label class=".uk-form-label" for="">Card Promotion</label>
                <select class="uk-select" name="card_promotion" id="card_promotion">
                   <option value="0" selected >--Select One--</option>
                   <?php
                    if (!empty($card_promotions)) {
                        foreach ($card_promotions as $card) {
                            echo '<option value="' . $card->promotion_id . '@' . round($card->discount_rate) . '">' . $card->title . '</option>';
                        }
                    }
                    ?>
               </select>
           </div>
        </fieldset>
        <p class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Close</button>
            <button class="uk-button uk-button-primary" type="button" onclick="add_special_discount()">Ok</button>
        </p>
    </div>
</div>
<div id="SaleDetails" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Sale Invoice Details</h6>
            </div>
            <div class="modal-body">
                <div class="sale-view" id="sale_view">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="sale_print_tharmal()">Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"
                        onclick="window.location.replace('<?= base_url() ?>sales')">Close
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="emptyAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li id="alert_text">
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="emptyCustomer" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li id="customer_alert_text">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" onclick="confirmEmptyCustomer()"> Yes</button>
                <button type="button" class="btn btn-warning"
                        data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($request_key)) {
    ?>
    <script>
        $(document).ready(function () {
            var dis= $('#cus_dis').html();
            if ($.trim(dis)) {
                var total=0;
                $('input[name^="total_price"]').each(function () {
                    total = ($(this).val() * 1) + total;
                });
                var amt=(total*dis)/100;
                //$('#cus_dis_total').html(amt);
                 var id=$('#src_customer_id').val();
                checkCustomerDiscount(id);
            }
            totalCalculation();
        });
    </script>

    <?php
}
?>
<!--    JavaScipt-->
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>
<script src="<?= base_url()?>themes/sales/js/delivery_add.js"></script>
<script src="<?= base_url()?>themes/sales/js/uikit.min.js"></script>
<script src="<?= base_url()?>themes/sales/js/uikit-icons.min.js"></script>
<script src="<?= base_url()?>themes/sales/js/popper.min.js"></script>
<script src="<?= base_url()?>themes/sales/js/bootstrap.min.js"></script>
<script src="<?= base_url()?>themes/sales/js/custom.js"></script>
<script src="<?= base_url()?>themes/sales/js/bootstrap-select.min.js"></script>
</body>

</html>