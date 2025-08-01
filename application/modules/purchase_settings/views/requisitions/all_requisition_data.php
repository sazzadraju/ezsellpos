<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("product_code"); ?></th>
    <th><?= lang("product_name"); ?></th>
    <th><?= lang("qty"); ?></th>
    <th><?= lang("store_name"); ?></th>
    <th><?= lang("full_name"); ?></th>
    <th><?= lang("date"); ?></th>
    <th><?= lang("status"); ?></th>
    </thead>
    <tbody>
    <?php
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                echo '<td>' . $post['product_code'] . '</td>';
                echo '<td>' . $post['product_name'] . '</td>';
                echo '<td>' . number_format($post['qty']) . '</td>';
                echo '<td>' . $post['store_name'] . '</td>';
                echo '<td>' . $post['fullname'] . '</td>';
                echo '<td>' . explode(" ", $post['dtt_add'])[0] . '</td>';
                if( $post['status_id']==1){
                    echo '<td>' . lang('informed') . '</td>';
                } else if($post['status_id']==2){
                    echo '<td>' . lang('canceled') . '</td>';
                } else{
                    echo '<td>' . lang('request_sent') . '</td>';
                }
                ?>
            </tr>
            <?php
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available");?></b></td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>