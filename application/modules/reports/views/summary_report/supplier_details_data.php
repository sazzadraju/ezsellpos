  <link href="<?= base_url(); ?>themes/default/css/custom.css" rel="stylesheet">
    <link href="<?= base_url(); ?>themes/default/css/report_print.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/bootstrap.min.css">
    <table id="mytable" class="table table-bordered table-striped">
        <thead>
        <th class="fit"><?= lang("sl_no"); ?></th>
        <th><?= lang("date"); ?></th>
        <th class="fit"><?= lang("trx_no"); ?></th>
        <th><?= lang("type"); ?></th>
        <th><?= lang("supplier"); ?></th>
        <th><?= lang("description"); ?></th>
        <th class="text-right"><?= lang("amount"); ?></th>
        
        
        </thead>
        <tbody>
        <?php
        $sum = 0;
        if (!empty($posts)):
            $count = 1;
            foreach ($posts as $post):
                ?>
                <tr>
                    <?php
                    echo '<td>'.$count.'</td>';
                    echo '<td>' . nice_date($post['transaction_date']) . '</td>';
                    echo '<td>' . $post['trx_no'] . '</td>';
                    echo '<td>' . $post['type_name'] . '</td>';
                    echo '<td>' . $post['supplier_name'] . '</td>';
                    echo '<td>' . substr($post['description'], 0, 60) . '</td>';
                    echo '<td class="right_text">' . floatVal($post['tot_amount']) . '</td>';
                    $sum = $sum + $post['tot_amount'];
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
        <th colspan="6" class="text-right"><?= lang("total"); ?></th>
        <th class="right_text"><?= floatVal($sum); ?></th>
        </tfoot>
    </table>