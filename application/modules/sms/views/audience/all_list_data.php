<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <tr>
            <th><?= lang('serial')?></th>
            <th><?= lang('name')?></th>
            <th><?= lang('date')?></th>
            <th><?= lang('action')?></th>
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
                    <td><?php echo $list['title'];?></td>
                    <td><?php echo $list['date'];?></td>
                    <td>
                        <!-- <button class="btn btn-success btn-xs" data-title="<?= lang("view"); ?>" data-toggle="modal" rel="tooltip" title="<?= lang("view") ?>"
                            data-target="#view" onclick="viewDetaitls('<?php echo $list['id_set_person']; ?>')">
                        <span class="glyphicon glyphicon-eye-open"></span></button> -->
                        <a class="btn btn-success btn-xs" href="<?= base_url().'sms/audience/show_details/'.$list['id_set_person']?>">
                        <span class="glyphicon glyphicon-eye-open"></span></a>
                       
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

                                