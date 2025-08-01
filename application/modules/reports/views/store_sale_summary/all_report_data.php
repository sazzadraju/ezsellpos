<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("sl"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th class="right_text"><?= lang("invoice_amount"); ?></th>
    <th class="right_text"><?= lang("discount_amount"); ?></th>
    <th class="right_text"><?= lang("paid-amt"); ?></th>
    <th class="right_text"><?= lang("due_amount"); ?></th>
    </thead>
    <tbody>
    <?php
    $invoice_sum=$paid_sum=$due_sum=$discount_sum=0;
    if (!empty($posts)):
        $count = 1;
        // print_r($posts);
        foreach ($posts as $post):
            $discount=0;
            foreach ($discounts as $key) {
               if($key['store_id']==$post['store_id']){
                    $discount=$key['discount_amt'];
                    break;
               }
            }
            ?>
            <tr>
                <?php


                echo '<td id="invoiceNo">'.$count.'</td>';
                $date = date('Y-m-d', strtotime($post['dtt_add']));
                echo '<td>' . $post['store_name'] . '</td>';
                
                echo '<td class="right_text">' . $post['tot_amt'] . '</td>';
                echo '<td class="right_text">' . $discount . '</td>';
                echo '<td class="right_text">' . ($post['paid_amt']) . '</td>';
                echo '<td class="right_text">' . ($post['due_amt']) . '</td>';
                $invoice_sum+=$post['tot_amt'];
                $paid_sum+=$post['paid_amt'];
                $due_sum+=$post['due_amt'];
                $discount_sum+=$discount;
                ?>
            </tr>
            <?php
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
    <th></th>

    <th><?= lang("total"); ?></th>
    <th class="right_text"><?= number_format($invoice_sum, 2, '.', '') ?></th>
    <th class="right_text"><?= number_format($discount_sum, 2, '.', '')?></th>
    <th class="right_text"><?= number_format($paid_sum, 2, '.', '') ?></th>
    <th class="right_text"><?= number_format($due_sum, 2, '.', '') ?></th>
    <!-- <th></th> -->
    </tfoot>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>


<script type="text/javascript">
    

