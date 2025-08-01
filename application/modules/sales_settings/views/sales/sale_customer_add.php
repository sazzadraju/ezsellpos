<div id="customer_add" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><?= lang('customer') ?> </h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <?php echo form_open_multipart('', array('id' => 'customer_info', 'class' => '')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for=""><?= lang('membership_id') ?><span
                                        class="req">*</span></label>
                            <div class="col-sm-12">
                                <input class="form-control" placeholder="<?= lang('membership_id') ?>" type="text"
                                       id="customer_code" name="customer_code" value="<?php echo time(); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label"><?= lang('customer_type') ?><span
                                        class="req">*</span></label>
                            <div class="col-sm-12">

                                <div class="row-fluid">
                                    <select class="custom-select custom-select-sm" id="customer_type_id" name="customer_type_id">
                                        <option value="0" selected><?= lang('select_one') ?></option>
                                        <?php
                                        if ($customer_type_list) {
                                            foreach ($customer_type_list as $type_list) {
                                                ?>
                                                <option
                                                        value="<?php echo $type_list->id_customer_type; ?>"><?php echo $type_list->name; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for=""><?= lang('full_name') ?><span
                                        class="req">*</span></label>
                            <div class="col-sm-12">
                                <input class="form-control" placeholder="<?= lang('full_name') ?>" type="text"
                                       id="customer_name" name="full_name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">    
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-12" for=""><?= lang('email') ?></label>
                            <div class="col-sm-12">
                                <input class="form-control" placeholder="<?= lang('email') ?>" type="email" id="email"
                                       name="email2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for=""><?= lang('phone') ?><span
                                        class="req">*</span></label>
                            <div class="col-sm-12">
                                <input class="form-control" placeholder="<?= lang('phone') ?>" type="text" id="phone"
                                       name="phone">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label"><?= lang('address_type') ?></label>
                            <div class="col-sm-12">
                                <div class="row-fluid">
                                    <select class="custom-select custom-select-sm" id="address_type" name="address_type2">
                                        <option value="0"><?= lang('select_one') ?></option>
                                        <option value="Present Address">Present Address</option>
                                        <option value="Permanent Address">Permanent Address</option>
                                        <option value="Shipping Address">Shipping Address</option>
                                        <option value="Billing Address">Billing Address</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label"><?= lang('city_division') ?></label>
                            <div class="col-sm-12">
                                <div class="row-fluid">
                                    <select class="custom-select custom-select-sm" data-live-search="true" id="city_division" name="city_division2" onchange="locationAddress(value);">
                                        <option value="0" selected><?= lang('select_one') ?></option>
                                        <optgroup label="City">
                                            <?php
                                            if ($city_list) {
                                                foreach ($city_list as $list) {
                                                    ?>
                                                    <option value="city-<?php echo $list['id_city']; ?>"><?php echo $list['city_name_en']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </optgroup>
                                        <optgroup label="Division">
                                            <?php
                                            if ($division_list) {
                                                foreach ($division_list as $list) {
                                                    ?>
                                                    <option value="divi-<?php echo $list['id_division']; ?>"><?php echo $list['division_name_en']; ?></option>
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

                    <div class="col-md-4">
                        <input type="hidden" name="division_id" id="division_id">
                        <input type="hidden" name="district_id" id="district_id">

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label"><?= lang('location') ?></label>
                            <div class="col-sm-12">
                                <div class="row-fluid">
                                    <select class="custom-select custom-select-sm" id="address_location" name="address_location2" onchange="cityDistLoc(value);">
                                        <option value="0"><?= lang('select_one') ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="city_id" id="city_id">
                        <input type="hidden" name="city_location_id" id="city_location_id">

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label"><?= lang('address') ?></label>
                            <div class="col-sm-12">
                                <textarea class="form-control" rows="3" name="addr_line_1" id="addr_line_1"></textarea>
                            </div>
                        </div>
                    </div> 

                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" value="<?= lang('submit') ?>"> </button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>


    </div>
</div>

<script type="text/javascript">
    function addCustomer() {
        $('#customer_info')[0].reset();
        $("#customer_code").val($.now());
        $("input").removeClass("focus_error");
        $("select").removeClass("focus_error");
        $('#city_division').val(0).change();
        $('#address_location').val(0).change();
        $('#address_type').val(0).change();
    }
    $("#customer_info").submit(function () {
        $("#phone_error").html('');
        $("input").removeClass("focus_error");
        $("select").removeClass("focus_error");
        var error_count = 0;
        var customer_name = $('#customer_name').val();
        var customer_type = $('#customer_type_id option:selected').val();
        var phone = $('#phone').val();
        if (customer_name == '') {
            $('#customer_name').addClass("focus_error");
            error_count += 1;
        }
        if (customer_type == '0') {
            $('#customer_type_id').addClass("focus_error");
            error_count += 1;
        }
        if (phone == '') {
            $('#phone').addClass("focus_error");
            error_count += 1;
        }
        if (error_count == 0) {
            var currentForm = $('#customer_info')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>create_customer_info_short",
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
                        console.log(result);
                        if (result.message[0].id_customer) {
                            $("#src_customer_id").val(result.message[0].id_customer);
                            $("#show_customer_balance").html('0');
                            $("#show_customer_phone").html(result.message[0].phone);
                            $("#src_customer_name").val(result.message[0].full_name + ' (' + result.message[0].phone + ')');
                        }
                        $('#customer_add').modal('toggle');
                        $('#customer_info').trigger("reset");
                        $("#customer_type_id").val("0").change();
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);
                        }, 500);
                    }
                    $('.loading').fadeOut("slow");
                }
            });
        }
        return false;
    });

    function locationAddress(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        // $('#select2-location-container').html("");
        if (cat == "divi") {
            var html = "<option value='0'><?= lang('select_district') ?></option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>customer_settings/customer/get_district',
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
            var html = "<option value='0'><?= lang('select_location') ?></option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>customer_settings/customer/get_city_location',
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

    function cityDistLoc(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        if (cat == "city") {
            $('#city_location_id').val(id);
        } else if (cat == "dist") {
            $('#district_id').val(id);
        }
    }
</script>