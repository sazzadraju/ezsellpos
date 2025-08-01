<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("product_code"); ?></th>
    <th><?= lang("product_name"); ?></th>
    <th><?= lang("category"); ?></th>
    <th><?= lang("sub_category"); ?></th>
    <th><?= lang("brand"); ?></th>
    <th class="text-right"><?= lang("stock"); ?></th>
    <th class="text-right"><?= lang("price"); ?>(<?=set_currency()?>)</th>
    <th class="center"><?= lang("action"); ?></th>
    </thead>
    <tbody>
    <?php
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                $val='';
                echo '<td>' . $post['product_code'] . '</td>';
                echo '<td>' . $post['product_name'] . '</td>';
                foreach ($categories as $category) {
                    if ($category->id_product_category == $post['cat_id']) {
                        $val = $category->cat_name;
                        break;
                    }
                }
                echo '<td>' . $val . '</td>';
                $val = '';
                if (!empty($post['subcat_id'])) {
                    foreach ($categories as $category) {
                        if ($category->id_product_category == $post['subcat_id']) {
                            $val = $category->cat_name;
                            break;
                        }
                    }
                }
                echo '<td>' . $val . '</td>';
                $brand_c='';
                foreach ($brands as $brand) {
                    if ($brand->id_product_brand == $post['brand_id']) {
                        $brand_c = $brand->brand_name;
                        break;
                    }
                }
                echo '<td>' . $brand_c . '</td>';
                $stock_t='';
                if(!empty($stocks)){
                    foreach ($stocks as $stock) {
                        if ($post['id_product'] == $stock['product_id']) {
                            $stock_t = $stock['stock_qty'];
                            break;
                        }
                    }
                }
                $btn=($stock_t!='')?'<a class="custom-a" onclick="stock_qty_details('.$post['id_product'].')">' . $stock_t . '</a>':'0';
                echo '<td class="text-right" id="ch_stock_'.$post['id_product'].'" >'.$btn.'</td>';
                echo '<td class="text-right">' . $post['sell_price'] . '</td>';
                ?>
                <td class="center">
                    <button class="btn btn-success btn-xs" data-title="<?= lang("view"); ?>" data-toggle="modal" rel="tooltip" title="<?= lang("view") ?>"
                            data-target="#view" onclick="viewProductDetaitls('<?php echo $post['id_product']; ?>')">
                        <span class="glyphicon glyphicon-eye-open"></span></button>

                    <button class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" data-toggle="modal" rel="tooltip" title="<?= lang("edit") ?>"
                            data-target="#add" onclick="editProducts('<?php echo $post['id_product']; ?>')"><span
                            class="glyphicon glyphicon-pencil"></span></button>
                    <button class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal" rel="tooltip" title="<?= lang("delete") ?>"
                            data-target="#deleteProduct" onclick="deleteProductModal('<?= $post['id_product'] ?>');">
                        <span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>
            <?php
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
<div class="modal fade" id="stock_qty_details" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("product_batch_details"); ?></h4>
            </div>
            <div class="modal-body">
                <table id="mytable" class="table table-bordred table-striped">
                    <thead>
                    <th><?= lang("stock_date"); ?></th>
                    <th><?= lang("batch_no"); ?></th>
                    <th><?= lang("store_name"); ?></th>
					<th><?= lang("attributes"); ?></th>
                    <?php 
                    $type= $this->session->userdata['login_info']['user_type_i92']; 
                     if($columns[0]->permission==1||$type==3){
                        echo '<th class="center">'.lang("buying_price").'('.set_currency().')</th>';
                     }
                    ?>
                    
                    <th class="center"><?= lang("selling_price"); ?>(<?=set_currency()?>)</th>
                    <th class="center"><?= lang("quantity"); ?></th>
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
<script>
    function stock_qty_details(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>product_settings/products/get_stock_qty_details',
            data: 'id=' + id,
            success: function (result) {
                var html = '';
                $("#stock_dts_data").html(result);
                $('#stock_qty_details').modal('toggle');
                //$('#postList').html(html);

            }
        });
    }
</script>
