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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="element-box full-box">
                                <h6 class="element-header" id="layout_title"><?= lang("add_transaction_category"); ?></h6>
                                <?php echo form_open('', array('id' => 'categoryform', 'class' => 'cmxform')); ?>
                                <input type="hidden" name="id" id="id" value="">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for=""><?= lang("type"); ?></label>
                                    <div class="col-sm-8">
                                        <div class="col-sm-4">
                                            <input onchange="change_category(1)" type="radio" name="cat_type" checked="" id="cat_type_1" value="1" />
                                            <label for="cat_type_1">Income</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input onchange="change_category(-1)" type="radio" name="cat_type" id="cat_type_2" value="-1" />
                                            <label for="cat_type_2">Expense</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for=""><?= lang("category"); ?></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="cat_name" id="cat_name" value="" placeholder="<?= lang("category"); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><?= lang("parent_category"); ?></label>
                                    <div class="col-sm-8">
                                        <div class="row-fluid" id="tt_income" style="">
                                            <select class="form-control" id="parent_cat" name="parent_cat">
                                                <option value="0"><?= lang("select_one"); ?></option>
                                                <?php foreach ($parent_categories[1] as $key=>$val) :?>
                                                <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-buttons-w">
                                    <button class="btn btn-primary" onclick="reset_all()" type="reset" ><?= lang("reset"); ?></button>
                                    <button class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="element-box full-box"> 
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive" id="catlist">
                                            <?php $this->load->view('transaction_categories/paginated_data', $categories); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="delete_category" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                    <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_this_entry"); ?></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<?= lang("confirm_delete"); ?> </div>
                                </div>
                                <div class="modal-footer ">
                                    <input type="hidden" id="category_delete_id">
                                    <button type="button" class="btn btn-success" onclick="delete_category();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteError" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_error"); ?></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span><span id="err_show"></span> </div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("close"); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script>
    function change_category(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>account-settings/transaction-categories/parent_categories/',
            data: 'id=' + id,
            success: function (html) {
               // console.log(html);
                //alert(html);
                $('#parent_cat').html(html);
            }
        });
    }
    
    function searchFilter(page_num) {
        // Reload select data
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>account-settings/transaction-categories/parent_categories/',
            data: 'id=1',
            success: function (html) {
                $('#parent_cat').html(html);
            }
        });
        
        // Reload table
        page_num = page_num ? page_num : 0;
        var cat_name = $('#cat_name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>account-settings/transaction-category-page/' + page_num,
            data: 'page=' + page_num + '&cat_name=' + cat_name,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#catlist').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

    function reset_all() {
        $('#categoryform')[0].reset();
        $('#layout_title').text('<?= lang("add_transaction_category"); ?>');
        $("#id").val('');
        $('#cat_type_1').prop('checked', true);
        //$("#parent_cat").val('0').change();
        $('#cat_name').val('');
        change_category(1);
    }

    function edit_trx_cat(id) {
        $('#layout_title').text('<?= lang("edit_transaction_category"); ?>');
        $("input[name='id'").val(id);
        
        $.ajax({
            url: '<?php echo base_url(); ?>account-settings-trx-cat/edit/' + id,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                
                if (result) {
                    var data = JSON.parse(result);
                    //console.log(data);
                    change_category(data.qty_modifier);
                    $("input[name='cat_type'][value='"+data.qty_modifier+"']").prop('checked', true);
					$("input[name='cat_name'").val(data.trx_name);

                    setTimeout(function () {
                        $("select[name='parent_cat'").val(data.parent_id).change();
                    }, 100);
                } else{
                    alert('No data found!');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
        $('.loading').fadeOut("slow");
    }
    
    function delete_category_modal(id){
        $('#category_delete_id').val(id);
    }
    
    function delete_category()
    {
        var id = $('#category_delete_id').val();
        $.ajax({
            url: '<?php echo base_url(); ?>account-settings-trx-cat/delete/' + id,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                if (!data.status) {
                    $('.loading').fadeOut("slow");
                    $('#delete_category').modal('toggle');
                    $('#deleteError').modal('show');
                    if(data.res==1){
                        $('#err_show').html('Please Delete Subcategory First');
                    }else{
                        $('#err_show').html('Add transaction in this category');
                    }
                } else {
                    $('.loading').fadeOut("slow");
                    $('#delete_category').modal('toggle');
                    window.onload = searchFilter(0);
                    $('#showMessage').html('<?= lang("delete_success"); ?>');
                    $('#showMessage').show();
                    var selValue = $('input[name=cat_type]:checked').val();
                    change_category(selValue);
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);
                    }, 3000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('<?= lang("delete_error"); ?>');
            }
        });
    }

    $.validator.setDefaults({
        submitHandler: function (form) {
            var currentForm = $('#categoryform')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>account-settings-trx-cat/add",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (response) {
                    console.log(response);
                    var result = JSON.parse(response);
                    console.log(result);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                           $('[name="'+key+'"]').addClass("error");
                            $('[name="'+key+'"]').after(' <label class="error">' + value + '</label>');
                        });
                        
                    } else {                        
                        window.onload = searchFilter(0);
                        $('#showMessage').show();
                        $('#showMessage').html(result.message);
                        setTimeout(function() {
                            $('#showMessage').fadeOut(300);
                        }, 3000);
                        
                        reset_all();
                    }
                    $('.loading').fadeOut("slow");
                }
            });

        }
    });
</script>