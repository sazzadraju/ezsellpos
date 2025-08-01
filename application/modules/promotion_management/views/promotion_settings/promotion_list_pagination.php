<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang('sl_no') ?></th>
    <th><?= lang('title') ?></th>
    <th><?= lang('description') ?></th>
    <th><?= lang('promotion_type') ?></th>
    <th><?= lang('validity_from') ?></th>
    <th><?= lang('validity_to') ?></th>
    <th><?= lang('store_name') ?></th>
    <th><?= lang('status') ?></th>
    <th class="center"><?= lang('action') ?></th>

    </thead>
    <tbody>
        <?php
        $i = 1;
        if (!empty($posts)) {
            foreach ($posts as $list) {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $list['title']; ?></td>
                    <td><?php echo $list['details']; ?></td>
                    <td>
                    <?php 
                        if($list['type_id'] == 1){
                            echo "Promotion on Product";
                        }elseif($list['type_id'] == 2){
                            echo "Promotion on Purchase";
                        }elseif($list['type_id'] == 3){
                            echo "Promotion on Card";
                        }  
                    ?>
                            
                    </td>
                    <td><?php echo $list['dt_from']; ?></td>
                    <td><?php echo $list['dt_to']; ?></td>
                    <td><?php echo $list['store_name']; ?></td>
                    <td class="center">
                        <a rel="tooltip" title="<?= lang("view")?>" href="<?php echo base_url(); ?>promotion_details/<?php echo $list['id_promotion']; ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                        <a rel="tooltip" title="<?= lang("edit")?>" href="<?php echo base_url(); ?>promotion_details/<?php echo $list['id_promotion']; ?>" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
                        <button rel="tooltip" title="<?= lang("delete")?>" class="btn btn-danger btn-xs" data-title="<?= lang('customer_name') ?>Delete" data-toggle="modal" data-target="#deleteCustomerInfoModal" onclick="deleteCustomerModal('<?php //echo $list['id_customer']; ?>');"><span class="glyphicon glyphicon-trash"></span></button>

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