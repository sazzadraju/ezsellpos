<div tabindex="-1" class="modal fade" id="imageModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-sm">
            <button class="close" type="button" data-dismiss="modal">×</button>
            <div class="modal-body-img">

            </div>
        </div>
    </div>
</div>
 <div class="showmessage" id="showMessage" style="display: none;"></div>
<div class="loading"  style="display: none;">
    <div class="loader"></div>
</div>
<script src="<?= base_url()?>themes/default/js/jquery-ui.min.js"></script> 
<script src="<?= base_url()?>themes/default/js/bootstrap.min.js"></script>
<script src="<?= base_url()?>themes/default/js/moment.js"></script>
<script src="<?= base_url()?>themes/default/js/select2.full.min.js"></script>
<script src="<?= base_url()?>themes/default/js/select.js"></script>
<script src="<?= base_url()?>themes/default/js/editor.js"></script> 
<script type="text/javascript" src="<?= base_url()?>themes/default/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>themes/default/js/main.js"></script>
<script type="text/javascript">
$(document).ready( function() {
$("#txtEditor").Editor();                    
});
</script>

</body>

</html>