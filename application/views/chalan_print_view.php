<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/a4_print.css">
<page size="A4">
    <div class="invoice-w">
        <div class="infos">
            <div class="info-1">
                <div class="company-name"><?= $invoices[0]['store_name'] ?></div>
                <div class="company-address">Address: <?= $invoices[0]['address_line'] ?></div>
                <div class="company-extra">Phone: <?= $invoices[0]['mobile'] ?></div>
                <div class="company-extra">Email: <?= $invoices[0]['email'] ?></div>
            </div>
            <div class="info-1-logo">
                <?php
                if ($this->session->userdata['login_info']['store_img'] != '') {
                    echo '<img src="' . documentLink('user') . $this->session->userdata['login_info']['store_img'] . '" alt="">';
                }
                ?>
            </div>
            <div class="info-2">
                <h3 style="margin-top:16px;font-size:20px;padding:5px;width: 100%; text-align: center; text-decoration: underline">Chalan</h3>
                <div class="invoice-heading">
                    <p style="font-size: 15px;margin: 0;"><strong style="width: 66px;display: block;float: left;">Invoice:</strong> <?= $invoices[0]['invoice_no'] ?></p>
                    <p style="margin: 0;"><strong style="width: 66px;display: block;float: left;">Code:</strong> <?= $invoices[0]['customer_code'] ?></p>
                    <p style="margin: 0;"><strong style="width: 66px;display: block;float: left;">Name:</strong> <?= $invoices[0]['customer_name'] ?></p>
                    <p style="margin: 0;"><strong style="width: 66px;display: block;float: left;">Phone:</strong> <?= $invoices[0]['customer_mobile'] ?></p>
                    <p style="margin: 0;"><strong style="width: 66px;display: block;float: left;">Address:</strong> <?= $customer_address ?></p>
                </div>
                <div class="invoice-no">&nbsp;</div>
                <div class="customer-details" style="float: right">
                    <div class="invoice-date"><strong>Date: </strong><?= nice_datetime($invoices[0]['dtt_add']) ?></div>
                </div>
            </div>
        </div>
        <div>

        </div>
        <style>
            td, th{
                border-top: 1px solid #ccc !important;
                border-bottom: 1px solid #ccc !important;
                border: 1px solid #000;
                vertical-align: middle !important;
            }
            tfoot td{
                border: 0px !important;
            }
            tfoot th{
                border: 0px !important;
            }
        </style>
        <div class="invoice-body">
            <div class="invoice-table" style="width: 90%;margin: 0 auto;">
                <table class="table">
                    <tr>
                        <th class="text-center" style="width: 10%;border-top: 1px solid #000 !important;border-bottom: 1px solid #000 !important;padding: 5px;">S/L</th>
                        <th class="text-left" style="width:60%;border-top: 1px solid #000 !important;border-bottom: 1px solid #000 !important;padding: 5px;">Product</th>
                         <th class="text-left" style="width:60%;border-top: 1px solid #000 !important;border-bottom: 1px solid #000 !important;padding: 5px;">Details</th>
                        <th class="text-center" style="width: 10%;border-top: 1px solid #000 !important;border-bottom: 1px solid #000 !important;padding: 5px;"><?= lang('qty') ?></th>
                        <th class="text-center" style="width: 20%;border-top: 1px solid #000 !important;border-bottom: 1px solid #000 !important;padding: 5px;">Remarks</th>
                    </tr>
                    <tbody>
                        <?= $post_data?>
                    </tbody>
                </table>
            </div>
        </div>
        <table style="width: 100%">
            <tfoot>
            <!-- Signature-->
            <tr>
                <td colspan="0" style="border: 0px !important;"><span
                        style="color: #666;display: inline-block;font-weight: bold;border-bottom: 1px solid;">Authorised Signature:</span>
                </td>
                <td class="text-right" colspan="0" style="border: 0px !important;"><span
                        style="color: #666;display: inline-block;font-weight: bold;border-bottom: 1px solid;">Customer Signature:</span>
                </td>
            </tr>
            <!-- Footer-->
            <tr>
                <td colspan="0">
                    <span style="color: #666;margin-top: 20px;display: block;">Printed: <?= nice_datetime(date('Y-m-d H:i:s'))?></span>
                </td>
                <td class="text-right" colspan="6"><span style="color: #666;margin-top: 20px;display: block;">Software Developed By: www.ezsellbd.com</span>
                </td>
            </tr>
            </tfoot>
        </table>

    </div>
</page>


<script>
    function sale_a4_print() {
        $("#sale_print").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/a4_print.css",
            iframe: false,
            noPrintSelector: ".avoid-this",
            // append : "Free jQuery Plugins!!!<br/>",
            // prepend : "<br/>jQueryScript.net!"
        });
        //$.print("#sale_view");
        $('#SaleInvoiceA4Details').modal('hide');
    }
</script>
