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
                                            <input class="form-control valid FromDate" aria-invalid="false" type="text"
                                                   name="FromDate" id="FromDate">
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
                                            <input class="form-control valid ToDate" aria-invalid="false" type="text"
                                                   name="ToDate" id="ToDate">
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
                                    <label class="col-sm-12 col-form-label"><?= lang("product_category"); ?></label>
                                    <div class="col-sm-12">

                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="cat_name"
                                                    name="cat_name">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($categories as $category) {
                                                    if (empty($category->parent_cat_id)) {
                                                        echo '<option value="' . $category->id_product_category . '">' . $category->cat_name . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("sub_category"); ?></label>
                                    <div class="col-sm-12">

                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="pro_sub_category"
                                                    name="pro_sub_category">
                                                <option value="0" selected><?= lang("product_sub_category"); ?></option>
                                                <?php
                                                foreach ($categories as $category) {
                                                    if (!empty($category->parent_cat_id)) {
                                                        echo '<option value="' . $category->id_product_category . '">' . $category->cat_name . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Filter By</label>
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <input id="qty" name="report_type" value="1" type="radio" checked>
                                            <label for="qty">Quantity</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="price" name="report_type" value="2" type="radio">
                                            <label for="price">Price</label>
                                        </div>
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
                                    <th><?= lang("product_name"); ?></th>
                                    <th><?= lang("product_code"); ?></th>
                                    <th><?= lang("cat/subcat"); ?></th>
                                    <th><?= lang("brand"); ?></th>
                                    <th><?= lang("store"); ?></th>
                                    <th><?= lang("qty"); ?></th>
                                    <th><?= lang("amount"); ?></th>
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

    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var report_type = $('[name^="report_type"]:checked').val();
        var store_id = $('#store_id').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var brand = $('#brand').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
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
                url: '<?php echo base_url(); ?>best-selling-products/page-data/' + page_num,
                data: 'page=' + page_num + '&cat_name=' + cat_name + '&pro_sub_category=' + pro_sub_category + '&brand=' + brand + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&report_type=' + report_type,
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
        var report_type = $('[name^="report_type"]:checked').val();
        var store_id = $('#store_id').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var brand = $('#brand').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
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
                url: '<?php echo base_url(); ?>best-selling-products/print-data',
                data: 'cat_name=' + cat_name + '&pro_sub_category=' + pro_sub_category + '&brand=' + brand + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&report_type=' + report_type,
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
        var report_type = $('[name^="report_type"]:checked').val();
        var store_id = $('#store_id').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var brand = $('#brand').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
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
                url: '<?php echo base_url(); ?>reports/best-selling-products/create_csv_data',
                data: 'cat_name=' + cat_name + '&pro_sub_category=' + pro_sub_category + '&brand=' + brand + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&report_type=' + report_type,
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
