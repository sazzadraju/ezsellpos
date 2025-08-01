<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th>Invoice No</th>
    <th>User name</th>
    <th>User Type</th>
    <th>Note</th>
    <th class="text-center">Date</th>
    <th class="text-right">Due Amount</th>
    <th class="text-right">Total Amount</th>
    </thead>
    <tbody>
    <?php
    $i = 1;
    $type='';
    if (!empty($posts)) {
        foreach ($posts as $list) {
            $date=($list['dtt_mod']!='')?$list['dtt_mod']:$list['dtt_add'];
            ?>
            <tr>
                <td><?php echo $list['invoice_no']; ?></td>
                <td><?php echo $list['user_name']; ?></td>
                <?php foreach ($this->config->item('sales_person') as $key => $val) :
                    if ($list['person_type'] == $key) {
                        $type=$val;
                    }
                endforeach;
                ?>
                <td><?=$type?></td>
                <td><?php echo $list['notes']; ?></td>
                <td class="text-center"><?php echo nice_date($date); ?></td>
                <td class="text-right"><?php echo $list['due_amt']; ?></td>
                <td class="text-right"><?php echo $list['tot_amt']; ?></td>
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