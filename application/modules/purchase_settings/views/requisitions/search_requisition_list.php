<form class="form-horizontal" role="form" id="enter_stock_in" action="" method="POST" enctype="multipart/form-data">
    <table id="mytable" class="table table-bordred table-striped table-hover">
        <thead>
        <th class=""><input type="checkbox" name="check_all" value="checkAll" id="CheckAll"  />
            <label for="CheckAll"><?=lang('check_all')?></label></th>
        <th><?= lang("product_code"); ?></th>
        <th><?= lang("product_name"); ?></th>
        <th><?= lang("qty"); ?></th>
        </thead>
        <tbody class="checkGroup">
        <?php
        if (!empty($posts)):
            $val=0;
            $count = 1;
            foreach ($posts as $post):
                if(!in_array($post['id_product'], $value)){
                ?>
                    <tr>
                    <td style="width: 18%;">
                        <input type="checkbox" id="<?= $count ?>" name="id_check[]" value="<?= $post['id_product'] ?>">
                        <label style="margin-bottom: 0px;" for="<?= $count ?>">&nbsp;</label>
                        <input type="hidden" name="code[]" id="code_<?=$count?>" value="<?= $post['product_code'] ?>">
                        <input type="hidden" name="name[]"  id="name_<?=$count?>" value="<?= $post['product_name'] ?>">
                    </td>
                    <?php
                    echo '<td>' . $post['product_code'] . '</td>';
                    echo '<td>' . $post['product_name'] . '</td>';
                    ?>
                    <td><input style="width: 60px" type="text" name="qty[]" class="form-control" id="qty_<?=$count?>"></td>
                    </tr>
                    <?php
                    $count++;
                    $val++;
                }
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
        var $html='';
        var dataString = new FormData($(this)[0]);
//        var checkedIds = $("input[name='id_check[]']:checked").map(function() {
//            var serial= this.id;
//            var id= this.val();
//            var code = $('#code_'+serial).val();
//            var name = $('#name_'+serial).val();
//            var qty = $('#qty_'+serial).val();
//            $html+= '<tr id="'+id+'">';
//            $html+='<td>'+code+'<input type="hidden" name="code[]" value="'+code+'"></td>';
//           // $html+='<td>'.$key.$name[serial].'<input type="hidden" name="code[]" value="'.$name[$key].'">'.'</td>';
//           // $html+='<td><input class="form-control" style="width: 60px" type="text" name="qty[]" id="qty[]" value="'.$qty[$key].'">'.'</td>';
//           // $html+='<td>'.'<input type="hidden" name="id_pro[]" value="'.$checks[$key].'">'.'<button class="btn btn-danger btn-xs" onclick="removeMore('.$checks[$key].');">X</button></td>';
//            $html+= '</tr>';
//        }).get();
        $("input[name='id_check[]']:checked").each(function(){
            var id = $(this).val();
            var serial= this.id;
            var code = $('#code_'+serial).val();
            var name = $('#name_'+serial).val();
            var qty = $('#qty_'+serial).val();
            $html+= '<tr id="'+id+'">';
            $html+='<td>'+code+'<input type="hidden" name="code[]" value="'+code+'"></td>';
            $html+='<td>'+name+'<input type="hidden" name="code[]" value="'+name+'"></td>';
            $html+='<td><input class="form-control" style="width: 60px" type="number" name="qty[]" id="qty[]" value="'+qty+'"></td>';
            $html+='<td>'+'<input type="hidden" name="id_pro[]" value="'+id+'">'+'<button class="btn btn-danger btn-xs" onclick="removeMore('+id+');">X</button></td>';
        });
        //alert($html);
        $('#addSection > tbody:last').append($html);
        $('#add_submit').show();
        $('#searchData').fadeOut(500, function() {
            $(this).html('').show();
        });
        return false;
//        var temp = checkedIds.split(",");
//        console.log(temp);
//        $.ajax({
//            type: "POST",
//            url: '<?php //echo base_url();?>//add_search_requisition',
//            data: dataString,
//            async: false,
//            beforeSend: function () {
//                $('.loading').show();
//            },
//            success: function (result) {
//                console.log(result);
//                $('#addSection > tbody:last').append(result);
//                $('.loading').fadeOut("slow");
//                $('#searchData').fadeOut(500, function() {
//                    $(this).html('').show();
//                });
//            },
//            cache: false,
//            contentType: false,
//            processData: false
//        });
       // return false;
     });

    function removeMore(id) {
        $("#" + id).remove();
    }

</script>