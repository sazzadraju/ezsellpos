                                            <table id="cash_acc_tbl" class="table table-bordred table-striped">
                                                <thead>
                                                    <th class="fit"><?= lang("sl_no"); ?></th>
                                                    <th><?= lang("account_name"); ?></th>
                                                    <th><?= lang("acc_uses"); ?></th>
                                                    <th class="fit"><?= lang("initial_balance"); ?></th>
                                                    <th class="fit"><?= lang("current_balance"); ?></th>
                                                    <th><?= lang("store"); ?></th>
                                                    <th><?= lang("station"); ?></th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($station_accounts)):
                                                        $count = 1;
                                                        foreach ($station_accounts as $acc):
                                                            ?>
                                                            <tr>
                                                                <td class="fit"><?php echo ($offset+$count); ?>.</td>
                                                                <td><?php echo $acc['account_name']; ?></td>
                                                                <td><?php echo get_key($this->config->item('acc_uses'), $acc['acc_uses_id']); ?></td>
                                                                <td class="fit text-right"><?php echo comma_seperator($acc['initial_balance']), ' ', lang('taka'); ?></td>
                                                                <td class="fit text-right"><?php echo comma_seperator($acc['curr_balance']), ' ', lang('taka'); ?>
                                                                    <input type="hidden" name="c_curr_balance" id="c_curr_balance_<?=$acc['id']?>" value="<?=$acc['curr_balance']?>"></td>
                                                                <td><?php echo $acc['stores']; ?></td>
                                                                <td><?php echo $acc['station_name']; ?></td>
                                                            </tr>
                                                            <?php
                                                            $count++;
                                                        endforeach;
                                                    else:
                                                        ?>
                                                        <tr><td colspan="8" align="center"><b><?= lang("data_not_available"); ?></b></td></tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                            <div class="clearfix"></div>
                                            <?php echo $pagination_link_4;?>