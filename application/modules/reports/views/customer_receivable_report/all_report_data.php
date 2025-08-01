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
                                      <th><?= lang("customer_name"); ?></th>
                                      <th><?= lang("store"); ?></th>
                                      <th class="right_text"><?= lang("invoice_amount").' ('.set_currency().')'; ?></th>
                                      <th class="right_text"><?= lang("paid-amt").' ('.set_currency().')'; ?></th>
                                      <th class="right_text"><?= lang("dues").' ('.set_currency().')'; ?></th>
                                      </thead>
                                      <tbody>
                                      <?php
                                      $count = 1;
                                      $tot_due=0;
                                      $tot_paid=0;
                                      $tot_amount=0;
                                      if (!empty($posts)):

                                          foreach ($posts as $post):
                                              ?>
                                              <tr>
                                                  <?php
                                                  // echo '<td>' . $post['dtt_add']. '</td>';
                                                  // echo '<td>' . $post['invoice_no']. '</td>';
                                                  echo '<td>' .  $post['customer_name']. '</td>';
                                                  echo '<td>' .  $post['store_name']. '</td>';
                                                  echo '<td class="right_text">' . $post['tot_amt']. '</td>';
                                                  echo '<td class="right_text">' . $post['paid_amt'] . '</td>';
                                                  echo '<td class="right_text">' . $post['due_amt'] . '</td>';
                                                  $tot_due=$tot_due+ $post['due_amt'];
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
                                              <td colspan="4"><b><?= lang("data_not_available");?></b></td>
                                          </tr>
                                      <?php endif; ?>
                                      </tbody>
                                      <tfoot>
                                      <!--                <th></th>-->
                                      <!--                <th></th>-->
                                      <th></th>
                                      <th class="right_text"><?= lang("total"); ?></th>
                                      <th class="right_text"><?= number_format($tot_amount, 2); ?></th>
                                      <th class="right_text"><?= number_format($tot_paid, 2); ?></th>
                                      <th class="right_text"><?= number_format($tot_due, 2); ?></th>
                                      </tfoot>
                                  </table>

                                  <div class="clearfix"></div>
                                  <?php echo $this->ajax_pagination->create_links(); ?>
