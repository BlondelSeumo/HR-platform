<?php
/* Training Type view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
  <?php if($system[0]->performance_option == 'both') {?>
    <?php if(in_array('42',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/performance_appraisal/');?>" data-link-data="<?php echo site_url('admin/performance_appraisal/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon oi oi-aperture"></span>
        <?php echo $this->lang->line('left_performance_xappraisal');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('left_performance_xappraisal');?></div>
      </a>
    </li>
    <?php } ?>
    <?php if(in_array('41',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/performance_indicator/');?>" data-link-data="<?php echo site_url('admin/performance_indicator/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon ion ion-ios-contract"></span>
        <?php echo $this->lang->line('xin_indicator');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_indicator');?></div>
      </a>
    </li>
    <?php } ?>
    <?php } ?>
	<?php if(in_array('107',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/goal_tracking/');?>" data-link-data="<?php echo site_url('admin/goal_tracking/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-cube"></span> <?php echo $this->lang->line('xin_hr_goal_tracking');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_hr_goal_tracking');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('108',$role_resources_ids)) {?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/goal_tracking/type/');?>" data-link-data="<?php echo site_url('admin/goal_tracking/type/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?></div>
      </a> </li>
    <?php } ?>  
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 animated fadeInRight">
<?php if(in_array('338',$role_resources_ids)) {?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_type');?></span> </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_type', 'id' => 'xin-form', 'autocomplete' => 'off','class' => 'm-b-1 add');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/goal_tracking/add_type', $attributes, $hidden);?>
        <div class="form-group">
          <label for="type_name"><?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?></label>
          <input type="text" class="form-control" name="type_name" placeholder="<?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?>">
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_hr_goal_tracking_types_se');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_type');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
