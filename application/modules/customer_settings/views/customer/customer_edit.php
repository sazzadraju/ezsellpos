<div id="edit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header"><?= lang('edit_customer') ?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <?php echo form_open_multipart('', array('id' => 'edit_customer_info', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                <input type="hidden" name="customer_id" id="edit_customer_id">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('membership_id') ?><span class="req">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('membership_id') ?>" type="text" id="edit_customer_code" name="edit_customer_code">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('full_name') ?><span class="req">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('full_name') ?>" type="text" id="edit_customer_name" name="edit_full_name">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('customer_type') ?><span class="req">*</span></label>
                    <div class="col-sm-8">

                        <div class="row-fluid">
                            <select class="select2" data-live-search="true" id="edit_customer_type_id" name="edit_customer_type_id">
                                <option value="0"><?= lang('select_one') ?></option>
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

                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for=""><?= lang('email') ?></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('email') ?>" type="email" id="edit_email" name="edit_c_email">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('phone') ?><span class="req">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="<?= lang('phone') ?>" type="text" id="edit_phone" name="edit_phone">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('gender') ?></label>
                    <div class="col-sm-8">
                        <div class="col-sm-4">
                            <input id="Male2" value="Male" name="edit_gender" type="radio" class="edit_gender">
                            <label for="Male2"><?= lang('male') ?></label>
                        </div>
                        <div class="col-sm-4">
                            <input id="Female2" value="Female" name="edit_gender" type="radio" class="edit_gender">
                            <label for="Female2"><?= lang('female') ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('dob') ?></label>
                    <div class='col-sm-8'>
                        <div class='input-group date' id='edit_DOB'>
                            <input type='text' class="form-control" id="edit_birth_date" name="edit_birth_date"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('marital_status') ?></label>
                    <div class="col-sm-8">

                        <div class="row-fluid">
                            <select class="select2" id="edit_marital_status" name="edit_marital_status">
                                <option selected><?= lang('select_one') ?></option>
                                <option value="Married">Married</option>
                                <option value="Unmarried">Unmarried</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for=""><?= lang('anniversary_date') ?></label>
                    <div class='col-sm-8'>
                        <div class='input-group date' id='edit_AD'>
                            <input type='text' class="form-control" id="edit_anniversary_date" name="edit_anniversary_date"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><?= lang('customer_photo') ?></label>
                    <div class="col-sm-8">
                        <div class="col-sm-12 pad-left-0">
                            <input type="file" name="profile_img" id="edit_profile_img">
                            <input type="hidden" name="old_customer_photo" id="old_customer_photo">
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

<script>
    $(function () {
        $('#edit_DOB').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

    });
    $(function () {
        $('#edit_AD').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

    });
</script>