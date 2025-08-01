<ul class="breadcrumb">
    <?php echo isset($breadcrumb) ? $breadcrumb : ''; ?>
</ul>
<div class="col-md-12"> 
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>
<script src="<?= base_url() ?>themes/default/js/account-form.js"></script>

<script>
    function searchFilter1(page_num = 0) {
        page_num = page_num ? page_num : 0;
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account-settings-account/page-bank-account/' + page_num,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#bank_acc_lst').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    function searchFilter2(page_num = 0) {
        page_num = page_num ? page_num : 0;
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account-settings-account/page-cash-account/' + page_num,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#cash_acc_lst').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    function searchFilter3(page_num = 0) {
        page_num = page_num ? page_num : 0;
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account-settings-account/page-mobile-account/' + page_num,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#mobile_acc_lst').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    function searchFilter4(page_num = 0) {
        page_num = page_num ? page_num : 0;
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account-settings-account/page-station-account/' + page_num,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#station_acc_lst').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

    function viewDetaitls(id) {
        $.ajax({
            url: "<?php echo base_url() ?>account-settings-account/details/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                $('.loading').fadeOut("slow");

                $('#ba_account_type').html(data.account_type);
                $('#ba_acc_uses').html(data.acc_uses);
                $('#ba_bank_or_acc_name').html(data.bank_or_acc_name);
                $('#ba_account_no').html(data.account_no);
                $('#ba_branch_name').html(data.branch_name);
                $('#ba_address').html(data.address);
                $('#ba_description').html(data.description);
                $('#ba_initial_balance').html(data.initial_balance + ' <?= lang('taka') ?>');
                $('#ba_stores').html(data.stores);

                $('#ca_account_type').html(data.account_type);
                $('#ca_acc_uses').html(data.acc_uses);
                $('#ca_account_name').html(data.account_name);
                $('#ca_description').html(data.description);
                $('#ca_initial_balance').html(data.initial_balance + ' <?= lang('taka') ?>');
                $('#ca_stores').html(data.stores);

                $('#ma_account_type').html(data.account_type);
                $('#ma_acc_uses').html(data.acc_uses);
                $('#ma_bank_or_acc_name').html(data.bank_or_acc_name);
                $('#ma_account_no').html(data.account_no);
                $('#ma_type_of_account').html(data.type_of_account);
                $('#ma_charge_per_transaction').html(data.charge_per_transaction + ' <?= lang('taka') ?>');
                $('#ma_description').html(data.description);
                $('#ma_initial_balance').html(data.initial_balance + ' <?= lang('taka') ?>');
                $('#ma_stores').html(data.stores);

                $('#sa_account_type').html(data.account_type);
                $('#sa_acc_uses').html(data.acc_uses);
                $('#sa_account_name').html(data.account_name);
                $('#sa_description').html(data.description);
                $('#sa_initial_balance').html(data.initial_balance + ' <?= lang('taka') ?>');
                $('#sa_stores').html(data.stores);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function reset_all() {
        $('#accountform')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $("#acc_type").val($('input[name="tid"]').val()).change();
        $("#store_id").val([]).change(); // Reset multi-Select
        $("#acc_uses").val('').change();
        $("#mobile_bank_account").val('').change();
        $("#bank_account").val('').change();
        $('[name="mob_acc_type"]').prop('checked', false);
        $("#mob_acc_type_1").prop('checked', true);
    }

    function add_account_data() {
        reset_all();
        
        $("#id").val('');
        var tid = parseInt($('input[name="tid"]').val());
        $("#acc_type").val(tid).change();
        $('#layout_title').text('<?= lang("add_account"); ?>');
        
        $('[name="acc_type"]').attr("disabled", false);
        $('[name="bank_account"]').attr("disabled", false);
        $('[name="cash_acc_name"]').attr("disabled", false);
        $('[name="mobile_bank_account"]').attr("disabled", false);
        $('[name="acc_no"]').attr("disabled", false);
        $('[name="branch_name"]').attr("disabled", false);
        $('[name="address"]').attr("disabled", false);
        $('[name="mob_acc_type"]').attr("disabled", false);
        $('[name="description"]').attr("disabled", false);
        $('[name="initial_balance"]').attr("disabled", false);
    }

    function edit_account_data(id) {
        
        var tid = parseInt($('input[name="tid"]').val());
        reset_all();
        
        $('#layout_title').text('<?= lang("edit_account"); ?>');
        $("#id").val(id);
        $("#acc_type").val(tid).change();
        $('[name="acc_type"]').attr("disabled", true);
        $('[name="bank_account"]').attr("disabled", true);
        $('[name="cash_acc_name"]').attr("disabled", true);
        $('[name="mobile_bank_account"]').attr("disabled", true);
        $('[name="acc_no"]').attr("disabled", true);
        $('[name="branch_name"]').attr("disabled", true);
        $('[name="address"]').attr("disabled", true);
        $('[name="mob_acc_type"]').attr("disabled", true);
        $('[name="description"]').attr("disabled", true);
        $('[name="initial_balance"]').attr("disabled", true);
        
        $.ajax({
            url: '<?php echo base_url(); ?>account-settings-account/edit-account-info/' + id,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                if (result) {
                    var data = JSON.parse(result);
                    console.log(data);
                    $('[name="acc_type"]').val(data.acc_type_id).change();
                    $('[name="acc_uses"]').val(data.acc_uses_id).change();
                    $('[name="bank_account"]').val(data.bank_id).change();
                    $('[name="cash_acc_name"]').val(data.account_name);
                    $('[name="mobile_bank_account"]').val(data.bank_id).change();
                    $('[name="acc_no"]').val(data.account_no);
                    $('[name="branch_name"]').val(data.branch_name);
                    $("[name='mob_acc_type'][value='"+data.mob_acc_type_id+"']").prop("checked",true);
                    $('[name="trx_charge"]').val(data.charge_per_transaction);
                    $("[name='description']").val(data.description);
                    $("[name='initial_balance']").val(data.initial_balance);
                    $("#store_id").val( data.store_id ).change();
                } else{
                    alert('No data found!');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
        
        $('.loading').fadeOut("slow");
    }
    
    function delete_account_modal(id) {
        $('#del_acc_id').val(id);
    }
    function delete_account()
    {
        var id = $('#del_acc_id').val();
        var balance = $('#c_curr_balance_'+id).val()*1;
        if(balance > 0){
            $('#delete_account_m').modal('hide');
            $('#emptyAlert').modal('toggle');
        } else {
            $.ajax({
                url: "<?php echo base_url() . 'account-settings-account/delete' ?>/" + id,
                type: "POST",
                dataType: "JSON",
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data) {
                    var tid = $('[name="acc_type"]').val();
                    if (tid === '1') {
                        window.onload = searchFilter1(0);
                    } else if (tid === '2') {
                        window.onload = searchFilter2(0);
                    } else if (tid === '3') {
                        window.onload = searchFilter3(0);
                    }
                    $('.loading').fadeOut("slow");
                    $('#showMessage').html('<?= lang("delete_success"); ?>');
                    $('#showMessage').show();
                    $('#delete_account_m').modal('toggle');
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);
                    }, 3000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('<?= lang("delete_error"); ?>');
                }
            });
        }
    }

    $.validator.setDefaults({
        submitHandler: function (form) {
            var currentForm = $('#accountform')[0];
            var formData = new FormData(currentForm);
            
            $.ajax({
                url: "<?php echo base_url();?>account-settings-account/add-account",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (response) {
                    console.log(response);
                    var result = $.parseJSON(response);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $('[name="' + key + '"]').addClass("error");
                            $('[name="' + key + '"]').after(' <label class="error">' + value + '</label>');
                            
                            if(key=='store_id'){
                                $('#store_id').addClass("error");
                                $('#store_id').after(' <label class="error">' + value + '</label>');
                            }
                        });
                        $('.loading').fadeOut("slow");
                    } else {
                        var tid = $('[name="acc_type"]').val();
                        if (tid == '1' || tid == 1) {
                            window.onload = searchFilter1(0);
                        } else if (tid == '2' || tid == 2) {
                            window.onload = searchFilter2(0);
                        } else if (tid == '3' || tid == 3) {
                            window.onload = searchFilter3(0);
                        }
                        $('#showMessage').show();
                        $('#showMessage').html(result.message);
                        $('#add').modal('hide');
                        setTimeout(function() {
                            $('#showMessage').fadeOut(300);
                        }, 3000);
                        $('.loading').fadeOut("slow");
                        reset_all();
                    }
                }
            });
        }
    });
