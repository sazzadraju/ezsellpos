
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
                                        <?php echo $doc_list['invoice_no']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('date') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo nice_datetime($doc_list['dtt_receive']); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('store_name') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $doc_list['store_name']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('supplier_name') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $doc_list['supplier_name']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('note') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $doc_list['notes']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('download_doc') ?> </label>
                                    <div class="col-sm-12">
                                        <?php
                                        if (!empty($doc_list['file'])) {
                                            ?>
                                            <a href="<?php echo documentLink('stock') . $doc_list['file']; ?>" download><button class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i></button></a>
                                            <?php
                                        }
                                        ?>                                           
                                    </div>
                                </div>
                                <button class="btn btn-primary pull-right" type="button"
                                        onclick="receive_print_view(<?= $receive_id ?>)"><i
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
                                            <tr>
                                                <th><?= lang("product_code"); ?></th>
                                                <th><?= lang("product_name"); ?></th>
                                                <th><?= lang("batch_no"); ?></th>
                                                <th><?= lang("attributes")?></th>
                                                <th><?= lang("qty"); ?></th>
                                                <th class="text-right"><?= lang("unit_price"); ?></th>
                                                <th class="text-right"><?= lang("total_price"); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            $i = 1;
                                            if (!empty($posts)) {
                                                foreach ($posts as $list) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $list['product_code']; ?></td>
                                                        <td><?php echo $list['product_name']; ?></td>
                                                        <td><?php echo $list['batch_no']; ?></td>
                                                        <td><?php echo $list['attribute_name']; ?></td>
                                                        <td><?php echo number_format($list['qty'],2); ?></td>
                                                        <?php $tot_amt = $list['qty'] * $list['purchase_price']; ?>
                                                        <td class="text-right"><?php echo number_format($list['purchase_price'],2); ?></td>
                                                        <td class="text-right"><?php echo number_format($tot_amt,2) ; ?></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                    $total += $tot_amt;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" style="text-align:right;">Total:</th>
                                                <th class="text-right" style=" margin-left: 10px;"><?= number_format($total,2) ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="clearfix"></div>
                                    <?php echo $this->ajax_pagination->create_links(); ?>
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
    function receive_print_view(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>purchase_settings/purchase_receive/receive_print_data',
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
