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
            <div class="col-lg-6">
                <div class="element-wrapper">
                    <!--This is for Number of Station Availability Start  -->
                    <div class="element-box full-box">

                        <h6 class="element-header"><?= lang("number_store_availability"); ?></h6>
                        <div class="station-info">
                            <h6><?= lang("total"); ?></h6>
                            <div class="num"><?= $records[0]->param_val ?></div>
                        </div>
                        <div class="station-info">
                            <h6><?= lang("used"); ?></h6>
                            <div class="num"><?= $records[0]->utilized_val ?></div>
                        </div>
                        <div class="station-info">
                            <h6><?= lang("remaining"); ?></h6>
                            <div class="num"><?= ($records[0]->param_val - $records[0]->utilized_val) ?></div>
                        </div>
                    </div>
                    <!--This is for Number of Station Availability Start  -->
                    <!-- Add Station start here -->
                    <div class="element-box full-box">
                        <?php echo form_open_multipart('', array('id' => 'stores', 'class' => 'cmxform')); ?>

                        <h6 class="element-header" id="layout_title"><?= lang("add_store"); ?></h6>
                        <input type="hidden" name="store_no" id="store_no"
                               value="<?= ($records[0]->param_val - $records[0]->utilized_val) ?>">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="edit_id" id="edit_id" value="1">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("store_name"); ?><span
                                    class="req">*</span></label></label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="<?= lang("store_name"); ?>" type="text"
                                       id="store_name" name="store_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("email"); ?></label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="<?= lang("email"); ?>" type="text" id="email"
                                       name="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("mobile_no"); ?></label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="<?= lang("mobile_no"); ?>" type="text"
                                       id="mobile_no" name="mobile_no">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><?= lang('city_division') ?><span
                                    class="req">*</span></label>
                            <div class="col-sm-8">
                                <div class="row-fluid">
                                    <select class="select2" data-live-search="true" id="city_division"
                                            name="city_division" onchange="locationAddress(value);">
                                        <option value="0" selected><?= lang('select_one') ?></option>
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

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><?= lang('location') ?><span
                                    class="req">*</span></label>
                            <div class="col-sm-8">
                                <div class="row-fluid">
                                    <select class="select2" id="address_location" name="address_location"
                                            onchange="cityDistLoc(value);">
                                        <option value="0"><?= lang('select_one') ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("vat_reg_no"); ?></label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="<?= lang("vat_reg_no"); ?>" type="text"
                                       id="reg_no" name="reg_no">
                            </div>
                        </div>
                        <input type="hidden" name="division_id" id="division_id">
                        <input type="hidden" name="district_id" id="district_id">
                        <input type="hidden" name="city_id" id="city_id">
                        <input type="hidden" name="city_location_id" id="city_location_id">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("post_code"); ?></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="post_code" id="post_code"
                                       placeholder="<?= lang("post_code"); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("address"); ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" rows="3" name="address" id="address"
                                          placeholder="<?= lang("address"); ?>"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("description"); ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" rows="3" name="description" id="description"
                                          placeholder="<?= lang("description"); ?>"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><?= lang("photo"); ?></label>
                            <div class="col-sm-8">
                                <input type="file" name="userfile" id="userfile"/>
                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("file_type"); ?></p>
                                <div id="imageDiv"></div>
                            </div>
                        </div>
                        <div class="form-buttons-w">
                            <button class="btn btn-primary pull-right" style="margin-left: 5px;" onclick="resetAll()"
                                    type="reset"><?= lang("reset"); ?></button>
                            <button class="btn btn-primary pull-right" type="submit"> <?= lang("submit"); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!-- Add Station End here -->

            </div>
            <!-- Stations List Start here -->
            <div class="col-lg-6">
                <div class="element-wrapper">
                    <div class="element-box full-box">

                        <h6 class="element-header"><?= lang("store_list"); ?></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang("sl_no"); ?></th>
                                        <th><?= lang("store_name"); ?></th>
                                        <th><?= lang("action"); ?></th>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!empty($posts)):
                                            $count = 1;
                                            foreach ($posts as $post): ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo $post->store_name; ?></td>
                                                    <td>
                                                        <button rel="tooltip" title="<?= lang("view")?>"  class="btn btn-primary btn-xs"
                                                                data-title="<?= lang("view"); ?>" data-toggle="modal"
                                                                data-target="#view"
                                                                onclick="viewStoreDetaitls(<?= $post->id_store ?>)">
                                                            <span class="glyphicon glyphicon-eye-open"></span></button>
                                                        <button rel="tooltip" title="<?= lang("edit")?>"  class="btn btn-primary btn-xs"
                                                                data-title="<?= lang("edit"); ?>"
                                                                onclick="edit_store(<?= $post->id_store ?>)"><span
                                                                class="glyphicon glyphicon-pencil"></span></button>
                                                    </td>
                                                </tr>
                                                <?php
                                                $count++;
                                            endforeach;
                                        else: ?>
                                            <tr>
                                                <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Stations List End here -->
        </div>
    </div>