</script>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <h6 class="element-header"><?= lang("account_list"); ?></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="tab-menu">
                                    <li class="active"><a href="#bank_account" data-toggle="tab" class="btn btn-primary tb" id="tb-1"><?= lang("bank_account"); ?></a></li>
                                    <li><a href="#cash_account" data-toggle="tab" class="btn btn-primary tb" id="tb-2"><?= lang("cash_account"); ?></a></li>
                                    <li><a href="#mobile_account" data-toggle="tab" class="btn btn-primary tb" id="tb-3"><?= lang("mobile_account"); ?></a></li>
                                    <li><a href="#station_account" data-toggle="tab" class="btn btn-primary tb" id="tb-3"><?= lang("station_account"); ?></a></li>
                                </ul>
                                <button data-toggle="modal" data-target="#add" class="btn btn-primary bottom-10 right" type="button" onclick="add_account_data()"><i class="fa fa-plus"></i> <?= lang("add_account"); ?></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div id="bank_account" class="tab-pane fade in active full-box">
                                        <div class="table-responsive" id="bank_acc_lst">
                                            <?php $this->load->view('account/bank_account_page', $bank_accounts); ?>
                                        </div>
                                    </div>

                                    <div id="cash_account" class="tab-pane fade full-box">
                                        <div class="table-responsive" id="cash_acc_lst">
                                            <?php $this->load->view('account/cash_account_page', $cash_accounts); ?>
                                        </div>
                                    </div>

                                    <div id="mobile_account" class="tab-pane fade full-box">
                                        <div class="table-responsive" id="mobile_acc_lst">
                                            <?php $this->load->view('account/mobile_account_page', $mobile_accounts); ?>
                                        </div>
                                    </div>

                                    <div id="station_account" class="tab-pane fade full-box">
                                        <div class="table-responsive" id="station_acc_lst">
                                            <?php $this->load->view('account/station_account_page', $station_accounts); ?>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!---BA View Modal BOX--->
