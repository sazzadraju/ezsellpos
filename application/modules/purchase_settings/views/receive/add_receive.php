<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>
<?php
$list_rack = '';
if (!empty($rack_list)) {
    foreach ($rack_list as $list) {
        $list_rack .= '<option value="' . $list->id_rack . '">' . $list->name . '</option>';
    }
}
if (!empty($posts)) {
    ?>
    <div class="content-i">
        <div class="content-box">
            <div class="row">
                <div class="col-lg-12">
                    <div class="element-wrapper">
                        <div class="top-btn full-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="searchData checkGroup" id="searchData">
                                        <?php
                                        $this->load->view('receive/show_order_data', $posts, false);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="rack_list" id="rack_list" value='<?php echo $list_rack; ?>'>
                        <form class="form-horizontal" role="form" id="add_orer_receive_data" action="" method="POST"
                              enctype="multipart/form-data">
                            <input type="hidden" name="supp_id" id="supp_id" value="<?= $orders[0]->supplier_id ?>">
                            <input type="hidden" name="order_id" id="order_id"
                                   value="<?= $orders[0]->id_purchase_order ?>">
                            <input type="hidden" name="store_id" id="store_id" value="<?= $orders[0]->store_id ?>">
                            <input type="hidden" name="batch_no" id="batch_no" value="<?php echo $batch_id; ?>">
                            <div class="element-box full-box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <input type="hidden" id="segment_id" value="0">
                                            <table id="addSection" class="table table-bordred table-striped">
                                                <thead>
                                                <tr>
                                                    <th rowspan="2"><?= lang('product_code') ?></th>
                                                    <th rowspan="2"><?= lang('product_name') ?></th>
                                                    <th rowspan="2"><?= lang('qty') ?></th>
                                                    <th colspan="2"><?= lang('price') ?></th>
                                                    <th rowspan="2"><?= lang('rack_id') ?></th>
                                                    <th rowspan="2"><?= lang('expiration_date') ?></th>
                                                    <th rowspan="2"><?= lang('alert_date') ?></th>
                                                    <th rowspan="2"><?= lang('batch') ?></th>
                                                    <th rowspan="2"><?= lang('total') ?></th>
                                                </tr>
                                                <tr>
                                                    <th><?= lang('purchase') ?></th>
                                                    <th><?= lang('sale') ?></th>
                                                </tr>
                                                </thead>
                                                <tbody id="add_section">


                                                </tbody>
                                                <tfoot>
                                                <tr id="row_sub_total" style="display:none">
                                                    <th colspan="2"></th>
                                                    <th id="sub_qty">00</th>
                                                    <th colspan="6"></th>
                                                    <th style=" margin-left: 10px;" id="sub_total">0TK</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            <div id="add_script"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="top-btn full-box" id="show_submit_tag" style="display:none;">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?= lang('stock_in_date') ?></label>
                                            <div class='col-sm-12'>
                                                <div class='input-group dateall' id='StockInDate'>
                                                    <input type='text' class="form-control dateall"
                                                           name="dtt_stock_mvt"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>												
                                                </span>
                                                </div>
                                                <span id="StockInDate-error" class="span_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"
                                                       for=""><?= lang('stock_in_doc') ?></label>
                                                <div class='col-sm-12'>
                                                    <input type="file" name="stock_in_doc" id="stock_in_doc">
                                                    <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
                                                    <span class="span_error" id="file_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?= lang('invoice_no') ?></label>
                                            <div class='col-sm-12'>
                                                <input class="form-control" type="text" id="invoice_no"
                                                       name="invoice_no" value="<?php echo $invoice_id; ?>"
                                                       onkeyup="check_invoice_number(this);">
                                                <input type="hidden" name="default_invoice_no" id="default_invoice_no"
                                                       value="<?php echo $invoice_id; ?>">
                                                <span id="invoice_no-error" class="span_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"
                                                   for=""><?= lang('stock_in_reason') ?></label>
                                            <div class="col-sm-12">

                                                <div class="row-fluid">
                                                    <select class="select2" data-live-search="true"
                                                            name="stock_mvt_reason_id" id="stock_mvt_reason_id"
                                                            onchange="reason_note(this);">
                                                        <option value="0"><?= lang('select_one') ?></option>
                                                        <?php
                                                        if (!empty($reason_list)) {
                                                            foreach ($reason_list as $list) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $list['id_stock_mvt_reason'] . '@' . $list['reason']; ?>"><?php echo $list['reason']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <label id="stock_mvt_reason_id-error" class="error"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="notes_section" style="display: none;">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label" for=""><?= lang('notes') ?></label>
                                            <div class='col-sm-12'>
                                                <input class="form-control" type="text" id="notes" name="notes">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="col-sm-12 col-form-label" for="">&nbsp</label>
                                        <button class="btn btn-primary" type="submit"> <?= lang('submit') ?></button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="element-wrapper">
                        <div class="element-box">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    echo 'No data found..';
}
$this->load->view('add_attributes', $attributes, false);

?>
<script type="text/javascript">
    var x = 1;
    var batch_inc = 1;
    function reason_note(elem) {
        var reason_val = $(elem).val();
        var check_reason = $("#stock_mvt_reason_id option[value='" + reason_val + "']").text();
        check_reason = check_reason.toLowerCase();
        if (check_reason == "others") {
            $('#notes').val('');
            $('#notes_section').show();
        } else {
            $('#notes_section').hide();
            $('#notes').val(check_reason);
        }
    }
    $("#add_orer_receive_data").submit(function () {
        //return false;
        if (validatefinalAddCart() != false) {
            var $html = '';
            $("div").removeClass("focus_error");
            var dataString = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>add_receive_data',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (dataArray) {
                    //console.log(dataArray);
                    //alert(dataArray);
                    var result = $.parseJSON(dataArray);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $('[name="' + key + '"]').addClass("error");
                            $('[name="' + key + '"]').after(' <label class="error">' + value + '</label>');
                        });
                        $('#validateAlert').modal('toggle');
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>purchase-receive";
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
            return false;
        } else {
            return false;
        }
    });
    function add_stock_cart() {
        if (validateStockCart() != false) {
            //get value from field start
            var product_id = $('#product_id').val();
            var unit_p = $('#unit_p').val();
            var quantity = $('#quantity').val();
            var ExpiryDate = $('#ExpiryDate').val();
            var AlertDate = $('#AlertDate').val();
            var product_name = $("#product_name").val();
            var product_code = $("#product_code").val();
            var purchase_price = $("#purchase_price").val();
            var sale_price = $("#sell_price_t").val();
            var product_vat_rate = $("#vat_t").val();
            var rows = $("#tot_rows").val();
            var batch_no = $("#batch_no").val();
            //get value from field end 
            var row_match = 0;
            var new_batch = null;
            var product_exist = "";
            var add_more_check = 1;
            var coutn = 0;
            var ck_er = 0;
            var namerrr = $('#f_expire_date').val();
            $('input[name^="name"]').each(function () {
                var p_nam = $(this).val();
                if (p_nam == product_name) {
                    $('input[name^="f_expire_date"]').each(function () {
                        //alert($(this).val());
                        if (ExpiryDate == $(this).val()) {
                            ck_er = 1;
                        }
                        if (ExpiryDate != $(this).val()) {
                            row_match = row_match * 1 + 1;
                        }
                    });
                }
                coutn = coutn * 1 + 1;
            });
            if (ck_er == 1) {
                $('#product_name-error').html("Product already exist");
                setTimeout(function () {
                    $('#product_name-error').html("");
                }, 2000);
                return false;

            } else {
                coutn = coutn * 1 + 1;
                if (row_match == 0) {
                    new_batch = batch_no;
                } else {
                    rows = rows * 1 + 1;
                    new_batch = batch_no + '-' + rows;
                }
                //var $html = null;
                //var fieldHTML = "<tr id='" + coutn + "'><td><section id='product_name_" + x + "'></section><input type='hidden' name='row_product_id[]' id='row_product_id_" + x + "'></td><td>tttt</td><td><input type='text' name='row_qty[]' id='row_qty_" + x + "'></td><td><input type='text' id='row_purchase_price_" + x + "' name='row_purchase_price[]'></td><td><input type='text' id='row_sale_price_" + x + "' name='row_sale_price[]'></td><td><select size='1' name='rack_id[]'><option value='0'><?= lang('select_one') ?></option>" + rack_list + "</select></td><td><input id='row_vat_rate_" + x + "' name='row_vat_rate[]' type='text' readonly='readonly'></td><td><input id='row_expire_date_" + x + "' name='row_expire_date[]' type='text' readonly='readonly'></td><td><input id='row_alert_date_" + x + "' name='row_alert_date[]' type='text' readonly='readonly'></td><td><input id='row_batch_no_" + x + "' name='row_batch_no[]' type='text' readonly='readonly'></td><td><button class='btn btn-danger btn-xs' onclick='removeMore(" + x + ");'>X</button></td></tr>";
                var $html = '<tr id="' + coutn + '">';
                $html += '<td>' + product_code + '<input type="hidden" name="code[]" value="' + product_code + '"><input type="hidden" name="details_id[]" value=""><input type="hidden" name="pro_id[]" value="' + product_id + '"></td>';
                $html += '<td>' + product_name + '<input type="hidden" name="name[]" value="' + product_name + '"></td>';
                $html += '<td><input style="width:50px;" class="form-control" onchange="change_price(this)" type="text" name="act_qty[]" value="' + quantity + '" id="act_qty_' + coutn + '"></td>';
                $html += '<td><input style="width:70px;" class="form-control Number" onchange="change_price(this)" type="text" name="unit_price[]" onchange="change_cart(' + coutn + ')" id="unit_price_' + coutn + '" value="' + unit_p + '">' + '</td>';
                $html += '<td><input style="width:60px;" class="form-control" type="text" name="sell_price[]" value="' + sale_price + '"></td>';
                $html += '<td><select class="select2" data-live-search="true" name="rack_id[]" id="rack_id[]">';
                $html += '<option value="0">Select One</option>';
                $html += '</select></td>';
                $html += '<td><input type="text" style="width:50px;" class="form-control Number" name="vat_v[]" value="' + product_vat_rate + '"></td>';
                $html += '<td><input type="text" class="form-control datepicker3"id="f_expire_date[]" name="f_expire_date[]" value="' + ExpiryDate + '"></td>';
                $html += '<td><input type="text" class="form-control datepicker3" name="f_alert_date[]" value="' + AlertDate + '"></td>';
                $html += '<td><input class="form-control" type="text" name="batch[]"  id="p_batch_' + coutn + '" value="' + new_batch + '"></td>';
                $html += '<td><input type="text" class="form-control" onchange="change_price(this)" id="total_price_' + coutn + '" name="total_price[]" value="' + (quantity * unit_p) + '"></td>';
                $html += '</tr>';
                //console.log($html);
                $("#tot_rows").val(rows);
                $('#addSection > tbody:last').append($html);
                var sum = 0;
                $("input[name='total_price[]']").each(function () {
                    sum += Number($(this).val());
                });
                var qty = 0;
                $("input[name='act_qty[]']").each(function () {
                    qty += Number($(this).val());
                });
                $("#sub_total").html(sum + 'TK');
                $("#sub_qty").html(qty);
            }
            $('#product_name').val('');
            $('#product_id').val('');
            $('#quantity').val('');
            $('#ExpiryDate').val('');
            $('#unit_p').val('');
            $('#AlertDate').val('');
            //add more section end

        } else {
            return false;
        }

    }
    function validateStockCart() {
        var product_id = $('#product_id').val();
        var unit_p = $('#unit_p').val();
        var quantity = $('#quantity').val();
        var ExpiryDate = $('#ExpiryDate').val();
        var AlertDate = $('#AlertDate').val();
        var AlertDate = $('#AlertDate').val();
        if (!($('#searchData').is(':empty'))) {
            $('#product_name-error').html("Please add cart data first");
            setTimeout(function () {
                $('#product_name-error').html("");
            }, 2000);
            return false;
        }
        if (product_id == "" || quantity == "" || unit_p == "") {
            $('#unit_p-error').html("");
            $('#product_name-error').html("");
            $('#quantity-error').html("");
            $('#expire_date-error').html("");
            $('#alert_date-error').html("");
            if (product_id == "") {
                $('#product_name-error').html("Product not be empty");
                setTimeout(function () {
                    $('#product_name-error').html("");
                }, 2000);
            }
            if (unit_p == "") {
                $('#unit_p-error').html("Unit Price not be empty");
                setTimeout(function () {
                    $('#unit_p-error').html("");
                }, 2000);
            }

            if (quantity == "") {
                $('#quantity-error').html("Quantity not be empty");
                setTimeout(function () {
                    $('#quantity-error').html("");
                }, 2000);
            } else if (!($.isNumeric(quantity))) {
                $('#quantity-error').html("Must be number");
                setTimeout(function () {
                    $('#quantity-error').html("");
                }, 2000);
            }

//            if (ExpiryDate == "") {
//                $('#expire_date-error').html("Exp. date not be empty");
//                setTimeout(function () {
//                    $('#expire_date-error').html("");
//                }, 2000);
//            }
//
//            if (AlertDate == "") {
//                $('#alert_date-error').html("Alert Date not be empty");
//                setTimeout(function () {
//                    $('#alert_date-error').html("");
//                }, 2000);
//            }
            return false;
        } else {
            return true;
        }
    }

    function validatefinalAddCart() {
        var error_count = 0;
        $('input[name^="act_qty"]').each(function () {
            var s_val = $(this).val();
            if (s_val == 0 || s_val == '') {
                error_count += 1;
                $(this).addClass("focus_error");
            } else {
                $(this).removeClass("focus_error");
            }
        });
        $('input[name^="unit_price"]').each(function () {
            var s_val = $(this).val();
            if (s_val == 0 || s_val == '') {
                error_count += 1;
                $(this).addClass("focus_error");
            } else {
                $(this).removeClass("focus_error");
            }
        });
        $('input[name^="total_price"]').each(function () {
            var s_val = $(this).val();
            if (s_val == 0 || s_val == '') {
                error_count += 1;
                $(this).addClass("focus_error");
            } else {
                $(this).removeClass("focus_error");
            }
        });
//        $('input[name^="f_expire_date"]').each(function () {
//            var s_val = $(this).val();
//            if (s_val == 0 || s_val == '') {
//                error_count += 1;
//                $(this).addClass("focus_error");
//            } else {
//                $(this).removeClass("focus_error");
//            }
//        });
//        $('input[name^="f_alert_date"]').each(function () {
//            var s_val = $(this).val();
//            if (s_val == 0 || s_val == '') {
//                error_count += 1;
//                $(this).addClass("focus_error");
//            } else {
//                $(this).removeClass("focus_error");
//            }
//        });
        $('input[name^="batch"]').each(function () {
            var s_val = $(this).val();
            if (s_val == 0 || s_val == '') {
                error_count += 1;
                $(this).addClass("focus_error");
            } else {
                $(this).removeClass("focus_error");
            }
        });

        var dtt_stock_mvt = $("input[name=dtt_stock_mvt]").val();
        var invoice_no = $("input[name=invoice_no]").val();
        if (dtt_stock_mvt == '') {
            $("input[name=dtt_stock_mvt]").addClass("focus_error");
            error_count += 1;
        }
        var file = $('#stock_in_doc').val();
        if (file != '') {
            var ext = $('#stock_in_doc').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'pdf', 'xls', 'xlsx', 'doc', 'docx']) == -1) {
                error_count += 1;
                $("input[name=stock_in_doc]").addClass("focus_error");
                // $('#file_error').html('Invoice select file type');
            } else {
                $("input[name=stock_in_doc]").removeClass("focus_error");
            }
        }
