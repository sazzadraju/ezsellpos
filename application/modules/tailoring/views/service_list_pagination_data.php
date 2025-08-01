<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <th>#</th>
        <th>Service Name</th>
        <th>Price</th>
        <th class="center">Actions</th>
    </thead>
    <tbody>
        <?php
            if(!empty($services)):
            $iid = 1; 
            foreach($services as $tailorService):
        ?>
        <tr>
            <td><?php echo $iid;?></td>
            <td><?php echo $tailorService['service_name'];?></td>
            <td><?php echo $tailorService['service_price'];?></td>
            <td class="center">
                <button id="serviceView" serviceId = "<?php echo $tailorService['id_service'];?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button>
                <a href="<?php echo base_url();?>tailoring/edit/<?php echo $tailorService['id_service'];?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                <button serviceId = "<?php echo $tailorService['id_service'];?>" class="btn btn-danger btn-xs serviceDelete" ><span class="glyphicon glyphicon-trash"></span></button>
            </td>       
        </tr>
        <?php $iid++; endforeach; else:?>
        <tr><td>Service(s) not available.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links(); ?>