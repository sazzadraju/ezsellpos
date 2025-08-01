<ul class="breadcrumb">
    <?php
        echo $this->breadcrumb->output();
    ?>
</ul>

<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
            	<div class="element-wrapper">
                    <h6 class="element-header">Order List</h6>
                    <div class="element-box full-box">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url() . 'tailoring-orders/add' ?>" class="btn btn-primary bottom-10 right"
                                ><?= lang("add_order"); ?></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="">Receipt No </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" placeholder="Receipt No" type="text" id="receipt_no" name="receipt_no">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('customer_name') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" placeholder="<?= lang('customer_name') ?>" type="text" id="name_customer" name="name_customer">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for=""><?= lang('phone') ?> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" placeholder="<?= lang('phone') ?>" type="text" name="phone_customer" id="phone_customer">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="">Date Type</label>
                                    <div class="col-sm-12">
                                        <select id="date_type" name="date_type" class="form-control">
                                            <option value="1">Ordered Date</option>
                                            <option value="2">Delivery date</option>
                                        </select>
                                    </div>
                                </div>
                            </div>                    
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="">Start date </label>
                                    <div class="col-sm-12">
                                          <div class="input-group start_date">
                                        <input class="form-control valid start_date" aria-invalid="false" type="text" name="start_date" id="start_date">
                                        <span class="input-group-addon">     
                                       <span class="glyphicon glyphicon-calendar"></span>  
                                       </span> 
                                       </div> 
                                        <span id="start_date-error" class="error" for="start_date"></span>                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="">End date </label>
                                    <div class="col-sm-12">
                                          <div class="input-group end_date">
                                        <input class="form-control valid end_date" aria-invalid="false" type="text" name="end_date" id="end_date">
                                        <span class="input-group-addon">     
                                       <span class="glyphicon glyphicon-calendar"></span>  
                                       </span> 
                                       </div> 
                                        <span id="end_date-error" class="error" for="end_date"></span>                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="">Order Status</label>
                                    <div class="col-sm-12">
                                        <select id="order_status" name="order_status" class="form-control">
                                            <option value="0">--Select One--</option>
                                            <option value="1">Order Place</option>
                                            <option value="2">Processing</option>
                                            <option value="3">Delivered</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1">

                                <label class="col-sm-12 col-form-label" for="">&nbsp;</label>
                                <button class="btn btn-primary btn-rounded center" type="button" onclick="searchFilter();"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                                // echo '<pre>';
                                // print_r($orders);
                                // echo '</pre>';
                            ?>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <div id="postList">
                                        <?php 
                                        $this->load->view('order_list_pagination_data');
                                        ?>
                                    </div>
                                    <div class="loading" style="display: none;"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click', '.invoiceView', function () {
        var oId = $(this).val();

        // print

        var w = window.open('<?php echo base_url().'tailoring/order_full_invoice';?>/'+oId,'name','width=800,height=500', '_blank');
        w.print({
            globalStyles: false,
            mediaPrint: true,
            stylesheet: "<?= base_url(); ?>themes/default/css/tailoring_order_invoice.css",
            iframe: false,
            noPrintSelector: ".avoid-this"
        });

    });

      $(function () {
          $('.start_date').datetimepicker({
              viewMode: 'years',
              format: 'YYYY-MM-DD',
          });
      });
      $(function () {
          $('.end_date').datetimepicker({
              viewMode: 'years',
              format: 'YYYY-MM-DD',
          });
      });

    function searchFilter(page_num){
        var receipt_no = $('#receipt_no').val();
        var name_customer = $('#name_customer').val();
        var phone_customer = $('#phone_customer').val();
        var date_type = $('#date_type').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var order_status = $('#order_status option:selected').val();

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>tailoring/filterOrderPagination/' + page_num,
          data: 'date_type=' + date_type +'&start_date=' + start_date + '&end_date=' + end_date +  '&receipt_no=' + receipt_no + '&name_customer=' + name_customer +'&phone_customer=' + phone_customer+'&order_status='+order_status,
          beforeSend: function () {
              $('.loading').show();
          },
          success: function (html) {
              // console.log(html);
              $('#postList').html(html);
              $('.loading').fadeOut("slow");
          }
        });
    }
</script>

