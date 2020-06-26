<?php 
$session = $this->session->userdata('username');
$user_info = $this->Exin_model->read_user_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
	$lde_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
} else { 
	if($user_info[0]->gender=='Male') {  
		$lde_file = base_url().'uploads/profile/default_male.jpg'; 
	} else {  
		$lde_file = base_url().'uploads/profile/default_female.jpg';
	}
}
$last_login =  new DateTime($user_info[0]->last_login_date);
// get designation
$designation = $this->Designation_model->read_designation_information($user_info[0]->designation_id);
if(!is_null($designation)){
	$designation_name = $designation[0]->designation_name;
} else {
	$designation_name = '--';	
}
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $announcement = $this->Announcement_model->get_new_announcements();?>
<?php foreach($announcement as $new_announcement):?>
<?php
	$current_date = strtotime(date('Y-m-d'));
	$announcement_end_date = strtotime($new_announcement->end_date);
	if($current_date <= $announcement_end_date) {
?>

<div class="alert alert-success alert-dismissible fade in mb-1" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <strong><?php echo $new_announcement->title;?>:</strong> <?php echo $new_announcement->summary;?> <a href="#" class="alert-link" data-toggle="modal" data-target=".view-modal-annoucement" data-announcement_id="<?php echo $new_announcement->announcement_id;?>"><?php echo $this->lang->line('xin_view');?></a> </div>
<?php } ?>
<?php endforeach;?>
<?php
$att_date =  date('d-M-Y');
$attendance_date = date('d-M-Y');
// get office shift for employee
$get_day = strtotime($att_date);
$day = date('l', $get_day);
$strtotime = strtotime($attendance_date);
$new_date = date('d-M-Y', $strtotime);
// office shift
$u_shift = $this->Timesheet_model->read_office_shift_information($user_info[0]->office_shift_id);
if(!is_null($u_shift)){
	// get clock in/clock out of each employee
	if($day == 'Monday') {
		if($u_shift[0]->monday_in_time==''){
			$office_shift = $this->lang->line('dashboard_today_monday_shift');
		} else {
			$in_time =  new DateTime($u_shift[0]->monday_in_time. ' ' .$attendance_date);
			$out_time =  new DateTime($u_shift[0]->monday_out_time. ' ' .$attendance_date);
			$clock_in = $in_time->format('h:i a');
			$clock_out = $out_time->format('h:i a');
			$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
		}
	} else if($day == 'Tuesday') {
		if($u_shift[0]->tuesday_in_time==''){
			$office_shift = $this->lang->line('dashboard_today_tuesday_shift');
		} else {
			$in_time =  new DateTime($u_shift[0]->tuesday_in_time. ' ' .$attendance_date);
			$out_time =  new DateTime($u_shift[0]->tuesday_out_time. ' ' .$attendance_date);
			$clock_in = $in_time->format('h:i a');
			$clock_out = $out_time->format('h:i a');
			$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
		}
	} else if($day == 'Wednesday') {
		if($u_shift[0]->wednesday_in_time==''){
			$office_shift = $this->lang->line('dashboard_today_wednesday_shift');
		} else {
			$in_time =  new DateTime($u_shift[0]->wednesday_in_time. ' ' .$attendance_date);
			$out_time =  new DateTime($u_shift[0]->wednesday_out_time. ' ' .$attendance_date);
			$clock_in = $in_time->format('h:i a');
			$clock_out = $out_time->format('h:i a');
			$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
		}
	} else if($day == 'Thursday') {
		if($u_shift[0]->thursday_in_time==''){
			$office_shift = $this->lang->line('dashboard_today_thursday_shift');
		} else {
			$in_time =  new DateTime($u_shift[0]->thursday_in_time. ' ' .$attendance_date);
			$out_time =  new DateTime($u_shift[0]->thursday_out_time. ' ' .$attendance_date);
			$clock_in = $in_time->format('h:i a');
			$clock_out = $out_time->format('h:i a');
			$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
		}
	} else if($day == 'Friday') {
		if($u_shift[0]->friday_in_time==''){
			$office_shift = $this->lang->line('dashboard_today_friday_shift');
		} else {
			$in_time =  new DateTime($u_shift[0]->friday_in_time. ' ' .$attendance_date);
			$out_time =  new DateTime($u_shift[0]->friday_out_time. ' ' .$attendance_date);
			$clock_in = $in_time->format('h:i a');
			$clock_out = $out_time->format('h:i a');
			$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
		}
	} else if($day == 'Saturday') {
		if($u_shift[0]->saturday_in_time==''){
			$office_shift = $this->lang->line('dashboard_today_saturday_shift');
		} else {
			$in_time =  new DateTime($u_shift[0]->saturday_in_time. ' ' .$attendance_date);
			$out_time =  new DateTime($u_shift[0]->saturday_out_time. ' ' .$attendance_date);
			$clock_in = $in_time->format('h:i a');
			$clock_out = $out_time->format('h:i a');
			$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
		}
	} else if($day == 'Sunday') {
		if($u_shift[0]->sunday_in_time==''){
			$office_shift = $this->lang->line('dashboard_today_sunday_shift');
		} else {
			$in_time =  new DateTime($u_shift[0]->sunday_in_time. ' ' .$attendance_date);
			$out_time =  new DateTime($u_shift[0]->sunday_out_time. ' ' .$attendance_date);
			$clock_in = $in_time->format('h:i a');
			$clock_out = $out_time->format('h:i a');
			$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
		}
	}
	$emp_shift = '1';
} else {
	$office_shift = $this->lang->line('xin_office_shift_not_assigned');
	$emp_shift = '0';
}
?>
<?php $sys_arr = explode(',',$system[0]->system_ip_address); ?>
<?php $attendances = $this->Timesheet_model->attendance_time_checks($user_info[0]->user_id); $dat = $attendances->result();?>
<?php
$bgatt = 'bg-success';
if($attendances->num_rows() < 1) {
	$bgatt = 'bg-success';
} else {
	$bgatt = 'bg-danger';
}
?>
<div class="media align-items-center mb-4">
  <img src="<?php echo $lde_file;?>" alt="" class="d-block ui-w-100 rounded-circle">
  <div class="media-body ml-4">
    <h4 class="font-weight-bold mb-0"><?php echo $user_info[0]->first_name. ' ' .$user_info[0]->last_name;?> <span class="text-muted font-weight-normal">@<?php echo $designation_name;?></span></h4>
    <div class="text-muted mb-2">ID: <?php echo $user_info[0]->employee_id;?></div>
    <div class="text-muted mb-2"><?php echo $office_shift;?></div>
    <?php if($emp_shift == 1){?>
		<?php $attributes = array('name' => 'set_clocking', 'id' => 'set_clocking', 'autocomplete' => 'off', 'class' => 'form');?>
        <?php $hidden = array('exuser_id' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/set_clocking', $attributes, $hidden);?>
        <input type="hidden" name="timeshseet" value="<?php echo $user_info[0]->user_id;?>">
        <?php if($attendances->num_rows() < 1) {?>
        <input type="hidden" value="clock_in" name="clock_state" id="clock_state">
        <input type="hidden" value="" name="time_id" id="time_id">
        <button class="btn btn-sm btn-success text-uppercase" type="submit" id="clock_btn"><?php echo $this->lang->line('dashboard_clock_in');?></button>&nbsp;
        <button class="btn btn-default btn-sm text-uppercase" disabled="disabled" type="submit" id="clock_btn"><?php echo $this->lang->line('dashboard_clock_out');?></button>&nbsp;
        <?php } else {?>
        <input type="hidden" value="clock_out" name="clock_state" id="clock_state">
        <input type="hidden" value="<?php echo $dat[0]->time_attendance_id;?>" name="time_id" id="time_id">
        <button class="btn btn-sm btn-success text-uppercase" type="submit" id="clock_btn" disabled="disabled"><?php echo $this->lang->line('dashboard_clock_in');?></button>&nbsp;
        <button class="btn btn-default btn-sm text-uppercase" type="submit" id="clock_btn"><?php echo $this->lang->line('dashboard_clock_out');?></button>&nbsp;
        <?php } ?>
        <?php if(in_array('445',$role_resources_ids)) { ?>
        <a href="<?php echo site_url('admin/profile');?>" class="btn btn-default btn-sm icon-btn" data-toggle="tooltip" data-state="primary" data-placement="top" title="<?php echo $this->lang->line('header_my_profile');?>"><i class="fas fa-user-cog"></i></a><?php } ?>
        <?php echo form_close(); ?>
    <?php } ?>
  </div>
</div>

<div class="row mt-3">
  <?php if(in_array('14',$role_resources_ids)) { ?>
  <?php if($system[0]->module_awards=='true'){?>
  <div class="col-sm-6 col-xl-3">
  <a href="<?php echo site_url('admin/awards/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-trophy display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->Exin_model->total_employee_awards_dash();?> <?php echo $this->lang->line('left_awards');?></div>
            <div class="text-large"><?php echo $this->lang->line('xin_view');?></div>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>
  <?php } ?>
  <?php } else {?>
  <?php if(in_array('28',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3">
  <a href="<?php echo site_url('admin/timesheet/attendance/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-clock display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('dashboard_attendance');?></div>
            <div class="text-large"><?php echo $this->lang->line('xin_view');?></div>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>
  <?php } ?>
  <?php } ?>
  <?php if(in_array('37',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3">
  <a href="<?php echo site_url('admin/payroll/payment_history/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-calculator display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('left_payslips');?></div>
            <div class="text-large"><?php echo $this->lang->line('xin_view');?></div>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>
  <?php } ?>
  <?php if(in_array('46',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3">
  <a href="<?php echo site_url('admin/timesheet/leave/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-calendar display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_performance_management');?></div>
            <div class="text-large"><?php echo $this->lang->line('left_leave');?></div>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>
 <?php } ?>
 <?php if($system[0]->module_travel=='true'){?>
 <?php if(in_array('17',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3">
  <a href="<?php echo site_url('admin/travel/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-paper-plane display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_travel');?></div>
            <div class="text-large"><?php echo $this->lang->line('xin_requests');?></div>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>
 <?php } ?>
 <?php } ?>
</div>
<?php if(in_array('37',$role_resources_ids)) { ?>
<div class="card mb-4">
  <h6 class="card-header with-elements">
    <div class="card-header-title"><?php echo $this->lang->line('left_payroll');?></div>
  </h6>
  <div class="row no-gutters row-bordered">
    <div class="col-md-8 col-lg-12 col-xl-8">
      <div class="card-body">
        <div style="height: 210px;">
          <canvas id="hrsale_user_payroll" style="display: block; height: 210px; width: 754px;" width="942" height="262"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-lg-12 col-xl-4">
      <div class="card-body"> 
        
        <!-- Numbers -->
        <div class="row">
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_attendance_this_month');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrsale_user_payroll_this_month($session['user_id']));?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_6_month');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrsale_user_payroll_last_6_month($session['user_id']));?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_1_year');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrsale_user_payroll_last_1year($session['user_id']));?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_2_year');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrsale_user_payroll_last_2years($session['user_id']));?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_3_year');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrsale_user_payroll_last_3years($session['user_id']));?></span> </div>
        </div>
        <!-- / Numbers --> 
        
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if(in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids)) { ?>
<div class="row">
    <?php if(in_array('44',$role_resources_ids)) { ?>
    <div class="col-md-6">
      <div class="card mb-4">
        <h6 class="card-header with-elements border-0 pr-0 pb-0">
          <div class="card-header-title"><?php echo $this->lang->line('xin_projects_status');?></div>
        </h6>
        <div class="row">
          <div class="col-md-6">
            <div id="overflow-scrolls" class="py-2 px-3 " style="overflow:auto; height:200px;">
              <div class="table-responsive">
                <table class="table mb-0 table-dashboard">
                  <tbody>
                    <?php //$dc_color = array(,'#2196f3','#02bc77','#d3733b','#673AB7');?>
                    <?php $dj=0;$projects = get_user_projects_status($session['user_id']); foreach($projects->result() as $eproject) { ?>
                    <?php
                    //$row = total_user_projects_status($eproject->status,$session['user_id']);
                    if($eproject->status==0){
                        $row = total_user_projects_status($eproject->status,$session['user_id']);
                        $csname = htmlspecialchars_decode($this->lang->line('xin_not_started'));
                        $bdcolor = '#647c8a';
                    } else if($eproject->status==1){
                        $csname = htmlspecialchars_decode($this->lang->line('xin_in_progress'));
                        $row = total_user_projects_status($eproject->status,$session['user_id']);
                        $bdcolor = '#2196f3';
                    } else if($eproject->status==2){
                        $csname = htmlspecialchars_decode($this->lang->line('xin_completed'));
                        $row = total_user_projects_status($eproject->status,$session['user_id']);
                        $bdcolor = '#02bc77';
                    } else if($eproject->status==3){
                        $csname = htmlspecialchars_decode($this->lang->line('xin_project_cancelled'));
                        $row = total_user_projects_status($eproject->status,$session['user_id']);
                        $bdcolor = '#d3733b';
                    } else if($eproject->status==4){
                        $csname = htmlspecialchars_decode($this->lang->line('xin_project_hold'));
                        $row = total_user_projects_status($eproject->status,$session['user_id']);
                        $bdcolor = '#673AB7';
                    }
                ?>
                    <tr>
                      <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $bdcolor;?>;"></div></td>
                      <td><?php echo htmlspecialchars_decode($csname);?> (<?php echo $row;?>)</td>
                    </tr>
                    <?php $dj++; } ?>
                    <?php  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div style="height:120px;">
              <canvas id="hrsale_user_chart_projects"  style="display: block; height: 150px; width:300px;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php if(in_array('45',$role_resources_ids)) { ?>
    <div class="col-md-6">
      <div class="card mb-4">
        <h6 class="card-header with-elements border-0 pr-0 pb-0">
          <div class="card-header-title"><?php echo $this->lang->line('xin_tasks_status');?></div>
        </h6>
        <div class="row">
          <div class="col-md-6">
            <div class="overflow-scrolls py-2 px-3" style="overflow:auto; height:200px;">
              <div class="table-responsive">
                <table class="table mb-0 table-dashboard">
                  <tbody>
                    <?php $dc_color = array('#3c8dbc','#006400','#dd4b39','#a98852','#f39c12','#605ca8');?>
                    <?php $sj=0;$tasks = get_user_tasks_status($session['user_id']); foreach($tasks->result() as $etask) { ?>
                    <?php
                    if($etask->task_status==0){
                        $sname = htmlspecialchars_decode($this->lang->line('xin_not_started'));
                        $trow = total_user_tasks_status($etask->task_status,$session['user_id']);
                        $tbdcolor = '#647c8a';
                    } else if($etask->task_status==1){
                        $sname = htmlspecialchars_decode($this->lang->line('xin_in_progress'));
                        $trow = total_user_tasks_status($etask->task_status,$session['user_id']);
                        $tbdcolor = '#2196f3';
                    } else if($etask->task_status==2){
                        $sname = htmlspecialchars_decode($this->lang->line('xin_completed'));
                        $trow = total_user_tasks_status($etask->task_status,$session['user_id']);
                        $tbdcolor = '#02bc77';
                    } else if($etask->task_status==3){
                        $sname = htmlspecialchars_decode($this->lang->line('xin_project_cancelled'));
                        $trow = total_user_tasks_status($etask->task_status,$session['user_id']);
                        $tbdcolor = '#d3733b';
                    } else if($etask->task_status==4){
                        $sname = htmlspecialchars_decode($this->lang->line('xin_project_hold'));
                        $trow = total_user_tasks_status($etask->task_status,$session['user_id']);
                        $tbdcolor = '#673AB7';
                    }	
                ?>
                    <tr>
                      <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $tbdcolor;?>;"></div></td>
                      <td><?php echo htmlspecialchars_decode($sname);?> (<?php echo $trow;?>)</td>
                    </tr>
                    <?php $sj++; } ?>
                    <?php  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div style="height:120px;">
              <canvas id="hrsale_user_tasks" style="display: block; height: 150px; width:300px;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
   </div>
 <?php } ?>  