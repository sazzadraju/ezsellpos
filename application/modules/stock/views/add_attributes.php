<div class="modal fade" id="add_attributes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Add Attributes</h4>
            </div>
            <style>
                .attributes-color label {
                    float: left;
                    margin: 0 10px 10px 10px !important;
                }
            </style>
            <?php echo form_open_multipart('', array('id' => 'submit_add_attribute', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                <div id="error_msg" class="error"></div>
                <?php
                $sl = 1;
                if(!empty($attributes)){
                    foreach ($attributes as $attr) {
                        echo '<div class="row">';
                        echo '<div class="col-md-4">';
                        echo '<input class="main mn_' . $sl . '" id="' . $sl . '" name="main[]" value="' . $attr->id_attribute . '@' . $attr->attribute_name . '" type="checkbox">';
                        echo '<label style="font-weight:bold" for="' . $sl . '">' . $attr->attribute_name . '</label>';
                        echo '</div>';
                        echo '<div class="col-md-8 attributes-color checkGroup">';
                        $stringValue = $attr->attribute_value;
                        $ch = 1;
                        foreach (explode(',', $stringValue) AS $value) {
                            echo '<input class="ch_' . $sl . ' child_value" id="c_' . $ch . '_' . $sl . '" name="child[' . $attr->id_attribute . '][]" value="' . $value . '" type="checkbox">';
                            echo '<label for="c_' . $ch . '_' . $sl . '">' . $value . '</label>';
                            $ch++;
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '<hr>';
                        $sl++;
                    }
                }
                ?>
            </div>
            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" value="<?= lang('submit') ?>"> </button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>