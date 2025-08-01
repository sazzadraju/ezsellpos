<?php
if (!empty($sales)) {
    if($delivery==''){
    ?>
    <form action="" class="sales-form" id="temp_add_sales_return" method="post">
        <div class="table-responsive">
            <div id="show_errors"></div>

            <table id="addSection" class="table table-bordred table-striped">
                <thead>
                <th>Check</th>
                <th>Product name</th>
                <th>Batch</th>
                <th>Quantity</th>
                <th>Already Return</th>
                <th>Return Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>Discount(<?=set_currency()?>)</th>
                <th>vat(<?=set_currency()?>)</th>
                <th>Total Price</th>
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
                        <td><?= $post->product_name ?><br><?= $post->product_code ?></td>
                        <td><?= $post->batch_no ?></td>
                        <td align="center"><?= number_format($post->qty, 0) ?> <input type="hidden" name="qty[]" id="qty_<?= $count ?>"
                                                                       value="<?= number_format($post->qty, 0) ?>"></td>
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
                        <td><input style="width: 50px;" class="Number" type="text" name="return_qty[]"
                                   id="return_qty_<?= $count ?>" disabled=""></td>
                        <td><?= $post->selling_price_est / $post->qty ?></td>
                        <td><?= number_format($post->selling_price_est) ?></td>
                        <td>
                            <?php
                            $dis_rate_val = $post->discount_amt;
                            echo $dis_rate_val
                            ?>
                        </td>
                        <td><?= number_format(($post->vat_amt), 2) ?></td>
                        <td><?= set_currency($post->selling_price_act) ?></td>
                    </tr>

                    <?php
                    $count++;
                    $check++;
                    $total = $total + $post->selling_price_act;
                }
                ?>

                </tbody>

            </table>

            <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
        </div>
        <div class="row">
            <div class="col-md-5 pull-right">
                <div class="row">
                    <div class="col-md-8">
                        <div>
                            Card Total
                        </div>
                    </div>

                    <div class="col-md-4">

                        <div class="text-right"><input type="hidden" name="cart_total[]" value="<?= $total ?>">
                            <?= set_currency(number_format($total,2)) ?>
                        </div>
                    </div>

                    <?php
                    $types = $this->config->item('promotion_type_sales');
                    if (!empty($promotions)) {
                        foreach ($promotions as $promo) {
                            $type_id = $promo->promotion_type_id;
                            ?>
                            <div class="col-md-8">
                                <div class="text-right">
                                    <input type="hidden" name="dis_type[]" value="<?= $type_id ?>">
                                    <?= $types[$type_id] . ' ' . number_format($promo->discount_rate, 2) . '%' ?>
                                    <input type="hidden" name="dis_rate[]"
                                           value="<?= number_format($promo->discount_rate, 0) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-right">
                                    <?= set_currency($promo->discount_amt) ?>
                                    <input type="hidden" name="dis_amt[]" value="<?= $promo->discount_amt ?>">
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="col-md-8">
                        <div>
                            Total
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-right">
                            <?= set_currency($sales[0]['tot_amt']) ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div>
                            Paid Amount
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-right">
                            <?= set_currency($sales[0]['paid_amt']) ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div>
                            Round
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-right">
                            <?= set_currency($sales[0]['round_amt']) ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div>
                            Total Due
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-right">
                            <?= set_currency($sales[0]['due_amt']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <button class="btn btn-primary" name="temp_add_return">Return Add</button>
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

<script>
    $('.Number').keypress(function (event) {
        if (event.which == 8 || event.which == 0) {
            return true;
        }
        if (event.which < 46 || event.which > 59) {
            return false;
        } // prevent if not number/dot

        if (event.which == 46 && $(this).val().indexOf('.') != -1) {
            return false;
        }
    });
    $("#temp_add_sales_return").submit(function () {
        $('#show_errors').html('');
        if (validate_data() != false) {
            var $html = '';
            var grand_total = $('#grand_total').text();
            var cart_total = $('#cart_total').text();
            var df_vat = $('#df_vat').text();
            var vat_total = $('#vat_total').text();
            var dataString = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>show_sale_return_data',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    //alert(result);
                    $('#return_data_add').html(result);
                    //$('#return_data_add > tbody:last').append(result);
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
    function validate_data() {
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
                    var qty = $('#qty_' + id).val();
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
</script>