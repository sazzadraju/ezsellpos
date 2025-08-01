<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("invoice_no"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th><?= lang("supplier_name"); ?></th>
    <th><?= lang("date"); ?></th>
    <th><?= lang("total_price"); ?></th>
    <th><?= lang("status"); ?></th>
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
            echo '<td>' . $post['store_name'] . '</td>';
            echo '<td>' . $post['supplier_name'] . '</td>';
            echo '<td>' . nice_datetime($post['dtt_add']) . '</td>';
            echo '<td>' . number_format($post['tot_amt']) . '</td>';
            if ($post['status_id'] == 1) {
                echo '<td>' . lang('order_placed') . '</td>';
            } else if ($post['status_id'] == 2) {
                echo '<td>' . lang('order_cancelled') . '</td>';
            } else {
                echo '<td class="bg-success">' . lang('order_received') . '</td>';
            }
            ?>
            <td class="center">
                <a class="btn btn-success btn-xs"  rel="tooltip" title="<?= lang("view")?>" href="<?php echo base_url().'purchase_order/details/'.$post['id_purchase_order']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                
                <?php
                if($post['status_id'] == 1){
                ?>
                    <a class="btn btn-success btn-xs"  rel="tooltip" title="<?= lang("receive")?>" href="<?php echo base_url().'purchase-receive/add/'.$post['id_purchase_order']; ?>">Receive</a>
                <?php
                }
                ?>
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