<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
$role_resources_ids = $this->Xin_model->user_role_resource();
?>
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="text-center font-weight-bold py-1 mb-2">
      <?php echo $this->lang->line('header_notifications');?></h3>
    <hr class="container-m-nx border-light my-0">
</div>
<div class="card messages-card">
  <div class="row no-gutters">

    <!-- Messages sidebox -->
    <div class="messages-sidebox messages-scroll col">

      <div class="card-body py-3">
        <div class="media align-items-center">
          <div class="media-body">
            <button type="button" class="btn btn-primary btn-block"><?php echo $this->lang->line('header_notifications');?></button>
          </div>
          <a href="javascript:void(0)" class="messages-sidebox-toggler d-lg-none d-block text-muted text-large font-weight-light pl-4">&times;</a>
        </div>
      </div>
      <hr class="border-light m-0">

      <div class="card-body pt-3">      

        <!-- Notification boxes -->
        <?php  if(in_array('46',$role_resources_ids)) { ?>
        <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
          <div>
            <i class="ion ion-ios-filing"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_leave');?>
          </div>
          <div class="badge badge-primary"><?php echo $this->Xin_model->hrsale_notifications_count('leave',$session['user_id']);?></div>
        </a>
        <?php } ?>
        <?php  if(in_array('44',$role_resources_ids)) { ?>
        <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
          <div>
            <i class="ion ion-logo-buffer"></i> &nbsp; <?php echo $this->lang->line('xin_projects');?>
          </div>
          <div class="badge badge-primary"><?php echo $this->Xin_model->hrsale_notifications_count('projects',$session['user_id']);?></div>
        </a>
        <?php } ?>
        <?php  if(in_array('45',$role_resources_ids)) { ?>
        <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
          <div>
            <i class="fab fa-fantasy-flight-games"></i> &nbsp; <?php echo $this->lang->line('xin_tasks');?>
          </div>
          <div class="badge badge-primary"><?php echo $this->Xin_model->hrsale_notifications_count('tasks',$session['user_id']);?></div>
        </a>
        <?php } ?>
        <?php  if(in_array('11',$role_resources_ids)) { ?>
        <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
          <div>
            <i class="ion ion-md-megaphone"></i> &nbsp; <?php echo $this->lang->line('dashboard_announcements');?>
          </div>
          <div class="badge badge-primary"><?php echo $this->Xin_model->hrsale_notifications_count('announcement',$session['user_id']);?></div>
        </a>
        <?php } ?>
        <?php if($system[0]->module_inquiry=='true'){?>
        <?php  if(in_array('43',$role_resources_ids)) { ?>
        <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
          <div>
            <i class="fab fa-critical-role"></i> &nbsp; <?php echo $this->lang->line('left_tickets');?>
          </div>
          <div class="badge badge-primary"><?php echo $this->Xin_model->hrsale_notifications_count('tickets',$session['user_id']);?></div>
        </a>
        <?php } ?>
        <?php } ?>
        <?php  if(in_array('25',$role_resources_ids)) { ?>
        <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
          <div>
            <i class="ion ion-md-today"></i> &nbsp; <?php echo $this->lang->line('xin_assets');?>
          </div>
          <div class="badge badge-primary"><?php echo $this->Xin_model->hrsale_notifications_count('asset',$session['user_id']);?></div>
        </a>
        <?php } ?>
        <?php  if(in_array('14',$role_resources_ids)) { ?>
        <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
          <div>
            <i class="fas fa-trophy"></i> &nbsp; <?php echo $this->lang->line('left_awards');?>
          </div>
          <div class="badge badge-primary"><?php echo $this->Xin_model->hrsale_notifications_count('awards',$session['user_id']);?></div>
        </a>
        <?php } ?>
        <!-- / Mail boxes -->
        <hr class="border-light my-4">
      </div>

    </div>
    <!-- / Messages sidebox -->
	<?php
    	$fcount = 0; $proj_count = 0; $leave_count = 0; $tsk_count = 0;
		$nst_count = 0; $tkt_count = 0; $asset_count = 0; $award_count = 0;
		if(in_array('46',$role_resources_ids)) {
			$leave_count = $this->Xin_model->hrsale_notifications_count('leave',$session['user_id']);
		}
		if(in_array('44',$role_resources_ids)) {
			$proj_count = $this->Xin_model->hrsale_notifications_count('projects',$session['user_id']);
		}
		if(in_array('45',$role_resources_ids)) {
			$tsk_count = $this->Xin_model->hrsale_notifications_count('tasks',$session['user_id']);
		}
		if(in_array('11',$role_resources_ids)) {
			$nst_count = $this->Xin_model->hrsale_notifications_count('announcement',$session['user_id']);
		}
		if($system[0]->module_inquiry=='true'){
			if(in_array('43',$role_resources_ids)) {
				$tkt_count = $this->Xin_model->hrsale_notifications_count('tickets',$session['user_id']);
			}
		}
		if(in_array('25',$role_resources_ids)) {
			$asset_count = $this->Xin_model->hrsale_notifications_count('asset',$session['user_id']);
		}
		if(in_array('14',$role_resources_ids)) {
			$award_count = $this->Xin_model->hrsale_notifications_count('awards',$session['user_id']);
		}
		// count);
		$fcount = $proj_count + $leave_count + $tsk_count + $nst_count + $tkt_count + $asset_count + $award_count;
	 ?>
    <!-- Messages list -->
    <div class="col">
     <?php if($fcount > 0) {?>
      <hr class="border-light m-0">
      <!-- / Controls -->
      <ul class="list-group messages-list">
      <?php  if(in_array('46',$role_resources_ids)) { ?>
      <?php foreach($this->Xin_model->hrsale_notifications('leave',$session['user_id']) as $leave_notify) {?>
		<?php
        $leave_info = $this->Timesheet_model->read_leave_information($leave_notify->module_id);
		if(!is_null($leave_info)){
			$leave_type = $this->Timesheet_model->read_leave_type_information($leave_info[0]->leave_type_id);
			$employee_info = $this->Xin_model->read_user_info($leave_info[0]->employee_id);
			// get leave types
			if(!is_null($leave_type)){
				$type_name = $leave_type[0]->type_name;
			} else {
				$type_name = '--';	
			}
			if(!is_null($employee_info)){
                $emp_name = $employee_info[0]->first_name. ' '.$employee_info[0]->last_name;
            } else {
                $emp_name = '--';	
            }
		} else {
			$type_name = '--';
			$emp_name = '--';
		}
        ?>
        <li class="list-group-item px-4">
          <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
            <?php echo $this->lang->line('xin_e_details_leave');?>
          </a>
          <a href="<?php echo site_url('admin/timesheet/leave_details/id')?>/<?php echo $leave_notify->module_id;?>/" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
            <?php echo $emp_name;?> <?php echo $this->lang->line('header_has_applied_for_leave').': '.$type_name;?>
          </a>
          <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($leave_notify->created_at);?></div>
        </li>
        <?php } ?>
        <?php } ?>
      <?php  if(in_array('44',$role_resources_ids)) { ?>  
      <?php foreach($this->Xin_model->hrsale_notifications('projects',$session['user_id']) as $nprj) {?>
      <?php $project_info = $result = $this->Project_model->read_project_information($nprj->module_id);?>
       <?php
	   	if(!is_null($project_info)){
			$iproject = $project_info[0]->title;
		} else {
			$iproject = '--';	
		}
	   ?>
        <li class="list-group-item px-4">
          <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
            <?php echo $this->lang->line('xin_projects');?>
          </a>
          <a href="<?php echo site_url('admin/project/detail')?>/<?php echo $nprj->module_id;?>/" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
            <?php echo $iproject;?>
          </a>
          <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($nprj->created_at);?></div>
        </li>  
       <?php } ?> 
       <?php } ?>
       <?php  if(in_array('45',$role_resources_ids)) { ?>
       <?php foreach($this->Xin_model->hrsale_notifications('tasks',$session['user_id']) as $ntsk) {?>
       <?php $task_info = $this->Timesheet_model->read_task_information($ntsk->module_id);?>
       <?php
	   	if(!is_null($task_info)){
			$task_name = $task_info[0]->task_name;
		} else {
			$task_name = '--';	
		}
	   ?> 
        <li class="list-group-item px-4">
          <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
            <?php echo $this->lang->line('xin_tasks');?>
          </a>
          <a href="<?php echo site_url('admin/timesheet/task_details')?>/id/<?php echo $ntsk->module_id;?>/" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
            <?php echo $task_name;?>
          </a>
          <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($ntsk->created_at);?></div>
        </li>
       <?php } ?>  
       <?php } ?>
       <?php  if(in_array('11',$role_resources_ids)) { ?>
       <?php foreach($this->Xin_model->hrsale_notifications('announcement',$session['user_id']) as $n_annc) {?>
       <?php $annc_info = $this->Announcement_model->read_announcement_information($n_annc->module_id);?>
       <?php
	   	if(!is_null($annc_info)){
			$annc_title = $annc_info[0]->title;
		} else {
			$annc_title = '--';	
		}
	   ?>
        <li class="list-group-item px-4">
          <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
            <?php echo $this->lang->line('dashboard_announcements');?>
          </a>
          <a href="<?php echo site_url('admin/announcement/index').'/'.$n_annc->module_id;?>" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
            <?php echo $annc_title;?>
          </a>
          <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($n_annc->created_at);?></div>
        </li>
       <?php } ?>  
       <?php } ?>
       <?php if($system[0]->module_inquiry=='true'){?>
        <?php  if(in_array('43',$role_resources_ids)) { ?>
       <?php foreach($this->Xin_model->hrsale_notifications('tickets',$session['user_id']) as $n_ticket) {?>
       <?php $ticket_info = $this->Tickets_model->read_ticket_information($n_ticket->module_id);?>
       <?php
	   	if(!is_null($ticket_info)){
			$subject = $ticket_info[0]->subject;
		} else {
			$subject = '--';	
		}
	   ?>
        <li class="list-group-item px-4">
          <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
            <?php echo $this->lang->line('left_tickets');?>
          </a>
          <a href="<?php echo site_url('admin/tickets/details')?>/<?php echo $n_ticket->module_id;?>" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
            <?php echo $subject;?>
          </a>
          <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($n_ticket->created_at);?></div>
        </li>
        <?php } ?> 
        <?php } ?>
        <?php } ?>
        <?php  if(in_array('25',$role_resources_ids)) { ?>
        <?php foreach($this->Xin_model->hrsale_notifications('asset',$session['user_id']) as $n_asset) {?>
       <?php $asset_info = $this->Assets_model->read_assets_info($n_asset->module_id);?>
       <?php
	   	if(!is_null($asset_info)){
			$asset_name = $asset_info[0]->name;
		} else {
			$asset_name = '--';	
		}
	   ?>
        <li class="list-group-item px-4">
          <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
            <?php echo $this->lang->line('xin_assets');?>
          </a>
          <a href="<?php echo site_url('admin/assets/index')?>/<?php echo $n_asset->module_id;?>" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
            <?php echo $asset_name;?>
          </a>
          <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($n_asset->created_at);?></div>
        </li>
        <?php } ?>
        <?php } ?>
        <?php  if(in_array('14',$role_resources_ids)) { ?>
        <?php foreach($this->Xin_model->hrsale_notifications('awards',$session['user_id']) as $n_award) {?>
       <?php
        $award_info = $this->Awards_model->read_award_information($n_award->module_id);
		if(!is_null($award_info)){
			// get award type
			$award_type = $this->Awards_model->read_award_type_information($award_info[0]->award_type_id);
			if(!is_null($award_type)){
				$award_type = $award_type[0]->award_type;
			} else {
				$award_type = '--';	
			}
		} else {
			$award_type = '--';	
		}
	   ?>
        <li class="list-group-item px-4">
          <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
            <?php echo $this->lang->line('left_awards');?>
          </a>
          <a href="<?php echo site_url('admin/awards/index')?>/<?php echo $n_award->module_id;?>" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
            <?php echo $award_type;?>
          </a>
          <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($n_award->created_at);?></div>
        </li>
        <?php } ?>
        <?php } ?>
      </ul>
      <?php } else {?>
      	<span class="mb-3 ml-5 text-center"><?php echo $this->lang->line('xin_no_nofitication_found');?></span>
        <hr class="border-light m-0">
      <?php } ?>
    </div>
    <!-- / Messages list -->

  </div><!-- / .row -->
</div><!-- / .card -->