<div id="ba_view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("bank_account_details"); ?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="col-md-12">
                        <div class="info-1"> 
                            <div class="margin-0"></div>
                            <div><strong class="fix-width"><?= lang("account_type"); ?></strong>: <span id="ba_account_type"></span></div>
                            <div><strong class="fix-width"><?= lang("acc_uses"); ?></strong>: <span id="ba_acc_uses"></span></div>
                            <div><strong class="fix-width"><?= lang("bank_or_acc_name"); ?></strong>: <span id="ba_bank_or_acc_name"></span></div>
                            <div><strong class="fix-width"><?= lang("account_no"); ?></strong>: <span id="ba_account_no"></span></div>
                            <div><strong class="fix-width"><?= lang("branch_name"); ?></strong>: <span id="ba_branch_name"></span></div>
                            <div><strong class="fix-width"><?= lang("address"); ?></strong>: <span id="ba_address"></span></div>
                            <div><strong class="fix-width"><?= lang("description"); ?> </strong>: <span id="ba_description"></span></div>
                            <div><strong class="fix-width"><?= lang("initial_balance"); ?></strong>: <span id="ba_initial_balance"></span></div>
                            <div><strong class="fix-width"><?= lang("stores"); ?></strong>: <span id="ba_stores"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
            </div>
        </div>

    </div>
</div>
<!---END of BA View Modal BOX--->

<!---CA View Modal BOX--->
<div id="ca_view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("cash_account_details"); ?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="col-md-12">
                        <div class="info-1"> 
                            <div class="margin-0"></div>
                            <div><strong class="fix-width"><?= lang("account_type"); ?></strong>: <span id="ca_account_type"></span></div>
                            <div><strong class="fix-width"><?= lang("acc_uses"); ?></strong>: <span id="ca_acc_uses"></span></div>
                            <div><strong class="fix-width"><?= lang("account_name"); ?></strong>: <span id="ca_account_name"></span></div>
                            <div><strong class="fix-width"><?= lang("description"); ?> </strong>: <span id="ca_description"></span></div>
                            <div><strong class="fix-width"><?= lang("initial_balance"); ?></strong>: <span id="ca_initial_balance"></span></div>
                            <div><strong class="fix-width"><?= lang("stores"); ?></strong>: <span id="ca_stores"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
            </div>
        </div>

    </div>
