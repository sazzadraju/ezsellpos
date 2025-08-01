<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
    <li class="breadcrumb-item"><a href="index.html">Products</a></li>
    <li class="breadcrumb-item"><span>Laptop with retina screen</span></li>
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
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="element-header"><?php if($customer_info){ echo $customer_info[0]['full_name'];}?></h2>
                                <button data-toggle="modal" data-target="#add_customer_address" class="btn btn-primary btn-rounded right" type="button"><i class="fa fa-plus"></i> Add Address</button>
                            </div>
                        </div>
                        <!---Add Modal BOX-->

                        <div id="add_customer_address" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="element-header margin-0">Customer Address <span class="close" data-dismiss="modal">&times;</span></h6>
                                    </div>
                                    <?php echo form_open_multipart('', array('id' => 'enter_customer_address', 'class' => 'cmxform')); ?>
                                    <div class="modal-body">
                                        <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_info[0]['id_customer'];?>">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Address Type<span class="req">*</span></label>
                                            <div class="col-sm-8">
                                                <div class="row-fluid">
                                                    <select class="select2" id="address_type" name="address_type">
                                                        <option value="0">Select One</option>
                                                        <option value="Present Address">Present Address</option>
                                                        <option value="Permanent Address">Permanent Address</option>
                                                        <option value="Shipping Address">Shipping Address</option>
                                                        <option value="Billing Address">Billing Address</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">City / Division<span class="req">*</span></label>
                                            <div class="col-sm-8">
                                                <div class="row-fluid">
                                                    <select class="select2" data-live-search="true" id="city_division" name="city_division" onchange="locationAddress(value);">
                                                        <option value="0" selected>Select One</option>
                                                        <optgroup label="City Wise">
                                                            <?php
                                                            if($city_list){
                                                                foreach ($city_list as $list) {
                                                            ?>
                                                                    <option value="city-<?php echo $list['id_city'];?>"><?php echo $list['city_name_en'];?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            
                                                        </optgroup>
                                                        <optgroup label="Division Wise">
                                                            <?php
                                                            if($division_list){
                                                                foreach ($division_list as $list) {
                                                            ?>
                                                                    <option value="divi-<?php echo $list['id_division'];?>"><?php echo $list['division_name_en'];?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="division_id" id="division_id">
                                        <input type="hidden" name="district_id" id="district_id">

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Location<span class="req">*</span></label>
                                            <div class="col-sm-8">
                                                <div class="row-fluid">
                                                    <select class="select2" id="address_location" name="address_location" onchange="cityDistLoc(value);">
                                                        <option value="0">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="city_id" id="city_id">
                                        <input type="hidden" name="city_location_id" id="city_location_id">

                                        <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Address<span class="req">*</span></label>
                                                <div class="col-sm-8">
                                                    locationAddress</div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <input class="btn btn-primary" type="submit" value="Submit"> </button>

                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                            <th>Serial</th>
                                            <th>Address Type</th>
                                            <th>Division</th>
                                            <th>District</th>
                                            <th>City</th>
                                            <th>Area</th>
                                            <th>Upazila</th>
                                            <th>Union</th>
                                            <th>Address</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i = 1;
                                            if(!empty($customer_address_list)){
                                                foreach ($customer_address_list as $list) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $list['address_type'];?></td>
                                                <td><?php echo $list['division_name_en'];?></td>
                                                <td><?php echo $list['district_name_en'];?></td>
                                                <td><?php echo $list['city_name_en'];?></td>
                                                <td><?php echo $list['area_name_en'];?></td>
                                                <td><?php echo $list['upazila_name_en'];?></td>
                                                <td><?php echo $list['union_name_en'];?></td>
                                                <td><?php echo $list['addr_line_1'];?></td>
                                                <td class="center">
                                                    <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit_customer_address_section" onclick="editCustomerAddress('<?php echo $list['id_customer_address'];?>')"><span class="glyphicon glyphicon-pencil"></span></button>

                                                </td>
                                                <td class="center">
                                                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#deleteCustomerAddress" onclick="deleteCustomerModal('<?php echo $list['id_customer_address'];?>');"><span class="glyphicon glyphicon-trash"></span></button>

                                                </td>
                                                
                                            </tr>

                                            <?php 
                                            $i++;
                                                }
                                            }
                                        ?>        
                                        </tbody>

                                    </table>

                                    <div class="clearfix"></div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<!--Edit Modal Start-->
<div id="edit_customer_address_section" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header">Edit Customer Address <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <?php echo form_open_multipart('', array('id' => 'edit_customer_address', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                    <input type="hidden" name="edit_id_customer_address" id="edit_id_customer_address">
                    <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Address Type<span class="req">*</span></label>
                    <div class="col-sm-8">
                        <div class="row-fluid">
                            <select class="select2" id="address_type" name="edit_address_type">
                                <option value="0">Select One</option>
                                <option value="Present Address">Present Address</option>
                                <option value="Permanent Address">Permanent Address</option>
                                <option value="Shipping Address">Shipping Address</option>
                                <option value="Billing Address">Billing Address</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">City / Division<span class="req">*</span></label>
                    <div class="col-sm-8">
                        <div class="row-fluid">
                            <select class="select2" data-live-search="true" id="city_division" name="city_division" onchange="editLocationAddress(value);">
                                <option value="0" selected>Select One</option>
                                <optgroup label="City Wise" name="edit_city" id="edit_city">
                                    <?php
                                    if($city_list){
                                        foreach ($city_list as $list) {
                                    ?>
                                            <option class="edit_city" value="city-<?php echo $list['id_city'];?>"><?php echo $list['city_name_en'];?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    
                                </optgroup>
                                <optgroup label="Division Wise">
                                    <?php
                                    if($division_list){
                                        foreach ($division_list as $list) {
                                    ?>
                                            <option class="edit_division" value="divi-<?php echo $list['id_division'];?>"><?php echo $list['division_name_en'];?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="division_id" id="edit_division_id">
                <input type="hidden" name="district_id" id="edit_district_id">

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Location<span class="req">*</span></label>
                    <div class="col-sm-8">
                        <div class="row-fluid">
                            <select class="select2" id="edit_address_location" name="address_location" onchange="editCityDistLoc(value);">
                                <option value="0">Select One</option>
                            </select>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="city_id" id="edit_city_id">
                <input type="hidden" name="city_location_id" id="edit_city_location_id">

                <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Address<span class="req">*</span></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="3" name="edit_addr_line_1" value="addr_line_1"></textarea>
                        </div>
                </div>

                <div class="form-buttons-w">
                    <button class="btn btn-primary" type="submit"> Submit</button>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <input class="btn btn-primary" type="submit" value="Submit"> </button> -->
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>
<!--Edit Modal End-->


<!--Delete Alert Start-->
<div class="modal fade" id="deleteCustomerAddress" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>

            </div>
            <div class="modal-footer ">
                <input type="hidden" id="customer_address_delete_id">
                <button type="button" class="btn btn-success" onclick="delete_customer_address();"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Delete Alert End-->
<script type="text/javascript">
   

    function locationAddress(value){
        var cat = value.substring(0,4);
        var id = value.substring(5);

       // $('#select2-location-container').html("");
        if(cat == "divi"){
            var html = "<option value='0'>Select District</option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>customer_settings/customer/get_district',
                data: {id: id},
                success: function (result) {
                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for(var i = 0; i < length; i++){
                            var val = data[i].id_district;
                            var district = data[i].district_name_en;
                            html += "<option value = '"+'dist-'+val+"'>"+district+"</option>";
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
        }else if(cat == "city"){
            var html = "<option value='0'>Select Location</option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>customer_settings/customer/get_city_location',
                data: {id: id},
                success: function (result) {
                    
                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for(var i = 0; i < length; i++){
                            var val = data[i].id_area;
                            var location = data[i].area_name_en;
                            html += "<option value = '"+'city-'+val+"'>"+location+"</option>";
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

    function editLocationAddress(value){
        var cat = value.substring(0,4);
        var id = value.substring(5);

       // $('#select2-location-container').html("");
        if(cat == "divi"){
            var html = "<option value='0'>Select District</option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>customer_settings/customer/get_district',
                data: {id: id},
                success: function (result) {
                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for(var i = 0; i < length; i++){
                            var val = data[i].id_district;
                            var district = data[i].district_name_en;
                            html += "<option value = '"+'dist-'+val+"'>"+district+"</option>";
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
        }else if(cat == "city"){
            var html = "<option value='0'>Select Location</option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>customer_settings/customer/get_city_location',
                data: {id: id},
                success: function (result) {
                    
                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for(var i = 0; i < length; i++){
                            var val = data[i].id_area;
                            var location = data[i].area_name_en;
                            html += "<option value = '"+'city-'+val+"'>"+location+"</option>";
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

    function cityDistLoc(value){
        var cat = value.substring(0,4);
        var id = value.substring(5);

        if(cat == "city"){
            $('#city_location_id').val(id);
        }else if(cat == "dist"){
            $('#district_id').val(id);
        }
    }

    function editCityDistLoc(value){
        var cat = value.substring(0,4);
        var id = value.substring(5);

        if(cat == "city"){
            $('#edit_city_location_id').val(id);
        }else if(cat == "dist"){
            $('#edit_district_id').val(id);
        }
    }
</script>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script>
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer_settings/customer/customer_address_list/',
            data: 'page=' + page_num,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

    function page_load(customer_id) {
        customer_id = customer_id ? customer_id : 0;
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer_settings/customer/customer_address_list/'+customer_id,
            //data: 'page_id=' + customer_id,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

    function edit_customer_type(id)
    {
        save_method = 'update';
        $('#customer_type')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo base_url() ?>customer_settings/customer/edit_customer_type/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                $('#name').val(data.name);
                $('#discount').val(data.discount);
                $('#target_sales_volume').val(data.target_sales_volume);
                $('#id').val(data.id_customer_type);
                    
                $('#layout_title').text('Edit Customer Type');
                $('[type="submit"]').text('Update');
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


    function editCustomerAddress(id){
        $.ajax({ 
          url: '<?php echo base_url();?>customer_settings/customer/edit_customer_address',
          data: {id: id},
          type: 'post',
          success: function(result) {
                if (result) {
                    var data = JSON.parse(result);
                    // console.log(data);
                    var division_id = data.result[0].div_id;
                    var district_id = data.result[0].dist_id;
                    var city_id = data.result[0].city_id;
                    var area_id = data.result[0].area_id;
                    $('[name="edit_id_customer_address"]').val(data.result[0].id_customer_address);
                    $('[name="edit_address_type"]').val(data.result[0].address_type).change();

                    if(division_id){
                        $('[name="city_division"]').val('divi-'+division_id).change();
                        $('[id="edit_address_location"]').val(district_id).change();
                    }

                    if(city_id){
                        $('[name="city_division"]').val('city-'+city_id).change();
                        $('[id="edit_address_location"]').val(area_id).change();
                    }
                    $('[name="edit_addr_line_1"]').val(data.result[0].addr_line_1);

                    // var html ="<option value='0'>Select One</option>";
                    // var selected = "";
                    // if(data.area == 'city'){
                    //     for(var i=0; i<data.location_result.length; i++){
                    //         if(area_id == data.location_result[i].id_area){
                    //             selected = "selected";
                    //         }
                    //         console.log('area '+selected);
                    //         html += "<option "+selected+" value='"+data.location_result[i].id_area+"'>"+data.location_result[i].area_name_en+"</option>";
                    //     }
                    // }

                    // if(data.area == 'division'){
                    //     if(district_id == data.location_result[i].id_district){
                    //         selected = "selected";
                    //     }
                    //     console.log('district '+selected);
                    //     for(var i=0; i<data.location_result.length; i++){
                    //         html += "<option "+selected+" value='"+data.location_result[i].id_district+"'>"+data.location_result[i].division_name_en+"</option>";
                    //     }
                    // }

                    // $('#edit_address_location').html(html);
                    return false;
                } else {
                    return false;
                }
            }
        });
    }

    function deleteCustomerModal(id){
        console.log(id);
        $('#customer_address_delete_id').val(id);
    }

    function delete_customer_address(){
        var id = $('#customer_address_delete_id').val();
        var customer_id = $('#customer_id').val();
        console.log(customer_id);
        $.ajax({
                url: '<?php echo base_url();?>customer_settings/customer/delete_customer_address',
                data: {id: id},
                type: 'post',
                success: function (data)
                {
                    $('#deleteCustomerAddress').modal('toggle');
                    $('#showMessage').html('Customer address deleted successfully');
                    $('#showMessage').show();
                    window.onload = page_load(customer_id);
                    setTimeout(function() {
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

            var customer_address_id = $('#edit_id_customer_address').val();
            
            //customer data insert
            if(customer_address_id != ""){
                var currentForm = $('#edit_customer_address')[0];
                var formData = new FormData(currentForm);
                
                $.ajax({
                    url: "<?= base_url() ?>customer_settings/customer/update_customer_address",
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
                            $('#edit_customer_address').modal('toggle');
                            //$('#customer_type')[0].reset();
                            $('#edit_customer_info').trigger("reset");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilter(0);
                            setTimeout(function() {
                                $('#showMessage').fadeOut(300);
                                
                            }, 3000);
                        }
                        
                    }
                });
            }else{
                var currentForm = $('#enter_customer_address')[0];
                var formData = new FormData(currentForm);
                
                $.ajax({
                    url: "<?= base_url() ?>customer_settings/customer/create_customer_address",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        var result = $.parseJSON(response);
                        var customer_id = result.customer_id;
                        if (result.status != 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#add_customer_address').modal('toggle');
                            //$('#customer_type')[0].reset();
                            $('#customer_info').trigger("reset");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = page_load(customer_id);
                            setTimeout(function() {
                                $('#showMessage').fadeOut(300);
                                
                            }, 3000);
                        }
                    }
                });
            }
            

        }
    });

</script>