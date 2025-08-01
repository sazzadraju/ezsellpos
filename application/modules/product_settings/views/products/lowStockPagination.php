 <?php if(!empty($low_stock_data)): ?>
<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <th><?= lang("product_code"); ?></th>
        <th><?= lang("product_name"); ?></th>
        <th><?= lang("store"); ?></th>
        <th><?= lang("category"); ?></th>
        <th><?= lang("sub_category"); ?></th>
        <th><?= lang("brand"); ?></th>
        <th><?php echo ($type==1)? lang("min_stock"):lang("max_stock"); ?></th>
        <th><?= lang("stock"); ?></th>
        <th><?= lang("price"); ?></th>
    </thead>
    <tbody>
        <?php if(!empty($low_stock_data)): foreach($low_stock_data as $asData): ?>
        <tr>
            <td><?php echo $asData['product_code'];?></td>
            <td><?php echo $asData['product_name'];?></td>
            <td><?php echo $asData['store_name'];?></td>
            <td><?php echo $asData['cat_name'];?></td>
            <td><?php echo $asData['sub_cat_name'];?></td>
            <td><?php echo $asData['brand_name'];?></td>
            <td><?php echo ($type==1)?$asData['min_stock']:$asData['max_stock'];?></td>
            <td><a class="custom-a" onclick="batchDetail(<?php echo $asData['id_product'].','.$asData['store_id'];?>)"><?php echo $asData['total_quantity'];?></a></td>
            <td><?php echo $asData['sell_price'];?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td><?= lang("not_available"); ?></td></tr>
        <?php endif; ?>                                
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links(); ?>
<?php endif; ?>   