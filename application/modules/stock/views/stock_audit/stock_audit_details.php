<?php
// echo "<pre>";
// print_r($stock_audit_list);
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
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('audit_no') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $stock_audit_list[0]['audit_no']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('stock_audit_date') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo date('Y-m-d', strtotime($stock_audit_list[0]['dtt_audit'])); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('audited_by') ?> </label>
                                    <div class="col-sm-12">
                                        <?php echo $stock_audit_list[0]['audit_participants']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('status') ?> </label>
                                    <div class="col-sm-12">

                                        <?php
                                        if ($stock_audit_list[0]['status_id'] == 1) {
                                        ?>
                                            <button class="btn btn-warning btn-xs"><?= lang('ongoing') ?></button>
                                        <?php
                                        } elseif ($stock_audit_list[0]['status_id'] == 2) {
                                        ?>
                                            <button class="btn btn-danger btn-xs"><?= lang('canceled') ?></button>
                                        <?php
                                        } elseif ($stock_audit_list[0]['status_id'] == 3) {
                                        ?>
                                            <button class="btn btn-success btn-xs"><?= lang('completed') ?></button>
                                        <?php
                                        }

                                        $id_stock_audit = $stock_audit_list[0]['id_stock_audit'];

                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('download_doc') ?> </label>
                                    <div class="col-sm-12">
                                        <!-- <?php
                                                if (!empty($doc_list['file'])) {
                                                ?>
                                            <a href="<?php echo base_url() . 'public/uploads/stock_documents/' . $doc_list['file']; ?>"
                                               download>
                                                <button class="btn btn-success btn-xs"><i class="fa fa-download"
                                                                                          aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            <?php
                                                }
                                            ?> -->
                                        <!-- <button class="btn btn-success btn-xs">
                                            CSV <i class="fa fa-download" aria-hidden="true"></i>
                                        </button> -->

                                        <a href="<?php echo base_url('export_stock_audit_csv') . '?id_stock_audit=' . $id_stock_audit; ?>" class="btn btn-success btn-xs">
                                            CSV <i class="fa fa-download" aria-hidden="true"></i>
                                        </a>



                                    </div>
                                </div>
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
                                                <th><?= lang('invoice_no') ?></th>
                                                <th><?= lang('batch') ?></th>
                                                <th><?= lang('product') ?></th>
                                                <th><?= lang('product_category') ?></th>
                                                <th><?= lang('product_sub_category') ?></th>
                                                <th><?= lang('brand_name') ?></th>
                                                <th><?= lang('attributes') ?></th>
                                                <th><?= lang('supplier') ?></th>
                                                <th class="text-right"><?= lang('stock_qty') ?></th>
                                                <th class="text-right"><?= lang('actual_qty') ?></th>
                                                <th><?= lang('note') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $tot_qty = 0;
                                            $total = 0;
                                            if (!empty($stock_audit_list)) {
                                                foreach ($stock_audit_list as $list) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $list['invoice_no']; ?></td>
                                                        <td><?php echo $list['batch_no']; ?></td>
                                                        <td><?php echo $list['product_name']; ?></td>
                                                        <td><?php echo $list['cat_name']; ?></td>
                                                        <td><?php echo $list['sub_cat_name']; ?></td>
                                                        <td><?php echo $list['brand_name']; ?></td>
                                                        <td><?php echo $list['attribute_name']; ?></td>
                                                        <td><?php echo $list['supplier_name']; ?></td>
                                                        <td class="text-right"><?php echo $list['qty_db']; ?></td>
                                                        <td class="text-right"><?php echo $list['qty_store']; ?></td>
                                                        <td><?php echo $list['notes']; ?></td>
                                                    </tr>
                                            <?php
                                                    $i++;
                                                    $tot_qty += $list['qty_db'];
                                                    $total += $list['qty_store'];
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <th class="text-right" colspan="8"><?= lang("total"); ?></th>
                                            <th class="text-right"><?= $tot_qty; ?></th>
                                            <th class="text-right"><?= $total; ?></th>
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