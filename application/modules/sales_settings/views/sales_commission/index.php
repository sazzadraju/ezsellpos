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
                    <div class="top-btn full-box">
                        <div class="row">
                        </div>
                    </div>


                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?=base_url().'sales-commission/add'?>" class="btn btn-primary btn-rounded right" id="add_s_p"><?= lang('add_sales_transaction') ?></a>

                            </div>
                        </div>
                        <!---Add Modal BOX-->

                        <div id="add" class="modal fade" role="dialog">
                            <div class="modal-dialog ">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="element-header margin-0"><?= lang('add_sales_person') ?> <span
                                                    class="close" data-dismiss="modal">&times;</span></h6>
                                    </div>
                                    <?php echo form_open_multipart('', array('id' => 'sales_person_info', 'class' => 'cmxform')); ?>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div id="error" class="error"></div>
                                            <div class="form-group">
                                                <label class="col-sm-4 col-form-label"><?= lang('person_type') ?><span
                                                            class="req">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" id="person_type" name="person_type">
                                                            <option value="0" selected><?= lang('select_one') ?></option>
                                                        <?php foreach ($this->config->item('sales_person') as $key=>$val) : ?>
                                                            <option value="<?php echo $key;?>"><?php echo $val; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="type_details">

                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <input class="btn btn-primary" type="submit"
                                               value="<?= lang('submit') ?>"> </button>

                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal"><?= lang('close') ?></button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <?php
                                    $this->load->view('sales_commission/all_sales_commission_data');
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
<!--View Modal Start-->
<script>
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
//        var name_customer = $('#name_customer').val();
//        var phone_customer = $('#phone_customer').val();
//        var type_of_customer = $('#type_of_customer').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>sales-commission/paginate-data/' + page_num,
            data: 'page=' + page_num,
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