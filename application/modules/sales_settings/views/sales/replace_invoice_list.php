<?php
if (!empty($sales)) {
    if($delivery==''){
    ?>
    <form action="" class="sales-form" id="temp_add_sales_return" method="post">
        <div class="table-responsive">
            <div id="show_errors"></div>
            <table id="" class="table table-bordered table-striped">
                <thead>
                <th>&nbsp;</th>
                <th>Product name</th>
                <th>Quantity</th>
                <th>Already Return</th>
                <th>Return Qty</th>
                <th>Total</th>
                <th>Dis(<?=set_currency()?>)</th>
                <th>vat(<?=set_currency()?>)</th>
                <th class="text-right">Total Price</th>
                </thead>
                <tbody>
                <?php
                $count = 1;
                $total = 0;
                $check = 0;
                foreach ($posts as $post) {
                    ?>
                    <tr>
                        <td><input type="checkbox" class="check_value" onclick="checkbox(this);" name="check_id[]"
                                   id="check_id_<?= $count ?>" value="<?= $post->id_sale_detail ?>">
                            <label for="check_id_<?= $count ?>"></td>
                        <td><?= $post->product_name ?><br><?= $post->product_code ?><br><?= $post->batch_no ?></td>
                        <td align="center"><?= number_format($post->qty, 0) ?> <input type="hidden" name="qty[]" id="rep_qty_<?= $count ?>"value="<?= number_format($post->qty, 0) ?>"></td>
                        <td align="center">
                            <?php
                            if(!empty($returns)) {
                                foreach ($returns as $return) {
                                    if($return['stock_id']==$post->stock_id){
                                        echo number_format($return['rtn_qty'], 0);
                                        echo '<input type="hidden" name="rtn_qty[]" id="rtn_qty_'. $count.'"value="'. number_format($return['rtn_qty'], 0).'">';
                                        break;
                                    }
                                }
                            }else{
                                echo '0';
                                echo '<input type="hidden" name="rtn_qty[]" id="rtn_qty_'. $count.'"value="0">';
                            }
                            ?>
                        </td>
                        <td><input style="width: 50px;" class="changeRtnQty Number" type="text" name="return_qty[]"
                                   id="return_qty_<?= $count ?>" disabled=""></td>
                        <td><?= number_format($post->selling_price_est) ?></td>
                        <td>
                            <?php
                            $dis_rate_val = $post->discount_amt;
                            echo $dis_rate_val
                            ?>
                        </td>
                        <td><?= number_format(($post->vat_amt), 2) ?></td>
                        <td class="text-right"><input style="width: 80px;" class="Number" type="text" name="selling_price[]"
                                   id="selling_price_<?= $count ?>" value="<?= $post->selling_price_act ?>" disabled=""></td>
                    </tr>

                    <?php
                    $count++;
                    $check++;
                    $total = $total + $post->selling_price_act;
                }
                ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">&nbsp</th>
                        <th colspan="3">Card Total</th>
                        <th class="text-right"><input type="hidden" name="cart_total[]" value="<?= $total ?>">
                            <?= number_format($total,2) ?></th>
                    </tr>
                    <?php
                    $types = $this->config->item('promotion_type_sales');
                    if (!empty($promotions)) {
                        foreach ($promotions as $promo) {
                            $type_id = $promo->promotion_type_id;
                            ?>
                            <tr>
                                <th colspan="5">&nbsp</th>
                                <th colspan="3"><input type="hidden" name="dis_type[]" value="<?= $type_id ?>">
                                    <?= $types[$type_id] . ' ' . number_format($promo->discount_rate, 2) . '%' ?>
                                    <input type="hidden" name="dis_rate[]"
                                           value="<?= number_format($promo->discount_rate, 0) ?>"></th>
                                <th class="text-right">
                                    <?= $promo->discount_amt ?>
                                    <input type="hidden" name="dis_amt[]" value="<?= $promo->discount_amt ?>">
                                </th>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <th colspan="5">&nbsp</th>
                        <th colspan="3">Total</th>
                        <th class="text-right"><?= $sales[0]['tot_amt'] ?></th>
                    </tr>
                    <tr>
                        <th colspan="5">&nbsp</th>
                        <th colspan="3">Paid Amount</th>
                        <th class="text-right"><?= $sales[0]['paid_amt'] ?></th>
                    </tr>
                    <tr>
                        <th colspan="5">&nbsp</th>
                        <th colspan="3">Round</th>
                        <th class="text-right"><?= $sales[0]['round_amt'] ?></th>
                    </tr>
                    <tr>
                        <th colspan="5">&nbsp</th>
                        <th colspan="3">Total Due</th>
                        <th class="text-right"><?= $sales[0]['due_amt'] ?></th>
                    </tr>
                </tfoot>

            </table>

            <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
        </div>
        <div class="row">
            <div class="col-md-11 d-flex justify-content-end">
                <input class="btn btn-primary" type="submit" value="Replace"> </button>
            </div>
        </div>
    </form>
    <?php
    }else{
        echo'<div class="alert alert-danger" style="font-size=18px;">This invoice has delivery. Please Return this Invoice From Delivery Orders. </div> ';
    }  
} else { ?>
    <div class="alert alert-danger">No data found</div>
    <?php
}
?>
<script type="text/javascript">
    $("#temp_add_sales_return").submit(function () {
        $('#show_errors').html('');
        if (validate_replace_data() != false) {
            var $html = '';
            var grand_total = $('#grand_total').text();
            var cart_total = $('#cart_total').text();
            var df_vat = $('#df_vat').text();
            var vat_total = $('#vat_total').text();
            var dataString = new FormData($('#temp_add_sales_return')[0]);
            $.ajax({
                type: "POST",
                url: URL+'sales_settings/sales/show_sale_return_data',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    //alert(result);
                    $('#replace_product_data').html(result);
                    $('#replace_data').val(1);
                    //$('#return_data_add > tbody:last').append(result);
                    $('#replaceSale').modal('toggle');
                    $('.loading').fadeOut("slow");
                    setTimeout(function () {
                        var total=$('#r_total_amt').val()*1;
                        $('#all_discount tr.shtr').after('<tr><td>Replace Total</td><td id="replace_total">'+Number(total.toFixed(2))+'</td></tr>');
                        sumDiscountCalculation();
                    }, 100);
                    
                    return false;
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
    });
    function validate_replace_data() {
        var error_count = 0;
        var val = '';
        var count_check = $('input[name="check_id[]"]:checked').length;
        if (count_check < 1) {
            error_count += 1;
            val = '<div class="alert alert-danger">Please Check any one</div>';
            $('.check_value').addClass("chk_error");
        }
        else {
            $('input[name^="check_id"]').each(function () {
                var s_val = $(this).val();
                var s_id = $(this).attr('id');
                var id = s_id.split("_").pop(-1);
                $('#return_qty_' + id).removeClass("focus_error");
                if ($(this).is(":checked")) {
                    var qty = $('#rep_qty_' + id).val();
                    var already_return = $('#rtn_qty_' + id).val();
                    var ret_qty = $('#return_qty_' + id).val();
                    if (ret_qty == '') {
                        error_count += 1;
                        val = '<div class="alert alert-danger">Return Quantity not null</div>';
                        $('#return_qty_' + id).addClass("focus_error");
                    }
                    else if (parseInt(qty) < (parseInt(ret_qty)+parseInt(already_return))) {
                        val = '<div class="alert alert-danger">Return Qty must be less then original Quantity</div>';
                        error_count += 1;
                        $('#return_qty_' + id).addClass("focus_error");
                    }
                }
            });

        }
        if (error_count > 0) {
            $('#show_errors').html(val);
            return false;
        } else {
            return true;
        }
    }
    $('input.changeRtnQty').on('input', function (e) {
    var id_full = this.id;
    var val = this.value*1;
    //alert(val+'==='+id_full);
    var id = id_full.split("_").pop(-1);
    var total_price = $('#selling_price_' + id).val() * 1;
    var sale_qty = $('#rep_qty_' + id).val() * 1;
    var unit_price=(total_price/sale_qty);
    $('#selling_price_' + id).val(unit_price*val);
});

    
</script>