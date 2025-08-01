<?php $this->load->view('template/default/header'); ?>
<div class="all-wrapper menu-side with-side-panel">
    
        <?php $this->load->view('template/default/top_menu'); ?>
    <div class="layout-w">
        <?php $this->load->view('template/default/site_menu'); ?>
        <div class="content-w">
            
            <?php echo $contents; ?>
        </div>
    </div>
</div>

<?php $this->load->view('template/default/footer'); ?>
        




