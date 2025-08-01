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
                    <h6 class="element-header"><?= lang("quotation_list"); ?></h6>
                    <div class="element-box full-box">
                        <div class="row">       
                            <?php
                                // echo '<pre>';
                                // print_r($all_quotation);
                                // echo '</pre>';
                            ?>  
                            <div class="col-md-12">
                                <a href="<?php echo base_url();?>quotation/add" class="btn btn-primary bottom-10 right"><?= lang("add_quotation"); ?></a>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <div id="postList">
                                        <table id="mytable" class="table table-bordred table-striped">
                                            <thead>
                                                <tr><th>#</th>
                                                <th><?= lang("quotation_no"); ?></th>
                                                <th><?= lang("creation_date"); ?></th>
                                                <th><?= lang("customer_name"); ?></th>
                                                <th><?= lang("product_price"); ?></th>
                                                <th><?= lang("vat-amount"); ?></th>
                                                <th><?= lang("discount_amount"); ?></th>
                                                <th><?= lang("total_amount"); ?></th>
                                                <th class="center"><?= lang("actions"); ?></th>
                                            </tr></thead>
                                            <tbody> 
                                            <?php 
                                                if(!empty($all_quotation)):  
                                                $i=0; 
                                                foreach($all_quotation as $aQuotation):
                                            ?>    
                                            <tr>
                                                <td><?php echo ($i+1);?></td>
                                                <td><?php echo $aQuotation['quotation_no'];?></td>
                                                <td><?php echo $aQuotation['dtt_add'];?></td>
                                                <td><?php echo $aQuotation['full_name'];?></td>
                                                <td>
                                                    <?php 
                                                        echo set_currency($aQuotation['product_amt']);
                                                    ?>   
                                                </td>      
                                                <td><?php echo set_currency($aQuotation['vat_amt']);?></td>
                                                <td><?php echo set_currency($aQuotation['discount_amt']);?></td>
                                                <td><?php echo set_currency($aQuotation['total_amt']);?></td>
                                                <td class="center">
                                                    <a href="<?php echo base_url().'quotation/view/'.$aQuotation['id_quotation'];?>" class="btn btn-success btn-xs" ><span class="glyphicon glyphicon-eye-open"></span></a>
                                                    <a href="<?php echo base_url().'quotation/edit/'.$aQuotation['id_quotation'];?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                                                </td>
                                            </tr>
                                            <?php 
                                                $i++; 
                                                endforeach;
                                                else: 
                                            ?>
                                            <tr><td colspan="9"><?= lang("data_not_available"); ?></td></tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->ajax_pagination->create_links(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <?php
                $mess = '';
                if ($this->session->flashdata('success') == TRUE): ?>
                    <?php $mess = $this->session->flashdata('success'); ?>
                    <script>
                        $(document).ready(function () {
                            $('#showMessage').show();
                            setTimeout(function () {
                                $('#showMessage').fadeOut(300);

                            }, 3000);
                        });
                    </script>
                <?php endif; ?>
                <div class="showmessage" id="showMessage" style="display: none;"><?= $mess ?></div>
            </div>
        </div>
    </div>
</div>
