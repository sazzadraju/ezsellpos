<ul class="breadcrumb">
    <?php
        echo $this->breadcrumb->output();
    ?>
</ul>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <h6 class="element-header"><?= lang("quotation_edit"); ?></h6>
            </div>
            <div class="col-sm-12">
                <div class="element-box full-box">
                    <form id="quotationForm">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="col-form-label" for=""><?= lang("customer_name"); ?></label>
                                <select name="customerId" class="form-control">
                                    <?php 
                                        foreach($all_customer as $aCustomer):
                                           $cid = $aCustomer['id_customer'];
                                           $scid = $qMaster[0]['customer_id'];
                                    ?>
                                        <option value="<?php echo $cid;?>" <?php if($cid == $scid){ echo 'selected';}?>><?php echo $aCustomer['full_name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label" for=""><?= lang("quotation_no"); ?></label>
                                <input class="form-control" name="quotationNo" value="<?php echo $qMaster[0]['quotation_no'];?>" type="text" readonly >
                            </div>
                        </div>  
                        <div class="form-group row">
                            <div class="col-sm-8"> 
                                    <label class="col-sm-12 col-form-label"><?= lang("select_search_type"); ?></label>
                                    <div class="col-sm-6">
                                        <input type="radio" id="stockSearch" name="spSearch" value="1" checked="">
                                        <label for="stockSearch"><?= lang("search_from_stock"); ?></label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="radio" id="productSearch" name="spSearch" value="2" >
                                        <label for="productSearch"><?= lang("search_from_product"); ?></label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="product_name" id="product_name" onkeyup="product_list_suggest(this);" placeholder="Search...">    
                                        <input type="hidden" id="product_id" name="product_id" value="">
                                        <input type="hidden" id="batch_no" name="batch_no" value="">
                                        <div class="pmsg"></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary btn-rounded" onclick="addNewRow()" type="button"><i class="fa fa-plus"></i></button>
                                    </div>
                            </div>   
                        </div> 
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                <table id="addSection" class="table table-bordred table-striped sales_table">
                                    <thead>
                                        <tr>
                                            <th><?= lang("product_name"); ?></th>
                                            <th><?= lang("code"); ?></th>
                                            <th><?= lang("batch"); ?></th>
                                            <th><?= lang("stock"); ?></th>
                                            <th><?= lang("qty"); ?></th>
                                            <th><?= lang("buy_price"); ?></th>
                                            <th><?= lang("sell_price"); ?></th>
                                            <th>
                                                <?= lang("discount"); ?> <br>
                                                <select id="discountType" onchange="dTypeChn(this)">
                                                    <option value="1">Amt</option>
                                                    <option value="2">%</option>
                                                </select>
                                            </th>                                            
                                            <th>
                                                <?= lang("vat"); ?><br>
                                                <select id="vatType" onchange="vatTypeChn(this)">
                                                    <option value="1">%</option>
                                                    <option value="2">Amt</option>
                                                </select>
                                            </th>
                                            <th><?= lang("total"); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($qDetails as $aDetail):

                                            $uid = $aDetail['product_id'].'_'.$aDetail['batch_no'];
                                        ?>
                                        <tr id="<?php echo $uid;?>">
                                            <!-- Hidden fields -->
                                            <input type="hidden" name="uniqueFld[]" value="<?php echo $uid;?>">
                                            <input type="hidden" name="id_product[]" value="<?php echo $aDetail['product_id'];?>">
                                            <input type="hidden" name="batch_no[]" value="<?php echo $aDetail['batch_no'];?>">
                                            <!-- Product name -->
                                            <td><?php echo $aDetail['product_name'];?></td>
                                            <!-- Code -->
                                            <td><?php echo $aDetail['product_code'];?></td>
                                            <!-- Batch -->
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
                                            <!-- Stock -->
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
                                            <!-- Qty --> 
                                            <td>                                                
                                                <input pid="<?php echo $aDetail['product_id'];?>" bno="<?php echo $aDetail['batch_no'];?>" type="text" style="width: 50px" id="qty_<?php echo $uid;?>" name="qty[]" value="<?php echo $aDetail['qty'];?>">    
                                            </td>
                                            <!-- buy price -->
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
                                            <!-- sell price -->
                                            <td>                                                
                                                <input pid="<?php echo $aDetail['product_id'];?>" bno="<?php echo $aDetail['batch_no'];?>" type="text" style="width: 60px" id="sell_price_<?php echo $uid;?>" name="sell_price[]" value="<?php echo $aDetail['selling_price'];?>">    
                                            </td>
                                            <!-- Discount -->
                                            <td>
                                                <div class="disAmt" style="">
                                                    <input pid="<?php echo $aDetail['product_id'];?>" bno="<?php echo $aDetail['batch_no'];?>" type="text" style="width: 45px" id="discountA_<?php echo $uid;?>" name="discountA[]" value="<?php echo $aDetail['discount_amt'];?>"><strong></strong>
                                                </div>
                                                <div class="disPer" style="display: none">
                                                    <input pid="<?php echo $aDetail['product_id'];?>" bno="<?php echo $aDetail['batch_no'];?>" type="text" style="width: 45px" id="discountP_<?php echo $uid;?>" name="discountP[]" value="<?php echo $aDetail['discount_rate'];?>"><strong></strong>
                                                </div> 
                                            </td>
                                            <!-- Vat(%) -->
                                            <td>
                                                <?php //echo $aDetail['vat_amt'];?>    
                                                <?php 
                                                   $vrate = $aDetail['vat_rate'];
                                                   if(!empty($vrate)){
                                                        $vrate = $vrate;
                                                   }else{
                                                        $vrate = 0.00;
                                                   }

                                                   $vAmt = $aDetail['vat_amt'];
                                                   if(!empty($vAmt)){
                                                        $vAmt = $vAmt;
                                                   }else{
                                                        $vAmt = 0.00;
                                                   }
                                                ?>               
                                                <!-- <input type="text" style="width: 60px" id="aVat_<?php echo $uid;?>" name="aVat[]" value="<?php echo $vrate;?>" readonly="">  -->

                                                <div class="vatPer">
                                                    <input type="text" style="width: 45px" id="aVat_<?php echo $uid;?>" name="aVat[]" value="<?php echo $vrate;?>" readonly=""> 
                                                </div>
                                                <div class="vatAmt" style="display: none;">
                                                    <input type="text" style="width: 45px" id="vat_amt_<?php echo $uid;?>" name="vat_amt[]" value="<?php echo $vAmt;?>" readonly=""> 
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" style="width: 60px" id="total_price_<?php echo $uid;?>" name="total_price[]" value="<?php echo $aDetail['total_amt'];?>" readonly="">  
                                            </td>
                                            <td>
                                                <a pid="<?php echo $aDetail['product_id'];?>" bno="<?php echo $aDetail['batch_no'];?>" class="close-button" onclick="temp_remove_product(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                          <td colspan="6"></td>  
                                          <td colspan="3"><?= lang("sub_total"); ?></td>
                                          <td colspan="2"><input type="text" style="width: 60px" name="subTotal" value="<?php echo $qMaster[0]['product_amt'];?>" readonly=""></td>
                                        </tr>
                                        <tr>
                                          <td colspan="6"></td>  
                                          <td colspan="1"><?= lang("discount"); ?></td>  
                                          <td colspan="1">
                                                <select id="totDisountType" onchange="totDisTypeCng(this)">
                                                    <option value="1">Amt</option>
                                                    <option value="2">%</option>
                                                </select>
                                          </td>  
                                          <td colspan="1">
                                                <input style="width: 60px" type="text" id="totDisAmt" name="totDisAmt" value="<?php echo $qMaster[0]['discount_amt'];?>">
                                                <!-- <input style="width: 60px" type="text" id="totDisPer" name="totDisPer" value="<?php echo $qMaster[0]['product_amt'];?>"> -->
                                          </td>
                                          <td colspan="2">
                                            <input style="width: 60px" type="text" name="finalTotDisAmt" value="<?php echo $qMaster[0]['discount_amt'];?>" readonly="">
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="6"></td>  
                                          <td colspan="3"><?= lang("total"); ?></td>
                                          <td colspan="2"><input style="width: 60px" type="text" name="finalTotAmt" readonly="" value="<?php echo $qMaster[0]['total_amt'];?>"></td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for=""><?= lang("note"); ?></label>
                            <div class="col-sm-12">
                                <textarea name="note" class="form-control" rows="6"><?php echo $qMaster[0]['note'];?></textarea>
                            </div>
                        </div>    
                        <button type="submit" id="addQuotation" class="btn btn-primary"><?= lang("add_quotation"); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_this_entry"); ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?= lang("confirm_delete"); ?></div>

            </div>
            <div class="modal-footer ">
                <button sid="" id="deleteEmi" type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span><?= lang("yes"); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span><?= lang("no"); ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url()?>themes/default/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    function product_list_suggest(elem) {
        var request = $('#product_name').val();

        var cb = $("input[name='spSearch']:checked").val();

        if(cb == 1){
            $("#product_name").autocomplete({
                source: "<?php echo base_url(); ?>quotation/get_available_stock_in_products?request=" + request,
                focus: function (event, ui) {
                    event.preventDefault();
                    $("#product_name").val(ui.item.label);
                },
                select: function (event, ui) {
                    event.preventDefault();
                    $("#product_id").val(ui.item.value);
                    $("#product_name").val(ui.item.label);
                    $("#batch_no").val(ui.item.batch_no);      
                    $('.pmsg').hide();          
                }
            });
        }else if(cb == 2){
            $("#product_name").autocomplete({
                source: "<?php echo base_url(); ?>quotation/get_all_products?request=" + request,
                focus: function (event, ui) {
                    event.preventDefault();
                    $("#product_name").val(ui.item.label);
                },
                select: function (event, ui) {
                    event.preventDefault();
                    $("#product_id").val(ui.item.value);
                    $("#product_name").val(ui.item.label);     
                    $('.pmsg').hide();         
                }
            });
        }

            
    }
    function addNewRow(){

        var cb = $("input[name='spSearch']:checked").val();
        var product_id = $("#product_id").val();
        var batch_no = $("#batch_no").val();
        var disType = $("#discountType").val();

        if(batch_no){
            var uval = product_id+'_'+batch_no;
        }else{
            var uval = product_id+'_0000';
        }
        var notMatch = true;
        $('input[name^="uniqueFld"]').each(function() {
            var nuval = $(this).val();
            if(uval == nuval){
                notMatch = false;
            }
        });

        if(product_id){
            if(notMatch){    
                $.ajax({
                    url: "<?php echo base_url().'quotation/QuotationAddRow';?>",
                    type: "post",
                    data: {cb : cb, product_id : product_id, batch_no : batch_no, disType: disType},
                    success: function(res) {  
                        var rowCount = $('#addSection tbody tr').length;
                        if(rowCount > 0){
                            $('#addSection tbody tr:last').after(res);
                        }else{
                            $('#addSection tbody').append(res);
                            $('#addSection tfoot').show();
                        }
                        $("#product_id").val('');
                        $("#batch_no").val('');
                        $("#product_name").val('');
                    }
                });
            }else{
                $('.pmsg').show();
                $('.pmsg').html('<span class="error"><?= lang("product_exist_list"); ?></span>');
            }    
        }else{
            $('.pmsg').show();
            $('.pmsg').html('<span class="error"><?= lang("search_select_product"); ?></span>');
        }

        

    }
    function temp_remove_product(res) {
         var pid = res.attributes.pid.value;
         var bno = res.attributes.bno.value;
         var rowCount = $('#addSection tbody tr').length;

         if(rowCount == 0){
            $('#addSection tfoot').hide();
         }else{
            var total_price     = $('#total_price_'+pid+'_'+bno).val();
            var subTotal        = $('input[name="subTotal"]').val();
            var finalTotDisAmt  = $('input[name="finalTotDisAmt"]').val();
            var finalTotAmt     = $('input[name="finalTotAmt"]').val();
            subTotal = Number(subTotal)-Number(total_price);
            $('input[name="subTotal"]').val(subTotal);
            var totDisPer = (Number(finalTotDisAmt)*100)/Number(subTotal);
            $('input[name="totDisPer"]').val(totDisPer);
            finalTotAmt = Number(finalTotAmt)-Number(total_price);
            $('input[name="finalTotAmt"]').val(finalTotAmt);   
         }

         $('#'+pid+'_'+bno).closest('tr').remove();

    }

    function dTypeChn(sel){
        var did = sel.value;
        if(did == 1){
            $('.disAmt').show();
            $('.disPer').hide();
        }else{
            $('.disAmt').hide();
            $('.disPer').show();
        }
    }

    
    // $(function () {
    //     $('#totDisPer').hide();
    //     $('#addSection tfoot').hide();
    // })

    // quantity, sell_price change update
   
    $(document).on('keyup', 'input[name^="qty"], input[name^="sell_price"]', function(){   

        var pid = $(this).attr('pid');
        var bno = $(this).attr('bno');

        var qty = $('#qty_'+pid+'_'+bno).val();
        var sellPrice = $('#sell_price_'+pid+'_'+bno).val();

        var dt = $('#discountType').val();

        if(dt == 1){
            var discountA = $('#discountA_'+pid+'_'+bno).val();
            var discountP = (Number(discountA)*100)/Number(sellPrice);
            $('#discountP_'+pid+'_'+bno).val(discountP);
        }else{
            var discountP = $('#discountP_'+pid+'_'+bno).val();
            var discountA = ((Number(sellPrice)*Number(discountP))/100)*Number(qty);
            $('#discountA_'+pid+'_'+bno).val(discountA);
        }        

        var totalPrice = (Number(sellPrice)*Number(qty))-(Number(discountA)*Number(qty));

        $('#total_price_'+pid+'_'+bno).val(totalPrice);

        var subTotal = 0;
        $('input[name^="total_price"]').each(function() {
            var tp = $(this).val();
            subTotal = Number(subTotal)+Number(tp);            
        });
        $('input[name^="subTotal"]').val(subTotal);
        var fdisAmt = $('input[name="finalTotDisAmt"]').val();

        var totDisPer = (Number(fdisAmt)*100)/Number(subTotal);
        $('input[name^="totDisPer"]').val(totDisPer);

        var finalTotAmt = Number(subTotal)-Number(fdisAmt);
        $('input[name="finalTotAmt"]').val(finalTotAmt);


        
    });

    // discountP change update

    $(document).on('keyup', 'input[name^="discountP"]', function(){   
        var pid = $(this).attr('pid');
        var bno = $(this).attr('bno');
        var qty = $('#qty_'+pid+'_'+bno).val();
        var sellPrice = $('#sell_price_'+pid+'_'+bno).val();
        var discountP = $(this).val();

        var discountA = ((Number(sellPrice)*Number(discountP))/100)*Number(qty);
        
        $('#discountA_'+pid+'_'+bno).val(discountA);

        var tempTotalPrice = (Number(sellPrice)*Number(qty))-(Number(discountA)*Number(qty));
        var totalPrice = tempTotalPrice.toFixed(2);
        $('#total_price_'+pid+'_'+bno).val(totalPrice);

        var subTotal = 0;
        $('input[name^="total_price"]').each(function() {
            var tp = $(this).val();
            subTotal = Number(subTotal)+Number(tp);
        });
        $('input[name^="subTotal"]').val(subTotal);

        var fdisAmt = $('input[name="finalTotDisAmt"]').val();

        var totDisPer = (Number(fdisAmt)*100)/Number(subTotal);
        $('input[name^="totDisPer"]').val(totDisPer);

        var finalTotAmt = Number(subTotal)-Number(fdisAmt);
        $('input[name="finalTotAmt"]').val(finalTotAmt);
    });

    // discountA change

    $(document).on('keyup', 'input[name^="discountA"]', function(){   
        var pid = $(this).attr('pid');
        var bno = $(this).attr('bno');
        var qty = $('#qty_'+pid+'_'+bno).val();
        var sellPrice = $('#sell_price_'+pid+'_'+bno).val();
        var discountA = $(this).val();
        var discountP = (Number(discountA)*100)/Number(sellPrice);
        $('#discountP_'+pid+'_'+bno).val(discountP);
        var tempTotalPrice = (Number(sellPrice)*Number(qty))-(Number(discountA)*Number(qty));
        var totalPrice = tempTotalPrice.toFixed(2);
        $('#total_price_'+pid+'_'+bno).val(totalPrice);

        var subTotal = 0;
        $('input[name^="total_price"]').each(function() {
            var tp = $(this).val();
            subTotal = Number(subTotal)+Number(tp);
        });
        $('input[name^="subTotal"]').val(subTotal);

        var fdisAmt = $('input[name="finalTotDisAmt"]').val();

        var totDisPer = (Number(fdisAmt)*100)/Number(subTotal);
        $('input[name^="totDisPer"]').val(totDisPer);

        var finalTotAmt = Number(subTotal)-Number(fdisAmt);
        $('input[name="finalTotAmt"]').val(finalTotAmt);
    });

    function totDisTypeCng(sel){
        var did = sel.value;
        if(did == 1){
            $('#totDisAmt').show();
            $('#totDisPer').hide();
        }else{
            $('#totDisAmt').hide();
            $('#totDisPer').show();
        }
        
    }

    // totDisAmt change

    $(document).on('keyup', 'input[name="totDisAmt"]', function(){        
        var totDisAmt =  $(this).val(); 
        var subTotal = $('input[name="subTotal"]').val();
        var totDisPer = (Number(totDisAmt)*100)/Number(subTotal);
        $('input[name="totDisPer"]').val(totDisPer);
        var finalTotAmt = Number(subTotal)-Number(totDisAmt);

        $('input[name="finalTotDisAmt"]').val(totDisAmt);
        $('input[name="finalTotAmt"]').val(finalTotAmt);
        
    });
    
    // totDisPer change

    $(document).on('keyup', 'input[name="totDisPer"]', function(){        
        var totDisPer =  $(this).val(); 
        var subTotal = $('input[name="subTotal"]').val();
        var totDisAmt = ((Number(subTotal)*Number(totDisPer))/100);
        $('input[name="totDisAmt"]').val(totDisAmt);
        var finalTotAmt = Number(subTotal)-Number(totDisAmt);

        $('input[name="finalTotDisAmt"]').val(totDisAmt);
        $('input[name="finalTotAmt"]').val(finalTotAmt);
        
    });
    
    $(document).on('click', '#addQuotation', function(){
        
        $('#quotationForm').validate({
            rules: {
                "customerId": {
                    required: true,
                },
                "quotationNo": {
                    required: true
                },
                "spSearch": {
                    required: true
                },
                "id_product[]": {
                    required: true
                },
                "batch_no[]": {
                    required: true
                },
                "qty[]": {
                    required: true,                    
                    number: true
                },
                "sell_price[]": {
                    required: true,                    
                    number: true
                },
                "total_price[]": {
                    required: true,                    
                    number: true
                },
                "subTotal": {
                    required: true,                    
                    number: true
                },
                "finalTotAmt": {
                    required: true,                    
                    number: true
                }
            },
            submitHandler: function(form) {
                var rowCount = $('#addSection tbody tr').length;
                // console.log(form);
                if(Number(rowCount) > 0){
                    $.ajax({
                        url: "<?php echo base_url().'quotation/Quotation_insert';?>",
                        type: "post",
                        data: $(form).serialize(),
                        success: function(res) {  
                            console.log(res);  
                            if(Number(res) > 0){
                                window.location = "<?php  echo site_url('quotation'); ?>";
                            }else{
                                var obj = JSON.parse(res);
                                if(obj.quotationNo){                                
                                    $( "input[name='quotationNo']" ).after('<div class="error">'+obj.quotationNo+'</div>' );
                                }
                                if(obj.customerId){                                
                                    $( "input[name='customerId']" ).after('<div class="error">'+obj.customerId+'</div>' );
                                }
                            }     
                        }
                    }); 
                }else{
                    $('.pmsg').show();
                    $('.pmsg').html('<span class="error"><?= lang("add_atlist_a_product"); ?></span>');
                }    
            }
        });


    });


    function vatTypeChn(sel){
        var did = sel.value;
        if(did == 1){
            $('.vatPer').show();
            $('.vatAmt').hide();
        }else{
            $('.vatPer').hide();
            $('.vatAmt').show();
        }
    }


</script>
