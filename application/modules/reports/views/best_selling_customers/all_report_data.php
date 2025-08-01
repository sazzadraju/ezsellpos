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
        <table id="mytable" class="table table-bordered table-striped">
            <thead>
            <th class="text-center"><?= lang("sl"); ?></th>
            <th><?= lang("customer_name"); ?></th>
            <th><?= lang("phone"); ?></th>
            <th><?= lang("type"); ?></th>
            <th><?= lang("store"); ?></th>
            <th class="right_text"><?= lang("total_amount"); ?></th>
            <th class="right_text"><?= lang("paid"); ?></th>
            <th class="right_text"><?= lang("due"); ?></th>
            </thead>
            <tbody>
            <?php
            $sum_total = 0;
            $paid_total = 0;
            $due_total = 0;
            if (!empty($posts)):
                $count = 1;

                foreach ($posts as $post):
                    // pa($post);
                    ?>
                    <tr>
                        <?php
                        echo '<td id="invoiceNo" class="text-center">'.$count.'</td>';
                        echo '<td>' . $post['customer_name'] . ' (' . $post['customer_code'] .')'. '</td>';
                        echo '<td>' . $post['phone'] . '</td>';
                        echo '<td>' . $post['customer_type'] . '</td>';
                        echo '<td>' . $post['store_name'] . '</td>';
                        echo '<td class="right_text">' . $post['tot_amt']. '</td>';
                        echo '<td class="right_text">' . $post['paid_amt'] . '</td>';
                        echo '<td class="right_text">' . $post['due_amt'] . '</td>';
                        $sum_total += $post['tot_amt'];
                        $paid_total += $post['paid_amt'];
                        $due_total +=  $post['due_amt'];
                        ?>
                    </tr>
                    <?php
                    $count++;
                endforeach;
            else:
                ?>
                <tr>
                    <td colspan="8"><b><?= lang("data_not_available"); ?></b></td>
                </tr>
            <?php endif; ?>
            </tbody>
            <tfoot>
            <th colspan="5" class="right_text"><?= lang("total"); ?></th>
            <th class="right_text"><?= $sum_total; ?></th>
            <th class="right_text"><?= $paid_total; ?></th>
            <th class="right_text"><?= $due_total; ?></th>
            </tfoot>
        </table>

        <div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>