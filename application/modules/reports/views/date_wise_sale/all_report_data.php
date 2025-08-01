<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <?php echo form_open_multipart('', array('id' => 'product', 'class' => 'cmxform')); ?>
                <div class="element-wrapper">
                    <div class="full-box element-box">
                        <div class="row">
                            <!--  <b>Showing Result For <?php echo $fdate; ?>   To <?php echo $tdate ?> For Store : All</b> -->
                            <label class="col-sm-4 col-form-label" for=""><?= lang('from_date') ?>
                                : <?php echo $fdate; ?></label>
                            <label class="col-sm-4 col-form-label" for=""><?= lang('to_date') ?>
                                : <?php echo $tdate; ?></label>
                            <label class="col-sm-4 col-form-label" for=""><?= lang('store') ?>
                                : <?php if ($which_store == 0) {
                                    echo lang('all_store');
                                } else {
                                    $store_name = '';
                                    foreach ($store as $stores) {
                                        if ($stores->id_store == $which_store) {
                                            $store_name = $stores->store_name;
                                            break;
                                        }
                                    }
                                    echo $store_name;

                                } ?></label>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <table id="mytable" class="table table-bordred table-striped">
            <thead>
            <th><?= lang("sl"); ?></th>
            <th><?= lang("date"); ?></th>
            <th class="right_text"><?= lang("invoice_amount"); ?></th>
            <th class="right_text"><?= lang("cash"); ?></th>
            <th class="right_text"><?= lang("bank"); ?></th>
            <th class="right_text"><?= lang("mobile"); ?></th>
            <th class="right_text"><?= lang("paid-amt"); ?></th>
            <th class="right_text"><?= lang("due_amount"); ?></th>
            </thead>
            <tbody>
            <?php
            $invoice_sum = $paid_sum = $due_sum =$cash_total = $bank_total = $mobile_total = 0;
            if (!empty($posts)):
                $count = 1;
                foreach ($posts as $post):
                    $transactions = $this->commonmodel->sale_transaction_by_date(explode(' ',$post['dtt_add'])[0],$post['store_id']);
                    $cash = $bank = $mobile = 0;
                    foreach ($transactions as $tran) {
                        if ($tran['payment_method_id'] == 1) {
                            $cash = $tran['amount'];
                            $cash_total += $tran['amount'];
                        } elseif ($tran['payment_method_id'] == 3) {
                            $mobile = $tran['amount'];
                            $mobile_total += $tran['amount'];
                        } else {
                            $bank = $tran['amount'];
                            $bank_total += $tran['amount'];
                        }
                    }
                    ?>
                    <tr>
                        <?php

                        echo '<td id="invoiceNo">' . $count . '</td>';
                        $date = date('Y-m-d', strtotime($post['dtt_add']));
                        echo '<td>' . $date . '</td>';
                        echo '<td class="right_text">' . $post['tot_amt'] . '</td>';
                        $invoice_sum += $post['tot_amt'];
                        echo '<td class="right_text">' . $cash . '</td>';
                        echo '<td class="right_text">' . $bank . '</td>';
                        echo '<td class="right_text">' . $mobile . '</td>';
                        echo '<td class="right_text">' . $post['paid_amt'] . '</td>';
                        echo '<td class="right_text">' . $post['due_amt'] . '</td>';
                        $paid_sum += $post['paid_amt'];
                        $due_sum += $post['due_amt'];
                        ?>
                        <!-- <td class="center">
                    <button class="btn btn-primary pull-right" type="button" onclick="searchFilter2('<?php echo $post["id_sale"] ?>')"><i class="fa fa-eye"></i></button>
                </td> -->
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
            <tfoot>
            <th></th>

            <th><?= lang("total"); ?></th>
            <th class="right_text"><?= number_format($invoice_sum, 2, '.', ''); ?></th>
            <th class="right_text"><?= number_format($cash_total, 2, '.', ''); ?></th>
            <th class="right_text"><?= number_format($bank_total, 2, '.', ''); ?></th>
            <th class="right_text"><?= number_format($mobile_total, 2, '.', ''); ?></th>
            <th class="right_text"><?= number_format($paid_sum, 2, '.', ''); ?></th>
            <th class="right_text"><?= number_format($due_sum, 2, '.', ''); ?></th>
            <!-- <th></th> -->
            </tfoot>
        </table>

        <div class="clearfix"></div>
        <?php echo $this->ajax_pagination->create_links(); ?>