</div>
<div id="view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("store_details"); ?> <span class="close"
                                                                                        data-dismiss="modal">&times;</span>
                </h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="col-md-8">
                        <div class="info-1">
                            <div class="company-name margin-0" id="store_name_view2"></div>
                            <div class="company-email"><strong class="fix-width"><?= lang("sl_no"); ?></strong>: <span
                                    id="sl_no"></span></div>
                            <div class="company-address"><strong class="fix-width"><?= lang("store_name"); ?></strong>:
                                <span id="store_name_view"></span></div>
                            <div class="company-address"><strong class="fix-width"><?= lang("email"); ?></strong>:
                                <span id="store_email_view"></span></div>
                            <div class="company-address"><strong class="fix-width"><?= lang("mobile_no"); ?></strong>:
                                <span id="store_mobile_view"></span></div>
                            <div class="company-address"><strong class="fix-width"><?= lang("vat_reg_no"); ?></strong>:
                                <span id="vat_reg_no_view"></span></div>
                            <div class="company-address"><strong class="fix-width"><?= lang("post_code"); ?></strong>: <span
                                    id="post_code_view"></span></div>
                            <div class="company-address"><strong class="fix-width"><?= lang("address"); ?></strong>:
                                <span id="address_view"></span></div>
                            <div class="company-address"><strong class="fix-width"><?= lang("description"); ?></strong>:
                                <span id="store_description"></span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product-img" id="pro_imageDiv" style="margin-top: 40px;">
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
<div class="modal fade" id="storeEmptyAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> Please add store first.
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>
<script>

    function edit_store(id_store) {
        $('#stores')[0].reset(); // reset form on modals
        //Ajax Load data from ajax
        // alert(id_store);
        $.ajax({
            url: "<?php echo base_url() ?>settings/store/edit_data/" + id_store,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                var division_id = data.div_id;
                var district_id = data.dist_id;
                var city_id = data.city_id;
                var area_id = data.area_id;

                $('.loading').fadeOut("slow");
                $('#store_name').val(data.store_name);
                if (id_store == 1) {
                    $('#store_name').attr('readonly', true);
                }
                $('#email').val(data.email);
                $('#description').val(data.description);
                $('#mobile_no').val(data.mobile);
                $('#post_code').val(data.post_code);
                $('#address').val(data.address_line);
                $('#reg_no').val(data.vat_reg_no);
                $('[name="id"]').val(data.id_store);
                $('#store_name').attr('store_name', 'store_name');
                $('#email').attr('email', 'email');
                $('#description').attr('description', 'description');
                $('#mobile_no').attr('mobile_no', 'mobile_no');
                $('#post_code').attr('post_code', 'post_code');
                $('#address').attr('address', 'address');
                if (division_id != 0) {
                    $('[id="city_division"]').val('divi-' + division_id).change();
                    setTimeout(function () {
                        $('[id="address_location"]').val('dist-' + district_id).change();
                    }, 500);
                }

                if (city_id != 0) {
                    $('[id="city_division"]').val('city-' + city_id).change();
                    setTimeout(function () {
                        $('[id="address_location"]').val('city-' + area_id).change();
                    }, 500);
                }
                var photo = data.store_img;
                if (photo != null) {
                    var image_path = "<?php echo documentLink('user');?>" + photo;
                    var image = "<img src='" + image_path + "'  height='70' width='100'>";
                    $('#imageDiv').html(image);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    function resetAll() {
        $('#stores')[0].reset();
        $('#layout_title').text('<?= lang("add_store"); ?>');
        $('[name="id"]').val('');
        $('#store_name').attr('name', 'store_name');
        $("#city_division").val("0").change();
        $("#address_location").val("0").change();
        $('#imageDiv').html('');
        $('#store_name').attr('readonly', false);
    }
    $.validator.setDefaults({
        submitHandler: function (form) {
            var store = $('[name="store_no"]').val();
            var id = $('[name="id"]').val();
            var edit_id = $('[name="edit_id"]').val();
            if (store <= 0 && id == '') {
                $('#storeEmptyAlert').modal('toggle');
                //$('#stores')[0].reset();
                return false;
            } else {
                var currentForm = $('#stores')[0];
                var formData = new FormData(currentForm);
                $.ajax({
                    url: "<?= base_url() ?>settings/store/add_data77",
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
                                console.log(key + ' : ' + value);
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                                //$('[name="' + key + '"]').addClass("error");
                                //$('[name="' + key + '"]').after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            // $('#stations')[0].reset();
                            $('#showMessage').html(result.message);
                            $('#store_name').attr('name', 'store_name');
                            $('#showMessage').show();
                            setTimeout(function () {
                                window.location.href = "<?php echo base_url() ?>settings/store";
                            }, 200);
                        }
                         $('.loading').fadeOut("slow");
                    }
                });
            }

        }
    });
    function locationAddress(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        // $('#select2-location-container').html("");
        if (cat == "divi") {
            var html = "<option value='0'><?= lang('select_district')?></option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>settings/get_district',
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
                url: '<?php echo base_url() ?>settings/get_city_location',
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

    function editCityDistLoc(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        if (cat == "city") {
            $('#edit_city_location_id').val(id);
        } else if (cat == "dist") {
            $('#edit_district_id').val(id);
        }
    }

    function viewStoreDetaitls(id_store) {
        // alert(id_store);
        $.ajax({
            url: "<?php echo base_url() ?>store/views/" + id_store,
            type: "GET",
            dataType: "JSON",
            // beforeSend: function () {
            //     $('.loading').show();
            // },
            success: function (data) {

                console.log(data);
                // alart($data);
                $('.loading').fadeOut("slow");
                // $('#store_name_view').html(data.product_name);
                $('#sl_no').html(data.id_store);
                $('#store_name_view').html(data.store_name);
                $('#store_description').html(data.description);
                $('#added_by').html(data.uname);
                $('#added_date').html(data.dtt_add);
                $('#last_modifed').html(data.dtt_mod);
                $('#store_email_view').html(data.email);
                $('#store_mobile_view').html(data.mobile);
                $('#vat_reg_no_view').html(data.vat_reg_no);
                $('#post_code_view').html(data.post_code);
                var address=data.address_line+', ';
                var area=data.area_name_en;
                if(!area){
                    address+=data.district_name_en+', '+data.division_name_en
                } else{
                    address+=data.area_name_en+', '+data.city_name_en;
                }
                $('#address_view').html(address);
                var photo = data.store_img;
                if (photo != '') {
                    var image_path = "<?php echo documentLink('user');?>" + photo;
                    var image = "<img src='" + image_path + "'  height='70' width='100'>";
                    $('#pro_imageDiv').html(image);
                }
            },

            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>  


