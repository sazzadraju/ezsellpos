<tr>
    <td>
        <input id="<?= $id ?>" name="check_address" value="new" type="radio" checked>
        <label for="<?= $id ?>"></label>
    </td>
    <td id="type_<?= $id ?>">Shipping Address</td>
    <td id="dis_<?= $id ?>">
        <select class="select2" data-live-search="true" id="city_division" name="city_division"
                onchange="locationAddress(value);">
            <option value="0" selected>Select One</option>
            <optgroup label="City Wise">
                <?php
                if ($city_list) {
                    foreach ($city_list as $list) {
                        ?>
                        <option actp="<?php echo $list->city_name_en; ?>" value="city-<?php echo $list->id_city; ?>"><?php echo $list->city_name_en; ?></option>
                        <?php
                    }
                }
                ?>

            </optgroup>
            <optgroup label="Division Wise">
                <?php
                if ($division_list) {
                    foreach ($division_list as $list) {
                        ?>
                        <option actp="<?php echo $list->division_name_en; ?>" value="divi-<?php echo $list->id_division; ?>"><?php echo $list->division_name_en; ?></option>
                        <?php
                    }
                }
                ?>
            </optgroup>
        </select>
        <input type="hidden" name="division_id" id="division_id">
        <input type="hidden" name="district_id" id="district_id">
    </td>
    <td id="area_<?= $id ?>">
        <select class="select2" id="address_location" name="address_location" onchange="cityDistLoc(value);">
            <option value="0">Select One</option>
        </select>
        <input type="hidden" name="city_id" id="city_id">
        <input type="hidden" name="city_location_id" id="city_location_id">
    </td>
    <td id="details_<?= $id ?>">
        <textarea class="form-control" rows="3" name="addr_line_1" id="addr_line_1"></textarea>
    </td>
</tr>