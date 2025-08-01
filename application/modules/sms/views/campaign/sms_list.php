<ul class="breadcrumb">
	<?php
	if($breadcrumb){
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
					<div class="element-box full-box">
						<div class="row">
                            <div class="col-md-12">
                                <h3>SMS list</h3>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-6">
								<div class="table-responsive" id="postList">
									<table id="mytable" class="table table-bordred table-striped">
                                        <thead>
                                            <tr>
                                                <th><?= lang('serial')?></th>
                                                <th><?= lang('phone')?></th>
                                                <th><?= lang('status')?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            if(!empty($posts)){
                                                foreach ($posts as $list) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i;?></td>
                                                        <td><?php echo $list['phone'];?></td>
                                                        <?php 
                                                        $status=($list['status']==1)?'success':'error';
                                                        ?>
                                                       <td> <span class="<?= $status?>"><?php echo $list['status_title'];?></span></td>
                                                    </tr>
                                                    <?php 
                                                    $i++;
                                                }
                                            }
                                            ?> 
                                        </tbody>
                                    </table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
