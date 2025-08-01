<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>

<div class="col-md-12">
    <?php
    $mess = '';
    if ($this->session->flashdata('success') == TRUE): ?>
        <?php $mess = $this->session->flashdata('success'); ?>
        <script>
            $(document).ready(function () {
                $('#showMessage').show();
                setTimeout(function () {
                    $('#showMessage').fadeOut(300);

                }, 3000);
            });
        </script>
    <?php endif; ?>
    <div class="showmessage" id="showMessage" style="display: none;"><?= $mess ?></div>
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
                                    <label class="col-sm-12 col-form-label"
                                           for=""><?= lang("product_code_name"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="product_name" name="product_name"
                                               placeholder="<?= lang("product_code_name"); ?>" type="text">
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
                                    <label class="col-sm-12 col-form-label"><?= lang("product_sub_category"); ?></label>
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
                                    <label class="col-sm-12 col-form-label"><?= lang("brand_name"); ?></label>
                                    <div class="col-sm-12">

                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="brand_name"
                                                    name="brand_name">
                                                <option value="0" selected><?= lang("brand_name"); ?></option>
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
                                    <label class="col-sm-12 col-form-label"
                                           for="priceRange"><?= lang("price_range"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="pricerange" type="text" id="priceRange" name="priceRange"
                                               readonly>
                                        <div id="price-range" class="slider"></div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">&nbsp; </label>
                                    <div class="col-sm-12">
                                        <input type="checkbox" id="inactive_pro" name="inactive_pro" value="1">
                                        <label for="inactive_pro">Inactive Product</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <label class="col-sm-12 col-form-label">&nbsp;
                                </label>
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                            class="fa fa-search"></i> <?= lang("search"); ?></button>
<button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>
                            </div>
                            </form>
                        </div>
                    </div>


                    <!---Add view BOX--->
                    <div id="view" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="element-header margin-0"><?= lang("product_details"); ?> <span
                                            class="close" data-dismiss="modal">&times;</span></h6>
                                </div>
                                <div class="modal-body">
                                    <div class="data-view">
                                        <div class="col-md-8">
                                            <div class="info-1">
                                                <div class="company-name margin-0" id="pro_name_view"></div>
                                                <div class="company-email"><strong
                                                        class="fix-width"><?= lang("product_code"); ?></strong>: <span
                                                        id="pro_code_vw"></span></div>
                                                <div class="company-address"><strong
                                                        class="fix-width"><?= lang("category"); ?></strong>: <span
                                                        id="pro_category"></span></div>
                                                <div class="company-address"><strong
                                                        class="fix-width"><?= lang("sub_category"); ?></strong>: <span
                                                        id="pro_subCategory"></span></div>
                                                <div class="company-phone"><strong
                                                        class="fix-width"><?= lang("brand_name"); ?></strong>: <span
                                                        id="pro_brands"></span></div>
                                                <div class="company-email"><strong
                                                        class="fix-width"><?= lang("selling_price"); ?></strong>: <span
                                                        id="pro_selling_price"></span></div>
                                                <div class="company-email"><strong
                                                        class="fix-width"><?= lang("buying_price"); ?></strong>: <span
                                                        id="pro_buying_price"></span></div>
                                                <div class="company-address"><strong
                                                        class="fix-width"><?= lang("min_stock"); ?> </strong>: <span
                                                        id="pro_min_stock"></span></div>
                                                <div class="company-address"><strong
                                                        class="fix-width"><?= lang("max_stock"); ?> </strong>: <span
                                                        id="pro_max_stock"></span></div>
                                                <div class="company-address"><strong
                                                        class="fix-width"><?= lang("unit"); ?></strong>: <span
                                                        id="pro_unit"></span></div>
                                                <div class="company-phone"><strong
                                                        class="fix-width"><?= lang("vat"); ?></strong>: <span
                                                        id="pro_vat"></span></div>
                                                <div class="company-address"><strong
                                                        class="fix-width"><?= lang("supplier"); ?></strong>: <span
                                                        id="pro_supplier"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-img" id="pro_imageDiv" style="margin-top: 40px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal"><?= lang("close"); ?></button>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!---Add Modal BOX--->

                    <div id="add" class="modal fade" role="dialog">
                        <div class="modal-dialog  modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <?php echo form_open_multipart('', array('id' => 'product', 'class' => 'cmxform')); ?>
                                <div class="modal-header">
                                    <h6 class="element-header margin-0"><span
                                            id="layout_title"><?= lang("add_product"); ?> </span> <span class="close"
                                                                                                        data-dismiss="modal">&times;</span>
                                    </h6>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="id" value="">
                                    <input type="hidden" name="image_dir" id="image_dir" value="">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang("product_code"); ?> <span
                                                        class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="pro_code" id="pro_code"
                                                           type="text" value="<?= time() ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang("product_name"); ?><span
                                                        class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="pro_name"
                                                           id="pro_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"><?= lang("category"); ?> <span
                                                        class="req">*</span></label>
                                                <div class="col-sm-12">

                                                    <div class="row-fluid">
                                                        <select class="form-control" name="category" id="category"
                                                                data-live-search="true"
                                                                onChange="getsubcategory(this.value)">
                                                            <option value="0"><?= lang("select_one"); ?></option>
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
                                                <label
                                                    class="col-sm-12 col-form-label"><?= lang("sub_category"); ?> </label>
                                                <div class="col-sm-12">

                                                    <div class="row-fluid">
                                                        <select class="select2" data-live-search="true"
                                                                name="subcategory" id="subcategory">
                                                            <option value="0"
                                                                    selected><?= lang("select_one"); ?></option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-12 col-form-label"><?= lang("brand_name"); ?><span
                                                        class="req">*</span></label>
                                                <div class="col-sm-12">

                                                    <div class="row-fluid">
                                                        <select class="form-control" data-live-search="true" id="brands"
                                                                name="brands">
                                                            <option value="0"><?= lang("select_one"); ?></option>
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
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("unit"); ?><span
                                                        class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <div class="row-fluid">
                                                        <select class="form-control" name="unit" id="unit"
                                                                data-live-search="true">
                                                            <option value="0"><?= lang("select_one"); ?></option>
                                                            <?php
                                                            foreach ($units as $unit) {
                                                                echo '<option value="' . $unit->id_product_unit . '">' . $unit->unit_code . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang("buying_price"); ?><span
                                                        class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="buying_price"
                                                           id="buying_price">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang("selling_price"); ?></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="selling_price"
                                                           id="selling_price">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-12 col-form-label"><?= lang("is_vatable"); ?></label>
                                                <div class="col-sm-12">
                                                    <div class="col-sm-4">
                                                        <input id="yes" name="vatType" value="Yes" type="radio"
                                                               onClick="getResults(this)" checked>
                                                        <label for="yes"><?= lang("yes"); ?></label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input id="no" name="vatType" type="radio" value="No"
                                                               onClick="getResults(this)">
                                                        <label for="no"><?= lang("no"); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang("min_stock"); ?> </label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="min_stock"
                                                           id="min_stock">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang("max_stock"); ?> </label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="max_stock"
                                                           id="max_stock">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-12"
                                                       for=""><?= lang("supplier"); ?></label>
                                                <div class="col-sm-12">
                                                    <select class="select2" multiple="true" name="supplier[]"
                                                            id="supplier">
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
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"><?= lang("photo"); ?></label>
                                                <div class="col-sm-12">
                                                    <input type="file" name="userfile" id="userfile"/>
                                                    <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("file_type"); ?></p>
                                                    <div id="imageDiv"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal"><?= lang("close"); ?></button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>

                        </div>
                    </div>

                    <!---Add Modal BOX--->


                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url() . 'csv' ?>" class="btn btn-primary bottom-10 right"
                                ><?= lang("import_from_csv"); ?></a>
                                <button data-toggle="modal" data-target="#add"
                                        class="btn btn-primary bottom-10 right  margin-right-5"
                                        type="button" onclick="addProduct()"><?= lang("add_product"); ?></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php
                                    $this->load->view('products/all_product_data', $posts, false);
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="modal fade" id="deleteProduct" tabindex="-1" role="dialog" aria-labelledby="edit"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                        <h4 class="modal-title custom_align"
                                            id="Heading"><?= lang("delect_this_entry"); ?></h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="alert alert-danger"><span
                                                class="glyphicon glyphicon-warning-sign"></span> <?= lang("confirm_delete"); ?>
                                        </div>

                                    </div>
                                    <div class="modal-footer ">
                                        <input type="hidden" id="product_delete_id">
                                        <button type="button" class="btn btn-success" onclick="delete_procuct();"><span
                                                class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                                class="glyphicon glyphicon-remove"></span><?= lang("no"); ?> 
                                        </button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="productEmptyAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span><?= lang("alert_stock_zero"); ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>
<script>
    function showdata() {
        var cat_name = $('#product').val();
        alert(cat_name);
    }

    function addProduct() {
        $('#product')[0].reset();
        $("#pro_code").val($.now());
        $("#id").val("");
        $("#supplier").val('').change();
        $('#layout_title').text('<?= lang("add_product"); ?>');
        $("#category").val("0").change();
        $("#subcategory").val("0").change();
        $("#brands").val("0").change();
        $("#unit").val("0").change();
        $("#vatShow").hide();
        $('#imageDiv').html('');
        $('[name="pro_code"]').removeAttr("readonly");
        $('[name="pro_code"]').attr('id', 'pro_code');
    }
    function getsubcategory(value) {
        //alert(value);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>product_settings/products/getsubcategory',
            data: 'id=' + value,
            success: function (result) {
                var html = '';
                console.log(result);
                var data = JSON.parse(result);
                // data =jQuery.parseJSON(result);
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
        var price_range = $('#priceRange').val();
        var brand_name = $('#brand_name').val();
        var inactive_product ='';
        if($('#inactive_pro').prop('checked')) {
            inactive_product=1;
        }  else {
            inactive_product=2;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>product/page_data/' + page_num,
            data: 'page=' + page_num + '&cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&price_range=' + price_range+ '&brand_name=' + brand_name+'&inactive_product='+inactive_product,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    function viewProductDetaitls(id) {
        //alert(id);
        $.ajax({
            url: "<?php echo base_url() ?>product/details/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                //console.log(data);
                $('.loading').fadeOut("slow");
                $('#pro_name_view').html(data.product_name);
                $('#pro_code_vw').html(data.product_code);
                $('#pro_category').html(data.cat_name);
                $('#pro_subCategory').html(data.sub_category);
                $('#pro_brands').html(data.brands);
                $('#pro_selling_price').html(data.sell_price);
                $('#pro_buying_price').html(data.buy_price);
                $('#pro_min_stock').html(data.min_stock);
                $('#pro_max_stock').html(data.max_stock);
                $('#pro_unit').html(data.unit_name);
                if(data.is_vatable==1){
                    $('#pro_vat').html(parseInt(data.default_vat) + '%');
                }else{
                    $('#pro_vat').html('0%');
                }
                $('#pro_supplier').html(data.supplier_name);
                //$('#pro_supplier').html(data.supplier_id);
                var photo = data.product_img;
                if (photo != '') {
                    var image_path = "<?php echo documentLink('product');?>" + photo;
                    var image = "<img src='" + image_path + "'  height='70' width='100'>";
                    $('#pro_imageDiv').html(image);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    function editProducts(id) {
        $('#imageDiv').html('');
        $.ajax({
            url: "<?php echo base_url() ?>product/edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (dataValue) {
                var result = dataValue;
                $('#layout_title').text('Edit Products');
                $('[name="pro_code"]').val(result.data.product_code);
                $('[name="id"]').val(result.data.id_product);
                $('#pro_name').val(result.data.product_name);
                $('#pro_name').attr('name', 'pr_name');
                $('[name="category"]').val(result.data.cat_id).change();
                $('[name="brands"]').val(result.data.brand_id).change();
                $('[name="unit"]').val(result.data.unit_id).change();
                $('[name="buying_price"]').val(result.data.buy_price);
                $('[name="selling_price"]').val(result.data.sell_price);
                $('[name="min_stock"]').val(result.data.min_stock);
                $('[name="max_stock"]').val(result.data.max_stock);
                $('[name="supplier_id"]').val(result.data.supplier_id);
                $('[name="image_dir"]').val(result.data.product_img);
                $('[name="pro_code"]').removeAttr("id");
                setTimeout(function () {
                    $('[name="subcategory"]').val(result.data.subcat_id).change();
                }, 1000);
                $("[name='vatType'][value=" + result.data.is_vatable + "]").prop("checked", true);
                if (result.data.is_unq_barcode == "1") {
                    $("[type='radio'][value='1']").prop("checked", true);
                } else {
                    $("[type='radio'][value='2']").prop("checked", true);
                }
                if (result.data.is_vatable == "1") {
                    $("#vatShow").show();
                    $("[type='radio'][value='Yes']").prop("checked", true);
                    $('[name="vat"]').val(parseInt(result.data.vat));
                } else {
                    $("#vatShow").hide();
                    $("[type='radio'][value='No']").prop("checked", true);
                }
                var photo = result.data.product_img;
                if (photo != '') {
                    var image_path = "<?php echo documentLink('product')?>" + photo;
                    if(ImageExist(image_path)){
                        var old_img = '<input type="hidden" name="old_image" id="old_image" value="' + photo + '" >';
                        var image = "<img src='" + image_path + "'  height='70' width='100'>" + old_img;
                        $('#imageDiv').html(image);
                    }
                }
                var html = "";
                for (var i = 0; i < result.suppliers.length; i++) {
                    var selected = "";
                    for (var j = 0; j < result.product_suppliers.length; j++) {
                        if (result.suppliers[i].id_supplier == result.product_suppliers[j].supplier_id) {
                            selected = "selected";
                        }
                    }
                    html += "<option " + selected + " value='" + result.suppliers[i].id_supplier + "'>" + result.suppliers[i].supplier_name + "</option>";
                }
                $('[id="supplier"]').html(html);

            },
            error: function (jqXHR, textStatus, errorThrown) {
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
    function deleteProductModal(id) {
        $('#product_delete_id').val(id);
    }
    function delete_procuct() {
        var id = $('#product_delete_id').val();
        var ck_id = $('#ch_stock_' + id).text();
        if (ck_id > 0) {
            $('#deleteProduct').modal('hide');
            $('#productEmptyAlert').modal('toggle');

        } else {
            $.ajax({
                url: "<?php echo base_url() . 'product/delete' ?>/" + id,
                type: "POST",
                dataType: "JSON",
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data) {
                    $('.loading').fadeOut("slow");
                    $('#showMessage').html('<?= lang("delete_success"); ?>');
                    $('#deleteProduct').modal('toggle');
                    window.onload = searchFilter(0);
                    $('#showMessage').show();
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }

    }


    $.validator.setDefaults({
        submitHandler: function (form) {
            var name = $('#pro_code').val();
            //var value = $(form).serialize();
            var currentForm = $('#product')[0];
            var formData = new FormData(currentForm);
            formData.append('file', document.getElementById("userfile").files[0]);
            //alert(formData);
            $.ajax({
                url: "<?= base_url() ?>product_settings/products/add_data",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (response) {
                    $('.loading').fadeOut("slow");
                    var result = $.parseJSON(response);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $('[name="' + key + '"]').addClass("error");
                            $('[name="' + key + '"]').after(' <label class="error">' + value + '</label>');
                        });
                    } else {
                        $('#product')[0].reset();
                        $('#add').modal('hide');
                        $('#showMessage').html(result.message);
                        window.onload = searchFilter(0);
                        $('#pro_name').attr('name', 'pro_name');
                        $('#showMessage').show();
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);

                        }, 3000);
                    }
                    //
                }
            });

        }
    });
    function csv_export() {
        var product_name = $('#product_name').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var price_range = $('#priceRange').val();
        var brand_name = $('#brand_name').val();
        var inactive_product ='';
        if($('#inactive_pro').prop('checked')) {
            inactive_product=1;
        }  else {
            inactive_product=2;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>product_settings/products/create_csv_data',
            data: 'cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&price_range=' + price_range+ '&brand_name=' + brand_name+'&inactive_product='+inactive_product,
        beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('.loading').fadeOut("slow");
                window.location.href = '<?php echo base_url(); ?>export_csv?request='+(html);
            }
        });
    }
    $(function () {

        $("#price-range").slider({
            range: true,
            min: 0,
            max: '<?=$max_val?>',
            values: [0, '<?=$max_val?>'],
            slide: function (event, ui) {
                $("#priceRange").val("<?= set_currency()?> " + ui.values[0] + " - <?= set_currency()?> " + ui.values[1]);
            }
        });
        $("#priceRange").val("<?= set_currency()?> " + $("#price-range").slider("values", 0) + " - <?= set_currency()?> " + $("#price-range").slider("values", 1));
    });


</script> 
