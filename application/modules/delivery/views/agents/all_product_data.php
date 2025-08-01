<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("agent-name"); ?></th>
     <th><?= lang("address"); ?></th>
    <th><?= lang("mobile_no"); ?></th>
    <th><?= lang("email"); ?></th>
    <th><?= lang("contact-person-name"); ?></th>
    <th><?= lang("mobile_no"); ?></th>
    
    <th class="center"><?= lang("view"); ?></th>
    <th class="center"><?= lang("edit"); ?></th>
    <th class="center"><?= lang("delete"); ?></th>
    </thead>
    <tbody>
    <?php
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                $val='';
                echo '<td>' . $post['agent_name'] . '</td>';
                 echo '<td>' . $post['address'] . '</td>';
                echo '<td>' . $post['agent_number'] . '</td>';
                echo '<td>' . $post['email'] . '</td>';
                echo '<td>' . $post['contact_person_name'] . '</td>';
                echo '<td>' . $post['contact_person_number'] . '</td>';      
                
                ?>
                <td class="center">
                    <button class="btn btn-success btn-xs" data-title="<?= lang("view"); ?>" data-toggle="modal"
                            data-target="#view" onclick="viewAgentDetaitls('<?php echo $post['id_agent']; ?>')">
                        <span class="glyphicon glyphicon-eye-open"></span></button>
                </td>
                <td class="center">
                    <button class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" data-toggle="modal"
                            data-target="#add" onclick="editProducts('<?php echo $post['id_agent']; ?>')"><span
                            class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td class="center">
                    <button class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>" data-toggle="modal"
                            data-target="#deleteAgents" onclick="deleteProductModal('<?= $post['id_agent'] ?>');">
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
<div class="modal fade" id="stock_qty_details" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang("product_batch_details"); ?></h4>
            </div>
            <div class="modal-body">
                <table id="mytable" class="table table-bordred table-striped">
                    <thead>
                    <th><?= lang("batch_no"); ?></th>
                    <th><?= lang("quantity"); ?></th>
                    </thead>
                    <tbody id="stock_dts_data">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span><?= lang("close"); ?> </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
