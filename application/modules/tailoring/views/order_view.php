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
                    <div class="element-box full-box">

                        <h6 class="element-header">Order View</h6>
                        <div class="row">
                            <div class="col-md-4">

                                <?php
                                    // echo '<pre>';
                                    // print_r($customer_info[0]);
                                    // echo '</pre>';
                                ?>

                                <div class="billing-des">
                                    <strong class="text-label">Customer Details</strong>
                                    <p><strong>Name:</strong>
                                        <?php echo $customer_info[0]['full_name'];?>
                                    </p>
                                    <p><strong>Code:</strong>
                                        <?php echo $customer_info[0]['customer_code'];?>
                                    </p>
                                    <p><strong>Phone:</strong>
                                        <?php echo $customer_info[0]['phone'];?>
                                    </p>
                                    <p><strong>Receipt No:</strong>
                                        <?php echo $aOrder[0]['receipt_no'];?>
                                    </p>
                                    <p><strong>Order date:</strong>
                                        <?php echo $aOrder[0]['order_date'];?>
                                    </p>
                                    <p><strong>Delivery Date:</strong>
                                        <?php echo $aOrder[0]['delivery_date'];?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="billing-des">
                                    <strong class="text-label">Order Description</strong>
                                    <span>
                                        <?php echo $aOrder[0]['notes'];?>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">


                                <form id="searchArray">
                                <div class="table-responsive bg service-list-table">
                                    <h3 class="element-header">Service List</h3>
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Service Name</th>
                                                <th>Note</th>
                                                <th>Measerments</th>
                                                <th>Design</th>
                                                <th>Quantity</th>
                                                <th class="t-a-r padding-right-20">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $tSerPri = 0; $i=1; foreach($serFullDt as $serFullDt):?>
                                                <tr>
                                                    <td>
                                                        <?php echo $i;?>
                                                    </td>
                                                    <td>
                                                        <?php echo $serFullDt['service_name'];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $serFullDt['notes'];?>
                                                    </td>
                                                    <td>
                                                        <div style="width: 100%">
                                                            <div class="d-flex align-items-center" style="width: 35px; float: left;"><button type="button" class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" data-toggle="modal" rel="tooltip" title="<?= lang("edit") ?>" data-target="#editMeasurement" onclick="measurementDetails('<?= $serFullDt['id_order_detail'] ?>');"><span class="glyphicon glyphicon-pencil"></span></button></div>
                                                            <div style="float: left;">
                                                                <?php 
                                                                foreach($serFullDt['measerDesign']['measure'] as $aMeaserDesign):

                                                                if($i == $aMeaserDesign['service_identify']):

                                                                ?>
                                                                <strong><?php echo $aMeaserDesign['field_id'];?>:</strong>
                                                                    <?php echo $aMeaserDesign['field_value'].'<br>';?>

                                                                <?php endif; endforeach;?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php foreach($serFullDt['measerDesign']['design'] as $aMeaserDesign):
                                                                if($i == $aMeaserDesign['service_identify']):
                                                                    if(!empty($aMeaserDesign['field_id'])):
                                                            ?>
                                                            
                                                            <img width="50px" src="<?php echo documentLink('tailoring').$aMeaserDesign['field_id'];?>">

                                                            <?php endif; endif; endforeach;?>
                                                    </td>
                                                    <td>
                                                        <?php echo $serFullDt['service_qty'];?>
                                                    </td>

                                                    <td class="t-a-r padding-20">
                                                        <?php echo $serFullDt['service_price'];?>
                                                    </td>

                                                </tr>
                                           
                                                <?php 

                                                    $tSerPri += ($serFullDt['service_qty'] * $serFullDt['service_price']);

                                                    $i++; endforeach;
                                                ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div id="statusMsg"></div>
                                <h3>Status Update</h3>
                                <?php
                                    $os = $aOrder[0]['order_status'];
                                    $add = $aOrder[0]['ac_delivery_date'];
                                ?>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select id="orderStatus" class="form-control">
                                            <option value="1" <?php if($os == 1){echo 'selected';}?>>Order Place</option>
                                            <option value="2" <?php if($os == 2){echo 'selected';}?>>Processing</option>
                                            <option value="3" <?php if($os == 3){echo 'selected';}?>>Delivered</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 actualDelivery">
                                        <?php 
                                            if(!empty($add) && $os == 3){
                                                echo "<p>Actual delivery date: ".$add."</p>";
                                            }
                                        ?>
                                    </div>
                                    <div class="col-sm-12">
                                        <button id="statusUpdate" class="btn btn-primary right" type="button">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                            <div class="col-md-4">

                                            <div class="billing-des billing-des-fix-top border-top-0">
                                                
                                                   <p class="ttl-amnt padding-right-15 padding-left-15 margin-top--25"><strong class="ttl-amnt ">Total:</strong>
                                                    <?php echo $tSerPri;?>
                                                </p>
                                                
                                                
                                                
                                                 <strong class="text-label">Previous Transection</strong>
                                                 <div class="bill-group">

                                                <?php 
                                                    $tBillPri = 0; foreach($serFullDt['measerDesign']['bill'] as $aMeaserDesign):
                                                    if(!empty($aMeaserDesign['field_value'])):
                                                ?>                                                               
                                                    <p><strong><?php echo $aMeaserDesign['field_id'];?>:</strong>
                                                    <?php echo $aMeaserDesign['field_value'];?></p> 
                                                <?php 
                                                    $tBillPri += $aMeaserDesign['field_value'];
                                                    endif;
                                                    endforeach;
                                                ?>

                                                
                                              
                                                <p class="ttl-amnt"><strong class="ttl-amnt">Sub Total:</strong>
                                                    <?php echo ($tSerPri+$tBillPri);?>
                                                </p>
                                                
                                                    <p><strong>Discount:</strong>
                                                    <?php echo $aOrder[0]['discount_amt'];?>
                                                </p> 
                                                
                                                   <p class="ttl-amnt"><strong class="ttl-amnt">Total:</strong>
                                                    <?php echo $aOrder[0]['tot_amt'];?>
                                                </p>
                                                
                                                <p><strong>Paid Amount:</strong>
                                                    <?php echo $aOrder[0]['paid_amt'];?>
                                                </p>
                                                <p><strong>Due Amount:</strong>
                                                    <?php echo $aOrder[0]['due_amt'];?>
                                                </p>
