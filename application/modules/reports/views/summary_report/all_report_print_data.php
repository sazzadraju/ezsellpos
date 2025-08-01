<style type="text/css">
    .print_div{width: 100%; overflow: hidden; }
    .half_width{ float: left;width: 48%; padding: 10px; }
    /*.print_div table{border:1px solid #000;}*/ 
</style>
<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/bootstrap.min.css">
<div class="print_div">
    <div class="half_width">
        <h4>Sales</h4>
        <table id="mytable" class="table table-bordered" border="1">
            <thead>
            <th class="text-center"><?= lang("serial"); ?></th>
            <th><?= lang("category"); ?></th>
            <th class="text-right"><?= lang("paid").' ('.set_currency().')'; ?></th>
            <th class="text-right"><?= lang("due").' ('.set_currency().')'; ?></th>
            <th class="text-right"><?= lang("total").' ('.set_currency().')'; ?></th>
            </thead>
            <tbody>
                <?php 
                $plus='<i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>';
                $misus='<i class="fa fa-minus-circle fa-lg" aria-hidden="true"></i>';
                $total=$paid=$due=$grand_total=0;
                $all_total=$all_paid=$all_due=$all_grand_total=0;
                $setData='?fdate='.$fdate.'&tdate='.$tdate.'&store='.$store;
                if($sales){
                    $total=$sales[0]['total_amount'];
                    $paid=$sales[0]['total_paid'];
                    $due=$sales[0]['total_due'];
                    $all_total+=$sales[0]['total_amount'];
                    $all_paid+=$sales[0]['total_paid'];
                    $all_due+=$sales[0]['total_due'];
                }
                ?>
                <tr>
                    <?php
                    echo '<td class="text-center">' . 1 . '</td>';
                    echo '<td>' . 'Sales' . '</td>';
                    echo '<td class="text-right">' . $paid . '</td>';
                    echo '<td class="text-right">' . $due . '</td>';
                    echo '<td class="text-right">' . $total . '</td>';
                    ?>
                </tr>
                <?php 
                $total=$paid=$due=$grand_total=0;
                if($saleReturns){
                    $total=$saleReturns[0]['total_amount'];
                    $paid=$saleReturns[0]['total_paid'];
                    $due=$saleReturns[0]['total_due'];
                    $all_total-=$saleReturns[0]['total_amount'];
                    $all_paid-=$saleReturns[0]['total_paid'];
                    $all_due-=$saleReturns[0]['total_due'];
                }
                ?>
                <tr>
                    <?php
                    echo '<td class="text-center">' . 2 . '</td>';
                    echo '<td>' . 'Sale Return' . '</td>';
                    echo '<td class="text-right">' . $paid . '</td>';
                    echo '<td class="text-right">' . $due . '</td>';
                    echo '<td class="text-right">' . $total . '</td>';
                    ?>
                </tr>
            </tbody>
            <tfoot>
            <th colspan="2" class="text-right"><?= lang("total"); ?></th>
            <th class="text-right"><?= $all_paid; ?></th>
            <th class="text-right"><?= $all_due; ?></th>
            <th class="text-right"><?= $all_total; ?></th>
            </tfoot>
        </table>
    </div>
    <div class="half_width">
        <h4>Supplier Payments</h4>
        <table id="mytable" class="table table-bordered">
            <thead>
            <th class="text-center"><?= lang("serial"); ?></th>
            <th><?= lang("type"); ?></th>
            <th width="5%"></th>
            <th class="text-right"><?= lang("total_amount").' ('.set_currency().')'; ?></th>
            </thead>
            <tbody>
                <?php 
                $total_supplier=0;
                $count=1;
                if($suppliers){
                    foreach ($suppliers as $value) {
                        $sign=($value['type_name']=='Refund Amount')?$plus:$misus;
                        echo '<tr>';
                        echo '<td class="text-center">' . $count . '</td>';
                        echo '<td>' . $value['type_name'] . '</td>';
                        echo '<td class="text-center">' . $sign . '</td>';
                        echo '<td class="text-right">' . $value['total_amount'] . '</td>';
                        echo '</tr>';
                        if($value['trx_mvt_type_id']==108){
                             $total_supplier+= $value['total_amount'];
                        }else{
                           $total_supplier-= $value['total_amount'];
                        }
                       $count++; 
                    }  
                } 
                ?>
            </tbody>
            <tfoot>
            <th colspan="3" class="text-right"><?= lang("total"); ?></th>
            <th class="text-right"><?= $total_supplier; ?></th>
            </tfoot>
        </table>
    </div>
