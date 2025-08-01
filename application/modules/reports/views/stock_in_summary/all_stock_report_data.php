<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/bootstrap.min.css">
<table id="mytable" class="table table-bordered" cellpadding="0" cellspacing="0">
    <thead>
    <th><?= lang("serial"); ?></th>
    <th><?= lang("date"); ?></th>
    <th><?= lang("store"); ?></th>
    <th><?= lang("product"); ?></th>
    <th><?= lang("cat/subcat"); ?></th>
    <th><?= lang("supplier"); ?></th>
    <th><?= lang("reason"); ?></th>
    <?php 
    $type= $this->session->userdata['login_info']['user_type_i92']; 
    if($columns[0]->permission==1||$type==3){
        echo '<th class="text-right">'. lang("purchase_price").'</th>';
    }
    ?>
    <th class="text-right"><?= lang('sale_price') ?></th>
    <th class="text-right"><?= lang("quantity"); ?></th>
    <?php 
    if($columns[0]->permission==1||$type==3){
        echo '<th class="text-right">'. lang("purchase_total").'</th>';
    }
    ?>
    <th class="text-right"><?= lang("sale_total"); ?></th>
    </thead>
    <tbody>
    <?php
    $qty = 0;
    $purchase_total=0;
    $sale_total=0;
    $sum_purchase=0;
    $sum_sale=0;
    if (!empty($posts) || !empty($postsPurchases)) {
        $count = 1;
        if (!empty($posts)) {
            foreach ($posts as $post):
                // echo "<pre>";
                // print_r($posts);

                ?>
                <tr>
                    <?php
                    $date = date('Y-m-d', strtotime($post['date']));
                    echo '<td>' . $count . '</td>';
                    echo '<td>' . $date . '</td>';
                    echo '<td>' . $post['store_name'] . '</td>';
                    echo '<td>' .  $post['batch_no'].' ' .$post['product_name'].' ('.$post['product_code'].')' . '</td>';
                    foreach ($categories as $category) {
                        if ($category->id_product_category == $post['cat_id']) {
                            $val = $category->cat_name;
                            break;
                        }
                    }
                    $sub_category_name = '';
                    foreach ($categories as $category) {
                        if ($category->id_product_category == $post['subcat_id'] && $category->parent_cat_id != null) {
                            $sub_category_name = $category->cat_name;
                            break;
                        }
                    }
                    $supplier_name = '';
                    foreach ($suppliers as $supplier) {
                        if ($supplier->id_supplier == $post['supplier_id']) {
                            $supplier_name = $supplier->supplier_name;
                            break;
                        }
                    }
                    $notes = '';
                    if ($post['note'] != null) {
                        $notes = $post['note'];
                    } else {
                        $notes = 'Purchase';
                    }
                    echo '<td>' . 'B:'.$post['brand_name'].' C:'.$val . '/' . $sub_category_name . '</td>';
                    echo '<td>' . $supplier_name . '</td>';
                    echo '<td>' . $post['reason'] . '</td>';
                    $colspan=8;
                    if($columns[0]->permission==1||$type==3){
                        $colspan=9;
                        echo '<td class="text-right">' . $post['purchase_price'] . '</td>';
                        $purchase_total += $post['purchase_price'] * $post['qty'];
                        $sum_purchase +=$post['purchase_price'];
                    }
                    echo '<td class="text-right">' . $post['selling_price_act'] . '</td>';
                    echo '<td class="text-right">' . $post['qty'] . '</td>';
                    if($columns[0]->permission==1||$type==3){
                        echo '<td class="text-right">' . $post['purchase_price'] * $post['qty'] . '</td>';
                    }
                    echo '<td class="text-right">' . $post['selling_price_act'] * $post['qty'] . '</td>';
                    $sum_sale+=$post['selling_price_act'];
                    $sale_total += $post['selling_price_act'] * $post['qty'];
                    $qty = $qty + $post['qty'];
                    ?>

                </tr>
                <?php
                $count++;
            endforeach;
        }
        if (!empty($postsPurchases)) {
            foreach ($postsPurchases as $purchase):
                ?>
                <tr>
                    <?php
                    $date = date('Y-m-d', strtotime($purchase['date']));
                    echo '<td>' . $count . '</td>';
                    echo '<td>' . $date . '</td>';
                    echo '<td>' . $purchase['store_name'] . '</td>';
                     echo '<td>' .  $post['batch_no'].' ' .$post['product_name'].' ('.$post['product_code'].')' . '</td>';
                    foreach ($categories as $category) {
                        if ($category->id_product_category == $purchase['cat_id']) {
                            $val = $category->cat_name;
                            break;
                        }
                    }
                    $sub_category_name = '';
                    foreach ($categories as $category) {
                        if ($category->id_product_category == $purchase['subcat_id'] && $category->parent_cat_id != null) {
                            $sub_category_name = $category->cat_name;
                            break;
                        }
                    }
                    $supplier_name = '';
                    foreach ($suppliers as $supplier) {
                        if ($supplier->id_supplier == $purchase['supplier_id']) {
                            $supplier_name = $supplier->supplier_name;
                            break;
                        }
                    }
                    $notes = '';
                    if ($purchase['note'] != null) {
                        $notes = $purchase['note'];
                    } else {
                        $notes = 'Purchase';
                    }
                    echo '<td>' . 'B:'.$post['brand_name'].' C:'.$val . '/' . $sub_category_name . '</td>';
                    echo '<td>' . $supplier_name . '</td>';
                    echo '<td>' . $purchase['reason'] . '</td>';
                    $colspan=8;
                    if($columns[0]->permission==1||$type==3){
                        $colspan=9;
                        echo '<td class="text-right">' . $purchase['purchase_price'] . '</td>';
                    $purchase_total += $purchase['purchase_price'] * $purchase['qty'];
                    $sum_purchase+=$purchase['purchase_price'];
                    }
                    echo '<td class="text-right">' . $purchase['selling_price_act'] . '</td>';
                    echo '<td class="text-right">' . $purchase['qty'] . '</td>';
                    if($columns[0]->permission==1||$type==3){
                        echo '<td class="text-right">' . $purchase['purchase_price'] * $purchase['qty'] . '</td>';
                    }
                    echo '<td class="text-right">' . $purchase['selling_price_act'] * $purchase['qty'] . '</td>';
                    $sum_sale+=$purchase['selling_price_act'];
                    $sale_total += $purchase['selling_price_act'] * $purchase['qty'];
                    $qty = $qty + $purchase['qty'];
                    ?>

                </tr>
                <?php
                $count++;
            endforeach;
        }
    } else {
        ?>
        <tr>
            <?php $colspan=8;?>
            <td colspan="10" class="text-center"><b><?= lang("data_not_available"); ?></b></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <th class="text-right" colspan="<?= $colspan?>"><?= lang("total"); ?>:</th>
    <th class="text-right"><?= number_format($qty, 2); ?></th>
    <?php 
    if($columns[0]->permission==1 ||$type==3){
        echo '<th class="text-right">'. number_format($purchase_total, 2).'</th>';
    }
    ?>
    <th class="text-right"><?= number_format($sale_total, 2); ?></th>
    
    </tfoot>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
