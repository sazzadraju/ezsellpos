<?php
// echo "<pre>";
// print_r($promotion_details_list);
// exit();
?>

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
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('title')?> </label>
                                        <div class="col-sm-12">
                                            <?php echo $promotion_details_list[0]['title'];?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('description')?> </label>
                                        <div class="col-sm-12">
                                            <?php echo $promotion_details_list[0]['details'];?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('promotion_type')?> </label>
                                        <div class="col-sm-12">
                                            <?php 
                                                if($promotion_details_list[0]['type_id'] == 1){
                                                    echo "Promotion on Product";
                                                }elseif($promotion_details_list[0]['type_id'] == 2){
                                                    echo "Promotion on Purchase";
                                                }elseif($promotion_details_list[0]['type_id'] == 3){
                                                    echo "Promotion on Card";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('validity_from')?> </label>
                                        <div class="col-sm-12">
                                            <?php echo $promotion_details_list[0]['dt_from'];?>                                       
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('validity_to')?> </label>
                                        <div class="col-sm-12">
                                           <?php echo $promotion_details_list[0]['dt_to'];?>                                         
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    if($promotion_details_list[0]['type_id'] == 2){
                                ?>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang('min_purchase_amount')?> </label>
                                                <div class="col-sm-12">
                                                    <?php echo $promotion_details_list[0]['min_purchase_amt'];?>                                        
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                }
                                if($promo[0]['is_product'] != 1){
                                ?>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('discount_amount')?> </label>
                                        <div class="col-sm-12">
                                           <?php
                                                if($promotion_details_list[0]['discount_rate'] != ""){
                                                    echo $promotion_details_list[0]['discount_rate'].' %';
                                                }elseif($promotion_details_list[0]['discount_amount'] != ""){
                                                    echo set_currency($promotion_details_list[0]['discount_amount']);
                                                }
                                            ?>                                          
                                        </div>
                                    </div>
                                </div>

                                <?php
                                }
                                    if($promotion_details_list[0]['type_id'] == 3){
                                ?>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('payment_type')?> </label>
                                        <div class="col-sm-12">
                                            <?php 
                                                if($promotion_details_list[0]['payment_type'] == 1){
                                                    echo lang('card');
                                                }elseif($promotion_details_list[0]['payment_type'] == 2){
                                                    echo lang('MobileBankAccount');
                                                }
                                            ;?>                                        
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('promotion_on')?> </label>
                                        <div class="col-sm-12">
                                            <?php 
                                                if($promotion_details_list[0]['is_category'] == 1){
                                                    echo lang('cat_subcat');
                                                }elseif($promotion_details_list[0]['is_brand'] == 1){
                                                    echo lang('brand');
                                                }elseif($promotion_details_list[0]['is_product'] == 1){
                                                    echo lang('product');
                                                }elseif($promotion_details_list[0]['is_category'] == 1 && $promotion_details_list[0]['is_brand'] == 1){
                                                    echo lang('category').' & '.lang('sub_category');
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
                                    <?php 
                                    if($promo[0]['is_product'] != 1){
                                    ?>
									<table id="mytable" class="table table-bordred table-striped">
										<thead>
											<tr>
                                                <th><?= lang('serial')?></th>
                                                <th><?= lang('category')?></th>
                                                <th><?= lang('sub_category')?></th>
                                                <th><?= lang('brand')?></th>
                                                <th><?= lang('product')?></th>
											</tr>
										</thead>
										<tbody>
											<?php
	                                            $i = 1;
	                                            if(!empty($promotion_details_list)){
	                                                foreach ($promotion_details_list as $list) {
	                                        ?>
											<tr>
												<td><?php echo $i;?></td>
												<td><?php echo $list['cat_name'];?></td>
                                                <td><?php echo $list['subcat_name'];?></td>
                                                <td><?php echo $list['brand_name'];?></td>
												<td><?php echo $list['product_name'];?></td>
												
											</tr>
											<?php 
	                                            $i++;
	                                                }
	                                            }
	                                        ?>
										</tbody>
									</table>
                                    <?php 
                                    }else{
                                        ?>
                                        <table id="mytable" class="table table-bordred table-striped">
                                            <thead>
                                            <tr>
                                                <th><?= lang('serial') ?></th>
                                                <th><?= lang('product_name') ?></th>
                                                <th><?= lang('product_code') ?></th>
                                                <th class="center"><?= lang('batch_no') ?></th>
                                                <th><?= lang('store_name') ?></th>
                                                <th class="center"><?= lang('qty') ?></th>
                                                <th class="center"><?= lang('purchase_price') ?></th>
                                                <th class="center"><?= lang('selling_price') ?></th>
                                                <th class="center"><?= lang('percentage') ?></th>
                                                <th class="center"><?= lang('taka') ?></th>
                                                <th></th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i = 1;
                                            if (!empty($product_lists)) {
                                                foreach ($product_lists as $list) {
                                                    ?>
                                                    <tr id="<?= $i?>">
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $list['product_name']; ?></td>
                                                        <td><?php echo $list['product_code']; ?></td> 
                                                        <td class="center"><?php echo $list['batch_no']; ?></td>    
                                                        <td><?php echo $list['store_name']; ?></td>
                                                        <td class="center"><?php echo $list['qty']; ?></td>
                                                        <td class="center"><?php echo $list['purchase_price']; ?></td>
                                                        <td class="center"><?php echo $list['selling_price_act']; ?></td>
                                                        <td class="center"><?= $list['discount_rate']?></td>
                                                        <td class="center"><?= $list['discount_amount']?></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>     


                                            </tbody>
                                        </table>
                                    <?php
                                    }
                                    ?>
									<div class="clearfix"></div>
                                    <?php //echo $this->ajax_pagination->create_links(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

