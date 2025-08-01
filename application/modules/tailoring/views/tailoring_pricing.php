<ul class="breadcrumb">
    <?php
        echo $this->breadcrumb->output();
    ?>
</ul>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
            	<div class="element-wrapper">
                   <div class="element-wrapper">
                        <div class="row">
                        	<div class="col-md-5">
                                <div class="element-box full-box">
                                    <h6 class="element-header">Add Bill Type</h6>
                                    <div id="massage"></div>
                                    <div id="formContainer">
                                        <form id="billAdd">
                                            <div class="form-group">                           
                                                <label class="col-form-label" for="">Bill Type Name</label>
                                                <input class="form-control" name="billtypename" placeholder="Enter Bill Type Name" type="text">
                                            </div>    
                                            <div class="form-buttons-w">
                                                <button  id="addBillType" class="btn btn-primary" type="submit"> Submit</button>
                                            </div>
                                        </form> 
                                    </div>                                       
                                </div>
                            </div>     
                            <div class="col-md-7">
                                <div class="element-box full-box">
                                    <h6 class="element-header">Bill Type List</h6>
                                    <div class="row">
								        <div class="table-responsive" id="postList">
								            <table id="pricingTable" class="table table-bordred table-striped">
								                <thead>
								                    <th>Bill Type Name</th>
								                    <th class="center">Edit</th>
								                    <th class="center">Delete</th>
								                </tr></thead>
								                <tbody>

                                                    <?php if(!empty($billTypes)): foreach($billTypes as $singlebt): ?>
                                                        <tr>
                                                            <td><?php echo $singlebt['field_name'];?></td>
                                                            <td class="center">
                                                                <button eValue="<?php echo $singlebt['field_name'];?>" pValue="<?php echo $singlebt['id_field'];?>" class="btn btn-primary btn-xs pricingEdit" type="button"><span class="glyphicon glyphicon-pencil"></span></button>
                                                            </td>
                                                            <td class="center">
                                                                 <button pValue="<?php echo $singlebt['id_field'];?>" class="btn btn-danger btn-xs pricingDelete"><span class="glyphicon glyphicon-trash" type="button"></span></button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; else: ?>
                                                    <tr><td colspan="4">Bill Type(s) not available.</td></tr>
                                                    <?php endif; ?>

								                </tbody>

								            </table>
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
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>

            </div>
            <div class="modal-footer ">
                <button type="button" id="pricingDelete" pId="" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script src="<?= base_url()?>themes/default/js/jquery.validate.min.js"></script>

<script type="text/javascript">

	$(document).on('click', '#addBillType', function(){
		$('#billAdd').validate({ 
	        rules: {
	            "billtypename": {
	                required: true
	            }
	        },
	        submitHandler: function(form) {
	        	var billtn = $("input[name='billtypename']").val();

		        if(billtn){

			        $.ajax({
                        url: '<?php echo site_url("tailoring/addbilltype");?>',
                        type: 'get',
                        data: {billtn: billtn},
                    })
                    .done(function(res) {
					    if(res){
					      $('.empty-text').remove();	
					      $("input[name='billtypename']").val('');	
					      $('#massage').html('<p class="success">Insertion succesfull</p>').delay(1200).fadeOut();
					      
                          $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?>tailoring/billTypeAjaxData',
                            beforeSend: function () {
                                $('.loading').show();
                            },
                            success: function (html){
                                $('#postList').html(html);
                                $('.loading').fadeOut("slow");
                            }
                          });
                          

					    }else{
					      $('#massage').html('<p class="error">Insertion unsuccesfull</p>');
					    }
                        
                    });
                }
	        }
	    });
	});
	

	$(document).on('click', '.pricingDelete', function(){
		var dv = $(this).attr('pvalue');
		$('#pricingDelete').attr('pId', dv);
	    $('#delete').modal('show');
	});

	$(document).on('click', '#pricingDelete', function(){
		var dv = $(this).attr('pId');
		$.ajax({
            url: '<?php echo site_url("tailoring/pricing_delete");?>',
            type: 'get',
            data: {dv: dv},
        })
		.done(function(res){
            $('#delete').modal('hide');
			$.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>tailoring/billTypeAjaxData',
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html){
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
              });
		});
	});


	$(document).on('click', '.pricingEdit', function(){

		var bId = $(this).attr('pvalue');
		var bVal = $(this).attr('eValue');

        var editForm = '<form id="billEdit">';
            editForm += '<div class="form-group">';                           
                editForm += '<label class="col-form-label" for="">Bill Type Name</label>';
                editForm += '<input class="form-control" name="eBTName" value="'+bVal+'" placeholder="Enter Bill Type Name" type="text">';
            editForm += '</div>';    
            editForm += '<div class="form-buttons-w">';
                editForm += '<input type="hidden" name="billId" value="'+bId+'">';
                editForm += '<button  id="editReload" class="btn btn-primary" type="button"> Reload</button>';
                editForm += '<button  id="editBT" class="btn btn-primary" type="button"> Update</button>';
            editForm += '</div>';
        editForm += '</form>';  

        $('#formContainer').html(editForm);

        // console.log(editForm);
	    
	});

    $(document).on('click', '#editReload', function(){

        var addForm = '<form id="billAdd">';
            addForm += '<div class="form-group">';                           
                addForm += '<label class="col-form-label" for="">Bill Type Name</label>';
                addForm += '<input class="form-control" name="billtypename" placeholder="Enter Bill Type Name" type="text">';
            addForm += '</div>';    
            addForm += '<div class="form-buttons-w">';
                addForm += '<button  id="addBillType" class="btn btn-primary" type="submit"> Submit</button>';
            addForm += '</div>';
        addForm += '</form>';

        $('#formContainer').html(addForm);
    });

    

	$(document).on('click', '#editBT', function(){				

		var fName = $('input[name="eBTName"]').val();
		var bId = $('input[name="billId"]').val();	
		
        $.ajax({
            url: '<?php echo site_url("tailoring/editBillTypes");?>',
            type: 'post',
            data: {bId: bId, fName: fName},
        }).done(function(res) {
		    if(res == 1){
		    	$.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>tailoring/billTypeAjaxData',
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (html){
                        $('#postList').html(html);
                        $('.loading').fadeOut("slow");
                    }
                });

                var addForm = '<form id="billAdd">';
                    addForm += '<div class="form-group">';                           
                        addForm += '<label class="col-form-label" for="">Bill Type Name</label>';
                        addForm += '<input class="form-control" name="billtypename" placeholder="Enter Bill Type Name" type="text">';
                    addForm += '</div>';    
                    addForm += '<div class="form-buttons-w">';
                        addForm += '<button  id="addBillType" class="btn btn-primary" type="submit"> Submit</button>';
                    addForm += '</div>';
                addForm += '</form>';

                $('#formContainer').html(addForm);
		    }     
        });

	});
	
	    
</script>