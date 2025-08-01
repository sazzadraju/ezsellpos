<style type="text/css">
    .focus_error{
        border: 1px solid red;
        background: #ffe6e6;
    }

    .span_error{
   position: absolute;
    color: #da4444;
    width: 200%;
    background: #fff;
    
    }
</style>
<ul class="breadcrumb">
	<?php
	if($breadcrumb){
		echo $breadcrumb;
	}
	?>
</ul>
<div class="col-md-12">
	<div class="showmessage" id="showMessage" style="display: none;"></div>
</div>

<script type="text/javascript">
	function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var batch_number = $('#batch_number').val();
        var supp_name = $('#supp_name').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>stock/stock_transfer_pagination_data/' + page_num,
            data: 'page=' + page_num + '&batch_number='+batch_number + '&supp_name='+supp_name + '&from_date='+from_date +'&to_date='+to_date,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
            	//console.log(html);
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
</script>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-lg-12">
				<div class="element-wrapper">
                    <form class="form-horizontal" role="form" id="enter_stock_in" action="" method="POST" enctype="multipart/form-data">
					<div class="element-box full-box">
						<div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo base_url();?>stock-recieve" class="btn btn-primary btn-rounded right" type="button"><?= lang('stock_recieve_list')?></a>
                            </div>
                        </div>
    						<div class="row">
    							<div class="col-md-12">
    								<div class="table-responsive" id="postList">
                                        <table id="mytable" class="table table-bordred table-striped">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center"><?= lang('serial')?></th>
                                                    <th rowspan="2"><?= lang('product')?></th>
                                                    <th rowspan="2" class="text-center"><?= lang('code')?></th>
                                                    <th rowspan="2"><?= lang('supplier')?></th>
                                                    <th colspan="2" class="text-center"><?= lang('price')?></th>
                                                    <th rowspan="2"><?= lang('vat')?></th>
                                                    <th rowspan="2"><?= lang('expiration_date')?></th>
                                                    <th rowspan="2"><?= lang('batch')?></th>
                                                    <th rowspan="2"><?= lang('invoice')?></th>
                                                    <th rowspan="2"><?= lang('qty')?></th>
                                                </tr>
                                                <tr>
                                                    <th><?= lang('purchase')?></th>
                                                    <th><?= lang('sale')?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if(!empty($stock_transfer_list)){
                                                        // echo "<pre>";
                                                        // print_r($stock_transfer_list);
                                                        // exit();
                                                        $i = 1;
                                                        foreach ($stock_transfer_list as $list) {
                                                ?>
                                                        <tr>
                                                            <td class="text-center">
                                                                <input type="hidden" id="total_num_of_fields" name="total_num_of_fields" value="<?php echo count($stock_transfer_list);?>">
                                                                <input type="hidden" name="product_id[]" value="<?php echo $list['product_id'];?>">
                                                                <input type="hidden" name="supplier_id[]" value="<?php echo $list['supplier_id'];?>">
                                                                <input type="hidden" name="id_stock_mvt_detail[]" value="<?php echo $list['id_stock_mvt_detail'];?>">
                                                                <input type="hidden" name="stock_mvt_id" value="<?php echo $list['id_stock_mvt'];?>">
                                                                <input type="hidden" name="stk_tx_snd_id" value="<?php echo $list['stock_mvt_id'];?>">
                                                                <input type="hidden" name="qty[]" value="<?php echo $list['qty'];?>">
                                                                <input type="hidden" name="purchase_price[]" value="<?php echo $list['purchase_price'];?>">
                                                                <input type="hidden" name="selling_price_est[]" value="<?php echo $list['selling_price_est'];?>">
                                                                <input type="hidden" name="vat_rate[]" value="<?php echo $list['vat_rate'];?>">
                                                                <input type="hidden" name="expire_date[]" value="<?php echo $list['expire_date'];?>">
                                                                <input type="hidden" name="alert_date[]" value="<?php echo $list['alert_date'];?>">
                                                                <input type="hidden" name="batch_no[]" value="<?php echo $list['batch_no'];?>">
                                                                <input type="hidden" name="attribute_name[]" value="<?php echo $list['attribute_name'];?>">
                                                                <input type="hidden" name="attribute_id[]" value="<?php echo $list['attribute_ids'];?>">
                                                                <?= $i ?>
                                                            </td>
                                                            <?php 
                                                            $attr_name=($list['attribute_name']!='')?' ('.$list['attribute_name'].')':'';
                                                            ?>
                                                            <td><?php echo $list['product_name'].$attr_name;?></td>
                                                            <td><?php echo $list['product_code'];?></td>
                                                            <td><?php echo $list['supplier_name'];?></td>
                                                            <?php 
                                                            $type= $this->session->userdata['login_info']['user_type_i92'];
                                                            if($columns[0]->permission==1||$type==3){
                                                                echo '<td>'.$list['purchase_price'].'</td>';
                                                            }else{
                                                                echo  '<td>'.' '.'</td>';
                                                            }
                                                            ?>
                                                            <td><?php echo $list['selling_price_est'];?></td>
                                                            <td><?php echo $list['vat_rate'];?></td>
                                                            <td><?php echo $list['expire_date'];?></td>
                                                            <td><?php echo $list['batch_no'];?></td>
                                                            <td><?php echo $list['invoice_no'];?></td>
                                                            <td><input type="text" name="row_qty[]" id="row_qty_<?php echo $i;?>" value="<?php echo floatval($list['qty']);?>"></td>
                                                        </tr>    
                                                <?php
                                                    $i++;
                                                        }
                                                    }
                                                ?>
                                                
                                            </tbody>
                                        </table>
                                        <div class="clearfix"></div>
                                        <?php echo $this->ajax_pagination->create_links(); ?>
                                    </div>
    							</div>
    						</div>
					    </div>
                        <div class="top-btn full-box">
                        <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label" for=""><?=lang('stock_recieve_date')?></label>
                                            <div class='col-sm-12'>
                                                <div class='input-group date' id='StockInDate'>
                                                    <input type='text' class="form-control" name="dtt_stock_mvt" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>                                              
                                                    </span>
                                                </div>
                                                <span id="StockInDate-error" class="span_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                            <label class="col-sm-12 col-form-label" for=""><?=lang('stock_recieve_doc')?></label>
                                            <div class='col-sm-12'>  
                                                <input type="file" name="stock_in_doc">
                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label" for=""><?=lang('invoice_no')?></label>
                                            <div class='col-sm-12'> 
                                                <input class="form-control" type="text" id="invoice_no" name="invoice_no" value="<?php echo $invoice_id;?>" onkeyup="check_invoice_number(this);">
                                                <input type="hidden" name="default_invoice_no" id="default_invoice_no" value="<?php echo $invoice_id;?>" readonly="readonly">
                                                <span id="invoice_no-error" class="span_error"></span>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label" for=""><?=lang('stck_recieve_reason')?></label>
                                            <div class="col-sm-12">

                                                <div class="row-fluid">
                                                    <select class="select2" data-live-search="true" name="stock_mvt_reason_id" id="stock_mvt_reason_id" onchange="reason_note(this);">
                                                        <option value="0"><?= lang('select_one')?></option>
                                                        <?php
                                                            if(!empty($reason_list)){
                                                                foreach ($reason_list as $list) {
                                                        ?>
                                                                <option value="<?php echo $list['id_stock_mvt_reason'];?>"><?php echo $list['reason'];?></option>   
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                        <option value="others"><?= lang('others')?></option>
                                                    </select>
                                                </div>
                                                <label id="stock_mvt_reason_id-error" class="error"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="notes_section" style="display: none;">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label" for=""><?=lang('notes')?></label>
                                            <div class='col-sm-12'> 
                                                <input class="form-control" type="text" id="notes" name="notes"> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="col-sm-12 col-form-label" for="">&nbsp</label>
                                        <button class="btn btn-primary" type="submit"> <?= lang('submit')?></button>
                                    </div>
                            </div>
                        </form>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--Validation Alert Start-->
<div class="modal fade" id="validateAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang('delect_this_entry')?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('qty_msg')?></li>
                    </ul>
                </div>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Validation Alert End-->

<script type="text/javascript">

    function reason_note(elem){
        var reason_val = $(elem).val();
        var check_reason = $("#stock_mvt_reason_id option[value='"+reason_val+"']").text();
        check_reason = check_reason.toLowerCase();
        if(check_reason == "others"){
            $('#notes').val('');
            $('#notes_section').show();
        }else{
            $('#notes_section').hide();
            $('#notes').val(check_reason);
        }
    }

    function validate_stock_enter(){
        var dtt_stock_mvt = $("input[name=dtt_stock_mvt]").val();
        for(var a = 0; a < $('#total_num_of_fields').val(); a++){
            var b = a*1+1;
            var qty = $('#row_qty_'+b).val();
            
            if(qty == "" || !($.isNumeric(qty))){
                var stock_validate = 1;
                $('#row_qty_'+b).removeClass('focus_error');
                if(qty == ""){
                    $('#row_qty_'+b).addClass('focus_error');
                }else if(!($.isNumeric(qty))){
                    $('#row_qty_'+b).val('');
                    $('#row_qty_'+b).addClass('focus_error');
                }
                
            }
            
        }


        if(stock_validate == 1 || dtt_stock_mvt == ""){

            if(stock_validate == 1){
                $('#validateAlert').modal('toggle');
            }

            if(dtt_stock_mvt == ""){
                $('#StockInDate-error').html('Stock in date should not be empty');
                setTimeout(function() {
                    $('#StockInDate-error').html('');
                }, 3000);
            }

            return false;
        }else{
            return true;
        }

    }

    $("#enter_stock_in").submit(function () {
        if (validate_stock_enter() != false) {
        var dataString = new FormData($(this)[0]);
        //console.log(dataString);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>stock_recieve_insert',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                var result = $.parseJSON(result);
                console.log(result);
                if (result.status != 'success') {
                    $.each(result, function (key, value) {
                        $("#" + key).addClass("error");
                        $("#" + key).after(' <label class="error">' + value + '</label>');
                    });
                } else {
                    $('#showMessage').html(result.message);
                    $('#showMessage').show();
                    setTimeout(function() {
                        window.location.href = "<?php echo base_url() ?>stock-recieve";
                        
                    }, 3000);
                    $('.loading').fadeOut("slow");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
         return false;
        } else {
            return false;
        }
    });
	
	$(function () {
        $('#StockInDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });

</script>