<input type="hidden" name="sales_commission" value="<?= $comm ?>">
<?php
if ($invoice == 1) {
    ?>
    <table id="bank_acc_tbl" class="table table-bordred table-striped">
        <thead>
        <tr>
            <th class="text-center"><input type="checkbox" id="sl_id_all" name="sl_id_all" value="1">
                <label for="sl_id_all"></label></th>
            <th class="text-center"><?= lang("invoice"); ?></th>
            <th><?= lang("date"); ?></th>
            <th class="text-center"><?= lang("invoice_total"); ?></th>
            <th class="text-center"><?= lang("com"); ?></th>
            <th class="text-center"><?= lang("pay"); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($unpaid_sales)):
            $count = 1;
            $td = 0;
            foreach ($unpaid_sales as $us):
                $comm = round(($us->tot_amt * $parsons[0]->commission) / 100, 2);
                ?>
                <tr>
                <td><input class="child" type="checkbox" id="sl_id_<?= $count ?>" name="sl_id[]"
                           value="<?= $us->id_sale; ?>">
                    <label for="sl_id_<?= $count ?>"></label>
                </td>
                <td><?= $us->invoice_no; ?></td>
                <td><?php echo nice_date($us->dtt_add); ?></td>
                <td class="text-right"><?= $us->tot_amt; ?></td>
                <td class="text-right comm_<?= $count ?>"><?= $comm ?></td>
                <td>
                    <input type="hidden" name="sale_total[]" value="<?= $us->tot_amt ?>">
                    <input type="hidden" name="comm_amt[]" value="<?= $comm ?>">
                    <input class="form-control text-right pay_amt_cls" type="text" name="pay_amt[]"
                           id="pay_amt_<?= $count; ?>" readonly>
                </td>
                </tr><?php
                $count++;
                $td += $comm;
            endforeach; ?>
            <tr>
                <td colspan="4" class="text-right"><b>Total Due:</b></td>
                <td class="text-right"><b><?= $td ?></b></td>
                <td>
                    <input type="text" class="form-control text-right" name="pay_amt_tot" id="pay_amt_tot" value=""
                           readonly="">
                    <label id="pay_amt_tot-error" class="error" for="pay_amt_tot"></label>
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="4"><?= lang('data_not_available'); ?></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php
} else {
    ?>
    <div class="form-group">
        <label class="col-md-4 col-form-label"><?= lang('due_invoices') ?></label>
        <div class="col-md-7">
            <div class="row-fluid">
                <select class="form-control" data-live-search="true"
                        id="due_invoice_no" name="due_invoice_no">
                    <option value="0"><?= lang('select_one') ?></option>
                    <?php foreach ($unpaid_invoice as $val) : ?>
                        <option value="<?php echo $val->id_sales_person_comm; ?>"><?php echo $val->invoice_no.'('.nice_date($val->dtt_add).')'; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div id="due_invoice_dtl"></div>
    <?php
}
?>
<script>
    $(document).ready(function () {
        $("select#due_invoice_no").change(function () {
            var value = $('option:selected', this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>DueSalesCommission',
                data: 'id=' + value,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    var result = $.parseJSON(html);
                    $('.loading').fadeOut("slow");
                    $('#due_invoice_dtl').html(result.htmlView);
                    $('#pay_amount').val(result.pre_due);
                }
            });
        });
        $('input.pay_amt_cls').on('input', function (e) {
            var tot = 0;
            $('input.pay_amt_cls').each(function () {
                var val = parseFloat($(this).val());
                if (!isNaN(val)) {
                    tot += val;
                }
            });
            $('#pay_amt_tot').val(tot.toFixed(2));
        });
        $('#sl_id_all:checkbox').change(function () {
            if (this.checked) {
                $('.child').each(function () {
                    this.checked = true;
                });
            }
            else {
                $('input:checkbox').removeAttr('checked');
            }
            checked_value_total();
        });
        $('.child:checkbox').change(function () {
            checked_value_total();
        });
    });
    function checked_value_total() {
        var tot = 0;
        $('.child').each(function () {
            var id_full = $(this).attr("id");
            var id = id_full.split("_").pop(-1);
            if (this.checked) {
                var comm = $('.comm_' + id).html();
                $('#pay_amt_' + id).val(comm);
                tot = (tot * 1) + (comm * 1);
            } else {
                $('#pay_amt_' + id).val('');
            }
        });
        $('#pay_amount').val(tot.toFixed(2));
        $('#pay_amt_tot').val(tot.toFixed(2));
        if (tot == 0) {
            $("#sl_id_all")[0].checked = false;
            $('#pay_amount').val('');
        }
    }
</script>