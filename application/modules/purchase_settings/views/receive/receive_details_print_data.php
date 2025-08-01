<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <tr>
        <th><?= lang("serial"); ?></th>
        <th><?= lang("product_code"); ?></th>
        <th><?= lang("product_name"); ?></th>
        <th><?= lang("batch_no"); ?></th>
        <th><?= lang("qty"); ?></th>
        <th class="text-right"><?= lang("unit_price"); ?></th>
        <th class="text-right"><?= lang("total_price"); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $total = 0;
    $qty_total=0;
    $i = 1;
    if (!empty($posts)) {
        foreach ($posts as $list) {
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $list['product_code']; ?></td>
                <td><?php echo $list['product_name']; ?></td>
                <td><?php echo $list['batch_no']; ?></td>
                <td><?php echo number_format($list['qty'], 2); ?></td>
                <?php $tot_amt = $list['qty'] * $list['purchase_price']; ?>
                <td class="text-right"><?php echo set_currency(number_format($list['purchase_price'], 2)); ?></td>
                <td class="text-right"><?php echo set_currency(number_format($tot_amt, 2)); ?></td>
            </tr>
            <?php
            $i++;
            $total += $tot_amt;
            $qty_total+=$list['qty'];
        }
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="4" style="text-align:right;">Total:</th>
        <th><?= number_format($qty_total,2)?></th>
        <th colspan="2" class="text-right"
            style=" margin-left: 10px;"><?= set_currency(number_format($total)) ?></th>
    </tr>
    </tfoot>
</table>
