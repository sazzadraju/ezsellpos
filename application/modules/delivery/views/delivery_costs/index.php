<style type="text/css">
  .error-custom{
    border-color: red;
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
                    <!---Add view BOX--->
                    <div id="view" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="element-header margin-0"><?= lang("DeliveryCost-details"); ?> <span class="close" data-dismiss="modal">&times;</span></h6>
                                </div>
                                <div class="modal-body">
                                    <div class="data-view">
                                     <div class="row">
                                            <div class="col-md-8">
                                            <div class="info-1"> 
                                                <div class="company-email"><strong class="fix-width"><?= lang("cost-name"); ?></strong>: <span id="cost_name_view"></span></div>
                                                <div class="company-address"><strong class="fix-width"><?= lang("type"); ?></strong>: <span id="type_view"></span></div>
                                                <div class="company-address"><strong class="fix-width"><?= lang("agent-name"); ?></strong>: <span id="agent_name_view"></span></div>
                                                <div class="company-phone"><strong class="fix-width"><?= lang("added_by"); ?></strong>: <span id="added_by"></span></div>
                                                <div class="company-address"><strong class="fix-width"><?= lang("added date"); ?></strong>: <span id="added_date"></span></div>
                                            </div>
                                        </div>
                                     </div>
                                     <br>
                                      <div class="row">
                                           <div class="col-md-12">
                                             <h6 class="element-header margin-0"><?= lang("DeliveryCost-configure"); ?></h6>
                                               <table id="mytable" class="table table-bordred table-striped">
                                                 <thead>
                                                   <th>From(gm)</th>
                                                   <th>To (gm)</th>
                                                   <th>price</th>


                                                 </thead>
                                                 <tbody class='tttt'>


                                                 </tbody>
                                               </table>   
                                           </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!---Add Modal BOX--->

                    <div id="add" class="modal fade" role="dialog">
                        <div class="modal-dialog  modal-lg">
                            <!-- Modal content-->

                            <div class="modal-content">
                                <?php echo form_open_multipart('', array('id' => 'DeliveryCost', 'class' => 'cmxform')); ?>
                                <div class="modal-header">
                                    <h6 class="element-header margin-0"><span id="layout_title"><?= lang("add-person"); ?> </span> <span class="close" data-dismiss="modal">&times;</span></h6>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="id" value="">
                                    <div class="row">    
                                         <div class="col-md-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"><?= lang("person-type"); ?> <span class="req">*</span></label>
                                                <div class="col-sm-12">

                                                    <div class="row-fluid">
                                                        <select class="form-control" name="type_id" id="person_type" data-live-search="true" onChange="getdeliveryPerson(this.value)">
                                                            <option value="0"><?= lang("select_one"); ?></option>
                                                            <option value="1" id="b"> Staff</option>
                                                            <option value="2" id="a"> Agent</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="person_type_edit" name="person_type_edit">
                                     <span id="type_id-error" class="error"></span>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12" id="agent_list" style="display: none;">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label"><?= lang("agent-select"); ?> </label>
                                                <div class="col-sm-12">

                                                    <div class="row-fluid">
                                                        <select class="form-control" name="ref_id" id="agent">
                                                            <option value="0"  selected><?= lang("select_one"); ?>
                                                                 <?php
                                                                 if (!empty($agents)) {
                                                           foreach ($agents as $agent) {
                                                        echo '<option value="' . $agent->id_agent . '">' . $agent->agent_name . '</option>';
                                                    }
                                                }
                                                ?>
                                                        </select>
                                                    </div>
                                                    <span id="agent-error" class="error"></span>
                                                </div>
                                            </div>
                                            <span id="staff-error" class="error"></span>
                                            <input type="hidden" id="agent_list_edit" name="agent_list_edit">
                                        </div>
                                         <div class="col-md-6 col-sm-12" style="display: none;" id="costName">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang("cost-name"); ?><span class="req">*</span></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="delivery_cost_name" id="delivery_cost_name">
                                                </div>
                                            </div>
                                             <span id="delivery_cost-error" class="error"></span>
                                        </div>  
                                    </div>  
                                        <div class="row">
                                          <div class="col-lg-12" id="costSection" style="display: none;">
                                              <h1>Cost Configure</h1>
                                              <table class="table table-bordered table-hover" id="tableAddRow">
                                                  <thead>
                                                      <tr>
                                                          <th>From(gm)</th>
                                                          <th>To (gm)</th>
                                                          <th>price</th>
                                                          <th style="width:10px">
                                                            <span class="btn btn-info addBtn" id="addBtn_0"><i class="fa fa-plus"></i></span>
                                                          </th>
                                                      </tr>
                                                      
                                                  </thead>
                                                  <tbody id="costDetails">
                                                      
                                                  </tbody>

                                              </table>

                                              
                                              <span id="addBtn_0-error" class="error"></span><br>
                                              <span id="addBtn_1-error" class="error"></span><br>
                                              <span id="price-error" class="error"></span><br>
                                          </div>
                                        </div> 
                                </div>    

                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>

                        </div>
                    </div>
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">

                                <button data-toggle="modal" data-target="#add" class="btn btn-primary bottom-10 right" type="button" onclick="addPersons()"><?= lang("add-cost"); ?></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php
                                    $this->load->view('delivery_costs/all_product_data', $posts, false);
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="modal fade" id="deleteCost" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                        <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_this_entry"); ?></h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?= lang("confirm_delete"); ?></div>

                                    </div>
                                    <div class="modal-footer ">
                                        <input type="hidden" id="product_delete_id">
                                        <button type="button" class="btn btn-success" onclick="delete_cost();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span><?= lang("no"); ?> </button>
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
</div>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script>

                                            function addPersons() {

                                                $('#DeliveryCost')[0].reset();
                                                document.getElementById("DeliveryCost").reset();
                                                $('#person_type').prop('selectedIndex',0);
                                                $("#id").val("");
                                                $("#person_type").val(0).change();
                                                $('#agent').removeAttr('disabled');
                                                $('#addBtn_0-error').html("");
                                                $("#agent").prop('enabled', false);
                                                $("#person_type").prop('disabled', false);
                                                $('#layout_title').text('<?= lang("add-cost"); ?>');
                                                var row='<tr id="tr_0"><td><input type="text" id="gm_from0" name="gm_from[]" class="form-control"/></td><td><input type="text" id="gm_to0" name="gm_to[]" class="form-control" /></td><td><input type="text" id="price0" name="price[]" class="form-control" /></td><td></td></tr>';
                                                  $("#costDetails").html(row);
                                            }
                                            function getdeliveryPerson(value) {
                                                 if(value == 0){
                                                        // $( "#person_type" ).show( "slow", function() {
                                                // alert( "Animation complete." );
                                                    document.getElementById('person_type').style.display = "block";
                                                     document.getElementById('agent_list').style.display = "none"; 
                                                     document.getElementById('costName').style.display = "none";
                                                     document.getElementById('costSection').style.display = "none";
                                                      // });
                                                 }
                                                if(value == 2){
                                                        $( "#agent_list" ).show( "slow", function() {
                                             
                                                     document.getElementById('agent_list').style.display = "block"; 
                                                     document.getElementById('costName').style.display = "block";
                                                     document.getElementById('costSection').style.display = "block";
                                                      });
                                                 }
                                                 if(value == 1){
                                                    $( "#costName" ).show( "slow", function() {
                                                 document.getElementById('costName').style.display = "block";
                                                  document.getElementById('costSection').style.display = "block";
                                                      });
                                                     
                                                     document.getElementById('agent_list').style.display = "none";
                                                 }

                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url(); ?>delivery/delivery_persons/getStaff',
                                                    data: 'id=' + value,
                                                    success: function (result) {
                                                        var html = '';
                                                        var data = JSON.parse(result);
                                                        if (result) {
                                                            var length = data.length;
                                                            html = "<option value = '0'><?= lang("select_one"); ?></option>";
                                                            for (var i = 0; i < length; i++) {
                                                                var val = data[i].id_user;
                                                                var name = data[i].fullname;
                                                                html += "<option value = '" + val + "'>" + name + "</option>";
                                                            }
                                                        }
                                                        //alert(html);
                                                        $("#staff").html(html);
                                                        //$('#postList').html(html);

                                                    }
                                                });
                                            }
                                         function viewCostDetaitls(id)
                                            {
                                                // alert(id);
                                                $.ajax({
                                                    url: "<?php echo base_url() ?>delivery-costs/details/" + id,
                                                    type: "GET",
                                                    dataType: "JSON",
                                                    beforeSend: function () {
                                                        $('.loading').show();
                                                    },
                                                    success: function (data)
                                                    {
                                                        console.log(data);
                                                        $('.loading').fadeOut("slow");
                                                        $('#cost_name_view').html(data.delivery_name);
                                                        if(data.type_id==1){
                                                            $('#type_view').html('Staff');
                                                            $('#agent_name_view').html('N/A');
                                                        }
                                                        else if(data.type_id==2){
                                                            $('#type_view').html('Agent');
                                                            $('#agent_name_view').html(data.agent_name);
                                                        } 
                                                        $('#added_by').html(data.fullname);
                                                        $('#added_date').html(data.dtt_add);

                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {
                                                        alert('Error get data from ajax');
                                                    }
                                                });
                                            }

                                            function searchFilter(page_num) {
                                                page_num = page_num ? page_num : 0;
                                                var src_person_name = $('#src_person_name').val();
                                                var src_type_id = $('#src_type_id').val();
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url(); ?>delivery-costs/page-data/' + page_num,
                                                    data: 'page=' + page_num + '&src_person_name=' + src_person_name + '&src_type_id=' + src_type_id,
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
                                           
                                            function editCosts(id)
                                            {
                                                $.ajax({
                                                    url: "<?php echo base_url() ?>delivery-costs/edit/" + id,
                                                    type: "GET",
                                                    dataType: "JSON",
                                                    success: function (dataValue)
                                                    {
                                                        console.log(dataValue);
                                                        var result = dataValue;
                                                        $('#layout_title').text('Edit Delivery Cost');
                                                        $('[name="id"]').val(result.data.id_delivery_cost);
                                                        $('#delivery_cost_name').val(result.data.delivery_name);
                                                        $("#person_type").val(result.data.type_id).change(); 
                                                        $("#person_type_edit").val(result.data.type_id); 
                                                        $('#costDetails').html(result.details);
                                                        $("#agent").val(result.data.ref_id).change(); 
                                                        $("#agent_list_edit").val(result.data.ref_id); 
                                                        $("#agent").prop('disabled', true);
                                                        $("#person_type").prop('disabled', true);
                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {
                                                        alert('Error get data from ajax');
                                                    }
                                                });
                                            }
                                            function deleteCostModal(id) {
                                                $('#deleteCost').val(id);
                                            }
                                            function delete_cost()
                                            {
                                                var id = $('#deleteCost').val();
                                                $.ajax({
                                                    url: "<?php echo base_url()?>delivery-costs/delete/" + id,
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    beforeSend: function () {
                                                        $('.loading').show();
                                                    },
                                                    success: function (data)
                                                    {
                                                        $('.loading').fadeOut("slow");
                                                        $('#showMessage').html('<?= lang("delete_success"); ?>');
                                                        $('#deleteCost').modal('toggle');
                                                        window.onload = searchFilter(0);
                                                        $('#showMessage').show();
                                                        setTimeout(function () {
                                                            $('#showMessage').fadeOut(300);

                                                        }, 3000);
                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {
                                                        alert('Error deleting data');
                                                    }
                                                });
                                            }
                                            $.validator.setDefaults({
                                                submitHandler: function (form) {
                                                    var currentForm = $('#DeliveryCost')[0];
                                                    var formData = new FormData(currentForm);
                                                     $err_count = 1;
                                                    var person_type = $('#person_type').val();
                                                    var agent = $('#agent').val();
                                                    // alert(formData);
                                                    var $number= [];
                                                    var delivery_cost_name = $('#delivery_cost_name').val();
                                                     // alert(formData);
                                                     var price_array=[];
                                                    var sum=$('[name="gm_from[]"]').length;
                                                     $('#addBtn_0-error').html("");
                                                      $('#delivery_cost-error').html("");
                                                      $('#agent-error').html("");
                                                      $('#price-error').html("");
                                                      $('[name="gm_to[]"]').removeClass('error-custom');
                                                      $('[name="gm_from[]"]').removeClass('error-custom');
                                                      $('[name="price[]"]').removeClass('error-custom');
                                                      $('#agent').removeClass('error-custom');
                                                      $('#delivery_cost_name').removeClass('error-custom');
                                                    for(var i=0;i<=(sum-1);i++){
                                                        var puls=i+1;
                                                        var gm_from = $('#gm_from'+i).val()*1;
                                                        var gm_from_plus = $('#gm_from'+puls).val()*1;
                                                        var gm_to_plus = $('#gm_to'+puls).val()*1;
                                                        var gm_to = $('#gm_to'+i).val()*1;
                                                        var gm_price = $('#price'+i).val()*1;
                                                        var gm_price_plus = $('#price'+puls).val()*1;
                                                        number1= range(gm_from,gm_to);
                                                        number2= range(gm_from_plus,gm_to_plus);
                                                        // var difference = $(number2).not(number1).get();
                                                        // var diff_length=difference.length;
                                                        var bExists = false;
                                                        console.log(number1);
                                                        var k = i+1;
                                                          while (k<sum) {
                                                            var gm_from_plus = $('#gm_from'+k).val()*1;
                                                            var gm_to_plus = $('#gm_to'+k).val()*1;
                                                            var price_plus = $('#price'+k).val()*1;
                                                            number2= range(gm_from_plus,gm_to_plus);
                                                            $.each(number2, function(index, value){
                                                               // alert(i+'lll'+index+'val:'+value+'aaaa:'+checkIsExist(number1,value));
                                                               
                                                               if(checkIsExist(number1,value)==1){

                                                                  $('#gm_from'+k).addClass('error-custom');
                                                                  $('#gm_to'+k).addClass('error-custom');
                                                                  $('#gm_to'+i).addClass('error-custom');
                                                                  $('#gm_from'+i).addClass('error-custom');
                                                                   $('#addBtn_0-error').html("* RENGE COULD NOT BE SAME .");
                                                                   $err_count = 2;
                                                                  return false;
                                                                  
                                                               }
                                                            });
                                                            if(gm_price==price_plus){
                                                              $('#price-error').html("* PRICE COULD NOT BE SAME .");
                                                              $('#price'+i).addClass('error-custom');
                                                              $('#price'+k).addClass('error-custom');
                                                              $err_count = 2;
                                                               return false;
                                                              
                                                            }

                                                             k++;
                                                          }
                                                       
                                                       if(gm_from==0 && gm_to==0){
                                                          jQuery('#gm_from'+i).addClass('error-custom');
                                                          jQuery('#gm_to'+i).addClass('error-custom');
                                                          $('#addBtn_0-error').html("* FILL THE FROM AND TO FIRST");
                                                          $err_count = 2;
                                                      }
                                                         if(gm_from==gm_to && gm_to>0){
                                                            jQuery('#gm_to'+i).addClass('error-custom');
                                                            jQuery('#gm_from'+i).addClass('error-custom');
                                                            $('#addBtn_0-error').html("* FROM VALUE AND TO VALUE COULD NOT BE SAME .");
                                                            $err_count = 2;
                                                        }

                                                         if(gm_from>gm_to){
                                                            $('#gm_to'+i).addClass('error-custom');
                                                            $('#gm_from'+i).addClass('error-custom');
                                                            $('#addBtn_0-error').html("* FROM COULD NOT BE GREATER .");

                                                            $err_count = 2;
                                                        }

                                                        if(gm_price==''){
                                                            $('#price-error').html("* FILL THE PRICE SECTION .");
                                                            $('#price'+i).addClass('error-custom');
                                                            
                                                            $err_count = 2;
                                                        }

                                                        if(gm_price==gm_price_plus){
                                                            $('#price-error').html("* PRICE COULD NOT BE SAME .");
                                                            $('#price'+i).addClass('error-custom');
                                                            $('#price'+puls).addClass('error-custom');
                                                            
                                                            $err_count = 2;

                                                        }


                                                        if(delivery_cost_name==''){
                                                            $('#delivery_cost-error').html("FILL THE DELIVERY COST NAME .");
                                                            $('#delivery_cost_name').addClass('error-custom');
                                                            $err_count = 2;
                                                        }  
                                                        if(person_type==2 && agent==0){
                                                            $('#agent-error').html("SELECT AGENT FIRST.");
                                                            $('#agent').addClass('error-custom');
                                                            $err_count = 2;
                                                        }  


                                                    }   

                                                    if ($err_count == 1)  {         
                                                    $.ajax({
                                                        url: "<?= base_url() ?>delivery/delivery_costs/add_data",
                                                        type: 'POST',
                                                        data: formData,
                                                        processData: false,
                                                        contentType: false,
                                                        beforeSend: function () {
                                                            $('.loading').show();
                                                        },
                                                        success: function (response) {
                                                            // alert(response);
                                                            // $('.loading').fadeOut("slow");
                                                            var result = $.parseJSON(response);
                                                            if (result.status != 'success') {
                                                                $.each(result, function (key, value) {
                                                                    $('[name="' + key + '"]').addClass("error");
                                                                    $('[name="' + key + '"]').after(' <label class="error">' + value + '</label>');
                                                                });
                                                            } else {
                                                                $('#DeliveryCost')[0].reset();
                                                                $('#add').modal('hide');
                                                                $('#showMessage').html(result.message);
                                                                window.onload = searchFilter(0);
                                                                setTimeout(function () {
                                                                    $('#showMessage').fadeOut(300);

                                                                }, 3000);
                                                            }
                                                            $('#showMessage').show();
                                                        }
                                                    });
                                                }    
                                                }
                                            });
                                            

                                            $(document).ready(function(){
                                                $("#a").click(function(){
                                                    $("#agent_type").hide();
                                                });
                                                $("#b").click(function(){
                                                    $("#staff_type").show();
                                                });
                                            });

                                        function checkIsExist(a, obj) {
                                            var i = a.length;
                                            while (i--) {
                                               if (a[i] === obj) {
                                                   return 1;
                                               }
                                            }
                                            return 2;
                                        }      
                                        function Staff_phone(value) {
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url(); ?>delivery/delivery_persons/getStaffPhone',
                                                data: 'id=' + value,
                                                success: function (result) {
                                                    console.log(result);
                                                    var html = '';
                                                    var data = JSON.parse(result);
                                                    if (result) {
                                                        var length = data.length;
                                                        html = "";
                                                        for (var i = 0; i < length; i++) {
                                                            var phone = data[i].mobile;
                                                        }
                                                    }
                                                    $('#person_number').val(phone);
                                                    //$('#postList').html(html);

                                                }
                                            });
                                        } 
                                        $('.addBtn').on('click', function () {
                                            addTableRow();
                                        });
                                        var i = 1;
                                        function addTableRow()
                                        {
                                            var tempTr = '<tr><td><input type="text" name="gm_from[]" id="gm_from' + i + '" class="form-control"/></td><td><input type="text" name="gm_to[]" id="gm_to' + i + '" class="form-control" /></td><td><input type="text" name="price[]" id="price' + i + '" class="form-control" /></td><td><span onclick="addBtnRemove(this)" class="btn btn-danger btn-xs" id="addBtn_' + i + '">X</span></td></tr>'; 
                                            $("#tableAddRow").append(tempTr)
                                            i++;
                                        }
                                    function  addBtnRemove(evl){
                                      $(evl).closest('tr').remove();
                                    }

                             function costConfig_details(id)
                            {
                         // alert(trx_no);
                         $.ajax({
                             url: "<?php echo base_url() ?>delivery/delivery_costs/costDetails_data/" + id,
                             type: "GET",
                             dataType: "JSON",
                             // beforeSend: function () {
                             //     $('.loading').show();
                             // },
                             success: function (data)
                             {
                                 console.log(data[1].gm_from);
                                 var res='';
                                 var total = 0;
                                  var vv = '';
                                  for (var i=0; i<data.length; i++) {
                                    total +=data[i].gm_from;
                                     vv += '<tr><td>'+data[i].gm_from+'</td><td>'+data[i].gm_to+'</td><td>'+data[i].price+'</td></tr>';
                                  }


                                  $('.tttt').html(vv);
                                
                             },

                             error: function (jqXHR, textStatus, errorThrown)
                             {
                                 alert('Error get data from ajax');
                             }
                         });
                     }                                   


                 function range(start, end) {
                   var arr = [];
                   for(var i = start; i <= end; i++)
                     arr.push(i);
                   return arr;
                 }
           </script> 
