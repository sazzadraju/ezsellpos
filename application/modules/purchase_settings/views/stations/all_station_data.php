<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("sl_no"); ?></th>
    <th><?= lang("station_name"); ?></th>
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
                <?php
                $val = '';
                if (!empty($post['parent_cat_id'])) {
                    foreach ($categories as $category) {
                        if ($category->id_product_category == $post['parent_cat_id']) {
                            $val = $category->cat_name;
                            //break;
                        }
                    }
                    echo '<td>' . $val . '</td>';
                    echo '<td>' . $post['cat_name'] . '</td>';
                } else {
                    echo '<td>' . $post['cat_name'] . '</td>';
                    foreach ($categories as $category) {
                        if ($category->id_product_category == $post['parent_cat_id']) {
                            $val = $category->cat_name;
                            //break;
                        }
                    }
                    echo '<td>' . $val . '</td>';
                }
                ?>
                <td>
                    <button class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" onclick="edit_person(<?= $post['id_product_category'] ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td class="center">
                    <button class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal" data-target="#deleteStation" onclick="deleteStationModal('<?= $post->id_station ?>');"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>
            <?php
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
        </tr>
    <?php endif; ?> 
</tbody>
</table>
<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>