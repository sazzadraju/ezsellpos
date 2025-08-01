

<form class="form-horizontal" role="form" id="enter_order_in" action="" method="POST" enctype="multipart/form-data">
    <table id="mytable" class="table table-bordred table-striped table-hover">
        <thead>
        <th><?= lang("sl_no"); ?></th>
        <th><?= lang("product_code"); ?></th>
        <th><?= lang("product_name"); ?></th>
        <th><?= lang("suppliers"); ?></th>
        <th><?= lang("qty"); ?></th>
        <th><?= lang("act_qty"); ?></th>
        <th><?= lang("unit_price"); ?></th>
        <th><?= lang("total_price"); ?></th>
        <th><?= lang("expiration_date"); ?></th>
        <th><?= lang("alert_date"); ?></th>
        </thead>
        <tbody class="checkGroup">
            <?php
            if (!empty($posts)):
                $val = 0;
                $count = 1;
                foreach ($posts as $post):
                    $attributes = $this->purchase_model->getvalue_row('purchase_attributes', 'p_attribute_id,s_attribute_name,s_attribute_value', array('status_id' => 1, 'order_details_id' => $post['id_purchase_order_detail']));
                    $c=1;
                    $attr_post='';
                    $attr_show='';
                    if($attributes){
                        foreach ($attributes as $attr){
                            $coma=($c > 1)?',':'';
                            $attr_post .= $coma . $attr->p_attribute_id . '=' . $attr->s_attribute_name . '=' . $attr->s_attribute_value;
                            $attr_show .= $coma .  $attr->s_attribute_name . '=' . $attr->s_attribute_value;
                            $c += 1;
                        }
                    }
                    ?>
                    <tr>
                        <td>
                            <?= $count ?>
                            <input type="hidden" id="details_id_<?= $count ?>" name="details_id[]" value="<?= $post['id_purchase_order_detail'] ?>">
                            <input type="hidden" id="chk_<?= $count ?>" name="id_check[]" value="<?= $post['id_product'] ?>">
                            <input type="hidden" name="code[]" id="code_<?= $count ?>" value="<?= $post['product_code'] ?>">
                            <input type="hidden" name="name[]"  id="name_<?= $count ?>" value="<?= $post['product_name'] ?>">
                            <input type="hidden" name="sell_price[]"  id="sell_price_<?= $count ?>" value="<?= $post['sell_price'] ?>">
                            <input type="hidden" name="row_attr_value[]"  id="row_attr_value_<?= $count ?>" value="<?= $attr_post ?>">
                            <input type="hidden" name="row_attr_show[]"  id="row_attr_show_<?= $count ?>" value="<?= $attr_show ?>">
                        </td>
                        <?php
                        $id_p = $post['id_product'];
                        echo '<td>' . $post['product_code'] .'<br>'.$attr_show. '</td>';
                        echo '<td>' . $post['product_name'] . '</td>';
                        echo '<td>' . $post['supplier_name'] . '<div class="btn btn-success btn-xs" name="add_row" id="' . $count . '"><i class="fa fa-plus-circle"></i></div>' . '</td>';
                        ?>
                        <td><input style="width: 60px" type="text" name="qty[]" class="form-control NumberOnly" id="qty_<?= $count ?>" value="<?= $post['qty'] ?>" readonly=""></td>
                        <td><input style="width: 60px" type="text" onchange="change_price(this)" name="act_qty[]" class="form-control NumberOnly" id="act_qty_<?= $count ?>" value="<?= $post['qty'] ?>"></td>
                        <td><input style="width: 80px" type="text" onchange="change_price(this)" name="unit_price[]" class="form-control Number"  id="unit_price_<?= $count ?>" value="<?= $post['unit_amt'] ?>"></td>
                        <td><input style="width: 80px" type="text" name="total_price[]" onchange="change_price(this)" class="form-control Number"  id="total_price_<?= $count ?>"value="<?= $post['tot_amt'] ?>"></td>
                        <td>
                            <input class="form-control dateall" type="text" id="date_ex_<?= $count ?>" name="f_expire_date[]">
                        </td>
                        <td>
                            <input class="form-control dateall" type="text" id="date_at_<?= $count ?>" name="f_alert_date[]">
                        </td>
                    </tr> 
                    <?php
                    $count++;
                    $val++;
                endforeach;
                echo '<input type="hidden" name="total_row" id="total_row" value="' . $val . '">';
            else:
                ?>
                <tr>
                    <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <button class="btn btn-info right margin-bottom-10" type="submit"><i class="fa fa-plus"></i> <?= lang('add_to_list')?></button>
</form>



