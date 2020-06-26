<style type="text/css">
.todo-list ul {
	list-style-type: none;
	padding: 0;
	margin: 0;
}
.todo-list ul li {
	position: relative;
	border: 1px solid #ebebee;
	padding: 15px 40px 15px 45px;
	border-radius: 10px;
	margin-top: 10px;
}
.control {
	display: block;
	position: absolute;
	cursor: pointer;
	left: 15px;
	top: 12px;
}
.control input {
	position: absolute;
	z-index: -1;
	opacity: 0;
}
.control .control-indicator {
	position: absolute;
	top: 2px;
	left: 0;
	height: 22px;
	width: 22px;
	border: 1px solid #e6e6e6;
	border-radius: 50%;
}
.todo-list ul li .task {
	font-size: 14px;
}
span {
	display: inline-block;
}
</style>
<?php $session = $this->session->userdata('username');?>
<?php $file_setting = $this->Xin_model->read_file_setting_info(1);?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $company_info = $this->Xin_model->read_company_setting_info(1); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $moduleInfo = $this->Xin_model->read_setting_info(1);?>
<div id="smarsdstwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/');?>" data-link-data="<?php echo site_url('admin/settings/');?>" class="mb-3 nav-link hrsale-link"><span class="sw-icon fas fa-cog"></span> <?php echo $this->lang->line('xin_system');?>
        <div class="text-muted small"><?php echo $this->lang->line('header_configuration');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/constants/');?>" data-link-data="<?php echo site_url('admin/settings/constants/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-adjust"></span> <?php echo $this->lang->line('left_constants');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up_all_types');?></div>
        </a> </li>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/settings/modules/');?>" data-link-data="<?php echo site_url('admin/settings/modules/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-life-ring"></span> <?php echo $this->lang->line('xin_setup_modules');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_enable_disable_modules');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/database_backup/');?>" data-link-data="<?php echo site_url('admin/settings/database_backup/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fa fa-database"></span> <?php echo $this->lang->line('header_db_log');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_database_backup_restore');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/email_template/');?>" data-link-data="<?php echo site_url('admin/settings/email_template/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-envelope"></span> <?php echo $this->lang->line('left_email_templates');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('left_email_templates');?></div>
        </a> </li>
    </ul>
 </div>   
<hr class="border-light m-0">  
<div class="card mt-3">
  <div class="card-body todo-list">
    <p class="card-text"><?php echo sprintf($this->lang->line('xin_setting_module_details'),$company_info[0]->company_name);?> </p>
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-hover table-bordered" id="xin_table">
       <?php /*?> <?php $attributes = array('name' => 'modules_info', 'id' => 'modules_info', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?php echo form_open('admin/settings/modules_info', $attributes, $hidden);?><?php */?>
        <tbody>
          <tr>
            <td style="width:160px;"><?php echo $this->lang->line('left_recruitment');?></td>
            <td><?php echo sprintf($this->lang->line('xin_setting_module_recruitment_details'),$company_info[0]->company_name);?></td>
            <td style="width:100px;"><label class="switcher switcher-success">
                <input data-group-cls="btn-group-sm" type="checkbox" id="m-recruitment" class="js-switch switch-setup-modules switcher-input" value="true" <?php if($module_recruitment=='true'):?> checked="checked" <?php endif;?>/>
                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label></td>
          </tr>
          <tr>
            <td><?php echo $this->lang->line('left_travels');?></td>
            <td><?php echo $this->lang->line('xin_setting_module_travels_details');?></td>
            <td><label class="switcher switcher-success">
                <input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch-setup-modules switcher-input" id="m-travel" <?php if($module_travel=='true'):?> checked="checked" <?php endif;?> value="true" />
                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label></td>
          </tr>
          <tr>
            <td><?php echo $this->lang->line('xin_files_manager');?></td>
            <td><?php echo $this->lang->line('xin_setting_module_fmanager_details');?></td>
            <td><label class="switcher switcher-success">
                <input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch-setup-modules switcher-input" id="m-files" <?php if($module_files=='true'):?> checked="checked" <?php endif;?> value="true" />
                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label></td>
          </tr>
          <tr>
            <td><?php echo $this->lang->line('xin_multi_language');?></td>
            <td><?php echo $this->lang->line('xin_setting_module_mlanguage_details');?></td>
            <td><label class="switcher switcher-success">
                <input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch-setup-modules switcher-input" id="m-language" <?php if($module_language=='true'):?> checked="checked" <?php endif;?> value="true" />
                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label></td>
          </tr>
          <tr>
            <td><?php echo $this->lang->line('xin_org_chart_title');?></td>
            <td><?php echo $this->lang->line('xin_setting_module_orgchart_details');?></td>
            <td><label class="switcher switcher-success">
                <input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch-setup-modules switcher-input" id="m-orgchart" <?php if($module_orgchart=='true'):?> checked="checked" <?php endif;?> value="true" />
                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label></td>
          </tr>
          <tr>
            <td><?php echo $this->lang->line('xin_hr_events_meetings');?></td>
            <td><?php echo $this->lang->line('xin_hr_events_meetings_details');?></td>
            <td><label class="switcher switcher-success">
                <input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch-setup-modules switcher-input" id="m-events" <?php if($module_events=='true'):?> checked="checked" <?php endif;?> value="true" />
                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label></td>
          </tr>
          <tr>
            <td><?php echo $this->lang->line('xin_hr_chat_box');?></td>
            <td><?php echo sprintf($this->lang->line('xin_hr_chat_box_details'),$company_info[0]->company_name);?></td>
            <td><label class="switcher switcher-success">
                <input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch-setup-modules switcher-input" id="m-chatbox" <?php if($module_chat_box=='true'):?> checked="checked" <?php endif;?> value="true" />
                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label></td>
          </tr>
          <tr>
            <td><?php echo $this->lang->line('xin_enable_sub_departments');?></td>
            <td><?php echo sprintf($this->lang->line('xin_subdepartments_title_details'),$company_info[0]->company_name);?></td>
            <td><label class="switcher switcher-success">
                <input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch-setup-modules switcher-input" id="m-sub_departments" <?php if($is_active_sub_departments=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label></td>
          </tr>
          <tr>
            <td><?php echo $this->lang->line('left_payroll');?></td>
            <td><?php echo sprintf($this->lang->line('xin_payroll_title_details'),$company_info[0]->company_name);?></td>
            <td><label class="switcher switcher-success">
                <input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch-setup-modules switcher-input" id="m-payroll" <?php if($module_payroll=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label></td>
          </tr>
          <tr>
            <td><?php echo $this->lang->line('left_performance');?></td>
            <td><?php echo sprintf($this->lang->line('xin_setting_module_performance_details'),$company_info[0]->company_name);?></td>
            <td><label class="switcher switcher-success">
                <input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch-setup-modules switcher-input" id="m-performance" <?php if($module_performance=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label></td>
          </tr>
        </tbody>
      </table>
      <?php //echo form_close(); ?> </div>
  </div>
</div>
