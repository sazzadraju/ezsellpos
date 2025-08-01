
<table id="mytable" class="table table-bordred table-striped">
<thead>
    <th><?= lang("date"); ?></th>
    <th><?= lang("store"); ?></th>
    <th><?= lang("product"); ?></th>
    <th><?= lang("batch_no"); ?></th>
    <th><?= lang("brand"); ?></th>
    <th><?= lang("cat/subcat"); ?></th>
    <th><?= lang("supplier"); ?></th>
    <th><?= lang("stock_type"); ?></th>
    <th><?= lang("stock_out_reason"); ?></th>
    <th class="text-center"><?= lang("quantity"); ?></th>
    <?php
    $type= $this->session->userdata['login_info']['user_type_i92'];
    if($columns[0]->permission==1||$type==3){
      echo '<th class="text-right">'. lang('purchase') . ' (' . set_currency() . ')</th>';
      echo '<th class="text-right">'.lang('total'). ' (' . set_currency() . ')</th>';
    }
    ?>
    
</thead>
<tbody>
    <?php
    $total_qty=0;
    $total=0;
    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
          foreach ($categories as $category) {
              if ($category->id_product_category == $post['cat_id']) {
                  $val = $category->cat_name;
                  break;
              }
          }
          $sub_category_name = '';
          foreach ($categories as $category) {
              if ($category->id_product_category == $post['subcat_id'] && $category->parent_cat_id != null) {
                  $sub_category_name = $category->cat_name;
                  break;
              }
          }
          $supplier_name = '';
          foreach ($suppliers as $supplier) {
              if ($supplier->id_supplier == $post['supplier_id']) {
                  $supplier_name = $supplier->supplier_name;
                  break;
              }
          }
          echo '<tr>';
          $date = date('Y-m-d',strtotime($post['dtt_stock_mvt']));
          echo '<td>' . $date . '</td>';
          echo '<td>' . $post['store_name'] . '</td>';
          echo '<td>' .  $post['product_name'].' ('.$post['product_code'].')' . '</td>';
          echo '<td>' . $post['batch_no'] . '</td>';
          echo '<td>' . $post['brand_name'] . '</td>';
          echo '<td>' . $val . '/' . $sub_category_name . '</td>';
          echo '<td>' . $supplier_name . '</td>';
          echo '<td>'.$post['type_name'].'</td>';
          echo '<td>'.$post['reason'].'</td>';
          echo '<td class="text-center">' . $post['qty'] . '</td>';
          if($columns[0]->permission==1||$type==3){
              echo '<td class="text-right">'. round($post['purchase_price'],2).'</td>';
              $total += ($post['qty'] * $post['purchase_price']);
              $sub=$post['qty'] * $post['purchase_price'];
              echo'<td class="text-right">'. number_format((float)$sub, 2, '.', '') .'</td>';
          }                  
          echo '</tr>';
          $total_qty+=$post['qty'];
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
    <th colspan="8"></th>
    <th><?= lang("total"); ?></th>
    <th class="text-center"><?= number_format($total_qty, 2); ?></th>
    <?php 
    if($columns[0]->permission==1||$type==3){
        echo'<th colspan="2" class="text-right">'. number_format((float)$total, 2, '.', '') .'</th>';
    }  
    ?>

    </tfoot>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>


<script type="text/javascript">
    
function searchFilter2(id) {
      // var invoice_id=$('#invoiceNo').html();
      // $(this).text();
      // alert(id);
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>stock-out-report/page-data2/' + id ,
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