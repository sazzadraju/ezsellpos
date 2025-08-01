
<style>


    table#profitnloss thead  th:nth-child(n){
        background: #3E4B5B;
        color: #fff;
        text-shadow: 0px 0px 4px #666;
        border: 0;
        text-align: center;
    }

    table#profitnloss tbody tr td:nth-child(n){
        background: #3e4b5b4f;
        border: 0;
        text-align: center;
    }



    /*sale price/buy price*/

    table#profitnloss thead  th:nth-child(3){
        background: #2ba023;
        color: #fff;
        text-shadow: 0px 0px 4px #666;
        border: 0;
        text-align: right;
        padding-right: 10px !important;
    }
    table#profitnloss thead  th:nth-child(4){
        background: #2ba023;
        color: #fff;
        text-shadow: 0px 0px 4px #666;
        border: 0;
        text-align: right;
        padding-right: 10px !important;
    }

    table#profitnloss tbody tr td:nth-child(4){
        background: #0aa50057;
        border: 0;
        text-align: right;
        padding-right: 10px !important;
    }
    table#profitnloss tbody tr td:nth-child(3){
        background: #0aa50057;
        border: 0;
        text-align: right;
        padding-right: 10px !important;
    }

    /*Return Sale/buy*/

    table#profitnloss thead  th:nth-child(5){
        background: #c56c20;
        color: #fff;
        text-shadow: 0px 0px 4px #666;
        border: 0;
        text-align: right;
        padding-right: 10px !important;
    }
    table#profitnloss thead  th:nth-child(6){
        background: #c56c20;
        color: #fff;
        text-shadow: 0px 0px 4px #666;
        border: 0;
        text-align: right;
        padding-right: 10px !important;
    }

    table#profitnloss tbody tr td:nth-child(5){
        background: #dc965999;
        border: 0;
        text-align: right;
        padding-right: 10px !important;
    }
    table#profitnloss tbody tr td:nth-child(6){
        background: #dc965999;
        border: 0;
        text-align: right;
        padding-right: 10px !important;
    }

    /*total*/

    table#profitnloss thead  th:last-child{
        background: #2665b3;
        color: #fff;
        text-shadow: 0px 0px 4px #666;
        border: 0;
        text-align: right;
        padding-right: 10px !important;
    }

    table#profitnloss tbody tr td:last-child{
        background: #0a56b36e;
        border: 0;
        text-align: right;
        padding-right: 10px !important;
    }
    table#profitnloss tbody tr td:nth-last-child(2){
        text-align: right;
        padding-right: 10px !important;
    }
    table#profitnloss tbody tr td:nth-last-child(3){
        text-align: right;
        padding-right: 10px !important;
    }
    table#profitnloss thead   th:nth-last-child(2){
        text-align: right;
        padding-right: 10px !important;
    }
    table#profitnloss thead  th:nth-last-child(3){
        text-align: right;
        padding-right: 10px !important;
    }
</style>
<table id="profitnloss" class="table table-bordred table-striped">
    <thead>
    <th ><?= lang("date"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th class="text-right"><?= lang("sales_price"); ?></th>
    <th class="text-right"><?= lang("buying_price"); ?></th>
    <th class="text-right"><?= lang("return_sale"); ?></th>
    <th class="text-right">Return VAT</th>
    <th class="text-right"><?= lang("return_buy"); ?></th>
    <th class="text-right"><?= lang("redeem"); ?></th>
    <th class="right_text"><?= lang("round"); ?></th>
    <th class="text-right">Total VAT</th>
    <th class="right_text"><?= lang("profit_loss"); ?></th>

    </thead>
    <tbody>
    <?php
    $sum = 0;
    $sum_round = 0;
    $sum_sale_price=$sub_buy_price=$sum_rtn_sale=$sum_rtn_buy=$sum_redeem=$sum_tot_vat=$sum_ret_vat=0;
    if (!empty($posts)):
        $count = 1;
        $i = 0;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                $date = date('Y-m-d', strtotime($post['dtt_add']));
                echo '<td>' . $date . '</td>';
                $store_name = '';
                foreach ($store as $stores) {
                    if ($stores->id_store == $post['store_id']) {
                        $store_name = $stores->store_name;
                        break;
                    }
                }
                $return_invoice=($post['return_tot']!='')?$post['return_tot'][$i]['return_invoice']:0;
                $return_purchase_price=($post['return']!='')?$post['return'][$i]['return_purchase_price']:0;
                $return_profit =  $return_invoice- $return_purchase_price;
                $tot_vat=($post['tot_vat']!='')?$post['tot_vat'][$i]['tot_vat']:0;
                $tot_ret_vat=($post['tot_return_vat']!='')?$post['tot_return_vat'][$i]['tot_ret_vat']:0;
                echo '<td>' . $store_name . '</td>';
                echo '<td class="right_text">' . $post['total'][$i]['sale_invoice'] . '</td>';
               
                echo '<td class="right_text">' . number_format((float)$post['amt'], 2, '.', '') . '</td>';
                echo '<td class="right_text">' . number_format((float)$return_invoice, 2, '.', '') . '</td>';
                echo '<td class="right_text">' . $tot_ret_vat . '</td>';
                echo '<td class="right_text">' . number_format((float)$return_purchase_price, 2, '.', '') . '</td>';
                echo '<td class="right_text">' . $post['round'][$i]['remit_amt'] . '</td>';
                echo '<td class="right_text">' . $post['round'][$i]['ramt'] . '</td>';
                echo '<td class="right_text">' . $tot_vat . '</td>';
                $profit = ($post['total'][$i]['sale_invoice'] - $post['amt']) + $post['round'][$i]['ramt'];

                $profit_loss = (($profit - $return_profit) - $post['round'][$i]['remit_amt'])-$tot_vat;
                echo '<td class="right_text">' . $profit_loss . '</td>';
                $sum = $sum + $profit_loss;
                $sum_sale_price+=$post['total'][$i]['sale_invoice'];
                $sub_buy_price+=$post['amt'];
                $sum_rtn_sale+=$return_invoice;
                $sum_rtn_buy+=$return_purchase_price;
                $sum_redeem+=$post['round'][$i]['remit_amt'];
                $sum_round+=$post['round'][$i]['ramt'];
                $sum_tot_vat+=$tot_vat;
                $sum_ret_vat+=$tot_ret_vat;
                ?>
            </tr>
            <?php
            $count++;

        endforeach;
    else:
        ?>
        <tr>
            <td colspan="9" class="text-center"><b><?= lang("data_not_available"); ?></b></td>
        </tr>
    <?php endif; ?>
    </tbody>
    <tfoot>
    <tr>
        <th class="right_text" colspan="2"><?= lang("net_total"); ?></th>
        <th class="right_text"> <?= $sum_sale_price; ?></th>
        <th class="right_text"> <?= $sub_buy_price; ?></th>
        <th class="right_text"> <?= $sum_rtn_sale; ?></th>
        <th class="right_text"> <?= $sum_ret_vat; ?></th>
        <th class="right_text"> <?= $sum_rtn_buy; ?></th>
        <th class="right_text"> <?= $sum_redeem; ?></th>
        <th class="right_text"> <?= $sum_round; ?></th>
        <th class="right_text"> <?= $sum_tot_vat; ?></th>
        <th class="right_text"> <?= $sum; ?></th>
    </tr>
    </tfoot>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
