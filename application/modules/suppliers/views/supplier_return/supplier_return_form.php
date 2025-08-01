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
                            <div class="col-md-12">
                                <a href="<?php echo base_url(); ?>supplier-return"
                                   class="btn btn-primary btn-rounded right margin-right-10"
                                   type="button"><?= lang('supplier_return_list') ?></a>
                            </div>
                        </div>
                        <div class="row">
                            <!--Hidden field value start-->
                            <input type="hidden" id="purchase_price">
                            <input type="hidden" id="sale_price">
                            <input type="hidden" id="product_vat_rate">
                            <input type="hidden" id="stock_rack_name">
                            <input type="hidden" id="id_stock">
                            <input type="hidden" id="alert_date">
                            <input type="hidden" id="rack_id">
                            <input type="hidden" id="store_id">
                            <input type="hidden" id="purchase_receive_id">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('invoice') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="invoice_name" id="invoice_name"
                                               class="invoice_name">
                                        <label id="invoice_name-error" class="error" for="invoice_name"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1">

                                <label class="col-sm-12 col-form-label">&nbsp;</label>
                                <button class="btn btn-info" onclick="add_return_cart();"><i class="fa fa-search"></i>
                                    Search
                                </button>
                            </div>

                        </div>
                    </div>

                    <form class="form-horizontal" role="form" id="enter_supplier_return" action="" method="POST"
                          enctype="multipart/form-data">
                        <input type="hidden" name="total_num_of_fields" id="total_num_of_fields" value="0">

                        <div class="element-box full-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <input type="hidden" id="segment_id" value="0">
                                        <table id="mytable" class="table table-bordred table-striped">
                                            <thead>
                                            <tr>
                                                <th><?= lang('product') ?></th>
                                                <th><?= lang('supplier') ?></th>
                                                <th><?= lang('purchase') . lang('qty') ?></th>
                                                <th><?= lang('stock_qty') ?></th>
                                                <th><?= lang('unit_price') ?></th>
                                                <th><?= lang('supplier_return_qty') ?></th>
                                                <th><?= lang('total_price') ?></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="temp_return_data">

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="top-btn full-box">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang('supplier_return_date') ?></label>
                                        <div class='col-sm-12'>
                                            <div class='input-group date' id='StockOutDate'>
                                                <input type='text' class="form-control" name="dtt_stock_mvt"/>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>												
												</span>
                                            </div>
                                            <span id="StockOutDate-error" class="span_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 form-group">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?= lang('supplier_return_doc') ?></label>
                                            <div class='col-sm-12'>
                                                <input type="file" name="stock_out_doc">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang('supplier_return_reason') ?></label>
                                        <div class="col-sm-12">

                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true"
                                                        name="stock_mvt_reason_id" id="stock_mvt_reason_id"
                                                        onchange="reason_note(this);">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php
                                                    if (!empty($reason_list)) {
                                                        foreach ($reason_list as $list) {
                                                            ?>
                                                            <option
                                                                value="<?php echo $list['id_stock_mvt_reason']; ?>"><?php echo $list['reason']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <label id="stock_mvt_reason_id-error" class="error"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">


                                <div class="col-md-4" id="notes_section" style="display: none;">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('notes') ?></label>
                                        <div class='col-sm-12'>
                                            <input class="form-control" type="text" id="notes" name="notes">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-sm-12 col-form-label" for="">&nbsp</label>
                                    <button class="btn btn-primary" type="submit"> <?= lang('submit') ?></button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="element-box">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Validation Alert Start-->
<div class="modal fade" id="validateAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang('attention') ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('stock_out_val_msg') ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Validation Alert End-->


<script type="text/javascript">

    $(function () {
        $('#ExpiryDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });

    $(function () {
        $('#AlertDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });


    $(function () {
        $('#StockOutDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });


</script>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css"
      href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css"/>

<script type="text/javascript">
    var x = 1;
    var batch_inc = 1;
    function add_return_cart() {
        var invoice_number = $('#invoice_name').val();
        if (invoice_number != "") {
            $('#invoice_name-error').html('');
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>get_supplier_return_purchase_list',
                data: {invoice_number: invoice_number},
                success: function (result) {
                    //alert(result);
                    console.log(result);
                    $('#temp_return_data').html(result);
                }
            });
        } else {
            $('#invoice_name-error').html('Invoice no is required');
        }


    }

    function removeMore(id) {
        $("#" + id).remove();
        x--;
        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
        $('input[name="total_num_of_fields"]').val(total_fields - 1);
    }

    function supplier_change() {
        $('#product_name').val('');
        $('#product_id').val('');
        $("#stock_batch_no").val("0").change();
        $('#quantity').val('');
        $('#ExpiryDate').val('');
    }


    function get_stock_details(elem) {
        var stock_id = $(elem).val();
        if (stock_id !== "") {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>get_stock_detail_data',
                data: {stock_id: stock_id},
                success: function (result) {
                    var result = $.parseJSON(result);
                    $('#supplier_name').val(result[0].supplier_name);
                    $('#quantity').val(result[0].qty);
                    $('#ExpiryDate').val(result[0].expire_date);
                    $("#purchase_price").val(result[0].purchase_price);
                    $("#sale_price").val(result[0].selling_price_act);
                    $("#product_vat_rate").val(result[0].vat_rate);
                    $('#stock_rack_name').val(result[0].name);
                    $('#id_stock').val(result[0].id_stock);
                    $('#product_id').val(result[0].product_id);
                    $('#supplier_id').val(result[0].supplier_id);
                    $('#rack_id').val(result[0].rack_id);
                    $('#alert_date').val(result[0].alert_date);
                    $('#store_id').val(result[0].store_id);
                }
            });
        }

    }


    function reason_note(elem) {
        var reason_val = $(elem).val();
        var check_reason = $("#stock_mvt_reason_id option[value='" + reason_val + "']").text();
        check_reason = check_reason.toLowerCase();
        if (check_reason == "others") {
            $('#notes').val('');
            $('#notes_section').show();
        } else {
            $('#notes_section').hide();
            $('#notes').val(check_reason);
        }
    }

    function check_invoice_number(elem) {
        var invoice_number = $(elem).val();
        if (invoice_number != "") {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>check_invoice_no',
                data: {invoice_number: invoice_number},
                success: function (result) {

                    if (result == 1) {
                        $('#invoice_no-error').html('Invoice number is already exist !');
                        setTimeout(function () {
                            $('#invoice_no').val('');
                            $('#invoice_no-error').html('');
                        }, 2000);

                    }

                }
            });
        }
    }
    function validate_supplier_return_enter() {
        var dtt_stock_mvt = $("input[name=dtt_stock_mvt]").val();
        var invoice_no = $('#invoice_no').val();
        var stock_qty;
        var check = 1;
        $("input[name='return_qty[]']").each(function () {
            var id_value = $(this).val() * 1;
            var id_full = $(this).attr('id');
            id = id_full.split("_").pop(-1);
            $('#return_error_' + id).html('');
            $(this).removeClass("focus_error");
            stock_qty = $('#stock_qty_' + id).val() * 1;
            if (id_value == '') {
                check = 2;
                $(this).addClass("focus_error");
                $('#return_error_' + id).html('Required');

            }
            if (id_value > stock_qty) {
                check = 2;
                $(this).addClass("focus_error");
                $('#return_error_' + id).html('Qty not available');
            }
        });
        if (check == 2) {
            return false;
        } else {
            return true;
        }
    }

    $("#enter_supplier_return").submit(function () {
        if (validate_supplier_return_enter() != false) {
            var dataString = new FormData($(this)[0]);
            dataString.append('invoice_no',$('#invoice_name').val());
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>supplier_return_insert',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data) {
                    //console.log(data);
                    var result = $.parseJSON(data);
                    //console.log(result);
                    if (result.status == 'success') {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>supplier-return";
                        }, 500);
                        $('.loading').fadeOut("slow");
                    }
                    // if (result.status != 'success') {
                    //     $.each(result, function (key, value) {
                    //         $("#" + key).addClass("error");
                    //         $("#" + key).after(' <label class="error">' + value + '</label>');
                    //     });
                    // } else {
                    //     $('#showMessage').html(result.message);
                    //     $('#showMessage').show();
                    //     setTimeout(function() {
                    //         window.location.href = "<?php //echo base_url() ?>stock_out";

                    //     }, 3000);
                    //     $('.loading').fadeOut("slow");
                    // }
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        } else {
            return false;
        }
    });
    $(document).on('input', '.chqty', function () {
        var qty = this.value*1;
        var m_id = this.id;
        var id = m_id.split('_').pop(-1);
        var price = $("#pur_price_" + id).val()*1;
        $("#total_price_" + id).val(price*qty);

    });


</script>
