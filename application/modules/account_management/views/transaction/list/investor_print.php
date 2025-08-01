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
.info{
    list-style: none;
    font-size: 13px;
    margin-left: 10px;

}
.info li{
    padding:3px;
}
.info li span{
    font-weight: bold;
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
                       <?php echo ($settings['shop_name']) ? '<h1>' . $store[0]['store_name'] . '</h1>' : ''; ?>
                        <ul>
                            <li><span class="bold">Address: </span><?= $store[0]['address_line'] ?></li>,
                            <li><span class="bold"><?php echo ($settings['phone']) ? 'Phone: ' . $store[0]['mobile'] : ''; ?></li>,
                            <li><span class="bold" style="width: 380px;"><?php echo ($settings['email']) ? 'Email: ' . $store[0]['email'] : ''; ?></li>
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
                        <h3>Transaction No: <?= $trx_no ?></h3>
                        <?php
                        $img = $this->barcode->code128BarCode($trx_no, 1);
                        ob_start();
                        imagepng($img);
                        $output_img = ob_get_clean();
                        echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
                        ?>
                        <br>
                        <span class="date-time">
                            <?= nice_datetime($dtt_trx) ?>
                        </span>
                    </div>
                    <div style="width: 35%; float: left;text-align: left;">
                        <ul class="info">
                            <li><span>Store:</span> <?= $store_name ?></li>
                            <li><span>Address:</span> <?= $address_line ?></li>
                            
                        </ul>
                    </div>
                    <div style="width: 35%; float: left;text-align: left;">
                        <ul class="info">
                            <li><span>Investor Name:</span> <?= $investor_name ?></li>
                            <li><span>Phone:</span> <?= $investor_phone ?></li>
                            <li><span>Paid By:</span> <?= $fullname ?></li>
                        </ul>
                    </div>
                </div>

                <br>
                <hr>
                <br>
                    <table id="products" border="1">
                        <thead>
                            <th class="fit"><?= lang("sl_no"); ?></th>
                            <th class=""><?= lang("trx_no"); ?></th>
                            <th class=""><?= lang("category"); ?></th>
                            <th class="right"><?= lang("amount"); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            //foreach ($trx_details as $item): ?>
                            <tr>
                                <td class="fit"><?php echo $count; ?>.</td>
                                <td class=""><?php echo $trx_no; ?></td>
                                <td class=""><?php echo get_key($qty_multipliers, $qty_multiplier); ?></td>
                                <td class="right"><?php echo comma_seperator($tot_amount); ?></td>
                            </tr><?php
                            $count++;
                           // endforeach;?>
                        </tbody>
                    </table>
                <?php //endif;?>
                <div class="table-break">
                    <div class="table-left">
                        <?php
                        $description='<div class="sales-person"><span class="bold">'.lang('description').'</span>:'. $description.'</div>';
                        echo  $description ;
                        ?>
                    </div>
                    <div class="table-right">
                        <table id="products" border="1">
                            <tr>
                                <td style="text-align: right"><span class="bold">Total</span></td>
                                <td style="text-align: right"><span class="bold"><?php echo comma_seperator($tot_amount);?></span></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><span class="bold"><?= lang('account'); ?></span></td>
                                <td style="text-align: right"><span class="bold"><?php echo $account_name;?></span></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><span class="bold"><?= lang('payment_method'); ?></span></td>
                                <td style="text-align: right"><span class="bold"><?php echo get_key($this->config->item('trx_payment_mehtods'), $payment_method_id);?></span></td>
                            </tr>
                            <?php if($payment_method_id==4):?>
                                <tr>
                                    <td style="text-align: right"><span class="bold"><?= lang('bank'); ?></span></td>
                                    <td style="text-align: right"><span class="bold"><?php echo get_key($general_banks, $ref_bank_id);?></span></td>
                                </tr>
                            <?php endif;?>

                            <?php if($payment_method_id==2):?>
                                <tr>
                                    <td style="text-align: right"><span class="bold"><?= lang('card'); ?></span></td>
                                    <td style="text-align: right"><span class="bold"><?php echo get_key($cards, $ref_card_id);?></span></td>
                                </tr>
                            <?php endif;?>
                            <?php if($payment_method_id==2 || $payment_method_id==3 || $payment_method_id==4):?>
                                    <tr>
                                    <td style="text-align: right"><span class="bold"><?= lang('account_card_no'); ?></span></td>
                                    <td style="text-align: right"><span class="bold"><?php echo !empty($ref_acc_no) ? $ref_acc_no : '';?></span></td>
                                </tr>
                            <?php endif;?>
                            <?php if($payment_method_id==2 || $payment_method_id==3):?>
                                <tr>
                                    <td style="text-align: right"><span class="bold"><?= lang('ref_trx_no'); ?></span></td>
                                    <td style="text-align: right"><span class="bold"><?php echo !empty($ref_trx_no) ? $ref_trx_no : '';?></span></td>
                                </tr>
                            <?php endif;?>
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
