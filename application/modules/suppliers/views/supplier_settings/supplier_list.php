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
                    <div class="top-btn full-box">
                        <div class="row">

                            <form action="">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('name') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('name') ?>" type="text"
                                                   id="name_supplier" name="name_supplier">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('phone') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('phone') ?>" type="text"
                                                   name="phone_supplier" id="phone_supplier">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('email') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('email') ?>" type="email"
                                                   name="email_supplier" id="email_supplier">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">&nbsp; </label>
                                        <div class="col-sm-12">
                                            <input type="checkbox" id="inactive_sup" name="inactive_sup" value="1">
                                            <label for="inactive_sup"><?= lang('inactive_supplier') ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2">

                                    <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                    <button class="btn btn-primary btn-rounded center" type="button"
                                            onclick="searchFilter();"><i class="fa fa-search"></i></button>
                                    <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <button data-toggle="modal" data-target="#add" class="btn btn-primary btn-rounded right"
                                        type="button"><?= lang('add_supplier') ?></button>
                            </div>
                        </div>
                        <!---Add Modal BOX-->

                        <div id="add" class="modal fade" role="dialog" aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="element-header margin-0"><?= lang('suppliers') ?> <span class="close"
                                                                                                           data-dismiss="modal">&times;</span>
                                        </h6>
                                    </div>
                                    <?php echo form_open_multipart('', array('id' => 'supplier_info', 'class' => 'cmxform')); ?>
                                    <div class="modal-body">

                                        <div class="row">
                                        <div class="col-md-3">

                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang('supplier_code') ?></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control"
                                                           placeholder="<?= lang('supplier_code') ?>" type="text"
                                                           id="supplier_code" name="supplier_code"
                                                           value="<?php echo time(); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang('supplier_name') ?>
                                                    <span class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" placeholder="<?= lang('supplier_name') ?>"
                                                           type="text" id="full_name" name="full_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang('contact_person') ?><span
                                                        class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control"
                                                           placeholder="<?= lang('contact_person') ?>" type="text"
                                                           id="contact_person" name="contact_person">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-12" for=""><?= lang('email') ?></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" placeholder="<?= lang('email') ?>"
                                                           type="email" id="email" name="s_email">
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang('phone') ?><span
                                                        class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" placeholder="<?= lang('phone') ?>"
                                                           type="text" id="phone" name="phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">

                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"><?= lang('city_division') ?></label>
                                                <div class="col-sm-12">
                                                    <div class="row-fluid">
                                                        <select class="select2" data-live-search="true"
                                                                id="city_division" name="city_division2"
                                                                onchange="locationAddress(value);">
                                                            <option value="0"
                                                                    selected><?= lang('select_one') ?></option>
                                                            <optgroup label="City Wise">
                                                                <?php
                                                                if ($city_list) {
                                                                    foreach ($city_list as $list) {
                                                                        ?>
                                                                        <option
                                                                            value="city-<?php echo $list['id_city']; ?>"><?php echo $list['city_name_en']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                            </optgroup>
                                                            <optgroup label="Division Wise">
                                                                <?php
                                                                if ($division_list) {
                                                                    foreach ($division_list as $list) {
                                                                        ?>
                                                                        <option
                                                                            value="divi-<?php echo $list['id_division']; ?>"><?php echo $list['division_name_en']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="hidden" name="division_id" id="division_id">
                                            <input type="hidden" name="district_id" id="district_id">

                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"><?= lang('location') ?></label>
                                                <div class="col-sm-12">
                                                    <div class="row-fluid">
                                                        <select class="select2" id="address_location"
                                                                name="address_location2" onchange="cityDistLoc(value);">
                                                            <option value="0"><?= lang('select_one') ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-12" for="">Store</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control select2" multiple="true"
                                                            name="store_id[]" id="store_id">
                                                        <option value="0"><?= lang('select_one') ?></option>
                                                        <?php
                                                        if ($store_list) {
                                                            foreach ($store_list as $list) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $list['id_store']; ?>"><?php echo $list['store_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                        <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang('vat_reg_no') ?></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" placeholder="<?= lang('vat_reg_no') ?>"
                                                           type="text" id="vat_reg_no" name="vat_reg_no">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-12 col-form-label"><?= lang('supplier_photo') ?></label>
                                                <div class="col-sm-12">
                                                    <input type="file" name="profile_img" id="profile_img">
                                                    <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("file_type"); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang('note') ?></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" placeholder="<?= lang('note') ?>"
                                                           type="text" id="note" name="note">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <input type="hidden" name="city_id" id="city_id">
                                            <input type="hidden" name="city_location_id" id="city_location_id">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"><?= lang('address') ?></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" rows="3" name="s_addr_line_1"
                                                              id="addr_line_1" value="addr_line_1"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                    </div>

                                    <div class="modal-footer">
                                        <input class="btn btn-primary" type="submit"
                                               value="<?= lang('submit') ?>"> </button>

                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal"><?= lang('close') ?></button>
                                    </div>
                                    <input type="hidden" id="total_num_of_fields" name="total_num_of_fields" value="1">
                                    <?php echo form_close(); ?>
                                </div>


                            </div>
                        </div>

                        <!---Add Modal BOX-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php $this->load->view('supplier_settings/supplier_info_data');?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!--Edit Supplier Reminder Modal Start-->
<div id="supplierPaymentAlert" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header"><?= lang('supplier_payment_alert') ?> <span class="close"
                                                                                       data-dismiss="modal">&times;</span>
                </h6>
            </div>
            <?php echo form_open_multipart('', array('id' => 'supplier_payment_alert', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                <input type="hidden" name="id_supplier_payment_alert" id="id_supplier_payment_alert"
                       value="<?php if (empty($supplier_payment_alert_list)) {
                           echo '0';
                       } ?>">
                <input type="hidden" name="supplier_id" id="supplier_payment_supplier_id">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('amount') ?></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('amount') ?>" type="text" id="amount"
                               name="amount">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('notification_date') ?><span
                            class="req">*</span></label>

                    <div class='col-sm-8'>
                        <div class='input-group date dateTime' id='dateTime'>
                            <input type='text' class="form-control" id="dtt_notification" name="dtt_notification"/>
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('payment_date') ?><span class="req">*</span></label>
                    <div class='col-sm-8'>
                        <div class='input-group date dateTime' id='dateTime'>
                            <input type='text' class="form-control" id="dtt_payment_est" name="dtt_payment_est"/>
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row" id="dtt_act" style="display: none;">
                    <label class="col-form-label col-sm-4" for=""><?= lang('payment_date') ?><span class="req">*</span></label>
                    <div class='col-sm-8'>
                        <div class='input-group date dateTime' id='dateTime'>
                            <input type='text' class="form-control" id="dtt_payment_act" name="dtt_payment_act"/>
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-buttons-w">
                    <button class="btn btn-primary" type="submit"> <?= lang('submit') ?></button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>
<!--Edit Modal End-->


<!--Edit Modal Start-->
<?php $this->load->view('supplier_settings/supplier_edit');?>
<!--Edit Modal End-->


<!--Delete Alert Start-->
<div class="modal fade" id="deleteSupplierInfoModal" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang('delect_this_entry') ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span
                        class="glyphicon glyphicon-warning-sign"></span> <?= lang('confirm_delete') ?></div>

            </div>
            <div class="modal-footer ">
                <input type="hidden" name="delete_sup_id" id="delete_sup_id">
                <button type="button" class="btn btn-success" onclick="delete_supplier_info();"><span
                        class="glyphicon glyphicon-ok-sign"></span> <?= lang('yes') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> <?= lang('no') ?></button>
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
                        <li><span class="glyphicon glyphicon-warning-sign"></span><?= lang("alert_supplier_zero"); ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Delete Alert End-->
<script type="text/javascript">

    function locationAddress(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        // $('#select2-location-container').html("");
        if (cat == "divi") {
            var html = "<option value='0'><?= lang('select_district')?></option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>supplier/get_district',
                data: {id: id},
                success: function (result) {
                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for (var i = 0; i < length; i++) {
                            var val = data[i].id_district;
                            var district = data[i].district_name_en;
                            html += "<option value = '" + 'dist-' + val + "'>" + district + "</option>";
                        }

                        $('#address_location').html(html);
                        $('#division_id').val(id);
                        $('#city_id').val("");
                        $('#district_id').val("");
                        $('#city_location_id').val("");
                        return true;
                    } else {
                        alert('data not found !');
                        return false;
                    }
                }
            });
        } else if (cat == "city") {
            var html = "<option value='0'><?= lang('select_location')?></option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>supplier/get_city_location',
                data: {id: id},
                success: function (result) {

                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for (var i = 0; i < length; i++) {
                            var val = data[i].id_area;
                            var location = data[i].area_name_en;
                            html += "<option value = '" + 'city-' + val + "'>" + location + "</option>";
                        }

                        $('#address_location').html(html);
                        $('#city_id').val(id);
                        $('#division_id').val("");
                        $('#district_id').val("");
                        $('#city_location_id').val("");
                    }
                }
            });
        }
    }

    function editLocationAddress(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        // $('#select2-location-container').html("");
        if (cat == "divi") {
            var html = "<option value='0'>Select District</option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>supplier/get_district',
                data: {id: id},
                success: function (result) {
                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for (var i = 0; i < length; i++) {
                            var val = data[i].id_district;
                            var district = data[i].district_name_en;
                            html += "<option value = '" + 'dist-' + val + "'>" + district + "</option>";
                        }

                        $('#edit_address_location').html(html);
                        $('#edit_division_id').val(id);
                        $('#edit_city_id').val("");
                        $('#edit_district_id').val("");
                        $('#edit_city_location_id').val("");
                        return true;
                    } else {
                        alert('data not found !');
                        return false;
                    }
                }
            });
        } else if (cat == "city") {
            var html = "<option value='0'>Select Location</option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>supplier/get_city_location',
                data: {id: id},
                success: function (result) {
                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for (var i = 0; i < length; i++) {
                            var val = data[i].id_area;
                            var location = data[i].area_name_en;
                            html += "<option value = '" + 'city-' + val + "'>" + location + "</option>";
                        }

                        $('#edit_address_location').html(html);
                        $('#edit_city_id').val(id);
                        $('#edit_division_id').val("");
                        $('#edit_district_id').val("");
                        $('#edit_city_location_id').val("");
                    }
                }
            });
        }
    }

    function cityDistLoc(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        if (cat == "city") {
            $('#city_location_id').val(id);
        } else if (cat == "dist") {
            $('#district_id').val(id);
        }
    }

    function editCityDistLoc(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        if (cat == "city") {
            $('#edit_city_location_id').val(id);
        } else if (cat == "dist") {
            $('#edit_district_id').val(id);
        }
    }
