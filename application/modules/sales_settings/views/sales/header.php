<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>EZSell Sales Interface</title>
    <!--    Fabicon-->
    <link rel="shortcut icon" href="<?= base_url()?>themes/default/img/favicon.ico" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--    Bootstrap CDN -->
    <link rel="stylesheet" href="<?= base_url()?>themes/sales/css/bootstrap.min.css">
    <!--    Slider css-->
    
    <!--    My Stylsheet-->
    <link rel="stylesheet" href="<?= base_url()?>themes/sales/css/uikit.min.css" />
    <link rel="stylesheet" href="<?= base_url()?>themes/sales/css/style.css">
    <!--    Javascript-->
    <script src="<?= base_url()?>themes/sales/js/jquery-3.5.1.min.js"></script>
    <!--    Font Awesome CDN-->
    <script src="<?= base_url()?>themes/sales/js/fontawesome.js"></script>
    <link rel="stylesheet" href="<?= base_url()?>themes/sales/css/jquery-ui.min.css">
    <script src="<?= base_url()?>themes/sales/js/jquery-ui.min.js"></script>
    <script>var URL = '<?= base_url(); ?>';</script>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-md bg-light">
         <!-- Brand/logo -->
         <a class="navbar-brand" href="#">
            <img src="<?= base_url()?>themes/default/img/logo.png" alt="">

        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"><i class="fas fa-info-circle" style="color:#000; font-size:26px;"></i></span>
        </button>

        <!-- Nav Item -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <div class="btn-group btn-group-sm">
                <div type="" class="top-button"><span class="material-icons" style="position:relative;top:5px;">storefront</span> <?=explode('&',$this->session->userdata['login_info']['store_name'])[0]?></div>
                <div type="" class="top-button2"><span class="material-icons" style="position:relative;top:5px;">point_of_sale</span> <?=$this->session->userdata['login_info']['station_name']?></div>
            </div>
           
            <div class="px-2 py-1">
                <input type="checkbox" name="gift_sale" id="gift_sale" style="margin-left: 380px;position: relative;top: 5px;">
                <label for="gift_sale" class="is-gift" ><span class="material-icons" style="position:relative;top:5px;">card_giftcard</span>Gift Sale</label>
            </div>
            <a href="<?=base_url()?>sales" class="reset-button"><span class="material-icons" style="position:relative;top:5px;">restart_alt</span>Reset</a>
        </div>


        <ul class="nav navbar-nav ml-auto" style="margin-top: 0!important;">
            <li>
                <div class="dropdown">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-user"></i> &nbsp; <?php echo $this->session->userdata['login_info']['fullname'];?>
                    </button>
                    <div class="dropdown-menu admin-dd-item">
                        <a class="dropdown-item" href="<?= base_url()?>change-password">Change Password</a>
                        <a class="dropdown-item" href="<?php echo base_url();?>logout"">Logout</a>
                    </div>
                </div>
            </li>
        </ul>

    </nav>
</header>