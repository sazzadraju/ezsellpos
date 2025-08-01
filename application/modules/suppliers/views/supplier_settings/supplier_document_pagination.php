<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <th><?= lang('serial')?></th>
        <th><?= lang('name')?></th>
        <th><?= lang('description')?></th>
        <th><?= lang('file')?></th>
        <th class="center"><?= lang('action')?></th>

    </thead>
    <tbody>
    <?php
        $i = 1;
        if(!empty($posts)){
            foreach ($posts as $list) {
    ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $list['name'];?></td>
            <td><?php echo $list['description'];?></td>
            <td>
                <?php
                $name = $list['file'];
                $fileExt = strrchr($name, ".");
                $output = '';
                if ($fileExt == '.jpg' || $fileExt == '.png' || $fileExt == '.jpeg' || $fileExt == '.gif') {
                    $output = '<a href="#" onclick="show_image(' . $list['id_document'] . ')"><i class="fa fa-picture-o" aria-hidden="true"></i></a>';
                    $output .= '<div id="img_' . $list['id_document'] . '" style="display: none;"><img src="' . documentLink('supplier') . $name . '" style="width:100%"></div>';
                } else if ($fileExt == '.doc' || $fileExt == '.docx') {
                    $output = '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
                } else if ($fileExt == '.xlsx' || $fileExt == '.xls'  || $fileExt == '.xlsm' || $fileExt == '.xltx' || $fileExt == '.xltm') {
                    $output = '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
                } else if ($fileExt == '.pdf' || $fileExt == '.xps') {
                    $output = '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
                } else {
                    $output = '<i class="fa fa-file" aria-hidden="true"></i>';
                }
                echo $output;
                ?>
            </td>

            <td class="center">
                <?php
                if (!empty($list['file'])) {
                    ?>
                    <a href="<?php echo documentLink('supplier') . $list['file']; ?>"  rel="tooltip" title="<?= lang("download")?>" download><button class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i></button></a>
                    <?php
                }
                ?>
                <button class="btn btn-primary btn-xs" data-title="Edit"  rel="tooltip" title="<?= lang("edit")?>" data-toggle="modal" data-target="#edit_supplier_document_modal" onclick="editSupplierDocument('<?php echo $list['id_document'];?>')"><span class="glyphicon glyphicon-pencil"></span></button>

                <button class="btn btn-danger btn-xs"  rel="tooltip" title="<?= lang("delete")?>" data-title="Delete" data-toggle="modal" data-target="#deleteSupplierDocumentModal" onclick="deleteSupplierDocModal('<?php echo $list['id_document'];?>');"><span class="glyphicon glyphicon-trash"></span></button>

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