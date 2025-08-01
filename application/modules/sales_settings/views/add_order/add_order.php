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

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <?php 
                        $configs = $this->commonmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
                        $sms_config = $this->commonmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 10));
                        if($configs[0]->param_val<1 && $sms_config[0]->sms_send ==1){
                            echo '<h3 class="error">'.lang('sms_balance_zero').'</h3>';
                        }
                        ?>
                        <div class="row">
                            <div id="error" class="error"></div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-2 col-form-label"><?= lang('product_name') ?><span
                                            class="req">*</span></label>
                                <div class="col-sm-3">
                                    <select class="select2" id="search_name" name="search_name" data-live-search="true">
                                        <option value="0" selected><?= lang('select_one') ?></option>
                                        <?php foreach ($posts as $post) : ?>
                                            <option value="<?php echo $post->id_product; ?>"><?php echo $post->product_name.'('.$post->product_code.')'; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="search_name_error"></div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" onclick="addNewRow()">+ Add</button>
                                </div>
                                <div class="col-md-4">
                                    <div class="total">
                                        <strong>Total: <b id="subTotal">00</b></strong> <span
                                                style="font-size: 12px;float: right">(Due = <b id="due">00</b>)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php echo form_open_multipart('', array('id' => 'addOrderSubmit', 'class' => '')); ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table id="addSection" class="table table-bordred table-striped sales_table">
                                        <thead>
                                        <tr>
                                            <th><?= lang("product_name"); ?></th>
                                            <th><?= lang("stock"); ?></th>
                                            <th><?= lang("qty"); ?></th>
                                            <th class="center"><?= lang("unit_price"); ?></th>
                                            <th> <?= lang("dis"); ?>(%)</th>
                                             <th> <?= lang("dis"); ?>(<?= set_currency()?>)</th>
                                            <th class="center"><?= lang("vat"); ?>(%)</th>
                                            <th><?= lang("total"); ?></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="3"><?= lang("sub_total"); ?></td>
                                            <td><input type="text" style="width: 60px" name="subTotal" value=""
                                                       readonly=""></td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                            <div class="col-md-4 order-add">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class=" col-form-label col-md-12"><?= lang('customer_name') ?><span
                                                    class="req">*</span></label>
                                        <div class="col-md-12">
                                            <select class="select2 col-md-12" style="float:left" data-live-search="true"
                                                    id="customer_name" name="customer_name">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($customers as $customer) {
                                                    echo '<option actp="' . $customer->full_name . '" value="' . $customer->id_customer . '">' . $customer->full_name . '(' . $customer->phone . ')' . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <div id="customer_name_error" class="error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class=" col-form-label col-md-12"><?= lang('sales_person') ?><span
                                                    class="req">*</span></label>
                                        <div class="col-md-12">
                                            <select class="select2" style="float:left" data-live-search="true"
                                                    id="sales_person" name="sales_person">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($salesPersons as $person) {
                                                    foreach ($this->config->item('sales_person') as $key => $val) :
                                                        if ($person['person_type'] == $key) {
                                                            $type = $val;
                                                        }
                                                    endforeach;
                                                    echo '<option actp="' . $person['user_name'] . '" value="' . $person['id_sales_person'] . '">' . $person['user_name'] . '(' . $type . ')' . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <div id="sales_person_error" class="error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class=" col-form-label  col-md-12"><?= lang('payment') ?></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="pay_amount" id="pay_amount">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class=" col-form-label col-md-12"><?= lang('payment_type') ?></label>
                                        <?php
                                        $html = '';
                                        if (!empty($accounts)) {
                                            foreach ($accounts as $account) :
                                                $ac_name = !empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name'];
                                                $html .= '<option actp="' . $account['acc_type'] . '" value="' . $account['acc_id'] . '">' . $ac_name . '</option>';
                                            endforeach;
                                        }
                                        ?>
                                        <div class="col-md-12">
                                            <select class="form-control" name="account" id="account">
                                                <option value="0"><?= lang('select_one') ?></option>
                                                <?php echo $html; ?>
                                            </select>
                                            <div class="error" id="account_error"></div>
                                            <input type="hidden" id="h_pay_method" name="h_pay_method" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" id="v_pay_method" style="display:none;">
                                            <label class="col-sm-12 col-form-label"><?= lang('payment_method') ?> </label>
                                            <div class="col-md-12">
                                                <div class="row-fluid">
                                                    <select class="form-control" data-live-search="true" id="pay_method"
                                                            name="pay_method">
                                                        <option value="0"><?= lang('select_one') ?></option>
                                                        <?php foreach ($this->config->item('trx_payment_mehtods_by_bank') as $key => $val) : ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label id="pay_method-error" class="error" for="pay_method"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" id="v_ref_bank" style="display:none;">
                                            <label class="col-sm-12 col-form-label"><?= lang('bank') ?></label>
                                            <div class="col-md-12">
                                                <div class="row-fluid">
                                                    <select class="form-control" data-live-search="true" id="ref_bank"
                                                            name="ref_bank">
                                                        <option value="0"><?= lang('select_one') ?></option>
                                                        <?php foreach ($general_banks as $key => $val) : ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label id="ref_bank-error" class="error" for="ref_bank"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" id="v_ref_mobile_bank" style="display:none;">
                                            <label class="col-sm-12 col-form-label"><?= lang('mobile_bank') ?></label>
                                            <div class="col-md-12">
                                                <div class="row-fluid">
                                                    <select class="form-control" data-live-search="true"
                                                            id="ref_mobile_bank" name="ref_mobile_bank">
                                                        <option value="0"><?= lang('select_one') ?></option>
                                                        <?php foreach ($mobile_banks as $key => $val) : ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label id="ref_mobile_bank-error" class="error"
                                                           for="ref_mobile_bank"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" id="v_ref_card" style="display:none;">
                                            <label class="col-sm-12 col-form-label"><?= lang('card') ?></label>
                                            <div class="col-md-12">
                                                <div class="row-fluid">
                                                    <select class="select2" data-live-search="true" id="ref_card"
                                                            name="ref_card">
                                                        <option value="0"><?= lang('select_one') ?></option>
                                                        <?php foreach ($cards as $key => $val) : ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label id="ref_card-error" class="error" for="ref_card"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" id="v_ref_acc_no" style="display:none;">
                                            <label class="col-sm-12 col-form-label"><?= lang('account_card_no'); ?></label>
                                            <div class="col-md-12">
                                                <input class="form-control" type="text" name="ref_acc_no"
                                                       id="ref_acc_no"">
                                                <label id="ref_acc_no-error" class="error" for="ref_acc_no"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" id="v_ref_trx_no" style="display:none;">
                                            <label class="col-sm-12 col-form-label"><?= lang('ref_trx_no'); ?></label>
                                            <div class="col-md-12">
                                                <input class="form-control" type="text" name="ref_trx_no"
                                                       id="ref_trx_no"">
                                                <label id="ref_trx_no-error" class="error" for="ref_trx_no"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-12 col-form-label" for=""><?= lang("note"); ?></label>
                                            <div class="col-sm-12">
                                                <textarea name="note" class="form-control" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" id="submit_order" name="order" value="order"
                                                    class="btn btn-primary right margin-top-10 submit_order"><?= lang("add_order"); ?></button>
                                            <button type="submit" id="submit_order" class="btn btn-primary right margin-top-10 margin-right-10 submit_order" name="print" value="print">
                                             Order & Print </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="orderDetails" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Order Invoice Details</h6>
            </div>
            <div class="modal-body">
                <div class="sale-view" id="order_view">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="sale_print()">Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"
                        onclick="window.location.replace('<?= base_url() ?>add-order')">Close
                </button>
            </div>
        </div>
    </div>
</div>



        <script>
        $(function () {
            $('#addSection tfoot').hide();
            $("select#account").change(function () {
                var option = $('option:selected', this).attr('actp');
                var value = $('option:selected', this).val();
                ref_acc_fields_by_account(option, value);
            });
            $("#pay_method").change(function () {
                ref_acc_fields_by_payment_method($(this).val());
            });

        });
        function addNewRow() {
            $('#search_name_error').html('');
            var id = $("#search_name option:selected").val();
            var count = 1
            $('input[name^="pro_id"]').each(function () {
                if ($(this).val() == id) {
                    count = 2;
                }
            });
            if (id != 0 && count == 1) {
                var rowCount = $('#addSection tbody tr').length;
                $.ajax({
                    url: "<?php echo base_url() . 'add-order/order-add-row';?>",
                    type: "post",
                    data: {id: id, row: rowCount},
                    success: function (res) {

                        if (rowCount > 0) {
                            $('#addSection tbody tr:last').after(res);
                        } else {
                            $('#addSection tbody').append(res);
                            $('#addSection tfoot').show();
                        }
                        totalCalculation();
                        $("#search_name").val(0).change();

                    }
                });
            } else if (count == 2) {
                $('#search_name_error').html('<span class="error"><?= lang("name_exist"); ?></span>');
            } else {
                $('#search_name_error').html('<span class="error"><?= lang("select_one"); ?></span>');
            }
        }
        function totalCalculation() {
            var subTotal = 0;
            $('input[name^="total_price"]').each(function () {
                var tp = $(this).val();
                subTotal = Number(subTotal) + Number(tp);
            });
            subTotal = parseFloat(subTotal).toFixed(2);
            var pay = ($('#pay_amount').val() == '') ? 0 : $('#pay_amount').val();
            $('input[name^="subTotal"]').val(subTotal);
            $('#subTotal').html(subTotal);
            var d = parseFloat((subTotal * 1) - (pay * 1)).toFixed(2);
            $('#due').html(d);
        }
        $(document).on('input', '#pay_amount', function () {
            totalCalculation();
        });
        $(document).on('input', '.cal_dis', function () {
            var m_id = this.id;
            var value= this.value;
           
            var id = m_id.split('_').pop(-1);
            var name=this.name;
            //var qty = $("#qty_" + id).val();
            var un_p = $("#unit_price_" + id).val();
            var qty = $("#qty_" + id).val();
            var discount_amount=0;
             if(name=='discount[]'){
                discount_amount= ((un_p * qty) * value) / 100;
                $('#discount_amt_'+id).val(discount_amount);
             }else if(name=='discount_amt[]'){
                var per=(value*100)/un_p;
                $('#discount_'+id).val(per);
                discount_amount=value;
             }
            var vat_tot = 0;
            var def_vat = $("#vat_" + id).val();
            vat_tot = (((un_p * qty) - discount_amount) * def_vat) / 100;
            $("#vat_amt_" + id).val(parseFloat(vat_tot).toFixed(2));
            var tot_val = ((qty * un_p) - discount_amount) + vat_tot;
            tot_val = parseFloat(tot_val).toFixed(2);
            $("#total_price_" + id).val(tot_val);
            totalCalculation();
        });
        $(document).on('input', '.change_value', function () {
            var m_id = this.id;
            var id = m_id.split('_').pop(-1);
            var qty = $("#qty_" + id).val();
            if (!$.isNumeric($(this).val())) {
                $(this).addClass("focus_error");
            } else {
                $(this).removeClass("focus_error");
                var discount_amount;
                var un_p = $("#unit_price_" + id).val();
                var discount = $("#discount_" + id).val();
                discount_amount = ((un_p * qty) * discount) / 100;
                var vat_tot = 0;
                var def_vat = $("#vat_" + id).val();
                vat_tot = (((un_p * qty) - discount_amount) * def_vat) / 100;
                $("#def_vat_amt_" + id).val(parseFloat(vat_tot).toFixed(2));
                var tot_val = ((qty * un_p) - discount_amount) + vat_tot;
                tot_val = parseFloat(tot_val).toFixed(2);
                $("#total_price_" + id).val(tot_val);
                totalCalculation();
            }
        });
        function temp_remove_product(id) {
            var rowCount = $('#addSection tbody tr').length;
            $('#' + id).closest('tr').remove();
            if (rowCount == 1) {
                $('#addSection tfoot').hide();
            } else {
                totalCalculation();
            }
        }

        function ref_acc_fields_by_account(acc_type_id, value) {
            if (acc_type_id == 2 || acc_type_id == 4) {
                $('#h_pay_method').val(1);
            } else if (acc_type_id == 3) {
                $('#h_pay_method').val(3);
            } else {
                $('#h_pay_method').val(0);
            }

            switch (acc_type_id) {
                case '1':  // Bank Account
                    $('#v_pay_method').show(500);
                    $('#v_ref_bank').hide(500);
                    $('#v_ref_mobile_bank').hide(500);
                    $('#v_ref_card').hide(500);
                    $('#v_ref_acc_no').hide(500);
                    $('#v_ref_trx_no').hide(500);
                    $('select#pay_method option').removeAttr("selected");
                    $('select#ref_card option').removeAttr("selected");
                    $('#ref_acc_no').val('');
                    $('#ref_trx_no').val('');
                    break;

                case '3':  // Mobile Bank Account
                    $('#v_pay_method').hide(500);
                    $('#v_ref_bank').hide(500);
                    $('#v_ref_mobile_bank').hide(500);
                    $('#v_ref_card').hide(500);
                    $('#v_ref_acc_no').show(500);
                    $('#v_ref_trx_no').show(500);
                    $('select#pay_method option').removeAttr("selected");
                    $('select#ref_card option').removeAttr("selected");
                    $('#ref_acc_no').val('');
                    $('#ref_trx_no').val('');
                    break;

                case '2':  // Cash Account
                default:   // other
                    $('#v_pay_method').hide(500);
                    $('#v_ref_bank').hide(500);
                    $('#v_ref_mobile_bank').hide(500);
                    $('#v_ref_card').hide(500);
                    $('#v_ref_acc_no').hide(500);
                    $('#v_ref_trx_no').hide(500);
                    $('select#pay_method option').removeAttr("selected");
                    $('select#ref_card option').removeAttr("selected");
                    $('#ref_acc_no').val('');
                    $('#ref_trx_no').val('');
                    break;
            }
        }
        function ref_acc_fields_by_payment_method(payment_method_id) {
//        $('#h_pay_method').val($('option:selected', this).attr('actp'));

            $('#h_pay_method').val(payment_method_id);

            switch (payment_method_id) {
                case '2':  // card
                    $('#v_ref_bank').hide(500);
                    $('#v_ref_mobile_bank').hide(500);
                    $('#v_ref_card').show(500);
                    $('#v_ref_acc_no').show(500);
                    $('#v_ref_trx_no').show(500);
                    $('select#ref_card option').removeAttr("selected");
                    $('#ref_acc_no').val('');
                    $('#ref_trx_no').val('');
                    break;

                case '3':  // mobile account
                    $('#v_ref_bank').hide(500);
                    $('#v_ref_mobile_bank').show(500);
                    $('#v_ref_card').hide(500);
                    $('#v_ref_acc_no').show(500);
                    $('#v_ref_trx_no').show(500);
                    $('select#pay_method option').removeAttr("selected");
                    $('select#ref_card option').removeAttr("selected");
                    $('#ref_acc_no').val('');
                    $('#ref_trx_no').val('');
                    break;

                case '4':  // check
                    $('#v_ref_bank').show(500);
                    $('#select#ref_bank').removeAttr("selected");
                    $('#v_ref_mobile_bank').hide(500);
                    $('#v_ref_card').hide(500);
                    $('#v_ref_acc_no').show(500);
                    $('#v_ref_trx_no').hide(500);
                    $('select#ref_card option').removeAttr("selected");
                    $('#ref_acc_no').val('');
                    $('#ref_trx_no').val('');
                    break;

                case '1':  // cash
                default:   // other
                    $('#v_ref_bank').hide(500);
                    $('#v_ref_mobile_bank').hide(500);
                    $('#v_ref_card').hide(500);
                    $('#v_ref_acc_no').hide(500);
                    $('#v_ref_trx_no').hide(500);
                    break;
            }
        }
        var button_pressed;
        $('.submit_order').click(function () {
            button_pressed = $(this).attr('name')
        });


        $("#addOrderSubmit").submit(function () {
            $('#error').html('');
               if(checkValidation()!= false) {
                var order_type = button_pressed;

                var dataString = new FormData($(this)[0]);
                dataString.append('order_type', order_type);
                $.ajax({
                    type: "POST",
                    url: URL + "sales_settings/add_order/add_order_submit",
                    data: dataString,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (result) {
                        $('.loading').fadeOut("slow");
                       
                        if (result != '3') {
                            $('#order_view').html(result);
                            $("#order_view").print({
                                globalStyles: false,
                                mediaPrint: false,
                                stylesheet: "<?= base_url(); ?>themes/default/css/a4_print.css",
                                iframe: false,
                                noPrintSelector: ".avoid-this",
                                // append : "Free jQuery Plugins!!!<br/>",
                                // prepend : "<br/>jQueryScript.net!"
                            });
                            window.location.replace("<?=base_url()?>add-order");
                        } else {
                            $('#showMessage').html("<?= lang('add_success')?>");
                            $('#showMessage').show();
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);
                                window.location.href = "<?= base_url()?>add-order";
                            }, 1000);
                        }

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
            return false;
        });
        function checkValidation(){
            $('#search_name').removeClass("focus_error");
            $('#customer_name').removeClass("focus_error");
            $('#sales_person').removeClass("focus_error");
            $('#customer_name_error').html('');
            $('#search_name_error').html('');
            $('#sales_person_error').html('');
            var rowCount = $('#addSection tbody tr').length;
            var cus_name = $('#customer_name option:selected').val();
            var sales_name = $('#sales_person option:selected').val();
            var pay_amount= $('#pay_amount').val();
            var count=1;
            if(rowCount<=0){
                $('#search_name_error').html('<span class="error"><?= lang("select_one"); ?></span>');
                $('#search_name').addClass("focus_error");
                count=2;
            }
            if(cus_name==0){
                $('#customer_name_error').html('<?= lang("select_one"); ?>');
                $('#customer_name').addClass("focus_error");
                count=2;
            }
            if(sales_name==0){
                $('#sales_person_error').html('<?= lang("select_one"); ?>');
                $('#sales_person').addClass("focus_error");
                count=2;
            }
            if(pay_amount!=''){
                var account = $('#account option:selected').val();
                if(account==0){
                    $('#account_error').html('<?= lang("select_one"); ?>');
                    count=2;
                }
            }
            return (count==1)?true:false;
        }


        function searchFilter(page_num) {
            page_num = page_num ? page_num : 0;
//        var name_customer = $('#name_customer').val();
//        var phone_customer = $('#phone_customer').val();
//        var type_of_customer = $('#type_of_customer').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>sales_person/paginate_data/' + page_num,
                data: 'page=' + page_num,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
            });
        }
    </script>