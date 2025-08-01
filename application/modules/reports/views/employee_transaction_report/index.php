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
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"
                                           for=""><?= lang("employee_name_id"); ?></label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="employee_name_id"
                                                name="employee_name_id">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($employee_name as $employee) {

                                                echo '<option value="' . $employee->id_user . '">' . $employee->fullname . '</option>';
                                                // }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("transaction_type"); ?></label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="transaction_type"
                                                name="transaction_type" onChange="getState(this.value);">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($transaction_type as $key => $val) {
                                                // if (empty($station->_id_station)) {
                                                // var_dump($types );
                                                echo '<option value="' . $key . '">' . $val . '</option>';
                                                // }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("select_store"); ?></label>
                                    <div class="col-sm-12">
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
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("transaction_name"); ?></label>
                                    <div class="col-sm-12">
                                        <select class="select2" data-live-search="true" id="transaction_name"
                                                name="transaction_name">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <!--   <?php foreach ($trx_name as $trx_names) {
                                                echo '<option value="' . $trx_names->trx_name . '">' . $trx_names->trx_name . '</option>';
                                                // }
                                            }
                                            ?>  -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                        class="fa fa-search"></i> <?= lang("search"); ?></button>
                                <button class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i class="fa fa-view"></i><?= lang("print-view"); ?></button>
                                <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>
                            </div>
                            <?php echo form_close(); ?>

                        </div>
                    </div>
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang("date"); ?></th>
                                        <th><?= lang("transaction_no"); ?></th>
                                        <th><?= lang("employee_name"); ?></th>
                                        <th><?= lang("transaction_name"); ?></th>
                                        <th><?= lang("transaction_type"); ?></th>
                                        <th><?= lang("store"); ?></th>
                                        <th><?= lang("amount"); ?></th>
                                        <th><?= lang("account_no"); ?></th>
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
        var employee_name_id = $('#employee_name_id').val();
        var store_id = $('#store_id').val();
        // var transaction_type = $('#transaction_type').val();
        var transaction_type = $('#transaction_type').val();
        var transaction_name = $('#transaction_name').val();
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
                url: '<?php echo base_url(); ?>employee-transaction-report/page_data/' + page_num,
                data: 'page=' + page_num + '&employee_name_id=' + employee_name_id + '&transaction_type=' + transaction_type + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&transaction_name=' + transaction_name,
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

    function getState(val) {
        $.ajax({
            type: "POST",
            url: "get_transaction_name",
            data: 'transaction_type=' + val,
            success: function (data) {
                $("#transaction_name").html(data);
            }
        });
    }
    function searchFilter2(page_num) {
    var employee_name_id = $('#employee_name_id').val();
        var store_id = $('#store_id').val();
        // var transaction_type = $('#transaction_type').val();
        var transaction_type = $('#transaction_type').val();
        var transaction_name = $('#transaction_name').val();
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
                url: '<?php echo base_url(); ?>reports/employee_transaction_report/print_data',
                data: 'employee_name_id=' + employee_name_id + '&transaction_type=' + transaction_type + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&transaction_name=' + transaction_name,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    //console.log(html);
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
            });
        }
    }
    function csv_export() {
      var transaction_no = $('#transaction_no').val();
      var store_id = $('#store_id').val();
      // var customer_id = $('#customer_id').val();
      var customer_id = $('#customer_id').val();
      var invoice_no = $('#invoice_no').val();
      var FromDate = $('#FromDate').val();
      var ToDate = $('#ToDate').val();
          // if(FromDate=='' || ToDate==''){
            if(FromDate==''){
              // alert('df');
              $('#FromDate-error').html("Please fill start Date");
            } else if(ToDate==''){
              $('#ToDate-error').html("Please fill end Date");
            }
            else{
              $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url(); ?>reports/employee_transaction_report/create_csv_data',
                  data: 'employee_name_id=' + employee_name_id + '&transaction_type=' + transaction_type + '&store_id=' + store_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate + '&transaction_name=' + transaction_name,
              beforeSend: function () {
                  $('.loading').show();
              },
              success: function (html) {
                  $('.loading').fadeOut("slow");
                  window.location.href = '<?php echo base_url(); ?>export_csv?request='+(html);
              }
          });
      }
  }

</script> 
