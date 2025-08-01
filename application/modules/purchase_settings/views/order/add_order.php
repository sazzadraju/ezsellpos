<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="top-btn full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo base_url(); ?>purchase-order"
                                   class="btn btn-primary btn-rounded right margin-right-10"
                                   type="button"><?= lang('order_list') ?></a>
                            </div>
                        </div>
                        <?php
                        if (!isset($requisitions)) {
                            ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('category') ?> </label>
                                        <div class="col-sm-12">
                                            <select class="select2" data-live-search="true" id="pro_cat_name"
                                                    name="pro_cat_name">
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
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang('sub_category') ?> </label>
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
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang('brand_name') ?> </label>
                                        <div class="col-sm-12">
                                            <select class="select2" data-live-search="true" id="pro_brand"
                                                    name="pro_brand">
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
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('suppliers') ?> </label>
                                        <div class="col-sm-12">
                                            <select class="select2" data-live-search="true" id="pro_supplier"
                                                    name="pro_supplier">
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
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('product') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="product_name"
                                                   id="product_name" class="product_name"
                                                   onkeyup="product_list_suggest(this);">
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
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="searchData checkGroup" id="searchData">
                                    <?php
                                    if (isset($_REQUEST['id'])) {
                                        $store_id=(isset($_REQUEST['sid']))?$_REQUEST['sid']:$this->session->userdata['login_info']['store_id'];
                                        $data['suppliers'] = $this->purchase_model->getvalue_row('suppliers', 'id_supplier,supplier_name', array('status_id' => 1));
                                        $data['posts'] = $this->purchase_model->getRowsRequisition_order($store_id);
                                        $this->load->view('order/search_requisition_list', $data, false);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <form class="form-horizontal" role="form" id="add_orer_data" class="cmxform" action=""
                              method="POST" enctype="multipart/form-data">
                            <div class="element-box full-box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="addSection" class="table table-bordred table-striped">
                                                <thead>
                                                <tr>
                                                    <th><?= lang('product_code') ?></th>
                                                    <th><?= lang('product_name') ?></th>
                                                    <th><?= lang('buying_price') ?></th>
                                                    <th><?= lang('suppliers') ?></th>
                                                    <th><?= lang('qty') ?></th>
                                                    <th><?= lang('unit_price') ?></th>
                                                    <th><?= lang('total_price') ?></th>
                                                    <th><?= lang('add_attributes') ?></th>
                                                    <th align="center"><?= lang('action') ?></th>
                                                </tr>
                                                </thead>
                                                <tbody id="add_section">


                                                </tbody>
                                                <tfoot>
                                                <tr id="row_sub_total" style="display:none">
                                                    <th colspan="4" style="text-align:right;">Total:</th>
                                                    <th id="sub_qty">0</th>
                                                    <th> </th>
                                                    <th style=" margin-left: 10px;" id="sub_total">0TK</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            <div id="add_submit" style="display: none;">
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label
                                                            class="col-sm-12col-form-label"><?= lang("store_name"); ?></label>
                                                        <div class="col-sm-12">
                                                            <div class="row-fluid">
                                                                <?php
                                                                $s_id=0;
                                                                $dis='';$sec='';
                                                                if(isset($_REQUEST['sid'])){
                                                                    $s_id= $_REQUEST['sid'];
                                                                    $dis='disabled="disabled"';
                                                                    echo '<input type="hidden" name="store_name" value="'.$s_id.'">';
                                                                }
                                                                ?>
                                                                <select class="form-control" id="store_name" name="store_name" <?= $dis?>>
                                                                    <?php
                                                                    $select_one = '<option value="0">' . lang("select_one") . '</option>';
                                                                    echo ($this->session->userdata['login_info']['user_type_i92'] == 3) ? $select_one : '';
                                                                    foreach ($stores as $store) {
                                                                        if(isset($_REQUEST['sid'])){
                                                                            $sec=($s_id==$store->id_store)?'selected':'';
                                                                        }
                                                                        if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                                                            echo '<option value="' . $store->id_store . '"'.$sec.' >' . $store->store_name . '</option>';
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
                                                <?php
                                                $req_id = (isset($requisitions)) ? 1 : 2;
                                                ?>
                                                <input type="hidden" name="requisition_id" value="<?= $req_id ?>">

                                                <button type="submit" name="submit"
                                                        class="btn btn-primary right"><?= lang('submit') ?></button>
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
<!--Validation Alert Start-->
<div class="modal fade" id="validateAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('order_val_msg') ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Validation Alert End-->
<div class="modal fade" id="add_attributes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang('delect_this_entry') ?></h4>
            </div>
            <style>
                .attributes-color label {
                    float: left;
                    margin: 0 10px 10px 10px !important;
                }
            </style>
            <?php echo form_open_multipart('', array('id' => 'submit_add_attribute', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                <div id="error_msg" class="error"></div>
                <?php
                $sl = 1;
                foreach ($attributes as $attr) {
                    echo '<div class="row">';
                    echo '<div class="col-md-4">';
                    echo '<input class="main mn_' . $sl . '" id="' . $sl . '" name="main[]" value="' . $attr->id_attribute . '@' . $attr->attribute_name . '" type="checkbox">';
                    echo '<label style="font-weight:bold" for="' . $sl . '">' . $attr->attribute_name . '</label>';
                    echo '</div>';
                    echo '<div class="col-md-8 attributes-color checkGroup">';
                    $stringValue = $attr->attribute_value;
                    $ch = 1;
                    foreach (explode(',', $stringValue) AS $value) {
                        echo '<input class="ch_' . $sl . ' child_value" id="c_' . $ch . '_' . $sl . '" name="child[' . $attr->id_attribute . '][]" value="' . $value . '" type="checkbox">';
                        echo '<label for="c_' . $ch . '_' . $sl . '">' . $value . '</label>';
                        $ch++;
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '<hr>';
                    $sl++;
                }
                ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="selectedRow" id="selectedRow" value="">
                <input class="btn btn-primary" type="submit" value="<?= lang('submit') ?>"> </button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function searchFilter() {
        var product_name = $('#product_name').val();
        var cat_name = $('#pro_cat_name').val();
        var sub_category = $('#pro_sub_category').val();
        var brand = $('#pro_brand').val();
        var supplier = $('#pro_supplier').val();
        var values = $("input[name='id_pro[]']")
            .map(function () {
                return $(this).val();
            }).get();
        //console.log(values);
        //alert(product_name+cat_name+sub_category+brand);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>search_add_order',
            data: 'cat_name=' + cat_name + '&product_name=' + product_name + '&sub_category=' + sub_category + '&brand=' + brand + '&values=' + values + '&supplier=' + supplier,
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
    $("#add_orer_data").submit(function () {
        var $html = '';
        $("div").removeClass("focus_error");
        var error_count = 0;
        var store = $('#store_name option:selected').val();
        if (store == 0) {
            $('#store_name').addClass("focus_error");
            error_count += 1;
        } else {
            $('#store_name').removeClass("focus_error");
        }
        if (error_count == 0) {
            var dataString = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>add_order_data',
                data: dataString,
                async: false,
//                beforeSend: function () {
//                    $('.loading').show();
//                },
                success: function (dataArray) {
                    var result = $.parseJSON(dataArray);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {

                            $('input[name="' + key + '"]').each(function () {
                                //alert(i+'==='+val);
                                //alert(key[i]);
                                var s_val = $(this).val();
                                if (s_val == 0 || s_val == '') {
                                    $(this).addClass("focus_error");
                                }
//                            alert($(this).val());
                            });
                            $('select[name="' + key + '"]').each(function () {
                                //alert(i+'==='+val);
                                //alert(key[i]);
                                var s_val = $(this).val();
                                if (s_val == 0 || s_val == '') {
                                    $(this).addClass("focus_error");
                                }
//                            alert($(this).val());
                            });
                        });
                        $('#validateAlert').modal('toggle');
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>purchase-order";
                        }, 500);

                        $('.loading').fadeOut("slow");

                    }
                    $('.loading').fadeOut("slow");
                    return false;
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
    });
    function change(id) {
        var tot_p = $("#total_price_" + id),
            qty = $("#qty_" + id).val(),
            price = $("#unit_price_" + id).val();
        tot_p.val((qty * price));
    }
    function change_price(id) {
        var un_p = $("#unit_price_" + id),
            qty = $("#qty_" + id).val(),
            price = $("#total_price_" + id).val(),
            t_un_p = (price / qty);
        un_p.val(t_un_p);
    }
    function change_cart(id) {
        var tot_p = $("#total_price_" + id),
            qty = $("#qty_" + id).val(),
            price = $("#unit_price_" + id).val();
        tot_p.val((qty * price));
        var sum = 0;
        $("input[name='p_tot_p[]']").each(function () {
            sum += Number($(this).val());
        });
        var qty = 0;
        $("input[name='p_qty[]']").each(function () {
            qty += Number($(this).val());
        });
        $("#sub_total").html(sum + 'TK');
        $("#sub_qty").html(qty);
    }
    function change_price_cart(id) {
        var un_p = $("#unit_price_" + id),
            qty = $("#qty_" + id).val(),
            price = $("#total_price_" + id).val(),
            t_un_p = (price / qty);
        un_p.val(t_un_p);
        var sum = 0;
        $("input[name='p_tot_p[]']").each(function () {
            sum += Number($(this).val());
        });
        var qty = 0;
        $("input[name='p_qty[]']").each(function () {
            qty += Number($(this).val());
        });
        $("#sub_total").html(sum + 'TK');
        $("#sub_qty").html(qty);
    }

    $('.NumberOnly').keypress(function (evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    });
    $('.Number').keypress(function (event) {
        //alert('sd');
        if (event.which == 8 || event.which == 0) {
            return true;
        }
        if (event.which < 46 || event.which > 59) {
            return false;
            //event.preventDefault();
        } // prevent if not number/dot

        if (event.which == 46 && $(this).val().indexOf('.') != -1) {
            return false;
            //event.preventDefault();
        } // prevent if already dot
    });
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
    function add_row(id) {
        $('#selectedRow').val(id);
    }
    $("#submit_add_attribute").submit(function () {
        var id=$('#selectedRow').val();
        var product_code=$('#code_'+id).val();
        var product_name=$('#name_'+id).val();
        var buying_price=$('#b_price_'+id).val();
        var unit_price=$('#unit_price_'+id).val();
        var id_pro=$('#id_pro_'+id).val();
        //var rowCount = $('#add_section >tr').length;
        var rowCount = $('#add_section tr:last').attr('id');
        var dataString = new FormData($(this)[0]);
        dataString.append('product_code',product_code);
        dataString.append('product_name',product_name);
        dataString.append('buying_price',buying_price);
        dataString.append('unit_price',unit_price);
        dataString.append('id_pro',id_pro);
        dataString.append('p_row', rowCount);
        $.ajax({
            type: "POST",
            //dataType: "json",
            url: '<?php echo base_url(); ?>purchase_insert_attributes',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('.loading').fadeOut("slow");
                //alert(data);
                //var result = $.parseJSON(data);
                $('#add_attributes').modal('hide');
                $('#addSection > tbody:last').append(data);
                //alert(rowCount);
                removeMore(id);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;

    });
    function removeMore(id) {
        $("#" + id).remove();
        var sum = 0;
        $("input[name='p_tot_p[]']").each(function () {
            sum += Number($(this).val());
        });
        var qty = 0;
        $("input[name='p_qty[]']").each(function () {
            qty += Number($(this).val());
        });
        $("#sub_total").html(sum + 'TK');
        $("#sub_qty").html(qty);
    }


</script>
