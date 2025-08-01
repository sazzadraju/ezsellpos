<html>

<head>
  <title>EZSellbd.com</title>
  <meta charset="utf-8">

 
  <link rel="stylesheet" href="http://localhost/pos03/themes/default/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://localhost/pos03/themes/default/css/editor.css"> 
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css"> 
  <link href="http://localhost/pos03/themes/default/css/select2.min.css" rel="stylesheet">
  <link href="http://localhost/pos03/themes/default/css/select.css" rel="stylesheet">
  <link href="http://localhost/pos03/themes/default/css/main.css" rel="stylesheet">
  <link href="http://localhost/pos03/themes/default/css/custom.css" rel="stylesheet">
</head>

<body>
  <div class="content-i"> 
    <div class="content-box">
      <form action="stock_mismatch_submit" method="post" enctype="multipart/form-data">


        <div class="row"> 
          <div class="col-md-8 col-sm-12">
            <div class="row">
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
                    <td width="50">Sale Store</td>
                    <td>Qty</td>
                    <td width="120">Sale Date</td>

                    <td width="50">Org Sale Store</td>
                    <td width="50">Sale Stock</td>
                    <td width="50">Stock Qty</td>

                    <td width="50">Stock Id</td>
                    <td width="50">Stock Store</td>
                    <td width="40">Current Stock Qty</td>
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
           </div>
         </div>
         <div class="col-md-4 col-sm-12">
            <div class="row">
              <table class="" border="1">
                <thead>
                  <tr>
                    <th colspan="5" style="text-align: center;">Mismatch Stock Details</th>
                  </tr>
                  <tr>
                    <td>S/L</td>
                    <td>Product</td>
                    <td>Stock Id</td>
                    <td>Store</td>
                    <td>Qty</td>
                  </tr>
                </thead>
                <tbody>

                  <?php 
                  // echo '<pre>';
                  // print_r($mitmatch_row);
                  // echo '</pre>';
                  $count=1;
                  foreach ($maismatch_stock_array as $key=>$value) {
                    $stocks = $this->commonmodel->getvalue_row_one('stocks', 'product_id,batch_no,id_stock,store_id,qty', array('id_stock' => $value));
                    echo '<tr>';
                    echo '<td>'.$count.'</td>';
                    echo '<td>'.$stocks[0]['product_id'].'('.$stocks[0]['batch_no'].')</td>';
                    echo '<td>'.$stocks[0]['id_stock'].'</td>';
                    echo '<td>'.$stocks[0]['store_id'].'</td>';
                    echo '<td>'.$stocks[0]['qty'].'</td>';
                    echo '</tr>';
                    $count++;
                  }
                  ?>
                </tbody>
              </table>
           </div>
         </div>
     </div>
     <div class="row">
       <div class="col-md-8 col-sm-12">
            <div class="row">
              <table class="" border="1">
                <thead>
                  <tr>
                    <th colspan="9" style="text-align: center;">Mismatch Stock Details</th>
                  </tr>
                  <tr>
                    <td>S/L</td>
                    <td>Sale Id</td>
                    <td>Product</td>
                    <td>Sale Store</td>
                    <td>Qty</td>
                    <td>Sale Date</td>
                    <td>Stock Id</td>
                    <td>Stock Store</td>
                    <td>Current Stock Qty</td>
                  </tr>
                </thead>
                <tbody>

                  <?php 
                  // echo '<pre>';
                  // print_r($mitmatch_row);
                  // echo '</pre>';
                  $count=1;
                  foreach ($details_stock_array as $key=>$value) {
                    $sale = $this->mitmatch_model->get_sale_stock_details($value);
                    echo '<tr>';
                    echo '<td>'.$count.'</td>';
                    echo '<td>'.$sale[0]['id_sale'].'</td>';
                    echo '<td>'.$sale[0]['product_id'].'('.$sale[0]['batch_no'].')</td>';
                    echo '<td>'.$sale[0]['store_id'].'</td>';
                    echo '<td>'.$sale[0]['sale_qty'].'</td>';
                    echo '<td>'.nice_date($sale[0]['dtt_add']).'</td>';
                    echo '<td>'.$sale[0]['id_stock'].'</td>';
                    echo '<td>'.$sale[0]['stock_store_id'].'</td>';
                    echo '<td>'.$sale[0]['stock_qty'].'</td>';
                    echo '</tr>';
                    $count++;
                  }
                  ?>
                </tbody>
              </table>
           </div>
         </div>
     </div>
   </form>
 </div>
</div>


<script src="http://localhost/pos03/themes/default/js/jquery-ui.min.js"></script> 
<script src="http://localhost/pos03/themes/default/js/bootstrap.min.js"></script>
<script src="http://localhost/pos03/themes/default/js/select2.full.min.js"></script>
<script src="http://localhost/pos03/themes/default/js/select.js"></script>
<script src="http://localhost/pos03/themes/default/js/main.js"></script>

</body>
</html>

