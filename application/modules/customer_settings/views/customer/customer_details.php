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

                    <div class="full-box element-box">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="tab-menu">
                                    <li class="active">
                                        <a href="#View" data-toggle="tab"
                                           class="btn btn-primary"><?= lang('details') ?></a>
                                    </li>

                                    <li>
                                        <a href="#CustomerAddress" data-toggle="tab"
                                           class="btn btn-primary"><?= lang('address') ?></a>
                                    </li>

<!--                                     <li>
                                        <a href="#CustomerDocument" data-toggle="tab"
                                           class="btn btn-primary"><?= lang('documents') ?></a>
                                    </li> -->
<!--                                     <li>
                                        <a href="#InvoiceHis" data-toggle="tab"
                                           class="btn btn-primary"><?= lang('invoice_history') ?></a>
                                    </li> -->
                                </ul>
                                <div class="total-point">Point: <?= $customer_info[0]['points']?></div>
                                <div class="cus_bal">Balance: <?= $customer_info[0]['balance']?></div>

                            </div>
                        </div>
                    </div>

                    <div class="element-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div id="View" class="tab-pane fade in active full-box">
                                        <input type="hidden" name="id_customer" id="id_customer"
                                               value="<?php echo $customer_info[0]['id_customer']; ?>">
                                        <div class="info-1">
                                            <div class="receive-payment">
                                                <h6 class="element-header"><?= lang('customer_details') ?></h6>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="rcv-pmnt"><strong><?= lang('membership_id') ?>
                                                            :</strong> <?php echo $customer_info[0]['customer_code']; ?>
                                                    </div>
                                                    <div class="rcv-pmnt"><strong><?= lang('full_name') ?>
                                                            :</strong> <?php echo $customer_info[0]['full_name']; ?>
                                                    </div>
                                                    <div class="rcv-pmnt"><strong><?= lang('customer_type') ?>
                                                            :</strong> <?php echo $customer_info[0]['name']; ?></div>
                                                    <div class="rcv-pmnt"><strong><?= lang('email') ?>
                                                            :</strong> <?php echo $customer_info[0]['email']; ?></div>
                                                    <div class="rcv-pmnt"><strong><?= lang('phone') ?>
                                                            :</strong> <?php echo $customer_info[0]['phone']; ?></div>
                                                    <div class="rcv-pmnt"><strong><?= lang('gender') ?>
                                                            :</strong> <?php echo $customer_info[0]['gender']; ?></div>
                                                    <div class="rcv-pmnt"><strong><?= lang('dob') ?>
                                                            :</strong> <?php echo $customer_info[0]['birth_date']; ?>
                                                    </div>
                                                    <div class="rcv-pmnt"><strong><?= lang('marital_status') ?>
                                                            :</strong> <?php echo $customer_info[0]['marital_status']; ?>
                                                    </div>
                                                    <div class="rcv-pmnt"><strong><?= lang('anniversary_date') ?>
                                                            :</strong> <?php echo $customer_info[0]['anniversary_date']; ?>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <div class="customer-logo">
                                                        <img
                                                            src="<?php echo documentLink('customer')?><?php echo $customer_info[0]['profile_img']; ?>"
                                                            width="100%" alt="" style="float: left;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-12">
                                                    <button class="btn btn-primary btn-xs right" data-title="Edit" rel="tooltip" title="<?= lang("edit") ?>"
                                                            data-toggle="modal" data-target="#edit"
                                                            onclick="editCustomer('<?php echo $customer_info[0]['id_customer']; ?>')">
                                                        <span class="glyphicon glyphicon-pencil"></span></button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <!--Edit Modal Start-->
                                    <?php $this->load->view('customer/customer_edit');?>
                                    <!--Edit Modal End-->

                                    <!--Customer Address-->
                                    <div id="CustomerAddress" class="tab-pane fade full-box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2 class="element-header"><?php if ($customer_info) {
                                                        echo $customer_info[0]['full_name'];
                                                    } ?></h2>
                                                <button data-toggle="modal" data-target="#add_customer_address"
                                                        class="btn btn-primary btn-rounded right"
                                                        type="button"><?= lang('add_address') ?></button>
                                            </div>
                                        </div>

                                        <!--Add Customer Address Modal Start-->
                                        <div id="add_customer_address" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="element-header margin-0"><?= lang('customer_address') ?>
                                                            <span class="close" data-dismiss="modal">&times;</span></h6>
                                                    </div>
                                                    <?php echo form_open_multipart('', array('id' => 'enter_customer_address', 'class' => 'cmxform')); ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" id="customer_id" name="customer_id"
                                                               value="<?php echo $customer_info[0]['id_customer']; ?>">
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><?= lang('address_type') ?>
                                                                <span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <div class="row-fluid">
                                                                    <select class="select2" id="address_type"
                                                                            name="address_type">
                                                                        <option
                                                                            value="0"><?= lang('select_one') ?></option>
                                                                        <option value="Present Address">Present
                                                                            Address
                                                                        </option>
                                                                        <option value="Permanent Address">Permanent
                                                                            Address
                                                                        </option>
                                                                        <option value="Shipping Address">Shipping
                                                                            Address
                                                                        </option>
                                                                        <option value="Billing Address">Billing
                                                                            Address
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><?= lang('city_division') ?>
                                                                <span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <div class="row-fluid">
                                                                    <select class="select2" data-live-search="true"
                                                                            id="city_division" name="city_division"
                                                                            onchange="locationAddress(value);">
                                                                        <option value="0"
                                                                                selected><?= lang('select_one') ?></option>
                                                                        <optgroup label="City Wise">
                                                                            <?php
                                                                            if ($city_list) {
                                                                                foreach ($city_list as $list) {
                                                                                    ?>
                                                                                    <option
                                                                                        value="city-<?php echo $list['id_city']; ?>"><?php echo $list['city_name_en']; ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>

                                                                        </optgroup>
                                                                        <optgroup label="Division Wise">
                                                                            <?php
                                                                            if ($division_list) {
                                                                                foreach ($division_list as $list) {
                                                                                    ?>
                                                                                    <option
                                                                                        value="divi-<?php echo $list['id_division']; ?>"><?php echo $list['division_name_en']; ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="division_id" id="division_id">
                                                        <input type="hidden" name="district_id" id="district_id">

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><?= lang('location') ?>
                                                                <span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <div class="row-fluid">
                                                                    <select class="select2" id="address_location"
                                                                            name="address_location"
                                                                            onchange="cityDistLoc(value);">
                                                                        <option
                                                                            value="0"><?= lang('select_one') ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="city_id" id="city_id">
                                                        <input type="hidden" name="city_location_id"
                                                               id="city_location_id">

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><?= lang('address') ?>
                                                                <span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" id="addr_line_1" rows="3"
                                                                          name="addr_line_1"
                                                                          value="addr_line_1"></textarea>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <input class="btn btn-primary" type="submit"
                                                               value="<?= lang('submit') ?>"> </button>

                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal"><?= lang('close') ?></button>
                                                    </div>

                                                    <?php echo form_close(); ?>
                                                </div>


                                            </div>
                                        </div>
                                        <!--Add Customer Address Modal End-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive" id="postList">
                                                    <table id="mytable" class="table table-bordred table-striped">
                                                        <thead>

                                                        <th><?= lang('serial') ?></th>
                                                        <th><?= lang('address_type') ?></th>
                                                        <th><?= lang('div_or_city') ?></th>
                                                        <th><?= lang('dis_or_area') ?></th>
                                                        <th><?= lang('address') ?></th>
                                                        <th class="text-center"><?= lang('action') ?></th>

                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $i = 1;
                                                        if (!empty($customer_address_list)) {
                                                            foreach ($customer_address_list as $list) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td><?php echo $list['address_type']; ?></td>
                                                                    <td><?php if ($list['division_name_en'] != "") {
                                                                            echo $list['division_name_en'];
                                                                        } else {
                                                                            echo $list['city_name_en'];
                                                                        } ?></td>
                                                                    <td><?php if ($list['district_name_en'] != "") {
                                                                            echo $list['district_name_en'];
                                                                        } else {
                                                                            echo $list['area_name_en'];
                                                                        } ?></td>
                                                                    <td><?php echo $list['addr_line_1']; ?></td>
                                                                    <td class="center">
                                                                        <button class="btn btn-primary btn-xs" rel="tooltip" title="<?= lang("edit") ?>"
                                                                                data-title="Edit" data-toggle="modal"
                                                                                data-target="#edit_customer_address_section"
                                                                                onclick="editCustomerAddress('<?php echo $list['id_customer_address']; ?>')">
                                                                            <span
                                                                                class="glyphicon glyphicon-pencil"></span>
                                                                        </button>
                                                                        <button class="btn btn-danger btn-xs" rel="tooltip" title="<?= lang("delete") ?>"
                                                                                data-title="Delete" data-toggle="modal"
                                                                                data-target="#deleteCustomerAddress"
                                                                                onclick="deleteCustomerModal('<?php echo $list['id_customer_address']; ?>');">
                                                                            <span
                                                                                class="glyphicon glyphicon-trash"></span>
                                                                        </button>

                                                                    </td>

                                                                </tr>

                                                                <?php
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                        </tbody>

                                                    </table>

                                                    <div class="clearfix"></div>
                                                    <?php echo $this->ajax_pagination->create_links(); ?>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <!--Edit Modal Start-->
                                    <div id="edit_customer_address_section" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="element-header"><?= lang('edit_customer_address') ?><span
                                                            class="close" data-dismiss="modal">&times;</span></h6>
                                                </div>
                                                <?php echo form_open_multipart('', array('id' => 'edit_customer_address', 'class' => 'cmxform')); ?>
                                                <div class="modal-body">
                                                    <input type="hidden" name="edit_id_customer_address"
                                                           id="edit_id_customer_address">
                                                    <div class="form-group row">
                                                        <label
                                                            class="col-sm-4 col-form-label"><?= lang('address_type') ?>
                                                            <span class="req">*</span></label>
                                                        <div class="col-sm-8">
                                                            <div class="row-fluid">
                                                                <select class="select2" id="edit_address_type"
                                                                        name="edit_address_type">
                                                                    <option value="0"><?= lang('select_one') ?></option>
                                                                    <option value="Present Address">Present Address
                                                                    </option>
                                                                    <option value="Permanent Address">Permanent
                                                                        Address
                                                                    </option>
                                                                    <option value="Shipping Address">Shipping Address
                                                                    </option>
                                                                    <option value="Billing Address">Billing Address
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label
                                                            class="col-sm-4 col-form-label"><?= lang('city_division') ?>
                                                            <span class="req">*</span></label>
                                                        <div class="col-sm-8">
                                                            <div class="row-fluid">
                                                                <select class="select2" data-live-search="true"
                                                                        id="city_division1" name="city_division1"
                                                                        onchange="editLocationAddress(value);">
                                                                    <option value="0"
                                                                            selected><?= lang('select_one') ?></option>
                                                                    <optgroup label="City Wise" name="edit_city"
                                                                              id="edit_city">
                                                                        <?php
                                                                        if ($city_list) {
                                                                            foreach ($city_list as $list) {
                                                                                ?>
                                                                                <option class="edit_city"
                                                                                        value="city-<?php echo $list['id_city']; ?>"><?php echo $list['city_name_en']; ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </optgroup>
                                                                    <optgroup label="Division Wise">
                                                                        <?php
                                                                        if ($division_list) {
                                                                            foreach ($division_list as $list) {
                                                                                ?>
                                                                                <option class="edit_division"
                                                                                        value="divi-<?php echo $list['id_division']; ?>"><?php echo $list['division_name_en']; ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="division_id" id="edit_division_id">
                                                    <input type="hidden" name="district_id" id="edit_district_id">

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label"><?= lang('location') ?>
                                                            <span class="req">*</span></label>
                                                        <div class="col-sm-8">
                                                            <div class="row-fluid">
                                                                <select class="select2" id="edit_address_location"
                                                                        name="edit_address_location"
                                                                        onchange="editCityDistLoc(value);">
                                                                    <option value="0"><?= lang('select_one') ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="city_id" id="edit_city_id">
                                                    <input type="hidden" name="city_location_id"
                                                           id="edit_city_location_id">

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label"><?= lang('address') ?>
                                                            <span class="req">*</span></label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" rows="3"
                                                                      name="edit_addr_line_1" id="edit_addr_line_1"
                                                                      value="addr_line_1"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-buttons-w">
                                                        <button class="btn btn-primary" type="submit"
                                                                id="edit_address"> <?= lang('submit') ?></button>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <!-- <input class="btn btn-primary" type="submit" value="Submit"> </button> -->
                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal"><?= lang('close') ?></button>
                                                </div>
                                                <?php echo form_close(); ?>
                                            </div>

                                        </div>
                                    </div>
                                    <!--Edit Modal End-->

                                    <!--Delete Alert Start-->
                                    <div class="modal fade" id="deleteCustomerAddress" tabindex="-1" role="dialog"
                                         aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-hidden="true"><span class="glyphicon glyphicon-remove"
                                                                                     aria-hidden="true"></span></button>
                                                    <h4 class="modal-title custom_align"
                                                        id="Heading"><?= lang('delect_this_entry') ?></h4>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="alert alert-danger"><span
                                                            class="glyphicon glyphicon-warning-sign"></span> <?= lang('confirm_delete') ?>
                                                    </div>

                                                </div>
                                                <div class="modal-footer ">
                                                    <input type="hidden" id="customer_address_delete_id">
                                                    <button type="button" class="btn btn-success"
                                                            onclick="delete_customer_address();"><span
                                                            class="glyphicon glyphicon-ok-sign"></span> <?= lang('yes') ?>
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        <span
                                                            class="glyphicon glyphicon-remove"></span> <?= lang('no') ?>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!--Delete Alert End-->
                                    <div id="CustomerDocument" class="tab-pane fade full-box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2 class="element-header"><?php if ($customer_info) {
                                                        echo $customer_info[0]['full_name'];
                                                    } ?></h2>
                                                <button data-toggle="modal" data-target="#add_customer_documents"
                                                        class="btn btn-primary btn-rounded right"
                                                        type="button"><?= lang('add_document') ?></button>
                                            </div>
                                        </div>

                                        <!--Add Customer Address Modal Start-->
                                        <div id="add_customer_documents" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="element-header margin-0"><?= lang('customer_document') ?>
                                                            <span class="close" data-dismiss="modal">&times;</span></h6>
                                                    </div>
                                                    <?php echo form_open_multipart('', array('id' => 'enter_customer_documents', 'class' => 'cmxform')); ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" id="customer_id" name="customer_id"
                                                               value="<?php echo $customer_info[0]['id_customer']; ?>">
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><?= lang('file_name') ?>
                                                                <span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="document_name"
                                                                       class="form-control" id="document_name">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><?= lang('description') ?>
                                                                </label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" rows="3"
                                                                          name="document_description"
                                                                          id="document_description"></textarea>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><?= lang('select_file') ?>
                                                                <span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="file" name="document_file"
                                                                       id="document_file">
                                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <input class="btn btn-primary" type="submit"
                                                               value="<?= lang('submit') ?>"> </button>

                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal"><?= lang('close') ?></button>
                                                    </div>
                                                    <input type="hidden" id="total_num_of_fields"
                                                           name="total_num_of_fields" value="1">
                                                    <?php echo form_close(); ?>
                                                </div>


                                            </div>
                                        </div>
                                        <!--Add Customer Address Modal End-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive" id="documentList">
                                                    <table id="mytable" class="table table-bordred table-striped">
                                                        <thead>
                                                        <th><?= lang('serial') ?></th>
                                                        <th><?= lang('name') ?></th>
                                                        <th><?= lang('description') ?></th>
                                                        <th><?= lang('file') ?></th>
                                                        <th class="text-center"><?= lang('action') ?></th>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $i = 1;
                                                        if (!empty($customer_document_list)) {
                                                            foreach ($customer_document_list as $list) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td><?php echo $list['name']; ?></td>
                                                                    <td><?php echo $list['description']; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $name = $list['file'];
                                                                        $fileExt = strrchr($name, ".");
                                                                        $output = '';
                                                                        if ($fileExt == '.jpg' || $fileExt == '.png' || $fileExt == '.jpeg' || $fileExt == '.gif') {
                                                                            $output = '<a href="#" onclick="show_image(' . $list['id_document'] . ')"><i class="fa fa-picture-o" aria-hidden="true"></i></a>';
                                                                            $output .= '<div id="img_' . $list['id_document'] . '" style="display: none;"><img src="' . documentLink('customer') . $name . '" style="width:100%"></div>';
                                                                        } else if ($fileExt == '.doc' || $fileExt == '.docx') {
                                                                            $output = '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
                                                                        } else if ($fileExt == '.xlsx' || $fileExt == '.xls' || $fileExt == '.xlsm' || $fileExt == '.xltx' || $fileExt == '.xltm') {
                                                                            $output = '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
                                                                        } else if ($fileExt == '.pdf' || $fileExt == '.xps') {
                                                                            $output = '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
                                                                        } else {
                                                                            $output = '<i class="fa fa-file" aria-hidden="true"></i>';
                                                                        }
                                                                        echo $output;
                                                                        ?>
                                                                    </td>

                                                                    <td class="center">
                                                                        <?php
                                                                        if (!empty($list['file'])) {
                                                                            ?>
                                                                            <a rel="tooltip" title="<?= lang("download") ?>" href="<?php echo documentLink('customer') . $list['file']; ?>"
                                                                               download>
                                                                                <button class="btn btn-success btn-xs">
                                                                                    <i class="fa fa-download"
                                                                                       aria-hidden="true"></i></button>
                                                                            </a>
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                        <button class="btn btn-primary btn-xs" rel="tooltip" title="<?= lang("edit") ?>"
                                                                                data-title="Edit" data-toggle="modal"
                                                                                data-target="#edit_customer_document_modal"
                                                                                onclick="editCustomerDocument('<?php echo $list['id_document']; ?>')">
                                                                            <span
                                                                                class="glyphicon glyphicon-pencil"></span>
                                                                        </button>

                                                                        <button class="btn btn-danger btn-xs" rel="tooltip" title="<?= lang("delete") ?>"
                                                                                data-title="Delete" data-toggle="modal"
                                                                                data-target="#deleteCustomerDocumentModal"
                                                                                onclick="deleteCustomerDocModal('<?php echo $list['id_document']; ?>');">
                                                                            <span
                                                                                class="glyphicon glyphicon-trash"></span>
                                                                        </button>

                                                                    </td>

                                                                </tr>

                                                                <?php
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                        </tbody>

                                                    </table>

                                                    <div class="clearfix"></div>
                                                    <?php echo $this->ajax_pagination->create_links(); ?>
                                                </div>

                                            </div>
                                        </div>
                                        <!--Edit Modal Start-->
                                        <div id="edit_customer_document_modal" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="element-header"><?= lang('edit_customer_address') ?>
                                                            <span class="close" data-dismiss="modal">&times;</span></h6>
                                                    </div>
                                                    <?php echo form_open_multipart('', array('id' => 'edit_customer_document', 'class' => 'cmxform')); ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="edit_customer_document_id"
                                                               id="edit_customer_document_id">

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><?= lang('file_name') ?>
                                                                <span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="edit_document_name"
                                                                       class="form-control" id="edit_document_name">
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><?= lang('description') ?>
                                                                <span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" rows="3"
                                                                          name="edit_document_description"
                                                                          id="edit_document_description"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><?= lang('select_file') ?>
                                                                <span class="req">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="file" name="edit_document_file"
                                                                       id="edit_document_file">
                                                                <input type="hidden" name="old_customer_doc"
                                                                       id="old_customer_doc">
                                                                <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("doc_file_type"); ?></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-buttons-w">
                                                            <button class="btn btn-primary"
                                                                    type="submit"> <?= lang('submit') ?></button>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal"><?= lang('close') ?></button>
                                                    </div>
                                                    <?php echo form_close(); ?>
                                                </div>

                                            </div>
                                        </div>
                                        <!--Edit Modal End-->

                                        <!--Delete Alert Start-->
                                        <div class="modal fade" id="deleteCustomerDocumentModal" tabindex="-1"
                                             role="dialog" aria-labelledby="edit" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true"><span
                                                                class="glyphicon glyphicon-remove"
                                                                aria-hidden="true"></span></button>
                                                        <h4 class="modal-title custom_align"
                                                            id="Heading"><?= lang('delect_this_entry') ?></h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="alert alert-danger"><span
                                                                class="glyphicon glyphicon-warning-sign"></span> <?= lang('confirm_delete') ?>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer ">
                                                        <input type="hidden" id="customer_document_delete_id">
                                                        <button type="button" class="btn btn-success"
                                                                onclick="delete_customer_document();"><span
                                                                class="glyphicon glyphicon-ok-sign"></span> <?= lang('yes') ?>
                                                        </button>
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal"><span
                                                                class="glyphicon glyphicon-remove"></span> <?= lang('no') ?>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!--Delete Alert End-->


                                    </div>


                                    <div id="InvoiceHis" class="tab-pane fade full-box">

                                        <h6 class="element-header"><?= lang('invoice') ?>:</h6>
                                        <div class="table-responsive">
                                            <table id="mytable" class="table table-bordred table-striped">
                                                <thead>
                                                <tr>
                                                    <th><?=lang('serial')?></th>
                                                    <th><?=lang('invoice_no')?></th>
                                                    <th><?=lang('store_name')?></th>
                                                    <th><?=lang('date')?></th>
                                                    <th><?=lang('amount')?></th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                //print_r($invoices);
                                                $count = 1;
                                                foreach ($invoices as $invoice) {
                                                    echo '<tr>';
                                                    echo '<td>' . $count . '</td>';
                                                    echo '<td>' . $invoice['invoice_no'] . '</td>';
                                                    echo '<td>' . $invoice['store_name'] . '</td>';
                                                    echo '<td>' . $invoice['dtt_add'] . '</td>';
                                                    echo '<td>' . $invoice['tot_amt'] . '</td>';
                                                    echo '<td> <button class="btn btn-primary pull-right " type="button" onclick="invoice_view('. $invoice["id_sale"].')"><i class="fa fa-eye"></i></button>';
                                                    echo '<button class="btn btn-primary pull-right margin-right-10" type="button" onclick="invoice_full_view('. $invoice["id_sale"].')">A4</button></td>';
                                                    echo '</tr>';
                                                    $count++;
                                                }
                                                ?>
                                                </tbody>

                                            </table>


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

<!---View data table-->

<div id="view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">View Billings <span class="close"
                                                                        data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="info-1">

                        <div class="company-name margin-0">Syntech Solution Ltd.</div>
                        <div class="company-email"><strong>Email:</strong> example@gmail.com</div>
                        <div class="company-address"><strong>Address:</strong> Mohammodpur, CA/34, Bangladesh</div>
                        <div class="company-address"><strong>Website:</strong> www.website.com</div>
                        <div class="company-phone"><strong>Phone:</strong> 858.745.5577</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="SaleInvoiceA4Details" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Sale Invoice Details</h6>
            </div>
            <div class="modal-body">
                <div class="sale-view invoice_content" id="sale_print">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="sale_a4_print()">Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close
                </button>
            </div>
        </div>
    </div>
</div>


<!---Delete data table-->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you
                    want to delete this Record?
                </div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Yes
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> No
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="SaleInvoiceDetails" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Sale Invoice Details</h6>
            </div>
            <div class="modal-body">
                <div class="sale-view invoice_content" id="sale_view">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="sale_print()">Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function invoice_view(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>invoice_view_sale/' + id ,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                // console.log(html);
                $('#sale_view').html(html);
                $('.loading').fadeOut("slow");
                $('#SaleInvoiceDetails').modal('toggle');
            }
        });
    }

</script>


<script type="text/javascript">

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

    function locationAddress(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        // $('#select2-location-container').html("");
        if (cat == "divi") {
            var html = "<option value='0'>Select District</option>";
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
            var html = "<option value='0'>Select Location</option>";
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

    function editLocationAddress(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        // $('#select2-location-container').html("");
        if (cat == "divi") {
            var html = "<option value='0'>Select District</option>";
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

                        $('#edit_address_location').html(html);
                        $('#edit_division_id').val(id);
                        $('#edit_city_id').val("");
                        $('#edit_district_id').val("");
                        $('#edit_city_location_id').val("");
                        return true;
                    } else {
                        alert('data not found !');
                        return false;
                    }
                }
            });
        } else if (cat == "city") {
            var html = "<option value='0'>Select Location</option>";
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

                        $('#edit_address_location').html(html);
                        $('#edit_city_id').val(id);
                        $('#edit_division_id').val("");
                        $('#edit_district_id').val("");
                        $('#edit_city_location_id').val("");
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

    function editCityDistLoc(value) {
        var cat = value.substring(0, 4);
        var id = value.substring(5);

        if (cat == "city") {
            $('#edit_city_location_id').val(id);
        } else if (cat == "dist") {
            $('#edit_district_id').val(id);
        }
    }
</script>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>
<script>
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var id_customer_search = $('#id_customer').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer_settings/customer/customer_address_pagination/',
            data: 'page=' + page_num + '&customer_id=' + id_customer_search,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

    function searchFilterDocument(page_num) {
        page_num = page_num ? page_num : 0;
        var id_customer_search = $('#id_customer').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer_settings/customer/customer_documents_pagination/',
            data: 'page=' + page_num + '&customer_id=' + id_customer_search,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#documentList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }


    function editCustomerAddress(id) {
        $.ajax({
            url: '<?php echo base_url();?>customer_settings/customer/edit_customer_address',
            data: {id: id},
            type: 'post',
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                if (result) {
                    $('.loading').fadeOut("slow");
                    var data = JSON.parse(result);
                    var division_id = data.result[0].div_id;
                    var district_id = data.result[0].dist_id;
                    var city_id = data.result[0].city_id;
                    var area_id = data.result[0].area_id;

                    $('[name="edit_id_customer_address"]').val(data.result[0].id_customer_address);
                    $('[name="edit_address_type"]').val(data.result[0].address_type).change();

                    if (division_id != 0) {
                        $('[id="city_division1"]').val('divi-' + division_id).change();
                        setTimeout(function () {
                            $('[id="edit_address_location"]').val('dist-' + district_id).change();
                        }, 500);
                    }

                    if (city_id != 0) {
                        $('[id="city_division1"]').val('city-' + city_id).change();
                        setTimeout(function () {
                            $('[id="edit_address_location"]').val('city-' + area_id).change();
                        }, 500);
                    }
                    $('[name="edit_addr_line_1"]').val(data.result[0].addr_line_1);

                    return false;
                } else {
                    return false;
                }
            }
        });
    }


    function editCustomerDocument(id) {
        $.ajax({
            url: '<?php echo base_url();?>customer_settings/customer/edit_customer_doc',
            data: {id: id},
            type: 'post',
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                if (result) {
                    var data = JSON.parse(result);
                    $('#edit_customer_document_id').val(data[0].id_document);
                    $('#edit_document_name').val(data[0].name);
                    $('#edit_document_description').val(data[0].description);
                    $('#old_customer_doc').val(data[0].file);
                    var photo = data[0].file;
                    if (photo) {
                        var image_path = "<?php echo base_url();?>public/uploads/customer_files/" + photo;
                        var image = "<img src='" + image_path + "'";
                        $("#customer_doc").attr("src", image_path);
                    }
                    $('.loading').fadeOut("slow");

                    return false;
                } else {
                    return false;
                }
            }
        });
    }

    function deleteCustomerModal(id) {
        $('#customer_address_delete_id').val(id);
    }

    function deleteCustomerDocModal(id) {
        $('#customer_document_delete_id').val(id);
    }

    function delete_customer_address() {
        var id = $('#customer_address_delete_id').val();
        var customer_id = $('#customer_id').val();
        $.ajax({
            url: '<?php echo base_url();?>customer_settings/customer/delete_customer_address',
            data: {id: id},
            type: 'post',
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('#deleteCustomerAddress').modal('toggle');
                $('#showMessage').html("<?php echo lang('delete_success');?>");
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

    function delete_customer_document() {
        var id = $('#customer_document_delete_id').val();
        $.ajax({
            url: '<?php echo base_url();?>customer_settings/customer/delete_customer_doc',
            data: {id: id},
            type: 'post',
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('#deleteCustomerDocumentModal').modal('toggle');
                $('#showMessage').html("<?php echo lang('delete_success');?>");
                $('#showMessage').show();
                window.onload = searchFilterDocument(0);
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

    function editCustomer(id) {
        $.ajax({
            url: '<?php echo base_url();?>customer_settings/customer/editCustomerInfo',
            data: {id: id},
            type: 'post',
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
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
                    $('.loading').fadeOut("slow");

                    return false;
                } else {
                    return false;
                }
            }
        });
    }
    function invoice_full_view(id) {
        $('#sale_print').html('');
        $('#sale_view').html('');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>invoice_full_view_sale/' + id ,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                // console.log(html);
                $('#sale_print').html(html);
                $('.loading').fadeOut("slow");
                $('#SaleInvoiceA4Details').modal('toggle');
            }
        });
    }


    $.validator.setDefaults({
        submitHandler: function (form) {
            //console.log(form.id);
            var id = form.id;
            if (id == "edit_customer_info") {
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
                                var id_customer = $('#id_customer').val();
                                window.location.href = '<?php echo base_url();?>customer/' + id_customer;

                            }, 3000);
                            $('.loading').fadeOut("slow");
                        }

                    }
                });
            }

            if (id == "enter_customer_address") {
                var currentForm = $('#enter_customer_address')[0];
                var formData = new FormData(currentForm);

                $.ajax({
                    url: "<?= base_url() ?>customer_settings/customer/create_customer_address",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (response) {
                        var result = $.parseJSON(response);
                        var customer_id = result.customer_id;
                        if (result.status != 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#add_customer_address').modal('toggle');
                            $('#enter_customer_address').trigger("reset");
                            $("#address_type").val("0").change();
                            $("#city_division").val("0").change();
                            $("#address_location").val("0").change();
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

            if (id == "edit_customer_address") {
                var currentForm = $('#edit_customer_address')[0];
                var formData = new FormData(currentForm);

                $.ajax({
                    url: "<?= base_url() ?>customer_settings/customer/update_customer_address",
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
                            $('#edit_customer_address_section').modal('toggle');
                            $('#edit_customer_address').trigger("reset");
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

            if (id == "enter_customer_documents") {
                var currentForm = $('#enter_customer_documents')[0];
                var formData = new FormData(currentForm);
                formData.append('file', document.getElementById("document_file").files[0]);
                $.ajax({
                    url: "<?= base_url() ?>customer_settings/customer/create_customer_document",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (response) {
                        var result = $.parseJSON(response);
                        var customer_id = result.customer_id;
                        if (result.status != 'success') {
                            $.each(result, function (key, value) {
                                $("#" + key).addClass("error");
                                $("#" + key).after(' <label class="error">' + value + '</label>');
                            });
                        } else {
                            $('#add_customer_documents').modal('toggle');
                            $('#enter_customer_documents').trigger("reset");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilterDocument(0);
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);

                            }, 3000);
                        }
                        $('.loading').fadeOut("slow");
                    }
                });
            }

            if (id == "edit_customer_document") {
                var currentForm = $('#edit_customer_document')[0];
                var formData = new FormData(currentForm);
                formData.append('file', document.getElementById("edit_document_file").files[0]);
                $.ajax({
                    url: "<?= base_url() ?>customer_settings/customer/update_customer_document",
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
                            $('#edit_customer_document_modal').modal('toggle');
                            $('#edit_customer_documents').trigger("reset");
                            $('#showMessage').html(result.message);
                            $('#showMessage').show();
                            window.onload = searchFilterDocument(0);
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

</script>

