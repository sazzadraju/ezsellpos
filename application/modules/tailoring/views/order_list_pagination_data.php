<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <th>Receipt No</th>
        <th>Customer Name</th>
        <th>Phone</th>
        <th class="text-center">Status</th>
        <th class="text-right">Total Amount</th>
        <th class="text-right">Paid Amount</th>
        <th class="text-right">Due Amount</th>
        <th class="text-center">Delivery date</th>
        <th class="text-center">Actions</th>
    </thead>
    <tbody>
        <?php if(!empty($orders)): $i=1; foreach($orders as $aOrder):?>
        <tr>
            <td><?php echo $aOrder['receipt_no'];?></td>
            <td><?php echo $aOrder['full_name'].' ('.$aOrder['customer_code'].')';?></td>
            <td><?php echo $aOrder['phone'];?></td>
            <td>
                <?php 
                    if($aOrder['order_status'] == 1){
                        echo 'Order Place';
                    }else if($aOrder['order_status'] == 2){
                        echo 'Processing';
                    }else if($aOrder['order_status'] == 3){
                        echo 'Delivered';
                    }
                ?>                                                                      
            </td>      
            <td class="text-right"><?php echo $aOrder['tot_amt'];?></td>
            <td class="text-right"><?php echo $aOrder['paid_amt'];?></td>
            <td class="text-right"><?php echo $aOrder['due_amt'];?></td>
            <td class="text-center"><?php echo $aOrder['delivery_date'];?></td>
            <td class="center">
                <a href="<?php echo base_url();?>tailoring/order_view/<?php echo $aOrder['id_order'];?>" class="btn btn-success btn-xs orderView"><span class="glyphicon glyphicon-eye-open"></span></a>
                <button value="<?php echo $aOrder['id_order'];?>" class="btn btn-success btn-xs invoiceView"><span class="glyphicon glyphicon-list-alt"></span></button>
            </td> 
        </tr>
        <?php $i++; endforeach; else:?>

         <tr><td>order(s) not available.</td></tr>

         <?php endif; ?>
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links(); ?>