<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("invoice_no"); ?></th>
    <th><?= lang("order_invoice_id"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th><?= lang("supplier_name"); ?></th>
    <th><?= lang("date"); ?></th>
    <th><?= lang("total_price"); ?></th>
    <th><?= lang("action"); ?></th>
</thead>
<tbody>
    <?php
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                echo '<td>' . $post['invoice_no'] . '</td>';
                echo '<td>' . $post['order_invoice_no'] . '</td>';
                echo '<td>' . $post['store_name'] . '</td>';
                echo '<td>' . $post['supplier_name'] . '</td>';
                echo '<td>' . nice_datetime($post['dtt_add']) . '</td>';
                echo '<td>' .  $post['invoice_amt'] . '</td>';
                ?>
                <td class="center">
                    <a class="btn btn-success btn-xs" rel="tooltip" title="<?= lang("view")?>" href="<?= base_url().'purchase_receive/details/'.$post['id_purchase_receive']?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
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
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>