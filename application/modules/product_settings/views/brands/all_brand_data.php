<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("serial"); ?></th>
    <th><?= lang("brand_name"); ?></th>
    <th><?= lang("photo"); ?></th>
    <th><?= lang("action"); ?></th>
</thead>
<tbody>
    <?php
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $post['brand_name']; ?></td>
                <td>
                    <?php
                    if ($post['img_main'] != NULL) {
                        echo '<img src="'. documentLink('brand'). $post['img_main'] . '" height="60" width="100">';
                    }
                    ?>
                </td>
                <td>
                    <button class="btn btn-primary btn-xs" rel="tooltip" title="<?= lang("edit")?>" data-title="<?= lang("edit");?>" onclick="edit_person(<?= $post['id_product_brand'] ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                    <button class="btn btn-danger btn-xs" rel="tooltip" title="<?= lang("delete")?>" data-title="<?= lang("delete");?>" data-toggle="modal" data-target="#deleteBrand" onclick="deleteBrandModal('<?= $post['id_product_brand'] ?>');"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>
            <?php
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available");?></b></td>
        </tr>
    <?php endif; ?>
</tbody>

</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>