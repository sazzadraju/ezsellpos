<div class="row">
    <?php if ($id == 2) {
        ?>
        <div class="col-sm-4">
            <div class="form-group row">
                <label class="col-sm-12 col-form-label" for=""><?= lang('agent-name')?> <span class="req">*</span></label>
                <div class="col-sm-12">
                    <select class="custom-select custom-select-sm" id="agent_name" onchange="setDelPerson(this)" name="agent_name">
                        <option value="0" selected><?= lang('select_one') ?></option>
                        <?php 
                        if (!empty($agents)) {
                            foreach ($agents as $agent) {
                                echo '<option value="' . $agent->id_agent . '@' . $agent->agent_name . '">' . $agent->agent_name . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <?php 
    }
    ?>
    <div class="col-md-4">
        <div class="form-group row">
            <label class="col-sm-12 col-form-label" for=""><?= lang('delivery_person') ?></label>
            <div class="col-sm-12">
                <select class="custom-select custom-select-sm" id="delivery_person1" name="delivery_person1">
                    <option value="0" selected><?= lang('select_one') ?></option>
                    <?php 
                    if ($id == 1) {
                        if (!empty($staffs)) {
                            foreach ($staffs as $staff) {
                                echo '<option value="' . $staff['id_delivery_person'] . '@' . $staff['person_name'] . '">' . $staff['person_name'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group row">
            <label class="col-sm-12 col-form-label" for=""><?= lang('service_name') ?><span class="req">*</span></label>
            <div class="col-sm-12">
                <select class="custom-select custom-select-sm" onchange="setServiceRange(this)"  id="service_name" name="service_name">
                    <option value="0" selected><?= lang('select_one') ?></option>
                    <?php 
                    if ($id == 1) {
                        if (!empty($costs)) {
                            foreach ($costs as $cost) {
                                echo '<option value="' . $cost->id_delivery_cost . '@' . $cost->delivery_name . '">' . $cost->delivery_name . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-4">
        <div class="form-group row">
            <label class="col-sm-12 col-form-label" for=""><?= lang('service_range') ?><span class="req">*</span></label>
            <div class="col-sm-12">
                <select class="custom-select custom-select-sm" onchange="setServicePrice(this)" id="service_range" name="service_range">
                    <option value="0" selected><?= lang('select_one') ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group row">
            <label class="col-sm-12 col-form-label" for=""><?=lang('service_price') ?><span class="req">*</span></label>
            <div class="col-sm-6">
                <input class="form-control" type="text" id="service_price" name="service_price">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group row">
            <label class="col-sm-12 col-form-label" for=""><?= lang('paid_amount') ?></label>
            <div class="col-sm-6">
                <input class="form-control" type="text" id="paid_amount" name="paid_amount">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group row">
            <label class="col-sm-12 col-form-label" for=""><?= lang('cod_charge') ?></label>
            <div class="col-sm-12">
                <input class="form-control" type="text" id="cod" name="cod">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group row">
            <label class="col-sm-12 col-form-label" for=""><?= lang('accounts') ?><span class="req">*</span></label>
            <div class="col-sm-12">
                <select class="custom-select custom-select-sm" onchange="checkAccounts(this)" id="service_accounts" name="service_accounts">
                    <option value="0" selected><?= lang('select_one') ?></option>
                    <?php
                    if (!empty($accounts)) {
                        foreach ($accounts as $account) :
                            $ac_name = !empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name'];
                            echo '<option actp="' . $account['acc_type'] . '" value="' . $account['acc_id'] . '@' . $ac_name . '">' . $ac_name . '</option>';
                        endforeach;
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div id="ref_trx_no"></div>