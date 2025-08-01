<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>var trx_with = '<?php echo $trx_with;?>';</script>
<script src="<?php echo base_url();?>themes/default/js/trx-add.js"></script>


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
                            <form class="form-horizontal" role="form" id="frm_trx_customer" action="" method="POST" enctype="multipart/form-data">
                                <!-- LEFT SIDE STARTS -->
                                <div class="col-md-7">
                                    <?php 
                                    $configs = $this->trxmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
                                    $sms_config = $this->trxmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 3));
                                    if($configs[0]->param_val<1 && $sms_config[0]->sms_send ==1){
                                        echo '<h3 class="error">Your SMS balance is zero. Please recharge.</h3>';
                                    }
                                    ?>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('trx_no'); ?></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <?php echo $trx_no; ?>
                                                <input type="hidden" name="trx_no" id="trx_no" value="<?php echo $trx_no; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('store') ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="form-control" data-live-search="true" id="store" name="store">
                                                    <option value=""><?= lang('select_one') ?></option>
                                                    <?php foreach ($stores as $key=>$val) : ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                    <?php endforeach;?>
                                                </select>
                                                <label id="store-error" class="error" for="store"></label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="qty_multiplier" id="qty_multiplier_2" value="1" />
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('customer'); ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <select class="select2" data-live-search="true" id="customer_name" name="supplier_name">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                            </select>
<!--                                            <input class="form-control" type="text" name="customer_name" id="customer_name" onkeyup="customerSuggest(this);">-->
                                            <input type="hidden" name="customer_id" id="customer_id" value="">
                                            <label id="customer_name-error" class="error" for="customer_name"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="upo" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('unpaid_orders') ?> <span class="req">*</span></label>
                                        <div class="col-md-8" id="unpaid_orders" style="font-size: .9em;"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('amount_paid'); ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="tot_amount" id="tot_amount" onkeypress="return amountInpt(this, event);">
                                            <label id="tot_amount-error" class="error" for="tot_amount"></label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('payment_date') ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class='input-group' id='dtt_trx'>
                                                <input type='text' readonly="" class="form-control" id="dtt_trx" name="dtt_trx" value="<?php echo $dtt_trx; ?>" />
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
                                            <textarea class="form-control" rows="3" name="description" id="description" value="description"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('account') ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="form-control" id="account" name="account">
                                                    <option actp="" value=""><?= lang('select_one') ?></option>
                                                    <?php if ($accounts) :
                                                        foreach ($accounts as $account) :
                                                            ?>
                                                            <option actp="<?php echo $account['acc_type']; ?>" value="<?php echo $account['acc_id']; ?>">
                                                            <?php echo !empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name']; ?>
                                                            </option><?php
                                                        endforeach;
                                                    endif;?>
                                                </select>
                                                <div id="account_balance"></div>
                                                <input type="hidden" id="h_pay_method" name="h_pay_method" value="" />
                                                <label id="account-error" class="error" for="account"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="v_pay_method" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('payment_method') ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="form-control" data-live-search="true" id="pay_method" name="pay_method">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($this->config->item('trx_payment_mehtods_by_bank') as $key=>$val) : ?>
                                                        <option value="<?php echo $key;?>"><?php echo $val; ?></option>
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
                                                <select class="form-control" data-live-search="true" id="ref_bank" name="ref_bank">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($general_banks as $key=>$val) : ?>
                                                        <option value="<?php echo $key;?>"><?php echo $val; ?></option>
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
                                                <select class="form-control" data-live-search="true" id="ref_mobile_bank" name="ref_mobile_bank">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($mobile_banks as $key=>$val) : ?>
                                                        <option value="<?php echo $key;?>"><?php echo $val; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label id="ref_mobile_bank-error" class="error" for="ref_mobile_bank"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="v_ref_card" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('card') ?></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" id="ref_card" name="ref_card">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($cards as $key=>$val) : ?>
                                                        <option value="<?php echo $key;?>"><?php echo $val; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label id="ref_card-error" class="error" for="ref_card"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="v_ref_acc_no" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('account_card_no'); ?></label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="ref_acc_no" id="ref_acc_no">
                                            <label id="ref_acc_no-error" class="error" for="ref_acc_no"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="v_ref_trx_no" style="display:none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('ref_trx_no'); ?></label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="ref_trx_no" id="ref_trx_no">
                                            <label id="ref_trx_no-error" class="error" for="ref_trx_no"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">&nbsp;</label>
                                        <div class="col-md-8">
                                            <button id="submit_btn" class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>
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
                                                <input class="form-control" placeholder="<?= lang('name') ?>" type="text" name="document_name" id="document_name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><?= lang('description') ?></label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" rows="3" name="document_description" id="document_description"></textarea>
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
        $("select#store").change(function(){
            var customer_id = parseInt($('#customer_id').val(), 10);
            if (isNaN(customer_id)) customer_id = 0;
            var store_id = parseInt($(this).val(), 10);
            if (isNaN(store_id)) store_id = 0;            
            customer_unpaid_orders( customer_id, store_id);
        });
    });



    function customerSuggest(elem)
    {
        $(elem).autocomplete({
            source: "<?php echo base_url(); ?>ajx-customers-by-key?key=" + $(elem).val(),
            autoFocus: true,
            minLength: 3,
            focus: function (event, ui) {
                event.preventDefault();
                $("#customer_name").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#customer_id").val(ui.item.value);
                $("#customer_name").val(ui.item.label);
                customer_unpaid_orders(ui.item.value, $('select#store').val());
            }
        });
    }

    function customer_unpaid_orders(customer_id, store_id)
    {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account-management/customer-unpaid-orders/'+customer_id+'/'+store_id,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#unpaid_orders').html(html);
                $('#upo').show().slideDown('fast');
                $('.loading').fadeOut("slow");
            }
        });
    }
    $('#customer_name').on('change', '', function (e) {
        var customer_id= this.value;
        var store_id= $('select#store').val();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account-management/customer-unpaid-orders/'+customer_id+'/'+store_id,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#customer_id').val(customer_id);
                $('#unpaid_orders').html(html);
                $('#upo').show().slideDown('fast');
                $('.loading').fadeOut("slow");
            }
        });
    });


    function validate_data() {

        var err = false;
        var token_no = $('#token_no').val();
        if(token_no==''){
            $('#customer_name-error').html('Multiple time submit now allow.');
            err = true;
        }
        if ($("#customer_name option:selected").val() == "0") {
            $('#customer_name-error').html('Please Select Customer.');
            setTimeout(function () {
                $('#customer_name-error').html("");
            }, 2000);
            err = true;
        }

        var tot_amount = parseFloat($("input[name='tot_amount']").val(), 10);
        var pay_amt_tot = parseFloat($("input[name='pay_amt_tot']").val(), 10);
        if (tot_amount == "") {
            $('#tot_amount-error').html('Please Enter Amount.');
            setTimeout(function () {
                $('#tot_amount-error').html("");
            }, 2000);
            err = true;
        }
        if (pay_amt_tot == "") {
            $('#pay_amt_tot-error').html('Please Enter Amount.');
            setTimeout(function () {
                $('#pay_amt_tot-error').html("");
            }, 2000);
            err = true;
        }
        if (tot_amount != "" && pay_amt_tot != "" && tot_amount != pay_amt_tot) {
            $('#tot_amount-error').html('Amounts should be Same.');
            $('#pay_amt_tot-error').html('Amounts should be Same.');
            setTimeout(function () {
                $('#tot_amount-error').html("");
                $('#pay_amt_tot-error').html("");
            }, 2000);
            err = true;
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

    $("#frm_trx_customer").submit(function () {
        $('#submit_btn').html('Processing...');
        $('#submit_btn').attr('disabled', 'disabled');
        if (validate_data() != false) {
            var data_string = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>account-management/add-customer-trx',
                data: data_string,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    $('.loading').fadeOut("slow");
                    var result = $.parseJSON(result);
                    if (result.status != 'success') {
                        $( "label.error" ).remove();
                        $(".error").removeClass("error");
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');
                        });
                    } else{
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>account-management/transactions/customer";
                        }, 2500);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        return false;
        }
        return false;
    });

    
</script>