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
<?php
$d_name = $id_document = $d_description = $d_file = '';
if (!empty($documents)) {
    $d_name = ($documents[0]['name']) ? $documents[0]['name'] : '';
    $id_document = ($documents[0]['id_document']) ? $documents[0]['id_document'] : '';
    $d_description = ($documents[0]['description']) ? $documents[0]['description'] : '';
    $d_file = ($documents[0]['file']) ? $documents[0]['file'] : '';
}
?>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <h6 class="element-header"><?php echo $page_title; ?></h6>
                        <!-- MAIN BODY STARTS-->
                        <div class="row">
                            <form class="form-horizontal" role="form" id="frm_trx_office" action="" method="POST"
                                  enctype="multipart/form-data">
                                <!-- LEFT SIDE STARTS -->
                                <div class="col-md-7">

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
                                        <label class="col-sm-4 col-form-label"><?= lang('store') ?> </label>
                                        <div class="col-md-8">
                                            <?php echo get_key($stores, $store_id); ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('type'); ?> <span
                                                class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <?php echo get_key($qty_multipliers, $qty_multiplier); ?>
                                                <input type="hidden" name="qty_multiplier" id="qty_multiplier"
                                                       value="<?= $qty_multiplier; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($qty_multiplier == -1): ?>
                                        <div class="form-group row" id="v_tt_expense">
                                            <label class="col-sm-4 col-form-label"><?= lang('expense') ?> <span
                                                    class="req">*</span></label>
                                            <div class="col-md-8">
                                                <div class="row-fluid">
                                                    <select class="select2 tt" data-live-search="true" id="tt_expense"
                                                            name="tt_expense">
                                                        <option value="0"><?= lang('select_one') ?></option>
                                                        <?php foreach ($trx_types[-1] as $k => $v) : ?>
                                                            <option value="<?= $k; ?>" <?php if ($k == $type_id) {
                                                                echo 'selected';
                                                            } ?>><?= $v; ?></option><?php
                                                        endforeach; ?>
                                                    </select>
                                                    <label id="tt_expense-error" class="error" for="tt_expense"></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($qty_multiplier == 1): ?>
                                        <div class="form-group row" id="v_tt_income">
                                            <label class="col-sm-4 col-form-label"><?= lang('income') ?> </label>
                                            <div class="col-md-8">
                                                <div class="row-fluid">
                                                    <select class="select2 tt" data-live-search="true" id="tt_income"
                                                            name="tt_income">
                                                        <option value="0"><?= lang('select_one') ?></option>
                                                        <?php foreach ($trx_types[1] as $k => $v) : ?>
                                                            <option value="<?= $k; ?>" <?php if ($k == $type_id) {
                                                                echo 'selected';
                                                            } ?>><?= $v; ?></option><?php
                                                        endforeach; ?>
                                                    </select>
                                                    <label id="tt_income-error" class="error" for="tt_income"></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;
                                    $arr = $this->trxmodel->office_trx_child_categories($type_id, $qty_multiplier); ?>
                                    <div class="form-group row" id="v_tt_child"
                                         <?php if (empty($arr)): ?>style="display: none;"<?php endif; ?>>

                                        <label class="col-sm-4 col-form-label"><?= lang('') ?></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid" id="off_ch">
                                                <?php if (!empty($child_type_id)): ?>
                                                <select class="select2" data-live-search="true" id="tt_child" name="tt_child">
                                                        <option value="0"><?= lang('select_one') ?></option><?php
                                                        foreach ($arr as $k => $v) {
                                                            ?>
                                                            <option value="<?= $k; ?>" <?php if ($child_type_id == $k) {
                                                                echo 'selected';
                                                            } ?>><?= $v; ?></option><?php
                                                        } ?>

                                                </select>
                                                <?php endif; ?>
                                                <label id="tt_child-error" class="error" for="tt_child"></label>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('description') ?> </label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" rows="3" name="description" id="description"
                                                      value="description"><?= $description; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('amount'); ?> <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="tot_amount" id="tot_amount"
                                                   value="<?= $tot_amount; ?>"
                                                   onkeypress="return amountInpt(this, event);">
                                            <label id="tot_amount-error" class="error" for="tot_amount"></label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= lang('payment_date') ?> <span
                                                class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class='input-group date' id='dtt_trx'>
                                                <input type='text' class="form-control" id="dtt_trx" name="dtt_trx"
                                                       value="<?php echo $dtt_trx; ?>"/>
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
                                                <select class="select2" data-live-search="true" id="account"
                                                        name="account">
                                                    <option actp="0" value="0"><?= lang('select_one') ?></option>
                                                    <?php
                                                    $acc_val = '';
                                                    if ($accounts) :
                                                        foreach ($accounts as $account) :
                                                            if ($account_id == $account['acc_id']) {
                                                                $acc_val = $account['curr_balance'];
                                                            }
                                                            ?>
                                                        <option actp="<?php echo $account['acc_type']; ?>"
                                                                value="<?php echo $account['acc_id']; ?>" <?php if ($account_id == $account['acc_id']): ?> selected<?php endif; ?>>
                                                            <?php echo !empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name']; ?>
                                                            </option><?php
                                                        endforeach;
                                                    endif; ?>
                                                </select>
                                                <div id="account_balance"><?php echo $acc_val; ?></div>
                                                <input type="hidden" id="h_pay_method" name="h_pay_method"
                                                       value="<?php echo $payment_method_id; ?>"/>
                                                <label id="account-error" class="error" for="account"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="v_pay_method"
                                         <?php if ($acc_type_id != 1): ?>style="display:none;"<?php endif; ?>>
                                        <label class="col-sm-4 col-form-label"><?= lang('payment_method') ?> <span
                                                class="req">*</span></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" id="pay_method"
                                                        name="pay_method">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($this->config->item('trx_payment_mehtods_for_office') as $key => $val) : ?>
                                                        <option
                                                            value="<?php echo $key; ?>" <?php if ($key == $payment_method_id): ?> selected<?php endif; ?>><?php echo $val; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label id="pay_method-error" class="error" for="pay_method"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $display = false;
                                    if ($payment_method_id == 4) {
                                        $display = true;
                                    } ?>
                                    <div class="form-group row" id="v_ref_bank"
                                         <?php if (!$display): ?>style="display:none;"<?php endif; ?>>
                                        <label class="col-sm-4 col-form-label"><?= lang('bank') ?></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" id="ref_bank"
                                                        name="ref_bank">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($general_banks as $key => $val) : ?>
                                                        <option
                                                            value="<?php echo $key; ?>" <?php if ($key == $ref_bank_id): ?> selected<?php endif; ?>><?php echo $val; ?></option>
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
                                                <select class="select2" data-live-search="true" id="ref_mobile_bank"
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
                                    <?php
                                    $display = false;
                                    if ($payment_method_id == 2) {
                                        $display = true;
                                    } ?>
                                    <div class="form-group row" id="v_ref_card"
                                         <?php if (!$display): ?>style="display:none;"<?php endif; ?>>
                                        <label class="col-sm-4 col-form-label"><?= lang('card') ?></label>
                                        <div class="col-md-8">
                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" id="ref_card"
                                                        name="ref_card">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php foreach ($cards as $key => $val) : ?>
                                                        <option
                                                            value="<?php echo $key; ?>" <?php if ($key == $ref_card_id): ?> selected<?php endif; ?>><?php echo $val; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label id="ref_card-error" class="error" for="ref_card"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $display = false;
                                    if ((in_array($payment_method_id, [2, 4])) || $acc_type_id == 3) {
                                        $display = true;
                                    } ?>
                                    <div class="form-group row" id="v_ref_acc_no"
                                         <?php if (!$display): ?>style="display:none;"<?php endif; ?>>
                                        <label class="col-sm-4 col-form-label"><?= lang('account_card_no'); ?></label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="ref_acc_no" id="ref_acc_no"
                                                   value="<?= $ref_acc_no; ?>">
                                            <label id="ref_acc_no-error" class="error" for="ref_acc_no"></label>
                                        </div>
                                    </div>
                                    <?php
                                    $display = false;
                                    if (($payment_method_id == 2) || $acc_type_id == 3) {
                                        $display = true;
                                    } ?>
                                    <div class="form-group row" id="v_ref_trx_no"
                                         <?php if (!$display): ?>style="display:none;"<?php endif; ?>>
                                        <label class="col-sm-4 col-form-label"><?= lang('ref_trx_no'); ?></label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="ref_trx_no" id="ref_trx_no"
                                                   value="<?= $ref_trx_no; ?>">
                                            <label id="ref_trx_no-error" class="error" for="ref_trx_no"></label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">&nbsp;</label>
                                        <div class="col-md-8">
                                            <button class="btn btn-primary"
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
                                                       type="text" name="document_name" id="document_name"
                                                       value="<?= $d_name ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><?= lang('description') ?></label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" rows="3" name="document_description"
                                                          id="document_description"><?= $d_description ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><?= lang('select_file') ?></label>
                                            <div class="col-sm-8">
                                                <input type="file" name="document_file" id="document_file">
                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
                                            </div>
                                        </div>
                                        <input type="hidden" id="doc_id" name="doc_id" value="<?= $id_document ?>">
                                        <input type="hidden" id="doc_file" name="doc_file" value="<?= $d_file ?>">
                                        <div class="element-box-content2">
                                            <?php
                                            if ($d_file != '') {
                                                echo '<img src="' . documentLink('transaction') . $d_file . '" width="100">';
                                            }
                                            ?>
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


