<style>
    #mytable input {
        width: 90px;
    }
    table tr td{
        padding: 4px !important;
    }

    ul.validation_alert{
        list-style: none;
    }

    ul.validation_alert li{
        padding: 5px 0;
    }

    .focus_error{
        border: 1px solid red;
        background: #ffe6e6;
    }

    .span_error{
        position: absolute;
        color: #da4444;
        width: 200%;
        background: #fff;

    }
</style>

<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>

<?php
$list_rack = '';
if (!empty($rack_list)) {
    foreach ($rack_list as $list) {
        $list_rack .= '<option value="' . $list['id_rack'] . '">' . $list['name'] . '</option>';
    }
}
?>
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
                                <a href="<?php echo base_url(); ?>stock_in_list"
                                   class="btn btn-primary btn-rounded right margin-right-10"
                                   type="button"><?= lang('stock_list') ?></a>
                            </div>
                        </div>
                        <div class="row">
                            <!--Hidden field value start-->
                            <input type="hidden" id="purchase_price">
                            <input type="hidden" id="sale_price">
                            <input type="hidden" id="pro_code">
                            <input type="hidden" id="product_name" name="product_name">
                            <!--Hidden field value end-->
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('product') ?> </label>
                                    <div class="col-sm-12">
                                        <!-- <select class="select2" data-live-search="true" id="product_name" name="product_name">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            //foreach ($products as $product) {
                                                //echo '<option actp="'.$product->product_name.'" value="' . $product->id_product . '">' . $product->product_name.'('.$product->product_code.')' . '</option>';
                                            //}
                                            ?>
                                        </select> -->
                                        <input type="text" class="form-control" name="product_list" id="product_list">
                                        <label id="product_list-error" class="error" for="product_name"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?php echo lang('supplier') ?> </label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="supplier_name" name="supplier_name">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($suppliers as $supplier) {
                                                echo '<option actp="'.$supplier->supplier_name.'" value="' . $supplier->id_supplier . '">' . $supplier->supplier_name.'('.$supplier->supplier_code.')' . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <label id="supplier_name-error" class="error" for="supplier_name"></label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('quantity') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="quantity" id="quantity">
                                        <label id="quantity-error" class="error" for="quantity"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('expiration_date') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" id="ExpiryDate" name="expire_date">
                                        <label id="expire_date-error" class="error" for="expire_date"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('alert_date') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" id="AlertDate" name="alert_date">
                                        <label id="alert_date-error" class="error" for="alert_date"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <label class="col-sm-12 col-form-label">&nbsp;</label>
                                <button class="btn btn-info" data-title="<?= lang("add_attributes"); ?>"
                                        data-toggle="modal" rel="tooltip" title="<?= lang("add_attributes") ?>"
                                        data-target="#add_attributes"><i class="fa fa-plus"></i></button>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" name="rack_list" id="rack_list" value='<?php echo $list_rack; ?>'>
                    <form class="form-horizontal" role="form" id="enter_stock_in" action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="total_num_of_fields" id="total_num_of_fields" value="0">
                        <input type="hidden" name="batch_no" id="batch_no" value="<?php echo $batch_id; ?>">
                        <div class="element-box full-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <input type="hidden" id="segment_id" value="0">
                                        <table id="mytable" class="table table-bordred table-striped">
                                            <thead>
                                            <tr>
                                                <th rowspan="2"><?= lang('serial') ?></th>
                                                <th rowspan="2"><?= lang('product') ?></th>
                                                <th rowspan="2"><?= lang('supplier') ?></th>
                                                <th rowspan="2"><?= lang('rack_id') ?></th>
                                                <th rowspan="2"><?= lang('expiration_date') ?></th>
                                                <th rowspan="2"><?= lang('qty') ?></th>
                                                <th colspan="2" class="text-center"><?= lang('price') ?></th>
                                                <th colspan="2" class="text-center"><?= lang('total') ?></th>
                                            </tr>
                                            <tr>
                                                <th><?= lang('purchase') ?></th>
                                                <th><?= lang('sale') ?></th>
                                                <th><?= lang('purchase') ?></th>
                                                <th><?= lang('sale') ?></th>
                                            </tr>
                                            </thead>
                                            <tbody id="add_more_section">


                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" class="text-right"><?= lang('total') ?></th>
                                                    <th id="sum_row_qty"></th>
                                                    <th id="sum_row_purchase"></th>
                                                    <th id="sum_row_sale"></th>
                                                    <th id="sum_row_total"></th>
                                                    <th id="sum_row_sale_total"></th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="top-btn full-box" id="add_submit" style="display:none;">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('stock_in_date') ?></label>
                                        <div class='col-sm-12'>
                                            <div class='input-group date' id='StockInDate'>
                                                <input type='text' class="form-control" name="dtt_stock_mvt" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>												
                                                </span>
                                            </div>
                                            <span id="StockInDate-error" class="span_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 form-group">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?= lang('stock_in_doc') ?></label>
                                            <div class='col-sm-12'>
                                                <input type="file" name="stock_in_doc" id="stock_in_doc">
                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("file_type"); ?></p>
                                                <span class="span_error" id="file_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12col-form-label"><?= lang("store_name"); ?></label>
                                        <div class="col-sm-12">
                                            <div class="row-fluid">
                                                <select class="form-control" id="store_name" name="store_name">
                                                    <option value="0" selected><?= lang("select_one"); ?></option>
                                                    <?php
                                                    foreach ($stores as $store) {
                                                        if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                                            echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                        } else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
                                                            echo '<option value="' . $store->id_store . '" selected>' . $store->store_name . '</option>';
                                                        }

                                                    }
                                                    ?>
                                                </select>
                                                <span class="span_error" id="store_name_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('invoice_no') ?></label>
                                        <div class='col-sm-12'>
                                            <input class="form-control" type="text" id="invoice_no" name="invoice_no"
                                                   value="<?php echo $invoice_id; ?>"
                                                   onkeyup="check_invoice_number(this);">
                                            <input type="hidden" name="default_invoice_no" id="default_invoice_no"
                                                   value="<?php echo $invoice_id; ?>">
                                            <span id="invoice_no-error" class="span_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang('stock_in_reason') ?></label>
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
                <h4 class="modal-title custom_align" id="Heading"><?= lang('delect_this_entry') ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('stock_in_val_msg') ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Validation Alert End-->
