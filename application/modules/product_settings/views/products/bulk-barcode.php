<div class="content-w">
    <ul class="breadcrumb">
        <?php echo $this->breadcrumb->output(); ?>
    </ul>
    <div class="content-i">
        <div class="content-box">
            <div class="row">
                <div class="col-lg-12">
                    <div class="element-wrapper">
                        <div class="full-box element-box">
                            <h6 class="element-header">Bulk Barcode</h6>
                            <form id="barcodeSubmit"
                                  action="<?php echo base_url() . 'product_settings/products/proview_bulk_barcode'; ?>"
                                  method="post">
                                <div class="row">
                                    <div class="error" id="show_error"></div>
                                    <input type="hidden" name="store_value" id="store_value">
                                    <div class="">
                                        <input type="radio" name="type" id="type" value="1" checked> <label
                                                for="type">Products</label>
                                        <input type="radio" name="type" id="type1" value="2"> <label
                                                for="type1">Invoice</label>
                                    </div>
                                    <div class="col-md-4" id="sw_pro">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?= lang('product') ?> </label>
                                            <div class="col-sm-12">
                                                <select class="select2" data-live-search="true" id="product_id"
                                                        name="product_id">
                                                    <option value="" selected>Select One</option>
                                                    <?php foreach ($products as $Name): ?>
                                                        <option value="<?php echo $Name->product_id; ?>"><?php echo $Name->product_name . ' (' . $Name->product_code . ')'; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label id="product_id-error" class="error" for="product_id"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="sw_inv" style="display: none;">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for="">Invoince Type</label>
                                                <div class="col-sm-12">
                                                    <div class="row-fluid">
                                                        <select class="select2" data-live-search="true"
                                                                id="invoice_type"
                                                                name="invoice_type">
                                                            <option value=""
                                                                    selected><?= lang("select_one"); ?></option>
                                                            <option value="1"><?= lang("stock_in"); ?></option>
                                                            <option value="2"><?= lang("stock_receive"); ?></option>
                                                            <option value="3"><?= lang("purchase_receive"); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for="">Invoince No</label>
                                                <div class="col-sm-12">
                                                    <div class="row-fluid">
                                                        <input class="form-control" type="text" id="invoice_no"
                                                               name="invoice_no">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label" for="">Select store</label>
                                            <div class="col-sm-12">
                                                <div class="row-fluid">
                                                    <select class="select2" data-live-search="true" id="store_name"
                                                            name="store_name">
                                                        <option value="" selected>Select Store</option>
                                                        <?php foreach ($storeName as $sNameId => $sName): ?>
                                                            <option acpt="<?php echo $sName; ?>" value="<?php echo $sNameId; ?>"><?php echo $sName; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label id="store_name-error" class="error" for="store_name"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?= lang("barcode_size"); ?></label>
                                            <div class="col-sm-12">
                                                <div class="row-fluid">
                                                    <select class="select2" data-live-search="true" id="barcode_size"
                                                            name="barcode_size">
                                                        <option value="" selected><?= lang("select_one"); ?></option>
                                                        <option value="1">2.5 X 1.5</option>
                                                        <option value="2">1.5 X 1.0</option>

                                                    </select>
                                                    <label id="barcode_size-error" class="error"
                                                           for="barcode_size"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?= lang("paper_size"); ?></label>
                                            <div class="col-sm-12">
                                                <div class="row-fluid">
                                                    <select class="select2" data-live-search="true" id="paper_size"
                                                            name="paper_size">
                                                        <option value="" selected><?= lang("select_one"); ?></option>
                                                        <option value="1"><?= lang("paper_size-1"); ?></option>
                                                        <option value="2"><?= lang("paper_size-2"); ?></option>
                                                    </select>
                                                    <label id="paper_size-error" class="error" for="paper_size"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for="">Barcode Text</label>
                                            <div class="col-sm-12">
                                                <div class="row-fluid">
                                                    <textarea name="barcode_text" id="barcode_text"></textarea>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group row">
                                                <label for="ck_size">Font Size</label>
                                                <select id="ck_size" name="ck_size">
                                                    <option value="11">12 PX</option>
                                                    <option value="13">14 PX</option>
                                                    <option value="15">16 PX</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="checkbox" name="ck_shop" id="ck_shop" value="1"> <label
                                                for="ck_shop">Shop Name</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="ck_name" id="ck_name" value="1"> <label
                                                for="ck_name">Product Name</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="ck_code" id="ck_code" value="1"> <label
                                                for="ck_code">Product Code</label>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="checkbox" name="ck_cur" id="ck_cur" value="1"><label for="ck_cur">
                                            Currency</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="ck_attr" id="ck_attr" value="1"> <label
                                                for="ck_attr">Attributes</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="checkbox" name="ck_price" id="ck_price" value="1"><label
                                                for="ck_price">Price</label>

                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                        <button class="mr-2 mb-2 btn btn-primary btn-rounded right" id="appendProduct"
                                                type="button"><i class="fa fa-plus"></i> Add</button>
                                    </div>


                                </div>
                                <hr>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="product-table" class="table table-bordred table-striped">
                                            <thead>
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Batch</th>
                                                <th>Stock Date</th>
                                                <th>Attributes</th>
                                                <th>Qty</th>
                                                <th>Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <button id="barcodePreview" class="btn btn-primary btn-rounded right" type="submit">
                                        Preview Barcode
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="previewModal">
        <div class="modal-dialog" style="width: 74%;">
            <div class="modal-content">
                <div class="modal-body">
                    <h6 class="element-header col-md-10">Bulk Barcode Preview</h6>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="element-wrapper">
                                <div class="element-box full-box">
                                    <div class="row">
                                        <div class="printcontainer">
                                            <div id="previewContent"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <button id="printBulkBarcode" class="btn btn-primary right" type="submit">
                                                Print Bulk Barcode
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
    <script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("input[type='radio']").click(function () {
                var radioValue = $("input[name='type']:checked").val();
                if (radioValue == 1) {
                    $("#sw_inv").hide();
                    $("#sw_pro").show();
                } else {
                    $("#sw_inv").show();
                    $("#sw_pro").hide();
                }
            });
            $('#barcodeSubmit').validate({
                rules: {
                    "barcode_size": {
                        required: true
                    },
                    "paper_size": {
                        required: true
                    },
                    "paper_size": {
                        required: true
                    },
                    "store_name": {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    var barcode_size = $('select[name^="barcode_size"]').val();
                    var paper_size = $('select[name^="paper_size"]').val();
                    var barcode_text = $('#barcode_text').val();
                    var store_name = $('#store_name').val();
                    //alert(barcode_text);
                    $.ajax({
                        url: "<?php echo base_url() . 'product_settings/products/proview_bulk_barcode';?>",
                        type: "post",
                        data: $(form).serialize() + "&barcode_size=" + barcode_size + "&paper_size=" + paper_size+"&barcode_text="+barcode_text+"&store_name="+store_name,
                        success: function (response) {
                            $('#previewContent').html(response);
                            $('#previewModal').modal('show');
                        }
                    });
                }
            });

        });

        $(document).on('click', '#appendProduct', function () {
            $('#show_error').html('');
            var pId = $('#product_id :selected').val();
            var inv_type = $('#invoice_type :selected').val();
            var store_value=$('#store_name option:selected').attr('acpt');
            $('#store_value').val(store_value);
            var inv_no = $('#invoice_no').val();
            var storeId = $('#store_name').val();
            var type = $("input[name='type']:checked").val();
            if (type == 1 && pId != 0) {
                $.ajax({
                    url: '<?php echo site_url("product_settings/products/get_available_stocked_product");?>',
                    type: 'POST',
                    data: {pId: pId, storeId: storeId},
                })
                    .done(function (res) {
                        var trl = $("#product-table > tbody > tr").length;
                        if (trl != 0) {
                            $('#product-table tbody tr:nth-child(' + trl + ')').after(res);
                        } else {
                            $('#product-table tbody').html(res);
                        }
                        $('#product_name').val('');
                        $('#product_id').val('');
                    });
            } else if (type == 2 && inv_type != '' && inv_no != '') {
                $.ajax({
                    url: '<?php echo site_url("product_settings/products/get_available_invoice_stocked_product");?>',
                    type: 'POST',
                    data: {invType: inv_type, invNo: inv_no, storeId: storeId},
                })
                    .done(function (res) {
                        var trl = $("#product-table > tbody > tr").length;
                        if (trl != 0) {
                            $('#product-table tbody tr:nth-child(' + trl + ')').after(res);
                        } else {
                            $('#product-table tbody').html(res);
                        }
                        $('#product_name').val('');
                        $('#product_id').val('');
                    });
            } else {
                $('#show_error').html('Select all Fields.');
            }

        });


        $(document).on('click', '.removeItem', function () {
            $(this).closest("tr").remove();
        });

        $(document).on('click', '#printBulkBarcode', function () {

            $("#previewContent").print({
                globalStyles: false,
                mediaPrint: false,
                stylesheet: "<?= base_url(); ?>themes/default/css/barcode_print.css",
                iframe: false,
                noPrintSelector: ".avoid-this",
            });

            location.reload();

        });


    </script>