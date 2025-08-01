
<?php if($cb == 1):?>
<?php  
   $uid = $pDetails[0]['id_product'].'_'.$pDetails[0]['batch_no'];
?>
<tr id="<?php echo $uid;?>">
    <!-- Hidden fields -->
    <input type="hidden" name="uniqueFld[]" value="<?php echo $uid;?>">
    <input type="hidden" name="id_product[]" value="<?php echo $pDetails[0]['id_product'];?>">
    <input type="hidden" name="batch_no[]" value="<?php echo $pDetails[0]['batch_no'];?>">
    <!-- Product name -->
    <td><?php echo $pDetails[0]['product_name'];?></td>
    <!-- Code -->
    <td><?php echo $pDetails[0]['product_code'];?></td>
    <!-- Batch -->
    <td><?php echo $pDetails[0]['batch_no'];?></td>
    <!-- Stock -->
    <td><?php echo $pDetails[0]['qty'];?></td>
    <!-- Qty -->    
    <td><input pid="<?php echo $pDetails[0]['id_product'];?>" bno="<?php echo $pDetails[0]['batch_no'];?>" type="text" style="width: 50px" id="qty_<?php echo $uid;?>" name="qty[]" value="1"></td>
    <!-- buy price -->
    <td><?php echo set_currency($pDetails[0]['purchase_price']);?></td>
    <!-- sell price -->
    <td><input pid="<?php echo $pDetails[0]['id_product'];?>" bno="<?php echo $pDetails[0]['batch_no'];?>" type="text" style="width: 60px" id="sell_price_<?php echo $uid;?>" name="sell_price[]" value="<?php echo $pDetails[0]['selling_price_est'];?>"></td>
    <!-- Discount -->
    <td>
        <div class="disAmt" style="<?php if($disType == 2){echo 'display: none';}?>">
            <input pid="<?php echo $pDetails[0]['id_product'];?>" bno="<?php echo $pDetails[0]['batch_no'];?>" type="text" style="width: 45px" id="discountA_<?php echo $uid;?>" name="discountA[]" value="0.00"><strong></strong>
        </div>
        <div class="disPer" style="<?php if($disType == 1){echo 'display: none';}?>">
            <input pid="<?php echo $pDetails[0]['id_product'];?>" bno="<?php echo $pDetails[0]['batch_no'];?>" type="text" style="width: 45px" id="discountP_<?php echo $uid;?>" name="discountP[]" value="0.00"><strong></strong>
        </div>
    </td>    
    <!-- Vat(%) -->
    <td>
        <?php 
           $is_vatable = $pDetails[0]['is_vatable']; 
           if($is_vatable == 1){            
               $vrate = $pDetails[0]['vat'];
               if(!empty($vrate)){
                    $vrate = $vrate;
               }else{
                    $vrate = 0.00;
               }
           }else{
                $vrate = 0.00;
           }
           
           $sp = $pDetails[0]['selling_price_est'];
           $vat_amt = ($vrate*$sp)/100;
        ?>               
        <div class="vatPer">
            <input type="text" style="width: 45px" id="aVat_<?php echo $uid;?>" name="aVat[]" value="<?php echo $vrate;?>" readonly=""> 
        </div>
        <div class="vatAmt" style="display: none;">
            <input type="text" style="width: 45px" id="vat_amt_<?php echo $uid;?>" name="vat_amt[]" value="<?php echo $vat_amt;?>" readonly=""> 
        </div>
    </td>
    <!-- Total -->
    <?php
        $sp = $pDetails[0]['selling_price_est'];
        $vatAmt = ($vrate*$sp)/100;
        $totPrice = $sp+$vatAmt;
    ?>
    <td><input type="text" style="width: 60px" id="total_price_<?php echo $uid;?>" name="total_price[]" value="<?php echo $totPrice;?>" readonly=""></td>

    <td><a pid="<?php echo $pDetails[0]['id_product'];?>" bno="<?php echo $pDetails[0]['batch_no'];?>" class="close-button" onclick="temp_remove_product(this)"><i class="fa fa-times" aria-hidden="true"></i></a></td>
</tr>  
<?php elseif($cb == 2):?>       
<?php  
   $uid = $pDetails[0]['id_product'].'_0000';
