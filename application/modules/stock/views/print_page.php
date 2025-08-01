<?php
$company = $this->session->userdata['login_info']['store_id'];
// $address= $this->session->userdata['login_info']['subscription_info'] ['address'];
// $mobile= $this->session->userdata['login_info']['mobile'];
$query = $this->commonmodel->store_details($company);
$printed_by = $this->session->userdata['login_info']['fullname'];
// print_r($company);
?>
<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<div class="row">
    <div class="col-md-12 col-sm-4">
    </div>
</div>
<page size="A4" id="stock_print">
    <div class="report-box">

        <div class="report-header">
            
                <?php $store_name = '';
                $mobile = '';
                $store_address = '';
                foreach ($query as $stores) {
                    $store_name = $stores->store_name;
                    $mobile = $stores->mobile;
                    $email = $stores->email;
                    if (!empty($stores->city_id)) {
                        $store_area = $stores->area_name_en;
                        $store_city = $stores->city_name_en;
                    } else {
                        $store_area = $stores->district_name_en;
                        $store_city = $stores->division_name_en;
                    }
                } ?>
            <table>
                <tr>
                    <td width="40%" style="line-height: normal;">
                        <span style="font-weight: bold;font-size: 20px;"><?php echo $store_name; ?></span><br>
                        <span class="text">Mobile:<?php echo $mobile; ?></span><br>
                        <span class="text">Email:<?php echo $email; ?></span><br>
                        <span class="text">
                            <?php echo $store_area . "," . $store_city; ?>
                        </span>
                    </td>
                    <td width="30%" style="text-align: center; line-height: normal;">
                        <?php
                        echo (isset($head))?'<h4>'.$head['title'].'</h4>':'';
                        if(isset($head)){
                            echo '<br><span class="text">Invoice: '. $head['invoice_no'].'</span>';
                        }?>
                    </td>
                    <td width="25%" style="text-align: right;">
                        <span class="text">Date:<?php
                        $date = date('Y-m-d', strtotime($head['date']));
                        echo $date; ?></span>
                    </td>
                </tr>

            </table>
        </div>

        <?php echo $report; ?>

    </div>
</page>
<!-- </body>

</html>
 -->
<script>

    function print_data() {
        $("#stock_print").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/a4_print.css",
            iframe: false,
            noPrintSelector: ".avoid-this",
            // append : "Free jQuery Plugins!!!<br/>",
            // prepend : "<br/>jQueryScript.net!"
        });
        //$.print("#sale_view");
        // $('#SaleInvoiceDetails').modal('hide');
    }
    function sale_print() {
        $('#stock_print').css('display', 'block');
        $("#stock_print").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/report_print.css",
            iframe: false,
            noPrintSelector: ".avoid-this",
            // append : "Free jQuery Plugins!!!<br/>",
            // prepend : "<br/>jQueryScript.net!"
        });
        //$.print("#sale_view");
        $('#stock_print').css('display', 'none');
         $('#stockDetailsData').modal('hide');
    }
</script>