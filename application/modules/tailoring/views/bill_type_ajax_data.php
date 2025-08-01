<table id="pricingTable" class="table table-bordred table-striped">
    <thead>
        <th>Bill Type Name</th>
        <th class="center">Edit</th>
        <th class="center">Delete</th>
    </tr></thead>
    <tbody>
		<?php if(!empty($billTypes)): foreach($billTypes as $singlebt): ?>
		<tr>
		    <td><?php echo $singlebt['field_name'];?></td>
		    <td class="center">
		        <button eValue="<?php echo $singlebt['field_name'];?>" pValue="<?php echo $singlebt['id_field'];?>" class="btn btn-primary btn-xs pricingEdit" type="button"><span class="glyphicon glyphicon-pencil"></span></button>
		    </td>
		    <td class="center">
		         <button pValue="<?php echo $singlebt['id_field'];?>" class="btn btn-danger btn-xs pricingDelete"><span class="glyphicon glyphicon-trash" type="button"></span></button>
		    </td>
		</tr>
		<?php endforeach; else: ?>
		<tr><td colspan="4">Bill Type(s) not available.</td></tr>
		<?php endif; ?>
	</tbody>
    </table>
    <?php echo $this->ajax_pagination->create_links(); ?>
</div>