//        if (invoice_no == '') {
//            $("input[name=invoice_no]").addClass("focus_error");
//            error_count += 1;
//        }
        if (error_count > 0) {
            return false;
        } else {
            return true;
        }
    }
    function validateTempAddCart() {
        var error_count = 0;
        $('input[name^="act_qty"]').each(function () {
            var s_val = $(this).val();
            if (s_val == 0 || s_val == '') {
                error_count += 1;
                $(this).addClass("focus_error");
            } else {
                $(this).removeClass("focus_error");
            }
        });
        $('input[name^="unit_price"]').each(function () {
            var s_val = $(this).val();
            if (s_val == 0 || s_val == '') {
                error_count += 1;
                $(this).addClass("focus_error");
            } else {
                $(this).removeClass("focus_error");
            }
        });
        $('input[name^="total_price"]').each(function () {
            var s_val = $(this).val();
            if (s_val == 0 || s_val == '') {
                error_count += 1;
                $(this).addClass("focus_error");
            } else {
                $(this).removeClass("focus_error");
            }
        });
//        $('input[name^="f_expire_date"]').each(function () {
//            var s_val = $(this).val();
//            if (s_val == 0 || s_val == '') {
//                error_count += 1;
//                $(this).addClass("focus_error");
//            } else {
//                $(this).removeClass("focus_error");
//            }
//        });
//        $('input[name^="f_alert_date"]').each(function () {
//            var s_val = $(this).val();
//            if (s_val == 0 || s_val == '') {
//                error_count += 1;
//                $(this).addClass("focus_error");
//            } else {
//                $(this).removeClass("focus_error");
//            }
//        });
        if (error_count > 0) {
            return false;
        } else {
            return true;
        }
    }
    function change_price(ele) {
        var m_id = ele.id;
        var id = m_id.split('_').pop();
        var un_p = $("#unit_price_" + id).val();
        var qty = $("#act_qty_" + id).val();
        var t_price = $("#total_price_" + id).val();
        if ((un_p && qty) != '') {
            var chk_id = 'total_price_' + id;
            var chk_qty = 'act_qty_' + id;
            if (m_id == chk_qty) {
                var t_up = (un_p * qty).toFixed(2);
                $("#total_price_" + id).val(t_up);
            } else if (m_id == chk_id) {
                var p_un_p = (t_price / qty).toFixed(2);
                $("#unit_price_" + id).val(p_un_p);
            } else {
                var t_up = (un_p * qty).toFixed(2);
                $("#total_price_" + id).val(t_up);
            }
        }
        var sum = 0;
        $("input[name='total_price[]']").each(function () {
            sum += Number($(this).val());
        });
        var qty = 0;
        $("input[name='act_qty[]']").each(function () {
            qty += Number($(this).val());
        });
        $("#sub_total").html(sum + 'TK');
        $("#sub_qty").html(qty);
    }
    function product_list_suggest(elem) {
        var request = $('#product_name').val();
        $("#product_name").autocomplete({
            source: "<?php echo base_url(); ?>get_products_auto?request=" + request,
            focus: function (event, ui) {
                event.preventDefault();
                $("#product_id").val(ui.item.value);
                $("#product_name").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#product_name").val('');
                $("#product_id").val('');
                $("#product_code").val('');
                $("#product_code").val(ui.item.product_code);
                $("#product_name").val(ui.item.label);
                $("#product_id").val(ui.item.value);
                $("#sell_price_t").val(ui.item.sell_price);
                $("#vat_t").val(ui.item.vat);
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
                $('.loading').fadeOut("slow");
                var result = $.parseJSON(data);
                $('#add_attributes').modal('hide');
                if (validateStockCart() != false) {
                    //get value from field start
                    var product_id = $('#product_id').val();
                    var unit_p = $('#unit_p').val();
                    var quantity = $('#quantity').val();
                    var ExpiryDate = $('#ExpiryDate').val();
                    var AlertDate = $('#AlertDate').val();
                    var product_name = $("#product_name").val();
                    var product_code = $("#product_code").val();
                    var purchase_price = $("#purchase_price").val();
                    var sale_price = $("#sell_price_t").val();
                    var product_vat_rate = $("#vat_t").val();
                    var rows = $("#tot_rows").val();
                    var batch_no = $("#batch_no").val();
                    //get value from field end
                    var row_match = 0;
                    var new_batch = null;
                    var product_exist = "";
                    var add_more_check = 1;
                    var coutn = 0;
                    var ck_er = 0;
                    var namerrr = $('#f_expire_date').val();
                    $.each(result, function (ke, obj) {
                        var attr = '';
                        var attr_show = '';
                        var c = 1;

                        $.each(obj, function (key, value) {
                            //console.log(key + '=' + value);
                            // alert(key + '=' + value);
                            var coma = '';
                            if (c > 1) {
                                coma = ',';
                            }
                            var lastItem = key.split("@");
                            attr += coma + lastItem[0] + '=' + lastItem[1] + '=' + value;
                            attr_show += coma + lastItem[1] + '=' + value;
                            c += 1;
                        });
                        $('input[name^="name"]').each(function () {
                            var p_nam = $(this).val();
                            if (p_nam == product_name) {
                                $('input[name^="f_expire_date"]').each(function () {
                                    //alert($(this).val());
                                    if (ExpiryDate == $(this).val()) {
                                        ck_er = 1;
                                    }
                                    if (ExpiryDate != $(this).val()) {
                                        row_match = row_match * 1 + 1;
                                    }
                                });
                                $('input[name^="row_attr_value"]').each(function () {
                                    if (attr == $(this).val()) {
                                        ck_er = 1;
                                    }
                                    if (attr != $(this).val()) {
                                        row_match = row_match * 1 + 1;
                                    }
                                });
                            }
                            coutn = coutn * 1 + 1;
                        });
                        if (ck_er == 1) {
                            $('#product_name-error').html("Product already exist");
                            setTimeout(function () {
                                $('#product_name-error').html("");
                            }, 2000);
                            return false;

                        } else {
                            coutn = coutn * 1 + 1;
                            if (row_match == 0) {
                                new_batch = batch_no;
                            } else {
                                rows = rows * 1 + 1;
                                new_batch = batch_no + '-' + rows;
                            }
                            //var $html = null;
                            //var fieldHTML = "<tr id='" + coutn + "'><td><section id='product_name_" + x + "'></section><input type='hidden' name='row_product_id[]' id='row_product_id_" + x + "'></td><td>tttt</td><td><input type='text' name='row_qty[]' id='row_qty_" + x + "'></td><td><input type='text' id='row_purchase_price_" + x + "' name='row_purchase_price[]'></td><td><input type='text' id='row_sale_price_" + x + "' name='row_sale_price[]'></td><td><select size='1' name='rack_id[]'><option value='0'><?= lang('select_one') ?></option>" + rack_list + "</select></td><td><input id='row_vat_rate_" + x + "' name='row_vat_rate[]' type='text' readonly='readonly'></td><td><input id='row_expire_date_" + x + "' name='row_expire_date[]' type='text' readonly='readonly'></td><td><input id='row_alert_date_" + x + "' name='row_alert_date[]' type='text' readonly='readonly'></td><td><input id='row_batch_no_" + x + "' name='row_batch_no[]' type='text' readonly='readonly'></td><td><button class='btn btn-danger btn-xs' onclick='removeMore(" + x + ");'>X</button></td></tr>";
                            var $html = '<tr id="' + coutn + '">';
                            $html += '<td>' + product_code + '<input type="hidden" name="code[]" value="' + product_code + '"><input type="hidden" name="details_id[]" value=""><input type="hidden" name="pro_id[]" value="' + product_id + '"></td>';
                            $html += '<td>' + product_name + '<input type="hidden" name="name[]" value="' + product_name + '"></td>';
                            $html += '<td><input style="width:50px;" class="form-control" onchange="change_price(this)" type="text" name="act_qty[]" value="' + quantity + '" id="act_qty_' + coutn + '"></td>';
                            $html += '<td><input style="width:70px;" class="form-control Number" onchange="change_price(this)" type="text" name="unit_price[]" onchange="change_cart(' + coutn + ')" id="unit_price_' + coutn + '" value="' + unit_p + '">' + '</td>';
                            $html += '<td><input style="width:60px;" class="form-control" type="text" name="sell_price[]" value="' + sale_price + '"></td>';
                            $html += '<td><select class="select2" data-live-search="true" name="rack_id[]" id="rack_id[]">';
                            $html += '<option value="0">Select One</option>';
                            $html += '</select></td>';
                            $html += '<td><input type="text" style="width:50px;" class="form-control Number" name="vat_v[]" value="' + product_vat_rate + '"></td>';
                            $html += '<td><input type="text" class="form-control datepicker3"id="f_expire_date[]" name="f_expire_date[]" value="' + ExpiryDate + '"></td>';
                            $html += '<td><input type="text" class="form-control datepicker3" name="f_alert_date[]" value="' + AlertDate + '"></td>';
                            $html += '<td><input class="form-control" type="text" name="batch[]"  id="p_batch_' + coutn + '" value="' + new_batch + '"></td>';
                            $html += '<td><input type="text" class="form-control" onchange="change_price(this)" id="total_price_' + coutn + '" name="total_price[]" value="' + (quantity * unit_p) + '"></td>';
                            $html += '</tr>';
                            //console.log($html);
                            $("#tot_rows").val(rows);
                            $('#addSection > tbody:last').append($html);
                            var sum = 0;
                            $("input[name='total_price[]']").each(function () {
                                sum += Number($(this).val());
                            });
                            var qty = 0;
                            $("input[name='act_qty[]']").each(function () {
                                qty += Number($(this).val());
                            });
                            $("#sub_total").html(sum + 'TK');
                            $("#sub_qty").html(qty);
                        }
                    });
                    $('#product_name').val('');
                    $('#product_id').val('');
                    $('#quantity').val('');
                    $('#ExpiryDate').val('');
                    $('#unit_p').val('');
                    $('#AlertDate').val('');
                    //add more section end

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
</script>