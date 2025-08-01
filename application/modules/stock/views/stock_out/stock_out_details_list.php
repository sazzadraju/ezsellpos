<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/bootstrap.min.css">
<table id="mytable" class="table table-bordered">
	<thead>
	<tr>
		<th class="text-center"><?= lang('serial') ?></th>
		<th><?= lang('batch') ?></th>
		<th><?= lang('product') ?></th>
		<th><?= lang('code') ?></th>
		<th><?= lang('supplier') ?></th>
		<th><?= lang('expiration_date') ?></th>
		<?php 
	    $type= $this->session->userdata['login_info']['user_type_i92']; 
	    if($columns[0]->permission==1||$type==3){
	        echo '<th class="text-right">'. lang("purchase_price").'</th>';
	    }
	    ?>
	    <th class="text-right"><?= lang('sale_price') ?></th>
	    <th class="text-right"><?= lang("quantity"); ?></th>
	    <?php 
	    if($columns[0]->permission==1||$type==3){
	        echo '<th class="text-right">'. lang("purchase_total").'</th>';
	    }
	    ?>
	    <th class="text-right"><?= lang("sale_total"); ?></th>

	</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	$tot_qty = 0;
	$purchase_total=0;
    $sale_total=0;
	if (!empty($stock_out_list)) {
		foreach ($stock_out_list as $list) {
			$attr_name=($list['attribute_name']!='')?' ('.$list['attribute_name'].')':'';
			?>
			<tr>
				<td class="text-center"><?php echo $i; ?></td>
				<td><?php echo $list['batch_no']; ?></td>
				<td><?php echo $list['product_name'].$attr_name; ?></td>
				<td><?php echo $list['product_code']; ?></td>
				<td><?php echo $list['supplier_name']; ?></td>
				<td><?php echo $list['expire_date']; ?></td>
				
				<?php 
                if($columns[0]->permission==1||$type==3){
                    echo '<td class="text-right">' . $list['purchase_price'] . '</td>';
                    $purchase_total += $list['purchase_price'] * $list['purchase_qty'];
                }
                echo '<td class="text-right">' . $list['selling_price_est'] . '</td>';
                echo '<td class="text-right">' . $list['purchase_qty'] . '</td>';
                if($columns[0]->permission==1||$type==3){
                    echo '<td class="text-right">' . $list['purchase_price'] * $list['purchase_qty'] . '</td>';
                }
                echo '<td class="text-right">' . $list['selling_price_est'] * $list['purchase_qty'] . '</td>';
                $sale_total += $list['selling_price_est'] * $list['purchase_qty'];
                ?> 
				</tr>
			<?php
			$i++;
			$tot_qty += $list['purchase_qty'];
		}
	}
	?>
	</tbody>
	<tfoot>
		<th class="text-right" colspan="6"></th>
		<?php 
	    if($columns[0]->permission==1 ||$type==3){
	        echo '<th></th>';
	    }
	    ?>
	    <th class="text-right"><?= lang("total"); ?>:</th>
	    <th class="right_text"><?= number_format($tot_qty, 2); ?></th>
	    <?php 
	    if($columns[0]->permission==1 ||$type==3){
	        echo '<th class="text-right">'. number_format($purchase_total, 2).'</th>';
	    }
	    ?>
	    <th class="text-right"><?= number_format($sale_total, 2); ?></th>
	</tfoot>
	</table>
	<div class="clearfix"></div>
	<?php echo $this->ajax_pagination->create_links(); ?>