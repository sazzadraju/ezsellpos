<!DOCTYPE html>
<html lang="en">

<head>
    <title>syntech invoice_content</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url().'themes/default/css/tailoring_order_invoice.css';?>">
</head>

<body>
    <page size="A4">

        <?php 
            // echo '<pre>';
            // print_r($aOrder);
            // echo '</pre>';
        ?>

        <div class="invoice-w">
            <div class="invoice-header">
                <div class="invoice-logo"><img alt="" src="<?php echo base_url().'themes/default/images/logo.png';?>"></div>
                <p>Invoice / Bill</p>
                <div class="header-left">
                    <table>
                        <tbody>
                            <tr>
                                <td>Name:</td>
                                <td><?php echo $customer_name[0]['full_name'];?></td>
                            </tr>
                            <!-- <tr>
                                <td>Address</td>
                                <td>House: #45, Road: #20, Mohakhali DOHS, Dhaka 1206.  
                                
                                </td>
                            </tr> -->
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
                                <td>Date:</td>
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
                                    </div>
                                </td>
                                
                                <td style="text-align:center"><?php echo $serFullDt['service_qty'];?></td>                                
                                <td style="text-align:center">TK <?php echo $serFullDt['service_price'];?></td>
                                <td style="text-align:center">TK <?php echo $serFullDt['service_qty']*$serFullDt['service_price'];?></td>
                            </tr>
                            <?php 
                                $totalSerPrice += ($serFullDt['service_qty']*$serFullDt['service_price']);
                                $i++; endforeach;
                            ?>
                            
                            <tr style="padding: text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top: 1px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top: 1px solid"><strong> Product price</strong></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top: 1px solid; text-align: center;"><strong> <?php echo $totalSerPrice;?></strong></td>
                            </tr>
                            <?php 
                            $billP = 0;
                            foreach($serFullDt['measerDesign']['bill'] as $aMeaserDesign):
                                if(!empty($aMeaserDesign['field_value'])):
                            ?>  

                            <tr style="padding: text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"><strong> <?php echo $aMeaserDesign['field_id'];?></strong></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px; border-top:0px solid; text-align: center;"><strong> <?php echo $aMeaserDesign['field_value'];?></strong></td>
                            </tr>

                            <?php 
                                $billP += $aMeaserDesign['field_value'];
                                endif; endforeach;
                            ?>

                            <tr style="padding: text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"><strong> Sub Total</strong></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid; text-align: center;"><strong> <?php echo ($totalSerPrice+$billP);?></strong></td>
                            </tr>

                            <tr style="padding: text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"><strong> Discount (<?php echo $aOrder[0]['discount_rate'];?> %)</strong></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid; text-align: center;"><strong> <?php echo $aOrder[0]['discount_amt'];?></strong></td>
                            </tr>

                            <tr style="padding: text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"><strong>Total Net Amount</strong>
                                </td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid; text-align: center;"><strong><?php echo $aOrder[0]['tot_amt'];?></strong></td>
                            </tr>
                            <tr style="padding: text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"><strong> Paid Amount</strong></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid; text-align: center;"><strong> <?php echo $aOrder[0]['paid_amt'];?></strong></td>
                            </tr>
                            <tr style="padding: text-align:center">
                                <td colspan="3" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid"><strong> Due Amount</strong></td>
                                <td colspan="1" style="font-weight: 600;padding:3px 3px;   border-top:0px solid; text-align: center;"><strong> <?php echo $aOrder[0]['due_amt'];?></strong></td>
                            </tr>

                        </tbody>

                    </table>
                  
                </div>
            </div>
         
        </div>
           <div class="invoice-footer">
                 <div class="terms"> 
                        <div class="terms-content">Thank you for shopping at primary store...</div>
                        <div><?php echo $store_info[0]['address_line'];?>  Mob : <?php echo $store_info[0]['mobile'];?> Email: <?php echo $store_info[0]['email'];?></div>
                    </div> 
                <div class="devt-by"><span>Software Developed By:</span><strong> www.syntechbd.com</strong></div>
            </div>
    </page>

    

</body>

</html>