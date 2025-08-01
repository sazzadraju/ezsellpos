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
                    <div class="full-box element-box">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('from_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group date FromDate" id="DOB">
                                            <input class="form-control valid FromDate" aria-invalid="false" type="text" name="FromDate" id="FromDate">
                                        <span class="input-group-addon">
                                        <!-- <input type="hidden" name="product_id" id="product_id"> -->

                                        <span class="glyphicon glyphicon-calendar"></span>
                                       </span>
                                        </div>
                                        <span id="FromDate-error" class="error" for="product_name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group date ToDate" id="DOB">
                                            <input class="form-control valid ToDate" aria-invalid="false" type="text" name="ToDate" id="ToDate">
                                        <span class="input-group-addon">

                                       <span class="glyphicon glyphicon-calendar"></span>
                                       </span>
                                        </div>
                                        <span id="ToDate-error" class="error" for="product_name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("customer_type"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="customer_type"
                                                    name="customer_type">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($customer_types as $type) {
                                                    echo '<option value="' . $type->id_customer_type . '">' . $type->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("store"); ?></label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="store_id" name="store_id">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($stores as $store) {
                                                echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">&nbsp;</label>
                                    <div class="col-sm-12">
                                        <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                                class="fa fa-search"></i> <?= lang("search"); ?></button>
                                        <button class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i
                                                class="fa fa-view"></i> <?= lang("print-view"); ?></button>
                                        <button class="btn btn-primary pull-right" type="button" onclick="csv_export()" style="margin-right: 10px;">CSV</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- body view from here -->
                <div class="element-box full-box">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="postList">
                                <table id="mytable" class="table table-bordred table-striped">
                                    <thead>
                                    <th><?= lang("sl"); ?></th>
                                    <th><?= lang("date"); ?></th>
                                    <th><?= lang("customer_name"); ?></th>
                                    <th><?= lang("customer_type"); ?></th>
                                    <th><?= lang("store"); ?></th>
                                    <th><?= lang("qty"); ?></th>
                                    <th><?= lang("amount"); ?></th>
                                    </thead>

                                </table>

                                <div class="clearfix"></div>
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
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
       // var customer_id = $('#customer_id option:selected').val();
        var customer_type = $('#customer_type option:selected').val();
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
                url: '<?php echo base_url(); ?>best-selling-customers/page-data/' + page_num,
                data: 'page=' + page_num  + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate+'&customer_type='+customer_type,
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

    function searchFilter2(page_num) {
        page_num = page_num ? page_num : 0;
        var store_id = $('#store_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
       // var customer_id = $('#customer_id option:selected').val();
        var customer_type = $('#customer_type option:selected').val();
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
                url: '<?php echo base_url(); ?>best-selling-customers/print-data',
                data: 'store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate +'&customer_type='+customer_type,
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
    function csv_export() {
       var store_id = $('#store_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        //var customer_id = $('#customer_id option:selected').val();
        var customer_type = $('#customer_type option:selected').val();
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
                url: '<?php echo base_url(); ?>reports/best_selling_customers/create_csv_data',
                data: 'store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate +'&customer_type='+customer_type,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    $('.loading').fadeOut("slow");
                    window.location.href = '<?php echo base_url(); ?>export_csv?request='+html;

                }
            });
        }
    }

</script> 
