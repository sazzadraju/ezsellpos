<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/a4_print.css">
<page size="A4">
    <div class="invoice-w">
        <div class="infos">
            <?php if ($settings['header']) { ?>
                <div class="info-1">
                    <?php echo ($settings['shop_name']) ? '<div class="company-name">' . explode("&", $this->session->userdata['login_info']['store_name'])[0] . '</div>' : ''; ?>
                    <div class="company-address"><?= $this->session->userdata['login_info']['address'] ?></div>
                    <?php echo ($settings['phone']) ? '<div class="company-extra">' . $this->session->userdata['login_info']['store_mobile'] . '</div>' : ''; ?>
                    <?php echo ($settings['email']) ? '<div class="company-extra">' . $this->session->userdata['login_info']['store_email'] . '</div>' : ''; ?>
                </div>
                <div class="info-1-logo">
                    <?php
                    if ($this->session->userdata['login_info']['store_img'] != '' && $settings['shop_logo']) {
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
                    <div class="invoice-date"><?= nice_datetime(date('Y-m-d H:i:s')) ?></div>
                    <h3>Vat Reg No: <?= $vat_reg_no[0]['vat_reg_no'] ?></h3>
                </div>

                <div class="invoice-no">
                    <h3>Invoice: <?= $invoice ?></h3>
                    <?php
                    $img = $this->barcode->code128BarCode($invoice, 1);
                    ob_start();
                    imagepng($img);
                    $output_img = ob_get_clean();
                    echo '<div class="bar-code">';
                    echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
                    echo '</div>';
                    ?>
                </div>

                <div class="customer-details">
                    <div class="cus-id"><?= $customer_code ?></div>
                    <div class="cus-name"><?= $customer_name ?></div>
                    <div class="cus-contact"><?= $customer_phone ?></div>
                </div>
            </div>
        </div>


        <div class="invoice-body" style="margin-top: 20px;">
            <div class="invoice-table">
                <table class="table">
                    <tr>
                        <th style="width: 35%" class="text-left">Product</th>
                        <?php
                        $c = 0;
                        if ($settings['brand']) {
                            $c += 1;
                            echo '<th class="text-left">' . lang("brand") . '</th>';
                        }
                        echo '<th class="text-left">' . lang("category") . '</th>';
                        if ($settings['sub_cat']) {
                            $c += 1;
                            echo '<th class="text-left">' . lang("sub_category") . '</th>';
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
                                <td><?php echo $code . '<span> ' . $row['product_name'] . '</span>' . '<br><span>' . $row['attribute_name'] . '</span>'; ?></td>
                                <?php
                                if ($settings['brand']) {
                                    echo '<td class="text-left">' . $row['brand_name'] . '</td>';
                                }
                                echo '<td class="text-left">' . $row['cat_name'] . '</td>';
                                echo ($settings['sub_cat']) ? '<td class="text-left">' . $row['sub_cat_name'] . '</td>' : '';
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
                        <td class="text-left" colspan="<?= (3 + $c) ?>" style="font-weight: 600;"><?= count($count_pro)?> Items</td>
                        <td class="text-center" style="font-weight: 600;"><?= $qty_sum ?></td>
                        <td class="text-right" colspan="2" style="font-weight: 600;"><?= $vat ?></td>
                        <td class="text-right" style="font-weight: 600;"><?= set_currency($product_amt) ?></td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td style="border: 0;">
                            <?php
                            if ($points != '') {
                                $bo_remit = isset($remit_point) ? (int)$remit_point : 0;
                                $bonus_total = ($points + $bonus_points) - $bo_remit;
                                ?>
                                <div class="rmet-point">
                                    <table>
                                        <tr>
                                            <td style="border: 0;">Current Bonus Point:</td>
                                            <td style="border: 0;"><?= round($bonus_points, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 0;">Total Bonus Point:</td>
                                            <td style="border: 0;"><?= round($bonus_total, 2) ?></td>
                                        </tr>
                                        <?php
                                            if( $sales_person_name!=0){
                                            ?>
                                                <tr>
                                                    <td style="border: 0;">Sold by:</td>
                                                    <td style="border: 0;"><?= $sales_person_name; ?></td>
                                                </tr>
                                            <?php }?>
                                    </table>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (!empty($delivery_address)) {
                                ?>
                                <div class="delvery-details">
                                    <h3><?= lang('delivery_details') ?></h3>
                                    <div class="delvery-details-title"><?= lang("delivery_person") ?>:</div>
                                    <div class="delvery-details-info"><?= $delivery_person_name ?></div>
                                    <div class="delvery-details-title"><?= lang("delivery_address") ?>:</div>
                                    <div class="delvery-details-info"><?= $delivery_address ?></div>
                                    <div class="delvery-details-title"><?= lang("service_price") ?>:</div>
                                    <div class="delvery-details-info"><?= $service_price ?></div>
                                    <div class="delvery-details-title"><?= lang("paid_amount") ?>:</div>
                                    <div class="delvery-details-info"><?= $de_paid_amount ?></div>
                                    <div class="delvery-details-title"><?= lang("due_amount") ?>:</div>
                                    <div class="delvery-details-info"><?= $service_price - $de_paid_amount ?></div>
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
                                echo ($note!='') ? '<b>Comments:</b>' . $note : '';
                                ?>
                            </div>
                        </td>
                        <td colspan="<?= (6 + $c) ?>" style="border: 0;padding: 0 !important;">
                            <blockquote>
                                <table class="foot-table">
                                    <tbody>
                                    <?php
                                    $all_dis = 0;
                                    if (isset($sp_discount)) {
                                        $sp_discount1 = explode("@", $sp_discount);
                                        echo '<tr><td class="text-right">Special Discount (-)' . $sp_discount1[0] . '%</td>';
                                        echo '<td class="text-right" >' . ($sp_discount1[1]) . '</td></tr>';
                                        $all_dis += $sp_discount1[1];
                                    }
                                    if (isset($cus_discount)) {
                                        $cus_discount1 = explode("@", $cus_discount);
                                        echo '<tr><td class="text-right">Customer Discount (-)' . $cus_discount1[0] . '%</td>';
                                        echo '<td class="text-right">' . ($cus_discount1[1]) . '</td></tr>';
                                        $all_dis += $cus_discount1[1];
                                    }
                                    if (isset($pur_discount)) {
                                        $pur_discount1 = explode("@", $pur_discount);
                                        echo '<tr><td class="text-right">Purchase Discount (-)' . $pur_discount1[0] . '%</td>';
                                        echo '<td class="text-right">' . ($pur_discount1[1]) . '</td></tr>';
                                        $all_dis += $pur_discount1[1];
                                    }
                                    if (isset($cart_discount)) {
                                        $cart_discount1 = explode("@", $cart_discount);
                                        echo '<tr><td class="text-right">Card Discount (-)' . $cart_discount1[0] . '%</td>';
                                        echo '<td class="text-right">' . ($cart_discount1[1]) . '</td></tr>';
                                        $all_dis += $cart_discount1[1];
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-right" style="font-weight: bold;"><span
                                                    style="border-bottom: 1px solid #666;">Net Amount(<?= set_currency() ?>
                                                )</span></td>
                                        <td class="text-right"
                                            style="font-weight: bold;border-bottom: 1px solid #666 !important;"><?php echo $product_amt - $all_dis; ?></td>
                                    </tr>

                                    <?php
                                    // Pay type
                                    $all_paid_amt = 0;
                                    if (isset($cash_pay)) {
                                        echo '<tr><td class="text-right">Cash Payment</td>';
                                        echo '<td class="text-right">' . ($cash_pay) . '</td></tr>';
                                        $all_paid_amt += $cash_pay;
                                    }
                                    if (isset($cart_pay)) {
                                        echo '<tr><td class="text-right">Card Payment</td>';
                                        echo '<td class="text-right">' . ($cart_pay) . '</td></tr>';
                                        $all_paid_amt += $cart_pay;
                                    }
                                    if (isset($mobile_pay)) {
                                        echo '<tr><td class="text-right">Mobile Payment</td>';
                                        echo '<td class="text-right">' . ($mobile_pay) . '</td></tr>';
                                        $all_paid_amt += $mobile_pay;
                                    }
                                    if (isset($order_pay)) {
                                        echo '<tr><td class="text-right">Order Advance Payment</td>';
                                        echo '<td class="text-right">' . ($order_pay) . '</td></tr>';
                                        $all_paid_amt += $order_pay;
                                    }

                                    ?>
                                    <!-- Total Amount-->
                                    <tr>
                                        <td class="text-right" style="font-weight: bold;"><span
                                                    style="border-bottom: 1px solid #666;">
                                                    Total Amount(<?= set_currency() ?>)
                                        </td>
                                        <td class="text-right"
                                            style="font-weight: bold;border-bottom: 1px solid #666 !important;">
                                            <?= $all_paid_amt ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $paid_amt_array = explode('@', $paid_amt);
                                    ?>
                                    <!-- Paid, Round, Due Amount-->
                                    <tr>
                                        <td class="text-right">
                                            <span style="font-weight: 600;">[Paid Amount]</span>
                                        </td>
                                        <td class="text-right"><?= ($paid_amt_array[0]) ?>
                                        </td>
                                    </tr>
                                    <?php
                                    if ($remit_taka != '0') {
                                        ?>
                                        <tr>
                                            <td class="text-right">
                                                <span style="font-weight: 600;">Redeem</span>
                                            </td>
                                            <td class="text-right"><?= ($remit_taka) ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-right">
                                            <span style="font-weight: 600;">Round</span>
                                        </td>
                                        <td class="text-right">
                                            <?= ($paid_amt_array[1]) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">
                                            <span style="font-weight: 600;">Due Amount</span>
                                        </td>
                                        <td class="text-right">
                                            <?= ($paid_amt_array[2]) ?>
                                        </td>
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
            <tfoot style="width: 100%;display: inherit;">
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
                <td colspan="0">
                </td>
                <td class="text-right" colspan="6"><span style="color: #666;margin-top: 20px;display: block;">Software Developed By: www.posspot.com</span>
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
