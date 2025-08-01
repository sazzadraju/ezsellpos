<ul class="breadcrumb">
    <?php echo isset($breadcrumb) ? $breadcrumb : ''; ?>
</ul>
<div class="col-md-12"> 
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div>

<script>
    function reset_all() {
    $('#fund_transfer_form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $("#acc_frm").val('0').change();
    $("#acc_to").val('0').change();
    $("#h_avl_amt").val('');
    $("#amount").val('');
    $("#description").val('');
    
    $('#h_avl_amt').val('');
    $('#avl_amt').text('');
    $('#v_avl_amt').hide();
}

function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
    $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>account-management/fund-transfer-records/' + page_num,
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (html) {
            $('#fund_trx_lst').html(html);
            $('.loading').fadeOut("slow");
        }
    });
}

function validate_data() {

    var err = false;

    var acc_frm = $("[name=acc_frm]").val();
    var acc_to = $("[name=acc_to]").val();
    var avl_amt = parseFloat($("input[name='h_avl_amt']").val(), 10);
    var amount = parseFloat($("input[name='amount']").val(), 10);

    if(acc_frm == "0" || acc_to == "0"){
        if (acc_frm == "0") {
            $('#acc_frm-error').html('Please Select Account.');
            setTimeout(function () {
                $('#acc_frm-error').html("");
            }, 2000);
            err = true;
        } if (acc_to == "0") {
            $('#acc_to-error').html('Please Select Account.');
            setTimeout(function () {
                $('#acc_to-error').html("");
            }, 2000);
            err = true;
        }
    } else if(acc_frm == acc_to){
        $('#acc_to-error').html('Please Select Different Account.');
        setTimeout(function () {
            $('#acc_to-error').html("");
        }, 2000);
        err = true;
    }
    
    if (amount == "" || isNaN(amount)) {
        $('#amount-error').html('Please Enter Amount.');
        setTimeout(function () {
            $('#amount-error').html("");
        }, 2000);
        err = true;
    }
    else if(amount > avl_amt){
        $('#amount-error').html('Sufficient Amout is not available.');
        setTimeout(function () {
            $('#amount-error').html("");
        }, 2000);
        err = true;
    }
    
    if (err === true) {
        return false;
    }
    return true;
}

$(function () {
    
    $("#fund_transfer_form").submit(function () {
        if (validate_data() !== false) {
            var form_data = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>account-management/add-fund-transfer',
                data: form_data,
                async: false,
                success: function (result) {
                    //console.log(result);
                    //alert(result);
                    var result = $.parseJSON(result);
                    if (result.status != 'success') {
                        $( "label.error" ).remove();
                        $(".error").removeClass("error");
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');
                        });
                    } else{
                        $('.loading').fadeOut("slow");
                        window.onload = searchFilter(0);
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        var $el = $('#fund_transfer_form');
                        $el.wrap('<form>').closest('form').get(0).reset();
                        $el.unwrap();
                        reset_all();
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);
                        }, 3000);                    
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
    });
    
    $("#acc_frm").change(function () {
        if($(this).val()=='0'){
            $('#h_avl_amt').val('');
            $('#v_avl_amt').hide(500);
        } else{
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url(); ?>account-management/account-current-banalce/' + $(this).val(),
                success: function (str) {
                    var fields = str.split('|');
                    $('#avl_amt').html(fields[1]);
                    $('#h_avl_amt').val(fields[0]);
                    $('#v_avl_amt').show(500);
                }
            });
        }   
    });
});
</script>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <!-- LEFT BLOCK STARTS -->
            <div class="col-lg-12">
                <div class="element-wrapper"> 
                    <div class="element-box full-box">
                        <h6 class="element-header" id="layout_title"><?= lang("fund_transfer_new"); ?></h6>
                        <?php echo form_open('', array('id' => 'fund_transfer_form', 'class' => 'cmxform')); ?>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for=""><?= lang("account_from"); ?></label>
                            <div class="row-fluid">
                                <select class="select2" data-live-search="true" id="acc_frm" name="acc_frm">
                                    <option actp="0" value="0"><?= lang('select_one') ?></option>
                                    <?php
                                    $i=1;
                                    $group='';
                                    if ($accounts_from) :
                                        foreach ($accounts_from as $account) :
                                            if($group != $account['store_name']){
                                                if($i == 1){
                                                    echo '<optgroup label="'.$account['store_name'].'">';
                                                }else{
                                                  echo '</optgroup>'; 
                                                  echo '<optgroup label="'.$account['store_name'].'">'; 
                                              }
                                              $group=$account['store_name'];
                                          }
                                          ?>
                                          <option actp="<?php echo $account['acc_type']; ?>" value="<?php echo $account['acc_id']; ?>">
                                            <?php echo!empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name']; ?>
                                            </option><?php
                                            $i++;
                                        endforeach;
                                    endif;
                                    ?>
                                </optgroup>
                            </select>
                            <label id="acc_frm-error" class="error" for="acc_frm"></label>
                        </div>
                        <div class="form-group row" id="v_avl_amt" style="display:none;">
                            <label class="col-sm-3 col-form-label"><?= lang("balance"); ?></label>
                            <div class="col-sm-9" id="avl_amt"></div>
                            <input type="hidden" name="h_avl_amt" id="h_avl_amt" value="">
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-3">
                        <label class="col-form-label" for=""><?= lang("acccount_to"); ?></label>
                        <div class="">
                            <div class="row-fluid">
                                <select class="select2" data-live-search="true" id="acc_to" name="acc_to">
                                    <option actp="0" value="0"><?= lang('select_one') ?></option>
                                    <?php
                                    if ($accounts_to) :
                                        foreach ($accounts_to as $account) :
                                            if($group != $account['store_name']){
                                                if($i == 1){
                                                    echo '<optgroup label="'.$account['store_name'].'">';
                                                }else{
                                                  echo '</optgroup>'; 
                                                  echo '<optgroup label="'.$account['store_name'].'">'; 
                                              }
                                              $group=$account['store_name'];
                                          }
                                          ?>
                                          <option actp="<?php echo $account['acc_type']; ?>" value="<?php echo $account['acc_id']; ?>">
                                            <?php echo!empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name']; ?>
                                            </option><?php
                                        endforeach;
                                    endif;
                                    ?>
                                </optgroup>
                            </select>
                            <label id="acc_to-error" class="error" for="acc_to"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label class="col-form-label" for="amount"><?= lang("amount"); ?></label>
                    <div class="">
                        <input class="form-control" type="text" name="amount" id="amount" value="" onkeypress="return amountInpt(this, event);">
                        <label id="amount-error" class="error"></label>
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label class="col-form-label"><?= lang('description') ?> </label>
                    <div class="">
                        <textarea class="form-control" rows="1" name="description" id="description" value="description"></textarea>
                        <label id="description-error" class="error" for="description"></label>
                    </div>
                </div>
                <div class="form-buttons-w col-sm-3">
                    <div class="col-md-12">
                        <button class="btn btn-primary" onclick="reset_all()" type="reset" ><?= lang("reset"); ?></button>
                        <button class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <!-- LEFT BLOCK ENDS -->
</div>
<div class="row">
    <!-- RIGHT BLOCK STARTS -->
    <div class="col-lg-12">
        <div class="element-wrapper"> 
            <div class="element-box full-box">
                <h6 class="element-header"><?=lang("fund_transfer_list");?></h6>
                <div class="table-responsive" id="fund_trx_lst">
                    <?php $this->load->view('fund_transfer/fund_transfer_records', $fund_records); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- RIGHT BLOCK ENDS -->
</div>
</div>
</div>