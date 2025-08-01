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
                                        <div class="input-group date datepic" id="DOB">
                                            <input class="form-control valid" aria-invalid="false" type="text" name="FromDate" id="FromDate"  onkeyup="product_list_suggest(this);">
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
                                        <div class="input-group date datepic" id="DOB">
                                            <input class="form-control valid" aria-invalid="false" type="text" name="ToDate" id="ToDate"  onkeyup="product_list_suggest(this);">
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                                        </div>
                                        <label id="ToDate-error" class="error" for="product_name"></label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("store"); ?></label>
                                    <div class="col-sm-12">
                                        <!-- <div class="row-fluid"> -->
                                        <select class="select2" data-live-search="true" id="store_id" name="store_id">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($stores as $store) {
                                                // if (empty($station->_id_station)) {
                                                echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                // }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- </div> -->
                                </div>
                            </div>


                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                        class="fa fa-search"></i> <?= lang("search"); ?></button>
                                <button href="<?php echo base_url(); ?>stock_report/print_page"
                                        class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i
                                        class="fa fa-view"></i> <?= lang("print-view"); ?></button>
                                <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>

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
                                        <th><?= lang("sl"); ?></th>
                                        <th><?= lang("date"); ?></th>
                                        <th class="right_text"><?= lang("amount"); ?></th>
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
<script>


    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var store_id = $('#store_id').val();
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
                url: '<?php echo base_url(); ?>date-wise-sale/page_data/' + page_num,
                data: 'page=' + page_num + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate,
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
        $('.datepic').datetimepicker({
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
    // function print_page() {

    //     $this->load->view('products/stock-in-report');
    // }
    function searchFilter2(page_num) {
        page_num = page_num ? page_num : 0;
        var store_id = $('#store_id').val();
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
                url: '<?php echo base_url(); ?>date-wise-sale/print_page/' + page_num,
                data: 'page=' + page_num + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate,
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
    function csv_export() {
        var store_id = $('#store_id').val();
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
                url: '<?php echo base_url(); ?>reports/date_wise_sale/create_csv_data',
                data: 'store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    $('.loading').fadeOut("slow");
                    window.location.href = '<?php echo base_url(); ?>export_csv?request='+html;

                }
            });
        }
    }


</script> 
