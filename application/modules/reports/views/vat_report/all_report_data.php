<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <?php echo form_open_multipart('', array('id' => 'product', 'class' => 'cmxform')); ?>
                <div class="element-wrapper">
                    <div class="full-box element-box">
                        <div class="row">
                            <!--  <b>Showing Result For <?php echo $fdate; ?>   To <?php echo $tdate ?> For Store : All</b> -->
                            <label class="col-sm-4 col-form-label" for=""><?= lang('from_date') ?>
                                : <?php echo $fdate; ?></label>
                            <label class="col-sm-4 col-form-label" for=""><?= lang('to_date') ?>
                                : <?php echo $tdate; ?></label>
                            <label class="col-sm-4 col-form-label" for=""><?= lang('store') ?>
                                : <?php if ($which_store == 0) {
                                    echo lang('all_store');
                                } else {
                                    $store_name = '';
                                    foreach ($store as $stores) {
                                        if ($stores->id_store == $which_store) {
                                            $store_name = $stores->store_name;
                                            break;
                                        }
                                    }
                                    echo $store_name;

                                } ?></label>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <table id="mytable" class="table table-bordred table-striped">
            <thead>
            <tr>
               <th rowspan="2" class="text-center"><?= lang("date"); ?></th>
                <th colspan="3" class="text-center">Non VAT Sale</th>
                <th colspan="3" class="text-center">Sale With VAT</th>
                <th rowspan="2" class="text-right">Total Dis.</th>
                <th rowspan="2" class="text-right">Total Sale+VAT</th>
            </tr>
            <tr>
                <th class="text-right"><?= lang("sale"); ?></th>
                <th class="text-right"><?= lang("vat"); ?></th>
                <th class="text-right">Sale+VAT</th>
                <th class="text-right"><?= lang("sale"); ?></th>
                <th class="text-right"><?= lang("vat"); ?></th>
                <th class="text-right">Sale+VAT</th>
            </tr>

            </thead>
            <tbody>
            <?php
            $sum_non_vat = 0;
            $sum_vat = 0;
            $total = 0;
            if (!empty($posts)):
                $count = 1;
                foreach ($posts as $post):
                    $date = date('Y-m-d', strtotime($post['dtt_add']));
                    $nonVat=$this->vat_report_model->get_sale_nonVat_product_total($date);
                    $non_vat_sale=($nonVat!='')?$nonVat[0]['vat_sale']:0;
                    $non_vat_total=($nonVat!='')?$nonVat[0]['vat_total']:0;
                    $vat=$this->vat_report_model->get_sale_vat_product_total($date);
                    $vat_sale=($vat!='')?$vat[0]['vat_sale']:0;
                    $vat_total=($vat!='')?$vat[0]['vat_total']:0;
                    ?>
                    <tr>
                        <?php

                        echo '<td class="text-center">' . $date . '</td>';
                        echo '<td class="text-right">' . $non_vat_sale . '</td>';
                        echo '<td class="text-right">' . $non_vat_total . '</td>';
                        echo '<td class="text-right">' . ($non_vat_sale+$non_vat_total) . '</td>';
                        $sum_non_vat += $non_vat_sale+$non_vat_total;
                        echo '<td class="text-right">' . ((int)$vat_sale - (int)$vat_total) . '</td>';
                        echo '<td class="text-right">' . $vat_total . '</td>';
                        echo '<td class="text-right">' . ($vat_sale+$vat_total) . '</td>';
                        $sum_non_vat += $vat_sale+$vat_total;
                        echo '<td class="text-right">' . $post['total_discount'] . '</td>';
                        $val=($sum_non_vat+$sum_vat)-$post['total_discount'];
                        echo '<td class="text-right">' . $val . '</td>';
                        $total+=$val;
                        ?>
                    </tr>
                    <?php
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
            <th colspan="7"></th>
            <th class="right_text"><?= lang("total"); ?></th>
            <th class="right_text"><?= set_currency($total); ?></th>
            </tfoot>
        </table>

        <div class="clearfix"></div>
        <?php echo $this->ajax_pagination->create_links(); ?>