<!--Delete Alert Start-->
<div class="modal fade" id="delete_doc_m" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_this_entry"); ?></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger"><span
                        class="glyphicon glyphicon-warning-sign"></span>&nbsp;<?= lang("confirm_delete"); ?> </div>
            </div>
            <div class="modal-footer ">
                <input type="hidden" id="doc_del_id">
                <button type="button" class="btn btn-success" onclick="delete_doc();"><span
                        class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Delete Alert End-->


<script>

    function deleteDocModal(id) {
        var tt = $('#docu_delete_id').val();
        if (!empty(tt)) {
            tt = tt + ',' + id;
        } else {
            tt = id;
        }
        $('#docu_delete_id').val(tt);
        $(this).closest('tr').remove();
    }


    function delete_doc_modal(id) {
        $('#doc_del_id').val(id);
    }
    function delete_doc() {
        var id = $('#doc_del_id').val();
        var tt = $('#delete_doc_ids').val();
        if (tt != '') {
            tt = tt + ',' + id;
        } else {
            tt = id;
        }
        $('#delete_doc_ids').val(tt);
        $('#delete_doc_m').modal('toggle');
        $('#tr-' + id).remove();
    }

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

    function validate_data() {

        var err = false;

        var qmv = '<?=$qty_multiplier;?>';
        if (qmv == '-1' && ($('input[name=tt_expense]').val() == '0' || $('input[name=tt_child]').val() == '0')) {
            $('#tt_expense-error').html('Please Select Expense.');
            setTimeout(function () {
                $('#tt_expense-error').html("");
            }, 2000);
            err = true;
        } else if (qmv == '1' && ($('input[name=tt_income]').val() == '0' || $('input[name=tt_child]').val() == '0')) {
            $('#tt_income-error').html('Please Select Income.');
            setTimeout(function () {
                $('#tt_income-error').html("");
            }, 2000);
            err = true;
        }

        var tot_amount = parseFloat($("input[name='tot_amount']").val(), 10);
        if (tot_amount == "" || isNaN(tot_amount)) {
            $('#tot_amount-error').html('Please Enter Amount.');
            setTimeout(function () {
                $('#tot_amount-error').html("");
            }, 2000);
            err = true;
        }
        var acc_bal = parseFloat($('#account_balance').html(), 10);
        ;
        if (tot_amount > acc_bal && qmv == '-1') {
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
            }, 2000);
            err = true;
        }
        if ($("[name=account]").val() == "" || $("[name=account]").val() == "0") {
            $('#account-error').html('Please Select Account.');
            setTimeout(function () {
                $('#account-error').html("");
            }, 2000);
            err = true;
        }

        if (err == true) {
            return false;
        }

        return true;
    }

    $("#frm_trx_office").submit(function () {
        if (validate_data() != false) {
            var data_string = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>account-management/edit-office-trx/<?php echo $this->commonlib->encrypt_srting($id);?>',
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
                            <?php if($return_type == 2):?>
                            window.location.href = "<?php echo base_url() ?>account-management/transaction-invoices";
                            <?php else:?>
                            window.location.href = "<?php echo base_url() ?>account-management/transactions/office";
                            <?php endif;?>
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


    $(function () {
        $("input:radio[name=qty_multiplier]").click(function () {
            if ($(this).val() == 1) {
                $('#v_tt_expense').hide();
                $('#v_tt_income').show();
                $('#v_tt_child').hide();
            } else {
                $('#v_tt_expense').show();
                $('#v_tt_income').hide();
                $('#v_tt_child').hide();
            }

            //$('#tt_expense select').select2("val", "0");
            //$('#tt_expense select').select2("val", "0");
            $('#tt_expense option[value="0"]').prop('selected', true);
            $('#tt_income option[value="0"]').prop('selected', true);
            //$("#tt_expense").val("0"); //.change();
            //$("#tt_income").val("0"); //.change();
            //$('select#tt_expense option').removeAttr("selected");
            //$('select#tt_income option').removeAttr("selected");
        });

    });

    $(".tt").change(function () {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account_management/transaction/office_trx_chld_cats/' + $(this).val() + '/' +<?=$qty_multiplier;?>,
            success: function (html) {
                if (html != '') {
                    $('#off_ch').html(html);
                    $('#v_tt_child').show(500);
                } else {
                    $('#off_ch').html('');
                    $('#v_tt_child').hide(500);
                }
            }
        });
    });
</script>