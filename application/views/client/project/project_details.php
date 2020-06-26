<?php
/* Project Details view
*/
?>
<?php $session = $this->session->userdata('client_username');?>
<?php //$u_created = $this->Xin_model->read_user_info($session['user_id']);?>
<?php
$id = $this->uri->segment(4);
$result = $this->Project_model->read_project_information($id);
if(is_null($result)){
	redirect('client/projects');
}	
?>
<?php $assigned_ids = explode(',',$result[0]->assigned_to);?>
<?php
//status
if($result[0]->status == 0) {
	$nstatus = $this->lang->line('xin_not_started');
} else if($result[0]->status ==1){
	$nstatus = $this->lang->line('xin_in_progress');
} else if($result[0]->status ==2){
	$nstatus = $this->lang->line('xin_completed');
} else {
	$nstatus = $this->lang->line('xin_deffered');
}
//priority
if($result[0]->priority == 1) {
	$epriority = '<span class="tag tag-default tag-danger">'.$this->lang->line('xin_highest').'</span>';
} else if($result[0]->priority ==2){
	$epriority = '<span class="tag tag-default tag-warning">'.$this->lang->line('xin_high').'</span>';
} else if($result[0]->priority ==3){
	$epriority = '<span class="tag tag-default tag-primary">'.$this->lang->line('xin_normal').'</span>';
} else {
	$epriority = '<span class="tag tag-default tag-success">'.$this->lang->line('xin_low').'</span>';
}
if($result[0]->project_progress <= 20) {
	$progress_class = 'progress-danger';
	$txt_class = 'text-danger';
} else if($result[0]->project_progress > 20 && $result[0]->project_progress <= 50){
	$progress_class = 'progress-warning';
	$txt_class = 'text-warning';
} else if($result[0]->project_progress > 50 && $result[0]->project_progress <= 75){
	$progress_class = 'progress-info';
	$txt_class = 'text-info';
} else {
	$progress_class = 'progress-success';
	$txt_class = 'text-success';
}
$project_id = $result[0]->project_id;
$projectTasks = $this->Project_model->completed_project_tasks($project_id);
$projectBugs = $this->Project_model->completed_project_bugs($project_id); 
?>
<?php // get company name by project id ?>
<?php $co_info  = $this->Project_model->read_project_information($project_id); ?>
<?php $eresult = $this->Department_model->ajax_company_employee_info($co_info[0]->company_id);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="border-right-0 border-left-0 ui-bordered container-m--x mb-4">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-9">
      <div class="media-body container-p-x py-4">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <div> <strong class="text-primary text-large"><?php echo $progress;?>%</strong> <?php echo $this->lang->line('xin_completed');?></div>
        </div>
        <div class="progress" style="height: 4px;">
          <div class="progress-bar" style="width: <?php echo $progress;?>%;"></div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="container-p-x py-4">
        <div class="text-muted small"><?php echo $this->lang->line('dashboard_xin_status');?></div>
        <strong class="<?php echo $txt_class;?> text-big"><?php echo $nstatus;?></strong> </div>
    </div>
  </div>
</div>
<div class="row">
<div class="col-xl-8 col-lg-8  <?php echo $get_animate;?>">
<div class="col current-tab <?php echo $get_animate;?>" id="overview"> 
    
    <!-- Description -->
    <div class="card mb-4">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_project_overview');?></strong></span> </div>
      <div class="card-body"> <?php echo html_entity_decode($description);?> </div>
    </div>
    <!-- / Description --> 
  </div>
  <?php /*?><div class="col"> 
    
    <!-- Description -->
    <div class="card mb-4">
      <h6 class="card-header"><?php echo $title;?> - <?php echo $this->lang->line('xin_project_overview');?></h6>
      <div class="card-body"> <?php echo html_entity_decode($description);?> </div>
    </div>
    <!-- / Description --> 
    <?php */?>
  </div>
  <div class="col-md-4 col-xl-3  <?php echo $get_animate;?>"> 
    
    <!-- Project details -->
    <div class="card mb-4">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_project_detail');?></strong></span> </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div class="text-muted"><?php echo $this->lang->line('xin_client_name');?></div>
          <div> <a href="javascript:void(0)"><?php echo $client_name;?></a> </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div class="text-muted"><?php echo $this->lang->line('xin_start_date');?></div>
          <div><?php echo $this->Xin_model->set_date_format($start_date);?></div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div class="text-muted"><?php echo $this->lang->line('xin_end_date');?></div>
          <div><?php echo $this->Xin_model->set_date_format($end_date);?></div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div class="text-muted"><?php echo $this->lang->line('xin_p_priority');?></div>
          <div><?php echo $epriority;?></div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div class="text-muted"><?php echo $this->lang->line('xin_prjct_detail_overall_progress');?><br />
            <?php echo $progress;?>%<br />
            <div class="progress" style="height: 7px;">
              <div class="progress-bar" style="width: <?php echo $progress;?>%;"></div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <!-- / Project details --> 
    <!-- Participants -->
    <div class="card mb-4">
      <h6 class="card-header with-elements"> <span class="card-header-title"><?php echo $this->lang->line('xin_project_users');?></span> </h6>
      <ul class="list-group list-group-flush">
        <?php if($assigned_to!='' && $assigned_to!='None') {?>
			<?php $employee_ids = explode(',',$assigned_to); foreach($employee_ids as $assign_id) {?>
            <?php $e_name = $this->Xin_model->read_user_info($assign_id);?>
            <?php if(!is_null($e_name)){ ?>
            <?php $_designation = $this->Designation_model->read_designation_information($e_name[0]->designation_id);?>
            <?php
			  if(!is_null($_designation)){
				$designation_name = $_designation[0]->designation_name;
			  } else {
				$designation_name = '--';	
			  }
			  ?>
        	<?php
			if($e_name[0]->profile_picture!='' && $e_name[0]->profile_picture!='no file') {
				$u_file = base_url().'uploads/profile/'.$e_name[0]->profile_picture;
			} else {
				if($e_name[0]->gender=='Male') { 
					$u_file = base_url().'uploads/profile/default_male.jpg';
				} else {
					$u_file = base_url().'uploads/profile/default_female.jpg';
				}
			} ?>
        <li class="list-group-item">
          <div class="media align-items-center"> <img src="<?php echo $u_file;?>" class="d-block ui-w-30 rounded-circle" alt="">
            <div class="media-body px-2"> <a href="javascript:void(0);" class="text-dark"><?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?></a><br />
              <p class="font-small-2 mb-0 text-muted"><?php echo $designation_name;?></p>
            </div>
          </div>
        </li>
        <?php } } ?>
        <?php } else { ?>
        <li class="list-group-item"><span>&nbsp;</span></li>
        <?php } ?>
      </ul>
    </div>
    <!-- / Participants --> 
  </div>
</div>
