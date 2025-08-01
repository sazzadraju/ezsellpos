<style type="text/css">
    .focus_error {
        border: 1px solid red;
        background: #ffe6e6;
    }

    .span_error {
        color: #da4444;
    }
    .ul_container {}
    .ul_container label { display: block; }
    .ul_container ul {}
    .ul_container ul ul { list-style: none;  display: none;  }
    .ul_container ul { list-style: none;  display: block; }
    .auto-80 {
    border: 1px solid #ddd;
    margin: 0 auto;
    padding: 40px;
    width: 80%;
    background: #fff;
    box-shadow: 0px 0px 30px rgba(69, 101, 173, 0.1);
}
.margin-bottom-20 {
    margin-bottom: 20px !important;
}
</style>

<!-- <link rel="stylesheet" href="<?php //echo base_url(); ?>plugins/bootstrap_tree_view/css/tree_style.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="<?php //echo base_url(); ?>plugins/bootstrap_tree_view/js/jstree.min.js"></script>
<script src="<?php //echo base_url(); ?>plugins/bootstrap_tree_view/js/jstree.checkbox.js"></script> -->

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
                            <form role="form" id="enter_promotion" action="" method="POST"
                                  enctype="multipart/form-data">
                                <h6 class="element-header"><?= lang('promotion_settings'); ?></h6>
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"for=""><?= lang("promotion_type"); ?> <span class="req">*</span></label>
                                            <div class="col-sm-12">
                                                <select class="select2" id="type_id" name="type_id" onchange="promotion_type_settings();">
                                                    <option value="0" selected><?= lang('select_one') ?></option>
                                                    <?php foreach ($promotion_types as $key => $val): ?>
                                                        <option value="<?= $key; ?>"><?= $val; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <lebel id="type_id-error" class="error"></lebel>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"><?= lang("store_name"); ?><span class="req">*</span></label>
                                            <div class="col-sm-12">
                                                <div class="row-fluid">
                                                    <select class="select2" multiple="true" id="store_name" name="store_name[]">
                                                        <?php
                                                        foreach ($stores as $store) {
                                                            if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                                                echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                            } else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
                                                                echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <lebel id="store_name-error" class="error"></lebel>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label" for=""><?php echo $this->lang->line('title');?></label>
                                            <div class="col-sm-12">
                                                <input class="form-control" name="title" id="title" type="text">
                                                <lebel id="title-error" class="error"></lebel>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?php echo $this->lang->line('description'); ?></label>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" name="details" id="details"></textarea>
                                                <lebel id="details-error" class="error"></lebel>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group row" style="visibility: hidden;" id="min_purchase_amt">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?php echo $this->lang->line('min_purchase_amount'); ?></label>
                                            <div class="col-sm-12">
                                                <input class="form-control margin-bottom-20" name="purchase_amt_from"
                                                       id="purchase_amt_from" type="text">
                                                <lebel id="purchase_amt_from-error" class="error"></lebel>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?php echo $this->lang->line('validity_from'); ?></label>
                                            <div class="col-sm-12">
                                                <div class="input-group date" id="validate_from">
                                                    <input type="text" class="form-control" id="dt_from" name="dt_from">
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                </div>
                                                <lebel id="validate_from-error" class="error"></lebel>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?php echo $this->lang->line('validity_to'); ?></label>
                                            <div class="col-sm-12">
                                                <div class="input-group date" id="validate_to">
                                                    <input type="text" class="form-control" id="dt_to" name="dt_to">
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                </div>
                                                <lebel id="validate_to-error" class="error"></lebel>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="discount_tab">
                                        <div class="col-sm-2">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?php echo $this->lang->line('discount_amount'); ?></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="discount_amount" id="discount_amount"
                                                           type="text">
                                                    <lebel id="discount_amount-error" class="error"></lebel>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?php echo $this->lang->line('discount_type'); ?></label>
                                                <div class="col-sm-12">
                                                    <div class="col-sm-6">
                                                        <input id="percentage1" value="1" name="discount_type" checked=""
                                                               type="radio">
                                                        <label for="percentage1"><?= lang('percentage') ?></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input id="fixed1" value="2" name="discount_type" type="radio">
                                                        <label for="fixed1"><?= lang('fixed') ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                

                                <div class="col-sm-12">
                                    <div style="display: none;" id="promotion_on_pro">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"
                                                   for=""><?php echo $this->lang->line('promotion_on'); ?></label>
                                            <div class="col-sm-9">
                                                <div class="col-sm-2">
                                                    <input id="promotion_on_cat" value="1" name="promotion_on" checked="" type="radio" onclick="promotion_on_cehck(this);">
                                                    <label for="promotion_on_cat"><?= lang('cat_subcat') ?></label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input id="promotion_on_brand" value="2" name="promotion_on"
                                                           type="radio" onclick="promotion_on_cehck(this);">
                                                    <label for="promotion_on_brand"><?= lang('brand') ?></label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input id="promotion_on_cat_brand" value="3" name="promotion_on"
                                                           type="radio" onclick="promotion_on_cehck(this);">
                                                    <label for="promotion_on_cat_brand"><?= lang('both') ?></label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input id="promotion_on_product" value="4" name="promotion_on"
                                                           type="radio" onclick="promotion_on_cehck(this);">
                                                    <label for="promotion_on_product"><?= lang('product') ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="promotion_cart" style="display: none;">
                                    <div class="element-box full-box">
                                        <!--Hidden field value start-->

                                        <!--Hidden field value end-->
                                        <div class="col-md-3" id="show_prduct" style="display: none;">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang('product_name') ?> </label>
                                                <div class="col-sm-12">
                                                    <div class="row-fluid">
                                                        <input class="form-control" type="text" name="s_product" id="s_product">
                                                    </div>
                                                    <lebel id="s_product-error" class="error"></lebel>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="cat_dropdown">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang('category') ?> </label>
                                                <div class="col-sm-12">
                                                    <div class="row-fluid">
                                                        <select class="select2" id="cat_id" name="cat_id"
                                                                onchange="sub_cat_load();">
                                                            <option value="0" selected><?= lang('select_one') ?></option>
                                                            <?php
                                                            if (!empty($cat_list)) {
                                                                foreach ($cat_list as $list) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $list['id_product_category']; ?>"><?php echo $list['cat_name']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <lebel id="cat-error" class="error"></lebel>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" id="sub_cat_dropdown">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?php echo lang('sub_category') ?> </label>
                                                <div class="col-sm-12">
                                                    <div class="row-fluid">
                                                        <select class="select2" id="sub_cat_id" name="sub_cat_id">


                                                        </select>
                                                    </div>
                                                    <lebel id="sub_cat_id-error" class="error"></lebel>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" id="brand_dropdown">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?php echo lang('brand') ?> </label>
                                                <div class="col-sm-12">
                                                    <div class="row-fluid">
                                                        <select class="select2" id="brand_id" name="brand_id"
                                                                disabled="disabled">
                                                            <option value="0" selected><?= lang('select_one') ?></option>
                                                            <?php
                                                            if (!empty($brand_list)) {
                                                                foreach ($brand_list as $list) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $list['id_product_brand']; ?>"><?php echo $list['brand_name']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <lebel id="brand-error" class="error"></lebel>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="col-sm-12 col-form-label">&nbsp;</label>
                                            <button type="button" class="btn btn-info" onclick="add_promotion_cart();"><i
                                                    class="fa fa-plus"></i></button>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <input type="hidden" id="segment_id" value="0">
                                                    <input type="hidden" id="total_num_rows" name="total_num_rows"
                                                           value="0">
                                                    <input type="hidden" id="total_row_number" name="total_row_number"
                                                           value="0">
                                                    <table id="mytable" class="table table-bordred table-striped">
                                                        <thead>
                                                        <tr id="table_tr">
                                                            <th><?= lang('cat_subcat') ?></th>
                                                            <th><?= lang('brand') ?></th>
                                                            <th></th>

                                                        </tr>
                                                        <tr id="table_tr_p" style="display: none;">
                                                            <th><?= lang('product_name') ?></th>
                                                            <th><?= lang('product_code') ?></th>
                                                            <th><?= lang('batch_no') ?></th>
                                                            <th><?= lang('store_name') ?></th>
                                                            <th><?= lang('qty') ?></th>
                                                            <th><?= lang('purchase_price') ?></th>
                                                            <th><?= lang('selling_price') ?></th>
                                                            <th><?= lang('percentage') ?><br>
                                                                <input type="text" id="all" style="width: 40px;">
                                                                <button type="button" class="btn btn-primary btn-xs" onClick="inputAll()">Add</button>
                                                                
                                                            </th>
                                                            <th><?= lang('taka') ?></th>
                                                            <th></th>

                                                        </tr>
                                                        </thead>
                                                        <tbody id="add_more_section">


                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit" id="submit"> Submit</button>
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
</div>

<!--Validation Alert Start-->
<div class="modal fade" id="validateAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang('attention') ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li id="alert_msg"><span class="glyphicon glyphicon-warning-sign"></span></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Validation Alert End-->
<script>
    var serial = 1;
    var position = 0;
    $(function () {
        $('#validate_from').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

    });

    $(function () {
        $('#validate_to').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

    });
    $(document).on('input', '.change_value', function () {
        var m_id = this.id;
        var value= this.value;
       
        var id = m_id.split('_').pop(-1);
        var name=this.name;
        //var qty = $("#qty_" + id).val();
        var selling_price = $("#selling_price_" + id).val();
         if(name=='percet[]'){
            var amount=(selling_price*value)/100;
            $('#taka_'+id).val(amount);
         }else if(name=='taka[]'){
            var per=(value*100)/selling_price;
             $('#percet_'+id).val(parseFloat(per).toFixed(2));
         }
    });

    function inputAll(){
        var value = $('#all').val();
        $('input[name^="percet"]').each(function() {
            var m_id = this.id;
            var id = m_id.split('_').pop(-1);
            var selling_price = $("#selling_price_" + id).val();
            var amount=(selling_price*value)/100;
            $('#taka_'+id).val(parseFloat(amount).toFixed(2));
            $("#percet_" + id).val(value);
        });
    }
    function promotion_type_settings() {
        var type_id = $('#type_id').val();
        if (type_id == 1) {
            $('#min_purchase_amt').css('visibility', 'hidden');
            $('#purchase_amt_from').val('');
            $('#promotion_on_pro').show();
            $('#promotion_cart').show();
        } else if (type_id == 2) {
            $('#min_purchase_amt').css('visibility', 'visible');
            $('#promotion_on_pro').hide();
            $('#promotion_cart').hide();
        } else if (type_id == 3) {
            $('#min_purchase_amt').css('visibility', 'hidden');
            $('#purchase_amt_from').val('');
            $('#promotion_on_pro').hide();
            $('#promotion_cart').hide();
        }
    }

    function promotion_on_cehck(elem) {
        var id_val = $(elem).val();
        if (id_val == 1) {
            $('#add_more_section').html('');
            $('#cat_id').val("0").change();
            $('#sub_cat_id').val("0").change();
            $('#brand_id').val("0").change();
            $('#cat_id').prop('disabled', false);
            $('#sub_cat_id').prop('disabled', false);
            $('#brand_id').prop('disabled', true);
            $('#table_tr').show();
            $('#table_tr_p').hide();
            $('#discount_tab').show();
            $('#discount_amount').val('');
            $('#show_prduct').hide();
        } else if (id_val == 2) {
            $('#add_more_section').html('');
            $('#cat_id').val("0").change();
            $('#sub_cat_id').val("0").change();
            $('#brand_id').val("0").change();
            $('#cat_id').prop('disabled', true);
            $('#sub_cat_id').prop('disabled', true);
            $('#brand_id').prop('disabled', false);
            $('#table_tr').show();
            $('#table_tr_p').hide();
            $('#discount_tab').show();
            $('#discount_amount').val('');
            $('#show_prduct').hide();
        } else if (id_val == 3) {
            $('#add_more_section').html('');
            $('#cat_id').val("0").change();
            $('#sub_cat_id').val("0").change();
            $('#brand_id').val("0").change();
            $('#cat_id').prop('disabled', false);
            $('#sub_cat_id').prop('disabled', false);
            $('#brand_id').prop('disabled', false);
            $('#table_tr').show();
            $('#table_tr_p').hide();
            $('#discount_tab').show();
            $('#discount_amount').val('');
            $('#show_prduct').hide();
        }else if (id_val == 4) {
            $('#add_more_section').html('');
            $('#cat_id').val("0").change();
            $('#sub_cat_id').val("0").change();
            $('#brand_id').val("0").change();
            $('#cat_id').prop('disabled', false);
            $('#sub_cat_id').prop('disabled', false);
            $('#brand_id').prop('disabled', false);
            $('#table_tr').hide();
            $('#table_tr_p').show();
            $('#show_prduct').show();
            $('#discount_tab').hide();
            
        }
    }

    function sub_cat_load() {
        var cat_id = $('#cat_id').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>promotion-management/get_sub_cat',
            data: {cat_id: cat_id},
            success: function (data) {
                var result = $.parseJSON(data);
                if (result) {
                    var html = "<option value='0'>" + "<?= lang('select_one');?>" + "</option>";
                    for (var i = 0; i < result.subcat_list.length; i++) {
                        html += "<option value='" + result.subcat_list[i].id_product_category + "'>" + result.subcat_list[i].cat_name + "</option>";
                    }

                    $('#sub_cat_id').html(html);
                }

            }
        });

    }


    function add_promotion_cart() {
        var cat_id = $('#cat_id').val();
        var sub_cat_id = $('#sub_cat_id').val();
        var brand_id = $('#brand_id').val();
        var total_num_rows = $('#total_num_rows').val();
        //var store_name = $('#store_name option:selected').val();
        var store_name='';
        $("#store_name :selected").map(function(i, el) {
            if(store_name!=''){
               store_name+=',';
            }
            store_name+= $(el).val();
        }).get();
        var promotion_on = $('input[name="promotion_on"]:checked').val();
        // console.log(cat_id+''+sub_cat_id+''+brand_id);
        // $('input[name="promotion_on"]:checked').each(function () {
        //     promotion_on = this.value;
        // });
        $('#cat-error').html('');
        $('#brand-error').html('');
        $('#store_name-error').html('');
        //alert(store_name);
        if (store_name == '') {
            $('#store_name-error').html("<?php echo lang('select_one');?>");
            return false;
        }

        if (promotion_on == 1) {
            if (cat_id == 0) {
                $('#cat-error').html("<?php echo lang('select_one');?>");
                return false;
            }
        }

        if (promotion_on == 2) {
            if (brand_id == 0) {
                $('#brand-error').html("<?php echo lang('select_one');?>");
                return false;
            }
        }

        if (promotion_on == 3) {

            if (cat_id == 0 || brand_id == 0) {
                if (cat_id == 0) {
                    $('#cat-error').html("<?php echo lang('select_one');?>");
                }

                if (brand_id == 0) {
                    $('#brand-error').html("<?php echo lang('select_one');?>");
                }
                return false;
            }
        }

        for (var k = 0; k < total_num_rows; k++) {
            if (promotion_on == 1) {
                if (sub_cat_id == 0 && cat_id == $('#parent_' + k).val()) {
                    $('#validateAlert').modal('toggle');
                    $('#alert_msg').html("<?php echo lang('same_entry_exist');?>");
                    return false;
                }

                if (sub_cat_id == 0 && cat_id == $('#child_' + k).val()) {
                    $('#validateAlert').modal('toggle');
                    $('#alert_msg').html("<?php echo lang('parent_cat_exist');?>");
                    return false;
                }

                if (sub_cat_id != 0 && sub_cat_id == $('#promo_cat_id_' + k).val()) {
                    $('#validateAlert').modal('toggle');
                    $('#alert_msg').html("<?php echo lang('same_entry_exist');?>");
                    return false;
                }

                if (sub_cat_id != 0 && (cat_id == $('#parent_' + k).val())) {
                    $('#validateAlert').modal('toggle');
                    $('#alert_msg').html("<?php echo lang('same_entry_exist');?>");
                    return false;
                }

            }

            if (promotion_on == 2) {
                if (brand_id != 0 && brand_id == $('#promo_brand_id_' + k).val()) {
                    $('#validateAlert').modal('toggle');
                    $('#alert_msg').html("<?php echo lang('same_entry_exist');?>");
                    return false;
                }
            }

            if (promotion_on == 3) {
                if ((cat_id != 0 || cat_id != "") && $('#promo_cat_id_' + k).val() == cat_id && $('#promo_brand_id_' + k).val() == brand_id) {
                    $('#validateAlert').modal('toggle');
                    $('#alert_msg').html("<?= lang('same_entry_exist');?>");
                    return false;
                } else if ((sub_cat_id != 0 || sub_cat_id != "") && $('#promo_cat_id_' + k).val() == sub_cat_id && $('#promo_brand_id_' + k).val() == brand_id) {
                    $('#validateAlert').modal('toggle');
                    $('#alert_msg').html("<?= lang('same_entry_exist');?>");
                    return false;
                } else if (cat_id != 0 && sub_cat_id == 0 && (cat_id == $('#child_' + k).val()) && ($('#promo_brand_id_' + k).val() == brand_id)) {
                    $('#validateAlert').modal('toggle');
                    $('#alert_msg').html("<?= lang('child_cat_exist');?>");
                    return false;
                }

                // else if((cat_id != 0 || cat_id != "") && cat_id == $('#child_'+k).val()){
                //     $('#validateAlert').modal('toggle');
                //     $('#alert_msg').html("<?= lang('child_cat_exist');?>");
                //     return false;
                // }
            }


            // if(sub_cat_id != 0 && cat_id == $('#parent_'+k).val() && brand_id == $('#promo_brand_id_'+k).val()){
            //     $('#validateAlert').modal('toggle');
            //     $('#alert_msg').html("<?php //echo lang('parent_cat_exist');?>");
            //     return false;
            // }

            // if((cat_id != 0 || cat_id != "") && $('#promo_cat_id_'+k).val() == cat_id && $('#promo_brand_id_'+k).val() == brand_id){
            //     $('#validateAlert').modal('toggle');
            //     $('#alert_msg').html("<?php //echo lang('same_entry_exist');?>");
            //     return false;
            // }else if((sub_cat_id != 0 || sub_cat_id != "") && $('#promo_cat_id_'+k).val() == sub_cat_id && $('#promo_brand_id_'+k).val() == brand_id){
            //     $('#validateAlert').modal('toggle');
            //     $('#alert_msg').html("<?php //echo lang('same_entry_exist');?>");
            //     return false;
            // }
        }
        if(promotion_on!=4)
        {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>promotion-management/promotion_cart_details',
                data: 'cat_id=' + cat_id + '&sub_cat_id=' + sub_cat_id + '&brand_id=' + brand_id,
                success: function (data) {
                    var result = $.parseJSON(data);
                    if (result) {
                        if (result.check == 1 && result.brand_list == "") {
                            for (var i = 0; i < result.cat_sub_list.length; i++) {
                                var html = "<tr id='" + serial + "'>";
                                html += "<td><input type='hidden' name='promo_sub_cat_id[]' id='promo_sub_cat_id' value='" + sub_cat_id + "'><input type='hidden' name='parent' id='parent_" + position + "' value='" + result.cat_sub_list[i].id_product_category + "'><input type='hidden' name='promo_cat_id[]' value='" + result.cat_sub_list[i].id_product_category + "' id='promo_cat_id_" + position + "'>" + result.cat_sub_list[i].cat_name + " (<?= lang('category');?>)" + "</td><td><input type='hidden' name='promo_brand_id[]' value='' id='promo_brand_id_" + position + "'>" + "" + "</td><td> <button class='btn btn-danger btn-xs' onclick='removeMore(" + serial + ");'>X</button></td>";
                                html += "</tr>";
                                serial++;
                                position++;
                                var total_num_rows = $('#total_num_rows').val();
                                $('#total_num_rows').val(total_num_rows * 1 + 1);
                                var total_row_number = $('#total_row_number').val();
                                $('#total_row_number').val(total_row_number * 1 + 1);

                            }
                        } else if (result.check == 2 && result.brand_list == "") {
                            for (var i = 0; i < result.cat_sub_list.length; i++) {
                                var html = "<tr id='" + serial + "'>";
                                html += "<td><input type='hidden' name='promo_cat_id[]' id='promo_cat_id_" + position + "' value='" + cat_id + "'><input type='hidden' name='child' id='child_" + position + "' value='" + result.cat_sub_list[i].parent_cat_id + "'><input type='hidden' name='promo_sub_cat_id[]' value='" + result.cat_sub_list[i].id_product_category + "' id='promo_cat_id_" + position + "'>" + result.cat_sub_list[i].cat_name + "</td><td><input type='hidden' name='promo_brand_id[]' value='' id='promo_brand_id_" + position + "'>" + "" + "</td><td> <button class='btn btn-danger btn-xs' onclick='removeMore(" + serial + ");'>X</button></td>";
                                html += "</tr>";
                                serial++;
                                position++;
                                var total_num_rows = $('#total_num_rows').val();
                                $('#total_num_rows').val(total_num_rows * 1 + 1);
                                var total_row_number = $('#total_row_number').val();
                                $('#total_row_number').val(total_row_number * 1 + 1);
                            }
                        } else if (result.check == "" && result.brand_list != "") {
                            for (var j = 0; j < result.brand_list.length; j++) {
                                var html = "<tr id='" + serial + "'>";
                                html += "<td></td><td><input type='hidden' name='promo_brand_id[]' value='" + result.brand_list[j].id_product_brand + "' id='promo_brand_id_" + position + "'>" + result.brand_list[j].brand_name + "</td><td> <button class='btn btn-danger btn-xs' onclick='removeMore(" + serial + ");'>X</button></td>";
                                html += "</tr>";
                                serial++;
                                position++;
                                var total_num_rows = $('#total_num_rows').val();
                                $('#total_num_rows').val(total_num_rows * 1 + 1);
                                var total_row_number = $('#total_row_number').val();
                                $('#total_row_number').val(total_row_number * 1 + 1);
                            }

                        } else if (result.check == 1 && result.brand_list != "") {
                            for (var i = 0; i < result.cat_sub_list.length; i++) {
                                for (var j = 0; j < result.brand_list.length; j++) {
                                    var html = "<tr id='" + serial + "'>";
                                    html += "<td><input type='hidden' name='promo_sub_cat_id[]' id='promo_sub_cat_id' value='" + sub_cat_id + "'><input type='hidden' name='parent' id='parent_" + position + "' value='" + result.cat_sub_list[i].id_product_category + "'><input type='hidden' name='promo_cat_id[]' value='" + result.cat_sub_list[i].id_product_category + "' id='promo_cat_id_" + position + "'>" + result.cat_sub_list[i].cat_name + " (<?= lang('category');?>)" + "</td><td><input type='hidden' name='promo_brand_id[]' value='" + result.brand_list[j].id_product_brand + "' id='promo_brand_id_" + position + "'>" + result.brand_list[j].brand_name + "</td><td> <button class='btn btn-danger btn-xs' onclick='removeMore(" + serial + ");'>X</button></td>";
                                    html += "</tr>";
                                    serial++;
                                    position++;
                                    var total_num_rows = $('#total_num_rows').val();
                                    $('#total_num_rows').val(total_num_rows * 1 + 1);
                                    var total_row_number = $('#total_row_number').val();
                                    $('#total_row_number').val(total_row_number * 1 + 1);

                                }

                            }
                        } else if (result.check == 2 && result.brand_list != "") {
                            for (var i = 0; i < result.cat_sub_list.length; i++) {
                                for (var j = 0; j < result.brand_list.length; j++) {
                                    var html = "<tr id='" + serial + "'>";
                                    html += "<td><input type='hidden' name='promo_cat_id[]' id='promo_cat_id' value='" + cat_id + "'><input type='hidden' name='child' id='child_" + position + "' value='" + result.cat_sub_list[i].parent_cat_id + "'><input type='hidden' name='promo_sub_cat_id[]' value='" + result.cat_sub_list[i].id_product_category + "' id='promo_cat_id_" + position + "'>" + result.cat_sub_list[i].cat_name + "</td><td><input type='hidden' name='promo_brand_id[]' value='" + result.brand_list[j].id_product_brand + "' id='promo_brand_id_" + position + "'>" + result.brand_list[j].brand_name + "</td><td> <button class='btn btn-danger btn-xs' onclick='removeMore(" + serial + ");'>X</button></td>";
                                    html += "</tr>";
                                    serial++;
                                    position++;
                                    var total_num_rows = $('#total_num_rows').val();
                                    $('#total_num_rows').val(total_num_rows * 1 + 1);
                                    var total_row_number = $('#total_row_number').val();
                                    $('#total_row_number').val(total_row_number * 1 + 1);
                                }

                            }
                        }

                        $('#add_more_section').append(html);
                    }

                }
            });
        }else{
            var s_product = $('#s_product').val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>promotion_management/promotion_settings/promotion_cart_details_product',
                data: 'cat_id=' + cat_id + '&sub_cat_id=' + sub_cat_id + '&brand_id=' + brand_id+ '&store_name=' + store_name+ '&s_product=' + s_product,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data) {
                    $('.loading').fadeOut("slow");
                    //var result = $.parseJSON(data);
                    $('#add_more_section').html(data);
                }
            });
        }

       


    }


    function removeMore(id) {
        $("#" + id).remove();
        var total_row_number = $('#total_row_number').val();
        $('#total_row_number').val(total_row_number * 1 - 1);


    }

    function validate_promotion_enter() {
        var type_id = $('#type_id').val();
        var store_name = $('#store_name').val();
        var title = $('#title').val();
        var discount_amount = $('#discount_amount').val();
        var promotion_on = $("input[name=promotion_on]:checked").val();
        var inDateStr = $('#dt_from').val();
        var endDateStr = $('#dt_to').val();
        var inDate = new Date(inDateStr);
        var eDate = new Date(endDateStr);
        var in_date = inDate.getTime();
        var end_date = eDate.getTime();
        var check_pomotion = 0;
        var cat_id = $('#cat_id').val();
        var brand_id = $('#brand_id').val();
        if (type_id == 1) {
            if (promotion_on == 1 && cat_id != 0) {
                check_pomotion = 1;
            }

            if (promotion_on == 2 && brand_id != 0) {
                check_pomotion = 1;
            }

            if (promotion_on == 3 && brand_id != 0 && cat_id != 0) {
                check_pomotion = 1;
            }

            var purchase_amt_from = '1';
        } else if (type_id == 2) {
            var purchase_amt_from = $('#purchase_amt_from').val();
            var cat_checked = 'not needed';
            var brand_checked = 'not needed';
            check_pomotion = 2;
        } else {
            var purchase_amt_from = '1';
            var cat_checked = 'not needed';
            var brand_checked = 'not needed';
            check_pomotion = 2;
        }

        console.log(type_id + '--' + title + '--' + inDateStr + '--' + endDateStr + '--' + end_date + '--' + in_date + '--' + purchase_amt_from + '--' + discount_amount + '--' + cat_checked + '--' + brand_checked + '--' + check_pomotion);


        if (type_id == 0 || title == "" || inDateStr == "" || endDateStr == "" || end_date < in_date || purchase_amt_from == "" || !($.isNumeric(purchase_amt_from)) || (discount_amount == "" && promotion_on != 4)|| (!($.isNumeric(discount_amount))&& promotion_on != 4) || check_pomotion == 0|| store_name=='') {
            var chk=1;
            $('#type_id-error').html('');
            $('#title-error').html('');
            $('#validate_from-error').html('');
            $('#validate_to-error').html('');
            $('#purchase_amt_from-error').html('');
            $('#discount_amount-error').html('');
            $('#cat-error').html('');
            $('#brand-error').html('');
            $('#store_name-error').html('');

            if (type_id == 0) {
                $('#type_id-error').html("<?php echo lang('select_one');?>");
                chk=2;
            }
            if (store_name == null) {
                $('#store_name-error').html("<?php echo lang('select_one');?>");
                chk=2;
            }

            if (title == "") {
                $('#title-error').html("<?php echo lang('must_not_be_empty');?>");
                chk=2;
            }

            if (type_id == 2) {
                if (purchase_amt_from == "") {
                    $('#purchase_amt_from-error').html("<?php echo lang('must_not_be_empty');?>");
                    chk=2;
                } else if (!($.isNumeric(purchase_amt_from))) {
                    $('#purchase_amt_from-error').html("<?php echo lang('must_be_number');?>");
                    chk=2;
                }
            }

            if (type_id == 1 && promotion_on == 1) {
                if (cat_id == "" || cat_id == 0) {
                    $('#cat-error').html("<?php echo lang('must_not_be_empty');?>");
                    chk=2;
                }
            }

            if (type_id == 1 && promotion_on == 2) {
                if (brand_id == "" || brand_id == 0) {
                    $('#brand-error').html("<?php echo lang('must_not_be_empty');?>");
                    chk=2;
                }
            }

            if (type_id == 1 && promotion_on == 3) {
                if (cat_id == "" || cat_id == 0) {
                    $('#cat-error').html("<?php echo lang('must_not_be_empty');?>");
                    chk=2;
                }

                if (brand_id == "" || brand_id == 0) {
                    $('#brand-error').html("<?php echo lang('must_not_be_empty');?>");
                    chk=2;
                }
            }

            if (inDateStr == "") {
                $('#validate_from-error').html("<?php echo lang('must_not_be_empty');?>");
                chk=2;
            }

            if (endDateStr == "") {
                $('#validate_to-error').html("<?php echo lang('must_not_be_empty');?>");
                chk=2;
            }

            if (end_date < in_date) {
                $('#validate_from-error').html("<?php echo lang('check_in_date');?>");
                $('#validate_to-error').html("<?php echo lang('check_end_date');?>");
                chk=2;
            }
            if(promotion_on != 4){
                if (discount_amount == "") {
                    $('#discount_amount-error').html("<?php echo lang('must_not_be_empty');?>");
                    chk=2;
                } else if (!($.isNumeric(discount_amount))) {
                    $('#discount_amount-error').html("<?php echo lang('must_be_number');?>");
                    chk=2;
                }
            }

           
            if(chk==1){
                return true;
            }else{
                return false;
            }
            // console.log('false');
            
        } else {
            return true;
        }

    }


    $("#enter_promotion").submit(function () {
        if (validate_promotion_enter() != false) {
            var dataString = new FormData($(this)[0]);
            //console.log(dataString);
            
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>promotion_insert',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data) {
                    var result = $.parseJSON(data);
                    
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');
                        });
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>promotion-management";

                        }, 3000);
                        $('.loading').fadeOut("slow");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        } else {
            return false;
        }
    });


</script>