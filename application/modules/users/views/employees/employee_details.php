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

                    <div class="full-box element-box">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="tab-menu">
                                    <li class="active">
                                        <a href="#View" data-toggle="tab" class="btn btn-primary"><?= lang('employee_details') ?></a>
                                    </li>

                                    <li>
                                        <a href="#EmployeeDocument" data-toggle="tab" class="btn btn-primary"><?= lang('employee_document') ?></a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>

                    <div class="element-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div id="View" class="tab-pane fade in active full-box">
                                        <input type="hidden" name="id_user" id="id_user" value="<?php echo $employee_info[0]['id_user']; ?>">
                                        <div class="info-1">
                                            <div class="receive-payment">
                                                <h6 class="element-header"><?= lang('employee_details') ?></h6>
                                                <button class="btn btn-primary btn-xs right" data-title="Edit" data-toggle="modal" data-target="#edit_employee" onclick="editEmployee('<?php echo $employee_info[0]['id_user']; ?>')"><span class="glyphicon glyphicon-pencil"></span></button>
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                                        <div class="rcv-pmnt"><strong class="fix-width"><?= lang('full_name') ?></strong>: <?php echo $employee_info[0]['fullname']; ?></div>
                                                        <div class="rcv-pmnt"><strong class="fix-width"><?= lang('user_id') ?></strong>: <?php echo $employee_info[0]['id_user']; ?></div>
                                                        <div class="rcv-pmnt"><strong class="fix-width"><?= lang('type') ?></strong> : <?php echo $employee_info[0]['type_name']; ?></div>
														<div class="rcv-pmnt"><strong class="fix-width"><?= lang('user_name') ?></strong> : <?php echo $employee_info[0]['uname']; ?></div>
                                                        <div class="rcv-pmnt"><strong class="fix-width"><?= lang('store') ?></strong> : <?php echo $employee_info[0]['store_name']; ?></div>
                                                        <div class="rcv-pmnt"><strong class="fix-width"><?= lang('email') ?></strong> : <?php echo $employee_info[0]['email']; ?></div>
                                                        <div class="rcv-pmnt"><strong class="fix-width"><?= lang('phone') ?></strong> : <?php echo $employee_info[0]['mobile']; ?></div>
                                                        <div class="rcv-pmnt"><strong class="fix-width"><?= lang('station') ?></strong> : <?php echo $employee_info[0]['station_name']; ?></div>
                                                        <div class="rcv-pmnt"><strong class="fix-width"><?= lang('address') ?></strong> : <?php echo $employee_info[0]['addr_line_1']; ?></div>
                                                        
                                                        <?php
                                                        if ($employee_info[0]['user_type_id'] == 2) {
                                                            ?>
                                                            <div class="rcv-pmnt" class="fix-width"><strong><?= lang('balance') ?></strong>: <?php echo $employee_info[0]['balance']; ?> TK</div>
                                                            <?php
                                                        }
                                                        if ($employee_info[0]['user_type_id'] == 1) {
                                                            ?>
                                                            <div class="rcv-pmnt" class="fix-width"><strong><?= lang('job_title') ?></strong>: <?php echo $employee_info[0]['job_title']; ?></div>
                                                            <div class="rcv-pmnt" class="fix-width"><strong><?= lang('dob') ?></strong> : <?php echo $employee_info[0]['birth_date']; ?></div>
                                                            <div class="rcv-pmnt" class="fix-width"><strong><?= lang('joining_date') ?></strong>: <?php echo $employee_info[0]['join_date']; ?></div>
                                                            <div class="rcv-pmnt" class="fix-width"><strong><?= lang('salary') ?></strong> : <?php echo $employee_info[0]['salary']; ?>TK</div>

                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="product-img" id="pro_imageDiv" style="margin-top: 40px;">
                                                            <?php
                                                            $photo = $employee_info[0]['profile_img'];
                                                            if ($photo != '') {
                                                                $image_path = documentLink('user') . $photo;
                                                                $image = "<img src='" . $image_path . "' style='float:left;  height:120px; width:120px;'>";
                                                                echo $image;
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Edit Modal Start-->
                                    <?php
                                    $this->load->view('employees/employee_edit');
                                    ?>
                                    <!--Edit Modal End-->

                                    <div id="EmployeeDocument" class="tab-pane fade full-box"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2 class="element-header"><?php
                                                    if ($employee_info) {
                                                        echo $employee_info[0]['fullname'];
                                                    }
                                                    ?></h2>
                                                <button data-toggle="modal" data-target="#add_employee_documents" class="btn btn-primary btn-rounded right" type="button"><?= lang('add_document') ?></button>
                                            </div>
                                        </div>

                                        <!--Add Supplier Document Modal Start-->
                                        <div id="add_employee_documents" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="element-header margin-0"><?= lang('employee_document') ?> <span class="close" data-dismiss="modal">&times;</span></h6>
                                                    </div>
                                                    <?php echo form_open_multipart('', array('id' => 'enter_employee_documents', 'class' => 'cmxform')); ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id_user" name="id_user" value="<?php echo $employee_info[0]['id_user']; ?>">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><?= lang('name') ?><span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="document_name" class="form-control" id="document_name">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><?= lang('description') ?></label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" rows="3" name="document_description" id="document_description"></textarea>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><?= lang('select_file') ?><span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="file" name="document_file" id="document_file">
                                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <input class="btn btn-primary" type="submit" value="<?= lang('submit') ?>"> </button>

                                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
                                                    </div>
                                                    <input type="hidden" id="total_num_of_fields" name="total_num_of_fields" value="1">
                                                    <?php echo form_close(); ?>
                                                </div>


                                            </div>
                                        </div>
                                        <!--Add Customer Address Modal End-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive" id="documentList">
                                                    <?php $this->load->view('employees/employee_document_pagination');?>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Edit Modal Start-->
                                        <div id="edit_employee_document_modal" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="element-header"><?= lang('edit_employee_document') ?> <span class="close" data-dismiss="modal">&times;</span></h6>
                                                    </div>
                                                    <?php echo form_open_multipart('', array('id' => 'edit_employee_document', 'class' => 'cmxform')); ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="edit_employee_document_id" id="edit_employee_document_id">
                                                        <input type="hidden" name="version" id="edit_document_version">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><?= lang('name') ?><span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="document_name" class="form-control" id="edit_document_name">
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><?= lang('description') ?></label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" rows="3" name="document_description" id="edit_document_description"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><?= lang('select_file') ?></label>
                                                            <div class="col-sm-8">
                                                                <input type="file" name="edit_document_file" id="edit_document_file">
                                                                <input type="hidden" name="old_employee_doc" id="old_employee_doc">
                                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
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

                                        <!--Delete Alert Start-->
                                        <div class="modal fade" id="deleteEmployeeDocumentModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                        <h4 class="modal-title custom_align" id="Heading"><?= lang('delect_this_entry') ?></h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('confirm_delete') ?></div>

                                                    </div>
                                                    <div class="modal-footer ">
                                                        <input type="hidden" id="employee_document_delete_id">
                                                        <button type="button" class="btn btn-success" onclick="delete_employee_document();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang('yes') ?></button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang('no') ?></button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!--Delete Alert End-->
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







<script type="text/javascript">

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
</script>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script>
    function searchFilterDocument(page_num) {
        page_num = page_num ? page_num : 0;
        var id_user_search = $('#id_user').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>employees/employee_document_pagination/',
            data: 'page=' + page_num + '&user_id=' + id_user_search,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                console.log(html);
                $('#documentList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    function showAccess(elem) {
        elem.checked && elem.value === "Yes" ? $("#add_access").show() : $("#add_access").hide();
    }
    function showParmit(elem) {

        (elem.checked && elem.id === "Admin" || elem.id === "Investor") ? $("#parmition_tab").hide() : $("#parmition_tab").show();
    }


    function editEmployDocument(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>employees/edit_employee_doc_by_id',
            data: {id: id},
            type: 'post',
            success: function (result) {
                if (result) {
                    var data = JSON.parse(result);
                    $('#edit_employee_document_id').val(data.id_document);
                    $('#edit_document_name').val(data.name);
                    $('#edit_document_description').val(data.description);
                    $('#old_employee_doc').val(data.file);
                    $('#edit_document_version').val(data.version);



                    return false;
                } else {
                    return false;
                }
            }
        });
    }
    function editEmployee(id)
    {
        $.ajax({
            url: "<?php echo base_url() ?>employee/edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
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

                $('#emp_blood_group').val(data.blood_group).change();
                $('#emp_store_name').val(data.store_id).change();
                data.user_type_id == 1 ? $("#emp_parmition_tab").show() : $("#emp_parmition_tab").hide();
                $('#type-' + data.user_type_id + ':not(:checked)').attr('disabled', true);
                $('#edit_addr_line').val(data.addr_line_1);
                setTimeout(function () {
                    $('#emp_category').val(data.station_id).change();
                }, 1000);
                if (division_id != 0) {
                    $('[id="city_division1"]').val('divi-' + division_id).change();
                    setTimeout(function () {
                        $('[id="edit_address_location"]').val('dist-' + district_id).change();
                    }, 1000);
                }
                if (city_id != 0) {
                    $('[id="city_division1"]').val('city-' + city_id).change();
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
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
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

    function deleteEmployeeModal(id) {
        $('#employee_address_delete_id').val(id);
    }

    function deleteEmployeeDocModal(id) {
        $('#employee_document_delete_id').val(id);
    }


    function delete_employee_document() {
        var id = $('#employee_document_delete_id').val();
        $.ajax({
            url: '<?php echo base_url(); ?>delete_employee_doc',
            data: {id: id},
            type: 'post',
            success: function (data)
            {
                $('#deleteEmployeeDocumentModal').modal('toggle');
                $('#showMessage').html('Employee document deleted successfully');
                $('#showMessage').show();
                window.onload = searchFilterDocument(0);
                setTimeout(function () {
                    $('#showMessage').fadeOut(300);

                }, 1000);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
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
            //console.log(form.id);
            var id = form.id;
            if (id === "employeeFormEdit") {
                var currentForm = $('#employeeFormEdit')[0];
                var formData = new FormData(currentForm);
                $.ajax({
                    url: "<?= base_url() ?>edit_employee_data",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        var result = $.parseJSON(response);
                        console.log(result.message);
                        if (result.status !== 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#edit_employee').modal('hide');
                            $('#employeeFormEdit')[0].reset();
                            $("#emp_category").val("0").change();
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);
                                var id_user = $('#id_user').val();
                                window.location.href = '<?php echo base_url(); ?>employee/' + id_user;
                            }, 1000);
                        }
                    }
                });
            }


            if (id == "enter_employee_documents") {
                var currentForm = $('#enter_employee_documents')[0];
                var formData = new FormData(currentForm);
                formData.append('file', document.getElementById("document_file").files[0]);
                $.ajax({
                    url: "<?= base_url() ?>employees/add/add_employee_document",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        var result = $.parseJSON(response);
                        //var result = response;
                        if (result.status != 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#add_employee_documents').modal('toggle');
                            $('#enter_employee_documents').trigger("reset");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilterDocument(0);
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);

                            }, 1000);
                        }
                    }
                });
            }

            if (id == "edit_employee_document") {
                var currentForm = $('#edit_employee_document')[0];
                var formData = new FormData(currentForm);
                formData.append('file', document.getElementById("edit_document_file").files[0]);
                $.ajax({
                    url: "<?= base_url() ?>employees/update_employee_document",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        var result = $.parseJSON(response);
                        if (result.status != 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#edit_employee_document_modal').modal('toggle');
                            $('#edit_employee_documents').trigger("reset");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilterDocument(0);
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);

                            }, 1000);
                        }
                    }
                });
            }



        }
    });

</script>

