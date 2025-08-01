<style>
	#mytable input {
		width: 90px;
	}
	table tr td{
		padding: 4px !important;
	}

	ul.validation_alert{
		list-style: none;
	}

	ul.validation_alert li{
		padding: 5px 0;
	}

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
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-lg-12">
				<div class="element-wrapper">

					<div class="top-btn full-box">
						<div class="row">
							<div class="col-md-12">
								<a href="<?php echo base_url();?>stock-recieve" class="btn btn-primary btn-rounded right margin-right-10" type="button"><?= lang('stock_recieve_list')?></a>
							</div>
						</div>
                        <div class="row">
                       			<!--Hidden field value start-->
                       			<input type="hidden" id="purchase_price">
                       			<input type="hidden" id="sale_price">
                       			<input type="hidden" id="product_vat_rate">
                       			<input type="hidden" id="stock_rack_name">
                       			<input type="hidden" id="id_stock">
                       			<input type="hidden" id="alert_date">
                       			<input type="hidden" id="rack_id">
                       			<input type="hidden" id="store_id">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('product')?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="product_name" id="product_name" class="product_name" onkeyup="product_list_suggest(this);">
                                            <input type="hidden" name="product_id" id="product_id">
                                            <label id="product_name-error" class="error" for="product_name"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang('batch_no')?> </label>
                                        <div class="col-sm-12">

                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" name="stock_batch_no" id="stock_batch_no" onchange="get_stock_details(this);">
                                                    
                                                </select>
                                            </div>
                                            <label id="stock_batch_no-error" class="error"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?php echo lang('supplier')?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="supplier_name" id="supplier_name" readonly="readonly">
                                            <input type="hidden" name="supplier_id" id="supplier_id">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-1">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('quantity')?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="quantity" id="quantity" readonly="readonly">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('expiration_date')?> </label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="ExpiryDate" name="expire_date" readonly="readonly">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('stck_transfer_qty')?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="stck_out_qty" id="stck_out_qty">
                                            <span id="stck_out_qty-error" class="span_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-1">

                                    <label class="col-sm-12 col-form-label">&nbsp;</label>
                                    <button class="btn btn-info" onclick="add_stock_cart();"><i class="fa fa-plus"></i></button>
                                </div>
                            
                        </div>
                    </div>
       
                    <form class="form-horizontal" role="form" id="enter_stock_out" action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="total_num_of_fields" id="total_num_of_fields" value="0">
                    
					<div class="element-box full-box">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<input type="hidden" id="segment_id" value="0">
									<table id="mytable" class="table table-bordred table-striped">
										<thead>
											<tr>
												<th rowspan="2"><?= lang('product')?></th>
												<th rowspan="2"><?= lang('supplier')?></th>
												<th rowspan="2"><?= lang('qty')?></th>
												<th colspan="2"><?= lang('price')?></th>
												<th rowspan="2"><?= lang('rack_id')?></th>
												<th rowspan="2"><?= lang('vat')?></th>
												<th rowspan="2"><?= lang('expiration_date')?></th>
												<th rowspan="2"><?= lang('batch')?></th>
												<th rowspan="2"><?= lang('stck_transfer_qty')?></th>
											</tr>
											<tr>
												<th><?= lang('purchase')?></th>
												<th><?= lang('sale')?></th>
											</tr>
										</thead>
											<tbody>
												
												
											</tbody>
										</table>
										
									</div>
								</div>
							</div>
						</div>
						
						<div class="top-btn full-box">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?=lang('stck_transfer_date')?></label>
										<div class='col-sm-12'>
											<div class='input-group date' id='StockOutDate'>
												<input type='text' class="form-control" name="dtt_stock_mvt" value="<?php echo date('Y-m-d');?>" />
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>												
												</span>
											</div>
											<span id="StockOutDate-error" class="span_error"></span>
										</div>
									</div>
								</div>

								<div class="col-md-4 form-group">
									<div class="col-sm-12">
										<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?=lang('stck_transfer_doc')?></label>
										<div class='col-sm-12'>  
											<input type="file" name="stock_out_doc">
											<p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
										</div>
									</div>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?=lang('invoice_no')?></label>
										<div class='col-sm-12'> 
											<input class="form-control" type="text" id="invoice_no" name="invoice_no" value="<?php echo $invoice_id;?>" onkeyup="check_invoice_number(this);" readonly="readonly">
											<input type="hidden" name="default_invoice_no" id="default_invoice_no" value="<?php echo $invoice_id;?>">
											<span id="invoice_no-error" class="span_error"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?=lang('store')?></label>
										<div class="col-sm-12">

	                                        <div class="row-fluid">
	                                            <select class="select2" name="to_store" id="to_store">
	                                            <option value="0"><?= lang('select_one')?></option>
	                                                <?php
	                                                	if(!empty($store_list)){
	                                                		foreach ($store_list as $list) {
	                                                ?>
	                                                		<option value="<?php echo $list['id_store'];?>"><?php echo $list['store_name'];?></option>	
	                                                <?php
	                                                		}
	                                                	}
	                                                ?>
	                                            </select>
	                                        </div>
	                                        <label id="to_store-error" class="error"></label>
	                                    </div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?=lang('stck_transfer_reason')?></label>
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
						</div>

					</form>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="element-wrapper">
					<div class="element-box">
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
                <h4 class="modal-title custom_align" id="Heading"><?= lang('attention')?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger">
                	<ul class="validation_alert">
                		<li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('stock_transfer_val_msg')?></li>
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
	
	$(function () {
		$('#ExpiryDate').datetimepicker({
			viewMode: 'years',
			format: 'YYYY-MM-DD',
		});
	});

	$(function () {
		$('#AlertDate').datetimepicker({
			viewMode: 'years',
			format: 'YYYY-MM-DD',
		});
	});


	$(function () {
		$('#StockOutDate').datetimepicker({
			viewMode: 'years',
			format: 'YYYY-MM-DD',
		});
	});


