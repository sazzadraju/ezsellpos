<form action="" class="sales-form" id="sales_return_submit" method="post" onsubmit="return false">
    <div class="table-responsive">
        <?php //print_r($posts);?>
        <table id="addSection" class="table table-bordred table-striped">
            <thead>
            <th>Product name</th>
            <th>Batch</th>
            <th>Return Qty</th>
            <th>Unit Price</th>
            <th>Price</th>
            <th>Discount(<?=set_currency()?>)</th>
            <th>vat(<?=set_currency()?>)</th>
            <th>Total</th>
            </thead>
            <tbody>
            <?php
            echo $data;
            ?>
            </tbody>
        </table>
        <input type="hidden" name="sale_id" value="<?= $sale_id ?>">
        <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
        <input type="hidden" name="total_vat" value="<?= $total_vat ?>">
        <input type="hidden" name="act_amount" value="<?= $act_amount ?>">
        <input type="hidden" name="total_pro_dis" value="<?= $total_pro_dis ?>">
        <input type="hidden" name="vat_per" value="<?= $total_vat?>">
        <input type="hidden" name="dis_per" value="<?= $total_pro_dis ?>">

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

                    <div><input type="hidden" name="cart_total" value="<?= $total ?>">
                        <?= number_format($total) ?>
                    </div>
                </div>

                <?php
                $discount=0;
                $types = $this->config->item('promotion_type_sales');
                $sub_total = 0;
                if(!empty($promotions)) {
                    foreach ($promotions as $promo) {
                        $type_id = $promo->promotion_type_id;
                        $dis_amt = 0;
                        if ($promo->discount_rate != '') {
                            $dis_amt = ($promo->discount_rate * $total) / 100;
                        } else {
                            $dis_amt = $promo->discount_amt;
                        }
                        ?>
                        <div class="col-md-8">
                            <div>
                                <?= $types[$type_id] . ' ' . number_format($promo->discount_rate, 2) . '%' ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <?= number_format($dis_amt, 2) ?>
                            </div>
                        </div>
                        <?php
                        $sub_total += $dis_amt;
                    }
                }
                ?>
                <div class="col-md-8">
                    <div>
                        Total
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <input type="hidden" name="dis_amt" value="<?= $sub_total ?>">
                        <?= number_format($total-$sub_total,2) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-primary" name="temp_add_return">Return</button>
</form>

<script>
    $("#sales_return_submit").submit(function () {
        //e.preventDefault();
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>add_sale_return',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                //console.log(data);
                //alert(data);
                $('#sale_view').html(data);
                $('#SaleDetails').modal('toggle');
                $('.loading').fadeOut("slow");
                //return false;
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
</script>