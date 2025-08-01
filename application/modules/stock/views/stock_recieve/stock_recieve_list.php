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
        var invoice_number = $('#invoice_number').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var store_name = $('#store_name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>stock/stock_recieve_pagination_data/' + page_num,
            data: 'page=' + page_num + '&invoice_number='+invoice_number + '&from_date='+from_date +'&to_date='+to_date+'&store_name='+store_name,
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
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('invoice_no')?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="invoice_number" id="invoice_number">
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
								<div class="table-responsive" id="postList">
                                    <?php
                                    $this->load->view('stock_recieve_list_pagination', $posts, false);
                                    ?>
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