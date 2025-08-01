<table id="mytable" class="table table-bordred table-striped">
<thead>
    <th><?= lang("product_code"); ?></th>
    <th><?= lang("product_name"); ?></th>
    <th><?= lang("category"); ?></th>
    <th><?= lang("supplier"); ?></th>
    <th><?= lang("batch_no"); ?></th>
    <th><?= lang("quantity"); ?></th>
    <th><?= lang("purchase_price"); ?></th>
    <th><?= lang("selling_price"); ?></th>
</thead>
<tbody>
    <?php
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                echo '<td>' . $post['product_code'] . '</td>';
                echo '<td>' . $post['product_name'] . '</td>';
                foreach ($categories as $category) {
                    if ($category->id_product_category == $post['cat_id']) {
                        $val = $category->cat_name;
                        break;
                    }
                }
                echo '<td>' . $val . '</td>';
            
                // echo '<td>' . $val. '</td>';
                echo '<td>' . $post['supplier_id'] . '</td>';
                echo '<td>' . $post['batch_no'] . '</td>';
                echo '<td>' . $post['qty'] . '</td>';
                echo '<td>' . $post['purchase_price'] . '</td>';
                echo '<td>' . $post['selling_price_act'] . '</td>';
                // echo '<td>' . $post['batch_no'] . '%</td>';
                ?>
             <!--    <td class="center">
                    <button class="btn btn-success btn-xs" data-title="<?= lang("view");?>" data-toggle="modal" data-target="#view" onclick="viewProductDetaitls('<?php echo $post['product_id']; ?>')"><span class="glyphicon glyphicon-eye-open"></span></button>
                </td> -->
<!--                 <td class="center">
                    <button class="btn btn-primary btn-xs" data-title="<?= lang("edit");?>" data-toggle="modal" data-target="#add" onclick="editProducts('<?php echo $post['id_product']; ?>')"><span class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td class="center">
                    <button class="btn btn-danger btn-xs" data-title="<?= lang("delete");?>" data-toggle="modal" data-target="#deleteProduct" onclick="deleteProductModal('<?= $post['id_product'] ?>');"><span class="glyphicon glyphicon-trash"></span></button>
                </td> -->
            </tr>
            <?php
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available");?></b></td>
        </tr>
    <?php endif; ?> 
</tbody>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
