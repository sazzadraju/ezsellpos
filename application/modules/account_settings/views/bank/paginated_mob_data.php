                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                            <th class="fit"><?= lang("sl_no"); ?></th>
                                            <th><?= lang("bank_name"); ?></th>
                                            <th class="center"><?= lang("action"); ?></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($mobile_banks)):
                                                $count = 1;
                                                foreach ($mobile_banks as $key=>$val):
                                                    ?>
                                                    <tr>
                                                        <td class="fit"><?php echo $count; ?>.</td>
                                                        <td><?php echo $val; ?></td>
                                                        <td class="center fit">
                                                            <button rel="tooltip" title="<?= lang("edit") ?>" class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" onclick="edit_bank(<?=$key ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                            <button rel="tooltip" title="<?= lang("delete") ?>" class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal" data-target="#delete_bank_m" onclick="delete_bank_modal('<?= $key ?>');"><span class="glyphicon glyphicon-trash"></span></button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $count++;
                                                endforeach;
                                            else:
                                                ?>
                                                <tr>
                                                    <td colspan="2"><b><?= lang("data_not_available"); ?></b></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <div class="clearfix"></div>
                                    <?php echo $pagination_link_2;?>