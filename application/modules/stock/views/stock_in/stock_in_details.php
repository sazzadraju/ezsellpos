<?php
// echo "<pre>";
// print_r($stock_in_list);
// exit();
?>

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
                                        <?php echo $stock_in_list[0]['invoice_no']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('stock_in_date') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $stock_in_list[0]['dtt_stock_mvt']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('store_name') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $store_name[0]['store_name']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"
                                           for=""><?= lang('stock_in_reason') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $stock_in_list[0]['notes']; ?>
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
                                            <a href="<?php echo documentLink('stock') . $doc_list['file']; ?>" download>
                                                <button class="btn btn-success btn-xs"><i class="fa fa-download"
                                                                                          aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <button class="btn btn-primary pull-right" type="button"
                                        onclick="stock_print_view(<?= $stock_id ?>)"><i
                                        class="fa fa-view"></i> <?= lang("print"); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php $this->load->view('stock_in/stock_in_details_list');?>
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
                <h6 class="element-header margin-0">Stock In Details</h6>
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
    function stock_print_view(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>stock/stock_in/stock_print_view',
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

