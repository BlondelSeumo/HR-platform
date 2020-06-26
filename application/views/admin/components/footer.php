<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php
if($theme[0]->fixed_layout=='true') {
	$lay_fixed = 'navbar-fixed-bottom';
} else {
	$lay_fixed = 'footer-static';
}
?>

<nav class="layout-footer footer bg-footer-theme">
  <div class="container-fluid d-flex flex-wrap justify-content-between text-center container-p-x pb-3">
    <div class="pt-3"> <span class="footer-text font-weight-bolder">
      <?php if($system[0]->enable_current_year=='yes'):?>
      <?php echo date('Y');?>
      <?php endif;?>
      © <?php echo $system[0]->footer_text;?> <?php echo $this->Xin_model->hrsale_version();?>
      <?php if($system[0]->enable_page_rendered=='yes'):?>
      - <?php echo $this->lang->line('xin_page_rendered_text');?> <strong>{elapsed_time}</strong> <?php echo $this->lang->line('xin_rendered_seconds');?>. <?php echo  (ENVIRONMENT === 'development') ?  ''.$this->lang->line('xin_codeigniter_version').' <strong>' . CI_VERSION . '</strong>' : '' ?>
      <?php endif; ?>
      </span> </div>
  </div>
</nav>
