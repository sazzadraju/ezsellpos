
<?php
$company_name =$client_logo= $address='';

foreach ($configs as $value) {


    $company_name = ($value->param_key == 'COMPANY_NAME') ? $value->param_val : $company_name;
     $address = ($value->param_key == 'ADDRESS') ? $value->param_val : $address;
     $client_logo = ($value->param_key == 'CLIENT_LOGO') ? $value->param_val : $client_logo;
    
}
?>
<div class="col-md-12"> 
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div> 

      <div class="content-i">
                <div class="content-box">
                    <div class="element-wrapper"> 
                    
                            <div class="element-box">
                           <div class="stk-main-content">
                               <div class="header-info">  
                                <div class="row">
                                      <div class="col-md-12">
                                  <div class="company-logo"><img src="<?php base_url(); ?>your-logo-here-27.png" alt=""></div>
                                  <div class="ifo">
                                        <h1 class="creation-date"><span>Stock Report</span></h1>
                                         <h1 class="cmpny-name"> <?php echo $company_name; ?></h1>
                                    <h5 class="comapny-des"><?php echo $address; ?></h5>
                                  </div>
                                   </div> 
                                     <div class="col-md-12">
                                <div class="head-info">
                                        <!-- <h6 class="creation-date"><span>Invoice No</span> : 165</h6> -->
                                    <h6 class="creation-date"><span>Print Date</span> :<?php echo date('d-m-y'); ?></h6>   
                                    <h6 class="creation-date"><span>Printed by</span> :  <?php foreach ($username as $user) {
                                        echo  $username->uname;
                                    }?></h6>   
                                        <button class="btn btn-sm right"><i class="fa fa-download"></i></button>
                                    <button class="btn btn-sm right margin-right-10"><i class="fa fa-eye"></i></button>
                                </div>
                                    </div>
                                </div>
                                </div>  
                                <div class="stk-details-bdy">
                                     
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="tblSample">
                                        <thead>
                                            <tr style="background: #656565; color: #fff;">
                                                <th><?= lang("product_code"); ?></th>
                                                <th><?= lang("product_name"); ?></th>
                                                <th><?= lang("category"); ?></th>
                                                <!-- <th><?= lang("sub_category"); ?></th> -->
                                                <th><?= lang("supplier"); ?></th>
                                                <th><?= lang("batch_no"); ?></th>
                                                <th><?= lang("quantity"); ?></th>
                                                <!-- <th><?= lang("qty-total"); ?></th> -->
                                                <th><?= lang("purchase_price"); ?></th>
                                                <th><?= lang("selling_price"); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          if (!empty($posts)):
                                              $count = 1;
                                              $sum=0;
                                              $compire1=0;
                                              $compire2=0;

                                              foreach ($posts as $post):
                                                  ?>
                                                  <tr>
                                                      <?php
                                                       echo '<td>' . $compire1=$post['product_code'] . '</td>';
                                                      echo '<td>' . $post['product_name'] . '</td>';
                                                       
                                                      foreach ($categories as $category) {
                                                          if ($category->id_product_category == $post['cat_id']) {
                                                              $val = $category->cat_name;
                                                              break;
                                                          }
                                                      }
                                                       foreach ($suppliers as $supplier) {
                                                          if ($supplier->id_supplier == $post['supplier_id']) {
                                                              $val2 = $supplier->supplier_name;
                                                              break;
                                                          }
                                                      }
                                                       if($compire2==$compire1){
                                                          $sum=$sum+$post['qty'];
                                                          $compire2=$compire1;
                                                      }
                                                       else
                                                      {
                                                          $sum=$post['qty'];
                                                          $compire2=$compire1;
                                                      }
                                                          echo '<td>' . $val . '</td>';
                                                      echo '<td>' . $val2 . '</td>';
                                                      echo '<td>' . $post['batch_no'] . '</td>';
                                                      echo '<td>' .$post['qty'] . '</td>';
                                                      // echo '<td >'. $sum.'</td>';
                                                      echo '<td>' . $post['purchase_price'] . '</td>';
                                                      echo '<td>' . $post['selling_price_act'] . '</td>'; 
                                                      // echo '<td>' . $post['batch_no'] . '%</td>';
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
                                    </table> 
                                </div> 
                                </div>
                                
                            <div class="footer-info">     
                                <div class="row"> 
                                     <div class="col-md-12">
                                     <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae nulla dolores aut sit nihil alias molestiae reprehenderit quae atque ipsum veniam commodi voluptas asperiores, expedita, voluptate eius molestias eum assumenda.</p>
                                    <!-- <h6 class="creation-date"><span>Invoice No</span> : 165</h6> -->
                                   <h6 class="creation-date"><span>Print Date</span> :<?php echo date('d-m-y'); ?></h6>   
                                    <h6 class="creation-date"><span>Printed by</span> : <?php foreach ($username as $user) {
                                        echo  $username->uname;
                                        // echo "<pre>";
                                        // print_r($username);
                                    }
                                    

                                     ?></h6>   
                                    </div> 
                                </div>
                                </div> 
                                </div>
                            </div> 
                    </div>
                </div>
 
            </div>
    </div>
    </div>
    <div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
