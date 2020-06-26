<?php
/* Attendance Calendar view > hrsale
*/
?>
<?php
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
$iuser = $this->Xin_model->read_user_info($session['user_id']);
$system = $this->Xin_model->read_setting_info(1);
$get_animate = $this->Xin_model->get_content_animate();
$month_year = $this->input->post('month_year');
if($user_info[0]->user_role_id==1){
	
	$employee_id = $this->input->post('employee_id');
	$company_id = $this->input->post('company_id');
	/* Set the date */
	//if(isset($company_id)){
	$date = strtotime(date("Y-m-d"));
	/* Set the date */
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
	}
	
	if($employee_id == ''){
		$r = $this->Xin_model->read_user_info($session['user_id']);
	} else {
		$r = $this->Xin_model->read_user_info($employee_id);
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
	$r = $this->Xin_model->read_user_info($session['user_id']);
}
?>
<?php
// get designation
$designation = $this->Designation_model->read_designation_information($r[0]->designation_id);
if(!is_null($designation)){
	$designation_name = $designation[0]->designation_name;
} else {
	$designation_name = '--';	
}
// department
$department = $this->Department_model->read_department_information($r[0]->department_id);
if(!is_null($department)){
$department_name = $department[0]->department_name;
} else {
$department_name = '--';	
}
// get company
$company = $this->Xin_model->read_company_info($r[0]->company_id);
if(!is_null($company)){
	$comp_name = $company[0]->name;
} else {
	$comp_name = '--';	
}
// total days in month
$daysInMonth =  date('t');
$imonth = date('F', $date);
$pcount = 0;
$acount = 0;
$lcount = 0;
for($i = 1; $i <= $daysInMonth; $i++):
	$i = str_pad($i, 2, 0, STR_PAD_LEFT);
	// get date <
	$attendance_date = $year.'-'.$month.'-'.$i;
	$get_day = strtotime($attendance_date);
	$day = date('l', $get_day);
	$user_id = $r[0]->user_id;
	$office_shift_id = $r[0]->office_shift_id;
	$attendance_status = '';
	// get holiday
	$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
	$holiday_arr = array();
	if($h_date_chck->num_rows() == 1){
		$h_date = $this->Timesheet_model->holiday_date($attendance_date);
		$begin = new DateTime( $h_date[0]->start_date );
		$end = new DateTime( $h_date[0]->end_date);
		$end = $end->modify( '+1 day' ); 
		
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);
		
		foreach($daterange as $date){
			$holiday_arr[] =  $date->format("Y-m-d");
		}
	} else {
		$holiday_arr[] = '99-99-99';
	}
	// get leave/employee
	$leave_date_chck = $this->Timesheet_model->leave_date_check($user_id,$attendance_date);
	$leave_arr = array();
	if($leave_date_chck->num_rows() == 1){
		$leave_date = $this->Timesheet_model->leave_date($user_id,$attendance_date);
		$begin1 = new DateTime( $leave_date[0]->from_date );
		$end1 = new DateTime( $leave_date[0]->to_date);
		$end1 = $end1->modify( '+1 day' ); 
		
		$interval1 = new DateInterval('P1D');
		$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
		
		foreach($daterange1 as $date1){
			$leave_arr[] =  $date1->format("Y-m-d");
		}	
	} else {
		$leave_arr[] = '99-99-99';
	}
	$office_shift = $this->Timesheet_model->read_office_shift_information($office_shift_id);
	$check = $this->Timesheet_model->attendance_first_in_check($user_id,$attendance_date);
	// get holiday>events
	if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
		$status = 'H';	
		$pcount += 0;
		//$acount += 0;
	} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
		$status = 'H';
		$pcount += 0;
		//$acount += 0;
	} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
		$status = 'H';
		$pcount += 0;
		//$acount += 0;
	} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
		$status = 'H';
		$pcount += 0;
		//$acount += 0;
	} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
		$status = 'H';
		$pcount += 0;
		//$acount += 0;
	} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
		$status = 'H';
		$pcount += 0;
		//$acount -= 1;
	} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
		$status = 'H';
		$pcount += 0;
		//$acount -= 1;
	} else if(in_array($attendance_date,$holiday_arr)) { // holiday
		$status = 'H';
		$pcount += 0;
		//$acount += 0;
	} else if(in_array($attendance_date,$leave_arr)) { // on leave
		$status = 'L';
		$pcount += 0;
		$lcount += 1;
	//	$acount += 0;
	} else if($check->num_rows() > 0){
		$pcount += 1;
		//$acount -= 1;
	}	else {
		$status = 'A';
		//$acount += 1;
		$pcount += 0;
		// set to present date
		$iattendance_date = strtotime($attendance_date);
		$icurrent_date = strtotime(date('Y-m-d'));
		if($iattendance_date <= $icurrent_date){
			$acount += 1;
		} else {
			$acount += 0;
		}
	}
