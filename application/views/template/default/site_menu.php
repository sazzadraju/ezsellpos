<!--------------------
START - Mobile Menu
-------------------->
<div class="menu-mobile menu-activated-on-click color-scheme-dark">
    <div class="mob-logo hidden-sm">
        <a class="mm-logo" href="<?php echo base_url();?>dashboard"><img src="<?=base_url()?>themes/default/img/logo.png"></a>
    </div>
    <div class="mm-logo-buttons-w bg  hidden-sm">

        <div class="top-sts mob-home-menu">
            <a href="<?php echo base_url();?>"><i class="fa fa-home mod" aria-hidden="true"></i></a>
        </div>
        <div class="pad0 module-mob-menu">
            <div class="mm-buttons">

                <div class="mob-menu"> <i id="mob-menu" class="fa fa-th-large mod" aria-hidden="true"></i>

                </div>


            </div>
        </div>

        <div class="col-xs-12 pad0">
            <ul class="nav navbar-nav" style="margin:0">

                <div class="col-xs-12">
                    <li class="left w-100">
                        <div class="str-mob" style="margin:0;font-size: 12px;"><i class="material-icons">store</i>
                            <p>
                                <strong>Store:</strong> <?=explode('&',$this->session->userdata['login_info']['store_name'])[0]?>
                            </p>
                        </div>
                    </li>
                </div>
                <div class="col-xs-12">
                    <li class="left  w-100">
                        <div class="str-mob" style="margin:0 !important;font-size: 12px;"><i class="material-icons">transfer_within_a_station</i>
                            <p>
                                <strong>Station:</strong> <?=$this->session->userdata['login_info']['station_name']?>
                            </p>
                        </div>
                    </li>
                </div>

            </ul>
        </div>


    </div>
   

    <div class="mob-menu-show hidden-sm">

        <?php
        echo $this->dynamic_menu->build_menu_mobile();
        ?>

    </div>


    <script>
        $(document).ready(function () {
            $("#mob-menu").click(function () {
                $(this).toggleClass('active-hover');
                $(".mob-menu-show").toggleClass('active-mob-menu');
            });

            $(".list").click(function () {
                $(this).siblings(".submenu").slideDown();

            });

            $(".sb-menu-back").click(function () {
                $(this).parent('.submenu').slideUp();
            });
        });
    </script>

    <div class="menu-and-user">

        <!--------------------
START - Mobile Menu List
-------------------->
        <?php
        echo $this->dynamic_menu->build_menu();
        ?>
        <!--------------------
END - Mobile Menu List
-------------------->

    </div>
</div>
<!--------------------
END - Mobile Menu
-------------------->
<!--------------------
START - Menu side
-------------------->
<div class="desktop-menu menu-side-w menu-activated-on-click">

    <div class="menu-and-user">

        <?php
        echo $this->dynamic_menu->build_menu();
        ?>


    </div>
</div>
<!--------------------
END - Menu side 
-------------------->