<table id="mytable" class="table table-bordred table-striped">
<thead>
    <th class="center">Serial</th>
    <th>Customer Name</th>
    <th>Customer Type</th>
    <th><?= lang('div_or_city')?></th>
    <th><?= lang('dis_or_area')?></th>
    <th><?= lang('address')?></th>
    <th><?= lang('store')?></th>
    <th class="center">Mobile Number</th>
    <th class="text-right">Points</th>
    <th class="text-right">Balance (<?= set_currency()?>)</th>
    <th>Action</th>

</thead>
<tbody>
<?php
    $i = 1;
    if(!empty($posts)){
        foreach ($posts as $list) {
?>
    <tr>
        <td class="center"><?php echo $offset+$i;?></td>
        <td><?php echo $list['full_name'].'<br>('.$list['customer_code'].')';?></td>
        <td><?php echo $list['name'];?></td>
        <td><?php if($list['division_name_en'] != ""){ echo $list['division_name_en'];}else{ echo $list['city_name_en'];}?></td>
        <td><?php if($list['district_name_en'] !=""){ echo $list['district_name_en'];}else{ echo $list['area_name_en'];}?></td>
        <td><?php echo $list['addr_line_1'];?></td>
        <td><?php echo $list['store_name'];?></td>
        <td class="center"><?php echo $list['phone'];?></td>
        <td class="text-right"><?php echo $list['points'];?></td>
        <td class="text-right" id="ch_balance_<?=$list['id_customer']?>"><?php echo $list['balance'];?></td>
        <td>
            <a href="<?php echo base_url();?>customer/details/<?php echo $list['id_customer'];?>" rel="tooltip" title="<?= lang("view") ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
            <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" rel="tooltip" title="<?= lang("edit") ?>" data-target="#edit" onclick="editCustomer('<?php echo $list['id_customer'];?>')"><span class="glyphicon glyphicon-pencil"></span></button>
            <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" rel="tooltip" title="<?= lang("delete") ?>" data-target="#deleteCustomerInfoModal" onclick="deleteCustomerModal('<?php echo $list['id_customer'];?>');"><span class="glyphicon glyphicon-trash"></span></button>
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