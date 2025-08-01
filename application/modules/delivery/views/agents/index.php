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
                    <!---Add view BOX--->
                    <div id="view" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="element-header margin-0"><?= lang("agents-details"); ?> <span class="close" data-dismiss="modal">&times;</span></h6>
                                </div>
                                <div class="modal-body">
                                    <div class="data-view">
                                        <div class="col-md-8">
                                            <div class="info-1"> 
                                                <div class="company-email"><strong class="fix-width"><?= lang("agent-name"); ?></strong>: <span id="agent_name_view"></span></div>
                                                <div class="company-address"><strong class="fix-width"><?= lang("address"); ?></strong>: <span id="address_view"></span></div>
                                                <div class="company-address"><strong class="fix-width"><?= lang("agent-phone"); ?></strong>: <span id="agent_number_view"></span></div>
                                                <div class="company-address"><strong class="fix-width"><?= lang("email"); ?></strong>: <span id="agent_email_view"></span></div>
                                                <div class="company-phone"><strong class="fix-width"><?= lang("contact-person-name"); ?></strong>: <span id="contact_person_name_view"></span></div>
                                                <div class="company-email"><strong class="fix-width"><?= lang("mobile_no"); ?></strong>: <span id="mobile_no_view"></span></div>
                                               <!--  <div class="company-address"><strong class="fix-width"><?= lang("unit"); ?></strong>: <span id="pro_unit"></span></div> -->
                                                <div class="company-phone"><strong class="fix-width"><?= lang("added_by"); ?></strong>: <span id="added_by"></span></div>
                                                <div class="company-address"><strong class="fix-width"><?= lang("added date"); ?></strong>: <span id="added_date"></span></div>
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


                    <!---Add Modal BOX--->

                    <div id="add" class="modal fade" role="dialog">
                        <div class="modal-dialog  modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <?php echo form_open_multipart('', array('id' => 'agent', 'class' => 'cmxform')); ?>
                                <div class="modal-header">
                                    <h6 class="element-header margin-0"><span id="layout_title"><?= lang("add-agent"); ?> </span> <span class="close" data-dismiss="modal">&times;</span></h6>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="id" value="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("agent-name"); ?><span class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="agent_name" id="agent_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("agent-phone"); ?><span class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="agent_number" id="agent_number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">    
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("address"); ?></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="address" id="address">
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-md-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("email"); ?></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="agent_email" id="agent_email">
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-md-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("contact-person-name"); ?></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="contact_person_name" id="contact_person_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("contact-person-mobile"); ?></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="contact_person_number" id="contact_person_number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

                                <button data-toggle="modal" data-target="#add" class="btn btn-primary bottom-10 right" type="button" onclick="addProduct()"><?= lang("add-agent"); ?></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php
                                    $this->load->view('agents/all_product_data', $posts, false);
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="modal fade" id="deleteAgents" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
                                        <button type="button" class="btn btn-success" onclick="delete_procuct();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
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
                                            

                                            function addProduct() {
                                                $('#agent')[0].reset();
                                                $("#id").val("");
                                                $('#layout_title').text('<?= lang("add-agent"); ?>');
                                                
                                            }
                                            function searchFilter(page_num) {
                                                page_num = page_num ? page_num : 0;
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url(); ?>agents/page_data/' + page_num,
                                                    data: 'page=' + page_num ,
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
                                            function viewAgentDetaitls(id)
                                            {
                                                // alert(id);
                                                $.ajax({
                                                    url: "<?php echo base_url() ?>agents/details/" + id,
                                                    type: "GET",
                                                    dataType: "JSON",
                                                    beforeSend: function () {
                                                        $('.loading').show();
                                                    },
                                                    success: function (data)
                                                    {
                                                        console.log(data);
                                                        $('.loading').fadeOut("slow");
                                                        $('#agent_name_view').html(data.agent_name);
                                                        $('#address_view').html(data.address);
                                                        $('#agent_number_view').html(data.agent_number);
                                                        $('#agent_email_view').html(data.email);
                                                        $('#contact_person_name_view').html(data.contact_person_name);
                                                        $('#mobile_no_view').html(data.contact_person_number);
                                                        $('#added_by').html(data.fullname);
                                                        $('#added_date').html(data.dtt_add);

                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {
                                                        alert('Error get data from ajax');
                                                    }
                                                });
                                            }
                                            function editProducts(id)
                                            {
                                                // alert(id);
                                                $.ajax({
                                                    url: "<?php echo base_url() ?>agents/edit/" + id,
                                                    type: "GET",
                                                    dataType: "JSON",
                                                    success: function (dataValue)
                                                    {
                                                        console.log(dataValue);
                                                        // var result = JSON.parse(dataValue);
                                                        var result = dataValue;
                                                        $('#layout_title').text('Edit Products');
                                                        $('[name="id"]').val(result.data.id_agent);
                                                        $('#agent_name').val(result.data.agent_name);
                                                        $('[name="address"]').val(result.data.address);
                                                        $('[name="agent_number"]').val(result.data.agent_number);
                                                        $('[name="contact_person_name"]').val(result.data.contact_person_name);
                                                        $('[name="contact_person_number"]').val(result.data.contact_person_number);
                                                        $('[name="agent_email"]').val(result.data.email);
                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {
                                                        alert('Error get data from ajax');
                                                    }
                                                });
                                            }
                                            function resetAll() {
                                                // $('#product_category')[0].reset();
                                                $('#layout_title').text('<?= lang("add_agent"); ?>');
                                                // $('#agent_name').attr('name', 'pro_name');
                                            }
                                            function deleteProductModal(id) {
                                                // alert(id);
                                                $('#deleteAgents').val(id);
                                            }
                                            function delete_procuct()
                                            {
                                                var id = $('#deleteAgents').val();
                                                // alert(id);
                                                $.ajax({
                                                    url: "<?php echo base_url() . 'agents/delete' ?>/" + id,
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    beforeSend: function () {
                                                        $('.loading').show();
                                                    },
                                                    success: function (data)
                                                    {
                                                        $('.loading').fadeOut("slow");
                                                        $('#showMessage').html('<?= lang("delete_success"); ?>');
                                                        $('#deleteAgents').modal('toggle');
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
                                                    var currentForm = $('#agent')[0];
                                                    var formData = new FormData(currentForm);
                                                    $.ajax({
                                                        url: "<?= base_url() ?>delivery/agents/add_data",
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
                                                                $('#agent')[0].reset();
                                                                $('#add').modal('hide');
                                                                $('#showMessage').html(result.message);
                                                                window.onload = searchFilter(0);
                                                                setTimeout(function () {
                                                                    $('#showMessage').fadeOut(300);

                                                                }, 3000);
                                                            }
                                                            $('#showMessage').show();
                                                        }
                                                    });

                                                }
                                            });                                           
                                        </script> 
