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
                        <div class="col-lg-8">
                            <?php echo form_open_multipart('', array('id' => 'addSalesCommission', 'class' => '')); ?>
                            <div class="row">
                                <h2><?= lang('add_sales_person_commission') ?></h2>
                                <div class="form-group row">
                                    <label class="col-md-6 col-form-label"><?= lang('stores') ?><span
                                                class="req">*</span></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="store_id" name="store_id">
                                            <?php
                                            $type_id = $this->session->userdata['login_info']['user_type_i92'];
                                            if ($type_id == 3) {
                                                echo '<option value="0" selected>' . lang("select_one") . '</option>';
                                                foreach ($stores as $key => $val) {
                                                    echo '<option value="' . $key . '">' . $val . '</option>';
                                                }
                                            } else {
                                                $store_id = $this->session->userdata['login_info']['store_id'];
                                                $store_name = $this->session->userdata['login_info']['store_name'];
                                                echo '<option value="' . $store_id . '" selected>' . $store_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div id="search_name_error"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-offset-4 col-md-4 ">
                                        <div class="row">
                                                <input type="radio" class="form-control" name="invoice" id="new_invoice" value="1" checked >
                                                <label for="new_invoice">New Sales Commission</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <input type="radio" class="form-control" name="invoice" id="old_invoice" value="2">
                                            <label for="old_invoice">Due Sales Commission</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class=" col-form-label col-md-6"><?= lang('sales_person') ?>
                                        <spantext-right
                                                class="req">*
                                        </spantext-right>
                                    </label>
                                    <div class="col-sm-6">
                                        <select class="select2 form-control" style="float:left" data-live-search="true"
                                                id="sales_person" name="sales_person">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($salesPersons as $person) {
                                                foreach ($this->config->item('sales_person') as $key => $val) :
                                                    if ($person['person_type'] == $key) {
                                                        $type = $val;
                                                    }
                                                endforeach;
                                                echo '<option actp="' . $person['commission'] . '" value="' . $person['id_sales_person'] . '">' . $person['user_name'] . '(' . $type . ')' . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div id="sales_person_error" class="error"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10" id="upo_data"></div>
                                </div>

                                <div class="form-group row" >
                                    <label class=" col-form-label  col-md-6"><?= lang('total') ?><span class="req">*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="pay_amount"
                                               id="pay_amount" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class=" col-form-label"><?= lang('paid_amount') ?><span
                                                    class="req">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="form-control" name="sataled" id="sataled" value="1">
                                        <label for="sataled">Sataled</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="paid_amount"
                                               id="paid_amount">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class=" col-form-label col-md-6"><?= lang('payment_type') ?><span
                                                class="req">*</span></label>
                                    <?php
                                    $html = '';
                                    if (!empty($accounts)) {
                                        foreach ($accounts as $account) :
                                            $ac_name = !empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name'];
                                            $html .= '<option actp="' . $account['acc_type'] . '" value="' . $account['acc_id'] . '">' . $ac_name . '</option>';
                                        endforeach;
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <select class="form-control" name="account" id="account" style="margin: 0px !important;">
                                            <option value="0"><?= lang('select_one') ?></option>
                                            <?php echo $html; ?>
                                        </select>
                                        <div class="error" id="account_error"></div>
                                        <input type="hidden" id="h_pay_method" name="h_pay_method" value=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group" id="v_pay_method" style="display:none;">
                                        <label class="col-sm-6 col-form-label"><?= lang('payment_method') ?> </label>
                                        <div class="col-md-6">
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
                                <div class="form-group row" id="v_ref_bank" style="display:none;">
                                    <label class="col-sm-6 col-form-label"><?= lang('bank') ?></label>
                                    <div class="col-md-6">
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
                                <div class="form-group row" id="v_ref_mobile_bank" style="display:none;">
                                    <label class="col-sm-6 col-form-label"><?= lang('mobile_bank') ?></label>
                                    <div class="col-md-6">
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
                                <div class="form-group row" id="v_ref_card" style="display:none;">
                                    <label class="col-sm-6 col-form-label"><?= lang('card') ?></label>
                                    <div class="col-md-6">
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
                                <div class="form-group row" id="v_ref_acc_no" style="display:none;">
                                    <label class="col-sm-6 col-form-label"><?= lang('account_card_no'); ?></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="ref_acc_no"
                                               id="ref_acc_no">
                                        <label id="ref_acc_no-error" class="error" for="ref_acc_no"></label>
                                    </div>
                                </div>
                                <div class="form-group row" id="v_ref_trx_no" style="display:none;">
                                    <label class="col-sm-6 col-form-label"><?= lang('ref_trx_no'); ?></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="ref_trx_no"
                                               id="ref_trx_no">
                                        <label id="ref_trx_no-error" class="error" for="ref_trx_no"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label" for=""><?= lang("note"); ?></label>
                                    <div class="col-sm-6">
                                        <textarea name="note" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" id="addQuotation"
                                                class="btn btn-primary right margin-top-10"><?= lang("add_order"); ?></button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(function () {

            $("select#sales_person").change(function () {
                var value = $('option:selected', this).val();
                var com=$('option:selected', this).attr('actp');
                var invoice=$('input[name="invoice"]:checked').val();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>salesPersonBalance',
                    data: 'id=' + value+'&com='+com+'&invoice='+invoice,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (html) {
                        $('.loading').fadeOut("slow");
                        $('#upo_data').html(html);
                    }
                });
            });
            $("select#account").change(function () {
                var option = $('option:selected', this).attr('actp');
                var value = $('option:selected', this).val();
                ref_acc_fields_by_account(option, value);
            });
            $("#pay_method").change(function () {
                ref_acc_fields_by_payment_method($(this).val());
            });
        });
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
        $("#addSalesCommission").submit(function () {
            if (checkValidation() != false) {
                var dataString = new FormData($(this)[0]);
                $.ajax({
                    type: "POST",
                    url: URL + "add_sales_commission",
                    data: dataString,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (response) {
                        $('.loading').fadeOut("slow");
                        console.log(response);
                        var result = $.parseJSON(response);
                        if (result.status != 'success') {
                            $.each(result, function (key, value) {
                                $('[name="' + key + '"]').addClass("error");
                                $('[name="' + key + '"]').after(' <label id="' + key + '_error" class="error">' + value + '</label>');
                            });
                        } else {
                            $('#showMessage').html("<?= lang('add_success')?>");
                            $('#showMessage').show();
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);
                                window.location.href = "<?= base_url()?>sales-commission";
                            }, 1000);
                        }
                        if (result != '3') {
                            $('#search_name').html('Problem in submited data.');
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
        function checkValidation() {
            $('#store_id').removeClass("error");
            $('#sales_person').removeClass("error");
            $('#pay_amount').removeClass("error");
            $('#account').removeClass("error");
            $("#store_id_error").remove();
            $("#sales_person_error").remove();
            $("#pay_amount_error").remove();
            $("#account_error").remove();
            $('#store_id').removeClass("error");
            $("#paid_amount_error").remove();
            $('#paid_amount').removeClass("error");

            return true;
        }

    </script>

