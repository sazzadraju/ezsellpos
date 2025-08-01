<div class="table-responsive">
    <?php //print_r($posts);?>
    <table class="table table-bordred table-striped">
        <thead>
            <tr>
                <th colspan="8 text-center">Replace Product List</th>
            </tr>
            <tr>
                <th>Product name</th>
                <th>Return Qty</th>
                <th>Unit Price</th>
                <th>Price</th>
                <th>Discount(Tk)</th>
                <th>vat(Tk)</th>
                <th>Deduction</th>
                <th class="text-right">Total</th>
            </tr>
        
        </thead>
        <tbody>
        <?php
        echo $data;
        ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">&nbsp;</th>
                <th colspan="2">Card Total</th>
                <th><?= number_format($total,2) ?></th>
            </tr>
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
                    <tr>
                        <th colspan="5">&nbsp;</th>
                        <th colspan="2">
                            <?= $types[$type_id] . ' ' . number_format($promo->discount_rate, 2) . '%' ?>
                        </th>
                        <th class="text-right">
                        
                            <?= number_format($dis_amt, 2) ?>
                        </th>
                    </tr>
                    <?php
                    $sub_total += $dis_amt;
                }
            }
            ?>
            <tr>
                <th colspan="5">&nbsp;</th>
                <th colspan="2">Return Total</th>
                <th>
                    <input type="hidden" name="r_dis_amt" value="<?= $sub_total ?>">
                    <input type="hidden" id="r_total_amt" name="r_total_amt" value="<?= ($total-$sub_total) ?>">
                    <?= number_format($total-$sub_total,2) ?>
                    <input type="hidden" name="r_sale_id" value="<?= $sale_id ?>">
                    <input type="hidden" name="r_customer_id" value="<?= $customer_id ?>">
                    <input type="hidden" name="r_total_vat" value="<?= $total_vat ?>">
                    <input type="hidden" name="r_act_amount" value="<?= $act_amount ?>">
                    <input type="hidden" name="r_total_pro_dis" value="<?= $total_pro_dis ?>">
                </th>
            </tr>
        </tfoot>
    </table>
    

</div>