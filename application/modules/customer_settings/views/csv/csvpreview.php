
<div class="content-i">
	<div class="content-box">
<div class="element-box full-box">
	<h6 class="element-header">Import CSV for Customers</h6>

	<br>


	<?php
	$attributes = array('method' => 'post', 'id' => 'csvPreview', 'name' => 'csvPreview');
	echo form_open('customer/csv/importcsv', $attributes);
	?>

	<!-- <form action="http://localhost/fpos/csv/importcsv" method="post" id="csvPreview" name="csvPreview" > -->


	<table class="table table-responsive">
		<thead>
		<tr>
			<th>#</th>
			<th><?= lang('membership_id') ?></th>
			<th><?= lang('customer_type') ?></th>
			<th><?= lang('full_name') ?></th>
			<th><?= lang('email') ?></th>
			<th><?= lang('phone') ?></th>
			<th><?= lang('gender') ?></th>
			<th><?= lang('dob') ?></th>
			<th><?= lang('marital_status') ?></th>
			<th><?= lang('anniversary_date') ?></th>
			<th><?= lang('address') ?></th>
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
					<input id='customer_code-<?php echo $i;?>' type="text" name="customer_code[]" class="form-control" value='<?php echo $pvd[0];?>'>
					<?php echo form_error('customer_code['.($i-1).']', '<div class="error">', '</div>'); ?>
				</td>
				<td>
					<select class="form-control" id="customer_type_id" name="customer_type_id[]">
                        <option value="0" selected><?= lang('select_one') ?></option>
                        <?php

                        if ($customer_type_list) {
                            foreach ($customer_type_list as $type_list) {
                            	$selected=($type_list['name']==$pvd[1] ||$type_list['id_customer_type']==$pvd[1])?'selected':'';
                            	echo '<option value="'.$type_list['id_customer_type'].'"'.$selected.'>'.$type_list['name'].'</option>';
                            }
                        }
                        ?>
                        </select>
					<?php echo form_error('customer_type_id['.($i-1).']', '<div class="error">', '</div>'); ?>
				</td>
				<td>
					<input id='full_name-<?php echo $i;?>' type="text" name="full_name[]" class="form-control" value='<?php echo $pvd[2];?>'>
					<?php echo form_error('full_name['.($i-1).']', '<div class="error">', '</div>'); ?>
				</td>
				<td>
					<input id='c_email-<?php echo $i;?>' type="text" name="c_email[]" class="form-control" value='<?php echo $pvd[3];?>'>
				</td>
				<td>
					<input id='phone-<?php echo $i;?>' type="text" name="phone[]" class="form-control" value='<?php echo html_escape($pvd[4]);?>'></td>
				<td>
					<input id='gender-<?php echo $i;?>' type="text" name="gender[]" class="form-control" value='<?php echo $pvd[5];?>'>
				</td>
				<td><input id='birth_date-<?php echo $i;?>' type="text" name="birth_date[]" class="form-control" value='<?php echo $pvd[6];?>'></td>
				<td>
					<input id='marital_status-<?php echo $i;?>' type="text" name="marital_status[]" class="form-control" value='<?php echo $pvd[7];?>'>
				</td>
				<td><input id='anniversary_date-<?php echo $i;?>' type="text" name="anniversary_date[]" class="form-control" value='<?php echo $pvd[8];?>'></td>
				<td>
					<textarea id='addr_line_1-<?php echo $i;?>' name="addr_line_1[]" class="form-control" ><?php echo $pvd[9];?></textarea>  
				</td>
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
					"customer_code[]": "required"
					,"full_name[]": "required"
				},
				messages: {
					"customer_code[]": "Alreasy Exist"
					"full_name[]": "Required"
				}
			});

			$( ".error" ).prev().css( "border-color", "#a94442" );
		});
	</script>
</div>
          </div>
</div>