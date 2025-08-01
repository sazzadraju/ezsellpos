<div id="edit_employee" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg modal-full">
        <!-- Modal content-->
        <div class="modal-content">
            <?php echo form_open_multipart('', array('id' => 'employeeFormEdit', 'class' => 'cmxform',)); ?>
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("edit_employee"); ?> <span class="close"
                                                                                        data-dismiss="modal">&times;</span>
                </h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group row   bottom-20">
                            <label class="col-sm-4 bottom-20 col-form-label"><?= lang("user_id"); ?><span
                                    class="req">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="user_id" id="user_id" type="text" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group row   bottom-20">
                            <label class="col-sm-4 bottom-20 col-form-label"><?= lang("type"); ?><span
                                    class="req">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="edit_type_id" id="edit_type_id" type="text"
                                       readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("full_name"); ?><span
                                    class="req">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="name" id="emp_name"
                                       placeholder="<?= lang("full_name"); ?>" type="text">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-4" for=""> <?= lang("email"); ?><span
                                    class="req">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="<?= lang("email"); ?>" type="email"
                                       name="email" id="emp_email_id" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="emp_parmition_tab">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4" for=""> <?= lang("phone"); ?><span
                                        class="req">*</span></label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="<?= lang("phone"); ?>" type="text"
                                           name="phone" id="emp_phone">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for=""><?= lang("job_title"); ?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="<?= lang("job_title"); ?>" type="text"
                                           name="job_title" id="emp_job_title">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for=""><?= lang("dob"); ?></label>
                                <div class='col-sm-8'>
                                    <div class='input-group date' id='EMPDOB'>
                                        <input type='text' name="dob" id="emp_dob" class="form-control"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for=""><?= lang("joining_date"); ?></label>
                                <div class='col-sm-8'>
                                    <div class='input-group date' id='EMPJoiningDate'>
                                        <input type='text' name="joining_date" id="emp_joining_date"
                                               class="form-control"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for=""><?= lang("nid"); ?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="<?= lang("nid"); ?>" type="text"
                                           name="emp_nid" id="emp_nid">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for=""><?= lang("blood_group"); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="emp_blood_group" name="emp_blood_group">
                                        <option value="0" selected><?= lang("select_one"); ?></option>
                                        <?php
                                        $groups=$this->config->item('blood_groups');
                                        foreach ($groups as $group) {
                                            echo '<option value="' . $group . '">' . $group . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for=""><?= lang("salary"); ?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="<?= lang("salary"); ?>" type="text"
                                           name="salary" id="emp_salary">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><?= lang("store_name"); ?><span
                                        class="req">*</span></label>
                                <div class="col-sm-8">
                                    <div class="row-fluid">
                                        <select class="form-control"  id="emp_store_name" onchange="getStationEdit(this.value)"
                                                name="store_name">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($stores as $store) {
                                                if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                                    echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                } else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
                                                    echo '<option value="' . $store->id_store . '" selected>' . $store->store_name . '</option>';
                                                }

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><?= lang("station"); ?><span class="req">*</span></label>
                                <div class="col-sm-8">
                                    <div class="row-fluid">
                                        <select class="form-control"  id="emp_category"
                                                name="category">
                                            <option value="0"><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($stations as $station) {
                                                echo '<option value="' . $station->id_station . '">' . $station->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><?= lang("select_file"); ?></label>
                                <div class="col-sm-8">
                                    <input type="file" name="userfile" id="userfile">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="imageDiv" id="imageDiv"></div>
                        </div>
                    </div>

                </div>


                <div class="col-md-12">
                    <fieldset class="form-group">
                        <legend><?= lang("address"); ?></legend>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang('city_division') ?></label>
                                <div class="col-sm-12">
                                    <div class="row-fluid">
                                        <select class="selectpicker" data-live-search="true" id="city_division1"
                                                name="city_division2" onchange="editLocationAddress(value);">
                                            <option value="0" selected><?= lang('select_one') ?></option>
                                            <optgroup label="City Wise">
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
                        </div>
                        <input type="hidden" name="division_id" id="edit_division_id">
                        <input type="hidden" name="district_id" id="edit_district_id">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang('location') ?></label>
                                <div class="col-sm-12">
                                    <div class="row-fluid">
                                        <select class="selectpicker" id="edit_address_location" name="address_location2"
                                                onchange="editCityDistLoc(value);">
                                            <option value="0"><?= lang('select_one') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang('address') ?></label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="addr_line" id="edit_addr_line"
                                              value="addr_line"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="image_id" id="image_id">
                        <input type="hidden" name="city_id" id="edit_city_id">
                        <input type="hidden" name="city_location_id" id="edit_city_location_id">
                    </fieldset>
                </div>
            </div>

            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" value="<?= lang("submit"); ?>"> </button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
            </div>
            <input type="hidden" name="employee_id" id="employee_id" value="">
            <?php echo form_close(); ?>
        </div>


    </div>
</div>