<?php $role_resources_ids = $this->Xin_model->user_role_resource();?>
<?php
$session = $this->session->userdata('username');
$theme = $this->Xin_model->read_theme_info(1);
$user_info = $this->Xin_model->read_user_info($session['user_id']);
if($user_info[0]->is_active!=1) {
	redirect('admin/');
}
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $arr_mod = $this->Xin_model->select_module_class($this->router->fetch_class(),$this->router->fetch_method()); ?>
<?php 
if($theme[0]->sub_menu_icons != ''){
	$submenuicon = $theme[0]->sub_menu_icons;
} else {
	$submenuicon = 'fa-circle-o';
}
?>
<div class="container-m-nx container-m-ny mb-3 mt-2">

  <div class="file-manager-actions container-p-x py-2">
    <div>
      <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-default icon-btn md-btn-flat active">
          <input type="radio" name="file-manager-view" value="file-manager-col-view" checked> <span class="ion ion-md-apps"></span>
        </label>
        <label class="btn btn-default icon-btn md-btn-flat">
          <input type="radio" name="file-manager-view" value="file-manager-row-view"> <span class="ion ion-md-menu"></span>
        </label>
      </div>
    </div>
  </div>
<hr class="m-0">
</div>
<div class="file-manager-container file-manager-col-view">

  <div class="file-manager-row-header">
    <div class="file-item-name pb-2">Reports</div>
  </div>
<?php if(in_array('111',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up ion ion-md-calculator text-secondary"></div>
    <a href="<?php echo site_url('admin/reports/payslip');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_hr_reports_payslip');?></strong>
    </a>
  </div>
<?php } ?>
<?php if(in_array('112',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up ion ion-md-clock text-secondary"></div>
    <a href="<?php echo site_url('admin/reports/employee_attendance');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_hr_reports_attendance_employee');?></strong>
    </a>
  </div>
  <?php } ?>
 <?php if(in_array('113',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-portrait text-secondary"></div>
    <a href="<?php echo site_url('admin/reports/employee_training');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_hr_reports_training');?></strong>
    </a>
  </div>
  <?php } ?> 
  <?php if(in_array('114',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up ion ion-logo-buffer text-secondary"></div>
    <a href="<?php echo site_url('admin/reports/projects');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_hr_reports_projects');?></strong>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('115',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-file-signature text-secondary"></div>
    <a href="<?php echo site_url('admin/reports/tasks');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_hr_reports_tasks');?></strong>
    </a>
  </div>
  <?php } ?> 
  <?php if(in_array('116',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-user-lock text-secondary"></div>
    <a href="<?php echo site_url('admin/reports/roles');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_hr_report_user_roles_report');?></strong>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('117',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-user-friends text-secondary"></div>
    <a href="<?php echo site_url('admin/reports/employees');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_hr_report_employees');?></strong>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('83',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-money-bill-alt text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/account_statement');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_acc_account_statement');?></strong>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('84',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up ion ion-md-cash text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/expense_report');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_acc_expense_reports');?></strong>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('85',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-money-check-alt text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/income_report');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_acc_income_reports');?></strong>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-exchange-alt text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <strong><?php echo $this->lang->line('xin_acc_transfer_report');?></strong>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fa fa-graduation-cap text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_awards_report');?>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-user-times text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_termination_report');?>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up ion ion-ios-airplane text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_travel_report');?>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-calendar-alt text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_hr_report_leave_report');?>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up ion ion-ios-paper-plane text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_holidays_report');?>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-edit text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_complaints_report');?>
    </a>
  </div>
  <?php } ?>
   <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-exclamation-triangle text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_warning_report');?>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-user-alt-slash text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_employees_exit_report');?>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up ion ion-md-trending-up text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_promotion_report');?>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up fas fa-user-edit text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_resignation_report');?>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
  <div class="file-item">
    <div class="file-item-icon file-item-level-up ion ion-md-today text-secondary"></div>
    <a href="<?php echo site_url('admin/accounting/transfer_report');?>" class="file-item-name">
      <?php echo $this->lang->line('xin_assets_report');?>
    </a>
  </div>
  <?php } ?>  
</div>
<hr class="m-0">