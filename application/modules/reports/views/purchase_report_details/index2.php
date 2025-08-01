
<div class="content-i"> 
  <div class="content-box">
    <div class="row">
      <div class="col-lg-10">
        <?php echo form_open_multipart('', array('id' => 'product', 'class' => 'cmxform')); ?>
        <div class="element-wrapper">
          <div class="full-box element-box">
            <div class="row"> 
              <?php
              $receive_date='';
              $invoice='';
              $file='';
              $id='';
              if (!empty($invoice_details)):

                $count = 1;
                $total=0;
                $file=0;

                foreach ($invoice_details as $post):
                  $invoice=$post ['invoice_no'] ;
                  $receive_date=$post['dtt_receive'];
                  $id=$post['purchase_receive_id'];
                  // pa($post);
                  break;
                endforeach;
              endif;
              if (!empty($documents)):
                foreach ($documents as $document):
                  $file=$document['file'] ;
                  break;
                endforeach;
              endif;
              ?>
              <label class="col-sm-4 col-form-label" for=""><?= lang('purchase_date') ?>: <?php echo date('Y-m-d', strtotime($receive_date)); ?></label>
              <label class="col-sm-4 col-form-label" for=""><?= lang('invoice_no') ?>:  <?php echo $invoice; ?> </label>
              <label class="col-sm-4 col-form-label" for=""><?= lang('documents') ?>:  <a href="<?php echo base_url(); ?>public/uploads/<?php echo $file; ?>" download=
                ''> <span class="fa fa-file"></span></a></label>
              </div>
              
            </div>

          </div> 

        </div>
         <div class="col-lg-2">
               <button class="btn btn-primary pull-right" type="button" onclick="searchFilter3('<?php echo $id ?>')"><i class="fa fa-view"></i> <?= lang("print-view"); ?></button>
             </div>    
      </div>

<table id="mytable" class="table table-bordred table-striped">
<thead>
     <th><?= lang("product_name"); ?></th>
      <th><?= lang("store_name"); ?></th>
      <th><?= lang("purchase_price"); ?></th>
      <th><?= lang("qty"); ?></th> 
      <th><?= lang("discount_amount"); ?></th> 
      <th><?= lang("vat"); ?></th> 
      <th><?= lang("note"); ?></th> 
      <th><?= lang("expire_date"); ?></th> 
      <th class="text-right"><?= lang("total").'('.set_currency().')'; ?></th> 

</thead>
<tbody>
    <?php
    if (!empty($invoice_details)):

        $count = 1;
        $total=0;
        foreach ($invoice_details as $post):
          // pa($invoice_details);
            ?>
            <tr>
                <?php
                $product_name='';
                foreach ($product as $products) {
                                       if ($products->id_product == $post['product_id']) {
                                       $product_name = $products->product_name;
                                             break;
                                               }
                                               }
                echo '<td>' .$product_name . '</td>';
                $store_name = '';
                 foreach ($stores as $store) {
                    if ($store->id_store == $post['store_id']) {
                        $store_name = $store->store_name;
                        break;
                    }
                }
                echo '<td>' . $store_name . '</td>';
                echo '<td>' . $post['purchase_price']. '</td>';
                echo '<td>' . $post['qty'] . '</td>';
                echo '<td>' . $post['discount_amt'] . '</td>';
                echo '<td>' . $post['vat_rate'] . '</td>';
                
                echo '<td>' . $post['notes'] . '</td>';
                echo '<td>' . $post['expire_date'] . '</td>';
                echo '<td class="text-right">' . $post['purchase_price']* $post['qty'] . '</td>';
                ?>
            </tr>
            <?php
            $count++;
        endforeach;
        ?>
         <tr>
                <?php
                echo '<td colspan="5"></td>';
                echo '<td><strong>'.lang("purchase_total").'</strong></td>';
                $store_name = '';
                 foreach ($stores as $store) {
                    if ($store->id_store == $post['store_id']) {
                        $store_name = $store->store_name;
                        break;
                    }
                }
                echo '<td></td>';
                echo '<td></td>';
                echo '<td class="text-right">' . number_format($post['tot_amt'], 2, '.', ''). '</td>';
                ?>
            </tr>
            <?php
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available");?></b></td>
        </tr>
    <?php endif; ?> 
</tbody>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
<script type="text/javascript">
    
                                      function searchFilter2(id) {
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url(); ?>purchase-report-details/page_data2/' + id ,
                                                beforeSend: function () {
                                                    $('.loading').show();
                                                },
                                                success: function (html) {
                                                    console.log(html);
                                                    $('#postList').html(html);
                                                    $('.loading').fadeOut("slow");
                                                }
                                            });
                                        }
                                          function searchFilter3(id) {
                                            // alert(id);
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url(); ?>purchase-report-details/print-data/' + id ,
                                                beforeSend: function () {
                                                    $('.loading').show();
                                                },
                                                success: function (html) {
                                                    console.log(html);
                                                    $('#postList').html(html);
                                                    $('.loading').fadeOut("slow");
                                                }
                                            });
                                        }
</script>
