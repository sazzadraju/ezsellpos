
<!-- <?php print_r($transaction_type); ?> -->

<table id="mytable" class="table table-bordred table-striped">
<thead>
     <th><?= lang("date"); ?></th>
     <th><?= lang("store"); ?></th> 
     <th><?= lang("transaction_no"); ?></th>
     <th><?= lang("investor_name"); ?></th> 
     <th><?= lang("details"); ?></th>
     <th><?= lang("transaction_type"); ?></th> 
    <th><?= lang("account_no"); ?></th> 
    <th class="text-right"><?= lang("amount").' ('.set_currency().')'; ?></th>
     
</thead>
<tbody>
    <?php
    $total = 0;
    if (!empty($posts)):

        $count = 1;
        foreach ($posts as $post):
          // echo "<pre>";
          //   print_r($post);
            ?>
            <tr>
                <?php
                $store_name = '';
                 foreach ($store as $stores) {
                    if ($stores->id_store == $post['store_id']) {
                        $store_name = $stores->store_name;
                        break;
                    }
                }
                $date = date('Y-m-d', strtotime($post['dtt_trx']));
                echo '<td>' . $date . '</td>';
                echo '<td>' .$store_name . '</td>';
                 echo '<td>' .$post['trx_no'] . '</td>';
                  $employee = '';
                 foreach ($employee_name as $employee_names) {
                    if ($employee_names->id_user == $post['ref_id']) {
                        $employee = $employee_names->fullname;
                        break;
                    }
                }
                 echo '<td>' .$employee. '</td>';
                  
                 foreach ($transaction_type as $key=>$val) {
                       $type_name = '';  
                            if ($key == $post['qty_multiplier']) {
                             $type_name =  $val;
                        break;
                    }                                         
                                }
                 echo '<td>' .$post['description']. '</td>';
                 echo '<td>' .$type_name. '</td>';
                 // echo '<td>' .$post['payment_method_id']. '</td>';
                 echo '<td>' .account_name_id($post['account_id']).'</td>';
                 echo '<td class="text-right">' .$post['tot_amount'] . '</td>';
                ?>
            </tr>
            <?php
            $total+=$post['tot_amount'];
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available");?></b></td>
        </tr>
    <?php endif; ?> 
</tbody>
<tfoot>
    <th colspan="6"></th>
    <th><?= lang("total"); ?></th>
    <th class="text-right"><?= $total; ?></th>
    <!-- <th></th> -->
    </tfoot>
</table>

<div class="clearfix"></div>

<!-- modal -->

<!-- modal -->

