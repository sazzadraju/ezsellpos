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

<div id="full" class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-md-10">
                <div class="element-box full-box margin-0">
                    <h6 class="element-header" id=""><span id="layout_title"><?= lang('sale_returns')?></span></h6>
                    <div class="row">
                        <div class="col-md-8">
                            <form class="sales-search" role="search" id="return_to_cart">
                                <div class="col-md-11 col-sm-10">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="<?= lang('invoice_no')?>" type="text" id="invoice" name="invoice">
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-2">
                                    <button type="submit" class="btn btn-default right"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                           <div id="post_data">

                           </div>
                        </div>

                    </div>
                    <div id="return_data_add">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


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
                        <li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('qty_limit_msg') ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="restore_hold" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div id="restore_hold_data"></div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div id="SaleDetails" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Sale Invoice Details</h6>
            </div>
            <div class="modal-body">
                <div class="sale-view" id="sale_view">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="sale_print()">Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"
                        onclick="location.reload()">Close
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function sale_print() {
        $("#sale_view").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/sale_print.css",
            iframe: false,
            noPrintSelector: ".avoid-this",
            // append : "Free jQuery Plugins!!!<br/>",
            // prepend : "<br/>jQueryScript.net!"
        });
        //$.print("#sale_view");

    }
    function checkbox(ele) {
        var id_full=ele.id;
        var id = id_full.split("_").pop(-1);
        if(ele.checked){
            $("#return_qty_"+id).prop('disabled', false);
        } else{
            $("#return_qty_"+id).val('');
            $("#return_qty_"+id).prop('disabled', true);
        }

//        $(this).click(function() {
//            if ($(this).is(':checked')) {
//                $(e).find('input').attr('disabled', true);
//            } else {
//                $(e).find('input').removeAttr('disabled');
//            }
//        });
    }
    $("#return_to_cart").submit(function () {
        var $html = '';
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>temp_add_return_sale',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
               // alert(result);
                //console.log(result);
                $('#post_data').html(result);
                $('.loading').fadeOut("slow");
                return false;
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    function total_purchase_discount(val) {
        $.ajax({
            type: "GET",
            url: '<?php echo base_url(); ?>total_purchase_discount?request=' + val,
            async: false,
            success: function (result) {
                alert(result);
            }
        });
    }
    function add_cart_discount(ele) {
        var val = ele.value;
        if (val != 0) {
            var val_data = val.split('@')[1];
            var chk_dis = $('#cart_dis').text();
            if (chk_dis) {
                $('#cart_dis').html(val_data);
            } else {
                var div = '<div id="card"><strong>Card Dis. <b id="cart_dis">' + val_data + '</b>%:</strong><span id="cart_dis_total"> 00</span>&nbsp;</div>';
                $('#all_discount').append(div);
            }
            totalCalculation();
        }
    }
    function discount(ele) {
        var id = ele.id;
        var val = ele.value;
        if (val != '') {
            if (id === 'percent') {
                $('#dis_per').html(val + '%');
                $("#taka").prop("disabled", true);
            } else {
                $('#dis_taka').html(val);
                $("#percent").prop("disabled", true);
            }
        } else {
            $('#dis_per').html('');
            $('#dis_taka').html('00');
            $("#percent").prop("disabled", false);
            $("#taka").prop("disabled", false);
        }
        totalCalculation()

    }
    $("#add_product_to_cart").submit(function () {
        var $html = '';
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>temp_add_cart_for_sales',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                //alert(result);
                //console.log(result);
                if (result != '1') {
                    var $product = $.parseJSON(result);
                    //console.log($product.purchase_dis);
                    var rowCount = $('#addSection >tbody >tr').length;
                    rowCount += 1;
                    $(this).attr('id');
                    var id_value, batch_value, id, check_id, check = 0;
                    $("input[name='pro_id[]']").each(function () {
                        id_value = $(this).val();
                        var id_full = $(this).attr('id');
                        id = id_full.split("_").pop(-1);
                        batch_value = $('#batch_' + id + ' :selected').val();
                        if ((id_value == $product.data[0]['id_product']) && ($product.data[0]['batch_no'] == batch_value)) {
                            //alert(batch_value);
                            check = 2;
                            check_id = id
                        }
                    });
                    //alert(batch_value + '=' + id_value);
                    if (check == 2) {
                        var qty_val = $('#qty_' + check_id).val();
                        var qty = qty_val * 1 + 1;
                        $('#qty_' + check_id).val(qty);
                        var discount_amount;
                        var un_p = $("#unit_price_" + check_id).val();
                        var discount = $("#discount_" + check_id).val();
                        var discount_type = $("#discount_type_" + check_id).val();
                        if (discount_type == 'TK') {
                            discount_amount = discount;
                        } else {
                            discount_amount = (un_p * discount) / 100;
                        }
                        var tot_val = (qty * un_p) - (discount_amount * qty);
                        $("#total_price_" + check_id).val(tot_val);
                    } else {
                        var $html;
                        var dis_val = 0, amt_type = '', promo_id = '', total_discount_amount = 0, dis_amt = 0;
                        //promo_id = 0;
                        if ($product.discount != '') {
                            dis_amt = $product.discount;
                            dis_val = dis_amt.split(' ')[0];
                            amt_type = dis_amt.split(' ')[1];
                            promo_id = dis_amt.split(' ')[2];
                            if (amt_type == '%') {
                                var total_discount_amount = ($product.data[0]['selling_price_est'] * dis_val) / 100;
                                //total_discount_amount = ($product.data[0]['selling_price_est'] - discount_amount);
                            } else {
                                total_discount_amount = dis_val;
                            }

                        }
                        var pro_total = $product.data[0]['selling_price_est'] - total_discount_amount;
                        $html += '<tr id="' + $product.data[0]['id_product'] + '"><input type="hidden" id="' + 'unit_id_' + rowCount + '" name="unit_id[]" value="' + $product.data[0]['unit_id'] + '">';
                        $html += '<td>' + $product.data[0]['product_name'] + '<div class="prom">P</div><input type="hidden" id="' + 'pro_name_' + rowCount + '" name="pro_name[]" value="' + $product.data[0]['product_name'] + '"><input type="hidden" id="' + 'pro_id_' + rowCount + '" name="pro_id[]" value="' + $product.data[0]['id_product'] + '">';
                        $html += '<input type="hidden" id="' + 'stock_id_' + rowCount + '" name="stock_id[]" value="' + $product.data[0]['id_stock'] + '"><input type="hidden" id="' + 'cat_id_' + rowCount + '" name="cat_id[]" value="' + $product.data[0]['cat_id'] + '"><input type="hidden" id="' + 'subcat_id_' + rowCount + '" name="subcat_id[]" value="' + $product.data[0]['subcat_id'] + '"><input type="hidden" id="' + 'brand_id_' + rowCount + '" name="brand_id[]" value="' + $product.data[0]['brand_id'] + '"></td>';
                        $html += '<td>' + $product.data[0]['product_code'] + '<input type="hidden" id="' + 'pro_code_' + rowCount + '" name="pro_code[]" value="' + $product.data[0]['product_code'] + '">' + '</td>';
                        //$html += '<td>' + $product.data[0]['batch_no'] + '<input type="hidden" id="' + 'batch_' + rowCount + '" name="batch[]" value="' + $product.data[0]['batch_no'] + '">' + '</td>';
                        $html += '<td>';
                        $html += '<select id="batch_' + rowCount + '" name="batch[]">';
                        $.each($product.batch, function (index, data) {
                            //alert(data.batch_no);
                            var select = (data.batch_no == $product.data[0]['batch_no']) ? 'selected' : '';
                            $html += '<option value="' + data.batch_no + '" ' + select + '>' + data.batch_no + '</option>';
                            //console.log('index', data)
                        });
                        $html += '</select>';
                        $html += '</td>';
                        $html += '<td>' + $product.data[0]['total_qty'] + '<input type="hidden" id="' + 'total_qty_' + rowCount + '" name="total_qty[]" value="' + $product.data[0]['total_qty'] + '">' + '</td>';
                        $html += '<td>' + '<input type="text" style="width: 50px" id="' + 'qty_' + rowCount + '" name="qty[]" value="1" onchange="change_price(this)" onchange="change_price(this)">' + '</td>';
                        $html += '<td>' + '<input type="text" style="width: 60px" id="' + 'unit_price_' + rowCount + '" name="unit_price[]" value="' + $product.data[0]['selling_price_est'] + '" onchange="change_price(this)">' + '</td>';
                        $html += '<td>' + '<input type="text" style="width: 45px" id="' + 'discount_' + rowCount + '" name="discount[]" value="' + dis_val + '" onchange="change_price(this)"><strong>' + amt_type + '</strong><input type="hidden" id="' + 'discount_type_' + rowCount + '" name="discount_type[]" value="' + amt_type + '"> <input type="hidden" name="pro_sale_id[]" value="' + promo_id + '"></td>';
                        $html += '<td>' + '<input type="text" style="width: 60px" id="' + 'total_price_' + rowCount + '" name="total_price[]" value="' + pro_total + '" readonly>' + '</td>';
                        $html += '</tr>';
                        $('#addSection > tbody:last').append($html);
                    }
                    //alert($product.purchase_dis.length);
                    totalCalculation();
                    if ($product.purchase_dis.length > 0) {
                        var purchase_val, purchase_val_taka, pur_key = 0;
                        var card_tot = $('#cart_total').text();
                        $.each($product.purchase_dis, function (key, value) {
                            //alert(card_tot + '==' + $product.purchase_dis[key].amount);
                            var amount_d = $product.purchase_dis[key].amount * 1;
                            if ((card_tot * 1) >= amount_d) {
                                //alert('keyyyy');
                                if (amount_d > (pur_key * 1)) {
                                    //alert('key valll');
                                    pur_key = $product.purchase_dis[key].amount;
                                    purchase_val = $product.purchase_dis[key].rate_per;
                                    purchase_val_taka = $product.purchase_dis[key].rate_taka;
                                }
                            }
                        });
                        //alert(purchase_val + '==' + purchase_val_taka);
                        if (purchase_val || purchase_val_taka) {
                            // alert('sdf');
                            var pur_dis_amount, prch_test = '';
                            if (purchase_val) {
                                pur_dis_amount = (purchase_val * card_tot) / 100;
                                prch_test = '<b id="pur_dis">' + Number(purchase_val) + '</b>%';
                            } else {
                                pur_dis_amount = purchase_val_taka;
                            }
                            var pur_dis_per = $('#pur_dis').text();
                            if (pur_dis_per.trim()) {
                                $('#pur_dis').html(Number(purchase_val));
                            } else {
                                var div = '<div><strong>Pur. Dis. ' + prch_test + ':</strong><span id="pur_dis_total"> ' + pur_dis_amount + '</span>&nbsp;</div>';
                                $('#all_discount').append(div);
                            }
                            $('#total_pur_dis').val(pur_dis_amount);

                        }
                    }
                    //alert($product[0].product_code);
                    $('#product_name').val('');
                    $('#product_id').val('');
                }
                $('.loading').fadeOut("slow");
                return false;
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    function totalCalculation() {
        var product_total = 0;
        var unit_total = 0;
        $('input[name^="total_price"]').each(function () {
            var id_f = $(this).attr('id');
            var div_id = id_f.split("_").pop(-1);
            var unit_val = $('#unit_price_' + div_id).val();
            var unit_qty = $('#qty_' + div_id).val();
            unit_total += (unit_val * unit_qty);
            product_total = ($(this).val() * 1) + product_total;
        });
        $('#original_product_price').val(unit_total);
        // alert(product_total);
        var vat_par = $('#df_vat').text();
        var cus_dis = $('#cus_dis').text();
        var dis_per = $('#dis_per').text();
        var dis_taka = $('#dis_taka').text();
        var cart_dis = $('#cart_dis').text();
        var cus_taka = 0, cart_taka, dis_rate;
        cart_taka = 0 * 1;
        if (cus_dis) {
            cus_taka = (product_total * cus_dis) / 100;
            $("#cus_dis_total").html(cus_taka);
        }
        dis_rate = 0;
        if (dis_per.trim()) {
            var dis_per_org = dis_per.substring(0, dis_per.length - 1);
            //alert(dis_per_org);
            dis_rate = (product_total * dis_per_org) / 100;
            $('#dis_taka').html(dis_rate);
        } else if (dis_taka.trim()) {
            dis_rate = dis_taka;
        }
        if (cart_dis.trim()) {
            cart_taka = (product_total * cart_dis) / 100;
            $('#cart_dis_total').html(cart_taka);
        }
        var vat_taka = (product_total * vat_par) / 100;
        var grand_total = ((product_total + vat_taka) - (cus_taka + (dis_rate * 1) + cart_taka));
        $("#cart_total").html(product_total);
        $("#grand_total").html(grand_total.toFixed(2));
        $("#vat_total").html(vat_taka);
        //alert(cus_dis);
        //var pre_total = $('#myDiv').text();
    }
    function customer_list_suggest(elem) {
        var request = $('#customer').val();
        //alert();
        $("#customer").autocomplete({
            source: "<?php echo base_url(); ?>get_customers_auto?request=" + request,
            focus: function (event, ui) {
                event.preventDefault();
                console.log(ui);
                $("#customer").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#customer").val('');
                $("#customer").val(ui.item.label);
                $("#c_phone").val(ui.item.phone);
                $("#points").val(ui.item.points);
                $("#balance").val(ui.item.balance);
                $("#id").val(ui.item.value);
            }
        });
    }
    function showCustormer() {
        var $name = $("#customer").val();
        var $phone = $("#c_phone").val();
        var $points = $("#points").val();
        var $balance = $("#balance").val();
        var html = '';
        if ($name == '') {
            html += '<p class="error">Please Insert Customer Name</p>';
        } else {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>show_customer_for_sales',
                data: 'customer_name=' + $name,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    //console.log(result);
                    var data = $.parseJSON(result);
                    console.log(data);
                    html += '<strong>Name</strong>';
                    html += '<span>' + data[0].full_name + '</span>';
                    html += '<strong>Type</strong>';
                    html += '<span>' + data[0].type_name + '</span>';
                    html += '<strong>Phone</strong>';
                    html += '<span>' + data[0].phone + '</span>';
                    html += '<strong>Points</strong>';
                    html += '<span>' + data[0].points + '</span>';
                    html += '<strong>Balance</strong>';
                    html += '<span>' + data[0].balance + '</span>';
                    html += '<input type="hidden" id="customer_discount" name="customer_discount" value="' + data[0].discount + '">';
                    html += '<input type="hidden" id="customer_id" name="customer_id" value="' + data[0].id_customer + '">';
                    $("#show_customer_data").html(html);
                    var div = '<div><strong>Cus. Dis. <b id="cus_dis">' + Number(data[0].discount) + '</b>%:</strong><span id="cus_dis_total"> 00</span>&nbsp;</div>';
                    $('#all_discount').append(div);
                    totalCalculation();
                    $('.loading').fadeOut("slow");
                    return false;
                }
            });
        }

    }

    function addCustomer() {
        //alert('df');
    }
    $.validator.setDefaults({
        submitHandler: function (form) {
            var currentForm = $('#customer_info')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>create_customer_info_short",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (response) {
                    //console.log(response);
                    var result = $.parseJSON(response);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');
                        });
                    } else {
                        $('#customer_add').modal('toggle');
                        $('#customer_info').trigger("reset");
                        $("#customer_type_id").val("0").change();
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);
                        }, 3000);
                    }
                    $('.loading').fadeOut("slow");
                }
            });
        }
    });
    function product_list_suggest(elem) {
        var request = $('#product_name').val();
        $("#product_name").autocomplete({
            source: "<?php echo base_url(); ?>get_products_auto_sales?request=" + request,
            focus: function (event, ui) {
                event.preventDefault();
                $("#product_name").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#product_name").val('');
                $("#product_name").val(ui.item.label);
                $("#product_id").val(ui.item.value);
                $("#batch_s").val(ui.item.batch_no);
            }
        });
    }
    function change_price(ele) {
        var m_id = ele.id;
        var id = m_id.split('_').pop(-1);
        var qty = $("#qty_" + id).val();
        var total_qty = $("#total_qty_" + id).val();
        //alert(id+'=='+qty+'=='+total_qty);
        if ((qty * 1) > (total_qty * 1)) {
            $(ele).addClass("focus_error");
            $('#validateAlert').modal('toggle');
        } else {
            $(ele).removeClass("focus_error");
            var discount_amount;
            var un_p = $("#unit_price_" + id).val();
            var discount = $("#discount_" + id).val();
            var discount_type = $("#discount_type_" + id).val();
            if (discount_type == 'TK') {
                discount_amount = discount;
            } else {
                discount_amount = (un_p * discount) / 100;
            }
            var tot_val = (qty * un_p) - (discount_amount * qty);
            $("#total_price_" + id).val(tot_val);
            var product_total = 0;
            $('input[name^="total_price"]').each(function () {
                product_total = ($(this).val() * 1) + product_total;
            });
            total_purchase_discount(product_total);
            totalCalculation();
        }

    }

</script>
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>