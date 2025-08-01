<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("delivery-name"); ?></th>  
    <th><?= lang("delivery-type"); ?></th>  
    <th><?= lang("agent-name"); ?></th>  
    <th class="center"><?= lang("view"); ?></th> 
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
                echo '<td>' . $post['delivery_name'] . '</td>';
               
                 if($post['type_id'] == 2){
                    echo '<td>' . lang("agents") . '</td>';
                }
                else if($post['type_id'] == 1){
                    echo '<td>' . lang("staff") . '</td>';
                }
                 if($post['type_id'] == 2){
                    echo '<td>' . $post['agent_name'] . '</td>';
                }

                else if($post['type_id'] == 1){
                    echo '<td> N/A </td>';
                }
                // echo '<td>' . $post['person_name'] . '</td>';
                // echo '<td>' . $post['type_id'] . '</td>';
                 
                
                // echo '<td>' . $post['gm_from'] .'-'.$post['gm_to']. '</td>';  
                // echo '<td>' . $post['price'] . '</td>';    
                
                ?>
                <td class="center">
                    <button class="btn btn-success btn-xs" data-title="<?= lang("view"); ?>" data-toggle="modal"
                            data-target="#view" onclick="viewCostDetaitls('<?php echo $post['id_delivery_cost']; ?>');costConfig_details(<?= $post['id_delivery_cost'] ?>);">
                        <span class="glyphicon glyphicon-eye-open"></span></button>
                </td>
                <td class="center">
                    <button class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" data-toggle="modal"
                            data-target="#add" onclick="editCosts('<?php echo $post['id_delivery_cost']; ?>');costConfig_details(<?= $post['id_delivery_cost'] ?>);"><span
                            class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td class="center">
                    <button class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal"
                            data-target="#deleteCost" onclick="deleteCostModal('<?= $post['id_delivery_cost'] ?>');">
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

