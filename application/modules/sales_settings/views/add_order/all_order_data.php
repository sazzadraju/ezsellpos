<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang('serial')?></th>
    <th><?= lang('order_no')?></th>
    <th><?= lang('customer')?></th>
    <th><?= lang('store_name')?></th>
    <th class="text-center"><?= lang('date')?></th>
    <th><?= lang('note')?></th>
    <th class="text-right"><?= lang('total_amount')?></th>
    <th class="text-right"><?= lang('advance_paid')?></th>
    <th class="text-center"><?= lang('order_status')?></th>
    <th><?= lang('action')?></th>

    </thead>
    <tbody>
    <?php
    $i = 1;
    if (!empty($posts)) {
        foreach ($posts as $list) {
            ?>
            <tr>
                <td><?php echo($offset + $i); ?></td>
                <td id="name_<?php echo $list['id_order']; ?>"><?php echo $list['invoice_no']; ?></td>
                <td><?php echo $list['customer_name']; ?></td>
                <td><?php echo $list['store_name']; ?></td>
                <td class="text-center"><?php echo nice_date($list['dtt_add']); ?></td>
                <td><?php echo $list['notes']; ?></td>
                <td class="text-right"><?php echo $list['tot_amt']; ?></td>
                <td class="text-right"><?php echo $list['paid_amt']; ?></td>
                <td class="text-center"><?php
                    if ($list['status_id'] == 1) {
                        echo 'Order';
                    } else if ($list['status_id'] == 2) {
                        echo 'Partial Sale';
                    } else if ($list['status_id'] == 3) {
                        echo 'Sale';
                    } else {
                        echo 'Cancel';
                    }
                    ?>
                </td>
                <td>
                    <button class="btn btn-danger btn-xs" data-title="Details" data-toggle="modal" rel="tooltip"
                            title="<?= lang("details") ?>" data-target="#order_details_view"
                            onclick="orderDetailsa('<?php echo $list['id_order']; ?>')">
                        <span class="glyphicon glyphicon-eye-open"></span></button>
                    <?php
                    if ($list['status_id'] == 1) {
                        ?>
                        <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" rel="tooltip"
                                title="<?= lang("edit") ?>" data-target="#order_cancel_view"
                                onclick="cancelOrder('<?php echo $list['id_order']; ?>')"><span
                                    class="glyphicon glyphicon-remove"></span></button>
                        <?php
                    }
                    if (($list['status_id'] == 1) || ($list['status_id'] == 2)) {
                        ?>
                        <a href="<?= base_url() . 'sales?order=' . $list['id_order'] ?>" class="btn btn-success btn-xs">
                            <i class="fa fa-link" aria-hidden="true"></i>
                        </a>
                        <?php
                    }
                    ?>
                    <button value="<?php echo  $list['id_order'];?>" class="btn btn-success btn-xs invoiceView"><span class="fa fa-print"></span></button>
                </td>
            </tr>

            <?php
            $i++;
        }
    }
    ?>
    </tbody>

</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
<div id="order_details_view" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Order Details</h6>
            </div>
            <div class="modal-body">
                <div class="order-view" id="order_view">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close
                </button>
            </div>
        </div>
    </div>
</div>
<div id="order_cancel_view" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Order Cancel</h6>
            </div>
            <div class="modal-body">
                <div class="order-view" id="order_cancel_data">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.invoiceView', function () {
        var oId = $(this).val();

        // print

        var w = window.open('<?php echo base_url().'add-order/print-invoice';?>/'+oId,'name','width=800,height=500', '_blank');
        w.print({
            globalStyles: false,
            mediaPrint: true,
            stylesheet: "<?= base_url(); ?>themes/default/css/a4_print_new.css",
            iframe: false,
            noPrintSelector: ".avoid-this"
        });

    });
    function orderDetailsa(value) {
        $.ajax({
            type: "POST",
            url: URL + "add-order/view-details",
            data: 'id=' + value,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                $('.loading').fadeOut("slow");
                $('#order_view').html(result);
            }
        });
    }
    function cancelOrder(value) {
        $.ajax({
            type: "POST",
            url: URL + "add-order/view-order-trn",
            data: 'id=' + value,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                $('.loading').fadeOut("slow");
                $('#order_cancel_data').html(result);
            }
        });
    }

</script>
