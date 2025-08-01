

    <link href="<?= base_url(); ?>themes/default/css/custom.css" rel="stylesheet">
    <link href="<?= base_url(); ?>themes/default/css/report_print.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/bootstrap.min.css">
    <table id="mytable" class="table table-bordered table-striped">
        <thead>
        <th><?= lang("sl"); ?></th>
        <th><?= lang("date"); ?></th>
        <th><?= lang("invoice_no"); ?></th>
        <th><?= lang("customer"); ?></th>
        <th><?= lang("station"); ?></th>
        <th><?= lang("sold_by"); ?></th>
        <th class="right_text"><?= lang("invoice_amount"); ?></th>
        <th class="right_text"><?= lang("discount_amount"); ?></th>
        <th class="right_text"><?= lang("sale_price"); ?></th>
        <th class="right_text"><?= lang("paid"); ?></th>        
        <th class="right_text"><?= lang("round"); ?></th>
        <th class="right_text"><?= lang("due"); ?></th>
        </thead>
        <tbody>
        <?php
        $sum = 0;
        $sale_sum = 0;
        $paid_sum = 0;
        $dis_sum = 0;
        $due_sum=0;
        $round_sum=0;
        if (!empty($posts)):
            $count = 1;

            foreach ($posts as $post):
                // pa($post);
                ?>
                <tr>
                    <?php
                    echo '<td id="invoiceNo">'.$count.'</td>';
                    $date = date('Y-m-d', strtotime($post['dtt_add']));
                    echo '<td>' . $date . '</td>';
                    echo '<td>' . $post['invoice_no'] . '</td>';
                    echo '<td>' . $post['customer_name'].' ('.$post['customer_type'].')' . '</td>';
                    echo '<td>' . $post['station_name'] . '</td>';
                    echo '<td>' . $post['user_name'] . '</td>';
                    echo '<td class="right_text">' . floatVal($post['product_amt']) . '</td>';
                    echo '<td class="right_text">' . floatVal($post['discount_amt']) . '</td>';
                     echo '<td class="right_text">' . floatVal($post['tot_amt']) . '</td>';
                    echo '<td class="right_text">' . floatVal($post['paid_amt']) . '</td>';
                    echo '<td class="right_text">' . floatVal($post['round_amt']) . '</td>';
                    echo '<td class="right_text">' . floatVal($post['due_amt']) . '</td>';
                    $sum = $sum + $post['product_amt'];
                    $sale_sum = $sale_sum + $post['tot_amt'];
                    $paid_sum += $post['paid_amt'];
                    $dis_sum +=  $post['discount_amt'];
                    $due_sum +=  $post['due_amt'];
                    $round_sum +=  $post['round_amt'];
                    ?>
                </tr>
                <?php
                $count++;
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="12"><b><?= lang("data_not_available"); ?></b></td>
            </tr>
        <?php endif; ?>
        </tbody>
        <tfoot>
        <th colspan="6" class="text-right"><?= lang("total"); ?></th>
        <th class="right_text"><?= floatVal($sum); ?></th>
        <th class="right_text"><?= floatVal($dis_sum); ?></th>
        <th class="right_text"><?= floatVal($sale_sum); ?></th>
        <th class="right_text"><?= floatVal($paid_sum); ?></th>
        <th class="right_text"><?= floatVal($round_sum); ?></th>
        <th class="right_text"><?= floatVal($due_sum); ?></th>
        </tfoot>
    </table>