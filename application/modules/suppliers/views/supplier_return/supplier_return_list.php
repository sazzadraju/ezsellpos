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
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>supplier-return/supplier_return_pagination_data/' + page_num,
            data: 'page=' + page_num + '&invoice_number='+invoice_number + '&from_date='+from_date +'&to_date='+to_date,
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
                                <a href="<?php echo base_url();?>supplier-return-form" class="btn btn-primary btn-rounded right" type="button"><?= lang('supplier_return')?></a>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive" id="postList">
                                    <?php
                                    $this->load->view('supplier_return/supplier_return_list_pagination', $posts, false);
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

<div id="view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("supplier_details"); ?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <table id="mytable" class="table table-bordred table-striped">
                    <thead>
                    <th><?= lang("product_name"); ?></th>
                    <th><?= lang("product_code"); ?></th>
                    <th><?= lang("qty"); ?></th>
                    <th class="text-right"><?= lang("unit_price"); ?></th>
                    <th class="text-right"><?= lang("total"); ?></th>
                    <th class="text-right"><?= lang("actual_price"); ?></th>
                    </thead  >
                    <tbody id="supp_details_id">
                    </tbody>
                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
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
    function viewSupplierDetails(id)
    {
        //alert(id);
        $.ajax({
            url: "<?php echo base_url() ?>supplier-return-details/" + id,
            type: "GET",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                //console.log(data);
               $('#supp_details_id').html(data);
                $('.loading').fadeOut("slow");
            }
        });
    }

</script>