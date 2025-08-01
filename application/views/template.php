
<?php $this->load->view('header'); ?>
<div class="all-wrapper menu-side with-side-panel">
    <div class="layout-w">
        <?php $this->load->view('site_menu'); ?>
        <div class="content-w">
            <?php $this->load->view('top_menu'); ?>
            <?php echo $contents ?>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>
