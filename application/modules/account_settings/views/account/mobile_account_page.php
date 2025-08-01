                                            <table id="mobile_acc_tbl" class="table table-bordred table-striped">
                                                <thead>
                                                    <th class="fit"><?= lang("sl_no"); ?></th>
                                                    <th><?= lang("mobile_bank"); ?></th>
                                                    <th><?= lang("account_no"); ?></th>
                                                    <th><?= lang("acc_uses"); ?></th>
                                                    <th class="fit"><?= lang("initial_balance"); ?></th>
                                                    <th class="fit"><?= lang("current_balance"); ?></th>
                                                    <th><?= lang("stores"); ?></th>
                                                    <th class="center"><?= lang("action"); ?></th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($mobile_accounts)):
                                                        $count = 1;
                                                        foreach ($mobile_accounts as $acc):
                                                            ?>
                                                            <tr>
                                                                <td class="fit"><?php echo ($offset+$count); ?>.</td>
                                                                <td><?php echo $acc['bank_name']; ?></td>
                                                                <td><?php echo $acc['account_no']; ?></td>
                                                                <td><?php echo get_key($this->config->item('acc_uses'), $acc['acc_uses_id']); ?></td>
                                                                <td class="fit text-right"><?php echo comma_seperator($acc['initial_balance']), ' ', lang('taka'); ?></td>
                                                                <td class="fit text-right"><?php echo comma_seperator($acc['curr_balance']), ' ', lang('taka'); ?>
                                                                    <input type="hidden" name="c_curr_balance" id="c_curr_balance_<?=$acc['id']?>" value="<?=$acc['curr_balance']?>"></td>
                                                                <td><?php echo $acc['stores']; ?></td>
                                                                <td class="center fit">
                                                                    <button rel="tooltip" title="<?= lang("view") ?>" class="btn btn-success btn-xs" data-title="<?= lang("view"); ?>" data-toggle="modal" data-target="#ma_view" onclick="viewDetaitls('<?= $acc['id'] ?>')"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                                    <button rel="tooltip" title="<?= lang("edit") ?>" class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" data-toggle="modal" data-target="#add" onclick="edit_account_data(<?= $acc['id'] ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                                    <button rel="tooltip" title="<?= lang("delete") ?>" class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal" data-target="#delete_account_m" onclick="delete_account_modal('<?= $acc['id'] ?>');"><span class="glyphicon glyphicon-trash"></span></button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $count++;
                                                        endforeach;
                                                    else:
                                                        ?>
                                                        <tr><td colspan="10" align="center"><b><?= lang("data_not_available"); ?></b></td></tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                            <div class="clearfix"></div>
                                            <?php echo $pagination_link_3;?>