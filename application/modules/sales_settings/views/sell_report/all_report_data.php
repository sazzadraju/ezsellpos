


<table id="mytable" class="table table-bordred table-striped">
<thead>
    <th><?= lang("invoice_no"); ?></th>
    <th><?= lang("sold_date"); ?></th>
    <th><?= lang("invoice_amount"); ?></th>
    <th><?= lang("sold_by"); ?></th>
    <th><?= lang("cusmtomer_name"); ?></th>
    <th><?= lang("station_name"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th class="center"><?= lang("view"); ?></th>
</thead>
<tbody>
    <?php
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php

                echo '<td>' . $post['invoice_no'] . '</td>';
                echo '<td>' . $post['dtt_add'] . '</td>';
               
                echo '<td>' .  $post['tot_amt']. '</td>';
                $val = '';
                // if (!empty($post['cat_id'])) {
                //     foreach ($categories as $category) {
                //         if ($category->id_product_category == $post['subcat_id']) {
                //             $val = $category->cat_name;
                //             break;
                //         }
                //     }
                // }
                $saler = '';
                 foreach ($sold_by as $solded_by) {
                    if ($solded_by->id_user == $post['uid_add']) {
                        $saler = $solded_by->uname;
                        break;
                    }
                }
                echo '<td>' .$saler. '</td>';
                $customer = '';
                 foreach ($customers as $customer_name) {
                    if ($customer_name->id_customer == $post['customer_id']) {
                        $customer = $customer_name->full_name;
                        break;
                    }
                }
                echo '<td>' . $customer . '</td>';
                 $station_name = '';
                 foreach ($station as $stations) {
                    if ($stations->id_station == $post['station_id']) {
                        $station_name = $stations->name;
                        break;
                    }
                }
                echo '<td>' . $station_name . '</td>';
                 $store_name = '';
                 foreach ($store as $stores) {
                    if ($stores->id_store == $post['store_id']) {
                        $store_name = $stores->store_name;
                        break;
                    }
                }
                echo '<td>' . $store_name . '</td>';
                // echo '<td>' . $post['purchase_price'] . '</td>';
                // echo '<td>' . $post['selling_price_act'] . '</td>';
                // echo '<td>' . $post['batch_no'] . '%</td>';
                ?>
                <td class="center">
                    <button class="btn btn-success btn-xs" data-title="<?= lang("view");?>" data-toggle="modal" data-target="#view" onclick="viewProductDetaitls('<?php echo $post['id_sale']; ?>')"><span class="glyphicon glyphicon-eye-open"></span></button>
                </td>
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
