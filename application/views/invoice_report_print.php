<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<link href="<?= base_url() ?>themes/default/css/sale_print_view.css" rel="stylesheet">
<?php
if ($invoices) {
    ?>
    <div class="">
        <div class="head">
            <div class="cmp-info">
                <?php if($invoices[0]['store_img']!=NULL && $settings['shop_logo']){
                    $image_path = documentLink('user').$invoices[0]['store_img'];
                    echo '<img src="'.$image_path.'" width="100">';
                }
                echo ($settings['shop_name'])?'<h4>'.$invoices[0]['store_name'].'</h4>':'';
                echo '<p>'.$invoices[0]['address_line'].'</p>';
                echo ($settings['email'])?'<p>'.$invoices[0]['email'].'</p>':'';
               ?>
            </div>
        </div>
        <div class="middle-content">
            <div class="bill">
                <div class="vat">
                    <p>VAT Reg: <?= $vat_reg_no[0]['vat_reg_no'] ?></p>
                </div>
                <div class="cus-info">
                    <p>ServedBy: <?= $invoices[0]['fullname']?></p>
                    <div class="date">Date: <?= nice_datetime($invoices[0]['dtt_add']) ?></div>
                    <p>CusID/Name: <?= $invoices[0]['customer_code'].'/'.$invoices[0]['customer_name'] ?></p>
                </div>
                <p class="invoice-no">
                   SL: <?php echo $serial_no; ?>, INV: <?= $invoices[0]['invoice_no'] ?>
                </p>
            </div>

            <div class="table-content">
                <table class="sale_view_table" cellspacing="0" cellpadding="0" border="1">
                    <tbody>
                    <tr>
                        <th class="center" width="30%">Product</th>
                        <th class="center" width="14%">U.Price</th>
                        <th class="center" width="14%">Dis</th>
                        <th class="center" width="14%">Qty</th>
                        <th class="center" width="14%">Vat</th>
                        <th class="right_align" width="16%">Total(<?=set_currency()?>)</th>
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
					$count_pro=array();
                    if (!empty($products)) {
                        foreach ($products as $row) {
                            if(!in_array($row['product_id'],$count_pro)){
                                $count_pro[]=$row['product_id'];
                            }
                            $discount = $row['discount_amt'];
                            $qty_sum += $row['qty'];
                            $vat += $row['vat_amt'];
                            $product_amt += $row['selling_price_act'];
                            $brand=($settings['brand'])?$row['brand_name']:'';
                            $code=($settings['code'])?$row['product_code']:'';
                            ?>
                            <tr >
                                <td colspan="5" style="text-align: left;border-bottom: none"><?php echo  $code . ' ' . $row['product_name'] . ' '.$brand ; ?></td>
                                <td>&nbsp;</td>
                                
                            </tr>
                            <tr style="border-bottom: 1px dashed #3E4B5B">
                                <td>&nbsp;</td>
                                <td><?php echo $row['selling_price_est']/$row['qty']; ?></td>
                                <td><?php echo $row['discount_amt']; ?></td>
                                <td><?php echo $row['qty']; ?></td>
                                <td><?php echo $row['vat_amt']; ?></td>
                                <td><?php echo $row['selling_price_act']; ?></td>
                            </tr>
                            <?php $i++;
                        }
                    }
                    ?>
                    </tbody>
                    <tbody>
                    <tr>
                        <td colspan="3" style="border-bottom: 0px !important; font-weight: bold"><?= count($count_pro)?> Items</td>
                        <td style="border-bottom: 0px !important; font-weight: bold; text-align: center"> <?= $qty_sum ?></td>
                        <td style="border-bottom: 0px !important; font-weight: bold; text-align: center"> <?= $vat ?></td>
                        <td style="border-bottom: 0px !important; font-weight: bold"><?= $product_amt ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="summury">
                <div class="adjustment">
                    <?php
                    $all_dis = 0;
                    $promo = $this->config->item('promotion_type_sales');
                    if ($promotions) {
                        foreach ($promotions as $promotion) {
                            $type = $promotion->promotion_type_id;
                            echo '<p>' . $promo[$type] . ' (-) ' . $promotion->discount_rate . '%  <span>' . $promotion->discount_amt . '</span></p>';
                            $all_dis += $promotion->discount_amt;
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="summury1">
                <div class="adjustment">
                    <p style="font-weight:bold;font-size:14px;">Net Amount (<?=set_currency()?>) <span
                            style="font-weight:bold"><?php echo $product_amt - $all_dis; ?></span></p>

                    <table class="table-pay-type" cellspacing="0" cellpadding="0" border="1">
                        <tbody>
                        <tr>
                            <th class="center_align" width="50%">Pay Type</th>
                            <th class="center_align" width="50%">Amount</th>
                        </tr>
                        <?php
                        $all_paid_amt = 0;
                        $method = $this->config->item('trx_payment_methods');
                        //echo $method[1];
                        foreach ($transactions as $transaction) {
                            $type = $transaction['payment_method_id'];
                            echo '<tr><td>' . $method[$type] . '</td><td>' . $transaction['amount'] . '</td></tr>';
                            $all_paid_amt += $transaction['amount'];
                        }
                        ?>
                        </tbody>
                    </table>
                    <div class="prd">
                        <p style="font-weight:bold;border-bottom: 1px solid #000;font-size: 14px;">Total Amount:
                            <span><?= $invoices[0]['tot_amt'] ?></span></p>
                        <p style="font-weight:bold;margin:0;">Paid Amount: <span><?= $all_paid_amt ?></span></p>
                        <?php
                        if ($invoices[0]['remit_amt'] > 0) {
                            echo '<p style="font-weight:bold;margin:0;">Remit: <span>' . $invoices[0]['remit_amt'] . '</span></p>';
                        }
                        ?>
                        <p style="font-weight:bold;margin:0;">Round: <span><?= $invoices[0]['round_amt'] ?></span>
                        </p>
                        <?php
                        $due_amt = 0;
                        if ($invoices[0]['round_amt'] == '0.00') {
                            $due_amt = $invoices[0]['tot_amt'] - $invoices[0]['paid_amt'];
                        }
                        if($invoices[0]['settle']==1){
                           echo '<p style="font-weight:bold;margin:0;">Settle Amount: <span>'.round($due_amt, 2) .'</span></p>' ;
                           $due_amt=0;
                        }
                        ?>
                        <p style="font-weight:bold;margin:0;">Due Amount: <span><?= round($due_amt, 2) ?></span></p>
                    </div>
                </div>
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
            <?php echo ($settings['phone'])?'<p style="font-weight:bold;">Shop Mobile No:'.$invoices[0]['mobile'].'</p>':''; ?>
            <?php
            echo ($invoices[0]['notes']!='') ? '<p>' . $invoices[0]['notes'].'</p>' : '';
            ?>
            <p>Software Developed By: www.ezsellbd.com</p>
            <p>Copy of Original</p>
            <p> Printed: <?= nice_datetime(date('Y-m-d H:i:s'))?></p>
            <?php
            $new_note=($settings['note_type']=='yes')?'<p>Note:'.$settings['note'].'</p>':'';
            echo $new_note;
            if($sales_person_name){
                echo 'Sales Person: '.$sales_person_name;
            }
            ?>
        </div>
    </div>
    <?php
}
?>
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
        $('#SaleInvoiceDetails').modal('hide');
    }
</script>
