<style type="text/css">
    .error-custom{
        border-color: red;
    }

</style>
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
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form id="delivery" enctype="multipart/form-data" method="post">
                                <div class="table-responsive" id="postList">
                                    <?php 
                                   // print_r($agent);
                                    ?>
                                    <p class="invoice-no">
                                        Invoice: <?= $invoices[0]['invoice_no'] ?>
                                    </p>
                                    <p><?= lang("delivery_type"); ?>: <?= $agent[0]['delivery_name'] ?></p>
                                    <p><?= lang("agent_name"); ?>: <?= $agent[0]['agent_name'] ?></p>
                                    <?php 
                                    $person=($agent[0]['type_id']==2)?$agent[0]['person_name']:$agent[0]['fullname'];
                                    ?>
                                    <p>Delivery Persone: <?= $person ?></p>
                                    <p>Delivery Address: <?= $agent[0]['delivery_address'] ?></p>
                                    <p>CusID/Name: <?= $invoices[0]['customer_name'] ?></p>
                                    <p>Customer Mobile: <?= $invoices[0]['customer_mobile'] ?></p>
                                    <input type="hidden" name="sale_id" value="<?php echo $invoices[0]['id_sale']; ?>">
                                    <input type="hidden" name="customer_id" value="<?php echo $invoices[0]['customer_id']; ?>">
                                    <input type="hidden" name="order_id" value="<?php echo $invoice; ?>">
                                    <table class="table table-bordred">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Total Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Due Amount</th>
                                            <th>New Payment Amount</th>
                                        </tr>

                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Products</td>
                                            <td><?= $invoices[0]['tot_amt'] ?></td>
                                            <td><?= $invoices[0]['paid_amt'] ?></td>
                                            <?php
                                            $p_deu=$invoices[0]['tot_amt']-  $invoices[0]['paid_amt'];
                                            $val='';
                                            if($p_deu==0){
                                                $val='readonly';
                                            }
                                            ?>
                                            <td><?= $p_deu?> <input type="hidden" id="p_due_amt" name="p_due_amt" value="<?=$p_deu ?>"></td>
                                            <td><input type="text" name="p_amount" <?= $val?> id="p_amount"></td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Charge</td>
                                            <td><?= $delivery[0]->tot_amt ?></td>
                                            <td><?= $delivery[0]->paid_amt ?></td>
                                            <?php
                                            $d_deu=($delivery[0]->tot_amt) -  ($delivery[0]->paid_amt);
                                            $val='';
                                            if($d_deu==0){
                                                $val='readonly';
                                            }
                                            ?>
                                            <td><?=$d_deu ?> <input type="hidden" id="d_due_amt" name="d_due_amt" value="<?=$d_deu ?>"></td>
                                            <td><input type="text" <?= $val?> name="d_amount" id="d_amount"></td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>

                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"><?= lang("reference_number"); ?></label>
                                            <div class="col-sm-12">

                                                <div class="row-fluid">
                                                   <input type="text" name="ref_num" id="ref_num" class="form-control" value="<?= $ref_no[0]['reference_num']?>">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"><?= lang("accounts"); ?></label>
                                            <div class="col-sm-12">

                                                <div class="row-fluid">
                                                    <?php
                                                    $html='';
                                                    if (!empty($accounts)) {
                                                        foreach ($accounts as $account) :
                                                            $ac_name = !empty($account['acc_no']) ? $account['acc_name'] . ' (' . $account['acc_no'] . ')' : $account['acc_name'];
                                                            $html .= '<option actp="'.$account['acc_type'].'" value="' . $account['acc_id'] . '">' . $ac_name . '</option>';
                                                        endforeach;
                                                    }
                                                    ?>
                                                    <select class="form-control" name="accounts" id="accounts" onchange="checkAccounts(this)">
                                                        <option value="0"><?= lang('select_one')?></option>
                                                        <?php echo $html;?>
                                                    </select>
                                                    <div id="ref_trx_no"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label"><?= lang("status"); ?></label>
                                            <div class="col-sm-12">
                                                <div class="row-fluid">
                                                    <select class="form-control" name="status" id="status">
                                                        <?php
                                                        $status=$this->config->item('order_status');
                                                        foreach($status as $key=>$val){
                                                            $select=($delivery[0]->order_status== $key)?'selected':'';
                                                            echo ' <option value="'.$key.'" '.$select.'>'.$val.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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

<script>
    function checkAccounts(evl) {
        var option = $('option:selected', evl).attr('actp');
        $html='<input type="hidden" name="account_method" id="account_method" value="'+option+'">';
        if(option==3){
            $html += '<div class="col-md-12">';
            $html += '<div class="form-group row">';
            $html += '<label class="col-sm-12 col-form-label" for="">Reff Transaction No</label>';
            $html += '<div class="col-sm-12">';
            $html += '<input class="form-control" type="text" id="ref_trx_no" name="ref_trx_no">';
            $html += '</div>';
            $html += '</div>';
            $html += '</div>';
        }
        $('#ref_trx_no').html($html);
    }
    $("#delivery").submit(function () {
        $('#p_amount').removeClass("focus_error");
        $('#d_amount').removeClass("focus_error");
        $('#accounts').removeClass("focus_error");
        var store = $('#accounts option:selected').val();
        var p_amt=$('#p_amount').val()*1;
        var d_amt=$('#d_amount').val()*1;
        var p_due_amt=$('#p_due_amt').val()*1;
        var d_due_amt=$('#d_due_amt').val()*1;
        var $error_count=1;
        // if((p_amt=='') && (p_due_amt>0)){
        //     $('#p_amount').addClass("focus_error");
        //     alert('s');
        //     $error_count=2;
        // }if((d_amt=='') && (d_due_amt>0)){
        //     $('#d_amount').addClass("focus_error");
        //     $error_count=2;
            
        // }
        if(p_amt>p_due_amt){
            $('#p_amount').addClass("focus_error");
            $error_count=2;
        }
        if(d_amt>d_due_amt){
            $('#d_amount').addClass("focus_error");
            $error_count=2;
        }
        if ((store == 0) && (p_amt>0 || d_amt>0)) {
            $('#accounts').addClass("focus_error");
            $error_count = 2;
        }
        if($error_count==2){
            return false;
        }else{
            var dataString = new FormData($(this)[0]);
            var method = $('#accounts option:selected').attr('actp');
            dataString.append('method_id', method);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>add_delivery_order_payment',
                data: dataString,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    if (result==0) {
                        alert('error in code');
                    } else {
                        $('#showMessage').html('Data added Successfully..');
                        $('#showMessage').show();
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>delivery-orders";
                        }, 500);

                        $('.loading').fadeOut("slow");

                    }
                    $('.loading').fadeOut("slow");
                    return false;
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

        return false;
    });
</script>
