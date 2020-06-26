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
<div class="row <?php echo $get_animate;?>">
<?php if(in_array('14',$role_resources_ids)) { ?>
  <?php if($system[0]->module_awards=='true'){?>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/awards/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-primary"><i class="fa fa-trophy"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Exin_model->total_employee_awards_dash();?> <?php echo $this->lang->line('left_awards');?></span> <span class="info-box-text"><span class=""> <?php echo $this->lang->line('xin_view');?> </span></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <?php } else {?>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/timesheet/attendance/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-primary"><i class="fa fa-clock-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('dashboard_attendance');?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_view');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <?php } ?>
  <?php } ?>
  <?php if(in_array('37',$role_resources_ids)) { ?>
  <!-- /.col -->
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/payroll/payment_history/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('left_payslips');?> <?php echo $this->lang->line('xin_view');?></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <!-- /.col --> 
  <?php } ?>
  <!-- fix for small devices only -->
  <?php if(in_array('46',$role_resources_ids)) { ?>
  <div class="clearfix visible-sm-block"></div>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/timesheet/leave/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-purple"><i class="fa fa-calendar"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_performance_management');?> <?php echo $this->lang->line('left_leave');?></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <?php } ?>
  <?php if($system[0]->module_travel=='true'){?>
  <!-- /.col -->
  <?php if(in_array('17',$role_resources_ids)) { ?>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/travel/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-plane"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_travel');?> <?php echo $this->lang->line('xin_requests');?></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>  
  <?php } ?>
  <!-- /.col -->
  <?php } ?>
</div>
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
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-primary">
      <div class="flexbox"> <span class="fa fa-life-bouy text-primary font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo cr_quote_quoted();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_quoted_title');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-danger">
      <div class="flexbox"> <span class="fa fa-server text-danger font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo cr_quote_project_created();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_q_project_created');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-success">
      <div class="flexbox"> <span class="ion ion-thumbsup text-success font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo cr_quote_inprogress();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_in_progress');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-yellow">
      <div class="flexbox"> <span class="fa fa-cube text-yellow font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo cr_quote_project_completed();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_q_project_completed');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-yellow">
      <div class="flexbox"> <span class="ion ion-thumbsup text-danger font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo cr_quote_invoiced();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_quote_invoiced');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-yellow">
      <div class="flexbox"> <span class="fa fa-cube text-yellow font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo cr_quote_paid();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_payment_paid');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-yellow">
      <div class="flexbox"> <span class="fa fa-server text-success font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo cr_quote_deffered();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_quote_deffered');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-green">
      <div class="flexbox"> <span class="fa fa-cube text-yellow font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo cr_quote_project_completed();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_q_project_completed');?></div>
    </div>
  </div>
</div>
<!--/ Stats --> 
<?php if(in_array('44',$role_resources_ids)) { ?>
<div class="row match-height">
  <?php if($system[0]->module_projects_tasks=='true'){?>
  <div class="col-xl-8 col-lg-8">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_my_projects');?></h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <p><?php echo $this->lang->line('xin_my_assigned_projects');?> <span class="float-xs-right"><a href="<?php echo site_url('admin/project');?>"><?php echo $this->lang->line('xin_more_projects');?> <i class="ft-arrow-right"></i></a></span></p>
        </div>
        <div class="table-responsive" style="height:250px;">
          <table id="recent-orderss" class="table table-hover mb-0 ps-container ps-theme-default">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                <th><?php echo $this->lang->line('xin_p_priority');?></th>
                <th><?php echo $this->lang->line('dashboard_project_date');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
              </tr>
            </thead>
            <tbody>
              <?php $project = $this->Project_model->get_projects();?>
              <?php $dId = array(); $i=1; foreach($project->result() as $pj):
                         // $aw_name = $hrm->e_award_type($emp_award->award_type_id);
                         $asd = array($pj->assigned_to);
                         $aim = explode(',',$pj->assigned_to);
                         foreach($aim as $dIds) {
                             if($session['user_id'] === $dIds) {
                                $dId[] = $session['user_id'];
							// project date		
							$pdate = $this->Xin_model->set_date_format($pj->end_date);
							// project progress
							if($pj->project_progress <= 20) {
								$progress_class = 'progress-danger';
							} else if($pj->project_progress > 20 && $pj->project_progress <= 50){
								$progress_class = 'progress-warning';
							} else if($pj->project_progress > 50 && $pj->project_progress <= 75){
								$progress_class = 'progress-info';
							} else {
								$progress_class = 'progress-success';
							}
							 
							// project progress
							if($pj->status == 0) {
								$status = $this->lang->line('xin_not_started');
							} else if($pj->status ==1){
								$status = $this->lang->line('xin_in_progress');
							} else if($pj->status ==2){
								$status = $this->lang->line('xin_completed');
							} else {
								$status = $this->lang->line('xin_deffered');
							}
							// priority
							if($pj->priority == 1) {
								$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_highest').'</span>';
							} else if($pj->priority ==2){
								$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_high').'</span>';
							} else if($pj->priority ==3){
								$priority = '<span class="tag tag-primary">'.$this->lang->line('xin_normal').'</span>';
							} else {
								$priority = '<span class="tag tag-success">'.$this->lang->line('xin_low').'</span>';
							}
							?>
              <tr>
                <td class="text-truncate"><a href="<?php echo site_url();?>admin/project/detail/<?php echo $pj->project_id;?>/"><?php echo $pj->title;?></a></td>
                <td class="text-truncate"><?php echo $priority;?></td>
                <td class="text-truncate"><i class="fa fa-calendar position-left"></i> <?php echo $pdate;?></td>
                <td class="text-truncate"><?php echo $status;?></td>
                <td class="text-truncate"><p class="m-b-0-5"><?php echo $this->lang->line('dashboard_completed');?> <span class="pull-xs-right"><?php echo $pj->project_progress;?>%</span></p>
                  <progress class="progress <?php echo $progress_class;?> progress-sm d-inline-block mb-0" value="<?php echo $pj->project_progress;?>" max="100"><?php echo $pj->project_progress;?>%</progress></td>
              </tr>
              <?php }
								} ?>
              <?php $i++; endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php //} else {?>
  <div class="col-xl-4 col-lg-4">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_recruitment');?> <?php echo $this->lang->line('dashboard_timeline');?></h3>
      </div>
      <div class="box-body px-1">
        <div id="recent-buyers" class="list-group scrollable-container height-300 position-relative">
          <?php foreach($all_jobs as $job):?>
          <?php $jtype = $this->Job_post_model->read_job_type_information($job->job_type); ?>
          <?php
			if(!is_null($jtype)){
				$jt_type = $jtype[0]->type;
			} else {
				$jt_type = '--';	
			}
		  ?>
          <a href="<?php echo site_url('frontend/jobs/detail/').$job->job_id;?>/" class="list-group-item list-group-item-action media no-border">
          <div class="media-body">
            <h6 class="list-group-item-heading"><?php echo $job->job_title;?> <span class="float-xs-right pt-1"><span class="tag tag-warning ml-1"><?php echo $jt_type;?></span></span></h6>
          </div>
          </a>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php } ?>
<?php if($theme[0]->dashboard_calendar == 'true'):?>
<?php $this->load->view('admin/calendar/calendar_hr');?>
<?php endif; ?>
<style type="text/css">
.btn-group {
	margin-top:5px !important;
}
</style>