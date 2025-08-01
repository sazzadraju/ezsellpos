<!-- <?php print_r($transaction_type); ?> -->

<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("date"); ?></th>
    <th><?= lang("store"); ?></th>
    <th><?= lang("transaction_no"); ?></th>
    <th><?= lang("transaction_category"); ?></th>
    <th><?= lang("transaction_type"); ?></th>
    <th><?= lang("account_no"); ?></th>
    <th class="text-right"><?= lang("amount").' ('.set_currency().')'; ?></th>
    
    </thead>
    <tbody>
    <?php
    $total=0;
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            // echo "<pre>";
            //   print_r($post);
            ?>
            <tr>
                <?php
                $date = date('Y-m-d', strtotime($post['dtt_trx']));
                echo '<td>' . $date . '</td>';
                echo '<td>' . $post['store_name'] . '</td>';
                echo '<td>' . $post['trx_no'] . '</td>';
                $store_name = '';
                foreach ($store as $stores) {
                    if ($stores->id_store == $post['store_id']) {
                        $store_name = $stores->store_name;
                        break;
                    }
                }
                foreach ($transaction_type as $key => $val) {
                    $type_name = '';
                    if ($key == $post['qty_multiplier']) {
                        $type_name = $val;
                        break;
                    }
                }
                $aa='';
                if(!empty($post['cat']&&$post['sub_cat']) ){
                    $aa='/';
                }
                echo '<td>' . $post['cat'].$aa. $post['sub_cat']. '</td>';
                echo '<td>' . $type_name . '</td>';
                // echo '<td>' .$post['payment_method_id']. '</td>';
                

                $account_name = '';
                $account_no = '';

                foreach ($accounts as $account) {
                    if ($account->id_account == $post['account_id']) {
                        $account_name = $account->account_name;
                        $account_no = $account->account_no;
                        break;
                    }
                }
                echo '<td>' . account_name_id($post['account_id']) . '</td>';
                echo '<td class="text-right">' . $post['tot_amount'] . '</td>';
                
                ?>
            </tr>
            <?php
            $count++;
            $total=$total+$post['tot_amount'];
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
        </tr>
    <?php endif; ?>
    </tbody>
    <tfoot>
    <th colspan="5"></th>
    <th><?= lang("total"); ?></th>
    <th class="text-right"><?= $total; ?></th>
    <!-- <th></th> -->
    </tfoot>
</table>

<div class="clearfix"></div>

<!-- modal -->

<!-- modal -->
<?php echo $this->ajax_pagination->create_links(); ?>
<div id="view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("payments_details"); ?> <span class="close"
                                                                                           data-dismiss="modal">&times;</span>
                </h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="col-md-6">
                        <table id="mytable" class="table table-bordred table-striped">
                            <thead>
                            <th><?= lang("transaction_no"); ?></th>
                            <th><?= lang("invoice_number"); ?></th>
                            <th><?= lang("amount"); ?></th>


                            </thead>
                            <tbody id='tttt'>


                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table id="mytable" class="table table-bordred table-striped">
                            <thead>
                            <th><?= lang("payment-mehod"); ?></th>
                            <th><?= lang("acc_number"); ?></th>
                            <th><?= lang("amount"); ?></th>


                            </thead>
                            <tbody id='pppp'>


                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        function payment_details(trx_no) {
            // alert(trx_no);
            $.ajax({
                url: "<?php echo base_url() ?>report/details/" + trx_no,
                type: "GET",
                dataType: "JSON",
                // beforeSend: function () {
                //     $('.loading').show();
                // },
                success: function (data) {
                    console.log(data);
                    var res = '';
                    //res=JSON.parse(data);
                    //console.log(res);
                    // console.log(data.length);

                    // alert('amount : ' + data[0].amount);
                    // alart($data);
                    // $('.loading').fadeOut("slow");
                    // $('#store_name_view').html(data.product_name);
                    // $('#sl_no').html(data.id_store);
                    var total = 0;
                    var vv = '';
                    for (var i = 0; i < data.length; i++) {
                        total += data[i].amount;
                        vv += '<tr><td>' + data[i].trx_no + '</td><td>' + data[i].invoice_no + '</td><td>' + data[i].tot_amount + '</td></tr>';
                    }

                    // alert(total);
                    // console.log('vv: '+ vv);

                    $('#tttt').html(vv);

                },

                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
        function method_details_data(trx_no) {
            // alert(trx_no);
            $.ajax({
                url: "<?php echo base_url() ?>report/method_details/" + trx_no,
                type: "GET",
                dataType: "JSON",
                // beforeSend: function () {
                //     $('.loading').show();
                // },
                success: function (data) {
                    console.log(data);
                    var res = '';
                    //res=JSON.parse(data);
                    //console.log(res);
                    // console.log(data.length);

                    // alert('amount : ' + data[0].amount);
                    // alart($data);
                    // $('.loading').fadeOut("slow");
                    // $('#store_name_view').html(data.product_name);
                    // $('#sl_no').html(data.id_store);
                    var total = 0;
                    var vv = '';
                    for (var i = 0; i < data.length; i++) {
                        total += data[i].amount;
                        vv += '<tr><td>' + data[i].account_name + '</td><td>' + data[i].account_no + '</td><td>' + data[i].amount + '</td></tr>';
                    }

                    // alert(total);
                    // console.log('vv: '+ vv);

                    $('#pppp').html(vv);

                },

                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    </script>