<script>




    $('[name="add_row"]').bind('click', function () {
        var id = $(this).attr('id');
        var key = $('#chk_' + id).val();
        var qty = $('#qty_' + id).val();
        var code = $('#code_' + id).val();
        var name = $('#name_' + id).val();
        var vat = $('#vat_' + id).val();
        var details_id = $('#details_id_' + id).val();
        var sell_pric = $('#sell_price_' + id).val();
        var unit_price = $('#unit_price_' + id).val();
        var total_price = $('#total_price_' + id).val();
        var row_attr_value = $('#row_attr_value_' + id).val();
        var row_attr_show = $('#row_attr_show_' + id).val();
        var total_row = $('#total_row').val();
        var row_id = (total_row * 1) + 1;
        $('#total_row').val(row_id)
        var data = '<tr id="row_' + row_id + '">'
        data += '<td><input type="hidden" id="' + row_id + '" name="id_check[]" value="' + key + '">';
        data += '<input type="hidden" id="' + row_id + '" name="details_id[]" value="' + details_id + '">';
        data += '<input type="hidden" id="' + row_id + '" name="code[]" value="' + code + '">';
        data += '<input type="hidden" id="' + row_id + '" name="name[]" value="' + name + '">';
        data += '<input type="hidden" id="' + row_id + '" name="sell_price[]" value="' + sell_pric + '">';
        data += '<input type="hidden" id="' + row_id + '" name="qty[]" value="' + qty + '">';
        data += '<input type="hidden" id="' + row_id + '" name="row_attr_value[]" value="' + row_attr_value + '">';
        data += '<input type="hidden" id="' + row_id + '" name="row_attr_show[]"   value=""' + row_attr_show+ '">';
        data += '</td>';
        data += '<td colspan="4"></td>';
        data += '<td><input style="width: 60px" type="text" onchange="change_price(this)" name="act_qty[]" class="form-control NumberOnly" id="act_qty_' + row_id + '"> </td>';
        data += '<td><input style="width: 80px" type="text" onchange="change_price(this)" name="unit_price[]" class="form-control NumberOnly" id="unit_price_' + row_id + '" value="' + unit_price + '"> </td>';
        data += '<td><input style="width: 80px" type="text" onchange="change_price(this)" name="total_price[]" class="form-control NumberOnly" id="total_price_' + row_id + '"> </td>';
        data += '<td><input class="form-control datepicker3" type="text" id="f_expire_date_' + row_id + '" name="f_expire_date[]"></td>';
        data += '<td><input class="form-control datepicker3" type="text" id="f_alert_date_' + row_id + '" name="f_alert_date[]"></td>';
        data += '<td><div onclick="removeRow(' + row_id + ')" class="btn btn-danger btn-xs">X</div></td>';
        data += '</tr>';
        data += '<script>$(function () {$(".datepicker3").datetimepicker({viewMode: "years",format: "YYYY-MM-DD",});});' + '</sc' + 'ript>';
        //alert($(this).attr('id'));
        $(data).insertAfter($(this).closest('tr'));
        //$(this).after('tr').remove();

        //$('<tr><td colspan="9">new td</td></tr>').insertAfter($(this).closest('tr'));
    });
    function removeRow(id) {
        $("#row_" + id).remove();
    }
    $('[name="row_del"]').bind('click', function () {
        $(this).parent('tr').remove();
    });
    $("div.row_del").click(function (event) {
        $(this).parent('tr').remove();
    });
    $(function () {
        $('.dateall').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });
    });
    var $chAll = $('#CheckAll');
    var $ch = $('.checkGroup input[type="checkbox"]').not($chAll);
    var $par = $('.parent input[type="checkbox"]').not($chAll);
    $chAll.click(function () {
        $ch.prop('checked', $(this).prop('checked'));
    });
    $ch.click(function () {
        if ($ch.size() == $('.checkGroup input[type="checkbox"]:checked').not($chAll).size())
            $chAll.prop('checked', true)
        else
            $chAll.prop('checked', false)
    });
    $("#enter_order_in").submit(function () {

        if (validateTempAddCart() != false) {
            var $html = '';
            var rowCount = $('#add_section >tr').length;
            //alert(rowCount);
            var dataString = new FormData($(this)[0]);
            //dataString.append('p_row',rowCount);
            //dataString.append('p_row', rowCount);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>add_search_receive',
                data: dataString,
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    console.log(result);
                    $('#addSection > tbody:last').append(result);
                    $('.loading').fadeOut("slow");
                    $("#searchData").empty();
                    $('#add_submit').show();
                    var sum = 0;
                    $("input[name='total_price[]']").each(function () {
                        sum += Number($(this).val());
                    });
                    var qty = 0;
                    $("input[name='act_qty[]']").each(function () {
                        qty += Number($(this).val());
                    });
                    $("#sub_total").html(sum + 'TK');
                    $("#sub_qty").html(qty);
                    $('#row_sub_total').show();
                    $('#show_submit_tag').show();
                    
//                $('#searchData').fadeOut(500, function () {
//                    $(this).html('').show();
//                });
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        } else {
            return false;
        }
    });
    function removeMore(id) {
        $("#" + id).remove();
        var sum = 0;
        $("input[name='p_tot_p[]']").each(function () {
            sum += Number($(this).val());
        });
        var qty = 0;
        $("input[name='act_qty[]']").each(function () {
            qty += Number($(this).val());
        });
        $("#sub_total").html(sum + 'TK');
        $("#sub_qty").html(qty);
    }



</script>

