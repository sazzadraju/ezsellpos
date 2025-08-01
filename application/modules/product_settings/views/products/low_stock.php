<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>


<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="full-box element-box">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Search Type</label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="type" name="type">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <option value="1"><?= lang("min_stock"); ?></option>
                                                <option value="2"><?= lang("max_stock"); ?></option>
                                            </select>
                                            <span class="error" id="type-error"></span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"
                                           for=""><?= lang("product_code_name"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="product_name" name="product_name"
                                               placeholder="<?= lang("product_code_name"); ?>" type="text">
                                    </div>
                                </div>
                            </div>
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
                                                    <option value="-1"> <?= lang("all_sub_cat"); ?></option>
                                                    
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                            </div> 
                          </div>
                          <div class="row">
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
                            <div class="col-md-3 col-sm-12">
                                <label class="col-sm-12 col-form-label">&nbsp;</label>
                                <div class="col-sm-12">
                                <button class="btn btn-primary" type="button" onclick="searchFilter(0)"><i
                                        class="fa fa-search"></i> <?= lang("search"); ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="post-list" id="postList">
                                <?php
                                $this->load->view('products/lowStockPagination');
                                ?>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="stock_qty_details" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("product_batch_details"); ?></h4>
            </div>
            <div class="modal-body">
                <table id="mytable" class="table table-bordred table-striped">
                    <thead>
                    <th><?= lang("batch_no"); ?></th>
                    <th><?= lang("store_name"); ?></th>
                    <th><?= lang("buying_price"); ?></th>
                    <th><?= lang("selling_price"); ?></th>
                    <th><?= lang("quantity"); ?></th>
                    <th><?= lang("expire_date"); ?></th>
                    </thead>
                    <tbody id="stock_dts_data">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span><?= lang("close"); ?> </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>

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
    });  

    function searchFilter(page_num){
        $('#type-error').html('');
        var product_name = $('#product_name').val();
        var type = $('#type option:selected').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var store_id = $('#store_id').val();
        var brand = $('#brand').val();
        if (type == 0) {
         $('#type-error').html("Please Select Any One");
        }else{
            $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>products/lowStockPagi2/' + page_num,
              data: 'type=submit' + '&product_name=' + product_name + '&page=' + page_num + '&cat_name=' + cat_name +'&pro_sub_category=' + pro_sub_category + '&store_id=' + store_id + '&brand=' + brand+ '&type=' + type ,
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
    function jsLinkFunc(page_num){
      var product_name = $('#product_name').val();
      var type = $('#type option:selected').val();
      var cat_name = $('#cat_name').val();
      var pro_sub_category = $('#pro_sub_category').val();
      var store_id = $('#store_id').val();
      var brand = $('#brand').val();

      $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>products/lowStockPagi2/' + page_num,
          data: 'type=link' + '&product_name=' + product_name + '&page=' + page_num + '&cat_name=' + cat_name +'&pro_sub_category=' + pro_sub_category + '&store_id=' + store_id + '&brand=' + brand+ '&type=' + type ,
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

     function batchDetail(id,store_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>product_settings/products/get_low_stock_qty_details',
            data: 'id=' + id+"&store_id="+store_id,
            success: function (result) {
                var html = '';
                $("#stock_dts_data").html(result);
                $('#stock_qty_details').modal('toggle');
                //$('#postList').html(html);

            }
        });
    }
</script>
