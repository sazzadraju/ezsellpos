<div class="col-md-5">

    <div class="billing-des">
        <strong class="text-label">Order Details</strong>
        <p><strong>Customer Name:</strong>
            <?php echo $aOrder['customerName'][0]['full_name']; ?>
        </p>
        <p><strong>Receipt No:</strong>
            <?php echo $aOrder['receiptNo']; ?>
        </p>
        <p><strong>Order date:</strong>
            <?php echo $aOrder['orderDate']; ?>
        </p>
        <p><strong>Delivery Date:</strong>
            <?php echo $aOrder['deliveryDate']; ?>
        </p>
    </div>
</div>
<div class="col-md-7">
    <div class="billing-des">
        <strong class="text-label">Order Description</strong>
        <span><?php echo $aOrder['description']; ?>!</span>
    </div>
</div>


<div class="col-md-12">

    <div class="table-responsive bg service-list-table">

        <h3 class="element-header">Service List</h3>
        <table id="mytable" class="table table-bordred table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Service Name</th>
                <th>Note</th>
                <th>Measerments</th>
                <th>Design</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            <?php $tSerP = 0;
            $i = 0;
            foreach ($allServices as $aService): ?>
                <tr>
                    <td>
                        <?php echo($i + 1); ?>
                    </td>
                    <td>
                        <?php echo $aService['serName']; ?>
                    </td>
                    <td>
                        <?php echo $aService['sNote']; ?>
                    </td>
                    <td>
                        <?php
                        $vi = 0;
                        foreach ($aService['mFieldsId'] as $fName) {
                            echo $fName . ': ' . $aService['mFields'][$vi] . '<br>';

                            $vi++;
                        };
                        ?>
                    </td>
                    <td>
                        <?php
                        foreach ($aService['sDesignId'] as $fVal) {
                            if ($fVal != NULL) {
                                echo '<img src="' . documentLink('tailoring') . $fVal . '"width="40">';
                            }
                        };
                        ?>
                    </td>

                    <td>
                        <?php echo $aService['pQuantity']; ?>
                    </td>
                    <td>
                        <?php echo $aService['serPrice']; ?>
                    </td>

                </tr>
                <?php
                $tSerP += ($aService['pQuantity'] * $aService['serPrice']);
                $i++; endforeach;
            ?>
            </tbody>
        </table>
    </div>
</div>


<div class="col-md-6">

    <?php
    // echo '<pre>';
    // print_r($aOrder);
    // echo '</pre>';
    ?>

</div>

<div class="col-md-6">
    <div class="billing-des billing-des-fix-top border-top-0">
        <p class="ttl-amnt padding-right-15 padding-left-15 margin-top--25"><strong class="ttl-amnt ">Total:</strong>
            <?php echo $tSerP; ?>
        </p>
        <strong class="text-label">Billing Type </strong>
        <div class="bill-group">

            <?php
            $i = 0;
            foreach ($aOrder['billTypeName'] as $aBillName) {
                echo '<p><strong>' . $aBillName . ':</strong>&nbsp;&nbsp;' . $aOrder['billType'][$i] . '</p>';
                $i++;
            }
            ?>
            <p class="ttl-amnt"><strong class="ttl-amnt">Sub Total:</strong>
                <?php echo $aOrder['subTotal']; ?>
            </p>

        </div>

        <strong class="text-label">Discount & Transection</strong>
        <div class="bill-group">
            <p><strong>Discount:</strong>
                <?php echo $aOrder['dAmount']; ?>
            </p>
            <p class="ttl-amnt"><strong class="ttl-amnt">Total Amount:</strong>
                <?php echo $aOrder['total_amount']; ?>
            </p>
            <p><strong>Paid Amount:</strong>
                <?php echo $aOrder['paid_amount']; ?>
            </p>
            <p>
                <strong>Due Amount:</strong>
                <?php
                if ($aOrder['paid_amount'] != 'NULL') {
                    echo($aOrder['total_amount'] - $aOrder['paid_amount']);
                } else {
                    echo $aOrder['total_amount'];
                }
                ?>
            </p>
        </div>

    </div>
</div>