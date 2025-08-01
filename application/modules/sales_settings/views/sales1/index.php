<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>

<div class="col-md-12">
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div>
<div id="full" class="content-i">
    <div class="content-box">

        <div class="row">
            <div class="col-md-8 md8">

                <div class="element-box full-box margin-0">
                    <input type="hidden" name="default_vat" id="default_vat" value="<?= $vat[0]['param_val'] ?>">
                    <div class="row">
                        <?php 
                        $configs = $this->commonmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
                        $sms_config = $this->commonmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 9));
                        if($configs[0]->param_val<1 && $sms_config[0]->sms_send ==1){
                            echo '<h3 class="error">'.lang('sms_balance_zero').'</h3>';
                        }
                        ?>
                        <form role="search" id="add_product_to_cart">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Select Search Type</label>
                                    <div class="col-sm-12">
                                        <div class="col-sm-4">
                                            <input id="ProductNameofCode" name="acc_type" value="Yes" type="radio"
                                                   checked>
                                            <label for="ProductNameofCode">Product Name/Code</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input id="BarCode" name="acc_type" value="No" type="radio">
                                            <label for="BarCode">Bar Code</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="sales-search">
                                    <div class="col-md-11 col-sm-10">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Search..." type="text"
                                                   id="product_name" class="product_name" name="product_name"
                                                   onkeyup="product_list_suggest(this);">
                                            <input type="hidden" name="product_id" id="product_id">
                                            <input type="hidden" name="batch_s" id="batch_s">
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-2">
                                        <button type="submit" class="btn btn-default right"><i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="error" style="font-weight: bold;font-size:16px;" id="product_name-error"></span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="element-box full-box bg-sale-menu">
                    <button class="btn btn-secondary button-bg1" onclick="hold_sale()">Hold Sale</button>
                    <button data-toggle="modal" data-target="#restore_hold" class="btn btn-secondary button-bg1"
                            onclick="restore_hold()">Sale Restore
                    </button>


                    <a href="<?= base_url() ?>sale-returns" class="btn btn-secondary button-bg2">Sell Return</a>
                    <button id="flip" class="btn btn-secondary button-bg4" type="button"><i
                                class="fa fa-chevron-left"></i></button>
                </div>
            </div>
            <div class="row">
                <form action="" class="sales-form" id="submit_sales_form" method="post">
                    <?php
                    // $store = ($this->session->userdata['login_info']['user_type_i92'] != 3) ? $this->session->userdata['login_info']['store_id'] : '';
                    ?>
                    <input type="hidden" id="store_from" name="store_from" value="<?= $store_name_p ?>">
                    <input type="hidden" id="station_id" name="station_id" value="<?= $station_name_p ?>">
                    <div class="col-md-8 sale-table md8">
                        <div class="col-md-12 bg">
                            <div class="table-responsive">
                                <table id="addSection" class="table table-bordred table-striped sales_table">
                                    <thead>
                                    <th>Product name</th>
                                    <th>Attr.</th>
                                    <th>Batch</th>
                                    <th>Stock</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Dis.</th>
                                    <th>Vat(%)
                                    <th>Total</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (isset($request_key)) {
                                        echo $request_key;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                        <th id="total_item_show"></th>
                                        <th colspan="3"></th>
                                        <th id="total_qty_show"></th>
                                        <th colspan="4"></th>
                                    </tfoot>

                                </table>

                            </div>
                            <div>
                                <button type="button" class="btn btn-primary" onclick="add_delivery()">Add Delivery
                                    Service
                                </button>
                            </div>
                            <div id="show_delivery"></div>
                        </div>
                        <div class="col-lg-6">
                            <label class="col-lg-12">Note:</label>
                            <div class="col-lg-12">
                                <textarea name="note" id="note" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 md4 pad-left-0 sale_option">

                        <div class="full-box element-box sale-fixed-top">
                            <div class="sale-ammount-detail">
                                <h6 class="element-header">Payment Summary</h6>
                                <div class="default_label"><strong>Items In Cart:</strong><span
                                            id="cart_total"> 00</span>&nbsp;
                                </div>
                                <div id="default_dis"></div>
                                <div id="all_discount">
                                    <?php
                                    if (isset($customer_d)) {
                                        echo '<div class="all-discount"><strong>Cus. Dis. <b id="cus_dis">' . number_format($customer_d[0]['discount'], 0) . '</b>%:<label class="switch"><input type="checkbox" name="ck_cus_dis" id="ck_cus_dis" checked onclick="cus_discount_chk()"><span class="slider round"></span></label></strong><span class="discount-ammount" id="cus_dis_total"> 00</span>&nbsp;</div>';
                                        //echo '<div class="all-discount">Cus. Dis. <b id="cus_dis">' . number_format($customer_d[0]['discount'], 0) . '</b>%:<span class="discount-ammount" id="cus_dis_total"> 00</span>&nbsp;TK</div>';
                                    }
                                    ?>
                                </div>
                                <div class="total"><strong>Total:</strong><span
                                            id="grand_total"> 00</span>&nbsp;<?= set_currency() ?></div>
                                <div class="ammount-due">
                                    <?php
                                    if (isset($ord)) {
                                        //if ($ord['orders'][0]['paid_amt'] != '') {
                                            echo '<p id="ord_paid_amt"><strong>Order Paid:</strong><span> <b id="order_paid_amount">' . $ord['orders'][0]['paid_amt'] . '</b></span></p>';
                                        //}
                                    }
                                    ?>
                                    <strong>Paid Amount:</strong><span> <b id="paid_amount">00</b></span>
                                    <p id="remit_text"></p>
                                    <strong>Round:
                                        <label class="switch round-position">
                                            <input class="amount_round" type="checkbox" id="round_check">
                                            <span class="slider round"></span>
                                        </label>
                                    </strong><span> <b id="round">00</b></span>
                                    <strong>Total Due:</strong><span> <b id="tot_due_amount">00</b></span>
                                </div>
                            </div>
                        </div>

                        <div class="full-box element-box bgc1" style="margin-top:0">
                            <div class="">
                                <div class="hrizn_title">
                                    Customer
                                </div>

                                <div class="sales-search-customar">
                                    <div class="col-md-12 pr0">
                                        <div class="col-md-12 margin-bottom-5">
                                            <select class="select2 col-md-12" style="float:left" data-live-search="true"
                                                    id="sales_person" name="sales_person">
                                                <option value="0" selected><?= lang("sales_person"); ?></option>
                                                <?php
                                                foreach ($salesPersons as $person) {
                                                    foreach ($this->config->item('sales_person') as $key => $val) :
                                                        if ($person['person_type'] == $key) {
                                                            $type = $val;
                                                        }
                                                    endforeach;
                                                    if (isset($ord) && ($ord['orders'][0]['sales_person_id'] != '')) {
                                                        $select = ($ord['orders'][0]['sales_person_id'] == $person['id_sales_person']) ? 'selected' : '';
                                                    }

                                                    echo '<option actp="' . $person['user_name'] . '" value="' . $person['id_sales_person'] . '"' . $select . '>' . $person['user_name'] . '(' . $type . ')' . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-2 pr0">
                                            <button class="btn btn-primary margin-right-5" style="float:left"
                                                    type="button"
                                                    data-toggle="modal" data-target="#customer_add"
                                                    onclick="addCustomer()">
                                                <i class="fa fa-plus"></i>
                                            </button>

                                        </div>
                                        <div class="col-md-10">
                                            <select class="select2 col-md-12" style="float:left" data-live-search="true"
                                                    id="customer" name="customer">
                                                <option value="0" selected><?= lang("select_customer"); ?></option>
                                                <?php
                                                $cus_id=(isset($customer_d))?$customer_d[0]['id_customer']:'';
                                                foreach ($customers as $customer) {
                                                    $select=($cus_id==$customer->id_customer)?'selected':'';
                                                    echo '<option actp="' . $customer->full_name . '" '.$select.' value="' . $customer->id_customer . '">' .$customer->customer_code.' '. $customer->full_name .$cus_id. '(' . $customer->phone . ')' . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12 col-sm-12 pr0">
                                            <div class="customar_info" id="show_customer_data">
                                                <?php
                                                if (isset($customer_d)) {
                                                    ?>
                                                    <div class="ci-info">
                                                        <span><?= $customer_d[0]['full_name'] ?></span>
                                                        <span>(<?= $customer_d[0]['phone'] ?>)</span>
                                                        <span class="gldn"><?= $customer_d[0]['type_name'] ?></span>
                                                    </div>
                                                    <div class="ci-point">
                                                        <span>Due Balance - <?= $customer_d[0]['balance'] ?></span>
                                                        <span>Point - <?= $customer_d[0]['points'] ?></span>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="cus_id" id="cus_id">
                                                <input type="hidden" name="c_phone" id="c_phone">
                                                <input type="hidden" name="points" id="points">
                                                <input type="hidden" name="balance" id="balance">
                                                <input type="hidden" name="per_point_balance" id="per_point_balance"
                                                       value="<?= $point_earn[0]['param_val'] ?>">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="full-box element-box bgc2" style="margin-top:0">
                            <div class="discout_header">
                                <div class="hrizn_title_discount">
                                    Discount
                                </div>
                                <div class="col-sm-12 pr0">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label pr0">Discount(%)</label>
                                            <div class="col-sm-7 pr0">
                                                <input class="form-control sp_discount Number" id="percent"
                                                       name="percent"
                                                       placeholder="(%)" type="text">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label pr0">Discount Taka</label>
                                            <div class="col-sm-7 pr0">
                                                <input class="form-control sp_discount Number" name="taka" id="taka"
                                                       placeholder="Discount Taka" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label pr0">Card Promotion</label>
                                            <div class="col-sm-7 pr0">

                                                <div class="row-fluid">
                                                    <select class="select2" data-live-search="true" id="card_promotion"
                                                            name="card_promotion" onchange="add_cart_discount(this)">
                                                        <option value="0" selected>
                                                            <?= lang("select_one"); ?>
                                                        </option>
                                                        <?php
                                                        if (!empty($card_promotions)) {
                                                            foreach ($card_promotions as $card) {
                                                                echo '<option value="' . $card->promotion_id . '@' . round($card->discount_rate) . '">' . $card->title . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="full-box element-box bgc3" style="margin-top:0px">

                            <div class="discout_header">
                                <div class="hrizn_title_payment">
                                    Payment
                                </div>

                                <div class="col-sm-12 pr0">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label pr0">Cash Payment</label>
                                            <div class="col-sm-7 pr0">
                                                <input class="form-control payment Number" placeholder="Cash"
                                                       type="text"
                                                       name="cash" id="cash">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label pr0">Cash Given</label>
                                            <div class="col-sm-7 pr0">
                                                <input class="form-control payment Number" placeholder="Cash Paid"
                                                       type="text"
                                                       name="cash_paid" id="cash_paid">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label pr0">Change Amt.</label>
                                            <div class="col-sm-7 pr0">
                                                <input class="form-control payment Number" placeholder="Change Amt."
                                                       type="text"
                                                       name="change_amt" id="change_amt" readonly>
                                            </div>
                                        </div>

                                        <div class="cash-group">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label pr0" for="">Card Payment</label>
                                                <div class="col-sm-7 pr0">
                                                    <input class="form-control payment Number"
                                                           placeholder="Card Payment"
                                                           type="text"
                                                           id="card_payment" name="card_payment">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label pr0" for="">Card Number</label>
                                                <div class="col-sm-7 pr0">
                                                    <input class="form-control" placeholder="Card Number" type="text"
                                                           id="card_number"
                                                           name="card_number">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label pr0" for="">Card Type</label>
                                                <div class="col-sm-7 pr0">
                                                    <select class="form-control" data-live-search="true" id="card_type"
                                                            name="card_type">
                                                        <option value="0" selected>
                                                            <?= lang("select_one"); ?>
                                                        </option>
                                                        <?php
                                                        foreach ($card_type as $card) {
                                                            echo '<option value="' . $card->id_card_type . '">' . $card->card_name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label pr0" for="">Bank Name</label>
                                                <div class="col-sm-7 pr0">
                                                    <select class="form-control" data-live-search="true" id="bank_name"
                                                            name="bank_name">
                                                        <option value="0" selected>
                                                            <?= lang("select_one"); ?>
                                                        </option>
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
                                </div>
                            </div>
                        </div>
                        <div class="full-box element-box bgc4" style="margin-top:0px !important">
                            <div class="mobile_gateway_header">
                                <div class="hrizn_title_mobile_gateway">
                                    Mobile Gateway
                                </div>

                                <div class="col-sm-12 pr0">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label pr0" for="">Amount</label>
                                            <div class="col-sm-7 pr0">
                                                <input class="form-control payment Number" placeholder="Mobile Amount"
                                                       type="text"
                                                       id="mobile_amount" name="mobile_amount">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label pr0">Mobile Bank</label>
                                            <div class="col-sm-7 pr0">

                                                <div class="row-fluid">
                                                    <select class="form-control" data-live-search="true"
                                                            id="mob_bank_name"
                                                            name="mob_bank_name">
                                                        <option value="0" selected>
                                                            <?= lang("select_one"); ?>
                                                        </option>
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
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label pr0" for="">Transaction No</label>
                                            <div class="col-sm-7 pr0">
                                                <input class="form-control" placeholder="Transaction No" type="text"
                                                       id="transaction_no"
                                                       name="transaction_no">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label pr0" for="">Receiver No</label>
                                            <div class="col-sm-7 pr0">
                                                <input class="form-control" placeholder="Receiver No" type="text"
                                                       id="mob_acc_no"
                                                       name="mob_acc_no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="sub_check_pro" class="full-box element-box bgc4 text-center" style="margin-top: 0px;">

                            <input type="hidden" name="total_pur_dis" id="total_pur_dis">
                            <input type="hidden" name="original_product_price" id="original_product_price">

                            <button type="submit" id="submit_sale"
                                    class="btn btn-primary  btn-md width-50 tc1 submit_sale"
                                    name="a4print" value="a4print" type="button">A4 Print
                            </button>
                            <button type="submit" id="submit_sale"
                                    class="btn btn-primary  btn-md width-50 tc1 submit_sale"
                                    name="print" value="print" type="button">Sale & Print
                            </button>
                            <button type="submit" id="submit_sale" name="sale" value="sale"
                                    class="btn btn-primary  btn-md width-50 tc1 submit_sale"
                                    type="button">Sale
                            </button>
                        </div>
                        <div id="sub_check_w" style="display: none;text-align: center"><button type="text" class="btn btn-primary btn-md">Sale Processing...
                            </button></div>
                        <div id="order_div">
                            <?php
                            if (isset($ord)) {
                                ?>
                                <div class="order-pop">
                                    <button type="button" class="btn btn-danger bt-xs" data-dismiss="modal"
                                            onclick="deleteOrder()"><span
                                                class="fa fa-close"></span></button>

                                    <div class="order-pop-details">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center active">
                                                <strong>Order No:</strong>
                                                <input type="hidden" id="order_id" name="order_id"
                                                       value="<?= $ord['orders'][0]['id_order'] ?>">
                                                <input type="hidden" id="order_account_id" name="order_account_id"
                                                       value="<?= $ord['orderPayments'][0]['account_id'] ?>">
                                                <input type="hidden" id="order_cus_id" name="order_cus_id"
                                                       value="<?= $ord['orders'][0]['customer_id'] ?>">
                                                <span class="badge badge-primary badge-pill"><?= $ord['orders'][0]['invoice_no'] ?></span>
                                            </li>
                                            <?php
                                            $i = 1;
                                            foreach ($ord['orderDetails'] as $details) {
                                                if ($details['sale_qty'] < $details['qty']) {
                                                    ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <input type="hidden" name="ord_pro_id[]" id="<?= $i ?>"
                                                               value="<?= $details['product_id'] ?>">
                                                        <input type="hidden" id="ord_org_qty_<?= $i ?>"
                                                               name="ord_org_qty[]" value="<?= $details['qty'] ?>">
                                                        <input type="hidden" id="ord_sale_qty_<?= $i ?>"
                                                               name="ord_sale_qty[]"
                                                               value="<?= $details['sale_qty'] ?>">
                                                        <input type="hidden" id="ord_dis_rate_<?= $i ?>"
                                                               name="ord_dis_rate[]" value="<?= $details['discount_rate'] ?>">
                                                        <strong style="float: left"><?= $details['product_name'] ?></strong>
                                                        <?php
                                                        $grn = ($details['sale_qty'] >= $details['qty']) ? 'green' : '';
                                                        ?>
                                                        <div class="value-order">
                                                        <span class="badge badge-primary badge-pill green"
                                                              id="ord_qty_org_<?= $i ?>"><?= $details['qty'] ?></span>
                                                            <span class="badge badge-primary badge-pill <?= $grn ?>"
                                                                  id="ord_qty_<?= $i ?>"><?= $details['sale_qty'] ?></span>
                                                        </div>
                                                    </li>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($request_key)) {
    ?>
    <script>
        $(document).ready(function () {
            var total = 0;
            $('input[name^="total_price"]').each(function () {
                total = ($(this).val() * 1) + total;
            });
            total_purchase_discount(total);
            totalCalculation()
        });
        //alert('sd');

    </script>

    <?php
}
?>
<div id="delivery_add" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang('add_delivery_cost') ?> <span class="close" data-dismiss="modal">&times;</span>
                </h6>
            </div>
            <?php echo form_open_multipart('', array('id' => 'delivery_info', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for=""><?= lang('delivery_type') ?><span
                                        class="req">*</span></label>
                            <div class="col-sm-12">
                                <select class="form-control" id="delivery_type" onchange="setAgentStaff(this)"
                                        name="delivery_type">
                                    <option value="0" selected><?= lang('select_one') ?></option>
                                    <option value="1@Staff"><?= lang('staff') ?></option>
                                    <option value="2@Agents"><?= lang('agents') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="order_sort_data"></div>
                    <div id="customer_data"></div>
                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" value="<?= lang('submit') ?>"> </button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>


    </div>
</div>
<?php
$this->load->view('sales/sale_customer_add', false);
?>
<div class="modal fade" id="validateAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> This batch number already exist.</li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="EmptyAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li id="alert_data">
                        </li>
                    </ul>
                </div>

            </div>
            <div class="modal-footer" id="alert_foot"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="EmptyAlertSale" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li id="alert_data_sale">
                        </li>
                    </ul>
                </div>

            </div>
            <div class="modal-footer" id="alert_foot">
                <button type="button" class="btn btn-default" onclick="location.reload()"><?= lang('close') ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="pointDetails" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="redeem">
                    <h4>1 point = <?= set_currency($point_remit[0]['param_val']) ?></h4>

                    <div class="crnt-points">
                        <input type="hidden" name="point_per_amount" id="point_per_amount"
                               value="<?= $point_remit[0]['param_val'] ?>">
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
                <button type="button" class="btn btn-default" onclick="add_remit_point()">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="restore_hold" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div id="restore_hold_data"></div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
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
<div class="modal fade" id="productEmptyAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> Please add product first.
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/sale_print_view.css">
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>
<script>
    var change_count=1;
    $(document).ready(function () {
        if($("#order_id").length>0) {
            change_count=2;
            setTimeout(function () {
                var cus_id=$("#order_cus_id").val();
                $("#customer").val(cus_id).change();
                change_count=1;
            }, 200);
        }
        $("#flip").click(function () {
            $(".desktop-menu").toggleClass("menu-hide-show");
            $(".md8").toggleClass("col9");
            $(".md4").toggleClass("col3");
        });
        $('input.payment').on('input', function (e) {
            amount_check();
        });
        $('input.amount_round').click(function () {
            amount_check();
        });
        $('input#cash_paid').on('input', function (e) {
            var cash=$('#cash').val();
            var cash_paid=$('#cash_paid').val();
            $('#change_amt').val(cash-cash_paid);
        });


        $('input.sp_discount').on('input', function (e) {
            var id = this.id;
            var val = this.value;
            //alert(val+'==='+id);
            if (val != '') {
                var default_dis = $('#default_dis').text();
                if (default_dis == '') {
                    var div = '<div class="default_dis"><strong>Discount <b id="dis_per"></b>:<label class="switch"><input type="checkbox" name="ck_sp_dis" id="ck_sp_dis" checked onclick="sp_discount_chk()"><span class="slider round"></span> </label></strong><span id="dis_taka"> 00 </span>&nbsp;</div>';
                    $('#default_dis').html(div);
                }
                if (id === 'percent') {
                    $('#dis_per').html(val + '%');
                    $("#taka").prop("disabled", true);
                } else {
                    $('#dis_taka').html(val);
                    $("#percent").prop("disabled", true);
                }
            } else {
                $('#default_dis').html('');
                $('#dis_per').html('');
                $('#dis_taka').html('00');
                $("#percent").prop("disabled", false);
                $("#taka").prop("disabled", false);
            }
            totalCalculation()

        });
    });
    function deleteOrder() {
        $('#EmptyAlert').modal('toggle');
        var btn = '<button type="button" class="btn btn-default" onclick="deleteOrderConfirm()">OK</button>';
        $('#alert_data').html('Are you sure cancel this order?');
        $('#alert_foot').html(btn);
    }
    function deleteOrderConfirm() {
        window.location.href = "<?php echo base_url() ?>sales";
    }

    function amount_check() {
        var chk_empty='';
        var total=0;
        $('input[name^="total_price"]').each(function () {
            chk_empty = ($(this).val() * 1) + total;
        });
        //alert(total);
        var pr_total = $('#grand_total').text() * 1;
        if (chk_empty < 1) {
            $('#productEmptyAlert').modal('toggle');
            $('#card_payment').val('');
            $('#cash').val('');
            $('#mobile_amount').val('');
            $('input[id=product_name]').focus();
        } else {
            var cart = $('#card_payment').val() * 1;
            var cash = $('#cash').val() * 1;
            var mobile = $('#mobile_amount').val() * 1;
            var order_amt=0*1;
            if($("#order_paid_amount").length){
                order_amt=$('#order_paid_amount').html()*1;
            }
            var paid_amt = cart + cash + mobile;
            $('#paid_amount').html(paid_amt);
            var remit_amount = $('#remit_take').html();
            var remit_total = 0;
            if (remit_amount) {
                remit_total = remit_amount * 1;
            }
            if ($('#round_check').prop("checked") == true) {
                var tot_due_m = (paid_amt + remit_total+order_amt) - pr_total;
                $('#round').html(tot_due_m.toFixed(2));
                $('#tot_due_amount').html('00');
                // $('#round_check').filter(':checkbox').prop('checked',false);
            } else {
                var tot_due_p = pr_total - (paid_amt + remit_total+order_amt);
                $('#tot_due_amount').html(tot_due_p.toFixed(2));
                $('#round').html('00');
            }
        }
    }
    function sp_discount_chk() {
//        if(!$('#ck_sp_dis').is(':checked')){
//        //if($('#ck_sp_dis').prop("checked") == true){
//            //alert('not checked');
//        }else{
//           // alert('checked');
//        }
        totalCalculation();
    }
    function cart_discount_chk() {
        totalCalculation();
    }
    function pur_discount_chk() {
        totalCalculation();
    }
    function cus_discount_chk() {
        totalCalculation();
    }
    function sale_print_tharmal() {
        $("#sale_view").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/sale_print_view.css",
            iframe: false,
            noPrintSelector: ".avoid-this",
            // append : "Free jQuery Plugins!!!<br/>",
            // prepend : "<br/>jQueryScript.net!"
        });
        //$.print("#sale_view");

    }
    function restore_hold() {
        $.ajax({
            url: "<?php echo base_url() ?>hold_sale_list",
            type: "GET",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('#restore_hold_data').html(data);
                $('.loading').fadeOut("slow");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }

        });
    }
    function hold_sale() {
        var cus_id = $('#customer_id').val();
        var stock = $('#stock_id_1').val();
        if (!stock) {
            $('#productEmptyAlert').modal('toggle');
        } else {
            var dataString = new FormData($('#submit_sales_form')[0]);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>hold_sale_add',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data) {
                    var result = $.parseJSON(data);
                    if (result.status != 'success') {
                        $('#showMessage').html('Error in data insertion.');
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>sales";
                        }, 500);
                    }
                    $('.loading').fadeOut("slow");
                    return false;
                },
                cache: false,
                contentType: false,
                processData: false
            });

        }
        $("input[name='stock_id[]']").each(function () {
            id_value = $(this).val();
            var id_full = $(this).attr('id');
            id = id_full.split("_").pop(-1);
            batch_value = $('#batch_' + id + ' :selected').val();
            if ((id_value == $product.data[0]['id_product']) && ($product.data[0]['batch_no'] == batch_value)) {
                //alert(batch_value);
                check = 2;
                check_id = id
            }
        });
        if (cus_id) {
            //alert(cus_id);
        }
    }
    var button_pressed;
    $('.submit_sale').click(function () {
        button_pressed = $(this).attr('name')
    });
    $("#submit_sales_form").submit(function () {
        var sale_type = button_pressed;
        $('#sub_check_pro').hide();
        $('#sub_check_w').show();
        if (validateSalesForm() != false) {
            $('#sub_check_pro').hide();
            var $html = '';
            var grand_total = $('#grand_total').text();
            var cart_total = $('#cart_total').text();
            //var df_vat = $('#df_vat').text();
            //var vat_total = $('#vat_total').text();
            var dis_per = $('#dis_per').text();
            var dis_taka = $('#dis_taka').text();
            var cus_dis = $('#cus_dis').text();
            var cus_dis_total = $('#cus_dis_total').text();
            var pur_dis = $('#pur_dis').text();
            var pur_dis_total = $('#pur_dis_total').text();
            var card_dis = $('#cart_dis').text();
            var card_dis_total = $('#cart_dis_total').text();
            var paid_amt = $('#paid_amount').text();
            var round_amt = $('#round').text();
            var due_amt = $('#tot_due_amount').text();
            var order_paid_amount = $('#order_paid_amount').text();
            var dataString = new FormData($(this)[0]);
            var sales_person_name =$('#sales_person option:selected').attr('actp');
            dataString.append('sales_person_name', sales_person_name);
            dataString.append('order_paid_amount', order_paid_amount);
            dataString.append('print_type', sale_type);
            dataString.append('cart_total', cart_total);
            dataString.append('paid_amt', paid_amt + '@' + round_amt + '@' + due_amt);
            dataString.append('special_dis', dis_per + '@' + dis_taka);
            dataString.append('cus_dis', cus_dis + '@' + cus_dis_total);
            dataString.append('pur_dis', pur_dis + '@' + pur_dis_total);
            dataString.append('card_dis', card_dis + '@' + card_dis_total);
            dataString.append('grand_total', grand_total);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>sales_add',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data) {
                    
                     // console.log(data);
                     // alert(data);
                    $('.loading').fadeOut("slow");
                    if (data != 'error') {
                        $('#sale_view').html(data);
                        if (sale_type == 'print') {
                            $("#sale_view").print({
                                globalStyles: false,
                                mediaPrint: false,
                                stylesheet: "<?= base_url(); ?>themes/default/css/sale_print_view.css",
                                iframe: false,
                                noPrintSelector: ".avoid-this",
                                // append : "Free jQuery Plugins!!!<br/>",
                                // prepend : "<br/>jQueryScript.net!"
                            });
                            setTimeout( function() {
                                window.location.replace("<?=base_url()?>sales");
                            }, 1000 );
                            
                        } else if (sale_type == 'a4print') {
                            //alert(button_pressed);
                            $("#sale_view").print({
                                globalStyles: false,
                                mediaPrint: false,
                                stylesheet: "<?= base_url(); ?>themes/default/css/a4_print.css",
                                iframe: false,
                                noPrintSelector: ".avoid-this",
                                // append : "Free jQuery Plugins!!!<br/>",
                                // prepend : "<br/>jQueryScript.net!"
                            });
                            setTimeout(function () {
                                window.location.replace("<?=base_url()?>sales");
                            }, 1000);

                        } else {
                            $('#SaleDetails').modal('toggle');
                        }
                    }else{
                        $('#EmptyAlertSale').modal('toggle');
                        $('#alert_data_sale').html('<span class="glyphicon glyphicon-warning-sign"></span> Unable to Process Sales. Your Internet Connection is very slow.');
                        // setTimeout(function () {
                        //         window.location.replace("<?=base_url()?>sales");
                        //     }, 2000);
                    }
                    return false;
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        } else {
            return false;
        }


    });
    function validateSalesForm() {
        var error_count = 0;
        var mobile_cash = $('#mobile_amount').val();
        var cart = $('#card_payment').val();
        var cash = $('#cash').val();
        var customer_id = $('#customer_id').val();
        var token_no = $('#token_no').val();
        if(token_no==''){
            $('#sub_check_pro').show();
            $('#sub_check_w').hide();
            $('#EmptyAlert').modal('toggle');
            $('#alert_data').html('<span class="glyphicon glyphicon-warning-sign"></span> Multiple time submit not allow.');
            return false;
        }
        if (!$.trim(customer_id)) {
            var total = (mobile_cash * 1) + (cart * 1) + (cash * 1);
            var due = $('#tot_due_amount').html() * 1;
            if (due != 0) {
                $('#sub_check_pro').show();
                $('#sub_check_w').hide();
                $('#EmptyAlert').modal('toggle');
                $('#alert_data').html('<span class="glyphicon glyphicon-warning-sign"></span> Due or over payment not allow.');
                return false;
            }
        }
        if ($.trim(customer_id)) {
            var total = (mobile_cash * 1) + (cart * 1) + (cash * 1);
            var due = $('#tot_due_amount').html() * 1;
            if (due < 0) {
                $('#sub_check_pro').show();
                $('#sub_check_w').hide();
                $('#EmptyAlert').modal('toggle');
                $('#alert_data').html('<span class="glyphicon glyphicon-warning-sign"></span>  Over payment not allow.');
                return false;
            }
        }
        $("input[name='pro_id[]']").each(function () {
            var id_full = $(this).attr('id');
            var id = id_full.split("_").pop(-1);
            var stk_qty = $('#total_qty_' + id).val() * 1;
            var sale_qty = $('#qty_' + id).val() * 1;
            if (sale_qty > stk_qty) {
                error_count += 1;
                $('#qty_' + id).addClass("focus_error");
                $('#qty_' + id).focus();
            } else {
                $('#qty_' + id).removeClass("focus_error");
            }
        });
        if (mobile_cash == '' && cart == '' && cash == '') {
            error_count += 1;
            $('#cash').focus();
            $('#cash').addClass("focus_error");
            $('#mobile_amount').addClass("focus_error");
            $('#card_payment').addClass("focus_error");
        } else {
            $('#cash').removeClass("focus_error");
            $('#mobile_amount').removeClass("focus_error");
            $('#card_payment').removeClass("focus_error");
        }
        if (cart != '') {
            if ($('#card_number').val() == '') {
                error_count += 1;
                $('#card_number').addClass("focus_error");
            } else {
                $('#card_number').removeClass("focus_error");
            }
            var card_type = $('#card_type option:selected').val();
            if (card_type == 0) {
                error_count += 1;
                $('#card_type').addClass("focus_error");
            } else {
                $('#card_type').removeClass("focus_error");
            }
            var bank_name = $('#bank_name option:selected').val();
            if (bank_name == 0) {
                error_count += 1;
                $('#bank_name').addClass("focus_error");
            } else {
                $('#bank_name').removeClass("focus_error");
            }

        }
        if (mobile_cash != '') {
            if ($('#transaction_no').val() == '') {
                error_count += 1;
                $('#transaction_no').addClass("focus_error");
            } else {
                $('#transaction_no').removeClass("focus_error");
            }
            if ($('#mob_acc_no').val() == '') {
                error_count += 1;
                $('#mob_acc_no').addClass("focus_error");
            } else {
                $('#mob_acc_no').removeClass("focus_error");
            }
            var mob_bank_name = $('#mob_bank_name option:selected').val();
            if (mob_bank_name == 0) {
                error_count += 1;
                $('#mob_bank_name').addClass("focus_error");
            } else {
                $('#mob_bank_name').removeClass("focus_error");
            }

        }
        if (error_count > 0) {
            $('#sub_check_pro').show();
            $('#sub_check_w').hide();
            $('#EmptyAlert').modal('toggle');
            $('#alert_data').html('<span class="glyphicon glyphicon-warning-sign"></span> Please Fill-up Required Fields.');
            return false;
        } else {
            $('#token_no').val('');
            return true;
        }
    }
    function total_purchase_discount(val) {
        $.ajax({
            type: "GET",
            url: '<?php echo base_url(); ?>total_purchase_discount?request=' + val,
            async: false,
            success: function (data) {
                var result = $.parseJSON(data);
                if ((result.rate != '') || (result.amount != '')) {
                    // alert('sdf');
                    var pur_dis_amount, pur_dis_val = '';
                    if (result.rate != '') {
                        pur_dis_val = '<b id="pur_dis">' + Number(result.rate) + '</b>%';
                    }
                    var pur_dis_per = $('#pur_dis').text();
                    if (pur_dis_per.trim()) {
                        $('#pur_dis').html(Number(result.rate));
                        $('#pur_dis_total').html(result.amount);
                    } else {
                        var div = '<div class="all-discount-pur" id="pur_dis_m"><strong class="pur-dis">Pur. Dis. ' + pur_dis_val + ':<label class="switch"><input type="checkbox" name="ck_pur_dis" id="ck_pur_dis" checked onclick="pur_discount_chk()"><span class="slider round"></span></label></strong><span class="discount-ammount pur-dis" id="pur_dis_total"> ' + result.amount + '</span>&nbsp;</div>';
                        $('#all_discount').append(div);
                    }
                    $('#total_pur_dis').val(pur_dis_amount);

                } else {
                    $("#pur_dis_m").remove();
                    //$('#pur_dis_m').html('');
                }

            }
        });
    }
    function add_cart_discount(ele) {
        var val = ele.value;
        if (val != 0) {
            var val_data = val.split('@')[1];
            var chk_dis = $('#cart_dis').text();
            if (chk_dis) {
                $('#cart_dis').html(val_data);
            } else {
                var div = '<div id="card" class="all-discount-card"><strong class="pur-dis">Card Dis. <b id="cart_dis">' + val_data + '</b>%:<label class="switch"><input type="checkbox" name="ck_cart_dis" id="ck_cart_dis" onclick="cart_discount_chk()" checked><span class="slider round"></span></label></strong><span id="cart_dis_total"> 00</span>&nbsp;</div>';
                $('#all_discount').append(div);
            }
            totalCalculation();
        }
    }
    $("#add_product_to_cart").submit(function () {
        var $html = '';
        $('#product_name-error').html('');
        var dataString = new FormData($(this)[0]);
        dataString.append('store_name', $('#store_from').val())
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>temp_add_cart_for_sales',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                $('.loading').fadeOut("slow");
                //console.log(result);
                //alert(result);
                var $product = $.parseJSON(result);
                if ($product.status == 1) {
                    if($product.data[0]['store_id'] != $('#store_from').val()){
                        $('#EmptyAlert').modal('toggle');
                        $('#alert_data').html('<span class="glyph icon glyphicon-warning-sign"></span>Unable to Process Sales. Your Internet Connection is very slow.');
                        $('#product_name').val('');
                        $('#product_name').focus();
                        return false;
                    }
                    //console.log($product);
                    var rowCount = $('#addSection >tbody >tr').length;
                    rowCount += 1;
                    $(this).attr('id');
                    var id_value, batch_value, id, check_id, check  = parseInt(0);
                    var total_qty, total_item=parseInt(1);
                    var exist = 1;
                    $("input[name='pro_id[]']").each(function () {
                        id_value = $(this).val();
                        var id_full = $(this).attr('id');
                        id = id_full.split("_").pop(-1);
                        batch_value = $('#batch_' + id + ' :selected').val();
                        if ((id_value == $product.data[0]['id_product']) && ($product.data[0]['batch_no'] == batch_value)) {
                            if (($product.data[0]['total_qty'] * 1) == ($('#qty_' + id).val() * 1)) {
                                exist = 2;
                            }
                            check = 2;
                            check_id = id
                        }
                        total_qty= total_qty+1;
                        total_item=total_item+1;

                    });
                    //alert(batch_value + '=' + id_value);
                    if (check == 2 && exist == 1) {
                        var qty_val = $('#qty_' + check_id).val();
                        var qty = qty_val * 1 + 1;
                        $('#qty_' + check_id).val(qty);
                        var discount_amount;
                        var un_p = $("#unit_price_" + check_id).val();
                        var discount = $("#discount_" + check_id).val();
                        var discount_type = $("#discount_type_" + check_id).val();
                        if (discount_type == 'TK') {
                            discount_amount = discount;
                        } else {
                            //discount_amount = (un_p * discount) / 100;
							              discount_amount = ((un_p * qty) * discount) / 100;
                        }
						            var vat_tot = 0;
						            var def_vat = $("#def_vat_" + check_id).val();
						            vat_tot = (((un_p * qty) - discount_amount) * def_vat) / 100;
						            $("#def_vat_amt_" + check_id).val(parseFloat(vat_tot).toFixed(2));
						            var tot_val = ((qty * un_p) - discount_amount) + vat_tot;
                        $("#total_price_" + check_id).val(tot_val);
                    } else if (exist == 1) {
                        var $html;
                        var dis_val = 0, amt_type = '', promo_id = '', total_discount_amount = 0, dis_amt = 0;
                        //promo_id = 0;
                        if ($product.discount != '') {
                            dis_amt = $product.discount;
                            dis_val = dis_amt.split(' ')[0];
                            amt_type = dis_amt.split(' ')[1];
                            promo_id = dis_amt.split(' ')[2];
                            if (amt_type == '%') {
                                total_discount_amount = ($product.data[0]['selling_price_est'] * dis_val) / 100;
                                //total_discount_amount = ($product.data[0]['selling_price_est'] - discount_amount);
                            } else {
                                total_discount_amount = dis_val;
                            }

                        }
                        var page = '';
                        if (total_discount_amount != 0) {
                            page = '<div class="prom">P</div>';
                        }
                        var attr = '';
                        if ($product.data[0]['attribute_name'] != null) {
                            attr = $product.data[0]['attribute_name'].replace(/\,/g, "<br>");
                        }
                        var pro_total = $product.data[0]['selling_price_est'] - total_discount_amount;
                        $html += '<tr id="' + rowCount + '"><input type="hidden" id="' + 'unit_id_' + rowCount + '" name="unit_id[]" value="' + $product.data[0]['unit_id'] + '">';
                        $html += '<td>' + $product.data[0]['product_name'] + page + '<br>' + $product.data[0]['product_code'] + '<input type="hidden" id="' + 'pro_name_' + rowCount + '" name="pro_name[]" value="' + $product.data[0]['product_name'] + '"><input type="hidden" id="' + 'pro_id_' + rowCount + '" name="pro_id[]" value="' + $product.data[0]['id_product'] + '">';
                        $html += '<input type="hidden" id="' + 'stock_id_' + rowCount + '" name="stock_id[]" value="' + $product.data[0]['id_stock'] + '"><input type="hidden" id="' + 'p_store_id_' + rowCount + '" name="p_store_id[]" value="' + $product.data[0]['store_id'] + '"><input type="hidden" id="' + 'cat_id_' + rowCount + '" name="cat_id[]" value="' + $product.data[0]['cat_id'] + '"><input type="hidden" id="' + 'subcat_id_' + rowCount + '" name="subcat_id[]" value="' + $product.data[0]['subcat_id'] + '"><input type="hidden" id="' + 'brand_id_' + rowCount + '" name="brand_id[]" value="' + $product.data[0]['brand_id'] + '"></td>';
                        $html += '<td style="width: 24px">' + attr + '<input type="hidden" id="' + 'pro_code_' + rowCount + '" name="pro_code[]" value="' + $product.data[0]['product_code'] + '">' + '</td>';
                        //$html += '<td>' + $product.data[0]['batch_no'] + '<input type="hidden" id="' + 'batch_' + rowCount + '" name="batch[]" value="' + $product.data[0]['batch_no'] + '">' + '</td>';
                        $html += '<td>';
                        $html += '<select id="batch_' + rowCount + '" name="batch[]" onchange="change_batch(this)">';
                        $.each($product.batch, function (index, data) {
                            var select = (data.batch_no == $product.data[0]['batch_no']) ? 'selected' : '';
                            $html += '<option value="' + data.batch_no + '" ' + select + '>' + data.batch_no + '</option>';
                        });
                        $html += '</select>';
                        $html += ' <input type="hidden" name="old_batch[]" id="old_batch_' + rowCount + '" value="' + $product.data[0]['batch_no'] + '"></td>';
                        $html += '<td>' + '<input style="width:40px;" type="text" id="' + 'total_qty_' + rowCount + '" name="total_qty[]" value="' + $product.data[0]['total_qty'] * 1 + '" readonly>' + '</td>';
                        $html += '<td>' + '<input type="text" style="width: 24px" id="' + 'qty_' + rowCount + '" name="qty[]" value="1" class="change_price">' + '</td>';
                        $html += '<td>' + '<input type="text" style="width: 48px" id="' + 'unit_price_' + rowCount + '" name="unit_price[]" value="' + $product.data[0]['selling_price_est'] * 1 + '" class="change_price">' + '</td>';
                        $html += '<td id="discount_td_'+rowCount+'">' + '<input type="text" style="width: 18px" id="' + 'discount_' + rowCount + '" name="discount[]" value="' + dis_val * 1 + '" class="change_price"><strong>' + amt_type + '</strong><input type="hidden" id="' + 'discount_type_' + rowCount + '" name="discount_type[]" value="' + amt_type + '"> <input type="hidden" name="pro_sale_id[]" value="' + promo_id + '"></td>';
                        $html += '<td>';
                        var de_vat = vat_total = 0;
                        if ($product.data[0]['is_vatable'] == 1) {
                            de_vat = $product.def_vat;
                            vat_total = (pro_total * de_vat) / 100;
                        }
                        $html += '<input type="text" style="width: 20px" id="' + 'def_vat_' + rowCount + '" name="def_vat[]" value="' + de_vat + '" readonly><input type="hidden" id="' + 'def_vat_amt_' + rowCount + '" name="def_vat_amt[]" value="' + parseFloat(vat_total).toFixed(2) + '" readonly>';
                        $html += '</td>';
                        $html += '<td>' + '<input type="text" style="width: 52px" id="' + 'total_price_' + rowCount + '" name="total_price[]" value="' + (pro_total + vat_total) + '" readonly>' + '</td>';
                        $html += '<td><a class="close-button" onclick="temp_remove_product(' + rowCount + ')"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
                        $html += '</tr>';
                        $('#addSection > tbody').prepend($html);
                    } else {
                        $('#EmptyAlert').modal('toggle');
                        $('#alert_data').html('<span class="glyphicon glyphicon-warning-sign"></span> Stock Not Abailable.');
                    }
                    var total = 0;
                    $('input[name^="total_price"]').each(function () {
                        total = ($(this).val() * 1) + total;
                    });
                    if ($('#order_id').length > 0) {
                        orderCount();
                    }
                    total_purchase_discount(total);
                    totalCalculation();
                }else{
                     $('#product_name-error').html($product.message);
                }
                $('#product_name').val('');
                $('#product_id').val('');
                $('#batch_s').val('');
                $('#product_name').focus();
                return false;
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    function temp_remove_product($id) {
        $('#' + $id).closest('tr').remove();
        var total = 0;
        $('input[name^="total_price"]').each(function () {
            total = ($(this).val() * 1) + total;
        });
        total_purchase_discount(total);
        totalCalculation();
        if ($('#order_id').length > 0) {
            orderCount();
        }
    }
    function change_batch(ele) {
        //alert();
        var id_full = ele.id;
        var store_id=$('#store_from').val();
        var div_id = id_full.split("_").pop(-1);
        var value = ele.value;
        var product_id = $('#pro_id_' + div_id).val();
        // var before_gross = $('#batch_' + div_id).val();
        //alert(before_gross+'%%%88888');
        var check = 0;
        $('select[name="batch[]"]').each(function () {
            var id_f = $(this).attr('id');
            var div_id = id_f.split("_").pop(-1);
            var pro_id = $('#pro_id_' + div_id).val();
            var batch_old = $(this).val();
            if ((pro_id == product_id) && (batch_old == value)) {
                // alert(batch_old+'='+pro_id);
                check = (check + 1);
            }
        });
        if (check == 2) {
            var old_id = $('#old_batch_' + div_id).val();
            var new_id = '#' + id_full + ' [value="' + old_id + '"]';
            $("#" + id_full).val(old_id).change();
            $('#validateAlert').modal('toggle');
        } else {
            //alert(div_id+'='+stock_id);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>check_batch_product',
                data: 'product_id=' + product_id + '&batch_no=' + value+ '&store_id=' + store_id,
                async: false,
                success: function (data) {
                    
                    $('.loading').fadeOut("slow");
                    var result = $.parseJSON(data);
                    if (result.data != '') {
                        //alert(result[0].id_stock);
                        // var qty=$('#qty_'+div_id).val();
                        var price = $('#unit_price_' + div_id).val();
                        var def_vat = $('#def_vat_' + div_id).val()*1;
                        var dis_key = $('#discount_' + div_id).val();
                        var discount_type = $('#discount_type_' + div_id).val();
                        $('#stock_id_' + div_id).val(result.data[0].id_stock);
                        $('#total_qty_' + div_id).val(result.data[0].total_qty);
                        $('#unit_price_' + div_id).val(result.data[0].selling_price_est);
                        var selling_price=result.data[0].selling_price_est*1;
                        var discount=0; vat = 0;
                        var dis_val = 0, amt_type = '', promo_id = '', total_discount_amount = 0, dis_amt = 0;
                        //promo_id = 0;
                        if (result.discount != '') {
                            dis_amt = result.discount;
                            dis_val = dis_amt.split(' ')[0];
                            amt_type = dis_amt.split(' ')[1];
                            promo_id = dis_amt.split(' ')[2];
                            
                            dis_val=dis_val*1;
                            if (amt_type == '%') {
                                discount = (selling_price * dis_val) / 100;
                                //total_discount_amount = ($product.data[0]['selling_price_est'] - discount_amount);
                            } else {
                                discount = dis_val;
                            }
                           var html='<input type="text" style="width: 18px" id="' + 'discount_' + div_id + '" name="discount[]" value="' + dis_val + '" class="change_price"><strong>%</strong><input type="hidden" id="' + 'discount_type_' + div_id + '" name="discount_type[]" value="'+amt_type+'"> <input type="hidden" name="pro_sale_id[]" value="' + promo_id + '">';
                            $('#discount_td_' + div_id).html(html);
                            dis_key=dis_key;
                            discount_type=amt_type;

                        }else{
                           var html='<input type="text" style="width: 18px" id="' + 'discount_' + div_id + '" name="discount[]" value="0" class="change_price"><strong></strong><input type="hidden" id="' + 'discount_type_' + div_id + '" name="discount_type[]" value=""> <input type="hidden" name="pro_sale_id[]" value="">';
                            $('#discount_td_' + div_id).html(html); 
                        }
                        //alert(selling_price+'=='+discount+'=='+def_vat);

                        var discount_price=selling_price-discount;
                        if (def_vat != '') {
                            vat = (discount_price * def_vat) / 100;
                        }

                        var tot_value = discount_price + vat;
                        $('#total_price_' + div_id).val(tot_value);
                        $('#qty_' + div_id).val('1');
                        $('#old_batch_' + div_id).val(value);
                        totalCalculation();
                    }
                }
            });
        }

    }
    function totalCalculation() {
        var product_total = 0;
        var unit_total = 0;
        var total_qty_sh=parseInt(0),item_array=[];
        var total_item_sh=parseInt(0);
        $('input[name^="total_price"]').each(function () {
            var id_f = $(this).attr('id');
            var div_id = id_f.split("_").pop(-1);
            var unit_val = $('#unit_price_' + div_id).val();
            var unit_qty = parseInt($('#qty_' + div_id).val());
            var pro_id_u = $('#pro_id_' + div_id).val();
            unit_total += (unit_val * unit_qty);
            product_total = ($(this).val() * 1) + product_total;
            total_qty_sh=total_qty_sh+unit_qty;
            item_array.push(pro_id_u);
        });
        var itemUniqueArray = item_array.filter(function(itm, i, a) {
            return i == a.indexOf(itm);
        });
        $('#total_item_show').html(itemUniqueArray.length+ ' items');
        $('#total_qty_show').html(total_qty_sh); 
        $('#original_product_price').val(unit_total);
        var cus_dis = $('#cus_dis').text();
        var dis_per = $('#pur_dis_total').text();
        //var dis_taka = $('#dis_taka').text();
        var cart_dis = $('#cart_dis').text();
        var special_dis = $('#dis_per').text();
        var special_dis_taka = $('#dis_taka').text();
        var cus_taka = cart_taka = 0;
        if ($('#ck_cus_dis').is(':checked')) {
            if (cus_dis) {
                cus_taka = (product_total * cus_dis) / 100;
                $("#cus_dis_total").html(cus_taka.toFixed(2));
            }
        }
        var pur_dis_amt = special_dis_amount = 0;
        if ($('#ck_sp_dis').is(':checked')) {
            if (special_dis != '') {
                var sp_dis = special_dis.slice(0, -1);
                special_dis_amount = (product_total * sp_dis) / 100;
                $('#dis_taka').html(special_dis_amount.toFixed(2));
            } else if (special_dis_taka != '00') {
                special_dis_amount = special_dis_taka * 1;
            }
        }
        if ($('#ck_pur_dis').is(':checked')) {
            if (dis_per.trim()) {
                pur_dis_amt = parseFloat(dis_per);
            }
        }
        if ($('#ck_cart_dis').is(':checked')) {
            if (cart_dis.trim()) {
                cart_taka = (product_total * cart_dis) / 100;
                $('#cart_dis_total').html(cart_taka.toFixed(2));
            }
        }
        var grand_total = (product_total - (cus_taka + cart_taka + pur_dis_amt + special_dis_amount));
        $("#cart_total").html(product_total.toFixed(2));
        $("#grand_total").html(grand_total.toFixed(2));
        var pr_total = $('#grand_total').text() * 1;
        var paid_amount = $('#paid_amount').text() * 1;
        var remit_amount = $('#remit_take').html();
        var remit_total = 0;
        if (remit_amount) {
            remit_total = remit_amount * 1;
        }
        $('#round_check').filter(':checkbox').prop('checked', false);
        $('#round').html('00');
        var order_amt = 0 * 1;
        if ($("#order_paid_amount").length) {
            order_amt = $('#order_paid_amount').html() * 1;
        }
        var tot_due_m = pr_total - (paid_amount + remit_total + order_amt);
        $('#tot_due_amount').html(tot_due_m.toFixed(2));
        if(pr_total==0){
            $('#cash').val(0)
        }
    }
    function customer_list_suggest(elem) {
        var request = $('#customer').val();
        //alert();
        $("#customer").autocomplete({
            source: "<?php echo base_url(); ?>get_customers_auto?request=" + request,
            focus: function (event, ui) {
                event.preventDefault();
                $("#customer").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#customer").val('');
                $("#customer").val(ui.item.label);
                $("#c_phone").val(ui.item.phone);
                $("#points").val(ui.item.points);
                $("#balance").val(ui.item.balance);
                $("#id").val(ui.item.value);
            }
        });
    }
    $('#customer').on('change', '', function (e) {
        var customer_id = this.value;
        var html = '';
        //alert($name);
        if (customer_id == '') {
            html += '<p class="error">Please Insert Customer Name</p>';
        } else if ($("#order_id").length > 0 && change_count == 1) {
            deleteOrder();
        } else {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>show_customer_for_sales',
                data: 'customer_name=' + customer_id,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    //console.log(result);
                    var data = $.parseJSON(result);
                    if (!jQuery.isEmptyObject(data)) {
                        //console.log(data);
                        //alert(data[0].balance+'=='+data[0].points)
                        html += '<div class="ci-info">';
                        html += '<span>' + data[0].full_name + '</span>';
                        html += '<span>(' + data[0].phone + ')</span>';
                        html += '<span class="gldn">' + data[0].type_name + '</span>';
                        html += '<span id="remit_val" ><a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#pointDetails" onclick="show_points(' + data[0].points + ')">Redeem</a></span>';
                        html += '</div>  <div class="ci-point">';
                        html += '<span>Balance: ' + data[0].balance + '</span>';
                        html += '<span>Points: ' + data[0].points + '</span> </div>';
                        html += '<input type="hidden" id="customer_phone" name="customer_phone" value="' + data[0].phone + '">';
                        html += '<input type="hidden" id="customer_discount" name="customer_discount" value="' + data[0].discount + '">';
                        html += '<input type="hidden" id="customer_id" name="customer_id" value="' + data[0].id_customer + '">';
                        html += '<input type="hidden" id="customer_name" name="customer_name" value="' + data[0].full_name + '">';
                        html += '<input type="hidden" id="customer_code" name="customer_code" value="' + data[0].customer_code + '">';
                        html += '<input type="hidden" id="remit_point" name="remit_point" value="">';
                        html += '<input type="hidden" id="remit_taka_val" name="remit_taka_val" value="">';
                        $("#show_customer_data").html(html);
                        $("#points").val(data[0].points);
                        $("#balance").val(data[0].balance);
                        var cus_dis = $('#cus_dis').text();
                        if (cus_dis.trim()) {
                            $('#cus_dis').html(Number(data[0].discount));
                        } else {
                            var div = '<div class="all-discount"><strong>Cus. Dis. <b id="cus_dis">' + Number(data[0].discount) + '</b>%:<label class="switch"><input type="checkbox" name="ck_cus_dis" id="ck_cus_dis" checked onclick="cus_discount_chk()"><span class="slider round"></span></label></strong><span class="discount-ammount" id="cus_dis_total"> 00</span>&nbsp;</div>';
                            $('#all_discount').append(div);
                        }

                        totalCalculation();
                    } else {
                        $("#show_customer_data").html('');
                        $(".all-discount").remove();
                        totalCalculation();
                    }
                    $('.loading').fadeOut("slow");
                    return false;
                }
            });
        }

    });
    function showCustormer() {
        var $name = $("#customer").val();
        var $phone = $("#c_phone").val();
        var $points = $("#points").val();
        var $balance = $("#balance").val();
        var html = '';
        if ($name == '') {
            html += '<p class="error">Please Insert Customer Name</p>';
        } else {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>show_customer_for_sales',
                data: 'customer_name=' + $name,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    //console.log(result);
                    var data = $.parseJSON(result);
                    if (!jQuery.isEmptyObject(data)) {
                        //console.log(data);
                        //alert(data[0].balance+'=='+data[0].points)
                        html += '<div class="ci-info">';
                        html += '<span>' + data[0].full_name + '</span>';
                        html += '<span>(' + data[0].phone + ')</span>';
                        html += '<span class="gldn">' + data[0].type_name + '</span>';
                        html += '<span id="remit_val" ><a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#pointDetails" onclick="show_points(' + data[0].points + ')">Redeem</a></span>';
                        html += '</div>  <div class="ci-point">';
                        html += '<span>Balance: ' + data[0].balance + '</span>';
                        html += '<span>Points: ' + data[0].points + '</span> </div>';
                        html += '<input type="hidden" id="customer_phone" name="customer_phone" value="' + data[0].phone + '">';
                        html += '<input type="hidden" id="customer_discount" name="customer_discount" value="' + data[0].discount + '">';
                        html += '<input type="hidden" id="customer_id" name="customer_id" value="' + data[0].id_customer + '">';
                        html += '<input type="hidden" id="customer_name" name="customer_name" value="' + data[0].full_name + '">';
                        html += '<input type="hidden" id="remit_point" name="remit_point" value="">';
                        html += '<input type="hidden" id="remit_taka_val" name="remit_taka_val" value="">';
                        $("#show_customer_data").html(html);
                        var cus_dis = $('#cus_dis').text();
                        if (cus_dis.trim()) {
                            $('#cus_dis').html(Number(data[0].discount));
                        } else {
                            var div = '<div class="all-discount"><strong>Cus. Dis. <b id="cus_dis">' + Number(data[0].discount) + '</b>%:<label class="switch"><input type="checkbox" name="ck_cus_dis" id="ck_cus_dis" checked onclick="cus_discount_chk()"><span class="slider round"></span></label></strong><span class="discount-ammount" id="cus_dis_total"> 00</span>&nbsp;</div>';
                            $('#all_discount').append(div);
                        }

                        totalCalculation();
                    } else {
                        $("#show_customer_data").html('');
                        $(".all-discount").remove();
                        totalCalculation();
                    }
                    $('.loading').fadeOut("slow");
                    return false;
                }
            });
        }

    }
    function show_points(val) {
        $('#cur_pnt').html(val);
    }
    function add_remit_point() {
        var rem = $('#remit').val() * 1;
        var total = $('#cur_pnt').html() * 1;
        $('#remit_error').html('');
        if (rem == 0) {
            $('#remit_error').html('Field is required');
        } else if (rem > total) {
            $('#remit_error').html('Point is too large');
        } else {
            var taka = $('#point_per_amount').val() * 1;
            $('#remit_val').html('<div class="remit-points-show">Remit: ' + rem + ' </div>');
            $('#remit_point').val(rem);
            $('#remit_text').html('<strong>Remit:</strong><span><b id="remit_take">' + (rem * taka) + '</b></span>');
            $('#remit_taka_val').val(rem * taka);
            $('#pointDetails').modal('toggle');
            totalCalculation();
        }

    }

    function addCustomer() {
        $("div").removeClass("focus_error");
    }
    $("#customer_info").submit(function () {
        $("div").removeClass("focus_error");
        var error_count = 0;
        var customer_name = $('#customer_name').val();
        var customer_type = $('#customer_type_id option:selected').val();
        var phone = $('#phone').val();
        if (customer_name == '') {
            $('#customer_name').addClass("focus_error");
            error_count += 1;
        }
        if (customer_type == '0') {
            $('#customer_type_id').addClass("focus_error");
            error_count += 1;
        }
        if (phone == '') {
            $('#phone').addClass("focus_error");
            error_count += 1;
        }
        if (error_count == 0) {
            var currentForm = $('#customer_info')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>create_customer_info_short",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (response) {
                    var result = $.parseJSON(response);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');
                        });
                    } else {
                        $('#customer_add').modal('toggle');
                        $('#customer_info').trigger("reset");
                        $("#customer_type_id").val("0").change();
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);
                        }, 500);
                    }
                    $('.loading').fadeOut("slow");
                }
            });
        }
        return false;
    });
    function product_list_suggest(elem) {

        // var acc_type = $('[name^="acc_type"]:checked').val();
        // alert(acc_type);
        var request = $('#product_name').val();
        var store_id = $('#store_from').val();
        $("#product_name").autocomplete({
            source: "<?php echo base_url(); ?>get_products_auto_sales?request=" + request + '&store_id=' + store_id,
            focus: function (event, ui) {
                event.preventDefault();
                $("#product_name").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#product_name").val('');
                $("#product_name").val(ui.item.label);
                $("#product_id").val(ui.item.value);
                $("#batch_s").val(ui.item.batch_no);
            }
        });
    }
    $(document).on('input', '.change_price', function () {
        var m_id = this.id;
        var id = m_id.split('_').pop(-1);
        var qty = $("#qty_" + id).val();
        var total_qty = $("#total_qty_" + id).val();
        if (!$.isNumeric($(this).val())) {
            $(this).addClass("focus_error");
        } else if ((qty * 1) > (total_qty * 1)) {
            $(this).addClass("focus_error");
            $('#validateAlert').modal('toggle');
        } else {
            $(this).removeClass("focus_error");
            var discount_amount;
            var un_p = $("#unit_price_" + id).val();
            var discount = $("#discount_" + id).val();
            var discount_type = $("#discount_type_" + id).val();
            if (discount_type == 'TK') {
                discount_amount = discount;
            } else {
                discount_amount = ((un_p * qty) * discount) / 100;
            }
            var vat_tot = 0;
            var def_vat = $("#def_vat_" + id).val();
            vat_tot = (((un_p * qty) - discount_amount) * def_vat) / 100;
            $("#def_vat_amt_" + id).val(parseFloat(vat_tot).toFixed(2));
            var tot_val = ((qty * un_p) - discount_amount) + vat_tot;
            tot_val = parseFloat(tot_val).toFixed(2);
            $("#total_price_" + id).val(tot_val);
            var product_total = 0;
            $('input[name^="total_price"]').each(function () {
                product_total = ($(this).val() * 1) + product_total;
            });
            total_purchase_discount(product_total);
            totalCalculation();
            if ($('#order_id').length > 0) {
                orderCount();
            }
        }
    });
    function orderCount() {
        $('input[name^="ord_pro_id"]').each(function () {
            var id_count = $(this).attr('id');
            $('#ord_qty_' + id_count).html(0);
            var ord_pro_id = $(this).val();
             var dis_rate = $("#ord_dis_rate_" + id_count).val()*1;

            $('input[name^="qty"]').each(function () {
                var m_id = $(this).attr('id');
                var id = m_id.split('_').pop(-1);
                var sale_pro_id = $("#pro_id_" + id).val()
                if (ord_pro_id == sale_pro_id) {
                    var ord_qty = $('#ord_qty_' + id_count).html() * 1;
                    var qty = $("#qty_" + id).val() * 1;
                    if(dis_rate>0){
                        $("#discount_" + id).val(dis_rate);
                        var un_p = $("#unit_price_" + id).val()*1;
                        var discount = dis_rate;
                        $("#discount_type_" + id).val('%');
                        var discount_amount = ((un_p * qty) * discount) / 100;
                        var vat_tot = 0;
                        var def_vat = $("#def_vat_" + id).val()*1;
                        vat_tot = (((un_p * qty) - discount_amount) * def_vat) / 100;
                        $("#def_vat_amt_" + id).val(parseFloat(vat_tot).toFixed(2));
                        var tot_val = ((qty * un_p) - discount_amount) + vat_tot;
                        tot_val = parseFloat(tot_val).toFixed(2);
                        $("#total_price_" + id).val(tot_val);
                    }
                    var total = ord_qty + qty;
                    $('#ord_qty_' + id_count).html(total);
                    $('#ord_sale_qty_' + id_count).val(total);
                    ord_qty = $('#ord_qty_' + id_count).html() * 1;
                    var org_qty = $('#ord_qty_org_' + id_count).html() * 1;
                    if (ord_qty == org_qty) {
                        $('#ord_qty_' + id_count).addClass("green");
                    } else if (ord_qty > org_qty) {
                        $('#ord_qty_' + id_count).removeClass("green");
                        $('#ord_qty_' + id_count).addClass("red");
                        $('#ord_qty_org_' + id_count).removeClass("green");
                        $('#ord_qty_org_' + id_count).addClass("red");
                    } else {
                        $('#ord_qty_org_' + id_count).removeClass("red");
                        $('#ord_qty_org_' + id_count).addClass("green");
                        $('#ord_qty_' + id_count).removeClass("green");
                        $('#ord_qty_' + id_count).removeClass("red");
                    }
                }
            });


        });
    }

</script>

<script src="<?= base_url() ?>themes/default/js/delivery_add.js"></script>
