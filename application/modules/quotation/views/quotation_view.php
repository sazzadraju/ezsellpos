<?php 
    function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }
?>
<ul class="breadcrumb">
    <?php
        echo $this->breadcrumb->output();
    ?>
</ul>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <div class="element-box full-box">

                        <h6 class="element-header"><?= lang("quotation_list"); ?></h6>
                        <div class="row">
                            <?php
                                // echo '<pre>';
                                // print_r($qMaster);
                                // print_r($qDetails);
                                // echo '</pre>';
                            ?>
                            <div class="col-md-4">

                                <div class="billing-des">
                                    <strong class="text-label"><?= lang("details"); ?></strong>
                                    <p>
                                        <strong><?= lang("cusmtomer_name"); ?>:</strong>
                                        <?php echo $qMaster[0]['full_name'];?>
                                    </p>
                                    <p>
                                        <strong><?= lang("quotation_no"); ?>:</strong>
                                        <?php echo $qMaster[0]['quotation_no'];?>
                                    </p>
                                    <p><strong><?= lang("quotation_date"); ?>:</strong>
                                        <?php echo $qMaster[0]['dtt_add'];?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="billing-des">
                                    <strong class="text-label"><?= lang("description"); ?></strong>
                                    <span>
                                        <?php echo $qMaster[0]['note'];?>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive bg service-list-table">
                                    <h3 class="element-header"><?= lang("quotation_list"); ?></h3>
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?= lang("product_name"); ?></th>
                                                <th><?= lang("code"); ?></th>
                                                <th><?= lang("batch"); ?></th>
                                                <th><?= lang("stock"); ?></th>
                                                <th><?= lang("qty"); ?></th>
                                                <th><?= lang("buy_price"); ?></th>
                                                <th><?= lang("sell_price"); ?></th>
                                                <th><?= lang("discount"); ?></th> 
                                                <th><?= lang("vat"); ?>(%)</th>
                                                <th><?= lang("total"); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i = 0;
                                                foreach($qDetails as $aDetail):
                                            ?>
                                                <tr>
                                                    <td><?php echo ($i+1);?></td>
                                                    <td><?php echo $aDetail['product_name'];?></td>
                                                    <td><?php echo $aDetail['product_code'];?></td>
                                                    <td>
                                                        <?php
                                                            $bn = $aDetail['batch_no'];
                                                            if($bn != '0000'){
                                                                echo $bn;
                                                            }else{
                                                                echo '--';
                                                            }
                                                        ?> 
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $s_qty = $aDetail['s_qty'];
                                                            if(!empty($s_qty)){
                                                                echo $s_qty;
                                                            }else{
                                                                echo '--';
                                                            }
                                                        ?> 
                                                    </td>
                                                    <td><?php echo $aDetail['qty'];?></td>
                                                    <td>
                                                        <?php 
                                                            $bn = $aDetail['batch_no'];
                                                            if($bn != '0000'){
                                                                echo set_currency($aDetail['s_purchase_price']);
                                                            }else{
                                                                echo set_currency($aDetail['p_buy_price']);
                                                            }
                                                        ?> 
                                                    </td>
                                                    <td>
                                                        <?php echo set_currency($aDetail['selling_price']);?>
                                                    </td>
                                                    <td>
                                                        <?php echo set_currency($aDetail['discount_amt']);?>
                                                        <?php echo '('.$aDetail['discount_rate'].' %)';?>
                                                    </td>
                                                    <td>
                                                        <?php //echo $aDetail['vat_amt'];?>    
                                                        <?php 
                                                           $vrate = $aDetail['vat_rate'];;
                                                           if(!empty($vrate)){
                                                                $vrate = set_currency($vrate);
                                                           }else{
                                                                $vrate = set_currency(0.00);
                                                           }
                                                        ?>   
                                                    </td>
                                                    <td>
                                                        <?php echo set_currency($aDetail['total_amt']);?>
                                                    </td>

                                                </tr>
                                                <?php $i++; endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h3>History</h3>
                                <ul>
                                    <?php 
                                    foreach($all_quotation as $aQuot):
                                        if($id!=$aQuot['id_quotation']){
                                            ?>
                                            <li><a href="<?php echo base_url().'quotation/view/'.$aQuot['id_quotation'];?>"><?php echo ordinal($aQuot['rivision_no']);?> version (<?php echo $aQuot['dtt_add'];?>)</a></li>
                                        <?php
                                        }else{
                                           echo '<li>' .ordinal($aQuot['rivision_no']).'version ('. $aQuot['dtt_add'].')'.'</li>';
                                        }
                                    ?>
                                    
                                    <?php endforeach;?>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="billing-des billing-des-fix-top border-top-0">    
                                    <div class="bill-group">          
                                        <p class="ttl-amnt"><strong class="ttl-amnt">Sub Total:</strong><?php echo set_currency($qMaster[0]['product_amt']);?></p>    
                                        <p><strong>Discount:</strong><?php echo set_currency($qMaster[0]['discount_amt']);?></p> 
                                        <p class="ttl-amnt"><strong class="ttl-amnt">Total:</strong><?php echo set_currency($qMaster[0]['total_amt']);?></p>
                                    </div>
                                </div>

                                <button value="<?php echo $qMaster[0]['id_quotation'];?>" type="button" id="printQuotation" class="btn btn-primary"><?= lang("print-view"); ?></button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url()?>themes/default/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).on('click', '#printQuotation', function () {
        var qId = $(this).val();
        // print
        var w = window.open('<?php echo base_url().'quotation/print';?>/'+qId,'name','width=800,height=500', '_blank');
        w.print({
            globalStyles: false,
            mediaPrint: true,
            stylesheet: "<?= base_url(); ?>themes/default/css/tailoring_order_invoice.css",
            iframe: false,
            noPrintSelector: ".avoid-this"
        });
    });
</script>