endfor;
//}
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
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/');?>" data-link-data="<?php echo site_url('admin/timesheet/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_month_timesheet_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view_all');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('261',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/timecalendar/');?>" data-link-data="<?php echo site_url('admin/timesheet/timecalendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-calendar"></span> <?php echo $this->lang->line('xin_acc_calendar');?>
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
        <?php echo form_open('admin/timesheet/timecalendar/', $attributes, $hidden);?>
  <div class="form-row">
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('xin_e_details_date');?></label>
      <input class="form-control hr_month_year" value="<?php if(!isset($month_year)): echo date('Y-m'); else: echo $month_year; endif;?>" name="month_year" type="text">
    </div>
    <?php if($user_info[0]->user_role_id==1){?>
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
      <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
        <option value=""></option>
        <?php foreach($get_all_companies as $company) {?>
        <option value="<?php echo $company->company_id?>" 
					<?php if(isset($employee_id)): if($company->company_id==$company_id): ?> selected="selected" <?php endif; endif;?>><?php echo $company->name?></option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md mb-3" id="employee_ajax">
      <label class="form-label"><?php echo $this->lang->line('xin_employee');?></label>
      <select name="employee_id" id="employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
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
<?php if(isset($company_id) || $user_info[0]->user_role_id!=1){?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $r[0]->first_name.' '.$r[0]->last_name;?> - <?php echo date('F Y',strtotime($month_year));?></strong></span> </div>
      <div class="card-body">
        <div class="table-responsive" data-pattern="priority-columns">
          <table class="table table-striped m-md-b-0">
            <tbody>
              <tr>
                <th scope="row"><?php echo $this->lang->line('left_company');?></th>
                <td class="text-right"><?php echo $comp_name;?></td>
              </tr>
              <tr>
                <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('left_department');?></th>
                <td class="text-right"><?php echo $department_name;?></td>
              </tr>
              <tr>
                <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('left_designation');?></th>
                <td class="text-right"><?php echo $designation_name;?></td>
              </tr>
              <tr>
                <th scope="row"><?php echo $this->lang->line('dashboard_employee_id');?></th>
                <td class="text-right"><?php echo $r[0]->employee_id;?></td>
              </tr>
              <tr>
                <th scope="row"><?php echo $this->lang->line('xin_attendance_total_present');?></th>
                <td class="text-right"><?php echo $pcount;?></td>
              </tr>
              <tr>
                <th scope="row"><?php echo $this->lang->line('xin_attendance_total_absent');?></th>
                <td class="text-right"><?php echo $acount;?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.popoverTitleCalendar{
  width: 100%;
  height: 100%;
  padding: 15px 15px;
  font-family: Roboto;
  font-size: 13px;
  border-radius: 5px 5px 0 0;
}
.popoverInfoCalendar i{
  font-size: 14px;
    margin-right: 10px;
    line-height: inherit;
    color: #d3d4da;
}
.popoverInfoCalendar p{
  margin-bottom: 1px;
}
.popoverDescCalendar{
  margin-top: 12px;
  padding-top: 12px;
  border-top: 1px solid #E3E3E3;
  overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
.popover-title {
    background: transparent;
    font-weight: 600;
    padding: 0 !important;
    border: none;
}
.popover-content {
    padding: 15px 15px;
    font-family: Roboto;
    font-size: 13px;
}
.fc-center h2{
   text-transform: uppercase;
  font-size: 18px;
  font-family: Roboto;
  font-weight: 500;
  color: #505363;
  line-height: 32px;
}
.fc-toolbar.fc-header-toolbar {
    margin-bottom: 22px;
    padding-top: 22px;
}
.fc-agenda-view .fc-day-grid .fc-row .fc-content-skeleton {
    padding-bottom: 1em;
    padding-top: 1em;
}
.fc-day{
  transition: all 0.2s linear;
}
.fc-day:hover{
  background:#EEF7FF;
  cursor: pointer;
  transition: all 0.2s linear;
}
.fc-highlight {
    background: #EEF7FF;
    opacity: 0.7;
}
.fc-time-grid-event.fc-short .fc-time:before {
    content: attr(data-start);
    display: none;
}
.fc-time-grid-event.fc-short .fc-time span {
    display: inline-block;
}
.fc-time-grid-event.fc-short .fc-avatar-image {
    display: none;
    transition: all 0.3s linear;
}
.fc-time-grid .fc-bgevent, .fc-time-grid .fc-event {
    border: 1px solid #fff !important;
}
.fc-time-grid-event.fc-short .fc-content {
    padding: 4px 20px 10px 22px !important;
}
.fc-time-grid-event .fc-avatar-image{
    top: 9px;
}
.fc-event-vert {
  min-height: 22px;
}
.fc .fc-axis {
    vertical-align: middle;
    padding: 0 4px;
    white-space: nowrap;
    font-size: 10px;
    color: #505362;
    text-transform: uppercase;
    text-align: center !important;
    background-color: #fafafa;
}
.fc-unthemed .fc-event .fc-content, .fc-unthemed .fc-event-dot .fc-content {
    padding: 10px 20px 10px 22px;
    font-family: 'Roboto', sans-serif;
    margin-left: -1px;
    height: 100%;
}
.fc-event{
    border: none !important;
}
.fc-day-grid-event .fc-time {
    font-weight: 700;
      text-transform: uppercase;
}
.fc-unthemed .fc-day-grid td:not(.fc-axis).fc-event-container {
    padding: 0.2rem 0.5rem;
}
.fc-unthemed .fc-content, .fc-unthemed .fc-divider, .fc-unthemed .fc-list-heading td, .fc-unthemed .fc-list-view, .fc-unthemed .fc-popover, .fc-unthemed .fc-row, .fc-unthemed tbody, .fc-unthemed td, .fc-unthemed th, .fc-unthemed thead {
    border-color: #DADFEA;
}
.fc-ltr .fc-h-event .fc-end-resizer, .fc-ltr .fc-h-event .fc-end-resizer:before, .fc-ltr .fc-h-event .fc-end-resizer:after, .fc-rtl .fc-h-event .fc-start-resizer, .fc-rtl .fc-h-event .fc-start-resizer:before, .fc-rtl .fc-h-event .fc-start-resizer:after {
    left: auto;
    cursor: e-resize;
    background: none;
}
.colorAppointment :before {
    background-color: #9F4AFF;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
.colorCheck-in :before {
    background-color: #ff4747;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
.colorCheckout :before {
    background-color: #FFC400;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
.colorInventory :before {
    background-color: #FE56F2;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
.colorValuation :before {
    background-color: #0DE882;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
.colorViewing :before {
    background-color: #26CBFF;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
select.filter{
  width: 500px !important;
}

.popover  {
	background: #fff !important;
	color: #2E2F34;
  border: none;
  margin-bottom: 10px;
}

/*popover header*/
.popover-title{
    background: #F7F7FC;
    font-weight: 600;
    padding: 15px 15px 11px ;
    border: none;
}

/*popover arrows*/
.popover.top .arrow:after {
  border-top-color: #fff;
}

.popover.right .arrow:after {
  border-right-color: #fff;
}

.popover.bottom .arrow:after {
  border-bottom-color: #fff;
}

.popover.left .arrow:after {
  border-left-color: #fff;
}

.popover.bottom .arrow:after {
  border-bottom-color: #fff;
}
.material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;  /* Preferred icon size */
  display: inline-block;
  line-height: 1;
  text-transform: none;
  letter-spacing: normal;
  word-wrap: normal;
  white-space: nowrap;
  direction: ltr;

  /* Support for all WebKit browsers. */
  -webkit-font-smoothing: antialiased;
  /* Support for Safari and Chrome. */
  text-rendering: optimizeLegibility;

  /* Support for Firefox. */
  -moz-osx-font-smoothing: grayscale;

  /* Support for IE. */
  font-feature-settings: 'liga';
}
.fc-icon-print::before{
  font-family: 'Material Icons';
  content: "\e8ad";
  font-size: 24px;
}
.fc-printButton-button{
  padding: 0 3px !important;
}

@media print {
.print-visible  { display: inherit !important; }
.hidden-print   { display: none !important; }
}
</style>
<?php } ?>
<style type="text/css">
.calendar-options { padding: .3rem 0.4rem !important;}
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
