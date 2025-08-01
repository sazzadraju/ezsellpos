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
            <div class="col-lg-5">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <input type="hidden" name="id" id="id" value="">
                        <h6 class="element-header"
                            id="layout_title"><?php echo $this->lang->line('point_earn_rate'); ?></h6>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <input class="form-control NumberOnly" name="point" id="point" placeholder="" type="text" value="<?= $earn_ratio[0]['param_val']?>">
                            </div>
                            <label class="col-sm-3 col-form-label" for=""><p style="line-height: 29px;"> <?= lang('bdt')?></p></label>

                            <div class="col-sm-1">
                                <p style="line-height: 29px;"> =</p>
                            </div>
                            <div class="col-sm-4">
                                <p style="line-height: 29px;">1 <?php echo $this->lang->line('point'); ?></p>
                            </div>
                        </div>
                        <div class="form-buttons-w">
                            <button class="btn btn-primary" onclick="updatePoints()"
                                    type="submit"><?php echo $this->lang->line('update'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <input type="hidden" name="id" id="id" value="">
                        <h6 class="element-header"
                            id="layout_title"><?php echo $this->lang->line('point_redeem_rate'); ?></h6>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for=""><p style="line-height: 29px;">  1 <?php echo $this->lang->line('point'); ?></p> </label>
                            <div class="col-sm-1">
                               <p style="line-height: 29px;"> =</p>
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control NumberOnly" name="redeem" id="redeem" placeholder="" type="text" value="<?= $redeem_ratio[0]['param_val']?>">
                            </div>
                            <div class="col-sm-4">
                              <p style="line-height: 29px;">  <?= lang('bdt')?></p>
                            </div>
                        </div>
                        <div class="form-buttons-w">
                            <button class="btn btn-primary" onclick="updateRedeem()"
                                    type="submit"><?php echo $this->lang->line('update'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>


    function updatePoints() {
        var earn=$('#point').val();
        if(earn==''){
            $('#point').addClass('error');
        }else{
            $('#point').removeClass('error');
            $.ajax({
                url: "<?= base_url() ?>customer_settings/customer_points/earn_points",
                type: 'POST',
                data:'id=' + earn,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (response) {
                    var result = $.parseJSON(response);
                    if (result.status != 'success') {
                        alert('error data');
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);
                        }, 3000);
                    }
                    $('.loading').fadeOut("slow");
                }
            });
        }

    }
    function updateRedeem() {
        var earn=$('#redeem').val();
        if(earn==''){
            $('#redeem').addClass('error');
        }else {
            $('#redeem').removeClass('error');
            $.ajax({
                url: "<?= base_url() ?>customer_settings/customer_points/redeem_points",
                type: 'POST',
                data: 'id=' + earn,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (response) {
                    var result = $.parseJSON(response);
                    if (result.status != 'success') {
                        alert('error data');
                    } else {
                        $('#showMessage').html(result.message);
                        $('#showMessage').show();
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);
                        }, 3000);
                    }
                    $('.loading').fadeOut("slow");
                }
            });
        }
    }

</script>