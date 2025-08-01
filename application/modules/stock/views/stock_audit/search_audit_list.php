<form class="form-horizontal" role="form" id="enter_stock_in" action="" method="POST" enctype="multipart/form-data">
    <table id="mytable" class="table table-bordred table-striped table-hover">
        <thead>
        <th class=""><input type="checkbox" name="check_all" value="checkAll" id="CheckAll"  />
            <label for="CheckAll"><?=lang('check_uncheck_all')?></label></th>
        <th><?= lang("product_code"); ?></th>
        <th><?= lang("product_name"); ?></th>
        <!-- <th><?php //echo lang("actual_qty"); ?></th> -->
        </thead>
        <tbody class="checkGroup">
        <?php
        if (!empty($posts)):
            $val=0;
            $count = 1;
            foreach ($posts as $post):
                //if(!in_array($post['id_product'], $value)){
                ?>
                    <tr>
                    <td style="width: 18%;">
                        <input type="checkbox" id="<?= $post['id_product'] ?>" name="id_check[]" value="<?= $post['id_product'] ?>">
                        <label style="margin-bottom: 20px;" for="<?= $post['id_product'] ?>"></label>
                        <input type="hidden" name="code[]" id="code_<?=$count?>" value="<?= $post['product_code'] ?>">
                        <input type="hidden" name="name[]"  id="name_<?=$count?>" value="<?= $post['product_name'] ?>">
                    </td>
                    <?php
                    echo '<td>' . $post['product_code'] . '</td>';
                    echo '<td>' . $post['product_name'] . '</td>';
                    ?>
                    </tr>
                    <?php
                    $count++;
                    $val++;
               // }
            endforeach;
            if($val==0){
                ?>
                <tr>
                    <td colspan="4"><b><?= lang("data_not_available");?></b></td>
                </tr>
                <?php
            }else{}
        else:
            ?>
            <tr>
                <td colspan="4"><b><?= lang("data_not_available");?></b></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
     <button class="btn btn-info right margin-bottom-10" type="submit"><i class="fa fa-plus"></i></button>
</form>

<script>
    var a = 0;
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
    $("#enter_stock_in").submit(function () {
        var html = '';
        var store_id = $('#store_from').val();
        var dataString = new FormData($(this)[0]);
        dataString.append('store_id', store_id);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>search_stock_product',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (result) {
                var result = $.parseJSON(result);
                var rowCount=0;
                var chkrow=1;
                for (var i = 0; i < result.length; i++) {
                    var id_stock = result[i].id_stock;
                    var batch_no = result[i].batch_no;
                    var product_id = result[i].product_id;
                    var product_code = result[i].product_code;
                    var product_name = result[i].product_name;
                    var qty = result[i].qty;
                    var chkq=1;
                    $("input[name='id_pro[]']").each(function () {
                        var id_value = $(this).val();
                        var id_full = $(this).attr('id');
                        id = id_full.split("_").pop(-1);
                        if(chkrow==1){
                            rowCount=id*1;
                        }
                        var batch_value = $('#batch_no_' + id).val();
                        if ((id_value == product_id) && (batch_no == batch_value)) {
                            chkq=2;
                        }
                    });
                    if(chkq==1){
                        chkrow=2;
                        rowCount += 1;
                        html += '<tr id="' + id_stock + '"><input type="hidden" name="stock_audit_detail_id[]"><input type="hidden" name="stock_id[]" value="' + id_stock + '"><input type="hidden" name="id_pro[]" id="id_pro_' + rowCount + '" value="' + product_id + '"><input id="batch_no_'+ rowCount +'" type="hidden" name="batch_no[]" value="' + batch_no + '">';
                        html += '<td>' + product_code + '</td>';
                        html += '<td>' + product_name + '</td>';
                        html += '<td>' + batch_no + '</td>';
                        html += '<td>' + qty + '<input type="hidden" name="qty_db[]" value="' + qty + '"></td>';
                        html += '<td><input class="form-control" style="width: 60px" type="text" name="qty_store[]" id="qty_store_' + rowCount + '"></td>';
                        html += '<td><input class="form-control" style="width: 100%" type="text" name="notes[]" id="notes"></td>';
                        html += '<td> <button class="btn btn-danger btn-xs" onclick="removeMore(' + id_stock + ');">X</button></td>';
                        a++;
                    }
                }
                $('#addSection > tbody:last').append(html);
                $('#add_submit').show();
                $('.loading').fadeOut("slow");
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
    }

</script>