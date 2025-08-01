<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th>User name</th>
    <th>User Type</th>
    <th>Phone</th>
    <th>Commission</th>
    <th>Balance</th>
    <th>Action</th>

    </thead>
    <tbody>
    <?php
    $i = 1;
    if (!empty($posts)) {
        foreach ($posts as $list) {
            ?>
            <tr>
                <td id="name_<?php echo $list['id_sales_person']; ?>"><?php echo $list['user_name']; ?></td>
                <?php foreach ($this->config->item('sales_person') as $key => $val) :
                    if ($list['person_type'] == $key) {
                        $type=$val;
                    }
                endforeach;
                ?>
                <td id="person_<?php echo $list['id_sales_person']; ?>"><?=$type?></td>
                <td><?php echo $list['phone']; ?></td>
                <td id="com_<?php echo $list['id_sales_person']; ?>"><?php echo $list['commission']; ?></td>
                <td><?php echo $list['curr_balance']; ?></td>
                <td>
                    <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" rel="tooltip"
                            title="<?= lang("edit") ?>" data-target="#edit"
                            onclick="editSales('<?php echo $list['id_sales_person']; ?>')"><span
                                class="glyphicon glyphicon-pencil"></span></button>
<!--                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" rel="tooltip"-->
<!--                            title="--><?//= lang("delete") ?><!--" data-target="#deleteCustomerInfoModal"-->
<!--                            onclick="deleteCustomerModal('--><?php //echo $list['id_sales_person']; ?><!-- ')">
//                    <span class="glyphicon glyphicon-trash"></span></button>-->
                </td>
            </tr>

            <?php
            $i++;
        }
    }
    ?>
    </tbody>

</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>