</script>

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
        var phone_supplier = $('#phone_supplier').val();
        var email_supplier = $('#email_supplier').val();
        var inactive_supplier ='';
        if($('#inactive_sup').prop('checked')) {
            inactive_supplier=1;
        }  else {
            inactive_supplier=2;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>suppliers/supplier_info_data/' + page_num,
            data: 'page=' + page_num + '&name_supplier=' + name_supplier + '&phone_supplier=' + phone_supplier + '&email_supplier=' + email_supplier+'&inactive_supplier='+inactive_supplier,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    function csv_export() {
        var name_supplier = $('#name_supplier').val();
        var phone_supplier = $('#phone_supplier').val();
        var email_supplier = $('#email_supplier').val();
        var inactive_supplier ='';
        if($('#inactive_sup').prop('checked')) {
            inactive_supplier=1;
        }  else {
            inactive_supplier=2;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>suppliers/supplier_settings/create_csv_data',
            data: 'name_supplier=' + name_supplier + '&phone_supplier=' + phone_supplier + '&email_supplier=' + email_supplier+'&inactive_supplier='+inactive_supplier,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('.loading').fadeOut("slow");
                window.location.href = '<?php echo base_url(); ?>export_csv?request='+(html);
            }
        });
    }


    function deleteSupplierModal(id) {
        $('#delete_sup_id').val(id);
    }

    function delete_supplier_info() {
        var id = $('#delete_sup_id').val();
        var balance = $('#s_bal_'+id).html()*1;
        var credit = $('#s_c_bal_'+id).html()*1;
        if(balance > 0 || credit>0){
            $('#deleteSupplierInfoModal').modal('hide');
            $('#emptyAlert').modal('toggle');
        } else {
            $.ajax({
                url: '<?php echo base_url();?>delete_supplier_info',
                data: {id: id},
                type: 'post',
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data) {
                    $('#deleteSupplierInfoModal').modal('toggle');
                    $('#showMessage').html("<?php echo lang('delete_success');?>");
                    $('#showMessage').show();
                    window.onload = searchFilter(0);
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                    $('.loading').fadeOut("slow");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    }

    function editSupplier(id) {
        $.ajax({
            url: '<?php echo base_url();?>editSupplierInfo',
            data: {id: id},
            type: 'post',
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                if (result) {
                    var data = JSON.parse(result);
                    var division_id = data.result[0].div_id;
                    var district_id = data.result[0].dist_id;
                    var city_id = data.result[0].city_id;
                    var area_id = data.result[0].area_id;
                    $('#edit_supplier_id').val(data.result[0].id_supplier);
                    $('#edit_supplier_code').val(data.result[0].supplier_code);
                    $('#edit_full_name').val(data.result[0].supplier_name);
                    $('#edit_contact_person').val(data.result[0].contact_person);
                    $('#edit_email').val(data.result[0].email);
                    $('#edit_phone').val(data.result[0].phone);
                    $('#edit_addr_line_1').val(data.result[0].addr_line_1);
                    $('#edit_version').val(data.result[0].version);
                    $('#edit_vat_reg_no').val(data.result[0].vat_reg_no);
                    $('#edit_note').val(data.result[0].note);
                    $('#old_supplier_photo').val(data.result[0].profile_img);
                    if (division_id != 0) {
                        $('[id="city_division1"]').val('divi-' + division_id).change();
                        setTimeout(function () {
                            $('[id="edit_address_location"]').val('dist-' + district_id).change();
                        }, 500);
                    }

                    if (city_id != 0) {
                        $('[id="city_division1"]').val('city-' + city_id).change();
                        setTimeout(function () {
                            $('[id="edit_address_location"]').val('city-' + area_id).change();
                        }, 500);
                    }

                    var html = "";

                    for (var i = 0; i < data.store.length; i++) {
                        var selected = "";
                        for (var j = 0; j < data.supplier_store.length; j++) {
                            if (data.store[i].id_store == data.supplier_store[j].store_id) {
                                selected = "selected";
                            }
                        }
                        html += "<option " + selected + " value='" + data.store[i].id_store + "'>" + data.store[i].store_name + "</option>";
                    }
                    $('[id="edit_store_id"]').html(html);

                    var photo = data.result[0].profile_img;
                    if (photo) {
                        var image_path = "<?php echo documentLink('supplier')?>" + photo;
                        var image = "<img src='" + image_path + "'";
                        $("#supplier_photo").attr("src", image_path);
                    }

                    $('.loading').fadeOut("slow");

                    return false;
                } else {
                    return false;
                }
            }
        });
    }

    function editSupplierPaymentAlert(id) {
        $.ajax({
            url: '<?php echo base_url();?>viewSupplierAlert',
            data: {id: id},
            type: 'post',
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                if (result) {
                    var data = JSON.parse(result);

                    if (result != 0) {
                        //show
                        $('#dtt_act').show();
                        $('#id_supplier_payment_alert').val(data[0].id_supplier_payment_alert);
                        $('#supplier_payment_supplier_id').val(id);
                        $('#amount').val(data[0].amount);
                        $('#dtt_notification').val(data[0].dtt_notification);
                        $('#dtt_payment_est').val(data[0].dtt_payment_est);
                        $('#dtt_payment_act').val(data[0].dtt_payment_act);
                    } else {
                        //not show
                        $('#supplier_payment_supplier_id').val(id);
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
            if (id == "supplier_info") {
                var currentForm = $('#supplier_info')[0];
                var formData = new FormData(currentForm);
                formData.append('file', document.getElementById("profile_img").files[0]);
                $.ajax({
                    url: "<?= base_url() ?>create_supplier",
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
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#add').modal('toggle');
                            $('#supplier_info').trigger("reset");
                            $("#city_division").val("0").change();
                            $("#address_location").val("0").change();
                            $("#add_more_section").html("");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilter(0);
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);

                            }, 500);
                        }
                        $('.loading').fadeOut("slow");
                    }
                });
            }

            if (id == "edit_supplier_info") {
                var currentForm = $('#edit_supplier_info')[0];
                var formData = new FormData(currentForm);
                formData.append('file', document.getElementById("edit_profile_img").files[0]);

                $.ajax({
                    url: "<?= base_url() ?>update_supplier_info",
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
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#editSupplierInfo').modal('toggle');
                            $('#edit_supplier_info').trigger("reset");
                            $("#edit_city_division").val("0").change();
                            $("#edit_address_location").val("0").change();
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilter(0);
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);

                            }, 500);
                        }
                        $('.loading').fadeOut("slow");
                    }
                });
            }

            if (id == "supplier_payment_alert") {
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
                        if (result.status != 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#supplierPaymentAlert').modal('toggle');
                            $('#supplier_payment_alert').trigger("reset");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilter(0);
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);

                            }, 3000);
                        }
                        $('.loading').fadeOut("slow");
                    }
                });
            }

        }
    });
</script>