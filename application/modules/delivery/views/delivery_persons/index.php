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
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("delivery-persons-name"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="src_person_name" name="product_name" placeholder="<?= lang("delivery-persons-name"); ?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("person-type"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <select class="form-control" data-live-search="true" id="src_type_id" name="cat_name">
                                                  <option value="0"><?= lang("select_one"); ?></option>
                                                  <option value="1" id="b"> Staff</option>
                                                  <option value="2" id="a"> Agent</option>
                                                  
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i class="fa fa-search"></i> <?= lang("search"); ?></button>
                            </div>
                            </form> 
                        </div>
                    </div>    

                    <!---Add Modal BOX--->

                    <div id="add" class="modal fade" role="dialog">
                        <div class="modal-dialog  modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <?php echo form_open_multipart('', array('id' => 'DeliveryPerson', 'class' => 'cmxform')); ?>
                                <div class="modal-header">
                                    <h6 class="element-header margin-0"><span id="layout_title"><?= lang("add-person"); ?> </span> <span class="close" data-dismiss="modal">&times;</span></h6>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="id" value="">
                                    <div class="row">    
                                         <div class="col-md-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"><?= lang("person-type"); ?> <span class="req">*</span></label>
                                                <div class="col-sm-12">

                                                    <div class="row-fluid">
                                                        <select class="form-control" name="type_id" id="person_type" data-live-search="true" onChange="getdeliveryPerson(this.value)">
                                                            <option value="0"><?= lang("select_one"); ?></option>
                                                            <option value="1" id="a"> Staff</option>
                                                            <option value="2" id="b">Agent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <span id="type_id-error" class="error"></span>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12" id="staff_type" style="display: none;">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"><?= lang("delivery-persons-name"); ?> </label>
                                                <div class="col-sm-12">

                                                    <div class="row-fluid">
                                                        <select class="form-control" name="ref_id" id="staff" onChange="Staff_phone(this.value)">
                                                            <option value="0"  selected><?= lang("select_one"); ?>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <span id="staff-error" class="error"></span>
                                        </div>
                                        <div class="col-md-6 col-sm-12" id="agent_list" style="display: none;">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"><?= lang("agent-select"); ?> </label>
                                                <div class="col-sm-12">

                                                    <div class="row-fluid">
                                                        <select class="form-control" name="ref_id1" id="agent">
                                                            <option value="0"  selected><?= lang("select_one"); ?>
                                                                 <?php
                                                                 if (!empty($agents)) {
                                                           foreach ($agents as $agent) {
                                                        echo '<option value="' . $agent->id_agent . '">' . $agent->agent_name . '</option>';
                                                    }
                                                }
                                                ?>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <span id="staff-error" class="error"></span>
                                        </div>
                                        <div class="col-md-6 col-sm-12" style="display: none;" id="agent_type">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("delivery-persons-name"); ?><span class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="person_name" id="person_name">
                                                </div>
                                            </div>
                                             <span id="person_name-error" class="error"></span>
                                        </div>
                                         <span id="person_name-error" class="error"></span>
                                        <div class="col-md-6 col-sm-12" style="display: none;" id="PersonMobileAgent">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("contact-person-mobile"); ?><span class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="person_number1" id="person_number1">
                                                </div>
                                            </div>
                                             <span id="person_number1-error" class="error"></span>
                                        </div>
                                        <div class="col-md-6 col-sm-12" style="display: none;" id="PersonMobileStaff">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("contact-person-mobile"); ?><span class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="person_number" id="person_number" readonly="yes">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span id="person_number-error" class="error"></span>
                                </div>    
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>

                        </div>
                    </div>
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">

                                <button data-toggle="modal" data-target="#add" class="btn btn-primary bottom-10 right" type="button" onclick="addPersons()"><?= lang("add-person"); ?></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php
                                    $this->load->view('delivery_persons/all_product_data', $posts, false);
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="modal fade" id="deletePersons" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                        <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_this_entry"); ?></h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?= lang("confirm_delete"); ?></div>

                                    </div>
                                    <div class="modal-footer ">
                                        <input type="hidden" id="product_delete_id">
                                        <button type="button" class="btn btn-success" onclick="delete_person();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span><?= lang("no"); ?> </button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script>

                                            function addPersons() {

                                                $('#DeliveryPerson')[0].reset();
                                                // $("#DeliveryPerson").get(0).reset();
                                                // $('input:checkbox').removeAttr('checked');
                                                // $('#person_type')[0].reset();
                                                $('#person_type').prop('selectedIndex',0);
                                                // $('#person_type').find('option:first').attr('selected', 'selected');
                                                $("#id").val("");
                                                $("#person_type").val(0).change();
                                                $('#layout_title').text('<?= lang("add-person"); ?>');
                                            }
                                            function getdeliveryPerson(value) {
                                                // alert(value);
                                                 if(value == 0){
                                                    $( "#staff_type" ).show( "slow", function() {
                                                    document.getElementById('staff_type').style.display = "none";
                                                    document.getElementById('PersonMobileStaff').style.display = "none";
                                                     document.getElementById('agent_type').style.display = "none";
                                                      });
                                                     document.getElementById('PersonMobileAgent').style.display = "none";
                                                     document.getElementById('agent_list').style.display = "none";
                                                 }
                                                 if(value == 1){
                                                    $( "#staff_type" ).show( "slow", function() {
                                                    document.getElementById('staff_type').style.display = "block";
                                                    document.getElementById('PersonMobileStaff').style.display = "block";
                                                     document.getElementById('agent_type').style.display = "none";
                                                      });
                                                     document.getElementById('PersonMobileAgent').style.display = "none";
                                                     document.getElementById('agent_list').style.display = "none";
                                                 }
                                                if(value == 2){
                                                        $( "#agent_type" ).show( "slow", function() {
                                                // alert( "Animation complete." );
                                             
                                                     document.getElementById('staff_type').style.display = "none";
                                                     document.getElementById('agent_list').style.display = "block";
                                                     document.getElementById('agent_type').style.display = "block";
                                                     document.getElementById('PersonMobileAgent').style.display = "block";
                                                     document.getElementById('PersonMobileStaff').style.display = "none";
                                                      });
                                                 }
                                            

                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url(); ?>delivery/delivery_persons/getStaff',
                                                    data: 'id=' + value,
                                                    success: function (result) {
                                                        var html = '';
                                                        var data = JSON.parse(result);
                                                        if (result) {
                                                            var length = data.length;
                                                            html = "<option value = '0'><?= lang("select_one"); ?></option>";
                                                            for (var i = 0; i < length; i++) {
                                                                var val = data[i].id_user;
                                                                var name = data[i].fullname;
                                                                html += "<option value = '" + val + "'>" + name + "</option>";
                                                            }
                                                        }
                                                        //alert(html);
                                                        $("#staff").html(html);
                                                        //$('#postList').html(html);

                                                    }
                                                });
                                            }
                                         

                                            function searchFilter(page_num) {
                                                page_num = page_num ? page_num : 0;
                                                var src_person_name = $('#src_person_name').val();
                                                var src_type_id = $('#src_type_id').val();
                                                // alert(src_type_id);
                                                // alert(src_person_name);
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url(); ?>delivery_persons/page_data/' + page_num,
                                                    data: 'page=' + page_num + '&src_person_name=' + src_person_name + '&src_type_id=' + src_type_id,
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
                                           
                                            function editPersons(id)
                                            {

                                                $.ajax({
                                                    url: "<?php echo base_url() ?>delivery_persons/edit/" + id,
                                                    type: "GET",
                                                    dataType: "JSON",
                                                    success: function (dataValue)
                                                    {
                                                        console.log(dataValue);
                                                        // var result = JSON.parse(dataValue);
                                                        var result = dataValue;
                                                        $('#layout_title').text('Edit Persons');
                                                        $('[name="id"]').val(result.data.id_delivery_person);
                                                        $('#person_name').val(result.data.person_name);
                                                        $('#person_number1').val(result.data.person_mobile);
                                                        $("#person_type").val(result.data.type_id).change();
                                                        
                                                        $("[name='vatType'][value=" + result.data.is_vatable + "]").prop("checked", true);
                                                        setTimeout(function () {
                                                        $('[name="ref_id"]').val(result.data.ref_id).change();
                                                        $('[name="ref_id1"]').val(result.data.ref_id).change();
                                                                        }, 400);


                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {
                                                        alert('Error get data from ajax');
                                                    }
                                                });
                                            }
                                            function deletePersonModal(id) {
                                                // alert(id);
                                                $('#deletePersons').val(id);
                                            }
                                            function delete_person()
                                            {
                                                var id = $('#deletePersons').val();
                                                // alert(id);
                                                $.ajax({
                                                    url: "<?php echo base_url() . 'delivery_persons/delete' ?>/" + id,
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    beforeSend: function () {
                                                        $('.loading').show();
                                                    },
                                                    success: function (data)
                                                    {
                                                        $('.loading').fadeOut("slow");
                                                        $('#showMessage').html('<?= lang("delete_success"); ?>');
                                                        $('#deletePersons').modal('toggle');
                                                        window.onload = searchFilter(0);
                                                        $('#showMessage').show();
                                                        setTimeout(function () {
                                                            $('#showMessage').fadeOut(300);

                                                        }, 3000);
                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {
                                                        alert('Error deleting data');
                                                    }
                                                });
                                            }
                                            $.validator.setDefaults({
                                                submitHandler: function (form) {
                                                    var type = $('#person_type').val();
                                                    var name = $('#person_name').val();
                                                    var ref=  $('#person_name').val();
                                                    var number = $('#person_number').val();
                                                    var number1 = $('#person_number1').val();
                                                    // alert(ref);
                                                    //var value = $(form).serialize();
                                                    var currentForm = $('#DeliveryPerson')[0];
                                                    var formData = new FormData(currentForm);
                                                     $err_count = 1;
                                                     $('#type_id-error').html("");
                                                     $('#person_name-error').html("");
                                                     $('#staff-error').html("");
                                                     $('#tperson_number-error').html("");
                                                     $('#tperson_number-error').html("");
                                                    if (type == 0) {
                                                         $err_count=2;
                                                         $('#type_id-error').html("Please Select Person Type");
                                                    }
                                                    if (type == 2 && name=='') {
                                                         $err_count=2;
                                                         $('#person_name-error').html("Please Fill Person Name");
                                                    }
                                                     if (type == 2 && number1=='') {
                                                         $err_count=2;
                                                         $('#person_number1-error').html("Please Fill Person contact Number");
                                                    }
                                                    if (type == 1 && number=='') {
                                                         $err_count=2;
                                                         $('#person_number1-error').html("Please Fill Person contact Number");
                                                    }

                                                    if ($err_count == 1)  {         
                                                    $.ajax({
                                                        url: "<?= base_url() ?>delivery/delivery_persons/add_data",
                                                        type: 'POST',
                                                        data: formData,
                                                        processData: false,
                                                        contentType: false,
                                                        beforeSend: function () {
                                                            $('.loading').show();
                                                        },
                                                        success: function (response) {
                                                            // $('.loading').fadeOut("slow");
                                                            var result = $.parseJSON(response);
                                                            if (result.status != 'success') {
                                                                $.each(result, function (key, value) {
                                                                    $('[name="' + key + '"]').addClass("error");
                                                                    $('[name="' + key + '"]').after(' <label class="error">' + value + '</label>');
                                                                });
                                                            } else {
                                                                $('#DeliveryPerson')[0].reset();
                                                                $('#add').modal('hide');
                                                                $('#showMessage').html(result.message);
                                                                window.onload = searchFilter(0);
                                                                // $('#pro_name').attr('name', 'pro_name');
                                                                setTimeout(function () {
                                                                    $('#showMessage').fadeOut(300);

                                                                }, 3000);
                                                            }
                                                            $('#showMessage').show();
                                                        }
                                                    });
                                                }    
                                                }
                                            });

                                            $(document).ready(function(){
                                                $("#a").click(function(){
                                                    $("#agent_type").hide();
                                                });
                                                $("#b").click(function(){
                                                    $("#staff_type").show();
                                                });
                                            });


                                        function Staff_phone(value) {
                                            // var id = $('#staff').val();
                                            // alert(value);
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url(); ?>delivery/delivery_persons/getStaffPhone',
                                                data: 'id=' + value,
                                                success: function (result) {
                                                    console.log(result);
                                                    var html = '';
                                                    var data = JSON.parse(result);
                                                    if (result) {
                                                        var length = data.length;
                                                        html = "";
                                                        for (var i = 0; i < length; i++) {
                                                            var phone = data[i].mobile;
                                                        
                                                        }
                                                    }
                                               
                                                    $('#person_number').val(phone);
                                                    //$('#postList').html(html);

                                                }
                                            });
                                        }    
</script> 
