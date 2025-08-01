<?php
$audit_by_data = explode(',', $audit_list[0]['audit_by']);
// echo "<pre>";
// print_r($audit_list);
// exit();
?>

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
								<a href="<?php echo base_url(); ?>stock_audit"
									class="btn btn-primary btn-rounded right margin-right-10"
									type="button"><?= lang('stock_audit_list') ?></a>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group row">
									<label class="col-sm-12 col-form-label"
										for=""><?= lang('stock_audit_date') ?></label>
									<div class='col-sm-12'>
										<div class='input-group date' id='stockAuditDate'>
											<input type='text' class="form-control" name="dtt_audit" id="dtt_audit"
												value="<?php echo date('Y-m-d'); ?>" />
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
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
											<select class="form-control select2" multiple="true" name="audited_by[]"
												id="audited_by">
												<?php
												if ($store_users) {
													foreach ($store_users as $list) {
														?>
														<option <?php if ($audit_by_data) {
															for ($i = 0; $i < count($audit_by_data); $i++) {
																if ($audit_by_data[$i] == $list['id_user']) {
																	echo 'selected';
																}

															}
														} ?> value="<?php echo $list['id_user']; ?>">
															<?php echo $list['uname']; ?>
														</option>
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

							<div class="col-md-3 form-group">
								<div class="col-sm-12">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for=""><?= lang('status') ?></label>
										<div class='col-sm-12'>
											<div class="row-fluid">
												<select class="select2" data-live-search="true" name="audit_status"
													id="audit_status">
													<option value="0" selected><?= lang('select_one') ?></option>
													<option <?php if ($audit_list[0]['status_id'] == "3") {
														echo "selected";
													} ?> value="3"><?= lang('completed') ?></option>
													<option <?php if ($audit_list[0]['status_id'] == "1") {
														echo "selected";
													} ?> value="1"><?= lang('ongoing') ?></option>
													<option <?php if ($audit_list[0]['status_id'] == "2") {
														echo "selected";
													} ?> value="2"><?= lang('canceled') ?></option>

												</select>
											</div>
											<span id="audit_status-error" class="span_error"></span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-4 form-group">
								<div class="col-sm-12">
									<div class="form-group row">
										<label class="col-sm-12 col-form-label"
											for=""><?= lang('stock_audit_doc') ?></label>
										<div class='col-sm-12'>
											<input type="file" name="stock_in_doc" id="stock_in_doc">
											<p
												style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px">
												<?= lang("doc_file_type"); ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="top-btn full-box">
						<div class="row" id="barcodeDiv">
							<form class="form-horizontal" role="form" id="enter_stock_to_cart" action="" method="POST"
								enctype="multipart/form-data">
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

						<form class="form-horizontal" role="form" id="add_requisition" action="" method="POST"
							enctype="multipart/form-data">
							<input type="hidden" name="audit_no" id="audit_no"
								value="<?php echo $audit_info['id_stock_audit']; ?>">


							<input type="hidden" name="is_doc_attached"
								value="<?php echo $audit_list[0]['is_doc_attached']; ?>">

							<?php
							if (!empty($doc_list)) {
								?>
								<input type="hidden" name="old_audit_doc" value="<?php echo $doc_list['file']; ?>">
								<?php
							} else {
								?>
								<input type="hidden" name="old_audit_doc">
								<?php
							}
							?>



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

													<?php
													$a = 0;
													foreach ($audit_list as $list) {
														?>
														<tr id="<?php echo $list['id_stock']; ?>">

															<input type="hidden" name="exist_barcode[]"
																class="exist_barcode"
																value="<?php echo $audit_list[$a]['id_product'] . '-' . $audit_list[$a]['batch_no']; ?>">


															<input type="hidden" name="stock_audit_detail_id[]"
																value="<?php echo $audit_list[$a]['id_stock_audit_detail']; ?>">
															<input type="hidden" name="stock_id[]"
																value="<?php echo $audit_list[$a]['id_stock']; ?>">
															<input type="hidden" name="id_pro[]"
																id="id_pro_<?php echo $a + 1; ?>"
																value="<?php echo $list['id_product']; ?>">
															<input type="hidden" name="batch_no[]"
																id="batch_no_<?php echo $a + 1; ?>"
																value="<?php echo $list['batch_no']; ?>">


															<td><?php echo $list['product_code']; ?></td>
															<td><?php echo $list['product_name']; ?></td>
															<td>
																<?php echo $list['cat_name']; ?>
															</td>
															<td>
																<?php echo $list['sub_cat_name']; ?>
															</td>
															<td>
																<?php echo $list['brand_name']; ?>
															</td>
															<td><?php echo $list['batch_no']; ?></td>
															<td><?php echo $list['purchase_price']; ?></td>

															<input type="hidden" name="total_price[]"
																value="<?php echo $list['purchase_price'] * $list['qty_db']; ?>">
															<input type="hidden" name="act_purchase_price[]"
																value="<?php echo $list['purchase_price'] * $list['qty_db']; ?>">


															<td><?php echo $list['qty_db']; ?><input type="hidden"
																	id="qty_db_<?php echo $a + 1; ?>" name="qty_db[]"
																	value="<?php echo $list['qty_db']; ?>">
															</td>


															<td><input class="form-control" style="width: 60px" type="text"
																	name="qty_store[]" id="qty_store_<?php echo $a + 1; ?>"
																	value="<?php echo round($list['qty_store']); ?>"></td>

															<td><input class="form-control" style="width: 100%" type="text"
																	name="notes[]" id="notes"
																	value="<?php echo $list['notes']; ?>"></td>

															<td> <button class="btn btn-danger btn-xs"
																	onclick="removeMore(<?php echo $list['id_stock']; ?>, event)">X</button>
															</td>
														</tr>
														<?php
														$a++;
													}
													?>

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
												<button type="submit" name="save" style="margin-right: 5px;"
													class="btn btn-primary right submit_data"><?= lang('save') ?></button>
												<button type="submit" style="margin-right: 5px;" name="save_continue"
													id="save_continue"
													class="btn btn-primary right submit_data"><?= lang('save_continue') ?></button>
												<button type="submit" style="margin-right: 5px;" name="complete_audit"
													class="btn btn-primary right submit_data"><?= lang('complete_audit') ?></button>


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

	<input type="hidden" name="" id="store_from" value="<?php echo $audit_info['store_id']; ?>">

</div>

<script>
	var total_count = <?php echo count($audit_list); ?>;
	var adit_barcode = $('.exist_barcode').map(function () {
		return $(this).val();
	}).get();

	console.log(adit_barcode); // Output the array to confirm


	function removeMore(id, event) {
		event.preventDefault(); // Prevent default behavior of the event
		$("#" + id).remove(); // Remove the element with the specified id
	}


	$(function () {
		$('#stockAuditDate').datetimepicker({
			viewMode: 'years',
			format: 'YYYY-MM-DD',
		});
	});

	$("#enter_stock_to_cart").submit(function (event) {
		event.preventDefault();

		$('#div_error').html('');
		var $html = '';
		var dataString = new FormData($(this)[0]);
		//var type = $('input:radio[name="acc_type"]:checked').val();
		var batch_no = $("input[name='batch_no[]']").map(function () {
			return $(this).val();
		}).get();
		var product_id = $("input[name='id_pro[]']").map(function () {
			return $(this).val();
		}).get();

		if (adit_barcode.includes($('#barcode_name').val())) {
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
			beforeSend: function () {
				$('.loading').show();
			},
			success: function (result) {

				$('.loading').fadeOut("slow");
				if (result != '') {
					var product = $.parseJSON(result);
					console.log(product)
					if (product.status == 2) {
						$("input[name='id_pro[]']").each(function () {

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


	var button_pressed;
	$('.submit_data').click(function () {
		button_pressed = $(this).attr('name')
	});
	$("#add_requisition").submit(function () {
		var save_type = button_pressed;
		event.preventDefault();

		var stockData = [];
		var audit_by_data = $('#audited_by').val();
		var audit_by_string = audit_by_data.join(',');
		var stock_audit_id = $('#audit_no').val();
		var status_id = $('#audit_status').val();
		var dtt_audit = $('#dtt_audit').val();
		var stock_in_doc = $('#stock_in_doc').val();

		if (button_pressed == 'complete_audit') {
			status_id = 3;
		}


		var row = 1;
		$('#add_section tr').each(function (index) {
			var stockId = this.id;

			var qtyStore = $('#qty_store_' + row).val();
			var qtyDb = $(this).find('input[name="qty_db[]"]').val();
			var notes = $(this).find('input[name="notes[]"]').val();

			stockData.push({
				stock_id: stockId,
				qty_store: qtyStore,
				qty_db: qtyDb,
				notes: notes,
			});

			row++;
		});

		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>stock/stock_audit/update_stock_audit',
			data: {
				stockData: stockData,
				audit_by: audit_by_string,
				stock_audit_id: stock_audit_id,
				status_id: status_id,
				dtt_audit: dtt_audit,
				stock_in_doc: stock_in_doc,
				old_audit_doc: $('input[name="old_audit_doc"]').val(),
				is_doc_attached: $('input[name="is_doc_attached"]').val(),

			},
			success: function (result) {

				var result = $.parseJSON(result);

				if (result.status == "success") {
					$('#showMessage').html(result.message).show();
					if (save_type == 'save') {
						setTimeout(function () {
							$('#showMessage').hide();
							window.location.href = "<?php echo base_url() ?>stock_audit";
						}, 500);

					} else if (save_type == 'save_continue') {
						setTimeout(function () {
							$('#showMessage').hide();
						}, 3000);
					} if (save_type == 'complete_audit') {
						setTimeout(function () {

							$('#showMessage').hide();
							window.location.href = "<?php echo base_url() ?>stock_audit";

						}, 500);
					}
				}

			}
		}, 'json');



	});



	$(document).ready(function () {
		total_sum();
	});



	function total_sum() {

		var total_audit_qty = 0;
		var total_purchase_price = 0;
		var sum_total_price = 0;
		var sum_act_purchase_price = 0;
		var total_stock_qty = 0;
		$('input[name^="qty_db"]').each(function () {
			total_stock_qty += ($(this).val() * 1);
		});
		$('input[name^="qty_store"]').each(function () {
			total_audit_qty += ($(this).val() * 1);
		});
		$('input[name^="purchase_price"]').each(function () {
			total_purchase_price += ($(this).val() * 1);
		});
		$('input[name^="total_price"]').each(function () {
			sum_total_price += ($(this).val() * 1);
		});
		$('input[name^="act_purchase_price"]').each(function () {
			sum_act_purchase_price += ($(this).val() * 1);
		});
		item_array = [];
		$('input[name^="id_pro"]').each(function () {
			item_array.push($(this).val());
		});
		var itemUniqueArray = item_array.filter(function (itm, i, a) {
			return i == a.indexOf(itm);
		});
		$('#total_item_show').html(itemUniqueArray.length + ' items');
		// $('#total_purchase_price').html('Stock Total= '+total_purchase_price); 
		$('#stock_qty_show').html('Stock Qty Total= ' + total_stock_qty);
		$('#total_price_show').html('Sum Total= ' + sum_total_price);

		$('#actial_qty_show').html('Audit Qty Total= ' + total_audit_qty);
		$('#actial_total_show').html('Sum Audit Total= ' + sum_act_purchase_price);

	}





</script>