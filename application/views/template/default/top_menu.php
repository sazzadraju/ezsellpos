
        <nav class="navbar navbar-default stycky">
            <div class="container-fluid pl">
           
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                     <div class="logo-w">
                    <a class="logo" href="<?php echo base_url();?>dashboard"><img src="<?=base_url()?>themes/default/img/logo.png"></a>
                </div>
                    <ul class="nav navbar-nav">
                        <li class="">
                            <div class="top-sts"><i class="material-icons"></i>Store:
                                <?=explode('&',$this->session->userdata['login_info']['store_name'])[0]?>
                            </div>
                        </li>
                        <li class="">
                            <div class="top-sts terminal-bg"><i class="material-icons"></i>Station:
                                <?=$this->session->userdata['login_info']['station_name']?>
                            </div>
                        </li>
                      <?php
                        $subscription=$this->session->userdata['login_info']['subscription_info']['SUBSCRIPTION_TO'];
                        $date1 = new DateTime($subscription);
                        $date2 = new DateTime(date('Y-m-d'));

                        $diff = $date2->diff($date1)->format("%a");
                        //print_r($subscription);
                        ?>

<!--                         <li class="">
                            <div class="remaining">
                                Remaining <span><?php echo $diff;?></span> Days. <a href="<?=base_url()?>company-info">get more...</a>
                            </div>
                        </li> -->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><i class="fa fa-user-circle"></i><?php echo $this->session->userdata['login_info']['fullname'];?></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Admin<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url()?>change-password">Change Password</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="<?php echo base_url();?>logout"><i class="fa fa-sign-out"></i> Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>