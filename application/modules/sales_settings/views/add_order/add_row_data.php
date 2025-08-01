<?php
$unit_price = ($posts[0]['stock_qty']>=0)? $posts[0]['s_sale_price']:$posts[0]['p_sale_price'];
$arr=$this->session->userdata('login_info');
$vat=$arr['subscription_info']['DEFAULT_VAT'];
$is_vatable = $posts[0]['is_vatable'];
if($is_vatable == 1){
    $vrate = $vat;
    if(!empty($vrate)){
        $vrate = $vrate;
    }else{
        $vrate = 0.00;
    }
}else{
    $vrate = 0.00;
}
$discount_amount = ($unit_price*$dis_per)/100;
$vat_tot=(($unit_price-$discount_amount)*$vrate)/100;
$totPrice = ($unit_price-$discount_amount)+$vat_tot;
?>
<tr id="<?php echo $row;?>">
    <td><?php echo $posts[0]['product_name'].'<br>'.$posts[0]['product_code'];?><input type="hidden" name="pro_id[]" value="<?php echo $posts[0]['id_product'];?>">
        <input type="hidden" name="promotion_id[]" value="<?php echo $promotion_id;?>"></td>
    <td><?php echo $posts[0]['stock_qty'];?></td>
    <td><input id="qty_<?=$row?>" class="Number change_value" name="qty[]" value="1" style="width: 50px;"></td>
    <td class="center"><?php echo $unit_price;?> <input type="hidden" id="unit_price_<?=$row?>" class="Number change_value" name="unit_price[]" value="<?php echo $unit_price;?>"></td>
    <td><input id="discount_<?=$row?>" class="Number change_value cal_dis" name="discount[]" value="<?php echo $dis_per;?>" style="width: 50px;"></td>
    <td><input id="discount_amt_<?=$row?>" class="Number change_value cal_dis" name="discount_amt[]" value="<?php echo $discount_amount;?>" style="width: 50px;"></td>
    <td class="center"><?php echo $vrate;?><input type="hidden" id="vat_<?=$row?>" class="Number change_value" name="vat[]" value="<?php echo $vrate;?>">
        <input type="hidden" id="vat_amt_<?=$row?>" class="Number change_value" name="vat_amt[]" value="<?php echo $vrate;?>"></td>
    <td><input type="text" style="width: 60px" id="total_price_<?php echo $row;?>" name="total_price[]" value="<?php echo round($totPrice, 2);?>" readonly=""></td>
    <td><a pid="<?php echo $posts[0]['id_product'];?>" class="close-button" onclick="temp_remove_product(<?= $row?>)"><i class="fa fa-times" aria-hidden="true"></i></a></td>
</tr>  