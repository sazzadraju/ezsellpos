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

<div id="full" class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-md-10">
                <div class="element-box full-box margin-0">
                    <h6 class="element-header" id=""><span id="layout_title"><?= lang('chalan')?></span></h6>
                    <div class="row">
                        <div class="col-md-8">
                            <form class="sales-search" role="search" id="chalan_preview">
                                <div class="col-md-11 col-sm-10">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="<?= lang('invoice_no')?>" type="text" id="invoice" name="invoice">
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-2">
                                    <button type="submit" class="btn btn-default right"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                           <div id="post_data">

                           </div>
                        </div>

                    </div>
                    <div id="return_data_add">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="validateAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('qty_limit_msg') ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="restore_hold" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div id="restore_hold_data"></div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div id="SaleDetails" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Sale Invoice Details</h6>
            </div>
            <div class="modal-body">
                <div class="sale-view" id="sale_view">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="sale_print()">Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"
                        onclick="location.reload()">Close
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#chalan_preview").submit(function () {
        var $html = '';
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>temp_add_print_chalan',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
               // alert(result);
                //console.log(result);
                $('#post_data').html(result);
                $('.loading').fadeOut("slow");
                return false;
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
</script>