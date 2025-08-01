<?php
if (!empty($posts)):
    ?>

    <div class="form-group">
        <label class="col-sm-4 col-form-label"><?= lang('person_name') ?><span
                    class="req">*</span></label>
        <div class="col-sm-6">
            <select class="form-control" id="person_name" name="person_name">
                <option value="0" selected><?= lang('select_one') ?></option>
                <?php
                foreach ($posts as $post):
                    echo '<option value="' . $post->id . '">' . $post->user_name . '</option>';
                endforeach;
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 col-form-label"><?= lang('commission') ?>(%)<span
                    class="req">*</span></label>
        <div class="col-sm-6">
            <input class="form-control Number" name="commission" id="commission">
        </div>
    </div>
    <?php
endif;
?>