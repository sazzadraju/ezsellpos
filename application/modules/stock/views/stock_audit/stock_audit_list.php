
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
        var audit_no = $('#audit_no').val();
        var supp_name = $('#supp_name').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var store_name = $('#store_name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>stock/stock_audit_pagination_data/' + page_num,
            data: 'page=' + page_num + '&audit_no='+audit_no+ '&from_date='+from_date +'&to_date='+to_date+'&store_name='+store_name,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
            	// console.log(html);
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
					<div class="top-btn full-box">
                        <div class="row">

                            <form action="">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12col-form-label"><?= lang("store_name"); ?></label>
                                        <div class="col-sm-12">
                                            <div class="row-fluid">
                                                <select class="select2" id="store_name" name="store_name">
                                                    <option value="0" selected><?= lang("select_one"); ?></option>
                                                    <?php
                                                    foreach ($stores as $store) {
                                                        if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                                            echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                        } else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
                                                            echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
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
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('audit_no')?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="audit_no" id="audit_no">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('from_date')?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" id="from_date" name="from_date">                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('to_date')?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" id="to_date" name="to_date">                                           
                                        </div>
                                    </div>
                                </div>
                
                                <div class="col-lg-1">

                                    <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                    <button class="btn btn-primary btn-rounded center" type="button" onclick="searchFilter();"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
					<div class="element-box full-box">
						<div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo base_url();?>add_stock_audit" class="btn btn-primary btn-rounded right" type="button"><?= lang('start_new_audit')?></a>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive" id="postList">
									<table id="mytable" class="table table-bordred table-striped">
										<thead>
											<tr>
                                                <th><?= lang('audit_no')?></th>
												<th><?= lang('stock_audit_date')?></th>
												<th><?= lang('audited_by')?></th>
												<th><?= lang('status')?></th>
											</tr>
										</thead>
										<tbody>
											 <?php
	                                            $i = 1;
	                                            if(!empty($posts)){
	                                                foreach ($posts as $list) {
	                                        ?>
											<tr>
                                                <td><?php if($list['status_id'] == 1){
                                                    ?>
                                                    <a href="<?php echo base_url();?>stock_audit/<?php echo $list['id_stock_audit'];?>"><?php echo $list['audit_no'];?></a>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <a href="<?php echo base_url();?>stock_audit_details/<?php echo $list['id_stock_audit'];?>"><?php echo $list['audit_no'];?></a>
                                                    <?php
                                                        }?></td>
												<td><?php echo date('Y-m-d', strtotime($list['dtt_audit']));?></td>
												<td><?php echo $list['audit_participants'];?></td>
												<td>
                                                <?php 
                                                    if($list['status_id'] == 1){
                                                ?>
                                                    <button class="btn btn-warning btn-xs"><?= lang('ongoing')?></button>
                                                <?php
                                                    }elseif($list['status_id'] == 2){
                                                ?>
                                                    <button class="btn btn-danger btn-xs"><?= lang('canceled')?></button>
                                                <?php
                                                    }elseif($list['status_id'] == 3){
                                                ?>
                                                    <button class="btn btn-success btn-xs"><?= lang('completed')?></button>
                                                <?php
                                                    }


                                                ?>
                                                </td>
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

<script type="text/javascript">
	
	$(function () {
		$('#from_date').datetimepicker({
			viewMode: 'years',
			format: 'YYYY-MM-DD',
		});
	});

	$(function () {
		$('#to_date').datetimepicker({
			viewMode: 'years',
			format: 'YYYY-MM-DD',
		});
	});

</script>