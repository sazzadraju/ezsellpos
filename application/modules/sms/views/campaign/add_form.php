<style>
    #mytable input {
        width: 90px;
    }

    table tr td {
        padding: 4px !important;
    }

    ul.validation_alert {
        list-style: none;
    }

    ul.validation_alert li {
        padding: 5px 0;
    }

    .focus_error {
        border: 1px solid red;
        background: #ffe6e6;
    }

    .span_error {
        position: absolute;
        color: #da4444;
        width: 200%;
        background: #fff;

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
                    <form class="form-horizontal" role="form" id="submit_data" action="" method="POST"
                          enctype="multipart/form-data">
                    <div class="top-btn full-box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('campaign_name') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" id="campaign_name" name="campaign_name">
                                        <span class="error" id="error_campaign_name"></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row text-center">
                                    <label for="username" class="col-sm-12 field-label">Current Balance</label>
                                    <div class="col-sm-12">
                                        <label for="fullname" class="field">
                                            <h4 id="show_curr_balance"><?= $configs[0]->param_val?></h4>
                                            <input type="hidden" name="curr_balance" id="curr_balance" value="<?= $configs[0]->param_val?>">
                                            <input type="hidden" name="unit_price" id="unit_price" value="<?= $configs[0]->utilized_val?>">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("audience_name"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <select class="select2" id="audience_name" name="audience_name[]" multiple="multiple">
                                                <?php
                                                foreach ($audiences as $row) {
                                                    echo '<option actp="' . $row['total_row'] . '" value="' . $row['id_set_person'] . '">' . $row['title'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="error" id="error_audience_name"></span> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row text-center">
                                    <label for="username" class="col-sm-12 field-label">Total SMS</label>
                                    <div class="col-sm-12">
                                        <label for="fullname" class="field">
                                            <h4 id="show_total_sms"></h4>
                                            <input type="hidden" name="total_sms" id="total_sms">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('message') ?> </label>
                                    <div class="col-sm-12">
                                        <textarea rows="6" class="form-control" name="message" id="message" ></textarea>
                                        <span class="error" id="error_message"></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row text-center">
                                    <label for="username" class="col-sm-12 field-label">Text Count</label>
                                    <div class="col-sm-12">
                                        <label for="fullname" class="field">
                                            <h4 id="show_sms_count"></h4>
                                            <input type="hidden" name="sms_count" id="sms_count">

                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('total_sms') ?> </label>
                                    <div class="col-sm-12">
                                        <h4 id="show_sum_total_sms"></h4>
                                        <input type="hidden" name="sum_total_sms" id="sum_total_sms">
                                        <span class="error" id="error_sum_total_sms"></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('total_price') ?> </label>
                                    <div class="col-sm-12">
                                        <h4 id="show_sum_total_price"></h4>
                                        <input type="hidden" name="sum_total_price" id="sum_total_price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-sm-12 col-form-label" for="">&nbsp</label>
                                <button class="btn btn-primary" type="submit"> <?= lang('submit') ?></button>
                            </div>
                        </div>
                    </div>
                </form>    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="element-box">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Validation Alert Start-->
<div class="modal fade" id="validateAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang('delect_this_entry') ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('stock_in_val_msg') ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<script type="text/javascript">
    function countChar(val){
        var len = val.value.length;
        if (len >= 500) {
              val.value = val.value.substring(0, 500);
        } else {
              $('#charNum').text(500 - len);
        }
    };
    $(function () {
        $('#message').keyup(function () {
            //var max = ;
            var len = $(this).val().length;
            //alert(len);
            var sms=(len>160)? Math.ceil(len/153): 1;
            if (sms > 3) {
                $('#show_sms_count').text(' you have reached the limit');
            } else{
                $('#show_sms_count').text(len+'/'+sms);
                $('#sms_count').val(sms);
                
            }
            var total_sms=$('#total_sms').val()*1;
            //alert(total_sms+'=='+sms);
            var total=(total_sms*sms);
            $('#show_sum_total_sms').text(total);
            $('#sum_total_sms').val(total);
            var unit_price=$('#unit_price').val()*1;
            $('#show_sum_total_price').text((total*unit_price).toFixed(2));
            $('#sum_total_price').val((total*unit_price).toFixed(2));
            
        });
           
        $("select#audience_name").change(function(){
            //var sms = $('option:selected', this).attr('actp');
          //  var value = $('option:selected', this).val();
          var sms=0;
            $("#audience_name option:selected").each(function(){
                var optionValue = $( this ).val();
                var optionText = $(this).attr('actp')*1;
                //console.log("optionText",optionText);                
               // alert(optionValue+'=='+optionText);
                sms=(sms+optionText);
                //selections.push(optionValue);
            });
            //alert(value);
            $('#total_sms').val(sms);
            $('#show_total_sms').html(sms);
        });
        $('#ExpiryDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    }); 
    var x = 1;

    function removeMore(id) {
        $("#" + id).remove();
        x--;
        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
        $('input[name="total_num_of_fields"]').val(total_fields - 1);
    }
    

    
    function validate_data(){
         $('#error_sum_total_sms').html('');
         $('#error_campaign_name').html('');
         $('#error_message').html('');
          $('#error_audience_name').html('');
        var campaign_name=$('#campaign_name').val();
        var message=$('#message').val();
        var count=1;
        if(campaign_name==''){
            $('#error_campaign_name').html('This field is requird');
            count=2;
        }
        if(message==''){
            $('#error_message').html('This field is requird');
            count=2;
        }
        if (!$("#audience_name option:selected").length) {
            $('#error_audience_name').html('Please select any one');
            count=2;
        }
        var curr_balance=$('#curr_balance').val()*1;
        var sum_total_sms=$('#sum_total_sms').val()*1;
        if(sum_total_sms>curr_balance){
            $('#error_sum_total_sms').html('Your maximum SMS limit:'+curr_balance);
            count=2;
        }
        
        return count;
    }
    
    $("#submit_data").submit(function () {
        if (validate_data() == 1) {
            var dataString = new FormData($(this)[0]);
            //console.log(dataString);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>sms/campaign/submit_data',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    $('.loading').fadeOut("slow");
                    console.log(result);
                    alert(result);
                    
                    if (result != 'error') {
                        $('#showMessage').html('Success data inserted');
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>sms/campaign/success/"+result;

                        }, 1000);
                        $('.loading').fadeOut("slow");
                    } else {
                        $('#showMessage').html('<span class="error">Error in submit data</span>');
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>sms/campaign";

                        }, 3000);
                        $('.loading').fadeOut("slow");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        } else {
            return false;
        }
    });

</script>
