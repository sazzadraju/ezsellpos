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
<?php //print_r($posts); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="full-box element-box">
                        <h6 class="element-header"><?= $product_name[0]->product_name ?></h6>
                        <form class="form-horizontal" role="form" id="add_barcode_data" class="cmxform" action=""
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="pro_id" id="pro_id" value="<?= $product_id ?>">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang("batch_no"); ?></label>
                                    <div class="col-sm-12">
                                        <div class="row-fluid">
                                            <select class="select2" data-live-search="true" id="batch_no"
                                            name="batch_no" onchange="get_qty(this.value)">
                                            <option value="0" selected><?= lang("select_one"); ?></option>
                                            <?php
                                            foreach ($posts as $batch) {
                                                if (!empty($batch->batch_no)) {
                                                    echo '<option value="' . $batch->batch_no . '">' . $batch->batch_no . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <label id="batch-error" class="error" for="batch_no"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"
                                for=""><?= lang("barcode_size"); ?></label>
                                <div class="col-sm-12">
                                    <div class="row-fluid">
                                        <select class="select2" data-live-search="true" id="barcode_size"
                                        name="barcode_size">
                                        <option value="0" selected><?= lang("select_one"); ?></option>
                                        <option value="1">2.5 X 1.5</option>
                                        <option value="2">1.5 X 1.0</option>

                                    </select>
                                    <label id="batch-error" class="error" for="barcode_size"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label"
                            for=""><?= lang("paper_size"); ?></label>
                            <div class="col-sm-12">
                                <div class="row-fluid">
                                    <select class="select2" data-live-search="true" id="paper_size"
                                    name="paper_size">
                                    <option value="0" selected><?= lang("select_one"); ?></option>
                                    <option value="1"><?= lang("paper_size-1"); ?></option>
                                    <option value="2"><?= lang("paper_size-2"); ?></option>
                                </select>
                                <label id="batch-error" class="error" for="batch_no"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12">
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for=""><?= lang("qty"); ?></label>
                        <div class="col-sm-12">
                            <input class="form-control" id="qty" name="qty" type="text">
                            <label id="qty-error" class="error" for="qty"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4">
                    <label class="col-sm-12 col-form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary" type="button" ><i
                        class="fa fa-search"></i> <?= lang("search"); ?></button>
                    </div>
                </form>
            </div>
        </div>

        <button class="btn btn-primary pull-right" type="button"
        onclick="sale_print()"></i> <?= lang("print-view"); ?></button>
        <div class="element-box full-box">
            <div class="row">
                <!--   <button class="btn btn-primary pull-right" type="button" onclick="sale_print()"></i> <?= lang("print-view"); ?></button> -->
                <div id="print">
                    <div class="" id="postList">
                        <?php
                        if(isset($batch_no)){
                                   // echo $product_id.'='.$batch_no.'='.$qty;
                            $barcode = $product_id . '-' . $batch_no;
                            $html = '';
                            $height = '';
                            $width = '';
                            $page_size_width = '';
                            $bar_width = '';

                                    // $page_size_width='';
                            if ($barcode_size == 1) {
                                $height = '62px';
                                $width = '150px';
                                $bar_width = '160px';
                            } else if ($barcode_size == 2) {
                                $height = '37px';
                                $width = '141px';
                                $bar_width = '141px';
                            }
                            if ($paper_size == 1) {
                                $page_size_width = '950px';
                                echo '<div class="barcodeouter"  style="width:' . $page_size_width . '; margin-bottom:4px;margin-left: 10px;">';
                                for ($i = 1; $i <= $qty; $i++) {
                                    $img = $this->barcode->code128BarCode($barcode, 1);
                                            //echo'<br>';

                                    ob_start();
                                    imagepng($img);
                                    $output_img = ob_get_clean();
                                    echo '<div class="barcode" style="width:' . $width . ';margin-right:10px;margin-bottom: 0px !important;margin-top: 15px !important;">';

                                    echo '<div style="padding:0px;">';
                                    echo '<span style="width:100%;line-height: 12px;float: left; font-weight:bold;font-size:12px;height: 12px;overflow: hidden;">' . $p_product_name . '</span>';
                                    if ($barcode_size == 1) {
                                        echo '<span class="no" style="font-size:14px;margin-top: -4px;font-weight:bold;letter-spacing: 2px;">' .set_currency($product_price) . $is_vat.'</span>';
                                    } else if ($barcode_size == 2) {
                                        echo '<span class="no" style="font-size:12px;margin-top: -4px;font-weight:bold;letter-spacing: 2px;">' .set_currency($product_price) . $is_vat.'</span>';
                                    }
                                    echo '<img height="'.$height.'" style="width:100%;"  src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
                                    echo '<span class="no" style="font-size:10px;margin-top: -3px;"> ' . $barcode . '</span>';

                                    echo '</div></div>';
                                    if($barcode_size==2){
                                        if ($i % 84 == 0){
                                            echo '<div class="print_space" style=" float: left;width: 100%;display: block;height: 35px;"></div>';
                                        }
                                    }
                                    if($barcode_size==1){
                                        if ($i % 50 == 0){
                                            echo '<div class="print_space" style=" float: left;width: 100%;display: block;height: 60px;"></div>';
                                        }
                                    }

                                }
                                echo '</div>';
                            } else if ($paper_size == 2) {
                                $page_size_width = '150px';
                                echo '<div class="barcodeouter"  style="width:' . $page_size_width . '; margin-bottom:4px;">';
                                for ($i = 1; $i <= $qty; $i++) {
                                    $img = $this->barcode->code128BarCode($barcode, 1);
                                            //echo'<br>';

                                    ob_start();
                                    imagepng($img);
                                    $output_img = ob_get_clean();
                                    echo '<div class="barcode" style="width:' . $width . '">';

                                    echo '<div style="padding:0px;">';
                                    echo '<span style="width:100%;line-height: 12px;float: left; font-weight:bold;font-size:12px;">' . $p_product_name . '</span>';
                                    if ($barcode_size == 1) {
                                        echo '<span class="no" style="font-size:14px;margin-top: -4px;font-weight:bold;letter-spacing: 2px;">' .set_currency($product_price) . $is_vat.'</span>';
                                    } else if ($barcode_size == 2) {
                                        echo '<span class="no" style="font-size:12px;margin-top: -4px;font-weight:bold;letter-spacing: 2px;">' .set_currency($product_price) . $is_vat.'</span>';
                                    }
                                    echo '<img height="'.$height.'" style="width:100%;"  src="data:image/png;base64,' . base64_encode($output_img) . '"/>';
                                    echo '<span class="no" style="font-size:10px;margin-top: -3px;"> ' . $barcode . '</span>';

                                    echo '</div></div>';
                                }
                                echo '</div>';
                            }

                                    //echo $html;
                        }
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
<script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
<script>
    $("#add_barcode_data").submit(function () {
        //alert('sdf');
        var batch = $('#batch_no').val();
        var pro_id = $('#pro_id').val();
        var qty = $('#qty').val();
        var barcode_size = $('#barcode_size').val();
        var paper_size = $('#paper_size').val();
        // alert(batch+'='+pro_id+'='+qty+'='+barcode_size+'='+paper_size);
        var count = 0;
        if (batch == '0') {
            $('#batch-error').html('Select any one');
            count = 1;
        }
        if (qty == '') {
            $('#qty-error').html('Quantity not be empty');
            count += 1;
        }
        if (qty > 1000) {
            $('#qty-error').html('Quantity is large');
            count += 1;
        }
        if (count == 0) {
            $('#qty-error').html('');
            $('#batch-error').html('');
            return true;

        }else {
            return false;
        }

    });
    function get_qty(id) {
        var pro_id = $('#pro_id').val();
        //alert(pro_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>products/get_product_qty_byBatch',
            data: 'pro_id=' + pro_id + '&batch=' + id,
            success: function (data) {
                $('#qty').val(Math.round(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    function searchFilter() {
        var batch = $('#batch_no').val();
        var pro_id = $('#pro_id').val();
        var qty = $('#qty').val();
        var barcode_size = $('#barcode_size').val();
        var paper_size = $('#paper_size').val();
        // alert(batch+'='+pro_id+'='+qty+'='+barcode_size+'='+paper_size);
        var count = 0;
        if (batch == '0') {
            $('#batch-error').html('Select any one');
            count = 1;
        }
        if (qty == '') {
            $('#qty-error').html('Quantity not be empty');
            count += 1;
        }
        if (qty > 1000) {
            $('#qty-error').html('Quantity is large');
            count += 1;
        }
        if (count == 0) {
            $('#qty-error').html('');
            $('#batch-error').html('');

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>products/get_barcode_byProduct',
                data: 'pro_id=' + pro_id + '&batch=' + batch + '&qty=' + qty + '&barcode_size=' + barcode_size + '&paper_size=' + paper_size,
                //     beforeSend: function () {
                //     $('.loading').show();
                // },

                success: function (data) {
                    // console.log(data);
                    $('.loading').fadeOut("slow");
                    $('#postList').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }
    //    function searchFilter2() {
    //        var batch = $('#batch_no').val();
    //        var pro_id = $('#pro_id').val();
    //        var qty = $('#qty').val();
    //        var barcode_size = $('#barcode_size').val();
    //        var paper_size = $('#paper_size').val();
    //        // alert(batch+'='+pro_id+'='+qty+'='+barcode_size+'='+paper_size);
    //        var count = 0;
    //        if (batch == '0') {
    //            $('#batch-error').html('Select any one');
    //            count = 1;
    //        }
    //        if (qty == '') {
    //            $('#qty-error').html('Quantity not be empty');
    //            count += 1;
    //        }
    //        if (qty > 1000) {
    //            $('#qty-error').html('Quantity is large');
    //            count += 1;
    //        }
    //        if (count == 0) {
    //            $('#qty-error').html('');
    //             $('#batch-error').html('');
    //
    //            $.ajax({
    //                type: 'POST',
    //                url: '<?php //echo base_url(); ?>//products/get_barcode_byProduct2',
    //                data: 'pro_id=' + pro_id + '&batch=' + batch + '&qty=' + qty + '&barcode_size=' + barcode_size + '&paper_size=' + paper_size,
    //            //     beforeSend: function () {
    //            //     $('.loading').show();
    //            // },
    //
    //                success: function (data)
    //                {
    //                    console.log(data);
    //                    $('.loading').fadeOut("slow");
    //                    $('#postList').html(data);
    //                },
    //                error: function (jqXHR, textStatus, errorThrown)
    //                {
    //                    alert('Error get data from ajax');
    //                }
    //            });
    //        }
    //    }
    function sale_print() {
        $("#print").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/sale_print.css",
            iframe: false,
            noPrintSelector: ".avoid-this",
            // append : "Free jQuery Plugins!!!<br/>",
            // prepend : "<br/>jQueryScript.net!"
        });
       // $.print("#print");

   }
</script>
