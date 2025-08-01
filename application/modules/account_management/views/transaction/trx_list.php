<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<ul class="breadcrumb">
    <?php echo isset($breadcrumb) ? $breadcrumb : ''; ?>
</ul>
<div class="col-md-12"> 
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <h6 class="element-header"><?php echo lang("list_of"), ' ', lang($trx_with), ' ', lang("transactions"); ?></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <?php  
                                $check_customer=$check_supplier=$check_office=$check_employee=$check_investor='';
                                $type=$this->session->userdata['login_info']['user_type_i92'];
                                if($type!=3)
                                {
                                    if($menus){
                                        foreach ($menus as $value) {
                                            $check_customer=($value->page_name=='customer')?1:$check_customer;
                                            $check_supplier=($value->page_name=='supplier')?1:$check_supplier;
                                            $check_office=($value->page_name=='office')?1:$check_office;
                                            $check_employee=($value->page_name=='employee')?1:$check_employee;
                                            $check_investor=($value->page_name=='investor')?1:$check_investor;
                                        }
                                    }
                                }
                                    ?>
                                <ul class="tab-menu">
                                    <?php 
                                    if($check_customer==1||$type==3){
                                        ?>
                                        <li <?php if('customer'==$trx_with):?>class="active"<?php endif;?>>
                                            <a href="<?= site_url('account-management/transactions/customer'); ?>" class="btn btn-primary tb" id="tb-1"><?= lang("customer"); ?></a>
                                        </li>
                                        <?php 
                                    }   
                                    if($check_supplier==1||$type==3){
                                        ?>
                                        <li <?php if('supplier'==$trx_with):?>class="active"<?php endif;?>>
                                            <a href="<?= site_url('account-management/transactions/supplier'); ?>" class="btn btn-primary tb" id="tb-2"><?= lang("supplier"); ?></a>
                                        </li>
                                        <?php 
                                    }   
                                    if($check_office==1||$type==3){
                                        ?>
                                        <li <?php if('office'==$trx_with):?>class="active"<?php endif;?>>
                                            <a href="<?= site_url('account-management/transactions/office'); ?>" class="btn btn-primary tb" id="tb-3"><?= lang("office"); ?></a>
                                        </li>
                                        <?php 
                                    }   
                                    if($check_employee==1||$type==3){
                                        ?>
                                        <li <?php if('employee'==$trx_with):?>class="active"<?php endif;?>>
                                            <a href="<?= site_url('account-management/transactions/employee'); ?>" class="btn btn-primary tb" id="tb-2"><?= lang("employee"); ?></a>
                                        </li>
                                        <?php 
                                    }   
                                    if($check_investor==1||$type==3){
                                    ?>
                                        <li <?php if('investor'==$trx_with):?>class="active"<?php endif;?>>
                                            <a href="<?= site_url('account-management/transactions/investor'); ?>" class="btn btn-primary tb" id="tb-3"><?= lang("investor"); ?></a>
                                        </li>
                                    <?php 
                                    }  
                                    ?>
                                </ul>
                                <a href="<?= site_url("account-management/transactions/add/{$trx_with}"); ?>" class="btn btn-primary btn-rounded right"><i class="fa fa-plus"></i> <?php echo lang("add"), ' ', lang($trx_with), ' ', lang("transaction");?></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div id="bank_account" class="tab-pane fade in active full-box">
                                        <div class="table-responsive" id="trx-<?= $trx_with;?>">
                                            <?php $this->load->view("transaction/list/$trx_with", $transactions); ?>
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


<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>

<script>
    $(function () {
//      $(document).on("hidden.bs.modal", "#add", function () {
//        //Reset form elements
//        $(this).find("input[type=text],input[type=file], textarea").val("");
//        $(this).find("input[type=radio], input[type=checkbox]").removeAttr('checked');
//        $(this).find("input[type=select]").removeAttr('selected');
//        $(this).find(".alert-danger").remove(); // Remove from DOM.
//      });
    });

    var x = 1;
    function addMoreDoc() 
    {
        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
        $('input[name="total_num_of_fields"]').val(total_fields + 1);
        var maxField = 3;
        var addButton = $('#add_more');
        var wrapper = $('#add_more_section');
        var fieldHTML = "<fieldset class='form-group' id='" + x + "'><legend>" + "<?= lang('documents') ?>" + "</legend><div class='form-group row'><label class='col-sm-4 col-form-label'>" + "<?= lang('name') ?>" + "</label><div class='col-sm-8'><input class='form-control' placeholder='" + "<?= lang('name') ?>" + "' type='text' name='document_name[]' id='document_name'></div></div><div class='form-group row'><label class='col-sm-4 col-form-label'>" + "<?= lang('description') ?>" + "</label><div class='col-sm-8'><textarea class='form-control' rows='3' name='document_description[]' id='document_description'></textarea></div></div><div class='form-group row'><label class='col-sm-4 col-form-label'>Select File</label><div class='col-sm-8'><input type='file' name='document_file[]' id='document_file'></div></div><div class='element-box-content2'><button class='mr-2 mb-2 btn btn-danger btn-rounded' type='button' onclick='removeMore(" + x + ");'><i class='fa fa-minus'></i>" + "</button></div></fieldset>";

        if (x < maxField) {
            x++;
            $(wrapper).append(fieldHTML);
        }
    }

    function removeMore(id)
    {
        $("#" + id).remove();
        x--;
        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
        $('input[name="total_num_of_fields"]').val(total_fields - 1);
    }
    
    function numeric_only(elem)
    {
        elem.value = elem.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');;
    }
    
    function validateFloatKeyPress(el, evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        var number = el.value.split('.');
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        //just one dot
        if(number.length>1 && charCode == 46){
             return false;
        }
        //get the carat position
        var caratPos = getSelectionStart(el);
        var dotPos = el.value.indexOf(".");
        if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
            return false;
        }
        return true;
    }
    function getSelectionStart(o) {
        if (o.createTextRange) {
            var r = document.selection.createRange().duplicate();
            r.moveEnd('character', o.value.length);
            if (r.text == '') return o.value.length;
            return o.value.lastIndexOf(r.text);
        } 
        else return o.selectionStart;
    }
</script>

