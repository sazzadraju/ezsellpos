


<table id="mytable" class="table table-bordred table-striped">
<thead>
     <th><?= lang("date"); ?></th>
     <th><?= lang("store"); ?></th> 
     <th><?= lang("transaction_no"); ?></th> 
     <th><?= lang("supplier_name"); ?></th> 
     <th><?= lang("trans_account"); ?></th> 
     <th><?= lang("invoice"); ?></th>
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
                $store_name = '';
                 foreach ($store as $stores) {
                    if ($stores->id_store == $post['store_id']) {
                        $store_name = $stores->store_name;
                        break;
                    }
                }
                $date = date('Y-m-d', strtotime($post['dtt_trx']));
                echo '<td>' . $date . '</td>';
                echo '<td>' .$store_name . '</td>';
                 echo '<td>' .$post['trx_no'] . '</td>';
                 // echo '<td>' .$post['invoice_no'] . '</td>';
                  $supplier_name = '';
                 foreach ($suppliers as $supplier) {
                    if ($supplier->id_supplier == $post['ref_id']) {
                        $supplier_name = $supplier->supplier_name;
                        break;
                    }
                }
                 echo '<td>' .$supplier_name . '</td>';
                  
                    $account_name = '';
                    $account_no = '';

                 foreach ($accounts as $account) {
                    if ($account->id_account == $post['account_id']) {
                        $account_name = $account->account_name;
                        $account_no = $account->account_no;
                        break;
                    }
                }

                 echo '<td>' .$account_no . '</td>'; 
                echo '<td>' .$post['invoice_no'] . '</td>';
                echo '<td>' .account_name_id($post['account_id']) . '</td>';
                echo '<td class="text-right">' .$post['tot_amount'] . '</td>';
                $total=$total+$post['tot_amount'];
                ?>
            </tr>
            <?php
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available");?></b></td>
        </tr>
    <?php endif; ?> 
</tbody>
    <tfoot>
    <th colspan="6"></th>
    <th><?= lang("total"); ?></th>
    <th class="text-right"><?= $total; ?></th>
    <!-- <th></th> -->
    </tfoot>
</table>

<div class="clearfix"></div>

<!-- modal -->

<!-- modal -->
<?php echo $this->ajax_pagination->create_links(); ?>

<script type="text/javascript">
                  function payment_details(trx_no)
                     {
                         // alert(trx_no);
                         $.ajax({
                             url: "<?php echo base_url() ?>report/supplier-details/" + trx_no,
                             type: "GET",
                             dataType: "JSON",
                             // beforeSend: function () {
                             //     $('.loading').show();
                             // },
                             success: function (data)
                             {
                                 console.log(data);
                                 var res='';
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
                                  for (var i=0; i<data.length; i++) {
                                    total +=data[i].amount;
                                     vv += '<tr><td>'+data[i].trx_no+'</td><td>'+data[i].invoice_no+'</td><td>'+jsCurrency('<?=set_js_currency() ?>',data[i].tot_amount)+'</td></tr>';
                                  }
                                  
                                  // alert(total);
                                 // console.log('vv: '+ vv);

                                  $('.tttt').html(vv);
                                
                             },

                             error: function (jqXHR, textStatus, errorThrown)
                             {
                                 alert('Error get data from ajax');
                             }
                         });
                     } 
                      function method_details_data(trx_no)
                     {
                         // alert(trx_no);
                         $.ajax({
                             url: "<?php echo base_url() ?>report/sepplier-method-details/" + trx_no,
                             type: "GET",
                             dataType: "JSON",
                             // beforeSend: function () {
                             //     $('.loading').show();
                             // },
                             success: function (data)
                             {
                                 console.log(data);
                                 var res='';
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
                                  for (var i=0; i<data.length; i++) {
                                    total +=data[i].amount;
                                     vv += '<tr><td>'+data[i].account_name+'</td><td>'+data[i].account_no+'</td><td>'+jsCurrency('<?=set_js_currency() ?>',data[i].tot_amount)+'</td></tr>';
                                  }
                                  
                                  // alert(total);
                                 // console.log('vv: '+ vv);

                                  $('.pppp').html(vv);
                                
                             },

                             error: function (jqXHR, textStatus, errorThrown)
                             {
                                 alert('Error get data from ajax');
                             }
                         });
                     }                                           
</script>
