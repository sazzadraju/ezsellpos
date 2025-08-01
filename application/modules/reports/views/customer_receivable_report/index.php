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
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('from_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group date FromDate" id="DOB">
                                            <input class="form-control valid FromDate" aria-invalid="false" type="text"
                                                   name="FromDate" id="FromDate">
                                        <span class="input-group-addon">
                                        <!-- <input type="hidden" name="product_id" id="product_id"> -->

                                        <span class="glyphicon glyphicon-calendar"></span>
                                       </span>
                                        </div>
                                        <label id="FromDate-error" class="error" for="FromDate"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group date ToDate" id="DOB">
                                            <input class="form-control valid ToDate" aria-invalid="false" type="text"
                                                   name="ToDate" id="ToDate">
                                        <span class="input-group-addon">

                                       <span class="glyphicon glyphicon-calendar"></span>
                                       </span>
                                        </div>
                                        <label id="ToDate-error" class="error" for="ToDate"></label>
                                    </div>
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
                                                        echo '<option value="' . $customer->id_customer . '">' . $customer->full_name.'('.$customer->phone.')' . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <span id="customer-error" class="error" for="customer_id"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("store"); ?></label>
                                    <div class="col-sm-12">
                                        <!-- <div class="row-fluid"> -->
                                        <?php
                                        if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                            ?>
                                            <select class="select2" data-live-search="true" id="store_id"
                                                    name="store_id">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($stores as $store) {
                                                    // if (empty($station->_id_station)) {
                                                    echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                    // }
                                                }
                                                ?>
                                            </select>
                                            <?php
                                        } else {
                                            foreach ($stores as $store) {
                                                echo $store->store_name;
                                                echo '<input id="store_id" name="store_id" type="hidden" value="' . $store->id_store . '">';
                                            }
                                        }
                                        ?>
                                        <span id="store-error" class="error" for="store_id"></span>
                                    </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Type</label>
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <input class="form-control" id="cutomer_view" onchange="change_type(this)" name="report_type" value="customer" type="radio" checked>
                                            <label for="cutomer_view">Customer</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="invoice_view" onchange="change_type(this)" name="report_type" value="invoice" type="radio">
                                            <label for="invoice_view">Invoice</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="show_product_list" style="display: none;">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">Show</label>
                                        <div class="col-sm-12">
                                            <div class="col-sm-5">
                                                <input id="due_only" name="type_data" value="1" type="radio" checked>
                                                <label for="due_only">Due Only</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input id="paid_only" name="type_data" value="2" type="radio">
                                                <label for="paid_only">Paid Only</label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input id="all" name="type_data" value="3" type="radio">
                                                <label for="all">All</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                        class="fa fa-search"></i> <?= lang("search"); ?></button>
                                <button class="btn btn-primary pull-right" type="button" onclick="print_view_show()"><i
                                        class="fa fa-view"></i> <?= lang("print-view"); ?></button>
                                <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>
                            </div>
                            <?php echo form_close(); ?>

                        </div>
                    </div>
                    <div class="element-box full-box">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang("customer_name"); ?></th>
                                        <th><?= lang("store"); ?></th>
                                        <th class="right_text"><?= lang("invoice_amount"); ?></th>
                                        <th class="right_text"><?= lang("paid-amt"); ?></th>
                                        <th class="right_text"><?= lang("dues"); ?></th>
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
<script>
    function change_type(el){
        var id=el.value;
        if(id=='customer'){
            $('#show_product_list').hide();
        }else{
            $('#show_product_list').show();
        }
    }


    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var store_id = $('#store_id').val();
        var customer_id = $('#customer_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var report_type = $('[name^="report_type"]:checked').val();
        var type_data = $('[name^="type_data"]:checked').val();
        if (check_valid() == 1) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>customer-receivable-report/page-data/' + page_num,
                data: 'page=' + page_num + '&customer_id=' + customer_id + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate+ '&report_type=' + report_type + '&type_data=' + type_data,
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

    function print_view_show(page_num) {
        page_num = page_num ? page_num : 0;
        var store_id = $('#store_id').val();
        var customer_id = $('#customer_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var report_type = $('[name^="report_type"]:checked').val();
        var type_data = $('[name^="type_data"]:checked').val();
        if (check_valid() == 1) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>customer-receivable-report/print-data/' + page_num,
                data: 'page=' + page_num + '&customer_id=' + customer_id + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate+ '&report_type=' + report_type + '&type_data=' + type_data,
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
    }
    function check_valid() {
        var store_id = $('#store_id').val();
        //var customer_id = $('#customer_id').val();
        $err_count = 1;
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        $('#FromDate-error').html("");
        $('#ToDate-error').html("");
        $('#customer-error').html("");
        $('#store-error').html("");
        // if(FromDate=='' || ToDate==''){
        if (FromDate == '') {
            $err_count = 2;
            $('#FromDate-error').html("Please fill start Date");
        }
        if (ToDate == '') {
            $err_count = 2;
            $('#ToDate-error').html("Please fill end Date");
        }
//        if (customer_id == '0') {
//            $err_count = 2;
//            $('#customer-error').html("Please Select Customer");
//        }
        if (store_id == '0') {
            $err_count = 2;
            $('#store-error').html("Please Select Store");
        }
        return $err_count;
    }
    function csv_export() {
        var store_id = $('#store_id').val();
        var customer_id = $('#customer_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var report_type = $('[name^="report_type"]:checked').val();
        var type_data = $('[name^="type_data"]:checked').val();
        if (check_valid() == 1) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>reports/customer_receivable_report/create_csv_data',
                data: 'customer_id=' + customer_id + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate+ '&report_type=' + report_type + '&type_data=' + type_data,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    $('.loading').fadeOut("slow");
                    window.location.href = '<?php echo base_url(); ?>export_csv?request='+(html);
                }
            });
        }
    }
</script> 
