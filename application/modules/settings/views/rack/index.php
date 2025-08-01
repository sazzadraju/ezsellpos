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
            <div class="col-lg-6">
                <div class="element-wrapper">
            <!-- Add Station start here -->
                    <div class="element-box full-box">
                        <?php echo form_open_multipart('', array('id' => 'racks', 'class' => 'cmxform')); ?>

                        <h6 class="element-header" id="layout_title"><?= lang("add_rack"); ?></h6> 
                        <!-- <input type="hidden" name="store_no" id="store_no" value="<?= ($records[0]->param_val - $records[0]->utilized_val) ?>"> -->
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="edit_id" id="edit_id" value="1">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("rack_name"); ?></label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="<?= lang("rack_name"); ?>" type="text" id="rack_name" name="rack_name">
                            </div>
                        </div>

                        <div class="form-buttons-w">
                            <button class="btn btn-primary" onclick="resetAll()" type="reset" ><?= lang("reset"); ?></button>
                            <button class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            <!-- Add Station End here -->

            </div>
        <!-- Stations List Start here -->
            <div class="col-lg-6">
                <div class="element-wrapper">
                    <div class="element-box full-box">

                        <h6 class="element-header"><?= lang("rack_list"); ?></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang("sl_no"); ?></th>
                                        <th><?= lang("rack_name"); ?></th>
                                        <th><?= lang("action"); ?></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($posts)):
                                                $count = 1;
                                                foreach ($posts as $post):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td><?php echo $post->name; ?></td>
                                                        <td>
                                                            <button rel="tooltip" title="<?= lang("edit")?>"  class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" onclick="edit_rack(<?= $post->id_rack ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                            <button rel="tooltip" title="<?= lang("delete")?>"  class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal" data-target="#deleteStation" onclick="deleteStationModal('<?= $post->id_rack ?>');"><span class="glyphicon glyphicon-trash"></span></button>
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


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Stations List End here -->
        </div>
    </div>
</div>
<div class="modal fade" id="deleteStation" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
                <input type="hidden" id="store_delete_id">
                <button type="button" class="btn btn-success" onclick="delete_station();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
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
                    function edit_rack(id_rack)
                    {
                        $('#racks')[0].reset(); // reset form on modals
                        //Ajax Load data from ajax
                        // alert(id_store);
                        $.ajax({
                            url: "<?php echo base_url() ?>settings/rack/edit_data77/" + id_rack,
                            type: "GET",
                            dataType: "JSON",
                            beforeSend: function () {
                                $('.loading').show();
                            },
                            success: function (data)
                            {   
                                $('.loading').fadeOut("slow");
                                $('#rack_name').val(data.name);
                                $('[name="id"]').val(data.id_rack);
                                $('#rack_name').attr('rack_name', 'name');
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Error get data from ajax');
                            }
                        });
                    }
                    function resetAll() {
                        $('#racks')[0].reset();
                        $('#layout_title').text('<?= lang("add_store"); ?>');
                        $('[name="id"]').val('');
                        $('#rack_name').attr('name', 'rack_name');
                    }
                    function deleteStationModal(id) {
                        $('#store_delete_id').val(id);
                    }
                    function delete_station()
                    {
                        var id = $('#store_delete_id').val();
                        // alert(id);
                        $.ajax({
                            url: "<?php echo base_url() . 'stations/rack/delete_data77' ?>/" + id,
                            type: "POST",
                            dataType: "JSON",
                            beforeSend: function () {
                                $('.loading').show();
                            },
                            success: function (data)
                            {
                                $('.loading').fadeOut("slow");
                                $('#showMessage').html('<?= lang("delete_success"); ?>');
                                $('#showMessage').show();
                                $('#deleteStation').modal('toggle');
                                setTimeout(function () {
                                    window.location.href = "<?php echo base_url() ?>rack-settings";
                                }, 200);
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('<?= lang("delete_error"); ?>');
                            }
                        });
                    }

                     $.validator.setDefaults({
                        submitHandler: function (form) {
                            // var rack = $('[name="rack_no"]').val();
                            var id = $('[name="id"]').val();
                            var edit_id = $('[name="edit_id"]').val();
                           
                            // alert(rack);
                            // alert(edit_id);
                            // if (store == 0 ) {
                            //     alert('Add Station First');
                            //     return false;
                            // } else {
                                var currentForm = $('#racks')[0];
                                var formData = new FormData(currentForm);
                                // console.log(store);
                                console.log(id);
                                 // alert(formData);
                                $.ajax({
                                    url: "<?= base_url() ?>settings/rack/add_data77",
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    beforeSend: function () {
                                        $('.loading').show();
                                    },
                                    success: function (response) {
                                        var result = $.parseJSON(response);
                                        // alert(result);
                                        if (result.status != 'success') {
                                            $.each(result, function (key, value) {
                                                $('[name="' + key + '"]').addClass("error");
                                                $('[name="' + key + '"]').after(' <label class="error">' + value + '</label>');
                                            });
                                        } else {
                                            // $('#stations')[0].reset();
                                            $('#showMessage').html(result.message);
                                            $('#rack_name').attr('name', 'rack_name');
                                            $('#showMessage').show();
                                            setTimeout(function () {
                                                window.location.href = "<?php echo base_url() ?>rack-settings";
                                            }, 200);
                                        }
                                         $('.loading').fadeOut("slow");
                                    }
                                });
                            // }

                        }
                    });
</script>  