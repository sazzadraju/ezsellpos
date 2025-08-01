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
                                    <div id="flash-msg"></div>
                                    <form id="orderSubmit1">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label" for="">Customer Name</label>
                                                <?php 
                                                //$this->benchmark->mark('code_start');


                                                ?>
                                                 <input class="form-control" placeholder="Search... ex:(min 2 digits)" type="text"
                                                   id="customer_name" class="form-control" name="customer_name"
                                                   onkeyup="customer_list_suggest(this);"> 
                                                <!-- <select id="customerName" name="customerName" class="selectpicker form-control" data-live-search="true">
                                                    <option value="">Select Customer</option>
                                                    <?php foreach($getAllCustomer as $singleCustomer):?>
                                                        <option value="<?php echo $singleCustomer['id_customer'];?>">
                                                            <?php echo $singleCustomer['customer_code'].' '.$singleCustomer['customer_name'].' '.$singleCustomer['phone'];?>
                                                        </option>
                                                        <?php endforeach;?>
                                                </select> --> 
                                                <?php 
                                                 // $this->benchmark->mark('code_end');
                                                 // echo $this->benchmark->elapsed_time('code_start', 'code_end');
                                                ?>
                                                <input type="hidden" name="customerName" id="customerName">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label" for="">Receipt No.</label>
                                                <input class="form-control" name="receiptNo" value="<?php echo $receipt_no;?>" type="text" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="customerInfo"></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label" for="">Order Date</label>
                                                    <div class="col-sm-12">
                                                        <div class="input-group date orderDate">
                                                            <input type="text" name="orderDate" id="orderDate" class="form-control orderDate">
                                                            <span class="input-group-addon">
                                                              <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                        <label id="orderDate-error" class="error" for="orderDate"></label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-6">

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label" for="">Delivery Date</label>
                                                    <div class="col-sm-12">
                                                        <div class="input-group date deliveryDate">
                                                            <input type="text" name="deliveryDate" id="deliveryDate" class="form-control deliveryDate">
                                                            <span class="input-group-addon">
                                                              <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                        <label id="deliveryDate-error" class="error" for="deliveryDate"></label>
                                                    </div>
                                                </div>

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
                                                    <option value="<?php echo $svalue['id_service'];?>">
                                                        <?php echo $svalue['service_name'];?>
                                                    </option>
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
                                            <table id="serviceTable" class="table table-bordred table-striped margin-bottom-5">
                                                <thead>
                                                    <tr style="font-size:12px">
                                                        <th>Service Name</th>
                                                        <th>Price</th>
                                                        <th>Qty</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>

                                                </tfoot>
                                            </table>
                                            <div class="ser-error"></div>
                                        </div>



                                        <?php
                                                        // echo '<pre>';
                                                        // print_r($billingTypes);
                                                        // echo '</pre>';
                                                    ?>
                                            <?php $bi = 0; foreach($billingTypes as $sBillt):?>
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-8 col-sm-8-custom col-form-label" for="billType[]">
                                                            <?php echo $sBillt['field_name'];?>
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <input id="billTypeId-<?php echo $bi;?>" name="billTypeId[]" value="<?php echo $sBillt['id_field'];?>" type="hidden">
                                                            <input class="form-control t-a-r" id="billId-<?php echo $bi;?>" name="billType[]" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $bi++; endforeach;?>


                                                    <div class="col-md-8 col-md-8-custom-2">
                                                        
                                                            <label class="col-sm-12 col-form-label t-a-r total-border">Sub Total:</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <input class="form-control" id="subTotal" name="subTotal" type="text" placeholder="000" readonly>


                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="col-md-5 col-md-5-custom">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-12 col-form-label">Discount Type</label>

                                                                    <div class="form-check">
                                                                        <div class="col-sm-6">
                                                                            <input type="radio" id="tdAmount" name="radio-group" value="1" checked="">
                                                                            <label for="tdAmount">Amount</label>

                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <input type="radio" id="tdPercentage" name="radio-group" value="2">
                                                                            <label for="tdPercentage">Percentage</label>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
          <div class="col-md-3">
                                                                <div class="col-md-12">
                                                                    <div class="form-group row margin-top-10">
                                                                        <div id="showDisAmount">
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-12 col-form-label"> </label>
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control t-a-r" id="dAmount" name="dAmount" type="text">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div id="showDisPer">
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-12 col-form-label"> </label>
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control t-a-r" id="dPercentage" name="dPercentage" type="text" placeholder="%">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="col-md-12">
                                                                    <div class="form-group row margin-top-10"> 
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-12 col-form-label"> </label>
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control t-a-r" id="totalDis" name="totalDis" type="text" readonly>
                                                                                </div>
                                                                            </div> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                  
                                                            <div class="col-md-8 col-md-8-custom-2">
                                                                   <label class="col-sm-12 col-form-label t-a-r total-border">Total:</label>
                                                            </div>
                                                            <div class="col-md-3">

                                                                <div class="form-group row"> 
                                                                    <div class="col-sm-12">
                                                                        <input class="form-control  totalAmount" id="totalAmount" name="totalAmount" type="text" placeholder="000" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-8 col-sm-8-custom col-form-label">Amount Paid</label>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control t-a-r" type="text" name="paid_amount" id="paid_amount">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-8 col-sm-8-custom col-form-label">Due Amount</label>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control t-a-r" type="text" name="due_amount" id="due_amount" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">

                                                        <div class="col-md-12 fix-right-padding">
                                                            <div class="col-md-12">

                                                                <div class="form-group row">
                                                                    <label class="col-sm-5 col-form-label">Account </label>
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

                                                            <div class="col-sm-12">

                                                                <strong class="text-label">Order Description</strong>
                                                                <div class="col-sm-12">

                                                                    <div class="form-group row">
                                                                        <textarea name="description" class="form-control" rows="6"></textarea>
                                                                        <input type="hidden" name="order_status" value="1">
                                                                    </div>

                                                                </div>
                                                                <button id="orderPreview" class="btn btn-primary right" type="button"> Order preview</button>
                                                            </div>
                                                        </div>


                                                    </div>


                                    </div>



                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
