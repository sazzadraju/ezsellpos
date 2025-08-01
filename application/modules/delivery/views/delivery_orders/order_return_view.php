<style type="text/css">
    .error-custom{
        border-color: red;
    }

</style>
<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>
<div class="col-md-12">
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            if (!empty($sales)) {
                                ?>
                                <form action="" class="sales-form" id="temp_add_sales_return" method="post">
                                    <div class="table-responsive">
                                        <div id="show_errors"></div>

                                        <p class="invoice-no">
                                        Invoice: <?= $invoices[0]['invoice_no'] ?>
                                        </p>
                                        <p><?= lang("delivery_type"); ?>: <?= $agent[0]['delivery_name'] ?></p>
                                        <p><?= lang("agent_name"); ?>: <?= $agent[0]['agent_name'] ?></p>
                                        <?php 
                                        $person=($agent[0]['type_id']==2)?$agent[0]['person_name']:$agent[0]['fullname'];
                                        ?>
                                        <p>Delivery Persone: <?= $person ?></p>
                                        <p>Delivery Address: <?= $agent[0]['delivery_address'] ?></p>
                                        <p>CusID/Name: <?= $invoices[0]['customer_name'] ?></p>
                                        <p>Customer Mobile: <?= $invoices[0]['customer_mobile'] ?></p>

                                        <table id="addSection" class="table table-bordred table-striped">
                                            <thead>
                                            <th>Serial</th>
                                            <th>Product name</th>
                                            <th>Batch</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th>Discount(Tk)</th>
                                            <th>vat(Tk)</th>
                                            <th>Total Price</th>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $count = 1;
                                            $total = 0;
                                            $check = 0;
                                            foreach ($posts as $post) {
                                                ?>
                                                <tr>
                                                    <td><?= $count ?></td>
                                                    <td><?= $post->product_name ?><br><?= $post->product_code ?></td>
                                                    <td><?= $post->batch_no ?></td>
                                                    <td align="center"><?= number_format($post->qty, 0) ?> <input type="hidden" name="qty[]" id="qty_<?= $count ?>" value="<?= number_format($post->qty, 0) ?>"></td>
                                                    <td><?= $post->selling_price_est / $post->qty ?></td>
                                                    <td><?= number_format($post->selling_price_est) ?></td>
                                                    <td>
                                                        <?php
                                                        $dis_rate_val = $post->discount_amt;
                                                        echo $dis_rate_val
                                                        ?>
                                                    </td>
                                                    <td><?= number_format(($post->vat_amt), 2) ?></td>
                                                    <td class="text-right"><?= $post->selling_price_act ?></td>
                                                </tr>

                                                <?php
                                                $count++;
                                                $check++;
                                                $total = $total + $post->selling_price_act;
                                            }
                                            ?>

                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 pull-right">
                                            <div class="row">
                                                <div class="col-md-8 bold">
                                                    <div>
                                                        Sub Total
                                                    </div>
                                                </div>

                                                <div class="col-md-4 bold">

                                                    <div class="text-right"><input type="hidden" name="cart_total[]" value="<?= $total ?>">
                                                        <?= number_format($total,2) ?>
                                                    </div>
                                                </div>

                                                <?php
                                                $types = $this->config->item('promotion_type_sales');
                                                if (!empty($promotions)) {
                                                    foreach ($promotions as $promo) {
                                                        $type_id = $promo->promotion_type_id;
                                                        ?>
                                                        <div class="col-md-8">
                                                            <div>
                                                                <input type="hidden" name="dis_type[]" value="<?= $type_id ?>">
                                                                <?= $types[$type_id] . ' ' . number_format($promo->discount_rate, 2) . '%' ?>
                                                                <input type="hidden" name="dis_rate[]"
                                                                       value="<?= number_format($promo->discount_rate, 0) ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="text-right">
                                                                (-) <?= $promo->discount_amt ?>
                                                                <input type="hidden" name="dis_amt[]" value="<?= $promo->discount_amt ?>">
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <div class="col-md-8 bold">
                                                    <div>
                                                        Total
                                                    </div>
                                                </div>
                                                <div class="col-md-4 bold">
                                                    <div class="text-right" style="font-size:16px;">
                                                        <?php 
                                                        $g_total= $sales[0]['tot_amt'];
                                                        echo $g_total; ?>
                                                        <input type="hidden" name="total_invoice_amt" value="<?= $g_total ?>">
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-md-8">
                                                    <div>
                                                        Round
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-right">
                                                        <?= $sales[0]['round_amt'] ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 bold size-inc">
                                                    <div>
                                                        Return Amount
                                                    </div>
                                                </div>
                                                <div class="col-md-4 bold size-inc">
                                                    <div class="text-right">
                                                        <?= $sales[0]['tot_amt'] ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 bold">
                                                    <div>
                                                        Delivery Charge
                                                    </div>
                                                </div>
                                                <div class="col-md-4 bold">
                                                    <div class="text-right">
                                                        <?= $delivery[0]['tot_amt'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 pull-right">
                                            <input type="hidden" name="sale_id" value="<?=$sales[0]['id_sale']?>">
                                            <input type="hidden" name="order_id" value="<?= $delivery[0]['id_delivery_order']?>">
                                            <button type="button" class="btn btn-primary" data-title="Delete" data-toggle="modal" rel="tooltip" title="<?= lang("delete") ?>" data-target="#deleteModal"  name="temp_add_return">Sale Return</button>
                                        </div> 
                                    </div>
                                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    <h4 class="modal-title custom_align" id="Heading">Sale Return Confirmation</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Customer Final Invoice Amount is Return Amount and will be Deducted From the Primary Account Cash Account. And Product will be added on Stock. Do you want to proceed ?</div>

                                                </div>
                                                <div class="modal-footer ">
                                                    <input type="hidden" name="delete_cus_id" id="delete_cus_id">
                                                    <button class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang('yes') ?></button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang('no') ?></button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    
                                </form>
                                <?php
                            } else { ?>
                                <div class="alert alert-danger">No data found</div>
                                <?php
                            }
                            ?>
                                                        
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $("#temp_add_sales_return").submit(function () {
        $('#show_errors').html('');
        if (validate_data() != false) {
            var $html = '';
            var dataString = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>delivery/delivery_orders/add_sale_return',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    var result = $.parseJSON(result);
                    $('.loading').fadeOut("slow");
                    if (result.status == 'success') {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>delivery-orders";

                        }, 1000);
                    } else {
                        alert('Submit Error');
                    }
                    return false;
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
    });

    function validate_data() {
       return true;
    }
</script>
