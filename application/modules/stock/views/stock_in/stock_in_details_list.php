<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/bootstrap.min.css">
<table id="mytable" class="table table-bordered" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th class="text-center"><?= lang('serial') ?></th>
            <th><?= lang('product_code') ?></th>
            <th><?= lang('product') ?></th>
            <th><?= lang('batch') ?></th>
            <th><?= lang('supplier') ?></th>
            <th><?= lang('expiration_date') ?></th>
            <th class="text-right"><?= lang('purchase')?></th>
            <th class="text-right"><?= lang('sale')?></th>
            <th class="text-right"><?= lang('quantity') ?></th>
            <th class="text-right"><?= lang('purchase_total') ?></th>
            <th class="text-right"><?= lang('sale_total') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $tot_qty = 0;
        $purchase_total = 0;
        $sale_total = 0;
        if (!empty($stock_in_list)) {
            foreach ($stock_in_list as $list) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $i; ?></td>
                    <td><?php echo $list['product_code']; ?></td>
                    <td><?php echo $list['product_name'].' '.$list['attribute_name']; ?></td>
                    <td><?php echo $list['batch_no']; ?></td>
                    <td><?php echo $list['supplier_name']; ?></td>
                    <td><?php echo (strtotime($list['expire_date']) > 0)?$list['expire_date']:'N/A'; ?></td>
                    <td class="text-right"><?php echo $list['purchase_price']; ?></td>
                    <td class="text-right"><?php echo $list['selling_price_act']; ?></td>
                    <td class="text-right"><?php echo $list['purchase_qty']; ?></td>
                    <td class="text-right"><?php echo $list['purchase_qty'] * $list['purchase_price']; ?></td>
                    <td class="text-right"><?php echo $list['selling_price_act'] * $list['purchase_qty']; ?></td>
                </tr>
                <?php
                $i++;
                $tot_qty += $list['purchase_qty'];
                $purchase_total += ($list['purchase_qty'] * $list['purchase_price']);
                $sale_total += ($list['purchase_qty'] * $list['selling_price_act']);
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="8"><?= lang("total"); ?></th>
            <th class="text-right"><?= number_format($tot_qty, 2); ?></th>
            <th class="text-right"><?= number_format($purchase_total, 2); ?></th>
            <th class="text-right"><?= number_format($sale_total, 2); ?></th>
        </tr>
    </tfoot>
</table>
<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>