</div>
<!---END of CA View Modal BOX--->

<!---MA View Modal BOX--->
<div id="ma_view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("mobile_account_details"); ?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="col-md-12">
                        <div class="info-1"> 
                            <div class="margin-0"></div>
                            <div><strong class="fix-width"><?= lang("account_type"); ?></strong>: <span id="ma_account_type"></span></div>
                            <div><strong class="fix-width"><?= lang("acc_uses"); ?></strong>: <span id="ma_acc_uses"></span></div>
                            <div><strong class="fix-width"><?= lang("bank_or_acc_name"); ?></strong>: <span id="ma_bank_or_acc_name"></span></div>
                            <div><strong class="fix-width"><?= lang("account_no"); ?></strong>: <span id="ma_account_no"></span></div>
                            <div><strong class="fix-width"><?= lang("type_of_account"); ?></strong>: <span id="ma_type_of_account"></span></div>
                            <div><strong class="fix-width"><?= lang("charge_per_transaction"); ?></strong>: <span id="ma_charge_per_transaction"></span></div>
                            <div><strong class="fix-width"><?= lang("description"); ?> </strong>: <span id="ma_description"></span></div>
                            <div><strong class="fix-width"><?= lang("initial_balance"); ?></strong>: <span id="ma_initial_balance"></span></div>
                            <div><strong class="fix-width"><?= lang("stores"); ?></strong>: <span id="ma_stores"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
            </div>
        </div>

    </div>
</div>
<!---MA View Modal BOX--->

<!---SA View Modal BOX--->
<div id="sa_view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("station_account_details"); ?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="col-md-12">
                        <div class="info-1"> 
                            <div class="margin-0"></div>
                            <div><strong class="fix-width"><?= lang("account_type"); ?></strong>: <span id="sa_account_type"></span></div>
                            <div><strong class="fix-width"><?= lang("acc_uses"); ?></strong>: <span id="sa_acc_uses"></span></div>
                            <div><strong class="fix-width"><?= lang("bank_or_acc_name"); ?></strong>: <span id="sa_bank_or_acc_name"></span></div>
                            <div><strong class="fix-width"><?= lang("account_no"); ?></strong>: <span id="sa_account_no"></span></div>
                            <div><strong class="fix-width"><?= lang("type_of_account"); ?></strong>: <span id="sa_type_of_account"></span></div>
                            <div><strong class="fix-width"><?= lang("charge_per_transaction"); ?></strong>: <span id="sa_charge_per_transaction"></span></div>
                            <div><strong class="fix-width"><?= lang("description"); ?> </strong>: <span id="sa_description"></span></div>
                            <div><strong class="fix-width"><?= lang("initial_balance"); ?></strong>: <span id="sa_initial_balance"></span></div>
                            <div><strong class="fix-width"><?= lang("stores"); ?></strong>: <span id="sa_stores"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
            </div>
        </div>

    </div>
</div>
<!---SA View Modal BOX--->


