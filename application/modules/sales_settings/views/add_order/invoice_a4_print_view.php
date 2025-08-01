<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/a4_print_new.css">
<style type="text/css">
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
h1{
    font-size: 38px;
}
body {
    background: #eee;
    font-family: 'Roboto', sans-serif;
    font-size: 12px;
}

.container {
    max-width: 870px;
    width: 100%;
    margin: 0 auto;
    padding: 0px 15px;
}

.invoice {
    width: 100%;
    background: #fff;
    padding: 15px;
    box-shadow: 0px 0px 3px #aaa;
    margin: 15px 0px;
}

header {
    width: 100%;
    background: ;
    background: ;
}

header::after {
    content: '';
    display: table;
    clear: both;
}

/*logo*/
.brand-inf {
    width: 30%;
    float: left;
}

.in-logo {
    width: 100%;
    float: left;
    height: 70px;
}

.in-logo img {
    height: 100%;
    padding-top: 10px;
}

.in-no {
    width: 80%;
    float: right;
    padding: 0px 10px;
    text-align: right;
}

.from-inf img {
    width: 50%;
}


/*in-from-to*/
.in-from-to {
    width: 100%;
}

.in-from-to::after {
    content: '';
    display: table;
    clear: both;
}

.from-inf {
    width: 50%;
    float: left;
}

.in-no ul {
    margin: 0;
    padding: 0;
}

.in-no ul li {
    list-style: none;
    display: inline-block;
}



.from-inf {
    width: 30%;
    float: left;
}

.to-inf {
    width: 70%;
    float: right;
    text-align: right;
}

.to-inf ul {
    margin: 0;
    padding: 0;
    padding-top: 10px;
}

.to-inf ul li {
    list-style: none;
    line-height: 2px;
}

/*table*/

#products {
    border-collapse: collapse;
    width: 100%;
}
#products::after{
    content: "";
    display: table;
    clear: both;
}
#products td,
#products th {
    border: 1px solid #ddd;
    padding: 8px;
    font-weight: 500;
    font-size: 14px;
}
#products th{
    text-align: center;
    font-weight: bolder;
    background: red;
}

#products tr:nth-child(even) {
    background-color: #f2f2f2;
}

#products tr:hover {
    background-color: #ddd;
}

#products th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: darkslategrey;
    color: white;
}

.bold {
    font-weight: bold;
    width: 130px;
    display: inline-block;
}


.table-break{
    width: 100%;
}
.table-break::after{
    content: "";
    display: table;
    clear: both;
}
.table-left{
    width: 50%;
    float: left;
}

.sales-person{
    width: 100%;
    padding: 10px 10px;
    border-left:1px solid #eee;
}
.comment{
    width: 100%;
    padding: 10px 10px;
    border: 1px solid #eee;
}
.delivery-details{
    width: 100%;
    padding: 10px 10px;
    border: 1px solid #eee;
    line-height: 16px;
}
.delivery-details h3{
    padding: 2px 0px;
}
.table-right{
    width: 50%;
    float: right;
}
/*signature*/

.signature {
    width: 100%;
    padding: 90px 0px 20px 0px;
}

.signature::after {
    content: "";
    display: table;
    clear: both;
}

.auth-sig {
    width: 30%;
    float: left;
}


.cust-sig {
    width: 50%;
    float: right;
    text-align: right;
}

.invoice{
    padding: 0 10px;
}

.right{
    text-align: right;
}

.left{
    text-align: left;
}

