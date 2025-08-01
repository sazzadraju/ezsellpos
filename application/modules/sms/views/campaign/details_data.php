<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <tr>
            <th><?= lang('serial')?></th>
            <th><?= lang('name')?></th>
            <th><?= lang('type')?></th>
            <th><?= lang('phone')?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        if(!empty($posts)){
            foreach ($posts as $list) {
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $list['person_name'];?></td>
                    <td><?php echo ($list['type']==1)?'Customer':'Supplier';?></td>
                    <td><?php echo $list['phone'];?></td>
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

                                