<div class="content-i">
    <div class="content-box">
        <div class="element-box full-box">
             <br>
 
             <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            

            <h6 class="element-header">CSV Preview</h6>
                <form id="fileImport" method="post" action="<?php echo base_url() ?>csv/previewcsv" enctype="multipart/form-data">
                    <input type="file" name="userfile" required><br><br>
                    <input type="submit" name="submit" value="Preview" class="btn btn-primary">
                </form> 
            <br><br> 
            <hr>


            <script type="text/javascript">                
                $( document ).ready(function() {
                    $('#fileImport').validate();
                });
            </script>

            </div></div></div>