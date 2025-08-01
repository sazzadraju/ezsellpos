<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tailoring Order Invoice</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url().'themes/default/css/tailoring_order_invoice.css';?>">
    <style type="text/css">

    </style>
</head>

<body>
    <page size="A4">
        <div class="invoice-w">
            <div class="invoice-header">
                <div class="invoice-logo" ><h1><?php echo $store_info[0]['store_name'];?></h1></div>

                <div class="in-head">
                    <div class="in-head-con"><div class="hidden">this is hidden</div> </div>
                    <div class="in-head-con">
                        <span class="head-text">Invoice / Bill</span>
                    </div>
                    <div class="in-head-con">
                        <span class="time-date">Date: <?= date('Y-m-d H:i:s')?></span>
                    </div>
                </div>


                <div class="header-left">
                    <table>
                        <tbody>
                            <tr>
                                <td>Name:</td>
                                <td><?php echo $customer_name[0]['full_name'];?></td>
                            </tr>
                            <tr>
                                <td>E-mail:</td>
                                <td><?php echo $customer_info[0]['email'];?></td>
                            </tr>
                            <tr>
                                <td>Mobile:</td>
                                <td><?php echo $customer_info[0]['phone'];?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="header-left header-right">
                    <table>
                        <tbody>
                            <tr>
                                <td>Care By:</td>
                                <td><?php echo $sellerName;?></td>
                            </tr>
                            <tr>
                                <td>Receipt No: </td>
                                <td><?php echo $aOrder[0]['receipt_no'];?></td>
                            </tr>
                            <tr>
                                <td>Order Date:</td>
                                <td><?php echo $aOrder[0]['order_date'];?></td>
                            </tr>
                            <tr>
                                <td>Delivery Date:</td>
                                <td><?php echo $aOrder[0]['order_date'];?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="invoice-body">
                <div class="invoice-table">
                    <table class="table" border="1">
                        <thead>
                            <tr>
                                <th>SL #</th>
                                <th>Product Info</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Amount in TK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalSerPrice = 0; $i=1; foreach($serFullDt as $serFullDt):?>
                            <tr>
                                <td style="font-weight: 600;text-align:center"><?php echo $i;?></td>
                                
                                <td style="width:30%;width: 50%;padding: 20px 4px;">
                                    <div class="prdc-info">

                                        <p><strong>Service Name:</strong>  <?php echo $serFullDt['service_name'];?></p>
                                        

                                        <div class="prdc">
                                            <?php 
                                                foreach($serFullDt['measerDesign']['measure'] as $aMeaserDesign):

                                                    if($i == $aMeaserDesign['service_identify']):

                                            ?>      
                                                    <strong><?php echo $aMeaserDesign['field_id'];?>:</strong> <?php echo $aMeaserDesign['field_value'].', ';?>  
                                                    
                                            <?php endif; endforeach;?>

                                        </div>
                                        <div><?php echo 'Note: '.$serFullDt['notes']?></div>
                                    </div>
                                </td>
                                
                                <td style="text-align:center"><?php echo $serFullDt['service_qty'];?></td>                                
                                <td style="text-align:center">TK <?php echo $serFullDt['service_price'];?></td>
                                <td style="text-align:right"><?php echo $serFullDt['service_qty']*$serFullDt['service_price'];?> TK </td>
                            </tr>
                            <?php 
                                $totalSerPrice += ($serFullDt['service_qty']*$serFullDt['service_price']);
                                $i++; endforeach;
                            ?>
                            
                            <tr style="text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top: 1px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top: 1px solid">Product price</td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top: 1px solid; text-align: right;"><?php echo $totalSerPrice;?> TK </td>
                            </tr>
                            <?php 
                            $billP = 0;
                            foreach($serFullDt['measerDesign']['bill'] as $aMeaserDesign):
                                if(!empty($aMeaserDesign['field_value'])):
                            ?>  

                            <tr style="text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"><?php echo $aMeaserDesign['field_id'];?></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px; border-top:0px solid; text-align: right;"><?php echo $aMeaserDesign['field_value'];?> TK </td>
                            </tr>

                            <?php 
                                $billP += $aMeaserDesign['field_value'];
                                endif; endforeach;
                            ?>

                            <tr style="text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid">Sub Total</td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid; text-align: right;"><?php echo ($totalSerPrice+$billP);?> TK </td>
                            </tr>

                            <tr style="text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid">Discount (<?php echo $aOrder[0]['discount_rate'];?> %)</td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid; text-align: right;"><?php echo $aOrder[0]['discount_amt'];?> TK </td>
                            </tr>

                            <tr style="text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"><strong>Net Amount</strong>
                                </td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid; text-align: right;"><strong><?php echo $aOrder[0]['tot_amt'];?> TK </strong></td>
                            </tr>
                            <tr style="text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:1px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:1px solid"><strong>Pay Type</strong>
                                </td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:1px solid; text-align: right;"><strong>Amount</strong></td>
                            </tr>
                            <?php 
                                $paymentMethod = array(1 => 'Cash', 2 => 'Card', 3 => 'Mobile Account', 4 => 'Check');
                                if(!empty($transactions)):
                                foreach ($transactions as $aTransaction): 
                                    if(!empty($aTransaction['payment_method_id']) && !empty($aTransaction['amount'])):
                            ?>
                                <tr style="text-align:center">
                                    <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                    <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"><?php echo '( '.nice_date($aTransaction['dtt_add']).') '.$paymentMethod[$aTransaction['payment_method_id']];?>
                                    </td>
                                    <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid; text-align: right;"><?php echo $aTransaction['amount'];?> TK </td>
                                </tr>
                            <?php endif;endforeach;endif;?>
                            <tr style="text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"><strong>Total Paid Amount</strong></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid; text-align: right;"><strong> <?php echo $aOrder[0]['paid_amt'];?> TK </strong></td>
                            </tr>
                            <tr style="text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:1px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:1px solid"><strong> Due Amount</strong></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:1px solid; text-align: right;"><strong> <?php echo $aOrder[0]['due_amt'];?> TK </strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
         
        </div>
           <div class="invoice-footer">
                 <div class="terms">
                        <div><?php echo $store_info[0]['address_line'];?>  Mob : <?php echo $store_info[0]['mobile'];?> Email: <?php echo $store_info[0]['email'];?></div>
                    </div> 
                <div class="devt-by"><span>Software Developed By:</span><strong> www.ezsellbd.com</strong></div>
            </div>
    </page>

    

</body>

</html>