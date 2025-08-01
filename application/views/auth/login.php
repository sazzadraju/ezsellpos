<!DOCTYPE html>
<html>

<head>
    <title>EZSell | Login Form</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="<?php echo base_url(); ?>themes/default/img/favicon.ico" rel="shortcut icon">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/default/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/default/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/default/css/select.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/default/css/editor.css">
    <link href="<?php echo base_url(); ?>themes/default/css/select2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/css/main.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/css/custom.css" rel="stylesheet">
</head>

<body class="auth-wrapper">
<div class="all-wrapper menu-side with-pattern login-frm">
    <div class="auth-box-w">
        <div class="logo-w login-frm-logo">
            <a href="#"><img alt="logo" src="<?php echo base_url(); ?>themes/default/img/logo.png"></a>
        </div>
        <?php
        if ($this->session->flashdata('login_error')) {
            ?>
            <div class="alert-msg">
                <p><?php echo $this->session->flashdata('login_error'); ?></p>
            </div>
            <?php
        }
        $subscription = $subs['SUBSCRIPTION_TO'];
        $date1 = new DateTime($subscription);
        $date2 = new DateTime(date('Y-m-d'));
        $diff = $date2->diff($date1)->format("%R%a");
        //print_r($subscription);
        $actual_link = isset($_SERVER['HTTPS']) ? "https://" : "http://";
        $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $site_url = str_replace($actual_link, '', $url);
        $main_url= @current(explode('.', $site_url));
        ?>
        <?php
        if($diff>0) {
            ?>
            <h3 class="auth-header" style="margin-left:80px;color: #303030;">Log in</h3>
            <h4 class="auth-header" style="margin-left:80px;color: #616161;font-weight: 400;">Continue to EZSell</h4>
            <form action="<?php echo base_url(); ?>login_check" method="post">
                <div class="form-group">
                    <label for="">Username</label>
                    <input class="form-control" type="text" name="login_name"
                           id="login_name" required="required">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input class="form-control" type="password" name="login_password"
                           id="login_password" required="required">
                </div>
                <div class="buttons-w">
                    <button class="btn btn-primary">Submit</button>
                    <div class="form-check-inline">
                    </div>
                </div>
            </form>
            <?php
        }else{
        ?>
            <h4 style="text-align: left;color: #b80202;font-size: 25px;font-weight:400;margin-left: 72px;">Subscription Expried.</h4>
            <h4 style="text-align: left;color: #165d97;font-size: 20px;font-weight:300;margin-left: 72px;">To Renew Your Subscription</h4>
            <h4 style="text-align: left;color: #165d97;font-size: 20px;font-weight:300;margin-bottom:45px;margin-left: 72px;">Please Call 01796 618111</h4>
<!--             <div class="renew">
                <?php echo form_open_multipart('http://posspot.com/sms/client-renew', array('id' => 'stations', 'class' => 'renew-reg')); ?>
                <input type="hidden" name="shop_name" value="<?=$main_url?>">
                <input class="btn btn-success " type="submit" value="Renew">
                <?php echo form_close(); ?>
            </div> -->
        <?php
        }
        ?>

    </div>
</div>
</body>

</html>