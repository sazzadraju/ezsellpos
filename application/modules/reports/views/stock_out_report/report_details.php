<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-10">
                <?php echo form_open_multipart('', array('id' => 'product', 'class' => 'cmxform')); ?>
                <div class="element-wrapper">
                    <div class="full-box element-box">
                        <div class="row">
                            <?php
                            $invoice = '';
                            if (!empty($invoice_details)):
                                foreach ($invoice_details as $post):
                                    $invoice = $post ['invoice_no'];
                                    break;
                                endforeach;
                            endif;
                            ?>
                            <label class="col-sm-4 col-form-label" for=""><?= lang('invoice_no') ?>
                                : <?php echo $invoice; ?> </label>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary pull-right" type="button"
                        onclick="searchFilter3('<?php echo $invoice ?>')"><i
                        class="fa fa-view"></i> <?= lang("print-view"); ?></button>
            </div>
        </div>

        <table id="mytable" class="table table-bordred table-striped">
            <thead>
            <th><?= lang("product_name"); ?></th>
            <th><?= lang("attributes"); ?></th>
            <th><?= lang("batch_no"); ?></th>
            <th><?= lang("store_name"); ?></th>
            <th><?= lang("purchase_price"); ?></th>
            <th><?= lang("qty"); ?></th>
            <th><?= lang("note"); ?></th>
            <th><?= lang("expire_date"); ?></th>

            </thead>
            <tbody>
            <?php
            if (!empty($invoice_details)):
                // pa($invoice_details);
                $count = 1;
                $total = 0;
                foreach ($invoice_details as $post):
                    ?>
                    <tr>
                        <?php
                        $product_name = '';
                        foreach ($product as $products) {
                            if ($products->id_product == $post['product_id']) {
                                $product_name = $products->product_name;
                                break;
                            }
                        }
                        echo '<td>' . $product_name . '</td>';
                        $store_name = '';
                        foreach ($stores as $store) {
                            if ($store->id_store == $post['store_id']) {
                                $store_name = $store->store_name;
                                break;
                            }
                        }
                        echo '<td>' .$post['attribute_name'] . '</td>';
                        echo '<td>' . $post['batch_no'] . '</td>';
                        echo '<td>' . $store_name . '</td>';
                        echo '<td>' . $post['purchase_price'] . '</td>';
                        echo '<td>' . $post['qty'] . '</td>';
                        echo '<td>' . $post['notes'] . '</td>';
                        echo '<td>' . $post['expire_date'] . '</td>';
                        ?>
                    </tr>
                    <?php
                    $count++;
                endforeach;
                ?>

                <?php
            else:
                ?>
                <tr>
                    <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <div class="clearfix"></div>
        <?php echo $this->ajax_pagination->create_links(); ?>
        <script type="text/javascript">

            function searchFilter3(id) {

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>stock-out-report/print-data/' + id,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (html) {
                        console.log(html);
                        $('#postList').html(html);
                        $('.loading').fadeOut("slow");
                    }
                });
            }
        </script>
