<?php
//dd($posts);
?>

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

                            <form action="">
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
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for=""><?= lang('title') ?> </label>
                                        <div class="col-sm-12">
                                            <input class="form-control" placeholder="<?= lang('title') ?>" type="text" id="title" name="title">
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><?= lang('promotion_type') ?> </label>
                                        <div class="col-sm-12">

                                            <div class="row-fluid">
                                                <select class="select2" data-live-search="true" name="type_id" id="type_id">
                                                    <<option value="0" selected><?= lang('select_one') ?></option>
                                                    <?php foreach($promotion_types as $key=>$val):?>
                                                        <option value="<?= $key;?>"><?= $val;?></option>
                                                    <?php endforeach;?>
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-1">

                                    <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                    <button class="btn btn-primary btn-rounded center" type="button" onclick="searchFilter();"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>



                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo base_url();?>add_promotion" class="btn btn-primary btn-rounded right" type="button"><?= lang('add_promotion')?></a>
                            </div>
                        </div>
                        <!---Add Modal BOX-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="postList">
                                    <table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                        <th><?= lang('sl_no') ?></th>
                                        <th><?= lang('title') ?></th>
                                        <th><?= lang('description') ?></th>
                                        <th><?= lang('promotion_type') ?></th>
                                        <th><?= lang('validity_from') ?></th>
                                        <th><?= lang('validity_to') ?></th>
                                        <th><?= lang('store_name') ?></th>
                                        <th><?= lang('status') ?></th>
                                        <th class="center"><?= lang('action') ?></th>
                                        
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            if (!empty($posts)) {
                                                foreach ($posts as $list) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $list['title']; ?></td>
                                                        <td><?php echo $list['details']; ?></td>
                                                        <td>
                                                        <?php 
                                                            if($list['type_id'] == 1){
                                                                echo "Promotion on Product";
                                                            }elseif($list['type_id'] == 2){
                                                                echo "Promotion on Purchase";
                                                            }elseif($list['type_id'] == 3){
                                                                echo "Promotion on Card";
                                                            }  
                                                        ?>
                                                                
                                                        </td>
                                                        <td><?php echo $list['dt_from']; ?></td>
                                                        <td><?php echo $list['dt_to']; ?></td>
                                                        <td><?php echo $list['store_name']; ?></td>
                                                        <td>
                                                            <?php 
                                                                if($list['status_id'] == 0 ){
                                                            ?>
                                                            <button class="btn btn-danger btn-xs">Inactive</button>
                                                            <?php
                                                                }elseif($list['status_id'] == 1){
                                                            ?>
                                                            <button class="btn btn-success btn-xs">Active</button>
                                                            <?php
                                                                }else{
                                                                  ?>
                                                            <button class="btn btn-danger btn-xs">Inactive</button>
                                                            <?php  
                                                                }
                                                            ?>
                                                                
                                                        </td>
                                                        <td class="center">
                                                            <a rel="tooltip" title="<?= lang("view")?>" href="<?php echo base_url(); ?>promotion_details/<?php echo $list['id_promotion']; ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                        <?php
                                                            if($list['dt_from'] > date('Y-m-d')){
                                                        ?>
                                                            <a rel="tooltip" title="<?= lang("edit")?>"  href="<?php echo base_url(); ?>reactive_promotion/<?php echo $list['id_promotion']; ?>" class="btn btn-primary btn-xs" data-title="Edit"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></a>

                                                        <?php
                                                            }else{
                                                        ?>
                                                                <a rel="tooltip" title="<?= lang("edit")?>" href="<?php echo base_url(); ?>edit_promotion/<?php echo $list['id_promotion']; ?>" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                                        <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if($list['status_id'] == 0){
                                                        ?>
                                                                <button rel="tooltip" title="<?= lang("delete")?>" class="btn btn-danger btn-xs" data-title="<?= lang('customer_name') ?>Delete" data-toggle="modal" data-target="#deletePromotionModal" onclick="deletePromotionID('<?php echo $list['id_promotion']; ?>');"><span class="glyphicon glyphicon-trash"></span></button>
                                                        <?php
                                                            }elseif($list['status_id'] == 1){
                                                        ?>
                                                                <button rel="tooltip" title="<?= lang("delete")?>" class="btn btn-danger btn-xs" data-title="<?= lang('customer_name') ?>Delete" data-toggle="modal" data-target="#inactivePromotionModal" onclick="inactivePromoID('<?php echo $list['id_promotion']; ?>');"><i class="fa fa-ban" aria-hidden="true"></i></button>
                                                        <?php
                                                            }
                                                        ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>        
                                        </tbody>

                                    </table>

                                    <div class="clearfix"></div>
                                    <?php echo $this->ajax_pagination->create_links(); ?>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<!--Delete Alert Start-->
<div class="modal fade" id="deletePromotionModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang('delect_this_entry') ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('confirm_delete') ?></div>

            </div>
            <div class="modal-footer ">
                <input type="hidden" name="delete_promotion_id" id="delete_promotion_id">
                <button type="button" class="btn btn-success" onclick="delete_promotion_info();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang('yes') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang('no') ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Delete Alert End-->



<div class="modal fade" id="inactivePromotionModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading"><?= lang('attention') ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?= lang('confirm_inactive') ?></div>

            </div>
            <div class="modal-footer ">
                <input type="hidden" name="inactive_promo_id" id="inactive_promo_id">
                <button type="button" class="btn btn-success" onclick="inactive_promotion_data();"><span class="glyphicon glyphicon-ok-sign"></span> <?= lang('yes') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?= lang('no') ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<script>
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var title = $('#title').val();
        var type_id = $('#type_id').val();
        var store_name = $('#store_name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>promotion-management/promotion_pagination_data/' + page_num,
            data: 'page=' + page_num + '&title=' + title + '&type_id=' + type_id+'&store_name='+store_name,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('#postList').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }


    function delete_customer_type(id)
    {
        if (confirm('Are you sure delete this data?'))
        {
            $.ajax({
                url: "<?php echo base_url() . 'customer_settings/customer/delete_customer_type' ?>/" + id,
                type: "POST",
                dataType: "JSON",
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (data)
                {
                    $('#showMessage').html('data successfully deleted..');
                    $('#showMessage').show();
                    window.onload = searchFilter(0);
                    setTimeout(function () {
                        $('#showMessage').fadeOut(300);

                    }, 3000);
                    $('.loading').fadeOut("slow");
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }


    function inactivePromoID(id) {
        $('#inactive_promo_id').val(id);
    }

    function inactive_promotion_data() {
        var id = $('#inactive_promo_id').val();
        $.ajax({
            url: '<?php echo base_url(); ?>promotion-management/inactive_promotion',
            data: {id: id},
            type: 'post',
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                $('#inactivePromotionModal').modal('toggle');
                $('#showMessage').html("<?php echo lang('inactive_success');?>");
                $('#showMessage').show();
                setTimeout(function () {
                    window.location.href = "<?php echo base_url() ?>promotion-management";

                }, 3000);
                $('.loading').fadeOut("slow");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error inactive data');
            }
        });
    }


    function deletePromotionID(id) {
        $('#delete_promotion_id').val(id);
    }


    function delete_promotion_info() {
        var id = $('#delete_promotion_id').val();
        $.ajax({
            url: '<?php echo base_url(); ?>promotion-management/delete_promotion',
            data: {id: id},
            type: 'post',
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data)
            {
                $('#deletePromotionModal').modal('toggle');
                $('#showMessage').html("<?php echo lang('delete_success');?>");
                $('#showMessage').show();
                window.onload = searchFilter(0);
                setTimeout(function () {
                    $('#showMessage').fadeOut(300);

                }, 3000);
                $('.loading').fadeOut("slow");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
    }

    


   
</script>