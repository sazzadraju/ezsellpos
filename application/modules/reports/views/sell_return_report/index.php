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
                <?php echo form_open_multipart('', array('id' => 'product', 'class' => 'cmxform')); ?>
                <div class="element-wrapper">
                    <div class="full-box element-box">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Report Type</label>
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <input id="invoice_view" onchange="change_type(this)" name="report_type" value="invoice" type="radio" checked>
                                            <label for="invoice_view">Invoice</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="summary_view" onchange="change_type(this)" name="report_type" value="summary" type="radio">
                                            <label for="summary_view">Summary</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('from_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group FromDate" id="DOB">
                                            <input class="form-control valid FromDate" aria-invalid="false" type="text"
                                                   name="FromDate" id="FromDate">
                                        <span class="input-group-addon"> 
                                        <!-- <input type="hidden" name="product_id" id="product_id"> -->
                                        <span id="FromDate-error" class="error" for="product_name"></span>
                                        <span class="glyphicon glyphicon-calendar"></span>  
                                       </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group ToDate" id="DOB">
                                            <input class="form-control valid ToDate" aria-invalid="false" type="text"
                                                   name="ToDate" id="ToDate">
                                        <span class="input-group-addon">  
                                        <span id="ToDate-error" class="error" for="product_name"></span>
                                       <span class="glyphicon glyphicon-calendar"></span>  
                                       </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="show_product_list" style="display: none;">
                                <div class="col-md-3 col-sm-12" >
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang("product_code_name"); ?></label>
                                        <div class="col-sm-12">
                                            <select class="select2" data-live-search="true" id="product_name"
                                                    name="product_name">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($products as $product) {
                                                    echo '<option actp="' . $product->product_name . '" value="' . $product->id_product . '">' . $product->product_name . '(' . $product->product_code . ')' . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang("batch_no"); ?></label>
                                        <div class="col-sm-12">
                                            <input type="text" name="batch_no" id="batch_no" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang("brands"); ?></label>
                                        <div class="col-sm-12">

                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" id="brand" name="brand">
                                                    <option value="0" selected><?= lang("select_one"); ?></option>
                                                    <?php
                                                    foreach ($brands as $brand) {
                                                        // if (empty($station->_id_station)) {
                                                        echo '<option value="' . $brand->id_product_brand . '">' . $brand->brand_name . '</option>';
                                                        // }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("invoice_no"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="invoice_no" name="invoice_no"
                                               placeholder="<?= lang("invoice_no"); ?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("store"); ?></label>
                                    <div class="col-sm-12">
                                        <!-- <div class="row-fluid"> -->
                                        <select class="select2" data-live-search="true" id="store_id" name="store_id"
                                                onchange="getStation(this.value);">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($stores as $store) {
                                                // if (empty($station->_id_station)) {
                                                echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                // }
                                            }

                                            ?>
                                        </select>
                                    </div>

                                    <!-- </div> -->
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("customer_name"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="customer_id"
                                                    name="customer_id">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($customers as $customer) {
                                                    if (empty($customer->_id_customer)) {
                                                        echo '<option value="' . $customer->id_customer . '">' . $customer->full_name . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                    class="fa fa-search"></i> <?= lang("search"); ?></button>
                            <button class="btn btn-primary pull-right" type="button" onclick="print_view()"><i class="fa fa-view"></i><?= lang("print-view"); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>


                    <!-- body view from here -->
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang("invoice_no"); ?></th>
                                        <th><?= lang("sold_date"); ?></th>
                                        <th><?= lang("invoice_amount"); ?></th>
                                        <th><?= lang("received_by"); ?></th>
                                        <th><?= lang("customer_name"); ?></th>
                                        <th><?= lang("station_name"); ?></th>
                                        <th><?= lang("store_name"); ?></th>
                                        <th class="center"><?= lang("view"); ?></th>
                                        </thead>


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

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>
<script>

    function change_type(el){
        var id=el.value;
        if(id=='summary'){
            $('#show_product_list').show();
        }else{
            $('#show_product_list').hide();
        }
    }


    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var report_type = $('[name^="report_type"]:checked').val();
        var product_id = $('#product_name option:selected').val();
        var invoice_no = $('#invoice_no').val();
        var station_id = $('#station_id').val();
        var store_id = $('#store_id').val();
        var customer_id = $('#customer_id').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var brand = $('#brand').val();
        var uid_add = $('#uid_add').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var batch_no = $('#batch_no').val();
        var brand = $('#brand').val();
        $err_count = 1;
        $('#FromDate-error').html("");
        $('#ToDate-error').html("");
        if (FromDate == '') {
            $err_count = 2;
            $('#FromDate-error').html("Please fill start Date");
        }
        if (ToDate == '') {
            $err_count = 2;
            $('#ToDate-error').html("Please fill end Date");
        }

        if ($err_count == 1) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>sell-return-report/page_data/' + page_num,
                data: 'page=' + page_num + '&invoice_no=' + invoice_no + '&store_id=' + store_id + '&customer_id=' + customer_id + '&uid_add=' + uid_add + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&cat_name=' + cat_name + '&pro_sub_category=' + pro_sub_category + '&brand=' + brand+ '&report_type=' + report_type+ '&product_id=' + product_id+ '&batch_no=' + batch_no+ '&brand=' + brand,
                // beforeSend: function () {
                //     $('.loading').show();
                // },
                success: function (html) {
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
            });
        }
    }

    $(function () {
        $('.FromDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });
    $(function () {
        $('.ToDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });
    // function print_page() {

    //     $this->load->view('products/stock-in-report');
    // }
    function print_view() {
        var report_type = $('[name^="report_type"]:checked').val();
        var product_id = $('#product_name option:selected').val();
        var invoice_no = $('#invoice_no').val();
        var station_id = $('#station_id').val();
        var store_id = $('#store_id').val();
        var customer_id = $('#customer_id').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var brand = $('#brand').val();
        var uid_add = $('#uid_add').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var batch_no = $('#batch_no').val();
        var brand = $('#brand').val();
        $err_count = 1;
        $('#FromDate-error').html("");
        $('#ToDate-error').html("");
        if (FromDate == '') {
            $err_count = 2;
            $('#FromDate-error').html("Please fill start Date");
        }
        if (ToDate == '') {
            $err_count = 2;
            $('#ToDate-error').html("Please fill end Date");
        }

        if ($err_count == 1) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>reports/sell_return_report/print_data',
                data: 'invoice_no=' + invoice_no + '&store_id=' + store_id + '&customer_id=' + customer_id + '&uid_add=' + uid_add + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&cat_name=' + cat_name + '&pro_sub_category=' + pro_sub_category + '&brand=' + brand+ '&report_type=' + report_type+ '&product_id=' + product_id+ '&batch_no=' + batch_no+ '&brand=' + brand,
                // beforeSend: function () {
                //     $('.loading').show();
                // },
                success: function (html) {
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
            });
        }
    }
    function getStation(val) {
        // alert(val);
        $.ajax({
            type: "POST",
            url: "get_station_name",
            data: 'store_id=' + val,
            success: function (data) {
                $("#station_id").html(data);
            }
        });
    }


</script> 
