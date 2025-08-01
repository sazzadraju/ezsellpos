<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("serial"); ?></th>
    <th><?= lang("invoice_no"); ?></th>
    <th><?= lang("sold_by"); ?></th>
    <th><?= lang("sales_person"); ?></th>
    <th><?= lang("customer"); ?></th>
    <th><?= lang("store_station"); ?></th>
    <th><?= lang("invoice_amount"); ?></th>
    <th><?= lang("discount_amount"); ?></th>
    <th><?= lang("sale_price"); ?></th>
    <th><?= lang("cash"); ?></th>
    <th><?= lang("bank"); ?></th>
    <th><?= lang("mobile"); ?></th>
    <th><?= lang("due_amount"); ?></th>
    <th><?= lang("settle_amount"); ?></th>
    </thead>
    <tbody>
    <?php
	$invoice_total = $due_total = $cash_total = $bank_total = $mobile_total =$total_discount = $product_total = 0;
    $total_settle=0;
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            $transactions = $this->commonmodel->sale_transaction_details($post['id_sale']);
            $personId = $this->sales_model->getSalesPersonById($post['sales_person_id']);
            $sPersonName=($personId)?$personId[0]['user_name'].'('.$personId[0]['person_type'].')':'';
            
            $cash = $bank = $mobile = 0;
            foreach ($transactions as $tran) {
                if ($tran['payment_method_id'] == 1) {
                    $cash += $tran['amount'];
                    $cash_total += $tran['amount'];
                } elseif ($tran['payment_method_id'] == 3) {
                    $mobile += $tran['amount'];
                    $mobile_total += $tran['amount'];
                } else {
                    $bank += $tran['amount'];
                    $bank_total += $tran['amount'];
                }
            }
            $promotions = $this->sell_report_model->sale_promotion_list($post['id_sale']);
            $discount_list=0;
            if ($promotions) {
                $i=1;
                $promo = $this->config->item('promotion_type_sales');
                foreach ($promotions as $promotion) {
                    $comma=($i==1)?'':', ';
                    $type = $promotion['promotion_type_id'];
                    //$discount_list=$discount_list.$comma.$promo[$type].'='.$promotion['discount_amt'];
                    $discount_list+=$promotion['discount_amt'];
                    $total_discount += $promotion['discount_amt'];
                    $i++;
                }

            }
            ?>
            <tr>
                <?php
                echo '<td>' . $count . '</td>';
                echo '<td id="invoiceNo"><b>' . $post['invoice_no'].'</b><br>'.nice_datetime($post['dtt_add']) . '</td>';
               
                echo '<td>' . $post['user_name'] . '</td>';
                echo '<td>' . $sPersonName . '</td>';
                echo '<td>' . $post['customer_name'].' <span class="gldn">'.$post['customer_type'].'</span>' . '</td>';
                echo '<td>' . $post['store_name'].' ('.$post['station_name'].')' . '</td>';
                echo '<td>' . $post['product_amt'] . '</td>';
                echo '<td>' . $discount_list . '</td>';
                echo '<td>' . $post['tot_amt'] . '</td>';
                echo '<td>' . $cash . '</td>';
                echo '<td>' . $bank . '</td>';
                echo '<td>' . $mobile . '</td>';
                $settle=0;
                $due=0;
                if($post['settle']==1){
                    $total_settle+=$post['due_amt'];
                    $settle=$post['due_amt'];
                }else{
                    $due_total+=$post['due_amt'];
                    $due=$post['due_amt'];
                }
                echo '<td>' . $due . '</td>';
                echo '<td>' . $settle . '</td>';
                ?>
            </tr>
            <?php
            $product_total+=$post['product_amt'];
            $invoice_total+=$post['tot_amt'];
            
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
        </tr>
    <?php endif; ?>
    </tbody>
    <tfoot>
    <th colspan="6" class="text-right"><?= lang("total"); ?></th>
    <th><?= $product_total; ?></th>
    <th><?= $total_discount; ?></th>
    <th><?= $invoice_total; ?></th>
    <th><?= $cash_total; ?></th>
    <th><?= $bank_total; ?></th>
    <th><?= $mobile_total; ?></th>
    <th><?= $due_total; ?></th>
    <th><?= $total_settle; ?></th>
    </tfoot>
</table>