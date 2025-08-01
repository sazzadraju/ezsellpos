<table id="bank_acc_tbl" class="table table-bordred table-striped">
    <thead>
        <th class="fit"><?= lang("sl_no"); ?></th>
        <th class="fit"><?= lang("transaction_no"); ?></th>
        <th class="fit"><?= lang("invoice_number"); ?></th>
        <th class="fit"><?= lang("amount"); ?></th>
        <th><?= lang("type"); ?></th>
        <th><?= lang("supplier"); ?></th>
        <th><?= lang("date"); ?></th>
        <th><?= lang("description"); ?></th>
        <th><?= lang("store"); ?></th>
        <th class="center"><?= lang("action"); ?></th>
    </thead>
    <tbody>
        <?php
        if (!empty($transactions['items'])):
            $count = 1;
            foreach ($transactions['items'] as $item): 
                $payment = $this->trxmodel->getSupplierTrxPaymentGroup($item['trx_no']);
                ?>

                <tr>
                    <td class="fit"><?php echo ($offset+$count); ?>.</td>
                    <td><?php echo $item['trx_no']; ?></td>
                    <td><?php echo $item['inv_no']; ?></td>
                    <td class="fit"><?php echo set_currency(comma_seperator($payment[0]['tot_amount'])); ?></td>
                    <td><?php echo $payment[0]['type_name']; ?></td>
                    <td><?php echo $item['supplier_name']; ?></td>
                    <td><?php echo nice_date($item['transaction_date']); ?></td>
                    <td><?php echo substr($item['description'], 0, 60); ?></td>
                    <td><?php echo get_key($stores, $item['store_id']);?></td>
                    <td class="center fit">
                        <button rel="tooltip" title="<?= lang("view") ?>" class="btn btn-success btn-xs" data-title="<?= lang("view"); ?>" data-toggle="modal" data-target="#view" onclick="viewDetaitls('<?= $this->commonlib->encrypt_srting($item['id']);?>')"><span class="glyphicon glyphicon-eye-open"></span></button>
                        <button value="<?php echo  $item['id'];?>" class="btn btn-success btn-xs invoiceView"><span class="fa fa-print"></span></button>
                    </td>
                </tr>
                <?php $count++;
            endforeach;
        else: ?>
            <tr><td colspan="10" align="center"><b><?= lang("data_not_available"); ?></b></td></tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links();?>

<!--- View Modal BOX --->
<div id="view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("supplier_trx_details"); ?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="col-md-12" id="det-inf"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
            </div>
        </div>
    </div>
</div>
<!--- END of View Modal BOX --->


<script>
    $(document).on('click', '.invoiceView', function () {
    var oId = $(this).val();

    // print

    var w = window.open('<?php echo base_url().'transactions/supplier_print_invoice';?>/'+oId,'name','width=800,height=500', '_blank');
    w.print({
        globalStyles: false,
        mediaPrint: true,
        stylesheet: "<?= base_url(); ?>themes/default/css/a4_print_new.css",
        iframe: false,
        noPrintSelector: ".avoid-this"
    });

});
function viewDetaitls(id) {
    
    $.ajax({
        url: "<?php echo base_url() ?>account-management/supplier-trx-details/" + id,
        type: "GET",
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (data)
        {
            //console.log(data);
            $('#det-inf').html(data);
            $('.loading').fadeOut("slow");
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
</script>