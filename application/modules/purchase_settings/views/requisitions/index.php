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
                                    <label class="col-sm-12 col-form-label"
                                           for=""><?= lang("product_code_name"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="product_name" name="product_name"
                                               placeholder="<?= lang("product_code_name"); ?>" type="text">
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
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("user_name"); ?></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="user_name" name="user_name"
                                               placeholder="<?= lang("user_name"); ?>" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-4">
                                <label class="col-sm-12 col-form-label">&nbsp;</label>
                                <button class="btn btn-primary" type="button" onclick="searchFilter()"><i
                                        class="fa fa-search"></i> <?= lang("search"); ?></button>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo base_url(); ?>add-requisition"
                                   class="btn btn-primary btn-rounded right"
                                   type="button"><?= lang('add_requisition') ?></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php
                                    $this->load->view('requisitions/all_requisition_data', $posts, false);
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
<script>
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var product_name = $('#product_name').val();
        var store_name = $('#store_name').val();
        var user_name = $('#user_name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>requisition/page_data/' + page_num,
            data: 'page=' + page_num + '&store_name=' + store_name + '&user_name=' + user_name + '&product_name=' + product_name,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }

</script>