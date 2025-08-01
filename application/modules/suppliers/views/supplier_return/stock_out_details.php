<ul class="breadcrumb">
	<?php
	if($breadcrumb){
		echo $breadcrumb;
	}
	?>
</ul>


<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-lg-12">
				<div class="element-wrapper">
					<div class="top-btn full-box">
                        <div class="row">

                        		<div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('invoice_no')?> </label>
                                        <div class="col-sm-12">
                                            <?php echo $stock_out_list[0]['invoice_no'];?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('stock_out_date')?> </label>
                                        <div class="col-sm-12">
                                            <?php echo $stock_out_list[0]['dtt_stock_mvt'];?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('stock_out_reason')?> </label>
                                        <div class="col-sm-12">
                                            <?php echo $stock_out_list[0]['notes'];?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('download_doc')?> </label>
                                        <div class="col-sm-12">
                                            <?php
                                            if (!empty($doc_list['file'])) {
                                                ?>
                                                <a href="<?php echo base_url() . 'public/uploads/stock_documents/' . $doc_list['file']; ?>" download><button class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i></button></a> 
                                                <?php
                                            }
                                            ?>                                           
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
					<div class="element-box full-box">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive" id="postList">
									<table id="mytable" class="table table-bordred table-striped">
										<thead>
											<tr>
                                                <th><?= lang('batch')?></th>
                                                <th><?= lang('product')?></th>
                                                <th><?= lang('supplier')?></th>
                                                <th><?= lang('quantity')?></th>
                                                <th><?= lang('purchase_price')?></th>
                                                <th><?= lang('sales_price')?></th>
                                                <th><?= lang('rack_id')?></th>
                                                <th><?= lang('expiration_date')?></th>
											</tr>
										</thead>
										<tbody>
											<?php
	                                            $i = 1;
	                                            if(!empty($stock_out_list)){
	                                                foreach ($stock_out_list as $list) {
	                                        ?>
											<tr>
												<td><?php echo $list['batch_no'];?></td>
												<td><?php echo $list['product_name'];?></td>
                                                <td><?php echo $list['supplier_name'];?></td>
												<td><?php echo $list['qty'];?></td>
												<td><?php echo $list['buy_price'];?></td>
												<td><?php echo $list['sell_price'];?></td>
												<td><?php echo $list['name'];?></td>
												<td><?php echo $list['expire_date'];?></td>
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
				</div>
			</div>
		</div>
	</div>
</div>

