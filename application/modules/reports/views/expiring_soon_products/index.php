<ul class="breadcrumb">
  <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
  ?>
</ul>
<div class="col-md-12" id="all"> 
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div> 
<div class="content-i"> 
    <div class="content-box">
            <div class="element-wrapper">
                <div class="full-box element-box">
                  <div class="row">
                    <!-- Select option -->
                    <div class="col-md-3 col-sm-12">
                        <?php
                          $xid = -1;
                          if(isset($_GET['xid'])){
                            $xid = $_GET['xid'];
                          }
                        ?>
                        <label class="col-form-label" for="">Select Option </label>
                        <select id="selectOption" class="form-control">
                          <option value="-1" <?php if($xid == -1){echo 'selected';}?>><?= lang("select_one"); ?></option>
                          <option value="1" <?php if($xid == 1){echo 'selected';}?>><?= lang("expired_product"); ?></option>
                          <option value="2" <?php if($xid == 2){echo 'selected';}?>><?= lang("expired_7"); ?></option>
                          <option value="3" <?php if($xid == 3){echo 'selected';}?>><?= lang("expired_15"); ?></option>
                          <option value="4" <?php if($xid == 4){echo 'selected';}?>><?= lang("expired_30"); ?></option>
                        </select>
                    </div>
                    <!-- From Date -->
                    <?php 
                        $start_date = '';
                        $end_date = '';
                        if($xid == 1){
                            $start_date = '';
                            $end_date = date('Y-m-d',strtotime("-1 days"));
                        }else if($xid == 2){
                            $start_date = date('Y-m-d');
                            $end_date = date('Y-m-d',strtotime("+6 days"));
                        }else if($xid == 3){
                            $start_date = date('Y-m-d');
                            $end_date = date('Y-m-d',strtotime("+14 days"));
                        }else if($xid == 4){
                            $start_date = date('Y-m-d');
                            $end_date = date('Y-m-d',strtotime("+29 days"));
                        }  
                    ?>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for=""><?= lang('from_date') ?> </label>
                            <div class="col-sm-12">
                               <div class="input-group FromDate">
                                  <input class="form-control valid FromDate" aria-invalid="false" type="text" name="FromDate" id="FromDate" value="<?php echo $start_date;?>">
                                  <span class="input-group-addon"> 
                                    <span class="glyphicon glyphicon-calendar"></span>  
                                  </span>     
                               </div>
                               <span id="FromDate-error" class="error" for="product_name"></span>
                            </div>
                        </div>
                    </div>
                    <!-- To date -->
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for=""><?= lang('to_date') ?> </label>
                            <div class="col-sm-12">
                                  <div class="input-group ToDate">
                                <input class="form-control valid ToDate" aria-invalid="false" type="text" name="ToDate" id="ToDate" value="<?php echo $end_date;?>">
                                <span class="input-group-addon">     
                               <span class="glyphicon glyphicon-calendar"></span>  
                               </span> 
                               </div> 
                                <span id="ToDate-error" class="error" for="product_name"></span>                       
                            </div>
                        </div>
                    </div>
                    <!-- Product search -->
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for=""><?= lang("product_code_name"); ?></label>
                            <div class="col-sm-12">
                                <select class="select2" data-live-search="true" id="product_name"
                                                name="product_name">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($products as $product) {
                                                echo '<option actp="' . $product->product_name . '" value="' . $product->id_product . '">' . $product->product_name . '(' . $product->product_code . ')' . '</option>';
                                            }
                                            ?>
                                        </select>
                                <?php echo form_error('product_name', '<div class="error">', '</div>'); ?>
                                <div id="pSalep"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label"
                                   for=""><?= lang("batch_no"); ?></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="batch_no" id="batch_no">
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <!-- Product cat search -->
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label"><?= lang("product_category"); ?></label>
                            <div class="col-sm-12">

                                <div class="row-fluid">
                                    <select class="select2" data-live-search="true" id="cat_name" name="cat_name">
                                        <option value="0" selected><?= lang("select_one"); ?></option>
                                        <?php
                                        foreach ($categories as $category) {
                                            if (empty($category->parent_cat_id)) {
                                                echo '<option value="' . $category->id_product_category . '">' . $category->cat_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Product sub cat search -->
                    <div class="col-md-3 col-sm-12">
                          <div class="form-group row">
                              <label class="col-sm-12 col-form-label"><?= lang("sub_category"); ?></label>
                              <div class="col-sm-12">
                                  <div class="row-fluid">
                                      <div id="cldSubCat">
                                        <select class="select2" data-live-search="true" id="pro_sub_category" name="pro_sub_category">
                                            <option value="-1"> All Sub Categories</option>
                                            
                                        </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div> 
                    <div class="col-md-3 col-sm-12">
                       <div class="form-group row">
                           <label class="col-sm-12 col-form-label"><?= lang("brands"); ?></label>
                           <div class="col-sm-12">

                               <div class="row-fluid">
                                   <select class="select2" data-live-search="true" id="brand" name="brand">
                                       <option value="0" selected><?= lang("select_one"); ?></option>
                                       <?php
                                         foreach ($brands as $brand) {
                                            echo '<option value="' . $brand->id_product_brand . '">' . $brand->brand_name . '</option>';
                                         }
                                       ?>
                                   </select>
                               </div>
                            </div>
                           </div>
                    </div>
                    <!-- Store name -->
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label"><?= lang("store_name"); ?></label>
                            <div class="col-sm-12">
                                <div class="row-fluid">
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
                    </div>
                    <!-- Brands -->
                    

                    <div class="col-md-12 col-sm-12">
                        <div style="margin-top: 25px;"></div>
                        <button class="btn btn-primary" type="button" onclick="searchSubmit(0)"><i class="fa fa-search"></i> <?= lang("search"); ?></button>
                         <button href="<?php echo base_url(); ?>stock_report/print_page"
                                    class="btn btn-primary pull-right" type="button" onclick="searchFilter2()"><i
                                    class="fa fa-view"></i> <?= lang("print-view"); ?></button>
                        <button class="btn btn-primary pull-right" type="button" onclick="csv_export()">CSV</button>
                    </div>
                  </div>  
                  <div class="row">
                      <?php 
                        // echo '<pre>';
                        // print_r($ex_product);
                        // echo '</pre>';
                      ?>
                      <div class="col-md-12">
                          <div class="table-responsive" id="postList">
                              <table id="mytable" class="table table-bordred table-striped">
                                  <thead>                                 
                                    <th><?= lang("product"); ?></th> 
                                    <th><?= lang("batch_no"); ?></th>
                                    <th><?= lang("cat/subcat"); ?></th>
                                    <th><?= lang("brands"); ?></th>
                                    <th><?= lang("store_name"); ?></th>
                                    <th><?= lang("expire_date"); ?></th>
                                    <th><?= lang("qty"); ?></th>
                                  </thead>
                                  <tbody>
                                    <?php 
                                        if(!empty($ex_product)):
                                        $i=1; 
                                        foreach($ex_product as $xaProduct):
                                    ?>
                                    <tr>
                                        <td><?php echo $xaProduct['product_name'].' ('.$xaProduct['product_code'].')';?></td>
                                        <td><?php echo $xaProduct['batch_no'];?></td>
                                        <td><?php echo $xaProduct['cat_name'].' / '.$xaProduct['sub_cat_name'];?></td>
                                        <td><?php echo $xaProduct['brand_name'];?></td>
                                        <td><?php echo $xaProduct['store_name'];?></td>
                                        <td><?php echo $xaProduct['expire_date'];?></td>
                                        <td><?php echo $xaProduct['qty'];?></td>
                                    </tr> 
                                    <?php $i++;endforeach;else:?>
                                    <tr>
                                      <td colspan="7">Not available</td>
                                    </tr>  
                                    <?php endif;?>
                                  </tbody>

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

<script type="text/javascript">  
  $(document).ready(function(){
      $("#cat_name").change(function(){
          var cid = $(this).val();
          $.ajax({
              type: 'POST',
              data: {cid: cid},
              url: '<?php echo base_url(); ?>reports/expiring_soon_products/get_sub_cat',
              success: function (html) {
                  $('#cldSubCat').html(html);
              }
          });
      });
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

  });

  $('#selectOption').change(function (){
    var xid = $(this).val();
    if(xid == 1){
        $('#FromDate').val('');
        $('#ToDate').val('<?php echo date('Y-m-d',strtotime("-1 days"));?>');
    }else if(xid == 2){
        $('#FromDate').val('<?php echo date('Y-m-d');?>');
        $('#ToDate').val('<?php echo date('Y-m-d',strtotime("+6 days"));?>');
    }else if(xid == 3){
        $('#FromDate').val('<?php echo date('Y-m-d');?>');
        $('#ToDate').val('<?php echo date('Y-m-d',strtotime("+14 days"));?>');
    }else if(xid == 4){
        $('#FromDate').val('<?php echo date('Y-m-d');?>');
        $('#ToDate').val('<?php echo date('Y-m-d',strtotime("+29 days"));?>');
    }else if(xid == -1){
        $('#FromDate').val('');
        $('#ToDate').val('');
    }      
  });
  function jsLinkFunc1(page_num){
    var xid = $('#selectOption').val();
    var startDate = '';
    var endDate = '';
    if(xid == 1){
        endDate = '<?php echo date('Y-m-d',strtotime("-1 days"));?>';
    }else if(xid == 2){
        startDate = '<?php echo date('Y-m-d');?>';
        endDate = '<?php echo date('Y-m-d',strtotime("+6 days"));?>';
    }else if(xid == 3){
        startDate = '<?php echo date('Y-m-d');?>';
        endDate = '<?php echo date('Y-m-d',strtotime("+14 days"));?>';
    }else if(xid == 4){
        startDate = '<?php echo date('Y-m-d');?>';
        endDate = '<?php echo date('Y-m-d',strtotime("+29 days"));?>';
    }

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>expiring-soon-products/page_data/' + page_num,
        data: 'type=link' +'&page=' + page_num + '&start_date=' + startDate + '&end_date=' + endDate,
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

  function searchSubmit(page_num){
      var fromDate = $('#FromDate').val();
      var toDate = $('#ToDate').val();
      var product_id = $('#product_name').val();
      var cat_name = $('#cat_name').val();
      var pro_sub_category = $('#pro_sub_category').val();
      var store_id = $('#store_id').val();
      var brand = $('#brand').val();
      var batch_no = $('#batch_no').val();

      $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>expiring-soon-products/submit_page_data/' + page_num,
          data: 'type=submit' +'&start_date=' + fromDate + '&end_date=' + toDate +  '&product_id=' + product_id + '&cat_name=' + cat_name +'&pro_sub_category=' + pro_sub_category + '&store_id=' + store_id + '&brand=' + brand + '&batch_no=' + batch_no ,
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
  function searchFilter2(page_num) {
      var fromDate = $('#FromDate').val();
      var toDate = $('#ToDate').val();
      var product_id = $('#product_name').val();
      var cat_name = $('#cat_name').val();
      var pro_sub_category = $('#pro_sub_category').val();
      var store_id = $('#store_id').val();
      var brand = $('#brand').val();
      var batch_no = $('#batch_no').val();
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>reports/expiring_soon_products/print_page',
          data: 'type=submit' +'&start_date=' + fromDate + '&end_date=' + toDate +  '&product_id=' + product_id + '&cat_name=' + cat_name +'&pro_sub_category=' + pro_sub_category + '&store_id=' + store_id + '&brand=' + brand+ '&batch_no=' + batch_no ,
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


  function jsLinkFunc2(page_num){
      var fromDate = $('#FromDate').val();
      var toDate = $('#ToDate').val();
      var product_id = $('#product_id').val();
      var cat_name = $('#cat_name').val();
      var pro_sub_category = $('#pro_sub_category').val();
      var store_id = $('#store_id').val();
      var brand = $('#brand').val();

      $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>expiring-soon-products/submit_page_data/' + page_num,
          data: 'type=link' +'&page=' + page_num +'&start_date=' + fromDate + '&end_date=' + toDate +  '&product_id=' + product_id + '&cat_name=' + cat_name +'&pro_sub_category=' + pro_sub_category + '&store_id=' + store_id + '&brand=' + brand ,
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
  function csv_export() {
      var fromDate = $('#FromDate').val();
      var toDate = $('#ToDate').val();
      var product_id = $('#product_name').val();
      var cat_name = $('#cat_name').val();
      var pro_sub_category = $('#pro_sub_category').val();
      var store_id = $('#store_id').val();
      var brand = $('#brand').val();
      var batch_no = $('#batch_no').val();
          $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>reports/expiring_soon_products/create_csv_data',
              data: 'type=link' +'&start_date=' + fromDate + '&end_date=' + toDate +  '&product_id=' + product_id + '&cat_name=' + cat_name +'&pro_sub_category=' + pro_sub_category + '&store_id=' + store_id + '&brand=' + brand + '&batch_no=' + batch_no,
              beforeSend: function () {
                  $('.loading').show();
              },
              success: function (html) {
                  $('.loading').fadeOut("slow");
                  window.location.href = '<?php echo base_url(); ?>export_csv?request='+(html);
              }
          });
  }
</script>

