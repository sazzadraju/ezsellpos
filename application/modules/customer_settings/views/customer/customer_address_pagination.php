<table id="mytable" class="table table-bordred table-striped">
    <thead>

        <th><?= lang('serial')?></th>
        <th><?= lang('address_type')?></th>
        <th><?= lang('div_or_city')?></th>
        <th><?= lang('dis_or_area')?></th>
        <th><?= lang('address')?></th>
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
            <td><?php echo $list['address_type'];?></td>
            <td><?php if($list['division_name_en'] != ""){ echo $list['division_name_en'];}else{ echo $list['city_name_en'];}?></td>
            <td><?php if($list['district_name_en'] !=""){ echo $list['district_name_en'];}else{ echo $list['area_name_en'];}?></td>
            <td><?php echo $list['addr_line_1'];?></td>
            <td class="center">
                <button class="btn btn-primary btn-xs" data-title="Edit" rel="tooltip" title="<?= lang("edit") ?>" data-toggle="modal" data-target="#edit_customer_address_section" onclick="editCustomerAddress('<?php echo $list['id_customer_address'];?>')"><span class="glyphicon glyphicon-pencil"></span></button>
                <button class="btn btn-danger btn-xs" data-title="Delete" rel="tooltip" title="<?= lang("delete") ?>" data-toggle="modal" data-target="#deleteCustomerAddress" onclick="deleteCustomerModal('<?php echo $list['id_customer_address'];?>');"><span class="glyphicon glyphicon-trash"></span></button>

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