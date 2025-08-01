<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("delivery-persons-name"); ?></th>
    <th><?= lang("mobile_no"); ?></th>  
    <th><?= lang("person-type"); ?></th>  
    <th><?= lang("agents"); ?></th>  
    <th><?= lang("added_by"); ?></th>  
    <th><?= lang("added date"); ?></th>  
    <!-- <th class="center"><?= lang("view"); ?></th> -->
    <th class="center"><?= lang("edit"); ?></th>
    <th class="center"><?= lang("delete"); ?></th>
    </thead>
    <tbody>
    <?php
    if (!empty($posts)):
        // pa($posts);
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                $val='';
                if($post['type_id'] == 2){
                    echo '<td>' . $post['person_name'] . '</td>';
                }
                else if($post['type_id'] == 1){
                    echo '<td>' . $post['fullname'] . '</td>';
                }
                // echo '<td>' . $post['person_name'] . '</td>';
                echo '<td>' . $post['person_mobile'] . '</td>';
                // echo '<td>' . $post['type_id'] . '</td>';
                  if($post['type_id'] == 2){
                    echo '<td>' . lang("agents") . '</td>';
                    echo '<td>' . $post['agent_name'] . '</td>';
                }
                else if($post['type_id'] == 1){
                    echo '<td>' . lang("staff") . '</td>';
                    echo '<td>' . 'N/A'. '</td>';
                }
                echo '<td>' . $post['added'] . '</td>';
                echo '<td>' . $post['dtt_add'] . '</td>';      
                
                ?>
                <td class="center">
                    <button class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" data-toggle="modal"
                            data-target="#add" onclick="editPersons('<?php echo $post['id_delivery_person']; ?>')"><span
                            class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td class="center">
                    <button class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal"
                            data-target="#deletePersons" onclick="deletePersonModal('<?= $post['id_delivery_person'] ?>');">
                        <span class="glyphicon glyphicon-trash"></span></button>
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

