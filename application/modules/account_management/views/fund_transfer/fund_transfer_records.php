<table id="bank_acc_tbl" class="table table-bordred table-striped">
    <thead>
        <th class="fit"><?= lang("sl_no"); ?></th>
        <th><?= lang("from_store"); ?></th>
        <th><?= lang("account_from"); ?></th>
        <th><?= lang("to_store"); ?></th>
        <th><?= lang("acccount_to"); ?></th>
        <th><?= lang("amount"); ?></th>
        <th><?= lang("date"); ?></th> 
        <th><?= lang("description"); ?></th>
        <th><?= lang("user"); ?></th>
        <?php /*?>
        <th class="fit"><?= lang("view"); ?></th>
        <th class="fit"><?= lang("edit"); ?></th>
        <th class="fit"><?= lang("delete"); ?></th>
        <?php */?>
    </thead>
    <tbody>
        <?php
        if (!empty($records)):
        $count = 1;
        foreach ($records as $rec):
        ?>
        <tr>
            <td class="fit"><?php echo ($offset+$count); ?>.</td>
            <td><?php echo $rec['from_store']; ?></td>
            <td><?php echo account_name_id($rec['acc_frm']); ?></td>
            <td><?php echo $rec['to_store']; ?></td>
            <td><?php echo account_name_id($rec['acc_to']); ?></td>
            <td class="fit text-right"><?php echo set_currency(comma_seperator($rec['amount'])); ?></td>
            <td><?php echo nice_datetime($rec['dtt_add']); ?></td>
            <td><?php echo $rec['description']; ?></td>
            <td><?php echo $rec['fullname']; ?></td>
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
        endforeach;
        else:
        ?>
        <tr><td colspan="10" align="center"><b><?= lang("data_not_available"); ?></b></td></tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links();?>