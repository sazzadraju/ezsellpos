<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th>S/L</th>
    <th>Product Name</th>
    <th>product Code</th>
    <th class="text-right">Unit Price</th>
    <th>Order Qty</th>
    <th>Sold Qty</th>
    <th class="text-center">Discount(%)</th>
    <th class="text-center">Vat(%)</th>
    <th class="text-right">Total Amount</th>
    </thead>
    <tbody>
    <?php
    $i = 1;
    $t_qty=0;
    $t_total=0;
    if (!empty($posts)) {
        foreach ($posts as $list) {
            ?>
            <tr>
                <td><?php echo  $i; ?></td>
                <td><?php echo $list['product_name']; ?></td>
                <td><?php echo $list['product_code']; ?></td>
                <td class="text-right"><?php echo $list['unit_price']; ?></td>
                <td><?php echo $list['qty']; ?></td>
                <td><?php echo $list['sale_qty']; ?></td>
                <td class="text-center"><?php echo $list['discount_rate']; ?></td>
                <td class="text-center"><?php echo $list['vat_rate']; ?></td>
                <td class="text-right"><?php echo $list['total_price']; ?></td>
            </tr>

            <?php
            $i++;
            $t_qty+=$list['qty'];
            $t_total+=$list['total_price'];
        }
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4" class="text-right">Total</td>
        <td><?= $t_qty?></td>
        <td colspan="3" class="text-right"><?= $t_total?></td>
    </tr>
    </tfoot>

</table>

