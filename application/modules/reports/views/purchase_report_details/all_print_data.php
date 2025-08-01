<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th class="text-center"><?= lang("serial"); ?></th>
    <th><?= lang("purchase_date"); ?></th>
    <th><?= lang("invoice_no"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th><?= lang("supplier_name"); ?></th>
    <th class="text-right"><?= lang("price"); ?></th>

    </thead>
    <tbody>
    <?php
    if (!empty($posts)):

        $count = 1;
        $total=0;
        foreach ($posts as $post):
            // print_r($post);
            ?>
            <tr>
                <?php
                echo '<td class="text-center">' . $count . '</td>';
                echo '<td>' . $post['dtt_receive'] . '</td>';
                echo '<td>' . $post['invoice_no'] . '</td>';
                echo '<td>' . $post['store_name'] . '</td>';
                echo '<td>' . $post['supplier_name'] . '</td>';
                echo '<td class="text-right">' . $post['tot_amt'] . '</td>';
                ?>
            </tr>
            <?php
            $total+=$post['tot_amt'];
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
        <tr>
            <th colspan="5" class="text-right"> Total</th>
            <th class="text-right"> <?= number_format($total, 2, '.', '')?></th>
        </tr>
    </tfoot>
</table>

<div class="clearfix"></div>
