
<div class="content-i">
	<div class="content-box">
<div class="element-box full-box">
	<h6 class="element-header">CSV Preview</h6>

	<br>


	<?php
	$attributes = array('method' => 'post', 'id' => 'csvPreview', 'name' => 'csvPreview');
	echo form_open('csv/importcsv', $attributes);
	?>

	<!-- <form action="http://localhost/fpos/csv/importcsv" method="post" id="csvPreview" name="csvPreview" > -->


	<table class="table table-responsive">
		<thead>
		<tr>
			<th>#</th>
			<th>Product code</th>
			<th>Product name</th>
			<th>Cat name</th>
			<th>Subcat name</th>
			<th>Description</th>
			<th>Brand name</th>
			<th>Unit name</th>
			<th>Buy price</th>
			<th>Sell price</th>
			<th>Min stock</th>
			<th>VAT()</th>
			<th>Supplier</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$i = 1;
		$rCount = 0 ;
		foreach($previewarray as $pvd):
			?>
			<tr>
				<th scope="row"><?php echo $i;?></th>
				<td>
					<input id='pCode-<?php echo $i;?>' type="text" name="pCode[]" class="form-control" value='<?php echo $pvd[0];?>'>
					<?php echo form_error('pCode['.($i-1).']', '<div class="error">', '</div>'); ?>
				</td>
				<td>
					<input id='pName-<?php echo $i;?>' type="text" name="pName[]" class="form-control" value='<?php echo $pvd[1];?>'>
					<?php echo form_error('pName['.($i-1).']', '<div class="error">', '</div>'); ?>
				</td>
				<td>
					<input id='pCat-<?php echo $i;?>' type="text" name="pCat[]" class="form-control" value='<?php echo $pvd[2];?>'>
					<?php echo form_error('pCat['.($i-1).']', '<div class="error">', '</div>'); ?>
				</td>
				<td><input id='pSubCat-<?php echo $i;?>' type="text" name="pSubCat[]" class="form-control" value='<?php echo $pvd[3];?>'></td>
				<td><input id='pDes-<?php echo $i;?>' type="text" name="pDes[]" class="form-control" value='<?php echo html_escape($pvd[4]);?>'></td>
				<td>
					<input id='pBrand-<?php echo $i;?>' type="text" name="pBrand[]" class="form-control" value='<?php echo $pvd[5];?>'>
					<?php echo form_error('pBrand['.($i-1).']', '<div class="error">', '</div>'); ?>
				</td>
				<td><input id='pUnit-<?php echo $i;?>' type="text" name="pUnit[]" class="form-control" value='<?php echo $pvd[6];?>'></td>
				<td>
					<input id='pBuyPrice-<?php echo $i;?>' type="number" name="pBuyPrice[]" class="form-control" value='<?php echo $pvd[7];?>'>
					<?php echo form_error('pBuyPrice['.($i-1).']', '<div class="error">', '</div>'); ?>
				</td>
				<td><input id='pSellPrice-<?php echo $i;?>' type="number" name="pSellPrice[]" class="form-control" value='<?php echo $pvd[8];?>'></td>
				<td><input id='pMinStock-<?php echo $i;?>' type="number" name="pMinStock[]" class="form-control" value='<?php echo $pvd[9];?>'></td>
				<td><input id='pVat-<?php echo $i;?>' type="text" name="pVat[]" class="form-control" value='<?php echo $pvd[10];?>'></td>
				<td><input id='pSupplier-<?php echo $i;?>' type="text" name="pSupplier[]" class="form-control" value='<?php echo $pvd[11];?>'></td>
			</tr>
			<input type="hidden" name="rCount[]" value="<?php echo $rCount;?>">
			<?php
			$i++;
		endforeach;
		?>
		</tbody>
	</table>
	<input type="submit" name="submit" value="Submit" class="btn btn-primary">

	</form>

	<script type="text/javascript">
		$(document).ready(function() {
			// validate the comment form when it is submitted
			$("#csvPreview").validate({
				rules: {
					"pName[]": "required",
					"pCat[]": "required",
					"pBrand[]": "required",
					"pUnit[]": "required",
					"pBuyPrice[]": "required",
				},
				messages: {
					"pName[]": "required",
					"pCat[]": "required",
					"pBrand[]": "required",
					"pUnit[]": "required",
					"pBuyPrice[]": "required",
				}
			});

			$( ".error" ).prev().css( "border-color", "#a94442" );
		});
	</script>
</div>
          </div>
</div>