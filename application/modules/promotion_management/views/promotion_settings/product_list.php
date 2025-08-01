
<?php
$i = $rowCount;
if (!empty($posts)) {
    foreach ($posts as $list) {
        ?>
        <tr id="<?= $i?>">
            <td>
                <input type="hidden" name="pro_id[]" id="pro_id_<?= $i?>" value="<?= $list['id_product']?>">
                <input type="hidden" name="cat_id[]" id="cat_id_<?= $i?>" value="<?= $list['cat_id']?>">
                <input type="hidden" name="subcat_id[]" id="subcat_id_<?= $i?>" value="<?= $list['subcat_id']?>">
                <input type="hidden" name="brand_id[]" id="brand_id_<?= $i?>" value="<?= $list['brand_id']?>">
                <input type="hidden" name="store_id[]" id="store_id_<?= $i?>" value="<?= $list['store_id']?>">
                <input type="hidden" name="batch_no[]" id="batch_no_<?= $i?>" value="<?= $list['batch_no']?>">
                <?php echo $list['product_name']; ?></td>
            <td><?php echo $list['product_code']; ?></td>    
            <td><?php echo $list['batch_no']; ?></td>    
            <td><?php echo $list['store_name']; ?></td>
            <td><?php echo $list['qty']; ?></td>
            <td><?php echo $list['purchase_price']; ?>
            <td><?php echo $list['selling_price_act']; ?>
               <input type="hidden" name="selling_price[]" id="selling_price_<?= $i?>" value="<?= $list['selling_price_act']?>"> 

            </td>
            <td><input type="text" class="change_value" name="percet[]" id="percet_<?= $i?>"></td>
            <td><input type="text" class="change_value" name="taka[]" id="taka_<?= $i?>"></td>
            <td> <button class='btn btn-danger btn-xs' onclick='removeMore("<?= $i?>");'>X</button></td>
        </tr>
        <?php
        $i++;
    }
}
?>        
                                       
                                    