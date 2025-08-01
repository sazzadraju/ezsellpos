<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <th><?= lang('sl_no')?></th>
        <th><?= lang('supplier')?></th>
        <th><?= lang('notification_date')?></th>
        <th><?= lang('payment_date')?></th>
        <th class="text-right"><?= lang('amount').' ('.set_currency().')'?></th>
        <th class="center"><?= lang('action')?></th>
    </thead>
    <tbody>
    <?php
        $i = 1;
        if(!empty($posts)){
            foreach ($posts as $list) {
    ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $list['supplier_name'];?></td>
            <td><?php echo $list['dtt_notification'];?></td>
            <td><?php echo $list['dtt_payment_est'];?></td>
            <td class="text-right"><?php echo $list['amount'];?></td>
            <td class="center">
                <button class="btn btn-primary btn-xs" rel="tooltip" title="<?= lang("edit")?>" data-title="<?= lang('name')?>Edit" data-toggle="modal" data-target="#editSupplierPaymentAlertModal" onclick="editSupplierPaymentAlert('<?php echo $list['id_supplier_payment_alert'];?>')"><span class="glyphicon glyphicon-pencil"></span></button>
                <button class="btn btn-danger btn-xs" rel="tooltip" title="<?= lang("delete")?>" data-title="<?= lang('name')?>Delete" data-toggle="modal" data-target="#deleteSupplierInfoModal" onclick="deleteSupplierModal('<?php echo $list['id_supplier_payment_alert'];?>');"><span class="glyphicon glyphicon-trash"></span></button>

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