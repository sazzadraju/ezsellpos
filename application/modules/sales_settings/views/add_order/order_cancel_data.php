<div>
 <div class="auto">
     <ul class="list-group">
         <li class="list-group-item d-flex justify-content-between align-items-center">
             Order No
             <span class="badge badge-primary badge-pill"><?php echo $posts[0]['invoice_no']; ?></span>
         </li>
         <li class="list-group-item d-flex justify-content-between align-items-center">
             Product Amount
             <span class="badge badge-primary badge-pill"><?php echo $posts[0]['product_amt']; ?></span>
         </li>
         <li class="list-group-item d-flex justify-content-between align-items-center">
             Discount Amount
             <span class="badge badge-primary badge-pill"><?php echo $posts[0]['discount_amt']; ?></span>
         </li>
         <li class="list-group-item d-flex justify-content-between align-items-center">
             Vat Amount
             <span class="badge badge-primary badge-pill"><?php echo $posts[0]['vat_amt']; ?></span>
         </li>
         <li class="list-group-item d-flex justify-content-between align-items-center">
             Total Amount
             <span class="badge badge-primary badge-pill"><?php echo $posts[0]['tot_amt']; ?></span>
         </li>
         <li class="list-group-item d-flex justify-content-between align-items-center">
             Paid Amount
             <span class="badge badge-primary badge-pill"><?php echo $posts[0]['amount']; ?></span>
         </li>
     </ul>
     <?php
     if($posts[0]['amount']!=''){
         ?>
         <p><span>Return Amount</span> <span><input type="text" name="ret_amt" id="ret_amt" class="form-control"></span></p>
         <?php
     }
     ?>
     <input type="hidden" name="uid" id="uid" value="<?=$id?>">
     <input type="hidden" id="customer_id" value="<?php echo $posts[0]['customer_id']; ?>">
     <br>
     <button class="btn btn-primary right" name="submit" onclick="cancel_order()">Cancel Order</button>
 </div>


</div>
<script>
    function cancel_order() {
        var amt='';
        var id= $('#uid').val();
        var customer_id= $('#customer_id').val();
        if ($('#ret_amt').length > 0){
           amt= $('#ret_amt').val();
        }
        $.ajax({
            type: "POST",
            url: URL + "add-order/cancel-order",
            data: 'id='+id+'&ret_amt='+amt+'&customer_id='+customer_id,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                $('.loading').fadeOut("slow");
                $('#order_cancel_data').modal('toggle');
                window.onload = searchFilter(0);
                    $('#showMessage').html("<?= lang('add_success')?>");
                    $('#showMessage').show();
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);
                    }, 1000);

            }
        });
    }

</script>

