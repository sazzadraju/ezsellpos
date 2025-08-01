<style type="text/css">
              </style>
              <div class="content-i">
                  <div class="content-box">
                      <div class="row">
                          <div class="col-lg-12">
                              <?php echo form_open_multipart('', array('id' => 'product', 'class' => 'cmxform')); ?>
                              <div class="element-wrapper">

                                  <table id="mytable" class="table table-bordred table-striped">
                                      <thead>
                                      <th><?= lang("date"); ?></th>
                                      <th><?= lang("invoice_no"); ?></th>
                                      <th><?= lang("customer_name"); ?></th>
                                      <th><?= lang("store"); ?></th>
                                      <th class="right_text"><?= lang("invoice_amount").' ('.set_currency().')'; ?></th>
                                      <th class="right_text"><?= lang("paid-amt").' ('.set_currency().')'; ?></th>
                                      <th class="right_text"><?= lang("dues").' ('.set_currency().')'; ?></th>
                                      <th class="right_text"><?= lang("settle_amount").' ('.set_currency().')'; ?></th>
                                      </thead>
                                      <tbody>
                                      <?php
                                      $count = 1;
                                      $tot_due=0;
                                      $tot_paid=0;
                                      $tot_amount=0;
                                      $total_settle=0;
                                      if (!empty($posts)):

                                          foreach ($posts as $post):
                                              ?>
                                              <tr>
                                                  <?php
                                                   echo '<td>' . nice_date($post['dtt_add']). '</td>';
                                                   echo '<td>' . $post['invoice_no']. '</td>';
                                                  echo '<td>' .  $post['customer_name']. '</td>';
                                                  echo '<td>' .  $post['store_name']. '</td>';
                                                  echo '<td class="right_text">' . $post['tot_amt']. '</td>';
                                                  echo '<td class="right_text">' . $post['paid_amt'] . '</td>';
                                                  $settle=0;
                                                  $due=0;
                                                  if($post['settle']==1){
                                                      $total_settle+=$post['due_amt'];
                                                      $settle=$post['due_amt'];
                                                  }else{
                                                      $tot_due+=$post['due_amt'];
                                                      $due=$post['due_amt'];
                                                  }
                                                  echo '<td class="right_text">' . $due . '</td>';
                                                  echo '<td class="right_text">' . $settle . '</td>';
                                                  $tot_paid=$tot_paid+ $post['paid_amt'];
                                                  $tot_amount=$tot_amount+ $post['tot_amt'];
                                                  ?>
                                              </tr>
                                              <?php
                                              $count++;
                                          endforeach;
                                      else:
                                          ?>
                                          <tr>
                                              <td colspan="7"><b><?= lang("data_not_available");?></b></td>
                                          </tr>
                                      <?php endif; ?>
                                      </tbody>
                                      <tfoot>
                                      <th class="right_text" colspan="4"><?= lang("total"); ?></th>
                                      <th class="right_text"><?= number_format($tot_amount, 2); ?></th>
                                      <th class="right_text"><?= number_format($tot_paid, 2); ?></th>
                                      <th class="right_text"><?= number_format($tot_due, 2); ?></th>
                                      <th class="right_text"><?= number_format($total_settle, 2); ?></th>
                                      </tfoot>
                                  </table>

                                  <div class="clearfix"></div>
                                  <?php echo $this->ajax_pagination->create_links(); ?>
