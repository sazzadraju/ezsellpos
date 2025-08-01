<ul class="breadcrumb">
    <?php echo isset($breadcrumb) ? $breadcrumb : ''; ?>
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
                        <h6 class="element-header"><?= lang("transaction_invoices"); ?></h6>
                        <div class="row">
                            <form action="">
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="transaction_type"><?= lang('transaction_type') ?> </label>
                                        <div class="col-sm-12">
                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" name="transaction_type" id="transaction_type">
                                                    <?php foreach ($trx_wth_items as $trx) {?>
                                                        <option value="<?php echo $trx;?>"><?php echo uc_first($trx);?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="transaction_id"><?= lang('transaction_id') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('transaction_id') ?>" type="text" name="transaction_id" id="transaction_id" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2" id="invoice_no_dv">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="invoice_no"><?= lang('invoice_no') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('invoice_no') ?>" type="text" name="invoice_no" id="invoice_no" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="from_date"><?= lang('from_date') ?> </label>
                                        <div class="col-sm-12">
                                            <div class="input-group date from_date">
                                                <input class="form-control valid from_date" aria-invalid="false" type="text" name="from_date" id="from_date" placeholder="<?= lang('from_date') ?>">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>  
                                               </span> 
                                           </div>
                                           <span class="error" id="from_date-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="to_date"><?= lang('to_date') ?> </label>
                                        <div class="col-sm-12">
                                            <div class="input-group date to_date">
                                                <input class="form-control valid to_date" aria-invalid="false" type="text" name="to_date" id="to_date" placeholder="<?= lang('to_date') ?>">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>  
                                               </span> 
                                           </div>                        
                                        </div>
                                        <span class="error" id="to_date-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                   <div class="form-group row">
                                     <label class="col-sm-12 col-form-label"><?= lang("store"); ?></label>
                                     <div class="col-sm-12">
                                       <!-- <div class="row-fluid"> -->
                                         <select class="select2" data-live-search="true" id="store_id" name="store_id">
                                           <option value="0" selected><?= lang("select_one"); ?></option>
                                           <?php
                                           foreach ($stores as $store) {
                                                                           // if (empty($station->_id_station)) {
                                             echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                                           // }
                                           }

                                           ?>
                                         </select>
                                       </div>

                                       <!-- </div> -->
                                     </div>
                                   </div>

                                <div class="col-md-1">
                                    <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                    <button class="btn btn-primary btn-rounded center" type="button" onclick="searchFilter(0);"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content" id="result">
                                    <div class="table-responsive" id="transactions">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(function() {
    $('.from_date').datetimepicker({
        format: 'YYYY-MM-DD',
    });
    $('.to_date').datetimepicker({
        format: 'YYYY-MM-DD',
    });

    $('#transaction_type').on('change', function() {
        if($(this).val()=='customer' || $(this).val()=='supplier'){
            $('#invoice_no_dv').removeClass("disp-off");
        } else {
            $('#invoice_no_dv').addClass("disp-off");
        }
    })
});

function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
    $('#from_date-error').html("");
    $('#to_date-error').html("");
    var from_date=$('#from_date').val();
    var to_date=$('#to_date').val();
    $err_count=1;
    if (from_date == '') {
        $err_count = 2;
        $('#from_date-error').html("Please fill start Date");
    }
    if (to_date == '') {
        $err_count = 2;
        $('#to_date-error').html("Please fill end Date");
    }
    if ($err_count == 1) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>account-management/search-transaction-invoices/' + page_num,
            data: {
                trx_type : $('#transaction_type').val(),
                trx_id : $('#transaction_id').val(),
                inv_no : $('#invoice_no').val(),
                from_date : $('#from_date').val(),
                to_date : $('#to_date').val(),
                store_id : $('#store_id').val()
            },
            beforeSend: function () {
              $('.loading').show();
            },
            success: function (html) {
                $('.loading').fadeOut("slow");
                $('#transactions').html(html);
            }
        });
    }
}

</script>