<!---Add Modal BOX--->
<div id="add" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <?php echo form_open_multipart('', array('id' => 'accountform', 'class' => 'cmxform',)); ?>
            <div class="modal-header">
                <h6 class="element-header margin-0"><span id="layout_title"><?= lang("add_account"); ?> </span> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value=""> 
                <input type="hidden" name="tid" id="tid" value="1" /> 
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('account_type'); ?> <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="row-fluid">
                            <select class="form-group select2" name="acc_type" id="acc_type">
                                <option value=""><?= lang("select_one"); ?></option>
                                <?php foreach ($this->config->item('acc_types_add') as $key => $val): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('acc_uses'); ?> <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="row-fluid">
                            <select class="form-group select2" name="acc_uses" id="acc_uses" data-live-search="true">
                                <option value=""><?= lang("select_one"); ?></option>
                                <?php foreach ($this->config->item('acc_uses') as $key => $val): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('bank_or_acc_name'); ?> <span class="req">*</span></label>
                    <div class="col-md-8 disp-off" id="d_bank_name">
                        <div class="row-fluid">
                            <select name="bank_account" id="bank_account" class="form-control" >
                                <option value="0"><?= lang("select_one_bank_acc"); ?></option>
                                <?php foreach ($general_banks as $key => $val): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8 disp-off" id="d_cash_acc_name">
                        <div class="row-fluid">
                            <input type="text" name="cash_acc_name" id="cash_acc_name" class="form-control" placeholder="<?= lang('cash_acc_name') ?>" value="" />
                        </div>
                    </div>
                    <div class="col-md-8 disp-off" id="d_acc_name">
                        <div class="row-fluid">
                            <select name="mobile_bank_account" id="mobile_bank_account" class="form-control">
                                <option value="0"><?= lang("select_one_mobile_acc"); ?></option>
                                <?php foreach ($mobile_banks as $key => $val): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row" id="d_acc_no">
                    <label class="col-sm-4 col-form-label"><?= lang('account_no'); ?> <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="row-fluid">
                            <input type="text" name="acc_no" id="acc_no" class="form-control" placeholder="<?= lang('account_no') ?>" value="" />
                        </div>
                    </div>
                </div>
                <div class="form-group row ba" id="d_acc_no">
                    <label class="col-sm-4 col-form-label"><?= lang('branch_name'); ?> <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="row-fluid">
                            <input type="text" name="branch_name" id="branch_name" class="form-control" placeholder="<?= lang('branch_name') ?>" value="" />
                        </div>
                    </div>
                </div>
                <div class="form-group row ba" id="d_acc_no">
                    <label class="col-sm-4 col-form-label"><?= lang('address'); ?></label>
                    <div class="col-md-8">
                        <div class="row-fluid">
                            <textarea name="address" id="address" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group row ma" id="d_acc_no">
                    <label class="col-sm-4 col-form-label"><?= lang('type_of_account'); ?> <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="row-fluid">
                            <div class="col-sm-12">
                                <input type="radio" name="mob_acc_type" id="mob_acc_type_1" checked value="1" />
                                <label for="mob_acc_type_1">Business</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="radio" name="mob_acc_type" id="mob_acc_type_2" value="2" />
                                <label for="mob_acc_type_2">Personal</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="radio" name="mob_acc_type" id="mob_acc_type_3" value="3" />
                                <label for="mob_acc_type_3">Agent</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row ma" id="d_acc_no">
                    <label class="col-sm-4 col-form-label"><?= lang('charge_per_transaction'); ?> <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="row-fluid">
                            <input type="text" name="trx_charge" id="trx_charge" class="form-control" placeholder="<?= lang('charge_per_transaction') ?>" value="" />
                        </div>
                    </div>
                </div>
                <div class="form-group row" id="d_acc_no">
                    <label class="col-sm-4 col-form-label"><?= lang('description'); ?></label>
                    <div class="col-md-8">
                        <div class="row-fluid">
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group row" id="d_acc_no">
                    <label class="col-sm-4 col-form-label"><?= lang('initial_balance'); ?> <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="row-fluid">
                            <input type="text" name="initial_balance" id="initial_balance" class="form-control" placeholder="<?= lang('initial_balance') ?>" value="" />
                        </div>
                    </div>
                </div>
                <div class="form-group row" id="d_acc_no">
                    <label class="col-sm-4 col-form-label"><?= lang('stores'); ?></label>
                    <div class="col-md-8">
                        <div class="row-fluid">
                            <select class="form-control select2" multiple="true" name="store_id[]" id="store_id">
                                <?php
                                if (count($stores)>1) {
                                    foreach ($stores as $key => $val) {
                                        ?><option value="<?php echo $key; ?>"><?=$val;?></option><?php 
                                    }
                                } else{
                                    foreach ($stores as $key => $val) {
                                        ?><option value="<?php echo $key; ?>" selected><?=$val;?></option><?php
                                    }
                                }?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <input class="btn btn-primary" type="submit" value="<?= lang("submit"); ?>"> </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!---END of Add Modal BOX--->

<div class="modal fade" id="delete_account_m" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_this_entry"); ?></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<?= lang("confirm_delete"); ?> </div>
            </div>
            <div class="modal-footer ">
                <input type="hidden" id="del_acc_id">
                <button type="button" class="btn btn-success" onclick="delete_account();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="emptyAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span><?= lang("alert_account_zero"); ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>