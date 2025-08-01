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
<?php
if ($this->session->flashdata('message')) {
    ?>
    <div class="showmessage" id="showMessage"> <?= $this->session->flashdata('message') ?></div>
    <?php
}
?>
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
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang("full_name"); ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang("full_name"); ?>"
                                                   type="text" id="sr_full_name" name="sr_full_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang("email"); ?></label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang("email"); ?>" type="text"
                                                   name="sr_email" id="sr_email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang("phone"); ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang("phone"); ?>" type="text"
                                                   name="sr_phone" id="sr_phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang("type"); ?> </label>
                                        <div class="col-sm-12">
                                            <select class="form-control"  id="sr_type" name="sr_type">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($types as $type) {
                                                        echo '<option value="' . $type->id_user_type . '">' . $type->type_name . '</option>';

                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">

                                    <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                    <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                            class="fa fa-search"></i> <?= lang("search"); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                echo '<div class="total-user">Total User: <span id="usr_total">'.$totalUser[0]['param_val'].'</span></div><div class="used"> Used: <span id="usr_used">'.$totalUser[0]['utilized_val'].'</span></div>';
                                ?>
                                <button onclick="add_users()" class="btn btn-primary btn-rounded right" type="button"><?= lang("add_employee"); ?> </button>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php $this->load->view('employees/all_employee_data', $posts, false);?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="add" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg modal-full">
        <!-- Modal content-->
        <div class="modal-content">
            <?php echo form_open_multipart('', array('id' => 'employeeFormAdd', 'class' => 'cmxform',)); ?>
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("employee"); ?> <span class="close"
                                                                                   data-dismiss="modal">&times;</span>
                </h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group row   bottom-20">
                            <label class="col-sm-12 bottom-10 col-form-label"><?= lang("type"); ?><span
                                    class="req">*</span></label>
                            <?php
                            foreach ($types as $type) {
                                $check = ($type->id_user_type == 1) ? 'checked=""' : '';
                                echo '<div class="col-sm-6">';
                                echo '<input id="' . $type->type_name . '" value="' . $type->id_user_type . '" name="user_type" type="radio" ' . $check . ' onClick="showParmit(this)">';
                                echo '<label for="' . $type->type_name . '">' . $type->type_name . '</label>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for=""><?= lang("full_name"); ?><span
                                    class="req">*</span></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="name" id="name"
                                       placeholder="<?= lang("full_name"); ?>" type="text">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-12" for=""> <?= lang("email"); ?><span
                                    class="req">*</span></label>
                            <div class="col-sm-12">
                                <input class="form-control" placeholder="<?= lang("email"); ?>" type="email"
                                       name="emp_email" id="emp_email">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-12" for=""> <?= lang("phone"); ?><span
                                    class="req">*</span></label>
                            <div class="col-sm-12">
                                <input class="form-control" placeholder="<?= lang("phone"); ?>" type="text" name="phone"
                                       id="phone">
                            </div>
                        </div>
                    </div>

                </div>

                <div id="parmition_tab">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for=""><?= lang("job_title"); ?></label>
                                <div class="col-sm-12">
                                    <input class="form-control" placeholder="<?= lang("job_title"); ?>" type="text"
                                           name="job_title" id="job_title">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for=""><?= lang("dob"); ?></label>
                                <div class='col-sm-12'>
                                    <div class='input-group date' id='DOB'>
                                        <input type='text' name="dob" id="dob" class="form-control"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for=""><?= lang("joining_date"); ?></label>
                                <div class='col-sm-12'>
                                    <div class='input-group date' id='JoiningDate'>
                                        <input type='text' name="joining_date" id="joining_date" class="form-control"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for=""><?= lang("salary"); ?></label>
                                <div class="col-sm-12">
                                    <input class="form-control" placeholder="<?= lang("salary"); ?>" type="text"
                                           name="salary" id="salary">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang("store_name"); ?><span
                                        class="req">*</span></label>
                                <div class="col-sm-12">
                                    <div class="row-fluid">
                                        <select class="form-control" id="store_name"
                                                name="store_name" onchange="getStations(this.value)">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($stores as $store) {
                                                if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                                    echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                } else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
                                                    echo '<option value="' . $store->id_store . '" selected>' . $store->store_name . '</option>';
                                                }

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang("station"); ?><span class="req">*</span></label>
                                <div class="col-sm-12">
                                    <div class="row-fluid">
                                        <select class="form-control" id="category" name="category">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            //foreach ($stations as $station) {
                                                //echo '<option value="' . $station->id_station . '">' . $station->name . '</option>';
                                           // }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for=""><?= lang("nid"); ?></label>
                                <div class="col-sm-12">
                                    <input class="form-control" placeholder="<?= lang("nid"); ?>" type="text"
                                           name="nid" id="nid">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for=""><?= lang("blood_group"); ?></label>
                                <div class="col-sm-12">
                                    <select class="form-control" id="blood_group" name="blood_group">
                                        <option value="0" selected><?= lang("select_one"); ?></option>
                                        <?php
                                        $groups=$this->config->item('blood_groups');
                                        foreach ($groups as $group) {
                                            echo '<option value="' . $group . '">' . $group . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-10 margin-bottom-10">
                    <div class="col-md-6">

                        <div id="add_access_type">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("software_access"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <input id="yes" name="access" value="Yes" type="radio"
                                                   onClick="showAccess(this)">
                                            <label for="yes"><?= lang("yes"); ?></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="no" name="access" value="No" type="radio" onClick="showAccess(this)">
                                            <label for="no"><?= lang("no"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang("select_file"); ?></label>
                                <div class="col-sm-12">
                                    <input type="file" name="userfile" id="userfile1">
                                    <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("file_type"); ?></p>
                                </div>
                            </div>
                        </div>
                        <div id="add_access" style="display: none;">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("user_name"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="emp_username" name="emp_username"
                                               placeholder="<?= lang("user_name"); ?>" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-12" for=""> <?= lang("password"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="password" name="password"
                                               placeholder="<?= lang("password"); ?>" type="password">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <fieldset class="form-group">
                            <legend><?= lang("address"); ?></legend>
                            <div class="col-md-6">
                                <div class="col-md-12 col-sm-4 col-xs-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang('city_division') ?></label>
                                        <div class="col-sm-12">
                                            <div class="row-fluid">
                                                <select class="selectpicker" data-live-search="true" id="city_division"
                                                        name="city_division2" onchange="locationAddress(value);">
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
                                </div>

                                <input type="hidden" name="division_id" id="division_id">
                                <input type="hidden" name="district_id" id="district_id">
                                <div class="col-md-12 col-sm-4 col-xs-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang('location') ?></label>
                                        <div class="col-sm-12">
                                            <div class="row-fluid">
                                                <select class="selectpicker" id="address_location" name="address_location2"
                                                        onchange="cityDistLoc(value);">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang('address') ?></label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="3" name="addr_line"
                                                      value="addr_line"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="city_id" id="city_id">
                            <input type="hidden" name="city_location_id" id="city_location_id">
                        </fieldset>
                    </div>
                </div>


                <input type="hidden" id="total_num_of_fields" name="total_num_of_fields" value="1">
            </div>

            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" value="<?= lang("submit"); ?>"> </button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>


    </div>
</div>
<?php
$this->load->view('employees/employee_edit');
?>
<div class="modal fade" id="deleteEmployee" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_this_entry"); ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span
                        class="glyphicon glyphicon-warning-sign"></span> <?= lang("confirm_delete"); ?></div>

            </div>
            <div class="modal-footer ">
                <input type="hidden" id="employee_delete_id">
                <button type="button" class="btn btn-success" onclick="delete_employee();"><span
                        class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="EmptyAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> New user add not available.
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
    function add_users() {
        var total = $('#usr_total').html()*1;
        var used = $('#usr_used').html()*1;
        if((total == used) || (total < used)){
            //$('#EmptyAlert').modal('toggle');
            $('#add_access_type').css('display','none');
        }else{
            $('#add_access_type').css('display','block');
        }
        $('#add').modal('toggle');
    }
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var sr_full_name = $('#sr_full_name').val();
        var sr_email = $('#sr_email').val();
        var sr_phone = $('#sr_phone').val();
        var sr_type = $('#sr_type').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>employee/page_data/' + page_num,
            data: 'page=' + page_num + '&sr_full_name=' + sr_full_name + '&sr_email=' + sr_email + '&sr_phone=' + sr_phone+ '&sr_type=' + sr_type,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                console.log(html);
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    var x = 1;
    function showAccess(elem) {
        elem.checked && elem.value === "Yes" ? $("#add_access").show() : $("#add_access").hide();
    }
    function showParmit(elem) {
        if (elem.checked && elem.id === "Admin" || elem.id === "Investor") {
            $("#parmition_tab").hide()
            $("#add_access_type").hide()
            $("#add_access").hide();

        } else {

            $("#add_access_type").show()
            $("#parmition_tab").show();
            var check = $('input[name="access"]:checked').val();
            if (check == 'Yes') {
                $("#add_access").show();
            }
        }

    }
    function getStations(value) {
        //alert(value);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>get_stations_by_store',
            data: 'id=' + value,
            success: function (result) {
                var html = '';
                var data = JSON.parse(result);
                if (data.status !== 'undefined') {
                    var length = data.length;
                    html = "<option value = '0'><?= lang("select_one"); ?></option>";
                    for (var i = 0; i < length; i++) {
                        var val = data[i].id_station;
                        var name = data[i].name;
                        html += "<option value = '" + val + "'>" + name + "</option>";
                    }
                }else{
                    html = "<option value = '0'><?= lang("select_one"); ?></option>";
                }
                //alert(html);
                $("#category").html(html);
                //$('#postList').html(html);

            }
        });
    }
    function getStationEdit(value) {
        //alert(value);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>get_stations_by_store',
            data: 'id=' + value,
            success: function (result) {
                var html = '';
                var data = JSON.parse(result);
                console.log(data);
                if (data.status !== 'undefined') {
                    var length = data.length;
                    html = "<option value = '0'><?= lang("select_one"); ?></option>";
                    for (var i = 0; i < length; i++) {
                        var val = data[i].id_station;
                        var name = data[i].name;
                        html += "<option value = '" + val + "'>" + name + "</option>";
                    }
                }else{
                    html = "<option value = '0'><?= lang("select_one"); ?></option>";
                }
                //alert(html);
                $("#emp_category").html(html);
                //$('#postList').html(html);

            }
        });
    }
    $(function () {
        $('#DOB').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });
    $(function () {
        $('#JoiningDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

    });
    $(function () {
        $('#EMPDOB').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });
    $(function () {
        $('#EMPJoiningDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

    });
    function editEmployee(id) {
        $.ajax({
            url: "<?php echo base_url() ?>employee/edit/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('.loading').fadeOut("slow");
                var division_id = data.div_id;
                var district_id = data.dist_id;
                var city_id = data.city_id;
                var area_id = data.area_id;
                $('#user_id').val(data.id_user);
                $('#emp_nid').val(data.nid);
                $('#emp_name').val(data.fullname);
                $('#image_id').val(data.profile_img)
                $('#employee_id').val(data.id_user);
                $('#emp_email_id').val(data.email);
                $('#emp_phone').val(data.mobile);
                $('#emp_job_title').val(data.job_title);
                $('#emp_dob').val(data.birth_date);
                $('#emp_joining_date').val(data.join_date);
                $('#edit_type_id').val(data.type_name);
                $('#emp_salary').val(data.salary);
                // $('#type-' + data.user_type_id).prop("checked", true);
               // $('#emp_blood_group').val(data.blood_group).change();
                $('#emp_store_name').val(data.store_id).change();
                setTimeout(function () {
                    $('#emp_category').val(data.station_id).change();
                }, 1000);
                //$('#emp_category').val(data.station_id).change();
                $('#emp_blood_group').val(data.blood_group).change();
                data.user_type_id == 1 ? $("#emp_parmition_tab").show() : $("#emp_parmition_tab").hide();
                $('#type-' + data.user_type_id + ':not(:checked)').attr('disabled', true);
                $('#edit_addr_line').val(data.addr_line_1);
                if (division_id != 0) {
                    $('[id="city_division1"]').val('divi-' + division_id).change();
                    setTimeout(function () {
                        $('[id="edit_address_location"]').val('dist-' + district_id).change();
                    }, 1000);
                }
                if (city_id != 0) {
                    console.log(city_id);
                    $('[id="city_division1"]').val('city-' + city_id).change();
                    $('.selectpicker').selectpicker('refresh');
                    setTimeout(function () {
                        $('[id="edit_address_location"]').val('city-' + area_id).change();
                    }, 1000);
                }
                var photo = data.profile_img;
                if (data.profile_img) {
                    var image_path = "<?php echo documentLink('user')?>" + photo;
                    var image = "<img src='" + image_path + "'  height='70' width='100'>";
                    $('#imageDiv').html(image);
                } else {
                    $('#imageDiv').html('');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    function deleteEmployeeModal(id) {
        $('#employee_delete_id').val(id);
    }
    function delete_employee() {
        var id = $('#employee_delete_id').val();
        $.ajax({
            url: "<?php echo base_url() . 'employee/delete' ?>/" + id,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                if(data.count==2){
                    $used=$('#usr_used').html()*1;
                    $('#usr_used').html($used-1);
                }
                $('.loading').fadeOut("slow");
                $('#showMessage').html('<?= lang("delete_success"); ?>');
                $('#deleteEmployee').modal('toggle');
                window.onload = searchFilter(0);
                $('#showMessage').show();
                setTimeout(function () {
                    $('#showMessage').fadeOut(300);

                }, 1000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error deleting data');
            }
        });
    }
    function locationAddress(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        // $('#select2-location-container').html("");
        if (cat == "divi") {
            var html = "<option value='0'><?= lang('select_district') ?></option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>get_district',
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
                url: '<?php echo base_url() ?>supplier/get_city_location',
                data: {id: id},
                success: function (result) {
                    $('.selectpicker').selectpicker('refresh');
                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for (var i = 0; i < length; i++) {
                            var val = data[i].id_area;
                            var location = data[i].area_name_en;
                            html += "<option value = '" + 'city-' + val + "'>" + location + "</option>";
                        }
                        //$(".selectpicker").selectpicker();
                        $('#address_location').html(html);
                        $('.selectpicker').selectpicker('refresh');
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
        $('.selectpicker').selectpicker('refresh');
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
    function editLocationAddress(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);
        $('.selectpicker').selectpicker('refresh');
        // $('#select2-location-container').html("");
        if (cat == "divi") {
            var html = "<option value='0'>Select District</option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>get_district',
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
                url: '<?php echo base_url() ?>get_city_location',
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
    $.validator.setDefaults({
        submitHandler: function (form) {
            var id = form.id;
            if (id == "employeeFormAdd") {
                var currentForm = $('#employeeFormAdd')[0];
                var formData = new FormData(currentForm);
                $.ajax({
                    url: "<?= base_url() ?>add_employee_data",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (response) {
                        var result = $.parseJSON(response);
                        //var result = response;
                        if (result.status !== 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            if(result.count==2){
                                $used=$('#usr_used').html()*1;
                                $('#usr_used').html($used+1);
                            }
                            $('#add').modal('hide');
                            $('#employeeFormAdd')[0].reset();
                            $('#add_more_section').html('');
                            $('#total_num_of_fields').val('1');
                            $("#category").val("0").change();
                            $('#add_access').hide();
                            $("#parmition_tab").show();
                            $('#showMessage').html(result.message);
                            window.onload = searchFilter(0);
                            $('#showMessage').show();
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);
                            }, 3000);
                        }
                        $('.loading').fadeOut("slow");
                    }
                });
            } else if (id === "employeeFormEdit") {
                var currentForm = $('#employeeFormEdit')[0];
                var formData = new FormData(currentForm);
                $.ajax({
                    url: "<?= base_url() ?>edit_employee_data",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (response) {
                        //console.log(response);
                        var result = $.parseJSON(response);
                        //var result = response;
                        if (result.status !== 'success') {
                            $.each(result, function (key, value) {
                                alert(key)
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#edit_employee').modal('hide');
                            $('#employeeFormEdit')[0].reset();
                            $("#emp_category").val("0").change();
                            $('#showMessage').html(result.message);
                            window.onload = searchFilter(0);
                            $('#showMessage').show();
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);
                            }, 1000);
                        }
                        $('.loading').fadeOut("slow");
                    }
                });
            } else {
                conslole.log('error in submit');
            }
        }
    });
</script>  

