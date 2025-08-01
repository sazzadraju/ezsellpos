<form class="form-horizontal" role="form" id="enter_order_in" action="" method="POST" enctype="multipart/form-data">
    <table id="mytable" class="table table-bordred table-striped table-hover">
        <thead>
        <th class=""><input type="checkbox" name="check_all" value="checkAll" id="CheckAll"/>
            <label for="CheckAll"><?= lang('check_all') ?></label></th>
        <th><?= lang("product_code"); ?></th>
        <th><?= lang("product_name"); ?></th>
        <th><?= lang("suppliers"); ?></th>
        <th><?= lang("qty"); ?></th>
        <th><?= lang("unit_price"); ?></th>
        <th><?= lang("total_price"); ?></th>
        </thead>
        <tbody class="checkGroup">
        <?php
        if (!empty($posts)):
            $val = 0;
            $count = 1;
            foreach ($posts as $post):
                ?>
                <tr>
                    <td style="width: 18%;">
                        <input type="checkbox" id="<?= $count ?>" name="id_check[]" value="<?= $post['product_id'] ?>">
                        <label style="margin-bottom: 0px;" for="<?= $count ?>">&nbsp;</label>
                        <input type="hidden" name="code[]" id="code_<?= $count ?>" value="<?= $post['product_code'] ?>">
                        <input type="hidden" name="name[]" id="name_<?= $count ?>" value="<?= $post['product_name'] ?>">
                    </td>
                    <?php
                    $id_p = $post['product_id'];
                    echo '<td>' . $post['product_code'] . '</td>';
                    echo '<td>' . $post['product_name'] . '</td>';
                    ?>
                    <td>
                        <select class="select2" data-live-search="true" id="supplier" name="supplier[<?= $id_p ?>][]">
                            <option value="0"><?= lang("select_one"); ?></option>
                            <?php
                            foreach ($suppliers as $supplier) {
                                $selected = '';
                                echo '<option value="' . $supplier->id_supplier . '" ' . $selected . '>' . $supplier->supplier_name . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td><input style="width: 60px" type="text" onchange="change(<?= $count ?>)"
                               name="qty[<?= $id_p ?>][]" class="form-control" onkeypress="return isNumber(event)"
                               id="qty_<?= $count ?>" value="<?= $post['qty'] ?>"></td>
                    <td><input style="width: 100px" type="text" onchange="change(<?= $count ?>)"
                               name="unit_price[<?= $id_p ?>][]" class="form-control"
                               onkeypress="return isNumber(event)" id="unit_price_<?= $count ?>"
                               value="<?= $post['buy_price'] ?>"></td>
                    <td><input style="width: 100px" type="text" name="total_price[<?= $id_p ?>][]" onchange="change_price(<?= $count ?>)" class="form-control"
                               onkeypress="return isNumber(event)" id="total_price_<?= $count ?>"  value="<?= $post['buy_price']*$post['qty'] ?>"></td>

                </tr>
                <?php
                $count++;
                $val++;
            endforeach;
            if ($val == 0) {
                ?>
                <tr>
                    <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
                </tr>
                <?php
            } else {

            }
        else:
            ?>
            <tr>
                <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php
if(!empty($posts)){
    echo '<button class="btn btn-info right margin-bottom-10" type="submit"><i class="fa fa-plus"></i></button>';
}
?>
</form>

<script>
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
        var $html = '';
        var rowCount = $('#add_section >tr').length;
        //alert(rowCount);
        var dataString = new FormData($(this)[0]);
        //dataString.append('p_row',rowCount);
        dataString.append('p_row', rowCount);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>add_search_order',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                console.log(result);
                $('#addSection > tbody:last').append(result);
                $('.loading').fadeOut("slow");
                $('#add_submit').show();
                var sum = 0;
                $("input[name='p_tot_p[]']").each(function () {
                    sum += Number($(this).val());
                });
                $("#sub_total").html(sum + 'TK');
                $('#row_sub_total').show();
                $('#searchData').fadeOut(500, function () {
                    $(this).html('').show();
                });
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    function removeMore(id) {
        $("#" + id).remove();
        var sum = 0;
        $("input[name='p_tot_p[]']").each(function () {
            sum += Number($(this).val());
        });
        $("#sub_total").html(sum + 'TK');
    }


</script>

