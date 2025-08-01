<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <tr><th>#</th>
        <th><?= lang("quotation_no"); ?></th>
        <th><?= lang("creation_date"); ?></th>
        <th><?= lang("customer_name"); ?></th>
        <th><?= lang("product_price"); ?></th>
        <th><?= lang("vat-amount"); ?></th>
        <th><?= lang("discount_amount"); ?></th>
        <th><?= lang("total_amount"); ?></th>
        <th class="center"><?= lang("actions"); ?></th>
    </tr></thead>
    <tbody> 
    <?php 
        if(!empty($all_quotation)):  
        $i=0; 
        foreach($all_quotation as $aQuotation):
    ?>    
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $aQuotation['quotation_no'];?></td>
        <td><?php echo $aQuotation['dtt_add'];?></td>
        <td><?php echo $aQuotation['full_name'];?></td>
        <td><?php echo $aQuotation['product_amt'];?></td>      
        <td><?php echo $aQuotation['vat_amt'];?></td>
        <td><?php echo $aQuotation['discount_amt'];?></td>
        <td><?php echo $aQuotation['total_amt'];?></td>
        <td class="center">
            <a href="<?php echo base_url().'quotation/view/'.$aQuotation['id_quotation'];?>" class="btn btn-success btn-xs" ><span class="glyphicon glyphicon-eye-open"></span></a>
            <a href="<?php echo base_url().'quotation/edit/'.$aQuotation['id_quotation'];?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
        </td>
    </tr>
    <?php 
        $i++; 
        endforeach;
        endif;
    ?>
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links(); ?>