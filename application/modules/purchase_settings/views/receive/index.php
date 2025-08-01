<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>
<div class="col-md-12">
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="full-box element-box">
                        <div class="row"> 
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("invoice_no"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="invoice_no" name="invoice_no" placeholder="<?= lang("invoice_no"); ?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12col-form-label"><?= lang("store_name"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <select class="select2" id="store_name" name="store_name">
                                                <option value="0" selected><?= lang("select_one"); ?></option>
                                                <?php
                                                foreach ($stores as $store) {
                                                    if ($this->session->userdata['login_info']['user_type_i92'] == 3) {
                                                        echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                    } else if ($this->session->userdata['login_info']['store_id'] == $store->id_store) {
                                                        echo '<option value="' . $store->id_store . '">' . $store->store_name . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("supplier_name"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="supplier_name" name="supplier_name" placeholder="<?= lang("supplier_name"); ?>" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-4">
                                <label class="col-sm-12 col-form-label">&nbsp;</label>
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i class="fa fa-search"></i> <?= lang("search"); ?></button>
                            </div>
                            </form> 
                        </div>
                    </div>
                    <div class="element-box full-box">
                        <h6 class="element-header"><?= lang("purchase_receive") ?></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php
                                    $this->load->view('receive/all_receive_data', $posts, false);
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!---Add view BOX--->
<div id="view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("order_details"); ?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <div class="modal-body">
                <div class="data-view" id="order_view_data">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
            </div>
        </div>

    </div>
</div>
<script>
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var invoice_no = $('#invoice_no').val();
        var store_name = $('#store_name').val();
        var supplier_name = $('#supplier_name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>purchase_receive/page_data/' + page_num,
            data: 'page=' + page_num + '&store_name=' + store_name + '&supplier_name=' + supplier_name + '&invoice_no=' + invoice_no,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
    function viewReceiveDetaitls(id) {
        $.ajax({
            url: "<?php echo base_url() ?>purchase_receive/details/" + id,
            type: "GET",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                $('#order_view_data').html(data);
                $('.loading').fadeOut("slow");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

    }

</script>