.center{
    text-align: center;
}
</style>
<page size="A4">
    <section class="invoice-sec">
        <div class="container">
            <div class="invoice">

                <header style="padding-top: 50px">
                 <?php if($settings['header']) { ?>
                    <div class="brand-inf">
                        <div class="in-logo">
                                <?php
                                 if ($this->session->userdata['login_info']['store_img'] != '' && $settings['shop_logo']) {
                                  echo '<img src="' . documentLink('user') . $this->session->userdata['login_info']['store_img'] . '" alt="">';
                                 }
                                ?>
                        </div>
                    </div>
                    <div class="in-no">
                       <?php echo ($settings['shop_name']) ? '<h1>' . $invoices[0]['store_name'] . '</h1>' : ''; ?>
                        <ul>
                            <li><span class="bold">Address: </span><?= $invoices[0]['address_line'] ?></li>,
                            <li><span class="bold"><?php echo ($settings['phone']) ? 'Phone: ' . $invoices[0]['mobile'] : ''; ?></li>,
                            <li><span class="bold" style="width: 380px;"><?php echo ($settings['email']) ? 'Email: ' . $invoices[0]['email'] : ''; ?></li>
                        </ul>
                    </div>
               <?php
               }else{
                 echo '<div style="height:'.$settings['head_size'].'px;"></div>';
               }
               ?>
                </header>
                <br>
                <hr>
                <br>

                <div class="in-from-to">
                    <div class="from-inf">
                        <h3>Invoice No: <?= $invoices[0]['invoice_no'] ?></h3>
                        <?php
                        $img = $this->barcode->code128BarCode($invoices[0]['invoice_no'], 1);
                        ob_start();
                        imagepng($img);
                        $output_img = ob_get_clean();
                        echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
                        ?>
                        <br>
                        <span class="date-time">
                            <?= nice_datetime($invoices[0]['dtt_add']) ?>
                        </span>
                    </div>
                    <div class="to-inf">
                        <ul>
                            <li><span class="bold">ID:</span> <?= $invoices[0]['customer_code'] ?></li>,
                            <li><span class="bold">Name:</span> <?= $invoices[0]['customer_name'] ?></li>,
                            <li><span class="bold"><i class="fas fa-mobile"></i> :</span> <?= $invoices[0]['customer_mobile'] ?></li>
                        </ul>
                    </div>
                </div>


                <hr>
                <table id="products" border="1">
                    <tr>
                        <th style="text-align:center; font-weight: bold;"><?= lang('product') ?></th>
                        <th style="text-align:center; font-weight: bold;"><?= lang('details') ?></th>
                        <th style="text-align:center; font-weight: bold;"><?= lang('unit_price') ?></th>
                        <th style="text-align:center; font-weight: bold;"><?= lang('qty') ?></th>
                        <th style="text-align:center; font-weight: bold;"><?= lang('dis') ?></th>
                        <th style="text-align:center; font-weight: bold;"><?= lang('vat') ?></th>
                        <th style="text-align:center; font-weight: bold;"><?= lang('price') ?></th>
                    </tr>
                    <?php
                    $i = 1;
                    $sum = 0;
                    $qty_sum = 0;
                    $total_sum = 0;
                    $discount = 0;
                    $paid_amount = 0;
                    $vat = 0;
                    $product_amt = 0;
                    $count_pro=array();
                    if (!empty($products)) {
                        foreach ($products as $row) {
                            if(!in_array($row['product_id'],$count_pro)){
                                $count_pro[]=$row['product_id'];
                            }
                            $discount = $row['discount_amt'];
                            $qty_sum += $row['qty'];
                            $vat += $row['vat_amt'];
                            $product_amt += $row['total_price'];
                            $code=($settings['code'])?'<span> ('.$row['product_code'].')</span>':'';
                            ?>
                            <tr>
                                <td><?php echo $code. '<span>' . $row['product_name'] . '</span>'; ?></td>
                                <?php
                                echo '<td>';
                                if($settings['brand']){
                                    echo 'Brand:'. $row['brand_name'].', ';
                                }
                                echo 'Cat:'. $row['cat_name'];
                                echo ($settings['sub_cat'])?'/'. $row['sub_cat_name']:'';
                                echo '</td>';
                                ?>
                                <td style="text-align: right"><?php echo $row['unit_price']; ?></td>
                                <td style="text-align: right"><?php echo $row['qty']; ?></td>
                                <td style="text-align: right"><?php echo $row['discount_amt']; ?></td>
                                <td style="text-align: right"><?php echo $row['vat_amt']; ?></td>
                                <td style="text-align: right"><?php echo $row['total_price']; ?></td>
                            </tr>
                            <?php $i++;
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="3"><span class="bold"><?= count($count_pro)?> Items</span></td>
                        <td style="text-align: right"><?= $qty_sum ?></td>
                        <td style="text-align: right" colspan="2"><?= $vat ?></td>
                        <td style="text-align: right"><?= $product_amt ?></td>
                    </tr>
                </table>
                <div class="table-break">
                    <div class="table-left">
                        <?php
                        $div='<div class="sales-person"><span class="bold">Note</span>:'.$settings['note'].'</div>';
                       // echo ($settings['note_type']=='yes') ? $div : '';
                        $comments='<div class="sales-person"><span class="bold">Note</span>:'. $invoices[0]['notes'].'</div>';
                        $sales_person='<div class="sales-person"><span class="bold">Sales Person</span>:'. $sales_person_name.'</div>';
                        echo ($invoices[0]['notes']!='') ? $comments : '';
                        echo ($sales_person_name)?$sales_person:'';
                        $dalivery_total=0;$dalivery_paid=0;  
                        ?>
                    </div>
                    <div class="table-right">
                        <table id="products" border="1">
                            <tr>
                                <td style="text-align: right"><span class="bold">Sub Total</span></td>
                                <td style="text-align: right"><span class="bold"><?php echo $product_amt ?></span></td>
                            </tr>
                            <?php
                                $all_dis = 0;
                                $total=$product_amt;
                                $g_total=$total;
                                ?>
                                <tr>
                                    <td style="text-align: right"><span class="bold">Total</span></td>
                                    <td style="text-align: right"><span class="bold"><?php echo $total; ?></span></td>
                                </tr>
                                <!-- Pay Type-->
                                <?php
                                $all_paid_amt = 0;
                                $method = $this->config->item('trx_payment_methods');
                                foreach ($transactions as $transaction) {
                                    $type = $transaction['payment_method_id'];
                                    echo '<tr><td style="text-align: right">' . nice_date($transaction['dtt_add']) . '<span>[' . $method[$type] . ']</span></td><td style="text-align: right" >' . $transaction['amount'] . '</td></tr>';
                                    $all_paid_amt += $transaction['amount'];
                                }
                                $remit=0;
                                
                                $g_total_paid=$all_paid_amt + $dalivery_paid+$remit;
                                ?>
                                <tr>
                                    <td style="text-align: right">
                                        <span class="bold">Total Paid Amount</span>
                                    </td>
                                    <td style="text-align: right"> <span class="bold"><?= $g_total_paid ?></span></td>
                                </tr>
                                <?php
                                $due_amt=$g_total-$g_total_paid;
                                ?>
                                <tr>
                                    <td style="text-align: right"><span class="bold">[Due Amount]</span></td>
                                    <td style="text-align: right"><span class="bold"><?= round($due_amt, 2) ?></span></td>
                                </tr>

                        </table>
                    </div>
                </div> 
                               
                <div class="signature">
                    <div class="cust-sig">
                        <h4>Authorised Signature:</h4>
                        <span>Copy of Original<br>Printed: <?= nice_datetime(date('Y-m-d H:i:s'))?></span>
                    </div>
                    <div class="auth-sig">
                        <h4>Customer Signature:</h4>
                        <span>Software Developed By: www.ezellbd.com</span>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</page>


<script>
    function sale_a4_print() {
        $("#sale_print").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/a4_print_new.css",
            iframe: false,
            noPrintSelector: ".avoid-this",
            // append : "Free jQuery Plugins!!!<br/>",
            // prepend : "<br/>jQueryScript.net!"
        });
        //$.print("#sale_view");
        $('#SaleInvoiceA4Details').modal('hide');
    }
</script>
