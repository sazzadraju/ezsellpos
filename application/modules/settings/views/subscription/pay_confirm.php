<link rel="stylesheet" href="<?= base_url(); ?>themes/default/css/payment.css">
<div class="exclusive">
    <div class="pricing-wrapper">
        <div class="">
            <header class="pricing-header">
                <img src="<?php echo documentLink('user'). $profile_img; ?>" alt="" width="150">
                <?php if ($status != '') {
                    echo '<h3>' . $message . '</h3>';
                }
                ?>

            </header>
            <?php
            if ($status != 'successed') {
                $this->load->view('subscription/ssl_payment_data');
            } else { ?>
                <b><?php echo $message_details; ?></b>
            <?php } ?>

        </div>
    </div>
</div>

