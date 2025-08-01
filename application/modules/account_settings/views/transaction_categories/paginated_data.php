                                            <table id="mytable" class="table table-bordred table-striped">
                                                <thead>
                                                <th class="fit"><?= lang("sl_no"); ?></th>
                                                <th><?= lang("category"); ?></th>
                                                <th><?= lang("child_category"); ?></th>
                                                <th><?= lang("type"); ?></th>
                                                <th class="center"><?= lang("action"); ?></th>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    if (!empty($categories)):
                                                        $count = 1;
                                                        foreach ($categories as $cat):
                                                            ?>
                                                            <tr>
                                                                <td class="fit"><?php echo ($offset+$count); ?>.</td>
                                                                <td><?php echo $cat['category'];?></td>
                                                                <td><?php echo $cat['child_category'];?></td>
                                                                <td><?php echo get_key($this->config->item('transaction_categories_types'), $cat['qty_modifier']);?></td>
                                                                <td class="center fit">
                                                                    <button rel="tooltip" title="<?= lang("edit") ?>" class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" onclick="edit_trx_cat(<?= $cat['id'] ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                                    <button rel="tooltip" title="<?= lang("delete") ?>" class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal" data-target="#delete_category" onclick="delete_category_modal('<?= $cat['id'] ?>');"><span class="glyphicon glyphicon-trash"></span></button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $count++;
                                                        endforeach;
                                                    else:
                                                        ?>
                                                        <tr>
                                                            <td colspan="6"><b><?= lang("data_not_available"); ?></b></td>
                                                        </tr>
                                                    <?php endif; ?> 
                                                </tbody>
                                            </table>
                                            <div class="clearfix"></div>
                                            <?php echo $this->ajax_pagination->create_links(); ?>