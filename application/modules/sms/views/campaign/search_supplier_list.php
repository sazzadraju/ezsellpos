<form class="form-horizontal" role="form" id="add_customer_list" action="" method="POST" enctype="multipart/form-data">
    <table id="mytable" class="table table-bordred table-striped table-hover">
        <thead>
        <th class=""><input type="checkbox" name="check_all" value="checkAll" id="CheckAll"  />
            <label for="CheckAll"><?=lang('check_all')?></label></th>
        <th><?= lang("supplier_name"); ?></th>
        <th><?= lang("supplier_code"); ?></th>
        <th><?= lang("phone"); ?></th>
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
                        <input type="checkbox" id="<?= $count ?>" name="id_check[]" value="<?= $post['id_supplier'] ?>">
                        <label style="margin-bottom: 0px;" for="<?= $count ?>">&nbsp;</label>
                        <input type="hidden" name="code[]" id="code_<?=$count?>" value="<?= $post['supplier_code'] ?>">
                        <input type="hidden" name="name[]"  id="name_<?=$count?>" value="<?= $post['supplier_name'] ?>">
                        <input type="hidden" name="phone[]"  id="phone_<?=$count?>" value="<?= $post['phone'] ?>">
                    </td>
                    <?php
                    echo '<td>' . $post['supplier_name'] . '</td>';
                    echo '<td>' . $post['supplier_code'] . '</td>';
                    echo '<td>' . $post['phone'] . '</td>';
                    ?>
                    </tr>
                    <?php
                    $count++;
                    $val++;
                //}
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
    $("#add_customer_list").submit(function () {
        var $html='';
        var dataString = new FormData($(this)[0]);
        $("input[name='id_check[]']:checked").each(function(){
            var id = $(this).val();
            var serial= this.id;
            var code = $('#code_'+serial).val();
            var name = $('#name_'+serial).val();
            var phone = $('#phone_'+serial).val();
            //var store = $('#store_'+serial).val();
            $html+= '<tr id="'+id+'">';
            $html+='<td>Supplier<input type="hidden" name="type[]" value="2"></td>';
            $html+='<td>'+code+'<input type="hidden" name="code[]" value="'+code+'"></td>';
            $html+='<td>'+name+'<input type="hidden" name="name[]" value="'+name+'"></td>';
            $html+='<td>'+phone+'<input type="hidden" name="phone[]"  value="'+phone+'"></td>';
            $html+='<td>'+''+'<input type="hidden" name="store[]"  value=""></td>';
            $html+='<td>'+'<input type="hidden" name="id[]" value="'+id+'"><input type="hidden" name="unique_check[]" value="2|'+id+'">'+'<button class="btn btn-danger btn-xs" onclick="removeMore('+id+');">X</button></td>';
        });
        $('#add_more_section:last').append($html);
        $('#add_submit').show();
        $('#searchData').fadeOut(500, function() {
            $(this).html('').show();
        });
        return false;
     });

    function removeMore(id) {
        $("#" + id).remove();
    }

</script>