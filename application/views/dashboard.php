<ul class="breadcrumb">
    <?php
    echo $this->breadcrumb->output();
    ?>
</ul>

<div class="content-i">
    <div class="content-box">
        <?php
        if($this->session->userdata['login_info']['user_type_i92']==3){
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper"> 
                    <div class="element-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="top-box">
                                    <div class="label">Current Stock Value <span>(<?= set_currency()?>) </div>
                                    <div class="value"><?= comma_seperator($stock) ?></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                               <div class="top-box top-box-2">
                                <table id="mytable" class="table table-bordred" style="text-align:center;">
                                    <thead>
                                    <th ></th>
                                    <th style="text-align:center;">Total
                                    <th style="text-align:center;">Used</th>
                                    <th style="text-align:center;">Available</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($config)):
                                        $count = 1;
                                        foreach ($config as $post):
                                            if ($post->param_key == 'TOT_STORES') {
                                                $available = (int)$post->param_val;
                                                $used = (int)$post->utilized_val;
                                                echo '<tr>';
                                                echo '<td style="text-align: center;">Stores</td>';
                                                echo '<td>' . $post->param_val . '</td>';
                                                echo '<td>' . $post->utilized_val . '</td>';
                                                echo '<td>' . ($available - $used) . '</td>';
                                                echo '</tr>';
                                            }
                                            if ($post->param_key == 'TOT_STATIONS') {
                                                $available = (int)$post->param_val;
                                                $used = (int)$post->utilized_val;
                                                echo '<tr>';
                                                echo '<td style="text-align: center;">Stations</td>';
                                                echo '<td>' . $post->param_val . '</td>';
                                                echo '<td>' . $post->utilized_val . '</td>';
                                                echo '<td>' . ($available - $used) . '</td>';
                                                echo '</tr>';
                                            }
                                            if ($post->param_key == 'TOT_USERS') {
                                                $available = (int)$post->param_val;
                                                $used = (int)$post->utilized_val;
                                                echo '<tr>';
                                                echo '<td style="text-align: center;">Users</td>';
                                                echo '<td>' . $post->param_val . '</td>';
                                                echo '<td>' . $post->utilized_val . '</td>';
                                                echo '<td>' . ($available - $used) . '</td>';
                                                echo '</tr>';
                                            }
                                        endforeach;
                                        ?>
<!--                                         <tr>
                                            <td colspan="4"><b><?= lang("data_not_available"); ?></b></td>
                                        </tr> -->
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="col-sm-4">
                               <div class="top-box-3">
                               <div class="label">Weekly Sales Summary
                               
                                <p><?= $sale_date ?></p>
                               </div>
                                <table id="mytable" class="table table-bordred table-striped">
                                    <thead>
                                    <th>Store Name</th>
                                    <?php echo '<th style="text-align: center;">' . 'Total Sale (' .' '. set_currency().' )'.'</th>';?>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($sales)):
                                        $count = 1;
                                        foreach ($sales as $sale):
                                            echo '<tr>';
                                            echo '<td>' . $sale['store_name'] . '</td>';
                                            echo '<td style="text-align: center;">' . $sale['tot_amt'] .'</td>';
                                            echo '</tr>';
                                            $count++;
                                        endforeach;
                                    endif; ?>
                                    </tbody>
                                </table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6"> 
               <div class="dash-accounts-details">
                <table id="mytable" class="table table-bordred">
                    <thead>
                    <th style="text-align:center;">Account Name</th>
                    <th style="text-align:center;">Type</th>
                    <th style="text-align:center;">Store</th>
                    <?php echo '<th>' . 'Balance (' .' '. set_currency().' )'.'</th>';?>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($accounts)):
                        $count = 1;
                        foreach ($accounts as $account):
                            if ($account['account_name'] != '') {
                                $name = $account['account_name'];
                            } else {
                                $name = $account['bank_name'];
                            }
                            echo '<tr>';
                            echo '<td>' . $name . '</td>';
                            foreach ($this->config->item('acc_types') as $key => $val):
                                if ($key == $account['acc_type_id']) {
                                    echo '<td>' . $val . '</td>';
                                }
                            endforeach;
                            echo '<td>' . $account['stores'] . '</td>';
                            echo '<td style="text-align: center;">' . $account['curr_balance'] .'</td>';
                            echo '</tr>';
                            $count++;
                        endforeach;
                    endif; ?>
                    </tbody>
                </table>
                </div>
            </div>
            
            <div class="col-sm-3" style="margin-top:19px;">
                <div class="top-box">
                    <?php
                    $today = date('Y-m-d');
                    $after7d = date('Y-m-d',strtotime('+7 days'));
                    $after15d = date('Y-m-d',strtotime('+15 days'));
                    $after30d = date('Y-m-d',strtotime('+30 days'));

                    $exQty = 0;
                    $exQty7 = 0;
                    $exQty15 = 0;
                    $exQty30 = 0;

                    foreach ($stock_data as $aStock) {
                        if($aStock->expire_date <  $today){
                            $exQty += $aStock->qty;
                        }else if($aStock->expire_date <= $after7d && $aStock->expire_date >= $today){
                            $exQty7 += $aStock->qty;
                        }else if($aStock->expire_date <= $after15d && $aStock->expire_date > $after7d){
                            $exQty15 += $aStock->qty;
                        }else if($aStock->expire_date <= $after30d && $aStock->expire_date > $after15d){
                            $exQty30 += $aStock->qty;
                        }
                    }

                    ?>
                    <ul class="expire-soon-products">
                        <li>
                            <a href="<?php echo base_url().'expiring-soon-products?xid=1';?>">
                            <?php echo $exQty;?>
                            <?= lang("expired_product"); ?> </a></li>
                        <li>
                            <a href="<?php echo base_url().'expiring-soon-products?xid=2';?>">
                            <?php echo $exQty7;?>
                            <?= lang("expired_7"); ?> </a></li>
                        <li>
                            <a href="<?php echo base_url().'expiring-soon-products?xid=3';?>"> 
                            <?php echo ($exQty15+$exQty7);?>
                            <?= lang("expired_15"); ?> </a></li>
                        <li>
                            <a href="<?php echo base_url().'expiring-soon-products?xid=4';?>"> 
                            <?php echo ($exQty15+$exQty7+$exQty30);?>
                            <?= lang("expired_30"); ?> </a></li>
                    </ul>
                </div>
            </div>
    
                <div class="col-sm-3" style="margin-top:20px;">
                                    <div class="top-box">
                                        <h3 style="text-align:center;"><?= lang("low_stock"); ?></h3>
                                        <?php echo '<div class="low-product"><strong>'.$low_stock.'</br>'.' </strong></div>';?>
                                        <a style="text-align:center;" href="<?php echo base_url().'products/low-high-stock';?>">
                                            <?= lang("details"); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else{
            ?>
            <div class="row">
                <div class="col-sm-12" style="min-height: 500px;">
                  <h1>Welcome to <?= $this->session->userdata['login_info']['fullname']?></h1>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>