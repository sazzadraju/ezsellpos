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

                    <div class="full-box element-box">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="tab-menu">
                                    <li class="active">
                                        <a href="#View" data-toggle="tab" class="btn btn-primary"><?= lang('details')?></a>
                                    </li>

                                    <li>
                                        <a href="#SupplierDocument" data-toggle="tab" class="btn btn-primary"><?= lang('documents')?></a>
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
                                        <input type="hidden" name="id_supplier" id="id_supplier" value="<?php echo $supplier_info[0]['id_supplier'];?>">
                                        <div class="info-1">
                                            <div class="receive-payment">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="rcv-pmnt"><strong><?= lang('supplier_code')?>:</strong> <?php echo $supplier_info[0]['supplier_code'];?></div>
                                                    <div class="rcv-pmnt"><strong><?= lang('supplier_name')?>:</strong> <?php echo $supplier_info[0]['supplier_name'];?></div>
                                                    <div class="rcv-pmnt"><strong><?= lang('contact_person')?>:</strong> <?php echo $supplier_info[0]['contact_person'];?></div>
                                                    <div class="rcv-pmnt"><strong><?= lang('email')?>:</strong> <?php echo $supplier_info[0]['email'];?></div>
                                                    <div class="rcv-pmnt"><strong><?= lang('phone')?>:</strong> <?php echo $supplier_info[0]['phone'];?></div>
                                                    <div class="rcv-pmnt"><strong>Address:</strong> <?php echo $supplier_info[0]['addr_line_1'];?></div>
                                                    <div class="rcv-pmnt"><strong><?= lang('vat_reg_no') ?>:</strong> <?php echo $supplier_info[0]['vat_reg_no'];?></div>
                                                    <div class="rcv-pmnt"><strong><?= lang('stores') ?>:</strong> <?php echo $supplier_info[0]['stores'];?></div>
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <div class="customer-logo">
                                                        <?php
                                                        if(!empty($supplier_info[0]['profile_img'])){
                                                            echo '<img src="'.documentLink('supplier'). $supplier_info[0]["profile_img"].'" width="100%" alt="" style="float: left;">';
                                                    }
                                                        ?>

                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-12">
                                                    <button class="btn btn-primary btn-xs right" rel="tooltip" title="<?= lang("edit")?>" data-title="Edit" data-toggle="modal" data-target="#editSupplierInfo" onclick="editSupplier('<?php echo $supplier_info[0]['id_supplier'];?>')"><span class="glyphicon glyphicon-pencil"></span></button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <!--Edit Modal Start-->
                                    <?php $this->load->view('supplier_settings/supplier_edit');?>
                                    <!--Edit Modal End-->

                                    <div id="SupplierDocument" class="tab-pane fade full-box"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2 class="element-header"><?php if($supplier_info){ echo $supplier_info[0]['supplier_name'];}?></h2>
                                                <button data-toggle="modal" data-target="#add_supplier_documents" class="btn btn-primary btn-rounded right" type="button"><?= lang('add_document')?></button>
                                            </div>
                                        </div>

                                        <!--Add Supplier Document Modal Start-->
                                        <div id="add_supplier_documents" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="element-header margin-0"><?= lang('supplier_document')?> <span class="close" data-dismiss="modal">&times;</span></h6>
                                                    </div>
                                                    <?php echo form_open_multipart('', array('id' => 'enter_supplier_documents', 'class' => 'cmxform')); ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" id="supplier_id" name="supplier_id" value="<?php echo $supplier_info[0]['id_supplier'];?>">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><?= lang('file_name')?><span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="document_name" class="form-control" id="document_name">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><?= lang('description')?></label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" rows="3" name="document_description" id="document_description"></textarea>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><?= lang('select_file')?><span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="file" name="document_file" id="document_file">
                                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <input class="btn btn-primary" type="submit" value="<?= lang('submit')?>"> </button>

                                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close')?></button>
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
                                                    <table id="mytable" class="table table-bordred table-striped">
                                                        <thead>
                                                            <th><?= lang('serial')?></th>
                                                            <th><?= lang('name')?></th>
                                                            <th><?= lang('description')?></th>
                                                            <th><?= lang('file')?></th>
                                                            <th class="center"><?= lang('action')?></th>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            $i = 1;
                                                            if(!empty($supplier_document_list)){
                                                                foreach ($supplier_document_list as $list) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i;?></td>
                                                                <td><?php echo $list['name'];?></td>
                                                                <td><?php echo $list['description'];?></td>
                                                                <td>
                                                                    <?php
                                                                    $name = $list['file'];
                                                                    $fileExt = strrchr($name, ".");
                                                                    $output = '';
                                                                    if ($fileExt == '.jpg' || $fileExt == '.png' || $fileExt == '.jpeg' || $fileExt == '.gif') {
                                                                        $output = '<a href="#" onclick="show_image(' . $list['id_document'] . ')"><i class="fa fa-picture-o" aria-hidden="true"></i></a>';
                                                                        $output .= '<div id="img_' . $list['id_document'] . '" style="display: none;"><img src="' . documentLink('supplier') . $name . '" style="width:100%"></div>';
                                                                    } else if ($fileExt == '.doc' || $fileExt == '.docx') {
                                                                        $output = '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
                                                                    } else if ($fileExt == '.xlsx' || $fileExt == '.xls'  || $fileExt == '.xlsm' || $fileExt == '.xltx' || $fileExt == '.xltm') {
                                                                        $output = '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
                                                                    } else if ($fileExt == '.pdf' || $fileExt == '.xps') {
                                                                        $output = '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
                                                                    } else {
                                                                        $output = '<i class="fa fa-file" aria-hidden="true"></i>';
                                                                    }
                                                                    echo $output;
                                                                    ?>
                                                                </td>

                                                                <td class="center">
                                                                    <?php
                                                                    if (!empty($list['file'])) {
                                                                        ?>
                                                                        <a href="<?php echo documentLink('supplier') . $list['file']; ?>"  rel="tooltip" title="<?= lang("download")?>" download><button class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i></button></a>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <button class="btn btn-primary btn-xs" data-title="Edit"  rel="tooltip" title="<?= lang("edit")?>" data-toggle="modal" data-target="#edit_supplier_document_modal" onclick="editSupplierDocument('<?php echo $list['id_document'];?>')"><span class="glyphicon glyphicon-pencil"></span></button>
                                                                    <button class="btn btn-danger btn-xs" data-title="Delete"  rel="tooltip" title="<?= lang("delete")?>" data-toggle="modal" data-target="#deleteSupplierDocumentModal" onclick="deleteSupplierDocModal('<?php echo $list['id_document'];?>');"><span class="glyphicon glyphicon-trash"></span></button>

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
                                                    <?php echo $this->ajax_pagination->create_links(); ?>
                                                </div>

                                            </div>
                                        </div>

                                        <!--Edit Modal Start-->
                                    <div id="edit_supplier_document_modal" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="element-header"><?= lang('edit_supplier_document')?> <span class="close" data-dismiss="modal">&times;</span></h6>
                                                </div>
                                                <?php echo form_open_multipart('', array('id' => 'edit_supplier_document', 'class' => 'cmxform')); ?>
                                                <div class="modal-body">
                                                    <input type="hidden" name="edit_supplier_document_id" id="edit_supplier_document_id">
                                                    <input type="hidden" name="version" id="edit_document_version">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label"><?= lang('file_name')?><span class="req">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="edit_document_name" class="form-control" id="edit_document_name">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label"><?= lang('description')?><span class="req">*</span></label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" rows="3" name="edit_document_description" id="edit_document_description"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label"><?= lang('select_file')?><span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <div class="col-sm-12 bottom-10 pad-left-0">
                                                                    
                                                                <img src="" alt="customer document" id="supplier_doc" width="170px" height="100px">
                                                            </div>
                                                           
                                                            <input type="file" name="edit_document_file" id="edit_document_file">
                                                            <input type="hidden" name="old_supplier_doc" id="old_supplier_doc">
                                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
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
                                    <div class="modal fade" id="deleteSupplierDocumentModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
                                                    <input type="hidden" id="supplier_document_delete_id">
                                                    <button type="button" class="btn btn-success" onclick="delete_supplier_document();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang('yes')?></button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang('no')?></button>
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
        $('#DOB').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

    });
    $(function () {
        $('#AD').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

    });

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
        var id_customer_search = $('#id_customer').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer_settings/customer/customer_address_pagination/',
            data: 'page=' + page_num + '&customer_id=' + id_customer_search,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

    function searchFilterDocument(page_num) {
        page_num = page_num ? page_num : 0;
        var id_supplier_search = $('#id_supplier').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>suppliers/supplier_document_pagination/',
            data: 'page=' + page_num + '&supplier_id=' + id_supplier_search,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#documentList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }


    function editSupplierDocument(id){
        $.ajax({ 
          url: '<?php echo base_url();?>edit_supplier_doc',
          data: {id: id},
          type: 'post',
          beforeSend: function () {
                    $('.loading').show();
                },
          success: function(result) {
                if (result) {
                    var data = JSON.parse(result);
                    $('#edit_supplier_document_id').val(data[0].id_document);
                    $('#edit_document_name').val(data[0].name);
                    $('#edit_document_description').val(data[0].description);
                    $('#old_supplier_doc').val(data[0].file);
                    $('#edit_document_version').val(data[0].version);
                    var photo = data[0].file;
                    if(photo){
                        var image_path = "<?php echo documentLink('supplier')?>"+photo;
                        var image = "<img src='"+image_path+"'";
                        $("#supplier_doc").attr("src",image_path);
                    }
                    $('.loading').fadeOut("slow");

                    return false;
                } else {
                    return false;
                }
            }
        });
    }

    function deleteSupplierDocModal(id){
        $('#supplier_document_delete_id').val(id);
    }


    function delete_supplier_document(){
        var id = $('#supplier_document_delete_id').val();
        $.ajax({
                url: '<?php echo base_url();?>delete_supplier_doc',
                data: {id: id},
                type: 'post',
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data)
                {
                    $('#deleteSupplierDocumentModal').modal('toggle');
                    $('#showMessage').html("<?php echo lang('delete_success');?>");
                    $('#showMessage').show();
                    window.onload = searchFilterDocument(0);
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


    function editSupplier(id){
        $.ajax({ 
          url: '<?php echo base_url();?>editSupplierInfo',
          data: {id: id},
          type: 'post',
          beforeSend: function () {
                $('.loading').show();
            },
          success: function(result) {
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
                        var image_path = "<?php echo documentLink('supplier'); ?>" + photo;
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



    $.validator.setDefaults({
        submitHandler: function (form) {
            //console.log(form.id);
            var id = form.id;

            if(id == "edit_supplier_info"){
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
                            setTimeout(function() {
                                $('#showMessage').fadeOut(300);
                                    var id_supplier = $('#id_supplier').val();
                                    window.location.href = '<?php echo base_url();?>supplier/'+id_supplier;
                            }, 3000);
                        }
                        $('.loading').fadeOut("slow");
                    }
                });
            }


            if(id == "enter_supplier_documents"){
                var currentForm = $('#enter_supplier_documents')[0];
                var formData = new FormData(currentForm);
                formData.append('file', document.getElementById("document_file").files[0]);
                $.ajax({
                    url: "<?= base_url() ?>create_supplier_document",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (response) {
                        var result = $.parseJSON(response);
                        var customer_id = result.customer_id;
                        if (result.status != 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#add_supplier_documents').modal('toggle');
                            $('#enter_supplier_documents').trigger("reset");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilterDocument(0);
                            setTimeout(function() {
                                $('#showMessage').fadeOut(300);
                                
                            }, 3000);
                            
                        }
                        $('.loading').fadeOut("slow");
                    }
                });
            }

            if(id == "edit_supplier_document"){
               var currentForm = $('#edit_supplier_document')[0];
                var formData = new FormData(currentForm);
                formData.append('file', document.getElementById("edit_document_file").files[0]);
                $.ajax({
                    url: "<?= base_url() ?>update_supplier_document",
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
                            $('#edit_supplier_document_modal').modal('toggle');
                            $('#edit_supplier_documents').trigger("reset");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilterDocument(0);
                            setTimeout(function() {
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

