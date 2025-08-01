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
              <div class="col-md-2 col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                  <div class="col-sm-12">
                    <div class="input-group date" id="DOB">
                      <input class="form-control valid" aria-invalid="false" type="text" name="ToDate" id="ToDate"  onkeyup="product_list_suggest(this);">
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
                  <label class="col-sm-12 col-form-label" for=""><?= lang("transaction_no"); ?></label>
                  <div class="col-sm-12">
                    <input class="form-control" id="transaction_no" name="transaction_no" placeholder="<?= lang("transaction_no"); ?>" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-2 col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-12 col-form-label"><?= lang("customer_name"); ?></label>
                  <div class="col-sm-12">
                    <select class="select2" data-live-search="true" id="customer_id" name="customer_id">
                      <option value="0" selected><?= lang("select_one"); ?></option>
                      <?php
                      foreach ($customers as $customer) {
                        echo '<option value="' . $customer->id_customer . '">' . $customer->full_name . '</option>';
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
                        echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-2 col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-12 col-form-label"><?= lang("invoice_no"); ?></label>
                  <div class="col-sm-12">
                      <input class="form-control" id="invoice_no" name="invoice_no"
                             placeholder="<?= lang("invoice_no"); ?>" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-4">
                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i class="fa fa-search"></i> <?= lang("search"); ?></button>
                <button class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i class="fa fa-view"></i><?= lang("print-view"); ?></button>
                <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>
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
                      <th><?= lang("date"); ?></th>
                      <th><?= lang("transaction_no"); ?></th> 
                      <th><?= lang("customer_name"); ?></th> 
                      <th><?= lang("store"); ?></th> 
                      <th><?= lang("trans_account"); ?></th> 
                      <th><?= lang("invoice"); ?></th> 
                      <th><?= lang("amount"); ?></th>
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
<div id="view" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="element-header margin-0"><?= lang("payments_details"); ?> <span class="close" data-dismiss="modal">&times;</span></h6>
      </div>
      <div class="modal-body" id="prints">
        <div class="data-view">
          <div class="col-md-6">
            <table id="mytable" class="table table-bordred table-striped">
              <thead>
                <th><?= lang("transaction_no"); ?></th> 
                <th><?= lang("invoice_number"); ?></th>
                <th><?= lang("amount"); ?></th>


              </thead>
              <tbody class='tttt'>


              </tbody>
            </table>   
          </div>
          <div class="col-md-6">
            <table id="mytable" class="table table-bordred table-striped">
              <thead>
                <th><?= lang("payment-method"); ?></th>
                <th><?= lang("acc_number"); ?></th>
                <th><?= lang("amount"); ?></th>


              </thead>
              <tbody class='pppp'>


              </tbody>
            </table>   
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" onclick="sale_print()">Print</button>
          <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
        </div>
      </div>
    </div>
  </div>
</div>
   
 <page size="A4" id="print11" style="display:none;">
  <div class="report-box">
<?php  
         $company= $this->session->userdata['login_info']['store_id'];
         // $address= $this->session->userdata['login_info']['subscription_info'] ['address'];
         // $mobile= $this->session->userdata['login_info']['mobile'];
         $query=$this->commonmodel->store_details($company);
         $printed_by= $this->session->userdata['login_info']['fullname']; 
         // print_r($company);
?>
    <div class="report-header">
                <div class="report-info">
                    <!-- $this->commonmodel->dfgd() -->
                    <?php $store_name = '';
                    $mobile='';
                    $store_address='';
                    // $sql ="select s.*,a.area_name_en,c.city_name_en FROM stores s JOIN loc_areas a ON a.id_area = s.area_id JOIN loc_cities c ON c.id_city = s.city_id WHERE s.id_store = '$company'";
                    // $query = $this->db->query($sql);
                    
                    foreach ($query as $stores) {
                        // print_r($query);
                        // echo "<pre>";
                         $store_name =$stores->store_name;
                         $mobile=$stores->mobile ;
                        // print_r($stores);
                    if (!empty($stores->city_id)) {
                        $store_area = $stores->area_name_en;
                        $store_city = $stores->city_name_en;
                    }
                    else{
                        $store_area=$stores->district_name_en;
                        $store_city=$stores->division_name_en;
                    }
                } ?>
                    <h2><?php echo $store_name;?><br></h2>
                    <p>Mobile:<?php echo $mobile;?></p>
                    <address>
                            <?php echo $store_area .",".$store_city ;?>
                  </address>
                </div>
      <div class="report-info2">
        <p>Date:<?php echo date('d-m-Y'); ?></p>
      </div>
    </div>
    <div class="print-col-md-6">
      <span>Invoice Details</span>
      <table id="mytable" class="table table-bordred table-striped">
        <thead>
          <th><?= lang("transaction_no"); ?></th> 
          <th><?= lang("invoice_number"); ?></th>
          <th><?= lang("amount"); ?></th>


        </thead>
        <tbody class='tttt'>


        </tbody>
      </table>   
    </div>
    <div class="print-col-md-6">
      <span style="padding-left:25px; ">Payments Details</span>
      <table id="mytable" class="table table-bordred table-striped">
        <thead>
          <th><?= lang("payment-method"); ?></th> 
          <th><?= lang("acc_number"); ?></th>
          <th><?= lang("amount"); ?></th>


        </thead>
        <tbody class='pppp'>


        </tbody>
      </table>   
    </div>
  </div>
</page>
<!-- </body>

</html>
 -->
<script>                                      
  function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
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
              url: '<?php echo base_url(); ?>customer-transaction-report/page_data/' + page_num,
              data: 'page=' + page_num + '&transaction_no=' + transaction_no +'&customer_id=' + customer_id + '&store_id=' + store_id +  '&FromDate=' + FromDate + '&ToDate=' + ToDate +'&invoice_no=' + invoice_no ,
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

  function searchFilter2(page_num) {
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
                url: '<?php echo base_url(); ?>reports/customer_transaction_report/print_data',
                data: 'transaction_no=' + transaction_no +'&customer_id=' + customer_id + '&store_id=' + store_id +  '&FromDate=' + FromDate + '&ToDate=' + ToDate +'&invoice_no=' + invoice_no,
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
                  url: '<?php echo base_url(); ?>reports/customer_transaction_report/create_csv_data',
                  data: 'transaction_no=' + transaction_no +'&customer_id=' + customer_id + '&store_id=' + store_id +  '&FromDate=' + FromDate + '&ToDate=' + ToDate +'&invoice_no=' + invoice_no,
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
<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<script type="text/javascript">
        function sale_print() {
        $('#print11').css('display', 'block');
        $("#print11").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/report_print.css",
            iframe: false,
            noPrintSelector: ".avoid-this",
            // append : "Free jQuery Plugins!!!<br/>",
            // prepend : "<br/>jQueryScript.net!"
        });
        //$.print("#sale_view");
         $('#print11').css('display', 'none');
        // $('#view').modal('hide');  
        }        
</script>
