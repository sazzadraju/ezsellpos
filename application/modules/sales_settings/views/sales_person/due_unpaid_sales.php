<table id="bank_acc_tbl" class="table table-bordred table-striped">
        <thead>
        <tr>
            <th class="text-center"><?= lang("invoice"); ?></th>
            <th><?= lang("date"); ?></th>
            <th class="text-center"><?= lang("invoice_total"); ?></th>
            <th class="text-center"><?= lang("com"); ?></th>
            <th class="text-center"><?= lang("pay"); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($unpaid_sales_details)):
            $count = 1;
            $td = 0;
            foreach ($unpaid_sales_details as $us):
                ?>
                <tr>
                <td><?= $us['invoice_no']; ?></td>
                <td><?php echo nice_date($us['dtt_add']); ?></td>
                <td class="text-right"><?= $us['invoice_amt']; ?></td>
                <td class="text-right comm_<?= $count ?>"><?= $us['comm_amt']; ?></td>
                <td>
                    <input class="form-control text-right pay_amt_cls" type="text" name="pay_amt[]"
                           id="pay_amt_<?= $count; ?>" readonly value="<?= $us['comm_amt']; ?>">
                </td>
                </tr><?php
                $count++;
                $td += $us['comm_amt'];
            endforeach; ?>
            <tr>
                <td colspan="4" class="text-right"><b>Total</b></td>
                <td>
                    <input type="text" class="form-control text-right" name="pay_amt_tot" id="pay_amt_tot" value="<?= $td?>"
                           readonly="">
                    <label id="pay_amt_tot-error" class="error" for="pay_amt_tot"></label>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>Previous Paid </b></td>
                <td>
                    <input type="text" class="form-control text-right" name="previous_paid" id="previous_paid" value="<?= $sales_persons[0]->paid_amt?>"
                           readonly="">
                    <input type="hidden" name="previous_due" value="<?= $sales_persons[0]->due_amt?>">
                    <input type="hidden" name="dp_sales_person_id" value="<?= $sales_persons[0]->id_sales_person_comm?>">
                    <label id="previous_paid-error" class="error" for="previous_paid"></label>
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="4"><?= lang('data_not_available'); ?></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
