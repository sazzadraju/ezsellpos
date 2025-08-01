
<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("serial"); ?></th>
    <th><?= lang("name"); ?></th>
    <th><?= lang("type"); ?></th>
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
                    <td><?php echo $post['reason']; ?></td>
                    <td><?php echo $post['type_name'];?></td>
                    <td>
                        <button class="btn btn-primary btn-xs" rel="tooltip" title="<?= lang("edit")?>" data-title="<?= lang("edit"); ?>" onclick="edit_reason(<?= $post['id_stock_mvt_reason'] ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button class="btn btn-danger btn-xs" rel="tooltip" title="<?= lang("delete")?>" data-title="<?= lang("delete"); ?>" data-toggle="modal" data-target="#deleteBrand" onclick="deleteBrandModal('<?= $post['id_stock_mvt_reason'] ?>');"><span class="glyphicon glyphicon-trash"></span></button>
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
