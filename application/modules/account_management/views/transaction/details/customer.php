<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('trx_no'); ?></label>
    <div class="col-md-8" id=""><?php echo $trx_no;?></div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('type'); ?></label>
    <div class="col-md-8" id=""><?php echo get_key($qty_multipliers, $qty_multiplier); ?></div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('customer'); ?></label>
    <div class="col-md-8" id=""><?php echo $full_name;?></div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('amount_paid'); ?></label>
    <div class="col-md-8" id=""><?php echo set_currency(comma_seperator($tot_amount));?></div>
</div>
<?php if(isset($trx_details)):?>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('payment_details'); ?></label>
    <div class="col-md-8" id="">
        <table id="bank_acc_tbl" class="table table-bordred table-striped">
            <thead>
                <th class="fit"><?= lang("sl_no"); ?></th>
                <th class=""><?= lang("invoice_no"); ?></th>
                <th class="fit text-right"><?= lang("amount"); ?></th>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($trx_details as $item): ?>
                <tr>
                    <td class="fit"><?php echo $count; ?>.</td>
                    <td class=""><?php echo $item['invoice_no']; ?></td>
                    <td class="fit text-right"><?php echo set_currency(comma_seperator($item['amount'])); ?></td>
                </tr><?php
                $count++;
                endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<?php endif;?>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('payment_date'); ?></label>
    <div class="col-md-8" id=""><?php echo nice_date($dtt_trx);?></div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('description'); ?></label>
    <div class="col-md-8" id=""><?php echo $description;?></div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('account'); ?></label>
    <div class="col-md-8" id=""><?php echo get_val($payment_details[0]['account_name']);?></div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('payment_method'); ?></label>
    <div class="col-md-8" id=""><?php echo get_key($this->config->item('trx_payment_mehtods'), $payment_details[0]['payment_method_id']);?></div>
</div>
<?php if($payment_details[0]['payment_method_id']==4):?>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('bank'); ?></label>
    <div class="col-md-8" id=""><?php echo get_key($general_banks, $payment_details[0]['ref_bank_id']);?></div>
</div>
<?php endif;?>
<?php /*if($payment_details[0]['payment_method_id']==3):?>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('mobile_bank'); ?></label>
    <div class="col-md-8" id=""><?php echo get_key($mobile_banks, $ref_bank_id);?></div>
</div><?php endif;*/?>
<?php if($payment_details[0]['payment_method_id']==2):?>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('card'); ?></label>
    <div class="col-md-8" id=""><?php echo get_key($cards, $payment_details[0]['ref_card_id']);?></div>
</div>
<?php endif;?>
<?php if($payment_details[0]['payment_method_id']==2 || $payment_details[0]['payment_method_id']==3 || $payment_details[0]['payment_method_id']==4):?>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('account_card_no'); ?></label>
    <div class="col-md-8" id=""><?php echo get_val($payment_details[0]['ref_acc_no']);?></div>
</div>
<?php endif;?>
<?php if($payment_details[0]['payment_method_id']==2 || $payment_details[0]['payment_method_id']==3):?>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('ref_trx_no'); ?></label>
    <div class="col-md-8" id=""><?php echo get_val($payment_details[0]['ref_trx_no']);?></div>
</div>
<?php endif;?>

<div class="form-group row">
    <label class="col-sm-4 col-form-label"><?= lang('documents'); ?></label>
    <div class="col-md-8" id="">
        <?php if(isset($documents) && !empty($documents)):?>
        <table id="bank_acc_tbl" class="table table-bordred table-striped">
            <tbody>
                <?php
                $count = 1;
                foreach ($documents as $item): ?>
                <tr>
                    <td class="fit"><?php echo $count; ?>.</td>
                    <td>
                        <a href="<?php echo documentLink('transaction').$item['file']?>" target="_blank">
                            <?php echo !empty($item['name']) ? $item['name'] : $item['file']; ?>
                        </a>
                    </td>
                </tr><?php
                $count++;
                endforeach;?>
            </tbody>
        </table>
        <?php else: echo lang('not_available');?>
        <?php endif;?>
    </div>
</div>
