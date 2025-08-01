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
                            <h6 class="element-header">Tailoring Services</h6>
                                <div class="element-box full-box">
                                    <div class="row">

                                        <?php 
                                            // echo '<pre>';
                                            // print_r($services);
                                        ?>

                                        <?php if ($this->session->flashdata('success') == TRUE): ?>
                                            <div id="successMessage" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                                        <?php endif; ?>

                                        <div class="col-md-12">
                                            <a href="<?= base_url();?>tailoring/service_create" class="btn btn-primary right"><i class="fa fa-plus"></i> Add Service</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <div id="postList">
                                                    <table id="mytable" class="table table-bordred table-striped">
                                                        <thead>
                                                            <th>#</th>
                                                            <th>Service Name</th>
                                                            <th>Price</th>
                                                            <th class="center">Actions</th>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                                if(!empty($services)):
                                                                $iid = 1; 
                                                                foreach($services as $tailorService):                                                                    
                                                            ?>

                                                            <tr>
                                                                <td><?php echo $iid;?></td>
                                                                <td><?php echo $tailorService['service_name'];?></td>
                                                                <td><?php echo $tailorService['service_price'];?></td>
                                                                <td class="center">
                                                                    <button id="serviceView" serviceId = "<?php echo $tailorService['id_service'];?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                                    <a href="<?php echo base_url();?>tailoring/edit/<?php echo $tailorService['id_service'];?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                                                                    <button serviceId = "<?php echo $tailorService['id_service'];?>" class="btn btn-danger btn-xs serviceDelete" ><span class="glyphicon glyphicon-trash"></span></button>
                                                                </td>
                                                            </tr>    
                                                            <?php $iid++; endforeach; else:?>                                                               
                                                                <tr><td>Service(s) not available.<td></tr>
                                                            <?php endif;?>
                                                        </tbody>

                                                    </table>
                                                <?php echo $this->ajax_pagination->create_links(); ?>
                                                </div>
                                                <div class="loading" style="display: none;">
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

        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>

                    </div>
                    <div class="modal-footer ">
                        <button sid="" id="deleteSer" type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">            
              <!-- Modal content-->
              <div class="modal-content">
              </div>              
            </div>
          </div>

        <script src="<?= base_url()?>themes/default/js/jquery.validate.min.js"></script>

        <script type="text/javascript">
            $(document).on('click', '#serviceView', function(){

                var sid = $(this).attr("serviceid");

                $.ajax({
                    url: '<?php echo site_url("tailoring/service_view");?>',
                    type: 'get',
                    data: {sid: sid},
                })
                .done(function(res) {
                    
                    // alert(res);
                    console.log(res);
                    $('.modal-content').html(res);
                    $('#myModal').modal('show');
                });
            });

            $(document).on('click', '.serviceDelete', function(){
                var sid = $(this).attr("serviceid");
                $('#delete').modal('show');
                $('#deleteSer').attr('sId', sid);    
            });
            $(document).on('click', '#deleteSer', function(){
                var sid = $(this).attr("sid");
                $.ajax({
                    url: '<?php echo site_url("tailoring/service_delete");?>',
                    type: 'get',
                    data: {sid: sid},
                })
                .done(function(res) {
                    if(res){
                        window.location.href = "<?php  echo base_url('tailoring'); ?>";
                    }                        
                });
            });


            $(document).ready(function(){
                setTimeout(function() {
                    $('#successMessage').fadeOut('fast');
                }, 3000);
            });

        </script>