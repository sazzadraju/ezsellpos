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
                                                   name="FromDate" id="FromDate" onkeyup="product_list_suggest(this);">
                                        <span class="input-group-addon"> 
                                        <!-- <input type="hidden" name="product_id" id="product_id"> -->
                                       
                                        <span class="glyphicon glyphicon-calendar"></span>  
                                       </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group date ToDate" id="DOB">
                                            <input class="form-control valid ToDate" aria-invalid="false" type="text"
                                                   name="ToDate" id="ToDate" onkeyup="product_list_suggest(this);">
                                        <span class="input-group-addon">  
                                      
                                       <span class="glyphicon glyphicon-calendar"></span>  
                                       </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("supplier_name"); ?></label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="supplier_id"
                                                name="supplier_id">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($suppliers as $supplier) {
                                                // if (empty($station->_id_station)) {
                                                echo '<option value="' . $supplier->id_supplier . '">' . $supplier->supplier_name.'('.$supplier->phone.')' . '</option>';
                                                // }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <span id="supplier-error" class="error" for="product_name"></span>
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
                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                        class="fa fa-search"></i> <?= lang("search"); ?></button>
                                <button href="<?php echo base_url(); ?>stock_report/print_page"
                                        class="btn btn-primary pull-right" type="button" onclick="print_view_show()"><i
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
                                        <th><?= lang("date"); ?></th>
                                        <th><?= lang("invoice_no"); ?></th>
                                        <th><?= lang("type"); ?></th>
                                        <th><?= lang("invoice_amount"); ?></th>
                                        <th><?= lang("paid_amount"); ?></th>
                                        </thead>

                                    </table>

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


    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var store_id = $('#store_id').val();
        var supplier_id = $('#supplier_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        if (check_valid() == 1) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>supplier-ledger-report/page-data',
                data: 'supplier_id=' + supplier_id + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate,
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
        var supplier_id = $('#supplier_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        if (check_valid() == 1) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>supplier-ledger-report/print-page',
                data: 'supplier_id=' + supplier_id + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
            });
        }
    }
    function check_valid() {
        var store_id = $('#store_id').val();
        var supplier_id = $('#supplier_id').val();
        $err_count = 1;
        $('#supplier-error').html("");
        $('#store-error').html("");
        if (supplier_id == '0') {
            $err_count = 2;
            $('#supplier-error').html("Please Select Supplier");
        }
        if (store_id == '0') {
            $err_count = 2;
            $('#store-error').html("Please Select Store");
        }
        return $err_count;
    }
    function csv_export() {
        var store_id = $('#store_id').val();
        var supplier_id = $('#supplier_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        if (check_valid() == 1) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>reports/supplier_ledger_report/create_csv_data',
                data: 'supplier_id=' + supplier_id + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate,
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
