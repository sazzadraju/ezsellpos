<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <th><?= lang("sl"); ?></th>
        <th><?= lang("date"); ?></th>
        <th><?= lang("invoice_no"); ?></th>
        <th><?= lang("product_name"); ?></th>
        <th><?= lang("batch_no"); ?></th>
        <th><?= lang("brand"); ?></th>
        <th><?= lang("customer"); ?></th>
        <th><?= lang("store"); ?></th>
        <th class="right_text"><?= lang("unit_price"); ?></th>
        <th class="right_text"><?= lang("qty"); ?></th>
        <th class="right_text"><?= lang("vat"); ?></th>
        <th class="right_text"><?= lang("dis"); ?></th>
        <th class="right_text"><?= lang("amount"); ?></th>
    </thead>
    <tbody>
        <?php
        $sum = 0;
        $qty_sum = 0;
        $vat_sum = 0;
        $dis_sum = 0;
        if (!empty($posts)):
            $count = 1;

            foreach ($posts as $post):
                    // pa($post);
                ?>
                <tr>
                    <?php
                    echo '<td id="invoiceNo">'.($offset+$count).'</td>';
                    $date = date('Y-m-d', strtotime($post['dtt_add']));
                    echo '<td>' . $date . '</td>';
                    echo '<td>' . $post['invoice_no'] . '</td>';
                    echo '<td>' . $post['product_name'].' ('.$post['product_code']  . ')</td>';
                    echo '<td>' . $post['batch_no'] . '</td>';
                    echo '<td>' . $post['brand_name'] . '</td>';
                    echo '<td>' . $post['customer_name'] . '</td>';
                    echo '<td>' . $post['store_name'] . '</td>';
                    echo '<td class="right_text">' . $post['unit_price']/$post['qty'] . '</td>';
                    echo '<td class="right_text">' . $post['qty'] . '</td>';
                    echo '<td class="right_text">' . $post['vat_amt'] . '</td>';
                    echo '<td class="right_text">' . $post['discount_amt'] . '</td>';
                    echo '<td class="right_text">' . $post['amt'] . '</td>';
                    $sum = $sum + $post['amt'];
                    $qty_sum = $qty_sum + $post['qty'];
                    $vat_sum += $post['vat_amt'];
                    $dis_sum +=  $post['discount_amt'];
                    ?>
                        <!-- <td class="center">
                    <button class="btn btn-primary pull-right" type="button" onclick="searchFilter2('<?php echo $post["id_sale"] ?>')"><i class="fa fa-eye"></i></button>
                </td> -->
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
    <th colspan="8"></th>
    <!-- <th></th> -->
    <th><?= lang("total"); ?></th>
    <th class="right_text"><?= $qty_sum; ?></th>
    <th class="right_text"><?= $vat_sum; ?></th>
    <th class="right_text"><?= $dis_sum; ?></th>
    <th class="right_text"><?= $sum; ?></th>
</tfoot>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>