<form id="pricingUpdateForm">  
<?php
    $attributes = array('id' => 'pricingUpdateForm');
    echo form_open('', $attributes);
?>    
    <table id="pricingTable" class="table table-bordred table-striped">
        <thead>
            <th><?= lang("name_code"); ?></th>
            <th><?= lang("batch"); ?></th>
            <th><?= lang("category"); ?></th>
            <th><?= lang("brand"); ?></th>
            <th><?= lang("expired_date"); ?></th>
            <th><?= lang("alert"); ?></th>
            <th><?= lang("qty"); ?></th>
            <?php 
            $type= $this->session->userdata['login_info']['user_type_i92']; 
             if($columns[0]->permission==1||$type==3){
                echo '<th class="center">'.lang("buying_price").'</th>';
             }
            ?>
            <th><?= lang("selling_price"); ?></th>
        </thead>
        <tbody>
             <?php $i=1; if(!empty($products)): foreach($products as $product): ?>
                 <tr>
                     <td><?php echo $product['p_product_name'].'-<br>'.$product['p_product_code'];?></td>
                     <td><?php echo $product['batch_no'];?></td>
                     <td><?php echo $product['cat_name'].'/'.$product['sub_cat_name'];?></td>
                     <td><?php echo $product['brand_name'];?></td>
                     <td>
                        <div class="form-group">
                            <div class="input-group date expire_date">
                                <input type="text" name="expire_date[]" id="expire_date-<?php echo $i;?>" class="form-control expire_date" value="<?php echo $product['expire_date'];?>">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <?php echo form_error('expire_date['.($i-1).']', '<div class="error">', '</div>'); ?>
                            </div>
                        </div>
                                               
                     </td>
                     <td>                            
                        <div class="form-group">
                            <div class="input-group date alert_date">
                                <input type="text" name="alert_date[]" id="alert_date-<?php echo $i;?>" class="form-control alert_date" value="<?php echo $product['alert_date'];?>">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <?php echo form_error('alert_date['.($i-1).']', '<div class="error">', '</div>'); ?>
                            </div>
                        </div>                
                     </td>
                     <td><?php echo $product['qty'];?></td>
                     <?php
                     if($columns[0]->permission==1||$type==3){
                        echo ' <td>'. $product['purchase_price'].'</td>';
                     }

                    ?>
                    
                     <td>
                        <input style="width:80px" id="selling_price_act-<?php echo $i;?>" name="selling_price_act[]" value="<?php echo $product['selling_price_act'];?>" type="text">
                        <?php echo form_error('selling_price_act['.($i-1).']', '<div class="error">', '</div>'); ?>

                        <input type="hidden" name="stock_id[]" id="stock_id" value="<?php echo $product['id_stock'];?>">   
                     </td>
                 </tr>
             <?php $i++; endforeach; else: ?>
             <tr><td colspan="8"><p><?= lang("data_not_available"); ?></p></td></tr>
             <?php endif; ?>
        </tbody>
    </table>
    <div class="form-buttons-w">
        <button id="pricingUpdate" class="btn btn-primary right" type="submit"> <?= lang("update"); ?></button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $('.alert_date, .expire_date').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

        $('#pricingUpdateForm').submit(function(e) { e.preventDefault(); }).validate({
             rules: {
                "selling_price_act[]": {
                    required: true,
                }
            },
            messages: {
                "selling_price_act[]": "required"
            },
            submitHandler: function(form) {
                $.ajax({
                    url: "<?php echo base_url().'products/pricing_update';?>",
                    type: "post",
                    data: $(form).serialize(),
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function(res) { 
                        if(Number(res) > 0){
                            $('#postList').html('');
                            $('#showMessage').html(res+' stock info update successfull');
                            $('#showMessage').show();
                            window.scrollTo(0, 0);
                        }else if(res == 0){
                            $('#showMessage').html('Nothing Updated');
                            $('#showMessage').show().css("background", "red");
                        }else{
                            $('#showMessage').html(res);
                            $('#showMessage').show().css("background", "red");
                        }
                        $('.loading').fadeOut("slow");
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);
                        }, 3000);
                        
                    }
                });    
            }
        }); 
    });  
</script> 
    
     

