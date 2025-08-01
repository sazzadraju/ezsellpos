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

                    <div class="top-btn full-box">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-12col-form-label"><?= lang("store_name"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <select class="select2" id="store_name" name="store_name">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($stores as $store) {
                                                    if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                                        echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                    } else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
                                                        echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                    }

                                                }
                                                ?>
                                            </select>
                                            <span class="error" id="error_store_name"></span> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                         <label class="col-sm-12 col-form-label">&nbsp;</label>
                                         <div class="col-sm-12">
                                            <input id="customer" name="acc_type" onchange="change_type(this)" value="customer" type="radio" checked="">
                                            <label for="customer">Customer</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label">&nbsp;</label>
                                        <div class="col-sm-12">
                                            <input id="supplier" onchange="change_type(this)" name="acc_type" value="supplier" type="radio">
                                            <label for="supplier">Supplier</label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div id="customer_div">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('customer_name') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('customer_name') ?>" type="text" id="name_customer" name="name_customer">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('phone') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('phone') ?>" type="text" name="phone_customer" id="phone_customer">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang('type_of_customer') ?> </label>
                                        <div class="col-sm-12">

                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" name="type_of_customer" id="type_of_customer">
                                                    <option value="0" selected><?= lang('select_one') ?></option>
                                                    <?php
                                                    if ($customer_type_list) {
                                                        foreach ($customer_type_list as $type_list) {
                                                            ?>
                                                            <option value="<?php echo $type_list['id_customer_type']; ?>"><?php echo $type_list['name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">City / Division</label>
                                        <div class="col-sm-12">
                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" id="city_division" name="city_division" onchange="locationAddress(value);">
                                                    <option value="0" selected>Select One</option>
                                                    <optgroup label="City Wise">
                                                        <?php
                                                        if($city_list){
                                                            foreach ($city_list as $list) {
                                                        ?>
                                                                <option value="city-<?php echo $list['id_city'];?>"><?php echo $list['city_name_en'];?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </optgroup>
                                                    <optgroup label="Division Wise">
                                                        <?php
                                                        if($division_list){
                                                            foreach ($division_list as $list) {
                                                        ?>
                                                                <option value="divi-<?php echo $list['id_division'];?>"><?php echo $list['division_name_en'];?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="division_id" id="division_id">
                                <input type="hidden" name="district_id" id="district_id">

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">Location</label>
                                        <div class="col-sm-12">
                                            <div class="row-fluid">
                                                <select class="select2" id="address_location" name="address_location" onchange="cityDistLoc(value);">
                                                    <option value="0">Select One</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="city_id" id="city_id">
                                <input type="hidden" name="city_location_id" id="city_location_id">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group row">
                                            <label class="col-sm-12 col-form-label">Address</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="cus_address" id="cus_address"></div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                        <div id="supplier_div" style="display: none">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('name') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('name') ?>" type="text"
                                                   id="name_supplier" name="name_supplier">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('phone') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('phone') ?>" type="text"
                                                   name="phone_supplier" id="phone_supplier">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('email') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('email') ?>" type="email"
                                                   name="email_supplier" id="email_supplier">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">&nbsp; </label>
                                        <div class="col-sm-12">
                                            <input type="checkbox" id="inactive_sup" name="inactive_sup" value="1">
                                            <label for="inactive_sup"><?= lang('inactive_supplier') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 pull-right">
                                <label class="col-sm-12 col-form-label">&nbsp;</label>
                                <button class="btn btn-info" onclick="searchFilter()"><?= lang('search') ?></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="search_row_error" class="error" style=" font-weight: bold;"></div>
                            <div class="searchData checkGroup" id="searchData">

                            </div>
                        </div>
                    </div>
                    <form class="form-horizontal" role="form" id="submit_data" action="" method="POST"
                          enctype="multipart/form-data">
                        <div class="element-box full-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <input type="hidden" id="segment_id" value="0">
                                        <table id="mytable" class="table table-bordred table-striped">
                                            <thead>
                                            <tr>
                                                <th><?= lang('type') ?></th>
                                                <th><?= lang('code') ?></th>
                                                <th><?= lang('name') ?></th>
                                                <th><?= lang('phone') ?></th>
                                                <th><?= lang('store') ?></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="add_more_section">


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="top-btn full-box" id="add_submit" style="display: none;">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang('title') ?></label>
                                        <div class='col-sm-12'>
                                            <div class='input-group' >
                                                <input type='text' class="form-control" name="title" id="title" />
                                            </div>
                                            <span id="title-error" class="span_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"
                                               for=""><?= lang('date') ?></label>
                                        <div class='col-sm-12'>
                                            <div class='input-group date' id='Date'>
                                                <input type='text' class="form-control" id="add_date" name="add_date"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>                                              
                                                </span>
                                            </div>
                                            <span id="Date-error" class="span_error"></span>
                                        </div>
                                    </div>
                                </div> -->
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
    function change_type(el){
        var id=el.value;
        if(id=='customer'){
            $('#customer_div').show();
            $('#supplier_div').hide();
        }else{
            $('#supplier_div').show();
            $('#customer_div').hide();
        }
    }

    $(function () {
        $('#ExpiryDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });

    $(function () {
        $('#AlertDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });


    $(function () {
        $('#Date').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });

    function searchFilter() {
        //page_num = page_num ? page_num : 0;
        $('#search_row_error').html('');
        var acc_type = $('[name^="acc_type"]:checked').val();
        var name_customer = $('#name_customer').val();
        var phone_customer = $('#phone_customer').val();
        var type_of_customer = $('#type_of_customer').val();
        var store_name = $('#store_name').val();
        var division_id = $('#division_id').val();
        var district_id = $('#district_id').val();
        var city_id = $('#city_id').val();
        var city_location_id = $('#city_location_id').val();
        var cus_address = $('#cus_address').val();

        var name_supplier = $('#name_supplier').val();
        var phone_supplier = $('#phone_supplier').val();
        var email_supplier = $('#email_supplier').val();
        var inactive_supplier ='';
        if($('#inactive_sup').prop('checked')) {
            inactive_supplier=1;
        }  else {
            inactive_supplier=2;
        }

        $err_count = 1;
        $('#error_store_name').html("");
        
        if (store_name == '0') {
            $err_count = 2;
            $('#error_store_name').html("Please select any one");
        }

        if ($err_count == 1) {
            if(acc_type=='customer'){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>sms/audience/search_customer',
                    data: 'name_customer=' + name_customer + '&phone_customer=' + phone_customer + '&type_of_customer=' + type_of_customer+ '&store_name=' + store_name+ '&division_id=' + division_id+ '&district_id=' + district_id+ '&city_id=' + city_id+ '&city_location_id=' + city_location_id+ '&cus_address=' + cus_address,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (html) {
                        $('#searchData').html(html);
                        $('.loading').fadeOut("slow");
                    }
                });
            }
            if(acc_type=='supplier'){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>sms/audience/search_supplier',
                    data: 'name_supplier=' + name_supplier + '&phone_supplier=' + phone_supplier + '&email_supplier=' + email_supplier+'&inactive_supplier='+inactive_supplier+ '&store_name=' + store_name,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (html) {
                        $('#searchData').html(html);
                        $('.loading').fadeOut("slow");
                    }
                });
            }
        }
    }


    var x = 1;
    var batch_inc = 1;
   

    function removeMore(id) {
        $("#" + id).remove();
        x--;
        var total_fields = parseInt($('input[name="total_num_of_fields"]').val());
        $('input[name="total_num_of_fields"]').val(total_fields - 1);
    }
    $('#product_name').on('change', '', function (e) {
        var product_id=this.value;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>product_details_by_id',
            data: 'id=' + product_id,
            success: function (data) {
                var result = $.parseJSON(data);
                $('#purchase_price').val(result[0].buy_price);
                $('#sale_price').val(result[0].sell_price);
                $('#pro_code').val(result[0].product_code);
            }
        });
    });

    
    function validate_data(){
        return true;
    }
    
    $("#submit_data").submit(function () {
        if (validate_data() != false) {
            var dataString = new FormData($(this)[0]);
            //console.log(dataString);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>sms/audience/submit_data',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    var result = $.parseJSON(result);
                    $('.loading').fadeOut("slow");
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $("#" + key).addClass("error");
                            $("#" + key).after(' <label class="error">' + value + '</label>');

                        });
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>sms/audience";

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
