<?php
/* Monthly Timesheet view > hrsale
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_resources_ids = $this->Xin_model->user_role_resource();
$month_year = $this->input->post('month_year');
if($user_info[0]->user_role_id==1){
	$employee_id = $this->input->post('employee_id');
	$company_id = $this->input->post('company_id');
	/* Set the date */
	$date = strtotime(date("Y-m-d"));
	// get month and year
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$xin_employees = $this->Timesheet_model->get_xin_employees();
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($this->input->post('employee_id')==0){
			$xin_employees = $this->Timesheet_model->get_xin_employees();
		} else {
			$xin_employees = $this->Xin_model->read_user_info($this->input->post('employee_id'));
		}
	}
} else if(in_array('10',$role_resources_ids)) {
	$employee_id = $this->input->post('employee_id');
	$company_id = $this->input->post('company_id');
	/* Set the date */
	$date = strtotime(date("Y-m-d"));
	// get month and year
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$xin_employees = $this->Timesheet_model->get_xin_employees();
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($this->input->post('employee_id')==0){
			$xin_employees = $this->Timesheet_model->get_xin_employees();
		} else {
			$xin_employees = $this->Xin_model->read_user_info($this->input->post('employee_id'));
		}
	}
} else {
	$date = strtotime(date("Y-m-d"));
	/* Set the date */
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$month_year = date('Y-m');
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		$month_year = $month_year;
	}
	$xin_employees = $this->Xin_model->read_user_info($session['user_id']);
}
// total days in month
$daysInMonth = date('t');
$imonth = date('F', $date);
?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('423',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/attendance_dashboard/');?>" data-link-data="<?php echo site_url('admin/timesheet/attendance_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_timesheet_dashboard_title');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('28',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/attendance/');?>" data-link-data="<?php echo site_url('admin/timesheet/attendance/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_attendance');?>
      <div class="text-muted small"><?php echo $this->lang->line('left_attendance');?> <?php echo $this->lang->line('xin_role_list');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('30',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/update_attendance');?>" data-link-data="<?php echo site_url('admin/timesheet/update_attendance');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-pencil-alt"></span> <?php echo $this->lang->line('left_update_attendance');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_edit_info');?> <?php echo $this->lang->line('left_attendance');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('10',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/');?>" data-link-data="<?php echo site_url('admin/timesheet/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_month_timesheet_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view_all');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('261',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/timecalendar/');?>" data-link-data="<?php echo site_url('admin/timesheet/timecalendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-calendar"></span> <?php echo $this->lang->line('xin_acc_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_acc_calendar');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('401',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/overtime_request/');?>" data-link-data="<?php echo site_url('admin/overtime_request/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-timer"></span> <?php echo $this->lang->line('xin_overtime_request');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_overtime_request');?></div>
      </a> </li>
      <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="ui-bordered px-4 pt-4 mb-4">
  <?php $attributes = array('name' => 'xin-form', 'id' => 'xin-form', 'autocomplete' => 'off');?>
  <?php $hidden = array('_user' => $session['user_id']);?>
  <?php echo form_open('admin/timesheet/', $attributes, $hidden);?>
  <div class="form-row">
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('xin_e_details_date');?></label>
      <input class="form-control hr_month_year" value="<?php if(!isset($month_year)): echo date('Y-m'); else: echo $month_year; endif;?>" name="month_year" type="text">
    </div>
    <?php if($user_info[0]->user_role_id==1){?>
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
      <select class="form-control" name="company_id" id="aj_company_mn" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
        <option value=""></option>
        <?php foreach($get_all_companies as $company) {?>
        <option value="<?php echo $company->company_id?>" 
					<?php if(isset($employee_id)): if($company->company_id==$company_id): ?> selected="selected" <?php endif; endif;?>><?php echo $company->name?></option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md mb-3" id="mn_employee_ajax">
      <label class="form-label"><?php echo $this->lang->line('xin_employee');?></label>
      <select name="employee_id" id="m_employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
        <?php if(isset($employee_id)): ?>
        <?php $result = $this->Department_model->ajax_company_employee_info($company_id); ?>
        <option value="0">All</option>
        <?php foreach($result as $employee) {?>
        <option value="<?php echo $employee->user_id;?>" <?php if($employee->user_id==$employee_id): ?> selected="selected" <?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
        <?php } ?>
        <?php endif;?>
      </select>
    </div>
    <?php } ?>
    <div class="col-md col-xl-2 mb-4">
      <label class="form-label d-none d-md-block">&nbsp;</label>
      <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
    </div>
  </div>
  <?php echo form_close(); ?> </div>
<div class="card <?php echo $get_animate;?>"> </div>
<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_employees_monthly_timesheet');?></strong> A: Absent, P: Present, H: Holiday, L: Leave </span> </div>
  <div class="card-body">
    <div id="calendar"></div>
  </div>
</div>
