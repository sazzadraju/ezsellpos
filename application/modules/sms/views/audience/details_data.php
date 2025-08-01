<ul class="breadcrumb">
    <?php
    if($breadcrumb){
        echo $breadcrumb;
    }
    ?>
</ul>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="element-wrapper">
                    <div class="top-btn full-box">
                        <div class="row">
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                    <tr>
                                        <th><?= lang('serial')?></th>
                                        <th><?= lang('name')?></th>
                                        <th><?= lang('type')?></th>
                                        <th><?= lang('phone')?></th>
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
                                                <td><?php echo $list['person_name'];?></td>
                                                <td><?php echo ($list['type']==1)?'Customer':'Supplier';?></td>
                                                <td><?php echo $list['phone'];?></td>
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


                                