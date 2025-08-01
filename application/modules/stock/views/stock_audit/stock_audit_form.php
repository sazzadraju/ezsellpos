<style>
	ul.validation_alert {
		list-style: none;
	}

	ul.validation_alert li {
		padding: 5px 0;
	}

	.focus_error {
		border: 1px solid red;
		background: #ffe6e6;
	}

	.span_error {
		position: absolute;
		color: #da4444;
		width: 200%;
		background: #fff;

	}
</style>


<ul class="breadcrumb">
	<?php
	if ($breadcrumb) {
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
								<a href="<?php echo base_url(); ?>stock_audit" class="btn btn-primary btn-rounded right margin-right-10" type="button"><?= lang('stock_audit_list') ?></a>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group row">
									<label class="col-sm-12col-form-label"><?= lang("store_name"); ?></label>
									<div class="col-sm-12">
										<div class="row-fluid">
											<?php
											$str_id = '';
											$str_name = '';
											foreach ($stores as $store) {
												if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
													$str_id = $store->id_store;
													$str_name = $store->store_name;
												}
											}
											?>
											<input type="hidden" id="store_from" value="<?= $str_id ?>">
											<div id="store_name">
												<?= $str_name ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group row">
									<label class="col-sm-12 col-form-label" for=""><?= lang('stock_audit_date') ?></label>
									<div class='col-sm-12'>
										<div class='input-group' id='stockAuditDate'>
											<input type='text' value="<?= date('Y-m-d') ?>" class="form-control" name="dtt_audit" readonly="" id="dtt_audit" />
										</div>
										<span id="dtt_audit-error" class="span_error"></span>
									</div>
								</div>
							</div>

							<div class="col-md-3 form-group">
								<div class="col-sm-12">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?= lang('audited_by') ?></label>
										<div class='col-sm-12'>
											<select class="form-control select2" multiple="true" name="audited_by[]" id="audited_by">
												<?php
												if ($store_users) {
													foreach ($store_users as $list) {
												?>
														<option value="<?php echo $list['id_user']; ?>"><?php echo $list['uname']; ?></option>
												<?php
													}
												}
												?>
											</select>
											<span id="audited_by-error" class="span_error"></span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-2 form-group">
								<div class="col-sm-12">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?= lang('status') ?></label>
										<div class='col-sm-12'>
											<div class="row-fluid">
												<input type="hidden" name="audit_status" id="audit_status" value="1"><?= lang('ongoing') ?>
												<!-- <select class="form-control" name="audit_status" id="audit_status">
	                                                    <option value="0" selected><?= lang('select_one') ?></option>
	                                                    <option value="3"><?= lang('completed') ?></option>
	                                                    <option value="1"><?= lang('ongoing') ?></option>
	                                                    <option value="2"><?= lang('canceled') ?></option>
	                                                    
	                                                </select> -->
											</div>
											<span id="audit_status-error" class="span_error"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="top-btn full-box">
						<div class="row">
							<!-- <div class="col-sm-4">
	                                <input id="ProductSearch" name="acc_type" value="Yes" type="radio" checked="">
	                              		  <label for="ProductSearch">Product Search</label>
	                            </div>
	                            <div class="col-sm-4">
	                                <input id="BarCode" name="acc_type" value="No" type="radio">
	                                <label for="BarCode">Using Barcode</label>
	                            </div> -->
						</div>
						<div class="row" id="barcodeDiv">
							<form class="form-horizontal" role="form" id="enter_stock_to_cart" action="" method="POST" enctype="multipart/form-data">
								<div class="col-lg-4">
									<label class="col-sm-12 col-form-label">Barcode</label>
									<input type="text" name="barcode_name" id="barcode_name">
								</div>
								<div class="col-lg-1">
									<label class="col-sm-12 col-form-label">&nbsp;</label>
									<input class="btn btn-info" type="submit" value="Add">
								</div>
							</form>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span id="div_error" class="error" style="font-weight: bold;font-size: 16px;"></span>
							</div>
						</div>
						<div class="row" id="searchDiv" style="display: none;">
							<div class="col-md-3">
								<div class="form-group row">
									<label class="col-sm-12 col-form-label" for=""><?= lang('category') ?> </label>
									<div class="col-sm-12">
										<select class="select2" data-live-search="true" id="pro_cat_name" name="pro_cat_name">
											<option value="0" selected><?= lang("select_one"); ?></option>
											<?php
											foreach ($categories as $category) {
												if (empty($category->parent_cat_id)) {
													echo '<option value="' . $category->id_product_category . '">' . $category->cat_name . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group row">
									<label class="col-sm-12 col-form-label" for=""><?= lang('sub_category') ?> </label>
									<div class="col-sm-12">
										<select class="select2" data-live-search="true" id="pro_sub_category" name="pro_sub_category">
											<option value="0" selected><?= lang("product_sub_category"); ?></option>
											<?php
											foreach ($categories as $category) {
												if (!empty($category->parent_cat_id)) {
													echo '<option value="' . $category->id_product_category . '">' . $category->cat_name . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group row">
									<label class="col-sm-12 col-form-label" for=""><?= lang('brand_name') ?> </label>
									<div class="col-sm-12">
										<select class="select2" data-live-search="true" id="pro_brand" name="pro_brand">
											<option value="0"><?= lang("select_one"); ?></option>
											<?php
											foreach ($brands as $brand) {
												echo '<option value="' . $brand->id_product_brand . '">' . $brand->brand_name . '</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group row">
									<label class="col-sm-12 col-form-label" for=""><?= lang('product') ?> </label>
									<div class="col-sm-12">
										<select class="select2" data-live-search="true" id="product_name" name="product_name">
											<option value="0" selected><?= lang("select_one"); ?></option>
										</select>
										<label id="product_name-error" class="error" for="product_name"></label>
									</div>
								</div>
							</div>
							<div class="col-lg-1">

								<label class="col-sm-12 col-form-label">&nbsp;</label>
								<button class="btn btn-info" onclick="searchFilter()"><?= lang('search') ?></button>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="searchData checkGroup" id="searchData">

								</div>
							</div>
						</div>
						<form class="form-horizontal" role="form" id="add_requisition" action="" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="audit_no" value="<?php echo $audit_no; ?>">
							<div class="element-box full-box">
								<div class="row">
									<div class="col-md-12">
										<div class="table-responsive">
											<table id="addSection" class="table table-bordred table-striped">
												<thead>
													<tr>
														<th style="width: 15%"><?= lang('product_code') ?></th>
														<th style="width: 15%"><?= lang('product_name') ?></th>
														<th style="width: 15%"><?= lang('product_category') ?></th>
														<th style="width: 15%"><?= lang('product_sub_category') ?></th>
														<th style="width: 15%"><?= lang('brand_name') ?></th>
														<th style="width: 5%"><?= lang('batch') ?></th>
														<th style="width: 5%"><?= lang('purchase_price') ?></th>
														<th style="width: 10%"><?= lang('stock_qty') ?></th>
														<th style="width: 10%"><?= lang('actual_qty') ?></th>
														<th style="width: 30%"><?= lang('note') ?></th>
														<th align="center" style="width: 5%"><?= lang('action') ?></th>
													</tr>
												</thead>
												<tbody id="add_section">


												</tbody>
												<tfoot>
													<tr>
														<th colspan="3" id="total_item_show"></th>
														<th colspan="2">
															<div id="purchase_price_show"></div>
															<div id="stock_qty_show"></div>
															<div id="total_price_show"></div>
														</th>
														<th colspan="2">
															<div id="actial_qty_show"></div>
															<div id="actial_total_show"></div>
														</th>
													</tr>
												</tfoot>
											</table>
											<div id="add_submit">
												<button type="submit" name="save" style="margin-right: 5px;" class="btn btn-primary right submit_data"><?= lang('save') ?></button>
												<button type="submit" style="margin-right: 5px;" name="save_continue" class="btn btn-primary right submit_data"><?= lang('save_continue') ?></button>
												<button type="submit" style="margin-right: 5px;" name="complete_audit" class="btn btn-primary right submit_data"><?= lang('complete_audit') ?></button>


											</div>

										</div>
									</div>
								</div>
							</div>
						</form>
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
				<h6 class="element-header margin-0">Select Store name for Stock Audit </h6>
			</div>
			<div class="modal-body">
				<div class="data-view">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group row">
								<label class="col-sm-12 col-form-label"><?= lang("store_name"); ?></label>
								<div class="col-sm-12">
									<div class="row-fluid">
										<select class="select2" id="store_name" name="store_name" onchange="store_from_name(this.value)">
											<option value="0" selected><?= lang("select_one"); ?></option>
											<?php
											foreach ($stores as $store) {
												if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
													echo '<option value="' . $store->id_store . '@' . $store->store_name . '">' . $store->store_name . '</option>';
												} else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
													echo '<option value="' . $store->id_store . '@' . $store->store_name . '" selected>' . $store->store_name . '</option>';
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


<script>
	var total_count = 0;
	var adit_barcode = [];

	$(function() {
		$('#stockAuditDate').datetimepicker({
			viewMode: 'years',
			format: 'YYYY-MM-DD',
		});
	});
	$(document).ready(function() {
		var id = "<?= $this->session->userdata['login_info']['user_type_i92'] ?>";
		if (id == 3) {
			$('#StoreNameForm').modal('toggle');
		} else {
			var str_id = "<?= $this->session->userdata['login_info']['store_name'] ?>";
			var val_id = str_id.split('&')[1];
			var val_data = str_id.split('&')[0];
			$('#store_from').val(val_id);
			var opt = '<option value="' + val_id + '">' + val_data + '</option>';
			$('#store_name').html(opt);
		}

	});
	$('input[name=acc_type]').click(function() {
		var section = $('input:radio[name="acc_type"]:checked').val();
		if (section == 'No') {
			$('#barcodeDiv').show();
			$('#searchDiv').hide();
		} else {
			$('#searchDiv').show();
			$('#barcodeDiv').hide();
		}
	});
	$(document).on('input', '.change_qty', function() {
		var m_id = this.id;
		var value = this.value;
		var id = m_id.split('_').pop(-1);
		var qty = $("#qty_" + id).val();
		var total_qty = $("#total_qty_" + id).val();
		if (!$.isNumeric($(this).val())) {
			$(this).addClass("focus_error");
		} else {
			$(this).removeClass("focus_error");

			var purchase_price = $("#purchase_price_" + id).val() * 1;
			var total = purchase_price * value;
			$("#act_purchase_price_" + id).val(total);
			total_sum();
		}
	});
	$("#enter_stock_to_cart").submit(function() {
		$('#div_error').html('');
		var $html = '';
		var dataString = new FormData($(this)[0]);
		//var type = $('input:radio[name="acc_type"]:checked').val();
		var batch_no = $("input[name='batch_no[]']").map(function() {
			return $(this).val();
		}).get();
		var product_id = $("input[name='id_pro[]']").map(function() {
			return $(this).val();
		}).get();

		if (adit_barcode.includes($('#barcode_name').val())) {
			console.log('barcode exist')
			dataString.append('barcode_exist', 1)
		} else {
			dataString.append('barcode_exist', 0)
			adit_barcode.push($('#barcode_name').val());
		}



		// dataString.append('acc_type', type);
		dataString.append('store_name', $('#store_from').val());
		dataString.append('batch_no', batch_no);
		dataString.append('product_id', product_id);
		dataString.append('total_count', total_count);
		dataString.append('brarcode', $('#barcode_name').val());
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>stock/stock_audit/temp_add_cart_for_barcode',
			data: dataString,
			async: false,
			beforeSend: function() {
				$('.loading').show();
			},
			success: function(result) {

				$('.loading').fadeOut("slow");
				if (result != '') {
					var product = $.parseJSON(result);
					console.log(product)
					if (product.status == 2) {
						$("input[name='id_pro[]']").each(function() {
							var id_value = $(this).val();
							var id_full = $(this).attr('id');
							id = id_full.split("_").pop(-1);
							var batch_value = $('#batch_no_' + id).val();
							if ((id_value == product.data['id_product']) && (product.data['batch_no'] == batch_value)) {
								var qty = $('#qty_store_' + id).val() * 1;
								qty = qty + 1;
								$('#qty_store_' + id).val(qty);
							}
						});
					} else if (product.status == 1) {
						total_count += 1;
						$('#addSection > tbody:last').append(product.data);
					} else {
						$('#div_error').html('No Product Found');
					}
					total_sum();

				}
				$('#barcode_name').val('');

			},
			cache: false,
			contentType: false,
			processData: false
		});
		return false;
	});




	function total_sum() {

		var total_audit_qty = 0;
		var total_purchase_price = 0;
		var sum_total_price = 0;
		var sum_act_purchase_price = 0;
		var total_stock_qty = 0;
		$('input[name^="qty_db"]').each(function() {
			total_stock_qty += ($(this).val() * 1);
		});
		$('input[name^="qty_store"]').each(function() {
			total_audit_qty += ($(this).val() * 1);
		});
		$('input[name^="purchase_price"]').each(function() {
			total_purchase_price += ($(this).val() * 1);
		});
		$('input[name^="total_price"]').each(function() {
			sum_total_price += ($(this).val() * 1);
		});
		$('input[name^="act_purchase_price"]').each(function() {
			sum_act_purchase_price += ($(this).val() * 1);
		});
		item_array = [];
		$('input[name^="id_pro"]').each(function() {
			item_array.push($(this).val());
		});
		var itemUniqueArray = item_array.filter(function(itm, i, a) {
			return i == a.indexOf(itm);
		});
		$('#total_item_show').html(itemUniqueArray.length + ' items');
		// $('#total_purchase_price').html('Stock Total= '+total_purchase_price); 
		$('#stock_qty_show').html('Stock Qty Total= ' + total_stock_qty);
		$('#total_price_show').html('Sum Total= ' + sum_total_price);

		$('#actial_qty_show').html('Audit Qty Total= ' + total_audit_qty);
		$('#actial_total_show').html('Sum Audit Total= ' + sum_act_purchase_price);

	}

	function store_from_name(id) {
		var val_id = id.split('@')[0];
		var val_data = id.split('@')[1];
		$('#store_from').val(val_id);
		var opt = '<option value="' + val_id + '">' + val_data + '</option>';
		$('#store_name').html(opt);
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>product_stock_list',
			data: 'id=' + val_id,
			success: function(data) {
				var result = $.parseJSON(data);
				var html = "<option value='0' selected><?= lang('select_one') ?></option>";
				for (var i = 0; i < result.length; i++) {
					html += "<option actp='" + result[i].product_name + "'  value = '" + result[i].id_product + "'>" + result[i].product_name + '(' + result[i].product_code + ')' + "</option>";
				}
				$('#product_name').html(html);
			}
		});
	}

	function checkSelect() {
		var store = $('#store_name').val();
		if (store == '0') {
			$('#select_error').html('Select any one');
		} else {
			$('#StoreNameForm').modal('hide');
		}


	}

	function searchFilter() {
		var product_name = $('#product_name option:selected').val();
		var cat_name = $('#pro_cat_name').val();
		var store_id = $('#store_from').val();
		var sub_category = $('#pro_sub_category').val();
		var brand = $('#pro_brand').val();
		var values = $("input[name='id_pro[]']")
			.map(function() {
				return $(this).val();
			}).get();
		console.log(values);
		//alert(product_name+cat_name+sub_category+brand);
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>search_audit_stock_list',
			data: 'cat_name=' + cat_name + '&product_name=' + product_name + '&sub_category=' + sub_category + '&brand=' + brand + '&values=' + values + '&store_id=' + store_id,
			beforeSend: function() {
				$('.loading').show();
			},
			success: function(html) {
				//console.log(html);
				$('#searchData').html(html);
				$('.loading').fadeOut("slow");
			}
		});
	}

	function product_list_suggest(elem) {
		var request = $('#product_name').val();
		var store_from = $('#store_from').val();
		$("#product_name").autocomplete({
			source: "<?php echo base_url(); ?>get_products_for_stock_audit?request=" + request + '&store=' + store_from,
			focus: function(event, ui) {
				event.preventDefault();
				$("#product_name").val(ui.item.label);
			},
			select: function(event, ui) {
				event.preventDefault();
				$("#product_name").val('');
				$("#product_name").val(ui.item.label);
			}
		});

	}


	function validate_stock_audit() {
		$('#dtt_audit-error').html('');
		$('#audited_by-error').html('');
		$('#audit_status-error').html('');
		var dtt_audit = $('#dtt_audit').val();
		var audited_by = $('#audited_by').val();
		var audit_status = $('#audit_status').val();
		var rowCount = $('#addSection >tbody >tr').length;
		$('#dtt_audit-error').html('');
		$('#audited_by-error').html('');
		$('#audit_status-error').html('');
		$('#div_error').html('');
		if (dtt_audit == "" || audited_by == "" || audit_status == 0 || audited_by == null || audit_status == null || rowCount == 0) {

			if (rowCount == 0) {
				$('#div_error').html("First add product to list.");
			}

			if (dtt_audit == "") {
				$('#dtt_audit-error').html("<?php echo lang('must_not_be_empty'); ?>");
			}

			if (audited_by == "" || audited_by == null) {
				$('#audited_by-error').html("<?php echo lang('select_one'); ?>");
			}

			if (audit_status == 0 || audit_status == null) {
				$('#audit_status-error').html("<?php echo lang('select_one'); ?>");
			}

			return false;
		} else {
			return true;
		}

	}

	var button_pressed;
	$('.submit_data').click(function() {
		button_pressed = $(this).attr('name')
	});
	$("#add_requisition").submit(function() {
		var save_type = button_pressed;
		//alert(sale_type);

		if (validate_stock_audit() != false) {
			var $html = '';
			var dtt_audit = $('#dtt_audit').val();
			var audited_by = $('#audited_by').val();
			var audit_status = $('#audit_status').val();
			if (save_type == 'complete_audit') {
				audit_status = 3;
			}
			var store_name = $('#store_from').val();
			var dataString = new FormData($(this)[0]);
			dataString.append('dtt_audit', dtt_audit);
			dataString.append('audited_by', audited_by);
			dataString.append('audit_status', audit_status);
			dataString.append('store_name', store_name);
			$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>add_stock_audit_data',
				data: dataString,
				processData: false,
				contentType: false,
				beforeSend: function() {
					$('.loading').show();
				},
				success: function(result) {
					var result = $.parseJSON(result);
					//console.log(result);
					//alert(result);
					if (result.status != 'success') {
						$.each(result, function(key, value) {
							$("#" + key).addClass("error");
							$("#" + key).after(' <label class="error">' + value + '</label>');
						});
					} else {
						$('#showMessage').html(result.message);
						$('#showMessage').show();
						setTimeout(function() {
							if (save_type == 'save') {
								window.location.href = "<?php echo base_url() ?>stock_audit";
							} else if (save_type == 'save_continue') {
								 
							} else {
								window.location.href = "<?php echo base_url() ?>stock_audit";
							}

						}, 500);
					}
					$('.loading').fadeOut("slow");
					return false;
				}
			});
			return false;
		} else {
			return false;
		}
	});
</script>