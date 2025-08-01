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
                            <div class="col-md-2">
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
                                        <span id="FromDate-error" class="error" for="product_name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
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
                                        <span id="ToDate-error" class="error" for="product_name"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
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
                            <div class="col-md-2 col-sm-12">
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
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-12">
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
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("store_name"); ?></label>
                                    <div class="col-sm-12">

                                        <div class="row-fluid">
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
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('suppliers') ?> </label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="supplier_id"
                                                name="supplier_id">
                                            <option value="0"><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($suppliers as $supplier) {
                                                echo '<option value="' . $supplier->id_supplier . '">' . $supplier->supplier_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                        class="fa fa-search"></i> <?= lang("search"); ?></button>
                                <button class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i
                                        class="fa fa-view"></i> <?= lang("print-view"); ?></button>
                                <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>


                    <!-- body view from here -->
                    <div class="element-box full-box">
                        <!--  <div class="row">
                            <div class="col-md-12">

                                <button data-toggle="modal" data-target="#add" class="btn btn-primary bottom-10 right" type="button" onclick="addProduct()"><?= lang("add_product"); ?></button>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang("purchase_date"); ?></th>
                                        <th><?= lang("product_name"); ?></th>
                                        <th><?= lang("category"); ?></th>
                                        <th><?= lang("sub_category"); ?></th>
                                        <th><?= lang("store_name"); ?></th>
                                        <th><?= lang("purchase_price"); ?></th>
                                        <th><?= lang("qty"); ?></th>
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
        var product_name = $('#product_name').val();
        var store_id = $('#store_id').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var supplier_id = $('#supplier_id').val();
        // alert(supplier_id);
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var batch_no = $('#batch_no').val();
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
                url: '<?php echo base_url(); ?>purchase-report/page_data/' + page_num,
                data: 'page=' + page_num + '&product_name=' + product_name + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&cat_name=' + cat_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id+ '&batch_no=' + batch_no,
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
        var product_name = $('#product_name').val();
        var store_id = $('#store_id').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var supplier_id = $('#supplier_id').val();
        // alert(supplier_id);
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var batch_no = $('#batch_no').val();
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
                url: '<?php echo base_url(); ?>purchase-report/print-data/' + page_num,
                data: 'page=' + page_num + '&product_name=' + product_name + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&cat_name=' + cat_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id+ '&batch_no=' + batch_no,
                // beforeSend: function () {
                //     $('.loading').show();
                // },
                success: function (html) {
                    console.log(html);
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
            });
        }
    }
    function csv_export() {
        var product_name = $('#product_name').val();
        var store_id = $('#store_id').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var supplier_id = $('#supplier_id').val();
        // alert(supplier_id);
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var batch_no = $('#batch_no').val();
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
                url: '<?php echo base_url(); ?>reports/purchase_report/create_csv_data',
                data: 'product_name=' + product_name + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&cat_name=' + cat_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id+ '&batch_no=' + batch_no,
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
