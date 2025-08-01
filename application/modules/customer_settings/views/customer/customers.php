<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>
<div class="col-md-12">
    <?php
    $mess = '';
    if ($this->session->flashdata('success') == TRUE): ?>
        <?php $mess = $this->session->flashdata('success'); ?>
        <script>
            $(document).ready(function () {
                $('#showMessage').show();
                setTimeout(function () {
                    $('#showMessage').fadeOut(300);

                }, 3000);
            });
        </script>
    <?php endif; ?>
    <div class="showmessage" id="showMessage" style="display: none;"><?= $mess ?></div>
</div>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="top-btn full-box">
                        <form action="">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('customer_name') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('customer_name') ?>" type="text" id="name_customer" name="name_customer">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('phone') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('phone') ?>" type="text" name="phone_customer" id="phone_customer">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
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
                                <div class="col-md-3 col-sm-12">
                                   <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang("store"); ?></label>
                                        <div class="col-sm-12">
                                           <!-- <div class="row-fluid"> -->
                                            <select class="select2" data-live-search="true" id="store_id" name="store_id">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                   <?php
                                                    foreach ($stores as $store) {
                                                        echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                    }
                                                   ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">City / Division</label>
                                        <div class="col-sm-12">
                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" id="city_division" name="city_division" onchange="srcLocationAddress(value);">
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

                                <input type="hidden" name="src_division_id" id="src_division_id">
                                <input type="hidden" name="src_district_id" id="src_district_id">

                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">Location</label>
                                        <div class="col-sm-12">
                                            <div class="row-fluid">
                                                <select class="select2" id="src_address_location" name="src_address_location" onchange="srcCityDistLoc(value);">
                                                    <option value="0">Select One</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="src_city_id" id="src_city_id">
                                <input type="hidden" name="src_city_location_id" id="src_city_location_id">
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group row">
                                            <label class="col-sm-12 col-form-label">Address</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="cus_address" id="cus_address"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">

                                <div class="col-md-3 pull-right">

                                    <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                    <button class="btn btn-primary btn-rounded center" type="button" onclick="searchFilter();"><i class="fa fa-search"></i>Search</button>
                                    <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV Export</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>



                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url() . 'customer/csv' ?>" class="btn btn-primary bottom-10 right"
                                ><?= lang("import_from_csv"); ?></a>
                                <button style="margin-right: 10px;" data-toggle="modal" data-target="#add" class="btn btn-primary btn-rounded right" type="button" onclick="addCustomer()"><?= lang('add_customer') ?></button>
                                <?php 
                                if($sms_due_config[0]->sms_send==1){
                                ?>
                                    <button style="margin-right: 10px;" data-toggle="modal" data-target="#due_customers" class="btn btn-primary btn-rounded right" type="button" onclick="sms_due_customers()">Send SMD Due Customers </button>
                                <?php 
                                }
                                ?>
                            </div>
                        </div>
                        <!---Add Modal BOX-->

                        <div id="add" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="element-header margin-0"><?= lang('customer') ?> <span class="close" data-dismiss="modal">&times;</span></h6>
                                    </div>
                                    <?php echo form_open_multipart('', array('id' => 'customer_info', 'class' => 'cmxform')); ?>
                                    <div class="modal-body">
                                        <input type="hidden" name="curr_balance" id="curr_balance" value="<?= $configs[0]->param_val?>">
                                        <input type="hidden" name="unit_price" id="unit_price" value="<?= $configs[0]->utilized_val?>">
                                        <input type="hidden" name="sms_send" id="sms_send" value="<?= $sms_config[0]->sms_send?>">
                                        <?php if($configs[0]->param_val<1 && $sms_config[0]->sms_send ==1){
                                            echo '<h3 class="error">Your SMS balance is zero. Please recharge.</h3>';
                                        }
                                        ?>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label" for=""><?= lang('membership_id') ?><span class="req">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" placeholder="<?= lang('membership_id') ?>" type="text" id="customer_code" name="customer_code" value="<?php echo time(); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label"><?= lang('customer_type') ?><span class="req">*</span></label>
                                                    <div class="col-sm-12">

                                                        <div class="row-fluid">
                                                            <select class="form-control" data-live-search="true" id="customer_type_id" name="customer_type_id">
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
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label" for=""><?= lang('full_name') ?><span class="req">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" placeholder="<?= lang('full_name') ?>" type="text" id="customer_name" name="full_name">
                                                    </div>
                                                </div></div>

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-form-label col-sm-12" for=""><?= lang('email') ?></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" placeholder="<?= lang('email') ?>" type="email" id="email" name="c_email">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label" for=""><?= lang('phone') ?><span class="req">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" placeholder="<?= lang('phone') ?>" type="text" id="phone" name="phone">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label"><?= lang('gender') ?></label>
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-6">
                                                            <input id="Male1" value="male" name="gender" checked="" type="radio">
                                                            <label for="Male1"><?= lang('male') ?></label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input id="Female1" value="female" name="gender" type="radio">
                                                            <label for="Female1"><?= lang('female') ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label" for=""><?= lang('dob') ?></label>
                                                    <div class='col-sm-12'>
                                                        <div class='input-group date' id='DOB'>
                                                            <input type='text' class="form-control" id="birth_date" name="birth_date"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label"><?= lang('marital_status') ?></label>
                                                    <div class="col-sm-12">
                                                        <div class="row-fluid">
                                                            <select class="form-control" id="marital_status" name="marital_status">
                                                                <option value="0" selected><?= lang('select_one') ?></option>
                                                                <option value="Married">Married</option>
                                                                <option value="Unmarried">Unmarried</option>
                                                                <option value="Divorced">Divorced</option>
                                                                <option value="Widowed">Widowed</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label" for=""><?= lang('anniversary_date') ?></label>
                                                    <div class='col-sm-12'>
                                                        <div class='input-group date' id='AD'>
                                                            <input type='text' class="form-control" id="anniversary_date" name="anniversary_date"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label"><?= lang('address_type') ?></label>
                                                    <div class="col-sm-12">
                                                        <div class="row-fluid">
                                                            <select class="select2" id="address_type" name="address_type2">
                                                                <option value="0"><?= lang('select_one') ?></option>
                                                                <option value="Present Address">Present Address</option>
                                                                <option value="Permanent Address">Permanent Address</option>
                                                                <option value="Shipping Address">Shipping Address</option>
                                                                <option value="Billing Address">Billing Address</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label"><?= lang('city_division') ?></label>
                                                    <div class="col-sm-12">
                                                        <div class="row-fluid">
                                                            <select class="select2" data-live-search="true" id="city_division" name="city_division2" onchange="locationAddress(value);">
                                                                <option value="0" selected><?= lang('select_one') ?></option>
                                                                <optgroup label="City">
                                                                    <?php
                                                                    if ($city_list) {
                                                                        foreach ($city_list as $list) {
                                                                            ?>
                                                                            <option value="city-<?php echo $list['id_city']; ?>"><?php echo $list['city_name_en']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>

                                                                </optgroup>
                                                                <optgroup label="Division">
                                                                    <?php
                                                                    if ($division_list) {
                                                                        foreach ($division_list as $list) {
                                                                            ?>
                                                                            <option value="divi-<?php echo $list['id_division']; ?>"><?php echo $list['division_name_en']; ?></option>
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

                                            <div class="col-md-3">
                                                <input type="hidden" name="division_id" id="division_id">
                                                <input type="hidden" name="district_id" id="district_id">

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label"><?= lang('location') ?></label>
                                                    <div class="col-sm-12">
                                                        <div class="row-fluid">
                                                            <select class="select2" id="address_location" name="address_location2" onchange="cityDistLoc(value);">
                                                                <option value="0"><?= lang('select_one') ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
</div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="city_id" id="city_id">
                                                <input type="hidden" name="city_location_id" id="city_location_id">

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label"><?= lang('address') ?></label>
                                                    <div class="col-sm-12">
                                                        <textarea class="form-control" rows="3" name="addr_line_1" id="addr_line_1" value="addr_line_1"></textarea>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-md-3"> 
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-form-label"><?= lang('customer_photo') ?></label>
                                                    <div class="col-sm-12">
                                                        <input type="file" name="profile_img" id="profile_img">
                                                        <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("file_type"); ?></p>
                                                    </div>
                                                </div> 
                                            </div>
</div>

                                    </div>

                                    <div class="modal-footer">
                                        <input class="btn btn-primary" type="submit" value="<?= lang('submit') ?>"> </button>

                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
                                    </div>
                                    <input type="hidden" id="total_num_of_fields" name="total_num_of_fields" value="1">
                                    <?php echo form_close(); ?>
                                </div>


                            </div>
                        </div>

                        <!---Add Modal BOX-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php
                                    $this->load->view('customer/customer_info_data');
                                    ?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="due_customers" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Due Customer List<span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="info-1">
                        <form class="form-horizontal" role="form" id="submit_send_sms" action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="error text-center bold" id="show_error"></div>
                            <div class="col-md-3 bold text-right">Available SMS :
                                <input type="hidden" name="unit_price" value="<?= $configs[0]->utilized_val?>">
                            </div>
                            <div class="col-md-1 bold" id="available_sms"><?= $configs[0]->param_val?></div>
                            <div class="col-md-3 bold text-right">Select SMS :</div>
                            <div class="col-md-1 bold" id="send_sms">0</div>
                            
                        </div>
                        <table id="mytable" class="table table-striped">
                            <thead>
                                <th><input type="checkbox" name="check_all" value="checkAll" id="CheckAll"  /><label for="CheckAll"><?=lang('check_all')?></label> </th>
                                <th><?=lang('customer_name')?></th>
                                <th><?=lang('customer_code')?></th>
                                <th><?=lang('type')?></th>
                                <th class="center"><?=lang('phone')?></th>
                                <th class="text-right">Balance</th>
                            </thead>
                            <tbody class="checkGroup">
                            <?php
                                $count = 1;
                                $total_balance = 0;
                                if(!empty($due_customers)){
                                    foreach ($due_customers as $list) {
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" id="<?= $count ?>" name="id_check[]" value="<?= $list['id_customer'] ?>">
                                        <label style="margin-bottom: 0px;" for="<?= $count ?>">&nbsp;</label>
                                        <input type="hidden" name="phone[]" id="phone_<?=$count?>" value="<?= $list['phone'] ?>">
                                        <input type="hidden" name="name[]"  id="name_<?=$count?>" value="<?= $list['full_name'] ?>">
                                    </td>
                                    <td><?php echo $list['full_name'];?></td>
                                    <td><?php echo $list['customer_code'];?></td>
                                    <td><?php echo $list['type_name'];?></td>
                                    <td class="center"><?php echo $list['phone'];?></td>
                                    <td class="text-right" id="ch_balance_<?=$list['id_customer']?>"><?php echo $list['balance'];
                                    $total_balance+= $list['balance']
                                    ?></td>

                                </tr>

                                <?php 
                                $count++;
                                    }
                                }
                            ?>        
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-center"> Total Customer: <?= $count-1?></th>
                                    <th class="text-right"><?=lang('total')?></th>
                                    <th class="text-right"><?=$total_balance?></th>
                                </tr>
                            </tfoot>

                            </table>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send SMS</button>
            </div>
        </div>

    </div>
</div>

<!--View Modal Start-->
<div id="view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang('customer_name') ?>View Customer <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="info-1">
                        <div class="manage-point">
                            <h6 class="element-header"><?= lang('customer_name') ?>Manage Point:</h6>
                            <ul>
                                <li class="v active">
                                    <button class="btn btn-success btn-xs" data-toggle="tab" href="#home"><span class="glyphicon glyphicon-eye-open"></span></button>
                                </li>
                                <li class="e">
                                    <button class="btn btn-primary btn-xs" data-toggle="tab" href="#menu1"><span class="glyphicon glyphicon-pencil"></span></button>
                                </li>
                                <li class="ex">
                                    <button class="btn btn-warning btn-xs" data-toggle="tab" href="#menu2"><span class="fa fa-exchange"></span></button>
                                </li>
                            </ul>
                            <div class="tab-content point">
                                <div id="home" class="tab-pane fade in view active">
                                    <h3><?= lang('customer_name') ?>Point</h3>
                                    <p>446.5</p>
                                </div>
                                <div id="menu1" class="tab-pane fade edit">
                                    <form class=""> 
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label class="col-sm-12 col-form-label" for=""><?= lang('customer_name') ?>Edit Point</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" placeholder="Station Name" type="text">
                                                </div>

                                            </div>
                                            <div class="col-sm-3">

                                                <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                                <div class="form-buttons-w">
                                                    <button class="btn btn-primary" type="submit"><?= lang('customer_name') ?>Update</button>
                                                </div>
                                            </div>


                                        </div>
                                    </form>
                                </div>
                                <div id="menu2" class="tab-pane fade exchange">
                                    <h3><?= lang('customer_name') ?>Menu 2</h3>
                                    <p><?= lang('customer_name') ?>Some content in menu 2.</p>
                                </div>
                            </div>
                        </div>
                        <div class="receive-payment">

                            <h6 class="element-header"><?= lang('customer_name') ?>Receive Payment:</h6>
                            <div class="rcv-pmnt"><strong><?= lang('customer_name') ?>Transaction No:</strong> 4523453453</div>
                            <div class="rcv-pmnt"><strong><?= lang('customer_name') ?>Amount:</strong> 99999tk</div>
                            <div class="rcv-pmnt"><strong><?= lang('customer_name') ?>Particular:</strong> 858.745.5577</div>
                            <div class="rcv-pmnt"><strong><?= lang('customer_name') ?>Date:</strong> 02/09/1994</div>
                            <div class="rcv-pmnt"><strong><?= lang('customer_name') ?>Payment Methods:</strong> Bkash</div>

                        </div>
                        <div class="membership-card-generation">
                            <div class="col-md-8 pad-left-0">
                                <h6 class="element-header"><?= lang('customer_name') ?>Membership Card Generation</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Card Generation
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Active</a></li>
                                        <li><a href="#">Inactive</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <a href="transaction_history.php" class="btn btn-success">Transaction History</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<!--View Modal End-->

<!--Edit Modal Start-->
<?php $this->load->view('customer/customer_edit');?>
<!--Edit Modal End-->


<!--Delete Alert Start-->
<div class="modal fade" id="deleteCustomerInfoModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang('delect_this_entry') ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('confirm_delete') ?></div>

            </div>
            <div class="modal-footer ">
                <input type="hidden" name="delete_cus_id" id="delete_cus_id">
                <button type="button" class="btn btn-success" onclick="delete_customer_info();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang('yes') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang('no') ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="emptyAlert" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul class="validation_alert">
                        <li><span class="glyphicon glyphicon-warning-sign"></span><?= lang("alert_customer_balance_zero"); ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Delete Alert End-->
<script type="text/javascript">
    var x = 1;
    

    $(function () {
        $('#DOB').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

    });
    $(function () {
        $('#AD').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

    });

    var $chAll = $('#CheckAll');
    var $ch = $('.checkGroup input[type="checkbox"]').not($chAll);

    $chAll.click(function () {
        $ch.prop('checked', $(this).prop('checked'));
        $('#send_sms').html($('input[name="id_check[]"]:checked').length);
    });
    $ch.click(function () {
        if ($ch.size() == $('.checkGroup input[type="checkbox"]:checked').not($chAll).size())
            $chAll.prop('checked', true);
        else
            $chAll.prop('checked', false);
        $('#send_sms').html($('input[name="id_check[]"]:checked').length);
    });

    function locationAddress(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        // $('#select2-location-container').html("");
        if (cat == "divi") {
            var html = "<option value='0'><?= lang('select_district') ?></option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>customer_settings/customer/get_district',
                data: {id: id},
                success: function (result) {
                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for (var i = 0; i < length; i++) {
                            var val = data[i].id_district;
                            var district = data[i].district_name_en;
                            html += "<option value = '" + 'dist-' + val + "'>" + district + "</option>";
                        }

                        $('#address_location').html(html);
                        $('#division_id').val(id);
                        $('#city_id').val("");
                        $('#district_id').val("");
                        $('#city_location_id').val("");
                        return true;
                    } else {
                        alert('data not found !');
                        return false;
                    }
                }
            });
        } else if (cat == "city") {
            var html = "<option value='0'><?= lang('select_location') ?></option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>customer_settings/customer/get_city_location',
                data: {id: id},
                success: function (result) {

                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for (var i = 0; i < length; i++) {
                            var val = data[i].id_area;
                            var location = data[i].area_name_en;
                            html += "<option value = '" + 'city-' + val + "'>" + location + "</option>";
                        }

                        $('#address_location').html(html);
                        $('#city_id').val(id);
                        $('#division_id').val("");
                        $('#district_id').val("");
                        $('#city_location_id').val("");
                    }
                }
            });
        }
    }

    function cityDistLoc(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        if (cat == "city") {
            $('#city_location_id').val(id);
        } else if (cat == "dist") {
            $('#district_id').val(id);
        }
    }
    function srcLocationAddress(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        // $('#select2-location-container').html("");
        if (cat == "divi") {
            var html = "<option value='0'><?= lang('select_district') ?></option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>customer_settings/customer/get_district',
                data: {id: id},
                success: function (result) {
                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for (var i = 0; i < length; i++) {
                            var val = data[i].id_district;
                            var district = data[i].district_name_en;
                            html += "<option value = '" + 'dist-' + val + "'>" + district + "</option>";
                        }

                        $('#src_address_location').html(html);
                        $('#src_division_id').val(id);
                        $('#src_city_id').val("");
                        $('#src_district_id').val("");
                        $('#src_city_location_id').val("");
                        return true;
                    } else {
                        alert('data not found !');
                        return false;
                    }
                }
            });
        } else if (cat == "city") {
            var html = "<option value='0'><?= lang('select_location') ?></option>";
            $('#address_location').html("");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>customer_settings/customer/get_city_location',
                data: {id: id},
                success: function (result) {

                    var data = JSON.parse(result);
                    if (result) {
                        var length = data.length;
                        for (var i = 0; i < length; i++) {
                            var val = data[i].id_area;
                            var location = data[i].area_name_en;
                            html += "<option value = '" + 'city-' + val + "'>" + location + "</option>";
                        }

                        $('#src_address_location').html(html);
                        $('#src_city_id').val(id);
                        $('#src_division_id').val("");
                        $('#src_district_id').val("");
                        $('#src_city_location_id').val("");
                    }
                }
            });
        }
    }

    function srcCityDistLoc(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        if (cat == "city") {
            $('#src_city_location_id').val(id);
        } else if (cat == "dist") {
            $('#src_district_id').val(id);
        }
    }
