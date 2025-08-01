<ul class="breadcrumb">
<?php echo isset($breadcrumb) ? $breadcrumb : '';?>
</ul>
<div class="col-md-12"> 
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>
<script>
    function searchFilter1(page_num) {
        page_num = page_num ? page_num : 0;
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account-settings-bank/page_general/' + page_num,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#gen_bnk_lst').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    
    function searchFilter2(page_num) {
        page_num = page_num ? page_num : 0;
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>account-settings-bank/page_mobile/' + page_num,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#mob_bnk_lst').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    
    function reset_all() {
        var tid = $('[name=tid]').val();
        $('#bank')[0].reset();
        $("#hid").val("");
        if(tid=='1' || tid==1){
            $("#bank_type_1").prop("checked", true).attr('checked', 'checked');
        } else{
            $("#bank_type_2").prop("checked", true).attr('checked', 'checked');
        }
        $('#layout_title').text('<?= lang("bank_add"); ?>');
    }
    
    function edit_bank(id) {
        save_method = 'update';
        $('#bank')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $.ajax({
            url: "<?php echo base_url() ?>account-settings-bank/edit/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('.loading').fadeOut("slow");
                $('[name="hid"]').val(data.id);
                $('[name="bank_name"]').val(data.bank);
                $('[name=tid]').val(data.type_id);
                if(data.type_id==1){
                    $("#bank_type_1").prop("checked", true).attr('checked', 'checked');
                } else{
                    $("#bank_type_2").prop("checked", true).attr('checked', 'checked');
                }
                $('#layout_title').text('<?= lang("bank_edit"); ?>');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    function delete_bank_modal(id) {
        $('#bank_del_id').val(id);
    }
    function delete_bank()
    {
        $('#eid').html('');
        var id = $('#bank_del_id').val();
        $.ajax({
            url: "<?php echo base_url() . 'account-settings-bank/delete' ?>/" + id,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('#delete_bank_m').modal('toggle');
                $('.loading').fadeOut("slow");
                if(data.type==1){
                    $('#eid').html('This name used in accounts.');
                }else{
                    $('#showMessage').html('<?= lang("delete_success"); ?>');
                    var tid = $('[name=tid]').val();
                    if(tid == '1' || tid == 1){
                        window.onload = searchFilter1(0);
                    } else{
                        window.onload = searchFilter2(0);
                    }
                    $('#showMessage').show();
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);
                    }, 3000);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('<?= lang("delete_error"); ?>');
            }
        });
    }

    $.validator.setDefaults({
        submitHandler: function (form) {
            var currentForm = $('#bank')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>account-settings-bank/add_data",
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
                    console.log(result);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');
                        });
                    } else {
                        $('.loading').fadeOut("slow");
                        var $el = $('#bank');
                        $el.wrap('<form>').closest('form').get(0).reset();
                        $el.unwrap();
                        $('#showMessage').html(result.message);
                        //window.onload = searchFilter1(0);
                        if($('[name=tid]').val() === '1'){
                            window.onload = searchFilter1(0);
                        } else{
                            window.onload = searchFilter2(0);
                        }
                        $('#showMessage').show();
                        reset_all();
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);
                        }, 3000);
                    }
                }
            });
        }
    });

    function setTabId(id){
        $('[name=tid]').val(id);
        $("#bank_type_"+id).prop("checked", true).attr('checked', 'checked');
    }
</script>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-5">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <?php echo form_open('', array('id' => 'bank', 'class' => 'cmxform')); ?>
                        <h6 class="element-header" id="layout_title"><?= lang("bank_add"); ?></h6>
                        <input type="hidden" name="hid" id="hid" value="" />
                        <input type="hidden" name="tid" id="tid" value="1" />
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("bank_name"); ?></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="bank_name" name="bank_name" value="" placeholder="<?= lang("bank_name"); ?>" />
                            </div>
                            <label class="col-sm-4 col-form-label" for=""><?= lang("bank_type"); ?></label>
                            <div class="col-sm-8" style="margin-top: 5px;">
                                <div class="col-sm-12">
                                    <input type="radio" name="bank_type" id="bank_type_1" class="form-group" checked value="1" />
                                    <label for="bank_type_1">General Bank</label>
                                </div>
                                <div class="col-sm-12">
                                    <input type="radio" name="bank_type" id="bank_type_2" class="form-group" value="2" />
                                    <label for="bank_type_2">Mobile Bank</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-buttons-w">
                            <button class="btn btn-primary" onclick="reset_all()" type="reset" ><?= lang("reset"); ?></button>
                            <button class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <h6 class="element-header"><?= lang("bank_list"); ?></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="tab-menu">
                                    <li class="active">
                                        <a href="#general_bank" data-toggle="tab" class="btn btn-primary" onclick="setTabId(1)"><?= lang("general_bank"); ?></a>
                                    </li>
                                    <li>
                                        <a href="#mobile_bank" data-toggle="tab" class="btn btn-primary" onclick="setTabId(2)"><?= lang("mobile_bank"); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div class="error" id="eid"></div>
                                    <div id="general_bank" class="tab-pane fade in active full-box">
                                        <div class="table-responsive" id="gen_bnk_lst">
                                            <?php $this->load->view('bank/paginated_gen_data', $general_banks); ?>
                                        </div>
                                    </div>
                                    <div id="mobile_bank" class="tab-pane fade full-box">
                                        <div class="table-responsive" id="mob_bnk_lst">
                                            <?php $this->load->view('bank/paginated_mob_data', $mobile_banks); ?>
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


<div class="modal fade" id="delete_bank_m" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
                <input type="hidden" id="bank_del_id">
                <button type="button" class="btn btn-success" onclick="delete_bank();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>