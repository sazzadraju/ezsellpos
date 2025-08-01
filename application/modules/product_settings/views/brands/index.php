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
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>product_brands/page_data/' + page_num,
            data: 'page=' + page_num,
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
    function edit_person(id)
    {
        save_method = 'update';
        $('#signupForm')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo base_url() ?>product_brands/edit/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {

                $('.loading').fadeOut("slow");
                $('[name="id"]').val(data.id);
                $('#brand_name').attr('name', 'br_name');
                $('#brand_name').val(data.brand_name);
                $('#layout_title').text('Edit Brands');
                $('[name="id"]').val(data.id_product_brand);
                $('[name="image_name"]').val(data.img_main);
                var photo = data.img_main;
                if (data.img_main) {
                    var image_path = "<?php echo documentLink('brand')?>" + photo;
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
    function deleteBrandModal(id) {
        $('#brand_delete_id').val(id);
    }
    function delete_brand()
    {
        var id = $('#brand_delete_id').val();
        $.ajax({
            url: "<?php echo base_url() . 'product_brands/delete' ?>/" + id,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                if (!data.status) {
                    $('.loading').fadeOut("slow");
                    $('#deleteBrand').modal('toggle');
                    $('#deleteError').modal('show');
                } else {
                    $('.loading').fadeOut("slow");
                    $('#showMessage').html('<?= lang("delete_success"); ?>');
                    $('#deleteBrand').modal('toggle');
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

    function resetAll() {
        $('#signupForm')[0].reset();
        $("#id").val("");
        $("#image_name").val("");
        $('#layout_title').text('<?= lang("add_brand"); ?>');
        $('#imageDiv').html('');
        $('#brand_name').attr('name', 'brand_name');

    }

    $.validator.setDefaults({
        submitHandler: function (form) {
            //alert('sdf');
            //var value = $(form).serialize();
            var currentForm = $('#signupForm')[0];
            var formData = new FormData(currentForm);
            formData.append('file', document.getElementById("userfile").files[0]);

            $.ajax({
                url: "<?= base_url() ?>product_settings/brands/add_data",
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
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $('[name="'+key+'"]').addClass("error");
                            $('[name="'+key+'"]').after(' <label class="error">' + value + '</label>');
                        });
                    } else {
                        
                        var $el = $('#signupForm');
                        $el.wrap('<form>').closest('form').get(0).reset();
                        $el.unwrap();
                        $('#showMessage').html(result.message);
                        window.onload = searchFilter(0);
                        $('#showMessage').show();
                        $('#brand_name').attr('name', 'brand_name');
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
            <div class="col-md-4">
                <div class="element-box full-box">
                    <h6 class="element-header" id="layout_title"><?= lang("add_brand"); ?></h6>
                    <!--                    <form class="cmxform" id="signupForm" method="post" action="" enctype='multipart/form-data'>-->
                    <?php echo form_open_multipart('', array('id' => 'signupForm', 'class' => 'cmxform')); ?>
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="image_name" id="image_name" value="">
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for=""><?= lang("brand_name"); ?></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control"  id="brand_name" name="brand_name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label"><?= lang("select_logo"); ?></label>
                        <div class="col-sm-12">  
                            <input type="file" name="userfile" id="userfile" /> 
                        </div>
                        <div class="col-sm-12">
                            <div id="imageDiv"></div>
                        </div>
                    </div>


                    <div class="form-buttons-w">
                        <button class="btn btn-primary" onclick="resetAll()" type="reset" ><?= lang("reset"); ?></button>
                        <button class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="col-md-8">

                <div class="element-box full-box">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="postList">
                                <?php $this->load->view('brands/all_brand_data');?>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteBrand" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
                <input type="hidden" id="brand_delete_id">
                <button type="button" class="btn btn-success" onclick="delete_brand();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="deleteError" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_error"); ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<?= lang("please_delete_product_brand_first"); ?> </div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("close"); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
