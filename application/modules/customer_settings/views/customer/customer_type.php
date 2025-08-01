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
            <div class="col-lg-5">
                <div class="element-wrapper">
                    <div class="element-box full-box">

                        <?php echo form_open_multipart('', array('id' => 'customer_type', 'class' => 'cmxform')); ?>
                        <input type="hidden" name="id" id="id" value="">
                        <h6 class="element-header"
                            id="layout_title"><?php echo $this->lang->line('customer_type'); ?></h6>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"
                                   for=""><?php echo $this->lang->line('type_name'); ?></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="cus_type_name" id="cus_type_name"
                                       placeholder="<?php echo $this->lang->line('type_name'); ?>" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"
                                   for=""><?php echo $this->lang->line('percentage_of_discount'); ?></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="discount" id="discount"
                                       placeholder="<?php echo $this->lang->line('percentage_of_discount'); ?>"
                                       type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"
                                   for=""><?php echo $this->lang->line('target_sales_volume'); ?></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="target_sales_volume" id="target_sales_volume"
                                       placeholder="<?php echo $this->lang->line('target_sales_volume'); ?>"
                                       type="text">
                            </div>
                        </div>

                        <div class="form-buttons-w">
                            <button class="btn btn-primary" onclick="resetAll()"
                                    type="reset"><?= lang("reset"); ?></button>
                            <button class="btn btn-primary"
                                    type="submit"><?php echo $this->lang->line('submit'); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>


            </div>
            <div class="col-lg-7">
                <div class="element-wrapper">
                    <div class="element-box full-box">

                        <h6 class="element-header"><?php echo $this->lang->line('customer_type_list'); ?></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th class="center"><?php echo $this->lang->line('serial'); ?></th>
                                        <th><?php echo $this->lang->line('customer_type'); ?></th>
                                        <th class="center"><?php echo $this->lang->line('percentage_of_discount'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('target_sales_volume').'('.set_currency().')'; ?></th>
                                        <th><?= lang('action')?></th>

                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 1;
                                        if (!empty($posts)) {
                                            foreach ($posts as $list) {
                                                ?>
                                                <tr>
                                                    <td class="center"><?php echo $i; ?></td>
                                                    <td><?php echo $list['name']; ?></td>
                                                    <td class="center"><?php echo $list['discount']; ?></td>
                                                    <td class="text-right"><?php echo $list['target_sales_volume']; ?></td>
                                                    <?php if ($list['id_customer_type'] != 1) { ?>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs" data-title="Edit" rel="tooltip" title="<?= lang("edit") ?>"
                                                                    onclick="edit_customer_type(<?= $list['id_customer_type'] ?>)">
                                                                <span class="glyphicon glyphicon-pencil"></span>
                                                            </button>

                                                            <button class="btn btn-danger btn-xs" rel="tooltip" title="<?= lang("delete") ?>"
                                                                    data-title="<?= lang("delete"); ?>"
                                                                    data-toggle="modal" data-target="#delete_type_m"
                                                                    onclick="deleteTypeModal('<?= $list['id_customer_type'] ?>');">
                                                                <span class="glyphicon glyphicon-trash"></span></button>
                                                        </td>
                                                    <?php } ?>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_type_m" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_this_entry"); ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span
                        class="glyphicon glyphicon-warning-sign"></span>&nbsp;<?= lang("confirm_delete"); ?> </div>

            </div>
            <div class="modal-footer ">
                <input type="hidden" id="cus_type_delete_id">
                <button type="button" class="btn btn-success" onclick="delete_customer_type();"><span
                        class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="customerEmptyAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang("customer_exists"); ?></li>
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
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer/customer_type_data/' + page_num,
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

    function resetAll() {
        $('#id').val('');
        $('#customer_type')[0].reset();
        $('#layout_title').text('<?= lang("customer_type");?>');
        $('#cus_type_name').attr('name', 'cus_type_name');
    }

    function edit_customer_type(id) {
        save_method = 'update';
        $('#customer_type')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo base_url() ?>customer_settings/customer/edit_customer_type/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('#cus_type_name').val(data.name);
                $('#cus_type_name').attr('name', 'cty_name');
                $('#discount').val(data.discount);
                $('#target_sales_volume').val(data.target_sales_volume);
                $('#id').val(data.id_customer_type);

                $('#layout_title').text('Edit Customer Type');
                $('#modal_form').modal('show');
                $('.loading').fadeOut("slow");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function deleteTypeModal(id) {
        $('#cus_type_delete_id').val(id);
    }

    function delete_customer_type(id) {
        var id = $('#cus_type_delete_id').val();
        $.ajax({
            url: "<?php echo base_url() . 'customer_settings/customer/delete_customer_type' ?>/" + id,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('.loading').fadeOut("slow");
                if(data.status===2){
                    $('#delete_type_m').modal('hide');
                    $('#customerEmptyAlert').modal('toggle');
                }else{
                    $('#showMessage').html("<?php echo lang('delete_success');?>");
                    $('#showMessage').show();
                    $('#delete_type_m').modal('toggle');
                    window.onload = searchFilter(0);
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error deleting data');
            }
        });
    }

    $.validator.setDefaults({
        submitHandler: function (form) {

            var currentForm = $('#customer_type')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>customer_settings/customer/create_customer_type",
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
                        $('#customer_type')[0].reset();
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        window.onload = searchFilter(0);
                        $('#cus_type_name').attr('name', 'cus_type_name');
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