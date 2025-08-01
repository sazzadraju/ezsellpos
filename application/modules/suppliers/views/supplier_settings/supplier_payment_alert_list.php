<ul class="breadcrumb">
    <?php
        if($breadcrumb){
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
                    <div class="top-btn full-box">
                        <div class="row">

                            <form action="">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang('supplier_name')?> </label>
                                        <div class="col-sm-12">

                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" name="name_supplier" id="name_supplier">
                                                    <option value="0" selected><?= lang('select_one')?></option>
                                                    <?php
                                                        if(!empty($supplier_list)){
                                                            foreach ($supplier_list as $list) {
                                                    ?>
                                                            <option value="<?php echo $list['id_supplier'];?>"><?php echo $list['supplier_name'];?></option>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-1">

                                    <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                    <button class="btn btn-primary btn-rounded center" type="button" onclick="searchFilter();"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>



                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <button data-toggle="modal" data-target="#supplierPaymentAlert" class="btn btn-primary btn-rounded right" type="button"> <?= lang('add_supp_payment_alert')?></button>
                            </div>
                        </div>
                        <!---Add Modal BOX-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php $this->load->view('supplier_settings/supplier_payment_alert_data');?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<div id="supplierPaymentAlert" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header"><?= lang('supplier_payment_alert')?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <?php echo form_open_multipart('', array('id' => 'supplier_payment_alert', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('supplier')?><span class="req">*</span></label>
                    <div class="col-sm-8">
                        <select class="select2" data-live-search="true" name="category" id="supplier_id">
                            <option value="0" selected><?= lang('select_one')?></option>
                            <?php
                                if(!empty($supplier_list)){
                                    foreach ($supplier_list as $list) {
                            ?>
                                    <option value="<?php echo $list['id_supplier'];?>"><?php echo $list['supplier_name'];?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('amount')?><span class="req">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('amount')?>" type="text" id="amount" name="number">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('notification_date')?><span class="req">*</span></label>

                    <div class='col-sm-8'>
                        <div class='input-group date dateTime'  id='dateTime'>
                            <input type='text' class="form-control" id="dtt_notification" name="f_date" />
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('payment_date')?><span class="req">*</span></label>
                    <div class='col-sm-8'>
                        <div class='input-group date dateTime'  id='dateTime'>
                            <input type='text' class="form-control" id="dtt_payment_est" name="t_date" />
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <label id="dtt_payment_est-error" class="error" for="dtt_payment_est"></label>
                    </div>
                </div>

                <div class="form-buttons-w">
                    <button class="btn btn-primary" type="submit"> <?= lang('submit')?></button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close')?></button>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>



<div id="editSupplierPaymentAlertModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header"><?= lang('edit_supplier_payment_alert')?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <?php echo form_open_multipart('', array('id' => 'edit_supplier_payment_alert', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <input type="hidden" name="id_supplier_payment_alert" id="edit_id_supplier_payment_alert">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('supplier')?><span class="req">*</span></label>
                    <div class="col-sm-8">
                        <select class="select2" data-live-search="true" name="edit_category" id="edit_supplier_id">
                            <option value="0" selected><?= lang('select_one')?></option>
                            <?php
                                if(!empty($supplier_list)){
                                    foreach ($supplier_list as $list) {
                            ?>
                                    <option value="<?php echo $list['id_supplier'];?>"><?php echo $list['supplier_name'];?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('amount')?><span class="req">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('amount')?>" type="text" id="edit_amount" name="edit_number">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('notification_date')?><span class="req">*</span></label>

                    <div class='col-sm-8'>
                        <div class='input-group date dateTime'  id='dateTime'>
                            <input type='text' class="form-control" id="edit_dtt_notification" name="edit_f_date" />
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('payment_date')?><span class="req">*</span></label>
                    <div class='col-sm-8'>
                        <div class='input-group date dateTime'  id='dateTime'>
                            <input type='text' class="form-control" id="edit_dtt_payment_est" name="edit_t_date" />
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <label id="dtt_payment_est-error" class="error" for="dtt_payment_est"></label>
                    </div>
                </div>

                <div class="form-buttons-w">
                    <button class="btn btn-primary" type="submit"> <?= lang('submit')?></button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close')?></button>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>

<!--Edit Modal End-->



<!--Delete Alert Start-->
<div class="modal fade" id="deleteSupplierInfoModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang('delect_this_entry')?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('confirm_delete')?></div>

            </div>
            <div class="modal-footer ">
                <input type="hidden" name="delete_sup_payment_id" id="delete_sup_payment_id">
                <button type="button" class="btn btn-success" onclick="delete_supplier_payment_alert_info();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang('yes')?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang('no')?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Delete Alert End-->

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 

<script>
    $(function () {
        $('.dateTime').datetimepicker({
            viewMode: 'years',
            //format: 'DD/MM/YYYY/LT',
            format: 'YYYY-MM-DD HH:MM:00',
        });

    });

    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var name_supplier = $('#name_supplier').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>suppliers/supplier_payment_alert_data/' + page_num,
            data: 'page=' + page_num + '&name_supplier='+name_supplier,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

    function check_date_for_alert() {

        var inDateStr = $('#dtt_notification').val();
        var endDateStr = $('#dtt_payment_est').val();
        var inDate = new Date(inDateStr);
        var eDate = new Date(endDateStr);
        var n_date = inDate.getTime();
        var p_date = eDate.getTime();

        if(p_date < n_date){
            $('#dtt_payment_est-error').show();
            $('#dtt_payment_est-error').html('Payment date must be after than notification date');
            return false;
        }

    }


    function deleteSupplierModal(id){
        $('#delete_sup_payment_id').val(id);
    }

    function delete_supplier_payment_alert_info(){
        var id = $('#delete_sup_payment_id').val();
        $.ajax({
                url: '<?php echo base_url();?>delete_supplier_payment_alert_info',
                data: {id: id},
                type: 'post',
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data)
                {
                    $('#deleteSupplierInfoModal').modal('toggle');
                    $('#showMessage').html("<?php echo lang('delete_success');?>");
                    $('#showMessage').show();
                    window.onload = searchFilter(0);
                    setTimeout(function() {
                            $('#showMessage').fadeOut(300);
                            
                        }, 3000);
                    $('.loading').fadeOut("slow");
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
    }

    function editSupplierPaymentAlert(id){
        $.ajax({ 
          url: '<?php echo base_url();?>viewSupplierAlert',
          data: {id: id},
          type: 'post',
          beforeSend: function () {
                $('.loading').show();
            },
          success: function(result) {
                // console.log(result);
                if (result) {
                    var data = JSON.parse(result);
                    
                    if(result != 0){
                        //show
                        $('#edit_id_supplier_payment_alert').val(data[0].id_supplier_payment_alert);
                        $('[id="edit_supplier_id"]').val(data[0].supplier_id).change();
                        $('#edit_amount').val(data[0].amount);
                        $('#edit_dtt_notification').val(data[0].dtt_notification);
                        $('#edit_dtt_payment_est').val(data[0].dtt_payment_est);
                    }
                    $('.loading').fadeOut("slow");

                    return false;
                } else {
                    return false;
                }
            }
        });
    }


</script>

<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            //console.log(form.id);
            var id = form.id;
            if(id == "supplier_payment_alert"){
                if (check_date_for_alert() != false) {
                    var currentForm = $('#supplier_payment_alert')[0];
                    var formData = new FormData(currentForm);

                    $.ajax({
                        url: "<?= base_url() ?>supplier_payment_alert_action",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('.loading').show();
                        },
                        success: function (response) {
                            var result = $.parseJSON(response);
                            console.log(result);
                            if (result.status != 'success') {
                                $.each(result, function (key, value) {
                                    $('[name="' + key + '"]').addClass("error");
                                    $('[name="' + key + '"]').after(' <label class="error">' + value + '</label>');
                                });
                            } else {
                                $('#supplierPaymentAlert').modal('toggle');
                                $('#supplier_payment_alert').trigger("reset");
                                $('#showMessage').html(result.message);
                                $('#showMessage').show();
                                window.onload = searchFilter(0);
                                setTimeout(function() {
                                    $('#showMessage').fadeOut(300);
                                    
                                }, 3000);
                            }
                            $('.loading').fadeOut("slow");
                        }
                    });
                }
            }


            if(id == "edit_supplier_payment_alert"){
                if (check_date_for_alert() != false) {
                    var currentForm = $('#edit_supplier_payment_alert')[0];
                    var formData = new FormData(currentForm);

                    $.ajax({
                        url: "<?= base_url() ?>supplier_payment_alert_action",
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
                                    $('[name="' + key + '"]').addClass("error");
                                    $('[name="' + key + '"]').after(' <label class="error">' + value + '</label>');
                                });
                            } else {
                                $('#editSupplierPaymentAlertModal').modal('toggle');
                                $('#edit_supplier_payment_alert').trigger("reset");
                                $('#showMessage').html(result.message);
                                $('#showMessage').show();
                                window.onload = searchFilter(0);
                                setTimeout(function() {
                                    $('#showMessage').fadeOut(300);
                                    
                                }, 3000);
                                
                            }
                            $('.loading').fadeOut("slow");
                        }
                    });
                }
            }

       }
    });
</script>