</div>
<div class="print_div">
    <div class="half_width">
        <h4>Office Transactions</h4>
        <table id="mytable" class="table table-bordered">
            <thead>
            <th class="text-center"><?= lang("serial"); ?></th>
            <th><?= lang("type"); ?></th>
            <th width="5%"></th>
            <th class="text-right"><?= lang("total_amount").' ('.set_currency().')'; ?></th>
            </thead>
            <tbody>
                <?php 
                $total_office=0;
                $count=1;
                if($office){
                    foreach ($office as $value) {
                        $type=($value['qty_multiplier']==1)?'Income':'Expense';
                        $sign=($value['qty_multiplier']==1)?$plus:$misus;
                        echo '<tr>';
                        echo '<td class="text-center">' . $count . '</td>';
                        echo '<td>' . $type . '</td>';
                        echo '<td class="text-center">' . $sign . '</td>';
                        echo '<td class="text-right">' . $value['total_amount'] . '</td>';
                        echo '</tr>';
                        if($value['qty_multiplier']==1){
                             $total_office+= $value['total_amount'];
                        }else{
                           $total_office-= $value['total_amount'];
                        }
                        $count++;
                    }   
                }
                ?>
            </tbody>
            <tfoot>
            <th colspan="3" class="text-right"><?= lang("total"); ?></th>
            <th class="text-right"><?= $total_office; ?></th>
            </tfoot>
        </table>
    </div>
    <div class="half_width">
        <h4>Employee Transactions</h4>
        <table id="mytable" class="table table-bordered">
            <thead>
            <th class="text-center"><?= lang("serial"); ?></th>
            <th><?= lang("type"); ?></th>
            <th width="5%"></th>
            <th class="text-right"><?= lang("total_amount").' ('.set_currency().')'; ?></th>
            </thead>
            <tbody>
                <?php 
                $total_employee=0;
                $count=1;
                if($employees){
                    foreach ($employees as $value) {
                        $type=($value['qty_multiplier']==1)?'Return':'Payment';
                        $type=($value['qty_multiplier']==1)?'Return':'Payment';
                        $sign=($value['qty_multiplier']==1)?$plus:$misus;
                        echo '<tr>';
                        echo '<td class="text-center">' . $count . '</td>';
                        echo '<td>' . $type . '</td>';
                        echo '<td class="text-center">' . $sign . '</td>';
                        echo '<td class="text-right">' . $value['total_amount'] . '</td>';
                        echo '</tr>';
                        if($value['qty_multiplier']==1){
                             $total_employee+= $value['total_amount'];
                        }else{
                           $total_employee-= $value['total_amount'];
                        }
                        $count++;
                    }   
                }
                ?>
            </tbody>
            <tfoot>
            <th colspan="3" class="text-right"><?= lang("total"); ?></th>
            <th class="text-right"><?= $total_employee; ?></th>
            </tfoot>
        </table>
    </div>
</div>
<div class="print_div">
    <div class="half_width">
        <h4>Invertor Transactions</h4>
        <table id="mytable" class="table table-bordered">
            <thead>
            <th class="text-center"><?= lang("serial"); ?></th>
            <th><?= lang("type"); ?></th>
            <th width="5%"></th>
            <th class="text-right"><?= lang("total_amount").' ('.set_currency().')'; ?></th>
            </thead>
            <tbody>
                <?php 
                $total_investor=0;
                $count=1;
                if($investors){
                    foreach ($investors as $value) {
                        $sign='';
                        if($value['qty_multiplier']==1){$type='Invest';$sign=$plus;}
                        if($value['qty_multiplier']==-1){$type='Invest Withdraw';$sign=$misus;}
                        if($value['qty_multiplier']==0){$type='Profit Withdraw';$sign=$misus;}
                        //$type=($value['qty_multiplier']==1)?'Return':'Payment';
                        echo '<tr>';
                        echo '<td class="text-center">' . $count . '</td>';
                        echo '<td>' . $type . '</td>';
                        echo '<td class="text-center">' . $sign . '</td>';
                        echo '<td class="text-right">' . $value['total_amount'] . '</td>';
                        echo '</tr>';
                        if($value['qty_multiplier']==1){
                             $total_investor+= $value['total_amount'];
                        }else{
                           $total_investor-= $value['total_amount'];
                        }
                        $count++;
                    }   
                }
                ?>
            </tbody>
            <tfoot>
            <th colspan="3" class="text-right"><?= lang("total"); ?></th>
            <th class="text-right"><?= $total_investor; ?></th>
            </tfoot>
        </table>
    </div>
    <div class="half_width">
        <h4>Total Summary Report</h4>
        <table id="mytable" class="table table-bordered">
            <thead>
            <th class="text-center"><?= lang("serial"); ?></th>
            <th><?= lang("type"); ?></th>
            <th class="text-right">Total Balance<?= ' ('.set_currency().')'?></th>
            </thead>
            <tbody>
                <?php 
                echo '<tr>';
                echo '<td class="text-center">' . 1 . '</td>';
                echo '<td>' . 'Sales Transactions' . '</td>';
                echo '<td class="text-right">' . $all_paid . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td class="text-center">' . 2 . '</td>';
                echo '<td>' . 'Supplier Transactions' . '</td>';
                echo '<td class="text-right">' . $total_supplier . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td class="text-center">' . 3 . '</td>';
                echo '<td>' . 'Office Transactions' . '</td>';
                echo '<td class="text-right">' . $total_office . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td class="text-center">' . 4 . '</td>';
                echo '<td>' . 'Employee Transactions' . '</td>';
                echo '<td class="text-right">' . $total_employee . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td class="text-center">' . 5 . '</td>';
                echo '<td>' . 'Invertor Transactions' . '</td>';
                echo '<td class="text-right">' . $total_investor . '</td>';
                echo '</tr>';
                ?>
            </tbody>
            <tfoot>
            <th colspan="2" class="text-right"><?= lang("total"); ?></th>
            <th class="text-right"><?= ($all_paid+$total_supplier+$total_office+$total_employee+$total_investor); ?></th>
            </tfoot>
        </table>
    </div>
</div>


