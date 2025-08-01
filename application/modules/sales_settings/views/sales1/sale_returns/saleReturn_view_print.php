<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<link href="<?= base_url() ?>themes/default/css/sale_print_view.css" rel="stylesheet">
<?php
//echo '<pre>';
//print_r($invoices);
//echo '</pre>';
if ($invoices) {
//print_r($stores);
    ?>
    <div class="invoice_content">
        <div class="head">
            <div class="cmp-info">
                <h4><?= $invoices[0]['store_name'] ?></h4>
                <p> <?= $invoices[0]['address_line'] ?></p>
                <p> <?= $invoices[0]['email'] ?></p>
            </div>
        </div>
        <div class="middle-content">
            <div class="bill">
                <div class="vat">
                    <p>VAT Reg: <?= $vat_reg_no[0]['vat_reg_no'] ?></p>
                </div>
                <div class="cus-info">
                    <p>ServedBy: <?= $invoices[0]['fullname'] . $invoices[0]['tot_amt'] ?></p>
                    <div class="date">Date: <?= date('d.m.Y') ?></div>
                    <div class="time"><?= date('h:i:s A'); ?></div>
                    <p>CusID/Name: <?= $invoices[0]['customer_name'] ?></p>
                </div>
                <p class="invoice-no" style="float: left;">
                    Ret. Inv.: <?= $invoices[0]['invoice_no'] ?>
                </p>
                <p class="invoice-no" style="float: right;">
                    Ref. Inv.: <?= $invoices[0]['ref_sale_invoice'] ?>
                </p>
            </div>

            <div class="table-content">
                <table class="sale_view_table" cellspacing="0" cellpadding="0" border="1">
                    <tbody>
                    <tr>
                        <th class="center_align" width="45%">Product</th>
                        <th class="center_align" width="14%">Dis</th>
                        <th class="center_align" width="14%">Qty</th>
                        <th class="center_align" width="14%">Vat(%)</th>
                        <th class="right_align" width="16%">Total</th>
                    </tr>
                    <?php
                    $i = 1;
                    $sum = 0;
                    $qty_sum = 0;
                    $total_sum = 0;
                    $discount = 0;
                    $paid_amount = 0;
                    $vat = 0;
                    $product_amt = 0;
                    if (!empty($products)) {
                        foreach ($products as $row) {
                            // if ($invoice->id_sale == $row['sale_id']) {
                            $discount = $row['discount_amt'];
                            $qty_sum += $row['qty'];
                            $vat = $row['vat_amt'];
                            $product_amt += $row['selling_price_act'];
                            ?>
                            <tr>
                                <td><?php echo '<span>' . $row['product_code'] . '</span>' . '<span>' . $row['product_name'] . '</span>'; ?></td>
                                <td><?php echo $row['discount_amt']; ?></td>
                                <td><?php echo $row['qty']; ?></td>
                                <td><?php echo $row['vat_rate']; ?></td>
                                <td><?php echo $row['selling_price_act']; ?></td>
                            </tr>
                            <?php $i++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="summury">
                <div class="bill-total">
                    <p>Total:</p>
                    <p><?= $qty_sum ?></p>
                    <p><?= $product_amt ?> TK</p>
                </div>
                <div class="adjustment">
                    <?php
                    $all_dis = 0;
                    $promo = $this->config->item('promotion_type_sales');
                    if ($promotions) {
                        foreach ($promotions as $promotion) {
                            $type = $promotion->promotion_type_id;
                            $dis=$promotion->discount_rate;
                            $dis_amt=($product_amt*$dis)/100;
                            echo '<p>' . $promo[$type] . ' (-) ' . $promotion->discount_rate . '%  <span>' . number_format($dis_amt,2) . 'TK</span></p>';
                            $all_dis += $dis_amt;
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="summury1">
                <div class="adjustment">
                    <p style="font-weight:bold;font-size:14px;">Net Amount (TK) <span
                            style="font-weight:bold"><?php echo $product_amt - $all_dis; ?></span></p>
                    <div class="prd">
                        <p style="font-weight:bold;border-bottom: 1px solid #000;font-size: 14px;">Return Amount:
                            <span><?= $invoices[0]['tot_amt'] ?> TK</span></p>
                    </div>
                </div>
            </div>
            <div class="">
                <?php
                if($minus_points!=''){
                    $c_p=$invoices[0]['customer_points']*1;
                    $bonus_total=$c_p-$minus_points;
                    echo 'Current Deduct Point: '.round($minus_points, 2);
                    echo '<br>Total Point: '.round($bonus_total, 2);
                }
                ?>
            </div>
        </div>
        <div class="foot">
            <div class="bar-code">
                <?php
                $img = $this->barcode->code128BarCode($invoices[0]['invoice_no'], 1);
                ob_start();
                imagepng($img);
                $output_img = ob_get_clean();
                echo '<div class="barcode">';
                echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '"/>' . '<br>';
                echo '<span class="no"> ' . $invoices[0]['invoice_no'] . '</span><br />';
                echo '</div>';
                ?>
            </div>
            <p style="font-weight:bold;">Shop Mobile
                No: <?= $invoices[0]['mobile'] ?> </p>
            <p>Thank You for Shopping at <?= $invoices[0]['store_name'] ?></p>
            <p>Software Developed By: www.ezsellbd.com</p>
        </div>
    </div>
    <?php
}
?>
