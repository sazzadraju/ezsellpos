<style type="text/css">
    .text-center{text-align: center;}
    .table th{font-weight: bold; margin-right: 5px;}
    .text-right{ text-align: right; }
</style>
<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/bootstrap.min.css">
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <?php echo form_open_multipart('', array('id' => 'product', 'class' => 'cmxform')); ?>
                <div class="element-wrapper">
                    <table id="mytable" class="table table-bordered" style="border: 1px solid; margin-bottom:10px;">
                        <tr>
                            <td><b><?= lang('from_date') ?></b>: <?php echo $fdate; ?></td>
                            <td><b><?= lang('to_date') ?></b>: <?php echo $tdate; ?></td>
                            <td><b><?= lang('store') ?></b>:  
                                <?php if ($which_store == 0) {
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

                                } ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <table id="mytable" class="table table-bordered printTable" cellpadding="0" cellspacing="0" border="1">
            <thead>
            <tr>
                <th class="text-center"><?= lang("date"); ?></th>
                <th class="text-center"><?= lang("sale"); ?></th>
                <th class="text-center"><?= lang("vat"); ?></th>
                <th class="text-center">Sale+VAT</th>
                <th class="text-center">Total Discount</th>
                <th class="text-center">Total Sale</th>
            </tr>

            </thead>
            <tbody>
            <?php
            $sum_non_vat = 0;
            $sum_vat = 0;
            $total_dis = 0;
            $total = 0;
            $total_non_vat_sale=$total_non_vat=$total_sum_non_vat=$total_sale=$total_vat=$total_sum_sale=0;
            if (!empty($posts)):
                $count = 1;
                foreach ($posts as $post):
                    $date = date('Y-m-d', strtotime($post['dtt_add']));
                    $vat=$this->vat_report_model->get_sale_vat_product_total($date,$which_store);
                    $vat_sale=($vat!='')?$vat[0]['vat_sale']:0;
                    $vat_total=($vat!='')?$vat[0]['vat_total']:0;
                    ?>
                    <tr>
                        <?php
                        echo '<td class="text-center">' . $date . '</td>';
                        echo '<td class="text-right">' . $vat_sale . '</td>';
                        echo '<td class="text-right">' . $vat_total . '</td>';
                        echo '<td class="text-right">' . ($vat_sale+$vat_total) . '</td>';
                        $sum_vat = $vat_sale+$vat_total;
                        echo '<td class="text-right">' . $post['total_discount'] . '</td>';
                        $val=($sum_non_vat+$sum_vat)-$post['total_discount'];
                        echo '<td class="text-right">' . $val . '</td>';
                        $total+=$val;
                        $total_dis+=$post['total_discount'];
                        $total_sale+=$vat_sale;
                        $total_vat+=$vat_total;
                        $total_sum_sale+= ($vat_sale+$vat_total) ;
                        ?>
                    </tr>
                    <?php
                    $count++;
                endforeach;
            else:
                ?>
                <tr>
                    <td colspan="6"><b><?= lang("data_not_available"); ?></b></td>
                </tr>
            <?php endif; ?>
            </tbody>
            <tfoot>
            <th col class="right_text"><?= lang("total"); ?></th>
            <th class="right_text"><?=  $total_sale; ?></th>
            <th class="right_text"><?=  $total_vat; ?></th>
            <th class="right_text"><?=  $total_sum_sale; ?></th>
            <th class="right_text"><?=  $total_dis; ?></th>
            <th class="right_text"><?= ($total); ?></th>
            </tfoot>
        </table>
        <div class="clearfix"></div>
        <?php echo $this->ajax_pagination->create_links(); ?>


