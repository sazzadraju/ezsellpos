<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <th><?= lang('sl_no')?></th>
        <th><?= lang('name')?></th>
        <th><?= lang('phone')?></th>
        <th><?= lang('email')?></th>
        <th><?= lang('address')?></th>
        <th class="text-right"><?= lang('dues')?></th>
		<th class="text-right"><?= lang('advance')?></th>
        <th class="center"><?= lang('action')?></th>
    </thead>
    <tbody>
    <?php
        $i = 1;
        if(!empty($posts)){
            foreach ($posts as $list) {
            $balance=$this->Supplier_settings_model->supplier_current_balance($list['id_supplier']);
            $tot_amt=0;$paid_amt=0;$due_amt=0;$settle_amt=0;
            $total_balance=0;
            if($balance){
                $tot_amt=$balance[0]['tot_amt'];
                $paid_amt=$balance[0]['paid_amt'];
                $total_balance=$balance[0]['due_amt']-$balance[0]['settle_amt'];
                $settle_amt=$balance[0]['settle_amt'];
            }    
    ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $list['supplier_name'];?></td>
            <td><?php echo $list['phone'];?></td>
            <td><?php echo $list['email'];?></td>
            <td><?php echo $list['addr_line_1'];?></td>
            <td class="text-right" id="s_bal_<?php echo $list['id_supplier'];?>"><?php echo $total_balance;?></td>
			<td class="text-right" id="s_c_bal_<?php echo $list['id_supplier'];?>"><?php echo $list['credit_balance'];?></td>
            <td class="center">
                <a href="<?php echo base_url();?>supplier/<?php echo $list['id_supplier'];?>" rel="tooltip" title="<?= lang("view")?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                <button class="btn btn-primary btn-xs" data-title="<?= lang('name')?>Edit" rel="tooltip" title="<?= lang("edit")?>" data-toggle="modal" data-target="#editSupplierInfo" onclick="editSupplier('<?php echo $list['id_supplier'];?>')"><span class="glyphicon glyphicon-pencil"></span></button>
                <button class="btn btn-danger btn-xs" data-title="<?= lang('name')?>Delete" rel="tooltip" title="<?= lang("delete")?>" data-toggle="modal" data-target="#deleteSupplierInfoModal" onclick="deleteSupplierModal('<?php echo $list['id_supplier'];?>');"><span class="glyphicon glyphicon-trash"></span></button>

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