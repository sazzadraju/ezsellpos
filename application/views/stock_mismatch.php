<html>

<head>
  <title>EZSellbd.com</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css"> 
</head>

<body>
  <div class="content-i"> 
    <div class="content-box">
      <div class="row">
        <form action="stock_mismatch_submit" method="post" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to submit the form?');">
          <div class="col-md-4 col-sm-12">
            <div class="form-group row">
              <label class="col-sm-12 col-form-label" for=""><?= lang("product_name"); ?></label>
              <div class="col-sm-12">
                <div class="row-fluid">
                  <select class="select2" onchange="get_batch(this)" data-live-search="true" id="product_id" name="product_id">
                   <option value="0" selected><?= lang("select_one"); ?></option>
                   <?php
                   foreach ($products as $row) {

                     echo '<option value="' . $row->id_product . '">' .$row->id_product .'='.$row->product_name.' ('.$row->product_code . ')</option>';

                   }
                   ?>
                 </select>
               </div>
             </div>
           </div>
         </div>
         <div class="col-md-3 col-sm-12">
          <div class="form-group row">
            <label class="col-sm-12 col-form-label" for=""><?= lang("batch"); ?></label>
            <div class="col-sm-12">
              <div class="row-fluid">
                <select class="select2" data-live-search="true" id="batch" name="batch">
                 <option value="0" selected><?= lang("select_one"); ?></option>
               </select>
             </div>
           </div>
         </div>
       </div>
       <div class="col-md-2 col-sm-12" style="display: none;" id="show_submit">
        <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
        <div class="col-sm-12">
         <input type="submit" name="submit" value="submit" class="btn btn-primary">
       </div>
     </div>
     <div class="col-md-2 col-sm-12" id="show_button">
      <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
      <div class="col-sm-12">
        <button type="button" onclick="show_data()" class="btn btn-primary">Search Data</button>
     </div>
   </div>
 </form>
</div>
<div class="row">
 <div class="col-md-12" id="show_search_data"></div>
</div>
</div>
</div>
<script type="text/javascript">
 function get_batch(el) {
  var id=el.value;
  $.ajax({
    type: "POST",
    url: "get_batch",
    data:'id='+id,
    success: function(data){
      $("#batch").html(data);
    }
  }); 
} 
function show_data() {
  var id=$('#product_id option:selected').val();
  var batch=$('#batch option:selected').val();
  $.ajax({
    type: "POST",
    url: "temp_show_mismatch_data",
    data:'product_id='+id+'&batch='+batch,
    success: function(data){
      $("#show_search_data").html(data);
      $('#show_submit').show();
      $('#show_button').hide();
    }
  }); 
}

</script>

<script src="http://localhost/pos03/themes/default/js/jquery-ui.min.js"></script> 
<script src="http://localhost/pos03/themes/default/js/bootstrap.min.js"></script>
<script src="http://localhost/pos03/themes/default/js/select2.full.min.js"></script>
<script src="http://localhost/pos03/themes/default/js/select.js"></script>
<script src="http://localhost/pos03/themes/default/js/main.js"></script>

</body>
</html>

