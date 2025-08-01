<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>
<div class="col-md-12">
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div>
<script src="<?= base_url() ?>themes/default/js/jquery.js"></script>
<script src="<?= base_url() ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>themes/default/js/123.js"></script>
<script>
    function updateVat() {
        var vat = $('#vat').val();
        var cur_name = $('#cur_name').val();
        if (vat === '') {
            $("#vat").addClass("error");
        } else if (cur_name === '') {
            $("#cur_name").addClass("error");
        } else if (!$.isNumeric(vat)) {
            $("#vat").addClass("error");
            $('#error').text('Enter Number Only');
        } else {
            var vat1 = vat;
            var position = $("#cur_pos option:selected").val();
            var time_zone = $("#cur_pos1 option:selected").val();
            $.ajax({
                url: "<?php echo base_url() ?>company_info/update_info",
                type: "POST",
                data: 'time_zone=' + time_zone + '&vat=' + vat1 + '&position=' + position + '&cur_name=' + cur_name,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data) {
                    if (data == 'success') {
                        $('#showMessage').html('<?= lang("update_success") ?>');
                        $('#showMessage').show();
                        $('.loading').fadeOut("slow");
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);

                        }, 3000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }
</script>
<div class="content-i">

    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="element-box auto">

                                <div class="row">
                                    <?php
                                    $client_id = $client_logo = $client_vat = $package_id = $form_date = $client_status = $to_date = $to_station = $to_store = $to_user = $vat_reg_no =$barcode_text = '';
                                    //echo '<pre>';
                                    //print_r($configs);
                                    foreach ($configs as $value) {


                                        $client_id = ($value->param_key == 'CLIENT_ID') ? $value->param_val : $client_id;
                                        $client_logo = ($image[0]->store_img != '') ? $image[0]->store_img : '4';
                                        $client_vat = ($value->param_key == 'DEFAULT_VAT') ? $value->param_val : $client_vat;
                                        $package_id = ($value->param_key == 'PACKAGE_ID') ? $value->param_val : $package_id;
                                        $form_date = ($value->param_key == 'SUBSCRIPTION_FROM') ? $value->param_val : $form_date;
                                        $client_status = ($value->param_key == 'SUBSCRIPTION_STATUS') ? $value->param_val : $client_status;
                                        $to_date = ($value->param_key == 'SUBSCRIPTION_TO') ? $value->param_val : $to_date;
                                        $to_station = ($value->param_key == 'TOT_STATIONS') ? $value->param_val : $to_station;
                                        $to_store = ($value->param_key == 'TOT_STORES') ? $value->param_val : $to_store;
                                        $to_user = ($value->param_key == 'TOT_USERS') ? $value->param_val : $to_store;
                                        $vat_reg_no = ($value->param_key == 'VAT_REG_NO') ? $value->param_val : $to_store;
                                        $barcode_text = ($value->param_key == 'BARCODE_TEXT') ? $value->param_val : $barcode_text;
                                        
                                    }
                                    // echo '</pre>';
                                    ?>
                                    <div id="View" class="">
                                        <div class="info-1">
                                            <div class="receive-payment">
                                                <h6 class="element-header">Company Details</h6>
                                                <div class="col-md-12">
                                                    <div class="rcv-pmnt">
                                                        <strong>Cleint Id</strong> :
                                                        <?php echo $client_id; ?>
                                                    </div>
                                                    <div class="rcv-pmnt">
                                                        <strong>Package Id</strong> :
                                                        <?php echo $package_id; ?>
                                                    </div>
                                                    <div class="rcv-pmnt">
                                                        <strong>Registration Date</strong> :
                                                        <?php if (!empty($form_date)) {
                                                                    echo date("d M, Y", strtotime($form_date));
                                                                    } else {
                                                                    echo "Invalid date!";
                                                                    }
                                                                ?>
                                                    </div>
                                                    <div class="rcv-pmnt">
                                                        <strong>Registration Expaired Date</strong> :
                                                        <?php if (!empty($to_date)) {
                                                                    echo date("d M, Y", strtotime($to_date));
                                                                    } else {
                                                                    echo "Invalid date!";
                                                                    }
                                                                ?>
                                <!--                    <?php echo form_open_multipart('http://posspot.com/sms/client-renew', array('id' => 'stations', 'class' => 'renew-reg')); ?>
                                                        <input type="hidden" name="shop_name" value="<?= get_url() ?>">
                                                        <input class="btn btn-success btn-xs" type="submit"
                                                               value="Renew">
                                                        <?php echo form_close(); ?> -->
                                                    </div>
                                                    <div class="rcv-pmnt">
                                                        <strong>Client Status</strong> :
                                                        <?php echo $client_status; ?>
                                                    </div>
                                                    <div class="rcv-pmnt">
                                                        <strong>Total Station</strong> :
                                                        <?php echo $to_station; ?>
                                                    </div>
                                                    <div class="rcv-pmnt">
                                                        <strong>Total Store</strong> :
                                                        <?php echo $to_store; ?>
                                                    </div>
                                                    <div class="rcv-pmnt">
                                                        <strong>Total User</strong> :
                                                        <?php echo $to_user; ?>
                                                    </div>
                                                    <div class="update-content">
                                                        <div class="rcv-pmnt">
                                                            <strong>Default Vat</strong> :
                                                            <input style="width: 150px;border: 1px solid #d0d0d0;height: 30px;border-radius: 4px;text-align: center;"
                                                                   type="text" name="vat"
                                                                   id="vat" value="<?= $client_vat ?>">
                                                            <div class="rcv-pmnt">
                                                                <strong>Currency</strong> :
                                                                <input style="width: 150px;border: 1px solid #d0d0d0;height: 30px;border-radius: 4px;text-align: center;"
                                                                       type="text" name="cur_name"
                                                                       id="cur_name"
                                                                       value="<?= $currency[0]->param_val ?>">
                                                            </div>
                                                            <div class="rcv-pmnt" >
                                                                <strong>Currency Position</strong> :
                                                                <?php
                                                                $cur = $currency[0]->utilized_val;
                                                                $time = $time_zone[0]->param_val;
                                                                ?>
                                                                <select id="cur_pos" style="width: 150px;border: 1px solid #d0d0d0;height: 30px;border-radius: 4px;text-align: center;" >
                                                                    <option value="R"<?= ($cur == 'R') ? 'selected' : '' ?>>
                                                                        Right
                                                                    </option>
                                                                    <option value="L"<?= ($cur == 'L') ? 'selected' : '' ?>>
                                                                        Left
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="rcv-pmnt">
                                                                <strong>Time Zone</strong> :
                                                                <select id="cur_pos1" style="width: 250px;border: 1px solid #d0d0d0;height: 30px;border-radius: 4px;text-align: center;">
                                                                    <?php
                                                                    foreach ($zones as $zone) {
                                                                        $select = ($time == $zone->timezone) ? 'selected' : '';
                                                                        echo '<option value="' . $zone->timezone . '" ' . $select . '>' . $zone->name . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            

                                                            <button class="btn btn-primary btn-rounded right"
                                                                    onclick="updateVat()">Update
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rcv-payment-details-logo">
                                                    <?php
                                                    if ($client_logo != 4) {
                                                        ?>
                                                        <img src="<?php echo documentLink('user') . $client_logo ?>">
                                                        <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="print-type">
                                            <h4>A4 Invoice Settings</h4>
                                            <?php
                                            $full_invoice = json_decode($invoice[0]->param_val);
                                            $thermal_invoice = json_decode($invoice[0]->utilized_val);
                                            ?>
                                            <form id="fullInvoiceSubmit" action="" method="post">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="f_shop" id="f_shop"
                                                               value="1"<?php if (isset($full_invoice->shop_name) && $full_invoice->shop_name == 1) echo 'checked' ?>>
                                                        <label for="f_shop">Shop Name</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="f_logo" id="f_logo"
                                                               value="1" <?php if (isset($full_invoice->shop_logo) && $full_invoice->shop_logo == 1) echo 'checked' ?>>
                                                        <label for="f_logo">Logo</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="f_phone" id="f_phone"
                                                               value="1" <?php if (isset($full_invoice->phone) && $full_invoice->phone == 1) echo 'checked' ?>>
                                                        <label for="f_phone">Phone</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="f_email" id="f_email"
                                                               value="1" <?php if (isset($full_invoice->email) && $full_invoice->email == 1) echo 'checked' ?>>
                                                        <label for="f_email">Email</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="f_brand" id="f_brand"
                                                               value="1" <?php if (isset($full_invoice->brand) && $full_invoice->brand == 1) echo 'checked' ?>>
                                                        <label for="f_brand">Product Brand</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="f_code" id="f_code"
                                                               value="1" <?php if (isset($full_invoice->code) && $full_invoice->code == 1) echo 'checked' ?>>
                                                        <label for="f_code">Product Code</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="f_sub_cat" id="f_sub_cat"
                                                               value="1" <?php if (isset($full_invoice->sub_cat) && $full_invoice->sub_cat == 1) echo 'checked' ?>>
                                                        <label for="f_sub_cat">Product Sub Category</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="checkbox" name="f_header" id="f_header"
                                                               value="1" <?php if (isset($full_invoice->header) && $full_invoice->header == 1) echo 'checked' ?>>
                                                        <label for="f_header">Show Header and Footer</label>
                                                   </div>
                                                    <div class="col-md-6">
                                                        Header: <input type="text" name="head_size" size="4" style="width: 50px;border: 1px solid #d0d0d0;height: 30px;border-radius: 4px;text-align: center; <?php if (isset($full_invoice->head_size)) echo 'value="'.$full_invoice->head_size.'"' ?>> PX ,
                                                        Footer: <input type="text" name="foot_size" size="4" style="width: 50px;border: 1px solid #d0d0d0;height: 30px;border-radius: 4px;text-align: center;<?php if (isset($full_invoice->foot_size)) echo 'value="'.$full_invoice->foot_size.'"' ?>> PX
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:7px; margin-bottom:7px;">
                                                        Invoice Note:
                                                        <input type="radio" name="f_note_type" id="f_note_y"
                                                               value="yes" <?php if (isset($full_invoice->note_type) && $full_invoice->note_type == 'yes') echo 'checked' ?>>
                                                        <label for="f_note_y">Yes</label>
                                                        <input type="radio" name="f_note_type" id="f_note_n"
                                                               value="no" <?php if (isset($full_invoice->note_type) && $full_invoice->note_type == 'no') echo 'checked' ?>>
                                                        <label for="f_note_n">No</label>
                                                    </div>
                                                    <div class="col-md-12" >
                                                        <textarea class="form-control" name="f_note"><?php if (isset($full_invoice->note)){echo $full_invoice->note;} ?></textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary btn-rounded right" type="submit" style="margin-top:7px;">
                                                            Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="print-type">
                                            <h4>Thermal Invoice Settings</h4>
                                            <form id="thermalInvoiceSubmit" action="" method="post">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="t_shop" id="t_shop"
                                                               value="1"<?php if (isset($thermal_invoice->shop_name) && $thermal_invoice->shop_name == 1) echo 'checked' ?>>
                                                        <label for="t_shop">Shop Name</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="t_logo" id="t_logo"
                                                               value="1" <?php if (isset($thermal_invoice->shop_logo) && $thermal_invoice->shop_logo == 1) echo 'checked' ?>>
                                                        <label for="t_logo">Logo</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="t_phone" id="t_phone"
                                                               value="1" <?php if (isset($thermal_invoice->phone) && $thermal_invoice->phone == 1) echo 'checked' ?>>
                                                        <label for="t_phone">Phone</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="t_email" id="t_email"
                                                               value="1" <?php if (isset($thermal_invoice->email) && $thermal_invoice->email == 1) echo 'checked' ?>>
                                                        <label for="t_email">Email</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="t_brand" id="t_brand"
                                                               value="1" <?php if (isset($thermal_invoice->brand) && $thermal_invoice->brand == 1) echo 'checked' ?>>
                                                        <label for="t_brand">Product Brand</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" name="t_code" id="t_code"
                                                               value="1" <?php if (isset($thermal_invoice->code) && $thermal_invoice->code == 1) echo 'checked' ?>>
                                                        <label for="t_code">Product Code</label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        Invoice Note:
                                                        <input type="radio" name="t_note_type" id="t_note_y"
                                                               value="yes" <?php if (isset($thermal_invoice->note_type) && $thermal_invoice->note_type == 'yes') echo 'checked' ?>>
                                                        <label for="t_note_y">Yes</label>
                                                        <input type="radio" name="t_note_type" id="t_note_n"
                                                               value="no" <?php if (isset($thermal_invoice->note_type) && $thermal_invoice->note_type == 'no') echo 'checked' ?>>
                                                        <label for="t_note_n">No</label>
                                                        <textarea class="form-control" name="t_note"><?php if (isset($thermal_invoice->note)) echo $thermal_invoice->note ?></textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary btn-rounded right" type="submit" style="margin-top:7px;">
                                                            Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="print-type">
                                            <h4>Column Configaration</h4>
                                            <form id="permissionSubmit" action="" method="post">
                                                <div class="row">
                                                    <table class="table">
                                                        <tr>
                                                            <th class="text-center">S/L</th>
                                                            <th>Menu Name</th>
                                                            <th>Column Name</th>
                                                            <th colspan="2">Permission</th>
                                                        </tr>
                                                        <?php 
                                                        $count=1;
                                                        foreach ($columns as $key) {
                                                            echo '<tr>';
                                                            echo '<td class="text-center">';
                                                            echo $count;
                                                            echo '<input type="hidden" name="id_column[]" id="id_column_'.$count.'" value="'.$key->id_acl_user_column.'">';
                                                            echo '</td>';
                                                            echo '<td>'.$key->acl_menu_name.'</td>';
                                                            echo '<td>'.$key->column_name.'</td>';
                                                            $per=$key->permission;
                                                            $per_yes=($per==1)?'checked':'';
                                                            $per_no=($per==2)?'checked':'';
                                                            $id=$key->id_acl_user_column;
                                                            echo '<td>';
                                                            echo '<input type="radio" name="permission_'.$id.'" id="permission_y_'.$count.'" value="1" '.$per_yes.'>';
                                                            echo '<label for="permission_y_'.$count.'">Yes</label>';
                                                             echo '</td>';
                                                             echo '<td>';
                                                            echo '<input type="radio" name="permission_'.$id.'" id="permission_n_'.$count.'" value="2" '.$per_no.'>';
                                                            echo '<label for="permission_n_'.$count.'">No</label>';
                                                             echo '</td>';
                                                            echo '</tr>';
                                                            $count++;
                                                        }

                                                        ?>
                                                    </table>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary btn-rounded right" type="submit">
                                                            Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- <div class="print-type">
                                            <h4>SMS Configaration</h4>
                                            <form id="smsSubmit" action="" method="post">
                                                <div class="row">
                                                    <table class="table">
                                                        <tr>
                                                            <th class="text-center">S/L</th>
                                                            <th>Menu Name</th>
                                                            <th>Numbers (EX:017..X,016..X,015..X)</th>
                                                            <th colspan="2">Permission</th>

                                                        </tr>
                                                        <?php 
                                                        $count=1;
                                                        foreach ($sms_configs as $key) {
                                                            $id=$key->id_sms_config;
                                                            echo '<tr>';
                                                            echo '<td class="text-center">';
                                                            echo $count;
                                                            echo '<input type="hidden" name="id_column[]" id="id_column_'.$count.'" value="'.$key->id_sms_config.'">';
                                                            echo '</td>';
                                                            echo '<td>'.$key->sms_category_name.'</td>';
                                                            echo '<td>'.'<textarea name="admin_phone_'.$id.'" >'.$key->sms_phone.'</textarea>'.'</td>';
                                                            $per=$key->sms_send;
                                                            $per_yes=($per==1)?'checked':'';
                                                            $per_no=($per==0)?'checked':'';
                                                            echo '<td>';
                                                            echo '<input type="radio" name="sms_send_'.$id.'" id="sms_send_y_'.$count.'" value="1" '.$per_yes.'>';
                                                            echo '<label for="sms_send_y_'.$count.'">Yes</label>';
                                                            echo '</td>';
                                                            echo '<td>';
                                                            echo '<input type="radio" name="sms_send_'.$id.'" id="sms_send_n_'.$count.'" value="0" '.$per_no.'>';
                                                            echo '<label for="sms_send_n_'.$count.'">No</label>';
                                                             echo '</td>';
                                                            echo '</tr>';
                                                            $count++;
                                                        }

                                                        ?>
                                                    </table>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-success btn-sm right" type="submit">
                                                            Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div> -->
                                         <div class="print-type">
                                            <h4>Sales Configaration</h4>
                                            <?php 
                                            $sales = json_decode($sales_configs[0]->param_val);
                                            ?>
                                            <form id="salesPermissionSubmit" action="" method="post">
                                                <div class="row">
                                                    <table class="table">
                                                        <tr>
                                                            <th class="text-center">S/L</th>
                                                            <th>Name</th>
                                                            <th colspan="2">Permission</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">1</td>
                                                            <td>Without Customer sales alert</td>
                                                            <?php 
                                                                $count=1;
                                                                $per=$sales->empty_customer;
                                                                $chk_yes=($per==1)?'checked':'';
                                                                $chk_no=($per==0)?'checked':'';
                                                            echo '<td>';
                                                            echo '<input type="radio" name="empty_customer" id="empty_customer_'.$count.'" value="1" '.$chk_yes.'>';
                                                            echo '<label for="empty_customer_'.$count.'">Yes</label>';
                                                            echo '</td>';
                                                            echo '<td>';
                                                            echo '<input type="radio" name="empty_customer" id="empty_customer_n_'.$count.'" value="0" '.$chk_no.'>';
                                                            echo '<label for="empty_customer_n_'.$count.'">No</label>';
                                                             echo '</td>';
                                                             ?>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">2</td>
                                                            <td>Edit Product price during sales</td>
                                                            <?php 
                                                                $count=1;
                                                                $per=$sales->price;
                                                                $chk_yes=($per==1)?'checked':'';
                                                                $chk_no=($per==0)?'checked':'';
                                                            echo '<td>';
                                                            echo '<input type="radio" name="price" id="price_'.$count.'" value="1" '.$chk_yes.'>';
                                                            echo '<label for="price_'.$count.'">Yes</label>';
                                                            echo '</td>';
                                                            echo '<td>';
                                                            echo '<input type="radio" name="price" id="price_n_'.$count.'" value="0" '.$chk_no.'>';
                                                            echo '<label for="price_n_'.$count.'">No</label>';
                                                             echo '</td>';
                                                             ?>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">3</td>
                                                            <td>Edit Product discount during sales</td>
                                                            <?php 
                                                                $count=1;
                                                                $per=$sales->discount;
                                                                $chk_yes=($per==1)?'checked':'';
                                                                $chk_no=($per==0)?'checked':'';
                                                            echo '<td>';
                                                            echo '<input type="radio" name="discount" id="discount_'.$count.'" value="1" '.$chk_yes.'>';
                                                            echo '<label for="discount_'.$count.'">Yes</label>';
                                                            echo '</td>';
                                                            echo '<td>';
                                                            echo '<input type="radio" name="discount" id="discount_n_'.$count.'" value="0" '.$chk_no.'>';
                                                            echo '<label for="discount_n_'.$count.'">No</label>';
                                                            echo '</td>';
                                                             ?>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">4</td>
                                                            <td>Discount on Invoice</td>
                                                            <?php 
                                                                $count=1;
                                                                $per=$sales->discount_invoice;
                                                                $chk_yes=($per==1)?'checked':'';
                                                                $chk_no=($per==0)?'checked':'';
                                                            echo '<td>';
                                                            echo '<input type="radio" name="discount_invoice" id="discount_invoice_'.$count.'" value="1" '.$chk_yes.'>';
                                                            echo '<label for="discount_invoice_'.$count.'">Yes</label>';
                                                            echo '</td>';
                                                            echo '<td>';
                                                            echo '<input type="radio" name="discount_invoice" id="discount_invoice_n_'.$count.'" value="0" '.$chk_no.'>';
                                                            echo '<label for="discount_invoice_n_'.$count.'">No</label>';
                                                            echo '</td>';
                                                             ?>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center" >5</td>
                                                            <td>Round Option</td>
                                                            <?php 
                                                                $count=1;
                                                                $rount=$sales->round;
                                                                $chk_yes=($per==1)?'checked':'';
                                                                $chk_no=($per==0)?'checked':'';
                                                            echo '<td colspan="2">';
                                                            echo '<input style="width: 86px;border: 1px solid #d0d0d0;height: 30px;border-radius: 4px;text-align: center;" type="text" name="round_option" id="round_option_'.$count.'" value="'.$rount.'" >';
                                                            echo '</td>';
                                                             ?>
                                                        </tr>
                                                    </table>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary btn-rounded right" type="submit">
                                                            Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $("#salesPermissionSubmit").submit(function () {
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>settings/companyInfo/sales_permission',
            data: dataString,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('.loading').fadeOut("slow");
                console.log(data);
                if(data==1){
                    $('#showMessage').html('<?= lang("update_success"); ?>');
                    $('#showMessage').show();
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                }

            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    $("#fullInvoiceSubmit").submit(function () {
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>settings/companyInfo/full_invoice_setup',
            data: dataString,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('.loading').fadeOut("slow");
                if(data==1){
                    $('#showMessage').html('<?= lang("update_success"); ?>');
                    $('#showMessage').show();
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                }

            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    $("#thermalInvoiceSubmit").submit(function () {
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>settings/companyInfo/thermal_invoice_setup',
            data: dataString,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('.loading').fadeOut("slow");
                if(data==1){
                    $('#showMessage').html('<?= lang("update_success"); ?>');
                    $('#showMessage').show();
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    $("#permissionSubmit").submit(function () {
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>settings/companyInfo/permission_setup',
            data: dataString,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('.loading').fadeOut("slow");
                if(data==1){
                    $('#showMessage').html('<?= lang("update_success"); ?>');
                    $('#showMessage').show();
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    $("#smsSubmit").submit(function () {
        var dataString = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>settings/companyInfo/sms_config_setup',
            data: dataString,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('.loading').fadeOut("slow");
                if(data==1){
                    $('#showMessage').html('<?= lang("update_success"); ?>');
                    $('#showMessage').show();
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    
</script>