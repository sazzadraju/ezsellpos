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
            <div class="col-lg-12">
                <?php echo form_open_multipart('', array('id' => 'product', 'class' => 'cmxform')); ?>
                <div class="element-wrapper">
                    <div class="full-box element-box">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('from_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group date" id="DOB">
                                            <input class="form-control valid" aria-invalid="false" type="text"
                                                   name="FromDate" id="FromDate" onkeyup="product_list_suggest(this);">
                                        <span class="input-group-addon"> 
                                        <!-- <input type="hidden" name="product_id" id="product_id"> -->
                                       
                                        <span class="glyphicon glyphicon-calendar"></span>  
                                       </span>
                                        </div>
                                        <label id="FromDate-error" class="error" for="product_name"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group date" id="DOB">
                                            <input class="form-control valid" aria-invalid="false" type="text"
                                                   name="ToDate" id="ToDate" onkeyup="product_list_suggest(this);">
                                        <span class="input-group-addon">     
                                       <span class="glyphicon glyphicon-calendar"></span>  
                                       </span>
                                        </div>
                                        <label id="ToDate-error" class="error" for="product_name"></label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-5 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("agent-name"); ?></label>
                                    <div class="col-sm-12">

                                        <select class="form-control" id="agent_name" name="agent_name">
                                            <option value="">Select One</option>
                                           <?php
                                            foreach ($agents as $agent) {

                                                echo '<option value="' . $agent->id_agent . '">' . $agent->agent_name . '</option>';
                                            }
                                            ?> 
                                        </select>
                                    </div>

                                </div>
                            </div>


                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                        class="fa fa-search"></i> <?= lang("search"); ?></button>
                            </div>
                            <?php echo form_close(); ?>

                        </div>
                    </div>
                    <!-- body view from here -->
                    <div class="element-box full-box">
                       
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th class="right_text"><?= lang("invoice_no"); ?></th>
                                        <th class="right_text"><?= lang("agent-name"); ?></th>
                                        <th class="right_text"><?= lang("invoice_amount"); ?></th>
                                        <th class="right_text"><?= lang("delivery_cost"); ?></th>
                                        <th class="right_text"><?= lang("cod_cost"); ?></th>
                                        </thead>

                                    </table>

                                    <div class="clearfix"></div>
                                    <?php echo $this->ajax_pagination->create_links(); ?>

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


    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        var agent_name = $('#agent_name').val();
        $err_count = 1;
        $('#FromDate-error').html("");
        $('#ToDate-error').html("");
        if (FromDate == '') {
            $err_count = 2;
            $('#FromDate-error').html("Please fill start Date");
        }
        if (ToDate == '') {
            $err_count = 2;
            $('#ToDate-error').html("Please fill end Date");
        }

        if ($err_count == 1) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>cod-costs/page_data/' + page_num,
                data: 'page=' + page_num + '&FromDate=' + FromDate + '&agent_name=' + agent_name + '&ToDate=' + ToDate,
                // beforeSend: function () {
                //     $('.loading').show();
                // },
                success: function (html) {
                    console.log(html);
                    // alert(html);
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
            });
        }
    }


    $(function () {
        $('#FromDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });
    $(function () {
        $('#ToDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });
    

</script> 
