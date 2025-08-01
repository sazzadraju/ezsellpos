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
                                    <label class="col-sm-12 col-form-label"><?= lang("from_store"); ?></label>
                                    <div class="col-sm-12">
                                        <!-- <div class="row-fluid"> -->
                                        <select class="select2" data-live-search="true" id="from_store" onchange="getFromAccounts(this.value);" name="from_store"
                                                onchange="getStation(this.value);">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($stores as $store) {
                                                echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="col-form-label" for=""><?= lang("account_from"); ?></label>
                                <div class="row-fluid">
                                    <select class="select2" data-live-search="true" id="acc_frm" name="acc_frm">
                                        <option actp="0" value="0"><?= lang('select_one') ?></option>
                                        <?php
                                        $i=1;
                                        $group='';
                                        if ($accounts_from) :
                                            foreach ($accounts_from as $account) :
                                                if($group != $account['store_name']){
                                                    if($i == 1){
                                                        echo '<optgroup label="'.$account['store_name'].'">';
                                                    }else{
                                                      echo '</optgroup>'; 
                                                      echo '<optgroup label="'.$account['store_name'].'">'; 
                                                  }
                                                  $group=$account['store_name'];
                                              }
                                              ?>
                                              <option actp="<?php echo $account['acc_type']; ?>" value="<?php echo $account['acc_id']; ?>">
                                                <?php echo!empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name']; ?>
                                                </option><?php
                                                $i++;
                                            endforeach;
                                        endif;
                                        echo '</optgroup>';
                                        ?>
                                    </select>
                                    <label id="acc_frm-error" class="error" for="acc_frm"></label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><?= lang("to_store"); ?></label>
                                    <div class="col-sm-12">
                                        <!-- <div class="row-fluid"> -->
                                        <select class="select2" data-live-search="true" id="to_store" onchange="getToAccounts(this.value);" name="to_store"
                                                onchange="getStation(this.value);">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($stores as $store) {
                                                echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="col-form-label" for=""><?= lang("acccount_to"); ?></label>
                                <div class="row-fluid">
                                    <select class="select2" data-live-search="true" id="acc_to" name="acc_to">
                                        <option actp="0" value="0"><?= lang('select_one') ?></option>
                                        <?php
                                        $i=1;
                                        $group='';
                                        if ($accounts_from) :
                                            foreach ($accounts_from as $account) :
                                                if($group != $account['store_name']){
                                                    if($i == 1){
                                                        echo '<optgroup label="'.$account['store_name'].'">';
                                                    }else{
                                                      echo '</optgroup>'; 
                                                      echo '<optgroup label="'.$account['store_name'].'">'; 
                                                  }
                                                  $group=$account['store_name'];
                                              }
                                              ?>
                                              <option actp="<?php echo $account['acc_type']; ?>" value="<?php echo $account['acc_id']; ?>">
                                                <?php echo!empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name']; ?>
                                                </option><?php
                                                $i++;
                                            endforeach;
                                        endif;
                                        echo '</optgroup>';
                                        ?>
                                    </select>
                                    <label id="acc_frm-error" class="error" for="acc_frm"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('from_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group FromDate" id="DOB">
                                            <input class="form-control valid FromDate" aria-invalid="false" type="text"
                                                   name="FromDate" id="FromDate" onkeyup="product_list_suggest(this);">
                                        <span class="input-group-addon"> 
                                        <!-- <input type="hidden" name="product_id" id="product_id"> -->
                                        <span class="glyphicon glyphicon-calendar"></span>  
                                       </span>
                                        </div>
                                        <span id="FromDate-error" class="error" for="product_name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                                    <div class="col-sm-12">
                                        <div class="input-group ToDate" id="DOB">
                                            <input class="form-control valid ToDate" aria-invalid="false" type="text"
                                                   name="ToDate" id="ToDate" onkeyup="product_list_suggest(this);">
                                        <span class="input-group-addon">  
                                       <span class="glyphicon glyphicon-calendar"></span>  
                                       </span>
                                        </div>
                                        <span id="ToDate-error" class="error" for="product_name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("user"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="user_id"
                                                    name="user_id">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                if(!empty($users)){
                                                    foreach ($users as $user) {
                                                        echo '<option value="' . $user->id_user . '">' . $user->fullname . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                    class="fa fa-search"></i> <?= lang("search"); ?></button>
                             <button class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i class="fa fa-view"></i> <?= lang("print-view"); ?></button>
                            <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>


                    <!-- body view from here -->
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
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
    function getFromAccounts(val) {
      $.ajax({
        type: "POST",
        url: "<?= base_url()?>reports/fund_transfer/get_account_name",
        data:'store_id='+val,
        success: function(data){
          $("#acc_frm").html(data);
        }
      }); 
    }
    function getToAccounts(val) {
      $.ajax({
        type: "POST",
        url: "<?= base_url()?>reports/fund_transfer/get_account_name",
        data:'store_id='+val,
        success: function(data){
          $("#acc_to").html(data);
        }
      }); 
    }

    function change_type(el){
        var id=el.value;
        if(id=='summary'){
            $('#show_product_list').show();
        }else{
            $('#show_product_list').hide();
        }
    }


    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        //var type = $('[name^="type"]:checked').val();
        var from_store = $('#from_store option:selected').val();
        var to_store = $('#to_store option:selected').val();
        var acc_frm = $('#acc_frm option:selected').val();
        var acc_to = $('#acc_to option:selected').val();
        var user_id = $('#user_id option:selected').val();
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
                url: '<?php echo base_url(); ?>fund_transfer_report/page_data/' + page_num,
                data: 'page=' + page_num + '&from_store=' + from_store + '&to_store=' + to_store + '&acc_frm=' + acc_frm + '&acc_to=' + acc_to + '&user_id=' + user_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate ,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    //console.log(html);
                    //alert(html);
                    $('#postList').html(html);
                    $('.loading').fadeOut("slow");
                }
            });
        }
    }

    $(function () {
        $('.FromDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });
    $(function () {
        $('.ToDate').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });
    // function print_page() {

    //     $this->load->view('products/stock-in-report');
    // }
    function searchFilter2(page_num) {
  var from_store = $('#from_store option:selected').val();
        var to_store = $('#to_store option:selected').val();
        var acc_frm = $('#acc_frm option:selected').val();
        var acc_to = $('#acc_to option:selected').val();
        var user_id = $('#user_id option:selected').val();
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
            url: '<?php echo base_url(); ?>reports/fund_transfer/print_data',
            data: 'from_store=' + from_store + '&to_store=' + to_store + '&acc_frm=' + acc_frm + '&acc_to=' + acc_to + '&user_id=' + user_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                console.log(html);
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
}
    function csv_export() {
        //var type = $('[name^="type"]:checked').val();
        var from_store = $('#from_store option:selected').val();
        var to_store = $('#to_store option:selected').val();
        var acc_frm = $('#acc_frm option:selected').val();
        var acc_to = $('#acc_to option:selected').val();
        var user_id = $('#user_id option:selected').val();
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
                url: '<?php echo base_url(); ?>reports/fund_transfer/create_csv_data',
                data: 'from_store=' + from_store + '&to_store=' + to_store + '&acc_frm=' + acc_frm + '&acc_to=' + acc_to + '&user_id=' + user_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate ,
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
    function getStation(val) {
        // alert(val);
        $.ajax({
            type: "POST",
            url: "get_station_name",
            data: 'store_id=' + val,
            success: function (data) {
                $("#station_id").html(data);
            }
        });
    }


</script> 
