<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <tr>
            <th><?= lang('serial')?></th>
            <th><?= lang('campaign_name')?></th>
            <th><?= lang('date')?></th>
            <th><?= lang('audience_name')?></th>
            <th><?= lang('message')?></th>
            <th class="text-center"><?= lang('total_sms')?></th>
            <th class="text-center"><?= lang('unit_price')?></th>
            <th class="text-right"><?= lang('total_price')?></th>
            <th class="text-center"><?= lang('action')?></th>
            
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
                    <td><?php echo $list['campaign_name'];?></td>
                    <td><?php echo $list['add_date'];?></td>
                    <td>
                    <?php 
                    $rows=$this->campaign_model->getAudienceById($list['id_campaign']);
                    foreach ($rows as $key) {
                        echo $key['title'].'('.$key['total'].')<br>';
                    }
                    ?>
                    <td><?php echo $list['message'];?></td>
                    <td class="text-center"><?php echo $list['total_sms'];?></td>
                    <td class="text-center"><?php echo $list['unit_price'];?></td>
                    <td class="text-right"><?php echo $list['total_price'];?></td>
                    <td class="text-right"><a class="btn btn-primary" href="<?= base_url().'sms/campaign/view_details/'.$list['id_campaign']?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    
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

                                