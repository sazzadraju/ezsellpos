<tr id="<?=$countRow?>">
    <input type="hidden" id="unit_id_<?=$countRow?>" name="unit_id[]" value="undefined">
    <td>
        <?=$product[0]['product_name']?><br><?=$product[0]['product_code']?>
        <input type="hidden" id="pro_name_<?=$countRow?>" name="pro_name[]" value="<?=$product[0]['product_name']?>">
        <input type="hidden" id="pro_id_<?=$countRow?>" name="pro_id[]" value="<?=$product[0]['id_product']?>">
        <input type="hidden" id="stock_id_<?=$countRow?>" name="stock_id[]" value="<?=$product[0]['id_stock']?>">
        <input type="hidden" id="p_store_id_<?=$countRow?>" name="p_store_id[]" value="<?=$product[0]['store_id']?>">
        <input type="hidden" id="cat_id_<?=$countRow?>" name="cat_id[]" value="<?=$product[0]['cat_id']?>">
        <input type="hidden" id="subcat_id_<?=$countRow?>" name="subcat_id[]" value="<?=$product[0]['subcat_id']?>">
        <input type="hidden" id="brand_id_<?=$countRow?>" name="brand_id[]" value="<?=$product[0]['brand_id']?>">
    </td>
    <td>
        <?php echo (isset($product[0]['attribute_name']))?$product[0]['attribute_name']:'';?>
        <input type="hidden" id="pro_code_<?=$countRow?>" name="pro_code[]" value="<?=$product[0]['product_code']?>">
    </td>
    <td>
        <select id="batch_<?=$countRow?>" name="batch[]" onchange="change_batch(this)" class="uk-select">
            <?php 
            foreach ($batches as $value) {
               $select=($value['batch_no']==$product[0]['batch_no'])?'selected':'';
               echo '<option value="'.$value['batch_no'].'" '.$select.'>'.$value['batch_no'].'</option>';
            }
            ?>
        </select> 
        <input type="hidden" name="old_batch[]" id="old_batch_<?=$countRow?>" value="<?=$product[0]['batch_no']?>">
    </td>
    <td>
        <input type="text" id="total_qty_<?=$countRow?>" name="total_qty[]" value="<?=floatVal($product[0]['total_qty'])?>" readonly="" class="form-control">
    </td>
    <td>
        <input type="text" class="form-control change_price Number" id="qty_<?=$countRow?>" name="qty[]" value="1">
    </td>
    <?php 
    $chance_price='';
    $chance_discount='';
    // if($user_columns){
    //     foreach ($user_columns as $value) {
    //         if(($value->id_acl_user_column==11) && ($value->permission==2)){
    //             $chance_price='readonly=""';
    //         }
    //         if(($value->id_acl_user_column==12) && ($value->permission==2)){
    //             $chance_discount='readonly=""';
    //         }
    //     }
    // }
    $chance_price=($config_price==0)?'readonly=""':'';
    $chance_discount=($config_discount==0)?'readonly=""':'';
    ?>
    <td>
        <input type="text" class="form-control change_price Number" id="unit_price_<?=$countRow?>" name="unit_price[]" <?= $chance_price?> value="<?=floatVal($product[0]['selling_price_est'])?>">
    </td>
    <?php 
    $pro_total = $product[0]['selling_price_est'];
    $dis_per='';
    $dis_amt=0;
    $dis_type='';
    $set_promo_id='';
    if(isset($promotion_id)){
        $set_promo_id=$promotion_id;
        $dis_type=$promotion_type;
        $dis_per=$promotion_discount;  
        $dis_amt=$promotion_discount_amt;
    }
    $pro_total = $product[0]['selling_price_est'] - $dis_amt;
    ?>
    <td id="discount_td_<?=$countRow?>">
        <input type="text" class="form-control change_price Number" id="discount_<?=$countRow?>" name="discount[]" value="<?=floatVal($dis_per)?>" <?= $chance_discount?>>
        <input type="hidden" id="discount_type_<?=$countRow?>" name="discount_type[]" value="<?= $dis_type?>"> 
        <input type="hidden" name="pro_sale_id[]" value="<?= $set_promo_id?>">
    </td>
    <td id="discount_amt_td_<?=$countRow?>">
        <input readonly="" type="text" class="form-control" id="discount_amt_<?=$countRow?>" name="discount_amt[]" value="<?=floatVal($dis_amt)?>">
        
    </td>
    <?php 
    $vat=0;
    $vat_total=0;
    if ($product[0]['is_vatable'] == 1) {
        $vat=$def_vat;
        $vat_total = ($pro_total * $vat) / 100;
    }
    ?>
    <td>
        <input type="text" class="form-control" id="def_vat_<?=$countRow?>" name="def_vat[]" value="<?= $vat?>" readonly="">
    </td>
    <td>
        <input type="text" class="form-control" id="def_vat_amt_<?=$countRow?>" name="def_vat_amt[]" value="<?= $vat_total?>" readonly="">
    </td>
    <td>
        <input type="text" class="form-control" id="total_price_<?=$countRow?>" name="total_price[]" value="<?= floatVal($pro_total+$vat_total)?>" readonly="">
    </td>
    <td>
        <a class="delete" title="Delete" onclick="temp_remove_product(1)"><i class="fas fa-trash-alt"></i></a>
    </td>
</tr>