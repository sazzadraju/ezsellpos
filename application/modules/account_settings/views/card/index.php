<ul class="breadcrumb">
<?php echo isset($breadcrumb) ? $breadcrumb : '';?>
</ul>
<div class="col-md-12"> 
    <div class="showmessage" id="showMessage" style="display: none;"></div>
</div>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-7">
                <div class="element-wrapper">
                    <div class="element-box full-box">
                        <h6 class="element-header"><?= lang("card_list"); ?></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div id="general_bank" class="tab-pane fade in active full-box">
                                        <div class="table-responsive" id="gen_bnk_lst">
                                            <table id="mytable" class="table table-bordred table-striped">
                                                <thead>
                                                    <th class="fit"><?= lang("sl_no"); ?></th>
                                                    <th><?= lang("card_name"); ?></th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($cards)):
                                                        $count = 1;
                                                        foreach ($cards as $key=>$val):
                                                            ?>
                                                            <tr>
                                                                <td class="fit"><?php echo $count; ?>.</td>
                                                                <td><?php echo $val; ?></td>
                                                            </tr>
                                                            <?php
                                                            $count++;
                                                        endforeach;
                                                    else:
                                                        ?>
                                                        <tr>
                                                            <td colspan="2"><b><?= lang("data_not_available"); ?></b></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                            <div class="clearfix"></div>
                                            <?php //echo $this->ajax_pagination->create_links(); ?>
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
</div>