?>
<tr id="<?php echo $uid;?>">
    <!-- Hidden fields -->
    <input type="hidden" name="uniqueFld[]" value="<?php echo $uid;?>">
    <input type="hidden" name="id_product[]" value="<?php echo $pDetails[0]['id_product'];?>">
    <input type="hidden" name="batch_no[]" value="<?php echo '0000';?>">
    <!-- Product name -->    
    <td><?php echo $pDetails[0]['product_name'];?></td>
    <!-- Code -->
    <td><?php echo $pDetails[0]['product_code'];?></td>
    <!-- Batch -->
    <td>--</td>
    <!-- Stock -->
    <td>--</td>
    <!-- Qty -->    
    <td><input pid="<?php echo $pDetails[0]['id_product'];?>" bno="<?php echo '0000';?>" type="text" style="width: 50px" id="qty_<?php echo $uid;?>" name="qty[]" value="1"></td>    
    <!-- buy price -->
    <td><?php echo set_currency($pDetails[0]['buy_price']);?></td>
    <!-- sell price -->
    <td><input pid="<?php echo $pDetails[0]['id_product'];?>" bno="<?php echo '0000';?>" type="text" style="width: 60px" id="sell_price_<?php echo $uid;?>" name="sell_price[]" value="<?php echo $pDetails[0]['sell_price'];?>" onchange="change_price(this)"></td>    
    <!-- Discount -->
    <td>   
        <div class="disAmt" style="<?php if($disType == 2){echo 'display: none';}?>">
            <input pid="<?php echo $pDetails[0]['id_product'];?>" bno="<?php echo '0000';?>" type="text" style="width: 45px" id="discountA_<?php echo $uid;?>" name="discountA[]" value="0.00"><strong></strong>
        </div>
        <div class="disPer" style="<?php if($disType == 1){echo 'display: none';}?>">
            <input pid="<?php echo $pDetails[0]['id_product'];?>" bno="<?php echo '0000';?>" type="text" style="width: 45px" id="discountP_<?php echo $uid;?>" name="discountP[]" value="0.00"><strong></strong>
        </div>
    </td>
    <!-- Vat(%) -->
    <td>
        <?php 
           $is_vatable = $pDetails[0]['is_vatable']; 
           if($is_vatable == 1){            
               $vrate = $pDetails[0]['vat'];
               if(!empty($vrate)){
                    $vrate = $vrate;
               }else{
                    $vrate = 0.00;
               }
           }else{
                $vrate = 0.00;
           }
           $sp = $pDetails[0]['sell_price'];
           $vat_amt = ($vrate*$sp)/100;
        ?>     
        <div class="vatPer">
            <input type="text" style="width: 45px" id="aVat_<?php echo $uid;?>" name="aVat[]" value="<?php echo $vrate;?>" readonly=""> 
        </div>
        <div class="vatAmt" style="display: none;">
            <input type="text" style="width: 45px" id="vat_amt_<?php echo $uid;?>" name="vat_amt[]" value="<?php echo $vat_amt;?>" readonly=""> 
        </div>
    </td>
    <!-- Total -->
    <?php
        $sp = $pDetails[0]['sell_price'];
        $vatAmt = ($vrate*$sp)/100;
        $totPrice = $sp+$vatAmt;
    ?>
    <td><input type="text" style="width: 60px" id="total_price_<?php echo $uid;?>" name="total_price[]" value="<?php echo $totPrice;?>" readonly=""></td>
    <td><a class="close-button" onclick="temp_remove_product('<?php echo $uid;?>')"><i class="fa fa-times" aria-hidden="true"></i></a></td>
</tr>  

<?php endif;?>

<script type="text/javascript">
$(function(){
     var subTotal = 0;
     var fdisAmt = $('input[name="finalTotDisAmt"]').val();
     $('input[name^="total_price"]').each(function() {
        var pPrice = $(this).val();
        subTotal = Number(subTotal)+Number(pPrice);
     });
     $('input[name="subTotal"]').val(subTotal);

     var totDisPer = (Number(fdisAmt)*100)/Number(subTotal);
     $('input[name^="totDisPer"]').val(totDisPer);

     var finalTotAmt = Number(subTotal)-Number(fdisAmt);
     $('input[name="finalTotAmt"]').val(finalTotAmt);
});
</script>

