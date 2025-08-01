<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("unit_type"); ?></th>
    <th><?= lang("edit"); ?></th>
    <th><?= lang("delete"); ?></th>
</thead>
<tbody>

    <?php
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <td><?= $post['unit_code'] ?></td>
                <td>
                    <button class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" onclick="edit_unit(<?= $post['id_product_unit'] ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td class="center">
                    <button class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal" data-target="#deleteUnit" onclick="deleteUnitModal('<?= $post['id_product_unit'] ?>');"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>
            <?php
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b>Data not available..</b></td>
        </tr>
    <?php endif; ?> 


</tbody>

</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>