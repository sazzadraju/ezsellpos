<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("serial"); ?></th>
    <th><?= lang("date"); ?></th>
    <th><?= lang("invoice_no"); ?></th>
    <th><?= lang("delivery_type"); ?></th>
    <th><?= lang("agent_name"); ?></th>
    <th><?= lang("reference_number"); ?></th>
    <th><?= lang("customer_name"); ?></th>
    <th><?= lang("customer_phone"); ?></th>
    <th class="center"><?= lang("service_price"); ?></th>
    <th class="center"><?= lang("paid_amount"); ?></th>
    <th class="center"><?= lang("status"); ?></th>
    <th class="center" colspan="3"><?= lang("action"); ?></th>

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
                echo '<td>' . ($offset+$count) . '</td>';
                echo '<td>' . nice_date($post['dtt_add']) . '</td>';
                echo '<td>' . $post['invoice_no'] . '</td>';
                $ttt=($post['type_id']==2)?'Agent':'Staf';
                echo '<td>' .$ttt.' ('. $post['delivery_name'] .')'. '</td>';
                $person=($post['type_id']==2)?$post['agent_name']:'Self';
                echo '<td>' . $person . '</td>';
                echo '<td>' . $post['reference_num'] . '</td>';
                echo '<td>' . $post['customer_name'] . '</td>';
                echo '<td>' . $post['customer_phone'] . '</td>';
                echo '<td class="center">' . $post['tot_amt'] . '</td>';
                echo '<td class="center">' . $post['paid_amt'] . '</td>';
                $order_status=$this->config->item('order_status');
                echo '<td>' . $order_status[$post['order_status']] . '</td>';
                if($post['order_status']!=4){
                    echo '<td>' . '<a href="'.base_url().'delivery-details/'.$post['sale_id'].'" class="btn btn-primary" >'.'<span class="glyphicon glyphicon-eye-open"></span>'.'</a>'. '</td>';
                echo '<td>' . '<a href="'.base_url().'delivery-orders/return/'.$post['sale_id'].'" class="btn btn-primary" >'.'Return'.'</a>'. '</td>';
            }else{
                echo '<td colspan="2">&nbsp;</td>';
            }
                
                 echo '<td>' . '<button class="btn btn-primary" onclick="print_view('.$post['sale_id'].')">'.'<span class="glyphicon glyphicon-print"></span>'.'</button>'. '</td>';
            
                ?>
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