<?php
$this->load->view('add_attributes', $attributes, false);
?>



<script type="text/javascript">

    $(function () {
        $('#ExpiryDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

        $( "#product_list" ).autocomplete({
            minLength: 0,
            source: function( request, response ) {
                var startTime= new Date().getTime();
                $.ajax({
                    type: 'GET',
                    url: URL+"get_product_auto_list",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function( data ) {
                        //console.log(data);
                        response(data);
                        var Time = new Date().getTime()-startTime;
                        var diff=(Time/1000).toString();
                        console.log(diff);
                    }
                });
            },
            focus: function (event, ui) {
            $("#product_list").val(ui.item.label);
            },
            select: function(event, ui) {
            $('#product_name').val(ui.item.value); // display the selected text
            $('#purchase_price').val(ui.item.purchase_price);
            $('#sale_price').val(ui.item.sale_price);
            $('#pro_code').val(ui.item.product_code);
            return false;
            } 
        });
    });

    $(function () {
        $('#AlertDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });


    $(function () {
        $('#StockInDate').datetimepicker({
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
    // function add_stock_cart() {
    //     if (validateStockCart() != false) {
    //         //get value from field start
    //         var product_id = $('#product_name option:selected').val();
    //         var product_code = $('#pro_code').val();
    //         var supplier_id = $('#supplier_name option:selected').val();
    //         var quantity = $('#quantity').val();
    //         var ExpiryDate = $('#ExpiryDate').val();
    //         var AlertDate = $('#AlertDate').val();
    //         var product_name = $('#product_name option:selected').attr('actp');
    //         var purchase_price = $("#purchase_price").val();
    //         var sale_price = $("#sale_price").val();
    //         // var is_unq_barcode = $("#is_unq_barcode").val();
    //         var supplier_name = $('#supplier_name option:selected').attr('actp');
    //         var batch_no = $("#batch_no").val();
    //         //get value from field end

    //         var product_exist = "";
    //         var add_more_check = 1;

    //         if ($('#total_num_of_fields').val() != 0) {
    //             for (var i = 0; i < x; i++) {

    //                 if (product_id == $('#row_product_id_' + i).val()) {
    //                     if (product_id == $('#row_product_id_' + i).val() && supplier_id == $('#row_supplier_id_' + i).val() && ExpiryDate == $('#row_expire_date_' + i).val()) {
    //                         //update row
    //                         row_qty = $('#row_qty_' + i).val();
    //                         $('#row_qty_' + i).val(row_qty * 1 + quantity * 1);
    //                         add_more_check = 0;
    //                         product_exist = 2;
    //                         break;
    //                     } else {
    //                         product_exist = 1;
    //                     }
    //                 }
    //             }
    //         }

    //         if (product_exist == 1) {
    //             batch_no = $("#batch_no").val() + "-" + batch_inc;
    //             batch_inc++;
    //         }

    //         if (add_more_check != 0) {
    //             //add more section start
    //             var rack_list = $('#rack_list').val();
    //             var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
    //             $('input[name="total_num_of_fields"]').val(total_fields + 1);
    //             var maxField = x * 1 + 1;
    //             var addButton = $('#add_more');
    //             //var wrapper = $('#add_more_section');
    //             var fieldHTML = "<tr id='" + x + "'><td><section id='product_name_" + x + "'></section><section id='product_code_" + x + "'></section><input type='hidden' name='row_product_id[]' id='row_product_id_" + x + "'></td><td><section id='supplier_name_" + x + "'></section><input type='hidden' name='row_supplier_id[]' id='row_supplier_id_" + x + "'></td><td><input type='text' name='row_qty[]' id='row_qty_" + x + "'></td><td><input type='text' id='row_purchase_price_" + x + "' name='row_purchase_price[]'></td><td><input type='text' id='row_sale_price_" + x + "' name='row_sale_price[]'></td><td><select size='1' name='rack_id[]'><option value='0'><?= lang('select_one') ?></option>" + rack_list + "</select></td><td><input id='row_expire_date_" + x + "' name='row_expire_date[]' type='text' readonly='readonly'></td><td><input id='row_alert_date_" + x + "' name='row_alert_date[]' type='text' readonly='readonly'></td><td><input id='row_batch_no_" + x + "' name='row_batch_no[]' type='text' readonly='readonly'></td><td><button class='btn btn-danger btn-xs' onclick='removeMore(" + x + ");'>X</button></td></tr>";

    //             if (x < maxField) {
    //                 $('#mytable > tbody:last').append(fieldHTML);
    //                 //assign value in add more section start
    //                 $('#row_product_id_' + x).val(product_id);
    //                 $('#product_name_' + x).html(product_name);
    //                 $('#product_code_' + x).html(product_code);
    //                 $('#row_supplier_id_' + x).val(supplier_id);
    //                 $('#supplier_name_' + x).html(supplier_name);
    //                 $('#row_qty_' + x).val(quantity);
    //                 $('#row_purchase_price_' + x).val(purchase_price);
    //                 $('#row_sale_price_' + x).val(sale_price);
    //                 // $('#row_is_unq_barcode_'+x).val(is_unq_barcode);
    //                 $('#row_expire_date_' + x).val(ExpiryDate);
    //                 $('#row_alert_date_' + x).val(AlertDate);
    //                 $('#row_batch_no_' + x).val(batch_no);
    //                 //assign value in add more section end
    //                 x++;
    //             }
    //         }

    //         $('#product_name').val('0').change();
    //         $('#supplier_name').val('0').change();
    //         $('#supplier_id').val('');
    //         $('#quantity').val('');
    //         $('#ExpiryDate').val('');
    //         // $('#is_unq_barcode').val('');
    //         $('#AlertDate').val('');
    //         //add more section end

    //     } else {
    //         return false;
    //     }

    // }

    function removeMore(id) {
        $("#" + id).remove();
        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
        $('input[name="total_num_of_fields"]').val(total_fields - 1);
        var tot_row=$("#total_num_of_fields").val()*1;
        if(tot_row==0){
            $('#add_submit').hide();
        }
        sum_calculation(); 
    }
    $('#product_name').on('change', '', function (e) {
        var product_id=this.value;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>product_details_by_id',
            data: 'id=' + product_id,
            success: function (data) {
                var result = $.parseJSON(data);
                $('#purchase_price').val(result[0].buy_price);
                $('#sale_price').val(result[0].sell_price);
                $('#pro_code').val(result[0].product_code);
            }
        });
    });

    function validateStockCart() {
        var product_id = $('#product_name option:selected').val();
        var supplier_id = $('#supplier_name option:selected').val();
        var quantity = $('#quantity').val();
       // var ExpiryDate = $('#ExpiryDate').val();
        //var AlertDate = $('#AlertDate').val();

        if (product_id == "0" || supplier_id == "0" || quantity == "" ) {

            $('#product_name-error').html("");
            $('#supplier_name-error').html("");
            $('#quantity-error').html("");

            if (product_id == "0") {
                $('#product_name-error').html("Product not be empty");
                setTimeout(function () {
                    $('#product_name-error').html("");
                }, 2000);
            }

            if (supplier_id == "0") {
                $('#supplier_name-error').html("Supplier not be empty");
                setTimeout(function () {
                    $('#supplier_name-error').html("");
                }, 2000);
            }

            if (quantity == "") {
                $('#quantity-error').html("Quantity not be empty");
                setTimeout(function () {
                    $('#quantity-error').html("");
                }, 2000);

            } else if (!($.isNumeric(quantity))) {
                $('#quantity-error').html("Must be number");
                setTimeout(function () {
                    $('#quantity-error').html("");
                }, 2000);
            }
            return false;
        } else {
            return true;
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
    function product_list_suggest(elem) {
        var request = $('#product_name').val();
        $("#product_name").autocomplete({
            source: "<?php echo base_url(); ?>get_products_for_stock_in?request=" + request,
            focus: function (event, ui) {
                event.preventDefault();
                $("#product_name").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#product_id").val('');
                $("#product_name").val('');
                $("#purchase_price").val('');
                $("#sale_price").val('');
                $("#pro_code").val('');

                $("#product_id").val(ui.item.value);
                $("#product_name").val(ui.item.label);
                $("#purchase_price").val(ui.item.buy_price);
                $("#sale_price").val(ui.item.sell_price);
                $("#pro_code").val(ui.item.pro_code);
            }
        });

    }
    function supplier_list_suggest(elem) {
        var request = $('#supplier_name').val();
        $("#supplier_name").autocomplete({
            source: "<?php echo base_url(); ?>get_suppliers_for_stock_in?request=" + request,
            minLength: 2,
            focus: function (event, ui) {
                event.preventDefault();
                $("#supplier_name").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#supplier_id").val('');
                $("#supplier_name").val('');

                $("#supplier_id").val(ui.item.value);
                $("#supplier_name").val(ui.item.label);
            }
        });

    }
    function validate_stock_enter() {
        var dtt_stock_mvt = $("input[name=dtt_stock_mvt]").val();
        var invoice_no = $('#invoice_no').val();
        var store_name = $('#store_name option:selected').val() * 1;
        $('#store_name_error').html('');
        var stock_validate =0;
        $("input[name='row_product_id[]']").each(function () {
            var id_full = $(this).attr('id');
            var b = id_full.split("_").pop(-1);
            var qty = $('#row_qty_' + b).val();
            var purchase_price = $('#row_purchase_price_' + b).val();
            var sale_price = $('#row_sale_price_' + b).val();
            if (qty == "" || purchase_price == "" || sale_price == "" || !($.isNumeric(qty)) || !($.isNumeric(purchase_price)) || !($.isNumeric(sale_price))) {

                stock_validate = 1;
                $('#row_qty_' + b).removeClass('focus_error');
                $('#row_purchase_price_' + b).removeClass('focus_error');
                $('#row_sale_price_' + b).removeClass('focus_error');

                if (qty == "") {
                    $('#row_qty_' + b).addClass('focus_error');
                } else if (!($.isNumeric(qty))) {
                    $('#row_qty_' + b).val('');
                    $('#row_qty_' + b).addClass('focus_error');
                }

                if (purchase_price == "") {
                    $('#row_purchase_price_' + b).addClass('focus_error');
                } else if (!($.isNumeric(purchase_price))) {
                    $('#row_purchase_price_' + b).val('');
                    $('#row_purchase_price_' + b).addClass('focus_error');
                }

                if (sale_price == "") {
                    $('#row_sale_price_' + b).addClass('focus_error');
                } else if (!($.isNumeric(sale_price))) {
                    $('#row_sale_price_' + b).val('');
                    $('#row_sale_price_' + b).addClass('focus_error');
                }

            }
        });
        var file_er = 1;
        var file = $('#stock_in_doc').val();
        if (file != '') {
            var ext = $('#stock_in_doc').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'pdf', 'xls', 'xlsx', 'doc', 'docx']) == -1) {
                file_er = 0;
            }
        }


        if (stock_validate == 1 || dtt_stock_mvt == "" || invoice_no == "" || store_name == 0 || file_er == 0) {

            if (stock_validate == 1) {
                $('#validateAlert').modal('toggle');
            }
            if (store_name == 0) {
                $('#store_name_error').html('Select Any One');
            }

            if (dtt_stock_mvt == "") {
                $('#StockInDate-error').html('Stock in date should not be empty');
            }

            if (file_er == 0) {
                $('#file_error').html('Invoice select file type');
            }

            if (invoice_no == "") {
                $('#invoice_no-error').html('Invoice number should not be empty');
            }
            return false;
        } else {
            return true;
        }

    }
    $("#enter_stock_in").submit(function () {
        if (validate_stock_enter() != false) {
            var dataString = new FormData($(this)[0]);
            //console.log(dataString);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>stock_in_insert',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    var result = $.parseJSON(result);
                    $('.loading').fadeOut("slow");
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');

                        });
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>stock_in_list";

                        }, 3000);
                        $('.loading').fadeOut("slow");
                    }
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
    $("#submit_add_attribute").submit(function () {
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            //dataType: "json",
            url: '<?php echo base_url(); ?>stock_insert_attributes',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('.loading').fadeOut("slow");

                var result = $.parseJSON(data);
                $('#add_attributes').modal('hide');
                if (validateStockCart() != false) {
                    var product_id = $('#product_name').val();
                    var product_code = $('#pro_code').val();
                    var supplier_id = $('#supplier_name option:selected').val();
                    var quantity = $('#quantity').val();
                    var ExpiryDate = $('#ExpiryDate').val();
                    var AlertDate = $('#AlertDate').val();
                    var product_name = $('#product_list').val()
                    var purchase_price = $("#purchase_price").val();
                    var sale_price = $("#sale_price").val();
                    // var is_unq_barcode = $("#is_unq_barcode").val();
                    var supplier_name = $('#supplier_name option:selected').attr('actp');
                    var batch_no = $("#batch_no").val();
                    //get value from field end

                    var product_exist = "";
                    var add_more_check = 1;
                    if(data!=1){
                        $.each(result, function (ke, obj) {
                            var attr = '';
                            var attr_show = '';
                            var c = 1;

                            $.each(obj, function (key, value) {
                                //console.log(key + '=' + value);
                                // alert(key + '=' + value);
                                var coma = '';
                                if (c > 1) {
                                    coma = ',';
                                }
                                var lastItem = key.split("@");
                                attr += coma + lastItem[0] + '=' + lastItem[1] + '=' + value;
                                attr_show += coma + lastItem[1] + '=' + value;
                                c += 1;
                            });

                            if ($('#total_num_of_fields').val() != 0) {
                                for (var i = 0; i < x; i++) {
                                    var expDate='';
                                    if(ExpiryDate!=''){
                                        expDate= '&&'+ ExpiryDate +'==' +$('#row_expire_date_' + i).val();
                                    }

                                    if (product_id == $('#row_product_id_' + i).val()) {
                                        if (product_id == $('#row_product_id_' + i).val() && supplier_id == $('#row_supplier_id_' + i).val() && attr == $('#row_attr_value_' + i).val() && ExpiryDate == $('#row_expire_date_' + i).val()) {
                                            //update row
                                            row_qty = $('#row_qty_' + i).val();
                                            $('#row_qty_' + i).val(row_qty * 1 + quantity * 1);
                                            add_more_check = 0;
                                            product_exist = 2;
                                            break;
                                        } else {
                                            product_exist = 1;
                                        }
                                    }
                                }
                            }
                            if (product_exist == 1) {
                                batch_no = $("#batch_no").val() + "-" + batch_inc;
                                batch_inc++;
                            }

                            if (add_more_check != 0) {
                                //add more section start


                                var attr_id = "<input type='hidden' name='row_attr_value[]' id='row_attr_value_" + x + "' value='" + attr + "'>";

                                // alert('sd-2');
                                var rack_list = $('#rack_list').val();
                                var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
                                $('input[name="total_num_of_fields"]').val(total_fields + 1);
                                var maxField = x * 1 + 1;
                                var addButton = $('#add_more');
                                //var wrapper = $('#add_more_section');
                                var fieldHTML = "<tr id='" + x + "'><td id='sl_" + x + "'></td><td><section id='product_name_" + x + "'></section>" + attr_id + "<section id='product_code_" + x + "'></section><input type='hidden' name='row_product_id[]' id='row_product_id_" + x + "'></td><td><section id='supplier_name_" + x + "'></section><input type='hidden' name='row_supplier_id[]' id='row_supplier_id_" + x + "'></td><td><select size='1' name='rack_id[]'><option value='0'><?= lang('select_one') ?></option>" + rack_list + "</select></td><td><input id='row_expire_date_" + x + "' name='row_expire_date[]' type='text' readonly='readonly'></td><td><input id='row_alert_date_" + x + "' name='row_alert_date[]' type='hidden' ><input type='text' class='change_val' name='row_qty[]' id='row_qty_" + x + "'></td><td><input type='text' id='row_purchase_price_" + x + "' name='row_purchase_price[]' class='change_val'></td><td><input type='text' id='row_sale_price_" + x + "' name='row_sale_price[]' class='change_val'></td><td><input id='row_batch_no_" + x + "' name='row_batch_no[]' type='hidden' readonly='readonly'><input id='row_total_price_" + x + "' name='row_total_price[]' type='text' readonly='readonly'></td><td><input id='row_total_sale_price_" + x + "' name='row_total_sale_price[]' type='text' readonly='readonly'></td><td><button class='btn btn-danger btn-xs' onclick='removeMore(" + x + ");'>X</button></td></tr>";

                                if (x < maxField) {
                                    $('#mytable > tbody:last').append(fieldHTML);
                                    //assign value in add more section start
                                    $('#row_product_id_' + x).val(product_id);
                                    $('#product_name_' + x).html(product_name + '<br>' + attr_show);
                                    $('#product_code_' + x).html(product_code);
                                    $('#row_supplier_id_' + x).val(supplier_id);
                                    $('#supplier_name_' + x).html(supplier_name);
                                    $('#row_qty_' + x).val(quantity);
                                    $('#row_purchase_price_' + x).val(purchase_price);
                                    $('#row_sale_price_' + x).val(sale_price);
                                    $('#row_total_price_'+x).val(quantity*purchase_price);
                                    $('#row_total_sale_price_'+x).val(quantity*sale_price);
                                    $('#row_expire_date_' + x).val(ExpiryDate);
                                    $('#row_alert_date_' + x).val(AlertDate);
                                    $('#row_batch_no_' + x).val(batch_no);
                                    //assign value in add more section end
                                    x++;
                                    $('#add_submit').show();
                                }
                            }
                        });
                    } else{
                        if ($('#total_num_of_fields').val() != 0) {
                            for (var i = 0; i < x; i++) {

                                if (product_id == $('#row_product_id_' + i).val()) {
                                    if (product_id == $('#row_product_id_' + i).val() && supplier_id == $('#row_supplier_id_' + i).val() && ExpiryDate == $('#row_expire_date_' + i).val()) {
                                        //update row
                                        row_qty = $('#row_qty_' + i).val();
                                        $('#row_qty_' + i).val(row_qty * 1 + quantity * 1);
                                        add_more_check = 0;
                                        product_exist = 2;
                                        break;
                                    } else {
                                        product_exist = 1;
                                    }
                                }
                            }
                        }
                        if (product_exist == 1) {
                            batch_no = $("#batch_no").val() + "-" + batch_inc;
                            batch_inc++;
                        }
                        if (add_more_check != 0) {
                            //add more section start
                            var attr_id = "<input type='hidden' name='row_attr_value[]' id='row_attr_value_" + x + "' value=''>";
                            var rack_list = $('#rack_list').val();
                            var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
                            $('input[name="total_num_of_fields"]').val(total_fields + 1);
                            var maxField = x * 1 + 1;
                            var addButton = $('#add_more');
                            //var wrapper = $('#add_more_section');
                            var fieldHTML = "<tr id='" + x + "'><td id='sl_" + x + "'></td><td><section id='product_name_" + x + "'></section>" + attr_id + "<section id='product_code_" + x + "'></section><input type='hidden' name='row_product_id[]' id='row_product_id_" + x + "'></td><td><section id='supplier_name_" + x + "'></section><input type='hidden' name='row_supplier_id[]' id='row_supplier_id_" + x + "'></td><td><select size='1' name='rack_id[]'><option value='0'><?= lang('select_one') ?></option>" + rack_list + "</select></td><td><input id='row_expire_date_" + x + "' name='row_expire_date[]' type='text' readonly='readonly'></td><input id='row_alert_date_" + x + "' name='row_alert_date[]' type='hidden' ><td><input type='text' class='change_val' name='row_qty[]' id='row_qty_" + x + "'></td><td><input type='text' id='row_purchase_price_" + x + "' name='row_purchase_price[]' class='change_val'></td><td><input type='text' class='change_val' id='row_sale_price_" + x + "' name='row_sale_price[]'></td><td><input id='row_batch_no_" + x + "' name='row_batch_no[]' type='hidden' readonly='readonly'><input id='row_total_price_" + x + "' name='row_total_price[]' type='text' readonly='readonly'></td><td><input id='row_total_sale_price_" + x + "' name='row_total_sale_price[]' type='text' readonly='readonly'></td><td><button class='btn btn-danger btn-xs' onclick='removeMore(" + x + ");'>X</button></td></tr>";

                            if (x < maxField) {
                                $('#mytable > tbody:last').append(fieldHTML);
                                //assign value in add more section start
                                $('#row_product_id_' + x).val(product_id);
                                $('#product_name_' + x).html(product_name);
                                $('#product_code_' + x).html(product_code);
                                $('#row_supplier_id_' + x).val(supplier_id);
                                $('#supplier_name_' + x).html(supplier_name);
                                $('#row_qty_' + x).val(quantity);
                                $('#row_purchase_price_' + x).val(purchase_price);
                                $('#row_sale_price_' + x).val(sale_price);
                                $('#row_total_price_'+x).val(quantity*purchase_price);
                                $('#row_total_sale_price_'+x).val(quantity*sale_price);
                                $('#row_expire_date_' + x).val(ExpiryDate);
                                $('#row_alert_date_' + x).val(AlertDate);
                                $('#row_batch_no_' + x).val(batch_no);
                                //assign value in add more section end
                                x++;
                                $('#add_submit').show();
                            }
                        }
                    }
                    sum_calculation();
                    $('#product_name').val('');
                    $('#supplier_name').val('0').change(); 
                    $('#product_list').val('');
                    $('#supplier_id').val('');
                    $('#quantity').val('');
                    $('#ExpiryDate').val('');
                    // $('#is_unq_barcode').val('');
                    $('#AlertDate').val('');
                    //add more section end

                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;

    });
    var $main = $('.main');
    var $ch = $('.checkGroup input[type="checkbox"]');

    $('.main').click(function () {
        $('#error_msg').html('');
        var length = $('.main:checked').length;
        if (length > 3) {
            $(this).prop('checked', false);
            $('#error_msg').html('Maximum three category allowed.');
        } else {
            var id = $(this).attr('id');
            if ($(this).prop('checked') == false) {
                $('.ch_' + id).prop('checked', false);
            } else {
                $('.ch_' + id).prop('checked', true);
            }
        }
        //$main.prop('checked', $(this).prop('checked'));
    });
    $('.child_value').click(function () {
        //alert($ch);
        $('#error_msg').html('');
        var id = $(this).attr('id');
        var lastItem = id.split("_").pop(-1);
        var length = $('.ch_' + lastItem + ':checked').length;
        $('.mn_' + lastItem).prop('checked', true);
        if (length < 1) {
            $('.mn_' + lastItem).prop('checked', false);
        }
        if (length == 1) {
            var length = $('.main:checked').length;
            if (length > 3) {
                $(this).prop('checked', false);
                $('.mn_' + lastItem).prop('checked', false);
                $('#error_msg').html('Maximum three category allowed.');
            }
        }
    });
    function sum_calculation(){
        var sum_qty=0;var sum_purchase=0;var sum_sale=0;var sum_total=0;var sum_total_sale_price=0;
        var sl=1;
        
        $('input[name^="row_product_id"]').each(function () {
            var id_f = $(this).attr('id');
            var div_id = id_f.split("_").pop(-1);
            var row_qty = $('#row_qty_' + div_id).val()*1;
            var row_purchase_price = $('#row_purchase_price_' + div_id).val()*1;
            var row_sale_price = $('#row_sale_price_' + div_id).val()*1;
            var row_total_price = $('#row_total_price_' + div_id).val()*1;
            var row_total_sale_price = $('#row_total_sale_price_' + div_id).val()*1;
            sum_qty += row_qty;
            sum_purchase += row_purchase_price;
            sum_sale += row_sale_price;
            sum_total += row_total_price;
            sum_total_sale_price += row_total_sale_price;
            $('#sl_' + div_id).html(sl);
            sl+=1;
        });
        $('#sum_row_qty').html(sum_qty); 
        $('#sum_row_purchase').html(sum_purchase); 
        $('#sum_row_sale').html(sum_sale); 
        $('#sum_row_total').html(sum_total); 
        $('#sum_row_sale_total').html(sum_total_sale_price);

    }
    $(document).on('input', '.change_val', function () {
        var m_id = this.id;
        var id = m_id.split('_').pop(-1);
        var qty = $("#row_qty_" + id).val()*1;
        var purchase_price = $("#row_purchase_price_" + id).val()*1;
        var sale_price = $('#row_sale_price_' + id).val()*1;
        $("#row_total_price_" + id).val(purchase_price*qty);
        $("#row_total_sale_price_" + id).val(sale_price*qty);
        sum_calculation();      
    });


</script>
