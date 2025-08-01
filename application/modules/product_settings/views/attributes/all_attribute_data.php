<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("attribute_name"); ?></th>
    <th><?= lang("attribute_value"); ?></th>
    <th><?= lang("action"); ?></th>
</thead>
<tbody>

    <?php
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                    echo '<td>' . $post['attribute_name'] . '</td>';
                    echo '<td>' . $post['attribute_value'] . '</td>';
                ?>
                <td>
                    <button class="btn btn-primary btn-xs" rel="tooltip" title="<?= lang("edit")?>" data-title="<?= lang("edit");?>" onclick="edit_person(<?= $post['id_attribute'] ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                    <button class="btn btn-danger btn-xs" rel="tooltip" title="<?= lang("delete") ?>" data-title="<?= lang("delete");?>" data-toggle="modal" data-target="#delete_attr" onclick="deleteAttributeModal('<?= $post['id_attribute'] ?>');"><span class="glyphicon glyphicon-trash"></span></button>

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