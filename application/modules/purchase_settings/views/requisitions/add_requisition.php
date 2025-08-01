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
                    <div class="top-btn full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo base_url(); ?>requisitions"
                                   class="btn btn-primary btn-rounded right margin-right-10"
                                   type="button"><?= lang('requisition_list') ?></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('category') ?> </label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="pro_cat_name"
                                                name="pro_cat_name" onChange="getsubcategory(this.value)">
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
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('sub_category') ?> </label>
                                    <div class="col-sm-12">
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
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('brand_name') ?> </label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="pro_brand" name="pro_brand">
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
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('product') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="product_name" id="product_name"
                                               class="product_name" onkeyup="product_list_suggest(this);">
                                        <input type="hidden" name="product_id" id="product_id">
                                        <label id="product_name-error" class="error" for="product_name"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1">

                                <label class="col-sm-12 col-form-label">&nbsp;</label>
                                <button class="btn btn-info" onclick="searchFilter()"><?= lang('search') ?></button>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="searchData checkGroup" id="searchData">

                                </div>
                            </div>
                        </div>
                        <form class="form-horizontal" role="form" id="add_requisition" action="" method="POST"
                              enctype="multipart/form-data">
                            <div class="element-box full-box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="addSection" class="table table-bordred table-striped">
                                                <thead>
                                                <tr>
                                                    <th><?= lang('product_code') ?></th>
                                                    <th><?= lang('product_name') ?></th>
                                                    <th><?= lang('qty') ?></th>
                                                    <th align="center"><?= lang('action') ?></th>
                                                </tr>
                                                </thead>
                                                <tbody id="add_section">
                                                </tbody>
                                            </table>
                                            <div id="add_submit" style="display: none;">
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label
                                                            class="col-sm-12col-form-label"><?= lang("store_name"); ?></label>
                                                        <div class="col-sm-12">
                                                            <div class="row-fluid">
                                                                <select class="form-control" id="store_name" name="store_name">
                                                                    <?php
                                                                    $select_one = '<option value="0" selected>' . lang("select_one") . '</option>';
                                                                    echo ($this->session->userdata['login_info']['user_type_i92'] == 3) ? $select_one : '';
                                                                    foreach ($stores as $store) {
                                                                        if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                                                            echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                                        } else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
                                                                            echo '<option value="' . $store->id_store . '" selected>' . $store->store_name . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" name="submit" class="btn btn-primary right"><?= lang('submit') ?></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function searchFilter() {
        var product_name = $('#product_name').val();
        var cat_name = $('#pro_cat_name').val();
        var sub_category = $('#pro_sub_category').val();
        var brand = $('#pro_brand').val();
        var values = $("input[name='id_pro[]']")
            .map(function () {
                return $(this).val();
            }).get();
        console.log(values);
        //alert(product_name+cat_name+sub_category+brand);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>search_add_requisition',
            data: 'cat_name=' + cat_name + '&product_name=' + product_name + '&sub_category=' + sub_category + '&brand=' + brand + '&values=' + values,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                //console.log(html);
                $('#searchData').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

    function product_list_suggest(elem) {
        var request = $('#product_name').val();
        $("#product_name").autocomplete({
            source: "<?php echo base_url(); ?>get_products_auto?request=" + request,
            focus: function (event, ui) {
                event.preventDefault();
                $("#product_name").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#product_name").val('');
                $("#product_name").val(ui.item.label);
            }
        });

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
                $("#pro_sub_category").html(html);
                //$('#postList').html(html);

            }
        });
    }
    $("#add_requisition").submit(function () {
        var $html = '';
        var dataString = new FormData($(this)[0]);
        var error_count = 0;
        $('input[name^="qty"]').each(function () {
            var s_val = $(this).val();
            if (s_val == 0 || s_val == '') {
                error_count += 1;
                $(this).addClass("focus_error");
            } else {
                $(this).removeClass("focus_error");
            }
        });
        var store=$('#store_name option:selected').val();
        if(store==0){
            $('#store_name').addClass("focus_error");
            error_count += 1;
        } else{
            $('#store_name').removeClass("focus_error");
        }
        if (error_count == 0) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>add_requisition_data',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    //alert(result);
                    console.log(result);
                    var result = $.parseJSON(result);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');
                        });
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>requisitions";
                        }, 500);
                    }
                    $('.loading').fadeOut("slow");
                    return false;
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            return false;
        }
        return false;
    });

</script>