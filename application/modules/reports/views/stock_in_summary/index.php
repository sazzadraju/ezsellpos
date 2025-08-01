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
                                                   name="FromDate" id="FromDate">
                                        <span class="input-group-addon">
                                        <!-- <input type="hidden" name="product_id" id="product_id"> -->
                                       
                                        <span class="glyphicon glyphicon-calendar"></span>  
                                       </span>
                                        </div>
                                        <label id="FromDate-error" class="error" for="product_name"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
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
                                    <label class="col-sm-12 col-form-label"
                                           for=""><?= lang("product_code_name"); ?></label>
                                    <div class="col-sm-12">
                                        <input type="hidden" name="product_name" id="product_name">
                                        <input type="text" class="form-control" name="product_list" id="product_list">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"
                                           for=""><?= lang("batch_no"); ?></label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="batch_no" id="batch_no">
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
                                                    echo '<option value="' . $brand->id_product_brand . '">' . $brand->brand_name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("stock_in_type"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <select class="select2" id="stock_type" name="stock_type">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <option value="1">Purchase Receive</option>
                                                <option value="12">General Stock In</option>
                                                <!-- <option value="5">Sales Return</option> -->
                                                <option value="8">Stock Transfer Receive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                               <div class="form-group row">
                                   <label class="col-sm-12 col-form-label"><?= lang("stock_in_reason"); ?></label>
                                   <div class="col-sm-12">
                                       <!-- <div class="row-fluid"> -->
                                           <select class="select2" data-live-search="true" id="reason" name="reason" >
                                               <option value="0" selected><?= lang("select_one"); ?></option>
                                               <?php
                                               foreach ($reason as $reasons) {
                                                       echo '<option value="' . $reasons->mvt_type_id . '">' . $reasons->reason . '</option>';
                                               }
                                               ?>
                                           </select>
                                       </div>

                                   <!-- </div> -->
                               </div>
                           </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
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
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                    class="fa fa-search"></i> <?= lang("search"); ?></button>
                            <button href="<?php echo base_url(); ?>stock_report/print_page"
                                    class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i
                                    class="fa fa-view"></i> <?= lang("print-view"); ?></button>
                            <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>
                        </div>
                    </div>
                    <!-- body view from here -->
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    

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
$('#stock_type').on('change', '', function (e) {
    var value=this.value;
    $.ajax({
        type: 'POST',
        url: URL+'reports/stock_in_summary/getStockReason',
        data: 'id=' + value,
        success: function (result) {
            var html = '';
            var data = JSON.parse(result);
            if (result) {
                var length = data.length;
                html = "<option value = '0'>Select One</option>";
                for (var i = 0; i < length; i++) {
                    var val = data[i].id_stock_mvt_reason;
                    var name = data[i].reason;
                    html += "<option value = '" + val + "'>" + name + "</option>";
                }
            }
            $("#reason").html(html);
        }
    });
});
$(function () {
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
        $('#product_name').val(ui.item.value);
        return false;
        } 
    });
});
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var product_name = $('#product_name').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        // var price_range = $('#priceRange').val();
        var supplier_id = $('#supplier_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var store_id = $('#store_id').val();
        var stock_type = $('#stock_type').val();
        var batch_no = $('#batch_no').val();
        var brand = $('#brand option:selected').val();
        var reason = $('#reason option:selected').val();
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
                url: '<?php echo base_url(); ?>stock-in-summary/page_data/' + page_num,
                data: 'page=' + page_num + '&cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&store_id=' + store_id + '&stock_type=' + stock_type+ '&batch_no=' + batch_no+ '&brand=' + brand+ '&reason=' + reason,
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
    function searchFilter2(page_num) {
        page_num = page_num ? page_num : 0;
        var product_name = $('#product_name').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        // var price_range = $('#priceRange').val();
        var supplier_id = $('#supplier_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var store_id = $('#store_id').val();
        var stock_type = $('#stock_type').val();
        var batch_no = $('#batch_no').val();
        var brand = $('#brand option:selected').val();
        var reason = $('#reason option:selected').val();
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
            url: '<?php echo base_url(); ?>stock-in-summary/print_page/' + page_num,
            data: 'page=' + page_num + '&cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&store_id=' + store_id + '&stock_type=' + stock_type+ '&batch_no=' + batch_no+ '&brand=' + brand+ '&reason=' + reason,
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
    function csv_export() {
        var product_name = $('#product_name').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        // var price_range = $('#priceRange').val();
        var supplier_id = $('#supplier_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var store_id = $('#store_id').val();
        var stock_type = $('#stock_type').val();
        var batch_no = $('#batch_no').val();
        var brand = $('#brand option:selected').val();
        var reason = $('#reason option:selected').val();
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
                url: '<?php echo base_url(); ?>reports/stock_in_summary/create_csv_data',
                data: 'cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&store_id=' + store_id + '&stock_type=' + stock_type+ '&batch_no=' + batch_no+ '&brand=' + brand+ '&reason=' + reason,
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
