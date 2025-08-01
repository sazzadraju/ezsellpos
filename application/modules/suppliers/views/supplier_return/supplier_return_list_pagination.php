<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <tr>
        <th><?= lang('invoice_no') ?></th>
        <th><?= lang('supplier_name') ?></th>
        <th><?= lang('stock_out_date') ?></th>
        <th><?= lang('supplier_return_qty') ?></th>
        <th class="text-right"><?= lang('total_price').' ('.set_currency().')' ?></th>
        <th class="center"><?= lang("view"); ?></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    if (!empty($posts)) {
        foreach ($posts as $list) {
            ?>
            <tr>

                <td><?php echo $list['invoice_no']; ?></td>
                <td><?php echo $list['supplier_name']; ?></td>
                <td><?php echo $list['dtt_add']; ?></td>
                <td><?php echo $list['qty']; ?></td>
                <td class="center"><?php echo $list['tot_amt']; ?></td>
                <td class="center">
                    <button class="btn btn-success btn-xs" data-title="<?= lang("view"); ?>" data-toggle="modal"
                            data-target="#view" onclick="viewSupplierDetails('<?php echo $list['id_supplier_return']; ?>')">
                        <span class="glyphicon glyphicon-eye-open"></span></button>
                </td>
            </tr>
            <?php
            $i++;
        }
    }
    ?>
    </tbody>
</table>
<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>

                                