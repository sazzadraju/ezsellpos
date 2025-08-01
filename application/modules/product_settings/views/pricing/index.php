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
            <div class="element-box full-box">
                    <h6 class="element-header" id="layout_title"><?= lang("product_pricing"); ?></h6>
                    <form id="pricingForm">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang("store"); ?></label>
                                <div class="col-sm-12">
                                    <div class="row-fluid">

                                        <?php 
                                            $str_cnt = count($store_info);
                                            if($str_cnt != 1):
                                        ?>
                                        <select class="select2" data-live-search="true" id="store" name="store">
                                            <option value="0" selected><?= lang("allstore"); ?></option>
                                            <?php 
                                                if(!empty($store_info)):
                                                foreach($store_info as $aStore):
                                            ?>
                                            <option value="<?php echo $aStore[0]['id_store'];?>"><?php echo $aStore[0]['store_name'];?></option>                  
                                            <?php 
                                                endforeach; 
                                                endif;
                                                else:
                                            ?>
                                            <input class="form-control" type="hidden" name="store" id="store" value="<?php echo $store_info[0][0]['id_store'];?>">
                                            <input class="form-control" type="text" value="<?php echo $store_info[0][0]['store_name'];?>" readonly>
                                            <?php     
                                                endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"
                                       for=""><?= lang("product_code_name"); ?></label>
                                <div class="col-sm-12">
                                    <select class="select2" data-live-search="true" id="product_name_code" name="product_name_code">
                                            <option value="0" selected><?= lang("all_product"); ?></option>
                                            <?php 
                                                if(!empty($products)):
                                                foreach($products as $product):
                                            ?>
                                            <option value="<?php echo $product->id_product;?>"><?php echo $product->product_name;?> ( <?php echo $product->product_code;?> ) </option>                  
                                            <?php 
                                                endforeach; 
                                                endif;
                                            ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang("product_category"); ?></label>
                                <div class="col-sm-12">
                                    <div class="row-fluid">
                                        <select class="select2" data-live-search="true" id="cat_name"
                                                name="cat_name">
                                            <option value="0" selected><?= lang("all_product_category"); ?></option>
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
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang("product_sub_category"); ?></label>
                                <div class="col-sm-12">

                                    <div class="row-fluid">
                                        <div id="cldSubCat">
                                            <select class="select2" data-live-search="true" id="pro_sub_category" name="pro_sub_category">
                                                <option value="-1"> <?= lang("all_sub_category"); ?></option>
                                                
                                            </select>
                                          </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang("brand"); ?></label>
                                <div class="col-sm-12">
                                    <div class="row-fluid">
                                        <select class="select2" data-live-search="true" id="brand" name="brand">
                                           <option value="0" selected><?= lang("all_brand"); ?></option>
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
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><?= lang("supplier"); ?></label>
                                <div class="col-sm-12">

                                    <div class="row-fluid">
                                        <select class="select2" data-live-search="true" id="supplier" name="supplier">
                                            <option value="0" selected><?= lang("all_supplier"); ?></option>
                                            <?php
                                             foreach ($suppliers as $supplier) {
                                                echo '<option value="' . $supplier->id_supplier . '">' . $supplier->supplier_name.' ( '.$supplier->phone.' ) ' . '</option>';
                                             }
                                           ?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <button style="margin-top: 25px;" class="btn btn-primary" type="button" onclick="searchFilter(0)"><i class="fa fa-search"></i> <?= lang("search"); ?></button>

                        </div>
                    </form>    
                </div>
                <div class="col-md-12">
                    <div class="table-responsive"> 
                        <div id="postList">   
                            
                        </div>      
                    </div>
                </div>
            </div>    
        </div>

    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("delect_this_entry"); ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?= lang("confirm_delete"); ?></div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success" id="softDelete" value=""><span class="glyphicon glyphicon-ok-sign"></span> <?= lang("yes"); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang("no"); ?></button>
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

    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;

        var store = $('#store').val();
        var product_name = $('#product_name_code').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        var brand = $('#brand').val();
        var supplier = $('#supplier').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>products/pricingPaginationData',
            data: 'page=' + page_num + '&store=' + store + '&product_name=' + product_name + '&cat_name=' + cat_name + '&pro_sub_category=' + pro_sub_category + '&brand=' + brand + '&supplier=' + supplier,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {

                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
</script>
