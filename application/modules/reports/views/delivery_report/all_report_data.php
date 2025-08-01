<table id="mytable" class="table table-bordred table-striped">
    <thead>
        <th><?= lang("date"); ?></th>
    <th><?= lang("invoice_no"); ?></th>
    <th><?= lang("delivery_type"); ?></th>
    <th><?= lang("agent_name"); ?></th>
    <th><?= lang("reference_number"); ?></th>
    <th><?= lang("customer_info"); ?></th>
    <th><?= lang("note"); ?></th>
    <th><?= lang("invoice_amount"); ?></th>
    <th><?= lang("invoice_paid"); ?></th>
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
        $total_sale_amt=0;
        $total_sale_paid=0;
        $total_amt=0;
        $total_paid=0;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                $val='';
                 echo '<td>' . nice_date($post['dtt_add']) . '</td>';
                echo '<td>' . $post['invoice_no'] . '</td>';
                $ttt=($post['type_id']==2)?'Agent':'Staf';
                echo '<td>' .$ttt.' ('. $post['delivery_name'] .')'. '</td>';
                $person=($post['type_id']==2)?$post['agent_name']:'Self';
                echo '<td>' . $person . '</td>';
                echo '<td>' . $post['reference_num'] . '</td>';
                echo '<td>' . $post['customer_code'].' '.$post['customer_name'] .'<br>('.$post['customer_phone']. ')</td>';
                echo '<td class="center">' . $post['notes'] . '</td>';
                echo '<td class="center">' . $post['sale_amt'] . '</td>';
                echo '<td class="center">' . $post['sale_paid'] . '</td>';
                echo '<td class="center">' . $post['tot_amt'] . '</td>';
                echo '<td class="center">' . $post['paid_amt'] . '</td>';
                $order_status=$this->config->item('order_status');
                echo '<td>' . $order_status[$post['order_status']] . '</td>';
                echo '<td>' . '<button class="btn btn-primary" onclick="print_view('.$post['sale_id'].')">'.'<span class="glyphicon glyphicon-print"></span>'.'</button>'. '</td>';
            
                ?>
            </tr>
            <?php
            $total_sale_amt+=$post['sale_amt'];
            $total_sale_paid+=$post['sale_paid'];
            $total_amt+=$post['tot_amt'];
            $total_paid+=$post['paid_amt'];
            $count++;
        endforeach;
        ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" class="text-right">Total</th>
                <th class="center"><?= $total_sale_amt?></th>
                <th class="center"><?= $total_sale_paid?></th>
                <th class="center"><?= $total_amt?></th>
                <th class="center"><?= $total_paid?></th>
            </tr>
        </tfoot>
        <?php 
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
        </tr>
    <?php endif; ?>
    
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
<div id="SaleInvoiceDetails" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0">Delivery Order Details</h6>
            </div>
            <div class="modal-body">
                <div class="sale-view invoice_content" id="sale_view">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="sale_print()">Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function print_view(id) {
    $('#sale_view').html('');
    $.ajax({
        type: "GET",
        url: URL+'delivery-orders/print-view/'+id,
        async: false,
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (data) {
            $('.loading').fadeOut("slow");
            console.log(data);
            alert(data);
            $('#sale_view').html(data);
            $('#SaleInvoiceDetails').modal('toggle');
        }
    });
}
</script>

