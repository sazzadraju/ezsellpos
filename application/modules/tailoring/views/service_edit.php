<ul class="breadcrumb">
    <?php
    echo $this->breadcrumb->output();
    ?>
</ul>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <div class="element-wrapper">

                        <a style="position: absolute;right: 5%;" href="<?= base_url(); ?>tailoring"
                           class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> All Services </a>


                        <div class="element-box">
                            <form id="tService" class="full-box" action="<?= base_url(); ?>tailoring/service_update"
                                  enctype="multipart/form-data" method="post">
                                <h6 class="element-header">Service</h6>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="sName">Service Name</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" name='sName' placeholder="First Name"
                                                   type="text" value="<?php echo $aServiceData['service_name']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="sPrice">Price</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" name="sPrice" placeholder="Price" type="text"
                                                   value="<?php echo $aServiceData['service_price']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <legend><b>Measurement fields</b></legend>

                                            <div class="repeatMeasurement">
                                                <?php
                                                $fi = 0;
                                                foreach ($aServiceData['fields'] as $singleField):
                                                    ?>
                                                    <div class="singleMeasurement">
                                                        <div class="form-group row">
                                                            <div class="col-sm-5">
                                                                <input class="form-control MeasureFields"
                                                                       id="fid-<?php echo $fi; ?>" name="fieldName[]"
                                                                       placeholder="Field Name" type="text"
                                                                       value="<?php echo $singleField['field_name']; ?>">
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    <?php
                                                                    $rf = $singleField['is_required']
                                                                    ?>
                                                                    <input type="hidden" name="fSta[<?php echo $fi; ?>]"
                                                                           value=""/>
                                                                    <input type="checkbox"
                                                                           id="fnStatus-<?php echo $fi; ?>"
                                                                           name="fSta[<?php echo $fi; ?>]" <?php if ($rf == 1) {
                                                                        echo "checked";
                                                                    } ?>>
                                                                    <label
                                                                        for="fnStatus-<?php echo $fi; ?>">Required</label>
                                                                    <input type="hidden" name="cMeasure[]">
                                                                </p>
                                                            </div>

                                                            <?php if ($fi == 0): ?>
                                                                <div class="col-sm-2">
                                                                    <button
                                                                        class="mr-2 mb-2 btn btn-primary btn-rounded"
                                                                        id="addMeasurement" type="button"><i
                                                                            class="fa fa-plus"></i></button>
                                                                </div>
                                                            <?php endif; ?>

                                                            <?php if ($fi > 0): ?>
                                                                <div class="col-sm-2">
                                                                    <button
                                                                        class="btn btn-danger btn-rounded measurMinus"
                                                                        type="button"><i class="fa fa-minus"></i>
                                                                    </button>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $fi++;
                                                endforeach;
                                                ?>

                                            </div>


                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <legend><b>Design</b></legend>
                                            <div class="repeatDesign">
                                                <?php
                                                $di = 0;
                                                foreach ($aServiceData['designs'] as $singleDesign):
                                                    ?>
                                                    <div class="singleDesign">
                                                        <div class="form-group row">
                                                            <div class="col-sm-5">
                                                                <input class="form-control designName"
                                                                       id="dName-<?php echo $di; ?>" name="designName[]"
                                                                       placeholder="Design Name" type="text"
                                                                       value="<?php echo $singleDesign['field_name']; ?>">
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    <input type="hidden" name="oldfiles[]"
                                                                           value="<?php echo $singleDesign['field_img']; ?>">
                                                                    <input type="file" id="userfile-<?php echo $di; ?>"
                                                                           name="userfile[]">
                                                                </p>
                                                            </div>

                                                            <?php if ($di == 0): ?>
                                                                <div class="col-sm-2">
                                                                    <button id="addDesign"
                                                                            class="mr-2 mb-2 btn btn-primary btn-rounded"
                                                                            type="button"><i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            <?php endif; ?>

                                                            <?php if ($di > 0): ?>
                                                                <div class="col-sm-2">
                                                                    <button
                                                                        class="btn btn-danger btn-rounded designMinus"
                                                                        type="button" fImg="<?php echo $singleDesign['field_img']; ?>"><i class="fa fa-minus"></i>
                                                                    </button>
                                                                </div>
                                                            <?php endif; ?>

                                                            <div class="col-sm-5">
                                                            <textarea id="dDesc-<?php echo $di; ?>" name="dDesc[]" class="form-control" rows="3">
                                                                <?php echo $singleDesign['notes']; ?>
                                                            </textarea>
                                                                <input type="hidden" name="cDesign[]">
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <?php
                                                                if ($singleDesign['field_img'] != NULL) {
                                                                    echo '<img src="' . documentLink('tailoring') . $singleDesign['field_img'] . '"width="80">';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $di++;
                                                endforeach;
                                                ?>
                                            </div>

                                        </fieldset>
                                    </div>
                                </div>
                                <div class="form-buttons-w">
                                    <input type="hidden" name="updateid" value="<?php echo $updateid; ?>">
                                    <button class="btn btn-primary" type="submit"> Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        // validate the comment form when it is submitted
        $("#tService").validate({
            rules: {
                "sName": "required",
                "sPrice": {
                    required: true,
                    number: true
                },
                "fieldName[]": "required",
                // "designName[]": "required",
                // "userfile[]": "required",
            }
        });
    });

    $("#tService").submit(function (e) {
        $('.newEntry').each(function () {
            var kk = $(this).val();
            if (kk) {
            } else {
                e.preventDefault();
                $(this).addClass("error");
                if ($(this).next().hasClass('error')) {
                } else {
                    $(this).after('<p class="error">This field is required.</p>');
                }
            }

        });
    });

    // duplicate value field name 

    $(document).on('keyup', '.MeasureFields', function () {
        var kk = $(this).val();
        var cField = $(this);
        var ii = 0;
        $('input[name^="fieldName"]').each(function () {
            var pp = $(this).val();

            if (kk == pp) {
                ii++;
            }
            if (ii > 1) {
                if (cField.next().hasClass('error')) {
                } else {
                    cField.addClass("error");
                    cField.after('<p class="error">Matching with another field name.</p>');
                }
            } else {
                if (cField.next().hasClass('error')) {
                    cField.removeClass("error");
                    cField.next(".error").remove();
                }

            }
        });
    });

    // Duplicate value desidn name 

    $(document).on('keyup', '.designName', function () {
        var kk = $(this).val();
        var cField = $(this);
        var ii = 0;
        $('input[name^="designName"]').each(function () {
            var pp = $(this).val();

            if (kk == pp) {
                ii++;
            }
            if (ii > 1) {
                if (cField.next().hasClass('error')) {
                } else {
                    cField.addClass("error");
                    cField.after('<p class="error">Matching with another Design name.</p>');
                }
            } else {
                if (cField.next().hasClass('error')) {
                    cField.removeClass("error");
                    cField.next(".error").remove();
                }

            }
        });
    });

    // append Measurement block

    $(document).on('click', '#addMeasurement', function () {

        var container = $('.repeatMeasurement');
        var inputs = container.find('.singleMeasurement');
        var id = inputs.length;

        $(".repeatMeasurement").append('<div class="singleMeasurement"><div class="form-group row"><div class="col-sm-5"><input class="form-control MeasureFields" id="fid-' + id + '" name="fieldName[]" placeholder="Field Name" type="text"></div><div class="col-sm-5"><p><input type="hidden" name="fSta[' + id + ']" value="" /><input type="checkbox" id="fnStatus-' + id + '" name="fSta[' + id + ']"><label for="fnStatus-' + id + '">Required</label><input type="hidden" name="cMeasure[]"></p></div><div class="col-sm-2"><button class="btn btn-danger btn-rounded measurMinus" type="button"><i class="fa fa-minus"></i></button></div></div></div>');
    });

    // append design block

    $(document).on('click', '#addDesign', function () {

        var container = $('.repeatDesign');
        var inputs = container.find('.singleDesign');
        var id2 = inputs.length;

        $(".repeatDesign").append('<div class="singleDesign"><div class="form-group row"><div class="col-sm-5"><input class="form-control designName" id="dName-' + id2 + '" name="designName[]" placeholder="Design Name" type="text"></div><div class="col-sm-5"><p><input type="hidden" name="oldfiles[]" value=""><input type="file" class="newEntry" id="userfile-' + id2 + '" name="userfile[]"></p></div><div class="col-sm-2"><button class="btn btn-danger btn-rounded designMinus" type="button"><i class="fa fa-minus"></i></button></div><div class="col-sm-12"><textarea id="dDesc-' + id2 + '" name="dDesc[]" class="form-control" rows="3"></textarea><input type="hidden" name="cDesign[]"></div></div></div>');
    });

    // remove Measurement append element 

    $(document).on('click', '.measurMinus', function () {
        $(this).closest('.singleMeasurement').remove();
    });

    // remove Measurement append element 

    $(document).on('click', '.designMinus', function () {
        var fImg = $(this).attr("fImg");
        $(this).closest('.singleDesign').html('<input type="hidden" name="deletedDesign[]" value="'+fImg+'" />');        
    });
</script>
<style type="text/css">
    .singleMeasurement,
    .singleDesign {
        float: left;
        width: 100%;
    }
</style>