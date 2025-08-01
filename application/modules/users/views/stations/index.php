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
            <div class="col-lg-6">
                <div class="element-wrapper"> 
                    <div class="element-box full-box">

                        <h6 class="element-header"><?= lang("number_station_availability"); ?></h6> 
                        <div class="station-info">
                            <h6><?= lang("total"); ?></h6> 
                            <div class="num"><?= $records[0]->param_val ?></div> 
                        </div>
                        <div class="station-info">
                            <h6><?= lang("used"); ?></h6> 
                            <div class="num"><?= $records[0]->utilized_val ?></div> 
                        </div>
                        <div class="station-info">
                            <h6><?= lang("remaining"); ?></h6> 
                            <div class="num"><?= ($records[0]->param_val - $records[0]->utilized_val) ?></div> 
                        </div>
                    </div> 

                    <div class="element-box full-box">
                        <?php echo form_open_multipart('', array('id' => 'stations', 'class' => 'cmxform')); ?>

                        <h6 class="element-header" id="layout_title"><?= lang("add_station"); ?></h6> 
                        <input type="hidden" name="station_no" id="station_no" value="<?= ($records[0]->param_val - $records[0]->utilized_val) ?>">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for=""><?= lang("station_name"); ?><span class="req">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="<?= lang("station_name"); ?>" type="text" id="station_name" name="station_name">
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><?= lang("store_name"); ?><span class="req">*</span></label>
                                <div class="col-sm-8">
                                    <div class="row-fluid">
                                        <select class="select2" data-live-search="true" id="store_name" name="store_name">
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
                                        <input type="hidden" name="store_id" id="store_id" value="">
                                    </div>
                                </div>
                            </div>

                        <div class="form-buttons-w">
                            <button class="btn btn-primary" onclick="resetAll()" type="reset" ><?= lang("reset"); ?></button>
                            <button class="btn btn-primary" type="submit"> <?= lang("submit"); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <h6 class="element-header"><?= lang("station_list"); ?></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang("sl_no"); ?></th>
                                        <th><?= lang("station_name"); ?></th>
                                        <th><?= lang("store_name"); ?></th>
                                        <th class="fit"><?= lang("action"); ?></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($posts)):
                                                $count = 1;
                                                foreach ($posts as $post):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count; ?> <input type="hidden" id="st_id_<?=$count?>" value="<?=$post->id_station;?>"></td>
                                                        <td><?php echo $post->name; ?><input type="hidden" id="str_id_<?=$count?>" value="<?=$post->store_id;?>"></td>
                                                        <td><?php echo $post->store_name; ?></td>
                                                        <td class="center fit">
                                                            <?php if($post->id_station != 1): ?>
                                                            <button class="btn btn-primary btn-xs" rel="tooltip" title="<?= lang("edit")?>"  data-title="<?= lang("edit"); ?>" onclick="edit_station(<?= $post->id_station ?>)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                            <?php endif;?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $count++;
                                                endforeach;
                                            else:
                                                ?>
                                                <tr>
                                                    <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
                                                </tr>
                                            <?php endif; ?>
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
<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>  
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script> 
<script>
function edit_station(id)
{
    $('#stations')[0].reset(); // reset form on modals
    //Ajax Load data from ajax
    $.ajax({
        url: "<?php echo base_url() ?>users/stations/edit_data/" + id,
        type: "GET",
        dataType: "JSON",
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (data)
        {
            $('.loading').fadeOut("slow");
            $('#layout_title').text('<?= lang("edit"); ?>');
            $('#station_name').val(data.name);
            $('#store_name').val(data.store_id).change();
            $('[name="id"]').val(data.id_station);
            $('#station_name').attr('name', 'st_name');
            $('#store_id').val(data.store_id);
            $('#store_name').prop('disabled', true);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
function resetAll() {
    $('#stations')[0].reset();
    $('#layout_title').text('<?= lang("add_station"); ?>');
    $('[name="id"]').val('');
    $('#station_name').attr('name', 'station_name');
    $('#store_name').prop('disabled', false);
    $('#store_id').val('');
}

$.validator.setDefaults({
    submitHandler: function (form) {
        var station = $('[name="station_no"]').val();
        var id = $('[name="id"]').val();
        if (station == 0&&id=='') {
            alert('Add Station First');
            return false;
        } else {
            var currentForm = $('#stations')[0];
            var formData = new FormData(currentForm);
            $.ajax({
                url: "<?= base_url() ?>users/stations/add_data",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (response) {
                    var result = $.parseJSON(response);
                    console.log(result);
                    if (result.status != 'success') {
                        $.each(result, function (key, value) {
                            $('[name="' + key + '"]').addClass("error");
                            $('[name="' + key + '"]').after(' <label class="error">' + value + '</label>');
                        });
                    } else {
                        $('#stations')[0].reset();
                        $('#showMessage').html(result.message);
                        $('#station_name').attr('name', 'station_name');
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>users/stations";
                        }, 200);
                    }
                     $('.loading').fadeOut("slow");
                }
            });
        }
    }
});
</script>  