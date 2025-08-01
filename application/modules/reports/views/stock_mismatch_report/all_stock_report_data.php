<table id="mytable" class="table table-bordred table-striped">
    <thead>
    <th><?= lang("date"); ?></th>
    <th><?= lang("send_invoice"); ?></th>
    <th><?= lang("receive_invoice"); ?></th>
    <th><?= lang("send-store"); ?></th>
    <th><?= lang("receive-store"); ?></th>
    <th><?= lang("send-qty"); ?></th>
    <th><?= lang("receive-qty"); ?></th>
    <th><?= lang("mismatch-qty"); ?></th>
    </thead>
    <tbody>
    <?php

    if (!empty($posts)):
        $count = 1;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                $date = date('Y-m-d', strtotime($post['dtt_add']));
                echo '<td>' . $date . '</td>';
                echo '<td>' . $post['from_invoice'] . '</td>';
                echo '<td>' . $post['to_invoice'] . '</td>';
                echo '<td>' . $post['from_store'] . '</td>';
                echo '<td>' . $post['to_store'] . '</td>';
                echo '<td>' . $post['from_qty'] . '</td>';
                echo '<td>' . $post['to_qty'] . '</td>';
                echo '<td>' . $post['mismatch_qty'] . '</td>';
                ?>
            </tr>
            <?php
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>


<div id="view" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="element-header margin-0"><?= lang("invoice-detail"); ?> <span class="close"
                                                                                         data-dismiss="modal">&times;</span>
                </h6>
            </div>
            <div class="modal-body">
                <div class="data-view">
                    <div class="col-md-12">
                        <table id="mytable" class="table table-bordred table-striped">
                            <thead>
                            <th><?= lang("product_name"); ?></th>
                            <th><?= lang("product_code"); ?></th>
                            <th><?= lang("send-qty"); ?></th>
                            <th><?= lang("receive-qty"); ?></th>
                            <th><?= lang("mismatch-qty"); ?></th>


                            </thead>
                            <tbody class='tttt'>


                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="sale_print()">Print</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
                </div>
            </div>
        </div>
    </div>


    <page size="A4" id="print11" style="display:none;">
        <div class="report-box">

            <?php
            $company = $this->session->userdata['login_info']['store_id'];
            // $address= $this->session->userdata['login_info']['subscription_info'] ['address'];
            // $mobile= $this->session->userdata['login_info']['mobile'];
            $query = $this->commonmodel->store_details($company);
            $printed_by = $this->session->userdata['login_info']['fullname'];
            // print_r($company);
            ?>
            <div class="report-header">
                <div class="report-info">
                    <!-- $this->commonmodel->dfgd() -->
                    <?php $store_name = '';
                    $mobile = '';
                    $store_address = '';
                    // $sql ="select s.*,a.area_name_en,c.city_name_en FROM stores s JOIN loc_areas a ON a.id_area = s.area_id JOIN loc_cities c ON c.id_city = s.city_id WHERE s.id_store = '$company'";
                    // $query = $this->db->query($sql);

                    foreach ($query as $stores) {
                        // print_r($query);
                        // echo "<pre>";
                        $store_name = $stores->store_name;
                        $mobile = $stores->mobile;
                        // print_r($stores);
                        if (!empty($stores->city_id)) {
                            $store_area = $stores->area_name_en;
                            $store_city = $stores->city_name_en;
                        } else {
                            $store_area = $stores->district_name_en;
                            $store_city = $stores->division_name_en;
                        }
                    } ?>
                    <h2><?php echo $store_name; ?><br></h2>
                    <p>Mobile:<?php echo $mobile; ?></p>
                    <address>
                        <?php echo $store_area . "," . $store_city; ?>
                    </address>
                </div>
                <div class="report-info2">
                    <p>Date:<?php echo date('d-m-Y'); ?></p>
                </div>
            </div>
            <div class="col-md-12">
                <table id="mytable" class="table table-bordred table-striped">
                    <thead>
                    <th><?= lang("product_name"); ?></th>
                    <th><?= lang("product_code"); ?></th>
                    <th><?= lang("send-qty"); ?></th>
                    <th><?= lang("receive-qty"); ?></th>
                    <th><?= lang("mismatch-qty"); ?></th>


                    </thead>
                    <tbody class='tttt'>


                    </tbody>
                </table>
            </div>
        </div>
    </page>
    <script type="text/javascript">


        function invoice_details(inv_no) {
            // alert(inv_no);
            $.ajax({
                url: "<?php echo base_url() ?>report/invoice-details/" + inv_no,
                type: "GET",
                dataType: "JSON",
                // beforeSend: function () {
                //     $('.loading').show();
                // },
                success: function (data) {
                    console.log(data);
                    var res = '';
                    //res=JSON.parse(data);
                    //console.log(res);
                    // console.log(data.length);

                    // alert('amount : ' + data[0].amount);
                    // alart($data);
                    // $('.loading').fadeOut("slow");
                    // $('#store_name_view').html(data.product_name);
                    // $('#sl_no').html(data.id_store);
                    var total = 0;
                    var vv = '';
                    for (var i = 0; i < data.length; i++) {
                        // total +=data[i].amount;
                        vv += '<tr><td>' + data[i].product_name + '</td><td>' + data[i].product_code + '</td><td>' + data[i].sqty + '</td><td>' + (data[i].sqty - data[i].qty) + '</td><td>' + data[i].qty + '</td></tr>';
                    }

                    // alert(total);
                    // console.log('vv: '+ vv);

                    $('.tttt').html(vv);

                },

                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    </script>

    <script src="<?= base_url() ?>themes/default/js/jquery.print.js"></script>
    <script type="text/javascript">
        function sale_print() {
            $('#print11').css('display', 'block');
            $("#print11").print({
                globalStyles: false,
                mediaPrint: false,
                stylesheet: "<?= base_url(); ?>themes/default/css/report_print.css",
                iframe: false,
                noPrintSelector: ".avoid-this",
                // append : "Free jQuery Plugins!!!<br/>",
                // prepend : "<br/>jQueryScript.net!"
            });
            //$.print("#sale_view");
            $('#print11').css('display', 'none');
            // $('#view').modal('hide');
        }
    </script>