</script>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script>
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var name_customer = $('#name_customer').val();
        var phone_customer = $('#phone_customer').val();
        var type_of_customer = $('#type_of_customer').val();

        var store_id = $('#store_id').val();
        var division_id = $('#src_division_id').val();
        var district_id = $('#src_district_id').val();
        var city_id = $('#src_city_id').val();
        var city_location_id = $('#src_city_location_id').val();
        var cus_address = $('#cus_address').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer/customer_info_data/' + page_num,
            data: 'page=' + page_num + '&name_customer=' + name_customer + '&phone_customer=' + phone_customer + '&type_of_customer=' + type_of_customer+ '&store_id=' + store_id+ '&division_id=' + division_id+ '&district_id=' + district_id+ '&city_id=' + city_id+ '&city_location_id=' + city_location_id+ '&cus_address=' + cus_address,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

    function edit_customer_type(id)
    {
        save_method = 'update';
        $('#customer_type')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo base_url() ?>customer_settings/customer/edit_customer_type/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                $('#name').val(data.name);
                $('#discount').val(data.discount);
                $('#target_sales_volume').val(data.target_sales_volume);
                $('#id').val(data.id_customer_type);

                $('#layout_title').text('<?= lang('customer_name') ?>Edit Customer Type');
                $('[type="submit"]').text('<?= lang('customer_name') ?>Update');
                $('#modal_form').modal('show');
                $('.loading').fadeOut("slow");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    function addCustomer() {
        $('#customer_info')[0].reset();
        $("#customer_code").val($.now());
    }
    function delete_customer_type(id)
    {
        if (confirm('Are you sure delete this data?'))
        {
            $.ajax({
                url: "<?php echo base_url() . 'customer_settings/customer/delete_customer_type' ?>/" + id,
                type: "POST",
                dataType: "JSON",
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data)
                {
                    $('#showMessage').html('data successfully deleted..');
                    $('#showMessage').show();
                    window.onload = searchFilter(0);
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                    $('.loading').fadeOut("slow");
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }

    function deleteCustomerModal(id) {
        $('#delete_cus_id').val(id);
    }

    function delete_customer_info() {
        var id = $('#delete_cus_id').val();
        var ck_id = $('#ch_balance_'+id).text();
        if(ck_id>0||ck_id<0){
            $('#deleteCustomerInfoModal').modal('hide');
            $('#emptyAlert').modal('toggle');

        }else {
            $.ajax({
                url: '<?php echo base_url(); ?>customer_settings/customer/delete_customer_info',
                data: {id: id},
                type: 'post',
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data) {
                    $('#deleteCustomerInfoModal').modal('toggle');
                    $('#showMessage').html("<?php echo lang('delete_success'); ?>");
                    $('#showMessage').show();
                    window.onload = searchFilter(0);
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                    $('.loading').fadeOut("slow");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    }

    function editCustomer(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>customer_settings/customer/editCustomerInfo',
            data: {id: id},
            type: 'post',
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                //console.log(result);
                if (result) {
                    var data = JSON.parse(result);
                    $('#edit_customer_id').val(data[0].id_customer);
                    $('#edit_customer_code').val(data[0].customer_code);
                    $('#edit_customer_name').val(data[0].full_name);
                    $('[id="edit_customer_type_id"]').val(data[0].customer_type_id).change();
                    $('#edit_email').val(data[0].email);
                    $('#edit_phone').val(data[0].phone);
                    if (data[0].gender == 'Male') {
                        $("[id='Male2']").prop("checked", true);
                    } else if (data[0].gender == 'Female') {
                        $("[id='Female2']").prop("checked", true);
                    }
                    $('#edit_birth_date').val(data[0].birth_date);
                    $('#edit_anniversary_date').val(data[0].anniversary_date);
                    $('[id="edit_marital_status"]').val(data[0].marital_status).change();
                    $('#old_customer_photo').val(data[0].profile_img);

                    var photo = data[0].profile_img;
                    if (photo) {
                        var image_path = "<?php echo documentLink('customer')?>" + photo;
                        var image = "<img src='" + image_path + "'";
                        $("#customer_photo").attr("src", image_path);
                    }
                    $('.loading').fadeOut("slow");

                    return false;
                } else {
                    return false;
                }
            }
        });
    }


    $.validator.setDefaults({
        submitHandler: function (form) {

            var customer_id = $('#edit_customer_id').val();

            //customer data insert
            if (customer_id != "") {
                var currentForm = $('#edit_customer_info')[0];
                var formData = new FormData(currentForm);
                formData.append('file', document.getElementById("edit_profile_img").files[0]);

                $.ajax({
                    url: "<?= base_url() ?>customer_settings/customer/edit_customer_basic_info",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (response) {
                        var result = $.parseJSON(response);
                        if (result.status != 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#edit').modal('toggle');
                            $('#edit_customer_info').trigger("reset");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilter(0);
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);

                            }, 3000);
                        }
                        $('.loading').fadeOut("slow");
                    }
                });
            } else {
                var currentForm = $('#customer_info')[0];
                var formData = new FormData(currentForm);
                formData.append('file', document.getElementById("profile_img").files[0]);
                $.ajax({
                    url: "<?= base_url() ?>create_customer_info",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (response) {
                        //console.log(response);
                        //alert(response);
                        var result = $.parseJSON(response);
                        if (result.status != 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#add').modal('toggle');
                            $('#customer_info').trigger("reset");
                            $("#customer_type_id").val("0").change();
                            $("#marital_status").val("0").change();
                            $("#address_type").val("0").change();
                            $("#city_division").val("0").change();
                            $("#address_location").val("0").change();
                            $("#add_more_section").html("");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilter(0);
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);

                            }, 3000);
                        }
                        $('.loading').fadeOut("slow");
                    }
                });
            }


        }
    });
    function sms_due_customers(){
        $chAll.prop('checked', false);
        $ch.prop('checked', false);
        $('#send_sms').html(0);
    }
    $("#submit_send_sms").submit(function () {
        $('#show_error').html('');
        var $html = '';
        var rowCount = $('#add_section >tr').length;
        //alert(rowCount);
        var nameArray = []; 
        var phoneArray = []; 
        $("input[name='id_check[]']:checked").each(function(){
            var id = $(this).val();
            var serial= this.id;
            var phone = $('#phone_'+serial).val();
            var name = $('#name_'+serial).val();
            nameArray.push(name);
            phoneArray.push(phone);
        });
        var dataString = new FormData($(this)[0]);
        for (var i = 0; i < nameArray.length; i++) {
            dataString.append('nameArray[]', nameArray[i]);
            dataString.append('phoneArray[]', phoneArray[i]);
        }
        var send_sms=$('#send_sms').html()*1;
        var available_sms=$('#available_sms').html()*1;
        //alert(send_sms+'=='+available_sms);
        if(send_sms <= available_sms){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>customer_settings/customer/submit_send_sms',
                data: dataString,
                //async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    $('.loading').fadeOut("slow");
                    // console.log(result);
                    // alert(result);
                    $('#due_customers').modal('toggle');
                    $('#showMessage').html('Customer Due SMS Send Successfully');
                    $('#showMessage').show();
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                    $('#available_sms').html(available_sms-send_sms);
                    
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }else{
            $('#show_error').html('Over SMS not allowed.');
        }
        
        return false;
    });
    function csv_export() {
        var name_customer = $('#name_customer').val();
        var phone_customer = $('#phone_customer').val();
        var type_of_customer = $('#type_of_customer').val();
        var store_id = $('#store_id').val();
        var division_id = $('#src_division_id').val();
        var district_id = $('#src_district_id').val();
        var city_id = $('#src_city_id').val();
        var city_location_id = $('#src_city_location_id').val();
        var cus_address = $('#cus_address').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer_settings/customer/create_csv_data',
            data: 'name_customer=' + name_customer + '&phone_customer=' + phone_customer + '&type_of_customer=' + type_of_customer+ '&store_id=' + store_id+ '&division_id=' + division_id+ '&district_id=' + district_id+ '&city_id=' + city_id+ '&city_location_id=' + city_location_id+ '&cus_address=' + cus_address,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('.loading').fadeOut("slow");
                window.location.href = '<?php echo base_url(); ?>export_csv?request='+(html);
            }
        });
    }

</script>