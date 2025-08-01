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
                                        <input class="form-control valid FromDate" aria-invalid="false" type="text" name="FromDate" id="FromDate"  onkeyup="product_list_suggest(this);">
                                        <span class="input-group-addon"> 
                                        <!-- <input type="hidden" name="product_id" id="product_id"> -->
                                        <span class="glyphicon glyphicon-calendar"></span>  
                                       </span>     
                                       </div>
                                       <label id="FromDate-error" class="error" for="product_name"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                                    <div class="col-sm-12">
                                          <div class="input-group date ToDate" id="DOB">
                                        <input class="form-control valid ToDate" aria-invalid="false" type="text" name="ToDate" id="ToDate"  onkeyup="product_list_suggest(this);">
                                        <span class="input-group-addon">     
                                       <span class="glyphicon glyphicon-calendar"></span>  
                                       </span> 
                                       </div> 
                                        <label id="ToDate-error" class="error" for="product_name"></label>                       
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("invoice_no"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="invoice_no" name="invoice_no" placeholder="<?= lang("invoice_no"); ?>" type="text">
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("store_name"); ?></label>
                                    <div class="col-sm-12">

                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="store_id" name="store_id">
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
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i class="fa fa-search"></i> <?= lang("search"); ?></button>
                                <button class="btn btn-primary pull-right" type="button" onclick="print_view()"><i class="fa fa-view"></i><?= lang("print-view"); ?></button>
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
                                          <th><?= lang("invoice_no"); ?></th> 
                                         <!--  <th><?= lang("category"); ?></th>
                                          <th><?= lang("sub_category"); ?></th> -->
                                           <th><?= lang("store_name"); ?></th>
                                           <th><?= lang("supplier_name"); ?></th>
                                           <th><?= lang("view"); ?></th>
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
                                  
                                            
function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
    var product_name = $('#product_name').val();
    var store_id = $('#store_id').val();
    // var customer_id = $('#customer_id').val();
    var cat_name = $('#cat_name').val();
    var invoice_no = $('#invoice_no').val();
    var pro_sub_category = $('#pro_sub_category').val();
    var supplier_id = $('#supplier_id').val();
    // var brand = $('#brand').val();
    // var uid_add = $('#uid_add').val();
    var FromDate = $('#FromDate').val();
    var ToDate = $('#ToDate').val();
        $err_count = 1;
   $('#FromDate-error').html("");
   $('#ToDate-error').html("");
   if (FromDate == '') {
       $err_count=2;
       $('#FromDate-error').html("Please fill start Date");
   }
   if (ToDate == '') {
       $err_count=2;
       $('#ToDate-error').html("Please fill end Date");
   }
    if ($err_count == 1)  {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>purchase-report-details/page_data/' + page_num,
            data: 'page=' + page_num + '&invoice_no=' + invoice_no +'&product_name=' + product_name + '&store_id=' + store_id +  '&FromDate=' + FromDate + '&ToDate=' + ToDate +'&cat_name=' + cat_name +'&pro_sub_category=' + pro_sub_category +'&supplier_id=' + supplier_id,
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
function searchFilter2(page_num) {
    page_num = page_num ? page_num : 0;
    var product_name = $('#product_name').val();
    var cat_name = $('#cat_name').val();
    var pro_sub_category = $('#pro_sub_category').val();
    // var price_range = $('#priceRange').val();
    var supplier_id = $('#supplier_id').val();
    var FromDate = $('#FromDate').val();
    var ToDate = $('#ToDate').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>purchase-report_details/page_data2/' + page_num,
        data: 'page=' + page_num + '&cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate,
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
 function print_view(page_num) {
    var product_name = $('#product_name').val();
    var store_id = $('#store_id').val();
    // var customer_id = $('#customer_id').val();
    var cat_name = $('#cat_name').val();
    var invoice_no = $('#invoice_no').val();
    var pro_sub_category = $('#pro_sub_category').val();
    var supplier_id = $('#supplier_id').val();
    // var brand = $('#brand').val();
    // var uid_add = $('#uid_add').val();
    var FromDate = $('#FromDate').val();
    var ToDate = $('#ToDate').val();
        $err_count = 1;
   $('#FromDate-error').html("");
   $('#ToDate-error').html("");
   if (FromDate == '') {
       $err_count=2;
       $('#FromDate-error').html("Please fill start Date");
   }
   if (ToDate == '') {
       $err_count=2;
       $('#ToDate-error').html("Please fill end Date");
   }
    if ($err_count == 1)  {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>reports/purchase_report_details/print_data',
                data: 'invoice_no=' + invoice_no +'&product_name=' + product_name + '&store_id=' + store_id +  '&FromDate=' + FromDate + '&ToDate=' + ToDate +'&cat_name=' + cat_name +'&pro_sub_category=' + pro_sub_category +'&supplier_id=' + supplier_id,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    //console.log(html);
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
            });
        }
    }
function csv_export() {
    var product_name = $('#product_name').val();
    var store_id = $('#store_id').val();
    // var customer_id = $('#customer_id').val();
    var cat_name = $('#cat_name').val();
    var invoice_no = $('#invoice_no').val();
    var pro_sub_category = $('#pro_sub_category').val();
    var supplier_id = $('#supplier_id').val();
    // var brand = $('#brand').val();
    // var uid_add = $('#uid_add').val();
    var FromDate = $('#FromDate').val();
    var ToDate = $('#ToDate').val();
    $err_count = 1;
    $('#FromDate-error').html("");
    $('#ToDate-error').html("");
    if (FromDate == '') {
       $err_count=2;
       $('#FromDate-error').html("Please fill start Date");
    }
    if (ToDate == '') {
       $err_count=2;
       $('#ToDate-error').html("Please fill end Date");
    }
    if ($err_count == 1)  {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>reports/purchase_report_details/create_csv_data',
            data: 'invoice_no=' + invoice_no +'&product_name=' + product_name + '&store_id=' + store_id +  '&FromDate=' + FromDate + '&ToDate=' + ToDate +'&supplier_id=' + supplier_id,
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
