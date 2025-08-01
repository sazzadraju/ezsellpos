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
                            <form class="form-horizontal" role="form" id="frm_trx_office" action="" method="POST" enctype="multipart/form-data">
                                <!-- LEFT SIDE STARTS -->
                                <div class="col-md-7">
                                    <?php 
                                    $configs = $this->trxmodel->getvalue_row('configs', 'param_val,utilized_val', array('param_key' => 'SMS_CONFIG'));
                                    $sms_config = $this->trxmodel->getvalue_row('sms_config', 'sms_send', array('id_sms_config' => 7));
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
                                                <select class="form-control" id="store" name="store">
                                                    <?php if(count($stores)>1):?><option value=""><?= lang('select_one') ?></option><?php endif;?>
                                                    <?php foreach ($stores as $key=>$val) : ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                    <?php endforeach;?>
                                                </select>
                                                <label id="store-error" class="error" for="store"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('investor'); ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control" id="investor_id" name="investor_id">
                                                <option value=""><?= lang('select_one') ?></option>
                                                <?php foreach ($investors as $key=>$val) : ?>
                                                    <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <label id="investor_id-error" class="error" for="store"></label>
                                        </div>
                                    </div>

                                    <?php /*?>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('type'); ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <div class="radio-inline">
                                                    <input type="radio" name="qty_multiplier" id="qty_multiplier_1" value="1" checked />
                                                    <label for="qty_multiplier_1"><?php echo $qty_multipliers[1]; ?></label>
                                                </div>
                                                <div class="radio-inline">
                                                    <input type="radio" name="qty_multiplier" id="qty_multiplier_2" value="-1" />
                                                    <label for="qty_multiplier_2"><?php echo $qty_multipliers[-1]; ?></label>
                                                </div>
                                                <div class="radio-inline">
                                                    <input type="radio" name="qty_multiplier" id="qty_multiplier_0" value="0" />
                                                    <label for="qty_multiplier_0"><?php echo $qty_multipliers[0]; ?></label>
                                                </div>
                                                <label id="qty_multiplier-error" class="error"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php */?>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('type'); ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control" id="qty_multiplier" name="qty_multiplier">
                                                <option value="-100"><?= lang('select_one') ?></option>
                                                <?php foreach ($qty_multipliers as $key=>$val) : ?>
                                                <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <label id="qty_multiplier-error" class="error"></label>
                                        </div>
                                    </div>

                                    <?php /*if (isset($trx_types[1]) && !empty($trx_types[1])): ?>
                                    <div class="form-group row" id="tt_invest">
                                        <label class="col-sm-4 col-form-label"><?= lang('invest') ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" id="tt_invest" name="tt_invest">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($trx_types[1] as $k=>$v) : ?>
                                                        <option value="<?=$k; ?>"><?=$v; ?></option><?php
                                                    endforeach; ?>
                                                </select>
                                                <label id="tt_invest-error" class="error" for="tt_invest"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif;?>
                                    <?php if (isset($trx_types[-1]) && !empty($trx_types[-1])): ?>
                                    <div class="form-group row" id="tt_withdraw" style="display: none;">
                                        <label class="col-sm-4 col-form-label"><?= lang('withdraw') ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" id="tt_withdraw" name="tt_withdraw">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($trx_types[-1] as $k=>$v) : ?>
                                                        <option value="<?=$k; ?>"><?=$v; ?></option><?php
                                                    endforeach; ?>
                                                </select>
                                                <label id="tt_withdraw-error" class="error" for="tt_withdraw"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif;*/?>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('description') ?> </label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" rows="3" name="description" id="description" value="description"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('amount'); ?> <span class="req">*</span></label>
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
                                        <label class="col-sm-4 col-form-label"><?= lang('account') ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="form-control" id="account" name="account">
                                                    <option actp="0" value=""><?= lang('select_one') ?></option>
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
                                                <select class="form-control" id="pay_method" name="pay_method">
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
                                                <select class="form-control" id="ref_bank" name="ref_bank">
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
                                                <select class="form-control" id="ref_mobile_bank" name="ref_mobile_bank">
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
                                                <select class="form-control" id="ref_card" name="ref_card">
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
    var x = 1;
    function addMoreDoc()
    {
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

    function removeMore(id)
    {
        $("#" + id).remove();
        x--;
        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
        $('input[name="total_num_of_fields"]').val(total_fields - 1);
    }

    function investorSuggest(elem)
    {
        $(elem).autocomplete({
            source: "<?php echo base_url(); ?>ajx-investors-by-key?key=" + $(elem).val(),
            autoFocus: true,
            minLength: 3,
            focus: function (event, ui) {
                event.preventDefault();
                $("#investor_name").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#investor_id").val(ui.item.value);
                $("#investor_name").val(ui.item.label);
            }
        });
    }

    function validate_data() {

        var err = false;
        var token_no = $('#token_no').val();
        if(token_no==''){
            $('#qty_multiplier-error').html('Multiple time submit now allow.');
            err = true;
        }
        //var qmv = $('input[name=qty_multiplier]:checked').val();
        var qmv = $('select#qty_multiplier').val();
        if (qmv == "-100" || typeof qmv == 'undefined') {
            $('#qty_multiplier-error').html('Please Select Type.');
            setTimeout(function () {
                $('#qty_multiplier-error').html("");
            }, 4000);
            err = true;
        } else{
            if(qmv == '-1' && $('input[name=tt_withdraw]').val()=='0'){
                $('#tt_withdraw-error').html('Please Select Witdraw.');
                setTimeout(function () {
                    $('#tt_withdraw-error').html("");
                }, 4000);
                err = true;
            }
            if(qmv == '1' && $('input[name=tt_invest]').val()=='0'){
                $('#tt_invest-error').html('Please Select Invest.');
                setTimeout(function () {
                    $('#tt_invest-error').html("");
                }, 4000);
                err = true;
            }
        }
        var emp=$('#investor_id option:selected').val();
        if (emp == '') {
            $('#investor_id-error').html('Please Select Investor.');
            setTimeout(function () {
                $('#investor_id-error').html("");
            }, 4000);
            err = true;
        }
        var tot_amount =$("input[name='tot_amount']").val();
        if (tot_amount == "") {
            $('#tot_amount-error').html('Please Enter Amount.');
            setTimeout(function () {
                $('#tot_amount-error').html("");
            }, 4000);
            err = true;
        }
        var acc_bal=parseFloat($('#account_balance').html(), 10);
        if(tot_amount>acc_bal&&qmv != '1'){
            $('#tot_amount-error').html('Not available balance.');
            setTimeout(function () {
                $('#tot_amount-error').html("");
            }, 4000);
            err = true;
        }
        if ($("input[name=dtt_trx]").val() == "") {
            $('#dtt_trx-error').html('Please Enter Date.');
            setTimeout(function () {
                $('#dtt_trx-error').html("");
            }, 4000);
            err = true;
        }
        if ($("[name=store]").val() == "") {
            $('#store-error').html('Please Select Store.');
            setTimeout(function () {
                $('#store-error').html("");
            }, 4000);
            err = true;
        }
        if ($("[name=account]").val() == "") {
            $('#account-error').html('Please Select Account.');
            setTimeout(function () {
                $('#account-error').html("");
            }, 4000);
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

    $("#frm_trx_office").submit(function () {
        $('#submit_btn').html('Processing...');
        $('#submit_btn').attr('disabled', 'disabled');
        if (validate_data() != false) {
            var data_string = new FormData($(this)[0]);
            
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>account-management/add-investor-trx',
                data: data_string,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    console.log(result);
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
                        $('.loading').fadeOut("slow");
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>account-management/transactions/investor";
                        }, 2000);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
        $('.loading').fadeOut("slow");
    });
    
    
    $(function () {        
        $("input:radio[name=qty_multiplier]").click(function(){
           if($(this).val() == 1){
               $('#tt_withdraw').hide();
               $('#tt_invest').show();
           } else {
               $('#tt_withdraw').show();
               $('#tt_invest').hide();
           }
        });        
    });
</script>