<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <th><?= lang("serial"); ?></th>
    <th><?= lang("product_code"); ?></th>
    <th><?= lang("product_name"); ?></th>
    <th><?= lang("attributes"); ?></th>
    <th class="text-right"><?= lang("qty"); ?></th>
    <th class="text-right"><?= lang("unit_price"); ?></th>
    <th class="text-right"><?= lang("total_price"); ?></th>
</thead>
<tbody>
    <?php
    $total=0;
    $qty_total=0;
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                echo '<td>' . $count . '</td>';
                echo '<td>' . $post['product_code'] . '</td>';
                echo '<td>' . $post['product_name'] . '</td>';
                echo '<td>' . $post['attribute_name'] . '</td>';
                echo '<td class="text-right">' . number_format($post['qty'],2) . '</td>';
                echo '<td class="text-right">' . number_format($post['unit_amt'],2) . '</td>';
                echo '<td class="text-right">' . number_format($post['tot_amt'],2) . '</td>';
                ?>
            </tr>
            <?php
            $count++;
            $total+=$post['tot_amt'];
            $qty_total+=$post['qty'];
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="5"><b><?= lang("data_not_available"); ?></b></td>
        </tr>
    <?php endif; ?>
</tbody>
<tfoot>
    <tr>
        <th colspan="4" style="text-align:right;">Total:</th>
        <th style="text-align:right;"><?= number_format($qty_total,2)?></th>
        <th colspan="2" style=" text-align:right;"><?= number_format($total,2)?></th>
    </tr>
</tfoot>
</table>