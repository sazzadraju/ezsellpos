<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <tr>
            <th><?= lang('audit_no')?></th>
            <th><?= lang('stock_audit_date')?></th>
            <th><?= lang('audited_by')?></th>
            <th><?= lang('status')?></th>
        </tr>
    </thead>
    <tbody>
         <?php
            $i = 1;
            if(!empty($posts)){
                foreach ($posts as $list) {
        ?>
        <tr>
            <td><?php echo $list['audit_no'];?></td>
            <td><?php echo date('Y-m-d', strtotime($list['dtt_audit']));?></td>
            <td><?php echo $list['audit_participants'];?></td>
            <td>
            <?php 
                if($list['status_id'] == 1){
            ?>
                <button class="btn btn-warning btn-xs"><?= lang('ongoing')?></button>
            <?php
                }elseif($list['status_id'] == 2){
            ?>
                <button class="btn btn-danger btn-xs"><?= lang('canceled')?></button>
            <?php
                }elseif($list['status_id'] == 3){
            ?>
                <button class="btn btn-success btn-xs"><?= lang('completed')?></button>
            <?php
                }


            ?>
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

                                