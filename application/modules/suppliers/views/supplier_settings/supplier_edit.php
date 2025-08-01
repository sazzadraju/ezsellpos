<div id="editSupplierInfo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header"><?= lang('edit_supplier') ?> <span class="close"
                                                                              data-dismiss="modal">&times;</span></h6>
            </div>
            <?php echo form_open_multipart('', array('id' => 'edit_supplier_info', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                <input type="hidden" name="supplier_id" id="edit_supplier_id">
                <input type="hidden" name="version" id="edit_version">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('supplier_code') ?></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('supplier_code') ?>" type="text"
                               id="edit_supplier_code" name="edit_supplier_code" readonly="readonly">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('supplier_name') ?><span
                            class="req">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('supplier_name') ?>" type="text"
                               id="edit_full_name" name="edit_full_name">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('contact_person') ?><span
                            class="req">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('contact_person') ?>" type="text"
                               id="edit_contact_person" name="edit_contact_person">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for=""><?= lang('email') ?></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('email') ?>" type="email" id="edit_email"
                               name="edit_s_email">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('phone') ?><span class="req">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('phone') ?>" type="text" id="edit_phone"
                               name="edit_phone">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('city_division') ?></label>
                    <div class="col-sm-8">
                        <div class="row-fluid">
                            <select class="select2" data-live-search="true" id="city_division1" name="city_division2"
                                    onchange="editLocationAddress(value);">
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

                <input type="hidden" name="division_id" id="edit_division_id">
                <input type="hidden" name="district_id" id="edit_district_id">

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('location') ?></label>
                    <div class="col-sm-8">
                        <div class="row-fluid">
                            <select class="select2" id="edit_address_location" name="edit_address_location2"
                                    onchange="editCityDistLoc(value);">
                                <option value="0"><?= lang('select_one') ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="city_id" id="edit_city_id">
                <input type="hidden" name="city_location_id" id="edit_city_location_id">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('vat_reg_no') ?></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('vat_reg_no') ?>" type="text" id="edit_vat_reg_no"
                               name="edit_vat_reg_no">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('note') ?></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('note') ?>" type="text" id="edit_note"
                               name="edit_note">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('address') ?></label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="3" id="edit_addr_line_1" name="edit_s_addr_line_1"
                                  value="addr_line_1"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="">Store</label>
                    <div class="col-sm-8">
                        <select class="form-control select2" multiple="true" name="edit_store_id[]" id="edit_store_id">

                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('supplier_photo') ?></label>
                    <div class="col-sm-8">
                        <div class="col-sm-12 bottom-10 pad-left-0">
                            <img src="" alt="Supplier Photo" id="supplier_photo" width="170px" height="100px">
                        </div>
                        <div class="col-sm-12 pad-left-0">
                            <input type="file" name="edit_profile_img" id="edit_profile_img">
                            <input type="hidden" name="old_supplier_photo" id="old_supplier_photo">
                            <p style="color: #0073FF;font-weight: 600;text-shadow: 1px 1px 1px #adadad; font-size:10px"> <?= lang("file_type"); ?></p>
                        </div>
                    </div>
                </div>

                <div class="form-buttons-w">
                    <button class="btn btn-primary" type="submit"> <?= lang('submit') ?></button>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <input class="btn btn-primary" type="submit" value="Submit"> </button> -->
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>