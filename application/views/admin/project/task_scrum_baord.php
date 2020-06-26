<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php
if($user_info[0]->user_role_id == '1'){
	$completed_task = $this->Project_model->calendar_complete_tasks();
	$cancelled_task = $this->Project_model->calendar_cancelled_tasks();
	$inprogress_task = $this->Project_model->calendar_inprogress_tasks();
	$not_started_task = $this->Project_model->calendar_not_started_tasks();
	$hold_task = $this->Project_model->calendar_hold_tasks();
} else {
	$completed_task = $this->Project_model->calendar_user_complete_tasks($session['user_id']);
	$cancelled_task = $this->Project_model->calendar_user_cancelled_tasks($session['user_id']);
	$inprogress_task = $this->Project_model->calendar_user_inprogress_tasks($session['user_id']);
	$not_started_task = $this->Project_model->calendar_user_not_started_tasks($session['user_id']);
	$hold_task = $this->Project_model->calendar_user_hold_tasks($session['user_id']);
}
$task = $this->Timesheet_model->get_tasks();
if($task->num_rows() > 0) {
?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('45',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/timesheet/tasks/');?>" data-link-data="<?php echo site_url('admin/timesheet/tasks/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-fantasy-flight-games"></span> <?php echo $this->lang->line('left_tasks');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('left_tasks');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('90',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/tasks_calendar/');?>" data-link-data="<?php echo site_url('admin/project/tasks_calendar/');?>" class="mb-3 nav-link hrsale-link">
    <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_tasks_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_tasks_calendar');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('91',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/project/tasks_scrum_board/');?>" data-link-data="<?php echo site_url('admin/project/tasks_scrum_board/');?>" class="mb-3 nav-link hrsale-link">
    <span class="sw-icon fas fa-clipboard-list"></span> <?php echo $this->lang->line('xin_tasks_sboard');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_tasks_sboard');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="form-row">
<div class="col-md">

    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-md-football text-info"></i> &nbsp; <?php echo $this->lang->line('xin_not_started');?></h6>
      <div class="kanban-box first-notstarted px-2 pt-2" id="first-notstarted" data-status="0">
      <?php foreach($not_started_task as $hltask) {?>
       <?php
		$ol = '';
		$cc = count(explode(',',$hltask->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltask->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($hltask->end_date);
		if($hltask->task_progress <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltask->task_progress > 20 && $hltask->task_progress <= 50){
			$progress_class = 'bg-warning';
		} else if($hltask->task_progress > 50 && $hltask->task_progress <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered notstarted_<?php echo $hltask->task_id;?> p-2 mb-2" data-id="<?php echo $hltask->task_id;?>" data-status="0" id="notstarted">
          <a href="<?php echo site_url('admin/timesheet/task_details/id/').$hltask->task_id;?>"><?php echo $hltask->task_name;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('xin_completed');?> <?php echo $hltask->task_progress;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hltask->task_progress;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('xin_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
      <div class="card-footer text-center py-2">
        <a href="javascript:void(0)" class="edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-task_status="0"><i class="ion ion-md-add"></i>&nbsp; <?php echo $this->lang->line('xin_add_task');?></a>
      </div>
    </div>

  </div>
  <div class="col-md">

    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-ios-list text-primary"></i> &nbsp; <?php echo $this->lang->line('xin_in_progress');?></h6>
      <div class="kanban-box first-inprogress px-2 pt-2" data-status="1" id="first-inprogress">
      <?php foreach($inprogress_task as $hltask) {?>
       <?php
		$ol = '';
		$cc = count(explode(',',$hltask->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltask->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($hltask->end_date);
		if($hltask->task_progress <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltask->task_progress > 20 && $hltask->task_progress <= 50){
			$progress_class = 'bg-warning';
		} else if($hltask->task_progress > 50 && $hltask->task_progress <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered in-progress_<?php echo $hltask->task_id;?> p-2 mb-2" data-id="<?php echo $hltask->task_id;?>" data-status="1" id="in-progress">
          <a href="<?php echo site_url('admin/timesheet/task_details/id/').$hltask->task_id;?>"><?php echo $hltask->task_name;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('xin_completed');?> <?php echo $hltask->task_progress;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hltask->task_progress;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('xin_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
    </div>

  </div>
  <div class="col-md">

    <div class="card border-info mb-3">
      <h6 class="card-header"><i class="ion ion-md-done-all text-success"></i> &nbsp; <?php echo $this->lang->line('xin_completed');?></h6>
      <div class="kanban-box first-completed px-2 pt-2" data-status="2" id="first-completed">
        <?php foreach($completed_task as $hltask) {?>
       <?php
		$ol = '';
		$cc = count(explode(',',$hltask->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltask->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($hltask->end_date);
		if($hltask->task_progress <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltask->task_progress > 20 && $hltask->task_progress <= 50){
			$progress_class = 'bg-warning';
		} else if($hltask->task_progress > 50 && $hltask->task_progress <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered complete_<?php echo $hltask->task_id;?> p-2 mb-2" data-id="<?php echo $hltask->task_id;?>" data-status="2" id="complete">
          <a href="<?php echo site_url('admin/timesheet/task_details/id/').$hltask->task_id;?>"><?php echo $hltask->task_name;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('xin_completed');?> <?php echo $hltask->task_progress;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hltask->task_progress;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('xin_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
    </div>

  </div>
  <div class="col-md">

    <div class="card border-warning mb-3">
      <h6 class="card-header"><i class="ion ion-md-close-circle-outline text-danger"></i> &nbsp; <?php echo $this->lang->line('xin_project_cancelled');?></h6>
      <div class="kanban-box first-cancelled px-2 pt-2" data-status="3" id="first-cancelled">
        <?php foreach($cancelled_task as $hltask) {?>
       <?php
		$ol = '';
		$cc = count(explode(',',$hltask->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltask->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($hltask->end_date);
		if($hltask->task_progress <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltask->task_progress > 20 && $hltask->task_progress <= 50){
			$progress_class = 'bg-warning';
		} else if($hltask->task_progress > 50 && $hltask->task_progress <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered cancelled_<?php echo $hltask->task_id;?> p-2 mb-2" data-id="<?php echo $hltask->task_id;?>" data-status="3" id="cancelled">
          <a href="<?php echo site_url('admin/timesheet/task_details/id/').$hltask->task_id;?>"><?php echo $hltask->task_name;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('xin_completed');?> <?php echo $hltask->task_progress;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hltask->task_progress;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('xin_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
    </div>

  </div>
  <div class="col-md">

    <div class="card border-success mb-3">
      <h6 class="card-header"><i class="ion ion-md-flash-off text-warning"></i> &nbsp; <?php echo $this->lang->line('xin_project_hold');?></h6>
      <div class="kanban-box first-hold px-2 pt-2"  data-status="4" id="first-hold">
        <?php foreach($hold_task as $hltask) {?>
       <?php
		$ol = '';
		$cc = count(explode(',',$hltask->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltask->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($hltask->end_date);
		if($hltask->task_progress <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltask->task_progress > 20 && $hltask->task_progress <= 50){
			$progress_class = 'bg-warning';
		} else if($hltask->task_progress > 50 && $hltask->task_progress <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered hold_<?php echo $hltask->task_id;?> p-2 mb-2" data-id="<?php echo $hltask->task_id;?>" data-status="4" id="hold">
          <a href="<?php echo site_url('admin/timesheet/task_details/id/').$hltask->task_id;?>"><?php echo $hltask->task_name;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('xin_completed');?> <?php echo $hltask->task_progress;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hltask->task_progress;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('xin_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
    </div>

  </div>
</div>
<?php } else {?>
<div class="row">
    <div class="col-md-7 col-md-offset-3">
    <img src="<?php echo base_url();?>skin/img/no-record-found.png" />
    </div>
</div>
<?php } ?>