<table id="mytable" class="table table-bordred table-striped">
  <thead>                                 
    <th><?= lang("product"); ?></th> 
    <th><?= lang("attributes"); ?></th>
    <th><?= lang("batch_no"); ?></th>
    <th><?= lang("cat/subcat"); ?></th>
    <th><?= lang("brands"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th><?= lang("expire_date"); ?></th>
    <th class="right_text"><?= lang("qty"); ?></th>
</thead>
<tbody>
    <?php 
    $tot_qty=0;
    if(!empty($ex_product)):
        foreach($ex_product as $xaProduct):
            ?>
            <tr>
                <td><?php echo $xaProduct['product_name'].' ('.$xaProduct['product_code'].')';?></td>
                <td><?php echo $xaProduct['attribute_name'];?></td>
                <td><?php echo $xaProduct['batch_no'];?></td>
                <td><?php echo $xaProduct['cat_name'].' / '.$xaProduct['sub_cat_name'];?></td>
                <td><?php echo $xaProduct['brand_name'];?></td>
                <td><?php echo $xaProduct['store_name'];?></td>
                <td><?php echo $xaProduct['expire_date'];?></td>
                <td class="right_text"><?php echo $xaProduct['qty'];?></td>
            </tr>
        <?php 
 $tot_qty+=$xaProduct['qty'];
    endforeach;else:?>
        <tr>
          <td colspan="8"><?= lang("not_found"); ?></td>
      </tr>  
  <?php endif;?>
</tbody>
<tfoot>
    <th colspan="6"></th>
    <th><?= lang("total"); ?></th>
    <th class="right_text"><?= $tot_qty; ?></th>
    <!-- <th></th> -->
    </tfoot>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
