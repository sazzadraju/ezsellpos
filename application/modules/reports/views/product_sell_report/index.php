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
                            <div class="col-md-2 col-sm-12">
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
                            <div class="col-md-2 col-sm-12">
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
                                  <label class="col-sm-12 col-form-label" for=""><?= lang("customer_name"); ?></label>
                                  <div class="col-sm-12">
                                    <div class="row-fluid">
                                      <select class="select2" data-live-search="true" id="customer_id" name="customer_id">
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
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                  <label class="col-sm-12 col-form-label" for=""><?= lang("supplier_name"); ?></label>
                                  <div class="col-sm-12">
                                    <div class="row-fluid">
                                      <select class="select2" data-live-search="true" id="supplier_id" name="supplier_id">
                                       <option value="0" selected><?= lang("select_one"); ?></option>
                                       <?php
                                       if($suppliers){
                                            foreach ($suppliers as $supplier) {
                                            echo '<option value="' . $supplier->id_supplier . '">' . $supplier->supplier_name.' '.$supplier->phone . '</option>';
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
                                    <label class="col-sm-12 col-form-label"><?= lang("sales_person"); ?></label>
                                    <div class="col-sm-12">
                                        <select class="select2 col-md-12" style="float:left" data-live-search="true"
                                                id="sales_person" name="sales_person">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($salesPersons as $person) {
                                                foreach ($this->config->item('sales_person') as $key => $val) :
                                                    if ($person['person_type'] == $key) {
                                                        $type=$val;
                                                    }
                                                endforeach;

                                                echo '<option actp="' . $person['user_name'] . '" value="' .$person['id_sales_person'] . '">' . $person['user_name'] . '(' . $type . ')' . '</option>';
                                            }
                                            ?>
                                        </select>
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
                            <div class="col-md-2 col-sm-12">
                              <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">&nbsp;</label>
                                    <div class="col-sm-12">
                                      <input type="checkbox" name="gift_sale" id="gift_sale" class="form-control">
                                      <label for="gift_sale" class="col-sm-12 col-form-label">Gift Sale</label>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
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
                                    <th><?= lang("invoice_no"); ?></th>
                                    <th><?= lang("product_name"); ?></th>
                                    <th><?= lang("batch_no"); ?></th>
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
        var store_id = $('#store_id').val();
        var product_name = $('#product_name').val();
        // var station_id = $('#station_id').val();
        // var customer_id = $('#customer_id').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var brand = $('#brand').val();
        // var uid_add = $('#uid_add').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var batch_no = $('#batch_no').val();
        var customer_id = $('#customer_id').val();
        var sales_person = $('#sales_person option:selected').val();
        var supplier_id = $('#supplier_id option:selected').val();
        var gift_sale=0;
        if($('#gift_sale').prop('checked') === true){
           gift_sale=1;
        }
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
                url: '<?php echo base_url(); ?>product-sell-report/page-data/' + page_num,
                data: 'page=' + page_num + '&cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&brand=' + brand + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate+ '&batch_no=' + batch_no+'&sales_person='+sales_person+'&customer_id='+customer_id+'&supplier_id='+supplier_id+'&gift_sale='+gift_sale,
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
        var product_name = $('#product_name').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var brand = $('#brand').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var batch_no = $('#batch_no').val();
        var customer_id = $('#customer_id').val();
        var sales_person = $('#sales_person option:selected').val();
        var gift_sale=0;
        if($('#gift_sale').prop('checked') === true){
           gift_sale=1;
        }

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
                url: '<?php echo base_url(); ?>product-sell-report/print-data/' + page_num,
                data: 'page=' + page_num + '&cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&brand=' + brand + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate+ '&batch_no=' + batch_no+'&sales_person='+sales_person+'&customer_id='+customer_id+'&gift_sale='+gift_sale,
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
        var product_name = $('#product_name').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var brand = $('#brand').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var batch_no = $('#batch_no').val();
        var customer_id = $('#customer_id').val();
        var sales_person = $('#sales_person option:selected').val();
        var gift_sale=0;
        if($('#gift_sale').prop('checked') === true){
           gift_sale=1;
        }
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
                url: '<?php echo base_url(); ?>reports/product_sell_report/create_csv_data',
                data: 'cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&brand=' + brand + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate+ '&batch_no=' + batch_no+'&sales_person='+sales_person+'&customer_id='+customer_id+'&gift_sale='+gift_sale,
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
