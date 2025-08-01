        <ul class="breadcrumb">
            <?php echo $this->breadcrumb->output();?>
        </ul>
        <div class="content-i">
            <div class="content-box">
                <div class="row">
                    <div class="col-sm-12">
                    	<div class="element-wrapper">
                           <div class="element-wrapper">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="element-box full-box">
                                            <h6 class="element-header">Order</h6>

                                            <?php 
                                                if(isset($aOrder)){
                                                    echo '<pre>';
                                                    // print_r($serFullDt);
                                                    print_r($aOrder);
                                                    echo '</pre>';
                                                }
                                            ?>
                                            
                                            <div id="flash-msg"></div>                                          
                                            
                                            <form id="orderSubmit1">
                                                <div class="form-group row">
                                                    <div class="col-sm-6">    
                                                        <input type="hidden" name="order_id" value="<?php echo $serFullDt[0]['order_id'];?>"/>
                                                        <!-- <input type="hidden" name="service_identify" value="<?php echo $serFullDt[0]['service_identify'];?>"/>                         -->
                                                        <label class="col-form-label" for="">Customer Name</label>
                                                        <select name="customerName" class="form-control">
                                                            <option value="">Select Customer</option>
                                                            <?php 
                                                                foreach($getAllCustomer as $singleCustomer):

                                                                $selected = '';
                                                                if(isset($aOrder[0]['customer_id'])){
                                                                    if($singleCustomer['id_customer'] == $aOrder[0]['customer_id']){
                                                                        $selected = 'selected';
                                                                    }
                                                                }
                                                            ?>
                                                            <option value="<?php echo $singleCustomer['id_customer'];?>" <?php echo $selected;?>><?php echo $singleCustomer['full_name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="">Receipt No.</label>
                                                        <?php 
                                                            if($ef){
                                                                $receipt_no = $aOrder[0]['receipt_no'];
                                                            }
                                                        ?>
                                                        <input class="form-control" name="receiptNo" value="<?php echo $receipt_no;?>" type="text">
                                                    </div>
                                                </div> 
                                                <div class="form-group row">
                                                    <div class="col-sm-6">                            
                                                        <label class="col-form-label" for="">Order date</label>
                                                        <input id="orderDate" name="orderDate" class="form-control" placeholder="Order date" value="<?php echo $aOrder[0]['order_date'];?>" type="text">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="">Delivery Date</label>
                                                        <input id="deliveryDate" name="deliveryDate" class="form-control" placeholder="Delivery Date" value="<?php echo $aOrder[0]['delivery_date'];?>" type="text">
                                                    </div>
                                                </div> 
                                            </form>    
                                            <div class="form-group row">
                                                <div class="col-sm-12">                           
                                                    <label class="col-form-label" for="">Select Service</label>
                                                    <select id="serviceLoader" class="selectpicker form-control" data-live-search="true">
                                                        <option value="-1">Select One</option>
                                                        <?php 
                                                            if(isset($services)):
                                                                foreach ($services as $svalue):
                                                        ?>
                                                            <option value="<?php echo $svalue['id_service'];?>"><?php echo $svalue['service_name'];?></option>
                                                        <?php 
                                                                endforeach;
                                                            endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="ServiceForm">
                                                                                             
                                            </div>   
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <form id="orderSubmit2" action="<?php echo base_url().'tailoring/order_complete';?>" method="post">
                                            <div class="element-box full-box">
                                                <h6 class="element-header">Service list</h6>
                                                <div class="table-responsive">
                                                        <table id="serviceTable" class="table table-bordred table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Service Name</th>
                                                                    <th>Service Price</th>
                                                                    <th>Quantity</th>
                                                                    <th>Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot>

                                                            </tfoot>
                                                        </table>
                                                </div>
                                            </div>
                                            <div class="element-box full-box">
                                                <div class="col-sm-12">                            
                                                    <h6 class="element-header">Billing Type</h6>
                                                    <?php
                                                        // echo '<pre>';
                                                        // print_r($billingTypes);
                                                        // echo '</pre>';
                                                    ?>
                                                    <?php $bi = 0; foreach($billingTypes as $sBillt):?>
                                                        <div class="form-group row">
                                                            <label class="col-sm-5 col-form-label" for="billType[]"><?php echo $sBillt['field_name'];?></label>
                                                            <div class="col-sm-7">
                                                                <input class="form-control" id="billId-<?php echo $bi;?>" fid="<?php echo $sBillt['id_field'];?>" name="billType[]" type="text">
                                                            </div>
                                                        </div>
                                                    <?php $bi++; endforeach;?>
                                                </div>
                                            </div>
                                            <div class="element-box full-box">
                                                <h6 class="element-header">Discount & Transection</h6>
                                                <div class="col-sm-12">     
                                                    <div class="form-group row">
                                                        <label class="col-sm-5 col-form-label">Discount Type</label>
                                                        <div class="col-sm-7">
                                                            <div class="form-check">
                                                                <p>
                                                                    <input type="radio" id="tdAmount" name="radio-group" value="1" checked="">
                                                                    <label for="tdAmount">Amount</label>
                                                                </p>
                                                                <p>
                                                                    <input type="radio" id="tdPercentage" name="radio-group" value="2" >
                                                                    <label for="tdPercentage">Percentage</label>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                    <div id="showDisAmount">
                                                        <div class="form-group row">
                                                            <label class="col-sm-5 col-form-label">Discount Amount</label>
                                                            <div class="col-sm-7">
                                                                <input class="form-control" id="dAmount" name="dAmount" type="text">
                                                            </div>
                                                        </div>      
                                                    </div>
                                                    <div id="showDisPer">
                                                        <div class="form-group row">
                                                            <label class="col-sm-5 col-form-label">Discount Percentage</label>
                                                            <div class="col-sm-7">
                                                                <input class="form-control" id="dPercentage" name="dPercentage" type="text" value="<?php echo $aOrder[0]['discount_amt'];?>" placeholder="%">
                                                            </div>
                                                        </div>      
                                                    </div>    
                                                    <div class="form-group row">
                                                        <label class="col-sm-5 col-form-label">Total Amount</label>
                                                        <div class="col-sm-7">
                                                            <input class="form-control" id="totalAmount" name="totalAmount" value="<?php echo $aOrder[0]['tot_amt'];?>" type="text">
                                                        </div>
                                                    </div>    
                                                    <div class="form-group row">
                                                        <label class="col-sm-5 col-form-label">Amount Paid</label>
                                                        <div class="col-md-7">
                                                            <input class="form-control" type="text" name="tot_amount" value="<?php echo $aOrder[0]['paid_amt'];?>" id="tot_amount">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-5 col-form-label">Account</label>
                                                        <?php
                                                            // echo '<pre>';
                                                            // print_r($getAllAccounts);
                                                            // echo '</pre>';
                                                        ?>
                                                        <div class="col-md-7">
                                                            <div class="row-fluid">
                                                                <select class="form-control" id="account" name="account">
                                                                    <option ctid="" value="">Select One</option>
                                                                    
                                                                    <?php foreach($getAllAccounts as $singleAccount):?>
                                                                    <option ctid="<?php echo $singleAccount['acc_type_id'];?>" value="<?php echo $singleAccount['id_account'];?>">
                                                                        <?php 
                                                                            if(!empty($singleAccount['account_name'])){
                                                                                echo $singleAccount['account_name'];
                                                                            }else{
                                                                                echo $singleAccount['bank_name'].'( '.$singleAccount['account_no'].' )';
                                                                            }
                                                                        ?>
                                                                    </option>
                                                                    <?php endforeach;?>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="fTransection"></div>
                                                    <div id="cardCheck"></div>
                                                </div>
                                            </div>
                                            <div class="element-box full-box">
                                                <div class="col-sm-12">                            
                                                    <h6 class="element-header">Order Description</h6>
                                                    <div class="form-group row">
                                                        <textarea name="description" class="form-control" rows="6"></textarea>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-5 col-form-label">Order Status</label>
                                                        <div class="row-fluid col-sm-7">
                                                            <select class="form-control" id="order_status" name="order_status">
                                                                <option value="1">Active</option>
                                                                <option value="2">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>        
                                        </form>   
                                            <div class="element-box full-box">
                                                <div class="col-sm-12">                            
                                                    <button id="bothFormSubmit" class="btn btn-primary right" type="submit"> Order placement</button>
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

        <script src="<?= base_url()?>themes/default/js/jquery.validate.min.js"></script>
        <script type="text/javascript">

            $( function() {
                $( "#orderDate" ).datepicker({ dateFormat: "yy-mm-dd" });
                $( "#deliveryDate" ).datepicker({ dateFormat: "yy-mm-dd" });
            });

            $(document).ready(function() {

                // load service data

                $('#serviceLoader').on('change', function() {
                  var sv = $(this).val();
                  if(sv != -1){
                    $.ajax({
                        url: '<?php echo site_url("tailoring/getaServiceById");?>',
                        type: 'get',
                        data: {sid: sv},
                    })
                    .done(function(res) {
                        $('#ServiceForm').html(res);
                    });
                  }else{
                    $('#ServiceForm').html('');
                  }
                });
            });

        

            $(document).on('change', '#account', function(){
               var aid = $(this).val();
               $.ajax({
                    url: '<?php echo site_url("tailoring/getSinAccount");?>',
                    type: 'get',
                    data: {aid: aid},
                })
                .done(function(res) {
                    $('#fTransection').html(res);
                    $('#cardCheck').html('');
                });
            });

            $(document).on('change', '#pay_method', function(){
                var aid = $(this).val();

                if(aid == 2){
                
                    var card = '<div class="form-group row">';
                            card += '<label class="col-sm-5 col-form-label">Card</label>';
                            card += '<div class="col-md-7">';
                                card += '<div class="row-fluid">';
                                    card += '<select class="form-control" id="ref_card" name="ref_card">';
                                        card += '<option value="0">Select One</option>';
                                        card += '<option value="3">Amex</option>';
                                        card += '<option value="2">Mastercard</option>';
                                        card += '<option value="4">Nexus</option>';
                                        card += '<option value="1">Visa</option>';
                                    card += '</select>';
                                card += '</div>';
                            card += '</div>';
                        card += '</div>';
                        card += '<div class="form-group row">';
                            card += '<label class="col-sm-5 col-form-label">Account/Card No</label>';
                            card += '<div class="col-md-7">';
                                card += '<input class="form-control" type="text" name="ref_acc_no">';
                            card += '</div>';
                        card += '</div>';
                    $('#cardCheck').html(card);
                    
                }else if(aid == 4){
                    var card = '<div class="form-group row" id="v_ref_bank" >';
                            card += '<label class="col-sm-5 col-form-label">Bank</label>';
                            card += '<div class="col-md-7">';
                                card += '<div class="row-fluid">';
                                    card += '<select class="form-control" data-live-search="true" id="ref_bank" name="ref_bank">';
                                        card += '<option value="0">Select One</option>';
                                        card += '<option value="4">ABC BANK</option>';
                                        card += '<option value="1">BRAC BANK</option>';
                                        card += '<option value="3">DBBL</option>';
                                        card += '<option value="5">ICBC BANK</option>';
                                    card += '</select>';
                                card += '</div>';
                            card += '</div>';
                        card += '</div>';
                        card += '<div class="form-group row">';
                                card += '<label class="col-sm-5 col-form-label">Account/Card No</label>';
                                card += '<div class="col-md-7">';
                                    card += '<input class="form-control" type="text" name="ref_acc_no">';
                                card += '</div>';
                            card += '</div>';
                        $('#cardCheck').html(card);
                }
            });   

             /* ....................................
                        Cost calculator start  
                ....................................*/

            var costCalculator = function(){

                var serPrices = $("input[name='serPrice[]']").map(function(){return $(this).val();}).get();
                var pQuantitys = $("input[name='pQuantity[]']").map(function(){return $(this).val();}).get();                
                var billType = $("input[name='billType[]']").map(function(){return $(this).val();}).get();

                var tprice = 0;
                var tprice2 = 0;

                for (i = 0; i < serPrices.length; i++) { 
                    tprice += (Number(serPrices[i])*Number(pQuantitys[i]));
                }

                $('#sCost').val(tprice);      

                for (i = 0; i < billType.length; i++) { 
                    tprice2 += Number(billType[i]);
                }     

                var disType = $('input[name="radio-group"]:checked').val();
                if(disType == 1){
                    var discount = $('input[name="dAmount"]').val();
                    var actPrice = Number(tprice)+Number(tprice2);
                    var dPercentage = (discount*100)/actPrice;

                    $('#dPercentage').val(dPercentage.toFixed(2));

                }else{
                    var dPercentage = $('input[name="dPercentage"]').val();
                    var tempTC = Number(tprice)+Number(tprice2);

                    var discount = (Number(tempTC)*Number(dPercentage))/100;
                    $('#dAmount').val(discount.toFixed(2));
                }

                var totalP = ((Number(tprice)+Number(tprice2))-Number(discount));

                $('#totalAmount').val(totalP); 

            }

            $(document).on('keyup', 'input[name^="serPrice[]"], input[name^="pQuantity[]"], input[name^="billType[]"], input[name^="dPercentage"], input[name^="dAmount"]', costCalculator);


            $('input[type=radio][name=radio-group]').change(costCalculator);


            $(function(){

              $('input[name="radio-group"]').click(function(){
                if ($(this).is(':checked')){

                  var rval = $(this).val();
                  if(rval == 1){
                    $('#showDisAmount').show();
                    $('#showDisPer').hide();                    
                  }else{
                    $('#showDisAmount').hide();
                    $('#showDisPer').show();  
                  }

                }
              });

            });

            
            $(document).on('click', '.serviceDelete', function(){

                  var ttrl = $("#serviceTable > tbody > tr").length;   

                  if(ttrl == 1){
                     $("#serviceTable > tfoot > tr").remove();     
                  }
                  var dd = confirm("Are you sure ? You want to delete this item ?");
                  if(dd){
                    $(this).closest("tr").remove();            
                  }

                  costCalculator();
            });
            

            /* ....................................
                        Cost calculator end  
                ....................................*/


            $(document).ready(function() {
                $('#orderSubmit1').validate({
                    rules: {
                        "customerName": {
                            required: true
                        },
                        "receiptNo": {
                            required: true
                        },
                        "orderDate": {
                            required: true
                        },
                        "deliveryDate": {
                            required: true
                        }
                    }
                });

                $('#orderSubmit2').validate({
                    rules: {
                        "serPrice[]": {
                            required: true,
                            number: true
                        },
                        "pQuantity[]": {
                            required: true,
                            number: true
                        },
                        "billType[]":{
                            number: true
                        }
                    },
                    submitHandler: function(form) {

                        var customerId = $('select[name^="customerName"]').val();
                        var receiptNo = $('input[name^="receiptNo"]').val();
                        var orderDate = $('input[name^="orderDate"]').val();
                        var deliveryDate = $('input[name^="deliveryDate"]').val();
                        var ctid = $('#account option:selected').attr('ctid');
                        

                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize()+ "&customerId=" +customerId+"&receiptNo=" +receiptNo+"&orderDate=" +orderDate+"&deliveryDate=" +deliveryDate+"&ctid=" +ctid,
                            success: function(response) {
                                // $('#answers').html(response);
                                alert(response);
                                console.log(response);
                            }            
                        });
                    }
                });

                $('#bothFormSubmit').on('click', function(e) {
                    e.preventDefault();
                    var forms = $('[id^="orderSubmit"]');
                    forms.each(function() {
                        $(this).valid();
                    });
                    if ($('#orderSubmit1').valid() && $('#orderSubmit2').valid()) {
                        $('#orderSubmit2').submit();
                    }
                });
            });   


        </script>

        <style type="text/css">
            #showDisPer{
                display: none;
            }
        </style>
