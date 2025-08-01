<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>var trx_with = '<?php echo $trx_with;?>';</script>
<script src="<?php echo base_url(); ?>themes/default/js/trx-add.js"></script>

<ul class="breadcrumb">
    <?php echo isset($breadcrumb) ? $breadcrumb : ''; ?>
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
                        <h6 class="element-header"><?php echo $page_title; ?></h6>
                        <!-- MAIN BODY STARTS-->
                        <div class="row">
                            <form class="form-horizontal" role="form" id="frm_trx_supplier" action="" method="POST"
                                  enctype="multipart/form-data">
                                <!-- LEFT SIDE STARTS -->
                                <div class="col-md-7">
                                    <?php 
                                    $configs = $this->trxmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
                                    $sms_config = $this->trxmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 4));
                                    if($configs[0]->param_val<1 && $sms_config[0]->sms_send ==1){
                                        echo '<h3 class="error">Your SMS balance is zero. Please recharge.</h3>';
                                    }
                                    ?>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('trx_no'); ?></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <?php echo $trx_no; ?>
                                                <input type="hidden" name="trx_no" id="trx_no"
                                                       value="<?php echo $trx_no; ?>"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('store') ?> <span
                                                    class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="form-control" id="store" name="store">
                                                    <?php if (count($stores) > 1): ?>
                                                        <option value=""><?= lang('select_one') ?></option><?php endif; ?>
                                                    <?php foreach ($stores as $key => $val) : ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label id="store-error" class="error" for="store"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="qty_multiplier" id="qty_multiplier_2" value="-1"/>
                                    <?php /*?>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('type'); ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <div class="radio-inline">
                                                    <input type="radio" name="qty_multiplier" id="qty_multiplier_2" value="-1" checked />
                                                    <label for="qty_multiplier_2"><?php echo $qty_multipliers[-1]; ?></label>
                                                </div>
                                                <div class="radio-inline">
                                                    <input type="radio" name="qty_multiplier" id="qty_multiplier_1" value="1" />
                                                    <label for="qty_multiplier_1"><?php echo $qty_multipliers[1]; ?></label>
                                                </div>
                                                <label id="qty_multiplier-error" class="error"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php */ ?>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('supplier'); ?> <span
                                                    class="req">*</span></label>
                                        <div class="col-md-8">
                                            <select class="select2" data-live-search="true" id="supplier_name"
                                                    name="supplier_name">
                                                <?php
                                                if (!empty($suppliers)) {
                                                    echo '<option value="0">' . lang('select_one') . '</option>';
                                                    foreach ($suppliers as $supplier) {
                                                        echo '<option actp="' . $supplier->credit_balance . '" value="' . $supplier->id_supplier . '">' . $supplier->supplier_name . ' (' . $supplier->phone . ')' . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <!--                                            <input class="form-control" type="text" name="supplier_name" id="supplier_name" onkeyup="supplierSuggest(this);">-->
                                            <input type="hidden" name="supplier_id" id="supplier_id" value="">
                                            <label id="supplier_name-error" class="error" for="supplier_name"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <input type="radio" id="unpaid_order" name="payment_type" value="1" checked><label
                                                    for="unpaid_order">Unpaid Order</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" id="advance_payment" name="payment_type"
                                                   value="2"><label for="advance_payment">Advance Payment</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" id="refund" name="payment_type" value="3"><label
                                                    for="refund">Refund Amount</label>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="upo" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('unpaid_purchases') ?> <span
                                                    class="req">*</span></label>
                                        <div class="col-md-8" id="unpaid_purchases" style="font-size: .9em;"></div>
                                    </div>
                                    <div class="form-group row" id="credit_check_div" style="display:none;">
                                        <div class="col-md-4">
                                            <input type="radio" id="cash" name="amount_type" value="1" checked><label
                                                    for="cash">Cash</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" id="credit_balance" name="amount_type" value="2"><label
                                                    for="credit_balance">Credit Amount</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" id="both" name="amount_type" value="3"><label
                                                    for="both">Both</label>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="refund_div" style="display:none;">
                                        <label class="col-sm-4 col-form-label">Credit Balance</label>
                                        <div class="col-md-3">
                                            <input class="form-control" type="text" name="debit_amount_org"
                                                   id="debit_amount_org" readonly>
                                        </div>
                                        <div class="col-md-5">
                                            <input class="form-control show_total" type="text" name="debit_amount"
                                                   id="debit_amount" onkeypress="return amountInpt(this, event);">
                                            <label id="debit_amount-error" class="error" for="tot_amount"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="amount_div">
                                        <label class="col-sm-4 col-form-label"><?= lang('amount_pay'); ?> <span
                                                    class="req">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control show_total" type="text" name="tot_amount"
                                                   id="tot_amount"
                                                   onkeypress="return amountInpt(this, event);">
                                            <label id="tot_amount-error" class="error" for="tot_amount"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="font-weight: 600;text-align: right; margin-right: 20px;"><span>Total: </span><span id="tot_sub_p" ></span></div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('payment_date') ?> <span
                                                    class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class='input-group' id='dtt_trx'>
                                                <input type='text' readonly="" class="form-control" id="dtt_trx" name="dtt_trx" value="<?php echo $dtt_trx; ?>"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <label id="dtt_trx-error" class="error" for="dtt_trx"></label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('description') ?> </label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" rows="3" name="description" id="description"
                                                      value="description"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('account') ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="form-control" id="account" name="account">
                                                    <option actp="0" value=""><?= lang('select_one') ?></option>
                                                    <?php if ($accounts) :
                                                        foreach ($accounts as $account) :
                                                            ?>
                                                        <option actp="<?php echo $account['acc_type']; ?>"
                                                                value="<?php echo $account['acc_id']; ?>">
                                                            <?php echo !empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name']; ?>
                                                            </option><?php
                                                        endforeach;
                                                    endif; ?>
                                                </select>
                                                <div id="account_balance"></div>
                                                <input type="hidden" id="h_pay_method" name="h_pay_method" value=""/>
                                                <label id="account-error" class="error" for="account"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="v_pay_method" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('payment_method') ?> <span
                                                    class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="form-control" id="pay_method" name="pay_method">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($this->config->item('trx_payment_mehtods_for_office') as $key => $val) : ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label id="pay_method-error" class="error" for="pay_method"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="v_ref_bank" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('bank') ?></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="form-control" id="ref_bank" name="ref_bank">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($general_banks as $key => $val) : ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label id="ref_bank-error" class="error" for="ref_bank"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="v_ref_mobile_bank" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('mobile_bank') ?></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="form-control" id="ref_mobile_bank"
                                                        name="ref_mobile_bank">
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

                                    <div class="form-group row" id="v_ref_card" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('card') ?></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="form-control" id="ref_card" name="ref_card">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($cards as $key => $val) : ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label id="ref_card-error" class="error" for="ref_card"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="v_ref_acc_no" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('account_card_no'); ?></label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="ref_acc_no" id="ref_acc_no"">
                                            <label id="ref_acc_no-error" class="error" for="ref_acc_no"></label>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="v_ref_trx_no" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('ref_trx_no'); ?></label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="ref_trx_no" id="ref_trx_no"">
                                            <label id="ref_trx_no-error" class="error" for="ref_trx_no"></label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">&nbsp;</label>
                                        <div class="col-md-8">
                                            <input type="hidden" name="token_no" id="token_no" value="<?= rand()?>" >
                                            <button id="submit_btn" class="btn btn-primary"
                                                    type="submit"> <?= lang("submit"); ?></button>
                                        </div>
                                    </div>
                                </div>
                                <!-- LEFT SIDE ENDS -->

                                <!-- RIGHT SIDE STARTS -->
                                <div class="col-md-5">
                                    <fieldset class="form-group">
                                        <legend><?= lang('documents') ?></legend>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for=""><?= lang('name') ?></label>
                                            <div class="col-sm-8">
                                                <input class="form-control" placeholder="<?= lang('name') ?>"
                                                       type="text" name="document_name" id="document_name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><?= lang('description') ?></label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" rows="3" name="document_description"
                                                          id="document_description"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><?= lang('select_file') ?></label>
                                            <div class="col-sm-8">
                                                <input type="file" name="document_file" id="document_file">
                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <!-- RIGHT SIDE ENDS -->
                            </form>
                        </div>
                        <!-- MAIN BODY ENDS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $(function () {

        $('input.show_total').on('input', function (e) {
            var d = $('#debit_amount').val() * 1;
            var t = $('#tot_amount').val() * 1;
            $('#tot_sub_p').html(d + t);
        });
        $("select#store").change(function () {
            var supplier_id = parseInt($('#supplier_id').val(), 10);
            if (isNaN(supplier_id)) supplier_id = 0;
            var store_id = parseInt($(this).val(), 10);
            if (isNaN(store_id)) store_id = 0;
            supplier_unpaid_orders(supplier_id, store_id);
        });
    });

    var x = 1;
    function addMoreDoc() {
        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
        $('input[name="total_num_of_fields"]').val(total_fields + 1);
        var maxField = 3;
        var addButton = $('#add_more');
        var wrapper = $('#add_more_section');
        var fieldHTML = "<fieldset class='form-group' id='" + x + "'><legend>" + "<?= lang('documents') ?>" + "</legend><div class='form-group row'><label class='col-sm-4 col-form-label'>" + "<?= lang('name') ?>" + "</label><div class='col-sm-8'><input class='form-control' placeholder='" + "<?= lang('name') ?>" + "' type='text' name='document_name[]' id='document_name'></div></div><div class='form-group row'><label class='col-sm-4 col-form-label'>" + "<?= lang('description') ?>" + "</label><div class='col-sm-8'><textarea class='form-control' rows='3' name='document_description[]' id='document_description'></textarea></div></div><div class='form-group row'><label class='col-sm-4 col-form-label'>Select File</label><div class='col-sm-8'><input type='file' name='document_file[]' id='document_file'></div></div><div class='element-box-content2'><button class='mr-2 mb-2 btn btn-danger btn-rounded' type='button' onclick='removeMore(" + x + ");'><i class='fa fa-minus'></i>" + "</button></div></fieldset>";

        if (x < maxField) {
            x++;
            $(wrapper).append(fieldHTML);
        }
    }

    function removeMore(id) {
        $("#" + id).remove();
        x--;
        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
        $('input[name="total_num_of_fields"]').val(total_fields - 1);
    }

    function supplierSuggest(elem) {
        $(elem).autocomplete({
            source: "<?php echo base_url(); ?>ajx-suppliers-by-key?key=" + $(elem).val(),
            autoFocus: true,
            minLength: 3,
            focus: function (event, ui) {
                event.preventDefault();
                $("#supplier_name").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#supplier_id").val(ui.item.value);
                $("#supplier_name").val(ui.item.label);

                var supplier_id = parseInt(ui.item.value, 10);
                if (isNaN(supplier_id)) supplier_id = 0;
                var store_id = parseInt($('select#store').val(), 10);
                if (isNaN(store_id)) store_id = 0;

                supplier_unpaid_orders(supplier_id, store_id);
            }
        });
    }


    function supplier_unpaid_orders(supplier, store_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account-management/supplier-unpaid-purchases/' + supplier + '/' + store_id,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#unpaid_purchases').html(html);
                $('#upo').show().slideDown('fast');
                $('.loading').fadeOut("slow");
            }
        });
    }
    $('#supplier_name').on('change', '', function (e) {
        var supplier = this.value;
        var store_id = $('select#store').val();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account-management/supplier-unpaid-purchases/' + supplier + '/' + store_id,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#supplier_id').val(supplier);
                $('#unpaid_purchases').html(html);
                $('#upo').show().slideDown('fast');
                $('.loading').fadeOut("slow");
                $('#credit_check_div').show(500);
            }
        });
    });


    function validate_data() {

        var err = false;
        var token_no = $('#token_no').val();
        if(token_no==''){
            $('#supplier_name-error').html('Multiple time submit now allow.');
            err = true;
        }
        if ($("#supplier_name option:selected").val() == "0") {
            $('#supplier_name-error').html('Please Select Supplier.');
            setTimeout(function () {
                $('#supplier_name-error').html("");
            }, 5000);
            err = true;
        }
        var pa_type = $("input[name='payment_type']:checked").val() * 1;
        var tot_amount = $("input[name='tot_amount']").val() * 1;
        var pay_amt_tot = $("input[name='pay_amt_tot']").val() * 1;
        var debit_amount = $("input[name='debit_amount']").val() * 1;
        var debit_amount_org = $("input[name='debit_amount_org']").val() * 1;
        var acc_bal = parseFloat($('#account_balance').html(), 10);
        var type = $("input[name='amount_type']:checked").val() * 1;
        if (pa_type == 1) {
            $('input.pay_amt_cls').each(function () {
                var val = parseFloat($(this).val());
                var ids = $(this).attr('id');
                var id = ids.split('_').pop(-1);
                var due = $('#tot_d_' + id).html();
                $('#pay_amt_' + id).removeClass("error");
                if (val > due) {
                    $('#pay_amt_' + id).addClass("error");
                    err = true;
                }
            });
        }
        if (pa_type == 1 && type == 1) {
            if (tot_amount == "") {
                $('#tot_amount-error').html('Please Enter Amount.');
                setTimeout(function () {
                    $('#tot_amount-error').html("");
                }, 5000);
                err = true;
            }
            if (pay_amt_tot == "") {
                $('#pay_amt_tot-error').html('Please Enter Amount.');
                setTimeout(function () {
                    $('#pay_amt_tot-error').html("");
                }, 5000);
                err = true;
            }
            if (tot_amount != "" && pay_amt_tot != "" && tot_amount != pay_amt_tot) {
                $('#tot_amount-error').html('Amounts should be Same.');
                $('#pay_amt_tot-error').html('Amounts should be Same.');
                setTimeout(function () {
                    $('#tot_amount-error').html("");
                    $('#pay_amt_tot-error').html("");
                }, 5000);
                err = true;
            }
            if (tot_amount > acc_bal) {
                $('#tot_amount-error').html('Not available balance.');
                setTimeout(function () {
                    $('#tot_amount-error').html("");
                }, 5000);
                err = true;
            }
        }
        if (pa_type == 1 && type == 2) {
            if (debit_amount == "") {
                $('#debit_amount-error').html('Please Enter Amount.');
                setTimeout(function () {
                    $('#debit_amount-error').html("");
                }, 5000);
                err = true;
            }
            if (pay_amt_tot == "") {
                $('#pay_amt_tot-error').html('Please Enter Amount.');
                setTimeout(function () {
                    $('#pay_amt_tot-error').html("");
                }, 5000);
                err = true;
            }
            if (debit_amount > debit_amount_org) {
                $('#debit_amount-error').html('Greater than value not allow.');
                setTimeout(function () {
                    $('#debit_amount-error').html("");
                }, 5000);
                err = true;
            }
            if (debit_amount != pay_amt_tot) {
                $('#debit_amount-error').html('Amounts should be Same.');
                $('#pay_amt_tot-error').html('Amounts should be Same.');
                setTimeout(function () {
                    $('#debit_amount-error').html("");
                    $('#pay_amt_tot-error').html("");
                }, 5000);
                err = true;
            }
        }
        if (pa_type == 1 && type == 3) {
            if (debit_amount == "") {
                $('#debit_amount-error').html('Please Enter Amount.');
                setTimeout(function () {
                    $('#debit_amount-error').html("");
                }, 5000);
                err = true;
            }
            if (tot_amount == "") {
                $('#tot_amount-error').html('Please Enter Amount.');
                setTimeout(function () {
                    $('#tot_amount-error').html("");
                }, 5000);
                err = true;
            }
            if (pay_amt_tot == "") {
                $('#pay_amt_tot-error').html('Please Enter Amount.');
                setTimeout(function () {
                    $('#pay_amt_tot-error').html("");
                }, 5000);
                err = true;
            }
            if (debit_amount > debit_amount_org) {
                $('#debit_amount-error').html('Greater than value not allow.');
                setTimeout(function () {
                    $('#debit_amount-error').html("");
                }, 5000);
                err = true;
            }
            if ((debit_amount + tot_amount) != pay_amt_tot) {
                $('#tot_amount-error').html('This and credit should be same total value.');
                $('#pay_amt_tot-error').html('Amounts should be Same.');
                setTimeout(function () {
                    $('#tot_amount-error').html("");
                    $('#pay_amt_tot-error').html("");
                }, 5000);
                err = true;
            }
        }
        if (pa_type == 2) {
            if (tot_amount == "") {
                $('#tot_amount-error').html('Please Enter Amount.');
                setTimeout(function () {
                    $('#tot_amount-error').html("");
                }, 5000);
                err = true;
            }
        }
        if (pa_type == 3) {
            if (debit_amount == "") {
                $('#debit_amount-error').html('Please Enter Amount.');
                setTimeout(function () {
                    $('#debit_amount-error').html("");
                }, 5000);
                err = true;
            }
            if (debit_amount > debit_amount_org) {
                $('#debit_amount-error').html('Greater than value not allow.');
                setTimeout(function () {
                    $('#debit_amount-error').html("");
                }, 5000);
                err = true;
            }
        }
        if ($("input[name=dtt_trx]").val() == "") {
            $('#dtt_trx-error').html('Please Enter Date.');
            setTimeout(function () {
                $('#dtt_trx-error').html("");
            }, 2000);
            err = true;
        }
        if ($("[name=store]").val() == "") {
            $('#store-error').html('Please Select Store.');
            setTimeout(function () {
                $('#store-error').html("");
            }, 2000);
            err = true;
        }
        if ($("[name=account]").val() == "") {
            $('#account-error').html('Please Select Account.');
            setTimeout(function () {
                $('#account-error').html("");
            }, 2000);
            err = true;
        }

        if (err == true) {
            $('#submit_btn').html('Submit');
            $('#submit_btn').removeAttr('disabled');
            return false;
        }
        $('#token_no').val('');
        return true;
    }

    $("#frm_trx_supplier").submit(function () {
        $('#submit_btn').html('Processing...');
        $('#submit_btn').attr('disabled', 'disabled');
        if (validate_data() != false) {
            var data_string = new FormData($(this)[0]);

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>account-management/add-supplier-trx',
                data: data_string,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    console.log(result);
                    var result = $.parseJSON(result);
                    if (result.status != 'success') {
                        $("label.error").remove();
                        $(".error").removeClass("error");
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');
                        });
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        $('.loading').fadeOut("slow");
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>account-management/transactions/supplier";
                        }, 2500);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
    });
</script>