</script>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />

<script type="text/javascript"> 
	var x = 1;
	var batch_inc = 1;
	function add_stock_cart(){
		if (validateStockCart() != false) {
	        //get value from field start
	        var id_stock = $('#id_stock').val();
			var product_name = $('#product_name').val();
			var stock_batch_no_val = $('#stock_batch_no').val();
			var stock_batch_no = $("#stock_batch_no option[value='"+stock_batch_no_val+"']").text();
			var supplier_name = $('#supplier_name').val();
			var quantity = $('#quantity').val();
			var ExpiryDate = $('#ExpiryDate').val();
			var stck_out_qty = $('#stck_out_qty').val();
	        var purchase_price = $("#purchase_price").val();
	        var sale_price = $("#sale_price").val();
	        var product_vat_rate = $("#product_vat_rate").val();
	        var stock_rack_name = $("#stock_rack_name").val();
	        var product_id = $('#product_id').val();
	        var supplier_id = $('#supplier_id').val(); 
	        var rack_id = $('#rack_id').val(); 
	        var store_id = $('#store_id').val();
	        var alert_date = $('#alert_date').val(); 

			//add more section start
			var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
			$('input[name="total_num_of_fields"]').val(total_fields + 1);
			var maxField = x*1+1;
			var addButton = $('#add_more');
			//var wrapper = $('#add_more_section');
			var fieldHTML = "<tr id='" + x + "'><input type='hidden' name='row_id_stock[]' id='row_id_stock_"+x+"'><td><section id='product_name_"+x+"'></section><input type='hidden' name='row_product_id[]' id='row_product_id_"+x+"'></td><td><section id='supplier_name_"+x+"'></section><input type='hidden' name='row_supplier_id[]' id='row_supplier_id_"+x+"'></td><td><input type='text' name='row_qty[]' id='row_qty_"+x+"' readonly='readonly'></td><td><input type='text' id='row_purchase_price_"+x+"' name='row_purchase_price[]' readonly='readonly'></td><td><input type='text' id='row_sale_price_"+x+"' name='row_sale_price[]' readonly='readonly'></td><td><input type='text' id='row_rack_name_"+x+"' name='row_rack_name[]' readonly='readonly'></td><input type='hidden' id='row_rack_id_"+x+"' name='row_rack_id[]'></td><td><input id='row_vat_rate_"+x+"' name='row_vat_rate[]' type='text' readonly='readonly'></td><td><input id='row_expire_date_"+x+"' name='row_expire_date[]' type='text' readonly='readonly'></td><input id='row_alert_date_"+x+"' name='row_alert_date[]' type='hidden'><td><input id='row_batch_no_"+x+"' name='row_batch_no[]' type='text' readonly='readonly'></td><td><input id='row_stock_out_qty_"+x+"' name='row_stock_out_qty[]' type='text'></td><td><button class='btn btn-danger btn-xs' onclick='removeMore(" + x + ");'>X</button></td></tr>";

			if (x < maxField) {
				$('#mytable > tbody:last').append(fieldHTML);
				//assign value in add more section start
		        $('#row_id_stock_'+x).val(id_stock);
		        $('#row_product_id_'+x).val(product_id);
		        $('#product_name_'+x).html(product_name);
		        $('#row_supplier_id_'+x).val(supplier_id);
		        $('#supplier_name_'+x).html(supplier_name);
		        $('#row_qty_'+x).val(quantity);
		        $('#row_purchase_price_'+x).val(purchase_price);
		        $('#row_sale_price_'+x).val(sale_price);
		        $('#row_rack_name_'+x).val(stock_rack_name);
		        $('#row_rack_id_'+x).val(rack_id);
		        $('#row_vat_rate_'+x).val(product_vat_rate);
		        $('#row_expire_date_'+x).val(ExpiryDate);
		        $('#row_alert_date_'+x).val(alert_date);
		        $('#row_batch_no_'+x).val(stock_batch_no);
		        $('#row_stock_out_qty_'+x).val(stck_out_qty);
		       
		        //assign value in add more section end
		        x++;
			}
	        
			$('#id_stock').val('');
			$('#product_name').val('');
			$('#stock_batch_no').val('');
			$('#supplier_name').val('');
			$('#quantity').val('');
			$('#ExpiryDate').val('');
			$('#stck_out_qty').val('');
	        $("#purchase_price").val('');
	        $("#sale_price").val('');
	        $("#product_vat_rate").val('');
	        $("#stock_rack_name").val('');
	        $('#product_id').val('');
	        $('#supplier_id').val(''); 
	        $('#rack_id').val(''); 
	        $('#store_id').val('');
	        $('#alert_date').val(''); 
	        $('#stock_batch_no').html('');
			//add more section end

		}else{
			return false;
		}

	}

	function removeMore(id) {
		$("#" + id).remove();
		x--;
		var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
		$('input[name="total_num_of_fields"]').val(total_fields - 1);
	}

	function validateStockCart(){
		var product_id = $('#product_id').val();
		var stock_batch_no = $('#stock_batch_no').val();
		var stck_out_qty = $('#stck_out_qty').val();
		var quantity = $('#quantity').val();
		quantity = Math.floor(quantity);
		
		if(product_id == "" || stock_batch_no == "" || stck_out_qty == "" || product_id === null || stock_batch_no === null || stck_out_qty === null || stock_batch_no == 0 || quantity < stck_out_qty){
			$('#product_name-error').html("");
			$('#stock_batch_no-error').html("");
			$('#stck_out_qty-error').html("");

			if(product_id == "" || product_id === null){
				$('#product_name-error').html("<?php echo lang('must_not_be_empty');?>");
				setTimeout(function() {
                	$('#product_name-error').html("");
                }, 2000);
			}

			if(stock_batch_no == "" || stock_batch_no == 0 || stock_batch_no === null){
				$('#stock_batch_no-error').html("<?php echo lang('select_one');?>");
				setTimeout(function() {
                	$('#stock_batch_no-error').html("");
                }, 2000);
			}

			if(stck_out_qty == "" || stck_out_qty === null){
				$('#stck_out_qty-error').html("<?php echo lang('must_not_be_empty');?>");
				setTimeout(function() {
                	$('#stck_out_qty-error').html("");
                }, 2000);
			}else if(!($.isNumeric(stck_out_qty))) {
                $('#stck_out_qty-error').html("<?php echo lang('must_be_number');?>");
                setTimeout(function() {
                	$('#stck_out_qty-error').html("");
                }, 2000);
            }

            if(quantity < stck_out_qty){
            	$('#stck_out_qty-error').html("<?php echo lang('stck_trnsfr_qty_validate_msg');?>");
            	setTimeout(function() {
                	$('#stck_out_qty-error').html("");
                }, 2000);
            }

			return false;
		}else{
			$('#product_name-error').html("");
			$('#stock_batch_no-error').html("");
			$('#stck_out_qty-error').html("");
			return true;
		}
	}

	function product_list_suggest(elem){
		var request = $('#product_name').val();
		$("#product_name").autocomplete({
		    source: "<?php echo base_url();?>get_products_for_stock_recieve?request="+ request,
		    focus: function (event, ui) {
		        event.preventDefault();
		       	$("#product_name").val(ui.item.label);
		    },
		    select: function (event, ui) {
		        event.preventDefault();
		        $("#product_id").val('');
		        $("#product_name").val('');
		        $("#supplier_id").val('');
		        $("#supplier_name").val('');
		        $("#quantity").val('');
		        $("#ExpiryDate").val('');

		        $("#product_id").val(ui.item.value);
		        $("#product_name").val(ui.item.label); 
		        var product_id = $("#product_id").val();

		        if(product_id !== ""){
		        	$.ajax({
			            type: "POST",
			            url: '<?php echo base_url();?>get_stock_batch_by_product_id',
			            data: {product_id: product_id},
			            success: function (result) {
			                var result = $.parseJSON(result);
			                var html = "<option value='0' selected><?= lang('select_one')?></option>";
			                
			               	for(var i = 0; i < result.length; i++){
			               		var b = i*1+1;
			               		if(total_num_of_fields != 0){

			               			var tbl_row_id = $('#row_id_stock_'+b).val();
			               			if(tbl_row_id != result[i].id_stock){
			               				html += "<option value = '"+result[i].id_stock+"'>"+result[i].batch_no+"</option>";
			               			}
			               		}else{
			               			html += "<option value = '"+result[i].id_stock+"'>"+result[i].batch_no+"</option>";
			               		}
	                        }
	                        $('#stock_batch_no').html(html);
			                
			            }
			        });
		        }
		    }
		});

	}


	function get_stock_details(elem){
		var stock_id = $(elem).val();
		if(stock_id !== ""){
			$.ajax({
	            type: "POST",
	            url: '<?php echo base_url();?>get_stock_detail_data',
	            data: {stock_id: stock_id},
	            success: function (result) {
	                var result = $.parseJSON(result);
	                $('#supplier_name').val(result[0].supplier_name);
	                $('#quantity').val(result[0].qty);
	                $('#ExpiryDate').val(result[0].expire_date);
	                $("#purchase_price").val(result[0].purchase_price);
		        	$("#sale_price").val(result[0].selling_price_act);
		        	$("#product_vat_rate").val(result[0].vat_rate);
		      		$('#stock_rack_name').val(result[0].name);
	                $('#id_stock').val(result[0].id_stock);
	                $('#product_id').val(result[0].product_id);
	                $('#supplier_id').val(result[0].supplier_id);
	                $('#rack_id').val(result[0].rack_id);
	                $('#alert_date').val(result[0].alert_date);
	                $('#store_id').val(result[0].store_id);
	            }
	        });
		}
		
	}


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

	function check_invoice_number(elem){
		var invoice_number = $(elem).val();
		if(invoice_number != ""){
			$.ajax({
	            type: "POST",
	            url: '<?php echo base_url();?>check_invoice_no',
	            data: {invoice_number: invoice_number},
	            success: function (result) {
	            	
	                if(result == 1){
	                	$('#invoice_no-error').html('Invoice number is already exist !');
	                	setTimeout(function() {
	                    	$('#invoice_no').val('');
	                    	$('#invoice_no-error').html('');
	                    }, 2000);
	                	
	                }
	                
	            }
	        });
		}
	}

	function validate_stock_out_enter(){
		var dtt_stock_mvt = $("input[name=dtt_stock_mvt]").val();
		var invoice_no = $('#invoice_no').val();
		var store = $('#to_store').val();
		for(var a = 0; a < $('#total_num_of_fields').val(); a++){
			var b = a*1+1;
			var qty = $('#row_qty_'+b).val();
			qty = Math.floor(qty);
			var stock_out_qty = $('#row_stock_out_qty_'+b).val();
			stock_out_qty = Math.floor(stock_out_qty);

			$('#row_stock_out_qty_'+b).removeClass('focus_error');
			if(stock_out_qty == "" || qty < stock_out_qty || !($.isNumeric(stock_out_qty))){
				
				var stock_validate = 1;
				if(stock_out_qty == ""){
					$('#row_stock_out_qty_'+b).addClass('focus_error');
				}else if(!($.isNumeric(stock_out_qty))){
					$('#row_stock_out_qty_'+b).val('');
					$('#row_stock_out_qty_'+b).addClass('focus_error');
				}

				if(qty < stock_out_qty){
					$('#row_stock_out_qty_'+b).addClass('focus_error');
				}
				
			}
			
		}


		if(stock_validate == 1 || dtt_stock_mvt == "" || invoice_no == "" || store == "" || store == 0){

			if(stock_validate == 1){
				$('#validateAlert').modal('toggle');
			}

			if(dtt_stock_mvt == ""){
				$('#StockOutDate-error').html("<?php echo lang('must_not_be_empty');?>");
				setTimeout(function() {
	            	$('#StockOutDate-error').html('');
	            }, 3000);
			}

			if(invoice_no == ""){
				$('#invoice_no-error').html("<?php echo lang('must_not_be_empty');?>");
				setTimeout(function() {
	            	$('#invoice_no-error').html('');
	            }, 3000);
			}

			if(store == "" || store == 0){
				$('#to_store-error').html("<?php echo lang('select_one');?>");
				setTimeout(function() {
	            	$('#to_store-error').html('');
	            }, 3000);
			}
			return false;
		}else{
			return true;
		}
		
	}

	$("#enter_stock_out").submit(function () {
        if (validate_stock_out_enter() != false) {
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
                        window.location.href = "<?php echo base_url() ?>stock_transfer";
                        
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
	
</script>
