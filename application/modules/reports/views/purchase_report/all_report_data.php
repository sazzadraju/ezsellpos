<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("purchase_date"); ?></th>
    <th><?= lang("product_name"); ?></th>
    <th><?= lang("product_code"); ?></th>
    <th><?= lang("batch_no"); ?></th>
    <th><?= lang("category"); ?></th>
    <th><?= lang("sub_category"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th><?= lang("supplier_name"); ?></th>
    <th class="right_text"><?= lang("purchase_price"); ?></th>
    <th class="right_text"><?= lang("qty"); ?></th>
    <th class="right_text"><?= lang("total"); ?></th>

    </thead>
    <tbody>
    <?php
    // pa($posts);
    $qty = 0;
    $total=0;
    if (!empty($posts)):

        $count = 1;
        foreach ($posts as $post):
            // print_r($post);
            ?>
            <tr>
                <?php
                echo '<td>' . $post['dtt_add'] . '</td>';
                echo '<td>' . $post['product_name'] . '</td>';
                echo '<td>' . $post['product_code'] . '</td>';
                echo '<td>' . $post['batch_no'] . '</td>';
                echo '<td>' . $post['cat_name'] . '</td>';
                echo '<td>' . $post['subcat_name'] . '</td>';
                echo '<td>' . $post['store_name'] . '</td>';
                echo '<td>' . $post['supplier_name'] . '</td>';
                echo '<td class="right_text">' . $post['purchase_price'] . '</td>';
                echo '<td class="right_text">' . $post['qty'] . '</td>';
                $qty = $qty + $post['qty'];
                $total += $post['purchase_price'] * $post['qty'];
                echo '<td class="right_text">' .  $post['purchase_price'] * $post['qty'] . '</td>';


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
    <th colspan="7"></th>
    <th><?= lang("total"); ?></th>
    <th></th>
    <th class="right_text"><?= number_format($qty, 2); ?></th>
    <th class="right_text"><?= number_format($total, 2); ?></th>
    </tfoot>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>

