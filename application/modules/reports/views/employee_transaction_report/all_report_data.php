<!-- <?php print_r($transaction_type); ?> -->

<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("date"); ?></th>
    <th><?= lang("transaction_no"); ?></th>
    <th><?= lang("employee_name"); ?></th>
    <th><?= lang("transaction_name"); ?></th>
    <th><?= lang("transaction_type"); ?></th>
    <th><?= lang("store"); ?></th>
    <th><?= lang("account_no"); ?></th>
    <th class="text-right"><?= lang("amount").' ('.set_currency().')'; ?></th>
    </thead>
    <tbody>
    <?php
    $total=0;
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                echo '<td>' . $post['dtt_trx'] . '</td>';
                echo '<td>' . $post['trx_no'] . '</td>';
                echo '<td>' . $post['emp_name'] . '</td>';
                foreach ($transaction_type as $key => $val) {
                    $type_name = '';
                    if ($key == $post['qty_multiplier']) {
                        $type_name = $val;
                        break;
                    }
                }
                echo '<td>' . $post['trx_name'] . '</td>';
                echo '<td>' . $type_name . '</td>';
                echo '<td>' . $post['store_name'] . '</td>';
                echo '<td>' . account_name_id($post['account_id']) . '</td>';
                echo '<td class="text-right">' . $post['tot_amount'] . '</td>';
                $total=$total+$post['tot_amount'];
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
    <th colspan="6"></th>
    <th ><?= lang("total"); ?></th>
    <th class="text-right"><?= number_format($total, 2, '.', ''); ?></th>
    <!-- <th></th> -->
    </tfoot>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
