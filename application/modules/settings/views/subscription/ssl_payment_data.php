<?php //echo $this->config->item('ssl_commerze_url'); ?>
<div class="pricing-body">

    <?php
    if ($status == 'successed') {
        ?>
        <div class="success-msg"><?php echo $message; ?></div>
        <?php
    } else if ($status == 'failed') {
        ?>
        <div class="alert-msg"><?php echo $message; ?></div>
        <?php
    } else if ($status == 'cancelled') {
        ?>
        <div class="alert-msg"><?php echo $message; ?></div>
        <?php
    } else {
        ?>
        <ul class="pricing-features">


            <li>Subscriber Name :
                <div class="fixed-center">
                    <em><?php echo trim($subscription_data['first_name'] . ' ' . $subscription_data['last_name']); ?></em>
                </div>
            </li>
            <li>E-mail :
                <div class="fixed-center"><em><?php echo $subscription_data['email_address']; ?></em></div>
            </li>
            <li>Phone :
                <div class="fixed-center"><em><?php echo $subscription_data['mobile']; ?></em></div>
            </li>
            <li>Pos Name :
                <div class="fixed-center"><em><?php echo $subscription_data['pos_name']; ?></em></div>
            </li>
            <li>Package :
                <div class="fixed-center"><em><?php echo $subscription_data['package_name']; ?></em></div>
            </li>
            <li>Stores :
                <div class="fixed-center"><em><?php echo $subscription_data['package_store']; ?></em></div>
            </li>
            <li>Stations :
                <div class="fixed-center"><em><?php echo $subscription_data['package_station']; ?></em></div>
            </li>
            <li>Users :
                <div class="fixed-center"><em><?php echo $subscription_data['package_user']; ?></em></div>
            </li>
            <li>Subscription Fee :
                <div class="fixed-center">
                    <em><?php echo comma_seperator($subscription_data['subscription_price']); ?></em></div>
            </li>
            <li>Discount :
                <div class="fixed-center">
                    <em><?php echo comma_seperator($subscription_data['subscription_discount']); ?><?php echo lang('tk'); ?></em>
                </div>
            </li>
            <li>Total Fee :
                <div class="fixed-center">
                    <em><?php echo comma_seperator($subscription_data['subscription_total_price']); ?><?php echo lang('tk'); ?></em>
                </div>
            </li>
            <li>Subscription From :
                <div class="fixed-center">
                    <em><?php echo nice_date($subscription_data['subscription_from_date']); ?></em></div>
            </li>
            <li>Subscription To :
                <div class="fixed-center"><em><?php echo nice_date($subscription_data['subscription_to_date']); ?></em>
                </div>
            </li>
        </ul>
        <?php
    }

    ?>


</div>
<script>
    $(document).ready(function () {
// Handler for .ready() called.
        window.setTimeout(function () {
            location.href = URL + 'company-info';
        }, 5000);
    });

</script>


