<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/bootstrap.min.css">
<table id="mytable" class="table table-bordered">
    <thead>
    <tr>
        <th class="text-center"><?= lang('serial') ?></th>
        <th><?= lang('product') ?></th>
        <th><?= lang('code') ?></th>
        <th ><?= lang('batch') ?></th>
        <th><?= lang('supplier') ?></th>
        <th><?= lang('expiration_date') ?></th>
        <th><?= lang('comments') ?></th>
        <?php 
        $type= $this->session->userdata['login_info']['user_type_i92']; 
        if($columns[0]->permission==1||$type==3){
            echo '<th class="text-right">'. lang("purchase_price").'</th>';
        }
        ?>
        <th class="text-right"><?= lang('sale_price') ?></th>
        <th class="text-right"><?= lang("quantity"); ?></th>
        <?php 
        if($columns[0]->permission==1||$type==3){
            echo '<th class="text-right">'. lang("purchase_total").'</th>';
        }
        ?>
        <th class="text-right"><?= lang("sale_total"); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $tot_qty = 0;
    $purchase_total=0;
    $sale_total=0;
    if (!empty($stock_transfer_list)) {
        $i = 1;
        foreach ($stock_transfer_list as $list) {
            $attr_name=($list['attribute_name']!='')?' ('.$list['attribute_name'].')':'';
            ?>
            <tr>
                <td class="text-center"><?php echo $i; ?></td>
                <td><?php echo $list['product_name'].$attr_name; ?></td>
                <td><?php echo $list['product_code']; ?></td>
                <td><?php echo $list['batch_no']; ?></td>
                <td><?php echo $list['supplier_name']; ?></td>
                <td><?php echo $list['expire_date']; ?></td>
                <td><?php echo $list['notes']; ?></td>
                <?php 
                $col_span=8;
                if($columns[0]->permission==1||$type==3){
                    $col_span=9;
                    echo '<td class="text-right">' . $list['purchase_price'] . '</td>';
                    $purchase_total += $list['purchase_price'] * $list['qty'];
                }
                echo '<td class="text-right">' . $list['selling_price_est'] . '</td>';
                echo '<td class="text-right">' . $list['qty'] . '</td>';
                if($columns[0]->permission==1||$type==3){
                    echo '<td class="text-right">' . $list['purchase_price'] * $list['qty'] . '</td>';
                }
                echo '<td class="text-right">' . $list['selling_price_est'] * $list['qty'] . '</td>';
                $sale_total += $list['selling_price_est'] * $list['qty'];
                ?> 
            </tr>
            <?php
            $i++;
            $tot_qty += $list['qty'];
            //$total += ($list['qty'] * $list['purchase_price']);
        }
    }
    ?>
    </tbody>
    <tfoot>
    <th class="text-right" colspan="<?= $col_span?>"><?= lang("total"); ?></th>
    <th class="right_text"><?= number_format($tot_qty, 2); ?></th>
    <?php 
    if($columns[0]->permission==1 ||$type==3){
        echo '<th class="text-right">'. number_format($purchase_total, 2).'</th>';
    }
    ?>
    <th class="text-right"><?= number_format($sale_total, 2); ?></th>
    </tfoot>
</table>
<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>