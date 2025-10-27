<style>
    #mytable input {
        width: 90px;
    }

    table tr td {
        padding: 4px !important;
    }

    ul.validation_alert {
        list-style: none;
    }

    ul.validation_alert li {
        padding: 5px 0;
    }

    .focus_error {
        border: 1px solid red;
        background: #ffe6e6;
    }

    .span_error {
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
                                <a href="<?php echo base_url(); ?>stock_transfer"
                                   class="btn btn-primary btn-rounded right margin-right-10"
                                   type="button"><?= lang('stock_transfer_list') ?></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <input id="ProductSearch" name="acc_type" value="Yes" type="radio" checked="">
                                <label for="ProductSearch">Product Search</label>
                            </div>
                            <div class="col-sm-4">
                                <input id="BarCode" name="acc_type" value="No" type="radio">
                                <label for="BarCode">Using Barcode</label>
                            </div>
                            <input type="hidden" id="store_from">
                        </div>
                        <div class="row" id="barcodeDiv" style="display: none;">
                            <form class="form-horizontal" role="form" id="enter_stock_to_cart" action="" method="POST"
                                  enctype="multipart/form-data">
                                <div class="col-lg-4">
                                    <label class="col-sm-12 col-form-label">Barcode</label>
                                    <input type="text" name="barcode_name" id="barcode_name">
                                    <div class="error" id="barcode-error"></div>
                                </div>
                                <div class="col-lg-1">
                                    <label class="col-sm-12 col-form-label">&nbsp;</label>
                                    <input  class="btn btn-info" type="submit" value="Add">
                                </div>
                            </form>
                        </div>
                        <div class="row" id="searchDiv">
                            <!--Hidden field value start-->
                            <!-- <input type="hidden" id="store_from"> -->
                            <input type="hidden" id="purchase_price">
                            <input type="hidden" id="sale_price">
                            <input type="hidden" id="stock_rack_name">
                            <input type="hidden" id="id_stock">
                            <input type="hidden" id="alert_date">
                            <input type="hidden" id="rack_id">
                            <input type="hidden" id="store_id">
                            <input type="hidden" id="product_code">
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('product') ?> </label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="product_name"
                                                onchange="product_list_suggest()"
                                                name="product_name">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($products as $product) {
                                                echo '<option actp="' . $product->product_name . '" value="' . $product->id_product . '">' . $product->product_name . '(' . $product->product_code . ')' . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <label id="product_name-error" class="error" for="product_name3"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang('batch_no') ?> </label>
                                    <div class="col-sm-12">

                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" name="stock_batch_no"
                                                    id="stock_batch_no" onchange="get_stock_details(this);">

                                            </select>
                                        </div>
                                        <label id="stock_batch_no-error" class="error"></label>
                                        <input type="hidden" id="sel_batch_no" value="">
                                        <input type="hidden" id="sel_attr" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"
                                           for=""><?php echo lang('supplier') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="supplier_name" id="supplier_name"
                                               readonly="readonly">
                                        <input type="hidden" name="supplier_id" id="supplier_id">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('quantity') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="quantity" id="quantity"
                                               readonly="readonly">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"
                                           for=""><?= lang('expiration_date') ?> </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="ExpiryDate" name="expire_date"
                                               readonly="readonly">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"
                                           for=""><?= lang('stck_transfer_qty') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="stck_out_qty" id="stck_out_qty">
                                        <span id="stck_out_qty-error" class="span_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <input type="hidden" name="show_column" id="show_column" value="<?= $columns[0]->permission?>">
                                <input type="hidden" name="user_type" id="user_type" value="<?= $this->session->userdata['login_info']['user_type_i92']?>">

                                <label class="col-sm-12 col-form-label">&nbsp;</label>
                                <button class="btn btn-info" onclick="add_stock_cart();"><i class="fa fa-plus"></i>
                                </button>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span id="div_error" class="error"></span>
                            </div>
                        </div>
                    </div>

                    <form class="form-horizontal" role="form" id="enter_stock_out" action="" method="POST"
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
                                                <th rowspan="2"><?= lang('serial') ?></th>
                                                <th rowspan="2"><?= lang('product') ?></th>
                                                <th rowspan="2"><?= lang('supplier') ?></th>
                                                <th rowspan="2"><?= lang('expiration_date') ?></th>
                                                <th rowspan="2"><?= lang('batch') ?></th>
                                                <th rowspan="2"><?= lang('qty') ?></th>
                                                <th colspan="2" class="text-center"><?= lang('price') ?></th>
                                                <th rowspan="2"><?= lang('stck_transfer_qty') ?></th>
                                                <th  colspan="2" class="text-center"><?= lang('total') ?></th>
                                            </tr>
                                            <tr>
                                                <th><?= lang('purchase') ?></th>
                                                <th><?= lang('sale') ?></th>
                                                <th><?= lang('purchase') ?></th>
                                                <th><?= lang('sale') ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="8" class="text-right"><?= lang('total') ?></th>
                                                    <th id="sum_row_qty"></th>
                                                    <th id="sum_row_purchase"></th>
                                                    <th id="sum_row_sale"></th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="top-btn full-box">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang('stock_transfer_date') ?></label>
                                        <div class='col-sm-12'>
                                            <div class='input-group date' id='StockOutDate'>
                                                <input type='text' class="form-control" name="dtt_stock_mvt"
                                                       value="<?php echo date('Y-m-d'); ?>"/>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>												
												</span>
                                            </div>
                                            <span id="StockOutDate-error" class="span_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label" for=""><?= lang('store_from') ?></label>
                                            <div class='col-sm-12'>
                                                <input class="form-control" type="text" name="from" id="from" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('store_to') ?></label>
                                        <div class="col-sm-12">

                                            <div class="row-fluid">
                                                <select class="form-control" name="to_store_name" id="to_store">
                                                    <option value="0"><?= lang('select_one') ?></option>
                                                    <?php
                                                    if (!empty($stores)) {
                                                        foreach ($stores as $list) {
                                                            ?>
                                                            <option value="<?php echo $list->id_store; ?>"><?php echo $list->store_name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <label id="to_store-error" class="error"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 form-group">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?= lang('stck_transfer_doc') ?></label>
                                            <div class='col-sm-12'>
                                                <input type="file" name="stock_out_doc" id="stock_out_doc">
                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
                                                <span class="span_error" id="file_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('invoice_no') ?></label>
                                        <div class='col-sm-12'>
                                            <input class="form-control" type="text" id="invoice_no" name="invoice_no" value="<?php echo $invoice_id; ?>"
                                                   onkeyup="check_invoice_number(this);">
                                            <input type="hidden" name="default_invoice_no" id="default_invoice_no"
                                                   value="<?php echo $invoice_id; ?>">
                                            <span id="invoice_no-error" class="span_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang('stck_transfer_reason') ?></label>
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
<div id="StoreNameForm" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Select Store name for transfer </h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang("store_name"); ?></label>
                                <div class="col-sm-12">
                                    <div class="row-fluid">
                                        <select class="select2" id="store_name" name="store_name"
                                                onchange="store_from_name(this.value)">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($stores as $store) {
                                                if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                                    echo '<option value="' . $store->id_store . '@'.$store->store_name.'">' . $store->store_name . '</option>';
                                                } else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
                                                    echo '<option value="' . $store->id_store . '@'.$store->store_name.'" selected>' . $store->store_name . '</option>';
                                                }

                                            }
                                            ?>
                                        </select>
                                        <label class="error" id="select_error"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="checkSelect()">OK</button>
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
                        <li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('stock_transfer_val_msg') ?>
                        </li>
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
    var toStoreOptions = '';
    var productListUrl = '<?php echo base_url(); ?>product_stock_list';
    $(document).ready(function () {
        toStoreOptions = $('#to_store').html();
        var id="<?= $this->session->userdata['login_info']['user_type_i92']?>";
        if(id==3){
            $('#StoreNameForm').modal('toggle');
        }else{
            var str_id="<?= $this->session->userdata['login_info']['store_name']?>";
            var val_id = str_id.split('&')[1];
            var val_data = str_id.split('&')[0];
            $('#store_from').val(val_id);
            $('#from').val(val_data);
            resetToStoreOptions(val_id);
            loadStoreProducts(val_id);
        }
    });
    $('input[name=acc_type]').click(function(){
        var section = $('input:radio[name="acc_type"]:checked').val();
        if(section=='No'){
            $('#barcodeDiv').show();
            $('#searchDiv').hide();
        }else{
            $('#searchDiv').show();
            $('#barcodeDiv').hide();
        }
    });
    $("#enter_stock_to_cart").submit(function () {
        $('#div_error').html('');
        $('#barcode-error').html('');
        var $html = '';
        var dataString = new FormData($(this)[0]);
        var type = $('input:radio[name="acc_type"]:checked').val();
        var batch_no = $("input[name='row_batch_no[]']").map(function(){return $(this).val();}).get();
        var product_id = $("input[name='row_product_id[]']").map(function(){return $(this).val();}).get();
        var row_qty = $("input[name='row_stock_out_qty[]']").map(function(){return $(this).val();}).get();
        dataString.append('acc_type', type);
        dataString.append('row_qty', row_qty);
        dataString.append('store_name', $('#store_from').val());
        dataString.append('batch_no', batch_no);
        dataString.append('product_id', product_id);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>stock/stock_transfer/temp_add_cart_for_barcode',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                $('.loading').fadeOut("slow");
                if(result!='') {
                    var product = $.parseJSON(result);
                    if (product.status == 1||product.status == 2) {
                        if (product.status == '1') {
                            $('#div_error').html('Stock quantity not available..');
                        } else {
                            $("input[name='row_product_id[]']").each(function () {
                                id_value = $(this).val();
                                var id_full = $(this).attr('id');
                                id = id_full.split("_").pop(-1);
                                batch_value = $('#row_batch_no_' + id).val();
                                if ((id_value == product.data['id_product']) && (product.data['batch_no'] == batch_value)) {
                                    var qty = $('#row_stock_out_qty_' + id).val() * 1;
                                    qty = qty + 1;
                                    $('#row_stock_out_qty_' + id).val(qty);

                                }
                            });
                        }

                    }else if(product.status == 3){
                        $('#barcode-error').html(product.message);

                    } else {
                        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
                        $('input[name="total_num_of_fields"]').val(total_fields + 1);
                        var maxField = x * 1 + 1;
                        var addButton = $('#add_more');
                        //var wrapper = $('#add_more_section');
                        var fieldHTML = "<tr id='" + x + "'><td id='sl_" + x + "'></td><input type='hidden' name='row_id_stock[]' id='row_id_stock_" + x + "'><td><section id='product_name_" + x + "'></section><section id='product_code_"+x+"'></section><section id='product_attr_"+x+"'></section><section id='product_code_" + x + "'></section><input type='hidden' name='row_product_id[]' id='row_product_id_" + x + "'></td><td><section id='supplier_name_" + x + "'></section><input type='hidden' name='row_supplier_id[]' id='row_supplier_id_" + x + "'></td><td><input type='hidden' id='row_rack_name_" + x + "' name='row_rack_name[]' readonly='readonly'><input type='hidden' id='row_rack_id_" + x + "' name='row_rack_id[]'><input id='row_expire_date_" + x + "' name='row_expire_date[]' type='text' readonly='readonly'><input id='row_alert_date_" + x + "' name='row_alert_date[]' type='hidden'></td><td><input id='row_batch_no_" + x + "' name='row_batch_no[]' type='text' readonly='readonly'></td><td><input type='text' name='row_qty[]' id='row_qty_" + x + "' readonly='readonly'></td><td><input type='text' id='row_purchase_price_" + x + "' name='row_purchase_price[]' readonly='readonly'></td><td><input type='text' id='row_sale_price_" + x + "' name='row_sale_price[]' readonly='readonly'></td><td><input class='change_val' id='row_stock_out_qty_" + x + "' name='row_stock_out_qty[]' type='text'></td><td><input id='row_sum_purchase_" + x + "' name='row_sum_purchase[]' type='text' readonly='readonly'></td><td><input id='row_sum_sale_" + x + "' name='row_sum_sale[]' type='text' readonly='readonly'></td><td><button class='btn btn-danger btn-xs' onclick='removeMore(" + x + ");'>X</button></td></tr>";

                        if (x < maxField) {
                            $('#mytable > tbody:last').append(fieldHTML);
                            //assign value in add more section start
                            $('#row_id_stock_' + x).val(product.data[0].id_stock);
                            $('#row_product_id_' + x).val(product.data[0].id_product);
                            $('#product_name_' + x).html(product.data[0].product_name);
                            $('#product_attr_'+x).html(product.data[0].attribute_name);
                            $('#product_code_' + x).html(product.data[0].product_code);
                            $('#row_supplier_id_' + x).val(product.data[0].supplier_id);
                            $('#supplier_name_' + x).html(product.data[0].supplier_name);
                            $('#row_qty_' + x).val(product.data[0].qty);
                            $('#row_purchase_price_' + x).val(product.data[0].purchase_price);
                            $('#row_sale_price_' + x).val(product.data[0].selling_price_act);
                            $('#row_rack_name_' + x).val('');
                            $('#row_rack_id_' + x).val(product.data[0].rack_id);
                            $('#row_expire_date_' + x).val(product.data[0].expire_date);
                            $('#row_alert_date_' + x).val(product.data[0].alert_date);
                            $('#row_batch_no_' + x).val(product.data[0].batch_no);
                            $('#row_stock_out_qty_' + x).val(1);
                            $('#row_sum_purchase_' + x).val(product.data[0].purchase_price);
                            $('#row_sum_sale_' + x).val(product.data[0].selling_price_act);

                            //assign value in add more section end
                            x++;
                            sum_calculation();
                        }
                    }
                }
                $('#barcode_name').val('');

            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    function store_from_name(id) {
        var val_id = id.split('@')[0];
        var val_data = id.split('@')[1];
        $('#store_from').val(val_id);
        $('#from').val(val_data);
        resetToStoreOptions(val_id);
        resetProductDependentFields();
        loadStoreProducts(val_id);
    }
    function checkSelect() {
        var store = $('#store_name').val();
        if (store == '0') {
            $('#select_error').html('Select any one');
        }
        else {
            $('#StoreNameForm').modal('hide');
        }


    }

    function resetToStoreOptions(val_id) {
        if (toStoreOptions !== '') {
            $('#to_store').html(toStoreOptions);
        }
        $('#to_store').val('0');
        if (val_id !== undefined && val_id !== null && val_id !== '') {
            $("#to_store option[value='"+val_id+"']").remove();
        }
        $('#to_store').trigger('change.select2');
    }

    function resetProductDependentFields() {
        $('#product_name').html("<option value='0' selected><?= lang('select_one'); ?></option>");
        $('#product_name').val('0');
        $('#product_name').trigger('change.select2');
        $('#product_id').val('');
        $('#stock_batch_no').html('');
        $('#supplier_name').val('');
        $('#supplier_id').val('');
        $('#quantity').val('');
        $('#ExpiryDate').val('');
        $('#stck_out_qty').val('');
        $("#purchase_price").val('');
        $("#sale_price").val('');
        $("#stock_rack_name").val('');
        $('#rack_id').val('');
        $('#store_id').val('');
        $('#alert_date').val('');
        $('#sel_attr').val('');
        $('#sel_batch_no').val('');
    }

    function loadStoreProducts(storeId) {
        if (storeId === undefined || storeId === null || storeId === '' || storeId === '0') {
            return;
        }
        $.ajax({
            type: 'POST',
            url: productListUrl,
            data: {id: storeId},
            success: function (result) {
                var $productSelect = $('#product_name');
                $productSelect.empty();
                var defaultOption = $('<option/>', {
                    value: '0',
                    text: '<?= lang('select_one'); ?>'
                });
                defaultOption.prop('selected', true);
                $productSelect.append(defaultOption);
                if (result) {
                    try {
                        var products = $.parseJSON(result);
                        $.each(products, function (index, item) {
                            if (item.id_product !== undefined) {
                                var option = $('<option/>', {
                                    value: item.id_product,
                                    text: item.product_name + '(' + item.product_code + ')'
                                }).attr('actp', item.product_name);
                                $productSelect.append(option);
                            }
                        });
                    } catch (e) {
                        console.error('Failed to parse product list', e);
                    }
                }
                $productSelect.val('0');
                $productSelect.trigger('change.select2');
            }
        });
    }


    function add_stock_cart() {
        if (validateStockCart() != false) {
            //get value from field start
            var id_stock = $('#id_stock').val();
            var show_column = $('#show_column').val();
            var user_type = $('#user_type').val();
            var product_name = $('#product_name option:selected').attr('actp');
            var product_code = $('#product_code').val();
            var stock_batch_no_val = $('#stock_batch_no').val();
            var stock_batch_no = $('#sel_batch_no').val();
            var stock_attr = $('#sel_attr').val();
            var supplier_name = $('#supplier_name').val();
            var quantity = $('#quantity').val();
            var ExpiryDate = $('#ExpiryDate').val();
            var stck_out_qty = $('#stck_out_qty').val()*1;
            var purchase_price = $("#purchase_price").val()*1;
            var sale_price = $("#sale_price").val()*1;
            var stock_rack_name = $("#stock_rack_name").val();
            var product_id = $('#product_name option:selected').val();
            var supplier_id = $('#supplier_id').val();
            var rack_id = $('#rack_id').val();
            var store_id = $('#store_id').val();
            var alert_date = $('#alert_date').val();
            var attribute=stock_attr.replace(/\,/g, "<br>");
            //add more section start
            var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
            $('input[name="total_num_of_fields"]').val(total_fields + 1);
            var maxField = x * 1 + 1;
            var addButton = $('#add_more');
            //var wrapper = $('#add_more_section');
            var show=(show_column==1||user_type==3)?'text':'hidden';
            var fieldHTML = "<tr id='" + x + "'><td id='sl_" + x + "'></td><input type='hidden' name='row_id_stock[]' id='row_id_stock_" + x + "'><td><section id='product_name_" + x + "'></section><section id='product_attr_"+x+"'></section><section id='product_code_" + x + "'></section><input type='hidden' name='row_product_id[]' id='row_product_id_" + x + "'></td><td><section id='supplier_name_" + x + "'></section><input type='hidden' name='row_supplier_id[]' id='row_supplier_id_" + x + "'></td><td><input type='hidden' id='row_rack_name_" + x + "' name='row_rack_name[]' readonly='readonly'><input type='hidden' id='row_rack_id_" + x + "' name='row_rack_id[]'><input id='row_expire_date_" + x + "' name='row_expire_date[]' type='text' readonly='readonly'><input id='row_alert_date_" + x + "' name='row_alert_date[]' type='hidden'></td><td><input id='row_batch_no_" + x + "' name='row_batch_no[]' type='text' readonly='readonly'></td><td><input type='text' name='row_qty[]' id='row_qty_" + x + "' readonly='readonly'></td><td><input type='text' id='row_purchase_price_" + x + "' name='row_purchase_price[]' readonly='readonly'></td><td><input type='text' id='row_sale_price_" + x + "' name='row_sale_price[]' readonly='readonly'></td><td><input id='row_stock_out_qty_" + x + "' name='row_stock_out_qty[]' type='text' class='change_val'></td><td><input id='row_sum_purchase_" + x + "' name='row_sum_purchase[]' readonly='readonly' type='text'></td><td><input readonly='readonly' id='row_sum_sale_" + x + "' name='row_sum_sale[]' type='text'></td><td><button class='btn btn-danger btn-xs' onclick='removeMore(" + x + ");'>X</button></td></tr>";

            if (x < maxField) {
                $('#mytable > tbody:last').append(fieldHTML);
                //assign value in add more section start
                $('#row_id_stock_' + x).val(id_stock);
                $('#row_product_id_' + x).val(product_id);
                $('#product_name_' + x).html(product_name);
                $('#product_code_' + x).html(product_code);
                $('#product_attr_'+x).html(attribute);
                $('#row_supplier_id_' + x).val(supplier_id);
                $('#supplier_name_' + x).html(supplier_name);
                $('#row_qty_' + x).val(quantity);
                $('#row_purchase_price_' + x).val(purchase_price);
                $('#row_sale_price_' + x).val(sale_price);
                $('#row_rack_name_' + x).val(stock_rack_name);
                $('#row_rack_id_' + x).val(rack_id);
                $('#row_expire_date_' + x).val(ExpiryDate);
                $('#row_alert_date_' + x).val(alert_date);
                $('#row_batch_no_' + x).val(stock_batch_no);
                $('#row_stock_out_qty_' + x).val(stck_out_qty);
                $('#row_sum_purchase_' + x).val(purchase_price*stck_out_qty);
                $('#row_sum_sale_' + x).val(sale_price*stck_out_qty);
                sum_calculation();
                x++;
            }

            $('#id_stock').val('');
            $('#product_name').val('0').change();
            $('#supplier_name').val('');
            $('#product_code').val('');
            $('#quantity').val('');
            $('#ExpiryDate').val('');
            $('#stck_out_qty').val('');
            $("#purchase_price").val('');
            $("#sale_price").val('');
            $("#stock_rack_name").val('');
            $('#product_id').val('');
            $('#supplier_id').val('');
            $('#rack_id').val('');
            $('#store_id').val('');
            $('#alert_date').val('');
            $('#sel_attr').val('');
            $('#sel_batch_no').val('');
            $('#stock_batch_no').html('');
            //add more section end

        } else {
            return false;
        }

    }

    function removeMore(id) {
        $("#" + id).remove();
        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
        $('input[name="total_num_of_fields"]').val(total_fields - 1);
        sum_calculation();  
    }

    function validateStockCart() {
        var product_id = $('#product_id').val();
        var stock_batch_no = $('#stock_batch_no').val();
        var stck_out_qty = $('#stck_out_qty').val();
        var quantity = $('#quantity').val();
        quantity = Math.floor(quantity);

        if (product_id == "" || stock_batch_no == "" || stck_out_qty == "" || product_id === null || stock_batch_no === null || stck_out_qty === null || stock_batch_no == 0 || quantity < stck_out_qty) {
            $('#product_name-error').html("");
            $('#stock_batch_no-error').html("");
            $('#stck_out_qty-error').html("");

            if (product_id == "" || product_id === null) {
                $('#product_name-error').html("<?php echo lang('must_not_be_empty');?>");
                setTimeout(function () {
                    $('#product_name-error').html("");
                }, 2000);
            }

            if (stock_batch_no == "" || stock_batch_no == 0 || stock_batch_no === null) {
                $('#stock_batch_no-error').html("<?php echo lang('select_one');?>");
                setTimeout(function () {
                    $('#stock_batch_no-error').html("");
                }, 2000);
            }

            if (stck_out_qty == "" || stck_out_qty === null) {
                $('#stck_out_qty-error').html("<?php echo lang('must_not_be_empty');?>");
                setTimeout(function () {
                    $('#stck_out_qty-error').html("");
                }, 2000);
            } else if (!($.isNumeric(stck_out_qty))) {
                $('#stck_out_qty-error').html("<?php echo lang('must_be_number');?>");
                setTimeout(function () {
                    $('#stck_out_qty-error').html("");
                }, 2000);
            }

            if (quantity < stck_out_qty) {
                $('#stck_out_qty-error').html("<?php echo lang('stck_trnsfr_qty_validate_msg');?>");
                setTimeout(function () {
                    $('#stck_out_qty-error').html("");
                }, 2000);
            }

            return false;
        } else {
            $('#product_name-error').html("");
            $('#stock_batch_no-error').html("");
            $('#stck_out_qty-error').html("");
            return true;
        }
    }

    function product_list_suggest(elem) {
        var product_id = $('#product_name option:selected').val();
        var store_from = $('#store_from').val();
        if (store_from == '') {
            $('#product_name-error').html('Select Store first');
        }
        else
        {
            if (product_id !== "0") {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url();?>get_stock_transfer_by_product_id',
                    data: {
                        product_id: product_id,
                        store_id: store_from
                    },
                    success: function (result) {
                        //console.log(result);
                        //alert(result);
                        var result = $.parseJSON(result);
                        var html = "<option value='0' selected><?= lang('select_one')?></option>";
                        var total_num_of_fields= $('#total_num_of_fields').val()*1;
                        for (var i = 0; i < result.length; i++) {
                        	var attr_val=(result[i].attribute_name=='null')?'':result[i].attribute_name;
                            if (total_num_of_fields != 0) {
                                var cnt=1;
                                for (var k=1;k <= total_num_of_fields;k++) {
                                  var tbl_row_id = $('#row_id_stock_'+k).val();
                                  if(tbl_row_id == result[i].id_stock){
                                    cnt=2;
                                  }
                                }
                                if(cnt==1){
                                    html += "<option actp='"+attr_val+"' value = '"+result[i].id_stock+"'>"+result[i].batch_no+"("+attr_val+")</option>";
                                }
                            } else {
                                html += "<option actp='"+attr_val+"' value = '"+result[i].id_stock+"'>"+result[i].batch_no+"("+attr_val+")</option>";
                            }
                        }
                        $('#stock_batch_no').html(html);

                    }
                });
            }
        }


    }


    function get_stock_details(elem) {
        var stock_id = $(elem).val();
        var attr = $('option:selected', elem).attr('actp');
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
                    $('#stock_rack_name').val(result[0].name);
                    $('#id_stock').val(result[0].id_stock);
                    $('#product_id').val(result[0].product_id);
                    $('#supplier_id').val(result[0].supplier_id);
                    $('#rack_id').val(result[0].rack_id);
                    $('#alert_date').val(result[0].alert_date);
                    $('#store_id').val(result[0].store_id);
                    $('#sel_batch_no').val(result[0].batch_no);
                    $('#product_code').val(result[0].product_code);
                    $('#sel_attr').val(attr);
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

    function validate_stock_out_enter() {
        var dtt_stock_mvt = $("input[name=dtt_stock_mvt]").val();
        var invoice_no = $('#invoice_no').val();
        var store = $('#to_store').val();
        var stock_validate =0;
        $("input[name='row_product_id[]']").each(function () {
            var id_full = $(this).attr('id');
            var b = id_full.split("_").pop(-1);
            var qty = $('#row_qty_' + b).val();
            qty = Math.floor(qty);
            var stock_out_qty = $('#row_stock_out_qty_' + b).val();
            stock_out_qty = Math.floor(stock_out_qty);

            $('#row_stock_out_qty_' + b).removeClass('focus_error');
            if (stock_out_qty == "" || qty < stock_out_qty || !($.isNumeric(stock_out_qty))) {

                stock_validate = 1;
                if (stock_out_qty == "") {
                    $('#row_stock_out_qty_' + b).addClass('focus_error');
                } else if (!($.isNumeric(stock_out_qty))) {
                    $('#row_stock_out_qty_' + b).val('');
                    $('#row_stock_out_qty_' + b).addClass('focus_error');
                }

                if (qty < stock_out_qty) {
                    $('#row_stock_out_qty_' + b).addClass('focus_error');
                }
            }
        });

        var file_er=1;
        var file=$('#stock_out_doc').val();
        if(file!=''){
            var ext = $('#stock_out_doc').val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['gif','png','jpg','jpeg','pdf','xls','xlsx','doc','docx']) == -1) {
                file_er=0;
            }
        }
        if (stock_validate == 1 || dtt_stock_mvt == "" || invoice_no == "" || store == "" || store == 0||file_er==0) {

            if (stock_validate == 1) {
                $('#validateAlert').modal('toggle');
            }

            if (dtt_stock_mvt == "") {
                $('#StockOutDate-error').html("<?php echo lang('must_not_be_empty');?>");
                setTimeout(function () {
                    $('#StockOutDate-error').html('');
                }, 3000);
            }

            if (invoice_no == "") {
                $('#invoice_no-error').html("<?php echo lang('must_not_be_empty');?>");
                setTimeout(function () {
                    $('#invoice_no-error').html('');
                }, 3000);
            }

            if (store == "" || store == 0) {
                $('#to_store-error').html("<?php echo lang('select_one');?>");
                setTimeout(function () {
                    $('#to_store-error').html('');
                }, 3000);
            }
            if (file_er == 0) {
                $('#file_error').html('Invoice select file type');
            }
            return false;
        } else {
            return true;
        }

    }

    $("#enter_stock_out").submit(function () {
        if (validate_stock_out_enter() != false) {
            var from=$('#store_from').val();
            var dataString = new FormData($(this)[0]);
            dataString.append('store_from',from);
            //console.log(dataString);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>stock_transfer_insert',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    var result = $.parseJSON(result);
                    console.log(result);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');
                        });
                        $('.loading').fadeOut("slow");
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>stock_transfer";

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
    function sum_calculation(){
        var sum_qty=0;var sum_purchase=0;var sum_sale=0;var sum_total=0;
        var sl=1;
        
        $('input[name^="row_product_id"]').each(function () {
            var id_f = $(this).attr('id');
            var div_id = id_f.split("_").pop(-1);
            var row_qty = $('#row_stock_out_qty_' + div_id).val()*1;
            var row_purchase_price = $('#row_sum_purchase_' + div_id).val()*1;
            var row_sale_price = $('#row_sum_sale_' + div_id).val()*1;
            //var row_total_price = $('#row_total_price_' + div_id).val()*1;
            sum_qty += row_qty;
            sum_purchase += row_purchase_price;
            sum_sale += row_sale_price;
            //sum_total += row_total_price;
            $('#sl_' + div_id).html(sl);
            sl+=1;
        });
        $('#sum_row_qty').html(sum_qty); 
        $('#sum_row_purchase').html(sum_purchase); 
        $('#sum_row_sale').html(sum_sale); 
        //$('#sum_row_total').html(sum_total); 
    }
    $(document).on('input', '.change_val', function () {
        var m_id = this.id;
        var id = m_id.split('_').pop(-1);
        var qty = $("#row_stock_out_qty_" + id).val()*1;
        var purchase_price = $("#row_purchase_price_" + id).val()*1;
        var sale_price = $("#row_sale_price_" + id).val()*1;
        $("#row_sum_purchase_" + id).val(purchase_price*qty);
         $("#row_sum_sale_" + id).val(sale_price*qty);
        sum_calculation();      
    });

</script>