</div>

                                                <br>



                                                <strong class="text-label">New Transection</strong>
                                                <form action="<?php echo base_url().'tailoring/reTransection';?>" name="newTransection" method="post">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <label for="rAmount">Repaid Amount <span class="req">*</span></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="text" name="rAmount" id="rAmount" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-form-label">Account <span class="req">*</span></label>
                                                        <div class="col-md-12">
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
                                                    <!-- <div class=""> -->
                                                    <div id="fTransection"></div>
                                                    <div id="cardCheck"></div>
                                                    <!-- </div> -->
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">                                                           
                                                            <input type="hidden" name="orderId" value="<?php echo $aOrder[0]['id_order'];?>">
                                                            <input type="hidden" name="customerId" value="<?php echo $aOrder[0]['customer_id'];?>">
                                                            <input type="hidden" name="sale_id" value="<?php echo $aOrder[0]['sale_id'];?>">
                                                            <input type="hidden" name="due_amt" value="<?php echo $aOrder[0]['due_amt'];?>">
                                                            <input type="hidden" name="paidAmount" value="<?php echo $aOrder[0]['paid_amt'];?>"> 
                                                            <button class="btn btn-primary right" type="submit">Submit</button>
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
</div>
<div class="modal fade" id="editMeasurement" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Measerment List</h4>
            </div>
            <div class="modal-body" id="show_data_result">
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span><?= lang("close"); ?> </button>
                <button type="button" class="btn btn-primary" onclick="updateMeasurement()"><span class="glyphicon glyphicon-pencil"></span><?= lang("update"); ?> </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="<?= base_url()?>themes/default/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("form[name='newTransection']").validate({
            rules: {
                rAmount: {
                    required: true,
                    number: true
                },
                account:{
                    required: true,
                },
                pay_method:{
                    required: true,
                },
                ref_card:{
                    required: true,
                }
            },
            submitHandler: function (form) {
                // form.submit();
                var accType = $('#account option:selected').attr('ctid');        

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize() + "&accType=" + accType ,
                    success: function (response) {
                        location.reload();
                    }
                });

            }
        });
    });
    $(document).on('change', '#account', function () {
        var aid = $(this).val();
        $.ajax({
                url: '<?php echo site_url("tailoring/getSinAccount2");?>',
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
    
    $(document).on('click', '#statusUpdate', function () {
        var sid = $('#orderStatus').val();
        var oid = '<?php echo $this->uri->segment(3);?>';      
        if(sid != 3){
            $('.actualDelivery').html('');
        }
        $.ajax({
            url: '<?php echo site_url("tailoring/orderStatusUpdate");?>',
            type: 'get',
            data: {sid: sid, oid: oid}
        })
        .done(function (res) {
            if(res == 1){
                $('#showMessage').html('Update Successfull');
                $('#showMessage').show();
                if(sid == 3){
                    $('.actualDelivery').html('<p>Actual delivery date: <?php echo date("Y-m-d");?></p>');
                } 
                setTimeout(function () {
                    $('#showMessage').fadeOut(300);

                }, 3000);

            }else{
                $('#showMessage').html('Update Unsuccessfull');
                $('#showMessage').show();
                setTimeout(function () {
                    $('#showMessage').fadeOut(300);

                }, 3000);
            }
        });
    });

    $(document).on('change', '#pay_method', function () {
        var aid = $(this).val();

        if (aid == 2) {

            var card = '<div class="form-group row">';
            card += '<label class="col-sm-12 col-form-label">Card</label>';
            card += '<div class="col-md-12">';
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
            card += '<label class="col-sm-12 col-form-label">Account/Card No</label>';
            card += '<div class="col-md-12">';
            card += '<input class="form-control" type="text" name="ref_acc_no">';
            card += '</div>';
            card += '</div>';
            $('#cardCheck').html(card);

        } else if (aid == 4) {
            var card = '<div class="form-group row" id="v_ref_bank" >';
            card += '<label class="col-sm-12 col-form-label">Bank</label>';
            card += '<div class="col-md-12">';
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
            card += '<label class="col-sm-12 col-form-label">Account/Card No</label>';
            card += '<div class="col-md-12">';
            card += '<input class="form-control" type="text" name="ref_acc_no">';
            card += '</div>';
            card += '</div>';
            $('#cardCheck').html(card);
        }
    });
    function measurementDetails(id){
        $.ajax({
            url: '<?php echo site_url("tailoring/tailoring/measurement_details");?>',
            type: 'get',
            data: {id: id},
        })
        .done(function (res) {
            $('#show_data_result').html(res);    
        });
    }
    function updateMeasurement(){
        console.log($('#measurementListArray :input').serialize()); 
        $.ajax({
            url: '<?php echo site_url("tailoring/tailoring/measurement_update");?>',
            type: 'post',
            //data: {sid: sid, oid: oid,dataArray:dataArray},
            data: $('#measurementListArray :input').serialize(),
        })
        .done(function (res) {
            if(res==1){
                $('#showMessage').html('Update Unsuccessfull');
                $('#showMessage').show();
                setTimeout(function () {
                    $('#showMessage').fadeOut(300);
                    location.reload(true); 
                }, 300);
            }
            
        });
    }
</script>