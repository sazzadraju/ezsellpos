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
            <h3 class="element-header"><?= lang('delivery_orders') ?></h3>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-12">
              <div class="form-group row">
                <label class="col-sm-12 col-form-label" for=""><?= lang('from_date') ?> </label>
                <div class="col-sm-12">
                  <div class="input-group date FromDate" id="DOB">
                    <input class="form-control valid FromDate" aria-invalid="false" type="text"name="FromDate" id="FromDate">
                    <span class="input-group-addon">
                      <!-- <input type="hidden" name="product_id" id="product_id"> -->

                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                  <span id="FromDate-error" class="error" for="product_name"></span>
                </div>
              </div>
            </div>
            <div class="col-md-2 col-sm-12">
              <div class="form-group row">
                <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                <div class="col-sm-12">
                  <div class="input-group date ToDate" id="DOB">
                    <input class="form-control valid ToDate" aria-invalid="false" type="text" name="ToDate" id="ToDate">
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
              <label class="col-sm-12 col-form-label"
              for=""><?= lang("type"); ?></label>
              <div class="col-sm-12">
                <select class="form-control" id="delivery_type" onchange="setAgentStaff(this)"
                name="delivery_type">
                <option value="0" selected><?= lang('select_one') ?></option>
                <option value="1f"><?= lang('staff') ?></option>
                <option value="2"><?= lang('agents') ?></option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-12">
          <div class="form-group row">
            <label class="col-sm-12 col-form-label"
            for=""><?= lang("name"); ?></label>
            <div class="col-sm-12">
              <select class="form-control" id="person_list" name="person_list">
                <option value="0"> <?= lang('select_one')?></option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-12">
          <div class="form-group row">
            <label class="col-sm-12 col-form-label"
            for=""><?= lang("reference_number"); ?></label>
            <div class="col-sm-12">
              <input type="text" class="form-control" name="ref_no" id="ref_no">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 col-sm-12">
          <div class="form-group row">
            <label class="col-sm-12 col-form-label"
            for=""><?= lang("invoice_no"); ?></label>
            <div class="col-sm-12">
              <input type="text" class="form-control" name="invoice_no" id="invoice_no">
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-12">
          <div class="form-group row">
            <label class="col-sm-12 col-form-label"
            for=""><?= lang("customer"); ?></label>
            <div class="col-sm-12">
              <select class="select2" id="customer_id" name="customer_id" data-live-search="true">
                <option value="0"> <?= lang('select_one')?></option>
                <?php 
                if(!empty($customers)){
                  foreach ($customers as $row) {
                    echo '<option value="'.$row['id_customer'].'">'.$row['customer_name'].' ('.$row['phone'].')</option>';
                  }
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-12">
          <div class="form-group row">
            <label class="col-sm-12 col-form-label"
            for=""><?= lang("note"); ?></label>
            <div class="col-sm-12">
              <input type="text" class="form-control" name="note" id="note">
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
      <div class="col-md-2 col-sm-12">
        <div class="form-group row">
          <label class="col-sm-12 col-form-label"
          for=""><?= lang("status"); ?></label>
          <div class="col-sm-12">
            <select name="ser_status" class="form-control" id="ser_status">
              <option value=""><?= lang('select_one')?></option>
              <?php 
              foreach ($this->config->item('order_status') as $key => $value) {
                echo '<option value="'.$key.'">'.$value.'</option>';
              }
              ?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="col-sm-4 pull-right">
        <div class="form-group row">
          <label class="col-sm-12 col-form-label"
          for="">&nbsp;</label>
          <div class="col-sm-12">
            <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
              class="fa fa-search"></i> <?= lang("search"); ?></button>
              <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>
            </div>
          </div>
        </div>
      </div>
      <!-- body view from here -->
      <div class="element-box full-box">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive" id="postList">
              <table id="mytable" class="table table-bordred table-striped">
                <thead>
                 <th><?= lang("date"); ?></th>
                 <th><?= lang("invoice_no"); ?></th>
                 <th><?= lang("delivery_type"); ?></th>
                 <th><?= lang("agent_name"); ?></th>
                 <th><?= lang("reference_number"); ?></th>
                 <th><?= lang("customer_name"); ?></th>
                 <th><?= lang("customer_phone"); ?></th>
                 <th class="center"><?= lang("service_price"); ?></th>
                 <th class="center"><?= lang("paid_amount"); ?></th>
                 <th class="center"><?= lang("status"); ?></th>
                 <th class="center" colspan="3"><?= lang("action"); ?></th>
               </thead>


             </table>

             <div class="clearfix"></div>

           </div>

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
    var delivery_type = $('#delivery_type option:selected').val();
    var person_list = $('#person_list option:selected').val();
    var customer_id = $('#customer_id option:selected').val();
    var sales_person = $('#sales_person option:selected').val();
    var note = $('#note').val();
    var invoice_no = $('#invoice_no').val();
    var FromDate = $('#FromDate').val();
    var ToDate = $('#ToDate').val();
    var ref_no = $('#ref_no').val();
    var status = $('#ser_status').val();
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
        url: '<?php echo base_url(); ?>delivery-report/page-data/' + page_num,
        data: 'page=' + page_num + '&delivery_type=' + delivery_type + '&person_list=' + person_list + '&FromDate=' + FromDate + '&ToDate=' + ToDate+ '&ref_no=' + ref_no+ '&status=' + status+'&customer_id=' + customer_id+ '&invoice_no=' + invoice_no+'&note='+note+'&sales_person='+sales_person,
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
  
  function setAgentStaff(evl) {
    //alert(evl.value);
    var final=evl.value;
    if(final==0){
      $('#order_sort_data').html('');
    } else{
      $.ajax({
        type: "POST",
        url: URL+'delivery/delivery-orders/show_agent_staff_list',
        data: {id:final},
        async: false,
        beforeSend: function () {
          $('.loading').show();
        },
        success: function (data) {
                //alert(data);
                $('#person_list').html(data);
                $('.loading').fadeOut("slow");
              }
            });
    }

  }
  function csv_export() {
    var delivery_type = $('#delivery_type option:selected').val();
    var person_list = $('#person_list option:selected').val();
    var customer_id = $('#customer_id option:selected').val();
    var sales_person = $('#sales_person option:selected').val();
    var note = $('#note').val();
    var invoice_no = $('#invoice_no').val();
    var FromDate = $('#FromDate').val();
    var ToDate = $('#ToDate').val();
    var ref_no = $('#ref_no').val();
    var status = $('#ser_status').val();
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
        url: '<?php echo base_url(); ?>reports/delivery-report/create_csv_data',
        data: 'delivery_type=' + delivery_type + '&person_list=' + person_list + '&FromDate=' + FromDate + '&ToDate=' + ToDate+ '&ref_no=' + ref_no+ '&status=' + status+'&customer_id=' + customer_id+ '&invoice_no=' + invoice_no+'&note='+note+'&sales_person='+sales_person,
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
