
<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>


<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="top-btn full-box">

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('invoice_no') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $posts[0]['invoice_no']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('date') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo nice_datetime($posts[0]['dtt_add']); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('store_name') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $posts[0]['store_name']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('supplier_name') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $posts[0]['supplier_name']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('status') ?> </label>
                                    <div class="col-sm-12">
                                        <?php if ($posts[0]['status_id'] == 1) {
                                            echo '<td>' . lang('order_placed') . '</td>';
                                        } else if ($posts[0]['status_id'] == 2) {
                                            echo '<td>' . lang('order_cancelled') . '</td>';
                                        } else {
                                            echo '<td class="bg-success">' . lang('order_received') . '</td>';
                                        } ?>
                                    </div>
                                </div>
                                <button class="btn btn-primary pull-right" type="button"
                                        onclick="order_print_view(<?= $order_id ?>)"><i
                                            class="fa fa-view"></i> <?= lang("print"); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang("product_code"); ?></th>
                                        <th><?= lang("product_name"); ?></th>
                                        <th><?= lang("attributes"); ?></th>
                                        <th class="text-right"><?= lang("qty"); ?></th>
                                        <th class="text-right"><?= lang("unit_price"); ?></th>
                                        <th class="text-right"><?= lang("total_price"); ?></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total=0;
                                        $qty_total=0;
                                        if (!empty($posts)):
                                            $count = 1;
                                            foreach ($posts as $post):
                                                ?>
                                                <tr>
                                                    <?php
                                                    echo '<td>' . $post['product_code'] . '</td>';
                                                    echo '<td>' . $post['product_name'] . '</td>';
                                                    echo '<td>' . $post['attribute_name'] . '</td>';
                                                    echo '<td class="text-right">' . number_format($post['qty'],2) . '</td>';
                                                    echo '<td class="text-right">' . number_format($post['unit_amt'],2) . '</td>';
                                                    echo '<td class="text-right">' . number_format($post['tot_amt'],2) . '</td>';
                                                    ?>
                                                </tr>
                                                <?php
                                                $count++;
                                                $total+=$post['tot_amt'];
                                                $qty_total+=$post['qty'];
                                            endforeach;
                                        else:
                                            ?>
                                            <tr>
                                                <td colspan="5"><b><?= lang("data_not_available"); ?></b></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" style="text-align:right;">Total:</th>
                                            <th style="text-align:right;"><?= number_format($qty_total,2)?></th>
                                            <th colspan="2" style=" text-align:right;"><?= number_format($total,2)?></th>
                                        </tr>
                                    </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="stockDetailsData" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Purchase Details</h6>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">Close
                </button>
                <button type="button" class="btn btn-default pull-right" onclick="sale_print()">Print</button>

            </div>
            <div class="modal-body">
                <div class="sale-view invoice_content" id="stock_view">

                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    function order_print_view(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>purchase_settings/purchase_order/order_print_data',
            data: 'id=' + id,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#stock_view').html(html);
                $('.loading').fadeOut("slow");
                $('#stockDetailsData').modal('toggle');
            }
        });
    }


</script>



