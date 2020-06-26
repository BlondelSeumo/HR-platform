<?php
/* Application > Update view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $hr_version = file_get_contents('http://www.hrsale.com/hrsale_updates/hrsale_update_version.txt');?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-6 mt-3 mb-1">
   <?php if($hr_version != $this->Xin_model->hrsale_version()):?>
   <div class="alert alert-success alert-dismissible">
        <i class="icon fa fa-check"></i> <?php echo $this->lang->line('xin_new_version_using_hrsale_available');?> <?php echo $hr_version;?>
      </div>
   <?php endif;?>
    <div class="alert alert-info alert-dismissible">
        <i class="icon fa fa-check"></i> <?php echo $this->lang->line('xin_app_update_new_version');?> <?php echo $this->Xin_model->hrsale_version();?>
      </div>
  </div>
</div>
<div class="row m-b-1 <?php echo $get_animate;?>">
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_upgrade_to_latest_version').' '.$hr_version;?> </h3>
      </div>
      <div class="box-body">
       <?php if($hr_version == $this->Xin_model->hrsale_version()):?> 
       <div class="alert alert-success alert-dismissible">
        <?php echo $this->lang->line('xin_version_using_hrsale');?>
      </div>
       <?php else:?>
        <div class="form-actions box-footer">
          <button type="button" class="btn btn-primary" id="downloadButton"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_update_hrsale').$hr_version;?> </button>
        </div>
        <?php endif;?>
       </div>
        <div id="dialog" title="HRSALE updates">
          <div class="progress-label">Starting updates...</div>
          <div id="progressbar"></div>
        </div>
    </div>
  </div>
</div>
<script>

</script>
<style>
#progressbar {
    margin-top: 20px;
  }
 
  .progress-label {
    font-weight: bold;
    text-shadow: 1px 1px 0 #fff;
  }
 
  .ui-dialog-titlebar-close {
    display: none;
  }
  </style>