<table id="addressTR" class="table table-bordered table-striped" width="60%">
    <thead>
        <th style="width: 50px;"></th>
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
                $checked=($i==1)?'checked':'';
    ?>
        <tr>
            <td>
                <div class="form-check">
                    <input id="<?=$i?>" class="form-check-input"  name="check_address" value="<?=$list['id_customer_address']?>" type="radio" <?= $checked?>>
                    <label class="form-check-label" for="<?=$i?>">&nbsp;</label>
                </div>
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
