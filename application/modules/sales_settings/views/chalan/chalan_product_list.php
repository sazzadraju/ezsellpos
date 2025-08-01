<?php
if (!empty($sales)) {
    ?>
    <form action="" class="sales-form" id="preview_add_chalan" method="post">
        <div class="table-responsive">
            <div id="show_errors"></div>

            <table id="addSection" class="table table-bordred table-striped">
                <thead>
                <th>S/L</th>
                <th>Product name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Org. Quantity</th>
                <th>Qty</th>
                <th>Action</th>
                </thead>
                <tbody>
                <?php
                $count = 1;
                $total = 0;
                $check = 0;
                //pa($products);
                foreach ($products as $post) {
                    ?>
                    <tr id="<?= $post['id_sale_detail'] ?>">
                        <td><?= $count ?></td>
                        <td><?= $post['product_name'] ?></td>
                        <td><?= $post['brand_name'] ?></td>
                        <td><?= $post['cat_name'] ?></td>
                        <td align="center"><?= number_format($post['qty'], 0) ?> <input type="hidden" name="qty[]"
                                                                                        id="qty_<?= $count ?>"
                                                                                        value="<?= number_format($post['qty'], 0) ?>">
                        </td>
                        <td style="width: 70px"><input class="Number change_price" type="text" name="send_qty[]"
                                                       id="send_qty_<?= $count ?>"
                                                       value="<?= number_format($post['qty'], 0) ?>"></td>
                        <td>
                            <input type="hidden" id="details_id" name="details_id[]"
                                   value="<?= $post['id_sale_detail'] ?>">
                            <button class="btn btn-danger btn-xs" onclick="removeMore(<?= $post['id_sale_detail'] ?>);">
                                X
                            </button>
                        </td>
                    </tr>

                    <?php
                    $count++;
                    $check++;
                }
                ?>

                </tbody>
                <tfoot>

                <tr>
                    <th colspan="7" style="font-weight: 500">
                        <h6 class="element-header" id=""><span id="layout_title">Address</span></h6>
                        <?php
                        $i = 1;
                        if (!empty($posts)) {
                            foreach ($posts as $list) {
                                ?>
                                <p style="margin: 10px 0;">

                                    <input id="<?= $i ?>" name="check_address"
                                           value="<?= $list['id_customer_address'] ?>"
                                           type="radio" checked>
                                    <label style="margin-bottom: 14px;" for="<?= $i ?>"></label>


                                    <strong id="type_<?= $i ?>"><?php echo $list['address_type']; ?>: </strong>
                                    <span id="dis_<?= $i ?>"><?php if ($list['division_name_en'] != "") {
                                            echo $list['division_name_en'];
                                        } else {
                                            echo $list['city_name_en'];
                                        } ?> </span>,
                                    <span id="area_<?= $i ?>"><?php if ($list['district_name_en'] != "") {
                                            echo $list['district_name_en'];
                                        } else {
                                            echo $list['area_name_en'];
                                        } ?> </span>,
                                    <span id="details_<?= $i ?>"><?php echo $list['addr_line_1']; ?></span>

                                </p>

                                <?php
                                $i++;
                            }
                        } else {
                            echo 'No address selected..';
                        }

                        ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="7">Remarks</th>
                </tr>
                <tr>
                    <td colspan="7"><textarea name="remarks"></textarea></td>
                </tr>

                </tfoot>

            </table>

            <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
        </div>
        <button class="btn btn-primary" name="preview_add_chalan">Preview</button>
    </form>
    <?php
} else { ?>
    <div class="alert alert-danger">No data found</div>
    <?php
}
?>
<div id="chalanPreview" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Chaalan Print View</h6>
            </div>
            <div class="modal-body">
                <div class="sale-view invoice_content" id="sale_print">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="sale_a4_print()">Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload()" aria-hidden="true">Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.Number').keypress(function (event) {
        if (event.which == 8 || event.which == 0) {
            return true;
        }
        if (event.which < 46 || event.which > 59) {
            return false;
        } // prevent if not number/dot

        if (event.which == 46 && $(this).val().indexOf('.') != -1) {
            return false;
        }
    });
    $("#preview_add_chalan").submit(function () {
        var $html = '';

        var dataString = new FormData($(this)[0]);
        var ck_id=$('input[name="check_address"]:checked').attr('id');
        var dis=$('#dis_'+ck_id).text();
        var area=$('#area_'+ck_id).text();
        var details=$('#details_'+ck_id).text();
        var addr=details+', '+area+', '+dis;
        dataString.append('address', addr);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>show_preview_chalan',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                $('.loading').fadeOut("slow");
                $('#sale_print').html(result);
                $('#chalanPreview').modal('toggle');
                //$('#post_data').html('');
                return false;
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });
    function removeMore(id) {
        $("#" + id).remove();
    }
    $(document).on('input', '.change_price', function () {
        var m_id = this.id;
        var id = m_id.split('_').pop(-1);
        var qty = $("#qty_" + id).val();
        var send_qty = $("#send_qty_" + id).val();
        if (!$.isNumeric($(this).val())) {
            $(this).addClass("focus_error");
        } else if ((qty * 1) < (send_qty * 1)) {
            $(this).addClass("focus_error");
        } else {
            $(this).removeClass("focus_error");
        }
    });
</script>