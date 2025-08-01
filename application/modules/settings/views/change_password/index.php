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
    
                    <div class="element-box auto">
                        <?php echo form_open_multipart('', array('id' => 'change_pass', 'class' => 'cmxform')); ?>
                         <span class="showmessage" id="successpass" style="display: none;"><?= lang("successpass"); ?></span>
                        <h6 class="element-header" id="layout_title"><?= lang("change-pass"); ?></h6>    
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("current-pass"); ?><span class="req">*</span></label></label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="<?= lang("current-pass"); ?>" type="password" id="current_pass" name="current_pass" required>
                                 <span class="error" id="wrongpass" style="display: none;">Current Password is wrong</span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("new-pass"); ?><span class="req">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="<?= lang("new-pass"); ?>" type="password" id="password" name="password" required>
                               
                            </div>
                        </div> 
                         <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("confirm-pass"); ?><span class="req">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="<?= lang("confirm-pass"); ?>" type="password" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div> 
                         
                        <div class="form-buttons-w">
                            <button class="btn btn-primary pull-right" type="submit" ></i> <?= lang("submit"); ?></button>
                           <!--  <button class="btn btn-primary pull-right" type="submit"> <?= lang("submit"); ?></button> -->
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            <!-- Add Station End here -->

            </div>
      
        </div>
    </div>
</div>
<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script>
                    function resetAll() {
                        $('#stores')[0].reset();
                        $('#layout_title').text('<?= lang("add_store"); ?>');
                        $('[name="id"]').val('');
                        $('#store_name').attr('name', 'store_name');
                    }
                    
                    
                   // function Change_password() {
                   //     var current_password = $('#current_pass').val();
                   //     var confirm_password = $('#confirm_password').val();
                   //     // alert('***');
                   //     // alert(confirm_password);
                   //     // alert(current_password);
                   $.validator.setDefaults({
                    submitHandler: function (form) {
                       // alert('******');
                        // var name = $('#current_pass').val();
                        //var value = $(form).serialize();
                        var current_password = $('#current_pass').val();
                       var confirm_password = $('#confirm_password').val();
                        var currentForm = $('#change_pass')[0];
                        var formData = new FormData(currentForm);
                        // formData.append('file', document.getElementById("userfile").files[0]);
                        // alert('******');
                       $.ajax({
                           type: 'POST',
                           url: '<?php echo base_url(); ?>settings/password_update',
                           data: 'current_password=' + current_password + '&confirm_password=' + confirm_password,
                           success: function (html) {
                                // alert(html);
                                var obj = jQuery.parseJSON(html);
                                   // alert( obj.status);
                                if(obj.status=='active'){
                                  $('#postList').html(html);
                                  $('.loading').fadeOut("slow");
                                  // alert('************');
                                  // massage=>
                                  $('#successpass').show();
                                  // window.location.href = 'settings/password-success';
                                   // redirect(base_url());
                                }
                                else if (obj.status=='inactive'){
                                 $('#wrongpass').show();
                                }
                               // $('#postList').html(html);
                               // $('.loading').fadeOut("slow");
                           }
                       });
                   }
                 });

</script>  


