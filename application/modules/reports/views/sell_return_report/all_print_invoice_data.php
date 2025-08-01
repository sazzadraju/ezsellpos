<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("invoice_no"); ?></th>
    <th><?= lang("sold_date"); ?></th>
    <th><?= lang("received_by"); ?></th>
    <th><?= lang("cusmtomer_name"); ?></th>
    <th><?= lang("station_name"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th class="text-right"><?= lang("invoice_amount"); ?></th>
    </thead>
    <tbody>
    <?php
    $total_amt=0;
    if (!empty($posts)):
        $count = 1;
        
        foreach ($posts as $post):
            ?>
            <tr>
                <?php

                echo '<td id="invoiceNo">' . $post['invoice_no'] . '</td>';
                echo '<td>' . $post['dtt_add'] . '</td>';

                
                $val = '';
                $saler = '';
                foreach ($sold_by as $solded_by) {
                    if ($solded_by->id_user == $post['uid_add']) {
                        $saler = $solded_by->uname;
                        break;
                    }
                }
                echo '<td>' . $saler . '</td>';
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
                $category_name = '';
                foreach ($categories as $category) {
                    if ($category->id_product_category == $post['cat_id'] && $category->parent_cat_id == null) {
                        $category_name = $category->cat_name;
                        break;
                    }
                }
                echo '<td class="text-right">' . round($post['tot_amt'],2) . '</td>';
                $total_amt+=$post['tot_amt'];

                ?>
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
    <tfoot>
        <th class="text-right" colspan="6"><?= lang("total"); ?></th>
        <th class="text-right"><?= round($total_amt,2); ?></th>
    </tfoot>
</table>
