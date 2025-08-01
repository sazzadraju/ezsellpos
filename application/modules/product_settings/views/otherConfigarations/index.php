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
            url: '<?php echo base_url(); ?>otherConfiguration/page_data/' + page_num,
            data: 'page=' + page_num,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                //console.log(html);
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

    function updateVat()
    {
        var vat = $('#vat').val();
        if (vat === '') {
            $("#vat").addClass("error");
            $('#error').text('This Field is required.');
        } else if (!$.isNumeric(vat)) {
            $("#vat").addClass("error");
            $('#error').text('Enter Number Only');
        } else {
            //alert(vat);
            var vat1 = parseInt(vat);
            $.ajax({
                url: "<?php echo base_url() ?>configureVat/edit_vat",
                type: "POST",
                data: 'vat=' + vat1,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data)
                {
                    $('#showMessage').html('<?= lang("update_success") ?>');
                    $('#vat_value').text(data);
                    $('#vat').val('');
                    $('#showMessage').show();
                    $('.loading').fadeOut("slow");
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }
    }
    function edit_unit(id)
    {
        $('#unit_type')[0].reset();
        $.ajax({
            url: "<?php echo base_url() ?>otherConfiguration/edit/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                $('.loading').fadeOut("slow");
                $('#unit_type_name').attr('name', 'name');
                $('#unit_type_name').val(data.unit_code);
                $('#layout_title').text('<?= lang("edit_unit"); ?>');
                $('[name="id"]').val(data.id_product_unit);
                // $('[name="name"]').addClass("error");
                //$('[name="name"]').after(' <label class="error">' + value + '</label>');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    function resetAll() {
        $("#id").val('');
        $('#unit_type')[0].reset();
        $('#layout_title').text('<?= lang("add_unit"); ?>');
        $('#unit_type_name').attr('name', 'unit_type_name');
    }
    function deleteUnitModal(id) {
        $('#unit_delete_id').val(id);
    }
    function delete_unit()
    {
        var id = $('#unit_delete_id').val();
        $.ajax({
            url: "<?php echo base_url() . 'unit/delete' ?>/" + id,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                $('.loading').fadeOut("slow");
                $('#showMessage').html('<?= lang("delete_success"); ?>');
                $('#deleteUnit').modal('toggle');
                window.onload = searchFilter(0);
                $('#showMessage').show();
                setTimeout(function () {
                    $('#showMessage').fadeOut(300);

                }, 3000);
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
            var currentForm = $('#unit_type')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>product_settings/otherConfigurations/add_data",
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
                        $("#id").val('');
                        $('#unit_type')[0].reset();
                        $('#layout_title').text('<?= lang("add_unit"); ?>');
                        window.onload = searchFilter(0);
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        $('#unit_type_name').attr('name', 'unit_type_name');
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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="element-box full-box">
                                <h6 class="element-header" id=""><span id="layout_title"><?= lang("add_unit"); ?></span></h6>
                                <?php echo form_open_multipart('', array('id' => 'unit_type', 'class' => 'cmxform')); ?>
                                <input type="hidden" name="id" id="id" value="">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("unit_type"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" placeholder="<?= lang("unit_type"); ?>" type="text" id="unit_type_name" name="unit_type_name">
                                    </div>
                                </div> 

                                <div class="form-buttons-w">
                                    <button class="btn btn-primary right" type="submit"> <?= lang("submit"); ?></button>
                                </div>

                                <div class="form-buttons-w">
                                    <button class="btn btn-primary right   margin-right-5" type="reset" onclick="resetAll()"> <?= lang("reset"); ?></button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="element-box full-box">
                                <h6 class="element-header" id=""><span id="layout_title"><?= lang("units"); ?></span></h6>
                                <div class="table-responsive" id="postList">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang("unit_type"); ?></th>
                                        <th class="center"><?= lang("action"); ?></th>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (!empty($posts)):
                                                $count = 1;
                                                foreach ($posts as $post):
                                                    ?>
                                                    <tr>
                                                        <td><?= $post['unit_code'] ?></td>
                                                        <td class="center">
                                                            <button class="btn btn-primary btn-xs" rel="tooltip" title="<?= lang("edit") ?>" data-title="<?= lang("edit"); ?>" onclick="edit_unit(<?= $post['id_product_unit'] ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                            <button class="btn btn-danger btn-xs" rel="tooltip" title="<?= lang("delete") ?>" data-title="<?= lang("delete"); ?>" data-toggle="modal" data-target="#deleteUnit" onclick="deleteUnitModal('<?= $post['id_product_unit'] ?>');"><span class="glyphicon glyphicon-trash"></span></button>

                                                        </td>

                                                    </tr>
                                                    <?php
                                                    $count++;
                                                endforeach;
                                            else:
                                                ?>
                                                <tr>
                                                    <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
                                                </tr>
                                            <?php endif; ?> 
                                        </tbody>

                                    </table>

                                    <div class="clearfix"></div>
                                    <?php echo $this->ajax_pagination->create_links(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteUnit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
                                    <input type="hidden" id="unit_delete_id">
                                    <button type="button" class="btn btn-success" onclick="delete_unit();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
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