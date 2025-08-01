<form class="form-horizontal" role="form" id="add_customer_list" action="" method="POST" enctype="multipart/form-data">
    <table id="mytable" class="table table-bordred table-striped table-hover">
        <thead>
        <th class=""><input type="checkbox" name="check_all" value="checkAll" id="CheckAll"  />
            <label for="CheckAll"><?=lang('check_all')?></label></th>
        <th><?= lang("customer_name"); ?></th>
        <th><?= lang("customer_code"); ?></th>
        <th><?= lang("customer_type"); ?></th>
        <th><?= lang("phone"); ?></th>
        <th><?= lang("store_name"); ?></th>
        <th></th>
        </thead>
        <tbody class="checkGroup">
        <?php
        if (!empty($posts)):
            $val=0;
            $count = 1;
            foreach ($posts as $post):
                //if(!in_array($post['id_product'], $value)){
                ?>
                    <tr id="row_<?= $count ?>">
                    <td style="width: 18%;">
                        <input type="checkbox" id="<?= $count ?>" name="id_check[]" value="<?= $post['id_customer'] ?>">
                        <label style="margin-bottom: 0px;" for="<?= $count ?>">&nbsp;</label>
                        <input type="hidden" name="code[]" id="code_<?=$count?>" value="<?= $post['customer_code'] ?>">
                        <input type="hidden" name="name[]"  id="name_<?=$count?>" value="<?= $post['full_name'] ?>">
                        <input type="hidden" name="type[]"  id="type_<?=$count?>" value="<?= $post['name'] ?>">
                        <input type="hidden" name="phone[]"  id="phone_<?=$count?>" value="<?= $post['phone'] ?>">
                        <input type="hidden" name="store[]"  id="store_<?=$count?>" value="<?= $post['store_name'] ?>">
                    </td>
                    <?php
                    echo '<td>' . $post['full_name'] . '</td>';
                    echo '<td>' . $post['customer_code'] . '</td>';
                    echo '<td>' . $post['name'] . '</td>';
                    echo '<td>' . $post['phone'] . '</td>';
                    echo '<td>' . $post['store_name'] . '</td>';
                    ?>
                    <td></td>
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
        var valid_phone=1;
        var valid_uniq=1;
        var msg='';
        $('#search_row_error').html('');
        $("input[name='id_check[]']:checked").each(function(){
            var id = $(this).val();
            var serial= this.id;
            $('#row_' + serial).removeClass("error");
            var code = $('#code_'+serial).val();
            var name = $('#name_'+serial).val();
            var phone = $('#phone_'+serial).val();
            if(!(isValid(phone))){
                $('#row_' + serial).addClass("error");
                valid_phone=2;
            }
            $('input[name^="unique_check"]').each(function() {
                var value=$(this).val();
                var result = value.split('|');
                if((result[1]==id) && (result[0]==1)){
                    $('#row_' + serial).addClass("error");
                    //alert(result[0]+'==='+result[1]);
                    valid_uniq=2
                }
            });
            var store = $('#store_'+serial).val();
            $html+= '<tr id="'+id+'">';
            $html+='<td>Customer<input type="hidden" name="type[]" value="1"></td>';
            $html+='<td>'+code+'<input type="hidden" name="code[]" value="'+code+'"></td>';
            $html+='<td>'+name+'<input type="hidden" name="name[]" value="'+name+'"></td>';
            $html+='<td>'+phone+'<input type="hidden" name="phone[]"  value="'+phone+'"></td>';
            $html+='<td>'+store+'<input type="hidden" name="store[]"  value="'+store+'"></td>';
            $html+='<td>'+'<input type="hidden" name="id[]" value="'+id+'"><input type="hidden" name="unique_check[]" value="1|'+id+'">'+'<button class="btn btn-danger btn-xs" onclick="removeMore('+id+');">X</button></td>';

           
            
        });
        if(valid_phone==2||valid_uniq==2){
            if(valid_phone==2){
                msg+='<div>Phone number is invalid. (ex:88 or 11 digit number)</div>';
            }
            if(valid_uniq==2){
                msg+='<div>This name already exists.</div>';
            }
            $('#search_row_error').html(msg);
            
        }else{
            $('#add_more_section:last').append($html);
            $('#add_submit').show();
            $('#searchData').fadeOut(500, function() {
                $(this).html('').show();
            });
        }
        return false;
     });

    function isValid(p) {
      //var phoneRe = /^(?:\+88|01)?\d{11}\r?$/;
      var phoneRe = /^(?:\+88|01|88)?(?:\d{11}|\d{13})$/;
      var digits = p.replace(/\D/g, "");
      return phoneRe.test(digits);
    }

    function removeMore(id) {
        $("#" + id).remove();
    }

</script>