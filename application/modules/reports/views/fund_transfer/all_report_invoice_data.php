<table id="" class="table table-bordred table-striped">
    <thead>
        <th class="fit"><?= lang("sl_no"); ?></th>
        <th><?= lang("date"); ?></th>
        <th><?= lang("from_store"); ?></th>
        <th><?= lang("account_from"); ?></th>
        <th><?= lang("to_store"); ?></th>
        <th><?= lang("acccount_to"); ?></th>
        <th><?= lang("description"); ?></th>
        <th><?= lang("user"); ?></th>
        <th><?= lang("amount").'('.set_currency().')'; ?></th> 
        <?php /*?>
        <th class="fit"><?= lang("view"); ?></th>
        <th class="fit"><?= lang("edit"); ?></th>
        <th class="fit"><?= lang("delete"); ?></th>
        <?php */?>
    </thead>
    <tbody>
        <?php
        $total = 0;
        if (!empty($records)):
        $count = 1;
        foreach ($records as $rec):
        ?>
        <tr>
            <td class="fit"><?php echo ($offset+$count); ?>.</td>
             <td><?php echo nice_datetime($rec['dtt_add']); ?></td>
            <td><?php echo $rec['from_store']; ?></td>
            <td><?php echo account_name_id($rec['acc_frm']); ?></td>
            <td><?php echo $rec['to_store']; ?></td>
            <td><?php echo account_name_id($rec['acc_to']); ?></td>
            <td><?php echo $rec['description']; ?></td>
            <td><?php echo $rec['fullname']; ?></td>
            <td class="fit text-right"><?php echo comma_seperator($rec['amount']); ?></td>
            <?php /*?>
            <td class="center fit">
                <button class="btn btn-success btn-xs" data-title="<?= lang("view"); ?>" data-toggle="modal" data-target="#ba_view"><span class="glyphicon glyphicon-eye-open"></span></button>
            </td>
            <td class="center fit">
                <button class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" data-toggle="modal" data-target="#add"><span class="glyphicon glyphicon-pencil"></span></button>
            </td>
            <td class="center fit">
                <button class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal" data-target="#delete_account_m"><span class="glyphicon glyphicon-trash"></span></button>
            </td>
            <?php */?>
        </tr>
        <?php
        $count++;
        $total+=$rec['amount'];
        endforeach;
        else:
        ?>
        <tr><td colspan="10" align="center"><b><?= lang("data_not_available"); ?></b></td></tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="8" class="fit text-right"><b><?= lang("total"); ?></b></th>
            <th class="fit text-right"><?= $total?></th>
        </tr>
    </tfoot>
</table>
<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links();?>