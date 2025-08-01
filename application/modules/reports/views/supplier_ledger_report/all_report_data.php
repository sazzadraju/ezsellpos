<style type="text/css">
</style>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <?php echo form_open_multipart('', array('id' => 'product', 'class' => 'cmxform')); ?>
                <div class="element-wrapper">
                    <?php
                    if(!empty($FromDate)){
                        echo'Previous Balance: '. ($balance['total_invoice']-$balance['total_payment']);
                    }
                    ?>
                    <table id="mytable" class="table table-bordred table-striped">
                        <thead>
                        <th><?= lang("date"); ?></th>
                        <th><?= lang("trx_no"); ?></th>
                        <th><?= lang("invoice_no"); ?></th>
                        <th><?= lang("type"); ?></th>
                        <th class="right_text"><?= lang("invoice_amount").' (' .set_currency().')'; ?></th>
                        <th class="right_text"><?= lang("paid_amount").' (' .set_currency().')'; ?></th>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;

                        $tot_paid = 0;
                        $tot_amount = 0;
                        if (!empty($posts)):
                            $check_invoice_amt = array();
                            $newData=sortData($posts);
                            foreach ($newData as $post):
                                ?>
                                <tr>
                                    <?php
                                    $date = date('Y-m-d', strtotime($post['dtt_add']));
                                    echo '<td>' . $date . '</td>';
                                     if ($post['account_id']>0) {
                                         echo '<td>' . $post['trx_no'] . '</td>';
                                    } else{
                                        echo '<td></td>';
                                    }
                                    echo '<td>' . $post['invoice_no'] . '</td>';
                                    if ($post['account_id']>0) {
                                        $type=$this->supplier_ledger_report_model->get_type_name($post['trx_no']);
                                        $type_name=($type!='')?' ('.$type[0]['type_name'].')':'';
                                        echo '<td>' . account_name_id($post['account_id']) .$type_name. '</td>';
                                    } else{
                                        echo '<td></td>';
                                    }
                                    if ($post['invoice_total_amt']>0) {
                                        echo '<td class="right_text">' . $post['invoice_total_amt'] . '</td>';
                                    } else{
                                        echo '<td class="right_text"></td>';
                                    }
                                    if ($post['payment_amt']>0) {
                                        echo '<td class="right_text">' . $post['payment_amt'] . '</td>';
                                    } else{
                                        echo '<td class="right_text"></td>';
                                    }
                                    //$tot_due=$tot_due+ $post['due_amt'];
                                    // $tot_paid=$tot_paid+ $post['paid_amt'];
                                    //$tot_amount=$tot_amount+ $post['tot_amt'];
                                    ?>
                                </tr>
                                <?php
                                $tot_paid = $tot_paid+$post['payment_amt'];
                                $tot_amount =$tot_amount+$post['invoice_total_amt'];
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
					   <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="right_text"><?=lang('total')?>:</th>
                            <th class="right_text"><?= number_format($tot_amount, 2, '.', '');?></th>
                            <th class="right_text"><?= number_format($tot_paid, 2, '.', '')?></th>
						</tr>
                        <?php 
                        $due_amount=$tot_amount-$tot_paid;
                        ?>
						<tr>
                            <th colspan="4"></th>
                            <th class="right_text">Due Amount:</th>
                            <th class="right_text"><?= number_format($due_amount, 2, '.', '')?></th>
						</tr>
                        <tr>
                            <th colspan="4"></th>
                            <th class="right_text">Settle Amount:</th>
                            <th class="right_text"><?= number_format($settle[0]['total_settle'], 2, '.', '')?></th>
                        <tr>
                        <tr>
                            <th colspan="4"></th>
                            <th class="right_text">Actual Due Amount:</th>
                            <th class="right_text"><?= number_format(($due_amount-$settle[0]['total_settle']), 2, '.', '')?></th>
                        <tr>
                        </tfoot>
                    </table>

                    <div class="clearfix"></div>
                    <?php //echo $this->ajax_pagination->create_links(); ?>
