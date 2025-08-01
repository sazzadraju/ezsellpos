<ul class="breadcrumb">
    <?php
    if ($breadcrumb) {
        echo $breadcrumb;
    }
    ?>
</ul>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="element-header"><?= lang('user_access_contorll') ?> </h6>
                            </div>
                        </div>
                        <?php  
                        $check_customer=$check_supplier=$check_office=$check_employee=$check_investor='';
                        if($userPages){
                            foreach ($userPages as $value) {
                                $check_customer=($value->page_name=='customer')?'checked':$check_customer;
                                $check_supplier=($value->page_name=='supplier')?'checked':$check_supplier;
                                $check_office=($value->page_name=='office')?'checked':$check_office;
                                $check_employee=($value->page_name=='employee')?'checked':$check_employee;
                                $check_investor=($value->page_name=='investor')?'checked':$check_investor;
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkgroup bottom-30">
                                    <input type="checkbox" name="check_all" value="checkAll" id="CheckAll"/>
                                    <label for="CheckAll">Check Uncheck All</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <?php echo form_open_multipart('user-access/' . $id, array('id' => 'access_controll')); ?>
                                <input type="hidden" name="id" id="id" value="<?= $id ?>">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group row checkgroup">
                                        <?php
                                        if (!empty($accessMenus)):
                                            $p_menu = 1;
                                            foreach ($accessMenus as $menu):
                                                if ($menu->parent_id == NULL) {
                                                    $check_module_active = '';
                                                    if (!empty($accessModules)) {
                                                        foreach ($accessModules as $checkModule) {
                                                            if ($checkModule->id_acl_module == $menu->id_acl_module) {
                                                                $check_module_active = 'checked';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <div class="col-sm-12 bottom-15 parent">
                                                        <input type="checkbox" id="parent-<?= $menu->id_acl_module ?>"
                                                               name="parent[]"
                                                               value="<?= $menu->id_acl_module ?>" <?= $check_module_active ?>>
                                                        <label for="parent-<?= $menu->id_acl_module ?>"><strong
                                                                style="font-weight:bold"><?= $menu->mod_name ?></strong></label>
                                                    </div>
                                                    <?php
                                                    $c_menu = 1;
                                                    foreach ($accessMenus as $subMenu) {
                                                        if ($subMenu->parent_id == $menu->id_acl_module) {
                                                            $check_submodule_active = '';
                                                            if (!empty($accessModules)) {
                                                                foreach ($accessSubModules as $checkSubModule) {
                                                                    if ($checkSubModule->id_acl_module == $subMenu->id_acl_module) {
                                                                        $check_submodule_active = 'checked';
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <div
                                                                class="sub-cat  bottom-10 chm-<?= $menu->id_acl_module ?>">
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <div class="col-sm-4 childMenu">
                                                                            <input type="checkbox"
                                                                                   id="child-<?= $subMenu->id_acl_module ?>"
                                                                                   name="child[<?= $menu->id_acl_module ?>][]"
                                                                                   value="<?= $subMenu->id_acl_module ?>" <?= $check_submodule_active ?>>
                                                                            <label
                                                                                for="child-<?= $subMenu->id_acl_module ?>"><?= $subMenu->mod_name ?></label>
                                                                        </div>
                                                                        <div
                                                                            class="chm-<?= $menu->id_acl_module ?> pm-<?= $subMenu->id_acl_module ?>">
                                                                            <?php
                                                                            if (!empty($accessPages)) {
                                                                                foreach ($accessPages as $page) {
                                                                                    if ($subMenu->id_acl_module == $page->submodule_id) {
                                                                                        $check_pages = '';
                                                                                        if (!empty($accessSubModulePages)) {
                                                                                            foreach ($accessSubModulePages as $accesssubPage) {
                                                                                                if ($accesssubPage->module_id == $subMenu->id_acl_module && $accesssubPage->page_id == $page->id_acl_page) {
                                                                                                    $check_pages = 'checked';
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                        <div class="col-sm-2">
                                                                                            <input type="checkbox"
                                                                                                   id="menu_page-<?= $page->id_acl_page ?>"
                                                                                                   name="menu_page[]"
                                                                                                   value="<?= $page->id_acl_page ?>"<?= $check_pages ?>>
                                                                                            <label
                                                                                                for="menu_page-<?= $page->id_acl_page ?>"><?= $page->page_title ?></label>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    $p_menu++;
                                                }
                                            endforeach;
                                        else:
                                            ?>
                                            <b>  <?= lang("data_not_available"); ?></b>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                    if (!empty($accessMenus)){
                                        ?>
                                        <div class="form-group row checkgroup">
                                        <div class="col-sm-12 bottom-15 ">
                                            <label for="parent-"><strong
                                                    style="font-weight:bold">Transactions</strong></label>
                                        </div>
                                        <div class="sub-cat  bottom-10">
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="col-sm-2 childMenu">
                                                        <input type="checkbox"
                                                               id="tr-1"
                                                               name="tr_page[]"
                                                               value="customer" <?= $check_customer ?>>
                                                        <label for="tr-1"><?=lang('customer')?></label>
                                                    </div>
                                                    <div class="col-sm-2 childMenu">
                                                        <input type="checkbox"
                                                               id="tr-2"
                                                               name="tr_page[]"
                                                               value="supplier" <?= $check_supplier ?>>
                                                        <label for="tr-2"><?=lang('supplier')?></label>
                                                    </div>
                                                    <div class="col-sm-2 childMenu">
                                                        <input type="checkbox"
                                                               id="tr-3"
                                                               name="tr_page[]"
                                                               value="office" <?= $check_office ?>>
                                                        <label for="tr-3"><?=lang('office')?></label>
                                                    </div>
                                                    <div class="col-sm-2 childMenu">
                                                        <input type="checkbox"
                                                               id="tr-4"
                                                               name="tr_page[]"
                                                               value="employee" <?= $check_employee ?>>
                                                        <label for="tr-4"><?=lang('employee')?></label>
                                                    </div>
                                                    <div class="col-sm-2 childMenu">
                                                        <input type="checkbox"
                                                               id="tr-5"
                                                               name="tr_page[]"
                                                               value="investor" <?= $check_investor ?>>
                                                        <label for="tr-5"><?=lang('investor')?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    <?php 
                                    }
                                    ?>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <input type="submit" name="sub_acc" value="<?= lang('submit') ?>"
                                           class="btn btn-primary right bottom-10">
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    var $chAll = $('#CheckAll');
    var $ch = $('.checkgroup input[type="checkbox"]').not($chAll);
    var $par = $('.parent input[type="checkbox"]').not($chAll);
    $chAll.click(function () {
        $ch.prop('checked', $(this).prop('checked'));
    });
    $ch.click(function () {
        if ($ch.size() == $('.checkgroup input[type="checkbox"]:checked').not($chAll).size())
            $chAll.prop('checked', true)
        else
            $chAll.prop('checked', false)
    });
    $('.parent input').on('change', function () {
        var $this = $(this);
        var par = $this.val();
        var val = $('.chm-' + par + ' input[type="checkbox"]');
        if ($this.is(":checked")) {
            val.prop('checked', true);
        } else {
            val.prop('checked', false);
        }
        // alert('sf');
//    var $inputs = $(this).siblings('input').add(this),
//        $checked = $inputs.filter(':checked'),
//        $all = $inputs.eq(0),
//        index = $inputs.index(this);
//         alert($checked);
//
//    (index === 0 ? $checked : $all).removeAttr('checked');
//
//    if(index === 0 || $checked.length === 0) {
//        $all.attr('checked', 'checked');
//    }
    });
    $('.childMenu input').on('change', function () {
        var $this = $(this);
        var par = $this.val();
        var val = $('.pm-' + par + ' input[type="checkbox"]');
        if ($this.is(":checked")) {
            val.prop('checked', true);
        } else {
            val.prop('checked', false);
        }

    });

</script>
