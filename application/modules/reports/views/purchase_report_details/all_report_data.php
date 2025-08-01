<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("purchase_date"); ?></th>
    <th><?= lang("invoice_no"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th><?= lang("supplier_name"); ?></th>
    <th class="text-right"><?= lang("price"); ?></th>
    <th><?= lang("view"); ?></th>

    </thead>
    <tbody>
    <?php
    if (!empty($posts)):

        $count = 1;
        $total=0;
        foreach ($posts as $post):
            // print_r($post);
            ?>
            <tr>
                <?php
                // echo '<td id="invoiceNo">' . $post['invoice_no'] . '</td>';
                echo '<td>' . $post['dtt_receive'] . '</td>';
                echo '<td>' . $post['invoice_no'] . '</td>';
                echo '<td>' . $post['store_name'] . '</td>';
                echo '<td>' . $post['supplier_name'] . '</td>';
                echo '<td class="text-right">' . $post['tot_amt'] . '</td>';
                ?>
                <td class="center">
                    <button class="btn btn-primary pull-right" type="button"
                            onclick="searchFilter2('<?php echo $post["id_purchase_receive"] ?>')"><i
                                class="fa fa-eye"></i></button>
                </td>
            </tr>
            <?php
            $total+=$post['tot_amt'];
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
            <th colspan="4" class="text-right"> Total</th>
            <th class="text-right"> <?= number_format($total, 2, '.', '')?></th>
        </tr>
    </tfoot>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
<script type="text/javascript">

    function searchFilter2(id) {
        // var invoice_id=$('#invoiceNo').html();
        // $(this).text();
        // alert(id);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>purchase-report-details/page_data2/' + id,
            // beforeSend: function () {
            //     $('.loading').show();
            // },
            success: function (html) {
                console.log(html);
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
</script>
