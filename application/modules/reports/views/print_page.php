<?php  
         $company= $this->session->userdata['login_info']['store_id'];
         // $address= $this->session->userdata['login_info']['subscription_info'] ['address'];
         // $mobile= $this->session->userdata['login_info']['mobile'];
         $query=$this->commonmodel->store_details($company);
         $printed_by= $this->session->userdata['login_info']['fullname']; 
         // print_r($company);
?>
<style type="text/css">
    .report-header::after{
        content: "";
        display: table;
        clear: both;
        width:100%;
    }
    .heads{
        width: 33%;
        float: left;
    }
    .left {
    float:left;
    width:40%;
    }

    .center {
        display: inline-block;
        margin:0 auto;
        width:30%px;
    }

    .right {
        float:right;
        width:20%;
    }
    .text{
        font-size: 14px;
        font-weight: bold;
    }
    .heads:nth-child(2){
        text-align: center;
    }
    .heads:nth-child(3){
        text-align: right;
    }
    .hd-title{
        display: block;
        font-size: 18px;
        font-weight: bolder;
    }
</style>
<script src="<?= base_url() ?>themes/default/js/jquery.min.js"></script> 
<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<div class="row">
    <div class="col-md-12 col-sm-4">
        <button class="btn btn-primary pull-right" type="button" onclick="sale_print()"> Print</button>&nbsp;&nbsp;
    </div>
</div>


<page size="A4" id="print11">
    <div class="report-box">
        <div class="report-header">
            <?php $store_name = '';
            $mobile = '';
            $store_address = '';
            foreach ($query as $stores) {
                $store_name = $stores->store_name;
                $mobile = $stores->mobile;
                $email = $stores->email;
                $vat_reg_no = $stores->vat_reg_no;
                // print_r($stores);
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
                        <span class="text">VAT REG. No:<?php echo $vat_reg_no; ?></span><br>
                        <span class="text">
                            <?php echo $store_area . "," . $store_city; ?>
                        </span>
                    </td>
                    <td width="30%" style="text-align: center; line-height: normal;">
                        <?php
                        echo (isset($title))?'<h4>'.$title.'</h4>':'';
                        echo (isset($title_text))?$title_text:'';
                        if(isset($fdate) && isset($tdate)){
                            echo '<br><span class="text"> From: '.$fdate.' - To  '.$tdate.'</span>';
                        }?>
                    </td>
                    <td width="25%" style="text-align: right;">
                        <span class="text">Date:<?php echo date('d-m-Y'); ?></span>
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

 function sale_print() {
        $("#print11").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/report_print.css",
            iframe: false,
            noPrintSelector: ".avoid-this",
            // append : "Free jQuery Plugins!!!<br/>",
            // prepend : "<br/>jQueryScript.net!"
        });
        //$.print("#sale_view");
        // $('#SaleInvoiceDetails').modal('hide');
    }
    
</script>