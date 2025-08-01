<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/a4_print.css">
<page size="A4">
    <div class="invoice-w">
        <div class="infos">
            <?php if ($settings['header']) { ?>
                <div class="info-1">
                    <?php echo($settings['shop_name'])?'<div class="company-name">'.$invoices[0]['store_name'].'</div>':'';?>
                    <div class="company-address"><?= $invoices[0]['address_line'] ?></div>
                    <?php echo($settings['phone'])?'<div class="company-extra">'.$invoices[0]['mobile'].'</div>':'';?>
                    <?php echo($settings['email'])?'<div class="company-extra">'.$invoices[0]['email'].'</div>':'';?>
                </div>
                <div class="info-1-logo">
                    <?php
                    if ($this->session->userdata['login_info']['store_img'] != ''&& $settings['shop_logo']) {
                        echo '<img src="' . documentLink('user') . $this->session->userdata['login_info']['store_img'] . '" alt="">';
                    }
                    ?>
                </div>
                <?php
            }else{
                echo '<div style="height:'.$settings['head_size'].'px;"></div>';
            }
            ?>
            <div class="info-2">
                <div class="invoice-heading">
                    <div class="invoice-date"><?= nice_datetime($invoices[0]['dtt_add']) ?></div>
                    <h3>Vat Reg No: <?= $vat_reg_no[0]['vat_reg_no'] ?></h3>
                </div>

                <div class="invoice-no">
                    <h4>SL: <?php echo $serial_no; ?>, INV: <?= $invoices[0]['invoice_no'] ?></h4>
                    <?php
                    $img = $this->barcode->code128BarCode($invoices[0]['invoice_no'], 1);
                    ob_start();
                    imagepng($img);
                    $output_img = ob_get_clean();
                    echo '<div class="bar-code">';
                    echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
                    echo '</div>';
                    ?>
                </div>

                <div class="customer-details">
                    <div class="cus-id"><?= $invoices[0]['customer_code'] ?></div>
                    <div class="cus-name"><?= $invoices[0]['customer_name'] ?></div>
                    <div class="cus-contact"><?= $invoices[0]['customer_mobile'] ?></div>
                </div>
            </div>
        </div>
        <div class="invoice-body">
            <div class="invoice-table">
                <table class="table">
                    <tr>
                        <th class="text-left" style="width:35%">Product</th>
                        <?php
                        $c=0;
                        if($settings['brand']){
                            $c+=1;
                            echo '<th class="text-left">'. lang("brand") .'</th>';
                        }
                        echo '<th class="text-left">'. lang("category") .'</th>';
                        if($settings['sub_cat']){
                            $c+=1;
                            echo '<th class="text-left">'. lang("sub_category") .'</th>';
                        }
                        ?>
                        <th class="text-center"><?= lang('unit_price') ?></th>
                        <th class="text-center"><?= lang('qty') ?></th>
                        <th class="text-center"><?= lang('dis') ?></th>
                        <th class="text-center"><?= lang('vat') ?></th>
                        <th class="text-right"><?= lang('price') ?></th>
                    </tr>
                    <tbody>
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
                            $code=($settings['code'])?'<span> ('.$row['product_code'].')</span>':'';
                            ?>
                            <tr>
                                <td class="text-left"
                                    style="width: 45%"><?php echo '<span>' . $row['product_name'] . '</span>' . $code. '<br><span>' . $row['attribute_name'] . '</span>'; ?></td>
                                <?php
                                if($settings['brand']){
                                echo '<td class="text-left">'. $row['brand_name'].'</td>';
                                }
                                echo '<td class="text-left">'. $row['cat_name'].'</td>';
                                echo ($settings['sub_cat'])?'<td class="text-left">'. $row['sub_cat_name'].'</td>':'';
                                ?>
                                <td class="text-center"><?php echo $row['selling_price_est'] / $row['qty']; ?></td>
                                <td class="text-center"><?php echo $row['qty']; ?></td>
                                <td class="text-center"><?php echo $row['discount_amt']; ?></td>
                                <td class="text-center"><?php echo $row['vat_amt']; ?></td>
                                <td style="text-align: right;"><?php echo $row['selling_price_act']; ?></td>
                            </tr>
                            <?php $i++;
                        }
                    }
                    ?>
                    <tr>
                        <td class="text-left" colspan="<?= (3+$c)?>" style="font-weight: 600;"><?= count($count_pro)?> Items</td>
                        <td class="text-center"  style="font-weight: 600;"><?= $qty_sum ?></td>
                        <td class="text-right" colspan="2" style="font-weight: 600;"><?= $vat ?></td>
                        <td class="text-right" style="font-weight: 600;"><?= set_currency($product_amt) ?></td>
                    </tr>

                    </tbody>
                    <tbody>
                    <tr>
                        <td style="border: 0;">
                            <?php
                            if (isset($delivery_person))
                            {
                                $person_name='  ';
                                if(!empty($delivery_person) ){
                                    $person_name=$delivery_person[0]->person_name;
                                }
                            ?>
                                <div class="delvery-details">
                                    <h3><?= lang('delivery_details') ?></h3>
                                    <div class="delvery-details-title"><?= lang("delivery_person") ?>:</div>
                                    <div class="delvery-details-info"><?php echo  $person_name?></div>
                                    <div class="delvery-details-title"><?= lang("delivery_address") ?>:</div>
                                    <div class="delvery-details-info"><?php echo $delivery[0]->delivery_address ?></div>
                                    <div class="delvery-details-title"><?= lang("service_price") ?>:</div>
                                    <div class="delvery-details-info"><?php echo $delivery[0]->tot_amt ?></div>
                                    <div class="delvery-details-title"><?= lang("paid_amount") ?>:</div>
                                    <div class="delvery-details-info"><?php echo $delivery[0]->paid_amt ?></div>
                                    <div class="delvery-details-title"><?= lang("due_amount") ?>:</div>
                                    <div class="delvery-details-info"><?= set_currency($delivery[0]->tot_amt - $delivery[0]->paid_amt) ?></div>
                                </div>
                                <?php
                            }
                            ?>
                            <div>
                                <?php
                                echo ($settings['note_type']=='yes') ? '<b>Note:</b>' . $settings['note'] : '';
                                ?>
                            </div>
                            <div>
                                <?php
                                echo ($invoices[0]['notes']!='') ? '<b>Comments:</b>' . $invoices[0]['notes'] : '';
                                ?>
                            </div>
                            <?php
                            if($sales_person_name){
                                echo '<div>';
                                echo 'Sales Person: '.$sales_person_name;
                                 echo '</div>';
                            }
                            ?>
                        </td>
                        <td colspan="<?= (6+$c)?>" style="border: 0;padding: 0 !important;">
                            <blockquote>
                            <table class="foot-table">
                                <tbody>
                                <!-- Discount -->
                                <?php
                                $all_dis = 0;
                                $promo = $this->config->item('promotion_type_sales');
                                if ($promotions) {
                                    foreach ($promotions as $promotion) {
                                        $type = $promotion->promotion_type_id;
                                        echo '<td class="text-right">' . $promo[$type] . ' (-)' . $promotion->discount_rate . '%</td>  <td class="text-right">' . $promotion->discount_amt . '</td>';
                                        $all_dis += $promotion->discount_amt;
                                        echo '<tr>';
                                    }

                                }
                                ?>
                                <!-- Net Amount-->
                                <tr>
                                    <td class="text-right" style="font-weight: bold;"><span
                                            style="border-bottom: 1px solid #666;">Net Amount(<?= set_currency() ?>
                                            )</span></td>
                                    <td class="text-right"
                                        style="font-weight: bold;border-bottom: 1px solid #666;"><?php echo $product_amt - $all_dis; ?></td>
                                </tr>
                                <!-- Pay Type-->
                                <?php
                                $all_paid_amt = 0;
                                $method = $this->config->item('trx_payment_methods');
                                foreach ($transactions as $transaction) {
                                    $type = $transaction['payment_method_id'];
                                    echo '<td class="text-right">' . nice_date($transaction['dtt_add']) . '<span style="font-weight: 600;">[' . $method[$type] . ']</span></td><td class="text-right" >' . $transaction['amount'] . '</td></tr>';
                                    $all_paid_amt += $transaction['amount'];
                                }
                                ?>
                                <!-- Total Amount-->
                                <tr>
                                    <td class="text-right" style="font-weight: bold;">
                                        <span style="border-bottom: 1px solid #666;"> Total Amount(<?= set_currency() ?>
                                            )</span>
                                    </td>
                                    <td class="text-right"
                                        style="font-weight: bold;border-bottom: 1px solid #666;"><?= $all_paid_amt ?></td>
                                </tr>
                                <!-- Paid, Round, Due Amount-->
                                <tr>
                                    <td class="text-right"><span
                                            style="font-weight: 600;">[Paid Amount]</span></td>
                                    <td class="text-right"><?= $all_paid_amt ?></td>
                                </tr>
                                <?php
                                if ($invoices[0]['remit_amt'] > '0') {
                                    ?>
                                    <tr>
                                        <td class="text-right"><span style="font-weight: 600;">[Redeem Amount]</span>
                                        </td>
                                        <td class="text-right"><?= $invoices[0]['remit_amt'] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                $due_amt = 0;
                                if ($invoices[0]['round_amt'] == '0.00') {
                                    $due_amt = $invoices[0]['tot_amt'] - $invoices[0]['paid_amt'];
                                }
                                ?>
                                <tr>
                                    <td class="text-right"><span style="font-weight: 600;">[Round]</span>
                                    </td>
                                    <td class="text-right"><?= $invoices[0]['round_amt'] ?></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span
                                            style="font-weight: 600;">[Due Amount]</span></td>
                                    <td class="text-right"><?= round($due_amt, 2) ?></td>
                                </tr>
                                </tbody>
                            </table>
                            </blockquote>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
        <table style="width: 100%">
            <tfoot>
            <!-- Signature-->
            <tr>
                <td colspan="0" style="border: 0px !important;"><span
                        style="color: #666;display: inline-block;font-weight: bold;border-bottom: 1px solid;">Authorised Signature:</span>
                </td>
                <td class="text-right" colspan="0" style="border: 0px !important;"><span
                        style="color: #666;display: inline-block;font-weight: bold;border-bottom: 1px solid;">Customer Signature:</span>
                </td>
            </tr>
            <!-- Footer-->
            <tr>
                <td colspan="0"><span style="color: #666;margin-top: 20px;display: block;">Copy of Original<br>
                    Printed: <?= nice_datetime(date('Y-m-d H:i:s'))?></span>
                </td>
                <td class="text-right" colspan="6"><span style="color: #666;margin-top: 20px;display: block;">Software Developed By: www.ezsellbd.com</span>
                </td>
            </tr>
            </tfoot>
        </table>
        <?php if(!$settings['header']) {
            echo '<div style="height:'.$settings['foot_size'].'px;"></div>';
        }
        ?>
    </div>
</page>


<script>
    function sale_a4_print() {
        $("#sale_print").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/a4_print.css",
            iframe: false,
            noPrintSelector: ".avoid-this",
            // append : "Free jQuery Plugins!!!<br/>",
            // prepend : "<br/>jQueryScript.net!"
        });
        //$.print("#sale_view");
        $('#SaleInvoiceA4Details').modal('hide');
    }
</script>
