<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <th class="center"><?php echo $this->lang->line('serial');?></th>
        <th><?php echo $this->lang->line('customer_type');?></th>
        <th class="center"><?php echo $this->lang->line('percentage_of_discount');?></th>
        <th class="text-right"><?php echo $this->lang->line('target_sales_volume');?></th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
    <?php
        $i = 1;
        if(!empty($posts)){
            foreach ($posts as $list) {
    ?>
            <tr>
                <td class="center"><?php echo $i;?></td>
                <td><?php echo $list['name'];?></td>
                <td class="center"><?php echo $list['discount'];?></td>
                <td class="text-right"><?php echo $list['target_sales_volume'];?></td>
                <?php if($list['id_customer_type'] != 1){?>
                <td>
                    <button class="btn btn-primary btn-xs" data-title="Edit" onclick="edit_customer_type(<?= $list['id_customer_type'] ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td>
                    <button class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal" data-target="#delete_type_m" onclick="deleteTypeModal('<?= $list['id_customer_type'] ?>');"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
                <?php }?>
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

                                