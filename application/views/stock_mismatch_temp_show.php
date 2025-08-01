
<table class="" border="1">
  <thead>
    <tr>
      <th colspan="7" style="text-align: center;">Sale Details Part</th>
      <th colspan="3" style="text-align: center;">Original Stock Details</th>
      <th colspan="3" style="text-align: center;">Mismatch Stock Details</th>
    </tr>
    <tr>
      <td>S/L</td>
      <td>Sale Id</td>
      <td>Product Id</td>
      <td>Batch</td>
      <td >Sale Store</td>
      <td>Qty</td>
      <td>Sale Date</td>

      <td>Org Sale Store</td>
      <td >Sale Stock</td>
      <td >Stock Qty</td>

      <td >Stock Id</td>
      <td >Stock Store</td>
      <td >Current Stock Qty</td>
    </tr>
  </thead>
  <tbody>

    <?php 
                  // echo '<pre>';
                  // print_r($mitmatch_row);
                  // echo '</pre>';
    $count=1;
    if($mitmatch_row!=''){
      foreach ($mitmatch_row as $row) {
        echo '<tr>';
        echo '<td>'.$count.'</td>';
        echo '<td>'.$row['id_sale'].'</td>';
        echo '<td>'.$row['product_id'].'</td>';
        echo '<td>'.$row['batch_no'].'</td>';
        echo '<td>'.$row['store_id'].'</td>';
        echo '<td>'.$row['sale_qty'].'</td>';
        echo '<td>'.nice_date($row['dtt_add']).'</td>';
        echo '<td>'.$row['sale_stock_store_id'].'</td>';
        echo '<td>'.$row['sale_stock_id'].'</td>';
        echo '<td>'.$row['sale_stock_qty'].'</td>';
        echo '<td>'.$row['id_stock'].'</td>';
        echo '<td>'.$row['stock_store_id'].'</td>';
        echo '<td>'.$row['stock_qty'].'</td>';

        echo '</tr>';
        $count++;
      }
    }else{
      echo '<tr>';
      echo '<th colspan="13" style="text-align: center; color:red;">No Data Found</th>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>
