<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <tr>
            <th><?= lang('transfer_invoice')?></th>
            <th><?= lang('recieve_invoice')?></th>
            <th><?= lang('from_store')?></th>
            <th><?= lang('to_store')?></th>
            <th><?= lang('transfered_date')?></th>
            <th><?= lang('recieved_date')?></th>
            <th><?= lang('comments')?></th>
            <th><?= lang('status')?></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
         <?php
            $i = 1;
            if(!empty($posts)){
                foreach ($posts as $list) {
                $from_store='';
                    $to_store='';
                    foreach ($stores as $store){
                        if($store->id_store==$list['from_store']){
                            $from_store=$store->store_name;
                        }
                        if($store->id_store==$list['to_store']){
                            $to_store=$store->store_name;
                        }
                    }
        ?>
        <tr>
            <td><?php echo $list['transfer_invoice'];?></td>
            <td><?php echo ($list['status_id'] == 1)?$list['recieve_invoice']:'';?></td>
            <td><?php echo $from_store;?></td>
            <td><?php echo $to_store;?></td>
            <td><?php echo nice_date($list['transfer_date']);?></td>
            <td><?php echo ($list['status_id'] == 1)?nice_date($list['recieve_date']):'';?></td>
            <td><?php echo $list['notes'];?></td>
            <td><?php if($list['status_id'] == 0){
        ?>
            <button class="btn btn-warning btn-xs">Pending</button>
        <?php
             }else{ 
        ?>
            <button class="btn btn-success btn-xs">Recieved</button>
        <?php
                }?></td>
            <td class="center">
                <a href="<?php echo base_url();?>stock_transfer_view/<?php echo $list['id_stock_mvt'];?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>

            </td>
            <?php
                if($list['status_id'] == 0){
            ?>
                <td class="center">
                    <a href="<?php echo base_url();?>stock_transfer_details/<?php echo $list['stock_mvt_id'];?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-check"></span></a>
                </td>
            <?php
                }
            ?>

            
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

                                