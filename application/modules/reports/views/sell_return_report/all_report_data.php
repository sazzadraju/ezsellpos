<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("invoice_no"); ?></th>
    <th><?= lang("sold_date"); ?></th>
    <th><?= lang("invoice_amount"); ?></th>
    <th><?= lang("received_by"); ?></th>
    <th><?= lang("cusmtomer_name"); ?></th>
    <th><?= lang("station_name"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <!-- <th><?= lang("category"); ?></th>
    <th><?= lang("sub_category"); ?></th>
    <th><?= lang("brand"); ?></th> -->
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

                echo '<td id="invoiceNo">' . $post['invoice_no'] . '</td>';
                echo '<td>' . $post['dtt_add'] . '</td>';

                echo '<td>' . $post['tot_amt'] . '</td>';
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

                ?>
                <td class="center">
                    <button class="btn btn-primary pull-right" type="button"
                            onclick="searchFilter2('<?php echo $post["id_sale_adjustment"] ?>')"><i class="fa fa-eye"></i></button>
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
<div id="SaleInvoiceDetails" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Sale Invoice Details</h6>
            </div>
            <div class="modal-body">
                <div class="sale-view invoice_content" id="sale_view">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="sale_print()">Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function searchFilter2(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>invoice_view_sale_return/' + id ,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                // console.log(html);
                $('#sale_view').html(html);
                $('.loading').fadeOut("slow");
                $('#SaleInvoiceDetails').modal('toggle');
            }
        });
    }
</script>
