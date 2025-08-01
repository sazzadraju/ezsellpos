<div class="modal-body">
    <div class="col-md-121">
        <button style="position: absolute;right: 20px;z-index: 99;" type="button" class="close"
                data-dismiss="modal">&times;</button>
    </div>
    <div class="col-md-12">
        <div class="servc-name">
            <p>
                <?php echo $aService['service_name']; ?>
            </p>
            <p> Price: <?php echo $aService['service_price']; ?>
            </p>
        </div>

        <hr>

    </div>


    <div class="col-md-6">
        <h3 class="element-header">Measurement fields</h3>
        <div class="repeatMeasurement">
            <?php
            $fi = 1;
            foreach ($aService['fields'] as $aSerField):
                ?>
                <div class="singleMeasurement">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="tailor-mesr">
                                <li>
                                    <strong><?php echo $aSerField['field_name']; ?></strong>
                                    <span class="reqired">
                                <?php
                                if ($aSerField['is_required'] == 1) {
                                    $ss = 'Required';
                                } else {
                                    $ss = '';
                                }
                                ?>
                                <?php echo $ss; ?>
                            </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                $fi++;
            endforeach;
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <h3 class="element-header">Design</h3>
        <div class="repeatDesign">
            <?php
            $di = 1;
            foreach ($aService['designs'] as $aDesField):
                ?>
                <div class="singleDesign">
                    <div class="row">
                        <div class="service-design">
                            <?php
                            if ($aDesField['field_img'] != NULL) {
                                echo '<img src="' . documentLink('tailoring') . $aDesField['field_img'] . '"width="50">';
                            }
                            ?>
                            <h4><?php echo $aDesField['field_name']; ?></h4>
                            <p> <?php echo $aDesField['notes']; ?></p>
                        </div>
                    </div>
                </div>
                <?php
                $di++;
            endforeach;
            ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>