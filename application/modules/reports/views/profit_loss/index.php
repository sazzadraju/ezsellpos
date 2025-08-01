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
                            <div class="col-md-2 col-sm-12">
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
                            <div class="col-md-2 col-sm-12">
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
                                    <label class="col-sm-12 col-form-label"><?= lang("store"); ?></label>
                                    <div class="col-sm-12">

                                        <select class="select2" data-live-search="true" id="store_id" name="store_id[]"
                                                multiple="true" data-placeholder="Select store...">
                                            <?php
                                            foreach ($stores as $store) {

                                                echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("sales_person"); ?></label>
                                    <div class="col-sm-12">
                                        <select class="select2 col-md-12" style="float:left" data-live-search="true"
                                                id="sales_person" name="sales_person">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($salesPersons as $person) {
                                                foreach ($this->config->item('sales_person') as $key => $val) :
                                                    if ($person['person_type'] == $key) {
                                                        $type=$val;
                                                    }
                                                endforeach;

                                                echo '<option actp="' . $person['user_name'] . '" value="' .$person['id_sales_person'] . '">' . $person['user_name'] . '(' . $type . ')' . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                        class="fa fa-search"></i> <?= lang("search"); ?></button>
                                <button href="<?php echo base_url(); ?>stock_report/print_page" class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i class="fa fa-view"></i> <?= lang("print-view"); ?></button>
                            </div>
                            <?php echo form_close(); ?>

                        </div>
                    </div>
                    <!-- body view from here -->
                    <div class="element-box full-box">
                        <!--  <div class="row">
                            <div class="col-md-12">

                                <button data-toggle="modal" data-target="#add" class="btn btn-primary bottom-10 right" type="button" onclick="addProduct()"><?= lang("add_product"); ?></button>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang("date"); ?></th>
                                        <th><?= lang("store_name"); ?></th>

                                        <th class="right_text"><?= lang("profit_loss"); ?></th>
                                        <th class="right_text"><?= lang("round_amount"); ?></th>
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
        var store_id = $('#store_id').val();
        var sales_person = $('#sales_person option:selected').val();
        var all = new Array();
        var x = document.getElementById("store_id");
        for (var i = 0; i < x.options.length; i++) {
            if (x.options[i].selected) {
                // alert(x.options[i].value);
                all[i] = x.options[i].value;

            }
        }
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
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
                url: '<?php echo base_url(); ?>profit_loss/page_data/' + page_num,
                data: 'page=' + page_num + '&FromDate=' + FromDate + '&store_id=' + store_id + '&ToDate=' + ToDate+ '&sales_person=' + sales_person,
                 beforeSend: function () {
                     $('.loading').show();
                 },
                success: function (html) {
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
            });
        }
    }
    function searchFilter2() {
        var store_id = $('#store_id').val();
        var sales_person = $('#sales_person option:selected').val();
        var all = new Array();
        var x = document.getElementById("store_id");
        for (var i = 0; i < x.options.length; i++) {
            if (x.options[i].selected) {
                // alert(x.options[i].value);
                all[i] = x.options[i].value;

            }
        }
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
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
                url: '<?php echo base_url(); ?>reports/profit_loss/print_data',
                data: 'FromDate=' + FromDate + '&store_id=' + store_id + '&ToDate=' + ToDate+ '&sales_person=' + sales_person,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
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
