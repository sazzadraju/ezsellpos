<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <tr>
            <th><?= lang('invoice_no')?></th>
            <th><?= lang('stock_in_date')?></th>
             <th><?= lang('store_name')?></th>
            <th><?= lang('user')?></th>
            <th><?= lang('stock_in_reason')?></th>
            <th><?= lang('documents')?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
         <?php
            $i = 1;
            if(!empty($posts)){
                foreach ($posts as $list) {
        ?>
        <tr>
            
            <td><a href="<?php echo base_url();?>stock_in_details/<?php echo $list['id_stock_mvt'];?>"><?php echo $list['invoice_no'];?></a></td>
            <td><?php echo $list['dtt_stock_mvt'];?></td>
            <td><?php echo $list['store_name'];?></td>
            <td><?php echo $list['user_name'];?></td>
            <td><?php echo $list['notes'];?></td>
            <td>
                <?php
                $name = $list['file'];
                $fileExt = strrchr($name, ".");
                $output = '';
                if ($fileExt == '.jpg' || $fileExt == '.png' || $fileExt == '.jpeg' || $fileExt == '.gif') {
                    $output = '<a href="#" onclick="show_image(' . $list['id_document'] . ')"><i class="fa fa-picture-o" aria-hidden="true"></i></a>';
                    $output .= '<div id="img_' . $list['id_document'] . '" style="display: none;"><img src="' . documentLink('stock') . $name . '" style="width:100%"></div>';
                } else if ($fileExt == '.doc' || $fileExt == '.docx') {
                    $output = '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
                } else if ($fileExt == '.xlsx' || $fileExt == '.xls'  || $fileExt == '.xlsm' || $fileExt == '.xltx' || $fileExt == '.xltm') {
                    $output = '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
                } else if ($fileExt == '.pdf' || $fileExt == '.xps') {
                    $output = '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
                } 
                echo $output;
                ?>
            </td>
            <td class="center">
                <?php
                if (!empty($list['file'])) {
                    ?>
                    <a href="<?php echo documentLink('stock') . $list['file']; ?>" download><button class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i></button></a>
                    <?php
                }
                ?>
            </td>
        </tr>
        <?php 
            $i++;
                }
            }
        ?>    
    </tbody>
</table>
<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>

                                