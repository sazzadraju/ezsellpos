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

<!--                            <form action="">-->
<!---->
<!--                                <div class="col-md-5 col-sm-12">-->
<!--                                    <div class="form-group row">-->
<!--                                        <label class="col-sm-12 col-form-label">--><?//= lang("category"); ?><!--</label>-->
<!--                                        <div class="col-sm-12">-->
<!---->
<!--                                            <div class="row-fluid">-->
<!--                                                <input type="text" name="cat_name" class="form-control" id="cat_name">-->
<!--                                            </div>-->
<!---->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-lg-2">-->
<!---->
<!--                                    <label class="col-sm-12 col-form-label" for="">&nbsp;</label>-->
<!--                                    <button onclick="searchFilter()" class="btn btn-primary btn-rounded center" type="button"><i class="fa fa-search"></i></button>-->
<!--                                </div>-->
<!--                            </form>-->
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-5">
                            <div class="element-box full-box">
                                <h6 class="element-header" id="layout_title"><?= lang("add_attributes"); ?></h6>
                                <?php echo form_open_multipart('', array('id' => 'add_attributes', 'class' => 'cmxform')); ?>
                                <input type="hidden" name="id" id="id" value="">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for=""><?= lang("attribute_name"); ?></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="attr_name" id="attr_name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for=""><?= lang("attribute_value"); ?></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="attr_val" id="attr_val">
                                        <span><?php echo lang('comma_separate');?></span>
                                    </div>
                                </div>
                                <div class="form-buttons-w">
                                    <button class="btn btn-primary" onclick="resetAll()" type="reset" ><?= lang("reset"); ?></button>
                                    <button class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>

                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <div class="col-md-7">

                            <div class="element-box full-box"> 

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive" id="postList">
                                            <?php $this->load->view('attributes/all_attribute_data');?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="delete_attr" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                    <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_this_entry"); ?></h4>
                                </div>
                                <div class="modal-body">

                                    <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<?= lang("confirm_delete"); ?> </div>

                                </div>
                                <div class="modal-footer ">
                                    <input type="hidden" id="attribute_delete_id">
                                    <button type="button" class="btn btn-success" onclick="delete_attribute();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
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
<div class="modal fade" id="deleteError" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_error"); ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<?= lang("please_delete_subcategory_first"); ?> </div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("close"); ?></button>
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
    function edit_person(id)
    {
        $('#add_attributes')[0].reset(); // reset form on modals
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo base_url() ?>attributes/edit/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                //alert(data.name);
                $('.loading').fadeOut("slow");
                $('#attr_name').val(data.attribute_name);
                $('#attr_val').val(data.attribute_value);
                $('#layout_title').text('<?= lang("edit_attributes"); ?>');
                $('[name="id"]').val(data.id_attribute);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    function resetAll() {
        $('#add_attributes')[0].reset();
        $("#id").val('');
        $('#layout_title').text('<?= lang("add_attributes"); ?>');
    }
    function deleteAttributeModal(id) {
        $('#attribute_delete_id').val(id);
    }
    function delete_attribute()
    {
        var id = $('#attribute_delete_id').val();
        $.ajax({
            url: "<?php echo base_url() . 'attribute/delete' ?>/" + id,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                if (!data.status) {
                    $('.loading').fadeOut("slow");
                    $('#deleteError').modal('show');
                } else {
                    $('#delete_attr').modal('hide');
                    $('.loading').fadeOut("slow");
                    $('#showMessage').html('<?= lang("delete_success"); ?>');
                    window.onload = searchFilter(0);
                    $('#showMessage').show();
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('<?= lang("delete_error"); ?>');
            }
        });
    }



    $.validator.setDefaults({
        submitHandler: function (form) {
            //alert('sdf');
            //var value = $(form).serialize();
            var currentForm = $('#add_attributes')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>product_settings/attributes/add_data",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (response) {
                    //var result =response
                    var result = JSON.parse(response);
                    console.log(result);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $('[name="'+key+'"]').addClass("error");
                            $('[name="'+key+'"]').after(' <label class="error">' + value + '</label>');
                        });
                    } else {

                        $('#add_attributes')[0].reset();
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

        }
    });
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var attribute_name = $('#attribute_name_s').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>attributes/page_data/' + page_num,
            data: 'page=' + page_num + '&attr_name=' + attribute_name,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }


</script>

