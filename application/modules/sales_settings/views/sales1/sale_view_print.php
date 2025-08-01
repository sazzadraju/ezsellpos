<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<div class="invoice_content">
    <div class="head">
        <div class="cmp-info">
            <?php if($this->session->userdata['login_info']['store_img']!=NULL&& $settings['shop_logo']){
                $image_path = documentLink('user').$this->session->userdata['login_info']['store_img'];
                echo '<img src="'.$image_path.'" width="100">';
            }
            $shop_n=explode("&", $this->session->userdata['login_info']['store_name'])[0];
            echo ($settings['shop_name'])?'<h4>'.$shop_n.'</h4>':'';
            ?>
            <p> <?= $this->session->userdata['login_info']['address'] ?></p>
            <?php
            echo ($settings['email'])?'<p>'.$this->session->userdata['login_info']['store_email'].'</p>':'';
            ?>
        </div>
    </div>
    <div class="middle-content">

        <div class="bill">
            <div class="vat">
                <p>VAT Reg: <?= $vat_reg_no[0]['vat_reg_no'] ?></p>
            </div>
            <div class="cus-info">
                <p>ServedBy: <?= $this->session->userdata['login_info']['fullname'] ?></p>
                <div class="date">Date:<?= nice_datetime(date('d.m.Y h:i:s A')) ?></div>
                <p>CusID/Name:<?= $customer_code.'/'.$customer_name ?></p>
            </div>
            <p class="invoice-no">
                Invoice: <?= $invoice ?>
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
                        // if ($invoice->id_sale == $row['sale_id']) {
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
                if (isset($sp_discount)) {
                    $sp_discount1 = explode("@", $sp_discount);
                    echo '<p>Special Discount (-)' . $sp_discount1[0] . '%  <span>' . $sp_discount1[1] . '</span></p>';
                    $all_dis += $sp_discount1[1];
                }
                if (isset($cus_discount)) {
                    $cus_discount1 = explode("@", $cus_discount);
                    echo '<p>Customer Discount (-)' . $cus_discount1[0] . '%  <span>' . $cus_discount1[1] . '</span></p>';
                    $all_dis += $cus_discount1[1];
                }
                if (isset($pur_discount)) {
                    $pur_discount1 = explode("@", $pur_discount);
                    echo '<p>Total Purchase Discount (-)' . $pur_discount1[0] . '%  <span>' . $pur_discount1[1] . '</span></p>';
                    $all_dis += $pur_discount1[1];
                }
                if (isset($cart_discount)) {
                    $cart_discount1 = explode("@", $cart_discount);
                    echo '<p>Total Cart Discount (-)' . $cart_discount1[0] . '%  <span>' . $cart_discount1[1] . '</span></p>';
                    $all_dis += $cart_discount1[1];
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
                    if (isset($cash_pay)) {
                        echo '<tr><td>Cash Payment</td><td>' . $cash_pay . ' </td></tr>';
                        $all_paid_amt += $cash_pay;
                    }
                    if (isset($cart_pay)) {
                        echo '<tr><td>Card Payment</td><td>' . $cart_pay . ' </td></tr>';
                        $all_paid_amt += $cart_pay;
                    }
                    if (isset($mobile_pay)) {
                        echo '<tr><td>Mobile Payment</td><td>' . $mobile_pay . ' </td></tr>';
                        $all_paid_amt += $mobile_pay;
                    }
                    if (isset($order_pay)) {
                        echo '<tr><td>Order Advance Payment</td><td>' . $order_pay . ' </td></tr>';
                        $all_paid_amt += $order_pay;
                    }
                    ?>
                    </tbody>
                </table>
                <div class="prd">
                    <p style="font-weight:bold;border-bottom: 1px solid #000;font-size: 14px;">Total Amount:
                        <span><?= $all_paid_amt ?> </span></p>
                    <?php
                    $paid_amt_array = explode('@', $paid_amt);
                    ?>

                    <p style="font-weight:bold;margin:0;">Paid Amount: <span><?= $paid_amt_array[0] ?></span></p>
                    <?php
                    if($remit_taka!='0'){
                        echo '<p style="font-weight:bold;margin:0;">Redeem: <span>'.$remit_taka.'</span></p>';
                    }
                    ?>
                    <p style="font-weight:bold;margin:0;">Round: <span><?= $paid_amt_array[1] ?></span></p>
                    <p style="font-weight:bold;margin:0;">Due Amount: <span><?= $paid_amt_array[2] ?></span></p>
                </div>
                <p>Paid Total:(<?=$cash_paid?>)</p><p>Change Amt.:(<?=$change_amt?>)</p>
            </div>
        </div>
        <div class="">
            <?php
            if($points!=''){
                $bo_remit=isset($remit_point)?(int)$remit_point:0;
                $bonus_total=($points+$bonus_points)-$bo_remit;
                echo 'Current Bonus Point: '.round($bonus_points, 2);
                echo '<br>Total Bonus Point: '.round($bonus_total, 2);
            }
            if($sales_person_name!=0){
                 echo '<br>Sold by: '.$sales_person_name;
            }
            ?>
        </div>
    </div>
    <div class="foot">
        <div class="bar-code">
            <?php
            $img = $this->barcode->code128BarCode($invoice, 1);
            ob_start();
            imagepng($img);
            $output_img = ob_get_clean();
            echo '<div class="barcode">';
            echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '"/>' . '<br>';
            echo '<span class="no"> ' . $invoice . '</span><br />';
            echo '</div>';
            ?>
        </div>
        <?php echo ($settings['phone'])?'<p style="font-weight:bold;">Shop Mobile No:'.$this->session->userdata['login_info']['store_mobile'].'</p>':''; ?>
        <?php
        echo ($note!='') ? '<p>'.$note.'</p>' : '';
        ?>
        <p>Software Developed By: www.ezsellbd.com</p>
        <?php
        $new_note=($settings['note_type']=='yes')?'<p>Note:'.$settings['note'].'</p>':'';
        echo $new_note;
        ?>

    </div>
</div>
