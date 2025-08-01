<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("sl_no"); ?></th>
    <th><?= lang("full_name"); ?></th>
	<th><?= lang("user_name"); ?></th>
    <th><?= lang("store"); ?></th>
    <th><?= lang("email"); ?></th>
    <th><?= lang("phone"); ?></th>
    <th><?= lang("type"); ?></th>
    <th></th>
    <th style="text-align: center;"><?= lang("action"); ?></th>
    </thead>
    <tbody>
    <?php
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            if ($post['id_user'] != 2) {
                ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $post['fullname']; ?></td>
					<td><?php echo $post['uname']; ?></td>
                    <td><?php echo $post['store_name']; ?></td>
                    <td><?php echo $post['email']; ?></td>
                    <td><?php echo $post['mobile']; ?></td>
                    <td><?php echo $post['type_name']; ?> </td>
                    <td><?php
                        if ($post['uname'] != null) {
                            echo '  <span class="gldn">' . lang("user") . '</span>';
                        } ?>
                    </td>
                    <td class="center">
                        <a href="<?php echo base_url(); ?>employee/<?php echo $post['id_user']; ?>"
                           class="btn btn-success btn-xs" rel="tooltip" title="<?= lang("view") ?>"><span
                                class="glyphicon glyphicon-eye-open"></span></a>
                        <button class="btn btn-primary btn-xs" data-title="<?= lang("edit"); ?>" data-toggle="modal"
                                data-target="#edit_employee" onclick="editEmployee('<?= $post['id_user'] ?>')"
                                rel="tooltip" title="<?= lang("edit") ?>"><span
                                class="glyphicon glyphicon-pencil"></span></button>
                        <?php
                        if ($post['id_user'] != 1) {
                            ?>
                            <button class="btn btn-danger btn-xs" data-title="<?= lang("delete"); ?>"
                                    data-toggle="modal"
                                    data-target="#deleteEmployee"
                                    onclick="deleteEmployeeModal('<?= $post['id_user'] ?>');"
                                    rel="tooltip" title="<?= lang("delete") ?>"><span
                                    class="glyphicon glyphicon-trash"></span></button>
                            <?php
                            if ($this->session->userdata['login_info']['user_type_i92'] == 3 && $post['uname'] != null) {
                                ?>
                                <a class="btn btn-danger btn-xs"
                                   href="<?= base_url() . 'user-access/' . $post['id_user'] ?>"
                                   rel="tooltip" title="<?= lang("user_access_contorll") ?>"><span
                                        class="fa fa-gavel"></span></a>
                                <?php
                            }
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $count++;
            }
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