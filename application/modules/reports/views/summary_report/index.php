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
           <div class="col-md-3">
            <div class="form-group row">
              <label class="col-sm-12 col-form-label" for=""><?= lang('from_date') ?> </label>
              <div class="col-sm-12">
                <div class="input-group FromDate" id="DOB">
                  <input class="form-control valid FromDate" aria-invalid="false" type="text" name="FromDate" id="FromDate">
                  <span class="input-group-addon"> 
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
                  <input class="form-control valid ToDate" aria-invalid="false" type="text" name="ToDate" id="ToDate" >
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
             <label class="col-sm-12 col-form-label"><?= lang("store"); ?></label>
             <div class="col-sm-12">
                 <select class="form-control" data-live-search="true" id="store_id" name="store_id">
                   <option value="0" selected><?= lang("select_one"); ?></option>
                   <?php
                   foreach ($stores as $store) {
                     echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                   }
                   ?>
                 </select>
                 <span id="store_id-error" class="error"></span>
               </div>
             </div>
           </div>
       </div>
       <div class="row">
        <div class="col-md-12 col-sm-4">
          <button class="btn btn-primary" type="button" onclick="searchFilter()"><i class="fa fa-search"></i> <?= lang("search"); ?></button>
          <!-- <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button> -->
          <button class="btn btn-primary pull-right" type="button" onclick="searchFilter2()" style="margin-right:5px;"><i
          class="fa fa-view" ></i> <?= lang("print-view"); ?></button>
        </div>
        <?php echo form_close(); ?>
      </div>


      <!-- body view from here -->
      <div class="element-box full-box">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive" id="postList">
              <table id="mytable" class="table table-bordred table-striped">
                <thead>
                 <th><?= lang("invoice_no"); ?></th>
                 <th><?= lang("sold_date"); ?></th>
                 <th><?= lang("invoice_amount"); ?></th>
                 <th><?= lang("sold_by"); ?></th>
                 <th><?= lang("customer_name"); ?></th>
                 <th><?= lang("type"); ?></th>
                 <th><?= lang("station_name"); ?></th>
                 <th><?= lang("store_name"); ?></th>
                 <th class="center"><?= lang("view"); ?></th>
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
    var store_id = $('#store_id option:selected').val();
    var FromDate = $('#FromDate').val();
    var ToDate = $('#ToDate').val();
    $err_count = 1;
    var startDate = new Date(FromDate);
    var endDateMoment = moment(startDate);
    endDateMoment.add(1, 'months');
    var dateRange=Date('Y-m-d',endDateMoment);
    var ToDateNew= new Date(ToDate); //dd-mm-YYYY
    $('#FromDate-error').html("");
    $('#ToDate-error').html("");
    $('#store_id-error').html("");
    if (FromDate == '') {
      $err_count=2;
      $('#FromDate-error').html("Please fill start Date");
    }
    if(ToDateNew>endDateMoment){
      $('#ToDate-error').html("Maximum one month use after from date");
      $err_count=2;
    }
   if (ToDate == '') {
     $err_count=2;
     $('#ToDate-error').html("Please fill end Date");
   }
   if (store_id == '0') {
     $err_count=2;
     $('#store_id-error').html("Please select any one");
   }

   if ($err_count == 1)  {
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>summary-report/page-data/' + page_num,
      data: 'page=' + page_num + '&store_id=' + store_id +  '&FromDate=' + FromDate + '&ToDate=' + ToDate,
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
function searchFilter2(page_num) {
  var store_id = $('#store_id option:selected').val();
    var FromDate = $('#FromDate').val();
    var ToDate = $('#ToDate').val();
    $err_count = 1;
    var startDate = new Date(FromDate);
    var endDateMoment = moment(startDate);
    endDateMoment.add(1, 'months');
    var dateRange=Date('Y-m-d',endDateMoment);
    var ToDateNew= new Date(ToDate); //dd-mm-YYYY
    $('#FromDate-error').html("");
    $('#ToDate-error').html("");
    $('#store_id-error').html("");
    if (FromDate == '') {
      $err_count=2;
      $('#FromDate-error').html("Please fill start Date");
    }
    if(ToDateNew>endDateMoment){
      $('#ToDate-error').html("Maximum one month use after from date");
      $err_count=2;
    }
   if (ToDate == '') {
     $err_count=2;
     $('#ToDate-error').html("Please fill end Date");
   }
   if (store_id == '0') {
     $err_count=2;
     $('#store_id-error').html("Please select any one");
   }

   if ($err_count == 1)  {
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>summary-report/print-page',
          data: 'page=' + page_num + '&store_id=' + store_id +  '&FromDate=' + FromDate + '&ToDate=' + ToDate,
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


  function csv_export() {
      var invoice_no = $('#invoice_no').val();
      var station_id = $('#station_id').val();
      var store_id = $('#store_id').val();
      var customer_id = $('#customer_id').val();
      var type = $('#customer_type').val();
      var cat_name = $('#cat_name').val();
      var pro_sub_category = $('#pro_sub_category').val();
      var brand = $('#brand').val();
      var uid_add = $('#uid_add').val();
      var FromDate = $('#FromDate').val();
      var ToDate = $('#ToDate').val();
      var sales_person = $('#sales_person option:selected').val();
      var sold_by = $('#sold_by option:selected').val();
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
              url: '<?php echo base_url(); ?>reports/sell_report/create_csv_data',
              data: 'invoice_no=' + invoice_no + '&station_id=' + station_id + '&store_id=' + store_id + '&customer_id=' + customer_id + '&uid_add=' + uid_add + '&FromDate=' + FromDate + '&ToDate=' + ToDate +'&cat_name=' + cat_name +'&pro_sub_category=' + pro_sub_category + '&brand=' + brand+'&type='+type+'&sales_person='+sales_person+'&sold_by='+sold_by,
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
