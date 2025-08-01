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

                        <a style="position: absolute;right: 25%;" href="<?= base_url();?>tailoring" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> All Services </a>


                        <div class="element-box">

                                <?php 
                                    // echo '<pre>';
                                    // print_r($tailoring_types);
                                    // print_r($tailoring_fields);
                                    // print_r($tailoring_designs);
                                    // echo '</pre>';
                                ?>

                                <form id="tService" class="auto" action="<?= base_url();?>tailoring/service_insert" enctype="multipart/form-data" method="post">
                                    <h6 class="element-header">Service</h6>
                                    <div class="col-md-6">
                                        <div class="form-group row">

                                            <label class="col-sm-12 col-form-label" for="sName">Service Name</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" name='sName' placeholder="Service Name" type="text" value="<?php if(isset($tailoring_types)){echo $tailoring_types['service_name'];}?>">
                                                <?php echo form_error('sName', '<div class="error">', '</div>'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">

                                            <label class="col-sm-12 col-form-label" for="sPrice">Price</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" name="sPrice" placeholder="Price" type="text" value="<?php if(isset($tailoring_types)){echo $tailoring_types['service_price'];}?>">
                                                <?php echo form_error('sPrice', '<div class="error">', '</div>'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <fieldset class="form-group">
                                        <legend><b>Measurement fields</b></legend>

                                        <div class="repeatMeasurement">

                                            <div class="singleMeasurement">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <input class="form-control MeasureFields" id="fid-0" name="fieldName[]" placeholder="Field Name" type="text" value="<?php if(isset($tailoring_fields)){echo $tailoring_fields[0]['field_name'];}?>">
                                                        <?php echo form_error('fieldName[0]', '<div class="error">', '</div>'); ?>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <p style="margin-top:7px">
                                                            <input type="hidden" name="fSta[0]" value="" />
                                                            <input type="checkbox" id="fnStatus-0" name="fSta[0]" <?php if(isset($tailoring_fields)){if($tailoring_fields[0][ 'is_required']==1 ){echo 'checked';}}?> >
                                                            <label for="fnStatus-0">Required</label>
                                                            <input type="hidden" name="cMeasure[]">
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="mr-2 mb-2 btn btn-primary btn-rounded" id="addMeasurement" type="button"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php 
                                                    if(isset($tailoring_fields)):
                                                    $c = count($tailoring_fields);
                                                        for ($i=0; $i < $c; $i++):
                                                            if ($i == 0) { continue;}
                                                ?>
                                                <div class="singleMeasurement">
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <input class="form-control MeasureFields" id="fid-<?php echo $i;?>" name="fieldName[]" placeholder="Field Name" type="text" value="<?php echo $tailoring_fields[$i]['field_name'];?>">
                                                            <?php echo form_error('fieldName['.$i.']', '<div class="error">', '</div>'); ?>

                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>
                                                                <input type="hidden" name="fSta[<?php echo $i;?>]" value="" />
                                                                <input type="checkbox" id="fnStatus-<?php echo $i;?>" name="fSta[<?php echo $i;?>]" <?php if(isset($tailoring_fields)){if($tailoring_fields[$i][ 'is_required']==1 ){echo 'checked';}}?> >
                                                                <label for="fnStatus-<?php echo $i;?>">Required</label>
                                                                <input type="hidden" name="cMeasure[]">
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <button class="btn btn-danger btn-rounded measurMinus" type="button"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                    endfor;
                                                    endif;
                                                ?>

                                        </div>

                                        <!--
                                            <div class="element-box-content2">
                                               
                                            </div>
-->
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <legend><b>Design</b></legend>
                                        <div class="repeatDesign">

                                            <div class="singleDesign">
                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <input class="form-control designName" id="dName-0" name="designName[]" placeholder="Design Name" type="text" value="<?php if(isset($tailoring_designs)){ echo $tailoring_designs[0]['field_name'];}?>">
                                                        <?php echo form_error('designName[0]', '<div class="error">', '</div>'); ?>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <p>
                                                            <input type="hidden" name="oldfiles[]" value="<?php if(isset($tailoring_designs)){ echo $tailoring_designs[0]['field_img'];}?>">
                                                            <input type="file" id="userfile-0" name="userfile[]">
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button id="addDesign" class="mr-2 mb-2 btn btn-primary btn-rounded" type="button"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="margin-top-10">
                                                            <textarea id="dDesc-0" name="dDesc[]" class="form-control" rows="3">
                                                                <?php if(isset($tailoring_designs)){ echo $tailoring_designs[0]['notes'];}?>
                                                            </textarea>
                                                            <input type="hidden" name="cDesign[]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php 
                                                    if(isset($tailoring_designs)):
                                                    $c = count($tailoring_designs);
                                                        for ($i=0; $i < $c; $i++):
                                                            if ($i == 0) { continue;}
                                                ?>
                                                <div class="singleDesign">
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <input class="form-control designName" id="dName-<?php echo $i;?>" name="designName[]" placeholder="Design Name" type="text" value="<?php if(isset($tailoring_designs)){ echo $tailoring_designs[$i]['field_name'];}?>">
                                                            <?php echo form_error('designName['.$i.']', '<div class="error">', '</div>'); ?>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>
                                                                <input type="hidden" name="oldfiles[]" value="<?php if(isset($tailoring_designs)){ echo $tailoring_designs[$i]['field_img'];}?>">
                                                                <input type="file" id="userfile-<?php echo $i;?>" name="userfile[]">
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <button class="btn btn-danger btn-rounded designMinus" type="button"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <textarea id="dDesc-<?php echo $i;?>" name="dDesc[]" class="form-control" rows="3">
                                                                <?php if(isset($tailoring_designs)){ echo $tailoring_designs[$i]['notes'];}?>
                                                            </textarea>
                                                            <input type="hidden" name="cDesign[]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                    endfor;
                                                    endif;
                                                ?>

                                        </div>

                                    </fieldset>

                                    <div class="form-buttons-w" style="text-align: right;">
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
<script src="<?= base_url()?>themes/default/js/jquery.validate.min.js"></script>
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
                "fieldName[]": "required"
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
                if (cField.next().hasClass('error')) {} else {
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
                if (cField.next().hasClass('error')) {} else {
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

        $(".repeatMeasurement").append('<div class="singleMeasurement"><div class="row"><div class="col-sm-5"><input class="form-control MeasureFields" id="fid-' + id + '" name="fieldName[]" placeholder="Field Name" type="text"></div><div class="col-sm-5"><p style="margin-top:7px"><input type="hidden" name="fSta[' + id + ']" value="" /><input type="checkbox" id="fnStatus-' + id + '" name="fSta[' + id + ']" ><label for="fnStatus-' + id + '">Required</label><input type="hidden" name="cMeasure[]"></p></div><div class="col-sm-2"><button class="btn btn-danger btn-rounded measurMinus" type="button"><i class="fa fa-minus"></i></button></div></div></div>');
    });

    // append design block

    $(document).on('click', '#addDesign', function () {

        var container = $('.repeatDesign');
        var inputs = container.find('.singleDesign');
        var id2 = inputs.length;

        $(".repeatDesign").append('<div class="singleDesign"><div class="form-group row"><div class="col-sm-5"><input class="form-control designName" id="dName-' + id2 + '" name="designName[]" placeholder="Design Name" type="text"></div><div class="col-sm-5"><p style="margin-top:7px"><input type="hidden" name="oldfiles[]" value=""><input type="file" id="userfile-' + id2 + '" name="userfile[]" checked=""></p></div><div class="col-sm-2"><button class="btn btn-danger btn-rounded designMinus" type="button"><i class="fa fa-minus"></i></button></div><div class="col-sm-12"><textarea id="dDesc-' + id2 + '" name="dDesc[]" class="form-control" rows="3"></textarea><input type="hidden" name="cDesign[]"></div></div></div>');
    });

    // remove Measurement append element 

    $(document).on('click', '.measurMinus', function () {
        $(this).closest('.singleMeasurement').remove();
    });

    // remove Measurement append element 

    $(document).on('click', '.designMinus', function () {
        $(this).closest('.singleDesign').remove();
    });
</script>
<style type="text/css">
    .singleMeasurement,
    .singleDesign {
        float: left;
        width: 100%;
    }
</style>