    <form id="appendedServices">
      <div class="form-group row">   
          <div class="col-sm-6">                    
              <input class="form-control" name="typeName" placeholder="Service Name" type="hidden" value="<?php echo $stdata['service_name'];?>" >
              <label class="col-form-label" for="typePrice">Price</label>
              <input class="form-control" name="typePrice" placeholder="Price" type="text" value="<?php echo $stdata['service_price'];?>">
          </div>
          <div class="col-sm-6">  
              <label class="col-form-label" for="pQuantity">Quantity</label>
              <input class="form-control" name="pQuantity" type="text" value="1">
          </div>
      </div> 
      <fieldset class="form-group row">
          <legend>Measerments</legend>
          <?php
            $mid = 0;
            foreach ($stdata['fields'] as $sField):
          ?>  
          <div class="col-sm-6">         
            <?php  
              if($sField['is_required'] == 1){
                $rcr = 'required';
                $str = '<span class="req">*</span>';
              }else{
                $rcr = '';
                $str = '';
              }
              $measurValue='';
              if($measurements){
                foreach ($measurements as $value) {
                  if($sField['id_field']==$value['field_id']){
                    $measurValue=$value['field_value'];
                  }
                }
              }
            ?>  
              <label class="col-form-label" for="fName[]"><?php echo $sField['field_name'].$str;?></label>
              <input class="form-control" id="mid-<?php echo $mid;?>" name="fName[]" placeholder="<?php $sField['field_name'];?>" type="text" <?php echo $rcr;?> value="<?= $measurValue?>">
              <input name="fieldId" id="fid-<?php echo $mid;?>" value="<?php echo $sField['id_field'];?>" type="hidden">
          </div>  
          <?php
            $mid++;    
            endforeach;
          ?>
      </fieldset>  
      <div class="form-group row">
          <div class="col-sm-12">                      
          <label class="col-form-label" for="">Select Design</label>
          </div>     
          <?php        
            $i = 0;
            foreach ($stdata['designs'] as $sDesigns):
          ?>
            <div class="col-sm-4">
              <input type="checkbox" id="cb<?php echo $i;?>" name="seleDesign[]" value="<?php echo $sDesigns['id_field'];?>"/>
                <label for="cb<?php echo $i;?>">
                <?php
                if ($sDesigns['field_img'] != NULL) {
                    echo '<img src="' . documentLink('tailoring') . $sDesigns['field_img'] . '"width="100">';
                }
                ?>
              </label>
            </div>
          <?php  
            $i++;
            endforeach;
          ?>
          <div class="col-sm-12">  
            <div id="designImg">
          </div>
      </div>
      <div class="form-group row">
          <div class="col-sm-12">  
              <label class="col-form-label" for="">Note</label>
              <textarea name="notes" class="form-control" rows="6"></textarea>    
          </div>
      </div>   
    </div> 
    <div class="form-buttons-w">
        <button  id="addSerToTbl" class="btn btn-primary right   margin-right-5" type="submit">Add Service</button>
    </form>

    <script src="<?= base_url()?>themes/default/js/jquery.validate.min.js"></script>

    <script type="text/javascript">
      $('#appendedServices').validate({
        rules: {
            "typePrice": {
                required: true,
                number: true
            },
            "pQuantity": {
                required: true,
                number: true
            }
        },
        submitHandler: function() {

          var serviceId = $('#serviceLoader').val();
          var typeName = $('#ServiceForm input[name="typeName"]').val();
          var typePrice = $('#ServiceForm input[name="typePrice"]').val();
          var pQuantity = $('#ServiceForm input[name="pQuantity"]').val();
          var fName = $('#ServiceForm input[name^="fName"]').map(function(){return $(this).val();}).get();
          var fieldId = $('#ServiceForm input[name^="fieldId"]').map(function(){return $(this).val();}).get();

          var seleDesign = $("input[name='seleDesign[]']:checked").map(function(){
            return $(this).val();
          }).get();

          var notes = $('#ServiceForm textarea[name="notes"]').val();

          var ttrl = $("#serviceTable > tbody > tr").length;

          var tableRow = '<tr>';
              // tableRow += '<td>'+rowCount+'</td>';
              tableRow += '<td>'+typeName;   
                  tableRow += '<input type="hidden" id="serCount-'+ttrl+'" name="serCount[]" value="1">';
                  tableRow += '<input type="hidden" id="serID-'+ttrl+'" name="serID[]" value="'+serviceId+'">';
                  tableRow += '<input type="hidden" id="serName-'+ttrl+'" name="serName[]" value="'+typeName+'">';
                  tableRow += '<input type="hidden" id="mFieldsId-'+ttrl+'" name="mFieldsId[]" value="'+fieldId+'">';
                  tableRow += '<input type="hidden" id="mFields-'+ttrl+'" name="mFields[]" value="'+fName+'">';   
                 
                  tableRow += '<input type="hidden" id="sDesignId-'+ttrl+'" name="sDesignId[]" value="'+seleDesign+'">';
                  // notes
                  tableRow += '<input type="hidden" id="sNote-'+ttrl+'" name="sNote[]" value="'+notes+'">';
              tableRow += '</td>';
              tableRow += '<td>';   
              tableRow += '<input type="text" id="serPrice-'+ttrl+'" class="form-control" name="serPrice[]" value="'+typePrice+'">';                 
              tableRow += '</td>';
              tableRow += '<td><input class="form-control" id="pQuan-'+ttrl+'" name="pQuantity[]" type="text" value="'+pQuantity+'"</td>';
            
            tableRow += '<td><input class="form-control" id="pTotal-'+ttrl+'" name="pTotal[]" type="text" value="" readonly /> </td>';
            
              tableRow += '<td><button type="button" class="btn btn-danger btn-xs serviceDelete" ><span class="glyphicon glyphicon-trash"></span></button></td>';
          tableRow += '</tr>';                          

          if(ttrl > 0){
              $('#serviceTable tbody tr:last').after(tableRow);

              var tc = $('#sCost').val();
              var totl = Number(tc)+(Number(typePrice)*Number(pQuantity));
              $('#sCost').val(totl);

          }else{
              $('#serviceTable tbody').html(tableRow);

              tfot = '<tr>'; 
                tfot += '<td colspan="3">Total service price: </td>';
                tfot += '<td colspan="1"><input  id="sCost" name="sCost" class="form-control totalAmount" value="'+(typePrice*pQuantity)+'" disabled/></td>';
                tfot += '<td></td>';
              tfot += '</tr>';

              $('#serviceTable tfoot').html(tfot);
          }
          

          costCalculator();
          
          $( '#appendedServices' ).remove();

          $('#serviceLoader option:first').prop('selected',true);
        }
      });

    </script>
