<table id="bank_acc_tbl" class="table table-bordred table-striped">
    <thead>
    <tr>
        <th class="text-center"><?= lang("invoice"); ?></th>
        <?php /*?><th><?= lang("date"); ?></th><?php */?>
        <th class="text-center"><?= lang("total"); ?></th>
        <th class="text-center"><?= lang("due"); ?></th>
        <th class="text-center"><?= lang("pay"); ?></th>
        <th class="text-center"><?= lang("settle"); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($unpaid_purchases)):
        $count = 1;
        $td=0;
        foreach ($unpaid_purchases as $up):?>
        <tr>
            <td><?=$up['invoice_no'];?></td>
            <?php /*?><td><?php echo nice_date($up['dtt_receive']); ?></td><?php */?>
            <td class="text-right"><?=$up['tot_amt'];?></td>
            <td class="text-right" id="tot_d_<?=$count;?>"><?=$up['due_amt'];?></td>
            <td>
                <input class="form-control text-right pay_amt_cls" type="text" name="pay_amt[]" id="pay_amt_<?=$count;?>" onkeypress="return amountInpt(this,event);">
            </td>
            <td>
                <input class="form-control checkbox" type="checkbox" name="settle_<?=$count?>" id="id_settle_<?=$count;?>" value="<?=$count?>">
                <label for="id_settle_<?=$count;?>">&nbsp;</label>
                <input type="hidden" name="param[]" id="param_<?=$count;?>" value="<?=$up['params'];?>" />
                <input type="hidden" name="settle[]" id="settle_<?=$count;?>" value="0" />
            </td>
        </tr><?php
        $count++;
            $td+=$up['due_amt'];
        endforeach;?>
        <tr>
            <td colspan="2" class="text-right" ><b>Total Due:</b></td>
            <td class="text-right" ><b><?=$td?></b></td>
            <td>
                <input type="text" readonly class="form-control text-right" name="pay_amt_tot" id="pay_amt_tot" value="" >
                <label id="pay_amt_tot-error" class="error" for="pay_amt_tot"></label>
            </td>
        </tr> 
    <?php else:?>
        <tr>
            <td colspan="4"><?=lang('data_not_available');?></td>
        </tr> 
    <?php endif; ?>
    </tbody>
</table>


<script>
$(document).ready(function(){
    $('.checkbox').change(function() {
        var id=this.value;
        if(this.checked) {
           $('#settle_'+id).val('1'); 
        }else{
            $('#settle_'+id).val('0'); 
        }
        //$('#textbox1').val(this.checked);        
    });
    $('input.pay_amt_cls').on('input', function(e){
        var tot = 0;
        $('input.pay_amt_cls').each(function() {
            var val = parseFloat($(this).val());
            var ids=$(this).attr('id');
            var id = ids.split('_').pop(-1);
            var due=$('#tot_d_'+id).html();
            $('#pay_amt_' + id).removeClass("error");
            if(val>due){
                $('#pay_amt_' + id).addClass("error");
            }
            if(!isNaN(val)){
                tot += val;
            }
        });
        $('#pay_amt_tot').val(tot.toFixed(2));
    });
});
</script>