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

                            <!--                            <form action="">-->
                            <!--                                <div class="col-md-3">-->
                            <!--                                    <div class="form-group row">-->
                            <!--                                        <label class="col-sm-12 col-form-label" for="">-->
                            <? //= lang('customer_name') ?><!-- </label>-->
                            <!--                                        <div class="col-sm-12">-->
                            <!--                                            <input class="form-control" placeholder="-->
                            <? //= lang('customer_name') ?><!--" type="text" id="name_customer" name="name_customer">-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                                <div class="col-md-3">-->
                            <!--                                    <div class="form-group row">-->
                            <!--                                        <label class="col-sm-12 col-form-label" for="">-->
                            <? //= lang('phone') ?><!-- </label>-->
                            <!--                                        <div class="col-sm-12">-->
                            <!--                                            <input class="form-control" placeholder="-->
                            <? //= lang('phone') ?><!--" type="text" name="phone_customer" id="phone_customer">-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                                <div class="col-md-3 col-sm-12">-->
                            <!--                                    <div class="form-group row">-->
                            <!--                                        <label class="col-sm-12 col-form-label">-->
                            <? //= lang('type_of_customer') ?><!-- </label>-->
                            <!--                                        <div class="col-sm-12">-->
                            <!---->
                            <!--                                            <div class="row-fluid">-->
                            <!--                                                <select class="select2" data-live-search="true" name="type_of_customer" id="type_of_customer">-->
                            <!--                                                    <option value="0" selected>-->
                            <? //= lang('select_one') ?><!--</option>-->
                            <!--                                                    --><?php
                            ////                                                    if ($customer_type_list) {
                            //                                                    //                                                        foreach ($customer_type_list as $type_list) {
                            //                                                    //                                                            ?>
                            <!--                                                    <!--                                                            <option value="-->
                            <?php ////echo $type_list['id_customer_type']; ?><!--<!--">-->
                            <?php ////echo $type_list['name']; ?><!--<!--</option>-->
                            <!--                                                    <!--                                                            -->
                            <?php
                            //                                                    //                                                        }
                            //                                                    //                                                    }
                            //                                                    ?>
                            <!--                                                </select>-->
                            <!--                                            </div>-->
                            <!---->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!---->
                            <!--                                <div class="col-lg-1">-->
                            <!---->
                            <!--                                    <label class="col-sm-12 col-form-label" for="">&nbsp;</label>-->
                            <!--                                    <button class="btn btn-primary btn-rounded center" type="button" onclick="searchFilter();"><i class="fa fa-search"></i></button>-->
                            <!--                                </div>-->
                            <!--                            </form>-->
                        </div>
                    </div>


                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url().'add-order/add'?>" class="btn btn-primary btn-rounded right"><?= lang('add_order') ?></a>
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
                                    $this->load->view('add_order/all_order_data');
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
<div id="edit_person" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang('edit_sales_person') ?> <span class="close" data-dismiss="modal">&times;</span></h6>
            </div>
            <?php echo form_open_multipart('', array('id' => 'sales_person_edit', 'class' => 'cmxform')); ?>
            <div class="modal-body">
                <div class="row">
                    <div id="edit_error" class="error"></div>
                    <div class="form-group">
                        <label class="col-sm-4 col-form-label"><?= lang('person_type') ?><span
                                    class="req">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="type" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-form-label"><?= lang('person_name') ?><span
                                    class="req">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="name" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-form-label"><?= lang('commission') ?>(%)<span
                                    class="req">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="commission" name="commission" class="form-control Number">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input name="c_id" id="c_id" type="hidden">
                <input class="btn btn-primary" type="submit"
                       value="<?= lang('update') ?>"> </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>
<script>
    $(function () {
        $('#add_s_p').click(function(){
            $('#sales_person_info')[0].reset();
            $('#error').html('');
            $('#type_details').html('');

        });
        $("select#person_type").change(function(){
            $('#error').html('');
            var id=$(this).val();
            $.ajax({
                type: "POST",
                url: URL + "sales_settings/sales_person/person_list",
                data: {id : id},
                success: function (result) {
                    $('#type_details').html(result);
                }
            });
        });
    });
    $("#sales_person_info").submit(function () {
        $('#error').html('');
        var type=$('#person_type option:selected').val();
        var name=$('#person_name option:selected').val();
        var com=$('#commission').val();
        if(type=='0'||name=='0'||com==''){
            $('#error').html('Select all requuired fields');
        }else{
            var dataString = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: URL + "sales_settings/sales_person/add_person_commission",
                data: dataString,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    $('.loading').fadeOut("slow");
                    if(result=='3'){
                        $('#error').html('Sales Person Already Exists.');
                    }else{
                        $('#add').modal('toggle');
                        $('#showMessage').html("<?= lang('add_success')?>");
                        $('#showMessage').show();
                        window.onload = searchFilter(0);
                        setTimeout(function () {
                            $('#showMessage').fadeOut(300);

                        }, 3000);
                    }

                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
    });
    function editSales(id){
        var name=$('#name_'+id).html();
        var person=$('#person_'+id).html();
        var com=$('#com_'+id).html();
        //alert(com);
        $('#type').val(name);
        $('#name').val(person);
        $('#commission').val(com);
        $('#c_id').val(id);
        $('#edit_person').modal("show");
    }
     $("#sales_person_edit").submit(function () {
        $('#edit_error').html('');
        var com=$('#commission').val();
        if(com==''){
            $('#edit_error').html('Select all requuired fields');
        }else{
            var dataString = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: URL + "sales_settings/sales_person/update_person_commission",
                data: dataString,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    $('.loading').fadeOut("slow");
                    $('#edit_person').modal('toggle');
                    $('#showMessage').html("<?= lang('update_success')?>");
                    $('#showMessage').show();
                    window.onload = searchFilter(0);
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
    });
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>add-order/paginate-data/' + page_num,
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