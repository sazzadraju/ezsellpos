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
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("product_code_name"); ?></label>
                                    <div class="col-sm-12">
                                        <input type="hidden" name="product_name" id="product_name">
                                        <input type="text" class="form-control" name="product_list" id="product_list">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("attributes"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <button class="btn btn-info" data-title="Add Attributes" data-toggle="modal" rel="tooltip" title="" data-target="#add_attributes" data-original-title="Add Attributes"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <div id="attr_show"></div>
                                        <div id="attr_data"></div>
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
                                    <label class="col-sm-12 col-form-label"><?= lang("product_category"); ?></label>
                                    <div class="col-sm-12">

                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="cat_name" name="cat_name">
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
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("sub_category"); ?></label>
                                    <div class="col-sm-12">

                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="pro_sub_category" name="pro_sub_category">
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
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('suppliers') ?> </label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="supplier_id" name="supplier_id" >
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
                            <!-- <div class="row"> -->
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
                           <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("brands"); ?></label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="brand_id" name="brand_id">
                                            <option value=""><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($brands as $brand) {
                                                echo '<option value="' . $brand->id_product_brand . '">' . $brand->brand_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">&nbsp;</label>
                                    <div class="col-sm-12">
                                        <input type="radio" class="form-control" id="zero_stock2" name="zero_stock" value="0" checked>
                                        <label for="zero_stock2">Only Stock Available</label>
                                        <input type="radio" class="form-control" id="zero_stock" name="zero_stock" value="1">
                                        <label for="zero_stock">With Zero Stock</label>
                                        <input type="radio" class="form-control" id="zero_stock1" name="zero_stock" value="2">
                                        <label for="zero_stock1">Only Zero Stock</label>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i class="fa fa-search"></i> <?= lang("search"); ?></button>
                                 <button href="<?php echo base_url(); ?>stock_report/print_page" class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i class="fa fa-view"></i> <?= lang("print-view"); ?></button>
                                 <button class="btn btn-primary pull-right" type="button" style="margin-right: 10px" onclick="csv_export()">CSV</button>
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
                                       <th><?= lang("product_code"); ?></th>
                                          <th><?= lang("product_name"); ?></th>
                                          <th><?= lang("attributes"); ?></th> 
                                          <th><?= lang("cat/subcat"); ?></th>
                                          <th><?= lang("store"); ?></th>
                                          <th><?= lang("supplier"); ?></th>
                                          <th><?= lang("batch_no"); ?></th>
                                          <th><?= lang("quantity"); ?></th>
                                          <th><?= lang("purchase_price"); ?></th>
                                          <th><?= lang("selling_price"); ?></th>
                                          <!-- <th class="center"><?= lang("view"); ?></th> -->
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
<?php
$this->load->view('add_attributes', $attributes, false);
?>
<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<script>
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
        var supplier_id = $('#supplier_id').val();  
        var store_id = $('#store_id').val();
        var brand_id = $('#brand_id option:selected').val();
        var zero_stock = $("input[name='zero_stock']:checked").val();
        var attribue_data = $("input[name='attribue_data[]']").map(function(){return $(this).val();}).get();
        var batch_no = $('#batch_no').val();  
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>stock_report/page_data/' + page_num,
            data: 'page=' + page_num + '&cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id + '&store_id=' + store_id+ '&attribue_data=' + attribue_data+'&zero_stock='+zero_stock+'&brand_id='+brand_id+'&batch_no='+batch_no,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
   
   
    
    $(function () {
            $('#FromDate').datetimepicker({
                viewMode: 'years',
                format: 'YYYY-MM-DD',
            });
        });
    $(function () {
            $('#ToDate').datetimepicker({
                viewMode: 'years',
                format: 'YYYY-MM-DD',
            });
        });

    function searchFilter2(page_num) {
        page_num = page_num ? page_num : 0;
        var product_name = $('#product_name').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var supplier_id = $('#supplier_id').val();  
        var store_id = $('#store_id').val();
        var zero_stock = $("input[name='zero_stock']:checked").val();
        var brand_id = $('#brand_id option:selected').val();
        var attribue_data = $("input[name='attribue_data[]']").map(function(){return $(this).val();}).get();
        var batch_no = $('#batch_no').val();  
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>stock_report/print_page/' + page_num,
            data: 'page=' + page_num + '&cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id + '&store_id=' + store_id+ '&attribue_data=' + attribue_data+'&zero_stock='+zero_stock+'&brand_id='+brand_id+'&batch_no='+batch_no,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    $("#submit_add_attribute").submit(function () {
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            //dataType: "json",
            url: '<?php echo base_url(); ?>stock_insert_attributes',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                console.log(data);
                $('.loading').fadeOut("slow");
                var result = $.parseJSON(data);
                $('#add_attributes').modal('hide');
                //alert(result);
                var show_data='';
                var show_data1='';
                if(data!=1){
                    $.each(result, function (ke, obj) {
                        
                        var c = 1;
                        var attr = '';
                        var attr_show = '';

                        $.each(obj, function (key, value) {
                            //console.log(key + '=' + value);
                            // alert(key + '=' + value);
                            var coma = '';
                            var comaS = '';
                            if (c > 1) {
                                coma = ';';
                                comaS = ',';
                            }
                            var lastItem = key.split("@");
                            attr += comaS + lastItem[1] + '=' + value;
                            attr_show += coma + lastItem[1] + '=' + value;
                            c += 1;
                        });
                        show_data+='<input type="hidden" name="attribue_data[]" value="'+attr_show+'">';
                        show_data1+=attr+'<br>';
                    });
                    $('#attr_data').html(show_data);
                    $('#attr_show').html(show_data1);
                } 
                   
                
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;

    });
    var $main = $('.main');
    var $ch = $('.checkGroup input[type="checkbox"]');

    $('.main').click(function () {
        $('#error_msg').html('');
        var length = $('.main:checked').length;
        if (length > 3) {
            $(this).prop('checked', false);
            $('#error_msg').html('Maximum three category allowed.');
        } else {
            var id = $(this).attr('id');
            if ($(this).prop('checked') == false) {
                $('.ch_' + id).prop('checked', false);
            } else {
                $('.ch_' + id).prop('checked', true);
            }
        }
        //$main.prop('checked', $(this).prop('checked'));
    });
    $('.child_value').click(function () {
        //alert($ch);
        $('#error_msg').html('');
        var id = $(this).attr('id');
        var lastItem = id.split("_").pop(-1);
        var length = $('.ch_' + lastItem + ':checked').length;
        $('.mn_' + lastItem).prop('checked', true);
        if (length < 1) {
            $('.mn_' + lastItem).prop('checked', false);
        }
        if (length == 1) {
            var length = $('.main:checked').length;
            if (length > 3) {
                $(this).prop('checked', false);
                $('.mn_' + lastItem).prop('checked', false);
                $('#error_msg').html('Maximum three category allowed.');
            }
        }
    });
    function csv_export() {
        var product_name = $('#product_name').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var supplier_id = $('#supplier_id').val();
        var store_id = $('#store_id').val();
        var zero_stock = $("input[name='zero_stock']:checked").val();
        var brand_id = $('#brand_id option:selected').val();
        var attribue_data = $("input[name='attribue_data[]']").map(function(){return $(this).val();}).get();
        var batch_no = $('#batch_no').val();  
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>reports/stock_report/create_csv_data',
                data: 'cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id + '&store_id=' + store_id+'&zero_stock='+zero_stock+ '&attribue_data=' + attribue_data+'&brand_id='+brand_id+'&batch_no='+batch_no,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    $('.loading').fadeOut("slow");
                    window.location.href = '<?php echo base_url(); ?>export_csv?request='+(html);
                }
            });
    }


</script> 
