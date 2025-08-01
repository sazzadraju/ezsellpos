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


<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script>
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var cat_name = $('#cat_name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>product_category/page_data/' + page_num,
            data: 'page=' + page_num + '&cat_name=' + cat_name,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    function edit_person(id)
    {
        $('#product_category')[0].reset(); // reset form on modals
        $("#category_main").removeAttr('disabled');
        $("#category_main").val(0).change();
        $.ajax({
            url: "<?php echo base_url() ?>product_category/edit/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                //alert(data.name);
                $('.loading').fadeOut("slow");
                $('#category_name').val(data.cat_name);
                $('#layout_title').text('<?= lang("edit_category"); ?>');
                $('[name="id"]').val(data.id_product_category);
                 $('#category_name').attr('name', 'cate_name');
                if(!data.parent_cat_id){
                    $("#category_main").attr("disabled", "disabled");
                }else {
                    $("#category_main").val(data.parent_cat_id).change();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    function resetAll() {
        $('#product_category')[0].reset();
        $("#id").val('');
        $('#layout_title').text('<?= lang("add_category"); ?>');
        $("#category_main").val("0").change();
        $('#category_name').attr('name', 'category_name');
    }
    function deleteCategoryModal(id) {
        $('#category_delete_id').val(id);
    }
    function delete_category()
    {
        var id = $('#category_delete_id').val();
        $.ajax({
            url: "<?php echo base_url() . 'product_category/delete' ?>/" + id,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                if (!data.status) {
                    $('.loading').fadeOut("slow");
                    $('#deleteCategory').modal('toggle');
                    $('#deleteError').modal('show');
                } else {
                    $("#category_main option[value='" + id + "']").remove();
                    $('.loading').fadeOut("slow");
                    $('#showMessage').html('<?= lang("delete_success"); ?>');
                    $('#deleteCategory').modal('toggle');
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
            var currentForm = $('#product_category')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>product_settings/categories/add_data",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (response) {
                    console.log(response);
                    //var result =response
                   var result = JSON.parse(response);
                    console.log(result);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                           $('[name="'+key+'"]').addClass("error");
                            $('[name="'+key+'"]').after(' <label class="error">' + value + '</label>');
                        });
                    } else {
                        if (result.id) {
                            $("#category_main").append('<option value=' + result.id + '>' + result.name + '</option>');
                        }
                        $('#product_category')[0].reset();
                        $("#category_main").removeAttr('disabled');
                        $("#category_main").val("0").change();
                        $('#showMessage').html(result.message);
                        window.onload = searchFilter(0);
                        $('#showMessage').show();
                        $('#category_name').attr('name', 'category_name');
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);

                        }, 3000);
                    }
                    $('.loading').fadeOut("slow");
                }
            });

        }
    });


</script>  
<div class="content-i">

    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="top-btn full-box">
                        <div class="row">

                            <form action="">

                                <div class="col-md-5 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang("category"); ?></label>
                                        <div class="col-sm-12">

                                            <div class="row-fluid">
                                                <input type="text" name="cat_name" class="form-control" id="cat_name">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">

                                    <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                    <button onclick="searchFilter()" class="btn btn-primary btn-rounded center" type="button"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-5">
                            <div class="element-box full-box">
                                <h6 class="element-header" id="layout_title"><?= lang("add_category"); ?></h6>
                                <?php echo form_open_multipart('', array('id' => 'product_category', 'class' => 'cmxform')); ?>
                                <input type="hidden" name="id" id="id" value="">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for=""><?= lang("category"); ?></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="category_name" id="category_name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><?= lang("select_category"); ?></label>
                                    <div class="col-sm-8">

                                        <div class="row-fluid">
                                            <select class="selectpicker" data-live-search="true" id="category_main" name="category_main">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($categories as $category) {
                                                    if ($category->parent_cat_id == NULL) {
                                                        echo '<option value="' . $category->id_product_category . '">' . $category->cat_name . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

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
                                            <?php $this->load->view('categories/all_category_data');?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
                                    <input type="hidden" id="category_delete_id">
                                    <button type="button" class="btn btn-success" onclick="delete_category();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
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

