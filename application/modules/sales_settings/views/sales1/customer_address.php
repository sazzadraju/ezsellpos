<table id="addressTR" class="table table-bordred table-striped" width="60%">
    <thead>
        <th></th>
        <th><?= lang('address_type')?></th>
        <th><?= lang('div_or_city')?></th>
        <th><?= lang('dis_or_area')?></th>
        <th><?= lang('address')?></th>

    </thead>
    <tbody >
    <?php
        $i = 1;
        if(!empty($posts)){
            foreach ($posts as $list) {
    ?>
        <tr>
            <td>
                <input id="<?=$i?>" name="check_address" value="<?=$list['id_customer_address']?>" type="radio" checked>
                <label for="<?=$i?>"></label>
            </td>
            <td id="type_<?=$i?>"><?php echo $list['address_type'];?></td>
            <td id="dis_<?=$i?>"><?php if($list['division_name_en'] != ""){ echo $list['division_name_en'];}else{ echo $list['city_name_en'];}?></td>
            <td id="area_<?=$i?>"><?php if($list['district_name_en'] !=""){ echo $list['district_name_en'];}else{ echo $list['area_name_en'];}?></td>
            <td id="details_<?=$i?>"><?php echo $list['addr_line_1'];?></td>
        </tr>

        <?php
        $i++;
            }
        }
    ?>
    </tbody>

</table>
<div id="addAdr"> <button type="button" class="btn btn-primary" onclick="addCustomerAddress()">Add Address</button> </div>
