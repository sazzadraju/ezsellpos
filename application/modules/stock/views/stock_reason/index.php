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
            url: '<?php echo base_url(); ?>stock_reason/page_data/' + page_num,
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

    function qty_set(elem){
        var id = $(elem).val();
        if(id != 0){
            $.ajax({
                url: "<?php echo base_url() ?>stock_reason/find_qty/" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data)
                {
                    //console.log(data.qty_multiplier);
                    $('#qty_multiplier').val(data.qty_multiplier);
                    
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }else{
            $('#qty_multiplier').val('');
        }
       
    }

    function edit_reason(id)
    {
        $('#stock_reason')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $.ajax({
            url: "<?php echo base_url() ?>stock_reason/edit/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                $('.loading').fadeOut("slow");
                $('[name="id"]').val(data.id_stock_mvt_reason);
                $('[name="reason_name"]').val(data.reason);
                $('#layout_title').text('<?= lang("edit_reason"); ?>');
                $("#category").val(data.mvt_type_id).change();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    function deleteBrandModal(id) {
        $('#reason_delete_id').val(id);
    }
    function delete_brand()
    {
        var id = $('#reason_delete_id').val();
        $.ajax({
            url: "<?php echo base_url() . 'stock_reason/delete' ?>/" + id,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                $('.loading').fadeOut("slow");
                $('#showMessage').html('<?= lang("delete_success"); ?>');
                $('#deleteBrand').modal('toggle');
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

    function resetAll() {
        $('#stock_reason')[0].reset();
        $("#id").val("");
        $('#layout_title').text('<?= lang("add_reason"); ?>');
        $('#imageDiv').html('');

    }

    $.validator.setDefaults({
        submitHandler: function (form) {
            //alert('sdf');
            //var value = $(form).serialize();
            var currentForm = $('#stock_reason')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>stock_reason/add_data",
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
                        $("#category").val("0").change();
                        $('.loading').fadeOut("slow");
                        var $el = $('#stock_reason');
                        $el.wrap('<form>').closest('form').get(0).reset();
                        $el.unwrap();
                        $('#showMessage').html(result.message);
                        window.onload = searchFilter(0);
                        $('#showMessage').show();
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);

                        }, 3000);
                        resetAll()
                    }
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
                    <h6 class="element-header" id="layout_title"><?= lang("add_reason"); ?></h6>
                    <?php echo form_open_multipart('', array('id' => 'stock_reason', 'class' => 'cmxform')); ?>
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for=""><?= lang("name"); ?></label>
                        <div class="col-sm-12">
                            <input type="hidden" name="qty_multiplier" id="qty_multiplier">
                            <input type="text" class="form-control"  id="reason_name" name="reason_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label"><?= lang("select_category"); ?></label>
                            <div class=" col-sm-12 row-fluid">
                                <select class="select2" id="category" name="category" onchange="qty_set(this);">
                                    <option value="0"><?php echo lang("select_one"); ?></option>
                                    <?php
                                        if(!empty($stock_mvt_type_list)){
                                            foreach ($stock_mvt_type_list as $list) {
                                    ?>
                                            <option value="<?php echo $list['id_stock_mvt_type'];?>"><?php echo $list['type_name']; ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
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
                                <?php $this->load->view('stock_reason/all_reason_data');?>
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
                <input type="hidden" id="reason_delete_id">
                <button type="button" class="btn btn-success" onclick="delete_brand();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
