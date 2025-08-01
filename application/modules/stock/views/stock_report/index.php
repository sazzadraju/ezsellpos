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
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("product_code_name"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="product_name" name="product_name" placeholder="<?= lang("product_code_name"); ?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
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
                             <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('from_date') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="FromDate" id="FromDate" class="product_name" onkeyup="product_list_suggest(this);">
                                        <input type="hidden" name="product_id" id="product_id">
                                        <label id="product_name-error" class="error" for="product_name"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="ToDate" id="ToDate" class="product_name" onkeyup="product_list_suggest(this);">
                                        <input type="hidden" name="product_id" id="product_id">
                                        <label id="product_name-error" class="error" for="product_name"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i class="fa fa-search"></i> <?= lang("search"); ?></button>
                                <button href="<?php echo base_url(); ?>stock_report/print_page" class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i class="fa fa-view"></i> <?= lang("print-view"); ?></button>
                            </div>
                            </form> 

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
                                          <th><?= lang("category"); ?></th>
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

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script>
                                            function showdata() {
                                                var cat_name = $('#product').val();
                                                alert(cat_name);
                                            }

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
                                                var product_name = $('#product_name').val();
                                                var cat_name = $('#cat_name').val();
                                                var pro_sub_category = $('#pro_sub_category').val();
                                                // var price_range = $('#priceRange').val();
                                                var supplier_id = $('#supplier_id').val();
                                                var FromDate = $('#FromDate').val();
                                                var ToDate = $('#ToDate').val();
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url(); ?>stock_report/page_data/' + page_num,
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
                                                url: '<?php echo base_url(); ?>stock_report/page_data2/' + page_num,
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
