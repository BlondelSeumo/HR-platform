<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php
if($user_info[0]->user_role_id == '1'){
	$completed_projects = $this->Project_model->calendar_complete_projects();
	$cancelled_projects = $this->Project_model->calendar_cancelled_projects();
	$inprogress_projects = $this->Project_model->calendar_inprogress_projects();
	$not_started_projects = $this->Project_model->calendar_not_started_projects();
	$hold_projects = $this->Project_model->calendar_hold_projects();
} else {
	$completed_projects = $this->Project_model->calendar_user_complete_projects($session['user_id']);
	$cancelled_projects = $this->Project_model->calendar_user_cancelled_projects($session['user_id']);
	$inprogress_projects = $this->Project_model->calendar_user_inprogress_projects($session['user_id']);
	$not_started_projects = $this->Project_model->calendar_user_not_started_projects($session['user_id']);
	$hold_projects = $this->Project_model->calendar_user_hold_projects($session['user_id']);
}
$projects = $this->Project_model->get_projects();
?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('312',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/projects_dashboard/');?>" data-link-data="<?php echo site_url('admin/project/projects_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_overview');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('44',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/');?>" data-link-data="<?php echo site_url('admin/project/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-buffer"></span> <?php echo $this->lang->line('left_projects');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('left_projects');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('119',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/clients/');?>" data-link-data="<?php echo site_url('admin/clients/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('xin_project_clients');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_clients');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('94',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/timelogs/');?>" data-link-data="<?php echo site_url('admin/project/timelogs/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-clock"></span> <?php echo $this->lang->line('xin_project_timelogs');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_timelogs');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('424',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/projects_calendar/');?>" data-link-data="<?php echo site_url('admin/project/projects_calendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_acc_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_acc_calendar');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('425',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/project/projects_scrum_board/');?>" data-link-data="<?php echo site_url('admin/project/projects_scrum_board/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-clipboard-list"></span> <?php echo $this->lang->line('xin_projects_scrm_board');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_projects_scrm_board');?></div>
      </a> </li>
      <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php
if($projects->num_rows() > 0) {
?>
<div class="form-row">
<div class="col-md">

    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-md-football text-info"></i> &nbsp; <?php echo $this->lang->line('xin_not_started');?></h6>
      <div class="kanban-box first-notstarted px-2 pt-2" id="first-notstarted" data-status="0">
      <?php foreach($not_started_projects as $ntprojects) {?>
          
          <?php
		$ol = '';
		$cc = count(explode(',',$ntprojects->assigned_to));
		$iuser = 0;
		foreach(explode(',',$ntprojects->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class="d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class="d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($ntprojects->end_date);
		if($ntprojects->project_progress <= 20) {
			$progress_class = 'bar-danger';
		} else if($ntprojects->project_progress > 20 && $ntprojects->project_progress <= 50){
			$progress_class = 'bar-warning';
		} else if($ntprojects->project_progress > 50 && $ntprojects->project_progress <= 75){
			$progress_class = 'bar-info';
		} else {
			$progress_class = 'bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$ntprojects->project_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ntprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ntprojects->project_progress.'%"></div></div></p>';
		?>
        <div class="ui-bordered notstarted_<?php echo $ntprojects->project_id;?> p-2 mb-2" data-id="<?php echo $ntprojects->project_id;?>" data-status="0" id="notstarted">
          <a target="_blank" href="<?php echo site_url('admin/project/detail/').$ntprojects->project_id;?>"><?php echo $ntprojects->title;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('xin_completed');?> <?php echo $ntprojects->project_progress;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $ntprojects->project_progress;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('xin_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
      <div class="card-footer text-center py-2">
        <a href="javascript:void(0)" class="edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-project_status="0"><i class="ion ion-md-add"></i>&nbsp; <?php echo $this->lang->line('xin_add_project');?></a>
      </div>
    </div>

  </div>
  <div class="col-md">

    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-ios-list text-primary"></i> &nbsp; <?php echo $this->lang->line('xin_in_progress');?></h6>
      <div class="kanban-box first-inprogress px-2 pt-2" data-status="1" id="first-inprogress">
      <?php foreach($inprogress_projects as $inprojects) {?>
          
          <?php
		$ol = '';
		$cc = count(explode(',',$inprojects->assigned_to));
		$iuser = 0;
		foreach(explode(',',$inprojects->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class="d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class="d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($inprojects->end_date);
		if($inprojects->project_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($inprojects->project_progress > 20 && $inprojects->project_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($inprojects->project_progress > 50 && $inprojects->project_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$inprojects->project_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$inprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$inprojects->project_progress.'%"></div></div></p>';
		?>
        <div class="ui-bordered in-progress_<?php echo $inprojects->project_id;?> p-2 mb-2" data-id="<?php echo $inprojects->project_id;?>" data-status="1" id="in-progress">
          <a target="_blank" href="<?php echo site_url('admin/project/detail/').$inprojects->project_id;?>"><?php echo $inprojects->title;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('xin_completed');?> <?php echo $inprojects->project_progress;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $inprojects->project_progress;?>%"></div>
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
       <?php foreach($completed_projects as $cprojects) {?>
         <?php
		$ol = '';
		$cc = count(explode(',',$cprojects->assigned_to));
		$iuser = 0;
		foreach(explode(',',$cprojects->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class="d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class="d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($cprojects->end_date);
		if($cprojects->project_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($cprojects->project_progress > 20 && $cprojects->project_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($cprojects->project_progress > 50 && $cprojects->project_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$cprojects->project_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$cprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$cprojects->project_progress.'%"></div></div></p>';
		?>
        <div class="ui-bordered complete_<?php echo $cprojects->project_id;?> p-2 mb-2" data-id="<?php echo $cprojects->project_id;?>" data-status="2" id="complete">
          <a target="_blank" href="<?php echo site_url('admin/project/detail/').$cprojects->project_id;?>"><?php echo $cprojects->title;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('xin_completed');?> <?php echo $cprojects->project_progress;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $cprojects->project_progress;?>%"></div>
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
        <?php foreach($cancelled_projects as $cnprojects) {?>
          <?php
		$ol = '';
		$cc = count(explode(',',$cnprojects->assigned_to));
		$iuser = 0;
		foreach(explode(',',$cnprojects->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class="d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class="d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($cnprojects->end_date);
		if($cnprojects->project_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($cnprojects->project_progress > 20 && $cnprojects->project_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($cnprojects->project_progress > 50 && $cnprojects->project_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$cnprojects->project_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$cnprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$cnprojects->project_progress.'%"></div></div></p>';
		?>
        <div class="ui-bordered cancelled_<?php echo $cnprojects->project_id;?> p-2 mb-2" data-id="<?php echo $cnprojects->project_id;?>" data-status="3" id="cancelled">
          <a target="_blank" href="<?php echo site_url('admin/project/detail/').$cnprojects->project_id;?>"><?php echo $cnprojects->title;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('xin_completed');?> <?php echo $cnprojects->project_progress;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $cnprojects->project_progress;?>%"></div>
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
       <?php foreach($hold_projects as $hlprojects) {?>
			  <?php
            $ol = '';
            $cc = count(explode(',',$hlprojects->assigned_to));
            $iuser = 0;
            foreach(explode(',',$hlprojects->assigned_to) as $uid) {
                //$user = $this->Xin_model->read_user_info($uid);
                if($iuser < 5) {
                    $assigned_to = $this->Xin_model->read_user_info($uid);
                    if(!is_null($assigned_to)){
                        
                    $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
                     if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
                        $ol .= '<a href="javascript:void(0);" class="d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                        } else {
                        if($assigned_to[0]->gender=='Male') { 
                            $de_file = base_url().'uploads/profile/default_male.jpg';
                         } else {
                            $de_file = base_url().'uploads/profile/default_female.jpg';
                         }
                        $ol .= '<a href="javascript:void(0);" class="d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                        }
                    }
                }
                $iuser++;
             }
             $ol .= '';
            $pedate = $this->Xin_model->set_date_format($hlprojects->end_date);
            if($hlprojects->project_progress <= 20) {
                $progress_class = 'progress-bar-danger';
            } else if($hlprojects->project_progress > 20 && $hlprojects->project_progress <= 50){
                $progress_class = 'progress-bar-warning';
            } else if($hlprojects->project_progress > 50 && $hlprojects->project_progress <= 75){
                $progress_class = 'progress-bar-info';
            } else {
                $progress_class = 'progress-bar-success';
            }
            $progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$hlprojects->project_progress.'%</span>
            <div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$hlprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$hlprojects->project_progress.'%"></div></div></p>';
            ?>
        <div class="ui-bordered hold_<?php echo $hlprojects->project_id;?> p-2 mb-2" data-id="<?php echo $hlprojects->project_id;?>" data-status="4" id="hold">
          <a target="_blank" href="<?php echo site_url('admin/project/detail/').$hlprojects->project_id;?>"><?php echo $hlprojects->title;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('xin_completed');?> <?php echo $hlprojects->project_progress;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hlprojects->project_progress;?>%"></div>
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
<span id="test">&nbsp;</span>
<span id="test1">&nbsp;</span>

