<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("product_code"); ?></th>
    <th><?= lang("product_name"); ?></th>
    <th><?= lang("attributes"); ?></th>
    <th><?= lang("cat/subcat"); ?></th>
    <th><?= lang("store"); ?></th>
    <th><?= lang("supplier"); ?></th>
    <th><?= lang("batch_no"); ?></th>
    <th class="right_text"><?= lang("quantity"); ?></th>
    <?php
    $type= $this->session->userdata['login_info']['user_type_i92']; 
    if($columns[0]->permission==1||$type==3){
        echo '<th class="right_text">'.lang("purchase_price").'</th>';
    }
    ?>
    <th class="right_text"><?= lang("selling_price"); ?></th>
    <th class="right_text"><?= lang("total_price"); ?></th>
    </thead>
    <tbody>
    <?php
    $qty = 0;
    $sell = 0;
    $total_price = 0;
    $purchase = 0;
    $count = 1;
    $total_sell=0;
    if (!empty($posts)):

        foreach ($posts as $post):
            // pa($post);
            ?>
            <tr>
                <?php
                echo '<td>' . $post['product_code'] . '</td>';
                echo '<td>' . $post['product_name'] . '</td>';
                echo '<td>' . $post['attribute_name'] . '</td>';
                $store_name = '';
                // foreach ($stores as $store) {
                //     if ($store->id_store == $post['store_id']) {
                //         $store_name = $store->store_name;
                //         break;
                //     }
                // }
                echo '<td>' .$post['cat_name'] . '/' . $post['subcat_name'] . '</td>';
                echo '<td>' . $post['store_name'] . '</td>';
                echo '<td>' . $post['supplier_name'] . '</td>';
                echo '<td>' . $post['batch_no'] . '</td>';
                echo '<td class="right_text">' . $post['qty'] . '</td>';
                if($columns[0]->permission==1||$type==3){
                    echo '<td class="right_text">' . number_format($post['purchase_price'],2) . '</td>';
                }
                
                echo '<td class="right_text">' . number_format($post['selling_price_act'],2) . '</td>';
                if($columns[0]->permission==1||$type==3){
                    echo '<td class="right_text">' . ($post['qty'] * $post['purchase_price']) . '</td>';
                }else{
                    echo '<td class="right_text">' . ($post['qty'] * $post['selling_price_act']) . '</td>';
                }
                
                $qty +=$post['qty'];
                $sell += $post['selling_price_act'];
                $purchase += $post['purchase_price'];
                $total_price +=($post['qty'] * $post['purchase_price']);
                $total_sell += ($post['qty'] * $post['selling_price_act']);

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
    <th colspan="5"> <?= lang("total"); ?></th>
    <th colspan="2" class="text-right">  Total Qty.:<?= number_format($qty, 2,'.','');?><br>
        Total Item: <?= $count - 1; ?>
    </th>
    <th  colspan="4" class="text-right">
        <?php 
        if($columns[0]->permission==1||$type==3){
                    echo 'Stock Value:';
                    echo set_currency(number_format($total_price, 2,'.','')) . '<br>';
        }
        ?>
        Est. Selling Price: <?= set_currency(number_format($total_sell, 2,'.','')); ?>
    </th>
    
    </tfoot>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