//$this->output->enable_profiler(TRUE);
?>

<!-- The Modal -->
<div class="modal fade" id="previewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">
                <h6 class="element-header col-md-10">Order Preview</h6>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="element-wrapper">
                            <div class="element-box full-box">
                                <div class="row">

                                    <div id="previewContent"></div>

                                    <div class="col-md-12">
                                        <button id="orderWithInvoice" class="btn btn-primary" type="submit"> Order placement & print Invoice</button>
                                        <button id="bothFormSubmit" class="btn btn-primary right" type="submit"> Order placement</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url()?>themes/default/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    function customer_list_suggest(elem) {

        // var acc_type = $('[name^="acc_type"]:checked').val();
        // alert(acc_type);
        var request = $('#customer_name').val();
        //var store_id = $('#store_from').val();
        var ajaxTime= new Date().getTime();
        $("#customer_name").autocomplete({
            source: "<?php echo base_url(); ?>tailoring/tailoring/get_customer_auto_list?request=" + request ,
            focus: function (event, ui) {
                console.log(ui);
                event.preventDefault();
                $("#customer_name").val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $("#customer_name").val('');
                $("#customer_name").val(ui.item.label);
                $("#customerName").val(ui.item.value);
                //$("#batch_s").val(ui.item.batch_no);
                selectCustomer(ui.item.value);
                
            }
        });
    }
    $(document).ready(function () {

        // load service data

        $('#serviceLoader').on('change', function () {
            var sv = $(this).val();
            var customer_id=$('#customerName').val();
            if (sv != -1) {
                $.ajax({
                        url: '<?php echo site_url("tailoring/getaServiceById");?>',
                        type: 'get',
                        data: {
                            sid: sv,
                            customer_id:customer_id
                        },
                    })
                    .done(function (res) {
                        $('#ServiceForm').html(res);
                        $('.ser-error').remove();
                    });
            } else {
                $('#ServiceForm').html('');
            }
        });
    });

    $(document).on('change', '#account', function () {
        var aid = $(this).val();
        $.ajax({
                url: '<?php echo site_url("tailoring/getSinAccount");?>',
                type: 'get',
                data: {
                    aid: aid
                },
            })
            .done(function (res) {
                $('#fTransection').html(res);
                $('#cardCheck').html('');
            });
    });

    $(document).on('change', '#pay_method', function () {
        var aid = $(this).val();

        if (aid == 2) {

            var card = '<div class="form-group row">';
            card += '<label class="col-sm-5 col-form-label">Card <span class="req">*</span></label>';
            card += '<div class="col-md-7">';
            card += '<div class="row-fluid">';
            card += '<select class="form-control" id="ref_card" name="ref_card" required>';
            card += '<option >Select One</option>';
            card += '<option value="3">Amex</option>';
            card += '<option value="2">Mastercard</option>';
            card += '<option value="4">Nexus</option>';
            card += '<option value="1">Visa</option>';
            card += '</select>';
            card += '</div>';
            card += '</div>';
            card += '</div>';
            card += '<div class="form-group row">';
            card += '<label class="col-sm-5 col-form-label">Account/Card No <span class="req">*</span></label>';
            card += '<div class="col-md-7">';
            card += '<input class="form-control" type="text" name="ref_acc_no" required>';
            card += '</div>';
            card += '</div>';
            $('#cardCheck').html(card);

        } else if (aid == 4) {
            var card = '<div class="form-group row" id="v_ref_bank" >';
            card += '<label class="col-sm-5 col-form-label">Bank <span class="req">*</span></label>';
            card += '<div class="col-md-7">';
            card += '<div class="row-fluid">';
            card += '<select class="form-control" data-live-search="true" id="ref_bank" name="ref_bank" required>';
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
            card += '<label class="col-sm-5 col-form-label">Account/Card No <span class="req">*</span></label>';
            card += '<div class="col-md-7">';
            card += '<input class="form-control" type="text" name="ref_acc_no" required>';
            card += '</div>';
            card += '</div>';
            $('#cardCheck').html(card);
        }
    });

    /* ....................................
               Cost calculator start  
       ....................................*/

    var costCalculator = function () {

        var serPrices = $("input[name='serPrice[]']").map(function () {
            return $(this).val();
        }).get();
        var pQuantitys = $("input[name='pQuantity[]']").map(function () {
            return $(this).val();
        }).get();
        var billType = $("input[name='billType[]']").map(function () {
            return $(this).val();
        }).get();

        var tprice = 0;
        var tprice2 = 0;

        for (i = 0; i < serPrices.length; i++) {
            tprice += (Number(serPrices[i]) * Number(pQuantitys[i]));
            $('#pTotal-'+i).val((Number(serPrices[i]) * Number(pQuantitys[i])));
        }

        $('#sCost').val(tprice);

        for (i = 0; i < billType.length; i++) {
            tprice2 += Number(billType[i]);
        }

        var subTotl = Number(tprice) + Number(tprice2);

        $('#subTotal').val(subTotl);

        var disType = $('input[name="radio-group"]:checked').val();
        if (disType == 1) {
            var discount = $('input[name="dAmount"]').val();
            var actPrice = Number(tprice) + Number(tprice2);
            var dPercentage = (discount * 100) / actPrice;

            $('#dPercentage').val(dPercentage.toFixed(2));
            $('#totalDis').val(discount);

        } else {
            var dPercentage = $('input[name="dPercentage"]').val();
            var tempTC = Number(tprice) + Number(tprice2);

            var discount = (Number(tempTC) * Number(dPercentage)) / 100;
            $('#dAmount').val(discount.toFixed(2));
            $('#totalDis').val(discount);
        }

        var totalP = ((Number(tprice) + Number(tprice2)) - Number(discount));

        $('#totalAmount').val(totalP);

        var pa = $('#paid_amount').val();

        var ta = $('#totalAmount').val();

        // alert(pa);
        // alert(ta);

        var da = (ta - pa);

        $('#due_amount').val(da);

    }

    $(document).on('keyup', 'input[name^="paid_amount"], input[name^="serPrice[]"], input[name^="pQuantity[]"], input[name^="billType[]"], input[name^="dPercentage"], input[name^="dAmount"]', costCalculator);


    $('input[type=radio][name=radio-group]').change(costCalculator);


    $(function () {

        $('input[name="radio-group"]').click(function () {
            if ($(this).is(':checked')) {

                var rval = $(this).val();
                if (rval == 1) {
                    $('#showDisAmount').show();
                    $('#showDisPer').hide();
                } else {
                    $('#showDisAmount').hide();
                    $('#showDisPer').show();
                }

            }
        });

    });


    $(document).on('click', '.serviceDelete', function () {

        var ttrl = $("#serviceTable > tbody > tr").length;

        if (ttrl == 1) {
            $("#serviceTable > tfoot > tr").remove();
        }
        var dd = confirm("Are you sure ? You want to delete this item ?");
        if (dd) {
            $(this).closest("tr").remove();
        }

        costCalculator();
    });


    /* ....................................
                Cost calculator end  
        ....................................*/

    /* ....................................
                Order submit 
        ....................................*/
            
    $(document).ready(function() {
        $('#orderSubmit1').validate({
            rules: {
                "customer_name": {
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

                var customerId = $('input[name^="customerName"]').val();
                var receiptNo = $('input[name^="receiptNo"]').val();
                var orderDate = $('input[name^="orderDate"]').val();
                var deliveryDate = $('input[name^="deliveryDate"]').val();
                var ctid = $('#account option:selected').attr('ctid');
                

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize()+ "&customerId=" +customerId+"&receiptNo=" +receiptNo+"&orderDate=" +orderDate+"&deliveryDate=" +deliveryDate+"&ctid=" +ctid,
                    success: function(response) {
                        if(response > 0){

                            $('#previewModal').modal('hide');
    
                            var btnId = localStorage.getItem("btnId")
                            
                            if(btnId == 1){
                                window.location = '<?php echo base_url().'tailoring/order';?>'; 
                            }
                            if(btnId == 2){
                                // print
                                var w = window.open('<?php echo base_url().'tailoring/order_invoice';?>/'+response,'name','width=800,height=500', '_blank');
                                w.print({
                                    globalStyles: false,
                                    mediaPrint: true,
                                    stylesheet: "<?= base_url(); ?>themes/default/css/tailoring_order_invoice.css",
                                    iframe: false,
                                    noPrintSelector: ".avoid-this"
                                });
                                // empty form
                                window.location = '<?php echo base_url().'tailoring/order';?>'; 

                            }

                        }   
                        
                    }                        
                });
            }
        });

        $('#bothFormSubmit').on('click', function(e) {
            e.preventDefault();

            $('#orderWithInvoice').hide();

            $(this).html('Order processing ....');

            localStorage.setItem("btnId", 1);

            var forms = $('[id^="orderSubmit"]');
            forms.each(function() {
                $(this).valid();
            });
            if ($('#orderSubmit1').valid() && $('#orderSubmit2').valid()) {
                $('#orderSubmit2').submit();
                // alert('ok');
            }
        });

        $('#orderWithInvoice').on('click', function(e) {
            e.preventDefault();

            $('#bothFormSubmit').hide();
            $(this).html('Order processing ....');
            localStorage.setItem("btnId", 2);

            var forms = $('[id^="orderSubmit"]');
            forms.each(function() {
                $(this).valid();
            });
            if ($('#orderSubmit1').valid() && $('#orderSubmit2').valid()) {
                $('#orderSubmit2').submit();
            }
        });

        

    });   

    /* ....................................
                Order submit end
        ....................................*/

    /* ....................................
                Order Preview start
        ....................................*/

    $('#orderPreview').on('click', function(e) {
        e.preventDefault();

        var forms = $('[id^="orderSubmit"]');
        forms.each(function() {
            $(this).valid();
        });
        if ($('#orderSubmit1').valid() && $('#orderSubmit2').valid()) {

            var ttrl = $("#serviceTable > tbody > tr").length;  

            if(ttrl != 0){
                var customerId = $('input[name^="customerName"]').val();
                var receiptNo = $('input[name^="receiptNo"]').val();
                var orderDate = $('input[name^="orderDate"]').val();
                var deliveryDate = $('input[name^="deliveryDate"]').val();
                var ctid = $('#account option:selected').attr('ctid');               

                $.ajax({
                    url: '<?php echo base_url(); ?>tailoring/order_preview',
                    type: "post",
                    data: $('#orderSubmit2').serialize()+ "&customerId=" +customerId+"&receiptNo=" +receiptNo+"&orderDate=" +orderDate+"&deliveryDate=" +deliveryDate+"&ctid=" +ctid,
                    success: function(response) {
                        // alert(response);
                        // console.log(response);
                        $('#previewContent').html(response);
                        $('#previewModal').modal('show');
                    }            
                });
            }else{
                $( ".ser-error" ).html( "<p class='error'>No service is entered</p>" );
            }                    
        }
    });


    /* ....................................
                Order Preview end
        ....................................*/

</script>


<script>
    $(function () {

        $('.orderDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

        $('.deliveryDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

        
    });

    $('#customerName').change(function() {
       var cid = $(this).val();
       if(cid){
            $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url();?>tailoring/getCustomerInfoById/',
                  data: 'cid=' + cid,
                  success: function (html) {
                      $('.customerInfo').html(html);
                  }
            });
        }else{
            $('.customerInfo').html('');

        }
        
    });
    function selectCustomer(id){
        if(id){
            $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url();?>tailoring/getCustomerInfoById/',
                  data: 'cid=' + id,
                  success: function (html) {
                      $('.customerInfo').html(html);
                  }
            });
        }else{
            $('.customerInfo').html('');

        }

    }

</script>

<style type="text/css">
    #showDisPer {
        display: none;
    }
</style>