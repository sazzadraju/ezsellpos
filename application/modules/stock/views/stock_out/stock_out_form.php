<style>
	#mytable input {
		width: 130px;
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
								<a href="<?php echo base_url();?>stock_out" class="btn btn-primary btn-rounded right margin-right-10" type="button"><?= lang('stock_out_list')?></a>
							</div>
						</div>
						<div class="row">
                            <div class="col-sm-4">
                                <input id="ProductSearch" name="acc_type" value="Yes" type="radio" checked="">
                                <label for="ProductSearch">Product Search</label>
                            </div>
                            <div class="col-sm-4">
                                <input id="BarCode" name="acc_type" value="No" type="radio">
                                <label for="BarCode">Using Barcode</label>
                            </div>
                            <input type="hidden" id="store_from">
                        </div>
                        <div class="row" id="barcodeDiv" style="display: none;">
                            <form class="form-horizontal" role="form" id="enter_stock_to_cart" action="" method="POST"
                                  enctype="multipart/form-data">
                                <div class="col-lg-4">
                                    <label class="col-sm-12 col-form-label">Barcode</label>
                                    <input type="text" name="barcode_name" id="barcode_name">
                                </div>
                                <div class="col-lg-1">
                                    <label class="col-sm-12 col-form-label">&nbsp;</label>
                                    <input  class="btn btn-info" type="submit" value="Add">
                                </div>
                            </form>
                        </div>
                        <div class="row" id="searchDiv">
                       			<!--Hidden field value start-->
								<!-- <input type="hidden" id="store_from"> -->
                       			<input type="hidden" id="purchase_price">
                       			<input type="hidden" id="sale_price">
                       			<input type="hidden" id="stock_rack_name">
                       			<input type="hidden" id="id_stock">
                       			<input type="hidden" id="alert_date">
                       			<input type="hidden" id="rack_id">
                       			<input type="hidden" id="store_id">
                       			<input type="hidden" id="product_code">
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('product')?> </label>
                                        <div class="col-sm-12">
											<select class="select2" data-live-search="true" id="product_name3"
													onchange="product_list_suggest()"
													name="product_name">
												<option value="0" selected><?= lang("select_one"); ?></option>
												<?php
												foreach ($products as $product) {
													echo '<option actp="' . $product->product_name . '" value="' . $product->id_product . '">' . $product->product_name . '(' . $product->product_code . ')' . '</option>';
												}
												?>
											</select>
											<!--                                            <input class="form-control" type="text" name="product_name" id="product_name" class="product_name" onkeyup="product_list_suggest(this);">-->
											<input type="hidden" name="product_id" id="product_id">
											<label id="product_name-error" class="error" for="product_name3"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang('batch_no')?> </label>
                                        <div class="col-sm-12">

                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" name="stock_batch_no" id="stock_batch_no" onchange="get_stock_details(this);">
                                                    
                                                </select>
                                            </div>
                                            <label id="stock_batch_no-error" class="error"></label>
											<input type="hidden" id="sel_batch_no" value="">
											<input type="hidden" id="sel_attr" value="">
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
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('stck_out_qty')?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="stck_out_qty" id="stck_out_qty">
                                            <span id="stck_out_qty-error" class="span_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-1">
									<input type="hidden" name="show_column" id="show_column" value="<?= $columns[0]->permission?>">
                                	<input type="hidden" name="user_type" id="user_type" value="<?= $this->session->userdata['login_info']['user_type_i92']?>">
                                    <label class="col-sm-12 col-form-label">&nbsp;</label>
                                    <button class="btn btn-info" onclick="add_stock_cart();"><i class="fa fa-plus"></i></button>
                                </div>
                            
                        </div>
                        <div class="row">
	                        <div class="col-md-12">
	                            <span id="div_error" class="error"></span>
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
												<th rowspan="2"><?= lang('expiration_date')?></th>
												<th rowspan="2"><?= lang('batch')?></th>
												<th rowspan="2"><?= lang('stck_out_qty')?></th>
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
								<div class="col-md-3">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?=lang('stock_out_date')?></label>
										<div class='col-sm-12'>
											<div class='input-group date' id='StockOutDate'>
												<input type='text' class="form-control" name="dtt_stock_mvt" />
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>												
												</span>
											</div>
											<span id="StockOutDate-error" class="span_error"></span>
										</div>
									</div>
								</div>

								<div class="col-md-3 form-group">
									<div class="col-sm-12">
										<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?=lang('stock_out_doc')?></label>
										<div class='col-sm-12'>  
											<input type="file" name="stock_out_doc" id="stock_out_doc">
											<p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
											<span class="span_error" id="file_error"></span>
										</div>
									</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group row">
										<label class="col-sm-12col-form-label"><?= lang("store_name"); ?></label>
										<div class="col-sm-12">
											<div class="row-fluid">
												<select class="form-control" id="store_name" name="store_name">
													<option value="0" selected><?= lang("select_one"); ?></option>
													<?php
													foreach ($stores as $store) {
														if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
															echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
														} else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
															echo '<option value="' . $store->id_store . '" selected>' . $store->store_name . '</option>';
														}

													}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?=lang('invoice_no')?></label>
										<div class='col-sm-12'> 
											<input class="form-control" type="text" id="invoice_no" name="invoice_no" value="<?php echo $invoice_id;?>" onkeyup="check_invoice_number(this);">
											<input type="hidden" name="default_invoice_no" id="default_invoice_no" value="<?php echo $invoice_id;?>">
											<span id="invoice_no-error" class="span_error"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?=lang('stock_out_reason')?></label>
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
<div id="StoreNameForm" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="element-header margin-0">Select Store name for Stock Out </h6>
			</div>
			<div class="modal-body">
				<div class="data-view">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label"><?= lang("store_name"); ?></label>
								<div class="col-sm-12">
									<div class="row-fluid">
										<select class="select2" id="store_name" name="store_name"
												onchange="store_from_name(this.value)">
											<option value="0" selected><?= lang("select_one"); ?></option>
											<?php
											foreach ($stores as $store) {
												if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
													echo '<option value="' . $store->id_store . '@'.$store->store_name.'">' . $store->store_name . '</option>';
												} else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
													echo '<option value="' . $store->id_store . '@'.$store->store_name.'" selected>' . $store->store_name . '</option>';
												}

											}
											?>
										</select>
										<label class="error" id="select_error"></label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="checkSelect()">OK</button>
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
                		<li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('stock_out_val_msg')?></li>
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
	$(document).ready(function () {
		var id="<?= $this->session->userdata['login_info']['user_type_i92']?>";
		if(id==3){
			$('#StoreNameForm').modal('toggle');
		}else{
			var str_id="<?= $this->session->userdata['login_info']['store_name']?>";
			var val_id = str_id.split('&')[1];
			var val_data = str_id.split('&')[0];
			$('#store_from').val(val_id);
			var opt='<option value="' + val_id +'">'+val_data+ '</option>';
			$('#store_name').html(opt);
		}

	});
	$('input[name=acc_type]').click(function(){
        var section = $('input:radio[name="acc_type"]:checked').val();
        if(section=='No'){
            $('#barcodeDiv').show();
            $('#searchDiv').hide();
        }else{
            $('#searchDiv').show();
            $('#barcodeDiv').hide();
        }
    });
    $("#enter_stock_to_cart").submit(function () {
        $('#div_error').html('');
        var $html = '';
        var dataString = new FormData($(this)[0]);
        var type = $('input:radio[name="acc_type"]:checked').val();
        var batch_no = $("input[name='row_batch_no[]']").map(function(){return $(this).val();}).get();
        var product_id = $("input[name='row_product_id[]']").map(function(){return $(this).val();}).get();
        var row_qty = $("input[name='row_stock_out_qty[]']").map(function(){return $(this).val();}).get();
        dataString.append('acc_type', type);
        dataString.append('row_qty', row_qty);
        dataString.append('store_name', $('#store_from').val());
        dataString.append('batch_no', batch_no);
        dataString.append('product_id', product_id);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>stock/stock_out/temp_add_cart_for_barcode',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                $('.loading').fadeOut("slow");
                if(result!='') {
                    var product = $.parseJSON(result);
                    if (product.status != 5) {
                        if (product.status == '1') {
                            $('#div_error').html('Stock quantity not available..');
                        } else {
                            $("input[name='row_product_id[]']").each(function () {
                                id_value = $(this).val();
                                var id_full = $(this).attr('id');
                                id = id_full.split("_").pop(-1);
                                batch_value = $('#row_batch_no_' + id).val();
                                if ((id_value == product.data['id_product']) && (product.data['batch_no'] == batch_value)) {
                                    var qty = $('#row_stock_out_qty_' + id).val() * 1;
                                    qty = qty + 1;
                                    $('#row_stock_out_qty_' + id).val(qty);

                                }
                            });
                        }

                    } else {
                        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
                        $('input[name="total_num_of_fields"]').val(total_fields + 1);
                        var maxField = x * 1 + 1;
                        var addButton = $('#add_more');
                        //var wrapper = $('#add_more_section');
                        var fieldHTML = "<tr id='" + x + "'><input type='hidden' name='row_id_stock[]' id='row_id_stock_" + x + "'><td><section id='product_name_" + x + "'></section><section id='product_code_"+x+"'></section><section id='product_attr_"+x+"'></section><input type='hidden' name='row_product_id[]' id='row_product_id_" + x + "'></td><td><section id='supplier_name_" + x + "'></section><input type='hidden' name='row_supplier_id[]' id='row_supplier_id_" + x + "'></td><td><input type='text' name='row_qty[]' id='row_qty_" + x + "' readonly='readonly'></td><td><input type='text' id='row_purchase_price_" + x + "' name='row_purchase_price[]' readonly='readonly'></td><td><input type='text' id='row_sale_price_" + x + "' name='row_sale_price[]' readonly='readonly'></td><td><input type='text' id='row_rack_name_" + x + "' name='row_rack_name[]' readonly='readonly'></td><input type='hidden' id='row_rack_id_" + x + "' name='row_rack_id[]'></td><td><input id='row_expire_date_" + x + "' name='row_expire_date[]' type='text' readonly='readonly'></td><input id='row_alert_date_" + x + "' name='row_alert_date[]' type='hidden'><td><input id='row_batch_no_" + x + "' name='row_batch_no[]' type='text' readonly='readonly'></td><td><input id='row_stock_out_qty_" + x + "' name='row_stock_out_qty[]' type='text'></td><td><button class='btn btn-danger btn-xs' onclick='removeMore(" + x + ");'>X</button></td></tr>";

                        if (x < maxField) {
                            $('#mytable > tbody:last').append(fieldHTML);
                            //assign value in add more section start
                            $('#row_id_stock_' + x).val(product.data[0].id_stock);
                            $('#row_product_id_' + x).val(product.data[0].id_product);
                            $('#product_name_' + x).html(product.data[0].product_name);
                            $('#product_code_'+x).html(product.data[0].product_code);
                            $('#product_attr_'+x).html(product.data[0].attribute_name);
                            $('#row_supplier_id_' + x).val(product.data[0].supplier_id);
                            $('#supplier_name_' + x).html(product.data[0].supplier_name);
                            $('#row_qty_' + x).val(product.data[0].qty);
                            $('#row_purchase_price_' + x).val(product.data[0].purchase_price);
                            $('#row_sale_price_' + x).val(product.data[0].selling_price_act);
                            $('#row_rack_name_' + x).val('');
                            $('#row_rack_id_' + x).val(product.data[0].rack_id);
                            $('#row_expire_date_' + x).val(product.data[0].expire_date);
                            $('#row_alert_date_' + x).val(product.data[0].alert_date);
                            $('#row_batch_no_' + x).val(product.data[0].batch_no);
                            $('#row_stock_out_qty_' + x).val(1);

                            //assign value in add more section end
                            x++;
                        }
                    }
                }
                $('#barcode_name').val('');

            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
	function store_from_name(id) {
		var val_id = id.split('@')[0];
		var val_data = id.split('@')[1];
		$('#store_from').val(val_id);
		var opt='<option value="' + val_id +'">'+val_data+ '</option>';
		$('#store_name').html(opt);
		$.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>product_stock_list',
            data: 'id=' + val_id,
            success: function (data) {
                var result = $.parseJSON(data);
                var html = "<option value='0' selected><?= lang('select_one')?></option>";
                for (var i = 0; i < result.length; i++) {
                    html += "<option actp='" + result[i].product_name + "'  value = '" + result[i].id_product + "'>" + result[i].product_name+'('+result[i].product_code+')' + "</option>";
                }
                $('#product_name3').html(html);
            }
        });
	}
	function checkSelect() {
		var store = $('#store_name').val();
		if (store == '0') {
			$('#select_error').html('Select any one');
		}
		else {
			$('#StoreNameForm').modal('hide');
		}
	}
	function add_stock_cart(){
		if (validateStockCart() != false) {
	        //get value from field start
	        var id_stock = $('#id_stock').val();
	        var show_column = $('#show_column').val();
            var user_type = $('#user_type').val();
			var product_name = $('#product_name3 option:selected').attr('actp');
			var product_code = $('#product_code').val();
			var stock_batch_no = $('#sel_batch_no').val();
			var stock_attr = $('#sel_attr').val();
			var supplier_name = $('#supplier_name').val();
			var quantity = $('#quantity').val();
			var ExpiryDate = $('#ExpiryDate').val();
			var stck_out_qty = $('#stck_out_qty').val();
	        var purchase_price = $("#purchase_price").val();
	        var sale_price = $("#sale_price").val();
	        var stock_rack_name = $("#stock_rack_name").val();
	        var product_id = $('#product_name3 option:selected').val();
	        var supplier_id = $('#supplier_id').val(); 
	        var rack_id = $('#rack_id').val(); 
	        var store_id = $('#store_id').val();
	        var alert_date = $('#alert_date').val(); 
			var attribute=stock_attr.replace(/\,/g, "<br>");
			//add more section start
			var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
			$('input[name="total_num_of_fields"]').val(total_fields + 1);
			var maxField = x*1+1;
			var addButton = $('#add_more');
			var show=(show_column==1||user_type==3)?'text':'hidden';
			//var wrapper = $('#add_more_section');
			var fieldHTML = "<tr id='" + x + "'><input type='hidden' name='row_id_stock[]' id='row_id_stock_"+x+"'><td style='width: 128px;'><section id='product_name_"+x+"'></section><section id='product_code_"+x+"'></section><section id='product_attr_"+x+"'></section><input type='hidden' name='row_product_id[]' id='row_product_id_"+x+"'></td><td><section id='supplier_name_"+x+"'></section><input type='hidden' name='row_supplier_id[]' id='row_supplier_id_"+x+"'></td><td><input style='width: 40px;' type='text' name='row_qty[]' id='row_qty_"+x+"' readonly='readonly'></td><td><input type='" + show + "' id='row_purchase_price_"+x+"' name='row_purchase_price[]' readonly='readonly'></td><td><input type='text' id='row_sale_price_"+x+"' name='row_sale_price[]' readonly='readonly'></td><td><input style='width:59px' type='text' id='row_rack_name_"+x+"' name='row_rack_name[]' readonly='readonly'></td><input type='hidden' id='row_rack_id_"+x+"' name='row_rack_id[]'></td><td><input id='row_expire_date_"+x+"' name='row_expire_date[]' type='text' readonly='readonly'></td><input id='row_alert_date_"+x+"' name='row_alert_date[]' type='hidden'><td><input id='row_batch_no_"+x+"' name='row_batch_no[]' type='text' readonly='readonly'></td><td><input style='width: 60px' id='row_stock_out_qty_"+x+"' name='row_stock_out_qty[]' type='text'></td><td><button class='btn btn-danger btn-xs' onclick='removeMore(" + x + ");'>X</button></td></tr>";

			if (x < maxField) {
				$('#mytable > tbody:last').append(fieldHTML);
				//assign value in add more section start
		        $('#row_id_stock_'+x).val(id_stock);
		        $('#row_product_id_'+x).val(product_id);
		        $('#product_name_'+x).html(product_name);
		        $('#product_code_'+x).html(product_code);
				$('#product_attr_'+x).html(attribute);
		        $('#row_supplier_id_'+x).val(supplier_id);
		        $('#supplier_name_'+x).html(supplier_name);
		        $('#row_qty_'+x).val(quantity);
		        $('#row_purchase_price_'+x).val(purchase_price);
		        $('#row_sale_price_'+x).val(sale_price);
		        $('#row_rack_name_'+x).val(stock_rack_name);
		        $('#row_rack_id_'+x).val(rack_id);
		        $('#row_expire_date_'+x).val(ExpiryDate);
		        $('#row_alert_date_'+x).val(alert_date);
		        $('#row_batch_no_'+x).val(stock_batch_no);
		        $('#row_stock_out_qty_'+x).val(stck_out_qty);
		       
		        //assign value in add more section end
		        x++;
			}
	        
			$('#id_stock').val('');
			$('#product_name3').val('0').change();
			$('#supplier_name').val('');
			$('#product_code').val('');
			$('#quantity').val('');
			$('#ExpiryDate').val('');
			$('#stck_out_qty').val('');
	        $("#purchase_price").val('');
	        $("#sale_price").val('');
	        $("#stock_rack_name").val('');
	        $('#product_id').val('');
	        $('#supplier_id').val(''); 
	        $('#rack_id').val(''); 
	        $('#store_id').val('');
	        $('#alert_date').val('');
			$('#sel_attr').val('');
			$('#sel_batch_no').val('');
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
		var product_id = $('#product_name3 option:selected').val();
		var stock_batch_no = $('#stock_batch_no').val();
		var stck_out_qty = $('#stck_out_qty').val();
		var quantity = $('#quantity').val()*1;
		
		if(product_id == "0" || stock_batch_no == "" || stck_out_qty == "" || product_id === null || stock_batch_no === null || stck_out_qty === null || stock_batch_no == 0 || quantity < stck_out_qty){
			$('#product_name-error').html("");
			$('#stock_batch_no-error').html("");
			$('#stck_out_qty-error').html("");

			if(product_id == "0" || product_id === null){
				$('#product_name-error').html("Product not be empty");
				setTimeout(function() {
                	$('#product_name-error').html("");
                }, 2000);
			}

			if(stock_batch_no == "" || stock_batch_no == 0 || stock_batch_no === null){
				$('#stock_batch_no-error').html("Select batch number");
				setTimeout(function() {
                	$('#stock_batch_no-error').html("");
                }, 2000);
			}

			if(stck_out_qty == "" || stck_out_qty === null){
				$('#stck_out_qty-error').html("Stock out quantity not be empty");
				setTimeout(function() {
                	$('#stck_out_qty-error').html("");
                }, 2000);
			}else if(!($.isNumeric(stck_out_qty))) {
                $('#stck_out_qty-error').html("Stock out quantity must be number");
                setTimeout(function() {
                	$('#stck_out_qty-error').html("");
                }, 2000);
            }

            if(quantity < stck_out_qty){
            	$('#stck_out_qty-error').html("Stock out qty should not be bigger than available qty");
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
		var product_id = $('#product_name3 option:selected').val();
		var store_from = $('#store_from').val();
		if(product_id !== "0"){
			$.ajax({
				type: "POST",
				url: '<?php echo base_url();?>get_stock_out_batch_by_product_id',
				data: {
					product_id: product_id,
					store_id: store_from
				},
				success: function (result) {
					var result = $.parseJSON(result);
					var html = "<option value='0' selected><?= lang('select_one')?></option>";
					var total_num_of_fields= $('#total_num_of_fields').val()*1;
					for(var i = 0; i < result.length; i++){
						if(total_num_of_fields != 0){
							var cnt=1;
							for (var k=1;k <= total_num_of_fields;k++) {
							  var tbl_row_id = $('#row_id_stock_'+k).val();
							  if(tbl_row_id == result[i].id_stock){
							  	cnt=2;
							  }
							}
							if(cnt==1){
								html += "<option actp='"+result[i].attribute_name+"' value = '"+result[i].id_stock+"'>"+result[i].batch_no+"("+result[i].attribute_name+")</option>";
							}
						}else{
							html += "<option actp='"+result[i].attribute_name+"' value = '"+result[i].id_stock+"'>"+result[i].batch_no+"("+result[i].attribute_name+")</option>";
						}
					}
					$('#stock_batch_no').html(html);

				}
			});
		}
	}


	function get_stock_details(elem){
		var stock_id = $(elem).val();
		var attr = $('option:selected', elem).attr('actp');
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
		      		$('#stock_rack_name').val(result[0].name);
	                $('#id_stock').val(result[0].id_stock);
	                $('#product_id').val(result[0].product_id);
	                $('#supplier_id').val(result[0].supplier_id);
	                $('#rack_id').val(result[0].rack_id);
	                $('#alert_date').val(result[0].alert_date);
	                $('#store_id').val(result[0].store_id);
					$('#sel_batch_no').val(result[0].batch_no);
					$('#product_code').val(result[0].product_code);
					$('#sel_attr').val(attr);
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
		for(var a = 0; a < $('#total_num_of_fields').val(); a++){
			var b = a*1+1;
			var qty = $('#row_qty_'+b).val()*1;
			var stock_out_qty = $('#row_stock_out_qty_'+b).val()*1;
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

		var file_er=1;
		var file=$('#stock_out_doc').val();
		if(file!=''){
			var ext = $('#stock_out_doc').val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['gif','png','jpg','jpeg','pdf','xls','xlsx','doc','docx']) == -1) {
				file_er=0;
			}
		}
		if(stock_validate == 1 || dtt_stock_mvt == "" || invoice_no == "" ||file_er==0){

			if(stock_validate == 1){
				$('#validateAlert').modal('toggle');
			}

			if(dtt_stock_mvt == ""){
				$('#StockOutDate-error').html('Stock out date should not be empty');
				setTimeout(function() {
	            	$('#StockOutDate-error').html('');
	            }, 3000);
			}

			if(invoice_no == ""){
				$('#invoice_no-error').html('Invoice number should not be empty');
				setTimeout(function() {
	            	$('#invoice_no-error').html('');
	            }, 3000);
			}
			if (file_er == 0) {
				$('#file_error').html('Invoice select file type');
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
            url: '<?php echo base_url();?>stock_out_insert',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                var result = $.parseJSON(result);
                if (result.status != 'success') {
                	$('.loading').fadeOut("slow");
                    $.each(result, function (key, value) {
                        $("#" + key).addClass("error");
                        $("#" + key).after(' <label class="error">' + value + '</label>');
                    });
                } else {
                    $('#showMessage').html(result.message);
                    $('#showMessage').show();
                    setTimeout(function() {
                        window.location.href = "<?php echo base_url() ?>stock_out";
                        
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