<script type="text/javascript">
    

    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var product_name = $('#product_name').val();
        var cat_name = $('#cat_name').val();
        var pro_sub_category = $('#pro_sub_category').val();
        // var price_range = $('#priceRange').val();
        var supplier_id = $('#supplier_id').val();
        var FromDate = $('#FromDate').val();
        var ToDate = $('#ToDate').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>stock/page_data/' + page_num,
            data: 'page=' + page_num + '&cat_name=' + cat_name + '&product_name=' + product_name + '&pro_sub_category=' + pro_sub_category + '&supplier_id=' + supplier_id + '&FromDate=' + FromDate + '&ToDate=' + ToDate,
            // beforeSend: function () {
            //     $('.loading').show();
            // },
            success: function (html) {
                console.log(html);
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    // $(document).ready(function () {
    //     $('#tblSample').each(function () {
    //         var Column_number_to_Merge = 7;
 
    //         // Previous_TD holds the first instance of same td. Initially first TD=null.
    //         var Previous_TD = null;
    //         var i = 1;
    //         $("tbody",this).find('tr').each(function () {
    //             // find the correct td of the correct column
    //             // we are considering the table column 1, You can apply on any table column
    //             var Current_td = $(this).find('td:nth-child(' + Column_number_to_Merge + ')');
                 
    //             if (Previous_TD == null) {
    //                 // for first row
    //                 Previous_TD = Current_td;
    //                 i = 1;
    //             } 
    //             else if (Current_td.text() == Previous_TD.text()) {
    //                 // the current td is identical to the previous row td
    //                 // remove the current td
    //                 Current_td.remove();
    //                 // increment the rowspan attribute of the first row td instance
    //                 Previous_TD.attr('rowspan', i + 1);
    //                 i = i + 1;
    //             } 
    //             else {
    //                 // means new value found in current td. So initialize counter variable i
    //                 Previous_TD = Current_td;
    //                 i = 1;
    //             }
    //         });
    //     });
    // });

    $(function() {  

function groupTable($rows, startIndex, total){
if (total === 0){
return;
}
var i , currentIndex = startIndex, count=1, lst=[];
var tds = $rows.find('td:eq('+ currentIndex +')');
var ctrl = $(tds[0]);
lst.push($rows[0]);
for (i=1;i<=tds.length;i++){
if (ctrl.text() ==  $(tds[i]).text()){
count++;
$(tds[i]).addClass('deleted');
lst.push($rows[i]);
}
else{
if (count>1){
ctrl.attr('rowspan',count);
groupTable($(lst),startIndex+1,total-1)
}
count=1;
lst = [];
ctrl=$(tds[i]);
lst.push($rows[i]);
}
}
}
groupTable($('#tblSample tr:has(td)'),0,3);
$('#tblSample .deleted').remove();
});

var first_row = '<tr class="row"><td class="id">NULL</td></tr>';
var rowCount = 0;
var rowSum = 0;
$.each($('.row'), function (index, curRow) {
    if ($(first_row).find('.id').text() != $(curRow).find('.id').text()) {
        if (rowCount > 1) {
            $(first_row).find('.val').text(rowSum);
            $(first_row).find('.val').attr('rowspan', rowCount).css('background-color','silver');
            for (i = 0; i < rowCount; i++) {
                $(first_row).next('.row').find('.val').remove();
            }
        }
        first_row = $(curRow);
        rowSum = 0;
        rowCount = 0;
    }
    rowSum += parseInt($(curRow).find('.val').text());
    rowCount += 1;
});
if (rowCount > 1) {
    $(first_row).find('.val').text(rowSum);
    $(first_row).find('.val').attr('rowspan', rowCount).css('background-color','silver');
    for (i = 0; i < rowCount; i++) {
        $(first_row).next('.row').find('.val').remove();
    }
}    


function deleteSelectedRows() {    
 var table = document.getElementById('tblSample');
 var rowCount = table.rows.length;        
 for(var i=0; i< rowCount; i++) {

  var row = table.rows[i];            
  var chkbox = row.cells[0].childNodes[0];             
  if(null != chkbox && true == chkbox.checked) {
   nbRows = row.cells[0].rowSpan + 1; // the number of row to delete
   for(var j=0; j<nbRows; j++) {       
    table.deleteRow(i); //delete the selected rows  
    rowCount--; 
   }
   i--;               
  }             
 }
}

</script>
