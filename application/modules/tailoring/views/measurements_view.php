<table id="measurementListArray">
    <?php 
    if(!empty($lists)): 
        $i=1; 
        foreach($lists as $list):?>
            <tr>
                <td width="200" class="text-right"><?php echo $list['field_name'];?></td>
                <td>
                    <input type="hidden" name="measurement_id[]" value="<?php echo $list['id_measurement'];?>">
                    <input type="text" name="field_value[]" value="<?php echo $list['field_value'];?>">
                </td>
            </tr>
            <?php 
            $i++; 
        endforeach; 
    else:?>
        <tr><td>No Data Found...</td></tr>
    <?php 
    endif; 
    ?>
</table>