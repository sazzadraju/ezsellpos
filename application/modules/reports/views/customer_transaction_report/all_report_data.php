<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("date"); ?></th>
    <th><?= lang("transaction_no"); ?></th>
    <th><?= lang("invoice"); ?></th>
    <th><?= lang("customer_name"); ?></th>
    <th><?= lang("store"); ?></th>
    <th class="text-right"><?= lang("amount").' ('.set_currency().')'; ?></th>
    <th><?= lang("details"); ?></th>
    </thead>
    <tbody>
    <?php
    $total=0;
    if (!empty($posts)):

        $count = 1;
        foreach ($posts as $post):
            // echo "<pre>";
            //   print_r($post);
            ?>
            <tr>
                <?php
                echo '<td>' . $post['dtt_trx'] . '</td>';
                echo '<td>' . $post['trx_no'] . '</td>';
                echo '<td>' . $post['invoice_no'] . '</td>';
                $customer_name = '';
                foreach ($customers as $customer) {
                    if ($customer->id_customer == $post['customer_id']) {
                        $customer_name = $customer->full_name;
                        break;
                    }
                }
                echo '<td>' . $customer_name . '</td>';
                $store_name = '';
                foreach ($store as $stores) {
                    if ($stores->id_store == $post['store_id']) {
                        $store_name = $stores->store_name;
                        break;
                    }
                }
                echo '<td>' . $store_name . '</td>';
                $account_name = '';
                $account_no = '';

                foreach ($accounts as $account) {
                    if ($account->id_account == $post['account_id']) {
                        $account_name = $account->account_name;
                        $account_no = $account->account_no;
                        break;
                    }
                }
                echo '<td class="text-right">' . $post['tot_amount'] . '</td>';
                ?>
                <td>
                    <button type="button" class="btn btn-primary btn-xs" data-title="<?= lang("view"); ?>"
                            data-toggle="modal" data-target="#view"
                            onclick="payment_details(<?= $post['trx_no'] ?>);method_details_data(<?= $post['trx_no'] ?>);">
                        <span class="glyphicon glyphicon-eye-open"></span></button>
                </td>
            </tr>
            <?php
            $total+=$post['tot_amount'];
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
            <th colspan="5" class="text-right">Total:</th>
            <th class="text-right"><?= number_format($total, 2, '.', '')?></th>
        </tr>
    </tfoot>
</table>

<div class="clearfix"></div>

<!-- modal -->

<!-- modal -->
<?php echo $this->ajax_pagination->create_links(); ?>


<script type="text/javascript">

    function payment_details(trx_no) {
        // alert(trx_no);
        $.ajax({
            url: "<?php echo base_url() ?>report/cus_trn_details/" + trx_no,
            type: "GET",
            dataType: "JSON",
            // beforeSend: function () {
            //     $('.loading').show();
            // },
            success: function (data) {
                console.log(data);
                var res = '';
                var total = 0;
                var vv = '';
                for (var i = 0; i < data.length; i++) {
                    total += data[i].amount;
                    vv += '<tr><td>' + data[i].trx_no + '</td><td>' + data[i].invoice_no + '</td><td>' + jsCurrency('<?=set_js_currency() ?>', data[i].tot_amount) + '</td></tr>';
                }
                $('.tttt').html(vv);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax4444');
            }
        });
    }
    function method_details_data(trx_no) {
        // alert(trx_no);
        $.ajax({
            url: "<?php echo base_url() ?>report/customer-method-details/" + trx_no,
            type: "GET",
            dataType: "JSON",
            // beforeSend: function () {
            //     $('.loading').show();
            // },
            success: function (data) {
                console.log(data);
                var res = '';
                var total = 0;
                var vv = '';
                for (var i = 0; i < data.length; i++) {
                    total += data[i].amount;
                    vv += '<tr><td>' + data[i].account_name + '</td><td>' + data[i].account_no + '</td><td>' + jsCurrency('<?=set_js_currency() ?>', data[i].amount) + '</td></tr>';
                }
                $('.pppp').html(vv);

            },

            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }


</script>
