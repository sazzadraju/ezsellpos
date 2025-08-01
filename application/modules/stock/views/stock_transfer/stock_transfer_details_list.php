<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/bootstrap.min.css">
<table width="90%" style=" font-weight: bold;" align="center">
    <tr>
        <td width="15%"><?= lang('from_store')?></td>
        <td width="1%">:</td>
        <td width="35%"><?=$stores[0]['from_store']?></td>
        <td width="15%"><?= lang('to_store')?></td>
        <td width="1%">:</td>
        <td width="35%"><?=$stores[0]['to_store']?></td>
    </tr>
</table>
<table id="mytable" class="table table-bordered">
    <thead>
    <tr>
        <th class="text-center"><?= lang('serial') ?></th>
        <th><?= lang('product') ?></th>
        <th><?= lang('code') ?></th>
        <th><?= lang('batch') ?></th>
        <th><?= lang('supplier') ?></th>
        <th><?= lang('expired') ?></th>
        <?php
        $type= $this->session->userdata['login_info']['user_type_i92'];
        if($columns[0]->permission==1||$type==3){
            echo '<th class="text-right">'. lang('purchase') . '</th>';
         }
        ?>
        <th class="text-right"><?= lang('sale') ?></th>
        <th class="text-right"><?= lang('quantity') ?></th>
        <?php
        if($columns[0]->permission==1||$type==3){
            echo '<th class="text-right">'. lang('purchase_total') .'</th>';
         }
        ?>
        <th class="text-right"><?= lang('sale_total') ?></th>

    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    $tot_qty = 0;
    $purchase_total = 0;
    $sale_total = 0;
    if (!empty($stock_transfer_list)) {
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
                <?php
                $colspan=7; 
                if($columns[0]->permission==1||$type==3){
                    $colspan=8; 
                    echo '<td class="text-right">'. round($list['purchase_price'],2).'</td>';
                    $pur_sub=$list['purchase_qty'] * $list['purchase_price'];
                    $purchase_total +=  $pur_sub;
                    
                }
                ?>
                
                <td class="text-right"><?php echo round($list['selling_price_est'],2); ?></td>
                <td class="text-right"><?php echo round($list['purchase_qty'],2); ?></td>
                <?php 
                if($columns[0]->permission==1||$type==3){
                    echo '<td class="text-right">'. round($pur_sub,2).'</td>';  
                }
                $sell_sub=$list['purchase_qty'] * $list['selling_price_est'];
                $sale_total +=  $sell_sub;
                ?>
                <td class="text-right"><?php echo round($sell_sub,2); ?></td>
            </tr>
            <?php
            $i++;
            $tot_qty += $list['purchase_qty'];
            
        }
    }
    ?>
    </tbody>
    <tfoot>
    <th class="text-right" colspan="<?= $colspan?>"><?= lang("total"); ?></th>
    <th class="text-right"><?= round($tot_qty,2); ?></th>
     <?php 
    if($columns[0]->permission==1||$type==3){
        echo '<th class="text-right">'. round($purchase_total,2).'</th>';  
    }?>
    <th class="text-right"><?= round($sale_total,2); ?></th>
    </tfoot>
</table>
<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>