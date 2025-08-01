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
                                        <input class="form-control" type="text" name="FromDate" id="FromDate" class="product_name" onkeyup="product_list_suggest(this);">
                                        <input type="hidden" name="product_id" id="product_id">
                                        <label id="FromDate-error" class="error" for="product_name"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="ToDate" id="ToDate" class="product_name" onkeyup="product_list_suggest(this);">  
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
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('sold_by') ?> </label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="uid_add" name="uid_add" >
                                            <option value="0"><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($users as $sold_by) {
                                                echo '<option value="' . $sold_by->id_user . '">' . $sold_by->uname . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("station_name"); ?></label>
                                    <div class="col-sm-12">

                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="station_id" name="station_id">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($stations as $station) {
                                                    // if (empty($station->_id_station)) {
                                                        echo '<option value="' . $station->id_station . '">' . $station->name . '</option>';
                                                    // }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                           <div class="col-md-2 col-sm-12">
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
                           

                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i class="fa fa-search"></i> <?= lang("search"); ?></button>
                                <!-- <button href="<?php echo base_url(); ?>stock_report/print_page" class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i class="fa fa-view"></i> <?= lang("print-view"); ?></button> -->
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
                                       <th><?= lang("invoice_no"); ?></th>
                                          <th><?= lang("sold_date"); ?></th>
                                          <th><?= lang("invoice_amount"); ?></th>
                                          <th><?= lang("sold_by"); ?></th>
                                          <th><?= lang("customer_name"); ?></th>
                                          <th><?= lang("station_name"); ?></th>
                                          <th><?= lang("store_name"); ?></th>
                                          <!-- <th><?= lang("price"); ?></th>
                                          <th><?= lang("stock"); ?></th> -->
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
                                            function showdata() {
                                                var cat_name = $('#product').val();
                                                alert(cat_name);
                                            }

                                            // function addProduct() {
                                            //     $('#product')[0].reset();
                                            //     $("#pro_code").val($.now());
                                            //     $("#id").val("");
                                            //     $("#supplier").val('').change();
                                            //     $('#layout_title').text('<?= lang("add_product"); ?>');
                                            //     $("#category").val("0").change();
                                            //     $("#subcategory").val("0").change();
                                            //     $("#brands").val("0").change();
                                            //     $("#unit").val("0").change();
                                            //     $("#vatShow").hide();
                                            //     $('#imageDiv').html('');
                                            //     $('[name="pro_code"]').removeAttr("readonly");
                                            //     $('[name="pro_code"]').attr('id', 'pro_code');
                                            // }
                                            function getsubcategory(value) {
                                                //alert(value);
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url(); ?>product_settings/products/getsubcategory',
                                                    data: 'id=' + value,
                                                    success: function (result) {
                                                        var html = '';
                                                        var data = JSON.parse(result);
                                                        if (result) {
                                                            var length = data.length;
                                                            html = "<option value = '0'><?= lang("select_one"); ?></option>";
                                                            for (var i = 0; i < length; i++) {
                                                                var val = data[i].id_product_category;
                                                                var name = data[i].cat_name;
                                                                html += "<option value = '" + val + "'>" + name + "</option>";
                                                            }
                                                        }
                                                        //alert(html);
                                                        $("#subcategory").html(html);
                                                        //$('#postList').html(html);

                                                    }
                                                });
                                            }
                                            function getResults(elem) {
                                                //alert('ss');
                                                elem.checked && elem.value == "Yes" ? $("#vatShow").show() : $("#vatShow").hide();
                                            }
                                            
                                            function searchFilter(page_num) {
                                                page_num = page_num ? page_num : 0;
                                                var invoice_no = $('#invoice_no').val();
                                                var station_id = $('#station_id').val();
                                                var customer_id = $('#customer_id').val();
                                                // var price_range = $('#priceRange').val();
                                                var uid_add = $('#uid_add').val();
                                                var FromDate = $('#FromDate').val();
                                                var ToDate = $('#ToDate').val();
                                                    // if(FromDate=='' || ToDate==''){
                                                        if(FromDate==''){
                                                        // alert('df');
                                                        $('#FromDate-error').html("Please fill start Date");
                                                    } else if(ToDate==''){
                                                        $('#ToDate-error').html("Please fill end Date");
                                                    }
                                                    else{
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url(); ?>sell-report/page_data/' + page_num,
                                                    data: 'page=' + page_num + '&invoice_no=' + invoice_no + '&station_id=' + station_id + '&customer_id=' + customer_id + '&uid_add=' + uid_add + '&FromDate=' + FromDate + '&ToDate=' + ToDate,
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
                                            function viewProductDetaitls(id)
                                            {
                                                //alert(id);
                                                $.ajax({
                                                    url: "<?php echo base_url() ?>product/details/" + id,
                                                    type: "GET",
                                                    dataType: "JSON",
                                                    beforeSend: function () {
                                                        $('.loading').show();
                                                    },
                                                    success: function (data)
                                                    {
                                                        console.log(data);
                                                        $('.loading').fadeOut("slow");
                                                        $('#pro_name_view').html(data.product_name);
                                                        $('#pro_code_vw').html(data.product_code);
                                                        $('#pro_category').html(data.cat_name);
                                                        $('#pro_subCategory').html(data.sub_category);
                                                        $('#pro_brands').html(data.brands);
                                                        $('#pro_selling_price').html(data.sell_price + 'Tk');
                                                        $('#pro_buying_price').html(data.buy_price + 'Tk');
                                                        $('#pro_min_stock').html(data.min_stock);
                                                        $('#pro_unit').html(data.unit_name);
                                                        $('#pro_vat').html(parseInt(data.vat) + '%');
                                                        $('#supplier_id').html(data.supplier_name);
                                                        //$('#supplier_id').html(data.supplier_id);
                                                        var photo = data.product_img;
                                                        if (photo != '') {
                                                            var image_path = "<?php echo base_url(); ?>public/uploads/products/" + photo;
                                                            var image = "<img src='" + image_path + "'  height='70' width='100'>";
                                                            $('#pro_imageDiv').html(image);
                                                        }

                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {
                                                        alert('Error get data from ajax');
                                                    }
                                                });
                                            }
                                           
                                            function resetAll() {
                                                $('#product_category')[0].reset();
                                                $('#layout_title').text('<?= lang("add_product"); ?>');
                                                $("#category").val("0").change();
                                                $('#pro_name').attr('name', 'pro_name');
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
                                                url: '<?php echo base_url(); ?>stock/page_data2/' + page_num,
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


</script> 
